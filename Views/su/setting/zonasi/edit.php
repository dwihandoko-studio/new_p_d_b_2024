<form id="formEditData" class="formEditData" action="./editSave" method="post">
    <input type="hidden" id="_id" name="_id" value="<?= $data->sekolah_id ?>" />
    <div class="modal-body">
        <div class="row">
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Nama Sekolah</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_nama" name="_nama" value="<?= $data->nama ?>" readonly />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">NPSN</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_email" name="_email" value="<?= $data->npsn ?>" readonly />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Jenjang Pendidikan</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_jenjang" name="_jenjang" value="<?= $data->bentuk_pendidikan ?>" readonly />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Kecamatan</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_kecamatan" name="_kecamatan" value="<?= $data->kecamatan ?>" readonly />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Jumlah Kebutuhan Rombel</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" id="_kebutuhan" name="_kebutuhan" value="<?= $data->jumlah_rombel_kebutuhan ?>" required />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Radius Zonasi</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" id="_radius" name="_radius" value="<?= $data->radius_zonasi ?>" required />
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">UPDATE</button>
    </div>
</form>
<script>
    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    function validateForm(formElement) {
        const id = document.getElementsByName('_id')[0];
        const kebutuhan = document.getElementsByName('_kebutuhan')[0];
        const radius = document.getElementsByName('_radius')[0];

        if ((kebutuhan.value === "" || kebutuhan.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Kebutuhan Rombel tidak boleh kosong.",
                'warning'
            ).then((valRes) => {
                kebutuhan.focus();
            });
            return false;
        }

        if ((radius.value === "" || radius.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Radius tidak boleh kosong.",
                'warning'
            ).then((valRes) => {
                radius.focus();
            });
            return false;
        }

        return true;
    }

    // Example usage: attach event listeners to form submission buttons
    const form = document.getElementById('formEditData');
    if (form) {
        form.addEventListener('submit', function(event) { // Prevent default form submission
            event.preventDefault();
            if (validateForm(this)) {
                // event.preventDefault();
                const nama = document.getElementsByName('_nama')[0].value;
                Swal.fire({
                    title: 'Apakah anda yakin ingin menyimpan data ini?',
                    text: "Update Data Kuota Sekolah: " + nama,
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, UPDATE!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "./editSave",
                            type: 'POST',
                            data: $(this).serialize(),
                            dataType: 'JSON',
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Menyimpan data Panitia...',
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
            } else {
                // event.preventDefault();
            }
        });
    }
</script>