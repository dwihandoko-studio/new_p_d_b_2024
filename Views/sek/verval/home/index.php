<?= $this->extend('t-verval/sek/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <div class="card overflow-hidden">
                            <div class="card-header border-0">
                                <div class="d-flex">
                                    <span class="mt-2">
                                        <i class="la la-users" style="font-size: 3vw;"></i>
                                        <!-- <svg width="32" height="40" viewBox="0 0 32 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.812 34.64L3.2 39.6C2.594 40.054 1.784 40.128 1.106 39.788C0.428 39.45 0 38.758 0 38V2C0 0.896 0.896 0 2 0H30C31.104 0 32 0.896 32 2V38C32 38.758 31.572 39.45 30.894 39.788C30.216 40.128 29.406 40.054 28.8 39.6L22.188 34.64L17.414 39.414C16.634 40.196 15.366 40.196 14.586 39.414L9.812 34.64ZM28 34V4H4V34L8.8 30.4C9.596 29.802 10.71 29.882 11.414 30.586L16 35.172L20.586 30.586C21.29 29.882 22.404 29.802 23.2 30.4L28 34ZM14 20H18C19.104 20 20 19.104 20 18C20 16.896 19.104 16 18 16H14C12.896 16 12 16.896 12 18C12 19.104 12.896 20 14 20ZM10 12H22C23.104 12 24 11.104 24 10C24 8.896 23.104 8 22 8H10C8.896 8 8 8.896 8 10C8 11.104 8.896 12 10 12Z" fill="#717579" />
                                        </svg> -->
                                    </span>
                                    <div class="invoices">
                                        <h4 class="total_pd_ta" id="total_pd_ta"><i class="fa fa-spinner fa-spin"></i></h4>
                                        <span>Jumlah PD Tingkat Akhir</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">

                                <div id="totalInvoices"></div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card overflow-hidden">
                            <div class="card-header border-0">
                                <div class="d-flex">
                                    <span class="mt-1">
                                        <i class="la la-user-check" style="font-size: 3vw;"></i>
                                        <!-- <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.812 48.64L11.2 53.6C10.594 54.054 9.78401 54.128 9.10602 53.788C8.42802 53.45 8.00002 52.758 8.00002 52V16C8.00002 14.896 8.89602 14 10 14H38C39.104 14 40 14.896 40 16V52C40 52.758 39.572 53.45 38.894 53.788C38.216 54.128 37.406 54.054 36.8 53.6L30.188 48.64L25.414 53.414C24.634 54.196 23.366 54.196 22.586 53.414L17.812 48.64ZM36 48V18H12V48L16.8 44.4C17.596 43.802 18.71 43.882 19.414 44.586L24 49.172L28.586 44.586C29.29 43.882 30.404 43.802 31.2 44.4L36 48ZM22 34H26C27.104 34 28 33.104 28 32C28 30.896 27.104 30 26 30H22C20.896 30 20 30.896 20 32C20 33.104 20.896 34 22 34ZM18 26H30C31.104 26 32 25.104 32 24C32 22.896 31.104 22 30 22H18C16.896 22 16 22.896 16 24C16 25.104 16.896 26 18 26Z" fill="#44814E" />
                                            <circle cx="43.5" cy="14.5" r="12.5" fill="#09BD3C" stroke="white" stroke-width="4" />
                                        </svg> -->
                                    </span>
                                    <div class="invoices">
                                        <h4 class="verified_pd_ta" id="verified_pd_ta"><i class="fa fa-spinner fa-spin"></i></h4>
                                        <span>PD Terverifikasi</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">

                                <div id="paidinvoices"></div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card overflow-hidden">
                            <div class="card-header border-0">
                                <div class="d-flex">
                                    <span class="mt-1">
                                        <i class="la la-user-alt-slash" style="font-size: 3vw;"></i>
                                        <!-- <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.812 48.64L11.2 53.6C10.594 54.054 9.78401 54.128 9.10602 53.788C8.42802 53.45 8.00002 52.758 8.00002 52V16C8.00002 14.896 8.89602 14 10 14H38C39.104 14 40 14.896 40 16V52C40 52.758 39.572 53.45 38.894 53.788C38.216 54.128 37.406 54.054 36.8 53.6L30.188 48.64L25.414 53.414C24.634 54.196 23.366 54.196 22.586 53.414L17.812 48.64ZM36 48V18H12V48L16.8 44.4C17.596 43.802 18.71 43.882 19.414 44.586L24 49.172L28.586 44.586C29.29 43.882 30.404 43.802 31.2 44.4L36 48ZM22 34H26C27.104 34 28 33.104 28 32C28 30.896 27.104 30 26 30H22C20.896 30 20 30.896 20 32C20 33.104 20.896 34 22 34ZM18 26H30C31.104 26 32 25.104 32 24C32 22.896 31.104 22 30 22H18C16.896 22 16 22.896 16 24C16 25.104 16.896 26 18 26Z" fill="#44814E" />
                                            <circle cx="43.5" cy="14.5" r="12.5" fill="#FD5353" stroke="white" stroke-width="4" />
                                        </svg> -->

                                    </span>
                                    <div class="invoices">
                                        <h4 class="notverified_pd_ta" id="notverified_pd_ta"><i class="fa fa-spinner fa-spin"></i></h4>
                                        <span>PD Belum Verifikasi</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div id="unpaidinvoices"></div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card overflow-hidden">
                            <div class="card-header border-0">
                                <div class="d-flex">
                                    <span class="mt-1">
                                        <i class="la la-user-lock" style="font-size: 3vw;"></i>
                                        <!-- <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.812 48.64L11.2 53.6C10.594 54.054 9.784 54.128 9.106 53.788C8.428 53.45 8 52.758 8 52V16C8 14.896 8.896 14 10 14H38C39.104 14 40 14.896 40 16V52C40 52.758 39.572 53.45 38.894 53.788C38.216 54.128 37.406 54.054 36.8 53.6L30.188 48.64L25.414 53.414C24.634 54.196 23.366 54.196 22.586 53.414L17.812 48.64ZM36 48V18H12V48L16.8 44.4C17.596 43.802 18.71 43.882 19.414 44.586L24 49.172L28.586 44.586C29.29 43.882 30.404 43.802 31.2 44.4L36 48ZM22 34H26C27.104 34 28 33.104 28 32C28 30.896 27.104 30 26 30H22C20.896 30 20 30.896 20 32C20 33.104 20.896 34 22 34ZM18 26H30C31.104 26 32 25.104 32 24C32 22.896 31.104 22 30 22H18C16.896 22 16 22.896 16 24C16 25.104 16.896 26 18 26Z" fill="#44814E" />
                                            <circle cx="43.5" cy="14.5" r="12.5" fill="#FFAA2B" stroke="white" stroke-width="4" />
                                        </svg> -->


                                    </span>
                                    <div class="invoices">
                                        <h4 class="generate_pd_ta" id="generate_pd_ta"><i class="fa fa-spinner fa-spin"></i></h4>
                                        <span>PD Tergenerate Akun</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div id="totalinvoicessent"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-block d-sm-flex border-0 transactions-tab">
                        <div class="me-3">
                            <h4 class="card-title mb-2">Dashboard Informasi</h4>
                            <span class="fs-12">Informasi seputar PPDB Kab. Lampung Tengah Tahun 2024/2025</span>
                        </div>
                        <div class="card-tabs mt-3 mt-sm-0">
                        </div>
                    </div>
                    <div class="card-body tab-content p-0">
                        <div class="accordion accordion-with-icon" id="accordion-six">
                            <?php if (isset($informasis)) { ?>
                                <?php if (count($informasis) > 0) { ?>
                                    <?php foreach ($informasis as $key => $value) { ?>
                                        <?php if ($key == 0) { ?>
                                            <div class="accordion-item">
                                                <div class="accordion-header rounded-lg" id="accord-6One<?= $key ?>" data-bs-toggle="collapse" data-bs-target="#collapse6One<?= $key ?>" aria-controls="collapse6One<?= $key ?>" aria-expanded="true" role="button">
                                                    <span class="accordion-header-icon"></span>
                                                    <span class="accordion-header-text"><?= $value->judul ?></span>
                                                    <span class="accordion-header-indicator"></span>
                                                </div>
                                                <div id="collapse6One<?= $key ?>" class="accordion__body collapse show" aria-labelledby="accord-6One<?= $key ?>" data-bs-parent="#accordion-six" style="">
                                                    <div class="accordion-body-text">
                                                        <?= $value->deskripsi ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="accordion-item">
                                                <div class="accordion-header collapsed rounded-lg" id="accord-6Two<?= $key ?>" data-bs-toggle="collapse" data-bs-target="#collapse6Two<?= $key ?>" aria-controls="collapse6Two<?= $key ?>" aria-expanded="true" role="button">
                                                    <span class="accordion-header-icon"></span>
                                                    <span class="accordion-header-text"><?= $value->judul ?></span>
                                                    <span class="accordion-header-indicator"></span>
                                                </div>
                                                <div id="collapse6Two<?= $key ?>" class="collapse accordion__body" aria-labelledby="accord-6Two<?= $key ?>" data-bs-parent="#accordion-six">
                                                    <div class="accordion-body-text">
                                                        <?= $value->deskripsi ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal">
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
<!-- <script src="<?= base_url() ?>/assets/js/dashboard/dashboard-1.js"></script> -->
<script src="<?= base_url() ?>/assets/vendor/owl-carousel/owl.carousel.js"></script>
<script>
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

        getStatistikTop();
    });

    function getStatistikTop() {
        $.ajax({
            url: "./statistik",
            type: 'POST',
            data: {
                id: 'get',
            },
            dataType: 'JSON',
            beforeSend: function() {
                // Swal.fire({
                //     title: 'Sedang Loading . . .',
                //     allowEscapeKey: false,
                //     allowOutsideClick: false,
                //     didOpen: () => {
                //         Swal.showLoading();
                //     }
                // });
            },
            success: function(resul) {
                if (resul.status !== 200) {
                    $('.total_pd_ta').html("0");
                    $('.verified_pd_ta').html("0");
                    $('.notverified_pd_ta').html("0");
                    $('.generate_pd_ta').html("0");
                } else {
                    $('.total_pd_ta').html(resul.data.total);
                    $('.verified_pd_ta').html(resul.data.verified);
                    $('.notverified_pd_ta').html(resul.data.notverified);
                    $('.generate_pd_ta').html(resul.data.generate);

                }
            }
        });
    }
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<?= $this->endSection(); ?>