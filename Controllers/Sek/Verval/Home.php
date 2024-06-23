<?php

namespace App\Controllers\Sek\Verval;

use App\Controllers\BaseController;
use App\Libraries\Profilelib;
use App\Libraries\Helplib;

class Home extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;
    private $_helpLib;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
        $this->_helpLib = new Helplib();
    }

    public function getAllPengaduan()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        $datas = $this->_db->table('riwayat_pengaduan a')
            // ->select("a.*, (SELECT count(*) FROM _notification_tb WHERE send_to = '$id' AND (readed = 0)) as jumlah, b.fullname, b.profile_picture as image_user")
            // ->join('_profil_users_tb b', 'a.send_from = b.id', 'LEFT')
            ->where('a.user_id', $user->data->id)
            ->limit(5)
            ->orderBy('a.created_at', 'DESC')
            ->get()->getResult();

        if (count($datas) > 0) {
            $x['datas'] = $datas;
            $response = new \stdClass;
            $response->status = 200;
            $response->message = "success";
            $response->data = $datas;
            return json_encode($response);
        } else {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Belum ada riwayat.";
            $response->data = [];
            return json_encode($response);
        }
    }

    public function getAllPermohonan()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        $datas = $this->_db->table('riwayat_permohonan a')
            // ->select("a.*, (SELECT count(*) FROM _notification_tb WHERE send_to = '$id' AND (readed = 0)) as jumlah, b.fullname, b.profile_picture as image_user")
            // ->join('_profil_users_tb b', 'a.send_from = b.id', 'LEFT')
            ->where('a.user_id', $user->data->id)
            ->limit(5)
            ->orderBy('a.created_at', 'DESC')
            ->get()->getResult();

        if (count($datas) > 0) {
            $x['datas'] = $datas;
            $response = new \stdClass;
            $response->status = 200;
            $response->message = "success";
            $response->data = $datas;
            return json_encode($response);
        } else {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Belum ada riwayat.";
            $response->data = [];
            return json_encode($response);
        }
    }

    public function index()
    {
        // var_dump("world");
        // die;
        return redirect()->to(base_url('sek/verval/home/data'));
    }

    public function data()
    {

        $Profilelib = new Profilelib();
        $user = $Profilelib->userSekolah();

        if (!$user || $user->status !== 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        // if ($user->data->image == NULL || $user->data->image == "") {
        if (password_verify("123456", $user->data->password)) {
            $data['firs_login'] = true;
        } else {
            $data['firs_login'] = false;
        }

        $data['informasis'] = $this->_db->table('doc_informasi')->where("tujuan IS NULL OR tujuan IN (3,4)")->get()->getResult();

        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        $data['title'] = 'Dashboard';
        return view('sek/verval/home/index', $data);
    }

    public function statistik()
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

                $data = $this->_db->table('dapo_peserta a')
                    ->select("a.sekolah_id, count(a.peserta_didik_id) AS total, (SELECT count(peserta_didik_id) FROM dapo_peserta WHERE dusun IS NOT NULL AND sekolah_id = a.sekolah_id) AS verified, (SELECT count(peserta_didik_id) FROM dapo_peserta WHERE dusun IS NULL AND sekolah_id = a.sekolah_id) AS notverified, (SELECT count(peserta_didik_id) FROM _users_profile_pd WHERE sekolah_id_asal = a.sekolah_id) AS generate")
                    ->where('a.sekolah_id', $user->data->sekolah_id)
                    ->get()->getRowObject();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = $data;
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
                $x['user'] = $user->data;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('sek/verval/home/edit', $x);
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function editSave()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                '_id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Id tidak boleh kosong. ',
                    ]
                ],
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
                $response->message = $this->validator->getError('_id')
                    . $this->validator->getError('_nama')
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

                $id = htmlspecialchars($this->request->getVar('_id'), true);
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

                $oldData = $this->_db->table('_users_profile_sekolah')->where('user_id', $id)->get()->getRowObject();
                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data pengguna tidak ditemukan.";
                    return json_encode($response);
                }

                $date = date('Y-m-d H:i:s');
                $passwordHas = password_hash($password, PASSWORD_BCRYPT);
                $this->_db->transBegin();
                try {
                    $this->_db->table('_users_tb')->where('id', $oldData->user_id)->update([
                        'email' => $email,
                        'nohp' => $nohp,
                        'password' => $passwordHas,
                        'updated_at' => $date
                    ]);
                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->table('_users_profile_sekolah')->where('user_id', $oldData->user_id)->update([
                            'nama' => $nama,
                            'updated_at' => $date
                        ]);
                        if ($this->_db->affectedRows() > 0) {
                            $oldDataPanitia = $this->_db->table('panitia_ppdb')->where('id', $oldData->user_id,)->get()->getRowObject();
                            if ($oldData) {
                                $this->_db->table('panitia_ppdb')->where('id', $oldDataPanitia->id)->update([
                                    'sekolah_id' => $oldData->sekolah_id,
                                    'nama' => $nama,
                                    'jabatan' => $jabatan,
                                    'jabatan_ppdb' => $jabatan_ppdb,
                                    'updated_at' => $date
                                ]);
                            } else {
                                $this->_db->table('panitia_ppdb')->insert([
                                    'id' => $oldData->user_id,
                                    'sekolah_id' => $oldData->sekolah_id,
                                    'nama' => $nama,
                                    'jabatan' => $jabatan,
                                    'jabatan_ppdb' => $jabatan_ppdb,
                                    'created_at' => $date
                                ]);
                            }
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
