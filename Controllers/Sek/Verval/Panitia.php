<?php

namespace App\Controllers\Sek\Verval;

use App\Controllers\BaseController;
use App\Models\Sek\Verval\PanitiaModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Panitia extends BaseController
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
        $Profilelib = new Profilelib();
        $user = $Profilelib->userSekolah();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $request = Services::request();
        $datamodel = new PanitiaModel($request);


        $lists = $datamodel->get_datatables($user->data->sekolah_id);
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                            <div class="dropdown-menu" style="">
                                <!-- <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama)) . '\');"><i class="fas fa-eye font-size-16 align-middle"></i> &nbsp;Detail</a> -->
                                <a class="dropdown-item" href="javascript:actionEdit(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="fas fa-edit font-size-16 align-middle"></i> &nbsp;Edit</a>
                                <a class="dropdown-item" href="javascript:actionResetPassword(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="fas fa-unlock-alt font-size-16 align-middle"></i> &nbsp;Reset Password</a>
                                <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="fas fa-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
                                <div class="dropdown-divider"></div>
                            </div>
                        </div>';

            $row[] = $action;
            switch ((int)$list->jabatan_ppdb) {
                case 1:
                    $row[] = 'Penanggung jawab';
                    break;
                case 2:
                    $row[] = 'Ketua';
                    break;
                case 3:
                    $row[] = 'Wakil Ketua';
                    break;
                case 4:
                    $row[] = 'Sekretaris';
                    break;
                case 5:
                    $row[] = 'Bendahara';
                    break;
                case 6:
                    $row[] = 'Anggota';
                    break;
                default:
                    $row[] = 'Anggota';
                    break;
            }
            $row[] = $list->nama;
            $row[] = $list->jabatan;
            if ((int)$list->is_active == 1) {
                $row[] = '<button type="button" onclick="actionDisabled(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\')" class="btn btn-primary btn-xxs">Aktif</button>';
            } else {
                $row[] = '<button type="button" onclick="actionAktifkan(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\')" class="btn btn-danger btn-xxs">Tidak Aktif</button>';
            }

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all($user->data->sekolah_id),
            "recordsFiltered" => $datamodel->count_filtered($user->data->sekolah_id),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        return redirect()->to(base_url('sek/verval/panitia/data'));
    }

    public function data()
    {
        $data['title'] = 'PANITIA PPDB';
        $Profilelib = new Profilelib();
        $user = $Profilelib->userSekolah();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;

        $data['lampiran'] = $this->_db->table('doc_panitia_sekolah')->where('sekolah_id', $user->data->sekolah_id)->get()->getRowObject();

        return view('sek/verval/panitia/index', $data);
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
                $user = $Profilelib->userSekolah();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    return redirect()->to(base_url('auth'));
                }

                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('sek/verval/panitia/add');
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

                $oldData = $this->_db->table('panitia_ppdb')->where('id', $id)->get()->getRowObject();

                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data tidak ditemukan.";
                    return json_encode($response);
                }

                $x['data'] = $oldData;

                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('sek/verval/panitia/edit', $x);
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function upload()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Id tidak boleh kosong. ',
                    ]
                ],
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
                $response->message = $this->validator->getError('id') . $this->validator->getError('jenis');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->userSekolah();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    return redirect()->to(base_url('auth'));
                }

                $jenis = htmlspecialchars($this->request->getVar('jenis'), true);
                $x['jenis'] = $jenis;

                $response = new \stdClass;
                if ($jenis == "pakta") {
                    $response->title = "UPLOAD FILE PAKTA INTEGRITAS";
                } else {
                    $response->title = "UPLOAD FILE SK PANITIA";
                }
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('sek/verval/panitia/upload', $x);
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function lihat()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Id tidak boleh kosong. ',
                    ]
                ],
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
                $response->message = $this->validator->getError('id') . $this->validator->getError('jenis');
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

                $jenis = htmlspecialchars($this->request->getVar('jenis'), true);
                $x['jenis'] = $jenis;

                $doc = $this->_db->table('doc_panitia_sekolah')->where('sekolah_id', $user->data->sekolah_id)->get()->getRowObject();

                $response = new \stdClass;
                if ($jenis == "pakta") {
                    $response->title = "LIHAT FILE PAKTA INTEGRITAS";
                    $x['title'] = "Pakta Integritas";
                    $x['doc'] = $doc->lampiran_pakta;
                } else {
                    $x['title'] = "SK Panitia";
                    $x['doc'] = $doc->lampiran_sk_panitia;
                    $response->title = "LIHAT FILE SK PANITIA";
                }


                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('sek/verval/panitia/lihat', $x);
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
                '_nama' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nama tidak boleh kosong. ',
                    ]
                ],
                '_email' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Email tidak boleh kosong. ',
                    ]
                ],
                '_nohp' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nohp tidak boleh kosong. ',
                    ]
                ],
                '_jabatan' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Jabatan tidak boleh kosong. ',
                    ]
                ],
                '_jabatan_ppdb' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Jabatan ppdb tidak boleh kosong. ',
                    ]
                ],
                '_password' => [
                    'rules' => 'required|min_length[6]|max_length[50]',
                    'errors' => [
                        'required' => 'Password is required. ',
                        'min_length' => 'Password must be at least {min} characters long. ',
                        'max_length' => 'Password cannot exceed {max} characters. ',
                    ],
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_nama')
                    . $this->validator->getError('_email')
                    . $this->validator->getError('_nohp')
                    . $this->validator->getError('_jabatan')
                    . $this->validator->getError('_jabatan_ppdb')
                    . $this->validator->getError('_password');
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

                $nama = htmlspecialchars($this->request->getVar('_nama'), true);
                $email = htmlspecialchars($this->request->getVar('_email'), true);
                $nohp = htmlspecialchars($this->request->getVar('_nohp'), true);
                $jabatan = htmlspecialchars($this->request->getVar('_jabatan'), true);
                $jabatan_ppdb = htmlspecialchars($this->request->getVar('_jabatan_ppdb'), true);
                $password = htmlspecialchars($this->request->getVar('_password'), true);

                if ($password == "123456") {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Keamanan password terlalu lemah.";
                    return json_encode($response);
                }

                $oldData = $this->_db->table('_users_tb')->where('username', $email)->get()->getRowObject();
                if ($oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Email sudah digunakan oleh pengguna lain.";
                    return json_encode($response);
                }

                $sekolah = $this->_db->table('dapo_sekolah')->where('sekolah_id', $user->data->sekolah_id)->get()->getRowObject();
                if (!$sekolah) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data sekolah tidak ditemukan.";
                    return json_encode($response);
                }

                $passwordHas = password_hash($password, PASSWORD_BCRYPT);

                $uuidLib = new Uuid();

                $dataUser = [
                    'id' => $uuidLib->v4(),
                    'username' => $email,
                    'email' => $email,
                    'nohp' => $nohp,
                    'password' => $passwordHas,
                    'is_active' => 1,
                    'level' => 3,
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $dataUserProfile = [
                    'user_id' => $dataUser['id'],
                    'sekolah_id' => $sekolah->sekolah_id,
                    'wilayah' => $sekolah->kode_wilayah,
                    'nama' => $nama,
                    'nama_sekolah' => $sekolah->nama,
                    'npsn' => $sekolah->npsn,
                    'created_at' => $dataUser['created_at']
                ];

                $this->_db->transBegin();
                try {
                    $this->_db->table('_users_tb')->insert($dataUser);
                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->table('_users_profile_sekolah')->insert($dataUserProfile);
                        if ($this->_db->affectedRows() > 0) {
                            $this->_db->table('panitia_ppdb')->insert([
                                'id' => $dataUser['id'],
                                'sekolah_id' => $sekolah->sekolah_id,
                                'nama' => $nama,
                                'jabatan' => $jabatan,
                                'jabatan_ppdb' => $jabatan_ppdb,
                                'created_at' => $dataUser['created_at']
                            ]);
                            if ($this->_db->affectedRows() > 0) {
                                $this->_db->transCommit();

                                $response = new \stdClass;
                                $response->status = 200;
                                $response->url = base_url('portal');
                                $response->message = "Data berhasil disimpan. Username Akun menggunakan Email";
                                return json_encode($response);
                            } else {
                                $this->_db->transRollback();
                                $response = new \stdClass;
                                $response->status = 400;
                                $response->message = "Gagal menyimpan data.";
                                return json_encode($response);
                            }
                        } else {
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "Gagal menyimpan data.";
                            return json_encode($response);
                        }
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

    public function editSave()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                '_nama' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nama tidak boleh kosong. ',
                    ]
                ],
                '_jabatan' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Jabatan tidak boleh kosong. ',
                    ]
                ],
                '_jabatan_ppdb' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Jabatan ppdb tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_nama')
                    . $this->validator->getError('_jabatan')
                    . $this->validator->getError('_jabatan_ppdb');
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

                $id = htmlspecialchars($this->request->getVar('_id'), true);
                $nama = htmlspecialchars($this->request->getVar('_nama'), true);
                $jabatan = htmlspecialchars($this->request->getVar('_jabatan'), true);
                $jabatan_ppdb = htmlspecialchars($this->request->getVar('_jabatan_ppdb'), true);

                $oldData = $this->_db->table('panitia_ppdb')->where('id', $id)->get()->getRowObject();

                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data tidak ditemukan.";
                    return json_encode($response);
                }

                $this->_db->transBegin();
                try {
                    $this->_db->table('panitia_ppdb')->where('id', $oldData->id)->update([
                        'nama' => $nama,
                        'jabatan' => $jabatan,
                        'jabatan_ppdb' => $jabatan_ppdb,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->table('_users_profile_sekolah')->where('user_id', $oldData->id)->update([
                            'nama' => $nama,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                        if ($this->_db->affectedRows() > 0) {
                            $this->_db->transCommit();

                            $response = new \stdClass;
                            $response->status = 200;
                            $response->url = base_url('portal');
                            $response->message = "Data berhasil diupdate.";
                            return json_encode($response);
                        } else {
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "Gagal mengupdate data.";
                            return json_encode($response);
                        }
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

                if ((int)$oldData->level == 4) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Admin sekolah tidak dapat dihapus. Silahkan gunakan menu edit, untuk merubah data.";
                    return json_encode($response);
                }

                $this->_db->transBegin();
                try {
                    $this->_db->table('_users_tb')->where('id', $oldData->id)->delete();
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

                $oldData = $this->_db->table('panitia_ppdb')->where('id', $id)->get()->getRowObject();

                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data tidak ditemukan.";
                    return json_encode($response);
                }

                $passwordHas = password_hash("123456", PASSWORD_BCRYPT);

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

    public function disable_akun()
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

                if ((int)$oldData->level == 4) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Akun Admin Sekolah tidak bisa di disabled. Silahkan hubungi admin ppdb dinas";
                    return json_encode($response);
                }

                $this->_db->transBegin();
                try {
                    $this->_db->table('_users_tb')->where('id', $oldData->id)->update(['is_active' => 0]);
                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->transCommit();

                        $response = new \stdClass;
                        $response->status = 200;
                        $response->url = base_url('portal');
                        $response->message = "Data $nama berhasil di nonaktifkan.";
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

    public function aktifkan_akun()
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

                if ((int)$oldData->level == 4) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Akun Admin Sekolah tidak bisa di diaktifkan. Silahkan hubungi admin ppdb dinas";
                    return json_encode($response);
                }

                $this->_db->transBegin();
                try {
                    $this->_db->table('_users_tb')->where('id', $oldData->id)->update(['is_active' => 1]);
                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->transCommit();

                        $response = new \stdClass;
                        $response->status = 200;
                        $response->url = base_url('portal');
                        $response->message = "Data $nama berhasil di aktifkan.";
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

    public function uploadSave()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                '_jenis' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Jenis tidak boleh kosong. ',
                    ]
                ],
                '_file' => [
                    'rules' => 'uploaded[_file]|max_size[_file,2048]|mime_in[_file,image/jpeg,image/jpg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih file terlebih dahulu. ',
                        'max_size' => 'Ukuran file terlalu besar, Maximum 2Mb. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar dan pdf. '
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_jenis')
                    . $this->validator->getError('_file');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->userSekolah();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Permintaan diizinkan";
                    return json_encode($response);
                }

                $jenis = htmlspecialchars($this->request->getVar('_jenis'), true);

                if ($jenis == "pakta") {
                    $dir = FCPATH . "uploads/panitia";
                    $field_db = 'lampiran_pakta';
                    $table_db = 'doc_panitia_sekolah';
                } else {
                    $dir = FCPATH . "uploads/panitia";
                    $field_db = 'lampiran_sk_panitia';
                    $table_db = 'doc_panitia_sekolah';
                }

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

                $oldData = $this->_db->table($table_db)->where('sekolah_id', $user->data->sekolah_id)->get()->getRowObject();

                if (!$oldData) {
                    $uuidLib = new Uuid();
                    $data['id'] = $uuidLib->v4();
                    $data['sekolah_id'] = $user->data->sekolah_id;
                    $data['created_at'] = date('Y-m-d H:i:s');
                } else {
                    $data['updated_at'] = date('Y-m-d H:i:s');
                }

                $this->_db->transBegin();
                try {
                    if ($oldData) {
                        $this->_db->table($table_db)->where('id', $oldData->id)->update($data);
                    } else {
                        $this->_db->table($table_db)->insert($data);
                    }
                } catch (\Exception $e) {
                    unlink($dir . '/' . $newNamelampiran);

                    $this->_db->transRollback();

                    $response = new \stdClass;
                    $response->status = 400;
                    // $response->error = var_dump($e);
                    $response->message = "Gagal menyimpan data.";
                    return json_encode($response);
                }

                if ($this->_db->affectedRows() > 0) {
                    // createAktifitas($user->data->id, "Mengupload lampiran data $jenis", "Mengupload Lampiran $jenis", "upload", $user->data->sekolah_id);
                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Data berhasil diupload.";
                    return json_encode($response);
                } else {
                    unlink($dir . '/' . $newNamelampiran);

                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menyimpan data";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function editUploadSave()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                '_jenis' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Jenis tidak boleh kosong. ',
                    ]
                ],
                '_file' => [
                    'rules' => 'uploaded[_file]|max_size[_file,2048]|mime_in[_file,image/jpeg,image/jpg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih file terlebih dahulu. ',
                        'max_size' => 'Ukuran file terlalu besar, Maximum 2Mb. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar dan pdf. '
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_jenis')
                    . $this->validator->getError('_file');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->userSekolah();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Permintaan diizinkan";
                    return json_encode($response);
                }

                $jenis = htmlspecialchars($this->request->getVar('_jenis'), true);

                if ($jenis == "pakta") {
                    $dir = FCPATH . "uploads/panitia";
                    $field_db = 'lampiran_pakta';
                    $table_db = 'doc_panitia_sekolah';
                } else {
                    $dir = FCPATH . "uploads/panitia";
                    $field_db = 'lampiran_sk_panitia';
                    $table_db = 'doc_panitia_sekolah';
                }

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

                $oldData = $this->_db->table($table_db)->where('sekolah_id', $user->data->sekolah_id)->get()->getRowObject();

                if (!$oldData) {
                    $uuidLib = new Uuid();
                    $data['id'] = $uuidLib->v4();
                    $data['sekolah_id'] = $user->data->sekolah_id;
                    $data['created_at'] = date('Y-m-d H:i:s');
                } else {
                    $data['updated_at'] = date('Y-m-d H:i:s');
                }

                $this->_db->transBegin();
                try {
                    if ($oldData) {
                        $this->_db->table($table_db)->where('id', $oldData->id)->update($data);
                    } else {
                        $this->_db->table($table_db)->insert($data);
                    }
                } catch (\Exception $e) {
                    unlink($dir . '/' . $newNamelampiran);

                    $this->_db->transRollback();

                    $response = new \stdClass;
                    $response->status = 400;
                    // $response->error = var_dump($e);
                    $response->message = "Gagal menyimpan data.";
                    return json_encode($response);
                }

                if ($this->_db->affectedRows() > 0) {
                    try {
                        if ($oldData) {
                            if ($jenis == "pakta") {
                                unlink($dir . '/' . $oldData->lampiran_pakta);
                            } else {
                                unlink($dir . '/' . $oldData->lampiran_sk_panitia);
                            }
                        }
                    } catch (\Throwable $th) {
                    }
                    // createAktifitas($user->data->id, "Mengupload lampiran data $jenis", "Mengupload Lampiran $jenis", "upload", $user->data->sekolah_id);
                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Data berhasil diupload.";
                    return json_encode($response);
                } else {
                    unlink($dir . '/' . $newNamelampiran);

                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menyimpan data";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
