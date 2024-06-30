<?php

namespace App\Controllers\Adm\Layanan;

use App\Controllers\BaseController;
use App\Models\Adm\Layanan\AccessverifiModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use setasign\Fpdi\TcpdfFpdi;

class Accessverifi extends BaseController
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
        $datamodel = new AccessverifiModel($request);


        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            // $action = '<a class="btn btn-primary" href="./detaillist?id=' . $list->sekolah_id . '&n=' . $list->nama . '"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
            //                     ';
            $action = '<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->user_id . '\',\'' . $list->nama . '\');"><i class="fas fa-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
                            </div>
                        </div>';

            $row[] = $action;
            $row[] = $list->nama;
            $row[] = $list->npsn;
            $row[] = $list->nama_sekolah;
            $row[] = $list->role;

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
        return redirect()->to(base_url('adm/layanan/accessverifi/data'));
    }

    public function data()
    {
        $data['title'] = 'AKUN PESERTA DIDIK SEKOLAH';
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
        $data['levels'] = $this->_db->table('_role_user')->whereNotIN('id', [0, 1, 2, 5])->orderBy('role', 'ASC')->get()->getResult();

        return view('adm/layanan/accessverifi/index', $data);
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

                $x['roles'] = $this->_db->table('_role_user')->whereNotIN('id', [0, 1, 2, 5])->orderBy('role', 'ASC')->get()->getResult();

                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('adm/layanan/accessverifi/add', $x);
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function getPengguna()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'keyword' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Keyword tidak boleh kosong. ',
                    ]
                ],
                'role' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Role tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('keyword')
                    . $this->validator->getError('role');
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

                $keyword = htmlspecialchars($this->request->getVar('keyword'), true);
                $role = htmlspecialchars($this->request->getVar('role'), true);

                $current = $this->_db->table('_users_profile_sekolah a')
                    ->select("a.user_id as id, a.nama, a.npsn, a.nama_sekolah, b.level")
                    ->join('_users_tb b', 'b.id = a.user_id')
                    ->where("b.level= $role AND (b.username LIKE '%$keyword%' OR a.nama LIKE '%$keyword%')")->get()->getResult();

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

    public function addSave()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                '_role' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Role tidak boleh kosong. ',
                    ]
                ],
                '_filter_pengguna' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Pengguna tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_role')
                    . $this->validator->getError('_filter_pengguna');
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

                $role = htmlspecialchars($this->request->getVar('_role'), true);
                $pengguna = htmlspecialchars($this->request->getVar('_filter_pengguna'), true);

                $oldData = $this->_db->table('_users_tb')->where('id', $pengguna)->get()->getRowObject();
                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Pengguna tidak ditemukan.";
                    return json_encode($response);
                }

                $dataUser = [
                    'user_id' => $pengguna,
                ];

                $this->_db->transBegin();
                try {
                    $this->_db->table('custom_verifi')->insert($dataUser);
                    if ($this->_db->affectedRows() > 0) {

                        $this->_db->transCommit();

                        $response = new \stdClass;
                        $response->status = 200;
                        $response->url = base_url('portal');
                        $response->message = "Data berhasil disimpan";
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
                    $response->message = "Gagal menyimpan data. with error";
                    return json_encode($response);
                }
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
                    $response->message = "Session expired";
                    return json_encode($response);
                }

                $id = htmlspecialchars($this->request->getVar('id'), true);
                $nama = htmlspecialchars($this->request->getVar('nama'), true);

                $oldData = $this->_db->table('custom_verifi')->where('user_id', $id)->get()->getRowObject();

                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data tidak ditemukan.";
                    return json_encode($response);
                }

                $this->_db->transBegin();
                try {
                    $this->_db->table('custom_verifi')->where('user_id', $oldData->user_id)->delete();
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
                        $response->message = "Gagal mengupdate data.";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupdate data. with error";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
