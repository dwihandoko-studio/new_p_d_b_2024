<?php

namespace App\Controllers\Adm\Layanan;

use App\Controllers\BaseController;
use App\Models\Adm\Layanan\PdModel;
use App\Models\Adm\Masterdata\SekolahpdModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use setasign\Fpdi\TcpdfFpdi;

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

    public function getAllTkAkhir()
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
            // $action = '<div class="btn-group">
            //                 <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
            //                 <div class="dropdown-menu" style="">
            //                     <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->peserta_didik_id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
            //                     <a class="dropdown-item" href="javascript:actionResetPassword(\'' . $list->peserta_didik_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="bx bx-key font-size-16 align-middle"></i> &nbsp;Reset Password</a>
            //                     <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->peserta_didik_id . '\', \'' . str_replace("'", "", $list->nama)  . '\');"><i class="bx bx-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
            //                     <div class="dropdown-divider"></div>
            //                 </div>
            //             </div>';
            $action = '<a class="btn btn-primary" href="./edit?id=' . $list->peserta_didik_id . '&t=' . $list->sekolah_id . '"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>';

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
        return redirect()->to(base_url('adm/layanan/pd/data'));
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

        return view('adm/layanan/pd/sekolah', $data);
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
        $data['id'] = $id;
        $data['sekolah'] = $name;
        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;

        return view('adm/layanan/pd/index', $data);
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
                $response->data = view('adm/layanan/pd/add');
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
                    curl_setopt($curlHandle, CURLOPT_TIMEOUT, 60);
                    curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 60);
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
                        $response->data = view('adm/layanan/pd/addPdBelum', $x);
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

    public function edit()
    {
        $data['title'] = 'EDIT DOMISILI PESERTA DIDIK';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $id = htmlspecialchars($this->request->getGet('id'), true);
        $sekolah_id = htmlspecialchars($this->request->getGet('t'), true);
        $data['id'] = $id;
        $data['sekolah_id'] = $sekolah_id;

        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;

        return view('adm/layanan/pd/edit', $data);
    }

    public function cekDataRefSekolah()
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

                $refSekolah = $this->_db->table('ref_sekolah')->where('id', $id)->get()->getRowObject();

                if ($refSekolah) {
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
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Permintaan diizinkan";
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
                    $response->data = view('adm/layanan/pd/form_edit', $x);
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
            $response->data = view('adm/layanan/pd/maps', $x);
            return json_encode($response);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function editSave()
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
                        $response->nama = $oldData->nama;
                        $response->peserta_didik_id = $oldData->peserta_didik_id;
                        $response->sekolah_id = $oldData->sekolah_id;
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

                $dataPd = $this->request->getVar('_data_pd');
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
                $dataPdf = decrypt_json_data($dataPd, 'secret key handokowae.my.id');

                $dataPdFix = json_decode($dataPdf);
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

                $tglLahirReplace = str_replace("-", "", $tanggal_lahir);
                $tglLahirConvert = substr($tglLahirReplace, 2, 8);
                $totalNisn = $this->_db->table('dapo_peserta')->where("LEFT(nisn,8) = 'BS$tglLahirConvert'")->countAllResults();

                if ($totalNisn > 0) {
                    $totalSumNisn = $totalNisn + 1;
                    if ($totalSumNisn > 9) {
                        $urutNisn = $totalSumNisn;
                    } else {
                        $urutNisn = '0' . $totalSumNisn;
                    }
                } else {
                    $urutNisn = '01';
                }

                $nisnCreate = "BS" . $tglLahirConvert . $urutNisn;

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
                        'nisn' => $nisnCreate,
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
                        // $password = $randomString;
                        $password = "123456";
                        $passwordFix = password_hash("123456", PASSWORD_BCRYPT);

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
                            'nama_sekolah_asal' => $refSeklah->nama,
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
                                $response->peserta_didik_id = $pdId;
                                $response->nama = $nama;
                                $response->message = "Username: menggunakan NIK  Password: default(123456).";
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

    public function generate()
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

                            $response = new \stdClass;
                            $response->status = 200;
                            $response->peserta_didik_id = $oldData->peserta_didik_id;
                            $response->nama = $oldData->nama;
                            $response->message = "Data akun berhasil digenerate.";
                            return json_encode($response);
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
                $user = $Profilelib->user();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session expired";
                    return json_encode($response);
                }

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
                $pdf->MultiCell(70, 20, "PANITIA PPDB DINAS,", 0, 'L', false, 1, 130, null, true, 0, true);
                $pdf->Ln(10);
                $pdf->MultiCell(70, 20, $user->data->nama, 0, 'L', false, 1, 130, null, true, 0, true);

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
}
