<?php

namespace App\Libraries\Sigaji;

class Acclib
{
    private $_db;
    private $_db_gaji;
    function __construct()
    {
        helper(['text', 'session', 'cookie', 'array', 'filesystem']);
        $this->_db      = \Config\Database::connect();
        $this->_db_gaji      = \Config\Database::connect('sigaji');
    }

    public function getAccess($userId)
    {

        $granted = $this->_db->table('granted_sigaji')
            ->where('id', $userId)
            ->countAllResults();

        if ($granted > 0) {
            return true;
        }

        return false;
    }

    public function getLockedSIPD($tahun)
    {

        $granted = $this->_db_gaji->table('tb_gaji_sipd')
            ->where(['tahun' => $tahun, 'is_locked' => 1])
            ->countAllResults();

        if ($granted > 0) {
            return true;
        }

        return false;
    }
}
