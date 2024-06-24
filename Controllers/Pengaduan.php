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
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('id');
                return json_encode($response);
            } else {
                $id = htmlspecialchars($this->request->getVar('id'), true);
                $response = new \stdClass;
                $response->status = 200;
                switch ($id) {
                    case 'belum punya akun':
                        $response->data = view('pengaduan/belum_punya_akun');
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
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('jenis');
                return json_encode($response);
            } else {
                $jenis = htmlspecialchars($this->request->getVar('jenis'), true);
                if ($jenis === "sudah") {

                    $nisn = htmlspecialchars($this->request->getVar('nisn'), true);
                    $npsn = htmlspecialchars($this->request->getVar('npsn'), true);

                    $cekDataRefPdLocal = $this->_db->table('dapo_peserta a')
                        ->select("a.*, b.nama as nama_sekolah, b.npsn as npsn_sekolah")
                        ->join('dapo_sekolah b', 'b.sekolah_id = a.sekolah_id')
                        ->where("a.nisn = '$nisn' AND b.npsn = '$npsn'")
                        ->get()->getRowObject();

                    if ($cekDataRefPdLocal) {
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

                        $x['sek'] = $sekAsal;
                        $response = new \stdClass;
                        $response->status = 200;
                        $response->message = "Berhasil mengambil data";
                        // $response->e = $encryptData;
                        $response->data = view('pengaduan/pd/addPd', $x);
                        return json_encode($response);
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
                                    $response = new \stdClass;
                                    $response->status = 200;
                                    $response->message = "Berhasil mengambil data";
                                    // $response->e = $encryptData;
                                    $response->data = view('adm/layanan/pd/addPd', $x);
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
}
