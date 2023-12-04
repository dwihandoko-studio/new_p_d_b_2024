<?php if (isset($data)) { ?>
    <div class="modal-body">
        <div class="row">
            <h2>DATA INDIVIDU</h2>
            <div class="col-lg-6">
                <label class="col-form-label">Nama Lengkap:</label>
                <input type="text" class="form-control" value="<?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NIK:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nik" aria-label="NIK" value="<?= $data->nik ?>" readonly />
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->nik ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NUPTK:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nuptk" aria-label="NUPTK" value="<?= $data->nuptk ?>" readonly />
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->nuptk ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NIP:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nip" aria-label="NIP" value="<?= $data->nip ?>" readonly />
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->nip ?>" readonly /> -->
            </div>
        </div>
        <hr />
        <div class="row mt-2">
            <h2>DATA ATRIBUT USULAN</h2>
            <div class="col-lg-12">
                <div class="row">
                    <?php if ($tw->tw == 1) { ?>
                        <div class="col-sm-4">
                            <label class="col-form-label">Bulan 1 :</label>
                            <div class="input-group">
                                <input type="text" class="form-control" aria-describedby="bulan_1" aria-label="BULAN 1" value="<?= rpAwalan($data->tf_gaji_pokok_1) ?>" readonly />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label class="col-form-label">Bulan 2 :</label>
                            <div class="input-group">
                                <input type="text" class="form-control" aria-describedby="bulan_2" aria-label="BULAN 2" value="<?= rpAwalan($data->tf_gaji_pokok_2) ?>" readonly />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label class="col-form-label">Bulan 3 :</label>
                            <div class="input-group">
                                <input type="text" class="form-control" aria-describedby="bulan_3" aria-label="BULAN 3" value="<?= rpAwalan($data->tf_gaji_pokok_3) ?>" readonly />
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-sm-6">
                        <label class="col-form-label">Jumlah Diterima :</label>
                        <div class="input-group">
                            <input type="text" class="form-control" aria-describedby="jumlah_diterima" aria-label="Jumlah Diterima" value="<?= rpAwalan($data->tf_jumlah_diterima) ?>" readonly />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">No Rekening :</label>
                        <div class="input-group">
                            <input type="text" class="form-control" aria-describedby="no_rekening" aria-label="No Rekening" value="<?= $data->tf_no_rekening ?>" readonly />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <label class="col-form-label">Keterangan :</label>
                <div class="input-group">
                    <textarea class="form-control" readonly><?= $data->tf_keterangan ?></textarea>
                </div>
            </div>
            <div class="col-lg-12 mt-2">
                <label class="col-form-label">Lampiran Dokumen:</label>
                <br />
                <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/spj/tpg') . '/' . $data->lampiran_pernyataan ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/spj/tpg') . '/' . $data->lampiran_pernyataan ?>" id="nik">
                    Pernyataan SPJ
                </a>
                <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/spj/tpg') . '/' . $data->lampiran_rekening_koran ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/spj/tpg') . '/' . $data->lampiran_rekening_koran ?>" id="nik">
                    Rekening Koran SPJ
                </a>
                <?php if ($data->lampiran_sk_dirgen === null || $data->lampiran_sk_dirgen === "") {
                } else { ?>
                    <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/spj/tpg') . '/' . $data->lampiran_sk_dirgen ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/spj/tpg') . '/' . $data->lampiran_sk_dirgen ?>" id="nik">
                        SKTP SPJ
                    </a>
                <?php } ?>
                <?php if ($doc_attribut->pangkat_terakhir === null || $doc_attribut->pangkat_terakhir === "") {
                } else { ?>
                    <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/ptk/pangkat') . '/' . $doc_attribut->pangkat_terakhir ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/pangkat') . '/' . $doc_attribut->pangkat_terakhir ?>" id="nik">
                        Pangkat
                    </a>
                <?php } ?>
                <?php if ($doc_attribut->kgb_terakhir === null || $doc_attribut->kgb_terakhir === "") {
                } else { ?>
                    <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/ptk/kgb') . '/' . $doc_attribut->kgb_terakhir ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/kgb') . '/' . $doc_attribut->kgb_terakhir ?>" id="nik">
                        KGB
                    </a>
                <?php } ?>
                <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/sekolah/pembagian-tugas') . '/' . $doc_sekolah->pembagian_tugas ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/sekolah/pembagian-tugas') . '/' . $doc_sekolah->pembagian_tugas ?>" id="nik">
                    Pembagian Tugas
                </a>
                <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/sekolah/slip-gaji') . '/' . $doc_sekolah->slip_gaji ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/sekolah/slip-gaji') . '/' . $doc_sekolah->slip_gaji ?>" id="nik">
                    Slip Gaji
                </a>
                <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/ptk/pernyataanindividu') . '/' . $doc_attribut->pernyataan_24jam ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/pernyataanindividu') . '/' . $doc_attribut->pernyataan_24jam ?>" id="nik">
                    Pernyataan 24 Jam
                </a>
                <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/sekolah/kehadiran') . '/' . $doc_sekolah->lampiran_bulan1 ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/sekolah/kehadiran') . '/' . $doc_sekolah->lampiran_bulan1 ?>" id="nik">
                    Absen Bulan (I)
                </a>
                <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/sekolah/kehadiran') . '/' . $doc_sekolah->lampiran_bulan2 ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/sekolah/kehadiran') . '/' . $doc_sekolah->lampiran_bulan2 ?>" id="nik">
                    Absen Bulan (II)
                </a>
                <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/sekolah/kehadiran') . '/' . $doc_sekolah->lampiran_bulan3 ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/sekolah/kehadiran') . '/' . $doc_sekolah->lampiran_bulan3 ?>" id="nik">
                    Absen Bulan (III)
                </a>
                <?php if ($doc_sekolah->doc_lainnya === null || $doc_sekolah->doc_lainnya === "") {
                } else { ?>
                    <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/sekolah/doc-lainnya') . '/' . $doc_sekolah->doc_lainnya ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/sekolah/doc-lainnya') . '/' . $doc_sekolah->doc_lainnya ?>" id="nik">
                        Doc Sekolah Lainnya
                    </a>
                <?php } ?>
                <?php if ($doc_attribut->cuti === null || $doc_attribut->cuti === "") {
                } else { ?>
                    <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/ptk/keterangancuti') . '/' . $doc_attribut->cuti ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/keterangancuti') . '/' . $doc_attribut->cuti ?>" id="nik">
                        Cuti
                    </a>
                <?php } ?>
                <?php if ($doc_attribut->pensiun === null || $doc_attribut->pensiun === "") {
                } else { ?>
                    <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/ptk/pensiun') . '/' . $doc_attribut->pensiun ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/pensiun') . '/' . $doc_attribut->pensiun ?>" id="nik">
                        Pensiun
                    </a>
                <?php } ?>
                <?php if ($doc_attribut->kematian === null || $doc_attribut->kematian === "") {
                } else { ?>
                    <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/ptk/kematian') . '/' . $doc_attribut->kematian ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/kematian') . '/' . $doc_attribut->kematian ?>" id="nik">
                        Kematian
                    </a>
                <?php } ?>
                <?php if ($doc_attribut->lainnya === null || $doc_attribut->lainnya === "") {
                } else { ?>
                    <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/ptk/lainnya') . '/' . $doc_attribut->lainnya ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/lainnya') . '/' . $doc_attribut->lainnya ?>" id="nik">
                        Atribut Lainnya
                    </a>
                <?php } ?>

            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
    </div>
<?php } ?>