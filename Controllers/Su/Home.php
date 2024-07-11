<?php

namespace App\Controllers\Su;

use App\Controllers\BaseController;
use App\Libraries\Profilelib;
use App\Libraries\Helplib;
use App\Libraries\Uuid;

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
        return redirect()->to(base_url('su/home/data'));
    }

    public function data()
    {

        $Profilelib = new Profilelib();
        $user = $Profilelib->user();

        if (!$user || $user->status !== 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        // $layanan = json_decode(file_get_contents(FCPATH . "uploads/layanans_silastri.json"), true);
        // $data['layanans'] = [];
        // var_dump("PENG");
        // die;
        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        $data['title'] = 'Dashboard';
        return view('su/home/index', $data);
    }

    public function getAktivasiWa()
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

            if (!$user || $user->status !== 200) {
                session()->destroy();
                delete_cookie('jwt');
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session expired.";
                return json_encode($response);
            }

            if ($id == "wa") {
                $x['user'] = $user->data;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situgu/ptk/home/aktivasi/wa', $x);
                return json_encode($response);
            } else if ($id == "email") {
                $x['user'] = $user->data;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situgu/ptk/home/aktivasi/email', $x);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function kirimAktivasiWa()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'nomor' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nomor tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('nomor');
            return json_encode($response);
        } else {
            $nomor = htmlspecialchars($this->request->getVar('nomor'), true);

            $Profilelib = new Profilelib();
            $user = $Profilelib->user();

            if (!$user || $user->status !== 200) {
                session()->destroy();
                delete_cookie('jwt');
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session expired.";
                return json_encode($response);
            }

            if (substr($nomor, 0, 1) == 0) {
                $nomor = "+62" . substr($nomor, 1);
            }

            if (substr($nomor, 0, 1) == 8) {
                $nomor = "+62" . substr($nomor, 0);
            }

            if (substr($nomor, 0, 2) == 62) {
                $nomor = "+62" . substr($nomor, 2);
            }

            $kode = rand(1000, 9999);
            $nama = $user->data->fullname;
            $message = "Hallo *$nama*....!!!\n______________________________________________________\n\n*KODE AKTIVASI* untuk akun *SI-TUGU* anda adalah : \n*$kode*\n\n\nPesan otomatis dari *SI-TUGU Kab. Lampung Tengah*\n_________________________________________________";

            $dataReq = [
                'number' => (string)$nomor,
                'message' => $message,
            ];

            $ch = curl_init("https://whapi.kntechline.id/send-message");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataReq));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
            ));
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);

            $server_output = curl_exec($ch);
            if (curl_errno($ch)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->error = curl_error($ch);
                $response->message = "Gagal mengirim kode aktivasi.";
                return json_encode($response);
            }
            curl_close($ch);
            $sended = json_decode($server_output, true);

            if ($sended) {
                $x['user'] = $user->data;
                $x['nomor'] = $nomor;
                $x['kode_aktivasi'] = $kode;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situgu/ptk/home/aktivasi/kode', $x);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengirim kode aktivasi.";
                return json_encode($response);
            }
        }
    }

    public function verifiAktivasiWa()
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
            'nomor' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nomor tidak boleh kosong. ',
                ]
            ],
            'kode' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kode tidak boleh kosong. ',
                ]
            ],
            'fth' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kode tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('nomor')
                . $this->validator->getError('kode')
                . $this->validator->getError('fth');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $nomor = htmlspecialchars($this->request->getVar('nomor'), true);
            $kode = htmlspecialchars($this->request->getVar('kode'), true);
            $fth = htmlspecialchars($this->request->getVar('fth'), true);

            $Profilelib = new Profilelib();
            $user = $Profilelib->user();

            if (!$user || $user->status !== 200) {
                session()->destroy();
                delete_cookie('jwt');
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session expired.";
                return json_encode($response);
            }

            if ($kode === $fth) {
                $this->_db->transBegin();
                try {
                    $date = date('Y-m-d H:i:s');
                    $this->_db->table('_profil_users_tb')->where('id', $user->data->id)->update([
                        'no_hp' => $nomor,
                        'updated_at' => $date
                    ]);

                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->table('_users_tb')->where('id', $user->data->id)->update([
                            'wa_verified' => 1,
                            'updated_at' => $date
                        ]);
                        if ($this->_db->affectedRows() > 0) {
                            $this->_db->transCommit();
                            $response = new \stdClass;
                            $response->status = 200;
                            $response->message = "Berhasil memverifikasi nomor whatsapp.";
                            return json_encode($response);
                        } else {
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "Gagal menautkan nomor whatsapp.";
                            return json_encode($response);
                        }
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal menautkan nomor whatsapp.";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menautkan nomor whatsapp.";
                    return json_encode($response);
                }
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Kode verifikasi salah.";
                return json_encode($response);
            }
        }
    }

    public function phpinfo()
    {
        phpinfo();
    }

    public function getTokenSync()
    {
        $curlHandle = curl_init("http://118.98.237.214/v1/api-gateway/authenticate/authenticateV2/");
        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "GET");
        // curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        $username = getenv('lay.default.username');
        $password = getenv('lay.default.password');
        $authorization = base64_encode($username . ':' . $password); // Encode username:password

        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic ' . $authorization,
            'Content-Type: application/json' // Keep Content-Type if needed
        ));
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 30);

        $send_data         = curl_exec($curlHandle);

        $result = json_decode($send_data);

        if (isset($result->error)) {
            return $result->error;
        }

        if ($result) {
            if (isset($result->data)) {
                if (isset($result->data->token)) {
                    if ($result->data->token !== "") {
                        try {
                            $this->_db->table('aa_token_sync')->insert([
                                'id' => 1,
                                'token' => $result->data->token,
                            ]);
                            echo "GET TOKEN SUCCESS.";
                            var_dump($result);
                            die;
                        } catch (\Throwable $th) {
                            $dbError = $this->_db->error();
                            if (strpos($dbError['message'], 'Duplicate entry') !== false || strpos($dbError['message'], 'Key \'PRIMARY\'') !== false) {
                                $this->_db->table('aa_token_sync')->where('id', 1)->update([
                                    'token' => $result->data->token,
                                ]);
                            }
                            echo "GET TOKEN UPDATE.";
                            var_dump($result);
                            die;
                        }
                    } else {
                        echo "GET TOKEN.";
                        var_dump($result);
                        die;
                    }
                } else {
                    echo "GET TOKEN.";
                    var_dump($result);
                    die;
                }
            } else {
                echo "GET TOKEN.";
                var_dump($result);
                die;
            }
        } else {
            echo "GET TOKEN.";
            var_dump($send_data);
            die;
        }
    }

    public function synDataBalikan()
    {
        // set_time_limit(0);

        ob_start();
        $tokenSyn = $this->_db->table('aa_token_sync')->where('id', 1)->get()->getRowObject();
        if (!$tokenSyn) {
            echo "TOKEN SYNCRONE TIDAK ADA.";
            die;
        }
        echo $tokenSyn->token;
        echo "<br/>";
        $datas = $this->_db->table('data_balikan_via_api')->where("status_syn = 0 AND cant_sync = 0")->limit(50)->get()->getResult();
        if (count($datas) > 0) {
            foreach ($datas as $key => $value) {
                $this->_db->table('data_balikan_via_api')->where('id', $value->id)->update([
                    'has_syn' => 1,
                ]);
                $result = $this->sendDataBalikan($value, $tokenSyn->token);
                if (isset($result['status_sync'])) {
                    if ($result['status_sync'] == 1) {
                        echo "Berhasil Sync: $value->id<br/>";
                        var_dump($result['message']);
                        echo "<br/>";
                        ob_flush();
                        flush();
                        continue;
                    } else {
                        echo "Gagal Sync: $value->id<br/>";
                        var_dump($result['error']);
                        ob_flush();
                        flush();
                        die;
                    }
                } else {
                    echo "Gagal Sync: $value->id<br/>";
                    ob_flush();
                    flush();
                    die;
                }
            }
        } else {
            echo "TIDAK ADA DATA.";
            die;
        }
    }

    private function sendDataBalikan($data, $tokenBearer)
    {
        $data_peserta = [
            'token' => getenv('lay.default.token'),
            'peserta_didik_id' => $data->peserta_didik_id ?? NULL,
            'sekolah_id_asal' => $data->sekolah_id_asal ?? NULL,
            'npsn_sekolah_asal' => $data->npsn_sekolah_asal ?? NULL,
            'nama_sekolah_asal' => $data->nama_sekolah_asal ?? NULL,
            'nik' => $data->nik ?? NULL,
            'nisn' => $data->nisn ?? NULL,
            'nama' => $data->nama ?? NULL,
            'tempat_lahir' => $data->tempat_lahir ?? NULL,
            'tanggal_lahir' => $data->tanggal_lahir ?? NULL,
            'jenis_kelamin' => $data->jenis_kelamin ?? NULL,
            'nik_ibu' => $data->nik_ibu ?? NULL,
            'nama_ibu_kandung' => $data->nama_ibu_kandung ?? NULL,
            'nama_ayah' => $data->nama_ayah ?? NULL,
            'nik_ayah' => $data->nik_ayah ?? NULL,
            'nama_wali' => $data->nama_wali ?? NULL,
            'nik_wali' => $data->nik_wali ?? NULL,
            'alamat_jalan' => $data->alamat_jalan ?? NULL,
            'rt' => $data->rt ?? NULL,
            'rw' => $data->rw ?? NULL,
            'nama_dusun' => $data->nama_dusun ?? NULL,
            'desa_kelurahan' => $data->desa_kelurahan ?? NULL,
            'kode_wilayah_siswa' => $data->kode_wilayah_siswa ?? NULL,
            'lintang' => $data->lintang ?? NULL,
            'bujur' => $data->bujur ?? NULL,
            'kebutuhan_khusus_id' => $data->kebutuhan_khusus_id ?? NULL,
            'agama_id' => $data->agama_id ?? NULL,
            'no_kk' => $data->no_kk ?? NULL,
            'sekolah_id_tujuan' => $data->sekolah_id_tujuan ?? NULL,
            'npsn_sekolah_tujuan' => $data->npsn_sekolah_tujuan ?? NULL,
            'nama_sekolah_tujuan' => $data->nama_sekolah_tujuan ?? NULL
        ];


        // $tokenBearer = getenv('lay.default.token_bearer');

        $curlHandle = curl_init("http://118.98.237.214/v1/api-gateway/pd/tambahDataHasilPPDB");
        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, json_encode($data_peserta));
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $tokenBearer,
            'Content-Type: application/json'
        ));
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 30);

        $send_data         = curl_exec($curlHandle);

        $result = json_decode($send_data);

        if (isset($result->error)) {
            $gagal = [
                'status_sync' => 0,
                'error' => $result->error
            ];
            return $gagal;
        }

        if ($result) {

            if (isset($result->statusCode)) {
                if ((int)$result->statusCode == 200) {
                    $this->updateBerhasilSyn($data->id);
                    $this->deleteGagalSyn($data->id);
                    $sukses = [
                        'status_sync' => 1,
                        'message' => $result->message
                    ];
                    return $sukses;
                } else {
                    if ((int)$result->statusCode == 203) {
                        // $this->deleteGagalSyn($data->id);
                        $sukses = [
                            'status_sync' => 1,
                            'message' => $result->message
                        ];
                        return $sukses;
                    } else {
                        $this->insertGagalSyn($data->id, $data, $result->message);
                        $sukses = [
                            'status_sync' => 1,
                            'message' => $result->message
                        ];
                        return $sukses;
                    }
                }
            } else {
                $gagal = [
                    'status_sync' => 0,
                    'error' => $result
                ];
                return $gagal;
            }
        } else {
            $gagal = [
                'status_sync' => 0,
                'error' => $send_data
            ];
            return $gagal;
        }
    }

    private function insertGagalSyn($id, $data, $pesan)
    {
        $data_insert = [
            'id' => $id,
            'data_syn' => json_encode($data),
            'keterangan' => $pesan,
            'created_at' => date('Y-m-d H:i:s')
        ];

        try {
            $this->_db->table('aa_gagal_syn_balikan')->insert($data_insert);
        } catch (\Throwable $th) {
            $dbError = $this->_db->error();
            if (strpos($dbError['message'], 'Duplicate entry') !== false || strpos($dbError['message'], 'Key \'PRIMARY\'') !== false) {
                $this->_db->table('aa_gagal_syn_balikan')->where('id', $id)->update([
                    'data_syn' => json_encode($data),
                    'keterangan' => $pesan,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
        return true;
    }

    private function deleteGagalSyn($id)
    {
        $this->_db->table('aa_gagal_syn_balikan')->where('id', $id)->delete();
        return true;
    }

    private function updateBerhasilSyn($id)
    {
        $data_update = [
            'status_syn' => 1,
            'updated_syn' => date('Y-m-d H:i:s')
        ];

        return $this->_db->table('data_balikan_via_api')->where('id', $id)->update($data_update);
    }


    // public function synDataBalikan()
    // {
    //     // set_time_limit(0);

    //     ob_start();
    //     $tokenSyn = $this->_db->table('aa_token_sync')->where('id', 1)->get()->getRowObject();
    //     if (!$tokenSyn) {
    //         echo "TOKEN SYNCRONE TIDAK ADA.";
    //         die;
    //     }
    //     echo $tokenSyn->token;
    //     echo "<br/>";
    //     $datas = $this->_db->table('data_balikan_via_api')->where("cant_sync = 0")->where("id IN (SELECT id FROM aa_gagal_syn_balikan WHERE keterangan = 'Data terdeteksi sudah ada sebelumnya.')")->limit(50)->get()->getResult();
    //     // $subQuery = $this->_db->table('aa_gagal_syn_balikan')
    //     //     ->select('id')
    //     //     ->where('keterangan', 'Data terdeteksi sudah ada sebelumnya.')
    //     //     ->limit(50);

    //     // $datas = $this->_db->table('data_balikan_via_api')
    //     //     ->where('status_syn', 0)
    //     //     ->where('cant_sync', 0)
    //     //     ->whereIn('id', $subQuery)
    //     //     ->limit(50)
    //     //     ->get()
    //     //     ->getResult();
    //     if (count($datas) > 0) {
    //         foreach ($datas as $key => $value) {
    //             $this->_db->table('data_balikan_via_api')->where('id', $value->id)->update([
    //                 'has_syn' => 1,
    //             ]);
    //             $result = $this->sendDataBalikan($value, $tokenSyn->token);
    //             if (isset($result['status_sync'])) {
    //                 if ($result['status_sync'] == 1) {
    //                     echo "Berhasil Sync: $value->id<br/>";
    //                     var_dump($result['message']);
    //                     echo "<br/>";
    //                     ob_flush();
    //                     flush();
    //                     continue;
    //                 } else {
    //                     echo "Gagal Sync: $value->id<br/>";
    //                     var_dump($result['error']);
    //                     ob_flush();
    //                     flush();
    //                     die;
    //                 }
    //             } else {
    //                 echo "Gagal Sync: $value->id<br/>";
    //                 ob_flush();
    //                 flush();
    //                 die;
    //             }
    //         }
    //     } else {
    //         echo "TIDAK ADA DATA.";
    //         die;
    //     }
    // }

    // private function sendDataBalikan($data, $tokenBearer)
    // {
    //     $data_peserta = [
    //         'token' => getenv('lay.default.token'),
    //         'peserta_didik_id' => $data->peserta_didik_id ?? NULL,
    //         'sekolah_id_asal' => $data->sekolah_id_asal ?? NULL,
    //         'npsn_sekolah_asal' => $data->npsn_sekolah_asal ?? NULL,
    //         'nama_sekolah_asal' => $data->nama_sekolah_asal ?? NULL,
    //         'nik' => $data->nik ?? NULL,
    //         'nisn' => $data->nisn ?? NULL,
    //         'nama' => $data->nama ?? NULL,
    //         'tempat_lahir' => $data->tempat_lahir ?? NULL,
    //         'tanggal_lahir' => $data->tanggal_lahir ?? NULL,
    //         'jenis_kelamin' => $data->jenis_kelamin ?? NULL,
    //         'nik_ibu' => $data->nik_ibu ?? NULL,
    //         'nama_ibu_kandung' => $data->nama_ibu_kandung ?? NULL,
    //         'nama_ayah' => $data->nama_ayah ?? NULL,
    //         'nik_ayah' => $data->nik_ayah ?? NULL,
    //         'nama_wali' => $data->nama_wali ?? NULL,
    //         'nik_wali' => $data->nik_wali ?? NULL,
    //         'alamat_jalan' => $data->alamat_jalan ?? NULL,
    //         'rt' => $data->rt ?? NULL,
    //         'rw' => $data->rw ?? NULL,
    //         'nama_dusun' => $data->nama_dusun ?? NULL,
    //         'desa_kelurahan' => $data->desa_kelurahan ?? NULL,
    //         'kode_wilayah_siswa' => $data->kode_wilayah_siswa ?? NULL,
    //         'lintang' => $data->lintang ?? NULL,
    //         'bujur' => $data->bujur ?? NULL,
    //         'kebutuhan_khusus_id' => $data->kebutuhan_khusus_id ?? NULL,
    //         'agama_id' => $data->agama_id ?? NULL,
    //         'no_kk' => $data->no_kk ?? NULL,
    //         'sekolah_id_tujuan' => $data->sekolah_id_tujuan ?? NULL,
    //         'npsn_sekolah_tujuan' => $data->npsn_sekolah_tujuan ?? NULL,
    //         'nama_sekolah_tujuan' => $data->nama_sekolah_tujuan ?? NULL
    //     ];


    //     // $tokenBearer = getenv('lay.default.token_bearer');

    //     $curlHandle = curl_init("http://118.98.237.214/v1/api-gateway/pd/tambahDataHasilPPDB");
    //     curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "POST");
    //     curl_setopt($curlHandle, CURLOPT_POSTFIELDS, json_encode($data_peserta));
    //     curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array(
    //         'Authorization: Bearer ' . $tokenBearer,
    //         'Content-Type: application/json'
    //     ));
    //     curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
    //     curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 30);

    //     $send_data         = curl_exec($curlHandle);

    //     $result = json_decode($send_data);

    //     if (isset($result->error)) {
    //         $gagal = [
    //             'status_sync' => 0,
    //             'error' => $result->error
    //         ];
    //         return $gagal;
    //     }

    //     if ($result) {

    //         if (isset($result->statusCode)) {
    //             if ((int)$result->statusCode == 200) {
    //                 $this->updateBerhasilSyn($data->id);
    //                 $this->deleteGagalSyn($data->id);
    //                 $sukses = [
    //                     'status_sync' => 1,
    //                     'message' => $result->message
    //                 ];
    //                 return $sukses;
    //             } else {
    //                 if ((int)$result->statusCode == 203) {
    //                     $this->deleteGagalSyn($data->id);
    //                     $sukses = [
    //                         'status_sync' => 1,
    //                         'message' => $result->message
    //                     ];
    //                     return $sukses;
    //                 } else {
    //                     $this->insertGagalSyn($data->id, $data, $result->message);
    //                     $sukses = [
    //                         'status_sync' => 1,
    //                         'message' => $result->message
    //                     ];
    //                     return $sukses;
    //                 }
    //             }
    //         } else {
    //             $gagal = [
    //                 'status_sync' => 0,
    //                 'error' => $result
    //             ];
    //             return $gagal;
    //         }
    //     } else {
    //         $gagal = [
    //             'status_sync' => 0,
    //             'error' => $send_data
    //         ];
    //         return $gagal;
    //     }
    // }

}
