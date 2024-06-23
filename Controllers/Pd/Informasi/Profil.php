<?php

namespace App\Controllers\Pd\Informasi;

use App\Controllers\BaseController;
use App\Libraries\Profilelib;
use App\Libraries\Helplib;
use App\Libraries\Ppdb\Datalib;
use App\Libraries\Ppdb\Pd\Riwayatlib;
use App\Libraries\Uuid;
use setasign\Fpdi\TcpdfFpdi;

class Profil extends BaseController
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

    public function index()
    {
        return redirect()->to(base_url('pd/informasi/profil/data'));
    }

    public function data()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->userPd();

        if (!$user || $user->status !== 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        // if ($user->data->image == NULL || $user->data->image == "") {
        if ($user->data->updated_at == NULL || $user->data->updated_at == "") {
            return redirect()->to(base_url('pd/home'));
        }

        $dataPd = $this->_db->table('dapo_peserta a')
            ->select("a.*, b.nama as sekolah_asal, b.npsn as npsn_asal")
            ->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id')
            ->where('a.peserta_didik_id', $user->data->peserta_didik_id)->get()->getRowObject();

        if (!$dataPd) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }
        $data['data'] = $dataPd;

        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        $data['title'] = 'Data Peserta';

        return view('pd/informasi/profil/index', $data);
    }
}
