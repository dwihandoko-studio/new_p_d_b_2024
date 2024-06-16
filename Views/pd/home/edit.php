<?php if (isset($user)) { ?>
    <form id="formEditData" class="formEditData" action="./editSave" method="post" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
                <input type="hidden" id="_id" name="_id" value="<?= $user->id ?>">
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Username</label>
                    <div class="col-sm-9">
                        <input type="text" id="_username" name="_username" class="form-control" value="<?= $user->username ?>" readonly />
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="_nama" name="_nama" value="<?= $user->nama ?>" placeholder="Nama Lengkap" readonly />
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <div class="input-group   input-primary">
                            <span class="input-group-text">Email</span>
                            <input type="email" class="form-control" id="_email" name="_email" value="<?= $user->email ?>" placeholder="example@example.com" required />
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">NO HP</label>
                    <div class="col-sm-9">
                        <div class="input-group   input-primary">
                            <span class="input-group-text">NOHP</span>
                            <input type="phone" class="form-control" id="_nohp" name="_nohp" value="<?= $user->nohp ?>" placeholder="628xxxxxxxxx" required />
                        </div>
                    </div>
                </div>
                <div class="mt-3 mb-3 row">
                    <label class="col-sm-3 col-form-label">Upload Foto: </label>
                    <div class="col-sm-9">
                        <input class="form-control" type="file" id="_file" name="_file" onFocus="inputFocus(this);" accept="image/*">
                        <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg">Files</code> and Maximum File Size <code>500 Kb</code></p>
                        <div class="help-block _file" for="_file"></div>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">UPDATE</button>
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

        function inputFocus(id) {
            const color = $(id).attr('id');
            $(id).removeAttr('style');
            $('.' + color).html('');
        }

        function validateForm(formElement) {
            const nama = document.getElementsByName('_nama')[0];
            const email = document.getElementsByName('_email')[0];
            const nohp = document.getElementsByName('_nohp')[0];
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

            if ((nama.value === "" || nama.value === undefined)) {
                nama.focus();
                return false;
            }

            if ((email.value === "" || email.value === undefined)) {
                email.focus();
                return false;
            }

            if ((nohp.value === "" || nohp.value === undefined)) {
                nohp.focus();
                return false;
            }

            return true;
        }

        // Example usage: attach event listeners to form submission buttons
        const form = document.getElementById('formEditData');
        if (form) {
            form.addEventListener('submit', function(event) { // Prevent default form submission

                if (validateForm(this)) {
                    event.preventDefault();
                    const username = document.getElementsByName('_username')[0].value;
                    const _nama = document.getElementsByName('_nama')[0].value;
                    const _email = document.getElementsByName('_email')[0].value;
                    const _nohp = document.getElementsByName('_nohp')[0].value;
                    const fileName = document.getElementsByName('_file')[0].value;
                    const formUpload = new FormData();
                    if (fileName === "") {
                        Swal.fire(
                            'Peringatan!',
                            "Silahkan pilih gambar terlebih dahulu.",
                            'warning'
                        ).then((valRes) => {
                            // password.focus();
                        });
                        return false;
                    }
                    const __file = document.getElementsByName('_file')[0].files[0];
                    formUpload.append('_file', __file);
                    formUpload.append('_nama', _nama);
                    formUpload.append('_email', _email);
                    formUpload.append('_nohp', _nohp);

                    Swal.fire({
                        title: 'Apakah anda yakin ingin menyimpan data ini?',
                        text: "Update Data Pengguna: " + username,
                        showCancelButton: true,
                        icon: 'question',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, UPDATE!'
                    }).then((result) => {
                        if (result.value) {
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
                                        title: 'Menyimpan data Pengguna...',
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
                    event.preventDefault();
                }
            });
        }
    </script>
<?php } ?>