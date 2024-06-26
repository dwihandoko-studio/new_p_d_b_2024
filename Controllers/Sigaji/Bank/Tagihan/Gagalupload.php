<?php

namespace App\Controllers\Sigaji\Bank\Tagihan;

use App\Controllers\BaseController;
use App\Models\Sigaji\Bank\Tagihan\GagaluploadModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Sigaji\Apilib;
use App\Libraries\Helplib;

class Gagalupload
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
        $datamodel = new GagaluploadModel($request);

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
            // $action = '<div class="btn-group">
            //             <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
            //             <div class="dropdown-menu" style="">
            //                 <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->nip . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama)) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
            //             </div>
            //         </div>';
            // $action = '<a href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bxs-show font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionSync(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-transfer-alt font-size-16 align-middle"></i></button>
            //     </a>
            // <a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            // <i class="bx bx-trash font-size-16 align-middle"></i></button>
            // </a>';
            // $row[] = $action;
            $row[] = '<a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->instansi . '\');" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1 delete" id="delete">
            <i class="bx bx-trash font-size-16 align-middle"></i> HAPUS
            </a>';
            $row[] = $list->tahun . '-' . $list->bulan;
            $row[] = $list->nama;
            $row[] = $list->nip;
            $row[] = $list->instansi;
            $row[] = $list->kecamatan;
            $row[] = rpTanpaAwalan($list->jumlah_tagihan);
            // $row[] = $list->kode_instansi;

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
        return redirect()->to(base_url('sigaji/bank/tagihan/gagalupload/data'));
    }

    public function data()
    {
        $data['title'] = 'DATA GAGAL UPLOAD TAGIHAN';
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

        return view('sigaji/bank/tagihan/gagalupload/index', $data);
    }


    public function delete()
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
                'instansi' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Instansi tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('id')
                    . $this->validator->getError('nama')
                    . $this->validator->getError('instansi');
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
                $instansi = htmlspecialchars($this->request->getVar('instansi'), true);

                $this->_db->table('tb_tagihan_gagal_upload')
                    ->where('id', $id)->delete();

                if ($this->_db->affectedRows() > 0) {
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Data Gagal Upload Tagihan atas nama : $nama ($instansi) berhasil dihapus.";
                    return json_encode($response);
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menghapus data.";
                    return json_encode($response);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
