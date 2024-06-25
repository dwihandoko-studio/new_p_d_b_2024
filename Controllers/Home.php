<?php

namespace App\Controllers;

use App\Libraries\Profilelib;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\KuotaModel;
use App\Models\SekolahzonaModel;
use App\Models\PanitiaModel;
use App\Models\KuotapendaftaranModel;
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

        $data['kecamatans'] = $this->_db->table('ref_kecamatan')->where('id_kabupaten', '120200')->orderBy('nama', 'ASC')->get()->getResult();
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
                $row[] = '<a href="' . base_url() . '/home/detail_sekolah?d=' . $list->sekolah_id . '"><strong style="color: #00167b;">' . $list->nama . '</strong></a>';
                $row[] = '<a href="' . base_url() . '/home/detail_sekolah?d=' . $list->sekolah_id . '"><strong style="color: #00167b;">' . $list->npsn . '</strong></a>';
                $row[] = $list->jumlah_rombel_kebutuhan;
                $row[] = $list->afirmasi;
                $row[] = $list->zonasi;
                $row[] = $list->mutasi;
                $row[] = $list->prestasi;
                $row[] = $list->total;
            } else {
                $row[] = '<a href="' . base_url() . '/home/detail_sekolah?d=' . $list->sekolah_id . '"><strong style="color: #00167b;">' . $list->nama . '</strong></a>';
                $row[] = '<a href="' . base_url() . '/home/detail_sekolah?d=' . $list->sekolah_id . '"><strong style="color: #00167b;">' . $list->npsn . '</strong></a>';
                $row[] = $list->jumlah_rombel_kebutuhan;
                $row[] = 0;
                $row[] = 0;
                $row[] = 0;
                $row[] = 0;
                $row[] = $list->total;
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
            $row[] = '<a href="' . base_url() . '/home/detail_sekolah?d=' . $list->sekolah_id . '"><strong style="color: #00167b;">' . $list->nama . '</strong></a>';
            $row[] = '<a href="' . base_url() . '/home/detail_sekolah?d=' . $list->sekolah_id . '"><strong style="color: #00167b;">' . $list->npsn . '</strong></a>';
            // $row[] = $list->nama;
            // $row[] = $list->npsn;
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

    public function getAllStatistikWeb()
    {
        $request = Services::request();
        $datamodel = new KuotapendaftaranModel($request);

        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row['no'] = $no;
            $row['button'] = '<div style="vertical-align: inherit;"><button style="height: 38px; width: 38px; border-radius: 50%; padding: 0.75rem 0; justify-content: center;margin: 0; display: inline-flex; cursor: pointer; user-select: none; align-items: center; vertical-align: inherit; text-align: center; overflow: hidden; position: relative; font-size: 1rem; transition: background-color .2s,color .2s,border-color .2s,box-shadow .2s; color: #fff; background: #4527a4; border: 1px solid #4527a4;" type="button" onclick="actionDetailPendaftar(\'' . $list->sekolah_id . '\', \'' . $list->npsn . '\');"><i class="fas fa-search-plus"></i></button></div>';
            $row['id'] = $list->sekolah_id;
            // $row['npsn'] = $list->npsn;
            $row['nama'] = '<div style="font-size: 13px; vertical-align: inherit;">' . $list->nama_sekolah . '<br/>' . $list->npsn . '<br/>' . $list->nama_kecamatan . '<br/><b>Total Kuota : ' . ($list->zonasi + $list->afirmasi + $list->mutasi + $list->prestasi) . '</b><br/><b>Total Diterima : ' . ($list->diterima_zonasi + $list->diterima_afirmasi + $list->diterima_mutasi + $list->diterima_prestasi + $list->diterima_swasta) . '</b><br/><b>Sisa Kuota : ' . (($list->zonasi + $list->afirmasi + $list->mutasi + $list->prestasi) - ($list->diterima_zonasi + $list->diterima_afirmasi + $list->diterima_mutasi + $list->diterima_prestasi + $list->diterima_swasta)) . '</b></div>';
            if ($list->status_sekolah_id == 1) {
                $row['zonasi'] = '<div style="font-size: 13px;">Kuota : <b>' . $list->zonasi . '</b>'
                    . '<br/>' . 'Pendaftar : <b>' . $list->pendaftar_zonasi . '</b>'
                    . '<br/>' . 'Terverifikasi : <b>' . $list->terverifikasi_zonasi . '</b>'
                    . '<br/>' . 'Belum Verifikasi : <b>' . $list->belum_verifikasi_zonasi . '</b>'
                    . '<br/>' . 'Diterima : <b>' . $list->diterima_zonasi . '</b></div>';
                $row['afirmasi'] = '<div style="font-size: 13px;">Kuota : <b>' . $list->afirmasi . '</b>'
                    . '<br/>' . 'Pendaftar : <b>' . $list->pendaftar_afirmasi . '</b>'
                    . '<br/>' . 'Terverifikasi : <b>' . $list->terverifikasi_afirmasi . '</b>'
                    . '<br/>' . 'Belum Verifikasi : <b>' . $list->belum_verifikasi_afirmasi . '</b>'
                    . '<br/>' . 'Diterima : <b>' . $list->diterima_afirmasi . '</b></div>';
                $row['mutasi'] = '<div style="font-size: 13px;">Kuota : <b>' . $list->mutasi . '</b>'
                    . '<br/>' . 'Pendaftar : <b>' . $list->pendaftar_mutasi . '</b>'
                    . '<br/>' . 'Terverifikasi : <b>' . $list->terverifikasi_mutasi . '</b>'
                    . '<br/>' . 'Belum Verifikasi : <b>' . $list->belum_verifikasi_mutasi . '</b>'
                    . '<br/>' . 'Diterima : <b>' . $list->diterima_mutasi . '</b></div>';
                $row['prestasi'] = '<div style="font-size: 13px;">Kuota : <b>' . $list->prestasi . '</b>'
                    . '<br/>' . 'Pendaftar : <b>' . $list->pendaftar_prestasi . '</b>'
                    . '<br/>' . 'Terverifikasi : <b>' . $list->terverifikasi_prestasi . '</b>'
                    . '<br/>' . 'Belum Verifikasi : <b>' . $list->belum_verifikasi_prestasi . '</b>'
                    . '<br/>' . 'Diterima : <b>' . $list->diterima_prestasi . '</b></div>';
                $row['swasta'] = '<div style="font-size: 13px;">Kuota : <b>0</b>'
                    . '<br/>' . 'Pendaftar : <b>0</b>'
                    . '<br/>' . 'Terverifikasi : <b>0</b>'
                    . '<br/>' . 'Belum Verifikasi : <b>0</b>'
                    . '<br/>' . 'Diterima : <b>0</b></div>';
            } else {
                $row['zonasi'] = '<div style="font-size: 13px;">Kuota : <b>0</b>'
                    . '<br/>' . 'Pendaftar : <b>0</b>'
                    . '<br/>' . 'Terverifikasi : <b>0</b>'
                    . '<br/>' . 'Belum Verifikasi : <b>' . $list->belum_verifikasi_zonasi . '</b>'
                    . '<br/>' . 'Diterima : <b>0</b></div>';
                $row['afirmasi'] = '<div style="font-size: 13px;">Kuota : <b>0</b>'
                    . '<br/>' . 'Pendaftar : <b>0</b>'
                    . '<br/>' . 'Terverifikasi : <b>0</b>'
                    . '<br/>' . 'Belum Verifikasi : <b>0</b>'
                    . '<br/>' . 'Diterima : <b>0</b></div>';
                $row['mutasi'] = '<div style="font-size: 13px;">Kuota : <b>0</b>'
                    . '<br/>' . 'Pendaftar : <b>0</b>'
                    . '<br/>' . 'Terverifikasi : <b>0</b>'
                    . '<br/>' . 'Belum Verifikasi : <b>0</b>'
                    . '<br/>' . 'Diterima : <b>0</b></div>';
                $row['prestasi'] = '<div style="font-size: 13px;">Kuota : <b>0</b>'
                    . '<br/>' . 'Pendaftar : <b>0</b>'
                    . '<br/>' . 'Terverifikasi : <b>0</b>'
                    . '<br/>' . 'Belum Verifikasi : <b>0</b>'
                    . '<br/>' . 'Diterima : <b>0</b></div>';
                $row['swasta'] = '<div style="font-size: 13px;">Kuota : <b>' . ((int)$list->zonasi + (int)$list->afirmasi + (int)$list->mutasi + (int)$list->prestasi) . '</b>'
                    . '<br/>' . 'Pendaftar : <b>' . $list->pendaftar_swasta . '</b>'
                    . '<br/>' . 'Terverifikasi : <b>' . $list->terverifikasi_swasta . '</b>'
                    . '<br/>' . 'Belum Verifikasi : <b>' . $list->belum_verifikasi_swasta . '</b>'
                    . '<br/>' . 'Diterima : <b>' . $list->diterima_swasta . '</b></div>';
            }
            // $row['datazonasi'] = zonasiDetailWeb($list->npsn);

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

    public function getDetailStatistikWeb()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Id tidak boleh kosong. ',
                    ]
                ],
                'name' => [
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
                    . $this->validator->getError('name');
                return json_encode($response);
            } else {
                $id = htmlspecialchars($this->request->getVar('id'), true);
                $nama = htmlspecialchars($this->request->getVar('name'), true);

                $terverifikasi = $this->_db->table('_tb_pendaftar')
                    ->select("id, kode_pendaftaran, via_jalur, nama_peserta as fullname, nisn_peserta as nisn, nama_sekolah_asal, count(nisn_peserta) as jumlahDaftar")
                    ->where('tujuan_sekolah_id_1', $id)
                    ->groupBy('nisn_peserta')
                    ->orderBy('created_at', 'asc')
                    ->get()->getResult();

                $belumverifikasi = $this->_db->table('_tb_pendaftar_temp')
                    ->select("id, kode_pendaftaran, via_jalur, nama_peserta as fullname, nisn_peserta as nisn, nama_sekolah_asal, count(nisn_peserta) as jumlahDaftar")
                    ->where('tujuan_sekolah_id_1', $id)
                    ->groupBy('nisn_peserta')
                    ->orderBy('created_at', 'asc')
                    ->get()->getResult();

                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data ditemukan.";
                // $response->data = $detail;
                $response->data_terverifikasi = $terverifikasi;
                $response->data_belum_verifikasi = $belumverifikasi;
                return json_encode($response);
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

    public function loadModal()
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

                $oldData = $this->_db->table('_setting_jadwal_tb ')
                    ->select("tgl_pengumuman")
                    ->orderBy('tgl_pengumuman', 'ASC')
                    ->limit(1)
                    ->get()->getRowObject();

                // if ($oldData) {
                //     $today = date("Y-m-d H:i:s");

                //     $startdate = strtotime($today);
                //     $enddateAwal = strtotime($oldData->tgl_pengumuman);

                //     if ($startdate < $enddateAwal) {
                //         $response = new \stdClass;
                //         $response->code = 400;
                //         $response->message = "Mohon maaf, saat ini hasil pengumuman belum dibuka.";
                //         return $response;
                //     }

                $response = new \stdClass;
                $response->status = 200;
                $response->data = $oldData;
                $response->message = "Permintaan diizinkan";
                $response->data = view('dashboard/cek_pengumuman');
                return json_encode($response);
                // }

                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Untuk saat ini jadwal pengumuman belum tersedia.";
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function submitCekPengumuman()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'nopes' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'No peserta tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('nopes');
                return json_encode($response);
            } else {
                $nopes = htmlspecialchars($this->request->getVar('nopes'), true);

                $nisn = $this->_db->table('_tb_pendaftar')->where('nisn_peserta', $nopes)->orderBy('updated_aproval', 'DESC')->limit(1)->get()->getRowObject();
                if (!$nisn) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Nomor peserta tidak ditemukan.";
                    return json_encode($response);
                }
                $x['data'] = $nisn;

                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('dashboard/content_cek_pengumuman', $x);
                return json_encode($response);
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
