<?php

namespace App\Controllers\Su\Masterdata;

use App\Controllers\BaseController;
use App\Models\Su\Masterdata\PdModel;
use App\Models\Su\Masterdata\SekolahpdModel;
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
        ini_set('max_execution_time', 180);
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
        return redirect()->to(base_url('su/masterdata/pd/data'));
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

        return view('su/masterdata/pd/sekolah', $data);
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
        $data['kecamatans'] = $this->_db->table('ref_kecamatan')->where('id_kabupaten', '120200')->orderBy('nama', 'ASC')->get()->getResult();

        return view('su/masterdata/pd/index', $data);
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
                $response->data = view('su/masterdata/pd/upload');
                return json_encode($response);
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


                $dataRow = [
                    'peserta_didik_id' => $peserta_didik_id,
                    'sekolah_id' => $sekolah_id,
                    'kode_wilayah' => $kode_wilayah,
                    'nama' => $nama,
                    'tempat_lahir' => $tempat_lahir,
                    'tanggal_lahir' => $tanggal_lahir,
                    'jenis_kelamin' => $jenis_kelamin,
                    'nik' => $nik == "" ? null : $nik,
                    'no_kk' => $no_kk == "" ? null : $no_kk,
                    'nisn' => $nisn == "" ? null : $nisn,
                    'kab' => $kode_wilayah == "" ? null : substr($kode_wilayah, 0, 4) . '00',
                    'kec' => $kode_wilayah == "" ? null : substr($kode_wilayah, 0, 6),
                    'kel' => $kode_wilayah == "" ? null : $kode_wilayah,
                    'alamat_jalan' => $alamat_jalan == "" ? null : $alamat_jalan,
                    'desa_kelurahan' => $desa_kelurahan == "" ? null : $desa_kelurahan,
                    'rt' => $rt == "" ? null : $rt,
                    'rw' => $rw == "" ? null : $rw,
                    'nama_dusun' => $nama_dusun == "" ? null : $nama_dusun,
                    'nama_ibu_kandung' => $nama_ibu_kandung == "" ? null : $nama_ibu_kandung,
                    'pekerjaan_ibu' => $pekerjaan_ibu == "" ? null : $pekerjaan_ibu,
                    'penghasilan_ibu' => $penghasilan_ibu == "" ? null : $penghasilan_ibu,
                    'nama_ayah' => $nama_ayah == "" ? null : $nama_ayah,
                    'pekerjaan_ayah' => $pekerjaan_ayah == "" ? null : $pekerjaan_ayah,
                    'penghasilan_ayah' => $penghasilan_ayah == "" ? null : $penghasilan_ayah,
                    'nama_wali' => $nama_wali == "" ? null : $nama_wali,
                    'pekerjaan_wali' => $pekerjaan_wali == "" ? null : $pekerjaan_wali,
                    'penghasilan_wali' => $penghasilan_wali == "" ? null : $penghasilan_wali,
                    'kebutuhan_khusus' => $kebutuhan_khusus == "" ? null : $kebutuhan_khusus,
                    'no_kip' => $no_kip == "" ? null : $no_kip,
                    'no_pkh' => $no_pkh == "" ? null : $no_pkh,
                    'lintang' => $lintang == "" ? null : $lintang,
                    'bujur' => $bujur == "" ? null : $bujur,
                    'flag_pip' => $flag_pip == "" ? null : $flag_pip,
                    'tingkat_pendidikan_id' => (int)$jenjang,
                    'created_at' => date('Y-m-d H:i:s'),
                ];



                $this->_db->transBegin();

                try {
                    // $this->_db->query("INSERT INTO dapo_peserta (peserta_didik_id, sekolah_id, kode_wilayah, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, nik, nisn, no_kk, kab, kec, kel, alamat_jalan, desa_kelurahan, rt, rw, nama_dusun, nama_ibu_kandung, pekerjaan_ibu, penghasil_ibu, nama_ayah, pekerjaan_ayah, penghasilan_ayah, nama_wali, pekerjaan_wali, penghasilan_wali, kebutuhan_khusus, no_kip, no_pkh, lintang, bujur, tingkat_pendidikan_id, flag_pip, created_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE nama = VALUES(nama), tempat_lahir = VALUES(tempat_lahir), tanggal_lahir = VALUES(tanggal_lahir), jenis_kelamin = VALUES(jenis_kelamin), nisn = VALUES(nisn), no_kip = VALUES(no_kip), no_pkh = VALUES(no_pkh), flag_pip = VALUES(flag_pip)", );
                    $this->_db->query("INSERT INTO dapo_peserta (peserta_didik_id, sekolah_id, kode_wilayah, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, nik, nisn, no_kk, kab, kec, kel, alamat_jalan, desa_kelurahan, rt, rw, nama_dusun, nama_ibu_kandung, pekerjaan_ibu, penghasilan_ibu, nama_ayah, pekerjaan_ayah, penghasilan_ayah, nama_wali, pekerjaan_wali, penghasilan_wali, kebutuhan_khusus, no_kip, no_pkh, lintang, bujur, tingkat_pendidikan_id, flag_pip, created_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE nama = VALUES(nama), tempat_lahir = VALUES(tempat_lahir), tanggal_lahir = VALUES(tanggal_lahir), jenis_kelamin = VALUES(jenis_kelamin), nisn = VALUES(nisn), no_kip = VALUES(no_kip), no_pkh = VALUES(no_pkh), flag_pip = VALUES(flag_pip)", [$dataRow['peserta_didik_id'], $dataRow['sekolah_id'], $dataRow['kode_wilayah'], $dataRow['nama'], $dataRow['tempat_lahir'], $dataRow['tanggal_lahir'], $dataRow['jenis_kelamin'], $dataRow['nik'], $dataRow['nisn'], $dataRow['no_kk'], $dataRow['kab'], $dataRow['kec'], $dataRow['kel'], $dataRow['alamat_jalan'], $dataRow['desa_kelurahan'], $dataRow['rt'], $dataRow['rw'], $dataRow['nama_dusun'], $dataRow['nama_ibu_kandung'], $dataRow['pekerjaan_ibu'], $dataRow['penghasilan_ibu'], $dataRow['nama_ayah'], $dataRow['pekerjaan_ayah'], $dataRow['penghasilan_ayah'], $dataRow['nama_wali'], $dataRow['pekerjaan_wali'], $dataRow['penghasilan_wali'], $dataRow['kebutuhan_khusus'], $dataRow['no_kip'], $dataRow['no_pkh'], $dataRow['lintang'], $dataRow['bujur'], $dataRow['tingkat_pendidikan_id'], $dataRow['flag_pip'], $dataRow['created_at']]);

                    // $this->_db->query(`INSERT INTO dapo_peserta (
                    //     peserta_didik_id, 
                    //     sekolah_id, 
                    //     kode_wilayah, 
                    //     nama, 
                    //     tempat_lahir, 
                    //     tanggal_lahir, 
                    //     jenis_kelamin, 
                    //     nik, 
                    //     nisn, 
                    //     no_kk, 
                    //     kab, 
                    //     kec, 
                    //     kel, 
                    //     alamat_jalan, 
                    //     desa_kelurahan, 
                    //     rt, 
                    //     rw, 
                    //     nama_dusun, 
                    //     nama_ibu_kandung, 
                    //     pekerjaan_ibu, 
                    //     penghasil_ibu, 
                    //     nama_ayah, 
                    //     pekerjaan_ayah, 
                    //     penghasilan_ayah, 
                    //     nama_wali, 
                    //     pekerjaan_wali, 
                    //     penghasilan_wali, 
                    //     kebutuhan_khusus, 
                    //     no_kip, 
                    //     no_pkh, 
                    //     lintang, 
                    //     bujur, 
                    //     tingkat_pendidikan_id, 
                    //     flag_pip, 
                    //     created_at) VALUES (
                    //     {$dataRow['peserta_didik_id']},
                    //     {$dataRow['sekolah_id']},
                    //     {$dataRow['kode_wilayah']},
                    //     {$dataRow['nama']},
                    //     {$dataRow['tempat_lahir']},
                    //     {$dataRow['tanggal_lahir']},
                    //     {$dataRow['jenis_kelamin']},
                    //     {$dataRow['nik']},
                    //     {$dataRow['nisn']},
                    //     {$dataRow['no_kk']},
                    //     {$dataRow['kab']},
                    //     {$dataRow['kec']},
                    //     {$dataRow['kel']},
                    //     {$dataRow['alamat_jalan']},
                    //     {$dataRow['desa_kelurahan']},
                    //     {$dataRow['rt']},
                    //     {$dataRow['rw']},
                    //     {$dataRow['nama_dusun']},
                    //     {$dataRow['nama_ibu_kandung']},
                    //     {$dataRow['pekerjaan_ibu']},
                    //     {$dataRow['penghasilan_ibu']},
                    //     {$dataRow['nama_ayah']},
                    //     {$dataRow['pekerjaan_ayah']},
                    //     {$dataRow['penghasilan_ayah']},
                    //     {$dataRow['nama_wali']},
                    //     {$dataRow['pekerjaan_wali']},
                    //     {$dataRow['penghasilan_wali']},
                    //     {$dataRow['kebutuhan_khusus']},
                    //     {$dataRow['no_kip']},
                    //     {$dataRow['no_pkh']},
                    //     {$dataRow['lintang']},
                    //     {$dataRow['bujur']},
                    //     {$dataRow['tingkat_pendidikan_id']},
                    //     {$dataRow['flag_pip']},
                    //     {$dataRow['created_at']}) ON DUPLICATE KEY UPDATE
                    //     nama = {$dataRow['nama']},
                    //     tempat_lahir = {$dataRow['tempat_lahir']},
                    //     tanggal_lahir = {$dataRow['tanggal_lahir']},
                    //     jenis_kelamin = {$dataRow['jenis_kelamin']},
                    //     nisn = {$dataRow['nisn']},
                    //     no_kip = {$dataRow['no_kip']},
                    //     no_pkh = {$dataRow['no_pkh']}
                    //     `);



                    // $oldData = $this->_db->table('dapo_peserta')->where('peserta_didik_id', $peserta_didik_id)->countAllResults();
                    // if ($oldData > 0) {

                    //     $dataTidakDitemukan++;
                    //     continue;
                    // }

                    // $this->_db->table('dapo_peserta')->insert($dataRow);
                    if ($this->_db->affectedRows() > 0) {

                        $this->_db->transCommit();
                        $dataBerhasil++;
                        continue;
                    } else {
                        $this->_db->transRollback();
                        // $this->_db->table('gagal_upload_import')->insert([
                        //     'data' => json_encode($dataRow),
                        //     'keterangan' => "Tidak ada perubahan disimpan."
                        // ]);
                        $dataGagal++;
                        continue;
                    }
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    // $this->_db->table('gagal_upload_import')->insert([
                    //     'data' => json_encode($dataRow),
                    //     'keterangan' => "error catch"
                    // ]);
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
            $response->data = "Jumlah data yang disimpan adalah Berhasil: $dataBerhasil, Gagal: $dataGagal, Sudah ada: $dataTidakDitemukan";
            return json_encode($response);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function phpinfo()
    {
        phpinfo();
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Id tidak boleh kosong. ',
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
                $nama = htmlspecialchars($this->request->getVar('nama'), true);

                $oldData = $this->_db->table('dapo_peserta')->where('peserta_didik_d', $id)->get()->getRowObject();

                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data tidak ditemukan.";
                    return json_encode($response);
                }

                if (substr($oldData->nisn, 0, 2) != 'BS') {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data peserta yang bukan belum sekolah, tidak dapat dihapus.";
                    return json_encode($response);
                }

                $this->_db->transBegin();
                try {
                    $this->_db->table('dapo_peserta')->where('peserta_didik_id', $oldData->id)->delete();
                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->transCommit();

                        $response = new \stdClass;
                        $response->status = 200;
                        $response->url = base_url('portal');
                        $response->message = "Data berhasil dihapus.";
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
                    $response->message = "Gagal mengupdate data. with error";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
