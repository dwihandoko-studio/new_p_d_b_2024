<?php

namespace App\Controllers\Su;

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

    public function testToken()
    {
        $curlHandle = curl_init("http://118.98.237.214/v1/api-gateway/authenticate/authenticateV2");
        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "GET");
        // curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        $username = 'ifkhar.halim@lampungtengahkab.go.id';
        $password = 'HalimGolok@123#';
        $authorization = base64_encode($username . ':' . $password); // Encode username:password

        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic ' . $authorization,
            'Content-Type: application/json' // Keep Content-Type if needed
        ));
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 30);

        $send_data         = curl_exec($curlHandle);

        $result = json_decode($send_data);

        return $send_data;

        if (isset($result->error)) {
            return $result->error;
        }

        if ($result) {
            return $result;
        } else {
            return $send_data;
        }
    }
}
