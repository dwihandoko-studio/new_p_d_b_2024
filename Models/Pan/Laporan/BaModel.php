<?php

namespace App\Models\Pan\Laporan;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class BaModel extends Model
{
    protected $table = "riwayat_perubahan_data a";
    protected $column_order = array(null, 'a.nama_pengaju', 'a.status_pengaju', 'a.perubahan_pengaju');
    protected $column_search = array('a.nama_pengaju', 'a.status_pengaju', 'a.perubahan_pengaju');
    // protected $order = array('a.username' => 'asc');
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;

        $this->dt = $this->db->table($this->table);
    }
    private function _get_datatables_query()
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        $this->dt->orderBy('a.created_at', 'desc');
        // if ($this->request->getPost('order')) {
        //     $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        // } else if (isset($this->order)) {
        //     $order = $this->order;
        //     $this->dt->orderBy(key($order), $order[key($order)]);
        // }
    }
    function get_datatables($id)
    {
        $this->dt->select("a.id, a.id_perubahan, a.nama_pengaju, a.status_pengaju, a.perubahan_pengaju, a.user_id, a.created_at");
        // $this->dt->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id');
        // $this->dt->whereNotIn('a.level', [0]);

        $this->dt->where('a.user_id', $id);
        if ($this->request->getPost('jenis')) {
            $jalur = htmlspecialchars($this->request->getPost('jenis'), true);
            if ($jalur !== "") {
                $this->dt->where('a.perubahan_pengaju', $jalur);
            }
        }
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered($id)
    {
        // $this->dt->select("a.peserta_didik_id, a.sekolah_id, a.nama, a.nisn, a.tempat_lahir, a.jenis_kelamin, a.nik, a.no_kk, a.nama_ibu_kandung, a.tingkat_pendidikan_id, a.tingkat_pendidikan, CONCAT(a.lintang, ',', a.bujur) as latlong, a.semester_id, b.nama as nama_sekolah, b.npsn as npsn_sekolah");
        // $this->dt->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id');
        // $this->dt->join('_role_user b', 'a.level = b.id');
        // $this->dt->whereNotIn('a.level', [0]);

        $this->dt->where('a.user_id', $id);
        if ($this->request->getPost('jenis')) {
            $jalur = htmlspecialchars($this->request->getPost('jenis'), true);
            if ($jalur !== "") {
                $this->dt->where('a.perubahan_pengaju', $jalur);
            }
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
    public function count_all($id)
    {
        // $this->dt->select("a.peserta_didik_id, a.sekolah_id, a.nama, a.nisn, a.tempat_lahir, a.jenis_kelamin, a.nik, a.no_kk, a.nama_ibu_kandung, a.tingkat_pendidikan_id, a.tingkat_pendidikan, CONCAT(a.lintang, ',', a.bujur) as latlong, a.semester_id, b.nama as nama_sekolah, b.npsn as npsn_sekolah");
        // $this->dt->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id');
        // $this->dt->join('_role_user b', 'a.level = b.id');
        // $this->dt->whereNotIn('a.level', [0]);
        $this->dt->where('a.user_id', $id);
        if ($this->request->getPost('jenis')) {
            $jalur = htmlspecialchars($this->request->getPost('jenis'), true);
            if ($jalur !== "") {
                $this->dt->where('a.perubahan_pengaju', $jalur);
            }
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
