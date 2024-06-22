<?php

namespace App\Controllers\Su\Setting;

use App\Controllers\BaseController;
use App\Models\Su\Setting\KuotaModel;
use Config\Services;
// use App\Models\Su\Setting\SekolahpdModel;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Kuota extends BaseController
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
        $datamodel = new KuotaModel($request);


        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            if ((int)$list->is_locked == 1) {
                $action = '<div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                <div class="dropdown-menu" style="">
                    <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->sekolah_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama)) . '\');"><i class="fas fa-eye font-size-16 align-middle"></i> &nbsp;Detail</a>
                    <a class="dropdown-item" href="javascript:actionEdit(\'' . $list->sekolah_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="fas fa-edit font-size-16 align-middle"></i> &nbsp;Edit</a>
                    <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->sekolah_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="fas fa-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
                    <div class="dropdown-divider"></div>
                </div>
            </div>';
            } else {
                $action = '<div class="btn-group">
                <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                <div class="dropdown-menu" style="">
                    <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->sekolah_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama)) . '\');"><i class="fas fa-eye font-size-16 align-middle"></i> &nbsp;Detail</a>
                    <a class="dropdown-item" href="javascript:actionEdit(\'' . $list->sekolah_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="fas fa-edit font-size-16 align-middle"></i> &nbsp;Edit</a>
                    <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->sekolah_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="fas fa-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
                    <div class="dropdown-divider"></div>
                </div>
            </div>';
            }

            $row[] = $action;
            $row[] = $list->nama;
            $row[] = $list->npsn;
            $row[] = $list->bentuk_pendidikan;
            $row[] = $list->kecamatan;
            $row[] = $list->jumlah_rombel_kebutuhan;

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

    // public function getAllDetail()
    // {
    //     $request = Services::request();
    //     $datamodel = new PdModel($request);


    //     $lists = $datamodel->get_datatables();
    //     $data = [];
    //     $no = $request->getPost("start");
    //     foreach ($lists as $list) {
    //         $no++;
    //         $row = [];

    //         $row[] = $no;
    //         $action = '<div class="btn-group">
    //                         <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
    //                         <div class="dropdown-menu" style="">
    //                             <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->peserta_didik_id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
    //                             <a class="dropdown-item" href="javascript:actionResetPassword(\'' . $list->peserta_didik_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="bx bx-key font-size-16 align-middle"></i> &nbsp;Reset Password</a>
    //                             <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->peserta_didik_id . '\', \'' . str_replace("'", "", $list->nama)  . '\');"><i class="bx bx-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
    //                             <div class="dropdown-divider"></div>
    //                         </div>
    //                     </div>';

    //         $row[] = $action;
    //         $row[] = $list->nama;
    //         $row[] = $list->nisn;
    //         $row[] = $list->nik;
    //         $row[] = $list->no_kk;
    //         $row[] = $list->tanggal_lahir;
    //         $row[] = $list->tingkat_pendidikan_id;
    //         $row[] = $list->nama_ibu_kandung;
    //         $row[] = $list->latlong;
    //         // switch ($list->is_active) {
    //         //     case 1:
    //         //         $row[] = '<div class="text-center">
    //         //                 <span class="badge rounded-pill badge-soft-success font-size-11">Aktif</span>
    //         //             </div>';
    //         //         break;
    //         //     default:
    //         //         $row[] = '<div class="text-center">
    //         //             <span class="badge rounded-pill badge-soft-danger font-size-11">Non Aktif</span>
    //         //         </div>';
    //         //         break;
    //         // }
    //         // switch ($list->email_verified) {
    //         //     case 1:
    //         //         $row[] = '<div class="text-center">
    //         //                 <span class="badge rounded-pill badge-soft-success font-size-11">Ya</span>
    //         //             </div>';
    //         //         break;
    //         //     default:
    //         //         $row[] = '<div class="text-center">
    //         //             <span class="badge rounded-pill badge-soft-danger font-size-11">Tidak</span>
    //         //         </div>';
    //         //         break;
    //         // }
    //         // switch ($list->wa_verified) {
    //         //     case 1:
    //         //         $row[] = '<div class="text-center">
    //         //                 <span class="badge rounded-pill badge-soft-success font-size-11">Ya</span>
    //         //             </div>';
    //         //         break;
    //         //     default:
    //         //         $row[] = '<div class="text-center">
    //         //             <span class="badge rounded-pill badge-soft-danger font-size-11">Tidak</span>
    //         //         </div>';
    //         //         break;
    //         // }

    //         $data[] = $row;
    //     }
    //     $output = [
    //         "draw" => $request->getPost('draw'),
    //         "recordsTotal" => $datamodel->count_all(),
    //         "recordsFiltered" => $datamodel->count_filtered(),
    //         "data" => $data
    //     ];
    //     echo json_encode($output);
    // }

    public function index()
    {
        return redirect()->to(base_url('su/setting/kuota/data'));
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
        // $data['jenjangs'] = $this->_db->table('dapo_sekolah')->select("bentuk_pendidikan_id, bentuk_pendidikan, count(bentuk_pendidikan_id) as jumlah")->groupBy('bentuk_pendidikan_id')->orderBy('bentuk_pendidikan', 'ASC')->get()->getResult();

        return view('su/setting/kuota/sekolah', $data);
    }

    public function detail()
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
                $user = $Profilelib->user();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session expired";
                    return json_encode($response);
                }

                $id = htmlspecialchars($this->request->getVar('id'), true);

                $oldData = $this->_db->table('_setting_kuota_tb a')
                    ->select("a.*, b.nama, b.kecamatan, b.bentuk_pendidikan")
                    ->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id')
                    ->where('a.sekolah_id', $id)->get()->getRowObject();
                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data kuota tidak ditemukan.";
                    return json_encode($response);
                }

                $x['data'] = $oldData;

                $response = new \stdClass;
                $response->status = 200;
                $response->title = "DETAIL KUOTA SEKOLAH";
                $response->message = "Permintaan diizinkan";
                $response->data = view('su/setting/kuota/detail', $x);
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function edit()
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
                $user = $Profilelib->user();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session expired";
                    return json_encode($response);
                }

                $id = htmlspecialchars($this->request->getVar('id'), true);

                $oldData = $this->_db->table('_setting_kuota_tb a')
                    ->select("a.*, b.nama, b.kecamatan, b.bentuk_pendidikan")
                    ->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id')
                    ->where('a.sekolah_id', $id)->get()->getRowObject();
                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data kuota tidak ditemukan.";
                    return json_encode($response);
                }

                $x['data'] = $oldData;

                $response = new \stdClass;
                $response->status = 200;
                $response->title = "EDIT KUOTA SEKOLAH";
                $response->message = "Permintaan diizinkan";
                $response->data = view('su/setting/kuota/edit', $x);
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function add()
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
                $user = $Profilelib->user();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session expired";
                    return json_encode($response);
                }

                $x['kecamatans'] = $this->_db->table('ref_kecamatan')->where('id_kabupaten', '120200')->orderBy('nama', 'ASC')->get()->getResult();

                $response = new \stdClass;
                $response->status = 200;
                $response->title = "TAMBAH KUOTA SEKOLAH";
                $response->message = "Permintaan diizinkan";
                $response->data = view('su/setting/kuota/add', $x);
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function refSekolah()
    {
        if ($this->request->isAJAX()) {

            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                return redirect()->to(base_url('auth'));
            }

            $kec = htmlspecialchars($this->request->getVar('kec'), true);
            $jenjang = htmlspecialchars($this->request->getVar('jenjang'), true);

            $where = "";

            if ($kec === "" && $jenjang === "") {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Pilih kecamatan / jenjang dulu.";
                return json_encode($response);
            }

            if ($kec !== "") {
                if ($jenjang !== "") {
                    $sekolahs = $this->_db->table('dapo_sekolah')
                        ->where("kode_kecamatan = '$kec' AND bentuk_pendidikan_id = $jenjang")->orderBy('nama', 'ASC')->get()->getResult();
                } else {
                    $sekolahs = $this->_db->table('dapo_sekolah')
                        ->where("kode_kecamatan = '$kec' AND bentuk_pendidikan_id = $jenjang")->orderBy('nama', 'ASC')->get()->getResult();
                }
            } else {
                if ($jenjang !== "") {
                    $sekolahs = $this->_db->table('dapo_sekolah')
                        ->where("bentuk_pendidikan_id = $jenjang AND kode_kabupaten = '120200'")->orderBy('nama', 'ASC')->get()->getResult();
                } else {
                    $sekolahs = $this->_db->table('dapo_sekolah')
                        ->where("kode_kabupaten = '120200'")->orderBy('nama', 'ASC')->get()->getResult();
                }
            }


            if (count($sekolahs) > 0) {
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = $sekolahs;
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function addSave()
    {
        if ($this->request->isAJAX()) {
            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session telah habis";
                return json_encode($response);
            }

            $rules = [
                '_jenjang' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'jenjang tidak boleh kosong. ',
                    ]
                ],
                '_kec' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'kecamatan tidak boleh kosong. ',
                    ]
                ],
                '_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'sekolah tidak boleh kosong. ',
                    ]
                ],
                '_kebutuhan' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Jumlah kebutuhan rombel tidak boleh kosong. ',
                    ]
                ],
                '_radius' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Jangkauan Radius Zonasi tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_jenjang')
                    . $this->validator->getError('_kec')
                    . $this->validator->getError('_sekolah')
                    . $this->validator->getError('_kebutuhan')
                    . $this->validator->getError('_radius');
                return json_encode($response);
            } else {

                $jenjang = htmlspecialchars($this->request->getVar('_jenjang'), true);
                $kec = htmlspecialchars($this->request->getVar('_kec'), true);
                $sekolah = htmlspecialchars($this->request->getVar('_sekolah'), true);
                $kebutuhan = htmlspecialchars($this->request->getVar('_kebutuhan'), true);
                $radius = htmlspecialchars($this->request->getVar('_radius'), true);

                $oldData = $this->_db->table('_setting_kuota_tb a')
                    ->select("a.*, b.nama, b.kecamatan, b.bentuk_pendidikan")
                    ->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id')
                    ->where('a.sekolah_id', $sekolah)->get()->getRowObject();
                if ($oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data kuota sudah ada, gunakan menu edit.";
                    return json_encode($response);
                }

                $refSekolah = $this->_db->table('dapo_sekolah')->select("sekolah_id, npsn, nama, bentuk_pendidikan_id")->where('sekolah_id', $sekolah)->get()->getRowObject();

                if (!$refSekolah) {
                    $response = new \stdClass;
                    $response->code = 400;
                    $response->message = "Referensi sekolah tidak ditemukan.";
                    return json_encode($response);
                }

                $prosentaseJalur = getProsentaseJalur($jenjang);

                if (!$prosentaseJalur) {
                    $response = new \stdClass;
                    $response->code = 400;
                    $response->message = "Referensi prosentase tidak ditemukan.";
                    return json_encode($response);
                }

                if ($jenjang == "6" || $jenjang == "10" || $jenjang == "31" || $jenjang == "32" || $jenjang == "33" || $jenjang == "35" || $jenjang == "36") {
                    $jumlahSiswa = 32 * (int)$kebutuhan;
                    $kZonasi = ceil(($prosentaseJalur->zonasi / 100) * $jumlahSiswa);
                    $kAfirmasi = ceil(($prosentaseJalur->afirmasi / 100) * $jumlahSiswa);
                    $kMutasi = ceil(($prosentaseJalur->mutasi / 100) * $jumlahSiswa);
                    $kPrestasi = $jumlahSiswa - ($kZonasi + $kAfirmasi + $kMutasi);
                } else {
                    $jumlahSiswa = 28 * (int)$kebutuhan;
                    $kZonasi = ceil(($prosentaseJalur->zonasi / 100) * $jumlahSiswa);
                    $kAfirmasi = ceil(($prosentaseJalur->afirmasi / 100) * $jumlahSiswa);
                    $kMutasi = ceil(($prosentaseJalur->mutasi / 100) * $jumlahSiswa);
                    $kPrestasi = $jumlahSiswa - ($kZonasi + $kAfirmasi + $kMutasi);
                }

                $this->_db->transBegin();
                try {
                    $this->_db->table('_setting_kuota_tb')->insert([
                        'sekolah_id' => $sekolah,
                        'bentuk_pendidikan_id' => $jenjang,
                        'npsn' => $refSekolah->npsn,
                        'jumlah_kelas' => $kebutuhan,
                        'jumlah_rombel_current' => $kebutuhan,
                        'jumlah_rombel_kebutuhan' => $kebutuhan,
                        'zonasi' => $kZonasi,
                        'afirmasi' => $kAfirmasi,
                        'mutasi' => $kMutasi,
                        'prestasi' => $kPrestasi,
                        'radius_zonasi' => $radius,
                        'is_locked' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->transCommit();

                        $response = new \stdClass;
                        $response->status = 200;
                        $response->message = "Data berhasil dimpan.";
                        return json_encode($response);
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal menyimpan data.";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menyimpan data. with e";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function editSave()
    {
        if ($this->request->isAJAX()) {
            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session telah habis";
                return json_encode($response);
            }

            $rules = [
                '_id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'id tidak boleh kosong. ',
                    ]
                ],
                '_kebutuhan' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Jumlah kebutuhan rombel tidak boleh kosong. ',
                    ]
                ],
                '_radius' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Jangkauan Radius Zonasi tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_id')
                    . $this->validator->getError('_kebutuhan')
                    . $this->validator->getError('_radius');
                return json_encode($response);
            } else {

                $id = htmlspecialchars($this->request->getVar('_id'), true);
                $kebutuhan = htmlspecialchars($this->request->getVar('_kebutuhan'), true);
                $radius = htmlspecialchars($this->request->getVar('_radius'), true);

                $oldData = $this->_db->table('_setting_kuota_tb a')
                    ->select("a.*, b.nama, b.kecamatan, b.bentuk_pendidikan")
                    ->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id')
                    ->where('a.sekolah_id', $id)->get()->getRowObject();
                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data kuota tidak ditemukan.";
                    return json_encode($response);
                }

                // if (
                //     (int)$oldData->jumlah_rombel_kebutuhan === (int)$kebutuhan && (int)$oldData->radius_zonasi === (int)$radius
                // ) {
                //     $response = new \stdClass;
                //     $response->status = 201;
                //     $response->message = "Tidak ada perubahan data yang perlu disimpan";
                //     return json_encode($response);
                // }

                $prosentaseJalur = getProsentaseJalur($oldData->bentuk_pendidikan_id);

                if (!$prosentaseJalur) {
                    $response = new \stdClass;
                    $response->code = 400;
                    $response->message = "Referensi prosentase tidak ditemukan.";
                    return json_encode($response);
                }

                if ($oldData->bentuk_pendidikan_id == "6" || $oldData->bentuk_pendidikan_id == "10" || $oldData->bentuk_pendidikan_id == "31" || $oldData->bentuk_pendidikan_id == "32" || $oldData->bentuk_pendidikan_id == "33" || $oldData->bentuk_pendidikan_id == "35" || $oldData->bentuk_pendidikan_id == "36") {
                    $jumlahSiswa = 32 * (int)$kebutuhan;
                    $kZonasi = ceil(($prosentaseJalur->zonasi / 100) * $jumlahSiswa);
                    $kAfirmasi = ceil(($prosentaseJalur->afirmasi / 100) * $jumlahSiswa);
                    $kMutasi = ceil(($prosentaseJalur->mutasi / 100) * $jumlahSiswa);
                    $kPrestasi = $jumlahSiswa - ($kZonasi + $kAfirmasi + $kMutasi);
                } else {
                    $jumlahSiswa = 28 * (int)$kebutuhan;
                    $kZonasi = ceil(($prosentaseJalur->zonasi / 100) * $jumlahSiswa);
                    $kAfirmasi = ceil(($prosentaseJalur->afirmasi / 100) * $jumlahSiswa);
                    $kMutasi = ceil(($prosentaseJalur->mutasi / 100) * $jumlahSiswa);
                    $kPrestasi = $jumlahSiswa - ($kZonasi + $kAfirmasi + $kMutasi);
                }

                $this->_db->transBegin();
                try {
                    $this->_db->table('_setting_kuota_tb')->where('sekolah_id', $oldData->sekolah_id)->update([
                        'jumlah_rombel_kebutuhan' => $kebutuhan,
                        'zonasi' => $kZonasi,
                        'afirmasi' => $kAfirmasi,
                        'mutasi' => $kMutasi,
                        'prestasi' => $kPrestasi,
                        'radius_zonasi' => $radius,
                        'is_locked' => 1,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->transCommit();

                        $response = new \stdClass;
                        $response->status = 200;
                        $response->message = "Data berhasil diupdate.";
                        return json_encode($response);
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal mengupdate data.";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupdate data.";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
