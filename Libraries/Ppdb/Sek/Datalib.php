<?php

namespace App\Libraries\Sekolah;

class Datalib
{
    private $_db;
    private $tb;
    function __construct()
    {
        helper(['text', 'array', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    public function canRegister($jalur = "ZONASI")
    {
        $setting = $this->_db->table('_setting_jadwal_tb')->where('is_active', 1)->get()->getRowObject();
        if (!$setting) {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = "Seting jadwal tidak ditemukan.";
            return $response;
        }

        return $this->verifiCanRegister($setting, $jalur);
    }

    public function canSetting()
    {
        $setting = $this->_db->table('_setting_jadwal_tb')->where('is_active', 1)->get()->getRowObject();
        if (!$setting) {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = "Seting jadwal tidak ditemukan.";
            return $response;
        }

        return $this->settingKuotaDanZonasi($setting);
    }

    private function settingKuotaDanZonasi($setting)
    {
        $today = date("Y-m-d H:i:s");

        $startdate = strtotime($today);

        $enddateAkhir = strtotime($setting->tgl_awal_pendaftaran_zonasi);
        if ($startdate > $enddateAkhir) {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = "Mohon maaf, saat ini proses pengajuan untuk pemetaan Kuota dan Zonasi PPDB telah ditutup.";
            return $response;
        }

        $response = new \stdClass;
        $response->code = 200;
        $response->message = "Setting Kuota dan Zonasi PPDB telah dibuka.";
        return $response;
    }

    private function verifiCanRegister($setting, $jalur)
    {
        if ($jalur == "ZONASI") {
            $today = date("Y-m-d H:i:s");

            $startdate = strtotime($today);
            $enddateAwal = strtotime($setting->tgl_awal_verifikasi_zonasi);

            if ($startdate < $enddateAwal) {
                $response = new \stdClass;
                $response->code = 400;
                $response->message = "Mohon maaf, saat ini proses verifikasi PPDB belum dibuka.";
                return $response;
            }

            $enddateAkhir = strtotime($setting->tgl_akhir_verifikasi_zonasi);
            if ($startdate > $enddateAkhir) {
                $response = new \stdClass;
                $response->code = 400;
                $response->message = "Mohon maaf, saat ini proses verifikasi PPDB telah ditutup.";
                return $response;
            }
            $response = new \stdClass;
            $response->code = 200;
            $response->message = "verifikasi PPDB telah dibuka.";
            return $response;
        } else if ($jalur == "AFIRMASI") {
            $today = date("Y-m-d H:i:s");

            $startdate = strtotime($today);
            $enddateAwal = strtotime($setting->tgl_awal_verifikasi_afirmasi);

            if ($startdate < $enddateAwal) {
                $response = new \stdClass;
                $response->code = 400;
                $response->message = "Mohon maaf, saat ini proses verifikasi PPDB belum dibuka.";
                return $response;
            }

            $enddateAkhir = strtotime($setting->tgl_akhir_verifikasi_afirmasi);
            if ($startdate > $enddateAkhir) {
                $response = new \stdClass;
                $response->code = 400;
                $response->message = "Mohon maaf, saat ini proses verifikasi PPDB telah ditutup.";
                return $response;
            }
            $response = new \stdClass;
            $response->code = 200;
            $response->message = "verifikasi PPDB telah dibuka.";
            return $response;
        } else if ($jalur == "PRESTASI") {
            $today = date("Y-m-d H:i:s");

            $startdate = strtotime($today);
            $enddateAwal = strtotime($setting->tgl_awal_verifikasi_prestasi);

            if ($startdate < $enddateAwal) {
                $response = new \stdClass;
                $response->code = 400;
                $response->message = "Mohon maaf, saat ini proses verifikasi PPDB belum dibuka.";
                return $response;
            }

            $enddateAkhir = strtotime($setting->tgl_akhir_verifikasi_prestasi);
            if ($startdate > $enddateAkhir) {
                $response = new \stdClass;
                $response->code = 400;
                $response->message = "Mohon maaf, saat ini proses verifikasi PPDB telah ditutup.";
                return $response;
            }
            $response = new \stdClass;
            $response->code = 200;
            $response->message = "verifikasi PPDB telah dibuka.";
            return $response;
        } else if ($jalur == "MUTASI") {
            $today = date("Y-m-d H:i:s");

            $startdate = strtotime($today);
            $enddateAwal = strtotime($setting->tgl_awal_verifikasi_mutasi);

            if ($startdate < $enddateAwal) {
                $response = new \stdClass;
                $response->code = 400;
                $response->message = "Mohon maaf, saat ini proses verifikasi PPDB belum dibuka.";
                return $response;
            }

            $enddateAkhir = strtotime($setting->tgl_akhir_verifikasi_mutasi);
            if ($startdate > $enddateAkhir) {
                $response = new \stdClass;
                $response->code = 400;
                $response->message = "Mohon maaf, saat ini proses verifikasi PPDB telah ditutup.";
                return $response;
            }
            $response = new \stdClass;
            $response->code = 200;
            $response->message = "verifikasi PPDB telah dibuka.";
            return $response;
        } else if ($jalur == "SWASTA") {
            $today = date("Y-m-d H:i:s");

            $startdate = strtotime($today);
            $enddateAwal = strtotime($setting->tgl_awal_verifikasi_afirmasi);

            if ($startdate < $enddateAwal) {
                $response = new \stdClass;
                $response->code = 400;
                $response->message = "Mohon maaf, saat ini proses verifikasi PPDB belum dibuka.";
                return $response;
            }

            $enddateAkhir = strtotime($setting->tgl_akhir_verifikasi_mutasi);
            if ($startdate > $enddateAkhir) {
                $response = new \stdClass;
                $response->code = 400;
                $response->message = "Mohon maaf, saat ini proses verifikasi PPDB telah ditutup.";
                return $response;
            }
            $response = new \stdClass;
            $response->code = 200;
            $response->message = "verifikasi PPDB telah dibuka.";
            return $response;
        } else {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = "Mohon maaf, saat ini proses verifikasi PPDB belum dimulai.";
            return $response;
        }
    }
}
