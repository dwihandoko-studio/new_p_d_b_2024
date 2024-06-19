<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Profilelib
{
    private $_db;
    function __construct()
    {
        helper(['text', 'session', 'cookie', 'array', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    public function user()
    {
        $jwt = get_cookie('jwt');
        $token_jwt = getenv('token_jwt.default.key');
        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
                if ($decoded) {
                    $userId = $decoded->id;
                    $level = $decoded->level;

                    switch ((int)$level) {
                        case 0:
                            $user = $this->_db->table('v_user_verval_admin')
                                ->where('id', $userId)
                                ->get()->getRowObject();
                            $level_nama = "Superadmin";
                            break;
                        case 1:
                            $user = $this->_db->table('v_user_verval_admin')
                                ->where('id', $userId)
                                ->get()->getRowObject();
                            $level_nama = "Admin";
                            break;
                        case 2:
                            $user = $this->_db->table('v_user_verval_admin')
                                ->where('id', $userId)
                                ->get()->getRowObject();
                            $level_nama = "Dinas";
                            break;
                        case 3:
                            $user = $this->_db->table('v_user_verval_sekolah')
                                ->where('id', $userId)
                                ->get()->getRowObject();
                            $level_nama = "Monev";
                            break;

                        default:
                            $user = $this->_db->table('v_user_pd')
                                ->where('id', $userId)
                                ->get()->getRowObject();
                            $level_nama = "Pengguna";
                            break;
                    }
                    // $user = $this->_db->table('v_user_verval')
                    //     ->where('id', $userId)
                    //     ->get()->getRowObject();
                    if ($user) {
                        $response = new \stdClass;
                        $response->status = 200;
                        $response->data = $user;
                        $response->level = $level;
                        $response->level_nama = $level_nama;
                    } else {
                        $response = new \stdClass;
                        $response->status = 401;
                        $response->message = "User tidak ditemukan atau user tidak active, silahkan hubungi admin.";
                    }
                } else {
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session telah habis.";
                }
            } catch (\Exception $e) {

                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session telah habis.";
            }
        } else {
            $response = new \stdClass;
            $response->status = 401;
            $response->message = "Session telah habis.";
        }

        return $response;
    }

    public function userSekolah()
    {
        $jwt = get_cookie('jwt');
        $token_jwt = getenv('token_jwt.default.key');
        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
                if ($decoded) {
                    $userId = $decoded->id;
                    $level = $decoded->level;

                    $user = $this->_db->table('v_user_verval_sekolah')
                        ->where('id', $userId)
                        ->get()->getRowObject();
                    $level_nama = "Admin Sekolah";

                    if ($user) {
                        $response = new \stdClass;
                        $response->status = 200;
                        $response->data = $user;
                        $response->level = $level;
                        $response->level_nama = $level_nama;
                    } else {
                        $response = new \stdClass;
                        $response->status = 401;
                        $response->message = "User tidak ditemukan atau user tidak active, silahkan hubungi admin.";
                    }
                } else {
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session telah habis.";
                }
            } catch (\Exception $e) {

                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session telah habis.";
            }
        } else {
            $response = new \stdClass;
            $response->status = 401;
            $response->message = "Session telah habis.";
        }

        return $response;
    }

    public function userPanitia()
    {
        $jwt = get_cookie('jwt');
        $token_jwt = getenv('token_jwt.default.key');
        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
                if ($decoded) {
                    $userId = $decoded->id;
                    $level = $decoded->level;

                    $user = $this->_db->table('v_user_verval_sekolah')
                        ->where('id', $userId)
                        ->get()->getRowObject();
                    $level_nama = "Admin Sekolah";

                    if ($user) {
                        $response = new \stdClass;
                        $response->status = 200;
                        $response->data = $user;
                        $response->level = $level;
                        $response->level_nama = $level_nama;
                    } else {
                        $response = new \stdClass;
                        $response->status = 401;
                        $response->message = "User tidak ditemukan atau user tidak active, silahkan hubungi admin.";
                    }
                } else {
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session telah habis.";
                }
            } catch (\Exception $e) {

                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session telah habis.";
            }
        } else {
            $response = new \stdClass;
            $response->status = 401;
            $response->message = "Session telah habis.";
        }

        return $response;
    }

    public function userPd()
    {
        $jwt = get_cookie('jwt');
        $token_jwt = getenv('token_jwt.default.key');
        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
                if ($decoded) {
                    $userId = $decoded->id;
                    $level = $decoded->level;

                    $user = $this->_db->table('v_user_verval_pd')
                        ->where('id', $userId)
                        ->get()->getRowObject();
                    $level_nama = "Peserta Didik";

                    if ($user) {
                        $response = new \stdClass;
                        $response->status = 200;
                        $response->data = $user;
                        $response->level = $level;
                        $response->level_nama = $level_nama;
                    } else {
                        $response = new \stdClass;
                        $response->status = 401;
                        $response->message = "User tidak ditemukan atau user tidak active, silahkan hubungi admin.";
                    }
                } else {
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session telah habis.";
                }
            } catch (\Exception $e) {

                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session telah habis.";
            }
        } else {
            $response = new \stdClass;
            $response->status = 401;
            $response->message = "Session telah habis.";
        }

        return $response;
    }

    public function userLevel()
    {
        $jwt = get_cookie('jwt');
        $token_jwt = getenv('token_jwt.default.key');
        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
                if ($decoded) {
                    $userId = $decoded->id;
                    $level = $decoded->level;

                    $user = $this->_db->table('_users_tb a')
                        ->select('a.level, a.id, b.role')
                        ->join('_role_user b', 'a.level = b.id')
                        ->where('a.id', $userId)
                        ->get()->getRowObject();
                    // $level_nama = "Superadmin";

                    if ($user) {
                        $response = new \stdClass;
                        $response->status = 200;
                        $response->data = $user;
                        $response->level = $level;
                        $response->level_nama = $user->role;
                    } else {
                        $response = new \stdClass;
                        $response->status = 401;
                        $response->message = "User tidak ditemukan atau user tidak active, silahkan hubungi admin.";
                    }
                } else {
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session telah habis.";
                }
            } catch (\Exception $e) {

                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session telah habis.";
            }
        } else {
            $response = new \stdClass;
            $response->status = 401;
            $response->message = "Session telah habis.";
        }

        return $response;
    }
}
