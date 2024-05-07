<?php

namespace App\Controllers\Sigaji\Bank\Tagihan;

use App\Controllers\BaseController;
use App\Models\Sigaji\Bank\Tagihan\AntrianModel;
use App\Models\Sigaji\Bank\Tagihan\AntriandetailModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Sigaji\Apilib;
use App\Libraries\Helplib;
use App\Libraries\Uuid;

class Antrian
extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;
    private $model;
    private $_helpLib;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect('sigaji');
        $this->_helpLib = new Helplib();
    }

    public function getAll()
    {
        $request = Services::request();
        $datamodel = new AntrianModel($request);
        // $datamodel = new AntriandetailModel($request);
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            ];
            echo json_encode($output);
            return;
        }

        $id_bank = $this->_helpLib->getIdBank($user->data->id);

        $lists = $datamodel->get_datatables($id_bank);
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                        <div class="dropdown-menu" style="">
                            <a class="dropdown-item" href="./datadetail?d=' . $list->id_tahun . '"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                        </div>
                    </div>';
            // $action = '<a href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bxs-show font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionSync(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-transfer-alt font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-trash font-size-16 align-middle"></i></button>
            //     </a>';
            $row[] = $action;
            $row[] = $list->tahun . '-' . $list->bulan;
            $row[] = $list->jumlah_pegawai;
            $row[] = $list->jumlah_tagihan;

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all($id_bank),
            "recordsFiltered" => $datamodel->count_filtered($id_bank),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function getAllDetail()
    {
        $request = Services::request();
        $datamodel = new AntrianModel($request);
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            ];
            echo json_encode($output);
            return;
        }

        $id_bank = $this->_helpLib->getIdBank($user->data->id);

        $lists = $datamodel->get_datatables($id_bank);
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                        <div class="dropdown-menu" style="">
                            <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id_pegawai . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama)) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                        </div>
                    </div>';
            // $action = '<a href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bxs-show font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionSync(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-transfer-alt font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-trash font-size-16 align-middle"></i></button>
            //     </a>';
            $row[] = $action;
            $row[] = $list->tahun . '-' . $list->bulan;
            $row[] = $list->nama;
            $row[] = $list->nip;
            $row[] = $list->instansi;
            $row[] = $list->kecamatan;
            $row[] = $list->besar_pinjaman;
            $row[] = $list->jumlah_tagihan;
            $row[] = $list->jumlah_bulan_angsuran;
            $row[] = $list->angsuran_ke;

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all($id_bank),
            "recordsFiltered" => $datamodel->count_filtered($id_bank),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        return redirect()->to(base_url('sigaji/bank/tagihan/antrian/data'));
    }

    public function data()
    {
        $data['title'] = 'DATA TAGIHAN BANK';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $data['tw'] = $this->_db->table('_ref_tahun_bulan')->where('is_current', 1)->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get()->getRowObject();
        $data['tws'] = $this->_db->table('_ref_tahun_bulan')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get()->getResult();

        return view('sigaji/bank/tagihan/antrian/index', $data);
    }

    public function datadetail()
    {
        $data['title'] = 'DATA DETAIL TAGIHAN BANK';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $tw = htmlspecialchars($this->request->getGet('d'), TRUE);
        $data['tw_active'] = $tw;
        $data['tw'] = $this->_db->table('_ref_tahun_bulan')->where('id', $tw)->get()->getRowObject();
        // $data['tws'] = $this->_db->table('_ref_tahun_bulan')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get()->getResult();
        $id_bank = $this->_helpLib->getIdBank($user->data->id);
        $data['datas'] = $this->_db->table('tb_tagihan_bank_antrian a')
            ->select("a.id, a.id_pegawai, a.instansi, a.kecamatan, a.besar_pinjaman, a.jumlah_tagihan, a.jumlah_bulan_angsuran, a.angsuran_ke, a.tahun, b.nama, b.nip, b.golongan, b.no_rekening_bank, b.kode_instansi, b.nama_instansi, b.nama_kecamatan, c.tahun, c.bulan")
            ->join('_ref_tahun_bulan c', 'a.tahun = c.id')
            ->join('tb_pegawai_ b', 'a.id_pegawai = b.id')
            ->where('a.dari_bank', $id_bank)
            ->where('a.tahun', $tw)
            ->countAllResults();

        // var_dump($data);
        // die;

        return view('sigaji/bank/tagihan/antrian/index_detail', $data);
    }

    public function ambiltagihan()
    {
        if ($this->request->isAJAX()) {
            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                return redirect()->to(base_url('auth'));
            }

            $id = htmlspecialchars($this->request->getVar('id'), true);
            $d['tw_active'] = $id;
            $d['tw'] = $this->_db->table('_ref_tahun_bulan')->where('id', $id)->get()->getRowObject();
            $d['tws'] = $this->_db->table('_ref_tahun_bulan')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get()->getResult();
            $id_bank = $this->_helpLib->getIdBank($user->data->id);
            $d['datas'] = $this->_db->table('tb_tagihan_bank a')
                ->select("a.id, a.id_pegawai, a.instansi, a.kecamatan, a.besar_pinjaman, a.jumlah_tagihan, a.jumlah_bulan_angsuran, a.angsuran_ke, a.tahun, b.nama, b.nip, b.golongan, b.no_rekening_bank, b.kode_instansi, b.nama_instansi, b.nama_kecamatan, c.tahun, c.bulan")
                ->join('_ref_tahun_bulan c', 'a.tahun = c.id')
                ->join('tb_pegawai_ b', 'a.id_pegawai = b.id')
                ->where('a.dari_bank', $id_bank)
                ->where('a.tahun', $id)
                ->orderBy('b.nama', 'ASC')
                ->get()->getResult();

            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('sigaji/bank/tagihan/antrian/form_ambil_tagihan', $d);
            return json_encode($response);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function ambildatatagihan()
    {
        if ($this->request->isAJAX()) {
            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                return redirect()->to(base_url('auth'));
            }

            $id = htmlspecialchars($this->request->getVar('id'), true);
            $tahun = htmlspecialchars($this->request->getVar('tahun'), true);
            $d['tw_active'] = $id;
            $d['tw'] = $this->_db->table('_ref_tahun_bulan')->where('id', $id)->get()->getRowObject();
            // $data['tws'] = $this->_db->table('_ref_tahun_bulan')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get()->getResult();
            $id_bank = $this->_helpLib->getIdBank($user->data->id);
            $d['bank_id'] = $id_bank;
            $d['tahun_dipilih'] = $tahun;
            $d['datas'] = $this->_db->table('tb_tagihan_bank a')
                ->select("a.id, a.id_pegawai, a.instansi, a.kecamatan, a.besar_pinjaman, a.jumlah_tagihan, a.jumlah_bulan_angsuran, a.angsuran_ke, a.tahun, b.nama, b.nip, b.golongan, b.no_rekening_bank, b.kode_instansi, b.nama_instansi, b.nama_kecamatan, c.tahun, c.bulan")
                ->join('_ref_tahun_bulan c', 'a.tahun = c.id')
                ->join('tb_pegawai_ b', 'a.id_pegawai = b.id')
                ->where('a.dari_bank', $id_bank)
                ->where('a.tahun', $tahun)
                ->orderBy('b.nama', 'ASC')
                ->get()->getResult();

            // var_dump($d);
            // die;

            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('sigaji/bank/tagihan/antrian/content_add_ambil_tagihan', $d);
            return json_encode($response);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function ambildataadd()
    {
        if ($this->request->isAJAX()) {
            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                return redirect()->to(base_url('auth'));
            }

            $id = htmlspecialchars($this->request->getVar('id'), true);
            $d['tw_active'] = $id;
            $d['tw'] = $this->_db->table('_ref_tahun_bulan')->where('id', $id)->get()->getRowObject();
            // $data['tws'] = $this->_db->table('_ref_tahun_bulan')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get()->getResult();
            $id_bank = $this->_helpLib->getIdBank($user->data->id);
            $d['datas'] = $this->_db->table('tb_tagihan_bank_antrian a')
                ->select("a.id, a.id_pegawai, a.instansi, a.kecamatan, a.besar_pinjaman, a.jumlah_tagihan, a.jumlah_bulan_angsuran, a.angsuran_ke, a.tahun, b.nama, b.nip, b.golongan, b.no_rekening_bank, b.kode_instansi, b.nama_instansi, b.nama_kecamatan, c.tahun, c.bulan")
                ->join('_ref_tahun_bulan c', 'a.tahun = c.id')
                ->join('tb_pegawai_ b', 'a.id_pegawai = b.id')
                ->where('a.dari_bank', $id_bank)
                ->where('a.tahun', $id)
                ->orderBy('b.nama', 'ASC')
                ->get()->getResult();

            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('sigaji/bank/tagihan/antrian/content_add', $d);
            return json_encode($response);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function savetagihan()
    {
        if ($this->request->isAJAX()) {
            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                return redirect()->to(base_url('auth'));
            }

            $jsonData = htmlspecialchars($this->request->getVar('data'), true);
            $formData = json_decode($jsonData, true);

            if (count($formData) !== 9) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data yang dikirim tidak valid. Pegawai tidak ditemukan.";
                return json_encode($response);
            }

            $id = $formData['id'];
            $nips = $formData['_filter_pegawai'];
            $instansis = $formData['instansi'];
            $kecamatans = $formData['kecamatan'];
            $jumlah_pinjamans = $formData['jumlah_pinjaman'];
            $jumlah_tagihans = $formData['jumlah_tagihan'];
            $jumlah_bulan_angsurans = $formData['jumlah_bulan_angsuran'];
            $angsuran_kes = $formData['angsuran_ke'];

            // $id = htmlspecialchars($this->request->getVar('id'), true);
            // $checks = $this->request->getVar('check');
            // $nips = $this->request->getVar('_filter_pegawai');
            // $instansis = $this->request->getVar('instansi');
            // $kecamatans = $this->request->getVar('kecamatan');
            // $jumlah_pinjamans = $this->request->getVar('jumlah_pinjaman');
            // $jumlah_tagihans = $this->request->getVar('jumlah_tagihan');
            // $jumlah_bulan_angsurans = $this->request->getVar('jumlah_bulan_angsuran');
            // $angsuran_kes = $this->request->getVar('angsuran_ke');

            $jmlData = count($nips);
            if ($jmlData === count($instansis) && $jmlData === count($kecamatans) && $jmlData === count($jumlah_pinjamans) && $jmlData === count($jumlah_tagihans) && $jmlData === count($jumlah_bulan_angsurans) && $jmlData === count($angsuran_kes)) {

                $id_bank = $this->_helpLib->getIdBank($user->data->id);
                $deletedAllData = $this->_db->table('tb_tagihan_bank_antrian')->where(['tahun' => $id, 'dari_bank' => $id_bank])->delete();
                if (!($this->_db->affectedRows() > 0)) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal memvalidasi data.";
                    return json_encode($response);
                }
                $uuidLib = new Uuid();
                $dataInserts = [];

                for ($i = 0; $i < $jmlData; $i++) {
                    $pegawai = getPegawaiByIdSigaji($nips[$i]);
                    if (!$pegawai) {
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Data yang dikirim tidak valid. Pegawai tidak ditemukan.";
                        return json_encode($response);
                    }

                    $getAnyTag = $this->_db->table('tb_tagihan_bank_antrian')
                        ->where([
                            'tahun' => $id,
                            'id_pegawai' => $nips[$i],
                            'dari_bank' => $id_bank,
                        ])->countAllResults();

                    if ($getAnyTag > 0) {
                        continue;
                    }

                    $this->_db->transBegin();
                    $dataRow = [
                        'id' => $uuidLib->v4(),
                        'tahun' => $id,
                        'id_pegawai' => $nips[$i],
                        'dari_bank' => $id_bank,
                        'nip' => $pegawai->nip,
                        'instansi' => $pegawai->nama_instansi,
                        'kode_kecamatan' => $pegawai->kode_kecamatan,
                        'kecamatan' => $pegawai->nama_kecamatan,
                        'besar_pinjaman' => str_replace(".", "", $jumlah_pinjamans[$i]),
                        'jumlah_tagihan' => str_replace(".", "", $jumlah_tagihans[$i]),
                        'jumlah_bulan_angsuran' => $jumlah_bulan_angsurans[$i],
                        'angsuran_ke' => $angsuran_kes[$i],
                        'created_at' => date('Y-m-d H:i:s'),
                    ];

                    try {
                        $this->_db->table('tb_tagihan_bank_antrian')->insert($dataRow);
                        if ($this->_db->affectedRows() > 0) {
                            $this->_db->transCommit();
                            $dataInserts[] = $dataRow;
                            continue;
                        } else {
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "Gagal menyimpan data. " . $dataRow['nip'] . " gagal disimpan.";
                            return json_encode($response);
                        }
                    } catch (\Throwable $th) {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal menyimpan data. " . $dataRow['nip'] . " gagal disimpan.";
                        return json_encode($response);
                    }
                }
                // try {
                //     $this->_db->table('tb_tagihan_bank_antrian')->insertBatch($dataInserts);
                //     if ($this->_db->affectedRows() > 0) {
                //         $this->_db->transCommit();
                //         $response = new \stdClass;
                //         $response->status = 200;
                //         $response->message = "Data berhasil disimpan.";
                //         $response->data = "Jumlah data yang disimpan adala " . count($dataInserts);
                //         return json_encode($response);
                //     } else {
                //         $this->_db->transRollback();
                //         $response = new \stdClass;
                //         $response->status = 400;
                //         $response->message = "Gagal menyimpan data.";
                //         return json_encode($response);
                //     }
                // } catch (\Throwable $th) {
                //     $this->_db->transRollback();
                //     $response = new \stdClass;
                //     $response->status = 400;
                //     $response->message = "Gagal menyimpan data.";
                //     return json_encode($response);
                // }

                // var_dump($dataInserts);
                // die;
                // $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data berhasil disimpan.";
                $response->sended_data = $jmlData;
                $response->data = "Jumlah data yang disimpan adala " . count($dataInserts);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data yang dikirim tidak valid.";
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function add()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            $response = new \stdClass;
            $response->status = 401;
            $response->message = "Permintaan diizinkan";
            return json_encode($response);
        }

        $d['bulans'] = $this->_db->table('_ref_tahun_bulan')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get()->getResult();

        $response = new \stdClass;
        $response->status = 200;
        $response->message = "Permintaan diizinkan";
        $response->data = view('sigaji/bank/tagihan/antrian/add', $d);
        return json_encode($response);
    }

    public function getPegawai()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() != 'post') {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Permintaan tidak diizinkan";
                return json_encode($response);
            }

            $rules = [
                'keyword' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Keyword tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('keyword');
                return json_encode($response);
            } else {
                $keyword = htmlspecialchars($this->request->getVar('keyword'), true);

                $current = $this->_db->table('tb_pegawai_')
                    ->select("id, nip, nama, nama_instansi, nama_kecamatan")
                    ->where("nip LIKE '%$keyword%' OR nama LIKE '%$keyword%' OR nama_instansi LIKE '%$keyword%'")->get()->getResult();

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
            exit('Mohon maaf tidak dapat di proses.');
        }
    }

    public function generate()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'tahun' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tahun bulan tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('tahun');
            return json_encode($response);
        } else {
            $tahun = htmlspecialchars($this->request->getVar('tahun'), true);

            $apiLib = new Apilib();
            $result = $apiLib->generatePotonganInfak($tahun);

            if ($result) {
                // var_dump($result);
                // die;
                if ($result->status == 200) {
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->resss = $result;
                    $response->message = "Generate Potongan Infak Berhasil Dilakukan.";
                    return json_encode($response);
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->error = $result;
                    $response->message = "Gagal Generate Potongan Infak.";
                    return json_encode($response);
                }
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal Generate Potongan Infak";
                return json_encode($response);
            }
        }
    }
}
