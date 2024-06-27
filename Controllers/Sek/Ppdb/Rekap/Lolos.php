<?php

namespace App\Controllers\Sek\Ppdb\Rekap;

use App\Controllers\BaseController;
use App\Models\Sek\Ppdb\Rekap\LolosModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Ppdb\Sek\Riwayatlib;
use App\Libraries\Ppdb\Notificationlib;
use App\Libraries\Apilib;
use App\Libraries\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use setasign\Fpdi\TcpdfFpdi;

class Lolos extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;
    private $model;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    public function getAll()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->userSekolah();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $request = Services::request();
        $datamodel = new LolosModel($request);


        $lists = $datamodel->get_datatables($user->data->sekolah_id);
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            // $row[] = $no;
            // $action = '<div class="btn-group">
            //                 <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
            //                 <div class="dropdown-menu" style="">
            //                     <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->peserta_didik_id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
            //                     <a class="dropdown-item" href="javascript:actionResetPassword(\'' . $list->peserta_didik_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="bx bx-key font-size-16 align-middle"></i> &nbsp;Reset Password</a>
            //                     <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->peserta_didik_id . '\', \'' . str_replace("'", "", $list->nama)  . '\');"><i class="bx bx-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
            //                     <div class="dropdown-divider"></div>
            //                 </div>
            //             </div>';
            $action = '<a href="' . base_url() . '/sek/ppdb/rekap/lolos/detail?d=' . $list->id . '&t=' . $list->kode_pendaftaran . '" class="btn btn-xs btn-primary waves-effect waves-light"><i class="las la-eye font-size-16 align-middle me-2" style="font-size: 1.5rem !important;"></i> DETAIL</a>';

            $row[] = $action;
            $row[] = $list->nama_peserta;
            $row[] = $list->nisn_peserta;
            $row[] = $list->via_jalur;
            $row[] = $list->nama_sekolah_asal;
            $row[] = $list->npsn_sekolah_asal;
            $row[] = round($list->jarak_domisili, 3) . ' Km';
            $row[] = $list->nama_verifikator;

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all($user->data->sekolah_id),
            "recordsFiltered" => $datamodel->count_filtered($user->data->sekolah_id),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        return redirect()->to(base_url('sek/ppdb/rekap/lolos/data'));
    }

    public function data()
    {
        $data['title'] = 'DATA PENDAFTAR LOLOS VERIFIKASI';
        $Profilelib = new Profilelib();
        $user = $Profilelib->userSekolah();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        $refSekolah = $this->_db->table('dapo_sekolah')->select("status_sekolah_id")->where('sekolah_id', $user->data->sekolah_id)->get()->getRowObject();
        if (!$refSekolah) {
            redirect()->to(base_url('sek/ppdb/home'));
        }
        if ((int)$refSekolah->status_sekolah_id == 1) {
            $data['sekNegeri'] = true;
            $data['sekSwasta'] = false;
        } else {
            $data['sekNegeri'] = false;
            $data['sekSwasta'] = true;
        }

        return view('sek/ppdb/rekap/lolos/index', $data);
    }

    public function detail()
    {
        $data['title'] = 'DETAIL PENDAFTAR LOLOS VERIFIKASI';
        $Profilelib = new Profilelib();
        $user = $Profilelib->userSekolah();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $id = htmlspecialchars($this->request->getGet('d'), true);

        $oldData = $this->_db->table('_tb_pendaftar a')
            ->select("a.*, b.nama_ibu_kandung, b.nik, b.no_kk, b.alamat_jalan, b.no_kip, b.no_pkh, c.nohp, c.email, d.nama as nama_verifikator")
            ->join('dapo_peserta b', 'b.peserta_didik_id = a.peserta_didik_id')
            ->join('_users_tb c', 'c.id = a.user_id')
            ->join('_users_profile_sekolah d', 'a.admin_approval = d.user_id', 'LEFT')
            ->where('a.id', $id)
            ->get()->getRowObject();

        if (!$oldData) {
            return redirect()->to(base_url('sek/ppdb/rekap/lolos'));
        }

        if (!($oldData->id_perubahan == "" || $oldData->id_perubahan == null)) {
            $perubahanData = $this->_db->table('riwayat_perubahan_data a')
                ->select('a.*')
                ->select('b.nama as nama_admin_perubahan')
                ->join('_users_profile_sekolah b', 'a.user_id = b.user_id', 'left')
                ->where("JSON_UNQUOTE(JSON_EXTRACT(a.data_lama, '$.kode_pendaftaran')) = '$oldData->kode_pendaftaran'")
                ->orderBy('a.created_at', 'DESC')
                ->get()->getResult();

            if (count($perubahanData) > 0) {
                $data['riwayat_perubahan_data'] = $perubahanData;
            }
        }

        $data['data'] = $oldData;
        $data['koreg'] = $oldData->kode_pendaftaran;
        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        if ($oldData->via_jalur == "PRESTASI") {
            return view('sek/ppdb/rekap/lolos/detail_pres', $data);
        } else {
            return view('sek/ppdb/rekap/lolos/detail', $data);
        }
    }

    public function form_download()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Id tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('id');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->userSekolah();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session expired";
                    return json_encode($response);
                }
                $refSekolah = $this->_db->table('dapo_sekolah')->select("status_sekolah_id")->where('sekolah_id', $user->data->sekolah_id)->get()->getRowObject();
                if (!$refSekolah) {
                    redirect()->to(base_url('sek/ppdb/home'));
                }
                if ((int)$refSekolah->status_sekolah_id == 1) {
                    $x['sekNegeri'] = true;
                    $x['sekSwasta'] = false;
                } else {
                    $x['sekNegeri'] = false;
                    $x['sekSwasta'] = true;
                }
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('sek/ppdb/download', $x);
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function download()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->userSekolah();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $jalur = htmlspecialchars($this->request->getGet('j'), true);
        $status = htmlspecialchars($this->request->getGet('s'), true);
        if ($jalur == "") {
            return view('404');
        }
        if ($status == "") {
            return view('404');
        }

        try {

            $spreadsheet = new Spreadsheet();
            $worksheet = $spreadsheet->getActiveSheet();

            // Menulis nama kolom ke dalam baris pertama worksheet
            $worksheet->fromArray(['NO', 'NAMA PESERTA', 'NISN PESERTA', 'TEMPAT LAHIR PESERTA', 'TANGGAL LAHIR PESERTA', 'JENIS KELAMIN', 'NO PENDAFTARAN', 'VIA JALUR', 'JARAK DOMISILI', 'STATUS PENDAFTARAN', 'WAKTU PENDAFTARAN', 'VERIFIKATOR'], NULL, 'A3');

            // Mengambil data dari database
            if ($jalur == "all") {
                if ($status == "all") {
                    $query = $this->_db->table('_tb_pendaftar a')
                        ->select("a.kode_pendaftaran, a.nama_peserta, a.nisn_peserta, a.tempat_lahir_peserta, a.tanggal_lahir_peserta, a.jenis_kelamin_peserta, a.kab_peserta, a.kec_peserta, a.kel_peserta, a.dusun_peserta, a.lat_long_peserta, a.nama_sekolah_asal, a.npsn_sekolah_asal, a.nama_sekolah_tujuan, a.npsn_sekolah_tujuan, a.jarak_domisili, a.via_jalur, a.status_pendaftaran, a.created_at, a.updated_aproval, a.admin_approval, b.nama as nama_verifikator")
                        ->join('_users_profile_sekolah b', 'a.admin_approval = b.user_id')
                        ->where('a.tujuan_sekolah_id_1', $user->data->sekolah_id)
                        ->whereIn('a.status_pendaftaran', [1, 2, 3])
                        ->orderBy('a.status_pendaftaran', 'ASC')
                        ->orderBy('a.via_jalur', 'ASC')
                        ->orderBy('a.nama_peserta', 'ASC')
                        ->get();
                } else {
                    $query = $this->_db->table('_tb_pendaftar a')
                        ->select("a.kode_pendaftaran, a.nama_peserta, a.nisn_peserta, a.tempat_lahir_peserta, a.tanggal_lahir_peserta, a.jenis_kelamin_peserta, a.kab_peserta, a.kec_peserta, a.kel_peserta, a.dusun_peserta, a.lat_long_peserta, a.nama_sekolah_asal, a.npsn_sekolah_asal, a.nama_sekolah_tujuan, a.npsn_sekolah_tujuan, a.jarak_domisili, a.via_jalur, a.status_pendaftaran, a.created_at, a.updated_aproval, a.admin_approval, b.nama as nama_verifikator")
                        ->join('_users_profile_sekolah b', 'a.admin_approval = b.user_id')
                        ->where('a.tujuan_sekolah_id_1', $user->data->sekolah_id)
                        ->where('a.status_pendaftaran', $status)
                        ->orderBy('a.via_jalur', 'ASC')
                        ->orderBy('a.nama_peserta', 'ASC')
                        ->get();
                }
            } else {
                if ($status == "all") {
                    $query = $this->_db->table('_tb_pendaftar a')
                        ->select("a.kode_pendaftaran, a.nama_peserta, a.nisn_peserta, a.tempat_lahir_peserta, a.tanggal_lahir_peserta, a.jenis_kelamin_peserta, a.kab_peserta, a.kec_peserta, a.kel_peserta, a.dusun_peserta, a.lat_long_peserta, a.nama_sekolah_asal, a.npsn_sekolah_asal, a.nama_sekolah_tujuan, a.npsn_sekolah_tujuan, a.jarak_domisili, a.via_jalur, a.status_pendaftaran, a.created_at, a.updated_aproval, a.admin_approval, b.nama as nama_verifikator")
                        ->join('_users_profile_sekolah b', 'a.admin_approval = b.user_id')
                        ->where('a.tujuan_sekolah_id_1', $user->data->sekolah_id)
                        ->where('a.via_jalur', $jalur)
                        ->whereIn('a.status_pendaftaran', [1, 2, 3])
                        ->orderBy('a.status_pendaftaran', 'ASC')
                        ->orderBy('a.nama_peserta', 'ASC')
                        ->get();
                } else {
                    $query = $this->_db->table('_tb_pendaftar a')
                        ->select("a.kode_pendaftaran, a.nama_peserta, a.nisn_peserta, a.tempat_lahir_peserta, a.tanggal_lahir_peserta, a.jenis_kelamin_peserta, a.kab_peserta, a.kec_peserta, a.kel_peserta, a.dusun_peserta, a.lat_long_peserta, a.nama_sekolah_asal, a.npsn_sekolah_asal, a.nama_sekolah_tujuan, a.npsn_sekolah_tujuan, a.jarak_domisili, a.via_jalur, a.status_pendaftaran, a.created_at, a.updated_aproval, a.admin_approval, b.nama as nama_verifikator")
                        ->join('_users_profile_sekolah b', 'a.admin_approval = b.user_id')
                        ->where('a.tujuan_sekolah_id_1', $user->data->sekolah_id)
                        ->where('a.status_pendaftaran', $status)
                        ->where('a.via_jalur', $jalur)
                        ->orderBy('a.nama_peserta', 'ASC')
                        ->get();
                }
            }

            // Menulis data ke dalam worksheet
            $data = $query->getResult();
            $row = 4;
            if (count($data) > 0) {
                foreach ($data as $key => $item) {
                    $worksheet->getCell('A' . $row)->setValue($key + 1);
                    $worksheet->getCell('B' . $row)->setValue($item->nama_peserta);
                    if (substr((string)$item->nisn_peserta, 0, 2) == "BS") {
                        $worksheet->setCellValueExplicit("C" . $row, "", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    } else {
                        $worksheet->setCellValueExplicit("C" . $row, (string)$item->nisn_peserta, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    }
                    $worksheet->getCell('D' . $row)->setValue($item->tempat_lahir_peserta);
                    $worksheet->getCell('E' . $row)->setValue($item->tanggal_lahir_peserta);
                    $worksheet->getCell('F' . $row)->setValue($item->jenis_kelamin_peserta);
                    $worksheet->getCell('G' . $row)->setValue($item->kode_pendaftaran);
                    $worksheet->getCell('H' . $row)->setValue($item->via_jalur);
                    $jarakDomisili = $item->jarak_domisili . ' Km';
                    $worksheet->getCell('I' . $row)->setValue($jarakDomisili);
                    switch ((int)$item->status_pendaftaran) {
                        case 1:
                            $worksheet->getCell('J' . $row)->setValue("MENUNGGU PENGUMUMAN");
                            break;
                        case 2:
                            $worksheet->getCell('J' . $row)->setValue("LOLOS");
                            break;
                        case 3:
                            $worksheet->getCell('J' . $row)->setValue("TIDAK LOLOS");
                            break;

                        default:
                            $worksheet->getCell('J' . $row)->setValue("MENUNGGU PENGUMUMAN");
                            break;
                    }
                    $worksheet->setCellValueExplicit("K" . $row, tgl_indo2($item->created_at), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $worksheet->getCell('L' . $row)->setValue($item->nama_verifikator);
                    // $worksheet->setCellValueExplicit("G" . $row, $item->us_pang_mk_tahun, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);

                    $row++;
                }
            }

            // Menyiapkan objek writer untuk menulis file Excel
            $writer = new Xls($spreadsheet);

            // Menuliskan file Excel
            if ($jalur == "all") {
                if ($status == "all") {
                    $filename = 'DATA_PENDAFTAR_LOLOS_VERIFIKASI.xls';
                } else {
                    $filename = 'DATA_PENDAFTAR_LOLOS_VERIFIKASI_' . $status . '.xls';
                }
            } else {
                if ($status == "all") {
                    $filename = 'DATA_PENDAFTAR_LOLOS_VERIFIKASI_' . strtoupper($jalur) . '.xls';
                } else {
                    $filename = 'DATA_PENDAFTAR_LOLOS_VERIFIKASI_' . $status . '_' . strtoupper($jalur) . '.xls';
                }
            }
            header('Content-Type: application/vnd-ms-excel');
            // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit();
            //code...
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }
}
