<?php $dokument = json_decode($data->lampiran); ?>
<form id="formPerubahanData" class="formPerubahanData" action="./perubahanSave" method="post">
    <input type="hidden" id="_id_perubahan" name="_id_perubahan" value="<?= $data->id ?>" />
    <input type="hidden" id="_nama_perubahan" name="_nama_perubahan" value="<?= replaceTandaBacaPetik($data->nama_peserta) ?>" />
    <div class="modal-body">
        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">Data Yang Mengajukan</h4>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="input-group   input-primary">
                                <span class="input-group-text" style="width: 150px; min-width: 150px;min-width: 150px;">Nama yang mengajukan</span>
                                <input type="text" class="form-control" id="_pengaju" name="_pengaju" value="" required />
                            </div>
                        </div>
                        <div class="col-12 mt-3 mb-2">
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Status :</label>
                                <div class="col-sm-9">
                                    <select class="w-100" id="_status_pengaju" name="_status_pengaju" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Orang Tua / Wali">Orang Tua / Wali</option>
                                        <option value="Peserta Didik">Peserta Didik</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Data yang diajukan :</label>
                                <div class="col-sm-9">
                                    <select class="w-100" id="_perubahan_pengaju" name="_perubahan_pengaju" onchange="changePerubahanData(this)" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="domisili">Domisili Peserta</option>
                                        <?php if ($data->via_jalur === "PRESTASI") { ?>
                                            <option value="prestasi">Inputan Prestasi</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="perubahan_data_domisili" class="card perubahan_data_domisili" style="display: none;">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title">Data Peserta</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="margin-top: 20px;">
                        <div class="row">
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
                        </div>
                        <div class="col-12" style="margin-top: 20px;">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="card-title">Data Domisili</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Provinsi</label>
                                        <div class="col-sm-9">
                                            <select class="w-100" style="width: 100%;" id="_prov" name="_prov" onchange="changeProv(this)" required>
                                                <option value="">-- Pilih --</option>
                                                <?php if (isset($props)) { ?>
                                                    <?php if (count($props) > 0) { ?>
                                                        <?php foreach ($props as $key => $value) { ?>
                                                            <option value="<?= $value->id ?>" <?= substr($value->id, 0, 2) === substr($data->kab_peserta, 0, 2) ? ' selected' : "" ?>><?= $value->nama ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Kabupaten</label>
                                        <div class="col-sm-9">
                                            <select class="w-100" style="width: 100%;" id="_kab" name="_kab" onchange="changeKab(this)" required>
                                                <option value="">-- Pilih --</option>
                                                <?php if (isset($kabs)) { ?>
                                                    <?php if (count($kabs) > 0) { ?>
                                                        <?php foreach ($kabs as $key => $value) { ?>
                                                            <option value="<?= $value->id ?>" <?= $value->id === $data->kab_peserta ? ' selected' : "" ?>><?= $value->nama ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Kecamatan</label>
                                        <div class="col-sm-9">
                                            <select class="w-100" style="width: 100%;" id="_kec" name="_kec" onchange="changeKec(this)" required>
                                                <option value="">-- Pilih --</option>
                                                <?php if (isset($kecs)) { ?>
                                                    <?php if (count($kecs) > 0) { ?>
                                                        <?php foreach ($kecs as $key => $value) { ?>
                                                            <option value="<?= $value->id ?>" <?= $value->id === $data->kec_peserta ? ' selected' : "" ?>><?= $value->nama ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Desa/Kelurahan</label>
                                        <div class="col-sm-9">
                                            <select class="w-100" style="width: 100%;" id="_kel" name="_kel" onchange="changeKel(this)" required>
                                                <option value="">-- Pilih --</option>
                                                <?php if (isset($kels)) { ?>
                                                    <?php if (count($kels) > 0) { ?>
                                                        <?php foreach ($kels as $key => $value) { ?>
                                                            <option value="<?= $value->id ?>" <?= $value->id === $data->kel_peserta ? ' selected' : "" ?>><?= $value->nama ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Dusun</label>
                                        <div class="col-sm-9">
                                            <select class="w-100" style="width: 100%;" id="_dusun" name="_dusun" onchange="changeDus(this)" required>
                                                <option value="">-- Pilih --</option>
                                                <?php if (isset($dusuns)) { ?>
                                                    <?php if (count($dusuns) > 0) { ?>
                                                        <?php foreach ($dusuns as $key => $value) { ?>
                                                            <option value="<?= $value->id ?>" <?= $value->id === $data->dusun_peserta ? ' selected' : "" ?>><?= $value->nama ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php $lat_long = explode(",", $data->lat_long_peserta); ?>
                                <div class="col-6">
                                    <div class="mb-3 row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-9">
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-3 col-form-label">Lintang</label>
                                                        <div class="col-sm-9">
                                                            <div class="input-group   input-primary">
                                                                <span class="input-group-text">Lat</span>
                                                                <input type="text" class="form-control" id="_lintang" name="_lintang" value="<?= $lat_long[0] ?>" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-3 col-form-label">Bujur</label>
                                                        <div class="col-sm-9">
                                                            <div class="input-group   input-primary">
                                                                <span class="input-group-text">Long</span>
                                                                <input type="text" class="form-control" id="_bujur" name="_bujur" value="<?= $lat_long[1] ?>" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <button type="button" onclick="ambilKoordinat(this);" style="width: 100%;" class="btn btn-sm btn-info waves-effect waves-light">Ambil Koordinat</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="perubahan_data_prestasi" class="card perubahan_data_prestasi" style="display: none;">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title">Data Peserta</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="margin-top: 20px;">
                        <div class="row">
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
                        </div>
                    </div>
                    <div class="col-12" style="margin-top: 20px;">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title">Data Prestasi</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-12" style="margin-top: 20px;">
                        <div class="row">
                            <?php if (isset($dokument->nilai_rapor)) { ?>
                                <?php if ($dokument->nilai_rapor) { ?>
                                    <div class="col-6">
                                        <h4>Nilai Rapor Kelas 4 Semester 1 :</h4>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Pendidikan Agama</span>
                                                <input type="number" id="__pa_1" name="__pa_1" class="form-control" value="<?= $dokument->nilai_rapor->semester_1->pa ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">PKn</span>
                                                <input type="number" id="__pkn_1" name="__pkn_1" class="form-control" value="<?= $dokument->nilai_rapor->semester_1->pkn ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Bahasa Indonesia</span>
                                                <input type="number" id="__bi_1" name="__bi_1" class="form-control" value="<?= $dokument->nilai_rapor->semester_1->bi ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">MTK</span>
                                                <input type="number" id="__mtk_1" name="__mtk_1" class="form-control" value="<?= $dokument->nilai_rapor->semester_1->mtk ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">IPA</span>
                                                <input type="number" id="__ipa_1" name="__ipa_1" class="form-control" value="<?= $dokument->nilai_rapor->semester_1->ipa ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">IPS</span>
                                                <input type="number" id="__ips_1" name="__ips_1" class="form-control" value="<?= $dokument->nilai_rapor->semester_1->ips ?>" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h4>Nilai Rapor Kelas 4 Semester 2 :</h4>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Pendidikan Agama</span>
                                                <input type="number" id="__pa_2" name="__pa_2" class="form-control" value="<?= $dokument->nilai_rapor->semester_2->pa ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">PKn</span>
                                                <input type="number" id="__pkn_2" name="__pkn_2" class="form-control" value="<?= $dokument->nilai_rapor->semester_2->pkn ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Bahasa Indonesia</span>
                                                <input type="number" id="__bi_2" name="__bi_2" class="form-control" value="<?= $dokument->nilai_rapor->semester_2->bi ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">MTK</span>
                                                <input type="number" id="__mtk_2" name="__mtk_2" class="form-control" value="<?= $dokument->nilai_rapor->semester_2->mtk ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">IPA</span>
                                                <input type="number" id="__ipa_2" name="__ipa_2" class="form-control" value="<?= $dokument->nilai_rapor->semester_2->ipa ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">IPS</span>
                                                <input type="number" id="__ips_2" name="__ips_2" class="form-control" value="<?= $dokument->nilai_rapor->semester_2->ips ?>" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <h4>Nilai Rapor Kelas 5 Semester 1 :</h4>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Pendidikan Agama</span>
                                                <input type="number" id="__pa_3" name="__pa_3" class="form-control" value="<?= $dokument->nilai_rapor->semester_3->pa ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">PKn</span>
                                                <input type="number" id="__pkn_3" name="__pkn_3" class="form-control" value="<?= $dokument->nilai_rapor->semester_3->pkn ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Bahasa Indonesia</span>
                                                <input type="number" id="__bi_3" name="__bi_3" class="form-control" value="<?= $dokument->nilai_rapor->semester_3->bi ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">MTK</span>
                                                <input type="number" id="__mtk_3" name="__mtk_3" class="form-control" value="<?= $dokument->nilai_rapor->semester_3->mtk ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">IPA</span>
                                                <input type="number" id="__ipa_3" name="__ipa_3" class="form-control" value="<?= $dokument->nilai_rapor->semester_3->ipa ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">IPS</span>
                                                <input type="number" id="__ips_3" name="__ips_3" class="form-control" value="<?= $dokument->nilai_rapor->semester_3->ips ?>" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <h4>Nilai Rapor Kelas 5 Semester 2 :</h4>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Pendidikan Agama</span>
                                                <input type="number" id="__pa_4" name="__pa_4" class="form-control" value="<?= $dokument->nilai_rapor->semester_4->pa ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">PKn</span>
                                                <input type="number" id="__pkn_4" name="__pkn_4" class="form-control" value="<?= $dokument->nilai_rapor->semester_4->pkn ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Bahasa Indonesia</span>
                                                <input type="number" id="__bi_4" name="__bi_4" class="form-control" value="<?= $dokument->nilai_rapor->semester_4->bi ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">MTK</span>
                                                <input type="number" id="__mtk_4" name="__mtk_4" class="form-control" value="<?= $dokument->nilai_rapor->semester_4->mtk ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">IPA</span>
                                                <input type="number" id="__ipa_4" name="__ipa_4" class="form-control" value="<?= $dokument->nilai_rapor->semester_4->ipa ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">IPS</span>
                                                <input type="number" id="__ips_4" name="__ips_4" class="form-control" value="<?= $dokument->nilai_rapor->semester_4->ips ?>" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <h4>Nilai Rapor Kelas 6 Semester 1 :</h4>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Pendidikan Agama</span>
                                                <input type="number" id="__pa_5" name="__pa_5" class="form-control" value="<?= $dokument->nilai_rapor->semester_5->pa ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">PKn</span>
                                                <input type="number" id="__pkn_5" name="__pkn_5" class="form-control" value="<?= $dokument->nilai_rapor->semester_5->pkn ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Bahasa Indonesia</span>
                                                <input type="number" id="__bi_5" name="__bi_5" class="form-control" value="<?= $dokument->nilai_rapor->semester_5->bi ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">MTK</span>
                                                <input type="number" id="__mtk_5" name="__mtk_5" class="form-control" value="<?= $dokument->nilai_rapor->semester_5->mtk ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">IPA</span>
                                                <input type="number" id="__ipa_5" name="__ipa_5" class="form-control" value="<?= $dokument->nilai_rapor->semester_5->ipa ?>" required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">IPS</span>
                                                <input type="number" id="__ips_5" name="__ips_5" class="form-control" value="<?= $dokument->nilai_rapor->semester_5->ips ?>" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <h4>&nbsp;</h4>
                                        <div class="mb-3">
                                            <div class="input-group   input-primary">
                                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Nilai Rata-Rata</span>
                                                <input type="text" id="_nilai_rata2" name="_nilai_rata2" class="form-control" value="" readonly required />
                                            </div>
                                        </div>
                                        <div class="mb-3">&nbsp;
                                        </div>
                                        <div class="mb-3">&nbsp;
                                        </div>
                                        <div class="mb-3">&nbsp;
                                        </div>
                                        <div class="mb-3">
                                            <button type="button" onclick="hitungNilaiRatarata()" class="btn btn-sm btn-primary waves-effect waves-light"><i class="las la-clipboard-list font-size-16 align-middle me-2"></i> HITUNG NILAI</button> &nbsp;&nbsp;
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <?php if (isset($dokument->prestasi_dimiliki)) { ?>
                                <?php if ($dokument->prestasi_dimiliki) { ?>
                                    <div class="col-9 col-12 mt-4">
                                        <h4>Jenis Prestasi yang Dimiliki :</h4>
                                        <div class="input-group mb-3">
                                            <select class="default-select form-control wide" style="width: 100%;" id="_prestasi_dimiliki" name="_prestasi_dimiliki" onchange="changeJenisPrestasi(this)" required>
                                                <option value="">-- Pilih --</option>
                                                <option value="akademik" <?= ($dokument->prestasi_dimiliki === "akademik") ? ' selected' : '' ?>>Prestasi Akademik</option>
                                                <option value="nonakademik" <?= ($dokument->prestasi_dimiliki === "nonakademik") ? ' selected' : '' ?>>Prestasi Non Akademik</option>
                                                <option value="tidakada" <?= ($dokument->prestasi_dimiliki === "tidakada") ? ' selected' : '' ?>>Tidak Ada</option>
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 prestasi-akademik-content" id="prestasi-akademik-content" style="display: <?= ($dokument->prestasi_dimiliki === "akademik") ? 'block' : 'none' ?>;">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="input-group mb-3">
                                                            <label for="_kec" class="col-form-label">Kategori:</label>
                                                            <select onchange="kategoriAkademik(this)" class="default-select form-control wide" style="width: 100%;" id="_kategori_akademik" name="_kategori_akademik">
                                                                <option value="">-- Pilih --</option>
                                                                <option value="sains" <?= isset($dokument->prestasi_akademik) ? ($dokument->prestasi_akademik->kategori === "sains" ? ' selected' : '') : '' ?>>Sains</option>
                                                                <option value="teknologi" <?= isset($dokument->prestasi_akademik) ? ($dokument->prestasi_akademik->kategori === "teknologi" ? ' selected' : '') : '' ?>>Teknologi</option>
                                                                <option value="riset" <?= isset($dokument->prestasi_akademik) ? ($dokument->prestasi_akademik->kategori === "riset" ? ' selected' : '') : '' ?>>Riset</option>
                                                                <option value="inovasi" <?= isset($dokument->prestasi_akademik) ? ($dokument->prestasi_akademik->kategori === "inovasi" ? ' selected' : '') : '' ?>>Inovasi</option>
                                                            </select>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <label for="_kec" class="col-form-label">Tingkat:</label>
                                                            <select onchange="tingkatAkademik(this)" class="default-select form-control wide" style="width: 100%;" id="_tingkat_akademik" name="_tingkat_akademik">
                                                                <option value="">-- Pilih --</option>
                                                                <option value="kecamatan" <?= isset($dokument->prestasi_akademik) ? ($dokument->prestasi_akademik->tingkat === "kecamatan" ? ' selected' : '') : '' ?>>Tingkat Kecamatan</option>
                                                                <option value="kabupaten" <?= isset($dokument->prestasi_akademik) ? ($dokument->prestasi_akademik->tingkat === "kabupaten" ? ' selected' : '') : '' ?>>Tingkat Kabupaten / Kota</option>
                                                                <option value="provinsi" <?= isset($dokument->prestasi_akademik) ? ($dokument->prestasi_akademik->tingkat === "provinsi" ? ' selected' : '') : '' ?>>Tingkat Provinsi</option>
                                                                <option value="nasional" <?= isset($dokument->prestasi_akademik) ? ($dokument->prestasi_akademik->tingkat === "nasional" ? ' selected' : '') : '' ?>>Tingkat Nasional</option>
                                                                <option value="internasional" <?= isset($dokument->prestasi_akademik) ? ($dokument->prestasi_akademik->tingkat === "internasional" ? ' selected' : '') : '' ?>>Tingkat Internasional</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group mb-3">
                                                            <label for="_kec" class="col-form-label">Penyelenggara:</label>
                                                            <select onchange="penyelenggaraAkademik(this)" class="default-select form-control wide" style="width: 100%;" id="_penyelenggara_akademik" name="_penyelenggara_akademik">
                                                                <option value="">-- Pilih --</option>
                                                                <option value="pusat" <?= isset($dokument->prestasi_akademik) ? ($dokument->prestasi_akademik->penyelenggara === "pusat" ? ' selected' : '') : '' ?>>Pemerintah Pusat</option>
                                                                <option value="daerah" <?= isset($dokument->prestasi_akademik) ? ($dokument->prestasi_akademik->penyelenggara === "daerah" ? ' selected' : '') : '' ?>>Pemerintah Daerah</option>
                                                                <option value="bumn" <?= isset($dokument->prestasi_akademik) ? ($dokument->prestasi_akademik->penyelenggara === "bumn" ? ' selected' : '') : '' ?>>Badan Usaha Milik Negara (BUMN)</option>
                                                                <option value="bumd" <?= isset($dokument->prestasi_akademik) ? ($dokument->prestasi_akademik->penyelenggara === "bumd" ? ' selected' : '') : '' ?>>Badan Usaha Milik Daerah (BUMD)</option>
                                                                <option value="lainnya" <?= isset($dokument->prestasi_akademik) ? ($dokument->prestasi_akademik->penyelenggara === "lainnya" ? ' selected' : '') : '' ?>>Lembaga Lainnya</option>
                                                            </select>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <label for="_kec" class="col-form-label">Juara:</label>
                                                            <select onchange="juaraAkademik(this)" class="default-select form-control wide" style="width: 100%;" id="_juara_akademik" name="_juara_akademik">
                                                                <option value="">-- Pilih --</option>
                                                                <option value="1" <?= isset($dokument->prestasi_akademik) ? ($dokument->prestasi_akademik->juara === "1" ? ' selected' : '') : '' ?>>Juara 1</option>
                                                                <option value="2" <?= isset($dokument->prestasi_akademik) ? ($dokument->prestasi_akademik->juara === "2" ? ' selected' : '') : '' ?>>Juara 2</option>
                                                                <option value="3" <?= isset($dokument->prestasi_akademik) ? ($dokument->prestasi_akademik->juara === "3" ? ' selected' : '') : '' ?>>Juara 3</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 prestasi-nonakademik-content" id="prestasi-nonakademik-content" style="display: <?= ($dokument->prestasi_dimiliki === "nonakademik") ? 'block' : 'none' ?>;">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="input-group mb-3">
                                                            <label for="_kec" class="col-form-label">Kategori:</label>
                                                            <select onchange="kategoriNonakademik(this)" class="default-select form-control wide" style="width: 100%;" id="_kategori_nonakademik" name="_kategori_nonakademik">
                                                                <option value="">-- Pilih --</option>
                                                                <option value="senibudaya" <?= isset($dokument->prestasi_nonakademik) ? ($dokument->prestasi_nonakademik->kategori === "senibudaya" ? ' selected' : '') : '' ?>>Seni Budaya</option>
                                                                <option value="olahraga" <?= isset($dokument->prestasi_nonakademik) ? ($dokument->prestasi_nonakademik->kategori === "olahraga" ? ' selected' : '') : '' ?>>Olah Raga</option>
                                                            </select>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <label for="_kec" class="col-form-label">Tingkat:</label>
                                                            <select onchange="tingkatNonakademik(this)" class="default-select form-control wide" style="width: 100%;" id="_tingkat_nonakademik" name="_tingkat_nonakademik">
                                                                <option value="">-- Pilih --</option>
                                                                <option value="kecamatan" <?= isset($dokument->prestasi_nonakademik) ? ($dokument->prestasi_nonakademik->tingkat === "kecamatan" ? ' selected' : '') : '' ?>>Tingkat Kecamatan</option>
                                                                <option value="kabupaten" <?= isset($dokument->prestasi_nonakademik) ? ($dokument->prestasi_nonakademik->tingkat === "kabupaten" ? ' selected' : '') : '' ?>>Tingkat Kabupaten / Kota</option>
                                                                <option value="provinsi" <?= isset($dokument->prestasi_nonakademik) ? ($dokument->prestasi_nonakademik->tingkat === "provinsi" ? ' selected' : '') : '' ?>>Tingkat Provinsi</option>
                                                                <option value="nasional" <?= isset($dokument->prestasi_nonakademik) ? ($dokument->prestasi_nonakademik->tingkat === "nasional" ? ' selected' : '') : '' ?>>Tingkat Nasional</option>
                                                                <option value="internasional" <?= isset($dokument->prestasi_nonakademik) ? ($dokument->prestasi_nonakademik->tingkat === "internasional" ? ' selected' : '') : '' ?>>Tingkat Internasional</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group mb-3">
                                                            <label for="_kec" class="col-form-label">Penyelenggara:</label>
                                                            <select onchange="penyelenggaraNonakademik(this)" class="default-select form-control wide" style="width: 100%;" id="_penyelenggara_nonakademik" name="_penyelenggara_nonakademik">
                                                                <option value="">-- Pilih --</option>
                                                                <option value="pusat" <?= isset($dokument->prestasi_nonakademik) ? ($dokument->prestasi_nonakademik->penyelenggara === "pusat" ? ' selected' : '') : '' ?>>Pemerintah Pusat</option>
                                                                <option value="daerah" <?= isset($dokument->prestasi_nonakademik) ? ($dokument->prestasi_nonakademik->penyelenggara === "daerah" ? ' selected' : '') : '' ?>>Pemerintah Daerah</option>
                                                                <option value="bumn" <?= isset($dokument->prestasi_nonakademik) ? ($dokument->prestasi_nonakademik->penyelenggara === "bumn" ? ' selected' : '') : '' ?>>Badan Usaha Milik Negara (BUMN)</option>
                                                                <option value="bumd" <?= isset($dokument->prestasi_nonakademik) ? ($dokument->prestasi_nonakademik->penyelenggara === "bumd" ? ' selected' : '') : '' ?>>Badan Usaha Milik Daerah (BUMD)</option>
                                                                <option value="lainnya" <?= isset($dokument->prestasi_nonakademik) ? ($dokument->prestasi_nonakademik->penyelenggara === "lainnya" ? ' selected' : '') : '' ?>>Lembaga Lainnya</option>
                                                            </select>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <label for="_kec" class="col-form-label">Juara:</label>
                                                            <select onchange="juaraNonakademik(this)" class="default-select form-control wide" style="width: 100%;" id="_juara_nonakademik" name="_juara_nonakademik">
                                                                <option value="">-- Pilih --</option>
                                                                <option value="1" <?= isset($dokument->prestasi_nonakademik) ? ($dokument->prestasi_nonakademik->juara === "1" ? ' selected' : '') : '' ?>>Juara 1</option>
                                                                <option value="2" <?= isset($dokument->prestasi_nonakademik) ? ($dokument->prestasi_nonakademik->juara === "2" ? ' selected' : '') : '' ?>>Juara 2</option>
                                                                <option value="3" <?= isset($dokument->prestasi_nonakademik) ? ($dokument->prestasi_nonakademik->juara === "3" ? ' selected' : '') : '' ?>>Juara 3</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">SIMPAN PERUBAHAN</button>
    </div>
</form>
<script>
    function changeJenisPrestasi(event) {
        const selectedOption = event.value;
        if (selectedOption === "" || selectedOption === undefined) {
            $('.prestasi-akademik-content').css('display', 'none');
            $('.prestasi-nonakademik-content').css('display', 'none');
        } else {
            if (selectedOption === "akademik") {
                $('.prestasi-akademik-content').css('display', 'block');
                $('.prestasi-nonakademik-content').css('display', 'none');
            } else if (selectedOption === "nonakademik") {
                $('.prestasi-akademik-content').css('display', 'none');
                $('.prestasi-nonakademik-content').css('display', 'block');
            } else {
                $('.prestasi-akademik-content').css('display', 'none');
                $('.prestasi-nonakademik-content').css('display', 'none');
            }
        }
    }

    function kategoriAkademik(event) {
        const tingkatAkademikSelects = $('#_tingkat_akademik');
        tingkatAkademikSelects.empty();
        const penyelenggaraAkademikSelects = $('#_penyelenggara_akademik');
        penyelenggaraAkademikSelects.empty();
        const juaraAkademikSelects = $('#_juara_akademik');
        juaraAkademikSelects.empty();
        if (event.value === "" || event.value === undefined) {} else {
            tingkatAkademikSelects.append('<option value="">-- Pilih --</option>');
            tingkatAkademikSelects.append('<option value="kecamatan">Tingkat Kecamatan</option>');
            tingkatAkademikSelects.append('<option value="kabupaten">Tingkat Kabupaten / Kota</option>');
            tingkatAkademikSelects.append('<option value="provinsi">Tingkat Provinsi</option>');
            tingkatAkademikSelects.append('<option value="nasional">Tingkat Nasional</option>');
            tingkatAkademikSelects.append('<option value="internasional">Tingkat Internasional</option>');
        }
    }

    function tingkatAkademik(event) {
        const penyelenggaraAkademikSelects = $('#_penyelenggara_akademik');
        penyelenggaraAkademikSelects.empty();
        const juaraAkademikSelects = $('#_juara_akademik');
        juaraAkademikSelects.empty();
        if (event.value === "" || event.value === undefined) {} else {
            penyelenggaraAkademikSelects.append('<option value="">-- Pilih --</option>');
            penyelenggaraAkademikSelects.append('<option value="pusat">Pemerintah Pusat</option>');
            penyelenggaraAkademikSelects.append('<option value="daerah">Pemerintah Daerah</option>');
            penyelenggaraAkademikSelects.append('<option value="bumn">Badan Usaha Milik Negara (BUMN)</option>');
            penyelenggaraAkademikSelects.append('<option value="bumd">Badan Usaha Milik Daerah (BUMD)</option>');
            penyelenggaraAkademikSelects.append('<option value="lainnya">Lembaga Lainnya</option>');
        }
    }

    function penyelenggaraAkademik(event) {
        const juaraAkademikSelects = $('#_juara_akademik');
        juaraAkademikSelects.empty();
        if (event.value === "" || event.value === undefined) {} else {

            juaraAkademikSelects.append('<option value="">-- Pilih --</option>');
            juaraAkademikSelects.append('<option value="1">Juara 1</option>');
            juaraAkademikSelects.append('<option value="2">Juara 2</option>');
            juaraAkademikSelects.append('<option value="3">Juara 3</option>');
        }
    }

    function juaraAkademik(event) {}

    function kategoriNonakademik(event) {
        const tingkatNonAkademikSelects = $('#_tingkat_nonakademik');
        tingkatNonAkademikSelects.empty();
        const penyelenggaraNonakademikSelects = $('#_penyelenggara_nonakademik');
        penyelenggaraNonakademikSelects.empty();
        const juaraNonakademikSelects = $('#_juara_nonakademik');
        juaraNonakademikSelects.empty();
        if (event.value === "" || event.value === undefined) {} else {
            tingkatNonAkademikSelects.append('<option value="">-- Pilih --</option>');
            tingkatNonAkademikSelects.append('<option value="kecamatan">Tingkat Kecamatan</option>');
            tingkatNonAkademikSelects.append('<option value="kabupaten">Tingkat Kabupaten / Kota</option>');
            tingkatNonAkademikSelects.append('<option value="provinsi">Tingkat Provinsi</option>');
            tingkatNonAkademikSelects.append('<option value="nasional">Tingkat Nasional</option>');
            tingkatNonAkademikSelects.append('<option value="internasional">Tingkat Internasional</option>');
        }
    }

    function tingkatNonakademik(event) {
        const penyelenggaraNonakademikSelects = $('#_penyelenggara_nonakademik');
        penyelenggaraNonakademikSelects.empty();
        const juaraNonakademikSelects = $('#_juara_nonakademik');
        juaraNonakademikSelects.empty();
        if (event.value === "" || event.value === undefined) {} else {
            penyelenggaraNonakademikSelects.append('<option value="">-- Pilih --</option>');
            penyelenggaraNonakademikSelects.append('<option value="pusat">Pemerintah Pusat</option>');
            penyelenggaraNonakademikSelects.append('<option value="daerah">Pemerintah Daerah</option>');
            penyelenggaraNonakademikSelects.append('<option value="bumn">Badan Usaha Milik Negara (BUMN)</option>');
            penyelenggaraNonakademikSelects.append('<option value="bumd">Badan Usaha Milik Daerah (BUMD)</option>');
            penyelenggaraNonakademikSelects.append('<option value="lainnya">Lembaga Lainnya</option>');
        }
    }

    function penyelenggaraNonakademik(event) {
        const juaraNonakademikSelects = $('#_juara_nonakademik');
        juaraNonakademikSelects.empty();
        if (event.value === "" || event.value === undefined) {} else {

            juaraNonakademikSelects.append('<option value="">-- Pilih --</option>');
            juaraNonakademikSelects.append('<option value="1">Juara 1</option>');
            juaraNonakademikSelects.append('<option value="2">Juara 2</option>');
            juaraNonakademikSelects.append('<option value="3">Juara 3</option>');
        }
    }

    function juaraNonakademik(event) {}

    function hitungNilaiRatarata() {
        const inputElements = document.querySelectorAll('input[name^="__"]');
        let sum = 0;
        let numberOfInputs = 0;

        for (const input of inputElements) {
            if (!isNaN(input.value) && input.value !== "") {
                sum += parseFloat(input.value);
                numberOfInputs++;
            }
        }

        let average = numberOfInputs > 0 ? sum / numberOfInputs : 0;

        document.getElementById("_nilai_rata2").value = average.toFixed(2);
    }

    function ambilKoordinat(event) {
        var lat = document.getElementsByName('_lintang')[0].value;
        var long = document.getElementsByName('_bujur')[0].value;

        if (lat === "" || lat === undefined) {
            lat = "<?= $sek->lintang ?>";
        }
        if (long === "" || long === undefined) {
            long = "<?= $sek->bujur ?>";
        }

        $.ajax({
            url: "./location",
            type: 'POST',
            data: {
                lat: lat,
                long: long,
            },
            dataType: 'JSON',
            beforeSend: function() {
                Swal.fire({
                    title: 'Sedang Loading . . .',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(resul) {
                if (resul.status !== 200) {
                    Swal.fire(
                        'Failed!',
                        resul.message,
                        'warning'
                    );
                } else {
                    Swal.close();
                    $('#content-mapModalLabel').html('AMBIL LOKASI');
                    $('.content-mapBodyModal').html(resul.data);
                    $('.content-mapModal').modal({
                        backdrop: 'static',
                        keyboard: false,
                    });
                    $('.content-mapModal').modal('show');

                    var map = L.map("map_inits").setView([lat, long], 14);
                    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors | Supported By <a href="https://esline.id">Esline.id</a>'
                    }).addTo(map);

                    var lati = lat;
                    var longi = long;
                    var marker;

                    marker = L.marker({
                        lat: lat,
                        lng: long
                    }, {
                        draggable: true
                    }).addTo(map);
                    document.getElementById('_lat').value = lati;
                    document.getElementById('_long').value = longi;

                    var onDrag = function(e) {
                        var latlng = marker.getLatLng();
                        lati = latlng.lat;
                        longi = latlng.lng;
                        document.getElementById('_lat').value = latlng.lat;
                        document.getElementById('_long').value = latlng.lng;
                    };

                    var onClick = function(e) {
                        map.removeLayer(marker);
                        // map.off('click', onClick); //turn off listener for map click
                        marker = L.marker(e.latlng, {
                            draggable: true
                        }).addTo(map);
                        lati = e.latlng.lat;
                        longi = e.latlng.lng;
                        document.getElementById('_lat').value = lati;
                        document.getElementById('_long').value = longi;

                        // marker.on('drag', onDrag);
                    };
                    marker.on('drag', onDrag);
                    map.on('click', onClick);

                    setTimeout(function() {
                        map.invalidateSize();
                        // console.log("maps opened");
                        $("h6#title_map").css("display", "block");
                    }, 1000);

                }
            },
            error: function() {
                Swal.fire(
                    'Failed!',
                    "Trafik sedang penuh, silahkan ulangi beberapa saat lagi.",
                    'warning'
                );
            }
        });
    }

    function takedKoordinat() {
        const latitu = document.getElementsByName('_lat')[0].value;
        const longitu = document.getElementsByName('_long')[0].value;

        document.getElementById('_lintang').value = latitu;
        document.getElementById('_bujur').value = longitu;

        $('#content-mapModal').modal('hide');
    }

    function changePerubahanData(event) {
        if (event.value === "" || event.value === undefined) {} else {
            const perubahanDataPrestasi = document.getElementById('perubahan_data_prestasi');
            const perubahanDataDomisili = document.getElementById('perubahan_data_domisili');
            if (event.value === "domisili") {
                perubahanDataPrestasi.style.display = "none";
                perubahanDataDomisili.style.display = "block";
            } else {
                perubahanDataDomisili.style.display = "none";
                perubahanDataPrestasi.style.display = "block";
            }
        }
    }

    function changeProv(event) {
        const kabupatenSelect = $('#_kab');
        kabupatenSelect.empty(); // Clear existing options
        const kecamatanSelect = $('#_kec');
        kecamatanSelect.empty();
        const kelurahanSelect = $('#_kel');
        kelurahanSelect.empty();
        if (event.value === "" || event.value === undefined) {} else {
            $.ajax({
                url: "./refkab",
                type: 'POST',
                data: {
                    id: event.value,
                },
                dataType: "json",
                beforeSend: function() {
                    Swal.fire({
                        title: 'Sedang Loading . . .',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                complete: function() {},
                success: function(response) {
                    if (response.status == 200) {
                        Swal.close();
                        // Process and populate the kecamatan dropdown based on the response
                        const kabupatens = response.data; // Assuming response has 'data' key with kabupatens
                        kabupatenSelect.append('<option value="">  -- Pilih -- </option>');
                        kabupatens.forEach(kabupaten => {
                            const option = $('<option>').val(kabupaten.id).text(kabupaten.nama);
                            // if (kecamatan.id.startsWith(selectedKabId.substring(0, 6))) {
                            //     option.attr('selected', true);
                            // }
                            kabupatenSelect.append(option);
                        });
                    } else {
                        Swal.fire(
                            'Failed!',
                            "gagal mengambil data",
                            'warning'
                        );
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire(
                        'Failed!',
                        "gagal mengambil data (" + xhr.status.toString + ")",
                        'warning'
                    );
                }

            });
        }
    }

    function changeKab(event) {
        const kecamatanSelect = $('#_kec');
        kecamatanSelect.empty(); // Clear existing options
        const kelurahanSelect = $('#_kel');
        kelurahanSelect.empty();
        if (event.value === "" || event.value === undefined) {} else {
            $.ajax({
                url: "./refkec",
                type: 'POST',
                data: {
                    id: event.value,
                },
                dataType: "json",
                beforeSend: function() {
                    Swal.fire({
                        title: 'Sedang Loading . . .',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                complete: function() {},
                success: function(response) {
                    if (response.status == 200) {
                        Swal.close();
                        // Process and populate the kecamatan dropdown based on the response
                        const kecamatans = response.data; // Assuming response has 'data' key with kecamatans
                        kecamatanSelect.append('<option value="">  -- Pilih -- </option>');
                        kecamatans.forEach(kecamatan => {
                            const option = $('<option>').val(kecamatan.id).text(kecamatan.nama);
                            // if (kecamatan.id.startsWith(selectedKabId.substring(0, 6))) {
                            //     option.attr('selected', true);
                            // }
                            kecamatanSelect.append(option);
                        });
                    } else {
                        Swal.fire(
                            'Failed!',
                            "gagal mengambil data",
                            'warning'
                        );
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire(
                        'Failed!',
                        "gagal mengambil data (" + xhr.status.toString + ")",
                        'warning'
                    );
                }

            });
        }
    }

    function changeKec(event) {
        const kelurahanSelect = $('#_kel');
        kelurahanSelect.empty();
        if (event.value === "" || event.value === undefined) {} else {
            $.ajax({
                url: "./refkel",
                type: 'POST',
                data: {
                    id: event.value,
                },
                dataType: "json",
                beforeSend: function() {
                    Swal.fire({
                        title: 'Sedang Loading . . .',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                complete: function() {

                },
                success: function(response) {
                    if (response.status == 200) {
                        Swal.close();

                        // Process and populate the kecamatan dropdown based on the response
                        const kelurahans = response.data; // Assuming response has 'data' key with kelurahans
                        kelurahanSelect.append('<option value="">  -- Pilih -- </option>');
                        kelurahans.forEach(kelurahan => {
                            const option = $('<option>').val(kelurahan.id).text(kelurahan.nama);
                            // if (kecamatan.id.startsWith(selectedKabId.substring(0, 6))) {
                            //     option.attr('selected', true);
                            // }
                            kelurahanSelect.append(option);
                        });
                    } else {
                        Swal.fire(
                            'Failed!',
                            "gagal mengambil data",
                            'warning'
                        );
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire(
                        'Failed!',
                        "gagal mengambil data (" + xhr.status.toString + ")",
                        'warning'
                    );
                }

            });
        }
    }

    function changeKel(event) {}

    function changeDus(event) {}

    function validateLat(lat) {
        // Define the valid range for latitude and longitude in Indonesia
        const minLat = -11.0; // Southernmost point in Indonesia
        const maxLat = 6.0; // Northernmost point in Indonesia

        // Check if the latitude and longitude are within the valid range
        if (lat >= minLat && lat <= maxLat) {
            return true;
        } else {
            return false;
        }
    }

    function validateLong(lon) {
        const minLon = 95.0; // Westernmost point in Indonesia
        const maxLon = 141.0; // Easternmost point in Indonesia

        // Check if the latitude and longitude are within the valid range
        if (lon >= minLon && lon <= maxLon) {
            return true;
        } else {
            return false;
        }
    }

    $('#_status_pengaju').select2({
        dropdownParent: ".content-editBodyModal",
    });

    $('#_perubahan_pengaju').select2({
        dropdownParent: ".content-editBodyModal",
    });

    $('#_prov').select2({
        dropdownParent: ".content-editBodyModal",
    });

    $('#_kab').select2({
        dropdownParent: ".content-editBodyModal",
    });
    $('#_kec').select2({
        dropdownParent: ".content-editBodyModal",
    });
    $('#_kel').select2({
        dropdownParent: ".content-editBodyModal",
    });
    $('#_dusun').select2({
        dropdownParent: ".content-editBodyModal",
    });

    function validateFormPerubahan(formElement) {
        const latitudeInput = formElement.querySelector('#_lintang');
        const longitudeInput = formElement.querySelector('#_bujur');
        const selProv = formElement.querySelector('#_prov');
        const selKab = formElement.querySelector('#_kab');
        const selKec = formElement.querySelector('#_kec');
        const selKel = formElement.querySelector('#_kel');
        const selDusun = formElement.querySelector('#_dusun');
        const inPengaju = formElement.querySelector('#_pengaju');
        const inStatusPengaju = formElement.querySelector('#_status_pengaju');
        const inPerubahanPengaju = formElement.querySelector('#_perubahan_pengaju');
        if ((inPengaju.value === "" || inPengaju.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Silahkan masukkan nama pengaju perubahan data.",
                'warning'
            ).then((valRes) => {
                inPengaju.focus();
            });
            return false;
        }
        if ((inStatusPengaju.value === "" || inStatusPengaju.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Silahkan pilih status pengaju perubahan data.",
                'warning'
            ).then((valRes) => {});
            return false;
        }
        if ((inPerubahanPengaju.value === "" || inPerubahanPengaju.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Silahkan pilih jenis perubahan data.",
                'warning'
            ).then((valRes) => {});
            return false;
        }

        if (inPerubahanPengaju.value === "domisili") {

            if (!validateLat(latitudeInput.value)) {
                Swal.fire(
                    'Failed!',
                    "Inputan Lintang tidak valid.",
                    'warning'
                ).then((valR) => {
                    latitudeInput.focus();
                });

                return false; // Prevent form submission if validation fails
            }

            if (!validateLong(longitudeInput.value)) {
                Swal.fire(
                    'Failed!',
                    "Inputan Bujur tidak valid.",
                    'warning'
                ).then((valR) => {
                    longitudeInput.focus();
                });

                return false; // Prevent form submission if validation fails
            }
            if ((selProv.value === "" || selProv.value === undefined)) {
                Swal.fire(
                    'Peringatan!',
                    "Silahkan pilih provinsi.",
                    'warning'
                ).then((valRes) => {});
                return false;
            }
            if ((selKab.value === "" || selKab.value === undefined)) {
                Swal.fire(
                    'Peringatan!',
                    "Silahkan pilih kabupaten.",
                    'warning'
                ).then((valRes) => {});
                return false;
            }
            if ((selKec.value === "" || selKec.value === undefined)) {
                Swal.fire(
                    'Peringatan!',
                    "Silahkan pilih kecamatan.",
                    'warning'
                ).then((valRes) => {});
                return false;
            }
            if ((selKel.value === "" || selKel.value === undefined)) {
                Swal.fire(
                    'Peringatan!',
                    "Silahkan pilih kelurahan.",
                    'warning'
                ).then((valRes) => {});
                return false;
            }
            if ((selDusun.value === "" || selDusun.value === undefined)) {
                Swal.fire(
                    'Peringatan!',
                    "Silahkan pilih dusun.",
                    'warning'
                ).then((valRes) => {});
                return false;
            }
        }

        if (inPerubahanPengaju.value === "prestasi") {
            hitungNilaiRatarata();
        }
        // If validation passes, you can submit the form here
        // (e.g., formElement.submit())

        return true;
    }

    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    // Example usage: attach event listeners to form submission buttons
    const formPerubahan = document.getElementById('formPerubahanData');
    if (formPerubahan) {
        formPerubahan.addEventListener('submit', function(event) { // Prevent default form submission
            const nama = this.querySelector('#_nama_perubahan').value;
            const jenisPerubahan = this.querySelector('#_perubahan_pengaju').value;
            event.preventDefault();
            if (validateFormPerubahan(this)) {
                Swal.fire({
                    title: 'Apakah anda yakin ingin menyimpan perubahan data peserta ' + nama + '?',
                    text: "Sesuai dengan isian",
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, SIMPAN PERUBAHAN'
                }).then((result) => {
                    if (result.value) {
                        if (jenisPerubahan === "domisili") {
                            $.ajax({
                                url: "./perubahanSave",
                                type: 'POST',
                                data: $(this).serialize(),
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
                                        Swal.fire({
                                            title: "<strong>Download Berita Acara</strong>",
                                            icon: "success",
                                            html: '<center><b>Perubahan Data Pendaftaran Peserta</b><br/>Atas Nama: ' + resul.nama + '</center>',
                                            showCloseButton: false,
                                            showCancelButton: false,
                                            focusConfirm: false,
                                            confirmButtonText: `
    <i class="las la-la-file-download"></i> Download
  `,
                                            confirmButtonAriaLabel: "File, Download"
                                        }).then((confm) => {
                                            if (confm.value) {
                                                $.ajax({
                                                    url: resul.url,
                                                    type: 'GET',
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
                                                    success: function(resulsuc) {
                                                        if (resulsuc.status !== 200) {
                                                            if (resulsuc.status !== 201) {
                                                                if (resulsuc.status === 401) {
                                                                    Swal.fire(
                                                                        'Failed!',
                                                                        resulsuc.message,
                                                                        'warning'
                                                                    ).then((valRes) => {
                                                                        reloadPage();
                                                                    });
                                                                } else {
                                                                    Swal.fire(
                                                                        'GAGAL!',
                                                                        resulsuc.message,
                                                                        'warning'
                                                                    );
                                                                }
                                                            } else {
                                                                Swal.fire(
                                                                    'Peringatan!',
                                                                    resulsuc.message,
                                                                    'success'
                                                                ).then((valRes) => {
                                                                    // reloadPage();
                                                                    const decodedBytes = atob(resulsuc.data);
                                                                    const arrayBuffer = new ArrayBuffer(decodedBytes.length);
                                                                    const intArray = new Uint8Array(arrayBuffer);
                                                                    for (let i = 0; i < decodedBytes.length; i++) {
                                                                        intArray[i] = decodedBytes.charCodeAt(i);
                                                                    }

                                                                    const blob = new Blob([intArray], {
                                                                        type: 'application/pdf'
                                                                    });
                                                                    const link = document.createElement('a');
                                                                    link.href = URL.createObjectURL(blob);
                                                                    link.download = resulsuc.filename; // Set desired filename
                                                                    link.click();

                                                                    // Revoke the object URL after download (optional)
                                                                    URL.revokeObjectURL(link.href);

                                                                    reloadPage();

                                                                })
                                                            }
                                                        } else {
                                                            Swal.fire(
                                                                'BERHASIL!',
                                                                resulsuc.message,
                                                                'success'
                                                            ).then((valRes) => {
                                                                // reloadPage();
                                                                const decodedBytes = atob(resulsuc.data);
                                                                const arrayBuffer = new ArrayBuffer(decodedBytes.length);
                                                                const intArray = new Uint8Array(arrayBuffer);
                                                                for (let i = 0; i < decodedBytes.length; i++) {
                                                                    intArray[i] = decodedBytes.charCodeAt(i);
                                                                }

                                                                const blob = new Blob([intArray], {
                                                                    type: 'application/pdf'
                                                                });
                                                                const link = document.createElement('a');
                                                                link.href = URL.createObjectURL(blob);
                                                                link.download = resulsuc.filename;
                                                                link.click();
                                                                URL.revokeObjectURL(resulsuc.href);

                                                                reloadPage();
                                                            })
                                                        }
                                                    }
                                                });
                                            }
                                        });
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
                        } else {
                            $.ajax({
                                url: "./perubahanPrestasiSave",
                                type: 'POST',
                                data: $(this).serialize(),
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
                                        Swal.fire({
                                            title: "<strong>Download Berita Acara</strong>",
                                            icon: "success",
                                            html: '<center><b>Perubahan Data Pendaftaran Peserta</b><br/>Atas Nama: ' + resul.nama + '</center>',
                                            showCloseButton: false,
                                            showCancelButton: false,
                                            focusConfirm: false,
                                            confirmButtonText: `
    <i class="las la-la-file-download"></i> Download
  `,
                                            confirmButtonAriaLabel: "File, Download"
                                        }).then((confm) => {
                                            if (confm.value) {
                                                $.ajax({
                                                    url: resul.url,
                                                    type: 'GET',
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
                                                    success: function(resulsuc) {
                                                        if (resulsuc.status !== 200) {
                                                            if (resulsuc.status !== 201) {
                                                                if (resulsuc.status === 401) {
                                                                    Swal.fire(
                                                                        'Failed!',
                                                                        resulsuc.message,
                                                                        'warning'
                                                                    ).then((valRes) => {
                                                                        reloadPage();
                                                                    });
                                                                } else {
                                                                    Swal.fire(
                                                                        'GAGAL!',
                                                                        resulsuc.message,
                                                                        'warning'
                                                                    );
                                                                }
                                                            } else {
                                                                Swal.fire(
                                                                    'Peringatan!',
                                                                    resulsuc.message,
                                                                    'success'
                                                                ).then((valRes) => {
                                                                    // reloadPage();
                                                                    const decodedBytes = atob(resulsuc.data);
                                                                    const arrayBuffer = new ArrayBuffer(decodedBytes.length);
                                                                    const intArray = new Uint8Array(arrayBuffer);
                                                                    for (let i = 0; i < decodedBytes.length; i++) {
                                                                        intArray[i] = decodedBytes.charCodeAt(i);
                                                                    }

                                                                    const blob = new Blob([intArray], {
                                                                        type: 'application/pdf'
                                                                    });
                                                                    const link = document.createElement('a');
                                                                    link.href = URL.createObjectURL(blob);
                                                                    link.download = resulsuc.filename; // Set desired filename
                                                                    link.click();

                                                                    // Revoke the object URL after download (optional)
                                                                    URL.revokeObjectURL(link.href);

                                                                    reloadPage();

                                                                })
                                                            }
                                                        } else {
                                                            Swal.fire(
                                                                'BERHASIL!',
                                                                resulsuc.message,
                                                                'success'
                                                            ).then((valRes) => {
                                                                // reloadPage();
                                                                const decodedBytes = atob(resulsuc.data);
                                                                const arrayBuffer = new ArrayBuffer(decodedBytes.length);
                                                                const intArray = new Uint8Array(arrayBuffer);
                                                                for (let i = 0; i < decodedBytes.length; i++) {
                                                                    intArray[i] = decodedBytes.charCodeAt(i);
                                                                }

                                                                const blob = new Blob([intArray], {
                                                                    type: 'application/pdf'
                                                                });
                                                                const link = document.createElement('a');
                                                                link.href = URL.createObjectURL(blob);
                                                                link.download = resulsuc.filename;
                                                                link.click();
                                                                URL.revokeObjectURL(resulsuc.href);

                                                                reloadPage();
                                                            })
                                                        }
                                                    }
                                                });
                                            }
                                        });
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
                    }
                });
            } else {}
        });
    }
</script>