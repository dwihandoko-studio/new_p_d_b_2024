<?php ob_start();
// var_dump(FCPATH . "temp/");die;
// include APPPATH . "Libraries/phpqrcode/qrlib.php";
// session_start();
// $tempdir = FCPATH . "temp/"; //Nama folder tempat menyimpan file qrcode
// if (!file_exists($tempdir)) //Buat folder bername temp
// 	mkdir($tempdir);

//isi qrcode jika di scan
// $siswa = json_decode($data->details);
// $codeContents = base_url('web/home/pengumumanpeserta') . '?sekolah=' . $sekolah->id;

//simpan file kedalam temp
//nilai konfigurasi Frame di bawah 4 tidak direkomendasikan

// QRcode::png($codeContents, $tempdir . $sekolah->id . '.png', QR_ECLEVEL_M, 4);
$qrCode = "data:image/png;base64," . base64_encode(file_get_contents('https://qrcode.esline.id/generate?data=' . base_url() . '/home/detail_sekolah?d=' . $sekolah->sekolah_id . '&choe=UTF-8'));

?>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<!-- <link rel="stylesheet" href="https://layanan.disdikbud.lampungtengahkab.go.id/assets/css/bootstrap.min.css"> -->
<!-- <link rel="stylesheet" href="<?= base_url('new-assets'); ?>/assets/vendor/bootstrap/dist/bootstrap.min.css"> -->
<link rel="shortcut icon" href="<?= base_url(); ?>/favicon/apple-icon-76x76.png">

<!DOCTYPE html>

<html>

<head>
    <title>SPTJM PESERTA PPDB - <?= $sekolah->nama ?></title>
    <style>
        @page {
            margin: 0px;
        }

        body {
            margin: 20px;
        }
    </style>
</head>

