<?php if (isset($data)) { ?>
    <form id="formEditInpassingModalData" action="./editSaveInpassing" method="post">
        <input type="hidden" id="_id" name="_id" value="<?= $data->id ?>" />
        <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
            <div class="mb-3">
                <label for="_pangkat" class="form-label">Pangkat Terakhir Inpassing</label>
                <input type="text" class="form-control pangkat" value="<?= $data->pangkat_golongan_ruang ?>" id="_pangkat" name="_pangkat" placeholder="Pangkat terakhir (example: IV/A)..." onfocusin="inputFocus(this);">
                <div class="help-block _pangkat"></div>
            </div>
            <div class="mb-3">
                <label for="_no_sk_pangkat" class="form-label">No SK Inpassing</label>
                <input type="text" class="form-control no-sk-pangkat" value="<?= $data->nomor_sk_impassing ?>" id="_no_sk_pangkat" name="_no_sk_pangkat" placeholder="No SK Pangkat terakhir..." onfocusin="inputFocus(this);">
                <div class="help-block _no_sk_pangkat"></div>
            </div>
            <div class="mb-3">
                <label for="_tgl_pangkat" class="form-label">Tanggal Inpassing</label>
                <input type="date" class="form-control tgl-pangkat" value="<?= $data->tgl_sk_impassing ?>" id="_tgl_pangkat" name="_tgl_pangkat" onfocusin="inputFocus(this);">
                <div class="help-block _tgl_pangkat"></div>
            </div>
            <div class="mb-3">
                <label for="_tmt_pangkat" class="form-label">TMT Inpassing</label>
                <input type="date" class="form-control tmt-pangkat" value="<?= $data->tmt_sk_impassing ?>" id="_tmt_pangkat" name="_tmt_pangkat" onfocusin="inputFocus(this);">
                <div class="help-block _tmt_pangkat"></div>
            </div>
            <div class="mb-3">
                <label for="_mkt_pangkat" class="form-label">Masa Kerja Tahun Inpassing</label>
                <input type="number" class="form-control mkt-pangkat" value="<?= $data->masa_kerja_tahun_impassing ?>" id="_mkt_pangkat" name="_mkt_pangkat" onfocusin="inputFocus(this);">
                <div class="help-block _mkt_pangkat"></div>
            </div>
            <div class="mb-3">
                <label for="_mkb_pangkat" class="form-label">Masa Kerja Bulan Inpassing</label>
                <input type="number" class="form-control mkt-pangkat" value="<?= $data->masa_kerja_bulan_impassing ?>" id="_mkb_pangkat" name="_mkb_pangkat" onfocusin="inputFocus(this);">
                <div class="help-block _mkb_pangkat"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
        </div>
    </form>

    <script>
        $("#formEditInpassingModalData").on("submit", function(e) {
            e.preventDefault();
            const id = document.getElementsByName('_id')[0].value;
            const pangkat = document.getElementsByName('_pangkat')[0].value;
            const no_sk_pangkat = document.getElementsByName('_no_sk_pangkat')[0].value;
            const tgl_pangkat = document.getElementsByName('_tgl_pangkat')[0].value;
            const tmt_pangkat = document.getElementsByName('_tmt_pangkat')[0].value;
            const mkt_pangkat = document.getElementsByName('_mkt_pangkat')[0].value;
            const mkb_pangkat = document.getElementsByName('_mkb_pangkat')[0].value;

            if (pangkat === "") {
                $("input#_pangkat").css("color", "#dc3545");
                $("input#_pangkat").css("border-color", "#dc3545");
                $('._pangkat').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pangkat inpassing tidak boleh kosong.</li></ul>');
                return false;
            }
            if (no_sk_pangkat === "") {
                $("input#no_sk_pangkat").css("color", "#dc3545");
                $("input#no_sk_pangkat").css("border-color", "#dc3545");
                $('.no_sk_pangkat').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">No sk inpassing tidak boleh kosong.</li></ul>');
                return false;
            }
            if (tgl_pangkat === "") {
                $("input#_tgl_pangkat").css("color", "#dc3545");
                $("input#_tgl_pangkat").css("border-color", "#dc3545");
                $('._tgl_pangkat').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Tgl SK inpassing tidak boleh kosong.</li></ul>');
                return false;
            }
            if (tmt_pangkat === "") {
                $("input#_tmt_pangkat").css("color", "#dc3545");
                $("input#_tmt_pangkat").css("border-color", "#dc3545");
                $('._tmt_pangkat').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">TMT Inpassing tidak boleh kosong.</li></ul>');
                return false;
            }
            if (mkt_pangkat === "") {
                $("input#_mkt_pangkat").css("color", "#dc3545");
                $("input#_mkt_pangkat").css("border-color", "#dc3545");
                $('._mkt_pangkat').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">MK Tahun Inpassing tidak boleh kosong.</li></ul>');
                return false;
            }
            if (mkb_pangkat === "") {
                $("input#_mkb_pangkat").css("color", "#dc3545");
                $("input#_mkb_pangkat").css("border-color", "#dc3545");
                $('._mkb_pangkat').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">MK Bulan Inpassing tidak boleh kosong.</li></ul>');
                return false;
            }

            Swal.fire({
                title: 'Apakah anda yakin ingin mengupdate data inpassing ini?',
                text: "Update Data Inpassing PTK: <?= $data->nama ?>",
                showCancelButton: true,
                icon: 'question',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Update!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "./editSaveInpassing",
                        type: 'POST',
                        data: {
                            id: id,
                            pangkat: pangkat,
                            no_sk_pangkat: no_sk_pangkat,
                            tgl_pangkat: tgl_pangkat,
                            tmt_pangkat: tmt_pangkat,
                            mkt_pangkat: mkt_pangkat,
                            mkb_pangkat: mkb_pangkat,
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