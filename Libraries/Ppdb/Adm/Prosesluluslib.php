<?php

namespace App\Libraries\Adm;

use App\Libraries\Uuid;
use Firebase\JWT\JWT;
use App\Libraries\Ppdb\Notificationlib;
use App\Libraries\Fcmlib;

class Prosesluluslib
{
    private $_db;
    private $tb;
    function __construct()
    {
        helper(['text', 'array', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    public function prosesLulusPrestasiSisa($data, $userId)
    {
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $number = $value->jumlah_lolos_prestasi;
                $this->luluskanPSisa($value, $number + ($key + 1), $userId);
            }

            return true;
        }

        return true;
    }

    public function prosesLulusAfirmasiSisa($data, $userId)
    {
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $number = $value->jumlah_lolo_afirmasi;
                $this->luluskanASisa($value, $number + ($key + 1), $userId);
            }

            return true;
        }

        return true;
    }

    public function prosesTidakLulusAfirmasiSisa($data, $userId)
    {
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $number = $value->jumlah_lolo_afirmasi;
                $this->tidakluluskanASisa($value, $number + ($key + 1), $userId);
            }

            return true;
        }

        return true;
    }

    public function prosesTidakLulusAfirmasiAntrian($data, $userId)
    {
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $this->tidakluluskanAAntrian($value, $key + 1, $userId);
            }

            return true;
        }

        return true;
    }

    public function prosesTidakLulusAfirmasiAntrianZMP($data, $userId)
    {
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $this->tidakluluskanAntrianZMP($value, $key + 1, $userId);
            }

            return true;
        }

        return true;
    }

    public function prosesTidakLulusAfirmasi($data, $userId)
    {
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $this->tidakluluskanA($value, $key + 1, $userId);
            }

            return true;
        }

        return true;
    }

    public function prosesTidakLulusSisa($data, $userId)
    {
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $this->tidakluluskanSisa($value, $key + 1, $userId);
            }

            return true;
        }

        return true;
    }

    public function prosesTidakLulusMutasi($data, $userId)
    {
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $this->tidakluluskanM($value, $key + 1, $userId);
            }

            return true;
        }

        return true;
    }

    public function prosesTidakLulusPrestasi($data, $userId)
    {
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $this->tidakluluskanP($value, $key + 1, $userId);
            }

            return true;
        }

        return true;
    }

    public function prosesTidakLulusZonasi($data, $userId)
    {
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $this->tidakluluskanZ($value, $key + 1, $userId);
            }

            return true;
        }

        return true;
    }

    public function prosesTidakLulusSwasta($data, $userId)
    {
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $this->tidakluluskanS($value, $key + 1, $userId);
            }

            return true;
        }

        return true;
    }

    public function prosesLulusAfirmasi($data, $userId)
    {
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $this->luluskanA($value, $key + 1, $userId);
            }

            return true;
        }

        return true;
    }

    public function prosesLulusMutasi($data, $userId)
    {
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $this->luluskanM($value, $key + 1, $userId);
            }

            return true;
        }

        return true;
    }

    public function prosesLulusPrestasi($data, $userId)
    {
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $this->luluskanP($value, $key + 1, $userId);
            }

            return true;
        }

        return true;
    }

    public function prosesLulusZonasi($data, $userId)
    {
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $this->luluskanZ($value, $key + 1, $userId);
            }

            return true;
        }

        return true;
    }

    public function prosesLulusSwasta($data, $userId)
    {
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $this->luluskanS($value, $key + 1, $userId);
            }

            return true;
        }

        return true;
    }

    private function tidakluluskanASisa($pen, $urut, $userId)
    {
        $data = $this->_db->table('_tb_pendaftar')->where('id', $pen->id_pendaftaran)->update([
            'status_pendaftaran' => 3,
            'rangking' => $urut,
            'ket' => "Kuota Sudah Terpenuhi.",
        ]);

        try {

            // $riwayatLib = new Riwayatlib();
            // $riwayatLib->insert("Memverifikasi Pendaftaran {$pen->fullname} via Jalur Afirmasi dengan No Pendaftaran : {$pen->kode_pendaftaran}", "Memverifikasi Pendaftaran Jalur Afirmasi", "submit");

            $saveNotifSystem = new Notificationlib();
            $saveNotifSystem->send([
                'judul' => "Pendaftaran Jalur " . $pen->via_jalur . " Tidak Lolos.",
                'isi' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>.",
                // 'isi' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>.",
                'action_web' => 'peserta/riwayat/pendaftaran',
                'action_app' => 'riwayat_pendaftaran_page',
                'token' => $pen->id_pendaftaran,
                'send_from' => $userId,
                'send_to' => $pen->id,
            ]);

            // $onesignal = new Fcmlib();
            // $send = $onesignal->pushNotifToUser([
            //     'title' => "Pendaftaran Jalur Afirmasi Tidak Lolos.",
            //     'content' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya anda dapat mendaftar kembali menggunakan jalur yang lain (ZONASI, PRESTASI, MUTASI).",
            //     'send_to' => $pen->id,
            //     'app_url' => 'riwayat_pendaftaran_page',
            // ]);
        } catch (\Throwable $th) {
        }

        return true;
    }

    private function tidakluluskanAAntrian($pen, $urut, $userId)
    {
        // $data = $this->_db->table('_tb_pendaftar')->where('id', $pen->id_pendaftaran)->update([
        //     'status_pendaftaran' => 3,
        //     'keterangan_penolakan' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/> dikarenakan belum terverifikasi oleh Sekolah Tujuan.<br/>Selanjutnya anda dapat mendaftar kembali menggunakan jalur yang lain (ZONASI, PRESTASI, MUTASI).",
        // ]);
        $cekRegisterTemp = $this->_db->table('_tb_pendaftar_temp a')
            ->select('a.*, b.nisn')
            ->join('_users_profil_tb b', 'a.peserta_didik_id = b.peserta_didik_id')
            ->where('a.id', $pen->id_pendaftaran)->get()->getRowArray();

        if (!$cekRegisterTemp) {
            return true;
        }

        $cekRegisterTemp['updated_at'] = date('Y-m-d H:i:s');
        $cekRegisterTemp['update_reject'] = date('Y-m-d H:i:s');
        $cekRegisterTemp['admin_approval'] = $userId;
        $cekRegisterTemp['keterangan_penolakan'] = "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/> dikarenakan belum terverifikasi oleh Sekolah Tujuan.<br/>Selanjutnya anda dapat mendaftar kembali menggunakan jalur yang lain (ZONASI, PRESTASI, MUTASI).";
        $cekRegisterTemp['status_pendaftaran'] = 3;

        $nisn = $cekRegisterTemp['nisn'];

        $this->_db->transBegin();
        unset($cekRegisterTemp['nisn']);
        $this->_db->table('_tb_pendaftar_tolak')->insert($cekRegisterTemp);
        if ($this->_db->affectedRows() > 0) {
            $this->_db->table('_tb_pendaftar_temp')->where('id', $cekRegisterTemp['id'])->delete();
            if ($this->_db->affectedRows() > 0) {
                $updatelockLib = new Updatedatalib();
                $berhasil = $updatelockLib->unlockUpdate($cekRegisterTemp['user_id']);

                try {
                    $riwayatLib = new Riwayatlib();
                    $riwayatLib->insert("Auto Proses Non Verifikasi Pendaftar ", "Unconfirm Pendaftaran Jalur Afirmasi", "tolak");

                    $saveNotifSystem = new Notificationlib();
                    $saveNotifSystem->send([
                        'judul' => "Pendaftaran Jalur Afirmasi Tidak Lolos.",
                        'isi' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/> dikarenakan belum terverifikasi oleh Sekolah Tujuan.<br/>Selanjutnya anda dapat mendaftar kembali menggunakan jalur yang lain (ZONASI, PRESTASI, MUTASI).",
                        'action_web' => 'peserta/riwayat/pendaftaran',
                        'action_app' => 'riwayat_pendaftaran_page',
                        'token' => $cekRegisterTemp['id'],
                        'send_from' => $userId,
                        'send_to' => $cekRegisterTemp['user_id'],
                    ]);

                    $onesignal = new Fcmlib();
                    $send = $onesignal->pushNotifToUser([
                        'title' => "Pendaftaran Jalur Afirmasi Tidak Lolos.",
                        'content' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/> dikarenakan belum terverifikasi oleh Sekolah Tujuan.<br/>Selanjutnya anda dapat mendaftar kembali menggunakan jalur yang lain (ZONASI, PRESTASI, MUTASI).",
                        'send_to' => $cekRegisterTemp['user_id'],
                        'app_url' => 'riwayat_pendaftaran_page',
                    ]);
                } catch (\Throwable $th) {
                }
                $this->_db->transCommit();
                return true;
            } else {
                $this->_db->transRollback();
                return true;
            }
        } else {
            $this->_db->transRollback();
            return true;
        }

        // try {

        //     // $riwayatLib = new Riwayatlib();
        //     // $riwayatLib->insert("Memverifikasi Pendaftaran {$pen->fullname} via Jalur Afirmasi dengan No Pendaftaran : {$pen->kode_pendaftaran}", "Memverifikasi Pendaftaran Jalur Afirmasi", "submit");

        //     $saveNotifSystem = new Notificationlib();
        //     $saveNotifSystem->send([
        //         'judul' => "Pendaftaran Jalur Afirmasi Tidak Lolos.",
        //         'isi' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/> dikarenakan belum terverifikasi oleh Sekolah Tujuan.<br/>Selanjutnya anda dapat mendaftar kembali menggunakan jalur yang lain (ZONASI, PRESTASI, MUTASI).",
        //         // 'isi' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>.",
        //         'action_web' => 'peserta/riwayat/pendaftaran',
        //         'action_app' => 'riwayat_pendaftaran_page',
        //         'token' => $pen->id_pendaftaran,
        //         'send_from' => $userId,
        //         'send_to' => $pen->id,
        //     ]);

        //     // $onesignal = new Fcmlib();
        //     // $send = $onesignal->pushNotifToUser([
        //     //     'title' => "Pendaftaran Jalur Afirmasi Tidak Lolos.",
        //     //     'content' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya anda dapat mendaftar kembali menggunakan jalur yang lain (ZONASI, PRESTASI, MUTASI).",
        //     //     'send_to' => $pen->id,
        //     //     'app_url' => 'riwayat_pendaftaran_page',
        //     // ]);
        // } catch (\Throwable $th) {
        // }

        return true;
    }

    private function tidakluluskanAntrianZMP($pen, $urut, $userId)
    {
        // $data = $this->_db->table('_tb_pendaftar')->where('id', $pen->id_pendaftaran)->update([
        //     'status_pendaftaran' => 3,
        //     'keterangan_penolakan' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/> dikarenakan belum terverifikasi oleh Sekolah Tujuan.<br/>Selanjutnya anda dapat mendaftar kembali menggunakan jalur yang lain (ZONASI, PRESTASI, MUTASI).",
        // ]);
        $cekRegisterTemp = $this->_db->table('_tb_pendaftar_temp a')
            ->select('a.*, b.nisn')
            ->join('_users_profil_tb b', 'a.peserta_didik_id = b.peserta_didik_id')
            ->where('a.id', $pen->id_pendaftaran)->get()->getRowArray();

        if (!$cekRegisterTemp) {
            return true;
        }

        $cekRegisterTemp['updated_at'] = date('Y-m-d H:i:s');
        $cekRegisterTemp['update_reject'] = date('Y-m-d H:i:s');
        $cekRegisterTemp['admin_approval'] = $userId;
        $cekRegisterTemp['keterangan_penolakan'] = "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/> dikarenakan belum terverifikasi oleh Sekolah Tujuan.";
        $cekRegisterTemp['status_pendaftaran'] = 3;

        $nisn = $cekRegisterTemp['nisn'];

        $this->_db->transBegin();
        unset($cekRegisterTemp['nisn']);
        try {
            //code...
            $this->_db->table('_tb_pendaftar_tolak')->insert($cekRegisterTemp);
        } catch (\Throwable $th) {
            // $this->_db->transRollback();
            $error = $th->errorInfo;
            if ($error[1] == 1062) {
                // echo "Duplicate entry, ignoring...";
            } else {
                $this->_db->transRollback();
                return true;
            }
        }
        if ($this->_db->affectedRows() > 0) {
            $this->_db->table('_tb_pendaftar_temp')->where('id', $cekRegisterTemp['id'])->delete();
            if ($this->_db->affectedRows() > 0) {
                $updatelockLib = new Updatedatalib();
                $berhasil = $updatelockLib->unlockUpdate($cekRegisterTemp['user_id']);

                try {
                    $riwayatLib = new Riwayatlib();
                    $riwayatLib->insert("Auto Proses Non Verifikasi Pendaftar ", "Unconfirm Pendaftaran Jalur " . $pen->via_jalur . "", "tolak");

                    $saveNotifSystem = new Notificationlib();
                    $saveNotifSystem->send([
                        'judul' => "Pendaftaran Jalur " . $pen->via_jalur . " Tidak Lolos.",
                        'isi' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/> dikarenakan belum diverifikasi oleh Sekolah Tujuan.",
                        'action_web' => 'peserta/riwayat/pendaftaran',
                        'action_app' => 'riwayat_pendaftaran_page',
                        'token' => $cekRegisterTemp['id'],
                        'send_from' => $userId,
                        'send_to' => $cekRegisterTemp['user_id'],
                    ]);

                    // $onesignal = new Fcmlib();
                    // $send = $onesignal->pushNotifToUser([
                    //     'title' => "Pendaftaran Jalur " . $pen->via_jalur . " Tidak Lolos.",
                    //     'content' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/> dikarenakan belum terverifikasi oleh Sekolah Tujuan.",
                    //     'send_to' => $cekRegisterTemp['user_id'],
                    //     'app_url' => 'riwayat_pendaftaran_page',
                    // ]);
                } catch (\Throwable $th) {
                }
                $this->_db->transCommit();
                return true;
            } else {
                $this->_db->transRollback();
                return true;
            }
        } else {
            $this->_db->transRollback();
            return true;
        }

        // try {

        //     // $riwayatLib = new Riwayatlib();
        //     // $riwayatLib->insert("Memverifikasi Pendaftaran {$pen->fullname} via Jalur Afirmasi dengan No Pendaftaran : {$pen->kode_pendaftaran}", "Memverifikasi Pendaftaran Jalur Afirmasi", "submit");

        //     $saveNotifSystem = new Notificationlib();
        //     $saveNotifSystem->send([
        //         'judul' => "Pendaftaran Jalur Afirmasi Tidak Lolos.",
        //         'isi' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/> dikarenakan belum terverifikasi oleh Sekolah Tujuan.<br/>Selanjutnya anda dapat mendaftar kembali menggunakan jalur yang lain (ZONASI, PRESTASI, MUTASI).",
        //         // 'isi' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>.",
        //         'action_web' => 'peserta/riwayat/pendaftaran',
        //         'action_app' => 'riwayat_pendaftaran_page',
        //         'token' => $pen->id_pendaftaran,
        //         'send_from' => $userId,
        //         'send_to' => $pen->id,
        //     ]);

        //     // $onesignal = new Fcmlib();
        //     // $send = $onesignal->pushNotifToUser([
        //     //     'title' => "Pendaftaran Jalur Afirmasi Tidak Lolos.",
        //     //     'content' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya anda dapat mendaftar kembali menggunakan jalur yang lain (ZONASI, PRESTASI, MUTASI).",
        //     //     'send_to' => $pen->id,
        //     //     'app_url' => 'riwayat_pendaftaran_page',
        //     // ]);
        // } catch (\Throwable $th) {
        // }

        return true;
    }

    private function tidakluluskanA($pen, $urut, $userId)
    {
        $data = $this->_db->table('_tb_pendaftar')->where('id', $pen->id_pendaftaran)->update([
            'status_pendaftaran' => 3,
            'rangking' => $urut,
        ]);

        try {

            // $riwayatLib = new Riwayatlib();
            // $riwayatLib->insert("Memverifikasi Pendaftaran {$pen->fullname} via Jalur Afirmasi dengan No Pendaftaran : {$pen->kode_pendaftaran}", "Memverifikasi Pendaftaran Jalur Afirmasi", "submit");

            $saveNotifSystem = new Notificationlib();
            $saveNotifSystem->send([
                'judul' => "Pendaftaran Jalur Afirmasi Tidak Lolos.",
                'isi' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya anda dapat mendaftar kembali menggunakan jalur yang lain (ZONASI, PRESTASI, MUTASI).",
                // 'isi' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>.",
                'action_web' => 'peserta/riwayat/pendaftaran',
                'action_app' => 'riwayat_pendaftaran_page',
                'token' => $pen->id_pendaftaran,
                'send_from' => $userId,
                'send_to' => $pen->id,
            ]);

            // $onesignal = new Fcmlib();
            // $send = $onesignal->pushNotifToUser([
            //     'title' => "Pendaftaran Jalur Afirmasi Tidak Lolos.",
            //     'content' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya anda dapat mendaftar kembali menggunakan jalur yang lain (ZONASI, PRESTASI, MUTASI).",
            //     'send_to' => $pen->id,
            //     'app_url' => 'riwayat_pendaftaran_page',
            // ]);
        } catch (\Throwable $th) {
        }

        return true;
    }

    private function tidakluluskanSisa($pen, $urut, $userId)
    {
        $data = $this->_db->table('_tb_pendaftar')->where('id', $pen->id_pendaftaran)->update([
            'status_pendaftaran' => 3,
            'rangking' => $urut,
        ]);

        try {

            // $riwayatLib = new Riwayatlib();
            // $riwayatLib->insert("Memverifikasi Pendaftaran {$pen->fullname} via Jalur Afirmasi dengan No Pendaftaran : {$pen->kode_pendaftaran}", "Memverifikasi Pendaftaran Jalur Afirmasi", "submit");

            $saveNotifSystem = new Notificationlib();
            $saveNotifSystem->send([
                'judul' => "Pendaftaran Jalur " . $pen->via_jalur . " Tidak Lolos.",
                'isi' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>.",
                // 'isi' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>.",
                'action_web' => 'peserta/riwayat/pendaftaran',
                'action_app' => 'riwayat_pendaftaran_page',
                'token' => $pen->id_pendaftaran,
                'send_from' => $userId,
                'send_to' => $pen->id,
            ]);

            // $onesignal = new Fcmlib();
            // $send = $onesignal->pushNotifToUser([
            //     'title' => "Pendaftaran Jalur Afirmasi Tidak Lolos.",
            //     'content' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya anda dapat mendaftar kembali menggunakan jalur yang lain (ZONASI, PRESTASI, MUTASI).",
            //     'send_to' => $pen->id,
            //     'app_url' => 'riwayat_pendaftaran_page',
            // ]);
        } catch (\Throwable $th) {
        }

        return true;
    }

    private function tidakluluskanM($pen, $urut, $userId)
    {
        $data = $this->_db->table('_tb_pendaftar')->where('id', $pen->id_pendaftaran)->update([
            'status_pendaftaran' => 3,
            'rangking' => $urut,
        ]);

        try {

            // $riwayatLib = new Riwayatlib();
            // $riwayatLib->insert("Memverifikasi Pendaftaran {$pen->fullname} via Jalur Afirmasi dengan No Pendaftaran : {$pen->kode_pendaftaran}", "Memverifikasi Pendaftaran Jalur Afirmasi", "submit");

            $saveNotifSystem = new Notificationlib();
            $saveNotifSystem->send([
                'judul' => "Pendaftaran Jalur " . $pen->via_jalur . " Tidak Lolos.",
                'isi' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>.",
                // 'isi' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>.",
                'action_web' => 'peserta/riwayat/pendaftaran',
                'action_app' => 'riwayat_pendaftaran_page',
                'token' => $pen->id_pendaftaran,
                'send_from' => $userId,
                'send_to' => $pen->id,
            ]);

            // $onesignal = new Fcmlib();
            // $send = $onesignal->pushNotifToUser([
            //     'title' => "Pendaftaran Jalur Afirmasi Tidak Lolos.",
            //     'content' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya anda dapat mendaftar kembali menggunakan jalur yang lain (ZONASI, PRESTASI, MUTASI).",
            //     'send_to' => $pen->id,
            //     'app_url' => 'riwayat_pendaftaran_page',
            // ]);
        } catch (\Throwable $th) {
        }

        return true;
    }

    private function tidakluluskanP($pen, $urut, $userId)
    {
        $data = $this->_db->table('_tb_pendaftar')->where('id', $pen->id_pendaftaran)->update([
            'status_pendaftaran' => 3,
            'rangking' => $urut,
        ]);

        try {

            // $riwayatLib = new Riwayatlib();
            // $riwayatLib->insert("Memverifikasi Pendaftaran {$pen->fullname} via Jalur Afirmasi dengan No Pendaftaran : {$pen->kode_pendaftaran}", "Memverifikasi Pendaftaran Jalur Afirmasi", "submit");

            $saveNotifSystem = new Notificationlib();
            $saveNotifSystem->send([
                'judul' => "Pendaftaran Jalur " . $pen->via_jalur . " Tidak Lolos.",
                'isi' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>.",
                // 'isi' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>.",
                'action_web' => 'peserta/riwayat/pendaftaran',
                'action_app' => 'riwayat_pendaftaran_page',
                'token' => $pen->id_pendaftaran,
                'send_from' => $userId,
                'send_to' => $pen->id,
            ]);

            // $onesignal = new Fcmlib();
            // $send = $onesignal->pushNotifToUser([
            //     'title' => "Pendaftaran Jalur Afirmasi Tidak Lolos.",
            //     'content' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya anda dapat mendaftar kembali menggunakan jalur yang lain (ZONASI, PRESTASI, MUTASI).",
            //     'send_to' => $pen->id,
            //     'app_url' => 'riwayat_pendaftaran_page',
            // ]);
        } catch (\Throwable $th) {
        }

        return true;
    }

    private function tidakluluskanZ($pen, $urut, $userId)
    {
        $data = $this->_db->table('_tb_pendaftar')->where('id', $pen->id_pendaftaran)->update([
            'status_pendaftaran' => 3,
            'rangking' => $urut,
        ]);

        try {

            // $riwayatLib = new Riwayatlib();
            // $riwayatLib->insert("Memverifikasi Pendaftaran {$pen->fullname} via Jalur Afirmasi dengan No Pendaftaran : {$pen->kode_pendaftaran}", "Memverifikasi Pendaftaran Jalur Afirmasi", "submit");

            $saveNotifSystem = new Notificationlib();
            $saveNotifSystem->send([
                'judul' => "Pendaftaran Jalur " . $pen->via_jalur . " Tidak Lolos.",
                'isi' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>.",
                // 'isi' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>.",
                'action_web' => 'peserta/riwayat/pendaftaran',
                'action_app' => 'riwayat_pendaftaran_page',
                'token' => $pen->id_pendaftaran,
                'send_from' => $userId,
                'send_to' => $pen->id,
            ]);

            // $onesignal = new Fcmlib();
            // $send = $onesignal->pushNotifToUser([
            //     'title' => "Pendaftaran Jalur Afirmasi Tidak Lolos.",
            //     'content' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya anda dapat mendaftar kembali menggunakan jalur yang lain (ZONASI, PRESTASI, MUTASI).",
            //     'send_to' => $pen->id,
            //     'app_url' => 'riwayat_pendaftaran_page',
            // ]);
        } catch (\Throwable $th) {
        }

        return true;
    }

    private function tidakluluskanS($pen, $urut, $userId)
    {
        $data = $this->_db->table('_tb_pendaftar')->where('id', $pen->id_pendaftaran)->update([
            'status_pendaftaran' => 3,
            'rangking' => $urut,
        ]);

        try {

            // $riwayatLib = new Riwayatlib();
            // $riwayatLib->insert("Memverifikasi Pendaftaran {$pen->fullname} via Jalur Afirmasi dengan No Pendaftaran : {$pen->kode_pendaftaran}", "Memverifikasi Pendaftaran Jalur Afirmasi", "submit");

            $saveNotifSystem = new Notificationlib();
            $saveNotifSystem->send([
                'judul' => "Pendaftaran Jalur " . $pen->via_jalur . " Tidak Lolos.",
                'isi' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>.",
                // 'isi' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>.",
                'action_web' => 'peserta/riwayat/pendaftaran',
                'action_app' => 'riwayat_pendaftaran_page',
                'token' => $pen->id_pendaftaran,
                'send_from' => $userId,
                'send_to' => $pen->id,
            ]);

            // $onesignal = new Fcmlib();
            // $send = $onesignal->pushNotifToUser([
            //     'title' => "Pendaftaran Jalur Afirmasi Tidak Lolos.",
            //     'content' => "Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya anda dapat mendaftar kembali menggunakan jalur yang lain (ZONASI, PRESTASI, MUTASI).",
            //     'send_to' => $pen->id,
            //     'app_url' => 'riwayat_pendaftaran_page',
            // ]);
        } catch (\Throwable $th) {
        }

        return true;
    }

    private function luluskanPSisa($pen, $urut, $userId)
    {
        $data = $this->_db->table('_tb_pendaftar')->where('id', $pen->id_pendaftaran)->update([
            'status_pendaftaran' => 2,
            'rangking' => $urut,
            'ket' => "tambahan kuota dari sisa zonasi.",
        ]);

        try {

            // $riwayatLib = new Riwayatlib();
            // $riwayatLib->insert("Memverifikasi Pendaftaran {$pen->fullname} via Jalur Afirmasi dengan No Pendaftaran : {$pen->kode_pendaftaran}", "Memverifikasi Pendaftaran Jalur Afirmasi", "submit");

            $saveNotifSystem = new Notificationlib();
            $saveNotifSystem->send([
                'judul' => "Pendaftaran Jalur " . $pen->via_jalur . " Telah Lolos.",
                'isi' => "Anda dinyatakan <b>LOLOS</b> pada seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya silahkan melakukan konfirmasi dan daftar ulang ke Sekolah Tujuan <br>sesuai jadwal yang telah ditentukan.",
                'action_web' => 'peserta/riwayat/pendaftaran',
                'action_app' => 'riwayat_pendaftaran_page',
                'token' => $pen->id_pendaftaran,
                'send_from' => $userId,
                'send_to' => $pen->id,
            ]);

            // $onesignal = new Fcmlib();
            // $send = $onesignal->pushNotifToUser([
            //     'title' => "Pendaftaran Jalur Afirmasi Telah Lolos.",
            //     'content' => "Anda dinyatakan <b>LOLOS</b> pada seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya silahkan melakukan konfirmasi dan daftar ulang ke Sekolah Tujuan <br>sesuai jadwal yang telah ditentukan.",
            //     'send_to' => $pen->id,
            //     'app_url' => 'riwayat_pendaftaran_page',
            // ]);
        } catch (\Throwable $th) {
        }

        return true;
    }

    private function luluskanASisa($pen, $urut, $userId)
    {
        $data = $this->_db->table('_tb_pendaftar')->where('id', $pen->id_pendaftaran)->update([
            'status_pendaftaran' => 2,
            'rangking' => $urut,
            'ket' => "tambahan kuota dari sisa zonasi.",
        ]);

        try {

            // $riwayatLib = new Riwayatlib();
            // $riwayatLib->insert("Memverifikasi Pendaftaran {$pen->fullname} via Jalur Afirmasi dengan No Pendaftaran : {$pen->kode_pendaftaran}", "Memverifikasi Pendaftaran Jalur Afirmasi", "submit");

            $saveNotifSystem = new Notificationlib();
            $saveNotifSystem->send([
                'judul' => "Pendaftaran Jalur " . $pen->via_jalur . " Telah Lolos.",
                'isi' => "Anda dinyatakan <b>LOLOS</b> pada seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya silahkan melakukan konfirmasi dan daftar ulang ke Sekolah Tujuan <br>sesuai jadwal yang telah ditentukan.",
                'action_web' => 'peserta/riwayat/pendaftaran',
                'action_app' => 'riwayat_pendaftaran_page',
                'token' => $pen->id_pendaftaran,
                'send_from' => $userId,
                'send_to' => $pen->id,
            ]);

            // $onesignal = new Fcmlib();
            // $send = $onesignal->pushNotifToUser([
            //     'title' => "Pendaftaran Jalur Afirmasi Telah Lolos.",
            //     'content' => "Anda dinyatakan <b>LOLOS</b> pada seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya silahkan melakukan konfirmasi dan daftar ulang ke Sekolah Tujuan <br>sesuai jadwal yang telah ditentukan.",
            //     'send_to' => $pen->id,
            //     'app_url' => 'riwayat_pendaftaran_page',
            // ]);
        } catch (\Throwable $th) {
        }

        return true;
    }

    private function luluskanA($pen, $urut, $userId)
    {
        $data = $this->_db->table('_tb_pendaftar')->where('id', $pen->id_pendaftaran)->update([
            'status_pendaftaran' => 2,
            'rangking' => $urut,
        ]);

        try {

            // $riwayatLib = new Riwayatlib();
            // $riwayatLib->insert("Memverifikasi Pendaftaran {$pen->fullname} via Jalur Afirmasi dengan No Pendaftaran : {$pen->kode_pendaftaran}", "Memverifikasi Pendaftaran Jalur Afirmasi", "submit");

            $saveNotifSystem = new Notificationlib();
            $saveNotifSystem->send([
                'judul' => "Pendaftaran Jalur Afirmasi Telah Lolos.",
                'isi' => "Anda dinyatakan <b>LOLOS</b> pada seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya silahkan melakukan konfirmasi dan daftar ulang ke Sekolah Tujuan <br>sesuai jadwal yang telah ditentukan.",
                'action_web' => 'pd/informasi/pengumuman',
                'action_app' => 'riwayat_pendaftaran_page',
                'token' => $pen->id_pendaftaran,
                'send_from' => $userId,
                'send_to' => $pen->user_id,
            ]);

            // $onesignal = new Fcmlib();
            // $send = $onesignal->pushNotifToUser([
            //     'title' => "Pendaftaran Jalur Afirmasi Telah Lolos.",
            //     'content' => "Anda dinyatakan <b>LOLOS</b> pada seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya silahkan melakukan konfirmasi dan daftar ulang ke Sekolah Tujuan <br>sesuai jadwal yang telah ditentukan.",
            //     'send_to' => $pen->id,
            //     'app_url' => 'riwayat_pendaftaran_page',
            // ]);
        } catch (\Throwable $th) {
        }

        return true;
    }

    private function luluskanM($pen, $urut, $userId)
    {
        $data = $this->_db->table('_tb_pendaftar')->where('id', $pen->id_pendaftaran)->update([
            'status_pendaftaran' => 2,
            'rangking' => $urut,
        ]);

        try {

            // $riwayatLib = new Riwayatlib();
            // $riwayatLib->insert("Memverifikasi Pendaftaran {$pen->fullname} via Jalur Afirmasi dengan No Pendaftaran : {$pen->kode_pendaftaran}", "Memverifikasi Pendaftaran Jalur Afirmasi", "submit");

            $saveNotifSystem = new Notificationlib();
            $saveNotifSystem->send([
                'judul' => "Pendaftaran Jalur " . $pen->via_jalur . " Telah Lolos.",
                'isi' => "Anda dinyatakan <b>LOLOS</b> pada seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya silahkan melakukan konfirmasi dan daftar ulang ke Sekolah Tujuan <br>sesuai jadwal yang telah ditentukan.",
                'action_web' => 'peserta/riwayat/pendaftaran',
                'action_app' => 'riwayat_pendaftaran_page',
                'token' => $pen->id_pendaftaran,
                'send_from' => $userId,
                'send_to' => $pen->id,
            ]);

            // $onesignal = new Fcmlib();
            // $send = $onesignal->pushNotifToUser([
            //     'title' => "Pendaftaran Jalur Afirmasi Telah Lolos.",
            //     'content' => "Anda dinyatakan <b>LOLOS</b> pada seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya silahkan melakukan konfirmasi dan daftar ulang ke Sekolah Tujuan <br>sesuai jadwal yang telah ditentukan.",
            //     'send_to' => $pen->id,
            //     'app_url' => 'riwayat_pendaftaran_page',
            // ]);
        } catch (\Throwable $th) {
        }

        return true;
    }

    private function luluskanP($pen, $urut, $userId)
    {
        $data = $this->_db->table('_tb_pendaftar')->where('id', $pen->id_pendaftaran)->update([
            'status_pendaftaran' => 2,
            'rangking' => $urut,
        ]);

        try {

            // $riwayatLib = new Riwayatlib();
            // $riwayatLib->insert("Memverifikasi Pendaftaran {$pen->fullname} via Jalur Afirmasi dengan No Pendaftaran : {$pen->kode_pendaftaran}", "Memverifikasi Pendaftaran Jalur Afirmasi", "submit");

            $saveNotifSystem = new Notificationlib();
            $saveNotifSystem->send([
                'judul' => "Pendaftaran Jalur " . $pen->via_jalur . " Telah Lolos.",
                'isi' => "Anda dinyatakan <b>LOLOS</b> pada seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya silahkan melakukan konfirmasi dan daftar ulang ke Sekolah Tujuan <br>sesuai jadwal yang telah ditentukan.",
                'action_web' => 'peserta/riwayat/pendaftaran',
                'action_app' => 'riwayat_pendaftaran_page',
                'token' => $pen->id_pendaftaran,
                'send_from' => $userId,
                'send_to' => $pen->id,
            ]);

            // $onesignal = new Fcmlib();
            // $send = $onesignal->pushNotifToUser([
            //     'title' => "Pendaftaran Jalur Afirmasi Telah Lolos.",
            //     'content' => "Anda dinyatakan <b>LOLOS</b> pada seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya silahkan melakukan konfirmasi dan daftar ulang ke Sekolah Tujuan <br>sesuai jadwal yang telah ditentukan.",
            //     'send_to' => $pen->id,
            //     'app_url' => 'riwayat_pendaftaran_page',
            // ]);
        } catch (\Throwable $th) {
        }

        return true;
    }

    private function luluskanZ($pen, $urut, $userId)
    {
        $data = $this->_db->table('_tb_pendaftar')->where('id', $pen->id_pendaftaran)->update([
            'status_pendaftaran' => 2,
            'rangking' => $urut,
        ]);

        try {

            // $riwayatLib = new Riwayatlib();
            // $riwayatLib->insert("Memverifikasi Pendaftaran {$pen->fullname} via Jalur Afirmasi dengan No Pendaftaran : {$pen->kode_pendaftaran}", "Memverifikasi Pendaftaran Jalur Afirmasi", "submit");

            $saveNotifSystem = new Notificationlib();
            $saveNotifSystem->send([
                'judul' => "Pendaftaran Jalur " . $pen->via_jalur . " Telah Lolos.",
                'isi' => "Anda dinyatakan <b>LOLOS</b> pada seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya silahkan melakukan konfirmasi dan daftar ulang ke Sekolah Tujuan <br>sesuai jadwal yang telah ditentukan.",
                'action_web' => 'peserta/riwayat/pendaftaran',
                'action_app' => 'riwayat_pendaftaran_page',
                'token' => $pen->id_pendaftaran,
                'send_from' => $userId,
                'send_to' => $pen->id,
            ]);

            // $onesignal = new Fcmlib();
            // $send = $onesignal->pushNotifToUser([
            //     'title' => "Pendaftaran Jalur Afirmasi Telah Lolos.",
            //     'content' => "Anda dinyatakan <b>LOLOS</b> pada seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya silahkan melakukan konfirmasi dan daftar ulang ke Sekolah Tujuan <br>sesuai jadwal yang telah ditentukan.",
            //     'send_to' => $pen->id,
            //     'app_url' => 'riwayat_pendaftaran_page',
            // ]);
        } catch (\Throwable $th) {
        }

        return true;
    }

    private function luluskanS($pen, $urut, $userId)
    {
        $data = $this->_db->table('_tb_pendaftar')->where('id', $pen->id_pendaftaran)->update([
            'status_pendaftaran' => 2,
            'rangking' => $urut,
        ]);

        try {

            // $riwayatLib = new Riwayatlib();
            // $riwayatLib->insert("Memverifikasi Pendaftaran {$pen->fullname} via Jalur Afirmasi dengan No Pendaftaran : {$pen->kode_pendaftaran}", "Memverifikasi Pendaftaran Jalur Afirmasi", "submit");

            $saveNotifSystem = new Notificationlib();
            $saveNotifSystem->send([
                'judul' => "Pendaftaran Jalur " . $pen->via_jalur . " Telah Lolos.",
                'isi' => "Anda dinyatakan <b>LOLOS</b> pada seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya silahkan melakukan konfirmasi dan daftar ulang ke Sekolah Tujuan <br>sesuai jadwal yang telah ditentukan.",
                'action_web' => 'peserta/riwayat/pendaftaran',
                'action_app' => 'riwayat_pendaftaran_page',
                'token' => $pen->id_pendaftaran,
                'send_from' => $userId,
                'send_to' => $pen->id,
            ]);

            // $onesignal = new Fcmlib();
            // $send = $onesignal->pushNotifToUser([
            //     'title' => "Pendaftaran Jalur Afirmasi Telah Lolos.",
            //     'content' => "Anda dinyatakan <b>LOLOS</b> pada seleksi PPDB Tahun Ajaran 2023/2024 <br/>di : <b>" . getNamaAndNpsnSekolah($pen->tujuan_sekolah_id_1) . "</b> Melalui Jalur <b>" . $pen->via_jalur . "</b>. <br/>Selanjutnya silahkan melakukan konfirmasi dan daftar ulang ke Sekolah Tujuan <br>sesuai jadwal yang telah ditentukan.",
            //     'send_to' => $pen->id,
            //     'app_url' => 'riwayat_pendaftaran_page',
            // ]);
        } catch (\Throwable $th) {
        }

        return true;
    }

    // public function insert($keterangan, $aksi = "merubah data", $icon = "submit")
    // {
    //     $jwt = get_cookie('jwt');
    //     $token_jwt = getenv('token_jwt.default.key');
    //     if ($jwt) {

    //         try {

    //             $decoded = JWT::decode($jwt, $token_jwt, array('HS256'));
    //             if ($decoded) {
    //                 $userId = $decoded->data->id;
    //                 $role = $decoded->data->role;
    //                 $uuidLib = new Uuid();
    //                 $uuid = $uuidLib->v4();
    //                 $dataInsert = [
    //                     'id' => $uuid,
    //                     'user_id' => $userId,
    //                     'keterangan' => $keterangan,
    //                     'aksi' => $aksi,
    //                     'icon' => $icon,
    //                     'created_at' => date('Y-m-d H:i:s'),
    //                 ];
    //                 return $this->_db->table('riwayat_system_dinas')->insert($dataInsert);
    //             } else {
    //                 return true;
    //             }
    //         } catch (\Exception $e) {
    //             return true;
    //         }
    //     } else {
    //         return true;
    //     }
    // }
}
