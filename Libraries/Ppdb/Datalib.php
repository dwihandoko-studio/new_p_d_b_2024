<?php

namespace App\Libraries\Ppdb;

class Datalib
{
    private $_db;
    private $tb;
    function __construct()
    {
        helper(['text', 'array', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    public function cekAlreadyRegistered($peserta_didik_id)
    {
        $cekRegisterApprove = $this->_db->query("SELECT * FROM (
			(SELECT * FROM _tb_pendaftar_temp WHERE peserta_didik_id = '{$peserta_didik_id}') 
			UNION ALL 
			(SELECT * FROM _tb_pendaftar WHERE peserta_didik_id = '{$peserta_didik_id}') 
			UNION ALL 
			(SELECT * FROM _tb_pendaftar_tolak WHERE peserta_didik_id = '{$peserta_didik_id}')
		) AS a ORDER BY a.created_at DESC LIMIT 1")->getRow();

        if ($cekRegisterApprove) {
            switch ((int)$cekRegisterApprove->status_pendaftaran) {
                case 1:
                    return $cekRegisterApprove;
                    break;
                case 2:
                    return $cekRegisterApprove;
                    break;
                case 3:
                    return false;
                    break;

                default:
                    return $cekRegisterApprove;
                    break;
            }
        } else {
            return false;
        }
    }

    public function canRegister($jalur = "afirmasi")
    {
        $setting = $this->_db->table('_setting_jadwal_tb')->where('id', $jalur)->get()->getRowObject();
        if (!$setting) {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = "Seting jadwal tidak ditemukan.";
            return $response;
        }

        return $this->verifiCanRegister($setting, $jalur);
    }

    private function verifiCanRegister($setting, $jalur)
    {
        $today = date("Y-m-d H:i:s");

        $startdate = strtotime($today);
        $enddateAwal = strtotime($setting->tgl_awal_pendaftaran);

        if ($startdate < $enddateAwal) {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = "Mohon maaf, saat ini proses pendaftaran PPDB belum dibuka";
            return $response;
        }

        $enddateAkhir = strtotime($setting->tgl_akhir_pendaftaran);
        if ($startdate > $enddateAkhir) {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = "Mohon maaf, saat ini proses pendaftaran PPDB telah ditutup";
            return $response;
        }
        $response = new \stdClass;
        $response->code = 200;
        $response->message = "Pendaftaran PPDB telah dibuka";
        return $response;
        // } else if ($jalur == "AFIRMASI") {
        //     $today = date("Y-m-d H:i:s");

        //     $startdate = strtotime($today);
        //     $enddateAwal = strtotime($setting->tgl_awal_pendaftaran_afirmasi);

        //     if ($startdate < $enddateAwal) {
        //         $response = new \stdClass;
        //         $response->code = 400;
        //         $response->message = "Mohon maaf, saat ini proses pendaftaran PPDB belum dibuka";
        //         return $response;
        //     }

        //     $enddateAkhir = strtotime($setting->tgl_akhir_pendaftaran_afirmasi);
        //     if ($startdate > $enddateAkhir) {
        //         $response = new \stdClass;
        //         $response->code = 400;
        //         $response->message = "Mohon maaf, saat ini proses pendaftaran PPDB telah ditutup";
        //         return $response;
        //     }
        //     $response = new \stdClass;
        //     $response->code = 200;
        //     $response->message = "Pendaftaran PPDB telah dibuka";
        //     return $response;
        // } else if ($jalur == "PRESTASI") {
        //     $today = date("Y-m-d H:i:s");

        //     $startdate = strtotime($today);
        //     $enddateAwal = strtotime($setting->tgl_awal_pendaftaran_prestasi);

        //     if ($startdate < $enddateAwal) {
        //         $response = new \stdClass;
        //         $response->code = 400;
        //         $response->message = "Mohon maaf, saat ini proses pendaftaran PPDB belum dibuka";
        //         return $response;
        //     }

        //     $enddateAkhir = strtotime($setting->tgl_akhir_pendaftaran_prestasi);
        //     if ($startdate > $enddateAkhir) {
        //         $response = new \stdClass;
        //         $response->code = 400;
        //         $response->message = "Mohon maaf, saat ini proses pendaftaran PPDB telah ditutup";
        //         return $response;
        //     }
        //     $response = new \stdClass;
        //     $response->code = 200;
        //     $response->message = "Pendaftaran PPDB telah dibuka";
        //     return $response;
        // } else if ($jalur == "MUTASI") {
        //     $today = date("Y-m-d H:i:s");

        //     $startdate = strtotime($today);
        //     $enddateAwal = strtotime($setting->tgl_awal_pendaftaran_mutasi);

        //     if ($startdate < $enddateAwal) {
        //         $response = new \stdClass;
        //         $response->code = 400;
        //         $response->message = "Mohon maaf, saat ini proses pendaftaran PPDB belum dibuka";
        //         return $response;
        //     }

        //     $enddateAkhir = strtotime($setting->tgl_akhir_pendaftaran_mutasi);
        //     if ($startdate > $enddateAkhir) {
        //         $response = new \stdClass;
        //         $response->code = 400;
        //         $response->message = "Mohon maaf, saat ini proses pendaftaran PPDB telah ditutup";
        //         return $response;
        //     }
        //     $response = new \stdClass;
        //     $response->code = 200;
        //     $response->message = "Pendaftaran PPDB telah dibuka";
        //     return $response;
        // } else if ($jalur == "SWASTA") {
        //     $today = date("Y-m-d H:i:s");

        //     $startdate = strtotime($today);
        //     $enddateAwal = strtotime($setting->tgl_awal_pendaftaran_afirmasi);

        //     if ($startdate < $enddateAwal) {
        //         $response = new \stdClass;
        //         $response->code = 400;
        //         $response->message = "Mohon maaf, saat ini proses pendaftaran PPDB belum dibuka";
        //         return $response;
        //     }

        //     $enddateAkhir = strtotime($setting->tgl_akhir_pendaftaran_mutasi);
        //     if ($startdate > $enddateAkhir) {
        //         $response = new \stdClass;
        //         $response->code = 400;
        //         $response->message = "Mohon maaf, saat ini proses pendaftaran PPDB telah ditutup";
        //         return $response;
        //     }
        //     $response = new \stdClass;
        //     $response->code = 200;
        //     $response->message = "Pendaftaran PPDB telah dibuka";
        //     return $response;
        // } else if ($jalur == "AKUN") {
        //     $today = date("Y-m-d H:i:s");

        //     $startdate = strtotime($today);
        //     $enddateAwal = strtotime($setting->tgl_awal_pendaftaran_afirmasi);

        //     if ($startdate < $enddateAwal) {
        //         $response = new \stdClass;
        //         $response->code = 400;
        //         $response->message = "Mohon maaf, saat ini proses pendaftaran Akun PPDB belum dibuka";
        //         return $response;
        //     }

        //     $enddateAkhir = strtotime($setting->tgl_akhir_pendaftaran_mutasi);
        //     if ($startdate > $enddateAkhir) {
        //         $response = new \stdClass;
        //         $response->code = 400;
        //         $response->message = "Mohon maaf, saat ini proses pendaftaran Akun PPDB telah ditutup";
        //         return $response;
        //     }
        //     $response = new \stdClass;
        //     $response->code = 200;
        //     $response->message = "Pendaftaran PPDB telah dibuka";
        //     return $response;
        // } else if ($jalur == "PENGUMUMAN_AFIRMASI") {
        //     $today = date("Y-m-d H:i:s");

        //     $startdate = strtotime($today);
        //     $enddateAwal = strtotime($setting->tgl_pengumuman_afirmasi);

        //     if ($startdate < $enddateAwal) {
        //         $response = new \stdClass;
        //         $response->code = 400;
        //         $response->message = "Mohon maaf, saat ini proses pengumuman PPDB Jalur Afirmasi belum dibuka";
        //         return $response;
        //     }

        //     $response = new \stdClass;
        //     $response->code = 200;
        //     $response->message = "Pengumuman PPDB Jalur Afirmasi telah dibuka";
        //     return $response;
        // } else if ($jalur == "PENGUMUMAN_ZONASI") {
        //     $today = date("Y-m-d H:i:s");

        //     $startdate = strtotime($today);
        //     $enddateAwal = strtotime($setting->tgl_pengumuman_zonasi);

        //     if ($startdate < $enddateAwal) {
        //         $response = new \stdClass;
        //         $response->code = 400;
        //         $response->message = "Mohon maaf, saat ini proses pengumuman PPDB Jalur Zonasi/Prestasi/Mutasi belum dibuka";
        //         return $response;
        //     }

        //     $response = new \stdClass;
        //     $response->code = 200;
        //     $response->message = "Pengumuman PPDB Jalur Zonasi/Prestasi/Mutasi telah dibuka";
        //     return $response;
        // } else {
        //     $response = new \stdClass;
        //     $response->code = 400;
        //     $response->message = "Mohon maaf, saat ini proses pendaftaran PPDB belum dimulai";
        //     return $response;
        // }
    }
}
