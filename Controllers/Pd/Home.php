<?php

namespace App\Controllers\Pd;

use App\Controllers\BaseController;
use App\Libraries\Profilelib;
use App\Libraries\Helplib;
use App\Libraries\Ppdb\Datalib;
use setasign\Fpdi\TcpdfFpdi;

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
        return redirect()->to(base_url('pd/home/data'));
    }

    public function data()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->userPd();

        if (!$user || $user->status !== 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        // if ($user->data->image == NULL || $user->data->image == "") {
        if ($user->data->updated_at == NULL || $user->data->updated_at == "") {
            $data['firs_login'] = true;
        } else {
            $data['firs_login'] = false;

            $hasRegister = new \stdClass;

            $dataLib = new Datalib();
            $cekAvailableRegistered = $dataLib->cekAlreadyRegistered($user->data->peserta_didik_id);

            if ($cekAvailableRegistered) {
                if ((int)$cekAvailableRegistered->status_pendaftaran !== 3) {
                    switch ((int)$cekAvailableRegistered->status_pendaftaran) {
                        case 1:
                            $hasRegister->message = "Anda sudah melakukan pendaftaran dan telah diverifikasi berkas. Silahkan menunggu pengumuman PPDB pada tanggal yang telah di tentukan.";
                            break;
                        case 2:
                            $hasRegister->message = "Anda dinyatakan <b>LOLOS</b> pada seleksi PPDB Tahun Ajaran 2024/2025 <br/> Melalui Jalur <b>" . $cekAvailableRegistered->via_jalur . "</b>. <br/>Selanjutnya silahkan melakukan konfirmasi dan daftar ulang ke Sekolah Tujuan <br>sesuai jadwal yang telah ditentukan.";
                            break;

                        default:
                            $hasRegister->message = "Anda sudah melakukan pendaftaran lewat jalur <b>'{$cekAvailableRegistered->via_jalur}'</b> dan dalam status menunggu verifikasi berkas.";
                            break;
                    }
                    $hasRegister->koreg = $cekAvailableRegistered->kode_pendaftaran;

                    $data['hasRegister'] = $hasRegister;
                } else {
                    $data['tertolakVerifikasi'] = "Pendaftaran anda melalui jalur $cekAvailableRegistered->via_jalur ditolak dengan keterangan: $cekAvailableRegistered->keterangan_penolakan.";
                }
            }

            $cekAlreadyRegisteredTertolak = $dataLib->cekAlreadyRegisteredTertolak($user->data->peserta_didik_id);
            if ($cekAlreadyRegisteredTertolak) {
                if ((int)$cekAlreadyRegisteredTertolak->status_pendaftaran === 3) {
                    $data['tertolakVerifikasi'] = "Pendaftaran anda melalui jalur $cekAlreadyRegisteredTertolak->via_jalur ke $cekAlreadyRegisteredTertolak->nama_sekolah_tujuan ditolak verifikasi oleh panitia dengan keterangan: $cekAlreadyRegisteredTertolak->keterangan_penolakan.";
                }
            }

            $cekAvailableRegisteredTidakLolos = $dataLib->cekAlreadyRegisteredTidakLolosAfirmasi($user->data->peserta_didik_id);
            if ($cekAvailableRegisteredTidakLolos) {
                if ($cekAvailableRegisteredTidakLolos->via_jalur === "AFIRMASI") {
                    $hasRegisterTidakLolos = new \stdClass;
                    $hasRegisterTidakLolos->message = "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . $cekAvailableRegisteredTidakLolos->nama_sekolah_tujuan . "(" . $cekAvailableRegisteredTidakLolos->npsn_sekolah_tujuan . ")</b> Melalui Jalur <b>" . $cekAvailableRegisteredTidakLolos->via_jalur . "</b>. <br/>Selanjutnya anda dapat mendaftar kembali menggunakan jalur yang lain (ZONASI, PRESTASI, MUTASI)";
                    $data['hasTidakLolosAfirmasi'] = $hasRegisterTidakLolos;
                }
            }
        }

        $data['informasis'] = $this->_db->table('doc_informasi')->where("tujuan IS NULL OR tujuan IN (5)")->get()->getResult();

        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        $data['title'] = 'Dashboard';

        return view('pd/home/index', $data);
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
                $user = $Profilelib->userPd();
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
                $response->data = view('pd/home/edit', $x);
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
                '_file' => [
                    'rules' => 'uploaded[_file]|max_size[_file,5048]|mime_in[_file,image/jpeg,image/jpg,image/png]',
                    'errors' => [
                        'uploaded' => 'Pilih file terlebih dahulu. ',
                        'max_size' => 'Ukuran file terlalu besar, Maximum 2 Mb. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar. '
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_nama')
                    . $this->validator->getError('_email')
                    . $this->validator->getError('_nohp')
                    . $this->validator->getError('_file');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->userPd();
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

                $dir = FCPATH . "uploads/user";
                $field_db = 'image';
                $table_db = '_users_profile_pd';

                $lampiran = $this->request->getFile('_file');
                $filesNamelampiran = $lampiran->getName();
                $newNamelampiran = _create_name_file($filesNamelampiran, "user-");

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


                $oldData = $this->_db->table('_users_profile_pd')->where('user_id', $user->data->id)->get()->getRowObject();
                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data pengguna tidak ditemukan.";
                    return json_encode($response);
                }

                $date = date('Y-m-d H:i:s');
                $this->_db->transBegin();
                try {
                    $this->_db->table('_users_tb')->where('id', $oldData->user_id)->update([
                        'email' => $email,
                        'nohp' => $nohp,
                        'updated_at' => $date
                    ]);
                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->table('_users_profile_pd')->where('user_id', $oldData->user_id)->update([
                            'nama' => $nama,
                            'image' => $data['image'],
                            'updated_at' => $date
                        ]);
                        if ($this->_db->affectedRows() > 0) {
                            $this->_db->transCommit();

                            $response = new \stdClass;
                            $response->status = 200;
                            $response->url = base_url('portal');
                            $response->message = "Data berhasil diupdate.";
                            return json_encode($response);
                        } else {
                            unlink($dir . '/' . $newNamelampiran);
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "Gagal mengupdate data.";
                            return json_encode($response);
                        }
                    } else {
                        unlink($dir . '/' . $newNamelampiran);
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal mengupdate data.";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    unlink($dir . '/' . $newNamelampiran);
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

    public function download()
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
                $user = $Profilelib->userPd();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session expired";
                    return json_encode($response);
                }

                $dataLib = new Datalib();
                $pendaftaran = $dataLib->cekAlreadyRegistered($user->data->peserta_didik_id);
                if (!$pendaftaran) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Pendaftaran tidak ditemukan.";
                    return json_encode($response);
                }

                $jadwalVerifi = $this->_db->table('_setting_jadwal_tb')->where('id', strtolower($pendaftaran->via_jalur))->get()->getRowObject();

                $html = '<table border="0">
                        <tr>
                            <td>Nomor Pendaftaran</td>
                            <td colspan="2">: <b>{{ no_pendaftaran }}</b></td>
                        </tr>
                        <tr>
                            <td>Nama Peserta</td>
                            <td colspan="2">: {{ nama_peserta }}</td>
                        </tr>
                        <tr>
                            <td>NISN Peserta</td>
                            <td colspan="2">: {{ nisn_peserta }}</td>
                        </tr>
                        <tr>
                            <td>Tempat & Tanggal Lahir</td>
                            <td colspan="2">: {{ ttl_peserta }}</td>
                        </tr>
                        <tr>
                            <td>Sekolah Asal</td>
                            <td colspan="2">: {{ sekolah_asal_peserta }}</td>
                        </tr>
                        <tr>
                            <td>NPSN Sekolah Asal</td>
                            <td colspan="2">: {{ npsn_asal_peserta }}</td>
                        </tr>
                        <tr>
                            <td>Alamat Peserta</td>
                            <td colspan="2">: {{ alamat_peserta }}</td>
                        </tr>
                    </table>';

                $html1 = '<table>
                        <tr>
                            <td>Sekolah Tujuan</td>
                            <td colspan="2">: <b>{{ sekolah_tujuan }}</b></td>
                        </tr>
                        <tr>
                            <td>NPSN Sekolah Tujuan</td>
                            <td colspan="2">: {{ npsn_sekolah_tujuan }}</td>
                        </tr>
                        <tr>
                            <td>Jalur PPDB</td>
                            <td colspan="2">: {{ jalur_ppdb }}</td>
                        </tr>
                        <tr>
                            <td>Jarak Domisili dengan Sekolah</td>
                            <td colspan="2">: {{ jarak_sekolah }} Km</td>
                        </tr>
                    </table>';

                $qrCode = $this->downloadImageFromUrl("https://qrcode.esline.id/generate?data=https://ppdb.lampungtengahkab.go.id/home/qrcode?t=$pendaftaran->kode_pendaftaran");

                // $ch = curl_init();
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // $imageData = curl_exec($ch);
                // curl_close($ch);

                // $dirQr = FCPATH . "uploads/temp";
                // $fileNameQr = $dirQr . '/' . $pendaftaran->kode_pendaftaran . '.png';
                // file_put_contents($fileNameQr, $imageData);
                sleep(1);

                $html2 = '<table>
                    <tr>
                        <td colspan="3">
                            <ol>
                                <li>Kartu Peserta ini dibawa pada saat verifikasi dokumen pendaftaran ke sekolah tujuan</li>
                                <li>Jadwal Verifikasi Dokumen Pendaftaran ' . $pendaftaran->via_jalur . ' tanggal ' . tgl_indo($jadwalVerifi->tgl_awal_verifikasi) . ' s/d ' . tgl_indo($jadwalVerifi->tgl_akhir_verifikasi) . '</li>
                                <li>Pastikan Peserta sudah mengajukan verifikasi dokumen pendaftaran sesuai jadwal</li>
                            </ol>
                        </td>
                        <td><img src="' . $qrCode . '" style="width: 80px;" alt="Logo"></td>
                    </tr>
                </table>';

                // $html2 = str_replace('{{ no_pendaftaran }}', $pendaftaran->kode_pendaftaran, $html2);

                $html = str_replace('{{ no_pendaftaran }}', $pendaftaran->kode_pendaftaran, $html);
                $html = str_replace('{{ nama_peserta }}', $pendaftaran->nama_peserta, $html);
                $html = str_replace('{{ nisn_peserta }}', $pendaftaran->nisn_peserta, $html);
                $html = str_replace('{{ ttl_peserta }}', ucwords(strtolower($pendaftaran->tempat_lahir_peserta)) . ', ' . tgl_indo($pendaftaran->tanggal_lahir_peserta), $html);
                $html = str_replace('{{ sekolah_asal_peserta }}', $pendaftaran->nama_sekolah_asal, $html);
                $html = str_replace('{{ npsn_asal_peserta }}', $pendaftaran->npsn_sekolah_asal, $html);
                $html = str_replace('{{ alamat_peserta }}', getNameDusun($pendaftaran->dusun_peserta) . ', ' . getNameKelurahan($pendaftaran->kel_peserta) . '<br/>&nbsp;&nbsp;' . getNameKecamatan($pendaftaran->kec_peserta) . ', Kab. ' . getNameKabupaten($pendaftaran->kab_peserta), $html);
                // $html1 = str_replace('{{ username_peserta }}', $pd->nisn, $html1);
                $html1 = str_replace('{{ sekolah_tujuan }}', $pendaftaran->nama_sekolah_tujuan, $html1);
                $html1 = str_replace('{{ npsn_sekolah_tujuan }}', $pendaftaran->npsn_sekolah_tujuan, $html1);
                $html1 = str_replace('{{ jalur_ppdb }}', $pendaftaran->via_jalur, $html1);
                $html1 = str_replace('{{ jarak_sekolah }}', round($pendaftaran->jarak_domisili, 3), $html1);

                // $kop = '<table border="0">
                //     <tr>
                //         <td width="17%" rowspan="4"><img src="https://ppdb.esline.id/favicon/apple-icon-120x120.png" style="width: 70px;" alt="Logo"></td>
                //         <td width="83%">DINAS PENDIDIKAN DAN KEBUDAYAAN</td>
                //     </tr>
                //     <tr>
                //         <td width="83%">KABUPATEN LAMPUNG TENGAH</td>
                //     </tr>
                //     <tr>
                //         <td width="83%">PENERIMAAN PESERTA DIDIK BARU (PPDB)</td>
                //     </tr>
                //     <tr>
                //         <td width="83%">TAHUN PELAJARAN 2024/2025</td>
                //     </tr>
                // </table>';
                $pdf = new TcpdfFpdi('P', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

                // Load HTML content
                $pdf->AddPage();
                // $pdf->SetFont('times', 'B', 12);
                $pdf->SetFont('times', 'B', 12);
                // $pdf->MultiCell(180, 10, $kop, 0, 'C', false, 1, 20, null, true, 0, true);
                // $pdf->MultiCell(180, 10, '<hr />', 0, 'C', false, 1, 20, null, true, 0, true);
                // $pdf->Cell(200, 10, 'KARTU AKUN PPDB KAB. LAMPUNG TENGAH TAHUN 2024/2025', 0, 1, 'C');
                $pdf->MultiCell(180, 5, '<h4>KARTU PENDAFTARAN</h4>', 0, 'C', false, 1, 20, null, true, 0, true);
                $pdf->MultiCell(180, 5, '<h4>PPDB KABUPATEN LAMPUNG TENGAH</h4>', 0, 'C', false, 1, 20, null, true, 0, true);
                $pdf->MultiCell(180, 5, '<h4>TAHUN PELAJARAN 2024/2025</h4>', 0, 'C', false, 1, 20, null, true, 0, true);
                $pdf->Ln(10);
                $pdf->SetFont('times', 'N', 12);
                $pdf->MultiCell(180, 10, $html, 0, 'L', false, 1, 20, null, true, 0, true);
                $pdf->Ln(5);
                $pdf->MultiCell(180, 10, $html1, 0, 'L', false, 1, 20, null, true, 0, true);
                $pdf->Ln(5);
                $pdf->MultiCell(180, 1, '<hr />', 0, 'C', false, 1, 20, null, true, 0, true);
                // $pdf->Ln(5);
                $pdf->MultiCell(180, 5, $html2, 0, 'C', false, 1, 20, null, true, 0, true);
                // $pdf->Ln(20);
                // $pdf->MultiCell(70, 20, "OPERATOR {$pd->nama_sekolah_asal}", 0, 'L', false, 1, 130, null, true, 0, true);
                // $pdf->Ln(10);
                // $pdf->MultiCell(70, 20, $user->data->nama, 0, 'L', false, 1, 130, null, true, 0, true);

                // $pdf->WriteHTML($html);

                // Output PDF
                $dir = FCPATH . "uploads/temp";
                $filename = 'PENDAFTARAN_PPDB_' . $pendaftaran->via_jalur . '_' . $pendaftaran->nisn_peserta . '.pdf';
                $fileName = $dir . '/' . $filename;
                $pdf->Output($fileName, 'F'); // Generate and save to temporary file

                sleep(2);

                $fileContent = file_get_contents($fileName);
                $base64Data = base64_encode($fileContent);
                unlink($fileName); // Delete the temporary file
                // unlink($qrCode); // Delete the temporary file

                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Akun Berhasil Didownload.";
                $response->data = $base64Data;
                $response->filename = $filename;
                return json_encode($response);
                // } else {
                //     $response = new \stdClass;
                //     $response->status = 400;
                //     $response->message = "Gagal mengenerate data.";
                //     return json_encode($response);
                // }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    private function downloadImageFromUrl($url)
    {
        // Set a temporary directory for downloaded images
        // $tempDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'pdf_images';

        // // Create the temporary directory if it doesn't exist
        // if (!is_dir($tempDir)) {
        //     if (!mkdir($tempDir, 0755, true)) {
        //         throw new \Exception("Failed to create temporary directory: $tempDir");
        //     }
        // }

        $tempDir = FCPATH . "uploads/temp";

        // Get the file extension from the URL (if available)
        //   $urlParts = explode('.', $url);
        //   $extension = end($urlParts);

        // Generate a unique filename based on the URL and current timestamp
        $filename = md5($url . microtime()) . '.png';

        // Create the full path to the downloaded image
        $filePath = $tempDir . DIRECTORY_SEPARATOR . $filename;

        // Download the image using cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);  // Follow redirects
        curl_setopt($ch, CURLOPT_FILE, fopen($filePath, 'w'));  // Write to file

        $success = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($success === false) {
            throw new \Exception("Failed to download image: $curlError");
        }

        // Return the path to the downloaded image
        return $filePath;
    }
}
