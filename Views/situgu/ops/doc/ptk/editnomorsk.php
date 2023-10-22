<?php if (isset($data)) { ?>
    <form id="formEditModalData" action="./editSave" method="post">
        <input type="hidden" id="_id" name="_id" value="<?= $data->id ?>" />
        <input type="hidden" id="_id_ptk" name="_id_ptk" value="<?= $data->id_ptk ?>" />
        <input type="hidden" id="_tw" name="_tw" value="<?= $data->id_tahun_tw ?>" />
        <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
            <div class="mb-3">
                <label for="_pangkat" class="form-label">Jenis Kepangkatan</label>
                <input type="text" class="form-control pangkat" value="<?= $data->pang_jenis ? $data->pang_jenis : '' ?>" id="_pangkat" name="_pangkat" placeholder="Pangkat (example: IV/A)..." readonly>
                <div class="help-block _pangkat"></div>
            </div>
            <div class="mb-3">
                <label for="_no_sk_pangkat" class="form-label">No SK</label>
                <input type="text" class="form-control no-sk-pangkat" value="<?= $data->pang_no ?>" id="_no_sk_pangkat" name="_no_sk_pangkat" placeholder="No SK..." onfocusin="inputFocus(this);">
                <div class="help-block _no_sk_pangkat"></div>
            </div>
            <div class="mb-3">
                <label for="_tgl_pangkat" class="form-label">Tanggal SK</label>
                <input type="date" class="form-control tgl-pangkat" value="<?= $data->pang_tgl ?>" id="_tgl_pangkat" name="_tgl_pangkat" onfocusin="inputFocus(this);">
                <div class="help-block _tgl_pangkat"></div>
            </div>
            <div class="mb-3">
                <label for="_pangkat" class="form-label">Pangkat</label>
                <input type="text" class="form-control pangkat" value="<?= $data->pang_golongan ?>" id="_pangkat" name="_pangkat" placeholder="Pangkat (example: IV/A)..." readonly>
                <div class="help-block _pangkat"></div>
            </div>
            <div class="mb-3">
                <label for="_tmt_pangkat" class="form-label">TMT Pangkat Terakhir</label>
                <input type="date" class="form-control tmt-pangkat" value="<?= $data->pang_tmt ?>" id="_tmt_pangkat" name="_tmt_pangkat" readonly>
                <div class="help-block _tmt_pangkat"></div>
            </div>
            <div class="mb-3">
                <label for="_mkt_pangkat" class="form-label">Masa Kerja Tahun</label>
                <input type="number" class="form-control mkt-pangkat" value="<?= $data->pang_tahun ?>" id="_mkt_pangkat" name="_mkt_pangkat" readonly">
                <div class="help-block _mkt_pangkat"></div>
            </div>
            <div class="mb-3">
                <label for="_mkb_pangkat" class="form-label">Masa Kerja Bulan</label>
                <input type="number" class="form-control mkt-pangkat" value="<?= $data->pang_bulan ?>" id="_mkb_pangkat" name="_mkb_pangkat" readonly">
                <div class="help-block _mkb_pangkat"></div>
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
            const id_ptk = document.getElementsByName('_id_ptk')[0].value;
            const tw = document.getElementsByName('_tw')[0].value;

            const no_sk_pangkat = document.getElementsByName('_no_sk_pangkat')[0].value;
            const tgl_pangkat = document.getElementsByName('_tgl_pangkat')[0].value;

            if (no_sk_pangkat === "") {
                $("input#_no_sk_pangkat").css("color", "#dc3545");
                $("input#_no_sk_pangkat").css("border-color", "#dc3545");
                $('._no_sk_pangkat').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">No Rekening tidak boleh kosong. Silahkan isi dengan tanda (-) jika tidak ada.</li></ul>');
                return false;
            }
            if (tgl_pangkat === "") {
                $("input#_tgl_pangkat").css("color", "#dc3545");
                $("input#_tgl_pangkat").css("border-color", "#dc3545");
                $('._tgl_pangkat').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Cabang Bank tidak boleh kosong. Silahkan isi dengan tanda (-) jika tidak ada.</li></ul>');
                return false;
            }

            Swal.fire({
                title: 'Apakah anda yakin ingin mengupdate data ini?',
                text: "Update Data Kepangkatan PTK: <?= $data->nama ?>",
                showCancelButton: true,
                icon: 'question',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Update!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "./editSaveNomorSk",
                        type: 'POST',
                        data: {
                            id: id,
                            id_ptk: id_ptk,
                            tw: tw,
                            no_sk: no_sk_pangkat,
                            tgl_sk: tgl_pangkat,
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
        });
    </script>

<?php } ?>