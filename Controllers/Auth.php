<?php

namespace App\Controllers;

use App\Models\AuthModel;
use Firebase\JWT\JWT;
use App\Libraries\Profilelib;
use App\Libraries\Auth\Authlib;
use setasign\Fpdi\TcpdfFpdi;

class Auth extends BaseController
{
    private $_db;
    function __construct()
    {
        helper(['text', 'file', 'form', 'cookie', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    public function index()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status == 200) {
            return redirect()->to(base_url('portal'));
        }
        set_cookie('containerLayout', 'full', strval(3600 * 24 * 1));
        set_cookie('layout', 'vertical', strval(3600 * 24 * 1));
        set_cookie('headerPosition', 'fixed', strval(3600 * 24 * 1));
        $data['title'] = "Login Layanan";
        return view('login/index', $data);
    }

    public function download()
    {
        $tiket = htmlspecialchars($this->request->getGet('t'), true);
        $oldData = $this->_db->table('dapo_peserta_pengajuan a')
            ->select("a.*, b.status")
            ->join('data_pengaduan b', 'b.no_tiket = a.id')
            ->where(['a.id' => $tiket, 'b.status' => 2])->get()->getRowObject();

        if (!$oldData) {
            return redirect()->to(base_url('home'));
        }

        $pd = $this->_db->table('_users_profile_pd a')
            ->select("c.username, b.peserta_didik_id, b.sekolah_id, b.nama, b.nisn, b.tempat_lahir, b.tanggal_lahir, b.jenis_kelamin, b.nik, a.user_id, a.nama_sekolah_asal, a.npsn_asal, a.acc_reg")
            ->join('dapo_peserta b', 'a.peserta_didik_id = b.peserta_didik_id')
            ->join('_users_tb c', 'a.user_id = c.id')
            ->where('a.peserta_didik_id', $oldData->peserta_didik_id)->get()->getRowObject();

        if (!$pd) {
            return redirect()->to(base_url('home'));
        }

        $html = '<table border="0">
                    <tr>
                        <td>Nama Peserta Didik</td>
                        <td colspan="2">: {{ nama_peserta }}</td>
                    </tr>
                    <tr>
                        <td>NISN</td>
                        <td>: {{ nisn_peserta }}</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>: {{ nik_peserta }}</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Sekolah Asal</td>
                        <td colspan="2">: {{ sekolah_asal_peserta }}</td>
                    </tr>
                    <tr>
                        <td>NPSN Asal</td>
                        <td>: {{ npsn_asal_peserta }}</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Tempat Lahir</td>
                        <td>: {{ tempat_lahir_peserta }}</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>: {{ tanggal_lahir_peserta }}</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>';

        $html1 = '<table>
                    <tr>
                        <td>Username</td>
                        <td>: <b>{{ username_peserta }}</b></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td>: <b>{{ password_peserta }}</b></td>
                        <td>&nbsp;</td>
                    </tr>
                </table>';
        $html2 = '<p><center>Akun peserta PPDB ini digunakan untuk pendaftaran<br />PPDB ke sekolah jenjang berikutnya melalui laman: <br /><b>https://ppdb.lampungtengahkab.go.id</b></center></p>';

        $html = str_replace('{{ nama_peserta }}', $pd->nama, $html);
        $html = str_replace('{{ nisn_peserta }}', $pd->nisn, $html);
        $html = str_replace('{{ nik_peserta }}', $pd->nik, $html);
        $html = str_replace('{{ sekolah_asal_peserta }}', $pd->nama_sekolah_asal, $html);
        $html = str_replace('{{ npsn_asal_peserta }}', $pd->npsn_asal, $html);
        $html = str_replace('{{ tempat_lahir_peserta }}', $pd->tempat_lahir, $html);
        $html = str_replace('{{ tanggal_lahir_peserta }}', $pd->tanggal_lahir, $html);

        $html1 = str_replace('{{ username_peserta }}', $pd->username, $html1);
        $html1 = str_replace('{{ password_peserta }}', $pd->acc_reg, $html1);

        $kop = '<table border="0">
                <tr>
                    <td width="17%" rowspan="4"><img src="https://ppdb.esline.id/favicon/apple-icon-120x120.png" style="width: 70px;" alt="Logo"></td>
                    <td width="83%">DINAS PENDIDIKAN DAN KEBUDAYAAN</td>
                </tr>
                <tr>
                    <td width="83%">KABUPATEN LAMPUNG TENGAH</td>
                </tr>
                <tr>
                    <td width="83%">PENERIMAAN PESERTA DIDIK BARU (PPDB)</td>
                </tr>
                <tr>
                    <td width="83%">TAHUN PELAJARAN 2024/2025</td>
                </tr>
            </table>';
        $pdf = new TcpdfFpdi('P', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Load HTML content
        $pdf->AddPage();
        $pdf->SetFont('times', 'B', 12);
        $pdf->MultiCell(180, 10, $kop, 0, 'C', false, 1, 20, null, true, 0, true);
        $pdf->MultiCell(180, 10, '<hr />', 0, 'C', false, 1, 20, null, true, 0, true);
        // $pdf->Cell(200, 10, 'KARTU AKUN PPDB KAB. LAMPUNG TENGAH TAHUN 2024/2025', 0, 1, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('times', 'N', 12);
        $pdf->MultiCell(180, 10, '<h4>DATA PESERTA DIDIK</h4>', 0, 'L', false, 1, 20, null, true, 0, true);
        $pdf->MultiCell(180, 10, $html, 0, 'L', false, 1, 20, null, true, 0, true);
        $pdf->Ln(10);
        $pdf->MultiCell(180, 10, '<h4>AKUN PESERTA PPDB</h4>', 0, 'L', false, 1, 20, null, true, 0, true);
        $pdf->MultiCell(180, 10, $html1, 0, 'L', false, 1, 20, null, true, 0, true);
        $pdf->Ln(20);
        $pdf->MultiCell(180, 10, $html2, 0, 'C', false, 1, 20, null, true, 0, true);
        $pdf->Ln(20);
        $pdf->MultiCell(70, 20, "PPDB Kab. Lampung Tengah,", 0, 'L', false, 1, 130, null, true, 0, true);
        $pdf->Ln(10);
        $pdf->MultiCell(70, 20, "Layanan Dari Pengaduan", 0, 'L', false, 1, 130, null, true, 0, true);

        // $pdf->WriteHTML($html);

        // Output PDF
        $dir = FCPATH . "uploads/temp";
        $filename = 'Akun_PPDB_' . $pd->nisn . '.pdf';
        $fileName = $dir . '/' . $filename;
        $pdf->Output($filename, 'D'); // Generate and save to temporary file

        // sleep(2);

        // $fileContent = file_get_contents($fileName);
        // $base64Data = base64_encode($fileContent);
        // unlink($fileName); // Delete the temporary file

        // $response = new \stdClass;
        // $response->status = 200;
        // $response->message = "Akun Berhasil Didownload.";
        // $response->data = $base64Data;
        // $response->filename = $filename;
        // return json_encode($response);
    }

    public function register()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status == 200) {
            return redirect()->to(base_url('home'));
        }

        $data['title'] = "Daftar";
        return view('register/index', $data);
    }

