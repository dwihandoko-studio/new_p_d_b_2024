<?php if (isset($data)) { ?>
    <form id="formEditModalData" action="./editSave" method="post">
        <input type="hidden" id="_id" name="_id" value="<?= $data->id ?>" />
        <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
            <div class="mb-3">
                <label for="_besar_pinjaman" class="form-label">Besar Pinjaman</label>
                <input type="text" class="form-control besar_pinjaman" value="<?= $data->besar_pinjaman ?>" id="_besar_pinjaman" name="_besar_pinjaman" placeholder="Besar Pinjaman..." onfocusin="inputFocus(this);">
                <div class="help-block _besar_pinjaman"></div>
            </div>
            <div class="mb-3">
                <label for="_jumlah_tagihan" class="form-label">Jumlah Tagihan</label>
                <input type="text" class="form-control jumlah_tagihan" value="<?= $data->jumlah_tagihan ?>" id="_jumlah_tagihan" name="_jumlah_tagihan" placeholder="Jumlah tagihan..." onfocusin="inputFocus(this);">
                <div class="help-block _jumlah_tagihan"></div>
            </div>
            <div class="mb-3">
                <label for="_jumlah_bulan_angsuran" class="form-label">Jumlah Bulan Angsuran</label>
                <input type="text" class="form-control jumlah_bulan_angsuran" value="<?= $data->jumlah_bulan_angsuran ?>" id="_jumlah_bulan_angsuran" name="_jumlah_bulan_angsuran" placeholder="Jumlah bulan angsuran..." onfocusin="inputFocus(this);">
                <div class="help-block _jumlah_bulan_angsuran"></div>
            </div>
            <div class="mb-3">
                <label for="_angsuran_ke" class="form-label">Angsuran Ke</label>
                <input type="text" class="form-control angsuran_ke" value="<?= $data->angsuran_ke ?>" id="_angsuran_ke" name="_angsuran_ke" placeholder="Angsuran ke..." onfocusin="inputFocus(this);">
                <div class="help-block _angsuran_ke"></div>
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
            const besar_pinjaman = document.getElementsByName('_besar_pinjaman')[0].value;
            const jumlah_tagihan = document.getElementsByName('_jumlah_tagihan')[0].value;
            const jumlah_bulan_angsuran = document.getElementsByName('_jumlah_bulan_angsuran')[0].value;
            const angsuran_ke = document.getElementsByName('_angsuran_ke')[0].value;

            Swal.fire({
                title: 'Apakah anda yakin ingin mengupdate data ini?',
                text: "Update Data Tagihan Bank Eka Metro: <?= $nama ?>",
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
                            besar_pinjaman: besar_pinjaman,
                            jumlah_tagihan: jumlah_tagihan,
                            jumlah_bulan_angsuran: jumlah_bulan_angsuran,
                            angsuran_ke: angsuran_ke,
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