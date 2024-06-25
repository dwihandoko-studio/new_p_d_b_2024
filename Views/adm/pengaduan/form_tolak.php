<form id="formTolakData" class="formTolakData" action="./tolakSave" method="post">
    <input type="hidden" id="_id_tolak" name="_id_tolak" value="<?= $data->no_tiket ?>" />
    <input type="hidden" id="_nama_tolak" name="_nama_tolak" value="<?= replaceTandaBacaPetik($data->nama_pengadu) ?>" />
    <div class="modal-body">
        <div class="row">
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Keterangan alasan penolakan pengaduan :</label>
                <div class="col-sm-9">
                    <textarea rows="10" class="form-control" id="_keterangan_penolakan" name="_keterangan_penolakan" placeholder="Ketikkan alasan penolakan pengaduan..." required></textarea>
                    <!-- <p class="font-size-11"> &nbsp;Nama akan publikasi di bagian kepanitian PPDB Sekolah.</p> -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">TOLAK & SIMPAN</button>
    </div>
</form>
<script>
    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    function validateFormTolak(formElement) {
        const keterangan_penolakan = document.getElementsByName('_keterangan_penolakan')[0];

        if ((keterangan_penolakan.value === "" || keterangan_penolakan.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Silahkan pilih jabatan.",
                'warning'
            ).then((valRes) => {
                keterangan_penolakan.focus();
            });
            return false;
        }
        return true;
    }

    // Example usage: attach event listeners to form submission buttons
    const formTolak = document.getElementById('formTolakData');
    if (formTolak) {
        formTolak.addEventListener('submit', function(event) { // Prevent default form submission
            const nama = this.querySelector('#_nama_tolak').value;
            event.preventDefault();
            if (validateFormTolak(this)) {
                Swal.fire({
                    title: 'Apakah anda yakin ingin menolak data pengaduan ' + nama + '?',
                    text: "Tolak verifikasi pengaduan dengan keterangan sesuai isian",
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, TOLAK & SIMPAN!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "./tolakSave",
                            type: 'POST',
                            data: $(this).serialize(),
                            dataType: 'JSON',
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Sedang loading...',
                                    text: 'Please wait while we process your action.',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
                            },
                            complete: function() {},
                            success: function(resul) {

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
                                        'BERHASIL!',
                                        resul.message,
                                        'success'
                                    ).then((valRes) => {
                                        reloadPage(resul.url);
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
                    }
                });
            } else {}
        });
    }
</script>