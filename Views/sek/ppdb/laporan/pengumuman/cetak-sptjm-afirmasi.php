<?php ob_start();
// var_dump(FCPATH . "temp/");die;
// include APPPATH . "Libraries/phpqrcode/qrlib.php";
// session_start();
// $tempdir = FCPATH . "temp/"; //Nama folder tempat menyimpan file qrcode
// if (!file_exists($tempdir)) //Buat folder bername temp
// 	mkdir($tempdir);

//isi qrcode jika di scan
// $siswa = json_decode($data->details);
// $codeContents = base_url('web/home/pengumumanpeserta') . '?sekolah=' . $data->id;

//simpan file kedalam temp
//nilai konfigurasi Frame di bawah 4 tidak direkomendasikan

// QRcode::png($codeContents, $tempdir . $data->id . '.png', QR_ECLEVEL_M, 4);

$qrCode = "data:image/png;base64," . base64_encode(file_get_contents('https://qrcode.esline.id/generate?data=' . base_url() . '/home/detail_sekolah?d=' . $sekolah->sekolah_id . '&choe=UTF-8'));

?>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<!-- <link rel="stylesheet" href="https://layanan.disdikbud.lampungtengahkab.go.id/assets/css/bootstrap.min.css"> -->
<!-- <link rel="stylesheet" href="<?= base_url('new-assets'); ?>/assets/vendor/bootstrap/dist/bootstrap.min.css"> -->
<link rel="shortcut icon" href="https://ppdb.lampungtengahkab.go.id/favicon/apple-icon-76x76.png">

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
    <div style="border: 0;">
        <div style="max-width: 100%; padding-top: 12px; padding-bottom: 5px; padding-left: 10px; padding-right: 8px;">
            <table width="100%" style="border: solid #cbd4dd; font-size: 12px">
                <tr>
                    <td colspan="5" width="10%" style="border:none;">
                        <img class="img" src="<?= base_url('favicon/android-icon-144x144.png') ?>" ec="H" style="width: 30mm; background-color: white; color: black;">
                    </td>
                    <td style="text-align: center;">
                        <span style="margin-top: 8px; font-size: 20px;">PEMERERINTAH KABUPATEN LAMPUNG TENGAH</span><br>
                        <span style="margin-top: 8px; font-size: 18px;">DINAS PENDIDIKAN DAN KEBUDAYAAN</span><br>
                        <span style="margin-top: 8px; font-size: 20px;"><?= $sekolah->nama ?></span><br>
                        <span style="margin-top: 8px; font-size: 14;"><?= $sekolah->npsn ?> - TAHUN PELAJARAN 2024/2025</span>
                    </td>
                </tr>
                <!-- <tr style="margin-top: 0px; margin-bottom: 0px;padding-top: 0px; padding-bottom: 0px;">
                    <td style="text-align: center;margin-top: 0px; margin-bottom: 0px; padding-top: 0px; padding-bottom: 0px;">
                        KABUPATEN LAMPUNG TENGAH
                    </td>
                </tr>
                <tr style="margin-top: 0px; margin-bottom: 0px;padding-top: 0px; padding-bottom: 0px;">
                    <td style="text-align: center;margin-top: 0px; margin-bottom: 0px; padding-top: 0px; padding-bottom: 0px;">
                        PROVINSI LAMPUNG
                    </td>
                </tr>
                <tr style="margin-top: 0px; margin-bottom: 0px;padding-top: 0px; padding-bottom: 0px;">
                    <td style="text-align: center;margin-top: 0px; margin-bottom: 0px; padding-top: 0px; padding-bottom: 0px;">
                        TAHUN AJARAN 2024/2025
                    </td>
                </tr> -->
            </table>
        </div>

        <!-- kolom atas -->
        <div style="max-width: 100%; padding-left: 20px; padding-right: 20px; text-align: center; align-items: center;">
            <center></center>
            <h4>SURAT PERTANGGUNGJAWABAN MUTLAK<br>
                PENDAFTARAN PESERTA DIDIK BARU (PPDB)<br>
                JALUR AFIRMASI<br>
                TAHUN PELAJARAN 2024/2025</h4>
            </center>
        </div>

        <div style="max-width: 100%; padding-left: 20px; padding-right: 20px;">
            <p>Saya yang bertanda tangan dibawah ini :</p>
            <p>Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ..............................</p>
            <p>NIP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ..............................</p>
            <p>Jabatan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ...............................</p>
            <p>Satuan Pendidikan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <?= $sekolah->nama ?>.</p>
            <p>NPSN &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= $sekolah->npsn ?>.</p>
            <p>Dengan ini saya menyatakan bahwa :</p>
            <ol>
                <li>Proses kegiatan PPDB dilakukan secara daring, mengacu pada peraturan yang telah ditetapkan, Pelaksanaan PPDB secara transparan, akuntable, Non Diskriminatif dan Berkeadilan.</li>
                <li>Seleksi proses penerimaan peserta didik baru TA. 2024/2025 Jalur Afirmasi dilaksanakan sesuai dengan peraturan yang telah di tetapkan dan dapat di pertanggungjawabkan.</li>
                <li>Data Peserta PPDB TA. 2024/2025 Jalur Afirmasi yang terlampir pada surat ini, dinyatakan lulus dan di terima di sekolah.</li>
            </ol>
            <p style="text-align:justify;">Demikian Surat Pernyataan Tanggung Jawab Mutlak ini dibuat dengan sebenarnya dan penuh tanggung jawab. Apabila di kemudian hari ternyata data PPDB TA. 2024/2025 yang telah Lulus ini tidak benar, maka saya siap menerima sanksi secara hukum yang berlaku.</p><br><br>
        </div>
        <div style="max-width: 100%; padding-left: 20px; padding-right: 20px;">
            <table width="100%" style="border: 0; ">
                <tr style=" font-size: 14px;">
                    <td>
                        <img class="img" src="<?= $qrCode ?>" ec="H" style="width: 20mm; background-color: white; color: black;">
                    </td>
                    <td style="text-align: left; padding-bottom: 10px; padding-top: 10px; font-size: 14px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td>
                        &nbsp;&nbsp;
                    </td>
                    <td>
                        &nbsp;&nbsp;
                    </td>
                    <td>
                        &nbsp;&nbsp;
                    </td>
                    <td style="text-align: left; padding-left: 10px; padding-bottom: 10px; padding-top: 10px; font-size: 14px;">
                        Lampung Tengah, .... Juni 2024<br>
                        Yang membuat,<br><br><br><br><br>
                        materai<br><br><br><br>
                        <u>.............................</u><br>
                        NIP. .............................
                    </td>
                </tr>
            </table>
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
$dompdf->setPaper('SPTJM', 'portrait');
$dompdf->render();
$dompdf->stream("SPTJM_AFIRMASI_" . $sekolah->npsn . ".pdf", array("Attachment" => false));
exit(0);
?>