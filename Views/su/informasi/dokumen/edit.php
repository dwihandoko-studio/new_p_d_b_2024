<form id="formEditData" class="formEditData" action="./editSave" method="post">
    <input type="hidden" id="_id_edit" name="_id_edit" value="<?= $data->id ?>" />
    <div class="modal-body">
        <div class="row">
            <div class="mb-3 row">
                <label for="_tujuan_edit" class="col-form-label">Tujuan:</label>
                <select class="form-control" id="_tujuan_edit" name="_tujuan_edit" width="100%" style="width: 100%;" required>
                    <option value="">--Pilih--</option>
                    <option value="3" <?= (int)$data->tujuan == 3 ? ' selected' : '' ?>>Admin Sekolah / Panitia Sekolah</option>
                    <option value="5" <?= (int)$data->tujuan == 5 ? ' selected' : '' ?>>Peserta Didik PPDB</option>
                </select>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Judul :</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_judul_edit" name="_judul_edit" value="<?= $data->judul ?>" placeholder="Judul...." required />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Deskripsi :</label>
                <div class="col-sm-12">
                    <textarea name="_deskripsi_edit" id="_deskripsi_edit"><?= $data->deskripsi ?></textarea>
                </div>
            </div>
            <!-- <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mt-3">
                            <label for="_file" class="form-label">Upload File : </label>
                            <input class="form-control" type="file" id="_file" name="_file" onFocus="inputFocus(this);" accept="image/*,application/pdf">
                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="pdf, jpg, png, jpeg">Files</code> and Maximum File Size <code>2 Mb</code></p>
                            <div class="help-block _file" for="_file"></div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">UPDATE</button>
    </div>
</form>
<script>
    ClassicEditor.create(document.querySelector("#_deskripsi_edit"), {})
        .then((e) => {
            window.editor = e;
        })
        .catch((e) => {
            console.error(e.stack);
        });

    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    function validateFormEdit(formElement) {
        const editorData = $('#_deskripsi_edit').val();
        const judul = document.getElementsByName('_judul_edit')[0];

        if (judul.value === "" || judul.value === undefined) {
            Swal.fire(
                'Peringatan!',
                "Silahkan masukkan judul.",
                'warning'
            ).then((valRes) => {
                repassword.focus();
            });
            return false;
        }

        return true;
    }

    // Example usage: attach event listeners to form submission buttons
    const formEdit = document.getElementById('formEditData');
    if (formEdit) {
        formEdit.addEventListener('submit', function(event) { // Prevent default form submission
            event.preventDefault();
            if (validateFormEdit(this)) {
                const tujuan = document.getElementsByName('_tujuan_edit')[0].value;
                const nama = document.getElementsByName('_judul_edit')[0].value;
                const id = document.getElementsByName('_id_edit')[0].value;
                Swal.fire({
                    title: 'Apakah anda yakin ingin menupdate data ini?',
                    text: "Update Data Informasi: ",
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Update!'
                }).then((result) => {
                    if (result.value) {
                        const deskripsi = $('#_deskripsi_edit').val();
                        const formUpload = new FormData();
                        formUpload.append('_id', id);
                        formUpload.append('_tujuan', tujuan);
                        formUpload.append('_judul', nama);
                        formUpload.append('_deskripsi', deskripsi);

                        $.ajax({
                            xhr: function() {
                                let xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress", function(evt) {
                                    if (evt.lengthComputable) {
                                        // ambilId("loaded_n_total").innerHTML = "Uploaded " + evt.loaded + " bytes of " + evt.total;
                                        // var percent = (evt.loaded / evt.total) * 100;
                                        // ambilId("progressBar").value = Math.round(percent);
                                        // ambilId("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
                                    }
                                }, false);
                                return xhr;
                            },
                            url: "./editSave",
                            type: 'POST',
                            data: formUpload,
                            contentType: false,
                            cache: false,
                            processData: false,
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