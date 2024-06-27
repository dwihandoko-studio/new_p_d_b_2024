<form id="formCabutBerkasData" class="formCabutBerkasData" action="./cabutBerkasSave" method="post">
    <input type="hidden" id="_id_cabut_berkas" name="_id_cabut_berkas" value="<?= $data->id ?>" />
    <input type="hidden" id="_koreg_cabut_berkas" name="_koreg_cabut_berkas" value="<?= $data->kode_pendaftaran ?>" />
    <input type="hidden" id="_nama_cabut_berkas" name="_nama_cabut_berkas" value="<?= replaceTandaBacaPetik($data->nama_peserta) ?>" />
    <div class="modal-body">
        <div class="row">
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Keterangan alasan cabut berkas pendaftaran :</label>
                <div class="col-sm-9">
                    <textarea rows="10" class="form-control" id="_keterangan_cabut_berkas" name="_keterangan_cabut_berkas" placeholder="Ketikkan alasan cabut berkas pendaftaran..." required></textarea>
                    <!-- <p class="font-size-11"> &nbsp;Nama akan publikasi di bagian kepanitian PPDB Sekolah.</p> -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">CABUT & SIMPAN</button>
    </div>
</form>
<script>
    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    function validateFormTolak(formElement) {
        const keterangan_penolakan = document.getElementsByName('_keterangan_cabut_berkas')[0];

        if ((keterangan_penolakan.value === "" || keterangan_penolakan.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Silahkan masukan keterangan cabut berkas.",
                'warning'
            ).then((valRes) => {
                keterangan_penolakan.focus();
            });
            return false;
        }
        return true;
    }

    // Example usage: attach event listeners to form submission buttons
    const formTolak = document.getElementById('formCabutBerkasData');
    if (formTolak) {
        formTolak.addEventListener('submit', function(event) { // Prevent default form submission
            const nama = this.querySelector('#_nama_cabut_berkas').value;
            event.preventDefault();
            if (validateFormTolak(this)) {
                Swal.fire({
                    title: 'Apakah anda yakin ingin menyimpan data cabut berkas pendaftaran ' + nama + '?',
                    text: "Cabut berkas verifikasi pendaftaran dengan keterangan sesuai isian",
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, CABUT & SIMPAN!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "./cabutBerkasSave",
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