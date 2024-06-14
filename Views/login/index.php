<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="Verval Data Peserta Didik, Verval PD, Disdikbud, disdik, dinas pendidikan, Dinas Pendidikan dan Kebudayaan, Dinas Pendidikan dan Kebudayaan Kabupaten Lampung Tengah" />
    <meta name="author" content="esline.id" />
    <meta name="description" content="Verval Data Peserta Didik Tingkat Akhir Dinas Pendidikan dan Kebudayaan Kabupaten Lampung Tengah" />
    <meta property="og:url" content="<?= base_url() ?>" />
    <meta property="og:title" content="Portal Verval Data Peserta Didik Tingkat Akhir Disdikbud Kab. Lampung Tengah" />
    <meta property="og:description" content="Verval Data Peserta Didik Tingkat Akhir Dinas Pendidikan dan Kebudayaan Kabupaten Lampung Tengah" />
    <meta property="og:image" content="<?= base_url('favicon/android-icon-192x192.png'); ?>" />
    <meta name="format-detection" content="telephone=no">

    <!-- PAGE TITLE HERE -->
    <title><?= isset($title) ? $title : "Halaman Login" ?></title>

    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon icon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?= base_url('favicon/apple-icon-57x57.png'); ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url('favicon/apple-icon-60x60.png'); ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url('favicon/apple-icon-72x72.png'); ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('favicon/apple-icon-76x76.png'); ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url('favicon/apple-icon-114x114.png'); ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url('favicon/apple-icon-120x120.png'); ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url('favicon/apple-icon-144x144.png'); ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url('favicon/apple-icon-152x152.png'); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('favicon/apple-icon-180x180.png'); ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= base_url('favicon/android-icon-192x192.png'); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('favicon/favicon-32x32.png'); ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url('favicon/favicon-96x96.png'); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('favicon/favicon-16x16.png'); ?>">
    <link rel="manifest" href="<?= base_url('favicon/manifest.json'); ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?= base_url('favicon/ms-icon-144x144.png'); ?>">
    <meta name="theme-color" content="#ffffff">
    <link href="<?= base_url() ?>/assets/css/style.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet" type="text/css" />

</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <a href="<?= base_url() ?>"><img src="<?= base_url() ?>/assets/images/logo-full.png" alt=""></a>
                                    </div>
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                    <form action="./auth/login">
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input id="username" name="username" type="text" class="form-control" value="" placeholder="example@example.com" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="******" aria-label="Password" aria-describedby="password-addon" required />
                                                <button class="btn btn-light " type="button" onclick="showHidePassword(this);" id="password-addon"><i class="mdi mdi-eye-outline" id="eye-icon-password"></i></button>
                                            </div>
                                            <!-- <input type="password" class="form-control" value="Password"> -->
                                        </div>
                                        <div class="row d-flex justify-content-between mt-4 mb-2">
                                            <!-- <div class="mb-3">
                                                <div class="form-check custom-checkbox ms-1">
                                                    <input type="checkbox" class="form-check-input" id="basic_checkbox_1">
                                                    <label class="form-check-label" for="basic_checkbox_1">Remember my preference</label>
                                                </div>
                                            </div> -->
                                            <div class="mb-3">
                                                <a href="javascript:;">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
                                        </div>
                                    </form>
                                    <!-- <div class="new-account mt-3">
                                        <p>Don't have an account? <a class="text-primary" href="page-register.html">Sign up</a></p>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--**********************************
	Scripts
***********************************-->
    <!-- Required vendors -->
    <script src="<?= base_url() ?>/assets/vendor/global/global.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/custom.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/dlabnav-init.js"></script>
    <script src="<?= base_url() ?>/assets/js/styleSwitcher.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
    <script>
        function showHidePassword(event) {
            const showedPassword = document.getElementById("password");
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

        <?php if (isset($error)) { ?>
            Swal({
                title: "Peringata!",
                text: '<?= $error ?>',
                type: "warning",
            });
            // Swal.fire(
            //     "Peringatan!",
            //     '<?= $error ?>',
            //     "warning"
            // );
        <?php } ?>
        $("form").on("submit", function(e) {

            e.preventDefault();
            var dataString = $(this).serialize();
            $.ajax({
                type: "POST",
                url: '/auth/login',
                data: dataString,
                dataType: 'JSON',
                beforeSend: function() {
                    Swal.fire({
                        title: 'Sedang Loading . . .',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            swal.showLoading();
                        }
                    });
                    // loading = true;
                    // $('div.content-loading').block({
                    //     message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                    // });
                },
                complete: function() {
                    // swal.close();
                    // $('.btnsimpanbanyak').removeAttr('disable')
                    // $('.btnsimpanbanyak').html('<i class="bx bx-save font-size-16 align-middle me-2"></i> SIMPAN');
                },
                success: function(msg) {
                    console.log(msg);
                    if (msg.status != 200) {
                        if (msg.status !== 201) {
                            if (msg.status !== 202) {
                                Swal.fire({
                                    title: "Peringatan!!!",
                                    text: msg.message,
                                    type: "warning",
                                });
                            } else {
                                Swal.fire(
                                    "Peringatan!!!",
                                    msg.message,
                                    "warning"
                                ).then((valRes) => {
                                    // setTimeout(function() {
                                    document.location.href = msg.url;
                                    // }, 2000);

                                })
                            }
                        } else {
                            // swal({
                            //     title: "Berhasil!",
                            //     text: msg.message,
                            //     type: "success",
                            // });
                            Swal.fire(
                                "Berhasil!",
                                msg.message,
                                "success"
                            ).then((valRes) => {
                                // setTimeout(function() {
                                document.location.href = msg.url;
                                // }, 2000);
                            });
                        }
                    } else {
                        Swal.fire(
                            'Berhasil!',
                            msg.message,
                            'success'
                        ).then((valRes) => {
                            // setTimeout(function() {
                            document.location.href = msg.url;
                            // }, 2000);
                            // document.location.href = window.location.href + "dashboard";
                        })
                    }
                },
                error: function(data) {
                    console.log(data);
                    Swal.fire(
                        'Gagal!',
                        "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                        'warning'
                    );
                }
            });

        });
    </script>
</body>

</html>