<form id="formAddModalData" action="./addSave" method="post">
    <div class="modal-body">
        <div class="mb-3">
            <label for="_bulan" class="col-form-label">Tahun Bulan:</label>
            <select class="form-control" id="_bulan" name="_bulan" required style="width: 100%">
                <option value="">--Pilih--</option>
                <?php if (isset($bulans)) {
                    if (count($bulans) > 0) {
                        foreach ($bulans as $key => $value) { ?>
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
        <button type="submit" class="btn btn-primary waves-effect waves-light">Lanjutkan</button>
    </div>
</form>

<script>
    // initSelect2("_role", ".content-detailModal");
    initSelect2("_bulan", ".content-detailModal");

    $("#formAddModalData").on("submit", function(e) {
        e.preventDefault();
        const bulan = document.getElementsByName('_bulan')[0].value;

        if (bulan === "") {
            $("select#_bulan").css("color", "#dc3545");
            $("select#_bulan").css("border-color", "#dc3545");
            $('._bulan').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih tahun bulan.</li></ul>');
            return false;
        }

        document.location.href = "<?= base_url('sigaji/bank/tagihan/antrian/datadetail') . '?d='; ?>" + bulan;

        // $.ajax({
        //     url: "./addSave",
        //     type: 'POST',
        //     data: {
        //         role: role,
        //         pengguna: pengguna,
        //     },
        //     dataType: 'JSON',
        //     beforeSend: function() {
        //         $('div.modal-content-loading').block({
        //             message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
        //         });
        //     },
        //     success: function(resul) {
        //         $('div.modal-content-loading').unblock();

        //         if (resul.status !== 200) {
        //             if (resul.status !== 201) {
        //                 if (resul.status === 401) {
        //                     Swal.fire(
        //                         'Failed!',
        //                         resul.message,
        //                         'warning'
        //                     ).then((valRes) => {
        //                         reloadPage();
        //                     });
        //                 } else {
        //                     Swal.fire(
        //                         'GAGAL!',
        //                         resul.message,
        //                         'warning'
        //                     );
        //                 }
        //             } else {
        //                 Swal.fire(
        //                     'Peringatan!',
        //                     resul.message,
        //                     'success'
        //                 ).then((valRes) => {
        //                     reloadPage();
        //                 })
        //             }
        //         } else {
        //             Swal.fire(
        //                 'SELAMAT!',
        //                 resul.message,
        //                 'success'
        //             ).then((valRes) => {
        //                 reloadPage();
        //             })
        //         }
        //     },
        //     error: function() {
        //         $('div.modal-content-loading').unblock();
        //         Swal.fire(
        //             'PERINGATAN!',
        //             "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
        //             'warning'
        //         );
        //     }
        // });
    });
</script>