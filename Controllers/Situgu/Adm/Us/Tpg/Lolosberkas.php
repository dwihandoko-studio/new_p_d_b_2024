<?php

namespace App\Controllers\Situgu\Adm\Us\Tpg;

use App\Controllers\BaseController;
use App\Models\Situgu\Adm\Tpg\LolosberkasModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;
use App\Libraries\Situgu\Kehadiranptklib;
use App\Libraries\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class Lolosberkas extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;
    private $model;
    private $_helpLib;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
        $this->_helpLib = new Helplib();
    }

    public function getAll()
    {
        $request = Services::request();
        $datamodel = new LolosberkasModel($request);

        $jwt = get_cookie('jwt');
        $token_jwt = getenv('token_jwt.default.key');
        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
                if ($decoded) {
                    $userId = $decoded->id;
                    $level = $decoded->level;
                } else {
                    $output = [
                        "draw" => $request->getPost('draw'),
                        "recordsTotal" => 0,
                        "recordsFiltered" => 0,
                        "data" => []
                    ];
                    echo json_encode($output);
                    return;
                }
            } catch (\Exception $e) {
                $output = [
                    "draw" => $request->getPost('draw'),
                    "recordsTotal" => 0,
                    "recordsFiltered" => 0,
                    "data" => []
                ];
                echo json_encode($output);
                return;
            }
        }

        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            // $action = '<div class="btn-group">
            //             <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
            //             <div class="dropdown-menu" style="">
            //                 <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
            //                 <a class="dropdown-item" href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><i class="bx bx-transfer-alt font-size-16 align-middle"></i> &nbsp;Sync Dapodik</a>
            //             </div>
            //         </div>';
            $action = '<a href="javascript:actionDetail(\'' . $list->id_usulan . '\', \'' . $list->id_ptk . '\', \'' . $list->id_tahun_tw . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama)) . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                <i class="bx bxs-show font-size-16 align-middle"></i> DETAIL</button>
                </a>';
            //     <a href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-transfer-alt font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-trash font-size-16 align-middle"></i></button>
            //     </a>';
            $row[] = $action;
            $row[] = str_replace('&#039;', "`", str_replace("'", "`", $list->nama));
            $row[] = $list->nik;
            $row[] = $list->nuptk;
            $row[] = $list->jenis_ptk;
            $row[] = $list->date_approve;

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
        return redirect()->to(base_url('situgu/adm/us/tpg/lolosberkas/data'));
    }

    public function data()
    {
        $data['title'] = 'USULAN LOLOS BERKAS TUNJANGAN PROFESI GURU';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }
        $id = $this->_helpLib->getPtkId($user->data->id);
        $data['user'] = $user->data;
        $data['tw'] = $this->_db->table('_ref_tahun_tw')->where('is_current', 1)->orderBy('tahun', 'desc')->orderBy('tw', 'desc')->get()->getRowObject();
        $data['tws'] = $this->_db->table('_ref_tahun_tw')->orderBy('tahun', 'desc')->orderBy('tw', 'desc')->get()->getResult();
        return view('situgu/adm/us/tpg/lolosberkas/index', $data);
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
            'id_ptk' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id PTK tidak boleh kosong. ',
                ]
            ],
            'tw' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'TW tidak boleh kosong. ',
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
                . $this->validator->getError('id_ptk')
                . $this->validator->getError('tw')
                . $this->validator->getError('nama');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $id_ptk = htmlspecialchars($this->request->getVar('id_ptk'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);

            $current = $this->_db->table('v_lolosberkas_usulan_tpg a')
                ->select("a.*, b.kecamatan as kecamatan_sekolah")
                ->join('ref_sekolah b', 'a.npsn = b.npsn')
                ->where(['a.id_usulan' => $id, 'a.id_tahun_tw' => $tw])->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $data['penugasans'] = $this->_db->table('_ptk_tb_dapodik a')
                    ->select("a.*, b.npsn, b.nama as namaSekolah, b.kecamatan as kecamatan_sekolah, (SELECT SUM(jam_mengajar_per_minggu) FROM _pembelajaran_dapodik WHERE ptk_id = a.ptk_id AND sekolah_id = a.sekolah_id AND semester_id = a.semester_id) as jumlah_total_jam_mengajar_perminggu")
                    ->join('ref_sekolah b', 'a.sekolah_id = b.id')
                    ->where('a.ptk_id', $current->id_ptk)
                    ->where("a.jenis_keluar IS NULL")
                    ->orderBy('a.ptk_induk', 'DESC')->get()->getResult();
                $data['igd'] = $this->_db->table('_info_gtk')->where('ptk_id', $current->id_ptk)->get()->getRowObject();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situgu/adm/us/tpg/detail-lolos', $data);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function download()
    {
        $tw = htmlspecialchars($this->request->getGet('tw'), true);
        if ($tw == "") {
            return view('404');
        }

        try {

            $spreadsheet = new Spreadsheet();

            // $spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            // $spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            // Membuat objek worksheet
            $worksheet = $spreadsheet->getActiveSheet();

            // Menulis nama kolom ke dalam baris pertama worksheet
            $worksheet->fromArray(['NO', 'NUPTK', 'NAMA', 'TEMPAT TUGAS', 'NIP', 'GOL', 'MASA KERJA TAHUN', 'GAJI POKOK PP.15', 'JML. BLN', 'JML.UANG', 'IURAN BPJS 1%', 'PPH.21', 'JML. DITERIMA', 'NO REKENING', 'NPSN', 'KECAMATAN', 'JENJANG SEKOLAH', 'KETERANGAN', 'VERIFIKATOR'], NULL, 'A3');

            // Mengambil data dari database
            $dataTw = $this->_db->table('_ref_tahun_tw')->where('id', $tw)->get()->getRowObject();
            $query = $this->_db->table('_tb_usulan_detail_tpg a')
                ->select("a.id as id_usulan, a.us_pang_golongan, a.us_pang_mk_tahun, a.us_pang_mk_bulan, a.us_gaji_pokok, a.date_approve, a.kode_usulan, a.id_ptk, a.id_tahun_tw, a.status_usulan, a.date_approve_sptjm, b.nama, b.nik, CONCAT('\'', b.nip) as nip, b.tempat_tugas, b.npsn, CONCAT('\'',b.no_rekening) as no_rekening, CONCAT('\'', b.nuptk) as nuptk, b.jenis_ptk, c.kecamatan, c.bentuk_pendidikan, d.fullname as verifikator, e.cuti as lampiran_cuti, e.pensiun as lampiran_pensiun, e.kematian as lampiran_kematian")
                ->join('_ptk_tb b', 'a.id_ptk = b.id')
                ->join('ref_sekolah c', 'b.npsn = c.npsn')
                ->join('_profil_users_tb d', 'a.admin_approve = d.id')
                ->join('_upload_data_attribut e', 'a.id_ptk = e.id_ptk AND (a.id_tahun_tw = e.id_tahun_tw)')
                ->where('a.status_usulan', 2)
                ->where('a.id_tahun_tw', $tw)
                ->get();

            // Menulis data ke dalam worksheet
            $data = $query->getResult();
            $row = 4;
            if (count($data) > 0) {
                foreach ($data as $key => $item) {
                    $keterangan = "";
                    $pph = "0%";
                    $pph21 = 0;
                    if ($item->us_pang_golongan == NULL || $item->us_pang_golongan == "") {
                    } else {
                        $pang = explode("/", $item->us_pang_golongan);
                        if ($pang[0] == "III" || $pang[0] == "IX") {
                            $pph21 = (5 / 100);
                            $pph = "5%";
                        } else if ($pang[0] == "IV") {
                            $pph21 = (15 / 100);
                            $pph = "15%";
                        } else {
                            $pph21 = 0;
                            $pph = "0%";
                        }
                    }

                    if (($item->lampiran_cuti == NULL || $item->lampiran_cuti == "") && ($item->lampiran_pensiun == NULL || $item->lampiran_pensiun == "") && ($item->lampiran_kematian == NULL || $item->lampiran_kematian == "")) {
                        $keterangan .= "- ";
                    }

                    if (!($item->lampiran_cuti == NULL || $item->lampiran_cuti == "")) {
                        $keterangan .= "Cuti ";
                    }

                    if (!($item->lampiran_pensiun == NULL || $item->lampiran_pensiun == "")) {
                        $keterangan .= "Pensiun ";
                    }

                    if (!($item->lampiran_kematian == NULL || $item->lampiran_kematian == "")) {
                        $keterangan .= "Kematian ";
                    }

                    $itemCreate = [
                        $key + 1,
                        substr($item->nuptk, 0),
                        $item->nama,
                        $item->tempat_tugas,
                        substr($item->nip, 0),
                        $item->us_pang_golongan,
                        $item->us_pang_mk_tahun,
                        $item->us_gaji_pokok,
                        3,
                        $item->us_gaji_pokok * 3,
                        ($item->us_gaji_pokok * 3) * 0.01,
                        ($item->us_gaji_pokok * 3) * $pph21,
                        ($item->us_gaji_pokok * 3) - (($item->us_gaji_pokok * 3) * 0.01) - (($item->us_gaji_pokok * 3) * $pph21),
                        substr($item->no_rekening, 0),
                        $item->npsn,
                        $item->kecamatan,
                        $item->bentuk_pendidikan,
                        $keterangan,
                        $item->verifikator,
                    ];
                    // $worksheet->getStyle('B' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                    // $worksheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                    // $worksheet->getStyle('N' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                    // $worksheet->getStyle('O' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                    $worksheet->fromArray($itemCreate, NULL, 'A' . $row);
                    // $worksheet->getStyle('B' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                    // $worksheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                    // $worksheet->getStyle('N' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                    // $worksheet->getStyle('O' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                    $row++;
                }
            }

            // Menyiapkan objek writer untuk menulis file Excel
            $writer = new Xlsx($spreadsheet);

            // Menuliskan file Excel
            $filename = 'data_lolosberkas_usulan_tpg_tahun_' . $dataTw->tahun . '_tw_' . $dataTw->tw . '.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit();
            //code...
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }
}
