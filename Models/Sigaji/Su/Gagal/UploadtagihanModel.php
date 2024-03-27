<?php

namespace App\Models\Sigaji\Su\Gagal;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class UploadtagihanModel extends Model
{
    protected $table = "tb_tagihan_gagal_upload a";
    protected $column_order = array(null, null, null, 'b.nama_bank', 'a.nip', 'a.instansi', 'a.kecamatan', 'a.jumlah_tagihan');
    protected $column_search = array('b.nama_bank', 'a.nip');
    protected $order = array('a.instansi' => 'asc');
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
        $this->dt->select("a.id, a.tahun, b.nama_bank, a.nip, a.instansi, a.instansi, a.jumlah_tagihan, a.kecamatan, c.tahun, c.bulan");
        $this->dt->join('_ref_tahun_bulan c', 'a.tahun = c.id');
        $this->dt->join('ref_bank b', 'a.dari_bank = b.id');
        // $this->dt->whereIn('a.status_usulan', [2]);
        if ($this->request->getPost('tw')) {
            if ($this->request->getPost('tw') !== "") {
                $this->dt->where('a.tahun', $this->request->getPost('tw'));
            } else {
                if ($this->request->getPost('tw_active')) {
                    if ($this->request->getPost('tw_active') !== "") {

                        $this->dt->where('a.tahun', $this->request->getPost('tw_active'));
                    }
                }
            }
        } else {
            if ($this->request->getPost('tw_active')) {
                if ($this->request->getPost('tw_active') !== "") {

                    $this->dt->where('a.tahun', $this->request->getPost('tw_active'));
                }
            }
        }
        if ($this->request->getPost('bank')) {
            $bank = htmlspecialchars($this->request->getPost('bank'), true);
            if ($bank !== "") {
                $this->dt->where('a.dari_bank', $bank);
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
        $this->dt->select("a.id, a.tahun, b.nama_bank, a.nip, a.instansi, a.instansi, a.jumlah_tagihan, a.kecamatan, c.tahun, c.bulan");
        $this->dt->join('_ref_tahun_bulan c', 'a.tahun = c.id');
        $this->dt->join('ref_bank b', 'a.dari_bank = b.id');
        if ($this->request->getPost('tw')) {
            if ($this->request->getPost('tw') !== "") {
                $this->dt->where('a.tahun', $this->request->getPost('tw'));
            } else {
                if ($this->request->getPost('tw_active')) {
                    if ($this->request->getPost('tw_active') !== "") {

                        $this->dt->where('a.tahun', $this->request->getPost('tw_active'));
                    }
                }
            }
        } else {
            if ($this->request->getPost('tw_active')) {
                if ($this->request->getPost('tw_active') !== "") {

                    $this->dt->where('a.tahun', $this->request->getPost('tw_active'));
                }
            }
        }
        if ($this->request->getPost('bank')) {
            $bank = htmlspecialchars($this->request->getPost('bank'), true);
            if ($bank !== "") {
                $this->dt->where('a.dari_bank', $bank);
            }
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
    public function count_all()
    {
        $this->dt->select("a.id, a.tahun, b.nama_bank, a.nip, a.instansi, a.instansi, a.jumlah_tagihan, a.kecamatan, c.tahun, c.bulan");
        $this->dt->join('_ref_tahun_bulan c', 'a.tahun = c.id');
        $this->dt->join('ref_bank b', 'a.dari_bank = b.id');
        if ($this->request->getPost('tw')) {
            if ($this->request->getPost('tw') !== "") {
                $this->dt->where('a.tahun', $this->request->getPost('tw'));
            } else {
                if ($this->request->getPost('tw_active')) {
                    if ($this->request->getPost('tw_active') !== "") {

                        $this->dt->where('a.tahun', $this->request->getPost('tw_active'));
                    }
                }
            }
        } else {
            if ($this->request->getPost('tw_active')) {
                if ($this->request->getPost('tw_active') !== "") {

                    $this->dt->where('a.tahun', $this->request->getPost('tw_active'));
                }
            }
        }
        if ($this->request->getPost('bank')) {
            $bank = htmlspecialchars($this->request->getPost('bank'), true);
            if ($bank !== "") {
                $this->dt->where('a.dari_bank', $bank);
            }
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
