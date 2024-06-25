<?php $qrCode = "data:image/png;base64," . base64_encode(file_get_contents('https://qrcode.esline.id/generate?data=' . base_url() . '/home/detail_sekolah?d=' . $data->id . '&choe=UTF-8')); ?>
<div style="border: 2px  dashed #cbd4dd;">
    <div style="max-width: 100%; padding-left: 10px; padding-right: 8px;">
        <p>LAMPIRAN 1<br>
            DATA PESERTA YANG LULUS PPDB JALUR <?= strtoupper($jalur) ?> TA. 2024/2025<br>
            KABUPATEN LAMPUNG TENGAH<br><br>
            Satuan Pendidikan : <?= $sekolah->nama ?><br>
            NPSN : <?= $sekolah->npsn ?></p>
    </div>

    <div style="max-width: 100%; padding-top: 5px; padding-left: 10px; padding-right: 8px;">
        <h4>JALUR <?= strtoupper($jalur) ?></h4>
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
                                    <?= $value->ket ?? "" ?>
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
                    <!--1. Pada saat pengumuman PPDB 2023/2024. Bagi peserta PPDB YANG TIDAK LOLOS di sekolah tujuan, langsung dapat mendaftar<br>-->
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