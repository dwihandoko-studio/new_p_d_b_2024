<form id="formEditKontakData" class="formEditKontakData" action="./saveChangeKontak" method="post">
    <input type="hidden" id="_id_tiket_pengaduan" name="_id_tiket_pengaduan" value="<?= $data->no_tiket ?>" />
    <div class="modal-body">
        <div class="row">
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="_email_tiket_pengaduan" name="_email_tiket_pengaduan" value="<?= $data->email_pengadu ?>" placeholder="Email..." required />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">No WA</label>
                <div class="col-sm-9">
                    <input type="phone" class="form-control" id="_nohp_tiket_pengaduan" name="_nohp_tiket_pengaduan" minlength="9" maxlength="16" value="<?= $data->nohp_pengadu ?>" placeholder="Email..." required />
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">UPDATE KONTAK</button>
    </div>
</form>
<script>
    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }
    const formEditKontak = document.getElementById('formEditKontakData');
    if (formEditKontak) {
        formEditKontak.addEventListener('submit', function(event) { // Prevent default form submission

            event.preventDefault();
            const emailPengaduan = document.getElementsByName('_email_tiket_pengaduan')[0].value;
            const nohpPengaduan = document.getElementsByName('_nohp_tiket_pengaduan')[0].value;
            $.ajax({
                url: "./saveChangeKontak",
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'JSON',
                beforeSend: function() {
                    Swal.fire({
                        title: 'Mengupdate data...',
                        text: 'Please wait while we process your action.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                complete: function() {},
                success: function(response) {

                    if (response.status !== 200) {
                        Swal.fire(
                            'Peringatan!',
                            response.message,
                            'warning'
                        ).then((valRes) => {
                            reloadPage();
                        })
                    } else {
                        Swal.fire(
                            'BERHASIL!',
                            response.message,
                            'success'
                        ).then((valResT) => {
                            reloadPage();
                        })
                    }
                },
                error: function() {
                    Swal.fire(
                        'PERINGATAN!',
                        "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                        'warning'
                    );
                }
            });

        });
    }
</script>