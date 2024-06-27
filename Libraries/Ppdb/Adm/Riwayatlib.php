<?php

namespace App\Libraries\Ppdb\Adm;

use App\Libraries\Uuid;

class Riwayatlib
{
    private $_db;
    private $tb;
    function __construct()
    {
        helper(['text', 'array', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    public function getAll($page = "1", $keyword = "")
    {
        $data = [];
        $limit_per_page = 10;

        if ((int)$page == 0 || (int)$page == 1) {
            $page = 1;
            $start = 0;
        } else {
            $page = (int)$page;
            $start = (($page - 1) * $limit_per_page);
        }

        if ($keyword == "") {
            $data['result'] = $this->_db->table('riwayat_system_dinas')
                ->orderBy('created_at', 'desc')
                ->limit($limit_per_page, $start)
                ->get()->getResult();
            $data['countData'] = $this->_db->table('riwayat_system_dinas')
                ->countAllResults();
            $data['page'] = $page;
            $data['totalPage'] = ($data['countData'] > 0) ? ceil($data['countData'] / $limit_per_page) : 0;
            $data['keyword'] = $keyword;
        } else {
            $data['result'] = $this->_db->table('riwayat_system_dinas')
                ->where("aksi LIKE '%$keyword%' OR keterangan LIKE '%$keyword%'")
                ->orderBy('created_at', 'desc')
                ->limit($limit_per_page, $start)
                ->get()->getResult();
            $data['countData'] = $this->_db->table('riwayat_system_dinas')
                ->where("aksi LIKE '%$keyword%' OR keterangan LIKE '%$keyword%'")
                ->countAllResults();
            $data['page'] = $page;
            $data['totalPage'] = ($data['countData'] > 0) ? ceil($data['countData'] / $limit_per_page) : 0;
            $data['keyword'] = $keyword;
        }

        return $data;
    }

    public function insert($userId, $keterangan, $aksi = "merubah data", $icon = "submit")
    {

        $uuidLib = new Uuid();
        $uuid = $uuidLib->v4();
        $dataInsert = [
            'id' => $uuid,
            'user_id' => $userId,
            'keterangan' => $keterangan,
            'aksi' => $aksi,
            'icon' => $icon,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        return $this->_db->table('riwayat_system_dinas')->insert($dataInsert);
    }
}
