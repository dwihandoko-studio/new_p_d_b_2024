<?php

namespace App\Controllers\Adm\Analisis;

use App\Controllers\BaseController;
use App\Models\Adm\Analisis\ProsesjalurModel;
use App\Models\Adm\Analisis\SekolahModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Adm\Prosesluluslib;
use App\Libraries\Apilib;
use App\Libraries\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use setasign\Fpdi\TcpdfFpdi;

class Proses extends BaseController
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
        $datamodel = new SekolahModel($request);


        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<a class="btn btn-primary" href="./detaillist?id=' . $list->sekolah_id . '&n=' . $list->nama_sekolah . '"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                                ';

            $row[] = $action;
            $row[] = $list->nama_sekolah;
            $row[] = $list->npsn;
            $row[] = $list->bentuk_pendidikan_sekolah;
            $row[] = $list->nama_kecamatan;
            $row[] = '<span class="badge light badge-primary">' . $list->jumlah_pendaftar . '</span>';

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

    public function getAllDetail()
    {
        $request = Services::request();
        $datamodel = new ProsesjalurModel($request);


        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            // $action = '<div class="btn-group">
            //     <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
            //     <div class="dropdown-menu" style="">
            //         <a class="dropdown-item" href="javascript:actionResetPassword(\'' . $list->peserta_didik_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="bx bx-key font-size-16 align-middle"></i> &nbsp;Reset Password</a>
            //     </div>
            // </div>';

            // $row[] = $action;
            $row[] = $list->nama_peserta;
            $row[] = $list->nisn_peserta;
            $row[] = $list->via_jalur;
            $row[] = $list->jarak_domisili . ' Km';
            $row[] = $list->nama_sekolah_asal;
            $row[] = $list->npsn_sekolah_asal;
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
        return redirect()->to(base_url('adm/analisis/proses/data'));
    }

    public function data()
    {
        $data['title'] = 'PROSES ANALISIS PPDB';
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
        $data['kecamatans'] = $this->_db->table('ref_kecamatan')->orderBy('nama', 'ASC')->get()->getResult();
        // $data['jenjangs'] = $this->_db->table('dapo_sekolah')->select("bentuk_pendidikan_id, bentuk_pendidikan, count(bentuk_pendidikan_id) as jumlah")->groupBy('bentuk_pendidikan_id')->orderBy('bentuk_pendidikan', 'ASC')->get()->getResult();

        return view('adm/analisis/proses/sekolah', $data);
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
        $data['title'] = "ANALISIS PROSES DATA PESERTA DIDIK SEKOLAH $name";
        $data['id'] = $id;
        $data['nama_sekolah'] = $name;
        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;

        return view('adm/analisis/proses/index', $data);
    }


    public function verified_otomatis()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data = $this->_db->table('_tb_pendaftar_temp')->get()->getResultArray();
        if (count($data) > 0) {
            print_r("MULAI VERIFIED OTOMATIS<br>");
            foreach ($data as $key => $cekRegisterTemp) {
                $cekRegisterTemp['updated_at'] = date('Y-m-d H:i:s');
                $cekRegisterTemp['update_reject'] = date('Y-m-d H:i:s');
                $cekRegisterTemp['admin_approval'] = 'system_auto';
                $cekRegisterTemp['status_pendaftaran'] = 3;
                $cekRegisterTemp['keterangan_penolakan'] = "Sekolah tujuan belum memverifikasi pendaftaran.";

                $this->_db->transBegin();
                $this->_db->table('_tb_pendaftar_tolak')->insert($cekRegisterTemp);
                if ($this->_db->affectedRows() > 0) {
                    $this->_db->table('_tb_pendaftar_temp')->where('id', $cekRegisterTemp['id'])->delete();
                    if ($this->_db->affectedRows() > 0) {

                        // try {

                        // $riwayatLib = new Riwayatlib();
                        // $riwayatLib->insert("Memverifikasi Pendaftaran $name via Jalur Afirmasi dengan No Pendaftaran : " . $cekRegisterTemp['kode_pendaftaran'], "Memverifikasi Pendaftaran Jalur Afirmasi", "submit");

                        // $saveNotifSystem = new Notificationlib();
                        // $saveNotifSystem->send([
                        //     'judul' => "Pendaftaran Jalur " . $cekRegisterTemp['via_jalur'] ." Telah Diverifikasi.",
                        //     'isi' => "Pendaftaran anda melalui jalur " . $cekRegisterTemp['via_jalur'] ." telah diverifikasi otomatis by system karena proses verifikasi oleh sekolah sudah di, selanjutnya silahkan menunggu pengumuman sesuai jadwal yang telah ditentukan.",
                        //     'action_web' => 'peserta/riwayat/pendaftaran',
                        //     'action_app' => 'riwayat_pendaftaran_page',
                        //     'token' => $cekRegisterTemp['kode_pendaftaran'],
                        //     'send_from' => $userId,
                        //     'send_to' => $cekRegisterTemp['user_id'],
                        // ]);

                        // $onesignal = new Fcmlib();
                        // $send = $onesignal->pushNotifToUser([
                        //     'title' => "Pendaftaran Jalur Afirmasi Telah Diverifikasi.",
                        //     'content' => "Pendaftaran anda melalui jalur afirmasi telah diverifikasi oleh sekolah tujuan, selanjutnya silahkan menunggu pengumuman sesuai jadwal yang telah ditentukan.",
                        //     'send_to' => $cekRegisterTemp['user_id'],
                        //     'app_url' => 'riwayat_pendaftaran_page',
                        // ]);
                        // } catch (\Throwable $th) {
                        // }

                        $this->_db->transCommit();
                        print_r("BERHASIL VERIVIED AUTO<br>");
                        continue;
                        // $response = new \stdClass;
                        // $response->code = 200;
                        // $response->message = "Verifikasi pendaftaran $name berhasil dilakukan.";
                        // return json_encode($response);
                    } else {
                        $this->_db->transRollback();
                        print_r("GAGAL VERIVIED AUTO<br>" . $cekRegisterTemp['id']);
                        continue;
                    }
                } else {
                    $this->_db->transRollback();
                    print_r("GAGAL VERIVIED AUTO<br>" . $cekRegisterTemp['id']);
                    continue;
                }
            }
        } else {
            print_r("TIDAK ADA DATA");
        }
    }

    public function proseskelulusanafirmasisd()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        // $selectSekolah = "a.id as id_pendaftaran, a.tujuan_sekolah_id_1, j.nama as nama_sekolah_tujuan, j.npsn as npsn_sekolah_tujuan, a.via_jalur, a.created_at, count(a.peserta_didik_id) as jumlah_pendaftar";  //14
        $dataSekolahs = $this->_db->table('_tb_pendaftar a')
            ->select("a.tujuan_sekolah_id_1, a.status_pendaftaran, b.bentuk_pendidikan_id, b.status_sekolah_id, count(a.peserta_didik_id) as jumlah_pendaftar")
            ->join('dapo_sekolah j', 'a.tujuan_sekolah_id_1 = j.id')
            ->where('a.status_pendaftaran', 1)
            ->where('a.via_jalur', 'AFIRMASI')
            ->where('j.bentuk_pendidikan_id', 5)
            ->groupBy('a.tujuan_sekolah_id_1')
            ->get()->getResult();

        if (count($dataSekolahs) > 0) {
            print_r("DATA SEKOLAH " . count($dataSekolahs));
            foreach ($dataSekolahs as $key => $id) {
                // print_r("SELESAI PROSES KELULUSAN ");
                $kuota = $this->_db->table('_setting_kuota_tb')->select("zonasi, afirmasi, mutasi, prestasi, (zonasi + afirmasi + mutasi + prestasi) as total, (SELECT count(peserta_didik_id) FROM _tb_pendaftar WHERE status_pendaftaran = 2 AND via_jalur = 'AFIRMASI' AND tujuan_sekolah_id_1 = '{$id->tujuan_sekolah_id_1}' ) as jumlah_lolos")->where('sekolah_id', $id->tujuan_sekolah_id_1)->get()->getRowObject();

                if (!$kuota) {
                    print_r("KUOTA TIDAK DITEMUKAN <br> ");
                    continue;
                }

                if ((int)$kuota->jumlah_lolos >= (int)$kuota->afirmasi) {
                    print_r("KUOTA AFIRMASI SUDAH PENUH <br> ");
                    continue;
                }

                // $sekolah = $this->_db->table('ref_sekolah_tujuan')->select("status_sekolah")->where('id', $id->tujuan_sekolah_id_1)->get()->getRowObject();

                // if (!$sekolah) {
                //     print_r("SEKOLAH TIDAK DITEMUKAN ");
                //     continue;
                // }

                if ((int)$id->status_sekolah_id != 1) {
                    print_r("SEKOLAH SWASTA SKIP ");
                    continue;
                }

                // $

                // $limitKuotaAfirmasi = 

                // $select = "b.id, b.nisn, b.fullname, b.peserta_didik_id, b.latitude, b.longitude, a.tujuan_sekolah_id_1, a.id as id_pendaftaran, c.nama as nama_sekolah_asal, c.npsn as npsn_sekolah_asal, j.nama as nama_sekolah_tujuan, j.npsn as npsn_sekolah_tujuan, j.latitude as latitude_sekolah_tujuan, j.longitude as longitude_sekolah_tujuan, a.kode_pendaftaran, a.via_jalur, a.created_at, ROUND(getDistanceKm(b.latitude,b.longitude,j.latitude,j.longitude), 2) AS jarak";


                $afirmasiData = $this->_db->table('_tb_pendaftar a')
                    ->select("a.id as id_pendaftaran, a.user_id, a.via_jalur, a.tujuan_sekolah_id_1, a.status_pendaftaran, a.jarak_domisili, a.created_at")
                    ->where('a.tujuan_sekolah_id_1', $id->tujuan_sekolah_id_1)
                    ->where('a.status_pendaftaran', 1)
                    ->where('a.via_jalur', 'AFIRMASI')
                    ->orderBy('a.jarak_domisili', 'ASC')
                    ->orderBy('a.created_at', 'ASC')
                    ->limit((int)$kuota->afirmasi)
                    ->get()->getResult();

                $lulusLib = new Prosesluluslib();

                if (count($afirmasiData) > 0) {
                    $lulusLib->prosesLulusAfirmasi($afirmasiData, $user->data->id);
                }
            }
            print_r("SELESAI PROSES KELULUSAN ");
        } else {
            print_r("DATA SEKOLAH TIDAK DITEMUKAN");
        }
    }

    public function proseskelulusanafirmasismp()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->code != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('web/home'));
        }

        $selectSekolah = "a.id as id_pendaftaran, a.tujuan_sekolah_id_1, j.nama as nama_sekolah_tujuan, j.npsn as npsn_sekolah_tujuan, a.via_jalur, a.created_at, count(a.peserta_didik_id) as jumlah_pendaftar";  //14
        $dataSekolahs = $this->_db->table('_tb_pendaftar a')
            ->select($selectSekolah)
            ->join('ref_sekolah_tujuan j', 'a.tujuan_sekolah_id_1 = j.id', 'LEFT')
            ->where('a.status_pendaftaran', 1)
            ->where('a.via_jalur', 'AFIRMASI')
            ->groupBy('a.tujuan_sekolah_id_1')
            ->where('j.bentuk_pendidikan_id', 6)
            ->get()->getResult();

        if (count($dataSekolahs) > 0) {
            print_r("DATA SEKOLAH " . count($dataSekolahs));
            foreach ($dataSekolahs as $key => $id) {
                // print_r("SELESAI PROSES KELULUSAN ");
                $kuota = $this->_db->table('_setting_kuota_tb')->select("zonasi, afirmasi, mutasi, prestasi, (zonasi + afirmasi + mutasi + prestasi) as total, (SELECT count(peserta_didik_id) FROM _tb_pendaftar WHERE status_pendaftaran = 2 AND via_jalur = 'AFIRMASI' AND tujuan_sekolah_id_1 = '{$id->tujuan_sekolah_id_1}' ) as jumlah_lolos")->where('sekolah_id', $id->tujuan_sekolah_id_1)->get()->getRowObject();

                if (!$kuota) {
                    print_r("KUOTA TIDAK DITEMUKAN <br> ");
                    continue;
                }

                if ((int)$kuota->jumlah_lolos >= (int)$kuota->afirmasi) {
                    print_r("KUOTA AFIRMASI SUDAH PENUH <br> ");
                    continue;
                }

                $sekolah = $this->_db->table('ref_sekolah_tujuan')->select("status_sekolah")->where('id', $id->tujuan_sekolah_id_1)->get()->getRowObject();

                if (!$sekolah) {
                    print_r("SEKOLAH TIDAK DITEMUKAN ");
                    continue;
                }

                if ((int)$sekolah->status_sekolah != 1) {
                    print_r("SEKOLAH SWASTA SKIP ");
                    continue;
                }

                // $

                // $limitKuotaAfirmasi = 

                $select = "b.id, b.nisn, b.fullname, b.peserta_didik_id, b.latitude, b.longitude, a.tujuan_sekolah_id_1, a.id as id_pendaftaran, c.nama as nama_sekolah_asal, c.npsn as npsn_sekolah_asal, j.nama as nama_sekolah_tujuan, j.npsn as npsn_sekolah_tujuan, j.latitude as latitude_sekolah_tujuan, j.longitude as longitude_sekolah_tujuan, a.kode_pendaftaran, a.via_jalur, a.created_at, ROUND(getDistanceKm(b.latitude,b.longitude,j.latitude,j.longitude), 2) AS jarak";


                $afirmasiData = $this->_db->table('_tb_pendaftar a')
                    ->select($select)
                    ->join('_users_profil_tb b', 'a.peserta_didik_id = b.peserta_didik_id', 'LEFT')
                    ->join('ref_sekolah_asal c', 'a.from_sekolah_id = c.id', 'LEFT')
                    ->join('ref_sekolah_tujuan j', 'a.tujuan_sekolah_id_1 = j.id', 'LEFT')
                    ->where('a.tujuan_sekolah_id_1', $id->tujuan_sekolah_id_1)
                    ->where('a.status_pendaftaran', 1)
                    ->where('a.via_jalur', 'AFIRMASI')
                    ->orderBy('jarak', 'ASC')
                    ->orderBy('a.created_at', 'ASC')
                    ->limit((int)$kuota->afirmasi)
                    ->get()->getResult();

                $lulusLib = new Prosesluluslib();

                if (count($afirmasiData) > 0) {
                    $lulusLib->prosesLulusAfirmasi($afirmasiData, $user->data->id);
                }
            }
            print_r("SELESAI PROSES KELULUSAN ");
        } else {
            print_r("DATA SEKOLAH TIDAK DITEMUKAN");
        }
    }


    // public function generate()
    // {
    //     if ($this->request->isAJAX()) {
    //         $Profilelib = new Profilelib();
    //         $user = $Profilelib->user();
    //         if ($user->status != 200) {
    //             delete_cookie('jwt');
    //             session()->destroy();
    //             $response = new \stdClass;
    //             $response->status = 401;
    //             $response->message = "Session telah habis";
    //             return json_encode($response);
    //         }

    //         $rules = [
    //             'id' => [
    //                 'rules' => 'required|trim',
    //                 'errors' => [
    //                     'required' => 'id tidak boleh kosong. ',
    //                 ]
    //             ],
    //             'nama' => [
    //                 'rules' => 'required|trim',
    //                 'errors' => [
    //                     'required' => 'Nama tidak boleh kosong. ',
    //                 ]
    //             ],
    //         ];

    //         if (!$this->validate($rules)) {
    //             $response = new \stdClass;
    //             $response->status = 400;
    //             $response->message = $this->validator->getError('id')
    //                 . $this->validator->getError('nama');
    //             return json_encode($response);
    //         } else {

    //             $id = htmlspecialchars($this->request->getVar('id'), true);
    //             $nama = htmlspecialchars($this->request->getVar('nama'), true);

    //             $oldData = $this->_db->table('dapo_peserta a')
    //                 ->select("a.*, b.npsn, b.nama as nama_sekolah")
    //                 ->join("dapo_sekolah b", "b.sekolah_id = a.sekolah_id")
    //                 ->where('a.peserta_didik_id', $id)->get()->getRowObject();
    //             if (!$oldData) {
    //                 $response = new \stdClass;
    //                 $response->status = 400;
    //                 $response->message = "Peserta didik tidak ditemukan.";
    //                 return json_encode($response);
    //             }

    //             $oldDataAkun = $this->_db->table('_users_profile_pd')
    //                 ->where('peserta_didik_id', $id)->get()->getRowObject();
    //             if ($oldDataAkun) {
    //                 $response = new \stdClass;
    //                 $response->status = 201;
    //                 $response->message = "Akun PD sudah tergenerate, Silahkan gunakan menu download.";
    //                 return json_encode($response);
    //             }

    //             $characters = array_merge(range('A', 'Z'), range(0, 9));
    //             $randomString = '';
    //             for ($i = 0; $i < 6; $i++) {
    //                 $randomIndex = mt_rand(0, count($characters) - 1);
    //                 $randomString .= $characters[$randomIndex];
    //             }
    //             $password = $randomString;
    //             $passwordFix = password_hash($password, PASSWORD_BCRYPT);

    //             $uuidLib = new Uuid();

    //             $dataUser = [
    //                 'id' => $uuidLib->v4(),
    //                 'username' => $oldData->nisn,
    //                 'password' => $passwordFix,
    //                 'is_active' => 1,
    //                 'level' => 5,
    //                 'created_at' => date('Y-m-d H:i:s')
    //             ];

    //             $dataUserProfile = [
    //                 'user_id' => $dataUser['id'],
    //                 'peserta_didik_id' => $oldData->peserta_didik_id,
    //                 'sekolah_id_asal' => $oldData->sekolah_id,
    //                 'wilayah' => $oldData->kode_wilayah,
    //                 'nama' => $oldData->nama,
    //                 'nama_sekolah_asal' => $oldData->nama_sekolah,
    //                 'npsn_asal' => $oldData->npsn,
    //                 'tingkat_pendidikan_asal' => $oldData->tingkat_pendidikan_id,
    //                 'acc_reg' => $password,
    //                 'created_at' => $dataUser['created_at']
    //             ];

    //             $this->_db->transBegin();
    //             try {
    //                 $this->_db->table('_users_tb')->insert($dataUser);
    //                 if ($this->_db->affectedRows() > 0) {
    //                     $this->_db->table('_users_profile_pd')->insert($dataUserProfile);
    //                     if ($this->_db->affectedRows() > 0) {
    //                         $this->_db->transCommit();

    //                         $response = new \stdClass;
    //                         $response->status = 200;
    //                         $response->message = "Data akun berhasil digenerate.";
    //                         return json_encode($response);
    //                     } else {
    //                         $this->_db->transRollback();
    //                         $response = new \stdClass;
    //                         $response->status = 400;
    //                         $response->message = "Gagal mengenerate data.";
    //                         return json_encode($response);
    //                     }
    //                 } else {
    //                     $this->_db->transRollback();
    //                     $response = new \stdClass;
    //                     $response->status = 400;
    //                     $response->message = "Gagal mengenerate data.";
    //                     return json_encode($response);
    //                 }
    //             } catch (\Throwable $th) {
    //                 $this->_db->transRollback();
    //                 $response = new \stdClass;
    //                 $response->status = 400;
    //                 $response->message = "Gagal mengenerate data.";
    //                 return json_encode($response);
    //             }
    //         }
    //     } else {
    //         exit('Maaf tidak dapat diproses');
    //     }
    // }

    // public function download()
    // {
    //     if ($this->request->isAJAX()) {

    //         $rules = [
    //             'id' => [
    //                 'rules' => 'required|trim',
    //                 'errors' => [
    //                     'required' => 'Id tidak boleh kosong. ',
    //                 ]
    //             ],
    //         ];

    //         if (!$this->validate($rules)) {
    //             $response = new \stdClass;
    //             $response->status = 400;
    //             $response->message = $this->validator->getError('id');
    //             return json_encode($response);
    //         } else {
    //             $Profilelib = new Profilelib();
    //             $user = $Profilelib->user();
    //             if ($user->status != 200) {
    //                 delete_cookie('jwt');
    //                 session()->destroy();
    //                 $response = new \stdClass;
    //                 $response->status = 401;
    //                 $response->message = "Session expired";
    //                 return json_encode($response);
    //             }

    //             $id = htmlspecialchars($this->request->getVar('id'), true);

    //             $pd = $this->_db->table('_users_profile_pd a')
    //                 ->select("c.username, b.peserta_didik_id, b.sekolah_id, b.nama, b.nisn, b.tempat_lahir, b.tanggal_lahir, b.jenis_kelamin, b.nik, a.user_id, a.nama_sekolah_asal, a.npsn_asal, a.acc_reg")
    //                 ->join('dapo_peserta b', 'a.peserta_didik_id = b.peserta_didik_id')
    //                 ->join('_users_tb c', 'a.user_id = c.id')
    //                 ->where('a.peserta_didik_id', $id)->get()->getRowObject();

    //             if (!$pd) {
    //                 $response = new \stdClass;
    //                 $response->status = 400;
    //                 $response->message = "Akun PD tidak ditemukan.";
    //                 return json_encode($response);
    //             }

    //             $html = '<table border="0">
    //                     <tr>
    //                         <td>Nama Peserta Didik</td>
    //                         <td colspan="2">: {{ nama_peserta }}</td>
    //                     </tr>
    //                     <tr>
    //                         <td>NISN</td>
    //                         <td>: {{ nisn_peserta }}</td>
    //                         <td>&nbsp;</td>
    //                     </tr>
    //                     <tr>
    //                         <td>NIK</td>
    //                         <td>: {{ nik_peserta }}</td>
    //                         <td>&nbsp;</td>
    //                     </tr>
    //                     <tr>
    //                         <td>Sekolah Asal</td>
    //                         <td colspan="2">: {{ sekolah_asal_peserta }}</td>
    //                     </tr>
    //                     <tr>
    //                         <td>NPSN Asal</td>
    //                         <td>: {{ npsn_asal_peserta }}</td>
    //                         <td>&nbsp;</td>
    //                     </tr>
    //                     <tr>
    //                         <td>Tempat Lahir</td>
    //                         <td>: {{ tempat_lahir_peserta }}</td>
    //                         <td>&nbsp;</td>
    //                     </tr>
    //                     <tr>
    //                         <td>Tanggal Lahir</td>
    //                         <td>: {{ tanggal_lahir_peserta }}</td>
    //                         <td>&nbsp;</td>
    //                     </tr>
    //                 </table>';

    //             $html1 = '<table>
    //                     <tr>
    //                         <td>Username</td>
    //                         <td>: <b>{{ username_peserta }}</b></td>
    //                         <td>&nbsp;</td>
    //                     </tr>
    //                     <tr>
    //                         <td>Password</td>
    //                         <td>: <b>{{ password_peserta }}</b></td>
    //                         <td>&nbsp;</td>
    //                     </tr>
    //                 </table>';
    //             $html2 = '<p><center>Akun peserta PPDB ini digunakan untuk pendaftaran<br />PPDB ke sekolah jenjang berikutnya melalui laman: <br /><b>https://ppdb.lampungtengahkab.go.id</b></center></p>';

    //             $html = str_replace('{{ nama_peserta }}', $pd->nama, $html);
    //             $html = str_replace('{{ nisn_peserta }}', $pd->nisn, $html);
    //             $html = str_replace('{{ nik_peserta }}', $pd->nik, $html);
    //             $html = str_replace('{{ sekolah_asal_peserta }}', $pd->nama_sekolah_asal, $html);
    //             $html = str_replace('{{ npsn_asal_peserta }}', $pd->npsn_asal, $html);
    //             $html = str_replace('{{ tempat_lahir_peserta }}', $pd->tempat_lahir, $html);
    //             $html = str_replace('{{ tanggal_lahir_peserta }}', $pd->tanggal_lahir, $html);
    //             $html1 = str_replace('{{ username_peserta }}', $pd->username, $html1);
    //             $html1 = str_replace('{{ password_peserta }}', $pd->acc_reg, $html1);

    //             $kop = '<table border="0">
    //                 <tr>
    //                     <td width="17%" rowspan="4"><img src="https://ppdb.esline.id/favicon/apple-icon-120x120.png" style="width: 70px;" alt="Logo"></td>
    //                     <td width="83%">DINAS PENDIDIKAN DAN KEBUDAYAAN</td>
    //                 </tr>
    //                 <tr>
    //                     <td width="83%">KABUPATEN LAMPUNG TENGAH</td>
    //                 </tr>
    //                 <tr>
    //                     <td width="83%">PENERIMAAN PESERTA DIDIK BARU (PPDB)</td>
    //                 </tr>
    //                 <tr>
    //                     <td width="83%">TAHUN PELAJARAN 2024/2025</td>
    //                 </tr>
    //             </table>';
    //             $pdf = new TcpdfFpdi('P', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

    //             // Load HTML content
    //             $pdf->AddPage();
    //             $pdf->SetFont('times', 'B', 12);
    //             $pdf->MultiCell(180, 10, $kop, 0, 'C', false, 1, 20, null, true, 0, true);
    //             $pdf->MultiCell(180, 10, '<hr />', 0, 'C', false, 1, 20, null, true, 0, true);
    //             // $pdf->Cell(200, 10, 'KARTU AKUN PPDB KAB. LAMPUNG TENGAH TAHUN 2024/2025', 0, 1, 'C');
    //             $pdf->Ln(10);
    //             $pdf->SetFont('times', 'N', 12);
    //             $pdf->MultiCell(180, 10, '<h4>DATA PESERTA DIDIK</h4>', 0, 'L', false, 1, 20, null, true, 0, true);
    //             $pdf->MultiCell(180, 10, $html, 0, 'L', false, 1, 20, null, true, 0, true);
    //             $pdf->Ln(10);
    //             $pdf->MultiCell(180, 10, '<h4>AKUN PESERTA PPDB</h4>', 0, 'L', false, 1, 20, null, true, 0, true);
    //             $pdf->MultiCell(180, 10, $html1, 0, 'L', false, 1, 20, null, true, 0, true);
    //             $pdf->Ln(20);
    //             $pdf->MultiCell(180, 10, $html2, 0, 'C', false, 1, 20, null, true, 0, true);
    //             $pdf->Ln(20);
    //             $pdf->MultiCell(70, 20, "PANITIA PPDB DINAS", 0, 'L', false, 1, 130, null, true, 0, true);
    //             $pdf->Ln(10);
    //             $pdf->MultiCell(70, 20, $user->data->nama, 0, 'L', false, 1, 130, null, true, 0, true);

    //             // $pdf->WriteHTML($html);

    //             // Output PDF
    //             $dir = FCPATH . "uploads/temp";
    //             $filename = 'Akun_PPDB_' . $pd->nisn . '.pdf';
    //             $fileName = $dir . '/' . $filename;
    //             $pdf->Output($fileName, 'F'); // Generate and save to temporary file

    //             sleep(2);

    //             $fileContent = file_get_contents($fileName);
    //             $base64Data = base64_encode($fileContent);
    //             unlink($fileName); // Delete the temporary file

    //             $response = new \stdClass;
    //             $response->status = 200;
    //             $response->message = "Akun Berhasil Didownload.";
    //             $response->data = $base64Data;
    //             $response->filename = $filename;
    //             return json_encode($response);
    //             // } else {
    //             //     $response = new \stdClass;
    //             //     $response->status = 400;
    //             //     $response->message = "Gagal mengenerate data.";
    //             //     return json_encode($response);
    //             // }
    //         }
    //     } else {
    //         exit('Maaf tidak dapat diproses');
    //     }
    // }

    // public function reset_password()
    // {
    //     if ($this->request->isAJAX()) {

    //         $rules = [
    //             'id' => [
    //                 'rules' => 'required|trim',
    //                 'errors' => [
    //                     'required' => 'Id tidak boleh kosong. ',
    //                 ]
    //             ],
    //             'nama' => [
    //                 'rules' => 'required|trim',
    //                 'errors' => [
    //                     'required' => 'Nama tidak boleh kosong. ',
    //                 ]
    //             ],
    //         ];

    //         if (!$this->validate($rules)) {
    //             $response = new \stdClass;
    //             $response->status = 400;
    //             $response->message = $this->validator->getError('id')
    //                 . $this->validator->getError('nama');
    //             return json_encode($response);
    //         } else {
    //             $Profilelib = new Profilelib();
    //             $user = $Profilelib->user();
    //             if ($user->status != 200) {
    //                 delete_cookie('jwt');
    //                 session()->destroy();
    //                 $response = new \stdClass;
    //                 $response->status = 401;
    //                 $response->message = "Session expired";
    //                 return json_encode($response);
    //             }

    //             $id = htmlspecialchars($this->request->getVar('id'), true);
    //             $nama = htmlspecialchars($this->request->getVar('nama'), true);

    //             $oldData = $this->_db->table('_users_profile_pd')->where('peserta_didik_id', $id)->get()->getRowObject();

    //             if (!$oldData) {
    //                 $response = new \stdClass;
    //                 $response->status = 400;
    //                 $response->message = "Data tidak ditemukan.";
    //                 return json_encode($response);
    //             }

    //             $passKartu = $oldData->acc_reg;
    //             $passwordHas = password_hash($passKartu, PASSWORD_BCRYPT);

    //             $this->_db->transBegin();
    //             try {
    //                 $this->_db->table('_users_tb')->where('id', $oldData->user_id)->update(['password' => $passwordHas]);
    //                 if ($this->_db->affectedRows() > 0) {
    //                     $this->_db->transCommit();

    //                     $response = new \stdClass;
    //                     $response->status = 200;
    //                     $response->url = base_url('portal');
    //                     $response->message = "Data $nama berhasil di reset. Password Default Sesuai Kartu Akun PD ($passKartu)";

    //                     return json_encode($response);
    //                 } else {
    //                     $this->_db->transRollback();
    //                     $response = new \stdClass;
    //                     $response->status = 400;
    //                     $response->message = "Gagal mengupdate data.";
    //                     return json_encode($response);
    //                 }
    //             } catch (\Throwable $th) {
    //                 $this->_db->transRollback();
    //                 $response = new \stdClass;
    //                 $response->status = 400;
    //                 $response->message = "Gagal mengupdate data. with error";
    //                 return json_encode($response);
    //             }
    //         }
    //     } else {
    //         exit('Maaf tidak dapat diproses');
    //     }
    // }
}
