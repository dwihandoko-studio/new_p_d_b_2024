<div class="col-lg-12">
    <?php if ((int)$data->status_pendaftaran === 2) { ?>
        <div class="card text-white bg-primary">
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">No Pendaftaran :</span><strong><?= $data->kode_pendaftaran ?></strong></li>
                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Jalur :</span><strong><?= $data->via_jalur ?></strong></li>
                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Nama Peserta :</span><strong><?= $data->nama_peserta ?></strong></li>
                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">NISN :</span><strong><?= $data->nisn_peserta ?></strong></li>
                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Tanggal Lahir :</span><strong><?= $data->tanggal_lahir_peserta ?></strong></li>
                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Sekolah Asal :</span><strong><?= $data->nama_sekolah_asal ?></strong></li>
                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">NPSN Asal :</span><strong><?= $data->npsn_sekolah_asal ?></strong></li>
                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Sekolah Tujuan :</span><strong><?= $data->nama_sekolah_tujuan ?></strong></li>
                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">NPSN Tujuan :</span><strong><?= $data->npsn_sekolah_tujuan ?></strong></li>
                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Jarak Domisili :</span><strong><?= round($data->jarak_domisili, 3) ?> Km</strong></li>
            </ul>
            <div class="mb-5 mt-5" style="padding-left: 20px; padding-right: 20px;">
                <span class="mb-5 mt-5" style="font-size: 1rem;">
                    <center>Anda dinyatakan <b>LOLOS</b> pada seleksi PPDB Tahun Ajaran 2024/2025 di : <br /><b><?= $data->nama_sekolah_tujuan ?></b> Melalui Jalur <b><?= $data->via_jalur ?></b>. <br />Selanjutnya silahkan melakukan konfirmasi dan daftar ulang ke Sekolah Tujuan <br>sesuai jadwal yang telah ditentukan.</center>
                </span>
            </div>
        </div>
    <?php } else { ?>
        <?php if ((int)$data->status_pendaftaran === 3) { ?>
            <div class="card text-white bg-danger">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between"><span class="mb-0">No Pendaftaran :</span><strong><?= $data->kode_pendaftaran ?></strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Jalur :</span><strong><?= $data->via_jalur ?></strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Nama Peserta :</span><strong><?= $data->nama_peserta ?></strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span class="mb-0">NISN :</span><strong><?= $data->nisn_peserta ?></strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Tanggal Lahir :</span><strong><?= $data->tanggal_lahir_peserta ?></strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Sekolah Asal :</span><strong><?= $data->nama_sekolah_asal ?></strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span class="mb-0">NPSN Asal :</span><strong><?= $data->npsn_sekolah_asal ?></strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Sekolah Tujuan :</span><strong><?= $data->nama_sekolah_tujuan ?></strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span class="mb-0">NPSN Tujuan :</span><strong><?= $data->npsn_sekolah_tujuan ?></strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Jarak Domisili :</span><strong><?= round($data->jarak_domisili, 3) ?> Km</strong></li>
                </ul>
                <div class="mb-5 mt-5" style="padding-left: 20px; padding-right: 20px;">
                    <span class="mb-5 mt-5" style="font-size: 1rem;">
                        <center>Anda dinyatakan <b>TIDAK LOLOS</b> seleksi PPDB Tahun Ajaran 2024/2025 di : <br /><b><?= $data->nama_sekolah_tujuan ?></b> Melalui Jalur <b><?= $data->via_jalur ?></b>.</center><br />
                        <center>Silahkan untuk dapat mendaftar ke sekolah yang kuotanya masih belum tercukupi.</center><br />
                        <center>
                            <div class="text-center">
                                <a href="<?= base_url('home') . '/pelimpahan?j=' . $data->bentuk_pendidikan_id . '&k=' . $data->kec_peserta ?>" class="btn btn-secondary btn-block">Data Sekolah Masih Mempunyai Kuota</a>
                            </div>
                        </center>
                    </span>
                </div>
            </div>
        <?php } else { ?>
            <div class="mb-5 mt-5" style="padding-left: 20px; padding-right: 20px;">
                <span class="mb-5 mt-5" style="font-size: 1rem;">
                    <center>Menunggu Hasil Pengumuman.</center>
                </span>
            </div>
        <?php } ?>
    <?php } ?>
</div>