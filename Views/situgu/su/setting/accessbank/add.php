<form id="formAddModalData" action="./addSave" method="post">
    <div class="modal-body">
        <div class="mb-3">
            <label for="_pengguna" class="col-form-label">Pengguna:</label>
            <select class="form-control" id="_pengguna" name="_pengguna" required>
                <option value="">--Pilih--</option>
                <?php if (isset($penggunas)) {
                    if (count($penggunas) > 0) {
                        foreach ($penggunas as $key => $value) { ?>
                            <option value="<?= $value->id ?>"><?= $value->fullname ?> | <?= $value->email ?></option>
                <?php }
                    }
                } ?>
            </select>
            <div class="help-block _pengguna"></div>
        </div>
        <div class="mb-3 _bank-block">
            <label for="_name" class="col-form-label">Bank:</label>
            <select class="form-control" id="_bank" name="_bank" style="width: 100%">
                <option value="">--Pilih--</option>
                <?php if (isset($banks)) {
                    if (count($banks) > 0) {
                        foreach ($banks as $key => $value) { ?>
                            <option value="<?= $value->id ?>"><?= $value->nama_bank ?></option>
                <?php }
                    }
                } ?>
            </select>
            <div class="help-block _bank"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
    </div>
</form>

<script>
    $("#formAddModalData").on("submit", function(e) {
        e.preventDefault();
        const bank = document.getElementsByName('_bank')[0].value;
        const pengguna = document.getElementsByName('_pengguna')[0].value;

        if (bank === "") {
            $("select#_bank").css("color", "#dc3545");
            $("select#_bank").css("border-color", "#dc3545");
            $('._bank').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih bank.</li></ul>');
            return false;
        }
        if (pengguna === "") {
            $("select#_pengguna").css("color", "#dc3545");
            $("select#_pengguna").css("border-color", "#dc3545");
            $('._pengguna').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih pengguna.</li></ul>');
            return false;
        }

        $.ajax({
            url: "./addSave",
            type: 'POST',
            data: {
                dari_bank: bank,
                pengguna: pengguna,
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
    });
</script>