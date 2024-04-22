<?php

namespace App\Controllers\Sigaji;

use App\Controllers\BaseController;
use App\Libraries\Profilelib;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Home extends BaseController
{
    private $_db;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }
    public function index()
    {
        $jwt = get_cookie('jwt');
        $token_jwt = getenv('token_jwt.default.key');
        var_dump($token_jwt);
        die;
        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
                if ($decoded) {
                    $userId = $decoded->id;
                    $level = $decoded->level;

                    switch ($level) {
                        case 1:
                            return redirect()->to(base_url('sigaji/su/home'));
                        case 2:
                            return redirect()->to(base_url('sigaji/adm/home'));
                        case 3:
                            return redirect()->to(base_url('sigaji/bend/home'));
                        case 4:
                            return redirect()->to(base_url('sigaji/bend/home'));
                        case 5:
                            return redirect()->to(base_url('sigaji/bend/home'));
                        case 6:
                            return redirect()->to(base_url('sigaji/bend/home'));
                        case 7:
                            return redirect()->to(base_url('sigaji/bend/home'));
                        default:
                            return redirect()->to(base_url('portal'));
                    }
                } else {
                    return redirect()->to(base_url('auth'));
                }
            } catch (\Exception $e) {

                return redirect()->to(base_url('auth'));
            }
        } else {

            return redirect()->to(base_url('auth'));
        }
    }
}
