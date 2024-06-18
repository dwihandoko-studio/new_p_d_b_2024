<?php

namespace App\Controllers\Adm\Masterdata;

use App\Controllers\BaseController;
use App\Models\Adm\Masterdata\KelurahanModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Kelurahan extends BaseController
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
        $datamodel = new KelurahanModel($request);


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
                                <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama)) . '\');"><i class="fas fa-eye font-size-16 align-middle"></i> &nbsp;Detail</a>
                                <a class="dropdown-item" href="javascript:actionResetPassword(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="fas fa-edit font-size-16 align-middle"></i> &nbsp;Reset Password</a>
                                <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="fas fa-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
                                <div class="dropdown-divider"></div>
                            </div>
                        </div>';

            $row[] = $action;
            $row[] = $list->id;
            $row[] = $list->nama;
            $row[] = getNameKecamatan($list->id_kecamatan);
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
        return redirect()->to(base_url('adm/masterdata/kelurahan/data'));
    }

    public function data()
    {
        $data['title'] = 'KELURAHAN';
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

        return view('adm/masterdata/kelurahan/index', $data);
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

                $response = new \stdClass;
                $response->status = 200;
                $response->title = "TAMBAH KUOTA SEKOLAH";
                $response->message = "Permintaan diizinkan";
                $response->data = view('adm/masterdata/kelurahan/add');
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function getKecamatan()
    {
        if ($this->request->isAJAX()) {

            $rules = [
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
                $response->message = $this->validator->getError('keyword');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->user();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    return redirect()->to(base_url('auth'));
                }

                $keyword = htmlspecialchars($this->request->getVar('keyword'), true);

                $current = $this->_db->table('ref_kecamatan a')
                    ->select("a.*, b.nama as kabupaten")
                    ->join("ref_kabupaten b", 'a.id_kabupaten = b.id')
                    ->where("(a.nama LIKE '%$keyword%')")->get()->getResult();

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
                '_nama' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nama kelurahan tidak boleh kosong. ',
                    ]
                ],
                '_kecamatan' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kecamatan tidak boleh kosong. ',
                    ]
                ],
                '_kode' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kode kelurahan tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_nama')
                    . $this->validator->getError('_kecamatan')
                    . $this->validator->getError('_kode');
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

                $nama = htmlspecialchars($this->request->getVar('_nama'), true);
                $kode = htmlspecialchars($this->request->getVar('_kode'), true);
                $kecamatan = htmlspecialchars($this->request->getVar('_kecamatan'), true);

                $oldData = $this->_db->table('ref_kelurahan')->where('id', $kode)->get()->getRowObject();
                if ($oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Kode sudah digunakan.";
                    return json_encode($response);
                }

                $data = [
                    'id' => $kode,
                    'id_kecamatan' => $kecamatan,
                    'nama' => $nama,
                    'id_wilayah' => 4,
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $this->_db->transBegin();
                try {
                    $this->_db->table('ref_kelurahan')->insert($data);
                    if ($this->_db->affectedRows() > 0) {

                        $this->_db->transCommit();

                        $response = new \stdClass;
                        $response->status = 200;
                        $response->url = base_url('portal');
                        $response->message = "Data berhasil disimpan.";
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
}
