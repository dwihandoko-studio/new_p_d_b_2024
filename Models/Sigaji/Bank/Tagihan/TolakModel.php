<?php

namespace App\Models\Sigaji\Bank\Tagihan;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class TolakModel extends Model
{
    protected $table = "tb_tagihan_bank_antrian a";
    protected $column_order = array(null, null, null, null);
    protected $column_search = array('b.nip', 'b.nama');
    protected $order = array('b.nama' => 'asc');
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
    function get_datatables($dari_bank)
    {
        $this->dt->select("a.id, a.tahun as id_tahun, a.id_pegawai, b.nama, b.nip, b.kode_instansi, b.nama_instansi, b.nama_kecamatan, c.tahun, c.bulan, count(a.id_pegawai) as jumlah_pegawai, SUM(a.jumlah_tagihan) as jumlah_tagihan");
        $this->dt->join('_ref_tahun_bulan c', 'a.tahun = c.id');
        $this->dt->join('tb_pegawai_ b', 'a.id_pegawai = b.id');
        $this->dt->where('a.dari_bank', $dari_bank);
        $this->dt->where('a.status_ajuan', 3);
        if ($this->request->getPost('tw')) {
            $tw = htmlspecialchars($this->request->getPost('tw'), true);
            if ($tw !== "") {
                $this->dt->where('a.tahun', $tw);
            } else {
                if ($this->request->getPost('tw_active')) {
                    if ($this->request->getPost('tw_active') !== "") {

                        $this->dt->where('a.tahun', $this->request->getPost('tw_active'));
                    }
                }
            }
        } else {
            if ($this->request->getPost('tw_active')) {
                $tw_active = htmlspecialchars($this->request->getPost('tw_active'), true);
                if ($tw_active) {

                    $this->dt->where('a.tahun', $this->request->getPost('tw_active'));
                }
            }
        }
        $query = $this->dt->groupBy('a.tahun');
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered($dari_bank)
    {
        $this->dt->select("a.id, a.tahun as id_tahun, a.id_pegawai, b.nama, b.nip, b.kode_instansi, b.nama_instansi, b.nama_kecamatan, c.tahun, c.bulan, count(a.id_pegawai) as jumlah_pegawai, SUM(a.jumlah_tagihan)");
        $this->dt->join('_ref_tahun_bulan c', 'a.tahun = c.id');
        $this->dt->join('tb_pegawai_ b', 'a.id_pegawai = b.id');
        $this->dt->where('a.dari_bank', $dari_bank);
        $this->dt->where('a.status_ajuan', 3);
        if ($this->request->getPost('tw')) {
            $tw = htmlspecialchars($this->request->getPost('tw'), true);
            if ($tw !== "") {
                $this->dt->where('a.tahun', $tw);
            } else {
                if ($this->request->getPost('tw_active')) {
                    if ($this->request->getPost('tw_active') !== "") {

                        $this->dt->where('a.tahun', $this->request->getPost('tw_active'));
                    }
                }
            }
        } else {
            if ($this->request->getPost('tw_active')) {
                $tw_active = htmlspecialchars($this->request->getPost('tw_active'), true);
                if ($tw_active) {

                    $this->dt->where('a.tahun', $this->request->getPost('tw_active'));
                }
            }
        }
        $query = $this->dt->groupBy('a.tahun');
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
    public function count_all($dari_bank)
    {
        $this->dt->select("a.id, a.tahun as id_tahun, a.id_pegawai, b.nama, b.nip, b.kode_instansi, b.nama_instansi, b.nama_kecamatan, c.tahun, c.bulan, count(a.id_pegawai) as jumlah_pegawai, SUM(a.jumlah_tagihan)");
        $this->dt->join('_ref_tahun_bulan c', 'a.tahun = c.id');
        $this->dt->join('tb_pegawai_ b', 'a.id_pegawai = b.id');
        $this->dt->where('a.dari_bank', $dari_bank);
        $this->dt->where('a.status_ajuan', 3);
        if ($this->request->getPost('tw')) {
            $tw = htmlspecialchars($this->request->getPost('tw'), true);
            if ($tw !== "") {
                $this->dt->where('a.tahun', $tw);
            } else {
                if ($this->request->getPost('tw_active')) {
                    if ($this->request->getPost('tw_active') !== "") {

                        $this->dt->where('a.tahun', $this->request->getPost('tw_active'));
                    }
                }
            }
        } else {
            if ($this->request->getPost('tw_active')) {
                $tw_active = htmlspecialchars($this->request->getPost('tw_active'), true);
                if ($tw_active) {

                    $this->dt->where('a.tahun', $this->request->getPost('tw_active'));
                }
            }
        }
        $query = $this->dt->groupBy('a.tahun');
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
