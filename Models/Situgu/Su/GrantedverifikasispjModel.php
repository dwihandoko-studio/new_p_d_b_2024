<?php

namespace App\Models\Situgu\Su;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class GrantedverifikasispjModel extends Model
{
    protected $table = "granted_verifikasi_spj a";
    protected $column_order = array(null, null, 'b.fullname', 'c.role', 'c.kecamatan');
    protected $column_search = array('b.fullname');
    protected $order = array('b.fullname' => 'asc');
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
        $select = "a.id, b.fullname, c.role as role_name, d.nama_kecamatan";

        $this->dt->select($select);
        $this->dt->join('_profil_users_tb b', 'a.id = b.id');
        $this->dt->join('_role_user c', 'b.role_user = c.id', 'LEFT');
        $this->dt->join('ref_kecamatan d', 'b.nama_kecamatan = d.id', 'LEFT');

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

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }
    function get_datatables()
    {
        // $this->dt->whereIn("role_user", [2, 3, 4]);
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered()
    {
        // $this->dt->whereIn("role_user", [2, 3, 4]);
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
    public function count_all()
    {
        // $this->dt->whereIn("role_user", [2, 3, 4]);
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
