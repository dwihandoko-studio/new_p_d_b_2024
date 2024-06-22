<?= $this->extend('t-dashboard/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">
    <div class="container-fluid" style="padding-top: 0.5rem;">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-block d-sm-flex border-0 transactions-tab">
                        <div class="me-3">
                            <h4 class="card-title mb-2">Jadwal Pelaksanaan</h4>
                            <span class="fs-12">PPDB Kab. Lampung Tengah Tahun 2024/2025</span>
                        </div>
                    </div>
                    <div class="card-body tab-content p-0">
                        <div class="tab-pane fade active show" id="monthly" role="tabpanel">
                            <div id="accordion-one" class="accordion style-1">
                                <?php if (isset($jadwals)) { ?>
                                    <?php if (count($jadwals) > 0) { ?>
                                        <?php foreach ($jadwals as $key => $value) { ?>
                                            <div class="accordion-item">
                                                <div class="accordion-header <?= $key == 0 ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#default_collapseOne<?= $key ?>">
                                                    <span>JALUR <?= strtoupper($value->id) ?></span>
                                                    <span class="accordion-header-indicator"></span>
                                                </div>
                                                <div id="default_collapseOne<?= $key ?>" class="collapse accordion_body <?= $key == 0 ? 'show' : '' ?>" data-bs-parent="#accordion-one">
                                                    <div class="payment-details accordion-body-text">
                                                        <!-- <style>
                                                            ol {
                                                                list-style-type: none;
                                                                /* Remove default bullet list style */
                                                                counter-reset: item;
                                                                /* Reset counter for list items */
                                                            }

                                                            ol li {
                                                                counter-increment: item;
                                                                /* Increment counter for each list item */
                                                                display: list-item;
                                                                /* Display as list item */
                                                                text-align: left;
                                                                /* Align list item text to the left */
                                                            }

                                                            ol li::before {
                                                                content: counter(item) ". ";
                                                                /* Add number and period before each list item */
                                                                margin-right: 5px;
                                                                /* Add margin to separate number from list content */
                                                            }
                                                        </style> -->
                                                        <div class="me-3 mb-3">
                                                            <span class="font-w500">Pendaftaran :</span>
                                                            <p class="fs-12 mb-2"><i class="fas fa-calendar"></i> <?= tgl_indo($value->tgl_awal_pendaftaran) ?> - <?= tgl_indo($value->tgl_akhir_pendaftaran) ?>
                                                            </p>
                                                        </div>
                                                        <br />
                                                        <div class="me-3 mb-3">
                                                            <span class="font-w500">Verifikasi :</span>
                                                            <p class="fs-12 mb-2">
                                                                <i class="fas fa-calendar"></i> <?= tgl_indo($value->tgl_awal_verifikasi) ?> - <?= tgl_indo($value->tgl_akhir_verifikasi) ?>
                                                            </p>
                                                        </div>
                                                        <br />
                                                        <div class="me-3 mb-3">
                                                            <span class="font-w500">Pengumuman :</span>
                                                            <p class="fs-12 mb-2">
                                                                <i class="fas fa-calendar"></i> <?= tgl_indo($value->tgl_pengumuman) ?>
                                                            </p>
                                                        </div>
                                                        <br />
                                                        <div class="me-3 mb-3">
                                                            <span class="font-w500">Daftar Ulang :</span>
                                                            <p class="fs-12 mb-2">
                                                                <i class="fas fa-calendar"></i> <?= tgl_indo($value->tgl_awal_daftar_ulang) ?> - <?= tgl_indo($value->tgl_akhir_daftar_ulang) ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?= $this->include('t-dashboard/bottom'); ?>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/vendor/owl-carousel/owl.carousel.css" rel="stylesheet" type="text/css" />

<link href="<?= base_url() ?>/assets/vendor/nouislider/nouislider.min.css" rel="stylesheet" type="text/css" />
<?= $this->endSection(); ?>