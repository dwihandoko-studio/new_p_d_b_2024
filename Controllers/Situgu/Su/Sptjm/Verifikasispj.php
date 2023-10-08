<?php

namespace App\Controllers\Situgu\Su\Sptjm;

use App\Controllers\BaseController;
use App\Models\Situgu\Su\SptjmverifikasispjModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Helplib;
use App\Libraries\Downloadlib;
// use Smalot\PdfParser\Parser;
// use Smalot\PdfParser\Element\Image;
// use Smalot\PdfParser\Element\Text;
// use Smalot\PdfParser\Element\Rectangle;
// use Smalot\PdfParser\Element\Table;
// use Spatie\PdfToText\Pdf;
// use TCPDF;
// use setasign\Fpdi\Fpdi;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use mPDF;
use PhpOffice\PhpWord\TemplateProcessor;

class Verifikasispj extends BaseController
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
        $datamodel = new SptjmverifikasispjModel($request);

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
            $action = '<div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                        <div class="dropdown-menu" style="">
                            <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->kode_verifikasi . '\', \'' . $list->kode_usulan . '\', \'' . $list->id_tahun_tw . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>';
            $action .= '</div>
                    </div>';
            // $action = '<a href="javascript:actionDetail(\'' . $list->id . '\', \'' . $list->kode_usulan . '\', \'' . $list->id_tahun_tw . '\', \'' . str_replace("'", "", $list->nama) . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bxs-show font-size-16 align-middle"></i> DETAIL</button>
            //     </a>';
            //     <a href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-transfer-alt font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-trash font-size-16 align-middle"></i></button>
            //     </a>';
            $row[] = $action;
            $row[] = $list->fullname;
            $row[] = $list->jabatan;
            $row[] = strtoupper($list->jenis_usulan);
            $row[] = $list->kode_verifikasi;
            $row[] = $list->tahun;
            $row[] = $list->tw;
            $row[] = $list->jumlah_ptk;
            if ($list->is_locked == 1) {
                $row[] = '<a target="popup" onclick="window.open(\'' . base_url('upload/verifikasi/sptjm') . '/' . $list->lampiran_sptjm . '\',\'popup\',\'width=600,height=600\'); return false;" href="' . base_url('upload/verifikasi/sptjm') . '/' . $list->lampiran_sptjm . '"><span class="badge rounded-pill badge-soft-dark">Lihat</span></a>';
            } else {
                if ($list->lampiran_sptjm == null || $list->lampiran_sptjm == "") {
                    $row[] = '<span class="badge rounded-pill badge-soft-danger">Belum Generate / Upload</span>';
                } else {
                    $row[] = '<a target="popup" onclick="window.open(\'' . base_url('upload/verifikasi/sptjm') . '/' . $list->lampiran_sptjm . '\',\'popup\',\'width=600,height=600\'); return false;" href="' . base_url('upload/verifikasi/sptjm') . '/' . $list->lampiran_sptjm . '"><span class="badge rounded-pill badge-soft-dark">Lihat</span></a>';
                }
            }

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
        return redirect()->to(base_url('situgu/su/sptjm/verifikasispj/data'));
    }

    public function data()
    {
        $data['title'] = 'SPTJM VERIFIKASI SPJ ADMIN, OPK, DAN OPSR';
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
        return view('situgu/su/sptjm/verifikasispj/index', $data);
    }
    public function detail()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            $response = new \stdClass;
            $response->status = 401;
            $response->message = "Session telah habis";
            $response->redirect = base_url('auth');
            return json_encode($response);
        }

        $rules = [
            'id' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id tidak boleh kosong. ',
                ]
            ],
            'tw' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'TW tidak boleh kosong. ',
                ]
            ],
            'tahun' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tahun tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('tahun')
                . $this->validator->getError('tw');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);
            $tahun = htmlspecialchars($this->request->getVar('tahun'), true);

            $currents = $this->_db->table('_tb_sptjm_verifikasi a')
                ->select("a.id, a.kode_verifikasi, a.kode_usulan, a.lampiran_sptjm, a.id_ptks, a.id_tahun_tw, a.aksi, a.keterangan, a.created_at, b.nama as nama_ptk, b.nuptk, b.npsn, b.tempat_tugas as nama_sekolah")
                ->join('_ptk_tb b', 'a.id_ptks = b.id')
                ->where('kode_verifikasi', $id)
                ->get()->getResult();

            if (count($currents) < 1) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "SPTJM tidak ditemukan. Silahkan Generate terlebih dahulu.";
                return json_encode($response);
            }

            $data['data'] = $currents;
            $data['tw'] = $tw;
            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('situgu/su/sptjm/verifikasispj/detail', $data);
            return json_encode($response);
        }
    }
}
