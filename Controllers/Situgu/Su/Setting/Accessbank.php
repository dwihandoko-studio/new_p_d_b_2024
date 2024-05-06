<?php

namespace App\Controllers\Situgu\Su\Setting;

use App\Controllers\BaseController;
use App\Models\Sigaji\Su\SettingaccessbankModel;
use Config\Services;
use App\Libraries\Helplib;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;

class Accessbank extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;
    private $_db_gaji;
    private $_helplib;
    private $model;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
        $this->_db_gaji      = \Config\Database::connect('sigaji');
        $this->_helplib = new Helplib();
    }

    public function getAll()
    {
        $request = Services::request();
        $datamodel = new SettingaccessbankModel($request);


        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<a href="javascript:actionHapus(\'' . $list->user_id . '\', \'' . str_replace("'", "", $list->fullname)  . '\', \'' . $list->dari_bank . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                <i class="bx bx-trash font-size-16 align-middle"></i></button>
                </a>';
            $row[] = $action;
            $row[] = $list->fullname;
            $row[] = $this->_helplib->getNamaBank($list->dari_bank);

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
        return redirect()->to(base_url('situgu/su/setting/accessbank/data'));
    }

    public function data()
    {
        $data['title'] = 'GRANTED ACCESS BANK';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;

        return view('situgu/su/setting/accessbank/index', $data);
    }

    public function add()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            $response = new \stdClass;
            $response->status = 401;
            $response->message = "Permintaan diizinkan";
            return json_encode($response);
        }

        $d['penggunas'] = $this->_db->table('_profil_users_tb')->select("id, fullname, email")->where('role_user', 9)->orderBy('fullname', 'asc')->get()->getResult();
        $d['banks'] = $this->_db_gaji->table('ref_bank')->select("id, nama_bank")->orderBy('nama_bank', 'asc')->get()->getResult();

        $response = new \stdClass;
        $response->status = 200;
        $response->message = "Permintaan diizinkan";
        $response->data = view('situgu/su/setting/accessbank/add', $d);
        return json_encode($response);
    }

    public function addSave()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'dari_bank' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Dari bank tidak boleh kosong. ',
                ]
            ],
            'pengguna' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Pengguna tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('dari_bank')
                . $this->validator->getError('pengguna');
            return json_encode($response);
        } else {
            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Permintaan diizinkan";
                return json_encode($response);
            }

            $dari_bank = htmlspecialchars($this->request->getVar('dari_bank'), true);
            $pengguna = htmlspecialchars($this->request->getVar('pengguna'), true);

            $cekData = $this->_db->table('_user_bank')->where(['user_id' => $pengguna])->get()->getRowObject();

            if ($cekData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Pengguna sudah ada dalam list.";
                return json_encode($response);
            }

            $this->_db->transBegin();
            $data = [
                'user_id' => $pengguna,
                'dari_bank' => $dari_bank,
            ];

            try {
                $this->_db->table('_user_bank')->insert($data);
                if ($this->_db->affectedRows() > 0) {
                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Data berhasil disimpan.";
                    $response->data = $data;
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
                $response->message = "Gagal menyimpan data.";
                return json_encode($response);
            }
        }
    }

    public function getPengguna()
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
            'keyword' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Keyword tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('keyword');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $keyword = htmlspecialchars($this->request->getVar('keyword'), true);

            $current = $this->_db->table('_profil_users_tb')
                ->select("id, fullname, email, npsn, kecamatan, nip")
                ->where("role_user = $id AND (nip LIKE '%$keyword%' OR fullname LIKE '%$keyword%' OR npsn LIKE '%$keyword%' OR kecamatan LIKE '%$keyword%')")->get()->getResult();

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
    }

    public function delete()
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
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);

            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Permintaan diizinkan";
                return json_encode($response);
            }

            $this->_db->transBegin();
            try {
                $this->_db->table('_user_bank')->where('user_id', $id)->delete();

                if ($this->_db->affectedRows() > 0) {
                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Data berhasil dihapus.";
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data gagal dihapus.";
                    return json_encode($response);
                }
            } catch (\Throwable $th) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data gagal dihapus.";
                return json_encode($response);
            }
        }
    }
}
