<form id="formAddModalData" action="./ambildatatagihan" method="post">
    <input type="hidden" id="_id" name="_id" value="<?= $tw_active ?>" />
    <div class="modal-body">
        <div class="mb-3">
            <label for="_bulan" class="col-form-label">Tahun Bulan:</label>
            <select class="form-control" id="_bulan" name="_bulan" required style="width: 100%">
                <option value="">--Pilih--</option>
                <?php if (isset($tws)) {
                    if (count($tws) > 0) {
                        foreach ($tws as $key => $value) { ?>
                            <option value="<?= $value->id ?>"><?= $value->tahun ?> - <?= $value->bulan_name ?></option>
                <?php }
                    }
                } ?>
            </select>
            <div class="help-block _role"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary waves-effect waves-light">Ambil Data</button>
    </div>
</form>

<script>
    // initSelect2("_role", ".content-detailModal");
    initSelect2("_bulan", ".content-detailModal");

    $("#formAddModalData").on("submit", function(e) {
        e.preventDefault();
        const bulan = document.getElementsByName('_bulan')[0].value;
        const id = document.getElementsByName('_id')[0].value;

        if (bulan === "") {
            $("select#_bulan").css("color", "#dc3545");
            $("select#_bulan").css("border-color", "#dc3545");
            $('._bulan').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih tahun bulan.</li></ul>');
            return false;
        }

        // document.location.href = "<?= base_url('sigaji/bank/tagihan/antrian/datadetail') . '?d='; ?>" + bulan;

        $.ajax({
            url: "./ambildatatagihan",
            type: 'POST',
            data: {
                tahun: bulan,
                id: id,
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
                    $('.content-detailModal').modal('hide');
                    $('.data-contens').html(resul.data);
                    $('.tomboh-ambil-data').html('<div class="tomboh-simpan-data" style="display: block;"><a class="btn btn-sm btn-success waves-effect waves-light" href="javascript:actionSimpanTagihan(this);"><i class="bx bx-save font-size-16 align-middle me-2"></i> SIMPAN</a>&nbsp;&nbsp;</div>');
                    // $('.tomboh-ambil-data').css('display', 'none');
                    // Swal.fire(
                    //     'SELAMAT!',
                    //     resul.message,
                    //     'success'
                    // ).then((valRes) => {
                    //     reloadPage();
                    // })
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