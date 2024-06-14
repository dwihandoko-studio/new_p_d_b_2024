<form id="formAddData" class="formAddData" action="./addSave" method="post">
    <div class="modal-body">
        <div class="row">
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_nama" name="_nama" value="" placeholder="Nama Lengkap" required />
                    <p class="font-size-11"> &nbsp;Nama akan publikasi di bagian kepanitian PPDB Sekolah.</p>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="_email" name="_email" placeholder="example@xxx.com" required />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">NO HP</label>
                <div class="col-sm-9">
                    <input type="phone" class="form-control" id="_nohp" name="_nohp" placeholder="628xxxxxxxxxx" required />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Jabatan Sekolah</label>
                <div class="col-sm-9">
                    <select class="default-select form-control wide mb-3" id="_jabatan" name="_jabatan">
                        <option value=""> -- Pilih --</option>
                        <option value="Kepala Sekolah">Kepala Sekolah</option>
                        <option value="Wakil Kepala Sekolah">Wakil Kepala Sekolah</option>
                        <option value="Guru Kelas / Guru Mapel">Guru Kelas / Guru Mapel</option>
                        <option value="Tendik">Tendik</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Jabatan Kepanitiaan</label>
                <div class="col-sm-9">
                    <select class="default-select form-control wide mb-3" id="_jabatan_ppdb" name="_jabatan_ppdb">
                        <option value=""> -- Pilih --</option>
                        <option value="1">Penanggung Jawab</option>
                        <option value="2">Ketua</option>
                        <option value="3">Wakil Ketua</option>
                        <option value="4">Sekretaris</option>
                        <option value="5">Bendahara</option>
                        <option value="6">Anggota</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                    <div class="input-group auth-pass-inputgroup">
                        <input type="password" class="form-control" id="_password" name="_password" placeholder="******" aria-label="Password" aria-describedby="password-addon" required />
                        <button class="btn btn-light " type="button" onclick="showHidePassword(this);" id="password-addon"><i class="mdi mdi-eye-outline" id="eye-icon-password"></i></button>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Ulangi Password</label>
                <div class="col-sm-9">
                    <div class="input-group auth-pass-inputgroup">
                        <input type="password" class="form-control" id="_repassword" name="_repassword" placeholder="******" aria-label="Password" aria-describedby="repassword-addon" required />
                        <button class="btn btn-light " type="button" onclick="showHideRePassword(this);" id="repassword-addon"><i class="mdi mdi-eye-outline" id="eye-icon-repassword"></i></button>
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
    function showHidePassword(event) {
        const showedPassword = document.getElementById("_password");
        const eyeIcon = event.querySelector('#eye-icon-password');
        if (showedPassword.type === "password") {
            showedPassword.type = "text";
            showedPassword.placeholder = "Masukkan password. . .";
            eyeIcon.classList.remove('mdi-eye-outline');
            eyeIcon.classList.add('mdi-eye-off-outline');
            // btnPassword.html('<i class="mdi mdi-eye-off-outline"></i>');
        } else {
            showedPassword.type = "password";
            showedPassword.placeholder = "******";
            eyeIcon.classList.remove('mdi-eye-off-outline');
            eyeIcon.classList.add('mdi-eye-outline');
            // btnPassword.html('<i class="mdi mdi-eye-outline"></i>');
        }
    }

    function showHideRePassword(event) {
        const showedRePassword = document.getElementById("_repassword");
        const eyeIconRe = event.querySelector('#eye-icon-repassword');
        if (showedRePassword.type === "password") {
            showedRePassword.type = "text";
            showedRePassword.placeholder = "Masukkan ulangi password. . .";
            eyeIconRe.classList.remove('mdi-eye-outline');
            eyeIconRe.classList.add('mdi-eye-off-outline');
            // btnPassword.html('<i class="mdi mdi-eye-off-outline"></i>');
        } else {
            showedRePassword.type = "password";
            showedRePassword.placeholder = "******";
            eyeIconRe.classList.remove('mdi-eye-off-outline');
            eyeIconRe.classList.add('mdi-eye-outline');
            // btnPassword.html('<i class="mdi mdi-eye-outline"></i>');
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
        const password = document.getElementsByName('_password')[0];
        const repassword = document.getElementsByName('_repassword')[0];
        const jabatan = document.getElementsByName('_jabatan')[0];
        const jabatan_ppdb = document.getElementsByName('_jabatan_ppdb')[0];

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
        if ((jabatan.value === "" || jabatan.value === undefined)) {
            jabatan.focus();
            return false;
        }
        if ((jabatan_ppdb.value === "" || jabatan_ppdb.value === undefined)) {
            jabatan_ppdb.focus();
            return false;
        }
        if ((password.value === "" || password.value === undefined)) {
            password.focus();
            return false;
        }
        if ((password.value.length < 6)) {
            Swal.fire(
                'Peringatan!',
                "Panjang password minimal 6 Karakter.",
                'warning'
            ).then((valRes) => {
                password.focus();
            });
            return false;
        }
        if (!(password.value === "" || password.value === undefined)) {
            if (!(password.value === repassword.value)) {
                Swal.fire(
                    'Peringatan!',
                    "Password dan Ulangi-Password tidak sama",
                    'warning'
                ).then((valRes) => {
                    repassword.focus();
                });
                return false;
            }
        }

        return true;
    }

    // Example usage: attach event listeners to form submission buttons
    const form = document.getElementById('formAddData');
    if (form) {
        form.addEventListener('submit', function(event) { // Prevent default form submission

            if (validateForm(this)) {
                event.preventDefault();
                const nama = document.getElementsByName('_nama')[0].value;
                Swal.fire({
                    title: 'Apakah anda yakin ingin menyimpan data ini?',
                    text: "Tambah Data Panitia: " + nama,
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, SIMPAN!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "./addSave",
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