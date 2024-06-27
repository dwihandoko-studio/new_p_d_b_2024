<?= $this->extend('t-ppdb/sek/index'); ?>

<?= $this->section('content'); ?>
<?php $dokument = json_decode($data->lampiran); ?>
<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Data Pendaftar</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?= $koreg ?></a></li>
            </ol>
        </div>
        <div class="row">
            <form id="formValidasiData" class="formValidasiData" action="./validasi" method="post">
                <input type="hidden" id="_id" name="_id" value="<?= $data->id ?>" />
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
                                        <div class="col-12 mt-2 ">
                                            <button type="button" onclick="aksiPerubahanData('<?= $data->id ?>', '<?= $data->kode_pendaftaran ?>', '<?= $data->nama_peserta ?>')" class="btn btn-xs btn-info waves-effect waves-light"><i class="las la-edit font-size-16 align-middle me-2" style="font-size: 1.5rem !important;"></i> Layanan Perubahan Data Peserta</button>
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
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <div class="input-group   input-primary">
                                                    <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Poin Nilai Rapor</span>
                                                    <input type="text" id="_nilai_rata2" name="_nilai_rata2" class="form-control" value="<?= round($dokument->nilai_rata_rapor, 3) ?>" readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Poin Prestasi</span>
                                                <input type="text" id="_point_prestasi" name="_point_prestasi" class="form-control" value="<?= $dokument->nilai_tambahan ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                <?php if (isset($dokument->nilai_prestasi)) { ?>
                    <?php if ($dokument->nilai_prestasi) { ?>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Total Poin</span>
                                            <input type="text" id="_total_point_prestasi" name="_total_point_prestasi" class="form-control" value="<?= round($dokument->nilai_prestasi, 3) ?>" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>

                <?php if (isset($riwayat_perubahan_data)) { ?>
                    <?= $this->include('sek/ppdb/rekap/riwayat_perubahan_data'); ?>
                <?php } ?>

                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <h4 class="card-title">Validasi Data & Dokumen <?= $data->via_jalur == "SWASTA" ? 'Sekolah ' . ucwords(strtolower($data->via_jalur)) : 'Jalur ' . ucwords(strtolower($data->via_jalur)) ?></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h4>Kesesuaian Data Dan Kepemilikan Dokumen Persyaratan :</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-responsive-sm">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th colspan="2">Data / Dokumen</th>
                                                    <th>Isian Peserta</th>
                                                    <th>Validasi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1.</td>
                                                    <td colspan="2">Data Peserta</td>
                                                    <td>Diatas</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="_data_peserta" name="_data_peserta" value="ya">
                                                            <label class="form-check-label" for="_data_peserta">
                                                                Sesuai
                                                            </label>
                                                        </div>
                                                        <!-- <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="_data_peserta_no" name="_data_peserta" value="tidak">
                                                            <label class="form-check-label" for="_data_peserta_no">
                                                                Tidak
                                                            </label>
                                                        </div> -->
                                                    </td>
                                                </tr>
                                                <?php $number = 2; ?>
                                                <?php if (isset($dokument->prestasi_dimiliki)) { ?>
                                                    <?php if ($dokument->prestasi_dimiliki) { ?>
                                                        <?php if ($dokument->prestasi_dimiliki == "akademik" || $dokument->prestasi_dimiliki == "nonakademik") { ?>
                                                            <?php $number += 1; ?>
                                                            <tr>
                                                                <td>2.</td>
                                                                <td colspan="2">Data Prestasi</td>
                                                                <td>Diatas</td>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" id="_data_prestasi" name="_data_prestasi" value="ya">
                                                                        <label class="form-check-label" for="_data_prestasi">
                                                                            Sesuai
                                                                        </label>
                                                                    </div>
                                                                    <!-- <div class="form-check">
                                                                        <input class="form-check-input" type="radio" id="_data_prestasi_no" name="_data_prestasi" value="tidak">
                                                                        <label class="form-check-label" for="_data_prestasi_no">
                                                                            Tidak
                                                                        </label>
                                                                    </div> -->
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>

                                                <?php if (isset($dokument->dokumen)) { ?>
                                                    <?php if (count($dokument->dokumen) > 0) { ?>
                                                        <?php foreach ($dokument->dokumen as $key => $value) { ?>
                                                            <tr>
                                                                <td><?= $key + $number ?>.</td>
                                                                <td colspan="2"><?= getTitleDokumenPersyaratan($value->key) ?></td>
                                                                <td><?= (int)$value->value == 1 ? 'Ada' : 'Tidak ada' ?></td>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" id="_<?= $value->key ?>" name="_<?= $value->key ?>" name="gridRadios" value="ya">
                                                                        <label class="form-check-label" for="_<?= $value->key ?>">
                                                                            Sesuai
                                                                        </label>
                                                                    </div>
                                                                    <!-- <div class="form-check">
                                                                        <input class="form-check-input" type="radio" id="_<?= $value->key ?>_no" name="_<?= $value->key ?>" name="gridRadios" value="tidak">
                                                                        <label class="form-check-label" for="_<?= $value->key ?>_no">
                                                                            Tidak
                                                                        </label>
                                                                    </div> -->
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
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
                                    <button type="button" onclick="aksiPerubahanData('<?= $data->id ?>', '<?= $data->kode_pendaftaran ?>', '<?= replaceTandaBacaPetik($data->nama_peserta) ?>')" class="btn btn-block btn-xs btn-info waves-effect waves-light"><i class="las la-edit font-size-16 align-middle me-2" style="font-size: 1.5rem !important;"></i> Layanan Perubahan Data Peserta</button>
                                </div>
                                <div class="col-4 mb-2">
                                    <button type="button" onclick="aksiTolak('<?= $data->id ?>', '<?= $data->kode_pendaftaran ?>', '<?= replaceTandaBacaPetik($data->nama_peserta) ?>')" class="btn btn-block btn-xs btn-danger waves-effect waves-light"><i class="las la-expand-arrows-alt font-size-16 align-middle me-2" style="font-size: 1.5rem !important;"></i> Tolak Verifikasi</button>
                                </div>
                                <div class="col-4 mb-2">
                                    <button type="submit" class="btn btn-block btn-xs btn-primary waves-effect waves-light"><i class="las la-tasks font-size-16 align-middle me-2" style="font-size: 1.5rem !important;"></i> Verifikasi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
    $(document).on('click', '.lihatPetanya', function(e) {
        // const dataId = e.getAttribute('data-id');
        const url = this.dataset.id;

        // Open the URL in a new tab
        window.open(url, '_blank');
    });

    function validateForm(formElement) {
        const selectedDatapeserta = document.querySelector('input[type="radio"][name^="_data_peserta"]:checked');

        if (!(selectedDatapeserta)) {

            Swal.fire(
                'Peringatan!',
                "Silahkan pilih validasi data peserta.",
                'warning'
            ).then((valRes) => {});
            return false;
        }
        <?php if (isset($dokument->prestasi_dimiliki)) { ?>
            <?php if ($dokument->prestasi_dimiliki) { ?>
                <?php if ($dokument->prestasi_dimiliki == "akademik" || $dokument->prestasi_dimiliki == "nonakademik") { ?>
                    const selectedDataprestasi = document.querySelector('input[type="radio"][name^="_data_prestasi"]:checked');

                    if (!(selectedDataprestasi)) {

                        Swal.fire(
                            'Peringatan!',
                            "Silahkan pilih validasi data prestasi.",
                            'warning'
                        ).then((valRes) => {});
                        return false;
                    }
                <?php } ?>
            <?php } ?>
        <?php } ?>
        <?php if (isset($dokument->dokumen)) { ?>
            <?php if (count($dokument->dokumen) > 0) { ?>
                <?php foreach ($dokument->dokumen as $key => $value) { ?>
                    const selectedD<?= $value->key ?> = document.querySelector('input[type="radio"][name^="_<?= $value->key ?>"]:checked');

                    if (!(selectedD<?= $value->key ?>)) {
                        Swal.fire(
                            'Peringatan!',
                            "Silahkan pilih validasi <?= getTitleDokumenPersyaratan($value->key) ?>.",
                            'warning'
                        ).then((valRes) => {});
                        return false;
                    }
                <?php } ?>
            <?php } ?>
        <?php } ?>

        return true;
    }

    const form = document.getElementById('formValidasiData');
    if (form) {
        form.addEventListener('submit', function(event) { // Prevent default form submission

            event.preventDefault();
            if (validateForm(this)) {
                const nama = this.querySelector('#_nama_peserta').value;
                Swal.fire({
                    title: 'Verifikasi Peserta : ' + nama,
                    text: "Saya menyatakan dengan sesungguhnya, bahwa data dan dokumen persyaratan pendaftaran telah sesuai.",
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Sesuai'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "./verifikasi",
                            type: 'POST',
                            data: $(this).serialize(),
                            dataType: 'JSON',
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Sedang loading ...',
                                    text: 'Please wait while we process your action.',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
                            },
                            complete: function() {},
                            success: function(resul) {

                                if (resul.status !== 200) {
                                    if (resul.status !== 201) {
                                        if (resul.status === 401) {
                                            Swal.fire(
                                                'Failed!',
                                                resul.message,
                                                'warning'
                                            ).then((valRes) => {
                                                reloadPage();
                                            });
                                        } else {
                                            Swal.fire(
                                                'GAGAL!',
                                                resul.message,
                                                'warning'
                                            );
                                        }
                                    } else {
                                        Swal.fire(
                                            'Peringatan!',
                                            resul.message,
                                            'success'
                                        ).then((valRes) => {
                                            reloadPage();
                                        })
                                    }
                                } else {
                                    Swal.fire(
                                        'BERHASIL!',
                                        resul.message,
                                        'success'
                                    ).then((valRes) => {
                                        reloadPage(resul.url);
                                    })
                                }
                            },
                            error: function() {
                                Swal.fire(
                                    'PERINGATAN!',
                                    "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                                    'warning'
                                );
                            }
                        });
                    }
                });
            }
        });
    }

    function aksiTolak(id, koreg, nama) {

        Swal.fire({
            title: 'Apakah anda yakin ingin menolak verifikasi pendaftaran ini?',
            text: "Tolak verifikasi pendaftaran: " + nama,
            showCancelButton: true,
            icon: 'question',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Lanjutkan!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "./formTolak",
                    type: 'POST',
                    data: {
                        id: id,
                        koreg: koreg,
                        nama: nama
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Sedang loading...',
                            text: 'Please wait while we process your action.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    complete: function() {},
                    success: function(response) {
                        if (response.status == 200) {
                            Swal.close();
                            $('#content-tolakModalLabel').html('KETERANGAN PENOLAKAN VERIFIKASI');
                            $('.content-tolakBodyModal').html(response.data);
                            $('.content-tolakModal').modal({
                                backdrop: 'static',
                                keyboard: false,
                            });
                            $('.content-tolakModal').modal('show');
                        } else {
                            Swal.fire(
                                'Peringatan!',
                                response.message,
                                'warning'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'PERINGATAN!',
                            "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                            'warning'
                        );
                    }
                });
            }
        });
    }

    function aksiPerubahanData(id, koreg, nama) {
        Swal.fire({
            title: 'Apakah anda yakin ingin melakukan perubahan data pendaftaran peserta ini?',
            text: "Perubahan data pendaftaran: " + nama,
            showCancelButton: true,
            icon: 'question',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Lanjutkan!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "./formPerubahan",
                    type: 'POST',
                    data: {
                        id: id,
                        koreg: koreg,
                        nama: nama
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Sedang loading...',
                            text: 'Please wait while we process your action.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    complete: function() {},
                    success: function(response) {
                        if (response.status == 200) {
                            Swal.close();
                            $('#content-editModalLabel').html('LAYANAN PERUBAHAN DATA PENDAFTARAN');
                            $('.content-editBodyModal').html(response.data);
                            $('.content-editModal').modal({
                                backdrop: 'static',
                                keyboard: false,
                            });
                            $('.content-editModal').modal('show');
                        } else {
                            Swal.fire(
                                'Peringatan!',
                                response.message,
                                'warning'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'PERINGATAN!',
                            "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                            'warning'
                        );
                    }
                });
            }
        });
    }

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
<style>
    .lihatPetanya {
        background-color: #407d4a !important;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .lihatPetanya:hover {
        background-color: #d653c1 !important;
    }
</style>
<?= $this->endSection(); ?>