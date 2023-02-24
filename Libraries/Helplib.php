<?php

namespace App\Libraries;

class Helplib
{
    private $_db;
    function __construct()
    {
        helper(['text', 'session', 'cookie', 'array', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    public function getSekolahNaungan($userId)
    {

        $user = $this->_db->table('sekolah_naungan')
            ->select("npsn")
            ->where('user_id', $userId)
            ->get()->getRowObject();

        if ($user) {
            return explode(",", $user->npsn);
        }

        return [];
    }

    public function getSekolahNaunganString($userId)
    {

        $user = $this->_db->table('sekolah_naungan')
            ->select("npsn")
            ->where('user_id', $userId)
            ->get()->getRowObject();

        if ($user) {
            return $user->npsn;
        }

        return '';
    }

    public function getNpsn($userId)
    {

        $user = $this->_db->table('_profil_users_tb')
            ->select("npsn")
            ->where('id', $userId)
            ->get()->getRowObject();

        if ($user) {
            return $user->npsn;
        }

        return false;
    }

    public function getKecamatan($userId)
    {

        $user = $this->_db->table('_profil_users_tb')
            ->select("kecamatan")
            ->where('id', $userId)
            ->get()->getRowObject();

        if ($user) {
            return $user->kecamatan;
        }

        return false;
    }

    public function getPtkId($userId)
    {

        $user = $this->_db->table('_profil_users_tb a')
            ->select("a.ptk_id, b.id")
            ->join('_ptk_tb b', 'a.ptk_id = b.id_ptk', 'LEFT')
            ->where('a.id', $userId)
            ->get()->getRowObject();

        if ($user) {
            return $user->id;
        }

        return false;
    }

    public function nilaiTamsil()
    {
        $val = $this->_db->table('ref_gaji')
            ->select('gaji_pokok')
            ->where('pangkat', 'tamsil')
            ->get()->getRowObject();

        if ($val) {
            return $val->gaji_pokok;
        }

        return 0;
    }

    public function nilaiPghm()
    {
        $val = $this->_db->table('ref_gaji')
            ->select('gaji_pokok')
            ->where('pangkat', 'pghm')
            ->get()->getRowObject();

        if ($val) {
            return $val->gaji_pokok;
        }

        return 0;
    }

    public function getAccess($userId)
    {

        $granted = $this->_db->table('granted_mt')
            ->where('id', $userId)
            ->countAllResults();

        if ($granted > 0) {
            return true;
        }

        return false;
    }
}
