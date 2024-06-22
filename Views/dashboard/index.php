<?= $this->extend('t-dashboard/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">
    <div class="container-fluid" style="padding-top: 0.5rem;">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body" style="padding: 0px;">
                        <img class="d-block w-100" style="max-height: 300px; border-radius: 1.25rem;" src="<?= base_url() ?>/assets/images/wall2.png" alt="home">
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-xl-flex d-block align-items-start description-bx">
                            <div>
                                <h4 class="fs-20 font-w700">PPDB</h4>
                                <!-- <span class="fs-12">Lorem ipsum dolor sit amet, consectetur</span> -->
                                <p class="description mt-4">Adalah rangkaian kegiatan sistematik yang rancang untuk mengelola penyelenggaraan PPDB mulai dari persiapan (pra pendaftaran), pengumuman pendaftaran, pendaftaran dan penyerahan dokumen persyaratan, seleksi hingga batas kuota daya tampung, pengumuman hasil seleksi secara terbuka di Kabupaten Lampung Tengah.</p>
                            </div>
                            <div class="card-bx ms-xl-5 ms-0">
                                <img class="d-block w-100" src="<?= base_url() ?>/assets/images/opo.png" alt="nano">
                                <!-- <img class="pattern-img" src="<?= base_url() ?>/assets/images/opo.png" alt=""> -->
                                <!-- <div class="card-info text-white">
                                    <div class="d-flex justify-content-between">
                                        <img src="<?= base_url() ?>/assets/images/pattern/circle.png" class="mb-4" alt="">
                                        <img src="<?= base_url() ?>/assets/images/pattern/circles1.png" class="mb-4" alt="">

                                    </div>

                                    <h2 class="text-white card-balance">$62,467</h2>
                                    <p class="fs-16">Wallet Balance</p>
                                    <span>+0,8% than last week</span>
                                </div> -->
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