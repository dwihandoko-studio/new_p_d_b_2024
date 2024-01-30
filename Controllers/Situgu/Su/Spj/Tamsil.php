<?php

namespace App\Controllers\Situgu\Su\Spj;

use App\Controllers\BaseController;
use App\Models\Situgu\Su\Spj\SpjtamsildetailModel;
use App\Models\Situgu\Su\Spj\SpjtamsilsekolahModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;
use App\Libraries\Situgu\Verifikasiadminlib;
use App\Libraries\Uuid;

class Tamsil extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;
    private $model;
    private $_helpLib;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
        $this->_helpLib = new Helplib();
    }

    public function getAll()
    {
        $request = Services::request();
        $datamodel = new SpjtamsilsekolahModel($request);

        $jwt = get_cookie('jwt');
        $token_jwt = getenv('token_jwt.default.key');
        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
                if ($decoded) {
                    $userId = $decoded->id;
                    $level = $decoded->level;
                } else {
                    $output = [
                        "draw" => $request->getPost('draw'),
                        "recordsTotal" => 0,
                        "recordsFiltered" => 0,
                        "data" => []
                    ];
                    echo json_encode($output);
                    return;
                }
            } catch (\Exception $e) {
                $output = [
                    "draw" => $request->getPost('draw'),
                    "recordsTotal" => 0,
                    "recordsFiltered" => 0,
                    "data" => []
                ];
                echo json_encode($output);
                return;
            }
        }

        // $kecamatan = $this->_helpLib->getKecamatan($userId);
        // $npsns = $this->_helpLib->getSekolahKecamatanArray($kecamatan, [5]);
        // var_dump($npsns);
        // die;

        $lists = $datamodel->get_datatables('tpg');
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            // $action = '<div class="btn-group">
            //             <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
            //             <div class="dropdown-menu" style="">
            //                 <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
            //                 <a class="dropdown-item" href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><i class="bx bx-transfer-alt font-size-16 align-middle"></i> &nbsp;Sync Dapodik</a>
            //             </div>
            //         </div>';
            // $action = '<a href="./datalist?n=' . $list->kode_usulan . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bxs-show font-size-16 align-middle"></i> DETAIL</button>
            //     </a>';
            $action = '<a href="javascript:actionDetail(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . $list->id_tahun_tw . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama)) . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                <i class="bx bxs-show font-size-16 align-middle"></i> DETAIL</button>
                </a>';
            //     <a href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-transfer-alt font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-trash font-size-16 align-middle"></i></button>
            //     </a>';
            $row[] = $action;

            $row[] = str_replace('&#039;', "`", str_replace("'", "`", $list->nama));
            $row[] = $list->nuptk;
            $row[] = $list->status_kepegawaian;
            $row[] = $list->npsn;
            $row[] = $list->us_pang_golongan;
            $row[] = $list->us_pang_tmt;
            $row[] = $list->us_pang_mk_tahun;
            $row[] = $list->jumlah_bulan;
            $row[] = $list->tf_jumlah_uang;
            $row[] = $list->tf_jumlah_diterima;
            $row[] = $list->tf_no_rekening;
            //
            // $row[] = str_replace('&#039;', "`", str_replace("'", "`", $list->nama));
            // $row[] = $list->npsn;
            // $row[] = $list->bentuk_pendidikan;
            // $row[] = $list->status_sekolah;
            // $row[] = $list->kecamatan;
            // $row[] = $list->jumlah_ptk;
            //

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all('tamsil'),
            "recordsFiltered" => $datamodel->count_filtered('tamsil'),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function getAllDetail()
    {
        $request = Services::request();
        $datamodel = new SpjtamsildetailModel($request);

        $jwt = get_cookie('jwt');
        $token_jwt = getenv('token_jwt.default.key');
        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
                if ($decoded) {
                    $userId = $decoded->id;
                    $level = $decoded->level;
                } else {
                    $output = [
                        "draw" => $request->getPost('draw'),
                        "recordsTotal" => 0,
                        "recordsFiltered" => 0,
                        "data" => []
                    ];
                    echo json_encode($output);
                    return;
                }
            } catch (\Exception $e) {
                $output = [
                    "draw" => $request->getPost('draw'),
                    "recordsTotal" => 0,
                    "recordsFiltered" => 0,
                    "data" => []
                ];
                echo json_encode($output);
                return;
            }
        }

        // $npsns = $this->_helpLib->getSekolahNaungan($userId);

        $lists = $datamodel->get_datatables($request->getPost('id'));
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            // $action = '<div class="btn-group">
            //             <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
            //             <div class="dropdown-menu" style="">
            //                 <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
            //                 <a class="dropdown-item" href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><i class="bx bx-transfer-alt font-size-16 align-middle"></i> &nbsp;Sync Dapodik</a>
            //             </div>
            //         </div>';
            $action = '<a href="javascript:actionDetail(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . $list->id_tahun_tw . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama)) . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                <i class="bx bxs-show font-size-16 align-middle"></i> DETAIL</button>
                </a>';
            //     <a href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-transfer-alt font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-trash font-size-16 align-middle"></i></button>
            //     </a>';
            $row[] = $action;
            $row[] = $list->kode_usulan;
            $row[] = str_replace('&#039;', "`", str_replace("'", "`", $list->nama));
            $row[] = $list->nik;
            $row[] = $list->nuptk;
            $row[] = $list->jenis_ptk;

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all($request->getPost('id')),
            "recordsFiltered" => $datamodel->count_filtered($request->getPost('id')),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        return redirect()->to(base_url('situgu/su/spj/tamsil/data'));
    }

    public function data()
    {
        $data['title'] = 'SPJ TAMSIL';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }
        $id = $this->_helpLib->getPtkId($user->data->id);
        $data['user'] = $user->data;
        $data['tw'] = $this->_db->table('_ref_tahun_tw')->where('is_current', 1)->orderBy('tahun', 'desc')->orderBy('tw', 'desc')->get()->getRowObject();
        $data['tws'] = $this->_db->table('_ref_tahun_tw')->orderBy('tahun', 'desc')->orderBy('tw', 'desc')->get()->getResult();
        return view('situgu/su/spj/tamsil/index', $data);
    }

    public function datalist()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $id = htmlspecialchars($this->request->getGet('n'), true);

        $data['title'] = 'SPJ TAMSIL';
        $data['user'] = $user->data;
        $data['kode_usulan'] = $id;
        $data['tw'] = $this->_db->table('_ref_tahun_tw')->where('is_current', 1)->orderBy('tahun', 'desc')->orderBy('tw', 'desc')->get()->getRowObject();
        // $data['tws'] = $this->_db->table('_ref_tahun_tw')->orderBy('tahun', 'desc')->orderBy('tw', 'desc')->get()->getResult();
        return view('situgu/su/spj/tamsil/detail_index', $data);
    }

    public function detail()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'id' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id tidak boleh kosong. ',
                ]
            ],
            'id_ptk' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id PTK tidak boleh kosong. ',
                ]
            ],
            'tw' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'TW tidak boleh kosong. ',
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
                . $this->validator->getError('id_ptk')
                . $this->validator->getError('tw')
                . $this->validator->getError('nama');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $id_ptk = htmlspecialchars($this->request->getVar('id_ptk'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);

            // $current = $this->_db->table('_tb_usulan_detail_tpg a')
            //     ->select("a.id as id_usulan, a.us_pang_golongan, a.us_pang_tmt, a.us_pang_tgl, a.us_pang_jenis, a.us_pang_mk_tahun, a.us_pang_mk_bulan, a.us_gaji_pokok, a.date_approve, a.kode_usulan, a.id_ptk, a.id_tahun_tw, a.status_usulan, a.date_approve_sptjm, b.nama, b.nik, b.nuptk, b.jenis_ptk, b.kecamatan, e.cuti as lampiran_cuti, e.pensiun as lampiran_pensiun, e.kematian as lampiran_kematian, e.pang_golongan as attr_pang_golongan, e.pang_jenis as attr_pang_jenis, e.pang_no as attr_pang_no, e.pang_tmt as attr_pang_tmt, e.pang_tgl as attr_pang_tgl, e.pang_tahun as attr_pang_mk_tahun, e.pang_bulan as attr_pang_mk_bulan")
            //     ->join('_ptk_tb b', 'a.id_ptk = b.id')
            //     ->join('_upload_data_attribut e', 'a.id_ptk = e.id_ptk AND (a.id_tahun_tw = e.id_tahun_tw)')
            //     ->where('a.status_usulan', 2)
            //     ->where(['a.id' => $id, 'a.id_tahun_tw' => $tw])
            //     ->get()->getRowObject();

            $current = $this->_db->table('_tb_spj_tamsil a')
                ->select("a.*, b.nama, b.nik, b.nuptk, b.nip, b.jenis_ptk, SUBSTRING_INDEX(SUBSTRING_INDEX(kode_usulan, '-', -2), '-', 1) AS npsn")
                ->join('_ptk_tb b', 'b.id = a.id_ptk')
                // ->join('_tb_sptjm c', 'a.kode_usulan = c.kode_usulan')
                // ->join('ref_gaji d', 'a.us_pang_golongan = d.pangkat AND (d.masa_kerja = (IF(a.us_pang_mk_tahun > 32, 32, a.us_pang_mk_tahun)))', 'LEFT')
                ->where(['a.id' => $id, 'a.id_tahun_tw' => $tw])->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $data['tw'] = $this->_db->table('_ref_tahun_tw')->where('id', $tw)->get()->getRowObject();
                if ($current->lanjutkan_tw == 0) {
                    $data['doc_attribut'] = $this->_db->table('_upload_data_attribut')->where(['id_ptk' => $current->id_ptk, 'id_tahun_tw' => $current->id_tahun_tw])->get()->getRowObject();
                    $data['doc_sekolah'] = $this->_db->table('_absen_kehadiran')->where(['id_ptk' => $current->id_ptk, 'id_tahun_tw' => $current->id_tahun_tw])->get()->getRowObject();
                } else {
                    $data['doc_attribut'] = $this->_db->table('_upload_data_attribut')->where(['id_ptk' => $current->id_ptk, 'id_tahun_tw' => $current->id_current_tahun_tw])->get()->getRowObject();
                    $data['doc_sekolah'] = $this->_db->table('_absen_kehadiran')->where(['id_ptk' => $current->id_ptk, 'id_tahun_tw' => $current->id_current_tahun_tw])->get()->getRowObject();
                }
                // $data['penugasans'] = $this->_db->table('_ptk_tb_dapodik a')
                //     ->select("a.*, b.npsn, b.nama as namaSekolah, b.kecamatan as kecamatan_sekolah, (SELECT SUM(jam_mengajar_per_minggu) FROM _pembelajaran_dapodik WHERE ptk_id = a.ptk_id AND sekolah_id = a.sekolah_id AND semester_id = a.semester_id) as jumlah_total_jam_mengajar_perminggu")
                //     ->join('ref_sekolah b', 'a.sekolah_id = b.id')
                //     ->where('a.ptk_id', $current->id_ptk)
                //     ->where("a.jenis_keluar IS NULL")
                //     ->orderBy('a.ptk_induk', 'DESC')->get()->getResult();
                // $data['igd'] = $this->_db->table('_info_gtk')->where('ptk_id', $current->id_ptk)->get()->getRowObject();
                // var_dump($data);
                // die;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situgu/su/spj/tamsil/detail', $data);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function formtolak()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'id' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id tidak boleh kosong. ',
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
                $response->message = "Session telah habis";
                $response->redirect = base_url('auth');
                return json_encode($response);
            }

            $canGrantedVerifikasi = canGrantedVerifikasi($user->data->id);

            if ($canGrantedVerifikasi && $canGrantedVerifikasi->code !== 200) {
                return json_encode($canGrantedVerifikasi);
            }

            $canUsulTamsil = canVerifikasiSpjTamsil();

            if ($canUsulTamsil && $canUsulTamsil->code !== 200) {
                return json_encode($canUsulTamsil);
            }

            $id = htmlspecialchars($this->request->getVar('id'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);

            $data['id'] = $id;
            $data['nama'] = $nama;
            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('situgu/su/verifikasi/spj/tamsil/tolak', $data);
            return json_encode($response);
        }
    }
}
