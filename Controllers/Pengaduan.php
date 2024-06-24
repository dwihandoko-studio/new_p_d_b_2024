<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use Config\Services;
use App\Libraries\Uuid;
use App\Libraries\Profilelib;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use setasign\Fpdi\TcpdfFpdi;

class Pengaduan extends BaseController
{
    private $_db;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'cookie', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    public function index()
    {
        return redirect()->to(base_url('pengaduan/data'));
    }

    public function data()
    {
        set_cookie('layout', 'horizontal', strval(3600 * 24 * 1));
        set_cookie('headerPosition', 'static', strval(3600 * 24 * 1));
        set_cookie('containerLayout', 'wide', strval(3600 * 24 * 1));

        $data['title'] = 'PENGADUAN || PPDB 2024/2025 Kab. Lampung Tengah';

        return view('pengaduan/index', $data);
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
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('pengaduan/add');
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function form_add()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Id tidak boleh kosong. ',
                    ]
                ],
                'nama_pengadu' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Id tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('id')
                    . $this->validator->getError('id');
                return json_encode($response);
            } else {
                $id = htmlspecialchars($this->request->getVar('id'), true);
                $nama_pengadu = htmlspecialchars($this->request->getVar('nama_pengadu'), true);
                $response = new \stdClass;
                $response->status = 200;
                switch ($id) {
                    case 'belum punya akun':
                        $response->jenis = $id;
                        $x['jenis'] = $id;
                        $x['nama_pengadu'] = $nama_pengadu;
                        $response->data = view('pengaduan/belum_punya_akun', $x);
                        break;

                    default:
                        $response->status = 400;
                        break;
                }
                $response->message = "Permintaan diizinkan";
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function cekDataPd()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'jenis' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Id tidak boleh kosong. ',
                    ]
                ],
                'jenis_pengaduan' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Id tidak boleh kosong. ',
                    ]
                ],
                'nama_pengadu' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nama pengadu tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('jenis')
                    . $this->validator->getError('jenis_pengaduan')
                    . $this->validator->getError('nama_pengadu');
                return json_encode($response);
            } else {
                $jenis = htmlspecialchars($this->request->getVar('jenis'), true);
                $jenis_pengaduan = htmlspecialchars($this->request->getVar('jenis_pengaduan'), true);
                $nama_pengadu = htmlspecialchars($this->request->getVar('nama_pengadu'), true);
                if ($jenis === "sudah") {

                    $nisn = htmlspecialchars($this->request->getVar('nisn'), true);
                    $npsn = htmlspecialchars($this->request->getVar('npsn'), true);
                    $tgl_lahir = htmlspecialchars($this->request->getVar('tgl_lahir'), true);

                    $cekDataRefPdLocal = $this->_db->table('dapo_peserta a')
                        ->select("a.*, b.nama as nama_sekolah, b.npsn as npsn_sekolah")
                        ->join('dapo_sekolah b', 'b.sekolah_id = a.sekolah_id')
                        ->where("a.nisn = '$nisn' AND b.npsn = '$npsn'")
                        ->get()->getRowObject();

                    if ($cekDataRefPdLocal) {
                        if ($cekDataRefPdLocal->dusun == null || $cekDataRefPdLocal->dusun == "") {

                            $x['data'] = $cekDataRefPdLocal;
                            $encryptData = encrypt_json_data($cekDataRefPdLocal, 'secret key handokowae.my.id');
                            $x['encrypt_data'] = $encryptData;
                            $x['npsn'] = $npsn;
                            $x['props'] = $this->_db->table('ref_provinsi')
                                ->get()->getResult();
                            $x['kabs'] = $this->_db->table('ref_kabupaten')
                                ->where("left(id,2) = left('{$cekDataRefPdLocal->kode_wilayah}',2)")->get()->getResult();
                            $x['kecs'] = $this->_db->table('ref_kecamatan')
                                ->where("left(id_kabupaten,4) = left('{$cekDataRefPdLocal->kode_wilayah}',4)")->get()->getResult();
                            $x['kels'] = $this->_db->table('ref_kelurahan')
                                ->where("left(id_kecamatan,6) = left('{$cekDataRefPdLocal->kode_wilayah}',6)")->get()->getResult();
                            $x['dusuns'] = $this->_db->table('ref_dusun')->orderBy('urut', 'ASC')
                                ->get()->getResult();
                            $sekAsal = $this->_db->table('dapo_sekolah')->select("lintang, bujur")->where('sekolah_id', $cekDataRefPdLocal->sekolah_id)->get()->getRowObject();

                            if (!$sekAsal) {
                                $response = new \stdClass;
                                $response->status = 400;
                                $response->message = "Referensi Sekolah Asal Tidak Ditemukan.";
                                return json_encode($response);
                            }

                            $x['jenis'] = $jenis_pengaduan;
                            $x['sek'] = $sekAsal;
                            $response = new \stdClass;
                            $response->status = 200;
                            $response->message = "Berhasil mengambil data";
                            // $response->e = $encryptData;
                            $response->data = view('pengaduan/pd/add_pd_belum_verval', $x);
                            return json_encode($response);
                        } else {
                            $cekHasAnyAkun = $this->_db->table('v_user_verval_pd')->where('peserta_didik_id', $cekDataRefPdLocal->peserta_didik_id)->get()->getRowObject();
                            if ($cekHasAnyAkun) {
                                if ($tgl_lahir == $cekDataRefPdLocal->tanggal_lahir) {
                                    $response = new \stdClass;
                                    $response->status = 201;
                                    $response->peserta_didik_id = $cekDataRefPdLocal->peserta_didik_id;
                                    $response->nama = $cekDataRefPdLocal->nama;
                                    $response->message = "Akun sudah terdaftar. Silahkan download akun.";
                                    return json_encode($response);
                                } else {
                                    $response = new \stdClass;
                                    $response->status = 400;
                                    $response->message = "Tanggal lahir yang anda masukkan tidak sesuai dengan data NISN Peserta.";
                                    return json_encode($response);
                                }
                            }
                            $response = new \stdClass;
                            $response->status = 202;
                            $response->peserta_didik_id = $cekDataRefPdLocal->peserta_didik_id;
                            $response->nama = $cekDataRefPdLocal->nama;
                            $response->message = "Data peserta ditemukan dan sudah di verval. Silahkan untuk mengajukan generate Akun.";
                            return json_encode($response);
                        }
                    } else {

                        $curlHandle = curl_init("https://pelayanan.data.kemdikbud.go.id/vci/index.php/CPelayananData/getSiswa?kode_wilayah=120200&token=CD04B72E-17EB-4C2D-9421-DCF4240C7138&nisn=$nisn&npsn=$npsn");

                        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "GET");
                        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 60);
                        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 60);
                        $send_data_curl         = curl_exec($curlHandle);

                        $result_curl = json_decode($send_data_curl);

                        // var_dump($result_curl);
                        // die;

                        if (isset($result_curl->error)) {
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "Gagal mengambil data.";
                            return json_encode($response);
                        }

                        if ($result_curl) {
                            if (isset($result_curl->message)) {
                                $response = new \stdClass;
                                $response->status = 400;
                                $response->message = $result_curl->message;
                                return json_encode($response);
                            } else {
                                if (isset($result_curl[0]->Keterangan)) {
                                    $response = new \stdClass;
                                    $response->status = 400;
                                    $response->message = $result_curl[0]->Keterangan;
                                    return json_encode($response);
                                }

                                if (count($result_curl) > 0) {
                                    $pdNya = $result_curl[0];
                                    $x['data'] = $pdNya;
                                    $encryptData = encrypt_json_data($pdNya, 'secret key handokowae.my.id');
                                    $x['encrypt_data'] = $encryptData;
                                    $x['npsn'] = $npsn;
                                    $x['props'] = $this->_db->table('ref_provinsi')
                                        ->get()->getResult();
                                    $x['kabs'] = $this->_db->table('ref_kabupaten')
                                        ->where("left(id,2) = left('{$pdNya->kode_wilayah}',2)")->get()->getResult();
                                    $x['kecs'] = $this->_db->table('ref_kecamatan')
                                        ->where("left(id_kabupaten,4) = left('{$pdNya->kode_wilayah}',4)")->get()->getResult();
                                    $x['kels'] = $this->_db->table('ref_kelurahan')
                                        ->where("left(id_kecamatan,6) = left('{$pdNya->kode_wilayah}',6)")->get()->getResult();
                                    $x['dusuns'] = $this->_db->table('ref_dusun')->orderBy('urut', 'ASC')
                                        ->get()->getResult();
                                    $sekAsal = $this->_db->table('dapo_sekolah')->select("lintang, bujur")->where('sekolah_id', $pdNya->sekolah_id)->get()->getRowObject();

                                    if (!$sekAsal) {
                                        $refSekolah = $this->_db->table('ref_sekolah')->where('id', $pdNya->sekolah_id)->get()->getRowObject();
                                        if (!$refSekolah) {
                                            $response = new \stdClass;
                                            $response->status = 400;
                                            $response->message = "Referensi Sekolah Asal Tidak Ditemukan.";
                                            return json_encode($response);
                                        }

                                        try {
                                            $this->_db->table('dapo_sekolah')->insert([
                                                'sekolah_id' => $refSekolah->id,
                                                'nama' => $refSekolah->nama,
                                                'npsn' => $refSekolah->npsn,
                                                'kode_wilayah' => $refSekolah->kode_wilayah,
                                                'kode_desa_kelurahan' => $refSekolah->kode_wilayah,
                                                'desa_kelurahan' => $refSekolah->desa_kelurahan,
                                                'kode_kecamatan' => substr($refSekolah->kode_wilayah, 0, 6),
                                                'kecamatan' => getNameKecamatan(substr($refSekolah->kode_wilayah, 0, 6)),
                                                'kode_kabupaten' => substr($refSekolah->kode_wilayah, 0, 4) . '00',
                                                'kabupaten' => getNameKabupaten(substr($refSekolah->kode_wilayah, 0, 4) . '00'),
                                                'kode_provinsi' => substr($refSekolah->kode_wilayah, 0, 2) . '0000',
                                                'provinsi' => getNameProvinsi(substr($refSekolah->kode_wilayah, 0, 2) . '0000'),
                                                'bentuk_pendidikan_id' => $refSekolah->bentuk_pendidikan_id,
                                                'status_sekolah_id' => $refSekolah->status_sekolah,
                                                'alamat_jalan' => $refSekolah->alamat_jalan,
                                                'rt' => $refSekolah->rt,
                                                'rw' => $refSekolah->rw,
                                                'lintang' => $refSekolah->latitude,
                                                'bujur' => $refSekolah->longitude,
                                            ]);
                                        } catch (\Throwable $th) {
                                            $response = new \stdClass;
                                            $response->status = 400;
                                            $response->message = "Gagal mengambil ref sekolah asal.";
                                            return json_encode($response);
                                        }

                                        $sekAsalNew = $this->_db->table('dapo_sekolah')->select("lintang, bujur")->where('sekolah_id', $pdNya->sekolah_id)->get()->getRowObject();
                                        if (!$sekAsalNew) {
                                            $response = new \stdClass;
                                            $response->status = 400;
                                            $response->message = "Gagal mengambil ref sekolah asal baru.";
                                            return json_encode($response);
                                        }
                                        $sekAsal = $sekAsalNew;
                                    }

                                    $x['sek'] = $sekAsal;
                                    $x['jenis'] = $jenis_pengaduan;
                                    $response = new \stdClass;
                                    $response->status = 200;
                                    $response->message = "Berhasil mengambil data";
                                    $response->nama_pengadu = $nama_pengadu;
                                    $response->data = view('pengaduan/pd/add_pd_belum_ref', $x);
                                    return json_encode($response);
                                } else {
                                    $response = new \stdClass;
                                    $response->status = 400;
                                    $response->message = "Data yang Anda cari tidak ditemukan atau peserta didik tidak berada di Tingkat Akhir.";
                                    return json_encode($response);
                                }
                            }
                        } else {
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "Gagal mengambil data. request to backbone";
                            return json_encode($response);
                        }
                    }
                } else {
                    if ($jenis === "belum") {
                        $nik = htmlspecialchars($this->request->getVar('_nik'), true);
                        $kk = htmlspecialchars($this->request->getVar('_kk'), true);

                        $anyUser = $this->_db->table('_users_tb')->where('username', $nik)->get()->getRowObject();
                        if ($anyUser) {
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "NIK sudah terdaftar. Silahkan login dengan menggunakan NIK.";
                            return json_encode($response);
                        }

                        $x['nik'] = $nik;
                        $x['kk'] = $kk;
                        $x['npsn'] = '10000001';
                        $x['sekolah_id'] = '4a1512a8-b6ac-11ec-985c-0242ac120002';
                        $x['props'] = $this->_db->table('ref_provinsi')
                            ->get()->getResult();
                        $x['kabs'] = $this->_db->table('ref_kabupaten')
                            ->where("left(id,2) = '12'")->get()->getResult();
                        $x['kecs'] = $this->_db->table('ref_kecamatan')
                            ->where("left(id_kabupaten,4) = '1202'")->get()->getResult();
                        $x['kels'] = $this->_db->table('ref_kelurahan')
                            ->where("left(id_kecamatan,6) = '120202'")->get()->getResult();
                        $x['dusuns'] = $this->_db->table('ref_dusun')->orderBy('urut', 'ASC')
                            ->get()->getResult();
                        $x['sek'] = $this->_db->table('dapo_sekolah')->select("lintang, bujur")->where('npsn', '10000001')->get()->getRowObject();
                        $response = new \stdClass;
                        $response->status = 200;
                        $response->message = "Berhasil mengambil data";
                        $response->data = view('pengaduan/pd/addPdBelum', $x);
                        return json_encode($response);
                    } else {
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Jenis pd tidak diketahui.";
                        return json_encode($response);
                    }
                }

                $response = new \stdClass;
                $response->status = 200;
                $response->data = view('pengaduan/belum_punya_akun');
                $response->message = "Permintaan diizinkan";
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function refkab()
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

                $id = htmlspecialchars($this->request->getVar('id'), true);

                $current = $this->_db->table('ref_kabupaten')
                    ->where("id_provinsi = '$id'")->get()->getResult();

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
                'sekolah_id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Sekolah id tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('id')
                    . $this->validator->getError('id');
                return json_encode($response);
            } else {

                $id = htmlspecialchars($this->request->getVar('id'), true);
                $sekolah_id = htmlspecialchars($this->request->getVar('sekolah_id'), true);

                $current = $this->_db->table('dapo_peserta')
                    ->where("peserta_didik_id = '$id'")->get()->getRowObject();

                if ($current) {
                    $x['data'] = $current;
                    $x['props'] = $this->_db->table('ref_provinsi')
                        ->get()->getResult();
                    $x['kabs'] = $this->_db->table('ref_kabupaten')
                        ->where("left(id,2) = left('{$current->kode_wilayah}',2)")->get()->getResult();
                    $x['kecs'] = $this->_db->table('ref_kecamatan')
                        ->where("left(id_kabupaten,4) = left('{$current->kode_wilayah}',4)")->get()->getResult();
                    $x['kels'] = $this->_db->table('ref_kelurahan')
                        ->where("left(id_kecamatan,6) = left('{$current->kode_wilayah}',6)")->get()->getResult();
                    $x['dusuns'] = $this->_db->table('ref_dusun')->orderBy('urut', 'ASC')
                        ->get()->getResult();
                    $x['sek'] = $this->_db->table('dapo_sekolah')->select("lintang, bujur")->where('sekolah_id', $sekolah_id)->get()->getRowObject();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Permintaan diizinkan";
                    $response->data = view('pengaduan/pd/form_edit', $x);
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
            $lat = htmlspecialchars($this->request->getVar('lat'), true) ?? "";
            $long = htmlspecialchars($this->request->getVar('long'), true) ?? "";
            $sekolah_id = htmlspecialchars($this->request->getVar('sekolah_id'), true) ?? "";

            if ($lat == "" && $long == "") {
                $sek = $this->_db->table('dapo_sekolah')->select("lintang, bujur")->where('sekolah_id', $sekolah_id)->get()->getRowObject();
                if ($sek) {
                    if ($lat == "") {
                        $lat = $sek->lintang;
                    }
                    if ($long == "") {
                        $lat = $sek->bujur;
                    }
                }
            }

            $x['lat'] = $lat;
            $x['long'] = $long;

            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->lat = $lat;
            $response->long = $long;
            $response->data = view('pengaduan/pd/maps', $x);
            return json_encode($response);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function addSavePengaduanAkunSekolahVerval()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                '_jenis_pengaduan_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Jenis pengaduan tidak boleh kosong. ',
                    ]
                ],
                '_peserta_didik_id_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Peserta didik id tidak boleh kosong. ',
                    ]
                ],
                '_prov_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Provinsi tidak boleh kosong. ',
                    ]
                ],
                '_kab_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kabupaten tidak boleh kosong. ',
                    ]
                ],
                '_kec_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kecamatan tidak boleh kosong. ',
                    ]
                ],
                '_kel_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kelurahan tidak boleh kosong. ',
                    ]
                ],
                '_dusun_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Dusun tidak boleh kosong. ',
                    ]
                ],
                '_lintang_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Lintang tidak boleh kosong. ',
                    ]
                ],
                '_bujur_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Bujur tidak boleh kosong. ',
                    ]
                ],
                '_nik_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'NIK tidak boleh kosong. ',
                    ]
                ],
                '_kk_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kartu Keluarga tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_peserta_didik_id_pd_sekolah')
                    . $this->validator->getError('_jenis_pengaduan_pd_sekolah')
                    . $this->validator->getError('_prov_pd_sekolah')
                    . $this->validator->getError('_kab_pd_sekolah')
                    . $this->validator->getError('_kec_pd_sekolah')
                    . $this->validator->getError('_kel_pd_sekolah')
                    . $this->validator->getError('_dusun_pd_sekolah')
                    . $this->validator->getError('_lintang_pd_sekolah')
                    . $this->validator->getError('_bujur_pd_sekolah')
                    . $this->validator->getError('_nik_pd_sekolah')
                    . $this->validator->getError('_kk_pd_sekolah');
                return json_encode($response);
            } else {
                $jenis_pengaduan = htmlspecialchars($this->request->getVar('_jenis_pengaduan_pd_sekolah'), true);
                $peserta_didik_id = htmlspecialchars($this->request->getVar('_peserta_didik_id_pd_sekolah'), true);
                $prov = htmlspecialchars($this->request->getVar('_prov_pd_sekolah'), true);
                $kab = htmlspecialchars($this->request->getVar('_kab_pd_sekolah'), true);
                $kec = htmlspecialchars($this->request->getVar('_kec_pd_sekolah'), true);
                $kel = htmlspecialchars($this->request->getVar('_kel_pd_sekolah'), true);
                $dusun = htmlspecialchars($this->request->getVar('_dusun_pd_sekolah'), true);
                $lintang = htmlspecialchars($this->request->getVar('_lintang_pd_sekolah'), true);
                $bujur = htmlspecialchars($this->request->getVar('_bujur_pd_sekolah'), true);
                $nik = htmlspecialchars($this->request->getVar('_nik_pd_sekolah'), true);
                $kk = htmlspecialchars($this->request->getVar('_kk_pd_sekolah'), true);

                $oldData = $this->_db->table('dapo_peserta')
                    ->where('peserta_didik_id', $peserta_didik_id)
                    ->get()->getRowObject();

                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data tidak ditemukan.";
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
                    $hasAcount = $this->_db->table('_users_tb')
                        ->where('username', $oldData->nisn)
                        ->get()->getRowObject();
                    if ($hasAcount) {
                        $response = new \stdClass;
                        $response->status = 204;
                        $response->message = "Data sudah di verval. Silahkan login ke aplikasi";
                        return json_encode($response);
                    } else {
                        $response = new \stdClass;
                        $response->status = 201;
                        $response->peserta_didik_id = $oldData->peserta_didik_id;
                        $response->nama = $oldData->nama;
                        $response->message = "Data sudah di verval. Namun belum generate akun.";
                        return json_encode($response);
                    }
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
                        $response->nama = $oldData->nama;
                        $response->peserta_didik_id = $oldData->peserta_didik_id;
                        $response->sekolah_id = $oldData->sekolah_id;
                        $response->message = "Data berhasil diupdate.";
                        return json_encode($response);
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal mengajukan verval data.";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengajukan verval data.";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function addSavePengaduanAkunSekolahNoId()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                '_nama_pengadu' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Jenis pengaduan tidak boleh kosong. ',
                    ]
                ],
                '_jenis_pengaduan_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Jenis pengaduan tidak boleh kosong. ',
                    ]
                ],
                '_data_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Peserta didik id tidak boleh kosong. ',
                    ]
                ],
                '_prov_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Provinsi tidak boleh kosong. ',
                    ]
                ],
                '_kab_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kabupaten tidak boleh kosong. ',
                    ]
                ],
                '_kec_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kecamatan tidak boleh kosong. ',
                    ]
                ],
                '_kel_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kelurahan tidak boleh kosong. ',
                    ]
                ],
                '_dusun_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Dusun tidak boleh kosong. ',
                    ]
                ],
                '_lintang_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Lintang tidak boleh kosong. ',
                    ]
                ],
                '_bujur_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Bujur tidak boleh kosong. ',
                    ]
                ],
                '_nik_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'NIK tidak boleh kosong. ',
                    ]
                ],
                '_kk_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kartu Keluarga tidak boleh kosong. ',
                    ]
                ],
                '_email_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Email tidak boleh kosong. ',
                    ]
                ],
                '_nohp_pd_sekolah' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'No WA tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_data_pd_sekolah')
                    . $this->validator->getError('_nama_pengadu')
                    . $this->validator->getError('_jenis_pengaduan_pd_sekolah')
                    . $this->validator->getError('_prov_pd_sekolah')
                    . $this->validator->getError('_kab_pd_sekolah')
                    . $this->validator->getError('_kec_pd_sekolah')
                    . $this->validator->getError('_kel_pd_sekolah')
                    . $this->validator->getError('_dusun_pd_sekolah')
                    . $this->validator->getError('_lintang_pd_sekolah')
                    . $this->validator->getError('_bujur_pd_sekolah')
                    . $this->validator->getError('_nik_pd_sekolah')
                    . $this->validator->getError('_kk_pd_sekolah')
                    . $this->validator->getError('_email_pd_sekolah')
                    . $this->validator->getError('_nohp_pd_sekolah');
                return json_encode($response);
            } else {
                $jenis_pengaduan = htmlspecialchars($this->request->getVar('_jenis_pengaduan_pd_sekolah'), true);
                $nama_pengadu = htmlspecialchars($this->request->getVar('_nama_pengadu'), true);
                $dataPd = $this->request->getVar('_data_pd_sekolah');
                $prov = htmlspecialchars($this->request->getVar('_prov_pd_sekolah'), true);
                $kab = htmlspecialchars($this->request->getVar('_kab_pd_sekolah'), true);
                $kec = htmlspecialchars($this->request->getVar('_kec_pd_sekolah'), true);
                $kel = htmlspecialchars($this->request->getVar('_kel_pd_sekolah'), true);
                $dusun = htmlspecialchars($this->request->getVar('_dusun_pd_sekolah'), true);
                $lintang = htmlspecialchars($this->request->getVar('_lintang_pd_sekolah'), true);
                $bujur = htmlspecialchars($this->request->getVar('_bujur_pd_sekolah'), true);
                $nik = htmlspecialchars($this->request->getVar('_nik_pd_sekolah'), true);
                $kk = htmlspecialchars($this->request->getVar('_kk_pd_sekolah'), true);
                $email = htmlspecialchars($this->request->getVar('_email_pd_sekolah'), true);
                $nohp = htmlspecialchars($this->request->getVar('_nohp_pd_sekolah'), true);

                $dataPdFix = decrypt_json_data($dataPd, 'secret key handokowae.my.id');
                $dataPdFix = (object)$dataPdFix;

                $oldData = $this->_db->table('dapo_peserta')->where('nisn', $dataPdFix->nisn)->get()->getRowObject();
                if ($oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Peserta didik sudah ada dengan Nisn: $oldData->nisn ($oldData->nama).";
                    return json_encode($response);
                }

                $refSeklah = $this->_db->table('dapo_sekolah')->where('sekolah_id', $dataPdFix->sekolah_id)->get()->getRowObject();
                if (!$refSeklah) {

                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Referensi sekolah asal PD tidak ditemukan.";
                    return json_encode($response);
                }

                $ticketKey = generateRandomTicketKey();
                $numberKey = 0;
                $ticketKeyF = date('d') . $ticketKey . date('H');

                $dataInsertPengajuan = [
                    'id' => $ticketKeyF . $numberKey,
                    'sekolah_id' => $dataPdFix->sekolah_id,
                    'nama' => $dataPdFix->nama,
                    'tempat_lahir' => $dataPdFix->tempat_lahir,
                    'tanggal_lahir' => $dataPdFix->tanggal_lahir,
                    'jenis_kelamin' => $dataPdFix->jenis_kelamin,
                    'nisn' => $dataPdFix->nisn,
                    'nik' => $nik,
                    'no_kk' => $kk,
                    'kab' => $kab,
                    'kec' => $kec,
                    'kel' => $kel,
                    'kode_wilayah' => $kel,
                    'alamat_jalan' => $dataPdFix->alamat_jalan,
                    'desa_kelurahan' => $dataPdFix->desa_kelurahan,
                    'rt' => $dataPdFix->rt,
                    'rw' => $dataPdFix->rw,
                    'nama_dusun' => $dataPdFix->nama_dusun,
                    'nama_ibu_kandung' => $dataPdFix->nama_ibu_kandung,
                    'pekerjaan_ibu' => $dataPdFix->pekerjaan_ibu,
                    'penghasilan_ibu' => $dataPdFix->penghasilan_ibu,
                    'nama_ayah' => $dataPdFix->nama_ayah,
                    'pekerjaan_ayah' => $dataPdFix->pekerjaan_ayah,
                    'penghasilan_ayah' => $dataPdFix->penghasilan_ayah,
                    'nama_wali' => $dataPdFix->nama_wali,
                    'pekerjaan_wali' => $dataPdFix->pekerjaan_wali,
                    'penghasilan_wali' => $dataPdFix->penghasilan_wali,
                    'kebutuhan_khusus' => $dataPdFix->kebutuhan_khusus,
                    'no_kip' => $dataPdFix->no_kip,
                    'no_pkh' => $dataPdFix->no_pkh,
                    'tingkat_pendidikan_id' => $dataPdFix->tingkat_pendidikan,
                    'dusun' => $dusun,
                    'lintang' => $lintang,
                    'bujur' => $bujur,
                    'nama_pengadu' => $nama_pengadu,
                    'email' => $email,
                    'nohp' => $nohp,
                    'is_edited' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                $this->_db->transBegin();
                try {
                    $this->_db->table('dapo_peserta_pengajuan')->insert($dataInsertPengajuan);
                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->table('data_pengaduan')->insert([
                            'no_tiket' => $dataInsertPengajuan['id'],
                            'jenis_pengaduan' => $dataInsertPengajuan['jenis_pengaduan'],
                            'nama_pengadu' => $dataInsertPengajuan['nama_pengadu'],
                            'email_pengadu' => $dataInsertPengajuan['email'],
                            'nohp_pengadu' => $dataInsertPengajuan['nohp'],
                        ]);
                        $this->_db->transCommit();
                        return $this->downloadTiketId($dataInsertPengajuan['id']);
                        // $response = new \stdClass;
                        // $response->status = 200;
                        // $response->tiket_id = $dataInsertPengajuan['id'];
                        // $response->message = "Data berhasil disimpan.";
                        // return json_encode($response);
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal menyimpan data. pd e";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    $dbError = $this->_db->error();
                    if (strpos($dbError['message'], 'Duplicate entry') !== false || strpos($dbError['message'], 'Key \'PRIMARY\'') !== false) {
                        $dataInsertPengajuan['id'] = $ticketKeyF . $numberKey + 1;
                        try {
                            $this->_db->table('dapo_peserta_pengajuan')->insert($dataInsertPengajuan);
                            if ($this->_db->affectedRows() > 0) {
                                $this->_db->table('data_pengaduan')->insert([
                                    'no_tiket' => $dataInsertPengajuan['id'],
                                    'jenis_pengaduan' => $dataInsertPengajuan['jenis_pengaduan'],
                                    'nama_pengadu' => $dataInsertPengajuan['nama_pengadu'],
                                    'email_pengadu' => $dataInsertPengajuan['email'],
                                    'nohp_pengadu' => $dataInsertPengajuan['nohp'],
                                ]);
                                $this->_db->transCommit();
                                return $this->downloadTiketId($dataInsertPengajuan['id']);
                                // $response = new \stdClass;
                                // $response->status = 200;
                                // $response->tiket_id = $dataInsertPengajuan['id'];
                                // $response->message = "Data berhasil disimpan.";
                                // return json_encode($response);
                            } else {
                                $this->_db->transRollback();
                                $response = new \stdClass;
                                $response->status = 400;
                                $response->message = "Gagal menyimpan data. pd e";
                                return json_encode($response);
                            }
                        } catch (\Throwable $th) {
                            $dbError = $this->_db->error();
                            if (strpos($dbError['message'], 'Duplicate entry') !== false || strpos($dbError['message'], 'Key \'PRIMARY\'') !== false) {
                                $dataInsertPengajuan['id'] = $ticketKeyF . $numberKey + 2;
                                try {
                                    $this->_db->table('dapo_peserta_pengajuan')->insert($dataInsertPengajuan);
                                    if ($this->_db->affectedRows() > 0) {
                                        $this->_db->table('data_pengaduan')->insert([
                                            'no_tiket' => $dataInsertPengajuan['id'],
                                            'jenis_pengaduan' => $dataInsertPengajuan['jenis_pengaduan'],
                                            'nama_pengadu' => $dataInsertPengajuan['nama_pengadu'],
                                            'email_pengadu' => $dataInsertPengajuan['email'],
                                            'nohp_pengadu' => $dataInsertPengajuan['nohp'],
                                        ]);
                                        $this->_db->transCommit();
                                        return $this->downloadTiketId($dataInsertPengajuan['id']);

                                        // $response = new \stdClass;
                                        // $response->status = 200;
                                        // $response->tiket_id = $dataInsertPengajuan['id'];
                                        // $response->message = "Data berhasil disimpan.";
                                        // return json_encode($response);
                                    } else {
                                        $this->_db->transRollback();
                                        $response = new \stdClass;
                                        $response->status = 400;
                                        $response->message = "Gagal menyimpan data. pd e";
                                        return json_encode($response);
                                    }
                                } catch (\Throwable $th) {
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
                        }
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal menyimpan data.";
                        return json_encode($response);
                    }
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function generateAkun()
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

                $id = htmlspecialchars($this->request->getVar('id'), true);
                $nama = htmlspecialchars($this->request->getVar('nama'), true);

                $oldData = $this->_db->table('dapo_peserta a')
                    ->select("a.*, b.npsn, b.nama as nama_sekolah")
                    ->join("dapo_sekolah b", "b.sekolah_id = a.sekolah_id")
                    ->where('a.peserta_didik_id', $id)->get()->getRowObject();
                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Peserta didik tidak ditemukan.";
                    return json_encode($response);
                }

                $oldDataAkun = $this->_db->table('_users_profile_pd')
                    ->where('peserta_didik_id', $id)->get()->getRowObject();
                if ($oldDataAkun) {
                    $response = new \stdClass;
                    $response->status = 201;
                    $response->peserta_didik_id = $oldData->peserta_didik_id;
                    $response->nama = $oldData->nama;
                    $response->message = "Akun PD sudah tergenerate, Silahkan gunakan menu download.";
                    return json_encode($response);
                }

                $characters = array_merge(range('A', 'Z'), range(0, 9));
                $randomString = '';
                for ($i = 0; $i < 6; $i++) {
                    $randomIndex = mt_rand(0, count($characters) - 1);
                    $randomString .= $characters[$randomIndex];
                }
                $password = $randomString;
                $passwordFix = password_hash($password, PASSWORD_BCRYPT);

                $uuidLib = new Uuid();

                $dataUser = [
                    'id' => $uuidLib->v4(),
                    'username' => $oldData->nisn,
                    'password' => $passwordFix,
                    'is_active' => 1,
                    'level' => 5,
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $dataUserProfile = [
                    'user_id' => $dataUser['id'],
                    'peserta_didik_id' => $oldData->peserta_didik_id,
                    'sekolah_id_asal' => $oldData->sekolah_id,
                    'wilayah' => $oldData->kode_wilayah,
                    'nama' => $oldData->nama,
                    'nama_sekolah_asal' => $oldData->nama_sekolah,
                    'npsn_asal' => $oldData->npsn,
                    'tingkat_pendidikan_asal' => $oldData->tingkat_pendidikan_id,
                    'acc_reg' => $password,
                    'created_at' => $dataUser['created_at']
                ];

                $this->_db->transBegin();
                try {
                    $this->_db->table('_users_tb')->insert($dataUser);
                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->table('_users_profile_pd')->insert($dataUserProfile);
                        if ($this->_db->affectedRows() > 0) {
                            $this->_db->transCommit();

                            return $this->downloadAkunPrivate($oldData->peserta_didik_id, $oldData->nama);
                        } else {
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "Gagal mengenerate data.";
                            return json_encode($response);
                        }
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal mengenerate data.";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengenerate data.";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function downloadAkun()
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
                $id = htmlspecialchars($this->request->getVar('id'), true);

                $pd = $this->_db->table('_users_profile_pd a')
                    ->select("c.username, b.peserta_didik_id, b.sekolah_id, b.nama, b.nisn, b.tempat_lahir, b.tanggal_lahir, b.jenis_kelamin, b.nik, a.user_id, a.nama_sekolah_asal, a.npsn_asal, a.acc_reg")
                    ->join('dapo_peserta b', 'a.peserta_didik_id = b.peserta_didik_id')
                    ->join('_users_tb c', 'a.user_id = c.id')
                    ->where('a.peserta_didik_id', $id)->get()->getRowObject();

                if (!$pd) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Akun PD tidak ditemukan.";
                    return json_encode($response);
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
                $pdf->MultiCell(70, 20, "Generate From Layanan", 0, 'L', false, 1, 130, null, true, 0, true);

                // $pdf->WriteHTML($html);

                // Output PDF
                $dir = FCPATH . "uploads/temp";
                $filename = 'Akun_PPDB_' . $pd->nisn . '.pdf';
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

    private function downloadTiketId($id)
    {
        $tiket = $this->_db->table('dapo_peserta_pengajuan')
            ->where('id', $id)->get()->getRowObject();

        if (!$tiket) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Tiket pengaduan tidak ditemukan.";
            return json_encode($response);
        }

        $html = '<table border="0">
                        <tr>
                            <td>Nama Pengadu</td>
                            <td colspan="2">: {{ nama_pengadu }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>: {{ email_pengadu }}</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>No WA</td>
                            <td>: {{ nohp_pengadu }}</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>';

        $html1 = '<table>
                        <tr>
                            <td><center><b>{{ no_tiket }}</b></center></td>
                        </tr>
                    </table>';
        $html2 = '<p><center>No tiket pengaduan ini digunakan untuk<br />melacak status pengaduan melalui laman: <br /><b>https://ppdb.lampungtengahkab.go.id/pengaduan</b></center></p>';

        $html = str_replace('{{ nama_pengadu }}', $tiket->nama_pengadu, $html);
        $html = str_replace('{{ email_pengadu }}', $tiket->email, $html);
        $html = str_replace('{{ nohp_pengadu }}', $tiket->nohp, $html);

        $html1 = str_replace('{{ no_tiket }}', $tiket->id, $html1);

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
        $pdf->MultiCell(180, 10, '<h4>DATA PENGADU</h4>', 0, 'L', false, 1, 20, null, true, 0, true);
        $pdf->MultiCell(180, 10, $html, 0, 'L', false, 1, 20, null, true, 0, true);
        $pdf->Ln(10);
        $pdf->MultiCell(180, 10, '<h4>TIKET PENGADUAN</h4>', 0, 'L', false, 1, 20, null, true, 0, true);
        $pdf->MultiCell(180, 10, $html1, 0, 'L', false, 1, 20, null, true, 0, true);
        $pdf->Ln(20);
        $pdf->MultiCell(180, 10, $html2, 0, 'C', false, 1, 20, null, true, 0, true);
        $pdf->Ln(20);
        $pdf->MultiCell(70, 20, "PPDB Kab. Lampung Tengah,", 0, 'L', false, 1, 130, null, true, 0, true);
        $pdf->Ln(10);
        $pdf->MultiCell(70, 20, "Generate From Layanan", 0, 'L', false, 1, 130, null, true, 0, true);

        // $pdf->WriteHTML($html);

        // Output PDF
        $dir = FCPATH . "uploads/temp";
        $filename = 'TIKET_PENGADUAN_' . $tiket->id . '.pdf';
        $fileName = $dir . '/' . $filename;
        $pdf->Output($fileName, 'F'); // Generate and save to temporary file

        sleep(2);

        $fileContent = file_get_contents($fileName);
        $base64Data = base64_encode($fileContent);
        unlink($fileName); // Delete the temporary file

        $response = new \stdClass;
        $response->status = 200;
        $response->message = "Tiket Pengaduan Berhasil Didownload.";
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

    private function downloadAkunPrivate($id, $nama)
    {
        $pd = $this->_db->table('_users_profile_pd a')
            ->select("c.username, b.peserta_didik_id, b.sekolah_id, b.nama, b.nisn, b.tempat_lahir, b.tanggal_lahir, b.jenis_kelamin, b.nik, a.user_id, a.nama_sekolah_asal, a.npsn_asal, a.acc_reg")
            ->join('dapo_peserta b', 'a.peserta_didik_id = b.peserta_didik_id')
            ->join('_users_tb c', 'a.user_id = c.id')
            ->where('a.peserta_didik_id', $id)->get()->getRowObject();

        if (!$pd) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Akun PD tidak ditemukan.";
            return json_encode($response);
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
        $pdf->MultiCell(70, 20, "Generate From Layanan", 0, 'L', false, 1, 130, null, true, 0, true);

        // $pdf->WriteHTML($html);

        // Output PDF
        $dir = FCPATH . "uploads/temp";
        $filename = 'Akun_PPDB_' . $pd->nisn . '.pdf';
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
}
