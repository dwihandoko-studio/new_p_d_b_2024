<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class KuotapendaftaranModel extends Model
{
    protected $table = "_setting_kuota_tb a";
    protected $column_order = array(null, 'b.nama', null, null, null, null, null);
    protected $column_search = array('b.nama', 'b.npsn');
    protected $order = array('a.zonasi' => 'desc');
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

        // $select = "a.*, b.nama as nama_sekolah, c.nama as nama_kecamatan, ((SELECT count(id) FROM _tb_pendaftar_temp WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'ZONASI') + (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'ZONASI')) as pendaftar_zonasi, ((SELECT count(id) FROM _tb_pendaftar_temp WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'AFIRMASI') + (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'AFIRMASI')) as pendaftar_afirmasi, ((SELECT count(id) FROM _tb_pendaftar_temp WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'MUTASI') + (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'MUTASI')) as pendaftar_mutasi, ((SELECT count(id) FROM _tb_pendaftar_temp WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'PRESTASI') + (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'PRESTASI')) as pendaftar_prestasi, ((SELECT count(id) FROM _tb_pendaftar_temp WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'SWASTA') + (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'SWASTA')) as pendaftar_swasta, (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'ZONASI') as terverifikasi_zonasi, (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'AFIRMASI') as terverifikasi_afirmasi, (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'MUTASI') as terverifikasi_mutasi, (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'PRESTASI') as terverifikasi_prestasi, (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'SWASTA') as terverifikasi_swasta, (SELECT count(id) FROM _tb_pendaftar_temp WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'ZONASI') as belum_verifikasi_zonasi, (SELECT count(id) FROM _tb_pendaftar_temp WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'AFIRMASI') as belum_verifikasi_afirmasi, (SELECT count(id) FROM _tb_pendaftar_temp WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'MUTASI') as belum_verifikasi_mutasi, (SELECT count(id) FROM _tb_pendaftar_temp WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'PRESTASI') as belum_verifikasi_prestasi, (SELECT count(id) FROM _tb_pendaftar_temp WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'SWASTA') as belum_verifikasi_swasta";

        // $this->dt->select($select);
        // // $this->dt->join('_users_profil_tb e', 'a.sekolah_id = e.sekolah_id');
        // $this->dt->join('ref_sekolah b', 'a.sekolah_id = b.id', 'LEFT');
        // // $this->dt->join('ref_bentuk_pendidikan d', 'a.bentuk_pendidikan_id = d.id', 'LEFT');
        // $this->dt->join('ref_kecamatan c', 'LEFT(b.kode_wilayah,6) = c.id', 'LEFT');

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
        $select = "a.*, e.nama as nama_pengguna_sekolah, b.nama as nama_sekolah, b.status_sekolah, b.kecamatan as nama_kecamatan, ((SELECT count(id) FROM _tb_pendaftar_temp WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'ZONASI') + (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'ZONASI')) as pendaftar_zonasi, ((SELECT count(id) FROM _tb_pendaftar_temp WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'AFIRMASI') + (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'AFIRMASI')) as pendaftar_afirmasi, ((SELECT count(id) FROM _tb_pendaftar_temp WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'MUTASI') + (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'MUTASI')) as pendaftar_mutasi, ((SELECT count(id) FROM _tb_pendaftar_temp WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'PRESTASI') + (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'PRESTASI')) as pendaftar_prestasi, ((SELECT count(id) FROM _tb_pendaftar_temp WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'SWASTA') + (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'SWASTA')) as pendaftar_swasta, (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'ZONASI') as terverifikasi_zonasi, (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'AFIRMASI') as terverifikasi_afirmasi, (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'MUTASI') as terverifikasi_mutasi, (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'PRESTASI') as terverifikasi_prestasi, (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'SWASTA') as terverifikasi_swasta, (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'ZONASI' AND status_pendaftaran = 2) as diterima_zonasi, (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'AFIRMASI' AND status_pendaftaran = 2) as diterima_afirmasi, (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'MUTASI' AND status_pendaftaran = 2) as diterima_mutasi, (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'PRESTASI' AND status_pendaftaran = 2) as diterima_prestasi, (SELECT count(id) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'SWASTA' AND status_pendaftaran = 2) as diterima_swasta, (SELECT count(id) FROM _tb_pendaftar_temp WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'ZONASI') as belum_verifikasi_zonasi, (SELECT count(id) FROM _tb_pendaftar_temp WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'AFIRMASI') as belum_verifikasi_afirmasi, (SELECT count(id) FROM _tb_pendaftar_temp WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'MUTASI') as belum_verifikasi_mutasi, (SELECT count(id) FROM _tb_pendaftar_temp WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'PRESTASI') as belum_verifikasi_prestasi, (SELECT count(id) FROM _tb_pendaftar_temp WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'SWASTA') as belum_verifikasi_swasta";
        $this->dt->select($select);
        $this->dt->join('_users_profil_sekolah e', 'a.sekolah_id = e.sekolah_id');
        $this->dt->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id', 'LEFT');
        // $this->dt->join('ref_bentuk_pendidikan d', 'a.bentuk_pendidikan_id = d.id', 'LEFT');

        $this->_get_datatables_query();
        $filterKecamatan = $this->request->getPost('kec');
        $filterJenajng = $this->request->getPost('jenjang');
        if ($filterJenajng != "") {
            $this->dt->where('a.bentuk_pendidikan_id', $filterJenajng);
        }

        if ($filterKecamatan != "") {
            $this->dt->where('b.kode_kecamatan', $filterKecamatan);
        }

        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered()
    {
        $select = "a.*, b.nama as nama_sekolah";
        $this->dt->select($select);
        // $this->dt->join('_users_profil_tb e', 'a.sekolah_id = e.sekolah_id');
        $this->dt->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id', 'LEFT');
        // $this->dt->join('ref_bentuk_pendidikan d', 'a.bentuk_pendidikan_id = d.id', 'LEFT');
        // $this->dt->join('ref_kecamatan c', 'LEFT(b.kode_wilayah,6) = c.id', 'LEFT');
        $this->_get_datatables_query();
        $filterKecamatan = $this->request->getPost('kec');
        $filterJenajng = $this->request->getPost('jenjang');
        if ($filterJenajng != "") {
            $this->dt->where('a.bentuk_pendidikan_id', $filterJenajng);
        }

        if ($filterKecamatan != "") {
            $this->dt->where('b.kode_kecamatan', $filterKecamatan);
        }

        return $this->dt->countAllResults();
    }
    public function count_all()
    {
        $select = "a.*, b.nama as nama_sekolah";
        $this->dt->select($select);
        // $this->dt->join('_users_profil_tb e', 'a.sekolah_id = e.sekolah_id');
        $this->dt->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id', 'LEFT');
        // $this->dt->join('ref_bentuk_pendidikan d', 'a.bentuk_pendidikan_id = d.id', 'LEFT');
        // $this->dt->join('ref_kecamatan c', 'LEFT(b.kode_wilayah,6) = c.id', 'LEFT');

        $this->_get_datatables_query();
        $filterKecamatan = $this->request->getPost('kec');
        $filterJenajng = $this->request->getPost('jenjang');

        if ($filterJenajng != "") {
            $this->dt->where('a.bentuk_pendidikan_id', $filterJenajng);
        }
        if ($filterKecamatan != "") {
            $this->dt->where('b.kode_kecamatan', $filterKecamatan);
        }

        return $this->dt->countAllResults();
    }
}
