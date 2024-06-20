<?php

namespace App\Models\Sek\Ppdb\Rekap;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class LolosModel extends Model
{
    protected $table = "_tb_pendaftar a";
    protected $column_order = array(null, 'a.nama_peserta', 'a.nisn_peserta', 'a.via_jalur', 'a.nama_sekolah_asal', 'a.npsn_sekolah_asal', 'a.jarak_domisili');
    protected $column_search = array('a.nisn_peserta', 'a.nama_peserta', 'a.kode_pendaftaran');
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

        // $this->dt->orderBy('a.nama', 'asc');
        // if ($this->request->getPost('order')) {
        //     $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        // } else if (isset($this->order)) {
        //     $order = $this->order;
        //     $this->dt->orderBy(key($order), $order[key($order)]);
        // }
    }
    function get_datatables($id)
    {
        $this->dt->select("a.id, a.kode_pendaftaran, a.nama_peserta, a.nisn_peserta, a.nama_sekolah_asal, a.npsn_sekolah_asal, a.via_jalur, a.jarak_domisili, a.tujuan_sekolah_id_1");
        // $this->dt->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id');
        // $this->dt->whereNotIn('a.level', [0]);

        $this->dt->where('a.tujuan_sekolah_id_1', $id);
        if ($this->request->getPost('jalur')) {
            $jalur = htmlspecialchars($this->request->getPost('jalur'), true);
            if ($jalur !== "") {
                $this->dt->where('a.via_jalur', $jalur);
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

        $this->dt->where('a.tujuan_sekolah_id_1', $id);
        if ($this->request->getPost('jalur')) {
            $jalur = htmlspecialchars($this->request->getPost('jalur'), true);
            if ($jalur !== "") {
                $this->dt->where('a.via_jalur', $jalur);
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
        $this->dt->where('a.tujuan_sekolah_id_1', $id);
        if ($this->request->getPost('jalur')) {
            $jalur = htmlspecialchars($this->request->getPost('jalur'), true);
            if ($jalur !== "") {
                $this->dt->where('a.via_jalur', $jalur);
            }
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
