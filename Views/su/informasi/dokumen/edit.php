<form id="formEditData" class="formEditData" action="./editSave" method="post">
    <input type="hidden" id="_id" name="_id" value="<?= $data->id ?>" />
    <div class="modal-body">
        <div class="row">
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_nama" name="_nama" value="<?= $data->nama ?>" placeholder="Nama Lengkap" required />
                    <p class="font-size-11"> &nbsp;Nama akan publikasi di bagian kepanitian PPDB Sekolah.</p>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Jabatan Sekolah</label>
                <div class="col-sm-9">
                    <select class="default-select form-control wide mb-3" id="_jabatan" name="_jabatan" required>
                        <option value=""> -- Pilih --</option>
                        <option value="Kepala Sekolah" <?= $data->jabatan === "Kepala Sekolah" ? ' selected' : '' ?>>Kepala Sekolah</option>
                        <option value="Wakil Kepala Sekolah" <?= $data->jabatan === "Wakil Kepala Sekolah" ? ' selected' : '' ?>>Wakil Kepala Sekolah</option>
                        <option value="Guru Kelas / Guru Mapel" <?= $data->jabatan === "Guru Kelas / Guru Mapel" ? ' selected' : '' ?>>Guru Kelas / Guru Mapel</option>
                        <option value="Tendik" <?= $data->jabatan === "Tendik" ? ' selected' : '' ?>>Tendik</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Jabatan Kepanitiaan</label>
                <div class="col-sm-9">
                    <select class="default-select form-control wide mb-3" id="_jabatan_ppdb" name="_jabatan_ppdb" required>
                        <option value=""> -- Pilih --</option>
                        <option value="1" <?= $data->jabatan_ppdb === "1" ? ' selected' : '' ?>>Penanggung Jawab</option>
                        <option value="2" <?= $data->jabatan_ppdb === "2" ? ' selected' : '' ?>>Ketua</option>
                        <option value="3" <?= $data->jabatan_ppdb === "3" ? ' selected' : '' ?>>Wakil Ketua</option>
                        <option value="4" <?= $data->jabatan_ppdb === "4" ? ' selected' : '' ?>>Sekretaris</option>
                        <option value="5" <?= $data->jabatan_ppdb === "5" ? ' selected' : '' ?>>Bendahara</option>
                        <option value="6" <?= $data->jabatan_ppdb === "6" ? ' selected' : '' ?>>Anggota</option>
                    </select>
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
        const nama = document.getElementsByName('_nama')[0];
        const jabatan = document.getElementsByName('_jabatan')[0];
        const jabatan_ppdb = document.getElementsByName('_jabatan_ppdb')[0];

        if ((nama.value === "" || nama.value === undefined)) {
            nama.focus();
            return false;
        }
        if ((jabatan.value === "" || jabatan.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Silahkan pilih jabatan.",
                'warning'
            ).then((valRes) => {
                // password.focus();
            });
            return false;
        }
        if ((jabatan_ppdb.value === "" || jabatan_ppdb.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Silahkan pilih jabatan kepanitiaan.",
                'warning'
            ).then((valRes) => {
                // password.focus();
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
                const nama = document.getElementsByName('_nama')[0].value;
                Swal.fire({
                    title: 'Apakah anda yakin ingin menupdate data ini?',
                    text: "Update Data Panitia: " + nama,
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, SIMPAN!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "./editSave",
                            type: 'POST',
                            data: $(this).serialize(),
                            dataType: 'JSON',
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Mengupdate data Panitia...',
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
                    }
                });
            } else {}
        });
    }
</script>