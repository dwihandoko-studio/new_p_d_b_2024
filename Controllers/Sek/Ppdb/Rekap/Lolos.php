<?php

namespace App\Controllers\Sek\Ppdb\Rekap;

use App\Controllers\BaseController;
use App\Models\Sek\Ppdb\Rekap\LolosModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Ppdb\Sek\Riwayatlib;
use App\Libraries\Ppdb\Notificationlib;
use App\Libraries\Apilib;
use App\Libraries\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use setasign\Fpdi\TcpdfFpdi;

class Lolos extends BaseController
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
        $Profilelib = new Profilelib();
        $user = $Profilelib->userSekolah();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $request = Services::request();
        $datamodel = new LolosModel($request);


        $lists = $datamodel->get_datatables($user->data->sekolah_id);
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            // $row[] = $no;
            // $action = '<div class="btn-group">
            //                 <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
            //                 <div class="dropdown-menu" style="">
            //                     <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->peserta_didik_id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
            //                     <a class="dropdown-item" href="javascript:actionResetPassword(\'' . $list->peserta_didik_id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\');"><i class="bx bx-key font-size-16 align-middle"></i> &nbsp;Reset Password</a>
            //                     <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->peserta_didik_id . '\', \'' . str_replace("'", "", $list->nama)  . '\');"><i class="bx bx-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
            //                     <div class="dropdown-divider"></div>
            //                 </div>
            //             </div>';
            $action = '<a href="' . base_url() . '/sek/ppdb/pendaftar/detail?d=' . $list->id . '&t=' . $list->kode_pendaftaran . '" class="btn btn-xs btn-primary waves-effect waves-light"><i class="las la-compress-arrows-alt font-size-16 align-middle me-2" style="font-size: 1.5rem !important;"></i> VERIFIKASI</a>';

            $row[] = $action;
            $row[] = $list->nama_peserta;
            $row[] = $list->nisn_peserta;
            $row[] = $list->via_jalur;
            $row[] = $list->nama_sekolah_asal;
            $row[] = $list->npsn_sekolah_asal;
            $row[] = round($list->jarak_domisili, 3) . ' Km';

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all($user->data->sekolah_id),
            "recordsFiltered" => $datamodel->count_filtered($user->data->sekolah_id),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        return redirect()->to(base_url('sek/ppdb/rekap/lolos/data'));
    }

    public function data()
    {
        $data['title'] = 'DATA PENDAFTAR LOLOS VERIFIKASI';
        $Profilelib = new Profilelib();
        $user = $Profilelib->userSekolah();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        $data['sekNegeri'] = true;
        $data['sekSwasta'] = false;

        return view('sek/ppdb/rekap/lolos/index', $data);
    }

    public function detail()
    {
        $data['title'] = 'DETAIL PENDAFTAR LOLOS VERIFIKASI';
        $Profilelib = new Profilelib();
        $user = $Profilelib->userSekolah();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $id = htmlspecialchars($this->request->getGet('d'), true);

        $oldData = $this->_db->table('_tb_pendaftar a')
            ->select("a.*, b.nama_ibu_kandung, b.nik, b.no_kk, b.alamat_jalan, b.no_kip, b.no_pkh, c.nohp, c.email")
            ->join('dapo_peserta b', 'b.peserta_didik_id = a.peserta_didik_id')
            ->join('_users_tb c', 'c.id = a.user_id')
            ->where('a.id', $id)
            ->get()->getRowObject();

        if (!$oldData) {
            return redirect()->to(base_url('sek/ppdb/rekap/lolos'));
        }

        $data['data'] = $oldData;
        $data['koreg'] = $oldData->kode_pendaftaran;
        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        if ($oldData->via_jalur == "PRESTASI") {
            return view('sek/ppdb/rekap/lolos/detail_pres', $data);
        } else {
            return view('sek/ppdb/rekap/lolos/detail', $data);
        }
    }
}
