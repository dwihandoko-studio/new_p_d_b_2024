<?php

namespace App\Controllers\Sek;

use App\Controllers\BaseController;
use App\Libraries\Profilelib;
use App\Libraries\Helplib;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Home extends BaseController
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
        $jwt = get_cookie('jwt');
        $token_jwt = getenv('token_jwt.default.key');
        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
                if ($decoded) {
                    $userId = $decoded->id;
                    $level = $decoded->level;

                    $Profilelib = new Profilelib();
                    $user = $Profilelib->userSekolah();

                    if (!$user || $user->status !== 200) {
                        session()->destroy();
                        delete_cookie('jwt');
                        return redirect()->to(base_url('auth'));
                    }
                    $data['user'] = $user->data;

                    $data['title'] = "Portal Layanan";
                    $data['level'] = $level;
                    return view('sek/home/index', $data);
                } else {
                    session()->destroy();
                    delete_cookie('jwt');
                    return redirect()->to(base_url('auth'));
                }
            } catch (\Exception $e) {
                session()->destroy();
                delete_cookie('jwt');
                return redirect()->to(base_url('auth'));
            }
        } else {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }
    }
}
