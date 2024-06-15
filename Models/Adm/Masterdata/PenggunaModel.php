<?php

namespace App\Models\Adm\Masterdata;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class PenggunaModel extends Model
{
    protected $table = "_users_tb a";
    protected $column_order = array(null, null, 'a.username', 'a.email', 'b.role', 'a.is_active', 'a.email_verified', 'a.wa_verified');
    protected $column_search = array('a.username', 'a.email');
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

        $this->dt->orderBy('a.level', 'desc');
        $this->dt->orderBy('a.username', 'asc');
        // if ($this->request->getPost('order')) {
        //     $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        // } else if (isset($this->order)) {
        //     $order = $this->order;
        //     $this->dt->orderBy(key($order), $order[key($order)]);
        // }
    }
    function get_datatables()
    {
        $this->dt->select("a.id, a.username, a.email, a.nohp, a.is_active, a.wa_verified, a.email_verified, a.level, b.role");
        $this->dt->join('_role_user b', 'a.level = b.id');
        if ($this->request->getPost('role')) {
            $role = htmlspecialchars($this->request->getPost('role'), true);
            if ($role !== "") {
                $this->dt->where('a.level', $role);
            }
        }
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered()
    {
        $this->dt->select("a.id, a.username, a.email, a.nohp, a.is_active, a.wa_verified, a.email_verified, a.level, b.role");
        $this->dt->join('_role_user b', 'a.level = b.id');
        if ($this->request->getPost('role')) {
            $role = htmlspecialchars($this->request->getPost('role'), true);
            if ($role !== "") {
                $this->dt->where('a.level', $role);
            }
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
    public function count_all()
    {
        $this->dt->select("a.id, a.username, a.email, a.nohp, a.is_active, a.wa_verified, a.email_verified, a.level, b.role");
        $this->dt->join('_role_user b', 'a.level = b.id');
        if ($this->request->getPost('role')) {
            $role = htmlspecialchars($this->request->getPost('role'), true);
            if ($role !== "") {
                $this->dt->where('a.level', $role);
            }
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
