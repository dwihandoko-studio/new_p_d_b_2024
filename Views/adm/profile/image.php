<form id="formUpData" class="formUpData" action="./uploadSave" method="post" enctype="multipart/form-data">
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mt-3">
                            <label for="_file" class="form-label">Upload Foto: </label>
                            <input class="form-control" type="file" id="_file" name="_file" onFocus="inputFocus(this);" accept="image/*">
                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg">Files</code> and Maximum File Size <code>500 Kb</code></p>
                            <div class="help-block _file" for="_file"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">UPLOAD</button>
    </div>
</form>
<script>
    document.getElementById('_file').addEventListener('change', loadFile, false);

    function loadFile(e) {
        const file = e.target.files[0];

        if (file) {
            const extensionFile = file.name.split('.').pop().toLowerCase();

            var mime_types = ['image/jpg', 'image/jpeg', 'image/png'];

            if (mime_types.indexOf(file.type) == -1) {
                e.target.value = "";
                // $('.imagePreviewUpload').attr('src', '');
                Swal.fire(
                    'Warning!!!',
                    "Hanya file type gambar yang diizinkan.",
                    'warning'
                );
                return false;
            }

            if (file.size > 1 * 512 * 1000) {
                e.target.value = "";
                // $('.imagePreviewUpload').attr('src', '');
                Swal.fire(
                    'Warning!!!',
                    "Ukuran file tidak boleh lebih dari 500 Kb.",
                    'warning'
                );
                return false;
            }

            if (file.type === 'application/pdf') {

            } else {
                // var reader = new FileReader();

                // reader.onload = function(e) {
                //     $('.imagePreviewUpload').attr('src', e.target.result);
                // }

                // reader.readAsDataURL(input.files[0]);
            }

        } else {
            // console.log("failed Load");
        }
    }

    function validateForm(formElement) {
        const _file = document.getElementsByName('_file')[0];

        if ((_file.value === "" || _file.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Silahkan pilih file gambar atau pdf yang akan diupload.",
                'warning'
            ).then((valRes) => {
                // password.focus();
            });
            return false;
        }

        return true;
    }

    // Example usage: attach event listeners to form submission buttons
    const form = document.getElementById('formUpData');
    if (form) {
        form.addEventListener('submit', function(event) { // Prevent default form submission

            if (validateForm(this)) {
                event.preventDefault();
                Swal.fire({
                    title: 'Apakah anda yakin ingin mengupload gambar ini?',
                    text: "Upload: Gambar",
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Upload!'
                }).then((result) => {
                    if (result.value) {
                        const fileName = document.getElementsByName('_file')[0].value;
                        const formUpload = new FormData();
                        if (fileName === "") {
                            Swal.fire(
                                'Peringatan!',
                                "Silahkan pilih file terlebih dahulu.",
                                'warning'
                            ).then((valRes) => {
                                // password.focus();
                            });
                            return false;
                        }
                        const __file = document.getElementsByName('_file')[0].files[0];
                        formUpload.append('_file', __file);

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
                            url: "./uploadSave",
                            type: 'POST',
                            data: formUpload,
                            contentType: false,
                            cache: false,
                            processData: false,
                            dataType: 'JSON',
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Mengupload File...',
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
            } else {
                event.preventDefault();
            }
        });
    }
</script>