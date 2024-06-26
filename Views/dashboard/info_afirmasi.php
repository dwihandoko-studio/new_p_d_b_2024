<?= $this->extend('t-dashboard/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">
    <div class="container-fluid" style="padding-top: 0.5rem;">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-block d-sm-flex border-0 transactions-tab">
                        <div class="me-3">
                            <h4 class="card-title mb-2">Informasi Pendaftaran Jalur Afirmasi</h4>
                            <span class="fs-12">PPDB Kab. Lampung Tengah Tahun 2024/2025</span>
                        </div>
                    </div>
                    <div class="card-body tab-content p-0">
                        <div class="tab-pane fade active show" id="monthly" role="tabpanel">
                            <div id="accordion-one" class="accordion style-1">
                                <div class="accordion-item">
                                    <div class="accordion-header" data-bs-toggle="collapse" data-bs-target="#default_collapseOne2">
                                        <span>Jalur afirmasi adalah jalur yang ditujukan kepada peserta didik yang diperuntukkan bagi peserta didik yang berasal dari keluarga ekonomi tidak mampu.</span>
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
                                                    <li>FC Ijazah/SKL</li>
                                                    <li>FC Kartu Keluarga</li>
                                                    <li>FC Akta Kelahiran (opsional)</li>
                                                    <li>Kartu Jaminan Sosial (PIP/KIP/PKH/Jamkesmas/Surat Keterangan DTKS dari Dinsos)</li>
                                                    <li>Surat Keteranggan Penyandang Disabilitas (untuk yang disabilitas)</li>
                                                    <li>Surat Pernyataan Keaslian Dokumen ttd bermaterai dari Orang tua peserta</li>
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