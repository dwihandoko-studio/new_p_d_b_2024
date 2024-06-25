<?php

namespace App\Controllers\Adm;

use App\Controllers\BaseController;
use App\Models\Adm\Pengaduan\PengaduanModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Helplib;
use App\Libraries\Uuid;

class Pengaduan extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;
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
        $datamodel = new PengaduanModel($request);


        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<a class="btn btn-primary" href="./detail?id=' . $list->no_tiket . '&n=' . $list->nama_pengadu . '"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                                ';

            $row[] = $action;
            $row[] = ucwords($list->jenis_pengaduan);
            $row[] = $list->nama_pengadu;
            $row[] = $list->no_tiket;

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
        return redirect()->to(base_url('adm/pengaduan/data'));
    }

    public function data()
    {

        $Profilelib = new Profilelib();
        $user = $Profilelib->user();

        if (!$user || $user->status !== 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        // $layanan = json_decode(file_get_contents(FCPATH . "uploads/layanans_silastri.json"), true);
        // $data['layanans'] = [];
        // var_dump("PENG");
        // die;
        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        $data['title'] = 'Dashboard';
        return view('adm/pengaduan/index', $data);
    }

    public function detail()
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

        $oldData = $this->_db->table('data_pengaduan a')
            ->select("b.*, a.no_tiket, a.jenis_pengaduan, a.file, a.status, a.keterangan, a.created_at as created_pengaduan, a.updated_at as updated_pengaduan, a.admin_approve")
            ->join('dapo_peserta_pengajuan b', 'a.no_tiket = b.id')
            ->where('a.no_tiket', $id)
            ->get()->getRowObject();

        if (!$oldData) {
            $data['error_tutup'] = "Data pengaduan tidak ditemukan dengan nomor tiket tersebut.";
            $data['error_url'] = base_url('adm/pengaduan');
        }
        $data['data'] = $oldData;

        $data['title'] = "DETAIL DATA PENGADUAN";
        $data['id'] = $id;
        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;

        return view('adm/pengaduan/detail', $data);
    }
}
