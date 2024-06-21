<?= $this->extend('t-ppdb/sek/index'); ?>

<?= $this->section('content'); ?>
<?php $dokument = json_decode($data->lampiran); ?>
<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Data Detail Pendaftaran Tertolak</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?= $koreg ?></a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="card-title">Data Peserta</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" style="margin-top: 30px;">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Kode Pendaftaran</span>
                                            <input type="text" class="form-control" id="_kode_pendaftaran" name="_kode_pendaftaran" value="<?= $data->kode_pendaftaran ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Nama</span>
                                            <input type="text" class="form-control" id="_nama_peserta" name="_nama_peserta" value="<?= $data->nama_peserta ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">NISN</span>
                                            <input type="text" class="form-control" id="_nisn_peserta" name="_nisn_peserta" value="<?= $data->nisn_peserta ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">NIK</span>
                                            <input type="text" class="form-control" value="<?= $data->nik ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">KK</span>
                                            <input type="text" class="form-control" value="<?= $data->no_kk ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Tempat Lahir </span>
                                            <input type="text" class="form-control" value="<?= $data->tempat_lahir_peserta ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Tanggal lahir </span>
                                            <input type="text" class="form-control" value="<?= tgl_indo($data->tanggal_lahir_peserta) ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Nama Ibu</span>
                                            <input type="text" class="form-control" value="<?= $data->nama_ibu_kandung ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Jenis Kelamin</span>
                                            <input type="text" class="form-control" value="<?= $data->jenis_kelamin_peserta ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Sekolah Asal</span>
                                            <input type="text" class="form-control" value="<?= $data->nama_sekolah_asal ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">NPSN Asal</span>
                                            <input type="text" class="form-control" value="<?= $data->npsn_sekolah_asal ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Alamat Domisili</span>
                                            <input type="text" class="form-control" value="<?= $data->alamat_jalan ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Provinsi</span>
                                            <input type="text" class="form-control" value="<?= getNameProvinsi($data->kab_peserta) ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Kabupaten</span>
                                            <input type="text" class="form-control" value="<?= getNameKabupaten($data->kab_peserta) ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Kecamatan</span>
                                            <input type="text" class="form-control" value="<?= getNameKecamatan($data->kec_peserta) ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Desa/Kelurahan</span>
                                            <input type="text" class="form-control" value="<?= getNameKelurahan($data->kel_peserta) ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Dusun/Lingkungan</span>
                                            <input type="text" class="form-control" value="<?= getNameDusun($data->dusun_peserta) ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Koordinat</span>
                                            <input type="text" class="form-control" value="<?= $data->lat_long_peserta ?>" readonly />
                                            <span class="input-group-text lihatPetanya" data-id="https://www.google.com/maps/@<?= $data->lat_long_peserta ?>,17z?q=<?= $data->lat_long_peserta ?>(Target Location)">Lihat</span>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Email</span>
                                            <input type="email" class="form-control" id="_email" name="_email" placeholder="example@example.com" value="<?= $data->email ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">No HP</span>
                                            <input type="phone" class="form-control" id="_nohp" name="_nohp" placeholder="628xxxxxxxxxxx" value="<?= $data->nohp ?>" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12 mb-2">
                            <div class="input-group   input-primary">
                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Jarak Domisili</span>
                                <input type="text" class="form-control" value="<?= round($data->jarak_domisili, 3) . ' Km' ?>" readonly />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (isset($dokument->nilai_rapor)) { ?>
                <?php if ($dokument->nilai_rapor) { ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>Nilai Rapor 5 Semester :</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php if (isset($dokument->nilai_rapor->semester_1)) { ?>
                                        <?php if ($dokument->nilai_rapor->semester_1) { ?>
                                            <div class="col-6">
                                                <h4>Nilai Rapor Kelas 4 Semester 1 :</h4>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Pendidikan Agama</span>
                                                        <input type="number" id="__pa_1" name="__pa_1" class="form-control" value="<?= $dokument->nilai_rapor->semester_1->pa ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">PKn</span>
                                                        <input type="number" id="__pkn_1" name="__pkn_1" class="form-control" value="<?= $dokument->nilai_rapor->semester_1->pkn ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Bahasa Indonesia</span>
                                                        <input type="number" id="__bi_1" name="__bi_1" class="form-control" value="<?= $dokument->nilai_rapor->semester_1->bi ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">MTK</span>
                                                        <input type="number" id="__mtk_1" name="__mtk_1" class="form-control" value="<?= $dokument->nilai_rapor->semester_1->mtk ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">IPA</span>
                                                        <input type="number" id="__ipa_1" name="__ipa_1" class="form-control" value="<?= $dokument->nilai_rapor->semester_1->ipa ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">IPS</span>
                                                        <input type="number" id="__ips_1" name="__ips_1" class="form-control" value="<?= $dokument->nilai_rapor->semester_1->ips ?>" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (isset($dokument->nilai_rapor->semester_2)) { ?>
                                        <?php if ($dokument->nilai_rapor->semester_2) { ?>
                                            <div class="col-6">
                                                <h4>Nilai Rapor Kelas 4 Semester 2 :</h4>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Pendidikan Agama</span>
                                                        <input type="number" id="__pa_2" name="__pa_2" class="form-control" value="<?= $dokument->nilai_rapor->semester_2->pa ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">PKn</span>
                                                        <input type="number" id="__pkn_2" name="__pkn_2" class="form-control" value="<?= $dokument->nilai_rapor->semester_2->pkn ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Bahasa Indonesia</span>
                                                        <input type="number" id="__bi_2" name="__bi_2" class="form-control" value="<?= $dokument->nilai_rapor->semester_2->bi ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">MTK</span>
                                                        <input type="number" id="__mtk_2" name="__mtk_2" class="form-control" value="<?= $dokument->nilai_rapor->semester_2->mtk ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">IPA</span>
                                                        <input type="number" id="__ipa_2" name="__ipa_2" class="form-control" value="<?= $dokument->nilai_rapor->semester_2->ipa ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">IPS</span>
                                                        <input type="number" id="__ips_2" name="__ips_2" class="form-control" value="<?= $dokument->nilai_rapor->semester_2->ips ?>" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (isset($dokument->nilai_rapor->semester_3)) { ?>
                                        <?php if ($dokument->nilai_rapor->semester_3) { ?>
                                            <div class="col-6 mt-2">
                                                <h4>Nilai Rapor Kelas 5 Semester 1 :</h4>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Pendidikan Agama</span>
                                                        <input type="number" id="__pa_3" name="__pa_3" class="form-control" value="<?= $dokument->nilai_rapor->semester_3->pa ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">PKn</span>
                                                        <input type="number" id="__pkn_3" name="__pkn_3" class="form-control" value="<?= $dokument->nilai_rapor->semester_3->pkn ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Bahasa Indonesia</span>
                                                        <input type="number" id="__bi_3" name="__bi_3" class="form-control" value="<?= $dokument->nilai_rapor->semester_3->bi ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">MTK</span>
                                                        <input type="number" id="__mtk_3" name="__mtk_3" class="form-control" value="<?= $dokument->nilai_rapor->semester_3->mtk ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">IPA</span>
                                                        <input type="number" id="__ipa_3" name="__ipa_3" class="form-control" value="<?= $dokument->nilai_rapor->semester_3->ipa ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">IPS</span>
                                                        <input type="number" id="__ips_3" name="__ips_3" class="form-control" value="<?= $dokument->nilai_rapor->semester_3->ips ?>" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (isset($dokument->nilai_rapor->semester_4)) { ?>
                                        <?php if ($dokument->nilai_rapor->semester_4) { ?>
                                            <div class="col-6 mt-2">
                                                <h4>Nilai Rapor Kelas 5 Semester 2 :</h4>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Pendidikan Agama</span>
                                                        <input type="number" id="__pa_4" name="__pa_4" class="form-control" value="<?= $dokument->nilai_rapor->semester_4->pa ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">PKn</span>
                                                        <input type="number" id="__pkn_4" name="__pkn_4" class="form-control" value="<?= $dokument->nilai_rapor->semester_4->pkn ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Bahasa Indonesia</span>
                                                        <input type="number" id="__bi_4" name="__bi_4" class="form-control" value="<?= $dokument->nilai_rapor->semester_4->bi ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">MTK</span>
                                                        <input type="number" id="__mtk_4" name="__mtk_4" class="form-control" value="<?= $dokument->nilai_rapor->semester_4->mtk ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">IPA</span>
                                                        <input type="number" id="__ipa_4" name="__ipa_4" class="form-control" value="<?= $dokument->nilai_rapor->semester_4->ipa ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">IPS</span>
                                                        <input type="number" id="__ips_4" name="__ips_4" class="form-control" value="<?= $dokument->nilai_rapor->semester_4->ips ?>" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (isset($dokument->nilai_rapor->semester_5)) { ?>
                                        <?php if ($dokument->nilai_rapor->semester_5) { ?>
                                            <div class="col-6 mt-2">
                                                <h4>Nilai Rapor Kelas 6 Semester 1 :</h4>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Pendidikan Agama</span>
                                                        <input type="number" id="__pa_5" name="__pa_5" class="form-control" value="<?= $dokument->nilai_rapor->semester_5->pa ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">PKn</span>
                                                        <input type="number" id="__pkn_5" name="__pkn_5" class="form-control" value="<?= $dokument->nilai_rapor->semester_5->pkn ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Bahasa Indonesia</span>
                                                        <input type="number" id="__bi_5" name="__bi_5" class="form-control" value="<?= $dokument->nilai_rapor->semester_5->bi ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">MTK</span>
                                                        <input type="number" id="__mtk_5" name="__mtk_5" class="form-control" value="<?= $dokument->nilai_rapor->semester_5->mtk ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">IPA</span>
                                                        <input type="number" id="__ipa_5" name="__ipa_5" class="form-control" value="<?= $dokument->nilai_rapor->semester_5->ipa ?>" readonly />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">IPS</span>
                                                        <input type="number" id="__ips_5" name="__ips_5" class="form-control" value="<?= $dokument->nilai_rapor->semester_5->ips ?>" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (isset($dokument->nilai_rata_rapor)) { ?>
                        <?php if ($dokument->nilai_rata_rapor) { ?>
                            <!-- <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <div class="input-group   input-primary">
                                                    <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Nilai Rata-Rata</span>
                                                    <input type="text" id="_nilai_rata2" name="_nilai_rata2" class="form-control" value="<?= $dokument->nilai_rata_rapor ?>" readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <?php if (isset($dokument->prestasi_dimiliki)) { ?>
                <?php if ($dokument->prestasi_dimiliki) { ?>
                    <?php if ($dokument->prestasi_dimiliki == "akademik" || $dokument->prestasi_dimiliki == "nonakademik") { ?>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <?php if ($dokument->prestasi_dimiliki == "akademik") { ?>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h4 class="card-title">Prestasi Akademik</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 140px; min-width: 140px;min-width: 140px;">Kategori Prestasi</span>
                                                        <input type="text" class="form-control" value="<?= ucwords($dokument->prestasi_akademik->kategori) ?>" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 140px; min-width: 140px;min-width: 140px;">Tingkat Prestasi</span>
                                                        <input type="text" class="form-control" value="<?= ucwords($dokument->prestasi_akademik->tingkat) ?>" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 140px; min-width: 140px;min-width: 140px;">Penyelenggara Prestasi</span>
                                                        <input type="text" class="form-control" value="<?= ucwords($dokument->prestasi_akademik->penyelenggara) ?>" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 140px; min-width: 140px;min-width: 140px;">Juara Prestasi</span>
                                                        <input type="text" class="form-control" value="<?= ucwords($dokument->prestasi_akademik->juara) ?>" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if ($dokument->prestasi_dimiliki == "nonakademik") { ?>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h4 class="card-title">Prestasi Non Akademik</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 140px; min-width: 140px;min-width: 140px;">Kategori Prestasi</span>
                                                        <input type="text" class="form-control" value="<?= ucwords($dokument->prestasi_nonakademik->kategori) ?>" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 140px; min-width: 140px;min-width: 140px;">Tingkat Prestasi</span>
                                                        <input type="text" class="form-control" value="<?= ucwords($dokument->prestasi_nonakademik->tingkat) ?>" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 140px; min-width: 140px;min-width: 140px;">Penyelenggara Prestasi</span>
                                                        <input type="text" class="form-control" value="<?= ucwords($dokument->prestasi_nonakademik->penyelenggara) ?>" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <div class="input-group   input-primary">
                                                        <span class="input-group-text" style="width: 140px; min-width: 140px;min-width: 140px;">Juara Prestasi</span>
                                                        <input type="text" class="form-control" value="<?= ucwords($dokument->prestasi_nonakademik->juara) ?>" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12 mb-2">
                            <div class="input-group   input-primary">
                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Keterangan Penolakan</span>
                                <textarea rows="10" class="form-control" readonly><?= $data->keterangan_penolakan ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 mb-2">
                                <a href="<?= base_url('sek/ppdb/rekap/lolos') ?>" class="btn btn-block btn-xs btn-primary waves-effect waves-light"><i class="las la-undo font-size-16 align-middle me-2" style="font-size: 1.5rem !important;"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="content-tolakModal" class="modal fade content-tolakModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-tolakModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="content-tolakBodyModal">
            </div>
        </div>
    </div>
</div>
<div id="content-editModal" class="modal fade content-editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 90vw !important;">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-editModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="content-editBodyModal">
            </div>
        </div>
    </div>
</div>
<div id="content-mapModal" class="modal fade content-mapModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-mapModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="content-mapBodyModal">
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script>
    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    $(document).ready(function() {

    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.js"></script>
<?= $this->endSection(); ?>