<?= $this->extend('t-ppdb/pd/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row">
            <?php if (isset($hasRegister)) { ?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-primary notification">
                                <p class="notificaiton-title mb-2"><strong>INFORMASI !!!</strong></p>
                                <p><?= $hasRegister->message ?></p>
                                <button onclick="actionDownload('<?= $hasRegister->koreg ?>', 'Download')" class="btn btn-primary btn-sm">Download Bukti Pendaftaran</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                                <a href="<?= base_url('pd/daftar/afirmasi') ?>">
                                    <div class="widget-stat card bg-primary">
                                        <div class="card-body  p-4">
                                            <div class="media">
                                                <span class="me-3">
                                                    <i class="las la-school"></i>
                                                </span>
                                                <div class="media-body text-white">
                                                    <p class="mb-1">JALUR AFIRMASI</p>
                                                    <small>Daftar Via Jalur Afirmasi</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                                <a href="<?= base_url('pd/daftar/zonasi') ?>">
                                    <div class="widget-stat card bg-warning">
                                        <div class="card-body  p-4">
                                            <div class="media">
                                                <span class="me-3">
                                                    <i class="las la-map-marked-alt"></i>
                                                </span>
                                                <div class="media-body text-white">
                                                    <p class="mb-1">JALUR ZONASI</p>
                                                    <small>Daftar Via Jalur Zonasi</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                                <a href="<?= base_url('pd/daftar/mutasi') ?>">
                                    <div class="widget-stat card bg-danger">
                                        <div class="card-body  p-4">
                                            <div class="media">
                                                <span class="me-3">
                                                    <i class="las la-bezier-curve"></i>
                                                </span>
                                                <div class="media-body text-white">
                                                    <p class="mb-1">JALUR MUTASI</p>
                                                    <small>Daftar Via Jalur Mutasi</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                                <a href="<?= base_url('pd/daftar/prestasi') ?>">
                                    <div class="widget-stat card bg-info">
                                        <div class="card-body  p-4">
                                            <div class="media">
                                                <span class="me-3">
                                                    <i class="las la-trophy"></i>
                                                </span>
                                                <div class="media-body text-white">
                                                    <p class="mb-1">JALUR PRESTASI</p>
                                                    <small>Daftar Via Jalur Prestasi</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                                <a href="<?= base_url('pd/daftar/swasta') ?>">
                                    <div class="widget-stat card bg-blue">
                                        <div class="card-body  p-4">
                                            <div class="media">
                                                <span class="me-3">
                                                    <i class="las la-university"></i>
                                                </span>
                                                <div class="media-body text-white">
                                                    <p class="mb-1">SEKOLAH SWASTA</p>
                                                    <small>Daftar Ke Sekolah Swasta</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php if (isset($canAccessPPDB)) { ?>
                                <?php if ($canAccessPPDB) { ?>
                                    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                                        <a href="<?= base_url('sek/ppdb/home') ?>">
                                            <div class="widget-stat card bg-info">
                                                <div class="card-body  p-4">
                                                    <div class="media">
                                                        <span class="me-3">
                                                            <i class="la la-users"></i>
                                                        </span>
                                                        <div class="media-body text-white">
                                                            <p class="mb-1">PPDB 2024/2025</p>
                                                            <small>Aplikasi PPDB</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div id="content-firsloginModal" class="modal fade content-firsloginModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-firsloginModalLabel">Modal title</h5>
                </button>
            </div>
            <div class="content-firsloginBodyModal">
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>

<script src="<?= base_url() ?>/assets/vendor/chart.js/Chart.bundle.min.js"></script>
<script src="<?= base_url() ?>/assets/vendor/apexchart/apexchart.js"></script>
<script src="<?= base_url() ?>/assets/vendor/peity/jquery.peity.min.js"></script>
<script src="<?= base_url() ?>/assets/vendor/nouislider/nouislider.min.js"></script>
<script src="<?= base_url() ?>/assets/vendor/wnumb/wNumb.js"></script>
<script src="<?= base_url() ?>/assets/js/dashboard/dashboard-1.js"></script>
<script src="<?= base_url() ?>/assets/vendor/owl-carousel/owl.carousel.js"></script>
<script>
    function actionDownload(id, nama) {
        Swal.fire({
            title: 'Apakah anda yakin ingin mendownload Bukti Pendaftaran ini?',
            text: "Download Bukti Pendaftaran",
            showCancelButton: true,
            icon: 'question',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Download!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "./download",
                    type: 'POST',
                    data: {
                        id: id,
                        nama: nama,
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Mendownload Data...',
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
                                    // reloadPage();
                                    const decodedBytes = atob(resul.data);
                                    const arrayBuffer = new ArrayBuffer(decodedBytes.length);
                                    const intArray = new Uint8Array(arrayBuffer);
                                    for (let i = 0; i < decodedBytes.length; i++) {
                                        intArray[i] = decodedBytes.charCodeAt(i);
                                    }

                                    const blob = new Blob([intArray], {
                                        type: 'application/pdf'
                                    });
                                    const link = document.createElement('a');
                                    link.href = URL.createObjectURL(blob);
                                    link.download = resul.filename; // Set desired filename
                                    link.click();

                                    // Revoke the object URL after download (optional)
                                    URL.revokeObjectURL(link.href);

                                })
                            }
                        } else {
                            Swal.fire(
                                'BERHASIL!',
                                resul.message,
                                'success'
                            ).then((valRes) => {
                                // reloadPage();
                                const decodedBytes = atob(resul.data);
                                const arrayBuffer = new ArrayBuffer(decodedBytes.length);
                                const intArray = new Uint8Array(arrayBuffer);
                                for (let i = 0; i < decodedBytes.length; i++) {
                                    intArray[i] = decodedBytes.charCodeAt(i);
                                }

                                const blob = new Blob([intArray], {
                                    type: 'application/pdf'
                                });
                                const link = document.createElement('a');
                                link.href = URL.createObjectURL(blob);
                                link.download = resul.filename;
                                link.click();
                                URL.revokeObjectURL(link.href);
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
    }

    $(document).on('click', '.lihatPetanya', function(e) {
        // const dataId = e.getAttribute('data-id');
        const url = this.dataset.id;

        // Open the URL in a new tab
        window.open(url, '_blank');
    });

    $(document).ready(function() {
        <?php if ($firs_login) { ?>
            $.ajax({
                url: "./edit",
                type: 'POST',
                data: {
                    id: 'edit',
                },
                dataType: 'JSON',
                beforeSend: function() {
                    Swal.fire({
                        title: 'Sedang Loading . . .',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(resul) {
                    if (resul.status !== 200) {
                        Swal.fire(
                            'Failed!',
                            resul.message,
                            'warning'
                        );
                    } else {
                        Swal.close();
                        $('#content-firsloginModalLabel').html('LENGKAPI DATA');
                        $('.content-firsloginBodyModal').html(resul.data);
                        $('.content-firsloginModal').modal({
                            backdrop: 'static',
                            keyboard: false,
                        });
                        $('.content-firsloginModal').modal('show');
                    }
                }
            });
        <?php } ?>
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<style>
    .lihatPetanya {
        background-color: #407d4a !important;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .lihatPetanya:hover {
        background-color: #d653c1 !important;
    }
</style>
<?= $this->endSection(); ?>