    public function saveregis()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status == 200) {
            return redirect()->to(base_url('home'));
        }
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            '_name' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong. ',
                ]
            ],
            '_no_hp' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'No handphone tidak boleh kosong. ',
                ]
            ],
            '_kode_pos' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kode pos tidak boleh kosong. ',
                ]
            ],
            '_alamat' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Alamat tidak boleh kosong. ',
                ]
            ],
            '_email' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Email tidak boleh kosong. ',
                ]
            ],
            '_password' => [
                'rules' => 'required|trim|min_length[6]',
                'errors' => [
                    'required' => 'Kata sandi tidak boleh kosong. ',
                    'min_length' => 'Panjang kata sandi minimal 6 karakter. ',
                ]
            ],
            '_repassword' => [
                'rules' => 'required|matches[_password]',
                'errors' => [
                    'required' => 'Ulangi kata sandi tidak boleh kosong. ',
                    'matches' => 'Ulangi kata sandi tidak sama. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = $this->validator->getError('_name')
                . $this->validator->getError('_no_hp')
                . $this->validator->getError('_kode_pos')
                . $this->validator->getError('_alamat')
                . $this->validator->getError('_email')
                . $this->validator->getError('_password')
                . $this->validator->getError('_repassword');
            return json_encode($response);
        } else {
            $name = htmlspecialchars($this->request->getVar('_name'), true);
            $no_hp = htmlspecialchars($this->request->getVar('_no_hp'), true);
            $kode_pos = htmlspecialchars($this->request->getVar('_kode_pos'), true);
            $alamat = htmlspecialchars($this->request->getVar('_alamat'), true);
            $email = htmlspecialchars($this->request->getVar('_email'), true);
            $password = htmlspecialchars($this->request->getVar('_password'), true);

            $cekData = $this->_db->table('_users_tb')->where('email', $email)->get()->getRowObject();

            if ($cekData) {
                $response = new \stdClass;
                $response->status = 204;
                $response->message = "Email sudah terdaftar, silahkan login ke aplikasi.";
                $response->redirect = base_url('auth');
                return json_encode($response);
            }

            $data = [
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'fullname' => $name,
                'no_hp' => $no_hp,
                'alamat' => $alamat,
                'kode_pos' => $kode_pos,
                'level' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->_db->transBegin();

            try {
                $this->_db->table('_users_tb')->insert($data);
            } catch (\Throwable $th) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Gagal mendaftarkan user.";
                return json_encode($response);
            }
            if ($this->_db->affectedRows() > 0) {
                $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
                $response->data = $data;
                $response->redirect = base_url('auth');
                $response->message = "Registrasi Berhasil. Selanjutnya silahkan login.";
                return json_encode($response);
            } else {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Gagal menyimpan user.";
                return json_encode($response);
            }
        }
    }
    public function login()
    {
        if (!($this->request->isAJAX())) {
            return redirect()->to(base_url('auth'));
        }
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status == 200) {
            return redirect()->to(base_url('home'));
        }

        $rules = [
            'username' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Username tidak boleh kosong. ',
                ]
            ],
            'password' => [
                'rules' => 'required|trim|min_length[6]',
                'errors' => [
                    'required' => 'Password tidak boleh kosong. ',
                    'min_length' => 'Panjang password minimal 6 karakter. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('username') . $this->validator->getError('password');
            return json_encode($response);
        } else {
            $username = htmlspecialchars($this->request->getVar('username'), true);
            $password = htmlspecialchars($this->request->getVar('password'), true);

            $authLib = new Authlib();
            $result = $authLib->postLogin($username, $password);

            if (!$result) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Username atau password salah.";
                return json_encode($response);
            }

            if (!($result->status == 200)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $result->message;
                return json_encode($response);
            }

            // $authLib = new AuthModel($this->_db);
            // $result = $authLib->getUsername($username);

            // if (!$result) {
            //     $response = new \stdClass;
            //     $response->status = 400;
            //     $response->message = "Username atau password salah.";
            //     return json_encode($response);
            // }

            // if (!(password_verify($password, $result->password))) {
            //     $response = new \stdClass;
            //     $response->status = 400;
            //     $response->message = "Username atau password salah.";
            //     return json_encode($response);
            // }

            // if ((int)$result->is_active !== 1) {
            //     $response = new \stdClass;
            //     $response->status = 400;
            //     $response->message = "Account anda telah di suspend, silahkan hubungi superadmin.";
            //     return json_encode($response);
            // }

            // $token_jwt = getenv('token_jwt.default.key');

            // $issuer_claim = "THE_CLAIM"; // this can be the servername. Example: https://domain.com
            // $audience_claim = "THE_AUDIENCE";
            // $issuedat_claim = time(); // issued at
            // $notbefore_claim = $issuedat_claim; //not before in seconds
            // $expire_claim = $issuedat_claim + (3600 * 24); // expire time in seconds
            // $token = array(
            //     "iss" => $issuer_claim,
            //     "aud" => $audience_claim,
            //     "iat" => $issuedat_claim,
            //     "nbf" => $notbefore_claim,
            //     "exp" => $expire_claim,
            //     "data" => array(
            //         "id" => $result->uid,
            //         "level" => (int)$result->level,
            //     )
            // );

            // $token = JWT::encode($token, $token_jwt, 'HS256');
            set_cookie('jwt', $result->data->access_token, strval(3600 * 24 * 1));

            $response = new \stdClass;
            $response->status = 200;
            $response->message = 'Login berhasil.';
            // if ((int)$result->level == 1) {
            $response->url = base_url('portal');
            // } else if ((int)$result->level == 2) {
            //     $response->redirect = base_url('sp/home');
            // } else if ((int)$result->level == 3) {
            //     $response->redirect = base_url('bp/home');
            // } else {
            //     $response->redirect = base_url('p/home');
            // }
            return json_encode($response);
        }
    }

    // public function resetpassword()
    // {
    //     if ($this->request->getMethod() != 'post') {
    //         $data['title'] = "Reset Password";
    //         return view('login/resetpassword', $data);
    //     }

    //     $rules = [
    //         'email' => 'required|trim',
    //     ];

    //     if (!$this->validate($rules)) {
    //         // $data = new \stdClass;
    //         $data['title'] = "Reset Password";
    //         $data['error'] = $this->validator->getError('email');
    //         return view('login/resetpassword', $data);
    //     } else {
    //         $username = htmlspecialchars($this->request->getVar('email'), true);

    //         $authLib = new Authlib();
    //         $result = $authLib->cekUser($username);
    //         if ($result->code == 200) {
    //             $data['title'] = "Reset Password";
    //             return view('login/sukses', $data);
    //         } else {
    //             $data['title'] = "Reset Password";
    //             $data['error'] = "Username tidak terdaftar atau belum terverifikasi.";
    //             return view('login/resetpassword', $data);
    //         }
    //     }
    // }

    // public function newpassword()
    // {
    //     if (!$this->request->getGet('token')) {
    //         return view('404');
    //     }

    //     if ($this->request->getMethod() != 'post') {
    //         $data['user'] = htmlspecialchars($this->request->getGet('token'), true);

    //         $data['title'] = "Buat Password Baru";
    //         // $data['error'] = "Username tidak terdaftar atau belum terverifikasi.";
    //         return view('login/newpassword', $data);
    //     } else {
    //         $rules = [
    //             'token' => 'required|trim',
    //             'newPassword' => 'required|trim',
    //             'retypeNewPassword' => 'matches[newPassword]',
    //         ];

    //         if (!$this->validate($rules)) {
    //             // $data = new \stdClass;
    //             $data['user'] = htmlspecialchars($this->request->getGet('user'), true);
    //             $data['title'] = "Ganti Password";
    //             $data['error'] = $this->validator->getError('retypeNewPassword');
    //             return view('login/newpassword', $data);
    //         } else {
    //             $pass = htmlspecialchars($this->request->getVar('newPassword'), true);
    //             $token = htmlspecialchars($this->request->getVar('token'), true);

    //             $authLib = new Authlib();
    //             $result = $authLib->changePassword($token, $pass);

    //             if ($validationToken->code == 200) {
    //                 $data['title'] = "Ganti Password";
    //                 $data['message'] = "Ganti password akun berhasil.";
    //                 $data['url'] = base_url();
    //                 return view('login/sukses', $data);
    //             } else if ($validationToken->code == 401) {
    //                 $data['user'] = htmlspecialchars($this->request->getGet('user'), true);
    //                 $data['title'] = "Ganti Password";
    //                 $data['error'] = $validationToken->message;
    //                 return view('login/newpassword', $data);
    //             } else {
    //                 $data['user'] = htmlspecialchars($this->request->getGet('user'), true);
    //                 $data['title'] = "Ganti Password";
    //                 $data['error'] = $validationToken->message;
    //                 return view('login/newpassword', $data);
    //             }
    //         }
    //     }
    // }

    public function logout()
    {
        delete_cookie('jwt');
        session()->destroy();
        $response = new \stdClass;
        $response->code = 200;
        $response->message = "Anda berhasil logout.";
        $response->url = base_url();
        return json_encode($response);
    }
}
