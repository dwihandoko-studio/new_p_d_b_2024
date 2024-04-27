<?php if (isset($data)) { ?>
    <form id="formEditModalData" action="./editSave" method="post">
        <input type="hidden" id="_id" name="_id" value="<?= $data->id ?>" />
        <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
            <div class="mb-3">
                <label for="_nama" class="form-label">Nama Pegawai</label>
                <input type="text" class="form-control nama" value="<?= $data->nama ?>" id="_nama" name="_nama" placeholder="Nama..." onfocusin="inputFocus(this);">
                <div class="help-block _nama"></div>
            </div>
            <div class="mb-3">
                <label for="_nip" class="form-label">NIP</label>
                <input type="text" class="form-control nip" value="<?= $data->nip ?>" id="_nip" name="_nip" placeholder="NIP..." onfocusin="inputFocus(this);">
                <div class="help-block _nip"></div>
            </div>
            <div class="mb-3">
                <label for="_kecamatan" class="col-form-label">Pilih Kecamatan:</label>
                <select class="select2 form-control select2" id="_kecamatan" name="_kecamatan" style="width: 100%" data-placeholder="Pilih Kecamatan ...">
                    <option value="">--Pilih Kecamatan--</option>
                    <?php if (isset($kecamatans)) { ?>
                        <?php if (count($kecamatans) > 0) { ?>
                            <?php foreach ($kecamatans as $key => $value) { ?>
                                <option value="<?= $value->kode_kecamatan ?>" <?= ($value->kode_kecamatan == $data->kode_kecamatan) ? ' selected' : '' ?>><?= $value->nama_kecamatan ?></option>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </select>
                <div class="help-block _kecamatan"></div>
            </div>
            <div class="mb-3">
                <label for="_kode_instansi" class="form-label">Kode Instansi</label>
                <input type="text" class="form-control kode-instansi" value="<?= $data->kode_instansi ?>" id="_kode_instansi" name="_kode_instansi" placeholder="Kode instansi..." onfocusin="inputFocus(this);">
                <div class="help-block _kode_instansi"></div>
            </div>
            <div class="mb-3">
                <label for="_nama_instansi" class="form-label">Nama Instansi</label>
                <input type="text" class="form-control nama_instansi" value="<?= $data->nama_instansi ?>" id="_nama_instansi" name="_nama_instansi" placeholder="Nama instansi..." onfocusin="inputFocus(this);">
                <div class="help-block _nama_instansi"></div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
        </div>
    </form>

    <script>
        $("#formEditModalData").on("submit", function(e) {
            e.preventDefault();
            const id = document.getElementsByName('_id')[0].value;
            const nama = document.getElementsByName('_nama')[0].value;
            const nip = document.getElementsByName('_nip')[0].value;
            const kecamatan = document.getElementsByName('_kecamatan')[0].value;
            const kode_instansi = document.getElementsByName('_kode_instansi')[0].value;
            const instansi = document.getElementsByName('_nama_instansi')[0].value;

            // if (pangkat === "") {
            //     $("input#_nrg").css("color", "#dc3545");
            //     $("input#_nrg").css("border-color", "#dc3545");
            //     $('._nrg').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">NRG tidak boleh kosong. Silahkan isi dengan tanda (-) jika tidak ada.</li></ul>');
            //     return false;
            // }
            // if (no_peserta === "") {
            //     $("input#_no_peserta").css("color", "#dc3545");
            //     $("input#_no_peserta").css("border-color", "#dc3545");
            //     $('._no_peserta').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">No Peserta tidak boleh kosong. Silahkan isi dengan tanda (-) jika tidak ada.</li></ul>');
            //     return false;
            // }
            // if (npwp === "") {
            //     $("input#_npwp").css("color", "#dc3545");
            //     $("input#_npwp").css("border-color", "#dc3545");
            //     $('._npwp').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">NPWP tidak boleh kosong. Silahkan isi dengan tanda (-) jika tidak ada.</li></ul>');
            //     return false;
            // }
            // if (no_rekening === "") {
            //     $("input#_no_rekening").css("color", "#dc3545");
            //     $("input#_no_rekening").css("border-color", "#dc3545");
            //     $('._no_rekening').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">No Rekening tidak boleh kosong. Silahkan isi dengan tanda (-) jika tidak ada.</li></ul>');
            //     return false;
            // }
            // if (cabang_bank === "") {
            //     $("input#_cabang_bank").css("color", "#dc3545");
            //     $("input#_cabang_bank").css("border-color", "#dc3545");
            //     $('._cabang_bank').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Cabang Bank tidak boleh kosong. Silahkan isi dengan tanda (-) jika tidak ada.</li></ul>');
            //     return false;
            // }

            Swal.fire({
                title: 'Apakah anda yakin ingin mengupdate data ini?',
                text: "Update Data Pegawai: <?= $data->nama ?>",
                showCancelButton: true,
                icon: 'question',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Update!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "./editSave",
                        type: 'POST',
                        data: {
                            id: id,
                            nama: nama,
                            nip: nip,
                            kecamatan: kecamatan,
                            kode_instansi: kode_instansi,
                            instansi: instansi,
                        },
                        dataType: 'JSON',
                        beforeSend: function() {
                            $('div.modal-content-loading-edit').block({
                                message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                            });
                        },
                        success: function(resul) {
                            $('div.modal-content-loading-edit').unblock();

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
                                    'SELAMAT!',
                                    resul.message,
                                    'success'
                                ).then((valRes) => {
                                    reloadPage();
                                })
                            }
                        },
                        error: function() {
                            $('div.modal-content-loading-edit').unblock();
                            Swal.fire(
                                'PERINGATAN!',
                                "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                                'warning'
                            );
                        }
                    });
                }
            })
        });
    </script>

<?php } ?>