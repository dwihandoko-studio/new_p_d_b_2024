<?php

namespace App\Models\Sigaji\Adm\Verifikasi;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class TagihanbankModel extends Model
{
    protected $table = "tb_tagihan_bank_antrian a";
    protected $column_order = array(null, null, 'b.nama_bank', null, null, null);
    protected $column_search = array('b.nama');
    protected $order = array('c.tahun' => 'desc', 'c.bulan' => 'desc');
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect('sigaji');
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

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }
    function get_datatables()
    {
        $select = "count(a.id_pegawai) as jumlah_pegawai, sum(a.jumlah_tagihan) as jumlah_tagihan, a.tahun as id_tahun, b.nama_bank, c.tahun, c.bulan, a.dari_bank";
        $this->dt->select($select);
        $this->dt->join('ref_bank b', 'a.dari_bank = b.id', 'LEFT');
        $this->dt->join('_ref_tahun_bulan c', 'a.tahun = c.id', 'LEFT');

        $this->dt->where(['a.status_ajuan' => 1]);
        $this->dt->groupBy('a.dari_bank');
        $this->dt->groupBy('a.tahun');

        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered()
    {
        $select = "count(a.id_pegawai) as jumlah_pegawai, sum(a.jumlah_tagihan) as jumlah_tagihan, a.tahun as id_tahun, b.nama_bank, c.tahun, c.bulan, a.dari_bank";
        $this->dt->select($select);
        $this->dt->join('ref_bank b', 'a.dari_bank = b.id', 'LEFT');
        $this->dt->join('_ref_tahun_bulan c', 'a.tahun = c.id', 'LEFT');

        $this->dt->where(['a.status_ajuan' => 1]);
        $this->dt->groupBy('a.dari_bank');
        $this->dt->groupBy('a.tahun');

        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
    public function count_all()
    {
        $select = "count(a.id_pegawai) as jumlah_pegawai, sum(a.jumlah_tagihan) as jumlah_tagihan, a.tahun as id_tahun, b.nama_bank, c.tahun, c.bulan, a.dari_bank";
        $this->dt->select($select);
        $this->dt->join('ref_bank b', 'a.dari_bank = b.id', 'LEFT');
        $this->dt->join('_ref_tahun_bulan c', 'a.tahun = c.id', 'LEFT');

        $this->dt->where(['a.status_ajuan' => 1]);
        $this->dt->groupBy('a.dari_bank');
        $this->dt->groupBy('a.tahun');

        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
