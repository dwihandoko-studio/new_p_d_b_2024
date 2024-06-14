<?= $this->extend('t-dashboard/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">
    <div class="container-fluid" style="padding-top: 0.5rem;">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-block d-sm-flex border-0 transactions-tab">
                        <div class="me-3">
                            <h4 class="card-title mb-2">Informasi Pendaftaran Jalur Mutasi</h4>
                            <span class="fs-12">PPDB Kab. Lampung Tengah Tahun 2024/2025</span>
                        </div>
                    </div>
                    <div class="card-body tab-content p-0">
                        <div class="tab-pane fade active show" id="monthly" role="tabpanel">
                            <div id="accordion-one" class="accordion style-1">
                                <div class="accordion-item">
                                    <div class="accordion-header" data-bs-toggle="collapse" data-bs-target="#default_collapseOne2">
                                        <span>Jalur Mutasi/Perpindahan Tugas Orang tua/Wali adalah jalur yang ditujukan pada peserta didik yang berdomisili di luar zonasi sekolah yang bersangkutan dikarenakan orang tuanya yang pindah domisili karena tugas.</span>
                                        <span class="accordion-header-indicator"></span>
                                    </div>
                                    <div id="default_collapseOne2" class="collapse accordion_body show" data-bs-parent="#accordion-one">
                                        <div class="payment-details accordion-body-text">
                                            <style>
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
                                            </style>
                                            <div class="me-3 mb-3">
                                                <span class="font-w500">Persyaratan Khusus:</span>
                                                <p class="fs-12 mb-2">

                                                <ol type="1">
                                                    <li>Ijazah/Surat Keterangan Lulus</li>
                                                    <li>Kartu Keluarga</li>
                                                    <li>Akte Kelahiran</li>
                                                    <li>Surat Keterangan Pindah Tugas</li>
                                                </ol>
                                                </p>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <span class="font-w500">TK/PAUD :</span>
                                                <p class="fs-12 mb-2">
                                                <ol type="1">
                                                    <li>Berusia paling rendah 4 tahun dan paling tinggi 5 tahun untuk kelompok A;dan</li>
                                                    <li>Berusia paling rendah 5 tahun dan paling tinggi 6 tahun untuk kelompok B</li>
                                                </ol>
                                                </p>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <span class="font-w500">SEKOLAH DASAR :</span>
                                                <p class="fs-12 mb-2">
                                                <ol type="1">
                                                    <li>Berusia 7 tahun; atau paling rendah 6 tahun pada tanggal 1 Juli tahun berjalan</li>
                                                    <li>Sekolah memperioritaskan penerimaan calon peserta didik yang berusia 7 tahun</li>
                                                    <li>Pengecualian syarat usia paling rendah 6 tahun yaitu paling rendah 5 tahun 6 bulan pada tanggal 1 Juli tahun berjalan yang diperuntukkan bagi calon peserta didik yang memiliki potensi kecerdasan dan/atau bakat istimewa dan kesiapan psikis yang dibuktikan dengan rekomendasi tertulis dari psikolog profesional/dewan guru Sekolah</li>
                                                </ol>
                                                </p>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <span class="font-w500">SEKOLAH MENENGAH PERTAMA :</span>
                                                <p class="fs-12 mb-2">
                                                <ol type="1">
                                                    <li>Berusia paling tinggi 15 tahun pada tanggal 1 Juli tahun berjalan;dan</li>
                                                    <li>Memiliki ijazah SD/sederajat atau dokumen lain yang menjelaskan telah menyelesaikan kelas 6 (enam) SD/MI</li>
                                                </ol>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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