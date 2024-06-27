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

class Perubahan extends BaseController
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
            $action = '<a href="' . base_url() . '/adm/layanan/perubahan/detail?d=' . $list->id . '&t=' . $list->kode_pendaftaran . '" class="btn btn-xs btn-primary waves-effect waves-light"><i class="las la-eye font-size-16 align-middle me-2" style="font-size: 1.5rem !important;"></i> DETAIL</a>';

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
        return redirect()->to(base_url('adm/layanan/perubahan/data'));
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

        return view('adm/layanan/perubahan/sekolah', $data);
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

        return view('adm/layanan/perubahan/index', $data);
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
            return redirect()->to(base_url('adm/layanan/perubahan/lolos'));
        }

        $data['data'] = $oldData;
        $data['koreg'] = $oldData->kode_pendaftaran;
        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        if ($oldData->via_jalur == "PRESTASI") {
            return view('adm/layanan/perubahan/detail_pres', $data);
        } else {
            return view('adm/layanan/perubahan/detail', $data);
        }
    }

    public function formPerubahan()
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


                // $x['props'] = $this->_db->table('ref_provinsi')
                //     ->get()->getResult();
                // $x['kabs'] = $this->_db->table('ref_kabupaten')
                //     ->where("left(id,2) = left('{$oldData->kab_peserta}',2)")->get()->getResult();
                // $x['kecs'] = $this->_db->table('ref_kecamatan')
                //     ->where("id_kabupaten = '{$oldData->kab_peserta}'")->get()->getResult();
                // $x['kels'] = $this->_db->table('ref_kelurahan')
                //     ->where("id_kecamatan = '{$oldData->kec_peserta}'")->get()->getResult();
                // $x['dusuns'] = $this->_db->table('ref_dusun')->orderBy('urut', 'ASC')
                //     ->get()->getResult();
                $x['sek'] = $this->_db->table('dapo_sekolah')->select("lintang, bujur")->where('sekolah_id', $oldData->from_sekolah_id)->get()->getRowObject();

                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('adm/layanan/perubahan/form_perubahan', $x);
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function perubahanSave()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                '_id_perubahan' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Id tidak boleh kosong. ',
                    ]
                ],
                '_nama_perubahan' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nama tidak boleh kosong. ',
                    ]
                ],
                '_pengaju' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Pengaju tidak boleh kosong. ',
                    ]
                ],
                '_status_pengaju' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Status pengaju tidak boleh kosong. ',
                    ]
                ],
                '_perubahan_pengaju' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Perubahan pengaju tidak boleh kosong. ',
                    ]
                ],
                '_lintang' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Lintang tidak boleh kosong. ',
                    ]
                ],
                '_bujur' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Bujur tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_id_perubahan')
                    . $this->validator->getError('_nama_perubahan')
                    . $this->validator->getError('_pengaju')
                    . $this->validator->getError('_status_pengaju')
                    . $this->validator->getError('_perubahan_pengaju')
                    . $this->validator->getError('_lintang')
                    . $this->validator->getError('_bujur');
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

                $id = htmlspecialchars($this->request->getVar('_id_perubahan'), true);
                $nama = htmlspecialchars($this->request->getVar('_nama_perubahan'), true);
                $nama_pengaju = htmlspecialchars($this->request->getVar('_pengaju'), true);
                $status_pengaju = htmlspecialchars($this->request->getVar('_status_pengaju'), true);
                $perubahan_pengaju = htmlspecialchars($this->request->getVar('_perubahan_pengaju'), true);
                $lintang = htmlspecialchars($this->request->getVar('_lintang'), true);
                $bujur = htmlspecialchars($this->request->getVar('_bujur'), true);

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

                $lat_long = $lintang . "," . $bujur;

                if (
                    ($lat_long === $oldData->lat_long_peserta)
                ) {
                    $response = new \stdClass;
                    $response->status = 201;
                    $response->message = "Tidak ada perubahan data yang disimpan.";
                    return json_encode($response);
                }

                $latitu = explode(",", $oldData->lat_long_peserta);

                $dataPerubahan = $this->_db->table('_tb_pendaftar')->where('id', $oldData->id)->get()->getRowArray();

                $getJarak = $this->_db->table('dapo_sekolah a')
                    ->select("a.nama, a.npsn, a.lintang, a.bujur, ROUND(getDistanceKm(a.lintang,a.bujur,'{$lintang}','{$bujur}'), 2) AS distance_in_km")
                    ->where("a.sekolah_id = '{$oldData->tujuan_sekolah_id_1}'")
                    ->get()->getRowObject();
                if (!$getJarak) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menghitung jarak domisili.";
                    return json_encode($response);
                }

                $dataLama = json_encode($dataPerubahan);

                $dataPerubahan['jarak_domisili'] = $getJarak->distance_in_km;

                if (!($lat_long === $oldData->lat_long_peserta)) {
                    $dataPerubahan['lat_long_peserta'] = $lat_long;
                }
                $uuid = new Uuid();
                $id_perubahan = $uuid->v4();
                $dataPerubahan['id_perubahan_ad'] = $id_perubahan;

                $this->_db->transBegin();
                $this->_db->table('_tb_pendaftar')->where('id', $oldData->id)->update($dataPerubahan);
                if ($this->_db->affectedRows() > 0) {
                    $this->_db->table('riwayat_perubahan_data_adm')->insert([
                        'id_perubahan' => $dataPerubahan['id_perubahan'],
                        'nama_pengaju' => $nama_pengaju,
                        'status_pengaju' => $status_pengaju,
                        'perubahan_pengaju' => $perubahan_pengaju,
                        'data_lama' => $dataLama,
                        'data_baru' => json_encode($dataPerubahan),
                        'user_id' => $user->data->id,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                    if ($this->_db->affectedRows() > 0) {
                        try {
                            $riwayatLib = new Riwayatlib();
                            $riwayatLib->insert("Melakukan perubahan data pendaftaran $oldData->nama_peserta via Jalur $oldData->via_jalur dengan NISN : " . $oldData->nisn_peserta, "Perubahan data pendaftaran $oldData->nisn_peserta", "update");
                        } catch (\Throwable $th) {
                        }
                        $this->_db->transCommit();

                        $response = new \stdClass;
                        $response->status = 200;
                        $response->nama = $oldData->nama_peserta;
                        $response->url = base_url('adm/layanan/perubahan') . '/download_berita_acara?id=' . $dataPerubahan['id_perubahan'];
                        $response->message = "Perubahan data pendaftaran $oldData->nama_peserta berhasil dilakukan.";
                        return json_encode($response);
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal melakukan perubahan pendaftaran peserta. $oldData->nama_peserta";
                        return json_encode($response);
                    }
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal melakukan perubahan pendaftaran peserta. $oldData->nama_peserta";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function location()
    {
        if ($this->request->isAJAX()) {
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

            $lat = htmlspecialchars($this->request->getVar('lat'), true) ?? "";
            $long = htmlspecialchars($this->request->getVar('long'), true) ?? "";

            if ($lat == "" && $long == "") {
                $sek = $this->_db->table('dapo_sekolah')->select("lintang, bujur")->where('sekolah_id', $user->data->sekolah_id)->get()->getRowObject();
                if ($sek) {
                    if ($lat == "") {
                        $lat = $sek->lintang;
                    }
                    if ($long == "") {
                        $lat = $sek->bujur;
                    }
                }
            }

            $x['lat'] = $lat;
            $x['long'] = $long;

            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->lat = $lat;
            $response->long = $long;
            $response->data = view('adm/layanan/perubahan/maps', $x);
            return json_encode($response);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function download_berita_acara()
    {
        if ($this->request->isAJAX()) {
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

            $id = htmlspecialchars($this->request->getGet('id'), true);

            $data = $this->_db->table('riwayat_perubahan_data_adm')->where('id_perubahan', $id)->get()->getRowObject();

            if (!$data) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data perubahan tidak ditemukan";
                return json_encode($response);
            }

            $htmlPengaju = '<table border="0">
                            <tr>
                                <td>Nama</td>
                                <td colspan="2">: <b>{{ nama_pengaju }}</b></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td colspan="2">: {{ status_pengaju }}</td>
                            </tr>
                        </table>';

            $htmlPeserta = '<table>
                            <tr>
                                <td>Nama Peserta</td>
                                <td colspan="2">: {{ nama_peserta }}</td>
                            </tr>
                            <tr>
                                <td>Nomor Peserta</td>
                                <td colspan="2">: <b>{{ nomor_peserta }}</b></td>
                            </tr>
                            <tr>
                                <td>NISN Peserta</td>
                                <td colspan="2">: {{ nisn_peserta }}</td>
                            </tr>
                            <tr>
                                <td>Nama Sekolah Asal</td>
                                <td colspan="2">: {{ nama_sekolah_asal }}</td>
                            </tr>
                            <tr>
                                <td>Jalur PPDB</td>
                                <td colspan="2">: {{ jalur_ppdb }}</td>
                            </tr>
                        </table>';

            $htmlPerubahan = '<table border="1" style="padding: 5px;">';
            $htmlPerubahan .= '<tr><td>Atribut</td><td>Data Lama</td><td>Data Baru</td></tr>';

            $dataLama = json_decode($data->data_lama);
            $dataBaru = json_decode($data->data_baru);

            if ($data->perubahan_pengaju === "domisili") {
                if ($dataLama->kab_peserta !== $dataBaru->kab_peserta) {
                    $kabupatenNameL = getNameKabupaten($dataLama->kab_peserta);
                    $kabupatenNameB = getNameKabupaten($dataBaru->kab_peserta);
                    $htmlPerubahan .= '
                            <tr>
                                <td>Kabupaten</td>
                                <td>' . $kabupatenNameL . '</td>
                                <td>' . $kabupatenNameB . '</td>
                            </tr>
                        ';
                }
                if ($dataLama->kec_peserta !== $dataBaru->kec_peserta) {
                    $kecamatanNameL = getNameKecamatan($dataLama->kec_peserta);
                    $kecamatanNameB = getNameKecamatan($dataBaru->kec_peserta);
                    $htmlPerubahan .= '
                            <tr>
                                <td>Kecamatan</td>
                                <td>' . $kecamatanNameL . '</td>
                                <td>' . $kecamatanNameB . '</td>
                            </tr>
                        ';
                }
                if ($dataLama->kel_peserta !== $dataBaru->kel_peserta) {
                    $kelurahanNameL = getNameKelurahan($dataLama->kel_peserta);
                    $kelurahanNameB = getNameKelurahan($dataBaru->kel_peserta);
                    $htmlPerubahan .= '
                            <tr>
                                <td>Kelurahan</td>
                                <td>' . $kelurahanNameL . '</td>
                                <td>' . $kelurahanNameB . '</td>
                            </tr>
                        ';
                }
                if ($dataLama->dusun_peserta !== $dataBaru->dusun_peserta) {
                    $dusunNameL = getNameDusun($dataLama->dusun_peserta);
                    $dusunNameB = getNameDusun($dataBaru->dusun_peserta);
                    $htmlPerubahan .= '
                            <tr>
                                <td>Dusun</td>
                                <td>' . $dusunNameL . '</td>
                                <td>' . $dusunNameB . '</td>
                            </tr>
                        ';
                }
                if ($dataLama->lat_long_peserta !== $dataBaru->lat_long_peserta) {
                    $latLongL = explode(",", $dataLama->lat_long_peserta);
                    $latLongB = explode(",", $dataBaru->lat_long_peserta);
                    $htmlPerubahan .= '
                            <tr>
                                <td>Lintang</td>
                                <td>' . $latLongL[0] . '</td>
                                <td>' . $latLongB[0] . '</td>
                            </tr>
                            <tr>
                                <td>Bujur</td>
                                <td>' . $latLongL[1] . '</td>
                                <td>' . $latLongB[1] . '</td>
                            </tr>
                        ';
                }
                if ($dataLama->jarak_domisili !== $dataBaru->jarak_domisili) {
                    $jarakL = round($dataLama->jarak_domisili, 3);
                    $jarakB = round($dataBaru->jarak_domisili, 3);
                    $htmlPerubahan .= '
                            <tr>
                                <td>Jarak Domisili</td>
                                <td>' . $jarakL . 'Km</td>
                                <td>' . $jarakB . 'Km</td>
                            </tr>
                        ';
                }
            } else {
                if ($dataLama->kab_peserta !== $dataBaru->kab_peserta) {
                    $kabupatenNameL = getNameKabupaten($dataLama->kab_peserta);
                    $kabupatenNameB = getNameKabupaten($dataBaru->kab_peserta);
                    $htmlPerubahan .= '
                            <tr>
                                <td>Kabupaten</td>
                                <td>$kabupatenNameL</td>
                                <td>$kabupatenNameB</td>
                            </tr>
                        ';
                }
            }

            $htmlPerubahan .= '</table>';

            $penutup = 'Berdasarkan dokumen ';
            if ($data->perubahan_pengaju === "domisili") {
                $penutup .= 'kependudukan ';
            } else {
                $penutup .= 'prestasi ';
            }
            $penutup .= "yang dimiliki, pengajuan perbaikan data {$data->perubahan_pengaju} disetujui oleh Panitia PPDB {$dataLama->nama_sekolah_tujuan} (NPSN: {$dataLama->npsn_sekolah_tujuan}).";

            $tglPerbaikan = "Lampung Tengah, " . tgl_indo($data->created_at);

            $bottom = '<table>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Orang Tua/Wali</td>
                            <td>&nbsp;</td>
                            <td>Panitia PPDB</td>
                            <td rowspan="5"><img src="https://qrcode.esline.id/generate?data=https://ppdb.lampungtengahkab.go.id/home/qrcode?ba={{ id_perubahan }}" style="width: 80px;" alt="Logo"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>{{ nama_pengaju }}</td>
                            <td>&nbsp;</td>
                            <td>{{ nama_panitia }}</td>
                        </tr>
                    </table>';

            $htmlPengaju = str_replace('{{ nama_pengaju }}', $data->nama_pengaju, $htmlPengaju);
            $htmlPengaju = str_replace('{{ status_pengaju }}', $data->status_pengaju, $htmlPengaju);

            $htmlPeserta = str_replace('{{ nomor_peserta }}', $dataLama->kode_pendaftaran, $htmlPeserta);
            $htmlPeserta = str_replace('{{ nama_peserta }}', $dataLama->nama_peserta, $htmlPeserta);
            $htmlPeserta = str_replace('{{ nisn_peserta }}', $dataLama->nisn_peserta, $htmlPeserta);
            $htmlPeserta = str_replace('{{ nama_sekolah_asal }}', $dataLama->nama_sekolah_asal . " (NPSN: " . $dataLama->npsn_sekolah_asal . ")", $htmlPeserta);
            $htmlPeserta = str_replace('{{ jalur_ppdb }}', $dataLama->via_jalur, $htmlPeserta);

            $bottom = str_replace('{{ nama_pengaju }}', ucwords(strtolower($data->nama_pengaju)), $bottom);
            $bottom = str_replace('{{ nama_panitia }}', ucwords(strtolower($user->data->nama)), $bottom);
            $bottom = str_replace('{{ id_perubahan }}', $data->id_perubahan, $bottom);

            $pdf = new TcpdfFpdi('P', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // Load HTML content
            $pdf->AddPage();
            // $pdf->SetFont('times', 'B', 12);
            $pdf->SetFont('times', 'B', 12);
            // $pdf->MultiCell(180, 10, $kop, 0, 'C', false, 1, 20, null, true, 0, true);
            // $pdf->MultiCell(180, 10, '<hr />', 0, 'C', false, 1, 20, null, true, 0, true);
            // $pdf->Cell(200, 10, 'KARTU AKUN PPDB KAB. LAMPUNG TENGAH TAHUN 2024/2025', 0, 1, 'C');
            $pdf->Ln(10);
            $pdf->MultiCell(180, 1, '<u>Berita Acara Layanan Perbaikan Data</u>', 0, 'C', false, 1, 20, null, true, 0, true);
            $pdf->SetFont('times', 'N', 12);
            $nomorSurat = "Nomor Pelayanan: BA.{$data->id}/PD/PPDB/2024";
            $pdf->MultiCell(180, 1, $nomorSurat, 0, 'C', false, 1, 20, null, true, 0, true);
            // $pdf->MultiCell(180, 5, '<h4>TAHUN PELAJARAN 2024/2025</h4>', 0, 'C', false, 1, 20, null, true, 0, true);
            $pdf->Ln(10);
            $pdf->MultiCell(180, 10, $htmlPengaju, 0, 'L', false, 1, 20, null, true, 0, true);
            $pdf->Ln(5);
            $centerContent = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telah mengajukan perubahan data {$data->perubahan_pengaju} peserta atas nama: ";
            $pdf->MultiCell(180, 10, $centerContent, 0, 'L', false, 1, 20, null, true, 0, true);
            $pdf->Ln(4);
            $pdf->MultiCell(180, 10, $htmlPeserta, 0, 'L', false, 1, 20, null, true, 0, true);
            $pdf->Ln(4);
            $pdf->MultiCell(180, 10, 'Data yang diajukan perbaikan :', 0, 'L', false, 1, 20, null, true, 0, true);
            $pdf->MultiCell(180, 10, $htmlPerubahan, 0, 'L', false, 1, 20, null, true, 0, true);
            $pdf->Ln(4);
            $pdf->MultiCell(180, 5, $penutup, 0, 'L', false, 1, 20, null, true, 0, true);
            $pdf->Ln(10);
            $pdf->MultiCell(180, 5, $tglPerbaikan, 0, 'C', false, 1, 20, null, true, 0, true);
            $pdf->MultiCell(180, 10, $bottom, 0, 'C', false, 1, 20, null, true, 0, true);
            // $pdf->Ln(20);
            // $pdf->MultiCell(70, 20, "OPERATOR {$pd->nama_sekolah_asal}", 0, 'L', false, 1, 130, null, true, 0, true);
            // $pdf->Ln(10);
            // $pdf->MultiCell(70, 20, $user->data->nama, 0, 'L', false, 1, 130, null, true, 0, true);

            // $pdf->WriteHTML($html);

            // Output PDF
            $dir = FCPATH . "uploads/temp";
            $filename = 'Berita_acara_perubahan_data_' . $data->id . '.pdf';
            $fileName = $dir . '/' . $filename;
            $pdf->Output($fileName, 'F'); // Generate and save to temporary file

            sleep(2);

            $fileContent = file_get_contents($fileName);
            $base64Data = base64_encode($fileContent);
            // unlink($fileName); // Delete the temporary file

            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Berita Acara Berhasil Didownload.";
            $response->data = $base64Data;
            $response->filename = $filename;
            return json_encode($response);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}