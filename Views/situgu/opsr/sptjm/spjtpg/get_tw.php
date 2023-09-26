<?php if (isset($tws)) { ?>
    <div class="modal-body">
        <div class="col-lg-12">
            <div class="mb-3">
                <label for="_tw" class="col-form-label">Pilih TW:</label>
                <select class="form-control" id="_tw" name="_tw" required>
                    <option value="">--Pilih--</option>
                    <?php if (isset($tws)) { ?>
                        <?php if (count($tws) > 0) { ?>
                            <?php foreach ($tws as $key => $value) { ?>
                                <option value="<?= $value->id ?>" <?= ($tw == $value->id) ? ' selected' : '' ?>><?= 'Tahun ' . $value->tahun . ' - TW. ' . $value->tw ?></option>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </select>
                <div class="help-block _tw"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="button" onclick="actionSubmit(this)" class="btn btn-success waves-effect waves-light button-submit">CEK Data Verifikasi SPJ TPG</button>
    </div>
    <script>
        function actionSubmit(event) {

            let status;
            const tw = document.getElementsByName('_tw')[0].value;

            if (tw === "" || tw === undefined) {
                Swal.fire(
                    'GAGAL!',
                    "Silahkan pilih triwulan terlebih dahulu.",
                    'warning'
                );
                return;
            }

            $.ajax({
                url: "./add",
                type: 'POST',
                data: {
                    id: 'tpg',
                    tw: tw,
                },
                dataType: 'JSON',
                beforeSend: function() {
                    $('.button-submit').attr('disabled', true);
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
                                $('.button-submit').attr('disabled', false);
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
                        $('#content-detailModalLabel').html('BUAT SPTJM VERIFIKASI SPJ TPG');
                        $('.contentBodyModal').html(resul.data);
                        $('.content-detailModal').modal({
                            backdrop: 'static',
                            keyboard: false,
                        });
                        $('.content-detailModal').modal('show');
                    }
                },
                error: function() {
                    $('.button-submit').attr('disabled', false);
                    $('div.modal-content-loading').unblock();
                    Swal.fire(
                        'PERINGATAN!',
                        "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                        'warning'
                    );
                }
            });
        }
    </script>
<?php } ?>