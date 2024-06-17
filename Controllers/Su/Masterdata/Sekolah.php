<?php

namespace App\Controllers\Su\Masterdata;

use App\Controllers\BaseController;
use App\Models\Su\Masterdata\SekolahModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Sekolah extends BaseController
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
        $datamodel = new SekolahModel($request);


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
                                <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->sekolah_id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                                <a class="dropdown-item" href="javascript:actionResetPassword(\'' . $list->sekolah_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="bx bx-key font-size-16 align-middle"></i> &nbsp;Reset Password</a>
                                <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->sekolah_id . '\', \'' . str_replace("'", "", $list->nama)  . '\');"><i class="bx bx-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
                                <div class="dropdown-divider"></div>
                            </div>
                        </div>';

            $row[] = $action;
            $row[] = $list->nama;
            $row[] = $list->npsn;
            $row[] = $list->bentuk_pendidikan;
            $row[] = $list->kecamatan;
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
        return redirect()->to(base_url('su/masterdata/sekolah/data'));
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

        return view('su/masterdata/sekolah/index', $data);
    }

    public function getWilayahShow()
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

            $wilayahs = $this->_db->table('ref_kecamatan')
                ->get()->getResult();

            if ($wilayahs) {
                $data['wilayahs'] = $wilayahs;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situgu/su/masterdata/pengguna/wilayahs', $data);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function detail()
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

            $current = $this->_db->table('_users_tb')
                ->where('uid', $id)->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('a/setting/pengguna/detail', $data);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
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
                $response->data = view('su/masterdata/sekolah/upload');
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

                $sekolah_id = $formData[$i][0];
                $npsn = $formData[$i][1];
                $nama = $formData[$i][2];
                $kode_wilayah = $formData[$i][3];
                $bentuk_pendidikan_id = $formData[$i][4];
                $status_sekolah = $formData[$i][5];
                $alamat_jalan = $formData[$i][6];
                $desa_kelurahan = $formData[$i][7];
                $rt = $formData[$i][8];
                $rw = $formData[$i][9];
                $lintang = $formData[$i][10];
                $bujur = $formData[$i][11];

                $this->_db->transBegin();
                $dataRow = [
                    'sekolah_id' => $sekolah_id,
                    'npsn' => $npsn,
                    'nama' => $nama,
                    'kode_wilayah' => $kode_wilayah,
                    'bentuk_pendidikan_id' => $bentuk_pendidikan_id,
                    'status_sekolah_id' => $status_sekolah,
                    'alamat_jalan' => $alamat_jalan == "" ? NULL : $alamat_jalan,
                    'desa_kelurahan' => $desa_kelurahan == "" ? NULL : $desa_kelurahan,
                    'rt' => $rt == "" ? NULL : $rt,
                    'rw' => $rw == "" ? NULL : $rw,
                    'lintang' => $lintang == "" ? NULL : $lintang,
                    'bujur' => $bujur == "" ? NULL : $bujur,
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                try {
                    $this->_db->table('dapo_sekolah')->insert($dataRow);
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
}
