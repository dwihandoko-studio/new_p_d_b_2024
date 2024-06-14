<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Mtlib;
use App\Libraries\Sigaji\Acclib;

class Filterauth implements FilterInterface
{
    function __construct()
    {
        helper(['cookie', 'web', 'array', 'filesystem']);
        // $this->_db      = \Config\Database::connect();
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $uri = current_url(true);
        $uriMain = $uri->getSegment(1);

        // var_dump($uriMain);
        // die;

        $jwt = get_cookie('jwt');
        $token_jwt = getenv('token_jwt.default.key');
        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
                if ($decoded) {
                    $userId = $decoded->id;
                    $level = $decoded->level;

                    // $uri = current_url(true);
                    $totalSegment = $uri->getTotalSegments();
                    if ($totalSegment > 0) {
                        $uriMain = $uri->getSegment(1);
                        if ($uriMain === "" || $uriMain === "home" || $uriMain === "auth" || $uriMain === "portal") {
                        } else {
                            $mtLib = new Mtlib();
                            if ($mtLib->get()) {
                                if (!$mtLib->getAccess($userId)) {
                                    if ($uriMain !== "maintenance") {
                                        return redirect()->to(base_url('maintenance'));
                                    }
                                } else {

                                    if ($level == 0) { //SuperAdmin

                                        if ($uriMain === "" || $uriMain === "index") {
                                            return redirect()->to(base_url('su/home'));
                                        }
                                        if ($uriMain != "su") {
                                            return redirect()->to(base_url('su/home'));
                                        }
                                    } else if ($level == 1) { //Admin
                                        if ($uriMain === "" || $uriMain === "index") {
                                            return redirect()->to(base_url('adm/home'));
                                        }
                                        if ($uriMain != "adm") {
                                            return redirect()->to(base_url('adm/home'));
                                        }
                                    } else if ($level == 2) { //Dinas
                                        if ($uriMain === "" || $uriMain === "index") {
                                            return redirect()->to(base_url('dinas/home'));
                                        }
                                        if ($uriMain != "dinas") {
                                            return redirect()->to(base_url('dinas/home'));
                                        }
                                    } else if ($level == 3) { //Monev
                                        if ($uriMain === "" || $uriMain === "index") {
                                            return redirect()->to(base_url('pan/home'));
                                        }
                                        if ($uriMain != "pan") {
                                            return redirect()->to(base_url('pan/home'));
                                        }
                                    } else if ($level == 4) { //Sekolah
                                        if ($uriMain === "" || $uriMain === "index") {
                                            return redirect()->to(base_url('sek/home'));
                                        }
                                        if ($uriMain != "sek") {
                                            return redirect()->to(base_url('sek/home'));
                                        }
                                    } else if ($level == 5) { //Kepsek
                                        if ($uriMain === "" || $uriMain === "index") {
                                            return redirect()->to(base_url('pd/home'));
                                        }
                                        if ($uriMain != "pd") {
                                            return redirect()->to(base_url('pd/home'));
                                        }
                                    } else {
                                        return redirect()->to(base_url('portal'));
                                    }
                                }
                            } else {

                                if ($level == 0) { //SuperAdmin

                                    if ($uriMain === "" || $uriMain === "index") {
                                        return redirect()->to(base_url('su/home'));
                                    }
                                    if ($uriMain != "su") {
                                        return redirect()->to(base_url('su/home'));
                                    }
                                } else if ($level == 1) { //Admin
                                    if ($uriMain === "" || $uriMain === "index") {
                                        return redirect()->to(base_url('adm/home'));
                                    }
                                    if ($uriMain != "adm") {
                                        return redirect()->to(base_url('adm/home'));
                                    }
                                } else if ($level == 2) { //Dinas
                                    if ($uriMain === "" || $uriMain === "index") {
                                        return redirect()->to(base_url('dinas/home'));
                                    }
                                    if ($uriMain != "dinas") {
                                        return redirect()->to(base_url('dinas/home'));
                                    }
                                } else if ($level == 3) { //Monev
                                    if ($uriMain === "" || $uriMain === "index") {
                                        return redirect()->to(base_url('pan/home'));
                                    }
                                    if ($uriMain != "pan") {
                                        return redirect()->to(base_url('pan/home'));
                                    }
                                } else if ($level == 4) { //Sekolah
                                    if ($uriMain === "" || $uriMain === "index") {
                                        return redirect()->to(base_url('sek/home'));
                                    }
                                    if ($uriMain != "sek") {
                                        return redirect()->to(base_url('sek/home'));
                                    }
                                } else if ($level == 5) { //Kepsek
                                    if ($uriMain === "" || $uriMain === "index") {
                                        return redirect()->to(base_url('pd/home'));
                                    }
                                    if ($uriMain != "pd") {
                                        return redirect()->to(base_url('pd/home'));
                                    }
                                } else {
                                    return redirect()->to(base_url('portal'));
                                }
                            }
                        }
                    } else {
                        return redirect()->to(base_url('portal'));
                    }
                } else {
                    $uri = current_url(true);
                    $totalSegment = $uri->getTotalSegments();
                    if ($totalSegment > 0) {
                        $uriMain = $uri->getSegment(1);

                        if ($uriMain == "" || $uriMain == "home" || $uriMain == "auth") {
                        } else {
                            return redirect()->to(base_url('auth'));
                        }
                    }
                }
            } catch (\Exception $e) {
                $uri = current_url(true);
                $totalSegment = $uri->getTotalSegments();
                if ($totalSegment > 0) {

                    $uriMain = $uri->getSegment(1);

                    if ($uriMain == "" || $uriMain == "home" || $uriMain == "auth") {
                    } else {
                        // var_dump($e);
                        // var_dump("<br>token salah");
                        // die;
                        return redirect()->to(base_url('auth'));
                    }
                }
            }
        } else {
            $uri = current_url(true);
            $totalSegment = $uri->getTotalSegments();
            if ($totalSegment > 0) {

                $uriMain = $uri->getSegment(1);

                if ($uriMain == "auth") {
                } else {
                    // var_dump("tidak ada token"); die;
                    return redirect()->to(base_url('auth'));
                }
            }
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $jwt = get_cookie('jwt');
        $token_jwt = getenv('token_jwt.default.key');
        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
                if ($decoded) {
                    $userId = $decoded->id;
                    $level = $decoded->level;
                    $uri = current_url(true);
                    $totalSegment = $uri->getTotalSegments();
                    if ($totalSegment == 0) {

                        $uriMain = $uri->getSegment(1);
                        if ($uriMain === "" || $uriMain === "home" || $uriMain == "portal") {
                        } else {

                            return redirect()->to(base_url('portal'));
                        }
                    } else {
                        return redirect()->to(base_url('portal'));
                    }
                } else {
                    $uri = current_url(true);
                    $totalSegment = $uri->getTotalSegments();
                    if ($totalSegment > 0) {

                        $uriMain = $uri->getSegment(1);
                        if ($uriMain != 'auth') {
                            return redirect()->to(base_url('auth'));
                        }
                    }
                }
            } catch (\Exception $e) {
                $uri = current_url(true);
                $totalSegment = $uri->getTotalSegments();
                if ($totalSegment > 0) {

                    $uriMain = $uri->getSegment(1);
                    if ($uriMain != 'auth') {
                        return redirect()->to(base_url('auth'));
                    }
                }
            }
        } else {
            $uri = current_url(true);
            $totalSegment = $uri->getTotalSegments();
            if ($totalSegment > 0) {
                $uriMain = $uri->getSegment(1);
                if ($uriMain != 'auth') {
                    return redirect()->to(base_url('auth'));
                }
            }
        }
    }
}
