<?php

namespace App\Libraries\Ppdb;

use DateTime;

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

    public function canVerifikasi($jalur = "afirmasi")
    {
        $setting = $this->_db->table('_setting_jadwal_tb')->where('id', $jalur)->get()->getRowObject();
        if (!$setting) {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = "Seting jadwal tidak ditemukan.";
            return $response;
        }

        return $this->verifiCanVerifikasi($setting, $jalur);
    }

    private function verifiCanVerifikasi($setting, $jalur)
    {
        $today = date("Y-m-d H:i:s");

        $startdate = strtotime($today);
        $enddateAwal = strtotime($setting->tgl_awal_verifikasi);

        if ($startdate < $enddateAwal) {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = "Mohon maaf, saat ini proses verfikasi pendaftaran PPDB belum dibuka";
            return $response;
        }

        $enddateAkhir = strtotime($setting->tgl_akhir_verifikasi);
        if ($startdate > $enddateAkhir) {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = "Mohon maaf, saat ini proses verifikasi pendaftaran PPDB telah ditutup";
            return $response;
        }
        $response = new \stdClass;
        $response->code = 200;
        $response->message = "Verifikasi Pendaftaran PPDB telah dibuka";
        return $response;
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

    public function verifiUmur($peserta_didik_id)
    {
        $pd = $this->_db->table('dapo_peserta')->select("tanggal_lahir")->where('peserta_didik_id', $peserta_didik_id)->get()->getRowObject();

        if (!$pd) {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = "Referensi Peserta Didik Tidak Ditemukan.";
            return $response;
        }

        $currentDate = new DateTime("2024-07-01");
        $ttl = new DateTime($pd->tanggal_lahir);

        $ageDifference = $currentDate->diff($ttl);

        $years = $ageDifference->y;
        $months = $ageDifference->m;
        $days = $ageDifference->d;

        if ($years >= 6) {
            $response = new \stdClass;
            $response->code = 200;
            $response->message = "Umur valid";
            return $response;
        }

        if ($years < 6) {
            if ($months >= 6) {
                $response = new \stdClass;
                $response->code = 201;
                $response->message = "Umur valid, dengan syarat.";
                return $response;
            }
        }

        $response = new \stdClass;
        $response->code = 400;
        $response->message = "Maaf, Saat ini Usia anda $years tahun $months bulan, belum mencukupi untuk mendaftar ke sekolah tingkat jenjang yang dituju. (Permendikbud No. 1 Tahun 2021 Tentang PPDB). ";
        return $response;
    }
}
