<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="keywords" content="PPDB 2024/2025, PPDB, Disdikbud, disdik, dinas pendidikan, Dinas Pendidikan dan Kebudayaan, Dinas Pendidikan dan Kebudayaan Kabupaten Lampung Tengah, PPDB Lampung Tengah, ppdb lampung tengah 2024, lampung tengah" />
    <meta name="author" content="esline.id" />
    <meta name="description" content="PPDB 2024/2025 Kabupaten Lampung Tengah" />
    <meta property="og:url" content="<?= base_url() ?>" />
    <meta property="og:title" content="Portal PPDB 2024/2025 Kab. Lampung Tengah" />
    <meta property="og:description" content="PPDB 2024/2025 Kabupaten Lampung Tengah" />
    <meta property="og:image" content="<?= base_url('favicon/android-icon-192x192.png'); ?>" /> -->
    <meta name="format-detection" content="telephone=no">

    <!-- PAGE TITLE HERE -->
    <title><?= isset($title) ? $title : "Halaman Portal PPDB 2024/2025 Kab. Lampung Tengah" ?></title>

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

    <link href="<?= base_url() ?>/assets/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet" type="text/css" />

    <link href="<?= base_url() ?>/assets/css/style_new.css" rel="stylesheet" type="text/css" />
    <script>
        const BASE_URL = '<?= base_url() ?>';
    </script>
    <?= $this->renderSection('scriptTop'); ?>
    <link href="<?= base_url() ?>/assets/vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <style>
        /* .button-pengaduan {
            position: fixed !important;
            bottom: 2rem !important;
            right: 2rem !important;
            z-index: 1000000000 !important;
            max-width: 190px !important;
            cursor: pointer !important;
        }

        .showed-on-page {
            display: none !important;
        } */

        /* .float-bob-y {
            animation-name: float-bob-y;
            animation-duration: 2s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
            -webkit-animation-name: float-bob-y;
            -webkit-animation-duration: 2s;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-timing-function: linear;
            -moz-animation-name: float-bob-y;
            -moz-animation-duration: 2s;
            -moz-animation-iteration-count: infinite;
            -moz-animation-timing-function: linear;
            -ms-animation-name: float-bob-y;
            -ms-animation-duration: 2s;
            -ms-animation-iteration-count: infinite;
            -ms-animation-timing-function: linear;
            -o-animation-name: float-bob-y;
            -o-animation-duration: 2s;
            -o-animation-iteration-count: infinite;
            -o-animation-timing-function: linear;
        }

        .float-bob-x {
            animation-name: float-bob-x;
            animation-duration: 15s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
            -webkit-animation-name: float-bob-x;
            -webkit-animation-duration: 15s;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-timing-function: linear;
            -moz-animation-name: float-bob-x;
            -moz-animation-duration: 15s;
            -moz-animation-iteration-count: infinite;
            -moz-animation-timing-function: linear;
            -ms-animation-name: float-bob-x;
            -ms-animation-duration: 15s;
            -ms-animation-iteration-count: infinite;
            -ms-animation-timing-function: linear;
            -o-animation-name: float-bob-x;
            -o-animation-duration: 15s;
            -o-animation-iteration-count: infinite;
            -o-animation-timing-function: linear;
        } */
    </style>
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
                                        <a href="#"><img src="<?= base_url() ?>/assets/images/logo-full.png" alt=""></a>
                                    </div>
                                    <h4 class="text-center mb-4">PPDB Kabupaten Lampung Tengah Tahun Pelajaran 2024/2025 saat ini sedang dalam proses analisis data validasi</h4>
                                    <center><a href="<?= base_url('home/data') ?>" class="btn btn-primary">Kembali</a></center>
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
</body>

</html>