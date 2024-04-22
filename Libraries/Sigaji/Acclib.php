<?php

namespace App\Libraries\Sigaji;

class Acclib
{
    private $_db;
    function __construct()
    {
        helper(['text', 'session', 'cookie', 'array', 'filesystem']);
        $this->_db      = \Config\Database::connect('sigaji');
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
}
