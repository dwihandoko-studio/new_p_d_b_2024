<?= $this->extend('t-verval/sek/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Pengguna</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form id="formEditData" class="formEditData" action="./editSave" method="post">
                                <input type="hidden" id="_id" name="_id" value="<?= $user->id ?>">
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Username</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="_username" name="_username" class="form-control" value="<?= $user->username ?>" readonly />
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Nama Pengguna</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="_nama" name="_nama" value="<?= $user->nama ?>" required />
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="_email" name="_email" value="<?= $user->email ?>" required />
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">NO HP</label>
                                    <div class="col-sm-9">
                                        <input type="phone" class="form-control" id="_nohp" name="_nohp" value="<?= $user->nohp ?>" required />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-6" style="float: inline-end;">
                                        <button type="submit" style="width: 100%;" class="btn btn-sm btn-primary waves-effect waves-light">SIMPAN</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="content-mapModal" class="modal fade content-mapModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-mapModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="content-mapBodyModal">
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
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
        if ((password.value === "" || password.value === undefined)) {
            password.focus();
            return false;
        }
        if ((password.value.length < 6)) {
            password.focus();
            return false;
        }
        if (!(password.value === "" || password.value === undefined)) {
            if (!(password.value === repassword.value)) {
                repassword.focus();
                return false;
            }
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
                            url: "./editSave",
                            type: 'POST',
                            data: $(this).serialize(),
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
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.js"></script>
<?= $this->endSection(); ?>