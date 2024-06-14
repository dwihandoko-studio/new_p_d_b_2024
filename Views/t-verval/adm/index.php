<!DOCTYPE html>
<html lang="en">

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

    <link href="<?= base_url() ?>/assets/vendor/owl-carousel/owl.carousel.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/vendor/nouislider/nouislider.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet" type="text/css" />
    <!-- <link href="<?= base_url() ?>/assets/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css" /> -->
    <link href="<?= base_url() ?>/assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <script>
        const BASE_URL = '<?= base_url() ?>';
    </script>
    <?= $this->renderSection('scriptTop'); ?>
</head>

<body>

    <div id="preloader" style="display: none;">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="nav-header">
            <a href="<?= base_url('portal') ?>" class="brand-logo">
                <img src="<?= base_url() ?>/favicon/apple-icon.png" style="max-width: 40px; max-height: 40px;" width="50" height="50" alt="Logo" />
                <!-- <svg class="logo-abbr" width="57" height="57" viewBox="0 0 57 57" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M32.9585 1.84675C30.4961 -0.615584 26.5039 -0.615585 24.0415 1.84675L19.3876 6.50068H12.8059C9.32365 6.50068 6.50071 9.32362 6.50071 12.8059V19.3876L1.84675 24.0415C-0.615584 26.5039 -0.615585 30.4961 1.84675 32.9585L6.50071 37.6124V44.1941C6.50071 47.6763 9.32365 50.4993 12.8059 50.4993H19.3876L24.0415 55.1532C26.5039 57.6156 30.4961 57.6156 32.9585 55.1532L37.6124 50.4993H44.1941C47.6764 50.4993 50.4993 47.6763 50.4993 44.1941V37.6124L55.1532 32.9585C57.6156 30.4961 57.6156 26.5039 55.1532 24.0415L50.4993 19.3876V12.8059C50.4993 9.32362 47.6764 6.50068 44.1941 6.50068H37.6124L32.9585 1.84675Z" fill="url(#paint0_linear)" />
                    <path class="logo-text" fill-rule="evenodd" clip-rule="evenodd" d="M24.7614 37.345L20.7666 40.3417C20.4005 40.616 19.9111 40.6607 19.5015 40.4553C19.0919 40.2511 18.8333 39.833 18.8333 39.375V17.625C18.8333 16.958 19.3746 16.4167 20.0416 16.4167H36.9583C37.6253 16.4167 38.1666 16.958 38.1666 17.625V39.375C38.1666 39.833 37.9081 40.2511 37.4984 40.4553C37.0888 40.6607 36.5994 40.616 36.2333 40.3417L32.2386 37.345L29.3543 40.2293C28.883 40.7018 28.1169 40.7018 27.6457 40.2293L24.7614 37.345ZM35.75 36.9584V18.8334H21.25V36.9584L24.15 34.7834C24.6309 34.4221 25.3039 34.4704 25.7293 34.8957L28.5 37.6664L31.2707 34.8957C31.696 34.4704 32.3691 34.4221 32.85 34.7834L35.75 36.9584ZM27.2916 28.5H29.7083C30.3753 28.5 30.9166 27.9587 30.9166 27.2917C30.9166 26.6247 30.3753 26.0834 29.7083 26.0834H27.2916C26.6246 26.0834 26.0833 26.6247 26.0833 27.2917C26.0833 27.9587 26.6246 28.5 27.2916 28.5ZM24.875 23.6667H32.125C32.792 23.6667 33.3333 23.1254 33.3333 22.4584C33.3333 21.7914 32.792 21.25 32.125 21.25H24.875C24.208 21.25 23.6666 21.7914 23.6666 22.4584C23.6666 23.1254 24.208 23.6667 24.875 23.6667Z" fill="white" />
                    <defs>
                    </defs>
                </svg> -->
                <div class="brand-title">
                    <h2 class="">PP<span style="color: fuchsia; opacity: 0.7 !important">DB</span></h2>
                    <span class="brand-sub-title">Kab. Lampung Tengah</span>

                </div>

            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>

        <div class="chatbox">
            <div class="chatbox-close"></div>
            <div class="custom-tab-1">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="index.html#notes">Notes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="index.html#alerts">Alerts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="index.html#chat">Chat</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="chat" role="tabpanel">

                    </div>
                    <div class="tab-pane fade" id="alerts" role="tabpanel">
                        <div class="card mb-sm-3 mb-md-0 contacts_card">
                            <div class="card-header chat-list-header text-center">
                                <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <circle fill="#000000" cx="5" cy="12" r="2" />
                                            <circle fill="#000000" cx="12" cy="12" r="2" />
                                            <circle fill="#000000" cx="19" cy="12" r="2" />
                                        </g>
                                    </svg></a>
                                <div>
                                    <h6 class="mb-1">Notications</h6>
                                    <p class="mb-0">Show All</p>
                                </div>
                                <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                            <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
                                        </g>
                                    </svg></a>
                            </div>
                            <div class="card-footer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
	Chat box End
***********************************-->
        <?= $this->include('t-verval/adm/topbar'); ?>
        <?= $this->include('t-verval/adm/menu'); ?>

        <?= $this->renderSection('content'); ?>
        <?= $this->include('t-verval/adm/footer'); ?>
    </div>
    <script src="<?= base_url() ?>/assets/vendor/global/global.min.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>

    <script src="<?= base_url() ?>/assets/js/custom.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/dlabnav-init.js"></script>
    <script src="<?= base_url() ?>/assets/js/demo.js"></script>
    <script src="<?= base_url() ?>/assets/js/styleSwitcher.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/select2/js/select2.min.js"></script>
    <?= $this->renderSection('scriptBottom'); ?>
    <script>
        function initSelect2(event, parrent) {
            $('#' + event).select2({
                width: "100%",
                dropdownParent: parrent
            });
        }

        function reloadPage(action = "") {
            if (action === "") {
                document.location.href = "<?= current_url(true); ?>";
            } else {
                document.location.href = action;
            }
        }

        function aksiLogout(e) {
            // e.preventDefault();
            const href = BASE_URL + "/auth/logout";
            Swal.fire({
                title: 'Apakah anda yakin ingin keluar?',
                text: "Keluar Dari Aplikasi.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Sign Out!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: href,
                        type: 'GET',
                        contentType: false,
                        cache: false,
                        beforeSend: function() {
                            // $('body.loading-logout').block({
                            //     message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                            // });
                            Swal.fire({
                                title: 'Sedang Loading . . .',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    swal.showLoading();
                                }
                            });
                        },
                        success: function(resMsg) {
                            Swal.fire(
                                'Berhasil!',
                                "Anda berhasil logout.",
                                'success'
                            ).then((valRes) => {
                                document.location.href = BASE_URL + "/home";
                            })
                        },
                        error: function() {
                            $('body.loading-logout').unblock();
                            Swal.fire(
                                'Gagal!',
                                "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                                'warning'
                            );
                        }
                    })
                }
            })
        };
    </script>
</body>

</html>