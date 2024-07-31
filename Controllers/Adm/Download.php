<?php

namespace App\Controllers\Adm;

use App\Controllers\BaseController;
use App\Models\Adm\Pengaduan\PengaduanModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Helplib;
use App\Libraries\Uuid;
use setasign\Fpdi\TcpdfFpdi;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Writer\Xls;


class Download extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;
    private $_helpLib;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
        $this->_helpLib = new Helplib();
    }

    public function index()
    {
        return redirect()->to(base_url('adm/download/data'));
    }

    public function data()
    {

        $Profilelib = new Profilelib();
        $user = $Profilelib->user();

        if (!$user || $user->status !== 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        // $layanan = json_decode(file_get_contents(FCPATH . "uploads/layanans_silastri.json"), true);
        // $data['layanans'] = [];
        // var_dump("PENG");
        // die;
        $data['user'] = $user->data;
        $data['level'] = $user->level;
        $data['level_nama'] = $user->level_nama;
        $data['title'] = 'Dashboard';
        return view('adm/download/index', $data);
    }

    public function pelenggara()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        try {

            $spreadsheet = new Spreadsheet();
            $worksheet = $spreadsheet->getActiveSheet();

            // Menulis nama kolom ke dalam baris pertama worksheet
            $worksheet->getCell('A1')->setValue("DATA SATUAN PENDIDIKAN PENYELENGGARA PPDB ONLINE");
            $worksheet->getCell('A2')->setValue("KABUPATEN LAMPUNG TENGAH");
            $worksheet->getCell('A3')->setValue("TAHUN PELAJARAN 2024/2025");
            // $worksheet->getCell('A4')->setValue("");
            $worksheet->fromArray(['NO', 'KECAMATAN', 'NPSN', 'SATUAN PENDIDIKAN', 'JENJANG', 'STATUS'], NULL, 'A5');

            $worksheet->getColumnDimension('A')->setWidth(4);
            $worksheet->getColumnDimension('B')->setWidth(30);
            $worksheet->getColumnDimension('C')->setWidth(10);
            $worksheet->getColumnDimension('D')->setWidth(50);
            $worksheet->getColumnDimension('E')->setWidth(8);
            $worksheet->getColumnDimension('F')->setWidth(7);
            // Mengambil data dari database
            $query = $this->_db->table('_setting_kuota_tb a')
                ->select("b.kecamatan, a.npsn, b.nama, b.bentuk_pendidikan_id, b.bentuk_pendidikan, b.status_sekolah")
                ->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id')
                ->orderBy('b.bentuk_pendidikan_id', 'DESC')
                ->orderBy('b.status_sekolah', 'ASC')
                ->orderBy('b.nama', 'ASC')
                ->get();

            // Menulis data ke dalam worksheet
            $data = $query->getResult();
            $row = 6;
            if (count($data) > 0) {
                foreach ($data as $key => $item) {
                    $worksheet->getCell('A' . $row)->setValue($key + 1);
                    $worksheet->getCell('B' . $row)->setValue($item->kecamatan);
                    $worksheet->getCell('C' . $row)->setValue($item->npsn);
                    $worksheet->getCell('D' . $row)->setValue($item->nama);
                    $worksheet->getCell('E' . $row)->setValue($item->bentuk_pendidikan);
                    $worksheet->getCell('F' . $row)->setValue($item->status_sekolah);
                    $row++;
                }
            }

            $writer = new Xls($spreadsheet);
            $filename = 'DATA_SEKOLAH_PENYELENGGARA_PPDB.xls';
            header('Content-Type: application/vnd-ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit();
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }

    public function petazonasi()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        // $jalur = htmlspecialchars($this->request->getGet('j'), true);
        // if ($jalur == "") {
        //     return view('404');
        // }

        try {

            $spreadsheet = new Spreadsheet();
            $worksheet = $spreadsheet->getActiveSheet();

            // Menulis nama kolom ke dalam baris pertama worksheet
            $worksheet->getCell('A1')->setValue("DATA KESIAPAN ZONASI PPDB");
            $worksheet->getCell('A2')->setValue("KABUPATEN LAMPUNG TENGAH");
            $worksheet->getCell('A3')->setValue("TAHUN PELAJARAN 2024/2025");
            // $worksheet->getCell('A4')->setValue("");
            $worksheet->fromArray(['NO', 'KECAMATAN', 'NPSN', 'SATUAN PENDIDIKAN', 'JENJANG', 'STATUS', 'PROVINSI', 'KABUPATEN', 'KECAMATAN', 'KELURAHAN', 'DUSUN/LINGKUNGAN'], NULL, 'A5');

            $worksheet->getColumnDimension('A')->setWidth(4);
            $worksheet->getColumnDimension('B')->setWidth(30);
            $worksheet->getColumnDimension('C')->setWidth(10);
            $worksheet->getColumnDimension('D')->setWidth(50);
            $worksheet->getColumnDimension('E')->setWidth(8);
            $worksheet->getColumnDimension('F')->setWidth(7);
            $worksheet->getColumnDimension('G')->setWidth(30);
            $worksheet->getColumnDimension('H')->setWidth(30);
            $worksheet->getColumnDimension('I')->setWidth(30);
            $worksheet->getColumnDimension('J')->setWidth(30);
            $worksheet->getColumnDimension('K')->setWidth(30);
            // Mengambil data dari database
            $query = $this->_db->table('_setting_kuota_tb a')
                ->select("b.kecamatan, a.npsn, b.nama, b.bentuk_pendidikan_id, b.bentuk_pendidikan, b.status_sekolah, a.jumlah_rombel_kebutuhan, (CASE WHEN b.bentuk_pendidikan_id = 6 THEN 32 ELSE 28 END) AS jumlah_pd_rombel, (CASE WHEN b.bentuk_pendidikan_id = 6 THEN (32 * a.jumlah_rombel_kebutuhan) ELSE (28 * a.jumlah_rombel_kebutuhan) END) AS jumlah_total_pd")
                ->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id')
                // ->where('a.tujuan_sekolah_id_1', $user->data->sekolah_id)
                // ->whereIn('a.status_pendaftaran', [1, 2, 3])
                // ->orderBy('a.status_pendaftaran', 'ASC')
                // ->orderBy('a.via_jalur', 'ASC')
                ->orderBy('b.bentuk_pendidikan_id', 'DESC')
                ->orderBy('b.status_sekolah', 'ASC')
                ->orderBy('b.nama', 'ASC')
                ->get();

            // Menulis data ke dalam worksheet
            $data = $query->getResult();
            $row = 6;
            if (count($data) > 0) {
                foreach ($data as $key => $item) {
                    $queryZonasi = $this->_db->table('_setting_zonasi_tb a')
                        ->select("a.*, b.nama as nama_provinsi, c.nama as nama_kabupaten, d.nama as nama_kecamatan, e.nama as nama_kelurahan, (SELECT count(dusun) FROM _setting_zonasi_tb WHERE dusun = a.dusun) as jumlah_dusun, count(dusun) as jumlah")
                        ->join('ref_provinsi b', 'b.id = a.provinsi')
                        ->join('ref_kabupaten c', 'c.id = a.kabupaten')
                        ->join('ref_kecamatan d', 'd.id = a.kecamatan')
                        ->join('ref_kelurahan e', 'e.id = a.kelurahan')
                        ->orderBy('a.kecamatan', 'asc')
                        ->orderBy('a.kelurahan', 'asc')
                        ->get();

                    $dataKuota = $queryZonasi->getResult();
                    if (count($dataKuota) > 0) {
                        foreach ($dataKuota as $keyKuota => $itemKuota) {
                            $worksheet->getCell('A' . $row)->setValue($key + 1);
                            $worksheet->getCell('B' . $row)->setValue($item->kecamatan);
                            $worksheet->getCell('C' . $row)->setValue($item->npsn);
                            $worksheet->getCell('D' . $row)->setValue($item->nama);
                            $worksheet->getCell('E' . $row)->setValue($item->bentuk_pendidikan);
                            $worksheet->getCell('F' . $row)->setValue($item->status_sekolah);
                            $worksheet->getCell('G' . $row)->setValue($itemKuota->nama_provinsi);
                            $worksheet->getCell('H' . $row)->setValue($itemKuota->nama_kabupaten);
                            $worksheet->getCell('I' . $row)->setValue($itemKuota->nama_kecamatan);
                            $worksheet->getCell('I' . $row)->setValue($itemKuota->nama_kelurahan);
                            $namaDusun = getDusunList($itemKuota->kelurahan, $itemKuota->sekolah_id);
                            $worksheet->getCell('K' . $row)->setValue($namaDusun);
                            // if (substr((string)$item->nisn_peserta, 0, 2) == "BS") {
                            //     $worksheet->setCellValueExplicit("C" . $row, "", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                            // } else {
                            //     $worksheet->setCellValueExplicit("C" . $row, (string)$item->nisn_peserta, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                            // }
                            // $worksheet->getCell('D' . $row)->setValue($item->tempat_lahir_peserta);
                            // $worksheet->getCell('E' . $row)->setValue($item->tanggal_lahir_peserta);
                            // $worksheet->getCell('F' . $row)->setValue($item->jenis_kelamin_peserta);
                            // $worksheet->getCell('G' . $row)->setValue($item->kode_pendaftaran);
                            // $worksheet->getCell('H' . $row)->setValue($item->via_jalur);
                            // $jarakDomisili = round($item->jarak_domisili, 3) . ' Km';
                            // $worksheet->getCell('I' . $row)->setValue($jarakDomisili);
                            // $worksheet->setCellValueExplicit("J" . $row, tgl_indo2($item->created_at), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                            // $worksheet->setCellValueExplicit("G" . $row, $item->us_pang_mk_tahun, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);

                            $row++;
                        }
                    }
                }
            }

            // Menyiapkan objek writer untuk menulis file Excel
            $writer = new Xls($spreadsheet);

            // Menuliskan file Excel
            // if ($jalur == "all") {
            $filename = 'DATA_KESIAPAN_PEMETAAN_ZONASI_PPDB.xls';
            // } else {
            //     $filename = 'DATA_PENDAFTAR_' . strtoupper($jalur) . '.xls';
            // }
            header('Content-Type: application/vnd-ms-excel');
            // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit();
            //code...
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }

    public function kuota()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        // $jalur = htmlspecialchars($this->request->getGet('j'), true);
        // if ($jalur == "") {
        //     return view('404');
        // }

        try {

            $spreadsheet = new Spreadsheet();
            $worksheet = $spreadsheet->getActiveSheet();

            // Menulis nama kolom ke dalam baris pertama worksheet
            $worksheet->getCell('A1')->setValue("DATA KESIAPAN ROMBEL PPDB");
            $worksheet->getCell('A2')->setValue("KABUPATEN LAMPUNG TENGAH");
            $worksheet->getCell('A3')->setValue("TAHUN PELAJARAN 2024/2025");
            // $worksheet->getCell('A4')->setValue("");
            $worksheet->fromArray(['NO', 'KECAMATAN', 'NPSN', 'SATUAN PENDIDIKAN', 'JENJANG', 'STATUS', 'JUMLAH KESIAPAN ROMBER', 'JUMLAH PD / ROMBEL', 'JUMLAH PESERTA'], NULL, 'A5');

            $worksheet->getColumnDimension('A')->setWidth(4);
            $worksheet->getColumnDimension('B')->setWidth(30);
            $worksheet->getColumnDimension('C')->setWidth(10);
            $worksheet->getColumnDimension('D')->setWidth(50);
            $worksheet->getColumnDimension('E')->setWidth(8);
            $worksheet->getColumnDimension('F')->setWidth(7);
            $worksheet->getColumnDimension('G')->setWidth(23);
            $worksheet->getColumnDimension('H')->setWidth(23);
            $worksheet->getColumnDimension('I')->setWidth(23);
            // Mengambil data dari database
            $query = $this->_db->table('_setting_kuota_tb a')
                ->select("b.kecamatan, a.npsn, b.nama, b.bentuk_pendidikan_id, b.bentuk_pendidikan, b.status_sekolah, a.jumlah_rombel_kebutuhan, (CASE WHEN b.bentuk_pendidikan_id = 6 THEN 32 ELSE 28 END) AS jumlah_pd_rombel, (CASE WHEN b.bentuk_pendidikan_id = 6 THEN (32 * a.jumlah_rombel_kebutuhan) ELSE (28 * a.jumlah_rombel_kebutuhan) END) AS jumlah_total_pd")
                ->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id')
                // ->where('a.tujuan_sekolah_id_1', $user->data->sekolah_id)
                // ->whereIn('a.status_pendaftaran', [1, 2, 3])
                // ->orderBy('a.status_pendaftaran', 'ASC')
                // ->orderBy('a.via_jalur', 'ASC')
                ->orderBy('b.bentuk_pendidikan_id', 'DESC')
                ->orderBy('b.status_sekolah', 'ASC')
                ->orderBy('b.nama', 'ASC')
                ->get();

            // Menulis data ke dalam worksheet
            $data = $query->getResult();
            $row = 6;
            if (count($data) > 0) {
                foreach ($data as $key => $item) {
                    $worksheet->getCell('A' . $row)->setValue($key + 1);
                    $worksheet->getCell('B' . $row)->setValue($item->kecamatan);
                    $worksheet->getCell('C' . $row)->setValue($item->npsn);
                    $worksheet->getCell('D' . $row)->setValue($item->nama);
                    $worksheet->getCell('E' . $row)->setValue($item->bentuk_pendidikan);
                    $worksheet->getCell('F' . $row)->setValue($item->status_sekolah);
                    $worksheet->getCell('G' . $row)->setValue($item->jumlah_rombel_kebutuhan);
                    $worksheet->getCell('H' . $row)->setValue($item->jumlah_pd_rombel);
                    $worksheet->getCell('I' . $row)->setValue($item->jumlah_total_pd);
                    // if (substr((string)$item->nisn_peserta, 0, 2) == "BS") {
                    //     $worksheet->setCellValueExplicit("C" . $row, "", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    // } else {
                    //     $worksheet->setCellValueExplicit("C" . $row, (string)$item->nisn_peserta, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    // }
                    // $worksheet->getCell('D' . $row)->setValue($item->tempat_lahir_peserta);
                    // $worksheet->getCell('E' . $row)->setValue($item->tanggal_lahir_peserta);
                    // $worksheet->getCell('F' . $row)->setValue($item->jenis_kelamin_peserta);
                    // $worksheet->getCell('G' . $row)->setValue($item->kode_pendaftaran);
                    // $worksheet->getCell('H' . $row)->setValue($item->via_jalur);
                    // $jarakDomisili = round($item->jarak_domisili, 3) . ' Km';
                    // $worksheet->getCell('I' . $row)->setValue($jarakDomisili);
                    // $worksheet->setCellValueExplicit("J" . $row, tgl_indo2($item->created_at), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    // $worksheet->setCellValueExplicit("G" . $row, $item->us_pang_mk_tahun, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);

                    $row++;
                }
            }

            // Menyiapkan objek writer untuk menulis file Excel
            $writer = new Xls($spreadsheet);

            // Menuliskan file Excel
            // if ($jalur == "all") {
            $filename = 'DATA_KESIAPAN_ROMBEL_PPDB.xls';
            // } else {
            //     $filename = 'DATA_PENDAFTAR_' . strtoupper($jalur) . '.xls';
            // }
            header('Content-Type: application/vnd-ms-excel');
            // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit();
            //code...
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }

    public function usia()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        try {

            $spreadsheet = new Spreadsheet();
            $worksheet = $spreadsheet->getActiveSheet();

            $boldFont = new Font();
            $boldFont->setBold(true);

            // Menulis nama kolom ke dalam baris pertama worksheet
            $worksheet->getCell('A1')->setValue("REKAPITULASI PESERTA PPDB BERDASARKAN USIA");
            $worksheet->getCell('A2')->setValue("KABUPATEN LAMPUNG TENGAH");
            $worksheet->getCell('A3')->setValue("TAHUN PELAJARAN 2024/2025");
            $worksheet->mergeCells('A5:A6');
            $worksheet->mergeCells('B5:B6');
            $worksheet->mergeCells('C5:C6');
            $worksheet->mergeCells('D5:D6');
            $worksheet->mergeCells('E5:E6');
            $worksheet->mergeCells('F5:F6');
            $worksheet->mergeCells('G5:P5');
            $worksheet->fromArray(['NO', 'KECAMATAN', 'NPSN', 'SATUAN PENDIDIKAN', 'JENJANG', 'STATUS', 'USIA'], NULL, 'A5');
            $worksheet->fromArray(['<6', '6', '7', '>7', '<12', '12', '13', '14', '15', '>15'], NULL, 'G6');

            $worksheet->getColumnDimension('A')->setWidth(5);
            $worksheet->getColumnDimension('B')->setWidth(30);
            $worksheet->getColumnDimension('C')->setWidth(10);
            $worksheet->getColumnDimension('D')->setWidth(50);
            $worksheet->getColumnDimension('E')->setWidth(8);
            $worksheet->getColumnDimension('F')->setWidth(7);
            $worksheet->getColumnDimension('G')->setWidth(7);
            $worksheet->getColumnDimension('H')->setWidth(7);
            $worksheet->getColumnDimension('I')->setWidth(7);
            $worksheet->getColumnDimension('J')->setWidth(7);
            $worksheet->getColumnDimension('K')->setWidth(7);
            $worksheet->getColumnDimension('L')->setWidth(7);
            $worksheet->getColumnDimension('M')->setWidth(7);
            $worksheet->getColumnDimension('N')->setWidth(7);
            $worksheet->getColumnDimension('O')->setWidth(7);
            $worksheet->getColumnDimension('P')->setWidth(7);
            // Mengambil data dari database
            $query = $this->_db->table('_setting_kuota_tb a')
                ->select("a.sekolah_id, b.kecamatan, a.npsn, b.nama, b.bentuk_pendidikan_id, b.bentuk_pendidikan, b.status_sekolah")
                ->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id')
                ->orderBy('b.bentuk_pendidikan_id', 'DESC')
                ->orderBy('b.status_sekolah', 'ASC')
                ->orderBy('b.nama', 'ASC')
                ->get();

            // Menulis data ke dalam worksheet
            $data = $query->getResult();
            $row = 7;
            if (count($data) > 0) {
                foreach ($data as $key => $item) {
                    $worksheet->getCell('A' . $row)->setValue($key + 1);
                    $worksheet->getCell('B' . $row)->setValue($item->kecamatan);
                    $worksheet->getCell('C' . $row)->setValue($item->npsn);
                    $worksheet->getCell('D' . $row)->setValue($item->nama);
                    $worksheet->getCell('E' . $row)->setValue($item->bentuk_pendidikan);
                    $worksheet->getCell('F' . $row)->setValue($item->status_sekolah);
                    $umurs = $this->_db->table('_tb_pendaftar')
                        ->select("YEAR('2024-07-01') - YEAR(tanggal_lahir_peserta) - (
                            CASE
                            WHEN MONTH('2024-07-01') < MONTH(tanggal_lahir_peserta) OR (
                                MONTH('2024-07-01') = MONTH(tanggal_lahir_peserta) AND
                                DAY('2024-07-01') < DAY(tanggal_lahir_peserta)
                            )
                            THEN 1
                            ELSE 0
                            END
                        ) AS umur_dalam_tahun, COUNT(*) AS jumlah_peserta")
                        ->where('tujuan_sekolah_id_1', $item->sekolah_id)
                        ->get()->getResult();

                    if (count($umurs) > 0) {
                        $umur_k6 = 0;
                        $umur_6 = 0;
                        $umur_6 = 0;
                        $umur_7 = 0;
                        $umur_b7 = 0;
                        $umur_k12 = 0;
                        $umur_12 = 0;
                        $umur_13 = 0;
                        $umur_14 = 0;
                        $umur_15 = 0;
                        $umur_b15 = 0;
                        foreach ($umurs as $key => $value) {
                            if ((int)$value->umur_dalam_tahun < 6) {
                                $umur_k6 = (int)$value->jumlah_peserta;
                            }
                            if ((int)$value->umur_dalam_tahun == 6) {
                                $umur_6 = (int)$value->jumlah_peserta;
                            }
                            if ((int)$value->umur_dalam_tahun == 7) {
                                $umur_7 = (int)$value->jumlah_peserta;
                            }
                            if ((int)$value->umur_dalam_tahun > 7 && (int)$value->umur_dalam_tahun < 11) {
                                $umur_b7 = (int)$value->jumlah_peserta;
                            }
                            if ((int)$value->umur_dalam_tahun < 12 && (int)$value->umur_dalam_tahun > 10) {
                                $umur_k12 = (int)$value->jumlah_peserta;
                            }
                            if ((int)$value->umur_dalam_tahun == 12) {
                                $umur_12 = (int)$value->jumlah_peserta;
                            }
                            if ((int)$value->umur_dalam_tahun == 13) {
                                $umur_13 = (int)$value->jumlah_peserta;
                            }
                            if ((int)$value->umur_dalam_tahun == 14) {
                                $umur_14 = (int)$value->jumlah_peserta;
                            }
                            if ((int)$value->umur_dalam_tahun == 15) {
                                $umur_15 = (int)$value->jumlah_peserta;
                            }
                            if ((int)$value->umur_dalam_tahun > 15) {
                                $umur_b15 = (int)$value->jumlah_peserta;
                            }
                        }
                        $worksheet->getCell('G' . $row)->setValue($umur_k6);
                        $worksheet->getCell('H' . $row)->setValue($umur_6);
                        $worksheet->getCell('I' . $row)->setValue($umur_7);
                        $worksheet->getCell('J' . $row)->setValue($umur_b7);
                        $worksheet->getCell('K' . $row)->setValue($umur_k12);
                        $worksheet->getCell('L' . $row)->setValue($umur_12);
                        $worksheet->getCell('M' . $row)->setValue($umur_13);
                        $worksheet->getCell('N' . $row)->setValue($umur_14);
                        $worksheet->getCell('O' . $row)->setValue($umur_15);
                        $worksheet->getCell('P' . $row)->setValue($umur_b15);
                    } else {
                        $worksheet->getCell('G' . $row)->setValue(0);
                        $worksheet->getCell('H' . $row)->setValue(0);
                        $worksheet->getCell('I' . $row)->setValue(0);
                        $worksheet->getCell('J' . $row)->setValue(0);
                        $worksheet->getCell('K' . $row)->setValue(0);
                        $worksheet->getCell('L' . $row)->setValue(0);
                        $worksheet->getCell('M' . $row)->setValue(0);
                        $worksheet->getCell('N' . $row)->setValue(0);
                        $worksheet->getCell('O' . $row)->setValue(0);
                        $worksheet->getCell('P' . $row)->setValue(0);
                    }
                    $row++;
                }
            }


            $styleKop = $worksheet->getStyle('A1:A4');
            $styleKop->setFont($boldFont);

            $styleHeader = $worksheet->getStyle('A5:P6');  // Adjust range based on your merged cells

            // Set vertical and horizontal alignment
            $styleHeader->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $styleHeader->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            // Apply bold font style to header cells
            $styleHeader->setFont($boldFont);

            $rowsToStyle = range('F', 'P');

            foreach ($rowsToStyle as $row) {
                $styleRow = $worksheet->getStyle($row);
                $styleRow->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $styleRow->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            }


            $writer = new Xls($spreadsheet);
            $filename = 'DATA_REKAPITULASI_PESERTA_PPDB_BERDASARKAN_USIA.xls';
            header('Content-Type: application/vnd-ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit();
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }

    public function afirmasi()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        try {

            $spreadsheet = new Spreadsheet();
            $worksheet = $spreadsheet->getActiveSheet();

            $boldFont = new Font();
            $boldFont->setBold(true);

            // Menulis nama kolom ke dalam baris pertama worksheet
            $worksheet->getCell('A1')->setValue("REKAPITULASI PESERTA PPDB JALUR ARIFMASI");
            $worksheet->getCell('A2')->setValue("KABUPATEN LAMPUNG TENGAH");
            $worksheet->getCell('A3')->setValue("TAHUN PELAJARAN 2024/2025");
            $worksheet->mergeCells('A5:A6');
            $worksheet->mergeCells('B5:B6');
            $worksheet->mergeCells('C5:C6');
            $worksheet->mergeCells('D5:D6');
            $worksheet->mergeCells('E5:E6');
            $worksheet->mergeCells('F5:F6');
            $worksheet->mergeCells('G5:H5');
            $worksheet->fromArray(['NO', 'KECAMATAN', 'NPSN', 'SATUAN PENDIDIKAN', 'JENJANG', 'STATUS', 'JUMLAH'], NULL, 'A5');
            $worksheet->fromArray(['PESERTA', 'DITERIMA'], NULL, 'G6');

            $worksheet->getColumnDimension('A')->setWidth(5);
            $worksheet->getColumnDimension('B')->setWidth(30);
            $worksheet->getColumnDimension('C')->setWidth(10);
            $worksheet->getColumnDimension('D')->setWidth(50);
            $worksheet->getColumnDimension('E')->setWidth(8);
            $worksheet->getColumnDimension('F')->setWidth(7);
            $worksheet->getColumnDimension('G')->setWidth(9);
            $worksheet->getColumnDimension('H')->setWidth(9);
            // Mengambil data dari database
            $query = $this->_db->table('_setting_kuota_tb a')
                ->select("a.sekolah_id, b.kecamatan, a.npsn, b.nama, b.bentuk_pendidikan_id, b.bentuk_pendidikan, b.status_sekolah, (SELECT count(*) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'AFIRMASI') AS jumlah_peserta, (SELECT count(*) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'AFIRMASI' AND status_pendaftaran = 2) AS jumlah_diterima")
                ->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id')
                ->where('b.status_sekolah_id', '1')
                ->orderBy('b.bentuk_pendidikan_id', 'DESC')
                ->orderBy('b.status_sekolah', 'ASC')
                ->orderBy('b.nama', 'ASC')
                ->get();

            // Menulis data ke dalam worksheet
            $data = $query->getResult();
            $row = 7;
            if (count($data) > 0) {
                foreach ($data as $key => $item) {
                    $worksheet->getCell('A' . $row)->setValue($key + 1);
                    $worksheet->getCell('B' . $row)->setValue($item->kecamatan);
                    $worksheet->getCell('C' . $row)->setValue($item->npsn);
                    $worksheet->getCell('D' . $row)->setValue($item->nama);
                    $worksheet->getCell('E' . $row)->setValue($item->bentuk_pendidikan);
                    $worksheet->getCell('F' . $row)->setValue($item->status_sekolah);
                    $worksheet->getCell('G' . $row)->setValue($item->jumlah_peserta);
                    $worksheet->getCell('H' . $row)->setValue($item->jumlah_diterima);
                    $row++;
                }
            }


            $styleKop = $worksheet->getStyle('A1:A4');
            $styleKop->setFont($boldFont);

            $styleHeader = $worksheet->getStyle('A5:H6');  // Adjust range based on your merged cells

            // Set vertical and horizontal alignment
            $styleHeader->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $styleHeader->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            // Apply bold font style to header cells
            $styleHeader->setFont($boldFont);

            $rowsToStyle = range('F', 'H');

            foreach ($rowsToStyle as $row) {
                $styleRow = $worksheet->getStyle($row);
                $styleRow->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $styleRow->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            }

            $writer = new Xls($spreadsheet);
            $filename = 'DATA_REKAPITULASI_PESERTA_PPDB_JALUR_AFIRMASI.xls';
            header('Content-Type: application/vnd-ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit();
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }

    public function zonasi()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        try {

            $spreadsheet = new Spreadsheet();
            $worksheet = $spreadsheet->getActiveSheet();

            $boldFont = new Font();
            $boldFont->setBold(true);

            // Menulis nama kolom ke dalam baris pertama worksheet
            $worksheet->getCell('A1')->setValue("REKAPITULASI PESERTA PPDB JALUR ZONASI");
            $worksheet->getCell('A2')->setValue("KABUPATEN LAMPUNG TENGAH");
            $worksheet->getCell('A3')->setValue("TAHUN PELAJARAN 2024/2025");
            $worksheet->mergeCells('A5:A6');
            $worksheet->mergeCells('B5:B6');
            $worksheet->mergeCells('C5:C6');
            $worksheet->mergeCells('D5:D6');
            $worksheet->mergeCells('E5:E6');
            $worksheet->mergeCells('F5:F6');
            $worksheet->mergeCells('G5:H5');
            $worksheet->fromArray(['NO', 'KECAMATAN', 'NPSN', 'SATUAN PENDIDIKAN', 'JENJANG', 'STATUS', 'JUMLAH'], NULL, 'A5');
            $worksheet->fromArray(['PESERTA', 'DITERIMA'], NULL, 'G6');

            $worksheet->getColumnDimension('A')->setWidth(5);
            $worksheet->getColumnDimension('B')->setWidth(30);
            $worksheet->getColumnDimension('C')->setWidth(10);
            $worksheet->getColumnDimension('D')->setWidth(50);
            $worksheet->getColumnDimension('E')->setWidth(8);
            $worksheet->getColumnDimension('F')->setWidth(7);
            $worksheet->getColumnDimension('G')->setWidth(9);
            $worksheet->getColumnDimension('H')->setWidth(9);
            // Mengambil data dari database
            $query = $this->_db->table('_setting_kuota_tb a')
                ->select("a.sekolah_id, b.kecamatan, a.npsn, b.nama, b.bentuk_pendidikan_id, b.bentuk_pendidikan, b.status_sekolah, (SELECT count(*) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'ZONASI') AS jumlah_peserta, (SELECT count(*) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'ZONASI' AND status_pendaftaran = 2) AS jumlah_diterima")
                ->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id')
                ->where('b.status_sekolah_id', '1')
                ->orderBy('b.bentuk_pendidikan_id', 'DESC')
                ->orderBy('b.status_sekolah', 'ASC')
                ->orderBy('b.nama', 'ASC')
                ->get();

            // Menulis data ke dalam worksheet
            $data = $query->getResult();
            $row = 7;
            if (count($data) > 0) {
                foreach ($data as $key => $item) {
                    $worksheet->getCell('A' . $row)->setValue($key + 1);
                    $worksheet->getCell('B' . $row)->setValue($item->kecamatan);
                    $worksheet->getCell('C' . $row)->setValue($item->npsn);
                    $worksheet->getCell('D' . $row)->setValue($item->nama);
                    $worksheet->getCell('E' . $row)->setValue($item->bentuk_pendidikan);
                    $worksheet->getCell('F' . $row)->setValue($item->status_sekolah);
                    $worksheet->getCell('G' . $row)->setValue($item->jumlah_peserta);
                    $worksheet->getCell('H' . $row)->setValue($item->jumlah_diterima);
                    $row++;
                }
            }


            $styleKop = $worksheet->getStyle('A1:A4');
            $styleKop->setFont($boldFont);

            $styleHeader = $worksheet->getStyle('A5:H6');  // Adjust range based on your merged cells

            // Set vertical and horizontal alignment
            $styleHeader->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $styleHeader->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            // Apply bold font style to header cells
            $styleHeader->setFont($boldFont);

            $rowsToStyle = range('F', 'H');

            foreach ($rowsToStyle as $row) {
                $styleRow = $worksheet->getStyle($row);
                $styleRow->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $styleRow->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            }

            $writer = new Xls($spreadsheet);
            $filename = 'DATA_REKAPITULASI_PESERTA_PPDB_JALUR_ZONASI.xls';
            header('Content-Type: application/vnd-ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit();
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }

    public function mutasi()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        try {

            $spreadsheet = new Spreadsheet();
            $worksheet = $spreadsheet->getActiveSheet();

            $boldFont = new Font();
            $boldFont->setBold(true);

            // Menulis nama kolom ke dalam baris pertama worksheet
            $worksheet->getCell('A1')->setValue("REKAPITULASI PESERTA PPDB JALUR MUTASI");
            $worksheet->getCell('A2')->setValue("KABUPATEN LAMPUNG TENGAH");
            $worksheet->getCell('A3')->setValue("TAHUN PELAJARAN 2024/2025");
            $worksheet->mergeCells('A5:A6');
            $worksheet->mergeCells('B5:B6');
            $worksheet->mergeCells('C5:C6');
            $worksheet->mergeCells('D5:D6');
            $worksheet->mergeCells('E5:E6');
            $worksheet->mergeCells('F5:F6');
            $worksheet->mergeCells('G5:H5');
            $worksheet->fromArray(['NO', 'KECAMATAN', 'NPSN', 'SATUAN PENDIDIKAN', 'JENJANG', 'STATUS', 'JUMLAH'], NULL, 'A5');
            $worksheet->fromArray(['PESERTA', 'DITERIMA'], NULL, 'G6');

            $worksheet->getColumnDimension('A')->setWidth(5);
            $worksheet->getColumnDimension('B')->setWidth(30);
            $worksheet->getColumnDimension('C')->setWidth(10);
            $worksheet->getColumnDimension('D')->setWidth(50);
            $worksheet->getColumnDimension('E')->setWidth(8);
            $worksheet->getColumnDimension('F')->setWidth(7);
            $worksheet->getColumnDimension('G')->setWidth(9);
            $worksheet->getColumnDimension('H')->setWidth(9);
            // Mengambil data dari database
            $query = $this->_db->table('_setting_kuota_tb a')
                ->select("a.sekolah_id, b.kecamatan, a.npsn, b.nama, b.bentuk_pendidikan_id, b.bentuk_pendidikan, b.status_sekolah, (SELECT count(*) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'MUTASI') AS jumlah_peserta, (SELECT count(*) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'MUTASI' AND status_pendaftaran = 2) AS jumlah_diterima")
                ->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id')
                ->where('b.status_sekolah_id', '1')
                ->orderBy('b.bentuk_pendidikan_id', 'DESC')
                ->orderBy('b.status_sekolah', 'ASC')
                ->orderBy('b.nama', 'ASC')
                ->get();

            // Menulis data ke dalam worksheet
            $data = $query->getResult();
            $row = 7;
            if (count($data) > 0) {
                foreach ($data as $key => $item) {
                    $worksheet->getCell('A' . $row)->setValue($key + 1);
                    $worksheet->getCell('B' . $row)->setValue($item->kecamatan);
                    $worksheet->getCell('C' . $row)->setValue($item->npsn);
                    $worksheet->getCell('D' . $row)->setValue($item->nama);
                    $worksheet->getCell('E' . $row)->setValue($item->bentuk_pendidikan);
                    $worksheet->getCell('F' . $row)->setValue($item->status_sekolah);
                    $worksheet->getCell('G' . $row)->setValue($item->jumlah_peserta);
                    $worksheet->getCell('H' . $row)->setValue($item->jumlah_diterima);
                    $row++;
                }
            }


            $styleKop = $worksheet->getStyle('A1:A4');
            $styleKop->setFont($boldFont);

            $styleHeader = $worksheet->getStyle('A5:H6');  // Adjust range based on your merged cells

            // Set vertical and horizontal alignment
            $styleHeader->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $styleHeader->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            // Apply bold font style to header cells
            $styleHeader->setFont($boldFont);

            $rowsToStyle = range('F', 'H');

            foreach ($rowsToStyle as $row) {
                $styleRow = $worksheet->getStyle($row);
                $styleRow->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $styleRow->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            }

            $writer = new Xls($spreadsheet);
            $filename = 'DATA_REKAPITULASI_PESERTA_PPDB_JALUR_MUTASI.xls';
            header('Content-Type: application/vnd-ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit();
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }

    public function prestasi()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        try {

            $spreadsheet = new Spreadsheet();
            $worksheet = $spreadsheet->getActiveSheet();

            $boldFont = new Font();
            $boldFont->setBold(true);

            // Menulis nama kolom ke dalam baris pertama worksheet
            $worksheet->getCell('A1')->setValue("REKAPITULASI PESERTA PPDB JALUR PRESTASI");
            $worksheet->getCell('A2')->setValue("KABUPATEN LAMPUNG TENGAH");
            $worksheet->getCell('A3')->setValue("TAHUN PELAJARAN 2024/2025");
            $worksheet->mergeCells('A5:A6');
            $worksheet->mergeCells('B5:B6');
            $worksheet->mergeCells('C5:C6');
            $worksheet->mergeCells('D5:D6');
            $worksheet->mergeCells('E5:E6');
            $worksheet->mergeCells('F5:F6');
            $worksheet->mergeCells('G5:H5');
            $worksheet->fromArray(['NO', 'KECAMATAN', 'NPSN', 'SATUAN PENDIDIKAN', 'JENJANG', 'STATUS', 'JUMLAH'], NULL, 'A5');
            $worksheet->fromArray(['PESERTA', 'DITERIMA'], NULL, 'G6');

            $worksheet->getColumnDimension('A')->setWidth(5);
            $worksheet->getColumnDimension('B')->setWidth(30);
            $worksheet->getColumnDimension('C')->setWidth(10);
            $worksheet->getColumnDimension('D')->setWidth(50);
            $worksheet->getColumnDimension('E')->setWidth(8);
            $worksheet->getColumnDimension('F')->setWidth(7);
            $worksheet->getColumnDimension('G')->setWidth(9);
            $worksheet->getColumnDimension('H')->setWidth(9);
            // Mengambil data dari database
            $query = $this->_db->table('_setting_kuota_tb a')
                ->select("a.sekolah_id, b.kecamatan, a.npsn, b.nama, b.bentuk_pendidikan_id, b.bentuk_pendidikan, b.status_sekolah, (SELECT count(*) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'PRESTASI') AS jumlah_peserta, (SELECT count(*) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'PRESTASI' AND status_pendaftaran = 2) AS jumlah_diterima")
                ->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id')
                ->where('b.status_sekolah_id', '1')
                ->orderBy('b.bentuk_pendidikan_id', 'DESC')
                ->orderBy('b.status_sekolah', 'ASC')
                ->orderBy('b.nama', 'ASC')
                ->get();

            // Menulis data ke dalam worksheet
            $data = $query->getResult();
            $row = 7;
            if (count($data) > 0) {
                foreach ($data as $key => $item) {
                    $worksheet->getCell('A' . $row)->setValue($key + 1);
                    $worksheet->getCell('B' . $row)->setValue($item->kecamatan);
                    $worksheet->getCell('C' . $row)->setValue($item->npsn);
                    $worksheet->getCell('D' . $row)->setValue($item->nama);
                    $worksheet->getCell('E' . $row)->setValue($item->bentuk_pendidikan);
                    $worksheet->getCell('F' . $row)->setValue($item->status_sekolah);
                    $worksheet->getCell('G' . $row)->setValue($item->jumlah_peserta);
                    $worksheet->getCell('H' . $row)->setValue($item->jumlah_diterima);
                    $row++;
                }
            }


            $styleKop = $worksheet->getStyle('A1:A4');
            $styleKop->setFont($boldFont);

            $styleHeader = $worksheet->getStyle('A5:H6');  // Adjust range based on your merged cells

            // Set vertical and horizontal alignment
            $styleHeader->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $styleHeader->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            // Apply bold font style to header cells
            $styleHeader->setFont($boldFont);

            $rowsToStyle = range('F', 'H');

            foreach ($rowsToStyle as $row) {
                $styleRow = $worksheet->getStyle($row);
                $styleRow->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $styleRow->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            }

            $writer = new Xls($spreadsheet);
            $filename = 'DATA_REKAPITULASI_PESERTA_PPDB_JALUR_PRESTASI.xls';
            header('Content-Type: application/vnd-ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit();
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }

    public function swasta()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        try {

            $spreadsheet = new Spreadsheet();
            $worksheet = $spreadsheet->getActiveSheet();

            $boldFont = new Font();
            $boldFont->setBold(true);

            // Menulis nama kolom ke dalam baris pertama worksheet
            $worksheet->getCell('A1')->setValue("REKAPITULASI PESERTA PPDB SEKOLAH SWASTA");
            $worksheet->getCell('A2')->setValue("KABUPATEN LAMPUNG TENGAH");
            $worksheet->getCell('A3')->setValue("TAHUN PELAJARAN 2024/2025");
            $worksheet->mergeCells('A5:A6');
            $worksheet->mergeCells('B5:B6');
            $worksheet->mergeCells('C5:C6');
            $worksheet->mergeCells('D5:D6');
            $worksheet->mergeCells('E5:E6');
            $worksheet->mergeCells('F5:F6');
            $worksheet->mergeCells('G5:H5');
            $worksheet->fromArray(['NO', 'KECAMATAN', 'NPSN', 'SATUAN PENDIDIKAN', 'JENJANG', 'STATUS', 'JUMLAH'], NULL, 'A5');
            $worksheet->fromArray(['PESERTA', 'DITERIMA'], NULL, 'G6');

            $worksheet->getColumnDimension('A')->setWidth(5);
            $worksheet->getColumnDimension('B')->setWidth(30);
            $worksheet->getColumnDimension('C')->setWidth(10);
            $worksheet->getColumnDimension('D')->setWidth(50);
            $worksheet->getColumnDimension('E')->setWidth(8);
            $worksheet->getColumnDimension('F')->setWidth(7);
            $worksheet->getColumnDimension('G')->setWidth(9);
            $worksheet->getColumnDimension('H')->setWidth(9);
            // Mengambil data dari database
            $query = $this->_db->table('_setting_kuota_tb a')
                ->select("a.sekolah_id, b.kecamatan, a.npsn, b.nama, b.bentuk_pendidikan_id, b.bentuk_pendidikan, b.status_sekolah, (SELECT count(*) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'SWASTA') AS jumlah_peserta, (SELECT count(*) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND via_jalur = 'SWASTA' AND status_pendaftaran = 2) AS jumlah_diterima")
                ->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id')
                ->where("b.status_sekolah_id != '1'")
                ->orderBy('b.bentuk_pendidikan_id', 'DESC')
                ->orderBy('b.status_sekolah', 'ASC')
                ->orderBy('b.nama', 'ASC')
                ->get();

            // Menulis data ke dalam worksheet
            $data = $query->getResult();
            $row = 7;
            if (count($data) > 0) {
                foreach ($data as $key => $item) {
                    $worksheet->getCell('A' . $row)->setValue($key + 1);
                    $worksheet->getCell('B' . $row)->setValue($item->kecamatan);
                    $worksheet->getCell('C' . $row)->setValue($item->npsn);
                    $worksheet->getCell('D' . $row)->setValue($item->nama);
                    $worksheet->getCell('E' . $row)->setValue($item->bentuk_pendidikan);
                    $worksheet->getCell('F' . $row)->setValue($item->status_sekolah);
                    $worksheet->getCell('G' . $row)->setValue($item->jumlah_peserta);
                    $worksheet->getCell('H' . $row)->setValue($item->jumlah_diterima);
                    $row++;
                }
            }


            $styleKop = $worksheet->getStyle('A1:A4');
            $styleKop->setFont($boldFont);

            $styleHeader = $worksheet->getStyle('A5:H6');  // Adjust range based on your merged cells

            // Set vertical and horizontal alignment
            $styleHeader->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $styleHeader->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            // Apply bold font style to header cells
            $styleHeader->setFont($boldFont);

            $rowsToStyle = range('F', 'H');

            foreach ($rowsToStyle as $row) {
                $styleRow = $worksheet->getStyle($row);
                $styleRow->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $styleRow->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            }

            $writer = new Xls($spreadsheet);
            $filename = 'DATA_REKAPITULASI_PESERTA_PPDB_SEKOLAH_SWASTA.xls';
            header('Content-Type: application/vnd-ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit();
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }

    public function belumsekolah()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        try {

            $spreadsheet = new Spreadsheet();
            $worksheet = $spreadsheet->getActiveSheet();

            $boldFont = new Font();
            $boldFont->setBold(true);

            // Menulis nama kolom ke dalam baris pertama worksheet
            $worksheet->getCell('A1')->setValue("REKAPITULASI PESERTA PPDB BELUM SEKOLAH");
            $worksheet->getCell('A2')->setValue("KABUPATEN LAMPUNG TENGAH");
            $worksheet->getCell('A3')->setValue("TAHUN PELAJARAN 2024/2025");
            $worksheet->mergeCells('A5:A6');
            $worksheet->mergeCells('B5:B6');
            $worksheet->mergeCells('C5:C6');
            $worksheet->mergeCells('D5:D6');
            $worksheet->mergeCells('E5:E6');
            $worksheet->mergeCells('F5:F6');
            $worksheet->mergeCells('G5:G6');
            $worksheet->fromArray(['NO', 'KECAMATAN', 'NPSN', 'SATUAN PENDIDIKAN', 'JENJANG', 'STATUS', 'JUMLAH'], NULL, 'A5');

            $worksheet->getColumnDimension('A')->setWidth(5);
            $worksheet->getColumnDimension('B')->setWidth(30);
            $worksheet->getColumnDimension('C')->setWidth(10);
            $worksheet->getColumnDimension('D')->setWidth(50);
            $worksheet->getColumnDimension('E')->setWidth(8);
            $worksheet->getColumnDimension('F')->setWidth(7);
            $worksheet->getColumnDimension('G')->setWidth(9);
            // Mengambil data dari database
            $query = $this->_db->table('_setting_kuota_tb a')
                ->select("a.sekolah_id, b.kecamatan, a.npsn, b.nama, b.bentuk_pendidikan_id, b.bentuk_pendidikan, b.status_sekolah, (SELECT count(*) FROM _tb_pendaftar WHERE tujuan_sekolah_id_1 = a.sekolah_id AND LEFT(nisn_peserta,2) = 'BS') AS jumlah_peserta")
                ->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id')
                ->where("b.bentuk_pendidikan_id = 5")
                ->orderBy('b.bentuk_pendidikan_id', 'DESC')
                ->orderBy('b.status_sekolah', 'ASC')
                ->orderBy('b.nama', 'ASC')
                ->get();

            // Menulis data ke dalam worksheet
            $data = $query->getResult();
            $row = 7;
            if (count($data) > 0) {
                foreach ($data as $key => $item) {
                    $worksheet->getCell('A' . $row)->setValue($key + 1);
                    $worksheet->getCell('B' . $row)->setValue($item->kecamatan);
                    $worksheet->getCell('C' . $row)->setValue($item->npsn);
                    $worksheet->getCell('D' . $row)->setValue($item->nama);
                    $worksheet->getCell('E' . $row)->setValue($item->bentuk_pendidikan);
                    $worksheet->getCell('F' . $row)->setValue($item->status_sekolah);
                    $worksheet->getCell('G' . $row)->setValue($item->jumlah_peserta);
                    $row++;
                }
            }


            $styleKop = $worksheet->getStyle('A1:A4');
            $styleKop->setFont($boldFont);

            $styleHeader = $worksheet->getStyle('A5:G6');  // Adjust range based on your merged cells

            // Set vertical and horizontal alignment
            $styleHeader->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $styleHeader->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            // Apply bold font style to header cells
            $styleHeader->setFont($boldFont);

            $rowsToStyle = range('F', 'G');

            foreach ($rowsToStyle as $row) {
                $styleRow = $worksheet->getStyle($row);
                $styleRow->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $styleRow->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            }

            $writer = new Xls($spreadsheet);
            $filename = 'DATA_REKAPITULASI_PESERTA_PPDB_BELUM_SEKOLAH.xls';
            header('Content-Type: application/vnd-ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit();
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }

    public function dalamkab()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        try {

            $spreadsheet = new Spreadsheet();
            $worksheet = $spreadsheet->getActiveSheet();

            $boldFont = new Font();
            $boldFont->setBold(true);

            // Menulis nama kolom ke dalam baris pertama worksheet
            $worksheet->getCell('A1')->setValue("REKAPITULASI PESERTA PPDB LULUSAN SEKOLAH");
            $worksheet->getCell('A2')->setValue("WILAYAH DALAM KABUPATEN LAMPUNG TENGAH");
            $worksheet->getCell('A3')->setValue("TAHUN PELAJARAN 2024/2025");
            $worksheet->mergeCells('A5:A6');
            $worksheet->mergeCells('B5:B6');
            $worksheet->mergeCells('C5:C6');
            $worksheet->mergeCells('D5:D6');
            $worksheet->mergeCells('E5:E6');
            $worksheet->mergeCells('F5:F6');
            $worksheet->mergeCells('G5:G6');
            $worksheet->fromArray(['NO', 'KECAMATAN', 'NPSN', 'SATUAN PENDIDIKAN', 'JENJANG', 'STATUS', 'JUMLAH'], NULL, 'A5');

            $worksheet->getColumnDimension('A')->setWidth(5);
            $worksheet->getColumnDimension('B')->setWidth(30);
            $worksheet->getColumnDimension('C')->setWidth(10);
            $worksheet->getColumnDimension('D')->setWidth(50);
            $worksheet->getColumnDimension('E')->setWidth(8);
            $worksheet->getColumnDimension('F')->setWidth(7);
            $worksheet->getColumnDimension('G')->setWidth(9);
            // Mengambil data dari database
            $query = $this->_db->table('_setting_kuota_tb a')
                ->select("a.sekolah_id, b.kecamatan, a.npsn, b.nama, b.bentuk_pendidikan_id, b.bentuk_pendidikan, b.status_sekolah, (SELECT count(*) FROM _tb_pendaftar JOIN dapo_sekolah ON dapo_sekolah.sekolah_id = _tb_pendaftar.from_sekolah_id WHERE _tb_pendaftar.tujuan_sekolah_id_1 = a.sekolah_id AND dapo_sekolah.kode_kabupaten = '120200') AS jumlah_peserta")
                ->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id')
                ->orderBy('b.bentuk_pendidikan_id', 'DESC')
                ->orderBy('b.status_sekolah', 'ASC')
                ->orderBy('b.nama', 'ASC')
                ->get();

            // Menulis data ke dalam worksheet
            $data = $query->getResult();
            $row = 7;
            if (count($data) > 0) {
                foreach ($data as $key => $item) {
                    $worksheet->getCell('A' . $row)->setValue($key + 1);
                    $worksheet->getCell('B' . $row)->setValue($item->kecamatan);
                    $worksheet->getCell('C' . $row)->setValue($item->npsn);
                    $worksheet->getCell('D' . $row)->setValue($item->nama);
                    $worksheet->getCell('E' . $row)->setValue($item->bentuk_pendidikan);
                    $worksheet->getCell('F' . $row)->setValue($item->status_sekolah);
                    $worksheet->getCell('G' . $row)->setValue($item->jumlah_peserta);
                    $row++;
                }
            }


            $styleKop = $worksheet->getStyle('A1:A4');
            $styleKop->setFont($boldFont);

            $styleHeader = $worksheet->getStyle('A5:G6');  // Adjust range based on your merged cells

            // Set vertical and horizontal alignment
            $styleHeader->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $styleHeader->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            // Apply bold font style to header cells
            $styleHeader->setFont($boldFont);

            $rowsToStyle = range('F', 'G');

            foreach ($rowsToStyle as $row) {
                $styleRow = $worksheet->getStyle($row);
                $styleRow->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $styleRow->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            }

            $writer = new Xls($spreadsheet);
            $filename = 'DATA_REKAPITULASI_PESERTA_PPDB_LULUSAN_DALAM_WILAYAH_KABUPATEN.xls';
            header('Content-Type: application/vnd-ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit();
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }

    public function luarkab()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        try {

            $spreadsheet = new Spreadsheet();
            $worksheet = $spreadsheet->getActiveSheet();

            $boldFont = new Font();
            $boldFont->setBold(true);

            // Menulis nama kolom ke dalam baris pertama worksheet
            $worksheet->getCell('A1')->setValue("REKAPITULASI PESERTA PPDB LULUSAN SEKOLAH");
            $worksheet->getCell('A2')->setValue("WILAYAH LUAR KABUPATEN LAMPUNG TENGAH");
            $worksheet->getCell('A3')->setValue("TAHUN PELAJARAN 2024/2025");
            $worksheet->mergeCells('A5:A6');
            $worksheet->mergeCells('B5:B6');
            $worksheet->mergeCells('C5:C6');
            $worksheet->mergeCells('D5:D6');
            $worksheet->mergeCells('E5:E6');
            $worksheet->mergeCells('F5:F6');
            $worksheet->mergeCells('G5:G6');
            $worksheet->fromArray(['NO', 'KECAMATAN', 'NPSN', 'SATUAN PENDIDIKAN', 'JENJANG', 'STATUS', 'JUMLAH'], NULL, 'A5');

            $worksheet->getColumnDimension('A')->setWidth(5);
            $worksheet->getColumnDimension('B')->setWidth(30);
            $worksheet->getColumnDimension('C')->setWidth(10);
            $worksheet->getColumnDimension('D')->setWidth(50);
            $worksheet->getColumnDimension('E')->setWidth(8);
            $worksheet->getColumnDimension('F')->setWidth(7);
            $worksheet->getColumnDimension('G')->setWidth(9);
            // Mengambil data dari database
            $query = $this->_db->table('_setting_kuota_tb a')
                ->select("a.sekolah_id, b.kecamatan, a.npsn, b.nama, b.bentuk_pendidikan_id, b.bentuk_pendidikan, b.status_sekolah, (SELECT count(*) FROM _tb_pendaftar JOIN dapo_sekolah ON dapo_sekolah.sekolah_id = _tb_pendaftar.from_sekolah_id WHERE _tb_pendaftar.tujuan_sekolah_id_1 = a.sekolah_id AND dapo_sekolah.kode_kabupaten != '120200') AS jumlah_peserta")
                ->join('dapo_sekolah b', 'a.sekolah_id = b.sekolah_id')
                ->orderBy('b.bentuk_pendidikan_id', 'DESC')
                ->orderBy('b.status_sekolah', 'ASC')
                ->orderBy('b.nama', 'ASC')
                ->get();

            // Menulis data ke dalam worksheet
            $data = $query->getResult();
            $row = 7;
            if (count($data) > 0) {
                foreach ($data as $key => $item) {
                    $worksheet->getCell('A' . $row)->setValue($key + 1);
                    $worksheet->getCell('B' . $row)->setValue($item->kecamatan);
                    $worksheet->getCell('C' . $row)->setValue($item->npsn);
                    $worksheet->getCell('D' . $row)->setValue($item->nama);
                    $worksheet->getCell('E' . $row)->setValue($item->bentuk_pendidikan);
                    $worksheet->getCell('F' . $row)->setValue($item->status_sekolah);
                    $worksheet->getCell('G' . $row)->setValue($item->jumlah_peserta);
                    $row++;
                }
            }


            $styleKop = $worksheet->getStyle('A1:A4');
            $styleKop->setFont($boldFont);

            $styleHeader = $worksheet->getStyle('A5:G6');  // Adjust range based on your merged cells

            // Set vertical and horizontal alignment
            $styleHeader->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $styleHeader->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            // Apply bold font style to header cells
            $styleHeader->setFont($boldFont);

            $rowsToStyle = range('F', 'G');

            foreach ($rowsToStyle as $row) {
                $styleRow = $worksheet->getStyle($row);
                $styleRow->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $styleRow->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            }

            $writer = new Xls($spreadsheet);
            $filename = 'DATA_REKAPITULASI_PESERTA_PPDB_LULUSAN_LUAR_WILAYAH_KABUPATEN.xls';
            header('Content-Type: application/vnd-ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit();
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }

    public function download()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'id' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => 'Id tidak boleh kosong. ',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $this->validator->getError('id');
                return json_encode($response);
            } else {
                $Profilelib = new Profilelib();
                $user = $Profilelib->user();
                if ($user->status != 200) {
                    delete_cookie('jwt');
                    session()->destroy();
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session expired";
                    return json_encode($response);
                }

                $id = htmlspecialchars($this->request->getVar('id'), true);

                $pd = $this->_db->table('_users_profile_pd a')
                    ->select("c.username, b.peserta_didik_id, b.sekolah_id, b.nama, b.nisn, b.tempat_lahir, b.tanggal_lahir, b.jenis_kelamin, b.nik, a.user_id, a.nama_sekolah_asal, a.npsn_asal, a.acc_reg")
                    ->join('dapo_peserta b', 'a.peserta_didik_id = b.peserta_didik_id')
                    ->join('_users_tb c', 'a.user_id = c.id')
                    ->where('a.peserta_didik_id', $id)->get()->getRowObject();

                if (!$pd) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Akun PD tidak ditemukan.";
                    return json_encode($response);
                }

                $html = '<table border="0">
                        <tr>
                            <td>Nama Peserta Didik</td>
                            <td colspan="2">: {{ nama_peserta }}</td>
                        </tr>
                        <tr>
                            <td>NISN</td>
                            <td>: {{ nisn_peserta }}</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>NIK</td>
                            <td>: {{ nik_peserta }}</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Sekolah Asal</td>
                            <td colspan="2">: {{ sekolah_asal_peserta }}</td>
                        </tr>
                        <tr>
                            <td>NPSN Asal</td>
                            <td>: {{ npsn_asal_peserta }}</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Tempat Lahir</td>
                            <td>: {{ tempat_lahir_peserta }}</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td>: {{ tanggal_lahir_peserta }}</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>';

                $html1 = '<table>
                        <tr>
                            <td>Username</td>
                            <td>: <b>{{ username_peserta }}</b></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td>: <b>{{ password_peserta }}</b></td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>';
                $html2 = '<p><center>Akun peserta PPDB ini digunakan untuk pendaftaran<br />PPDB ke sekolah jenjang berikutnya melalui laman: <br /><b>https://ppdb.lampungtengahkab.go.id</b></center></p>';

                $html = str_replace('{{ nama_peserta }}', $pd->nama, $html);
                $html = str_replace('{{ nisn_peserta }}', $pd->nisn, $html);
                $html = str_replace('{{ nik_peserta }}', $pd->nik, $html);
                $html = str_replace('{{ sekolah_asal_peserta }}', $pd->nama_sekolah_asal, $html);
                $html = str_replace('{{ npsn_asal_peserta }}', $pd->npsn_asal, $html);
                $html = str_replace('{{ tempat_lahir_peserta }}', $pd->tempat_lahir, $html);
                $html = str_replace('{{ tanggal_lahir_peserta }}', $pd->tanggal_lahir, $html);

                $html1 = str_replace('{{ username_peserta }}', $pd->username, $html1);
                $html1 = str_replace('{{ password_peserta }}', $pd->acc_reg, $html1);

                $kop = '<table border="0">
                    <tr>
                        <td width="17%" rowspan="4"><img src="https://ppdb.esline.id/favicon/apple-icon-120x120.png" style="width: 70px;" alt="Logo"></td>
                        <td width="83%">DINAS PENDIDIKAN DAN KEBUDAYAAN</td>
                    </tr>
                    <tr>
                        <td width="83%">KABUPATEN LAMPUNG TENGAH</td>
                    </tr>
                    <tr>
                        <td width="83%">PENERIMAAN PESERTA DIDIK BARU (PPDB)</td>
                    </tr>
                    <tr>
                        <td width="83%">TAHUN PELAJARAN 2024/2025</td>
                    </tr>
                </table>';
                $pdf = new TcpdfFpdi('P', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

                // Load HTML content
                $pdf->AddPage();
                $pdf->SetFont('times', 'B', 12);
                $pdf->MultiCell(180, 10, $kop, 0, 'C', false, 1, 20, null, true, 0, true);
                $pdf->MultiCell(180, 10, '<hr />', 0, 'C', false, 1, 20, null, true, 0, true);
                // $pdf->Cell(200, 10, 'KARTU AKUN PPDB KAB. LAMPUNG TENGAH TAHUN 2024/2025', 0, 1, 'C');
                $pdf->Ln(10);
                $pdf->SetFont('times', 'N', 12);
                $pdf->MultiCell(180, 10, '<h4>DATA PESERTA DIDIK</h4>', 0, 'L', false, 1, 20, null, true, 0, true);
                $pdf->MultiCell(180, 10, $html, 0, 'L', false, 1, 20, null, true, 0, true);
                $pdf->Ln(10);
                $pdf->MultiCell(180, 10, '<h4>AKUN PESERTA PPDB</h4>', 0, 'L', false, 1, 20, null, true, 0, true);
                $pdf->MultiCell(180, 10, $html1, 0, 'L', false, 1, 20, null, true, 0, true);
                $pdf->Ln(20);
                $pdf->MultiCell(180, 10, $html2, 0, 'C', false, 1, 20, null, true, 0, true);
                $pdf->Ln(20);
                $pdf->MultiCell(70, 20, "PANITIA PPDB DINAS,", 0, 'L', false, 1, 130, null, true, 0, true);
                $pdf->Ln(10);
                $pdf->MultiCell(70, 20, $user->data->nama, 0, 'L', false, 1, 130, null, true, 0, true);

                // $pdf->WriteHTML($html);

                // Output PDF
                $dir = FCPATH . "uploads/temp";
                $filename = 'Akun_PPDB_' . $pd->nisn . '.pdf';
                $fileName = $dir . '/' . $filename;
                $pdf->Output($fileName, 'F'); // Generate and save to temporary file

                sleep(2);

                $fileContent = file_get_contents($fileName);
                $base64Data = base64_encode($fileContent);
                unlink($fileName); // Delete the temporary file

                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Akun Berhasil Didownload.";
                $response->data = $base64Data;
                $response->filename = $filename;
                return json_encode($response);
                // } else {
                //     $response = new \stdClass;
                //     $response->status = 400;
                //     $response->message = "Gagal mengenerate data.";
                //     return json_encode($response);
                // }
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
