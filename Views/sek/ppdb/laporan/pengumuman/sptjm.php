<?php $qrCode = "data:image/png;base64," . base64_encode(file_get_contents('https://qrcode.esline.id/generate?data=' . base_url() . '/home/detail_sekolah?d=' . $data->id . '&choe=UTF-8')); ?>
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
        </table>
    </div>

    <!-- kolom atas -->
    <div style="max-width: 100%; padding-left: 20px; padding-right: 20px; text-align: center; align-items: center;">
        <center></center>
        <h4>SURAT PERTANGGUNGJAWABAN MUTLAK<br>
            PENDAFTARAN PESERTA DIDIK BARU (PPDB)<br>
            JALUR <?= strtoupper($jalur) ?><br>
            TAHUN PELAJARAN 2024/2025</h4>
        </center>
    </div>

    <div style="max-width: 100%; padding-left: 20px; padding-right: 20px;">
        <p>Saya yang bertanda tangan dibawah ini :</p>
        <p>Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= (isset($sekolah->nama_panitia)) ? $sekolah->nama_panitia : "............................." ?>.</p>
        <!-- <p>NIP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= (isset($sekolah->nama_panitia)) ? $sekolah->nama_panitia : "............................." ?>.</p> -->
        <p>Jabatan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;<?= getNameJabatanPpdb($sekolah->jabatan_ppdb) ?>.</p>
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
                    <u><?= (isset($sekolah->nama_panitia)) ? $sekolah->nama_panitia : "............................." ?></u><br>
                    <!-- NIP. <?= (isset($sekolah->nama_panitia)) ? $sekolah->nama_panitia : "............................." ?> -->
                </td>
            </tr>
        </table>
    </div>
</div>