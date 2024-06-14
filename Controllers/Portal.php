<?php

namespace App\Controllers;

use App\Libraries\Profilelib;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Portal extends BaseController
{
    private $_db;

    function __construct()
    {
        helper(['text', 'file', 'form', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }
    public function index()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->userLevel();

        if (!$user || $user->status !== 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        // $data['user'] = $user->data;

        switch ((int)$user->level) {
            case 0:
                return redirect()->to(base_url('su/home'));
                break;
            case 1:
                return redirect()->to(base_url('adm/home'));
                break;
            case 2:
                return redirect()->to(base_url('dinas/home'));
                break;
            case 3:
                return redirect()->to(base_url('pan/home'));
                break;
            case 4:
                return redirect()->to(base_url('sek/home'));
                break;

            default:
                return redirect()->to(base_url('pd/home'));
                break;
        }

        // $data['title'] = "Portal Layanan";
        // $data['level'] = $user->level;
        // // $data['layanans'] = $layanan['layanans'];
        // return view('portal/index', $data);
    }
}
