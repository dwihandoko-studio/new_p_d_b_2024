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
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/ptk/ktp') . '/' . $data->lampiran_ktp ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/ktp') . '/' . $data->lampiran_ktp ?>" id="nik">Lampiran KTP</a>
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->nik ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NUPTK:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nuptk" aria-label="NUPTK" value="<?= $data->nuptk ?>" readonly />
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/ptk/nuptk') . '/' . $data->lampiran_nuptk ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/nuptk') . '/' . $data->lampiran_nuptk ?>" id="nik">Lampiran NUPTK</a>
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->nuptk ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NIP:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nip" aria-label="NIP" value="<?= $data->nip ?>" readonly />
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/ptk/karpeg') . '/' . $data->lampiran_karpeg ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/karpeg') . '/' . $data->lampiran_karpeg ?>" id="nik">Lampiran Karpeg</a>
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->nip ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NRG:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nrg" aria-label="NRG" value="<?= $data->nrg ?>" readonly />
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/ptk/nrg') . '/' . $data->lampiran_nrg ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/nrg') . '/' . $data->lampiran_nrg ?>" id="nik">Lampiran NRG</a>
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->nrg ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">No Peserta:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="no_peserta" aria-label="No Peserta" value="<?= $data->no_peserta ?>" readonly />
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/ptk/serdik') . '/' . $data->lampiran_serdik ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/serdik') . '/' . $data->lampiran_serdik ?>" id="no_peserta">Lampiran Serdik</a>
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->no_peserta ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NPWP:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="npwp" aria-label="NPWP" value="<?= $data->npwp ?>" readonly />
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/ptk/npwp') . '/' . $data->lampiran_npwp ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/npwp') . '/' . $data->lampiran_npwp ?>" id="nik">Lampiran NPWP</a>
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->npwp ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">No Rekening:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="no_rekening" aria-label="NO REKENING" value="<?= $data->no_rekening ?>" readonly />
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/ptk/bukurekening') . '/' . $data->lampiran_buku_rekening ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/bukurekening') . '/' . $data->lampiran_buku_rekening ?>" id="nik">Lampiran Rekening</a>
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->no_rekening ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Cabang Bank:</label>
                <input type="text" class="form-control" value="<?= $data->cabang_bank ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Pendidikan Terakhir:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="pendidikan_terakhir" aria-label="PENDIDIKAN TERAKHIR" value="<?= $data->pendidikan ?>" readonly />
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/ptk/ijazah') . '/' . $data->lampiran_ijazah ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/ijazah') . '/' . $data->lampiran_ijazah ?>" id="nik">Lampiran Ijazah</a>
                </div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Tempat Lahir:</label>
                <input type="text" class="form-control" value="<?= $data->tempat_lahir ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Tanggal Lahir:</label>
                <input type="text" class="form-control" value="<?= $data->tgl_lahir ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Jenis Kelamin:</label>
                <div><?php switch ($data->jenis_kelamin) {
                            case 'P':
                                echo '<span class="badge badge-pill badge-soft-primary">Perempuan</span>';
                                break;
                            case 'L':
                                echo '<span class="badge badge-pill badge-soft-primary">Laki-Laki</span>';
                                break;
                            default:
                                echo '-';
                                break;
                        } ?>
                </div>
            </div>
        </div>
        <hr />
        <div class="row mt-2">
            <h2>DATA ATRIBUT USULAN</h2>
            <div class="col-lg-12">
                <div class="row">
                    <?php if ($tw->tw_tw == 1) { ?>
                        <div class="col-sm-4">
                            <label class="col-form-label">Bulan 1 :</label>
                            <div class="input-group">
                                <input type="text" class="form-control" aria-describedby="bulan_1" aria-label="BULAN 1" value="<?= $data->tf_gaji_pokok_1 ?>" readonly />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label class="col-form-label">Bulan 2 :</label>
                            <div class="input-group">
                                <input type="text" class="form-control" aria-describedby="bulan_2" aria-label="BULAN 2" value="<?= $data->tf_gaji_pokok_2 ?>" readonly />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label class="col-form-label">Bulan 3 :</label>
                            <div class="input-group">
                                <input type="text" class="form-control" aria-describedby="bulan_3" aria-label="BULAN 3" value="<?= $data->tf_gaji_pokok_3 ?>" readonly />
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
                            <input type="text" class="form-control" aria-describedby="jumlah_diterima" aria-label="Jumlah Diterima" value="<?= $data->tf_jumlah_diteri ?>" readonly />
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
                <label class="col-form-label">Lampiran Dokumen SPJ:</label>
                <br />
                <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/spj/tpg') . '/' . $data->lampiran_pernyataan ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/spj/tpg') . '/' . $data->lampiran_pernyataan ?>" id="nik">
                    Pernyataan
                </a>
                <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/spj/tpg') . '/' . $data->lampiran_rekening_koran ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/spj/tpg') . '/' . $data->lampiran_rekening_koran ?>" id="nik">
                    Rekening Koran
                </a>
                <?php if ($data->lampiran_impassing === null || $data->lampiran_impassing === "") {
                } else { ?>
                    <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/spj/tpg') . '/' . $data->lampiran_sk_dirgen ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/spj/tpg') . '/' . $data->lampiran_sk_dirgen ?>" id="nik">
                        SKTP
                    </a>
                <?php } ?>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="button" onclick="actionTolak(this)" class="btn btn-danger waves-effect waves-light">Tolak Usulan TPG</button>
        <button type="button" onclick="actionApprove(this)" class="btn btn-success waves-effect waves-light">Setujui Usulan TPG</button>
    </div>
    <script>
        function actionTolak(e) {
            const nama = '<?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?>';
            Swal.fire({
                title: 'Apakah anda yakin ingin menolak Laporan SPJ TPG ini?',
                text: "Tolak Pelaporan SPJ TPG PTK: <?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?>",
                showCancelButton: true,
                icon: 'question',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Tolak!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "./formtolak",
                        type: 'POST',
                        data: {
                            id: '<?= $data->id_usulan ?>',
                            nama: nama,
                        },
                        dataType: 'JSON',
                        beforeSend: function() {
                            $('div.modal-content-loading').block({
                                message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                            });
                        },
                        success: function(resul) {
                            $('div.modal-content-loading').unblock();
                            if (resul.status !== 200) {
                                Swal.fire(
                                    'Failed!',
                                    resul.message,
                                    'warning'
                                );
                            } else {
                                $('#content-tolakModalLabel').html('TOLAK LAPORAN SPJ TPG ' + nama);
                                $('.contentTolakBodyModal').html(resul.data);
                                $('.content-tolakModal').modal({
                                    backdrop: 'static',
                                    keyboard: false,
                                });
                                $('.content-tolakModal').modal('show');
                            }
                        },
                        error: function() {
                            $('div.modal-content-loading').unblock();
                            Swal.fire(
                                'Failed!',
                                "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                                'warning'
                            );
                        }
                    });
                }
            })
        }

        function simpanTolak(e) {
            const id = '<?= $data->id_usulan ?>';
            const nama = '<?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?>';
            const keterangan = document.getElementsByName('_keterangan_tolak')[0].value;

            $.ajax({
                url: "./tolak",
                type: 'POST',
                data: {
                    id: id,
                    nama: nama,
                    keterangan: keterangan,
                },
                dataType: 'JSON',
                beforeSend: function() {
                    e.disabled = true;
                    $('div.modal-content-loading').block({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                    });
                },
                success: function(resul) {
                    $('div.modal-content-loading').unblock();

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
                                e.disabled = false;
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
                            'SELAMAT!',
                            resul.message,
                            'success'
                        ).then((valRes) => {
                            reloadPage();
                        })
                    }
                },
                error: function(erro) {
                    console.log(erro);
                    // e.attr('disabled', false);
                    e.disabled = false
                    $('div.modal-content-loading').unblock();
                    Swal.fire(
                        'PERINGATAN!',
                        "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                        'warning'
                    );
                }
            });
        };

        function actionApprove(e) {
            const id = '<?= $data->id_usulan ?>';
            const nama = '<?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?>';
            Swal.fire({
                title: 'Apakah anda yakin ingin menyetujui Laporan SPJ TPG ini?',
                text: "Setujui Laporan SPJ TPG PTK: <?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?>",
                showCancelButton: true,
                icon: 'question',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Setujui!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "./approve",
                        type: 'POST',
                        data: {
                            id: id,
                            nama: nama,
                        },
                        dataType: 'JSON',
                        beforeSend: function() {
                            e.disabled = true;
                            $('div.modal-content-loading').block({
                                message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                            });
                        },
                        success: function(resul) {
                            $('div.modal-content-loading').unblock();

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
                                        e.disabled = false;
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
                                    'SELAMAT!',
                                    resul.message,
                                    'success'
                                ).then((valRes) => {
                                    reloadPage();
                                })
                            }
                        },
                        error: function(erro) {
                            console.log(erro);
                            // e.attr('disabled', false);
                            e.disabled = false
                            $('div.modal-content-loading').unblock();
                            Swal.fire(
                                'PERINGATAN!',
                                "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                                'warning'
                            );
                        }
                    });
                }
            })
        };
    </script>
<?php } ?>