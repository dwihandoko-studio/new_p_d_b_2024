<?= $this->extend('t-dashboard/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">
    <div class="container-fluid" style="padding-top: 0.5rem;">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-block d-sm-flex border-0 transactions-tab">
                        <div class="me-3">
                            <h4 class="card-title mb-2">Statistik</h4>
                            <span class="fs-12">PPDB Kab. Lampung Tengah Tahun 2024/2025</span>
                        </div>
                    </div>
                    <div class="card-body tab-content p-0">
                        <div class="tab-pane fade active show" id="monthly" role="tabpanel">
                            <div id="accordion-one" class="accordion style-1">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-xxl-4">
                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <div>
                            <h4 class="fs-20 font-w700 mb-2">Dinas Pendidikan dan Kebudayaan</h4>
                            <span class="fs-14">Kabupaten Lampung Tengah</span>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <p class="description">Jl. H Muchtar RT. 03 /RW. 01, Komplek Perkantoran Gunung Sugih No. 1, Lampung Tengah, Gn. Sugih, Kec. Gn. Sugih, Metro Lampung, Lampung 34161</p>
                        <ul class="specifics-list">
                            <li>
                                <span class="bg-blue"></span>
                                <div>
                                    <h4>63,876</h4>
                                    <span>CS: SMP</span>
                                </div>
                            </li>
                            <li>
                                <span class="bg-red"></span>
                                <div>
                                    <h4>97,125</h4>
                                    <span>CS: SD</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-xxl-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="mail-list rounded">
                                    <div class="intro-title d-flex justify-content-between my-0">
                                        <h5>Halaman</h5>
                                    </div>
                                    <p style="margin-bottom: 0px;"><a href="<?= base_url('home/data') ?>">Home</a></p>
                                    <p style="margin-bottom: 0px;"><a href="<?= base_url('home/jadwal') ?>">Jadwal Pendaftaran</a></p>
                                    <p style="margin-bottom: 0px;"><a href="<?= base_url('home/kuota') ?>">Kuota Sekolah</a></p>
                                    <p style="margin-bottom: 0px;"><a href="<?= base_url('home/zonasi_wilayah') ?>">Zonasi Wilayah</a></p>
                                    <p style="margin-bottom: 0px;"><a href="<?= base_url('home/statistik') ?>">Statistik</a></p>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mail-list rounded">
                                    <div class="intro-title d-flex justify-content-between my-0">
                                        <h5>Tautan</h5>
                                    </div>
                                    <p><a href="https://disdikbud.lampungtengahkab.go.id">Website Dinas Pendidikan dan Kebudayaan Kab. Lampung Tengah</a></p>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mail-list rounded">
                                    <div class="intro-title d-flex justify-content-between my-0">
                                        <h5>Pengaduan</h5>
                                    </div>
                                    <p>Punya Kendala PPDB </p>
                                    <button class="btn btn-primary ms-5">BUAT PENGADUAN</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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