<?php

namespace App\Models\Adm\Analisis;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ProsesjalurModel extends Model
{
    protected $table = "_tb_pendaftar a";
    protected $column_order = array('a.jarak_domisili', null, null, null, null, null, 'a.jarak_domisili');
    protected $column_search = array('a.nisn_peserta', 'a.nama_peserta');
    // protected $order = array('jarak' => 'asc', 'a.created_at' => 'asc');
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
        // $select = "b.id, b.nisn, b.fullname, b.peserta_didik_id, b.latitude, b.longitude, a.id as id_pendaftaran, c.nama as nama_sekolah_asal, c.npsn as npsn_sekolah_asal, j.nama as nama_sekolah_tujuan, j.npsn as npsn_sekolah_tujuan, j.latitude as latitude_sekolah_tujuan, j.longitude as longitude_sekolah_tujuan, a.kode_pendaftaran, a.via_jalur, a.created_at, ROUND(getDistanceKm(b.latitude,b.longitude,j.latitude,j.longitude), 2) AS jarak";  //14

        // $this->dt->select($select);
        // $this->dt->join('_users_profil_tb b', 'a.peserta_didik_id = b.peserta_didik_id', 'LEFT');
        // $this->dt->join('ref_sekolah c', 'a.from_sekolah_id = c.id', 'LEFT');
        // $this->dt->join('ref_sekolah j', 'a.tujuan_sekolah_id_1 = j.id', 'LEFT');
        // $this->dt->join('ref_bentuk_pendidikan i', 'c.bentuk_pendidikan_id = i.id', 'LEFT');
        // $this->dt->join('ref_provinsi d', 'b.provinsi = d.id', 'LEFT');
        // $this->dt->join('ref_kabupaten e', 'b.kabupaten = e.id', 'LEFT');
        // $this->dt->join('ref_kecamatan f', 'b.kecamatan = f.id', 'LEFT');
        // $this->dt->join('ref_kelurahan g', 'b.kelurahan = g.id', 'LEFT');
        // $this->dt->join('ref_dusun h', 'b.dusun = h.id', 'LEFT');
        // $this->dt->join('_upload_kelengkapan_berkas k', 'b.id = k.user_id', 'LEFT');

        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    // $this->dt->groupStart();
                    // $this->dt->like($item, $this->request->getPost('search')['value']);
                    $this->dt->where($item, $this->request->getPost('search')['value']);
                } else {
                    // $this->dt->orLike($item, $this->request->getPost('search')['value']);
                    $this->dt->where($item, $this->request->getPost('search')['value']);
                }
                // if (count($this->column_search) - 1 == $i)
                //     $this->dt->groupEnd();
            }
            $i++;
        }

        $this->dt->orderBy('a.jarak_domisili', 'ASC');
        $this->dt->orderBy('a.created_at', 'ASC');
        // if ($this->request->getPost('order')) {
        //     $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        // } else if (isset($this->order)) {
        //     $order = $this->order;
        //     $this->dt->orderBy(key($order), $order[key($order)]);
        // }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        // $this->dt->where("a.tujuan_sekolah_id = (SELECT sekolah_id FROM _users_profil_tb WHERE id = '$userId') AND (a.status_pendaftaran = 1)");
        $this->dt->where('a.status_pendaftaran', 1);
        // $this->dt->whereIn('a.status_pendaftaran', [2, 3]);
        $sekolah_id = htmlspecialchars($this->request->getPost('id'), true);
        $this->dt->where('a.tujuan_sekolah_id_1', $sekolah_id);

        $filter_jalur = htmlspecialchars($this->request->getPost('jalur'), true);
        if ($filter_jalur != "") {
            $this->dt->where('a.via_jalur', $filter_jalur);
        } else {
            $this->dt->where('a.via_jalur', 'AFIRMASI');
        }

        // if ($filter_jenjang != "") {
        //     $this->dt->where('j.bentuk_pendidikan_id', $filter_jenjang);
        // }

        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $this->dt->where('a.status_pendaftaran', 1);
        // $this->dt->whereIn('a.status_pendaftaran', [2, 3]);
        $sekolah_id = htmlspecialchars($this->request->getPost('id'), true);
        $this->dt->where('a.tujuan_sekolah_id_1', $sekolah_id);

        $filter_jalur = htmlspecialchars($this->request->getPost('jalur'), true);
        if ($filter_jalur != "") {
            $this->dt->where('a.via_jalur', $filter_jalur);
        } else {
            $this->dt->where('a.via_jalur', 'AFIRMASI');
        }

        // if ($filter_jenjang != "") {
        //     $this->dt->where('j.bentuk_pendidikan_id', $filter_jenjang);
        // }

        return $this->dt->countAllResults();
    }

    public function count_all()
    {
        $this->_get_datatables_query();
        $this->dt->where('a.status_pendaftaran', 1);
        $sekolah_id = htmlspecialchars($this->request->getPost('id'), true);
        $this->dt->where('a.tujuan_sekolah_id_1', $sekolah_id);

        $filter_jalur = htmlspecialchars($this->request->getPost('jalur'), true);
        if ($filter_jalur != "") {
            $this->dt->where('a.via_jalur', $filter_jalur);
        } else {
            $this->dt->where('a.via_jalur', 'AFIRMASI');
        }

        // if ($filter_jenjang != "") {
        //     $this->dt->where('j.bentuk_pendidikan_id', $filter_jenjang);
        // }

        return $this->dt->countAllResults();
    }
}
