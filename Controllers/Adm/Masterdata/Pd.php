<?php

namespace App\Controllers\Adm\Masterdata;

use App\Controllers\BaseController;
use App\Models\Adm\Masterdata\PdModel;
use App\Models\Adm\Masterdata\SekolahpdModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pd extends BaseController
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
        $request = Services::request();
        $datamodel = new SekolahpdModel($request);


        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<a class="btn btn-primary" href="./detaillist?id=' . $list->sekolah_id . '&n=' . $list->nama . '"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                                ';

            $row[] = $action;
            $row[] = $list->nama;
            $row[] = $list->npsn;
            $row[] = $list->bentuk_pendidikan;
            $row[] = $list->kecamatan;
            $row[] = $list->jumlah_siswa;

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all(),
            "recordsFiltered" => $datamodel->count_filtered(),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function getAllDetail()
    {
        $request = Services::request();
        $datamodel = new PdModel($request);


        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->peserta_didik_id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                                <a class="dropdown-item" href="javascript:actionResetPassword(\'' . $list->peserta_didik_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="bx bx-key font-size-16 align-middle"></i> &nbsp;Reset Password</a>
                                <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->peserta_didik_id . '\', \'' . str_replace("'", "", $list->nama)  . '\');"><i class="bx bx-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
                                <div class="dropdown-divider"></div>
                            </div>
                        </div>';

            $row[] = $action;
            $row[] = $list->nama;
            $row[] = $list->nisn;
            $row[] = $list->nik;
            $row[] = $list->no_kk;
            $row[] = $list->tanggal_lahir;
            $row[] = $list->tingkat_pendidikan_id;
            $row[] = $list->nama_ibu_kandung;
            $row[] = $list->latlong;
            // switch ($list->is_active) {
            //     case 1:
            //         $row[] = '<div class="text-center">
            //                 <span class="badge rounded-pill badge-soft-success font-size-11">Aktif</span>
            //             </div>';
            //         break;
            //     default:
            //         $row[] = '<div class="text-center">
            //             <span class="badge rounded-pill badge-soft-danger font-size-11">Non Aktif</span>
            //         </div>';
            //         break;
            // }
            // switch ($list->email_verified) {
            //     case 1:
            //         $row[] = '<div class="text-center">
            //                 <span class="badge rounded-pill badge-soft-success font-size-11">Ya</span>
            //             </div>';
            //         break;
            //     default:
            //         $row[] = '<div class="text-center">
            //             <span class="badge rounded-pill badge-soft-danger font-size-11">Tidak</span>
            //         </div>';
            //         break;
            // }
            // switch ($list->wa_verified) {
            //     case 1:
            //         $row[] = '<div class="text-center">
            //                 <span class="badge rounded-pill badge-soft-success font-size-11">Ya</span>
            //             </div>';
            //         break;
            //     default:
            //         $row[] = '<div class="text-center">
            //             <span class="badge rounded-pill badge-soft-danger font-size-11">Tidak</span>
            //         </div>';
            //         break;
            // }

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all(),
            "recordsFiltered" => $datamodel->count_filtered(),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        return redirect()->to(base_url('adm/masterdata/pd/data'));
    }

    public function data()
    {
        $data['title'] = 'SEKOLAH';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        $data['kecamatans'] = $this->_db->table('ref_kecamatan')->orderBy('nama', 'ASC')->get()->getResult();
        $data['jenjangs'] = $this->_db->table('dapo_sekolah')->select("bentuk_pendidikan_id, bentuk_pendidikan, count(bentuk_pendidikan_id) as jumlah")->groupBy('bentuk_pendidikan_id')->orderBy('bentuk_pendidikan', 'ASC')->get()->getResult();

        return view('adm/masterdata/pd/sekolah', $data);
    }

    public function detaillist()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $id = htmlspecialchars($this->request->getGet('id'), true);
        $name = htmlspecialchars($this->request->getGet('n'), true);
        $data['title'] = "DATA PESERTA DIDIK SEKOLAH $name";

        $data['user'] = $user->data;
        $data['id'] = $id;
        $data['sekolah'] = $name;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        $data['kecamatans'] = $this->_db->table('ref_kecamatan')->orderBy('nama_kecamatan', 'ASC')->get()->getResult();

        return view('adm/masterdata/pd/index', $data);
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
                $user = $Profilelib->user();
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
                $response->data = view('adm/masterdata/pd/upload');
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
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
                $user = $Profilelib->user();
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
                $response->data = view('adm/masterdata/pd/add');
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function cekData()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                '_jenis' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'NISN tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_jenis');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->user();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session expired";
                    return json_encode($response);
                }

                $jenis = htmlspecialchars($this->request->getVar('_jenis'), true);

                if ($jenis === "sudah") {

                    $nisn = htmlspecialchars($this->request->getVar('_nisn'), true);
                    $npsn = htmlspecialchars($this->request->getVar('_npsn'), true);

                    $curlHandle = curl_init("https://pelayanan.data.kemdikbud.go.id/vci/index.php/CPelayananData/getSiswa?kode_wilayah=120200&token=CD04B72E-17EB-4C2D-9421-DCF4240C7138&nisn=$nisn&npsn=$npsn");

                    curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "GET");
                    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
                    curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 30);
                    $send_data         = curl_exec($curlHandle);

                    $result = json_decode($send_data);


                    if (isset($result->error)) {
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal mengambil data.";
                        return json_encode($response);
                    }

                    if ($result) {
                        if (isset($result->message)) {
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = $result->message;
                            return json_encode($response);
                        } else {
                            if (count($result) > 0) {
                                $pdNya = $result[0];
                                $x['data'] = $pdNya;
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
                                $x['sek'] = $this->_db->table('dapo_sekolah')->select("lintang, bujur")->where('sekolah_id', $pdNya->sekolah_id)->get()->getRowObject();
                                $response = new \stdClass;
                                $response->status = 200;
                                $response->message = "Berhasil mengambil data";
                                $response->data = view('adm/masterdata/pd/addPd', $x);
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
                        $response->message = "Gagal mengambil data.";
                        return json_encode($response);
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
                        $response->data = view('adm/masterdata/pd/addPdBelum', $x);
                        return json_encode($response);
                    } else {
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Jenis pd tidak diketahui.";
                        return json_encode($response);
                    }
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
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session expired";
                return json_encode($response);
            }

            $lat = htmlspecialchars($this->request->getVar('lat'), true) ?? "";
            $long = htmlspecialchars($this->request->getVar('long'), true) ?? "";

            if ($lat == "" && $long == "") {
                $sek = $this->_db->table('dapo_sekolah')->select("lintang, bujur")->where('sekolah_id', $user->data->sekolah_id)->get()->getRowObject();
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
            $response->data = view('sek/verval/pd/maps', $x);
            return json_encode($response);
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
                $Profilelib = new Profilelib();
                $user = $Profilelib->user();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    return redirect()->to(base_url('auth'));
                }

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
                $Profilelib = new Profilelib();
                $user = $Profilelib->user();
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
                $user = $Profilelib->user();
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

    public function saveupload()
    {
        if ($this->request->isAJAX()) {
            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
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

    public function addSave()
    {
        if ($this->request->isAJAX()) {
            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session telah habis";
                return json_encode($response);
            }

            $rules = [
                '_data_pd' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'id tidak boleh kosong. ',
                    ]
                ],
                '_nik' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nik tidak boleh kosong. ',
                    ]
                ],
                '_kk' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'No KK tidak boleh kosong. ',
                    ]
                ],
                '_kab' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kabupaten tidak boleh kosong. ',
                    ]
                ],
                '_kec' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kecamatan tidak boleh kosong. ',
                    ]
                ],
                '_kel' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kelurahan tidak boleh kosong. ',
                    ]
                ],
                '_dusun' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Dusun tidak boleh kosong. ',
                    ]
                ],
                '_lintang' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Lintang tidak boleh kosong. ',
                    ]
                ],
                '_bujur' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Bujur tidak boleh kosong. ',
                    ]
                ],
                '_peserta_didik_id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Peserta didik id tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_data_pd')
                    . $this->validator->getError('_nik')
                    . $this->validator->getError('_kk')
                    . $this->validator->getError('_kab')
                    . $this->validator->getError('_kec')
                    . $this->validator->getError('_kel')
                    . $this->validator->getError('_dusun')
                    . $this->validator->getError('_lintang')
                    . $this->validator->getError('_bujur')
                    . $this->validator->getError('_peserta_didik_id');
                return json_encode($response);
            } else {

                $dataPd = htmlspecialchars($this->request->getVar('_data_pd'), true);
                $nik = htmlspecialchars($this->request->getVar('_nik'), true);
                $kk = htmlspecialchars($this->request->getVar('_kk'), true);
                $kab = htmlspecialchars($this->request->getVar('_kab'), true);
                $kec = htmlspecialchars($this->request->getVar('_kec'), true);
                $kel = htmlspecialchars($this->request->getVar('_kel'), true);
                $dusun = htmlspecialchars($this->request->getVar('_dusun'), true);
                $lintang = htmlspecialchars($this->request->getVar('_lintang'), true);
                $bujur = htmlspecialchars($this->request->getVar('_bujur'), true);
                $pdId = htmlspecialchars($this->request->getVar('_peserta_didik_id'), true);

                $oldData = $this->_db->table('dapo_peserta')->where('peserta_didik_id', $pdId)->get()->getRowObject();
                if ($oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Peserta didik sudah ada dengan Nisn: $oldData->nisn ($oldData->nama).";
                    return json_encode($response);
                }

                $dataPdFix = json_decode($dataPd);
                $refSeklah = $this->_db->table('dapo_sekolah')->where('sekolah_id', $dataPdFix->sekolah_id)->get()->getRowObject();
                if (!$refSeklah) {

                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Referensi sekolah asal PD tidak ditemukan.";
                    return json_encode($response);
                }


                $this->_db->transBegin();
                try {
                    $this->_db->table('dapo_peserta')->insert([
                        'peserta_didik_id' => $pdId,
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
                        'flag_pip' => $dataPdFix->flag_pip,
                        'dusun' => $dusun,
                        'lintang' => $lintang,
                        'bujur' => $bujur,
                        'is_edited' => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                    if ($this->_db->affectedRows() > 0) {
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
                            'username' => $dataPdFix->nisn,
                            'password' => $passwordFix,
                            'is_active' => 1,
                            'level' => 5,
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        $dataUserProfile = [
                            'user_id' => $dataUser['id'],
                            'peserta_didik_id' => $pdId,
                            'sekolah_id_asal' => $dataPdFix->sekolah_id,
                            'wilayah' => $kel,
                            'nama' => $dataPdFix->nama,
                            'nama_sekolah_asal' => $refSeklah->nama_sekolah,
                            'npsn_asal' => $refSeklah->npsn,
                            'tingkat_pendidikan_asal' => $dataPdFix->tingkat_pendidikan_id,
                            'acc_reg' => $password,
                            'created_at' => $dataUser['created_at']
                        ];

                        $this->_db->table('_users_tb')->insert($dataUser);
                        if ($this->_db->affectedRows() > 0) {
                            $this->_db->table('_users_profile_pd')->insert($dataUserProfile);
                            if ($this->_db->affectedRows() > 0) {

                                $this->_db->transCommit();

                                $response = new \stdClass;
                                $response->status = 200;
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
                    $response->message = "Gagal menyimpan data.";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function addSaveBelum()
    {
        if ($this->request->isAJAX()) {
            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session telah habis";
                return json_encode($response);
            }

            $rules = [
                '_tingkat_pendidikan_pd' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'tingkat pendidikan tidak boleh kosong. ',
                    ]
                ],
                '_sekolah_id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'sekolah id tidak boleh kosong. ',
                    ]
                ],
                '_nik' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nik tidak boleh kosong. ',
                    ]
                ],
                '_kk' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'No KK tidak boleh kosong. ',
                    ]
                ],
                '_nama_pd' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nama PD tidak boleh kosong. ',
                    ]
                ],
                '_tempat_lahir_pd' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Tempat Lahir PD tidak boleh kosong. ',
                    ]
                ],
                '_tanggal_lahir_pd' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Tanggal Lahir PD tidak boleh kosong. ',
                    ]
                ],
                '_jenis_kelamin_pd' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Jenis kelamin PD tidak boleh kosong. ',
                    ]
                ],
                '_nama_ibu_kandung_pd' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Nama ibu kandung PD tidak boleh kosong. ',
                    ]
                ],
                '_kab' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kabupaten tidak boleh kosong. ',
                    ]
                ],
                '_kec' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kecamatan tidak boleh kosong. ',
                    ]
                ],
                '_kel' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Kelurahan tidak boleh kosong. ',
                    ]
                ],
                '_dusun' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Dusun tidak boleh kosong. ',
                    ]
                ],
                '_lintang' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Lintang tidak boleh kosong. ',
                    ]
                ],
                '_bujur' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Bujur tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('_tingkat_pendidikan_pd')
                    . $this->validator->getError('_sekolah_id')
                    . $this->validator->getError('_nik')
                    . $this->validator->getError('_kk')
                    . $this->validator->getError('_nama_pd')
                    . $this->validator->getError('_tempat_lahir_pd')
                    . $this->validator->getError('_tanggal_lahir_pd')
                    . $this->validator->getError('_jenis_kelamin_pd')
                    . $this->validator->getError('_nama_ibu_kandung_pd')
                    . $this->validator->getError('_kab')
                    . $this->validator->getError('_kec')
                    . $this->validator->getError('_kel')
                    . $this->validator->getError('_dusun')
                    . $this->validator->getError('_lintang')
                    . $this->validator->getError('_bujur');
                return json_encode($response);
            } else {

                $tingkat_pendidikan = htmlspecialchars($this->request->getVar('_tingkat_pendidikan_pd'), true);
                $sekolah_id = htmlspecialchars($this->request->getVar('_sekolah_id'), true);
                $nama = htmlspecialchars($this->request->getVar('_nama_pd'), true);
                $tempat_lahir = htmlspecialchars($this->request->getVar('_tempat_lahir_pd'), true);
                $tanggal_lahir = htmlspecialchars($this->request->getVar('_tanggal_lahir_pd'), true);
                $jenis_kelamin = htmlspecialchars($this->request->getVar('_jenis_kelamin_pd'), true);
                $nama_ibu_kandung = htmlspecialchars($this->request->getVar('_nama_ibu_kandung_pd'), true);
                $nik = htmlspecialchars($this->request->getVar('_nik'), true);
                $kk = htmlspecialchars($this->request->getVar('_kk'), true);
                $kab = htmlspecialchars($this->request->getVar('_kab'), true);
                $kec = htmlspecialchars($this->request->getVar('_kec'), true);
                $kel = htmlspecialchars($this->request->getVar('_kel'), true);
                $dusun = htmlspecialchars($this->request->getVar('_dusun'), true);
                $lintang = htmlspecialchars($this->request->getVar('_lintang'), true);
                $bujur = htmlspecialchars($this->request->getVar('_bujur'), true);

                $anyUser = $this->_db->table('_users_tb')->where('username', $nik)->get()->getRowObject();
                if ($anyUser) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "NIK sudah terdaftar. Silahkan login dengan menggunakan NIK.";
                    return json_encode($response);
                }

                $refSeklah = $this->_db->table('dapo_sekolah')->where('sekolah_id', $sekolah_id)->get()->getRowObject();
                if (!$refSeklah) {

                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Referensi sekolah asal PD tidak ditemukan.";
                    return json_encode($response);
                }

                $uuidLib = new Uuid();

                $pdId = $uuidLib->v4();

                $this->_db->transBegin();
                try {
                    $this->_db->table('dapo_peserta')->insert([
                        'peserta_didik_id' => $pdId,
                        'sekolah_id' => $sekolah_id,
                        'nama' => $nama,
                        'tempat_lahir' => $tempat_lahir,
                        'tanggal_lahir' => $tanggal_lahir,
                        'jenis_kelamin' => $jenis_kelamin,
                        'nisn' => '-',
                        'nik' => $nik,
                        'no_kk' => $kk,
                        'kab' => $kab,
                        'kec' => $kec,
                        'kel' => $kel,
                        'kode_wilayah' => $kel,
                        'alamat_jalan' => '-',
                        'desa_kelurahan' => '-',
                        'rt' => 0,
                        'rw' => 0,
                        'nama_dusun' => '-',
                        'nama_ibu_kandung' => $nama_ibu_kandung,
                        'tingkat_pendidikan_id' => $tingkat_pendidikan,
                        'dusun' => $dusun,
                        'lintang' => $lintang,
                        'bujur' => $bujur,
                        'is_edited' => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                    if ($this->_db->affectedRows() > 0) {
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
                            'username' => $nik,
                            'password' => $passwordFix,
                            'is_active' => 1,
                            'level' => 5,
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        $dataUserProfile = [
                            'user_id' => $dataUser['id'],
                            'peserta_didik_id' => $pdId,
                            'sekolah_id_asal' => $sekolah_id,
                            'wilayah' => $kel,
                            'nama' => $nama,
                            'nama_sekolah_asal' => $refSeklah->nama_sekolah,
                            'npsn_asal' => $refSeklah->npsn,
                            'tingkat_pendidikan_asal' => $tingkat_pendidikan,
                            'acc_reg' => $password,
                            'created_at' => $dataUser['created_at']
                        ];

                        $this->_db->table('_users_tb')->insert($dataUser);
                        if ($this->_db->affectedRows() > 0) {
                            $this->_db->table('_users_profile_pd')->insert($dataUserProfile);
                            if ($this->_db->affectedRows() > 0) {

                                $this->_db->transCommit();

                                $response = new \stdClass;
                                $response->status = 200;
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
                    $response->message = "Gagal menyimpan data.";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