<body>
    <div style="border: 2px  dashed #cbd4dd;">
        <div style="max-width: 100%; padding-left: 10px; padding-right: 8px;">
            <p>LAMPIRAN 1<br>
                DATA PESERTA YANG LULUS PPDB SEKOLAH SWASTA TA. 2024/2025<br>
                KABUPATEN LAMPUNG TENGAH<br><br>
                Satuan Pendidikan : <?= $sekolah->nama ?><br>
                NPSN : <?= $sekolah->npsn ?></p>
        </div>

        <div style="max-width: 100%; padding-top: 5px; padding-left: 10px; padding-right: 8px;">
            <table width="100%" style="border: solid #cbd4dd; font-size: 12px;">
                <thead>
                    <tr>
                        <th style="font-size: 12px; text-align: left;">No</th>
                        <th style="font-size: 12px; text-align: left;">Nama Peserta</th>
                        <th style="font-size: 12px; text-align: left;">NISN</th>
                        <th style="font-size: 12px; text-align: left;">No Pendaftaran</th>
                        <th style="font-size: 12px; text-align: left;">Jalur PPDB</th>
                        <th style="font-size: 12px; text-align: left;">NPSN Asal Sekolah</th>
                        <th style="font-size: 12px; text-align: left;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($lolos)) {
                        if (count($lolos) > 0) {
                            $no = 1;
                            foreach ($lolos as $key => $value) { ?>
                                <tr>
                                    <td style="font-size: 12px">
                                        <?= $key + 1 ?>
                                    </td>
                                    <td style="font-size: 12px">
                                        <?= $value->nama_peserta ?>
                                    </td>
                                    <td style="font-size: 12px">
                                        <?= $value->nisn_peserta ?>
                                    </td>
                                    <td style="font-size: 10px">
                                        <?= $value->kode_pendaftaran ?>
                                    </td>
                                    <td style="font-size: 12px">
                                        <?= $value->via_jalur ?>
                                    </td>
                                    <td style="font-size: 12px">
                                        <?= $value->npsn_sekolah_asal ?>
                                    </td>
                                    <td style="font-size: 12px">
                                        LULUS
                                    </td>
                                </tr>
                            <?php
                                $no++;
                            } ?>

                        <?php } else { ?>
                            <tr>
                                <td colspan="6" style="text-align: center; align-items: center;">Tidak ada peserta.</td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6" style="text-align: center; align-items: center;">Tidak ada peserta.</td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>

        <!-- kolom informasi -->
        <div style="max-width: 100%; padding-top: 5px; padding-bottom: 12px;  padding-left: 10px; padding-right: 8px;">
            <table width="100%" style="border: solid #cbd4dd; font-size: 12px">
                <tr>
                    <td style="text-align: left; padding-left: 10px; padding-bottom: 10px; padding-top: 10px;">
                        <img class="img" src="<?= $qrCode ?>" ec="H" style="width: 30mm; background-color: white; color: black;">
                        <!--<b>INFORMASI</b><br>-->
                        <!--1. Pada saat pengumuman PPDB 2024/2025. Bagi peserta PPDB YANG TIDAK LOLOS di sekolah tujuan, langsung dapat mendaftar<br>-->
                        <!--   melalui PPDB Dalam Jaringan ke Sekolah Terdekat yang Jumlah Kuotanya belum terpenuhi sampai tanggal 30 Juni 2023.<br>-->
                        <!--2. Peserta yang tidak lolos dan kemudian mendaftar kembali melalui PPDB Dalam Jaringan, akan otomatis dapat melihat Sekolah-Sekolah<br>-->
                        <!--   yang Kuotanya Belum Tercukupi.<br>-->
                        <!--3. Panitia PPDB Sekolah tidak lagi wajib untuk melakukan verifikasi (Sistem Otomatis) dan Peserta yang mendaftar ke sekolah tersebut, otomatis diterima di sekolah tersebut.<br>-->
                        <!--4. Panitia PPDB Sekolah, yang Jumlah Kuota Kesiapan di sekolahannya belum tercukupi, dapat membantu Peserta Orang Tua/Wali yang tidak Lolos pada pengumuman PPDB untuk mendaftarkan di sekolahannya.<br>-->
                        <!--5. Peserta yang tidak lolos pada pengumuman PPDB, apabila tidak melakukan pendaftaran, maka akan dipetakan oleh Panitia PPDB Dinas ke sekolah-sekolah terdekat yang kuotanya belum terpenuhi.-->
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div style="border: 2px  dashed #cbd4dd;">
        <div style="max-width: 100%; padding-left: 10px; padding-right: 8px;">
            <p>LAMPIRAN 2<br>
                DATA PESERTA YANG TIDAK LULUS PPDB SEKOLAH SWASTA TA. 2024/2025<br>
                KABUPATEN LAMPUNG TENGAH<br><br>
                Satuan Pendidikan : <?= $sekolah->nama ?><br>
                NPSN : <?= $sekolah->npsn ?></p>
        </div>

        <div style="max-width: 100%; padding-top: 5px; padding-left: 10px; padding-right: 8px;">
            <table width="100%" style="border: solid #cbd4dd; font-size: 12px;">
                <thead>
                    <tr>
                        <th style="font-size: 12px; text-align: left;">No</th>
                        <th style="font-size: 12px; text-align: left;">Nama Peserta</th>
                        <th style="font-size: 12px; text-align: left;">NISN</th>
                        <th style="font-size: 12px; text-align: left;">No Pendaftaran</th>
                        <th style="font-size: 12px; text-align: left;">Jalur PPDB</th>
                        <th style="font-size: 12px; text-align: left;">NPSN Asal Sekolah</th>
                        <th style="font-size: 12px; text-align: left;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($gagal)) {
                        if (count($gagal) > 0) {
                            $no = 1;
                            foreach ($gagal as $key => $valgal) { ?>
                                <tr>
                                    <td style="font-size: 12px">
                                        <?= $key + 1 ?>
                                    </td>
                                    <td style="font-size: 12px">
                                        <?= $valgal->nama_peserta ?>
                                    </td>
                                    <td style="font-size: 12px">
                                        <?= $valgal->nisn_peserta ?>
                                    </td>
                                    <td style="font-size: 10px">
                                        <?= $valgal->kode_pendaftaran ?>
                                    </td>
                                    <td style="font-size: 12px">
                                        <?= $valgal->via_jalur ?>
                                    </td>
                                    <td style="font-size: 12px">
                                        <?= $valgal->npsn_sekolah_asal ?>
                                    </td>
                                    <td style="font-size: 12px">
                                        TIDAK LULUS
                                    </td>
                                </tr>
                            <?php
                                $no++;
                            } ?>

                        <?php } else { ?>
                            <tr>
                                <td colspan="6" style="text-align: center; align-items: center;">Tidak ada peserta.</td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6" style="text-align: center; align-items: center;">Tidak ada peserta.</td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>

        <!-- kolom informasi -->
        <div style="max-width: 100%; padding-top: 5px; padding-bottom: 12px;  padding-left: 10px; padding-right: 8px;">
            <table width="100%" style="border: solid #cbd4dd; font-size: 12px">
                <tr>
                    <td style="text-align: left; padding-left: 10px; padding-bottom: 10px; padding-top: 10px;">
                        <img class="img" src="<?= $qrCode ?>" ec="H" style="width: 30mm; background-color: white; color: black;">
                        <!--<b>INFORMASI</b><br>-->
                        <!--1. Pada saat pengumuman PPDB 2024/2025. Bagi peserta PPDB YANG TIDAK LOLOS di sekolah tujuan, langsung dapat mendaftar<br>-->
                        <!--   melalui PPDB Dalam Jaringan ke Sekolah Terdekat yang Jumlah Kuotanya belum terpenuhi sampai tanggal 30 Juni 2023.<br>-->
                        <!--2. Peserta yang tidak lolos dan kemudian mendaftar kembali melalui PPDB Dalam Jaringan, akan otomatis dapat melihat Sekolah-Sekolah<br>-->
                        <!--   yang Kuotanya Belum Tercukupi.<br>-->
                        <!--3. Panitia PPDB Sekolah tidak lagi wajib untuk melakukan verifikasi (Sistem Otomatis) dan Peserta yang mendaftar ke sekolah tersebut, otomatis diterima di sekolah tersebut.<br>-->
                        <!--4. Panitia PPDB Sekolah, yang Jumlah Kuota Kesiapan di sekolahannya belum tercukupi, dapat membantu Peserta Orang Tua/Wali yang tidak Lolos pada pengumuman PPDB untuk mendaftarkan di sekolahannya.<br>-->
                        <!--5. Peserta yang tidak lolos pada pengumuman PPDB, apabila tidak melakukan pendaftaran, maka akan dipetakan oleh Panitia PPDB Dinas ke sekolah-sekolah terdekat yang kuotanya belum terpenuhi.-->
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
<?php
$html = ob_get_clean();
require_once APPPATH . "Libraries/vendor/autoload.php";

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("SPTJM_LAMPIRAN_SWASTA_" . $sekolah->npsn . ".pdf", array("Attachment" => false));
exit(0);
?>