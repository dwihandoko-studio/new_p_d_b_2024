<?php

namespace App\Controllers\Pan;

use App\Controllers\BaseController;
use App\Models\Pan\PanitiaModel;
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
            // $action = '<div class="btn-group">
            //                 <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
            //                 <div class="dropdown-menu" style="">
            //                     <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
            //                     <a class="dropdown-item" href="javascript:actionResetPassword(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="bx bx-key font-size-16 align-middle"></i> &nbsp;Reset Password</a>
            //                     <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\');"><i class="bx bx-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
            //                     <div class="dropdown-divider"></div>
            //                 </div>
            //             </div>';

            // $row[] = $action;
            switch ((int)$list->jabatan_ppdb) {
                case 1:
                    $row[] = 'Penanggung jawab';
                    break;
                case 2:
                    $row[] = 'Sekretaris';
                    break;
                case 3:
                    $row[] = 'Bendahara';
                    break;
                case 4:
                    $row[] = 'Anggota';
                    break;
                default:
                    $row[] = 'Anggota';
                    break;
            }
            $row[] = $list->nama;
            $row[] = $list->jabatan;
            if ((int)$list->is_active == 1) {
                $row[] = '<button type="button" onclick="actionDisabled(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama) . '\')" class="btn btn-primary btn-xxs">Aktif</button>';
            } else {
                $row[] = '<button type="button" onclick="actionDisabled(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama) . '\')" class="btn btn-danger btn-xxs">Tidak Aktif</button>';
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
        return redirect()->to(base_url('pan/panitia/data'));
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

        return view('pan/panitia/index', $data);
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
                $response->data = view('pan/panitia/add');
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
                                $response->message = "Data berhasil disimpan.";
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

    public function edit()
    {
        $data['title'] = 'EDIT DOMISILI PESERTA DIDIK';
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

        return view('pan/pd/edit', $data);
    }

    public function getPd()
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
                $user = $Profilelib->userSekolah();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    return redirect()->to(base_url('auth'));
                }

                $keyword = htmlspecialchars($this->request->getVar('keyword'), true);

                $sekolah_id = $user->data->sekolah_id;

                $current = $this->_db->table('dapo_peserta')
                    ->select("peserta_didik_id as id, nama, nisn, tanggal_lahir, tempat_lahir")
                    ->where("sekolah_id = '$sekolah_id' AND (nisn LIKE '%$keyword%' OR nama LIKE '%$keyword%')")->get()->getResult();

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
                $user = $Profilelib->userSekolah();
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
                $user = $Profilelib->userSekolah();
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

    public function changedPd()
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
                $user = $Profilelib->userSekolah();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    return redirect()->to(base_url('auth'));
                }

                $id = htmlspecialchars($this->request->getVar('id'), true);

                $current = $this->_db->table('dapo_peserta')
                    ->where("peserta_didik_id = '$id'")->get()->getRowObject();

                if ($current) {
                    $x['data'] = $current;
                    $x['kabs'] = $this->_db->table('ref_kabupaten')
                        ->where("left(id,2) = left('{$current->kode_wilayah}',2)")->get()->getResult();
                    $x['kecs'] = $this->_db->table('ref_kecamatan')
                        ->where("id = left('{$current->kode_wilayah}',6)")->get()->getResult();
                    $x['kels'] = $this->_db->table('ref_kelurahan')
                        ->where("id = '{$current->kode_wilayah}'")->get()->getResult();
                    $x['dusuns'] = $this->_db->table('ref_dusun')
                        ->get()->getResult();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Permintaan diizinkan";
                    $response->data = view('pan/pd/form_edit', $x);
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

    public function location()
    {
        if ($this->request->isAJAX()) {
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

            $x['lat'] = htmlspecialchars($this->request->getVar('lat'), true) ?? "";
            $x['long'] = htmlspecialchars($this->request->getVar('long'), true) ?? "";

            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('pan/pd/maps', $x);
            return json_encode($response);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function editSave()
    {
        if ($this->request->isAJAX()) {
            $Profilelib = new Profilelib();
            $user = $Profilelib->userSekolah();
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
                'nik' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nik tidak boleh kosong. ',
                    ]
                ],
                'kk' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'No KK tidak boleh kosong. ',
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
                'lintang' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Lintang tidak boleh kosong. ',
                    ]
                ],
                'bujur' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Bujur tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('id')
                    . $this->validator->getError('nik')
                    . $this->validator->getError('kk')
                    . $this->validator->getError('kab')
                    . $this->validator->getError('kec')
                    . $this->validator->getError('kel')
                    . $this->validator->getError('dusun')
                    . $this->validator->getError('lintang')
                    . $this->validator->getError('bujur');
                return json_encode($response);
            } else {

                $id = htmlspecialchars($this->request->getVar('id'), true);
                $nik = htmlspecialchars($this->request->getVar('nik'), true);
                $kk = htmlspecialchars($this->request->getVar('kk'), true);
                $kab = htmlspecialchars($this->request->getVar('kab'), true);
                $kec = htmlspecialchars($this->request->getVar('kec'), true);
                $kel = htmlspecialchars($this->request->getVar('kel'), true);
                $dusun = htmlspecialchars($this->request->getVar('dusun'), true);
                $lintang = htmlspecialchars($this->request->getVar('lintang'), true);
                $bujur = htmlspecialchars($this->request->getVar('bujur'), true);

                $oldData = $this->_db->table('dapo_peserta')->where('peserta_didik_id', $id)->get()->getRowObject();
                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Peserta didik tidak ditemukan.";
                    return json_encode($response);
                }

                if (
                    $oldData->nik === $nik
                    && $oldData->no_kk === $kk
                    && $oldData->kab === $kab
                    && $oldData->kec === $kec
                    && $oldData->kel === $kel
                    && $oldData->dusun === $dusun
                    && $oldData->lintang === $lintang
                    && $oldData->bujur === $bujur
                ) {
                    $response = new \stdClass;
                    $response->status = 201;
                    $response->message = "Tidak ada perubahan data yang perlu disimpan";
                    return json_encode($response);
                }

                $this->_db->transBegin();
                try {
                    $this->_db->table('dapo_peserta')->where('peserta_didik_id', $oldData->peserta_didik_id)->update([
                        'nik' => $nik,
                        'no_kk' => $kk,
                        'kab' => $kab,
                        'kec' => $kec,
                        'kel' => $kel,
                        'kode_wilayah' => $kel,
                        'dusun' => $dusun,
                        'lintang' => $lintang,
                        'bujur' => $bujur,
                        'is_edited' => 1,
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
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('su/masterdata/pd/upload');
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function saveupload()
    {
        if ($this->request->isAJAX()) {
            $Profilelib = new Profilelib();
            $user = $Profilelib->userSekolah();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                return redirect()->to(base_url('auth'));
            }

            $jenjang = htmlspecialchars($this->request->getVar('jenjang'), true);
            $jsonData = htmlspecialchars($this->request->getVar('data'), true);

            if ($jenjang === "" || $jsonData === "") {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data yang diupload tidak valid.";
                return json_encode($response);
            }
            $formData = json_decode($jsonData, true);

            $jmlData = count($formData);

            if ($jmlData < 1) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data yang diupload tidak valid.";
                return json_encode($response);
            }

            $dataBerhasil = 0;
            $dataGagal = 0;
            $dataTidakDitemukan = 0;

            $uuidLib = new Uuid();

            $dataInserts = [];

            for ($i = 0; $i < $jmlData; $i++) {

                $peserta_didik_id = $formData[$i][0];
                $sekolah_id = $formData[$i][1];
                $kode_wilayah = $formData[$i][2];
                $nama = $formData[$i][3];
                $tempat_lahir = $formData[$i][4];
                $tanggal_lahir = $formData[$i][5];
                $jenis_kelamin = $formData[$i][6];
                $nik = $formData[$i][7];
                $no_kk = $formData[$i][8];
                $nisn = $formData[$i][9];
                $alamat_jalan = $formData[$i][10];
                $desa_kelurahan = $formData[$i][11];
                $rt = $formData[$i][12];
                $rw = $formData[$i][13];
                $nama_dusun = $formData[$i][14];
                $nama_ibu_kandung = $formData[$i][15];
                $pekerjaan_ibu = $formData[$i][16];
                $penghasilan_ibu = $formData[$i][17];
                $nama_ayah = $formData[$i][18];
                $pekerjaan_ayah = $formData[$i][19];
                $penghasilan_ayah = $formData[$i][20];
                $nama_wali = $formData[$i][21];
                $pekerjaan_wali = $formData[$i][22];
                $penghasilan_wali = $formData[$i][23];
                $kebutuhan_khusus = $formData[$i][24];
                $no_kip = $formData[$i][25];
                $no_pkh = $formData[$i][26];
                $lintang = $formData[$i][27];
                $bujur = $formData[$i][28];
                $flag_pip = $formData[$i][29];

                $this->_db->transBegin();
                $dataRow = [
                    'peserta_didik_id' => $peserta_didik_id,
                    'sekolah_id' => $sekolah_id,
                    'kode_wilayah' => $kode_wilayah,
                    'nama' => $nama,
                    'tempat_lahir' => $tempat_lahir,
                    'tanggal_lahir' => $tanggal_lahir,
                    'jenis_kelamin' => $jenis_kelamin,
                    'nik' => $nik == "" ? NULL : $nik,
                    'no_kk' => $no_kk == "" ? NULL : $no_kk,
                    'nisn' => $nisn == "" ? NULL : $nisn,
                    'alamat_jalan' => $alamat_jalan == "" ? NULL : $alamat_jalan,
                    'desa_kelurahan' => $desa_kelurahan == "" ? NULL : $desa_kelurahan,
                    'rt' => $rt == "" ? NULL : $rt,
                    'rw' => $rw == "" ? NULL : $rw,
                    'nama_dusun' => $nama_dusun == "" ? NULL : $nama_dusun,
                    'nama_ibu_kandung' => $nama_ibu_kandung == "" ? NULL : $nama_ibu_kandung,
                    'pekerjaan_ibu' => $pekerjaan_ibu == "" ? NULL : $pekerjaan_ibu,
                    'penghasilan_ibu' => $penghasilan_ibu == "" ? NULL : $penghasilan_ibu,
                    'nama_ayah' => $nama_ayah == "" ? NULL : $nama_ayah,
                    'pekerjaan_ayah' => $pekerjaan_ayah == "" ? NULL : $pekerjaan_ayah,
                    'penghasilan_ayah' => $penghasilan_ayah == "" ? NULL : $penghasilan_ayah,
                    'nama_wali' => $nama_wali == "" ? NULL : $nama_wali,
                    'pekerjaan_wali' => $pekerjaan_wali == "" ? NULL : $pekerjaan_wali,
                    'penghasilan_wali' => $penghasilan_wali == "" ? NULL : $penghasilan_wali,
                    'kebutuhan_khusus' => $kebutuhan_khusus == "" ? NULL : $kebutuhan_khusus,
                    'no_kip' => $no_kip == "" ? NULL : $no_kip,
                    'no_pkh' => $no_pkh == "" ? NULL : $no_pkh,
                    'lintang' => $lintang == "" ? NULL : $lintang,
                    'bujur' => $bujur == "" ? NULL : $bujur,
                    'flag_pip' => $flag_pip == "" ? NULL : $flag_pip,
                    'tingkat_pendidikan_id' => (int)$jenjang,
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                try {
                    $this->_db->table('dapo_peserta')->insert($dataRow);
                    if ($this->_db->affectedRows() > 0) {

                        $this->_db->transCommit();
                        $dataBerhasil++;
                        continue;
                    } else {
                        $this->_db->transRollback();
                        $this->_db->table('gagal_upload_import')->insert([
                            'data' => json_encode($dataRow),
                            'keterangan' => "Tidak ada perubahan disimpan."
                        ]);
                        $dataGagal++;
                        continue;
                    }
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $this->_db->table('gagal_upload_import')->insert([
                        'data' => json_encode($dataRow),
                        'keterangan' => "error catch"
                    ]);
                    $dataGagal++;
                    continue;
                }

                // $response = new \stdClass;
                // $response->status = 400;
                // $response->message = "Data yang dikirim tidak valid. Pegawai tidak ditemukan.";
                // return json_encode($response);

            }

            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Data berhasil diupload.";
            $response->sended_data = $jmlData;
            $response->upload_sukses = $dataBerhasil;
            $response->upload_gagal = $dataGagal;
            $response->upload_tidakditemukan = $dataTidakDitemukan;
            $response->data = "Jumlah data yang disimpan adalah Berhasil: $dataBerhasil, Gagal: $dataGagal";
            return json_encode($response);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
