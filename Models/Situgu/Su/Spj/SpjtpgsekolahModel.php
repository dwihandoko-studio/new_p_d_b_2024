<?php

namespace App\Models\Situgu\Su\Spj;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class SpjtpgsekolahModel extends Model
{
    protected $table = "_tb_spj_tpg a";
    protected $column_order = array(null, null, 'b.nama', 'b.nuptk', 'b.status_pegewagaian', 'b.npsn', null, null);
    protected $column_search = array('b.npsn', 'b.nama', 'b.nuptk');
    protected $order = array('a.date_approve_spj' => 'asc');
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

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }
    function get_datatables($jenis)
    {
        $this->dt->select("a.kode_usulan, a.kode_usulan_different, a.lanjutkan_tw, a.id, a.id_usulan_different, a.id_ptk, a.id_tahun_tw, a.id_current_tahun_tw, a.us_pang_golongan, a.us_pang_tmt, a.us_pang_mk_tahun, a.us_gaji_pokok, a.no_sk_dirjen, a.no_urut_sk, a.tf_gaji_pokok_1, a.tf_gaji_pokok_2, a.tf_gaji_pokok_3, a.tf_jumlah_uang, a.tf_iuran_bpjs, a.tf_pph21, a.tf_jumlah_diterima, a.tf_no_rekening, a.lampiran_pernyataan, a.lampiran_rekening_koran, a.lampiran_sk_dirgen, b.nama, b.nuptk, b.status_kepegawaian, b.npsn");
        $this->dt->join('_ptk_tb b', "b.id = a.id_ptk", 'LEFT');
        $this->dt->where('a.status_usulan', 2);
        $this->dt->where("a.lampiran_pernyataan IS NOT NULL");
        if ($this->request->getPost('tw') !== "") {
            $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
        }
        // $this->dt->whereIn("SUBSTRING_INDEX(SUBSTRING_INDEX(a.kode_usulan, '-', -2), '-', 1)", $npsns);
        $this->dt->groupBy('a.kode_usulan');
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered($jenis)
    {
        $this->dt->select("a.id_ptk");
        // $this->dt->join('_ptk_tb b', "b.id = a.id_ptk", 'LEFT');
        $this->dt->where('a.status_usulan', 2);
        $this->dt->where("a.lampiran_pernyataan IS NOT NULL");
        if ($this->request->getPost('tw') !== "") {
            $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
        }
        // $this->dt->whereIn("SUBSTRING_INDEX(SUBSTRING_INDEX(a.kode_usulan, '-', -2), '-', 1)", $npsns);
        // $this->dt->groupBy('a.kode_usulan');
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
    public function count_all($jenis)
    {
        $this->dt->select("a.id_ptk");
        // $this->dt->join('_ptk_tb b', "b.id = a.id_ptk", 'LEFT');
        $this->dt->where('a.status_usulan', 2);
        $this->dt->where("a.lampiran_pernyataan IS NOT NULL");
        if ($this->request->getPost('tw') !== "") {
            $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
        }
        // $this->dt->whereIn("SUBSTRING_INDEX(SUBSTRING_INDEX(a.kode_usulan, '-', -2), '-', 1)", $npsns);
        // $this->dt->groupBy('a.kode_usulan');
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}

// class SpjtpgsekolahModel extends Model
// {
//     protected $table = "_tb_spj_tpg a";
//     protected $column_order = array(null, null, 'b.nama', 'b.npsn', 'b.bentuk_pendidikan', 'b.status_sekolah', 'b.kecamatan', null);
//     protected $column_search = array('b.npsn', 'b.nama');
//     protected $order = array('a.date_prosestransfer' => 'asc');
//     protected $request;
//     protected $db;
//     protected $dt;

//     function __construct(RequestInterface $request)
//     {
//         parent::__construct();
//         $this->db = db_connect();
//         $this->request = $request;

//         $this->dt = $this->db->table($this->table);
//     }
//     private function _get_datatables_query()
//     {
//         $i = 0;
//         foreach ($this->column_search as $item) {
//             if ($this->request->getPost('search')['value']) {
//                 if ($i === 0) {
//                     $this->dt->groupStart();
//                     $this->dt->like($item, $this->request->getPost('search')['value']);
//                 } else {
//                     $this->dt->orLike($item, $this->request->getPost('search')['value']);
//                 }
//                 if (count($this->column_search) - 1 == $i)
//                     $this->dt->groupEnd();
//             }
//             $i++;
//         }

//         if ($this->request->getPost('order')) {
//             $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
//         } else if (isset($this->order)) {
//             $order = $this->order;
//             $this->dt->orderBy(key($order), $order[key($order)]);
//         }
//     }
//     function get_datatables($jenis)
//     {
//         $this->dt->select("count(a.kode_usulan) as jumlah_ptk, a.kode_usulan, a.status_usulan, a.date_approve_sptjm, b.nama, b.npsn, b.bentuk_pendidikan, b.status_sekolah, b.kecamatan");
//         $this->dt->join('ref_sekolah b', "b.npsn = SUBSTRING_INDEX(SUBSTRING_INDEX(a.kode_usulan, '-', -2), '-', 1)");
//         $this->dt->where('a.status_usulan', 2);
//         $this->dt->where("a.lampiran_pernyataan IS NOT NULL");
//         if ($this->request->getPost('tw') !== "") {
//             $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
//         }
//         // $this->dt->whereIn("SUBSTRING_INDEX(SUBSTRING_INDEX(a.kode_usulan, '-', -2), '-', 1)", $npsns);
//         $this->dt->groupBy('a.kode_usulan');
//         $this->_get_datatables_query();
//         if ($this->request->getPost('length') != -1)
//             $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
//         $query = $this->dt->get();
//         return $query->getResult();
//     }
//     function count_filtered($jenis)
//     {
//         $this->dt->select("count(a.kode_usulan) as jumlah_ptk, a.kode_usulan, a.status_usulan, a.date_approve_sptjm, b.nama, b.npsn, b.bentuk_pendidikan, b.status_sekolah, b.kecamatan");
//         $this->dt->join('ref_sekolah b', "b.npsn = SUBSTRING_INDEX(SUBSTRING_INDEX(a.kode_usulan, '-', -2), '-', 1)");
//         $this->dt->where('a.status_usulan', 2);
//         $this->dt->where("a.lampiran_pernyataan IS NOT NULL");
//         if ($this->request->getPost('tw') !== "") {
//             $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
//         }
//         // $this->dt->whereIn("SUBSTRING_INDEX(SUBSTRING_INDEX(a.kode_usulan, '-', -2), '-', 1)", $npsns);
//         $this->dt->groupBy('a.kode_usulan');
//         $this->_get_datatables_query();

//         return $this->dt->countAllResults();
//     }
//     public function count_all($jenis)
//     {
//         $this->dt->select("count(a.kode_usulan) as jumlah_ptk, a.kode_usulan, a.status_usulan, a.date_approve_sptjm, b.nama, b.npsn, b.bentuk_pendidikan, b.status_sekolah, b.kecamatan");
//         $this->dt->join('ref_sekolah b', "b.npsn = SUBSTRING_INDEX(SUBSTRING_INDEX(a.kode_usulan, '-', -2), '-', 1)");
//         $this->dt->where('a.status_usulan', 2);
//         $this->dt->where("a.lampiran_pernyataan IS NOT NULL");
//         if ($this->request->getPost('tw') !== "") {
//             $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
//         }
//         // $this->dt->whereIn("SUBSTRING_INDEX(SUBSTRING_INDEX(a.kode_usulan, '-', -2), '-', 1)", $npsns);
//         $this->dt->groupBy('a.kode_usulan');
//         $this->_get_datatables_query();

//         return $this->dt->countAllResults();
//     }
// }
