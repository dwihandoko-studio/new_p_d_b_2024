<?php

namespace App\Controllers\Adm\Layanan;

use App\Controllers\BaseController;
use App\Models\Adm\Layanan\PendaftaranModel;
use App\Models\Adm\Masterdata\SekolahpdModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Ppdb\Adm\Riwayatlib;
use App\Libraries\Ppdb\Notificationlib;
use App\Libraries\Apilib;
use App\Libraries\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use setasign\Fpdi\TcpdfFpdi;

class Cabutberkas extends BaseController
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
        $request = Services::request();
        $datamodel = new SekolahpdModel($request);


        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<a class="btn btn-primary" href="./detaillist?id=' . $list->sekolah_id . '&n=' . $list->nama . '"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                                ';

            $row[] = $action;
            $row[] = $list->nama;
            $row[] = $list->npsn;
            $row[] = $list->bentuk_pendidikan;
            $row[] = $list->kecamatan;
            $row[] = $list->jumlah_siswa;

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all(),
            "recordsFiltered" => $datamodel->count_filtered(),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function getAllTkAkhir()
    {

        $request = Services::request();
        $datamodel = new PendaftaranModel($request);


        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            // $action = '<div class="btn-group">
            //                 <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
            //                 <div class="dropdown-menu" style="">
            //                     <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->peserta_didik_id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
            //                     <a class="dropdown-item" href="javascript:actionResetPassword(\'' . $list->peserta_didik_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="bx bx-key font-size-16 align-middle"></i> &nbsp;Reset Password</a>
            //                     <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->peserta_didik_id . '\', \'' . str_replace("'", "", $list->nama)  . '\');"><i class="bx bx-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
            //                     <div class="dropdown-divider"></div>
            //                 </div>
            //             </div>';
            $action = '<a href="' . base_url() . '/adm/layanan/cabutberkas/detail?d=' . $list->id . '&t=' . $list->kode_pendaftaran . '" class="btn btn-xs btn-primary waves-effect waves-light"><i class="las la-eye font-size-16 align-middle me-2" style="font-size: 1.5rem !important;"></i> DETAIL</a>';

            $row[] = $action;
            $row[] = $list->nama_peserta;
            $row[] = $list->nisn_peserta;
            $row[] = $list->via_jalur;
            $row[] = $list->nama_sekolah_asal;
            $row[] = $list->npsn_sekolah_asal;
            $row[] = round($list->jarak_domisili, 3) . ' Km';
            $row[] = $list->nama_verifikator;
            // switch ($list->is_active) {
            //     case 1:
            //         $row[] = '<div class="text-center">
            //                 <span class="badge rounded-pill badge-soft-success font-size-11">Aktif</span>
            //             </div>';
            //         break;
            //     default:
            //         $row[] = '<div class="text-center">
            //             <span class="badge rounded-pill badge-soft-danger font-size-11">Non Aktif</span>
            //         </div>';
            //         break;
            // }
            // switch ($list->email_verified) {
            //     case 1:
            //         $row[] = '<div class="text-center">
            //                 <span class="badge rounded-pill badge-soft-success font-size-11">Ya</span>
            //             </div>';
            //         break;
            //     default:
            //         $row[] = '<div class="text-center">
            //             <span class="badge rounded-pill badge-soft-danger font-size-11">Tidak</span>
            //         </div>';
            //         break;
            // }
            // switch ($list->wa_verified) {
            //     case 1:
            //         $row[] = '<div class="text-center">
            //                 <span class="badge rounded-pill badge-soft-success font-size-11">Ya</span>
            //             </div>';
            //         break;
            //     default:
            //         $row[] = '<div class="text-center">
            //             <span class="badge rounded-pill badge-soft-danger font-size-11">Tidak</span>
            //         </div>';
            //         break;
            // }

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all(),
            "recordsFiltered" => $datamodel->count_filtered(),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        return redirect()->to(base_url('adm/layanan/cabutberkas/data'));
    }

    public function data()
    {
        $data['title'] = 'SEKOLAH';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        $data['kecamatans'] = $this->_db->table('ref_kecamatan')->where('id_kabupaten', '120200')->orderBy('nama', 'ASC')->get()->getResult();
        $data['jenjangs'] = $this->_db->table('dapo_sekolah')->select("bentuk_pendidikan_id, bentuk_pendidikan, count(bentuk_pendidikan_id) as jumlah")->groupBy('bentuk_pendidikan_id')->orderBy('bentuk_pendidikan', 'ASC')->get()->getResult();

        return view('adm/layanan/cabutberkas/sekolah', $data);
    }

    public function detaillist()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $id = htmlspecialchars($this->request->getGet('id'), true);
        $name = htmlspecialchars($this->request->getGet('n'), true);
        $data['title'] = "DATA PESERTA DIDIK SEKOLAH $name";
        $data['id'] = $id;
        $data['sekolah'] = $name;
        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;

        return view('adm/layanan/cabutberkas/index', $data);
    }

    public function detail()
    {
        $data['title'] = 'DETAIL PENDAFTAR LOLOS VERIFIKASI';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
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
            return redirect()->to(base_url('adm/layanan/cabutberkas/lolos'));
        }

        $data['data'] = $oldData;
        $data['koreg'] = $oldData->kode_pendaftaran;
        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        if ($oldData->via_jalur == "PRESTASI") {
            return view('adm/layanan/cabutberkas/detail_pres', $data);
        } else {
            return view('adm/layanan/cabutberkas/detail', $data);
        }
    }


    public function formCabut()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Id tidak boleh kosong. ',
                    ]
                ],
                'koreg' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kode pendaftaran tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('id')
                    . $this->validator->getError('nama')
                    . $this->validator->getError('koreg');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->user();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    return redirect()->to(base_url('auth'));
                }

                $id = htmlspecialchars($this->request->getVar('id'), true);
                $koreg = htmlspecialchars($this->request->getVar('koreg'), true);
                $nama = htmlspecialchars($this->request->getVar('nama'), true);

                $oldData = $this->_db->table('_tb_pendaftar a')
                    ->select("a.*, b.nama_ibu_kandung, b.nik, b.no_kk, b.alamat_jalan, b.no_kip, b.no_pkh, c.nohp, c.email")
                    ->join('dapo_peserta b', 'b.peserta_didik_id = a.peserta_didik_id')
                    ->join('_users_tb c', 'c.id = a.user_id')
                    ->where('a.id', $id)
                    ->get()->getRowObject();

                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data tidak ditemukan.";
                    return json_encode($response);
                }

                $x['data'] = $oldData;

                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('adm/layanan/cabutberkas/form_keterangan', $x);
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function cabutBerkasSave()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                '_id_cabut_berkas' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Id tidak boleh kosong. ',
                    ]
                ],
                '_nama_cabut_berkas' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nama tidak boleh kosong. ',
                    ]
                ],
                '_keterangan_cabut_berkas' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Keterangan tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_id_cabut_berkas')
                    . $this->validator->getError('_nama_cabut_berkas')
                    . $this->validator->getError('_keterangan_cabut_berkas');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->user();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session expired";
                    return json_encode($response);
                }

                $id = htmlspecialchars($this->request->getVar('_id_cabut_berkas'), true);
                $nama = htmlspecialchars($this->request->getVar('_nama_cabut_berkas'), true);
                $keterangan_penolakan = htmlspecialchars($this->request->getVar('_keterangan_cabut_berkas'), true);

                $oldData = $this->_db->table('_tb_pendaftar a')
                    ->select("a.*, b.nama_ibu_kandung, b.nik, b.no_kk, b.alamat_jalan, b.no_kip, b.no_pkh, c.nohp, c.email")
                    ->join('dapo_peserta b', 'b.peserta_didik_id = a.peserta_didik_id')
                    ->join('_users_tb c', 'c.id = a.user_id')
                    ->where('a.id', $id)
                    ->get()->getRowObject();

                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data tidak ditemukan.";
                    return json_encode($response);
                }

                $dataMove = $this->_db->table('_tb_pendaftar')->where('id', $oldData->id)->get()->getRowArray();

                $this->_db->transBegin();

                $dataMove['updated_at'] = date('Y-m-d H:i:s');
                $dataMove['update_reject'] = date('Y-m-d H:i:s');
                $dataMove['admin_approval'] = $user->data->id;
                $dataMove['keterangan_penolakan'] = "Cabut berkas pendaftaran dengan keterangan: " . $keterangan_penolakan;
                $dataMove['status_pendaftaran'] = 3;

                $this->_db->table('_tb_pendaftar_tolak')->insert($dataMove);
                if ($this->_db->affectedRows() > 0) {
                    $this->_db->table('_tb_pendaftar')->where('id', $dataMove['id'])->delete();
                    if ($this->_db->affectedRows() > 0) {
                        try {
                            $riwayatLib = new Riwayatlib();
                            $riwayatLib->insert($user->data->id, "Menolak Pendaftaran $oldData->nama_peserta via Jalur $oldData->via_jalur dengan NISN : " . $oldData->nisn_peserta, "Tolak Pendaftaran Jalur $oldData->via_jalur", "tolak");

                            $saveNotifSystem = new Notificationlib();
                            $saveNotifSystem->send([
                                'judul' => "Pendaftaran Jalur $oldData->via_jalur Ditolak.",
                                'isi' => "Pendaftaran anda melalui jalur $oldData->via_jalur ditolak dengan keterangan: $keterangan_penolakan.",
                                'action_web' => 'peserta/riwayat/pendaftaran',
                                'action_app' => 'riwayat_pendaftaran_page',
                                'token' => $dataMove['id'],
                                'send_from' => $user->data->id,
                                'send_to' => $dataMove['user_id'],
                            ]);
                        } catch (\Throwable $th) {
                        }
                        $this->_db->transCommit();
                        $response = new \stdClass;
                        $response->status = 200;
                        $response->url = base_url('adm/layanan/cabutberkas');
                        $response->message = "Cabut Berkas Verifikasi pendaftaran $oldData->nama_peserta berhasil dilakukan.";
                        return json_encode($response);
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal cabut berkas verifikasi status pendaftaran peserta. $oldData->nama_peserta";
                        return json_encode($response);
                    }
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal cabut berkas verifikasi pendaftaran peserta. $oldData->nama_peserta";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
