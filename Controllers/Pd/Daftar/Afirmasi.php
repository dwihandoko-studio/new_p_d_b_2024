<?php

namespace App\Controllers\Pd\Daftar;

use App\Controllers\BaseController;
use App\Libraries\Profilelib;
use App\Libraries\Helplib;
use App\Libraries\Ppdb\Datalib;
use App\Libraries\Ppdb\Pd\Riwayatlib;
use App\Libraries\Uuid;
use setasign\Fpdi\TcpdfFpdi;

class Afirmasi extends BaseController
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

    public function index()
    {
        return redirect()->to(base_url('pd/daftar/afirmasi/data'));
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
            return redirect()->to(base_url('pd/home'));
        }

        $dataLib = new Datalib();
        $cekAvailableRegistered = $dataLib->cekAlreadyRegistered($user->data->peserta_didik_id);
        if ($cekAvailableRegistered) {
            if ((int)$cekAvailableRegistered->status_pendaftaran !== 3) {
                switch ((int)$cekAvailableRegistered->status_pendaftaran) {
                    case 1:
                        $data['message'] = "Anda sudah melakukan pendaftaran dan telah diverifikasi berkas. Silahkan menunggu pengumuman PPDB pada tanggal yang telah di tentukan.";
                        break;
                    case 2:
                        $data['message'] = "Anda dinyatakan <b>LOLOS</b> pada seleksi PPDB Tahun Ajaran 2024/2025 <br/> Melalui Jalur <b>" . $cekAvailableRegistered->via_jalur . "</b>. <br/>Selanjutnya silahkan melakukan konfirmasi dan daftar ulang ke Sekolah Tujuan <br>sesuai jadwal yang telah ditentukan.";
                        break;

                    default:
                        $data['message'] = "Anda sudah melakukan pendaftaran lewat jalur <b>'{$cekAvailableRegistered->via_jalur}'</b> dan dalam status menunggu verifikasi berkas.";
                        break;
                }
                $data['user'] = $user->data;
                $data['level'] = $user->level;
                $data['level_nama'] = $user->level_nama;
                $data['koreg'] = $cekAvailableRegistered->kode_pendaftaran;
                $data['title'] = 'Dashboard';

                return view('pd/daftar/afirmasi/index_hasregister', $data);
            }
        }

        $dataLib = new Datalib();
        $canDaftar = $dataLib->canRegister("afirmasi");
        if ($canDaftar->code !== 200) {
            $data['error_tutup'] = $canDaftar->message . " untuk <b>Jalur Afirmasi</b>.";
        }

        $canVerifiUmur = $dataLib->verifiUmur($user->data->peserta_didik_id);
        if ($canVerifiUmur->code !== 200) {
            if ($canVerifiUmur->code !== 201) {
                $data['error_umur'] = $canVerifiUmur->message;
            } else {
                $data['pengecualian_umur'] = $canVerifiUmur->message;
            }
        }

        $dataPd = $this->_db->table('dapo_peserta a')
            ->select("a.*, b.nama as sekolah_asal, b.npsn as npsn_asal")
            ->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id')
            ->where('a.peserta_didik_id', $user->data->peserta_didik_id)->get()->getRowObject();

        if (!$dataPd) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }
        $data['data'] = $dataPd;

        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        $data['title'] = 'Data Peserta';

        return view('pd/daftar/index_detail', $data);
    }

    public function nextdata()
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
            return redirect()->to(base_url('pd/home'));
        }

        $dataLib = new Datalib();
        $cekAvailableRegistered = $dataLib->cekAlreadyRegistered($user->data->peserta_didik_id);
        if ($cekAvailableRegistered) {
            if ((int)$cekAvailableRegistered->status_pendaftaran !== 3) {
                switch ((int)$cekAvailableRegistered->status_pendaftaran) {
                    case 1:
                        $data['message'] = "Anda sudah melakukan pendaftaran dan telah diverifikasi berkas. Silahkan menunggu pengumuman PPDB pada tanggal yang telah di tentukan.";
                        break;
                    case 2:
                        $data['message'] = "Anda dinyatakan <b>LOLOS</b> pada seleksi PPDB Tahun Ajaran 2024/2025 <br/> Melalui Jalur <b>" . $cekAvailableRegistered->via_jalur . "</b>. <br/>Selanjutnya silahkan melakukan konfirmasi dan daftar ulang ke Sekolah Tujuan <br>sesuai jadwal yang telah ditentukan.";
                        break;

                    default:
                        $data['message'] = "Anda sudah melakukan pendaftaran lewat jalur <b>'{$cekAvailableRegistered->via_jalur}'</b> dan dalam status menunggu verifikasi berkas.";
                        break;
                }
                $data['user'] = $user->data;
                $data['level'] = $user->level;
                $data['level_nama'] = $user->level_nama;
                $data['koreg'] = $cekAvailableRegistered->kode_pendaftaran;
                $data['title'] = 'Dashboard';

                return view('pd/daftar/afirmasi/index_hasregister', $data);
            }
        }

        $dataLib = new Datalib();
        $canDaftar = $dataLib->canRegister("afirmasi");
        if ($canDaftar->code !== 200) {
            $data['error_tutup'] = $canDaftar->message . " untuk <b>Jalur Afirmasi</b>.";
        }

        $canVerifiUmur = $dataLib->verifiUmur($user->data->peserta_didik_id);
        if ($canVerifiUmur->code !== 200) {
            if ($canVerifiUmur->code !== 201) {
                $data['error_umur'] = $canVerifiUmur->message;
            } else {
                $data['pengecualian_umur'] = $canVerifiUmur->message;
            }
        }

        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        $data['title'] = 'Dashboard';
        $data['kecamatans'] = $this->_db->table('ref_kecamatan')->where('id_kabupaten', '120200')->orderBy('nama', 'ASC')->get()->getResult();

        return view('pd/daftar/afirmasi/index', $data);
    }

    public function validasiData()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'email' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Email tidak boleh kosong. ',
                    ]
                ],
                'nohp' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nohp tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('email')
                    . $this->validator->getError('nohp');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->userPd();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session telah habis";
                    return json_encode($response);
                }

                $email = htmlspecialchars($this->request->getVar('email'), true);
                $nohp = htmlspecialchars($this->request->getVar('nohp'), true);

                if ($email == $user->data->email && $nohp == $user->data->nohp) {
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->url = base_url('pd/daftar/afirmasi/nextdata');
                    $response->message = "Data berhasil diupdate.";
                    return json_encode($response);
                }

                $date = date('Y-m-d H:i:s');
                $this->_db->transBegin();
                try {
                    $this->_db->table('_users_tb')->where('id', $user->data->id)->update([
                        'email' => $email,
                        'nohp' => $nohp,
                        'updated_at' => $date
                    ]);
                    if ($this->_db->affectedRows() > 0) {

                        $this->_db->transCommit();

                        $response = new \stdClass;
                        $response->status = 200;
                        $response->url = base_url('pd/daftar/afirmasi/nextdata');
                        $response->message = "Data berhasil diupdate.";
                        return json_encode($response);
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal mengkonfirmasi data.";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal Gagal mengkonfirmasi data. with error";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function changedKec()
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
                $user = $Profilelib->userPd();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session telah habis";
                    return json_encode($response);
                }

                $dataLib = new Datalib();
                $canDaftar = $dataLib->canRegister("afirmasi");
                if ($canDaftar->code !== 200) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = $canDaftar->message . " untuk <b>Jalur Afirmasi</b>.";
                    return json_encode($response);
                }

                $canVerifiUmur = $dataLib->verifiUmur($user->data->peserta_didik_id);
                if ($canVerifiUmur->code !== 200) {
                    if ($canVerifiUmur->code !== 201) {
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = $canDaftar->message;
                        return json_encode($response);
                    } else {
                    }
                }

                $kec = htmlspecialchars($this->request->getVar('id'), true);

                $userPd = $this->_db->table('dapo_peserta')->where('peserta_didik_id', $user->data->peserta_didik_id)->get()->getRowObject();
                if (!$userPd) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data peserta tidak ditemukan.";
                    return json_encode($response);
                }

                if (tingkatPendidikanInArray($user->data->tingkat_pendidikan_asal)) {
                    $andWhere = " AND (b.bentuk_pendidikan_id IN (6,10,31,32,33,35,36))";
                } else {
                    $andWhere = " AND (b.bentuk_pendidikan_id IN (5,9,30,31,32,33,38))";
                }

                $current = $this->_db->table('_setting_kuota_tb a')
                    ->select("a.sekolah_id, a.afirmasi, b.nama, b.npsn, b.status_sekolah_id, b.lintang, b.bujur, b.alamat_jalan, b.desa_kelurahan, b.kecamatan, ROUND(getDistanceKm(b.lintang,b.bujur,'{$userPd->lintang}','{$userPd->bujur}'), 2) AS distance_in_km")
                    // ->select("a.sekolah_id, a.afirmasi, b.nama, b.npsn, b.status_sekolah_id, b.lintang, b.bujur, b.alamat_jalan, b.desa_kelurahan, b.kecamatan, DEGREES(ACOS(LEAST(1.0, COS(RADIANS(b.lintang)) * COS(RADIANS({$userPd->lintang})) * COS(RADIANS(b.bujur - {$userPd->bujur})) + SIN(RADIANS(b.lintang)) * SIN(RADIANS({$userPd->lintang}))))) AS distance_in_km")
                    ->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id')
                    ->where("b.status_sekolah_id = '1' AND LEFT(b.kode_wilayah,6) = '$kec' $andWhere")
                    ->orderBy('distance_in_km', 'ASC')
                    ->get()->getResult();

                if (count($current) > 0) {
                    $x['data'] = $current;
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Permintaan diizinkan";
                    $response->data = view('pd/daftar/afirmasi/pilihan', $x);
                    return json_encode($response);
                } else {
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Permintaan diizinkan";
                    $response->data = view('pd/daftar/pilihan_zonk');
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function pilihsekolah()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'id tidak boleh kosong. ',
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
                $user = $Profilelib->userPd();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session telah habis";
                    return json_encode($response);
                }

                $sekolah_id = htmlspecialchars($this->request->getVar('id'), true);
                $nama = htmlspecialchars($this->request->getVar('nama'), true);

                $dataLib = new Datalib();
                $canDaftar = $dataLib->canRegister("afirmasi");
                if ($canDaftar->code !== 200) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = $canDaftar->message . " untuk <b>Jalur Afirmasi</b>.";
                    return json_encode($response);
                }

                $userPd = $this->_db->table('dapo_peserta')->where('peserta_didik_id', $user->data->peserta_didik_id)->get()->getRowObject();
                if (!$userPd) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data peserta tidak ditemukan.";
                    return json_encode($response);
                }

                $dataLib = new Datalib();
                $cekAvailableRegistered = $dataLib->cekAlreadyRegistered($user->data->peserta_didik_id);
                if ($cekAvailableRegistered) {
                    if ((int)$cekAvailableRegistered->status_pendaftaran !== 3) {
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->url = base_url('pd/home/data');
                        switch ((int)$cekAvailableRegistered->status_pendaftaran) {
                            case 1:
                                $response->message = "Anda sudah melakukan pendaftaran dan telah diverifikasi berkas. Silahkan menunggu pengumuman PPDB pada tanggal yang telah di tentukan.";
                                break;
                            case 2:
                                $response->message = "Anda dinyatakan <b>LOLOS</b> pada seleksi PPDB Tahun Ajaran 2023/2024 <br/> Melalui Jalur <b>" . $cekAvailableRegistered->via_jalur . "</b>. <br/>Selanjutnya silahkan melakukan konfirmasi dan daftar ulang ke Sekolah Tujuan <br>sesuai jadwal yang telah ditentukan.";
                                break;

                            default:
                                $response->message = "Anda sudah melakukan pendaftaran. Untuk merubah data silahkan batalkan pendaftaran melalui panitia PPDB Sekolah Tujuan.";
                                break;
                        }
                        return json_encode($response);
                    }
                }

                if ($userPd) {
                    $canVerifiUmur = $dataLib->verifiUmur($user->data->peserta_didik_id);
                    if ($canVerifiUmur->code !== 200) {
                        if ($canVerifiUmur->code !== 201) {
                            $x['error_umur'] = $canVerifiUmur->message;
                        } else {
                            $x['pengecualian_umur'] = $canVerifiUmur->message;
                        }
                    }
                    $x['sekolah_id'] = $sekolah_id;
                    $x['nama_sekolah'] = $nama;
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->title = "HALAMAN KONFIRMASI DOKUMEN SYARAT PENDAFTARAN";
                    $response->message = "Permintaan diizinkan";
                    $response->data = view('pd/daftar/afirmasi/validasi', $x);
                    return json_encode($response);
                } else {
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Permintaan tidak diizinkan";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function exeDaftar()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                '_id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Id tidak boleh kosong. ',
                    ]
                ],
                '_ijazah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Ijazah tidak boleh kosong. ',
                    ]
                ],
                '_skl' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Surat keterangan lulus tidak boleh kosong. ',
                    ]
                ],
                '_kk' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kartu keluarga tidak boleh kosong. ',
                    ]
                ],
                '_aktakel' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Akta kelahiran tidak boleh kosong. ',
                    ]
                ],
                '_jamsos' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Jaminan sosial tidak boleh kosong. ',
                    ]
                ],
                '_disabilitas' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Disabilitas tidak boleh kosong. ',
                    ]
                ],
                '_keaslian' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Keaslian tidak boleh kosong. ',
                    ]
                ],
                '_has_confirmed' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Konfirmasi tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_id')
                    . $this->validator->getError('_ijazah')
                    . $this->validator->getError('_skl')
                    . $this->validator->getError('_kk')
                    . $this->validator->getError('_aktakel')
                    . $this->validator->getError('_jamsos')
                    . $this->validator->getError('_disabilitas')
                    . $this->validator->getError('_keaslian')
                    . $this->validator->getError('_has_confirmed');
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

                $id = htmlspecialchars($this->request->getVar('_id'), true);
                $ijazah = htmlspecialchars($this->request->getVar('_ijazah'), true);
                $skl = htmlspecialchars($this->request->getVar('_skl'), true);
                $kk = htmlspecialchars($this->request->getVar('_kk'), true);
                $aktakel = htmlspecialchars($this->request->getVar('_aktakel'), true);
                $jamsos = htmlspecialchars($this->request->getVar('_jamsos'), true);
                $disabilitas = htmlspecialchars($this->request->getVar('_disabilitas'), true);
                $keaslian = htmlspecialchars($this->request->getVar('_keaslian'), true);
                $kecumur = htmlspecialchars($this->request->getVar('_kecumur'), true);
                $has_confirmed = htmlspecialchars($this->request->getVar('_has_confirmed'), true);

                $dataLib = new Datalib();
                $canDaftar = $dataLib->canRegister("afirmasi");
                if ($canDaftar->code !== 200) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = $canDaftar->message . " untuk <b>Jalur Afirmasi</b>.";
                    return json_encode($response);
                }
                $canVerifiUmur = $dataLib->verifiUmur($user->data->peserta_didik_id);
                if ($canVerifiUmur->code !== 200) {
                    if ($canVerifiUmur->code !== 201) {
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = $canVerifiUmur->message;
                        return json_encode($response);
                    } else {
                        if ($kecumur === "" || $kecumur === NULL) {
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = $canVerifiUmur->message;
                            return json_encode($response);
                        }
                    }
                }
                $dataLib = new Datalib();
                $cekAvailableRegistered = $dataLib->cekAlreadyRegistered($user->data->peserta_didik_id);
                if ($cekAvailableRegistered) {
                    if ((int)$cekAvailableRegistered->status_pendaftaran !== 3) {
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->url = base_url('pd/home/data');
                        switch ((int)$cekAvailableRegistered->status_pendaftaran) {
                            case 1:
                                $response->message = "Anda sudah melakukan pendaftaran dan telah diverifikasi berkas. Silahkan menunggu pengumuman PPDB pada tanggal yang telah di tentukan.";
                                break;
                            case 2:
                                $response->message = "Anda dinyatakan <b>LOLOS</b> pada seleksi PPDB Tahun Ajaran 2023/2024 <br/> Melalui Jalur <b>" . $cekAvailableRegistered->via_jalur . "</b>. <br/>Selanjutnya silahkan melakukan konfirmasi dan daftar ulang ke Sekolah Tujuan <br>sesuai jadwal yang telah ditentukan.";
                                break;

                            default:
                                $response->message = "Anda sudah melakukan pendaftaran. Untuk merubah data silahkan batalkan pendaftaran melalui panitia PPDB Sekolah Tujuan.";
                                break;
                        }
                        return json_encode($response);
                    }
                }

                $oldData = $this->_db->table('dapo_peserta a')
                    ->select("a.*, b.nama as nama_sekolah_asal, b.npsn as npsn_sekolah_asal")
                    ->join('dapo_sekolah b', 'b.sekolah_id = a.sekolah_id')
                    ->where('a.peserta_didik_id', $user->data->peserta_didik_id)->get()->getRowObject();
                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data pengguna tidak ditemukan.";
                    return json_encode($response);
                }

                $sekTujuan = $this->_db->table('dapo_sekolah a')
                    ->select("a.nama, a.npsn, a.lintang, a.bujur, ROUND(getDistanceKm(a.lintang,a.bujur,'{$oldData->lintang}','{$oldData->bujur}'), 2) AS distance_in_km")
                    // ->select("a.nama, a.npsn, a.lintang, a.bujur, DEGREES(ACOS(LEAST(1.0, COS(RADIANS(a.lintang)) * COS(RADIANS({$oldData->lintang})) * COS(RADIANS(a.bujur - {$oldData->bujur})) + SIN(RADIANS(a.lintang)) * SIN(RADIANS({$oldData->lintang}))))) AS distance_in_km")
                    ->where('a.sekolah_id', $id)->get()->getRowObject();
                if (!$sekTujuan) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Sekolah tujuan tidak ditemukan.";
                    return json_encode($response);
                }

                $dokumen_pendaftaran = [];
                $dokumen_pendaftaran[] = [
                    'key' => 'ijazah',
                    'value' => $ijazah
                ];
                $dokumen_pendaftaran[] = [
                    'key' => 'skl',
                    'value' => $skl
                ];
                $dokumen_pendaftaran[] = [
                    'key' => 'kk',
                    'value' => $kk
                ];
                $dokumen_pendaftaran[] = [
                    'key' => 'aktakel',
                    'value' => $aktakel
                ];
                $dokumen_pendaftaran[] = [
                    'key' => 'jamsos',
                    'value' => $jamsos
                ];
                $dokumen_pendaftaran[] = [
                    'key' => 'disabilitas',
                    'value' => $disabilitas
                ];
                $dokumen_pendaftaran[] = [
                    'key' => 'keaslian',
                    'value' => $keaslian
                ];
                if ($kecumur == "" || $kecumur == NULL) {
                } else {
                    $dokumen_pendaftaran[] = [
                        'key' => 'kecumur',
                        'value' => $kecumur
                    ];
                }

                $lampiran_pendaftaran = [
                    'dokumen' => $dokumen_pendaftaran
                ];

                $uuidLib = new Uuid();
                $uuid = $uuidLib->v4();

                $data = [
                    'id' => $uuid,
                    'kode_pendaftaran' => createKodePendaftaran("AFIRMASI", $oldData->nisn),
                    'peserta_didik_id' => $oldData->peserta_didik_id,
                    'nama_peserta' => $oldData->nama,
                    'nisn_peserta' => $oldData->nisn,
                    'tempat_lahir_peserta' => $oldData->tempat_lahir,
                    'tanggal_lahir_peserta' => $oldData->tanggal_lahir,
                    'jenis_kelamin_peserta' => $oldData->jenis_kelamin,
                    'kab_peserta' => $oldData->kab,
                    'kec_peserta' => $oldData->kec,
                    'kel_peserta' => $oldData->kel,
                    'dusun_peserta' => $oldData->dusun,
                    'lat_long_peserta' => $oldData->lintang . ',' . $oldData->bujur,
                    'user_id' => $user->data->id,
                    'from_sekolah_id' => $oldData->sekolah_id,
                    'nama_sekolah_asal' => $oldData->nama_sekolah_asal,
                    'npsn_sekolah_asal' => $oldData->npsn_sekolah_asal,
                    'tujuan_sekolah_id_1' => $id,
                    'nama_sekolah_tujuan' => $sekTujuan->nama,
                    'npsn_sekolah_tujuan' => $sekTujuan->npsn,
                    'jarak_domisili' => $sekTujuan->distance_in_km,
                    'via_jalur' => "AFIRMASI",
                    'status_pendaftaran' => 0,
                    'lampiran' => json_encode($lampiran_pendaftaran),
                    'keterangan' => null,
                    'pendaftar' => 'SISWA',
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $this->_db->transBegin();
                $this->_db->table('_tb_pendaftar_temp')->insert($data);
                if ($this->_db->affectedRows() > 0) {
                    $this->_db->transCommit();
                    // try {
                    $riwayatLib = new Riwayatlib();
                    $riwayatLib->insert($user->data->id, "Mendaftar via Jalur Afirmasi, untuk diverifikasi berkas oleh sekolah tujuan.", "Daftar Jalur Afirmasi");
                    // } catch (\Throwable $th) {
                    // }
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->data = $data;
                    $response->url = base_url('pd/daftar/afirmasi/data');
                    $response->message = "Pendaftaran via jalur Afirmasi berhasil dilakukan.";
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Pendaftaran via jalur Afirmasi gagal dilakukan.";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
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

                // $koreg = htmlspecialchars($this->request->getVar('id'), true);

                // $pd = $this->_db->table('_users_profile_pd a')
                //     ->select("b.peserta_didik_id, b.sekolah_id, b.nama, b.dusun, b.kel, b.kec, b.kab, b.nisn, b.tempat_lahir, b.tanggal_lahir, b.jenis_kelamin, b.nik, a.user_id, a.nama_sekolah_asal, a.npsn_asal, a.acc_reg")
                //     ->join('dapo_peserta b', 'a.peserta_didik_id = b.peserta_didik_id')
                //     ->where('a.peserta_didik_id', $user->data->peserta_didik_id)->get()->getRowObject();

                // if (!$pd) {
                //     $response = new \stdClass;
                //     $response->status = 400;
                //     $response->message = "Akun PD tidak ditemukan.";
                //     return json_encode($response);
                // }

                $dataLib = new Datalib();
                $pendaftaran = $dataLib->cekAlreadyRegistered($user->data->peserta_didik_id);
                if (!$pendaftaran) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Pendaftaran tidak ditemukan.";
                    return json_encode($response);
                }

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
                $html2 = '<table>
                    <tr>
                        <td colspan="3">
                            <ol>
                                <li>Kartu Peserta ini dibawa pada saat verifikasi dokumen pendaftaran ke sekolah tujuan</li>
                                <li>Jadwal Verifikasi Dokumen Pendaftaran Jalur Afirmasi tanggal 24 s/d 25 Juni 2024</li>
                                <li>Pastikan Peserta sudah mengajukan verifikasi dokumen pendaftaran sesuai jadwal</li>
                            </ol>
                        </td>
                        <td><img src="https://qrcode.esline.id/generate?data=https://ppdb.lampungtengahkab.go.id/home/qrcode?t={{ no_pendaftaran }}" style="width: 80px;" alt="Logo"></td>
                    </tr>
                </table>';

                $html2 = str_replace('{{ no_pendaftaran }}', $pendaftaran->kode_pendaftaran, $html2);

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
                $pdf->Ln(10);
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
                $filename = 'PENDAFTARAN_PPDB_AFIRMASI_' . $pendaftaran->nisn_peserta . '.pdf';
                $fileName = $dir . '/' . $filename;
                $pdf->Output($fileName, 'F'); // Generate and save to temporary file

                sleep(2);

                $fileContent = file_get_contents($fileName);
                $base64Data = base64_encode($fileContent);
                unlink($fileName); // Delete the temporary file

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
