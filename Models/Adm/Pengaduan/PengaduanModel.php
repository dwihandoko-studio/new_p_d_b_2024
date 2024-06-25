<?php

namespace App\Models\Adm\Pengaduan;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class PengaduanModel extends Model
{
    protected $table = "data_pengaduan a";
    protected $column_order = array(null, null, 'a.jenis_pengaduan', 'a.nama_pengadu', 'a.no_tiket');
    protected $column_search = array('a.no_tiket', 'a.nama_pengadu');
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

        $this->dt->orderBy('a.created_at', 'asc');
        // $this->dt->orderBy('b.bentuk_pendidikan_id', 'desc');
        // $this->dt->orderBy('a.nama', 'asc');
        // if ($this->request->getPost('order')) {
        //     $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        // } else if (isset($this->order)) {
        //     $order = $this->order;
        //     $this->dt->orderBy(key($order), $order[key($order)]);
        // }
    }
    function get_datatables()
    {
        // $this->dt->select("b.sekolah_id, a.nama, b.npsn, b.bentuk_pendidikan_id, a.bentuk_pendidikan, a.kecamatan, b.jumlah_rombel_kebutuhan, b.is_locked");
        // $this->dt->join('dapo_sekolah a', 'a.sekolah_id = b.sekolah_id');
        if ($this->request->getPost('jenis_pengaduan')) {
            $kec = htmlspecialchars($this->request->getPost('jenis_pengaduan'), true);
            if ($kec !== "") {
                $this->dt->where('a.jenis_pengaduan', $kec);
            }
        }
        // if ($this->request->getPost('jenjang')) {
        //     $jenjang = htmlspecialchars($this->request->getPost('jenjang'), true);
        //     if ($jenjang !== "") {
        //         $this->dt->where('b.bentuk_pendidikan_id', $jenjang);
        //     }
        // }
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered()
    {
        // $this->dt->select("b.sekolah_id, a.nama, b.npsn, b.bentuk_pendidikan_id, a.bentuk_pendidikan, a.kecamatan, a.kode_kecamatan, b.jumlah_rombel_kebutuhan");
        // $this->dt->join('dapo_sekolah a', 'a.sekolah_id = b.sekolah_id');
        if ($this->request->getPost('jenis_pengaduan')) {
            $kec = htmlspecialchars($this->request->getPost('jenis_pengaduan'), true);
            if ($kec !== "") {
                $this->dt->where('a.jenis_pengaduan', $kec);
            }
        }
        // if ($this->request->getPost('jenjang')) {
        //     $jenjang = htmlspecialchars($this->request->getPost('jenjang'), true);
        //     if ($jenjang !== "") {
        //         $this->dt->where('b.bentuk_pendidikan_id', $jenjang);
        //     }
        // }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
    public function count_all()
    {
        // $this->dt->select("b.sekolah_id, a.nama, b.npsn, b.bentuk_pendidikan_id, a.bentuk_pendidikan, a.kecamatan, a.kode_kecamatan, b.jumlah_rombel_kebutuhan");
        // $this->dt->join('dapo_sekolah a', 'a.sekolah_id = b.sekolah_id');
        if ($this->request->getPost('jenis_pengaduan')) {
            $kec = htmlspecialchars($this->request->getPost('jenis_pengaduan'), true);
            if ($kec !== "") {
                $this->dt->where('a.jenis_pengaduan', $kec);
            }
        }
        // if ($this->request->getPost('jenjang')) {
        //     $jenjang = htmlspecialchars($this->request->getPost('jenjang'), true);
        //     if ($jenjang !== "") {
        //         $this->dt->where('b.bentuk_pendidikan_id', $jenjang);
        //     }
        // }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
