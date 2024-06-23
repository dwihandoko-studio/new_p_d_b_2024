<?php

namespace App\Controllers\Pan\Laporan;

use App\Controllers\BaseController;
use App\Libraries\Profilelib;
use App\Libraries\Helplib;
use App\Libraries\Ppdb\Datalib;
use App\Libraries\Ppdb\Pd\Riwayatlib;
use App\Libraries\Uuid;
use setasign\Fpdi\TcpdfFpdi;

class Panduan extends BaseController
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
        return redirect()->to(base_url('pan/laporan/panduan/data'));
    }

    public function data()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->userSekolah();

        if (!$user || $user->status !== 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        // if ($user->data->image == NULL || $user->data->image == "") {
        if ($user->data->updated_at == NULL || $user->data->updated_at == "") {
            return redirect()->to(base_url('pan/home'));
        }

        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        $data['title'] = 'Data Panduan';

        return view('pan/laporan/panduan/index', $data);
    }
}
