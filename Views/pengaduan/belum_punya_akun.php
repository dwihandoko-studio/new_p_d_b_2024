<div class="mb-3 row">
    <label class="col-sm-3 col-form-label">Status Peserta :</label>
    <div class="col-sm-9">
        <select class="form-control" id="_jenis_pd" name="_jenis_pd" onchange="changedStatusPeserta(this)" width="100%" style="width: 100%;" required>
            <option value="">--Pilih--</option>
            <option value="sudah">Sudah Sekolah</option>
            <option value="belum">Belum Sekolah</option>
        </select>
    </div>
</div>
<div class="col-12 content-sudah-sekolah" id="content-sudah-sekolah" style="display: none;">
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">NISN</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="_nisn" name="_nisn" value="" placeholder="NISN..." />
        </div>
    </div>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">NPSN</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="_npsn" name="_npsn" placeholder="NPSN..." />
        </div>
    </div>
</div>
<div class="col-12 content-belum-sekolah" id="content-belum-sekolah" style="display: none;">
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">NIK</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="_nik" name="_nik" value="" placeholder="NIK..." />
        </div>
    </div>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">No. Kartu Keluarga</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="_kk" name="_kk" placeholder="Nomor Kartu Keluarga..." />
        </div>
    </div>
</div>
<div class="col-12 mt-5">
    <button type="button" onclick="actionCekDataPd(this)" class="btn btn-block btn-primary">CEK DATA</button>
</div>
<script>
    function changedStatusPeserta(event) {
        const selectedOption = event.value;
        if (selectedOption === "" || selectedOption === undefined) {
            $('.content-sudah-sekolah').css('display', 'none');
            $('.content-belum-sekolah').css('display', 'none');
        } else {
            if (selectedOption === "sudah") {
                $('.content-sudah-sekolah').css('display', 'block');
                $('.content-belum-sekolah').css('display', 'none');
            } else if (selectedOption === "belum") {
                $('.content-sudah-sekolah').css('display', 'none');
                $('.content-belum-sekolah').css('display', 'block');
            } else {
                $('.content-sudah-sekolah').css('display', 'none');
                $('.content-belum-sekolah').css('display', 'none');
            }
        }
    }

    function actionCekDataPd(event) {
        const jenisPd = document.getElementsByName('_jenis_pd')[0].value;
        if (jenis === "sudah") {
            const nisn = document.getElementsByName('_nisn')[0].value;
            const npsn = document.getElementsByName('_npsn')[0].value;
            $.ajax({
                url: "./cekDataPd",
                type: 'POST',
                data: {
                    jenis: jenis,
                    nisn: nisn,
                    npsn: npsn,
                },
                dataType: 'JSON',
                beforeSend: function() {
                    Swal.fire({
                        title: 'Sedang Loading...',
                        text: 'Please wait while we process your action.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                complete: function() {},
                success: function(response) {
                    if (response.status == 200) {
                        Swal.close();
                        $('#content-dataPdModalLabel').html('DATA PESERTA');
                        $('.content-dataPdModalBody').html(response.data);
                        $('.content-dataPdModal').modal({
                            backdrop: 'static',
                            keyboard: false,
                        });
                        $('.content-dataPdModal').modal('show');
                    } else {
                        Swal.fire(
                            'Failed!',
                            response.message,
                            'warning'
                        );
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
        // const nik = document.getElementsByName('_nik')[0].value;
        // const kk = document.getElementsByName('_kk')[0].value;

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