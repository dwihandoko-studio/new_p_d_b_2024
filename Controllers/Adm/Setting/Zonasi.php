<?php

namespace App\Controllers\Adm\Setting;

use App\Controllers\BaseController;
use App\Models\Adm\Setting\ZonasiModel;
use App\Models\Adm\Setting\SekolahzonaModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Zonasi extends BaseController
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
        $datamodel = new SekolahzonaModel($request);

        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            if ((int)$list->jumlah_zona == (int)$list->jumlah_zona_verified) {
                if ((int)$list->jumlah_zona > 0) {
                    $action = '<a class="btn btn-primary" href="./detaillist?id=' . $list->sekolah_id . '&n=' . $list->nama . '"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                                ';
                } else {
                    $action = '<a class="btn btn-warning" href="./detaillist?id=' . $list->sekolah_id . '&n=' . $list->nama . '"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                                    ';
                }
            } else {
                $action = '<a class="btn btn-warning" href="./detaillist?id=' . $list->sekolah_id . '&n=' . $list->nama . '"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                                    ';
            }

            $row[] = $action;
            $row[] = $list->nama;
            $row[] = $list->npsn;
            $row[] = $list->bentuk_pendidikan;
            $row[] = $list->kecamatan;
            $row[] = $list->jumlah_zona;

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
        $datamodel = new ZonasiModel($request);


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
                                <!-- <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->sekolah_id . '\',\'' . $list->kelurahan . '\',\'' . $list->nama_kelurahan . '\');"><i class="fas fa-edit font-size-16 align-middle"></i> &nbsp;Detail</a> -->
                                <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->sekolah_id . '\',\'' . $list->kelurahan . '\',\'' . $list->nama_kelurahan . '\');"><i class="fas fa-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
                            </div>
                        </div>';
            } else {
                $action = '<div class="btn-group">
                                <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                                <div class="dropdown-menu" style="">
                                    <!-- <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->sekolah_id . '\',\'' . $list->kelurahan . '\',\'' . $list->nama_kelurahan . '\');"><i class="fas fa-edit font-size-16 align-middle"></i> &nbsp;Detail</a> -->
                                    <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->sekolah_id . '\',\'' . $list->kelurahan . '\',\'' . $list->nama_kelurahan . '\');"><i class="fas fa-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
                                </div>
                            </div>';
            }

            $row[] = $action;
            $row[] = $list->nama_provinsi;
            $row[] = $list->nama_kabupaten;
            $row[] = $list->nama_kecamatan;
            $row[] = $list->nama_kelurahan;
            $row[] = getDusunList($list->kelurahan, $list->sekolah_id);
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
        return redirect()->to(base_url('adm/setting/zonasi/data'));
    }

    public function data()
    {
        $data['title'] = 'ZONASI WILAYAH';
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

        return view('adm/setting/zonasi/sekolah', $data);
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
        $data['title'] = "DATA ZONASI WILAYAH SEKOLAH $name";

        $data['user'] = $user->data;
        $data['id'] = $id;
        $data['sekolah'] = $name;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        // $data['kecamatans'] = $this->_db->table('ref_kecamatan')->orderBy('nama_kecamatan', 'ASC')->get()->getResult();

        return view('adm/setting/zonasi/index', $data);
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
                'kel' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kelurahan tidak boleh kosong. ',
                    ]
                ],
                'nam_kel' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nama Kelurahan tidak boleh kosong. ',
                    ]
                ],
                'nama' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nama tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('id')
                    . $this->validator->getError('kel')
                    . $this->validator->getError('nam_kel')
                    . $this->validator->getError('nama');
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
                $kel = htmlspecialchars($this->request->getVar('kel'), true);
                $nam_kel = htmlspecialchars($this->request->getVar('nam_kel'), true);
                $nama = htmlspecialchars($this->request->getVar('nama'), true);

                $oldData = $this->_db->table('_setting_zonasi_tb a')
                    ->select("a.*, b.nama as nama_provinsi, c.nama as nama_kabupaten, d.nama as nama_kecamatan, e.nama as nama_kelurahan, f.nama as nama_dusun")
                    ->join('ref_provinsi b', 'b.id = a.provinsi')
                    ->join('ref_kabupaten c', 'c.id = a.kabupaten')
                    ->join('ref_kecamatan d', 'd.id = a.kecamatan')
                    ->join('ref_kelurahan e', 'e.id = a.kelurahan')
                    ->join('ref_dusun f', 'f.id = a.dusun')
                    ->where(['a.sekolah_id' => $id, 'a.kelurahan' => $kel])->get()->getResult();
                if (count($oldData) > 0) {

                    $x['data'] = $oldData;
                    $x['nama_kelurahan'] = $nam_kel;
                    $x['id_kel'] = $kel;
                    $x['sek_id'] = $id;
                    $x['sekolah'] = $nama;

                    $response = new \stdClass;
                    $response->status = 200;
                    $response->title = "DETAIL ZONASI SEKOLAH $nama";
                    $response->message = "Permintaan diizinkan";
                    $response->data = view('adm/setting/zonasi/detail', $x);
                    return json_encode($response);
                }
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data zonasi tidak ditemukan.";
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
                $response->data = view('adm/setting/kuota/edit', $x);
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
                'name' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nama tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('id')
                    . $this->validator->getError('name');
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

                $x['id'] = htmlspecialchars($this->request->getVar('id'), true);
                $x['nama'] = htmlspecialchars($this->request->getVar('name'), true);

                $x['provinsis'] = $this->_db->table('ref_provinsi')->whereNotIn('id', ['350000', '000000'])->orderBy('nama', 'asc')->get()->getResult();

                $x['dusuns'] = $this->_db->table('ref_dusun')->orderBy('urut', 'asc')->get()->getResult();

                $response = new \stdClass;
                $response->status = 200;
                $response->title = "TAMBAH WILAYAH ZONASI SEKOLAH";
                $response->message = "Permintaan diizinkan";
                $response->data = view('adm/setting/zonasi/add', $x);
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function verify()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Id tidak boleh kosong. ',
                    ]
                ],
                'name' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nama tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('id')
                    . $this->validator->getError('name');
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
                $nama = htmlspecialchars($this->request->getVar('name'), true);

                $oldData = $this->_db->table('_setting_zonasi_tb')->where(['sekolah_id' => $id, 'is_locked' => 0])->countAllResults();

                if (!($oldData > 0)) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data zonasi sudah terverifikasi";
                    return json_encode($response);
                }

                $this->_db->transBegin();
                try {
                    $this->_db->table('_setting_zonasi_tb')->where(['sekolah_id' => $id, 'is_locked' => 0])->update(['is_locked' => 1]);
                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->transCommit();

                        $response = new \stdClass;
                        $response->status = 200;
                        $response->url = base_url('portal');
                        $response->message = "Data berhasil diverifikasi.";
                        return json_encode($response);
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal memverifikasi data.";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal memverifikasi data. with e";
                    return json_encode($response);
                }
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
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'id tidak boleh kosong. ',
                    ]
                ],
                'prov' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Provinsi tidak boleh kosong. ',
                    ]
                ],
                'kab' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kabupaten tidak boleh kosong. ',
                    ]
                ],
                'kec' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kecamatan tidak boleh kosong. ',
                    ]
                ],
                'kel' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kelurahan tidak boleh kosong. ',
                    ]
                ],
                'dusun' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Dusun tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('id')
                    . $this->validator->getError('prov')
                    . $this->validator->getError('kab')
                    . $this->validator->getError('kec')
                    . $this->validator->getError('kel')
                    . $this->validator->getError('dusun');
                return json_encode($response);
            } else {

                $id = htmlspecialchars($this->request->getVar('id'), true);
                $prov = htmlspecialchars($this->request->getVar('prov'), true);
                $kab = htmlspecialchars($this->request->getVar('kab'), true);
                $kec = htmlspecialchars($this->request->getVar('kec'), true);
                $kel = htmlspecialchars($this->request->getVar('kel'), true);
                $dusunx = htmlspecialchars($this->request->getVar('dusun'), true);

                $dusuns = explode(",", $dusunx);

                $getSekolah = $this->_db->table('dapo_sekolah')->select("nama, bentuk_pendidikan_id, npsn")->where('sekolah_id', $id)->get()->getRowObject();

                if (!$getSekolah) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Sekolah tidak ditemukan.";
                    return json_encode($response);
                }

                $this->_db->transBegin();
                try {

                    foreach ($dusuns as $key => $dusun) {

                        $cekData = $this->_db->table('_setting_zonasi_tb')->select("id,sekolah_id")->where(['sekolah_id' => $id, 'provinsi' => $prov, 'kabupaten' => $kab, 'kecamatan' => $kec, 'kelurahan' => $kel, 'dusun' => $dusun])->get()->getRowObject();
                        // $cekData = $this->_db->table('_setting_zonasi_tb')->where(['sekolah_id' => $sekolah, 'provinsi' => $prov, 'kabupaten' => $kab, 'kecamatan' => $kec, 'kelurahan' => $kel])->get()->getRowObject();

                        if ($cekData) {
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "Zonasi untuk sekolah ini dengan wilayah yang di pilih sudah di set, silahkan menggunakan menu edit untuk merubah data.";
                            return json_encode($response);
                        }

                        $uuidLib = new Uuid();
                        $uuid = $uuidLib->v4();

                        $data = [
                            'id' => $uuid,
                            'sekolah_id' => $id,
                            'bentuk_pendidikan_id' => $getSekolah->bentuk_pendidikan_id,
                            'npsn' => $getSekolah->npsn,
                            'provinsi' => $prov,
                            'kabupaten' => $kab,
                            'kecamatan' => $kec,
                            'kelurahan' => $kel,
                            'dusun' => $dusun,
                            'is_locked' => 1,
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        // try {
                        $this->_db->table('_setting_zonasi_tb')->insert($data);
                        if ($this->_db->affectedRows() > 0) {
                            continue;
                        } else {
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "Gagal menyimpan zonasi.";
                            return json_encode($response);
                        }
                    }
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menyimpan zonasi. with e.";
                    return json_encode($response);
                }

                $this->_db->transCommit();

                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data berhasil disimpan.";
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Id tidak boleh kosong. ',
                    ]
                ],
                'kel' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kelurahan tidak boleh kosong. ',
                    ]
                ],
                'nam_kel' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nama Kelurahan tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('id')
                    . $this->validator->getError('kel')
                    . $this->validator->getError('nam_kel');
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
                $kel = htmlspecialchars($this->request->getVar('kel'), true);
                $nam_kel = htmlspecialchars($this->request->getVar('nam_kel'), true);

                $oldData = $this->_db->table('_setting_zonasi_tb')->where(['sekolah_id' => $id, 'kelurahan' => $kel])->countAllResults();

                if (!($oldData > 0)) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data tidak ditemukan.";
                    return json_encode($response);
                }

                $this->_db->transBegin();
                try {
                    $this->_db->table('_setting_zonasi_tb')->where(['sekolah_id' => $id, 'kelurahan' => $kel])->delete();
                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->transCommit();

                        $response = new \stdClass;
                        $response->status = 200;
                        $response->url = base_url('portal');
                        $response->message = "Data berhasil dihapus.";
                        return json_encode($response);
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal menghapus data.";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menghapus data. with e";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function refkab()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'id tidak boleh kosong. ',
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
                    return redirect()->to(base_url('auth'));
                }

                $id = htmlspecialchars($this->request->getVar('id'), true);

                $current = $this->_db->table('ref_kabupaten')
                    ->where("id_provinsi = '$id'")->get()->getResult();

                if (count($current) > 0) {
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Permintaan diizinkan";
                    $response->data = $current;
                    return json_encode($response);
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data tidak ditemukan";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function refkec()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'id tidak boleh kosong. ',
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
                    return redirect()->to(base_url('auth'));
                }

                $id = htmlspecialchars($this->request->getVar('id'), true);

                $current = $this->_db->table('ref_kecamatan')
                    ->where("id_kabupaten = '$id'")->get()->getResult();

                if (count($current) > 0) {
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Permintaan diizinkan";
                    $response->data = $current;
                    return json_encode($response);
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data tidak ditemukan";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function refkel()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'id tidak boleh kosong. ',
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
                    return redirect()->to(base_url('auth'));
                }

                $id = htmlspecialchars($this->request->getVar('id'), true);

                $current = $this->_db->table('ref_kelurahan')
                    ->where("id_kecamatan = '$id'")->get()->getResult();

                if (count($current) > 0) {
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Permintaan diizinkan";
                    $response->data = $current;
                    return json_encode($response);
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data tidak ditemukan";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
