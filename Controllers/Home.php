<?php

namespace App\Controllers;

use App\Libraries\Profilelib;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\KuotaModel;
use App\Models\SekolahzonaModel;
use App\Models\PanitiaModel;
use Config\Services;

class Home extends BaseController
{
    private $_db;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'cookie', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }
    public function index()
    {
        $jwt = get_cookie('jwt');
        $token_jwt = getenv('token_jwt.default.key');
        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
                if ($decoded) {
                    $userId = $decoded->data->id;
                    $level = $decoded->data->level;

                    // if ($level === 1) {
                    return redirect()->to(base_url('portal'));
                    // } else if ($level === 2) {
                    //     return redirect()->to(base_url('sp/home'));
                    // } else if ($level === 3) {
                    //     return redirect()->to(base_url('bp/home'));
                    // } else {
                    //     return redirect()->to(base_url('p/home'));
                    // }
                } else {
                    return redirect()->to(base_url('auth'));
                }
            } catch (\Exception $e) {

                return redirect()->to(base_url('home/data'));
            }
        } else {
            return redirect()->to(base_url('home/data'));
        }
    }

    public function data()
    {
        set_cookie('layout', 'horizontal', strval(3600 * 24 * 1));
        set_cookie('headerPosition', 'static', strval(3600 * 24 * 1));
        set_cookie('containerLayout', 'wide', strval(3600 * 24 * 1));
        $data['title'] = 'DASHBOARD || PPDB 2024/2025 Kab. Lampung Tengah';

        return view('dashboard/index', $data);
    }

    public function informasi_afirmasi()
    {
        set_cookie('layout', 'horizontal', strval(3600 * 24 * 1));
        set_cookie('headerPosition', 'static', strval(3600 * 24 * 1));
        set_cookie('containerLayout', 'wide', strval(3600 * 24 * 1));
        $data['title'] = 'Informasi Afirmasi || PPDB 2024/2025 Kab. Lampung Tengah';

        return view('dashboard/info_afirmasi', $data);
    }

    public function informasi_zonasi()
    {
        set_cookie('layout', 'horizontal', strval(3600 * 24 * 1));
        set_cookie('headerPosition', 'static', strval(3600 * 24 * 1));
        set_cookie('containerLayout', 'wide', strval(3600 * 24 * 1));
        $data['title'] = 'Informasi Zonasi || PPDB 2024/2025 Kab. Lampung Tengah';

        return view('dashboard/info_zonasi', $data);
    }

    public function informasi_mutasi()
    {
        set_cookie('layout', 'horizontal', strval(3600 * 24 * 1));
        set_cookie('headerPosition', 'static', strval(3600 * 24 * 1));
        set_cookie('containerLayout', 'wide', strval(3600 * 24 * 1));
        $data['title'] = 'Informasi Mutasi || PPDB 2024/2025 Kab. Lampung Tengah';

        return view('dashboard/info_mutasi', $data);
    }

    public function informasi_prestasi()
    {
        set_cookie('layout', 'horizontal', strval(3600 * 24 * 1));
        set_cookie('headerPosition', 'static', strval(3600 * 24 * 1));
        set_cookie('containerLayout', 'wide', strval(3600 * 24 * 1));
        $data['title'] = 'Informasi Prestasi || PPDB 2024/2025 Kab. Lampung Tengah';

        return view('dashboard/info_prestasi', $data);
    }

    public function informasi_swasta()
    {
        set_cookie('layout', 'horizontal', strval(3600 * 24 * 1));
        set_cookie('headerPosition', 'static', strval(3600 * 24 * 1));
        set_cookie('containerLayout', 'wide', strval(3600 * 24 * 1));
        $data['title'] = 'Informasi Swasta || PPDB 2024/2025 Kab. Lampung Tengah';

        return view('dashboard/info_swasta', $data);
    }

    public function jadwal()
    {
        set_cookie('layout', 'horizontal', strval(3600 * 24 * 1));
        set_cookie('headerPosition', 'static', strval(3600 * 24 * 1));
        set_cookie('containerLayout', 'wide', strval(3600 * 24 * 1));
        $data['title'] = 'Jadwal || PPDB 2024/2025 Kab. Lampung Tengah';
        $data['jadwals'] = $this->_db->table('_setting_jadwal_tb')->orderBy('urut', 'ASC')->get()->getResult();

        return view('dashboard/jadwal', $data);
    }

    public function kuota()
    {
        set_cookie('layout', 'horizontal', strval(3600 * 24 * 1));
        set_cookie('headerPosition', 'static', strval(3600 * 24 * 1));
        set_cookie('containerLayout', 'wide', strval(3600 * 24 * 1));
        $data['title'] = 'Kuota Sekolah || PPDB 2024/2025 Kab. Lampung Tengah';
        $data['kecamatans'] = $this->_db->table('ref_kecamatan')->where('id_kabupaten', '120200')->orderBy('nama', 'ASC')->get()->getResult();

        return view('dashboard/kuota', $data);
    }

    public function zonasi_wilayah()
    {
        set_cookie('layout', 'horizontal', strval(3600 * 24 * 1));
        set_cookie('headerPosition', 'static', strval(3600 * 24 * 1));
        set_cookie('containerLayout', 'wide', strval(3600 * 24 * 1));
        $data['title'] = 'Zonasi Wilayah || PPDB 2024/2025 Kab. Lampung Tengah';
        $data['kecamatans'] = $this->_db->table('ref_kecamatan')->where('id_kabupaten', '120200')->orderBy('nama', 'ASC')->get()->getResult();

        return view('dashboard/zonasi_wilayah', $data);
    }

    public function statistik()
    {
        set_cookie('layout', 'horizontal', strval(3600 * 24 * 1));
        set_cookie('headerPosition', 'static', strval(3600 * 24 * 1));
        set_cookie('containerLayout', 'wide', strval(3600 * 24 * 1));
        $data['title'] = 'Statistik || PPDB 2024/2025 Kab. Lampung Tengah';

        return view('dashboard/statistik', $data);
    }

    public function detail_sekolah()
    {
        set_cookie('layout', 'horizontal', strval(3600 * 24 * 1));
        set_cookie('headerPosition', 'static', strval(3600 * 24 * 1));
        set_cookie('containerLayout', 'wide', strval(3600 * 24 * 1));

        $id = htmlspecialchars($this->request->getGet('d'), true);
        $sekolah = $this->_db->table('dapo_sekolah a')->where('sekolah_id', $id)->get()->getRowObject();
        if (!$sekolah) {
            return redirect()->to(base_url('home'));
        }
        $kuota = $this->_db->table('_setting_kuota_tb a')
            ->select("a.*, (afirmasi + zonasi + mutasi + prestasi) as total")
            ->where('sekolah_id', $id)->get()->getRowObject();
        if (!$kuota) {
            return redirect()->to(base_url('home'));
        }
        $sekolah->kuota_sekolah = $kuota;

        $data['title'] = 'Detail Sekolah || PPDB 2024/2025 Kab. Lampung Tengah';
        $data['sekolah'] = $sekolah;

        return view('dashboard/detail_sekolah', $data);
    }


    public function getAllPanitia()
    {
        $request = Services::request();
        $datamodel = new PanitiaModel($request);


        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            switch ((int)$list->jabatan_ppdb) {
                case 1:
                    $row[] = 'Penanggung jawab';
                    break;
                case 2:
                    $row[] = 'Ketua';
                    break;
                case 3:
                    $row[] = 'Wakil Ketua';
                    break;
                case 4:
                    $row[] = 'Sekretaris';
                    break;
                case 5:
                    $row[] = 'Bendahara';
                    break;
                case 6:
                    $row[] = 'Anggota';
                    break;
                default:
                    $row[] = 'Anggota';
                    break;
            }
            $row[] = '<strong style="color: #00167b;">' . $list->nama . '</strong>';
            $row[] = $list->jabatan;

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

    public function getAllKuota()
    {
        $request = Services::request();
        $datamodel = new KuotaModel($request);


        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            // if ((int)$list->is_locked == 1) {
            //     $action = '<div class="btn-group">
            //     <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
            //     <div class="dropdown-menu" style="">
            //         <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->sekolah_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama)) . '\');"><i class="fas fa-eye font-size-16 align-middle"></i> &nbsp;Detail</a>
            //         <a class="dropdown-item" href="javascript:actionEdit(\'' . $list->sekolah_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="fas fa-edit font-size-16 align-middle"></i> &nbsp;Edit</a>
            //         <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->sekolah_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="fas fa-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
            //         <div class="dropdown-divider"></div>
            //     </div>
            // </div>';
            // } else {
            //     $action = '<div class="btn-group">
            //     <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
            //     <div class="dropdown-menu" style="">
            //         <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->sekolah_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama)) . '\');"><i class="fas fa-eye font-size-16 align-middle"></i> &nbsp;Detail</a>
            //         <a class="dropdown-item" href="javascript:actionEdit(\'' . $list->sekolah_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="fas fa-edit font-size-16 align-middle"></i> &nbsp;Edit</a>
            //         <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->sekolah_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="fas fa-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
            //         <div class="dropdown-divider"></div>
            //     </div>
            // </div>';
            // }

            // $row[] = $action;
            if ((int)$list->status_sekolah_id == 1) {
                $row[] = '<a href="' . base_url() . '/home/detail_sekolah?d=' . $list->sekolah_id . '" target="_blank"><strong style="color: #00167b;">' . $list->nama . '</strong></a>';
                $row[] = '<a href="' . base_url() . '/home/detail_sekolah?d=' . $list->sekolah_id . '" target="_blank"><strong style="color: #00167b;">' . $list->npsn . '</strong></a>';
                $row[] = $list->jumlah_rombel_kebutuhan;
                $row[] = $list->afirmasi;
                $row[] = $list->zonasi;
                $row[] = $list->mutasi;
                $row[] = $list->prestasi;
                $row[] = $list->total;
            } else {
                $row[] = '<a href="' . base_url() . '/home/detail_sekolah?d=' . $list->sekolah_id . '" target="_blank"><strong style="color: #00167b;">' . $list->nama . '</strong></a>';
                $row[] = '<a href="' . base_url() . '/home/detail_sekolah?d=' . $list->sekolah_id . '" target="_blank"><strong style="color: #00167b;">' . $list->npsn . '</strong></a>';
                $row[] = $list->jumlah_rombel_kebutuhan;
                $row[] = 0;
                $row[] = 0;
                $row[] = 0;
                $row[] = 0;
                $row[] = $list->total;
            }
            // $row['url_sekolah'] = 'https://invome.dexignlab.com/codeigniter/demo/button';

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

    public function getAllZonasi()
    {
        $request = Services::request();
        $datamodel = new SekolahzonaModel($request);

        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            // $row[] = $no;
            // if ((int)$list->jumlah_zona == (int)$list->jumlah_zona_verified) {
            //     if ((int)$list->jumlah_zona > 0) {
            $action = '<a class="btn btn-primary" href="javascript:getDetailZonasi(\'' . $list->sekolah_id . '\',\'' . $list->nama . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                                 ';
            //     } else {
            //         $action = '<a class="btn btn-warning" href="./detaillist?id=' . $list->sekolah_id . '&n=' . $list->nama . '"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
            //                         ';
            //     }
            // } else {
            //     $action = '<a class="btn btn-warning" href="./detaillist?id=' . $list->sekolah_id . '&n=' . $list->nama . '"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
            //                         ';
            // }

            $row[] = $action;
            $row[] = $list->nama;
            $row[] = $list->npsn;
            $row[] = $list->jumlah_kelurahan ?? 0;
            $row[] = $list->jumlah_zona_verified ?? 0;

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

    public function getAllWilayahZonasi()
    {
        if ($this->request->isAJAX()) {
            $request = Services::request();

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Id tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $output = [
                    "draw" => $request->getPost('draw'),
                    "recordsTotal" => 0,
                    "recordsFiltered" => 0,
                    "data" => []
                ];
                echo json_encode($output);
                return;
            } else {
                $id = htmlspecialchars($this->request->getVar('id'), true);

                $oldData = $this->_db->table('_setting_zonasi_tb a')
                    ->select("a.*, b.nama as nama_provinsi, c.nama as nama_kabupaten, d.nama as nama_kecamatan, e.nama as nama_kelurahan, (SELECT count(dusun) FROM _setting_zonasi_tb WHERE dusun = a.dusun) as jumlah_dusun, count(dusun) as jumlah")
                    ->join('ref_provinsi b', 'b.id = a.provinsi')
                    ->join('ref_kabupaten c', 'c.id = a.kabupaten')
                    ->join('ref_kecamatan d', 'd.id = a.kecamatan')
                    ->join('ref_kelurahan e', 'e.id = a.kelurahan')
                    ->where(['a.sekolah_id' => $id, 'is_locked' => 1])
                    ->groupBy('a.kelurahan')
                    ->get()->getResult();
                if (count($oldData) > 0) {
                    $dataN = [];
                    $no = $request->getPost("start");
                    foreach ($oldData as $key => $value) {
                        $no++;
                        $row = [];
                        $row[] = $no;
                        $row[] = $value->nama_provinsi;
                        $row[] = $value->nama_kabupaten;
                        $row[] = $value->nama_kecamatan;
                        $row[] = $value->nama_kelurahan;
                        $row[] = getDusunList($value->kelurahan, $value->sekolah_id);
                        $dataN[] = $row;
                    }

                    $output = [
                        "draw" => $request->getPost('draw'),
                        "recordsTotal" => count($oldData),
                        "recordsFiltered" => count($oldData),
                        "data" => $dataN
                    ];
                    echo json_encode($output);
                    return;
                }

                $output = [
                    "draw" => $request->getPost('draw'),
                    "recordsTotal" => 0,
                    "recordsFiltered" => 0,
                    "data" => []
                ];
                echo json_encode($output);
                return;
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function detailZonasi()
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
                $id = htmlspecialchars($this->request->getVar('id'), true);
                $nama = htmlspecialchars($this->request->getVar('nama'), true);

                $oldData = $this->_db->table('_setting_zonasi_tb a')
                    ->select("a.*, b.nama as nama_provinsi, c.nama as nama_kabupaten, d.nama as nama_kecamatan, e.nama as nama_kelurahan, (SELECT count(dusun) FROM _setting_zonasi_tb WHERE dusun = a.dusun) as jumlah_dusun, count(dusun) as jumlah")
                    ->join('ref_provinsi b', 'b.id = a.provinsi')
                    ->join('ref_kabupaten c', 'c.id = a.kabupaten')
                    ->join('ref_kecamatan d', 'd.id = a.kecamatan')
                    ->join('ref_kelurahan e', 'e.id = a.kelurahan')
                    ->where(['a.sekolah_id' => $id, 'is_locked' => 1])
                    ->groupBy('a.kelurahan')
                    ->get()->getResult();
                if (count($oldData) > 0) {

                    $x['data'] = $oldData;
                    $x['sek_id'] = $id;
                    $x['sekolah'] = $nama;

                    $response = new \stdClass;
                    $response->status = 200;
                    $response->title = "DETAIL ZONASI SEKOLAH $nama";
                    $response->message = "Permintaan diizinkan";
                    $response->data = view('dashboard/detail_zonasi', $x);
                    return json_encode($response);
                }

                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data zonasi tidak ditemukan.";
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
