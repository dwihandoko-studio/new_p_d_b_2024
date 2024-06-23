<?php

namespace App\Controllers\Su\Informasi;

use App\Controllers\BaseController;
use App\Models\Su\Informasi\AssetsModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Assets extends BaseController
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
        $datamodel = new AssetsModel($request);


        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->judul))  . '\');"><i class="fas fa-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
                                <div class="dropdown-divider"></div>
                            </div>
                        </div>';

            $row[] = $action;

            $row[] = $list->judul;
            $row[] = $list->file;
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

        return redirect()->to(base_url('su/informasi/assets/data'));
    }

    public function data()
    {
        $data['title'] = 'INFORMASI ASSET GAMBAR';
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

        return view('su/informasi/assets/index', $data);
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
                    return redirect()->to(base_url('auth'));
                }

                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('su/informasi/assets/add');
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function addSave()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                '_judul' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Judul tidak boleh kosong. ',
                    ]
                ],

            ];


            $filenamelampiran = dot_array_search('_file.name', $_FILES);
            if ($filenamelampiran != '') {
                $lampiranVal = [
                    '_file' => [
                        'rules' => 'uploaded[_file]|max_size[_file,2048]|mime_in[_file,image/jpeg,image/jpg,image/png,application/pdf]',
                        'errors' => [
                            'uploaded' => 'Pilih gambar/pdf terlebih dahulu. ',
                            'max_size' => 'Ukuran gambar/pdf terlalu besar. ',
                            'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar/pdf. '
                        ]
                    ],
                ];
                $rules = array_merge($rules, $lampiranVal);
            }

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_judul')
                    . $this->validator->getError('_file');
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

                $judul = htmlspecialchars($this->request->getVar('_judul'), true);

                $dir = FCPATH . "uploads/gambar";
                $field_db = 'file';
                $table_db = 'assets_gambar';

                if ($filenamelampiran != '') {
                    $lampiran = $this->request->getFile('_file');
                    $filesNamelampiran = $lampiran->getName();
                    $newNamelampiran = _create_name_file($filesNamelampiran);

                    $data = [];

                    if ($lampiran->isValid() && !$lampiran->hasMoved()) {
                        $lampiran->move($dir, $newNamelampiran);
                        $data[$field_db] = $newNamelampiran;
                    } else {
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal mengupload file.";
                        return json_encode($response);
                    }
                }

                $data['judul'] = $judul;
                $data['is_active'] = 1;
                $data['created_at'] = date('Y-m-d H:i:s');

                $this->_db->transBegin();
                try {
                    $this->_db->table($table_db)->insert($data);
                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->transCommit();

                        $response = new \stdClass;
                        $response->status = 200;
                        $response->url = base_url('portal');
                        $response->message = "Data berhasil disimpan.";
                        return json_encode($response);
                    } else {
                        unlink($dir . '/' . $newNamelampiran);
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal menyimpan data.";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    unlink($dir . '/' . $newNamelampiran);
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

                $oldData = $this->_db->table('assets_gambar')->where('id', $id)->get()->getRowObject();

                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data tidak ditemukan.";
                    return json_encode($response);
                }

                $dir = FCPATH . "uploads/gambar/" . $oldData->file;

                $this->_db->transBegin();
                try {
                    $this->_db->table('assets_gambar')->where('id', $oldData->id)->delete();
                    if ($this->_db->affectedRows() > 0) {
                        try {
                            unlink($dir);
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
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
