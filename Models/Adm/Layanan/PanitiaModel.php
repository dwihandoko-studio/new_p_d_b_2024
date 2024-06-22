<?php

namespace App\Models\Adm\Layanan;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class PanitiaModel extends Model
{
    protected $table = "panitia_ppdb a";
    protected $column_order = array(null, 'a.jabatan_ppdb', 'a.nama', 'a.jabatan', 'b.is_active');
    protected $column_search = array('a.nama', 'a.jabatan', 'a.jabatan_ppdb');
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
    }
    function get_datatables()
    {
        $this->dt->select("a.*, b.is_active");
        $this->dt->join('_users_tb b', 'b.id = a.id');
        $id = htmlspecialchars($this->request->getPost('id'), true);
        $this->dt->where('a.sekolah_id', $id);
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered()
    {
        // $this->dt->select("a.peserta_didik_id, a.sekolah_id, a.nama, a.nisn, a.tempat_lahir, a.jenis_kelamin, a.nik, a.no_kk, a.nama_ibu_kandung, a.tingkat_pendidikan_id, a.tingkat_pendidikan, CONCAT(a.lintang, ',', a.bujur) as latlong, a.semester_id, b.nama as nama_sekolah, b.npsn as npsn_sekolah");
        // $this->dt->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id');
        // $this->dt->join('_role_user b', 'a.level = b.id');
        // $this->dt->whereNotIn('a.level', [0]);
        $id = htmlspecialchars($this->request->getPost('id'), true);

        $this->dt->where('a.sekolah_id', $id);

        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
    public function count_all()
    {
        // $this->dt->select("a.peserta_didik_id, a.sekolah_id, a.nama, a.nisn, a.tempat_lahir, a.jenis_kelamin, a.nik, a.no_kk, a.nama_ibu_kandung, a.tingkat_pendidikan_id, a.tingkat_pendidikan, CONCAT(a.lintang, ',', a.bujur) as latlong, a.semester_id, b.nama as nama_sekolah, b.npsn as npsn_sekolah");
        // $this->dt->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id');
        // $this->dt->join('_role_user b', 'a.level = b.id');
        // $this->dt->whereNotIn('a.level', [0]);
        $id = htmlspecialchars($this->request->getPost('id'), true);
        $this->dt->where('a.sekolah_id', $id);
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
