<form id="formAddData" class="formAddData" action="./addSave" method="post" enctype="multipart/form-data">
    <div class="modal-body">
        <div class="row">
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Judul :</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_judul" name="_judul" value="" placeholder="Judul...." required />
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mt-3">
                            <label for="_file" class="form-label">Upload File : </label>
                            <input class="form-control" type="file" id="_file" name="_file" onFocus="inputFocus(this);" accept="image/*">
                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg">Files</code> and Maximum File Size <code>2 Mb</code></p>
                            <div class="help-block _file" for="_file"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">SIMPAN</button>
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
                    "Hanya file type gambar dan pdf yang diizinkan.",
                    'warning'
                );
                return false;
            }

            if (file.size > 2 * 1024 * 1000) {
                e.target.value = "";
                // $('.imagePreviewUpload').attr('src', '');
                Swal.fire(
                    'Warning!!!',
                    "Ukuran file tidak boleh lebih dari 2 Mb.",
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

    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    function validateForm(formElement) {
        const judul = document.getElementsByName('_judul')[0];

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
    const form = document.getElementById('formAddData');
    if (form) {
        form.addEventListener('submit', function(event) { // Prevent default form submission

            if (validateForm(this)) {
                event.preventDefault();
                const nama = document.getElementsByName('_judul')[0].value;
                Swal.fire({
                    title: 'Apakah anda yakin ingin menyimpan data ini?',
                    text: "Tambah Data Gambar: " + nama,
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, SIMPAN!'
                }).then((result) => {
                    if (result.value) {
                        const fileName = document.getElementsByName('_file')[0].value;
                        const formUpload = new FormData();
                        if (fileName !== "") {
                            const __file = document.getElementsByName('_file')[0].files[0];
                            formUpload.append('_file', __file);
                        }
                        formUpload.append('_judul', nama);

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
                            url: "./addSave",
                            type: 'POST',
                            data: formUpload,
                            contentType: false,
                            cache: false,
                            processData: false,
                            dataType: 'JSON',
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Menyimpan data...',
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