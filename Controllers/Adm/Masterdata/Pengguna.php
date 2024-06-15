<?php

namespace App\Controllers\Adm\Masterdata;

use App\Controllers\BaseController;
use App\Models\Adm\Masterdata\PenggunaModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pengguna extends BaseController
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
        $datamodel = new PenggunaModel($request);


        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            switch ($list->level) {
                case 0:
                    $action = '<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->username)) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                                <a class="dropdown-item" href="javascript:actionResetPassword(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->username))  . '\');"><i class="bx bx-key font-size-16 align-middle"></i> &nbsp;Reset Password</a>
                                <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->username))  . '\');"><i class="bx bx-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
                                <div class="dropdown-divider"></div>
                            </div>
                        </div>';
                    break;

                default:
                    $action = '<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->username)) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                                <a class="dropdown-item" href="javascript:actionResetPassword(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->username))  . '\');"><i class="bx bx-key font-size-16 align-middle"></i> &nbsp;Reset Password</a>
                                <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->username)) . '\');"><i class="bx bx-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
                                <div class="dropdown-divider"></div>
                            </div>
                        </div>';
                    break;
            }
            $row[] = $action;
            $row[] = $list->username;
            $row[] = $list->role;
            switch ($list->is_active) {
                case 1:
                    $row[] = '<div class="text-center">
                            <span class="badge rounded-pill badge-soft-success font-size-11">Aktif</span>
                        </div>';
                    break;
                default:
                    $row[] = '<div class="text-center">
                        <span class="badge rounded-pill badge-soft-danger font-size-11">Non Aktif</span>
                    </div>';
                    break;
            }
            switch ($list->email_verified) {
                case 1:
                    $row[] = '<div class="text-center">
                            <span class="badge rounded-pill badge-soft-success font-size-11">Ya</span>
                        </div>';
                    break;
                default:
                    $row[] = '<div class="text-center">
                        <span class="badge rounded-pill badge-soft-danger font-size-11">Tidak</span>
                    </div>';
                    break;
            }
            switch ($list->wa_verified) {
                case 1:
                    $row[] = '<div class="text-center">
                            <span class="badge rounded-pill badge-soft-success font-size-11">Ya</span>
                        </div>';
                    break;
                default:
                    $row[] = '<div class="text-center">
                        <span class="badge rounded-pill badge-soft-danger font-size-11">Tidak</span>
                    </div>';
                    break;
            }

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
        return redirect()->to(base_url('adm/masterdata/pengguna/data'));
    }

    public function data()
    {
        $data['title'] = 'PENGGUNA';
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
        $data['roles'] = $this->_db->table('_role_user')->whereNotIn('id', [0])->get()->getResult();

        return view('adm/masterdata/pengguna/index', $data);
    }

    public function generate()
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
                $response->message = "Permintaan diizinkan";
                $x['jenjangs'] = $this->_db->table('dapo_sekolah')->select("bentuk_pendidikan_id, bentuk_pendidikan, count(bentuk_pendidikan_id) as jumlah")->groupBy('bentuk_pendidikan_id')->orderBy('bentuk_pendidikan', 'ASC')->get()->getResult();
                $response->data = view('adm/masterdata/pengguna/generate', $x);
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function generateSave()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'jenis' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Jenis tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('jenis');
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

                $jenis = htmlspecialchars($this->request->getVar('jenis'), true);

                if ($jenis === "") {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Jenis tidak dikenali.";
                    return json_encode($response);
                } else {

                    $sekolahs = $this->_db->table('dapo_sekolah')->select("sekolah_id, npsn, bentuk_pendidikan, nama, kode_wilayah")->where('bentuk_pendidikan_id', $jenis)->get()->getResult();

                    $jmlData = count($sekolahs);

                    if ($jmlData > 0) {
                        $uuidLib = new Uuid();

                        $dataBerhasil = 0;
                        $dataGagal = 0;
                        $password = password_hash("123456", PASSWORD_DEFAULT);

                        foreach ($sekolahs as $key => $value) {
                            // if ($value->koreg == NULL || $value->koreg == "") {
                            //     $this->_db->table('gagal_generate_user')->insert([
                            //         'data' => json_encode($value),
                            //         'keterangan' => "Tidak ada koreg."
                            //     ]);
                            //     $dataGagal++;
                            //     continue;
                            // }

                            // 'password' => password_hash($value->koreg, PASSWORD_DEFAULT),
                            $dataUser = [
                                'id' => $uuidLib->v4(),
                                'username' => $value->npsn,
                                'password' => $password,
                                'is_active' => 1,
                                'level' => 4,
                                'created_at' => date('Y-m-d H:i:s')
                            ];

                            $dataUserProfile = [
                                'user_id' => $dataUser['id'],
                                'sekolah_id' => $value->sekolah_id,
                                'wilayah' => $value->kode_wilayah,
                                'nama' => $value->nama,
                                'nama_sekolah' => $value->nama,
                                'npsn' => $value->npsn,
                                'created_at' => $dataUser['created_at']
                            ];

                            $this->_db->transBegin();
                            try {
                                $this->_db->table('_users_tb')->insert($dataUser);
                                if ($this->_db->affectedRows() > 0) {
                                    $this->_db->table('_users_profile_sekolah')->insert($dataUserProfile);
                                    if ($this->_db->affectedRows() > 0) {
                                        $this->_db->transCommit();
                                        $dataBerhasil++;
                                        continue;
                                    } else {
                                        $this->_db->transRollback();
                                        $this->_db->table('gagal_generate_user')->insert([
                                            'data' => json_encode($dataUser),
                                            'data1' => json_encode($dataUserProfile),
                                            'keterangan' => "Tidak ada perubahan disimpan."
                                        ]);
                                        $dataGagal++;
                                        continue;
                                    }
                                } else {
                                    $this->_db->transRollback();
                                    $this->_db->table('gagal_generate_user')->insert([
                                        'data' => json_encode($dataUser),
                                        'data1' => json_encode($dataUserProfile),
                                        'keterangan' => "Tidak ada perubahan disimpan."
                                    ]);
                                    $dataGagal++;
                                    continue;
                                }
                            } catch (\Throwable $th) {
                                $this->_db->transRollback();
                                $this->_db->table('gagal_generate_user')->insert([
                                    'data' => json_encode($dataUser),
                                    'data1' => json_encode($dataUserProfile),
                                    'keterangan' => "Tidak ada perubahan disimpan."
                                ]);
                                $dataGagal++;
                                continue;
                            }
                        }

                        $response = new \stdClass;
                        $response->status = 200;
                        $response->message = "Data pengguna berhasil digenerate.";
                        $response->sended_data = $jmlData;
                        $response->upload_sukses = $dataBerhasil;
                        $response->upload_gagal = $dataGagal;
                        $response->data = "Jumlah data yang digenerate adalah Berhasil: $dataBerhasil, Gagal: $dataGagal";
                        return json_encode($response);
                    } else {
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Tidak ada data sekolah.";
                        return json_encode($response);
                    }
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function reset_password()
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
                $user = $Profilelib->userSekolah();
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

                $oldData = $this->_db->table('_users_tb')->where('id', $id)->get()->getRowObject();

                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data tidak ditemukan.";
                    return json_encode($response);
                }

                $passwordHas = password_hash("123456", PASSWORD_DEFAULT);

                $this->_db->transBegin();
                try {
                    $this->_db->table('_users_tb')->where('id', $oldData->id)->update(['password' => $passwordHas]);
                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->transCommit();

                        $response = new \stdClass;
                        $response->status = 200;
                        $response->url = base_url('portal');
                        $response->message = "Data $nama berhasil di reset. Password Default (123456)";
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
