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

    public function cekAlreadyRegisteredTidakLolosAfirmasi($peserta_didik_id)
    {
        $cekRegisterApprove = $this->_db->query("SELECT id, kode_pendaftaran, peserta_didik_id, nama_peserta, nisn_peserta, tempat_lahir_peserta, tanggal_lahir_peserta, jenis_kelamin_peserta, kab_peserta, kec_peserta, kel_peserta, dusun_peserta, lat_long_peserta, user_id, from_sekolah_id, nama_sekolah_asal, npsn_sekolah_asal, tujuan_sekolah_id_1, nama_sekolah_tujuan, npsn_sekolah_tujuan, jarak_domisili, via_jalur, keterangan, status_pendaftaran, created_at, updated_at, updated_aproval, update_reject, updated_registered, admin_approval, keterangan_penolakan, pendaftar, batal_pendaftar, rangking, ket, id_perubahan FROM _tb_pendaftar WHERE peserta_didik_id = '{$peserta_didik_id}' AND status_pendaftaran = 3 ORDER BY created_at DESC LIMIT 1")->getRow();

        if ($cekRegisterApprove) {
            switch ((int)$cekRegisterApprove->status_pendaftaran) {
                case 1:
                    return $cekRegisterApprove;
                    break;
                case 2:
                    return $cekRegisterApprove;
                    break;
                case 3:
                    return $cekRegisterApprove;
                    break;

                default:
                    return $cekRegisterApprove;
                    break;
            }
        } else {
            return false;
        }
    }

    public function cekAlreadyRegistered($peserta_didik_id)
    {
        $cekRegisterApprove = $this->_db->query("SELECT id, kode_pendaftaran, peserta_didik_id, nama_peserta, nisn_peserta, tempat_lahir_peserta, tanggal_lahir_peserta, jenis_kelamin_peserta, kab_peserta, kec_peserta, kel_peserta, dusun_peserta, lat_long_peserta, user_id, from_sekolah_id, nama_sekolah_asal, npsn_sekolah_asal, tujuan_sekolah_id_1, nama_sekolah_tujuan, npsn_sekolah_tujuan, jarak_domisili, via_jalur, keterangan, status_pendaftaran, created_at, updated_at, updated_aproval, update_reject, updated_registered, admin_approval, keterangan_penolakan, pendaftar, batal_pendaftar, rangking, ket, id_perubahan FROM (
			(SELECT id, kode_pendaftaran, peserta_didik_id, nama_peserta, nisn_peserta, tempat_lahir_peserta, tanggal_lahir_peserta, jenis_kelamin_peserta, kab_peserta, kec_peserta, kel_peserta, dusun_peserta, lat_long_peserta, user_id, from_sekolah_id, nama_sekolah_asal, npsn_sekolah_asal, tujuan_sekolah_id_1, nama_sekolah_tujuan, npsn_sekolah_tujuan, jarak_domisili, via_jalur, keterangan, status_pendaftaran, created_at, updated_at, updated_aproval, update_reject, updated_registered, admin_approval, keterangan_penolakan, pendaftar, batal_pendaftar, rangking, ket, id_perubahan FROM _tb_pendaftar_temp WHERE peserta_didik_id = '{$peserta_didik_id}') 
			UNION ALL 
			(SELECT id, kode_pendaftaran, peserta_didik_id, nama_peserta, nisn_peserta, tempat_lahir_peserta, tanggal_lahir_peserta, jenis_kelamin_peserta, kab_peserta, kec_peserta, kel_peserta, dusun_peserta, lat_long_peserta, user_id, from_sekolah_id, nama_sekolah_asal, npsn_sekolah_asal, tujuan_sekolah_id_1, nama_sekolah_tujuan, npsn_sekolah_tujuan, jarak_domisili, via_jalur, keterangan, status_pendaftaran, created_at, updated_at, updated_aproval, update_reject, updated_registered, admin_approval, keterangan_penolakan, pendaftar, batal_pendaftar, rangking, ket, id_perubahan FROM _tb_pendaftar WHERE peserta_didik_id = '{$peserta_didik_id}') 
			UNION ALL 
			(SELECT id, kode_pendaftaran, peserta_didik_id, nama_peserta, nisn_peserta, tempat_lahir_peserta, tanggal_lahir_peserta, jenis_kelamin_peserta, kab_peserta, kec_peserta, kel_peserta, dusun_peserta, lat_long_peserta, user_id, from_sekolah_id, nama_sekolah_asal, npsn_sekolah_asal, tujuan_sekolah_id_1, nama_sekolah_tujuan, npsn_sekolah_tujuan, jarak_domisili, via_jalur, keterangan, status_pendaftaran, created_at, updated_at, updated_aproval, update_reject, updated_registered, admin_approval, keterangan_penolakan, pendaftar, batal_pendaftar, rangking, ket, id_perubahan FROM _tb_pendaftar_tolak WHERE peserta_didik_id = '{$peserta_didik_id}')
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
                $response->message = "Usia peserta per-tanggal 1 Juli 2024 adalah $years tahun $months bulan. Selanjutnya dapat mengikuti PPDB TA. 2024/2025 dengan syarat memiliki Surat rekomendasi tertulis dari psikolog profesional/dewan guru Sekolah (Permendikbud No. 1 Tahun 2021 tentang PPDB).";
                return $response;
            }
        }

        $response = new \stdClass;
        $response->code = 400;
        $response->message = "Maaf, Usia peserta per-tanggal 1 Juli 2024 adalah $years tahun $months bulan, belum mencukupi untuk mendaftar ke sekolah tingkat jenjang yang dituju. (Permendikbud No. 1 Tahun 2021 Tentang PPDB). ";
        return $response;
    }

    public function customVerifi($userId)
    {
        return $this->_db->table('custom_verifi')->where('user_id', $userId)->get()->getRowObject();
    }
}
