<?php

namespace App\Controllers;

use App\Libraries\Profilelib;
use App\Libraries\Mtlib;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\KuotaModel;
use App\Models\SekolahzonaModel;
use App\Models\PanitiaModel;
use App\Models\KuotapendaftaranModel;
use Config\Services;

class Maintenance extends BaseController
{
    private $_db;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'cookie', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }
    public function index()
    {
        return redirect()->to(base_url('maintenance/data'));
    }

    public function data()
    {
        set_cookie('layout', 'horizontal', strval(3600 * 24 * 1));
        set_cookie('headerPosition', 'static', strval(3600 * 24 * 1));
        set_cookie('containerLayout', 'wide', strval(3600 * 24 * 1));
        $data['title'] = 'DASHBOARD || PPDB 2024/2025 Kab. Lampung Tengah';

        $mtLib = new Mtlib();
        if (!$mtLib->get()) {
            return redirect()->to(base_url('home/data'));
        }

        $data['title'] = "MAINTENANCE";
        $template = $this->_db->table('_tb_maintenance')->where(['id' => 1, 'template_active' => 1])->get()->getRowObject();
        if ($template) {
            if ($template->template !== null) {
                $activeTemplate = $template->template;
            } else {
                $activeTemplate = 'index';
            }
        } else {
            $activeTemplate = 'index';
        }

        return view('maintenance/index', $data);
    }
}
