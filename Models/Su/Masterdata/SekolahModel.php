<?php

namespace App\Models\Su\Masterdata;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class SekolahModel extends Model
{
    protected $table = "dapo_sekolah a";
    protected $column_order = array(null, null, 'a.nama', 'a.npsn', 'a.bentuk_pendidikan', 'b.kecamatan', null);
    protected $column_search = array('a.nama', 'a.npsn');
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

        $this->dt->orderBy('a.kecamatan', 'asc');
        $this->dt->orderBy('a.bentuk_pendidikan', 'asc');
        $this->dt->orderBy('a.nama', 'asc');
        // if ($this->request->getPost('order')) {
        //     $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        // } else if (isset($this->order)) {
        //     $order = $this->order;
        //     $this->dt->orderBy(key($order), $order[key($order)]);
        // }
    }
    function get_datatables()
    {
        $this->dt->select("a.sekolah_id, a.nama, a.npsn, a.bentuk_pendidikan, a.bentuk_pendidikan_id, a.kecamatan, a.kode_kecamatan, CONCAT(a.lintang, ',', a.bujur) as latlong");
        // $this->dt->join('_role_user b', 'a.level = b.id');
        // $this->dt->whereNotIn('a.level', [0]);
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered()
    {
        $this->dt->select("a.sekolah_id, a.nama, a.npsn, a.bentuk_pendidikan, a.bentuk_pendidikan_id, a.kecamatan, a.kode_kecamatan, CONCAT(a.lintang, ',', a.bujur) as latlong");
        // $this->dt->join('_role_user b', 'a.level = b.id');
        // $this->dt->whereNotIn('a.level', [0]);
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
    public function count_all()
    {
        $this->dt->select("a.sekolah_id, a.nama, a.npsn, a.bentuk_pendidikan, a.bentuk_pendidikan_id, a.kecamatan, a.kode_kecamatan, CONCAT(a.lintang, ',', a.bujur) as latlong");
        // $this->dt->join('_role_user b', 'a.level = b.id');
        // $this->dt->whereNotIn('a.level', [0]);
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
