<?= $this->extend('t-dashboard/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">
    <div class="container-fluid" style="padding-top: 0.5rem;">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body" style="padding: 0px;">
                        <img class="d-block w-100" style="max-height: 300px; border-radius: 1.25rem;" src="<?= base_url() ?>/assets/images/wall.png" alt="home">
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
                                    <h4>CS: SMP</h4>
                                    <span>0853-2791-9291</span>
                                </div>
                            </li>
                            <li>
                                <span class="bg-red"></span>
                                <div>
                                    <h4>CS: SD</h4>
                                    <span>0852-6902-2481</span>
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