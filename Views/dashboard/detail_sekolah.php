<?= $this->extend('t-dashboard/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">
    <div class="container-fluid" style="padding-top: 0.5rem;">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Profil Sekolah</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?= $sekolah->nama ?> (NPSN: <?= $sekolah->npsn ?>)</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="profile card card-body px-3 pt-3 pb-0">
                    <div class="profile-head">
                        <div class="photo-content">
                            <div class="cover-photo rounded" style="background: url(<?= base_url() ?>/uploads/gambar/wall_2.png); object-fit: contain;"></div>
                        </div>
                        <div class="profile-info">
                            <div class="profile-photo">
                                <img style="max-width: 100px; max-height: 100px; width: 100px; height: 100px;" src="<?= $sekolah->image ? base_url('uploads/user') . '/' . $sekolah->image : base_url() . '/uploads/gambar/pict_1.png' ?>" class="img-fluid rounded-circle" alt="">
                            </div>
                            <div class="profile-details">
                                <div class="profile-name px-3 pt-2">
                                    <h4 class="text-primary mb-0"><?= $sekolah->nama ?></h4>
                                    <p><?= $sekolah->npsn ?></p>
                                </div>
                                <div class="profile-email px-2 pt-2">
                                    <h4 class="text-muted mb-0"><?= $sekolah->email ?? '-' ?></h4>
                                    <p>Email</p>
                                </div>
                                <div class="profile-email px-2 pt-2">
                                    <h4 class="text-muted mb-0"><?= $sekolah->website ?? '-' ?></h4>
                                    <p>Website</p>
                                </div>
                            </div>
                        </div>
                        <p>
                            <center>Alamat Sekolah: <?= $sekolah->alamat_jalan ?>, <?= $sekolah->desa_kelurahan ?> - <?= $sekolah->kecamatan ?>, <?= $sekolah->kabupaten ?> - <?= $sekolah->provinsi ?> (Kode Pos: <?= $sekolah->kode_pos ?>)</center>
                        </p>
                    </div>

                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="card-title">Data Kepanitian PPDB Sekolah <?= $sekolah->nama ?></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" style="margin-top: 30px;">
                                <div class="table-responsive">
                                    <table id="data-datatables-kepanitian-ppdb" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Jabatan Kepanitiaan PPDB</th>
                                                <th>Nama Lengkap</th>
                                                <th>Jabatan</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="card-title">Data Ketersediaan Kuota PPDB Sekolah <?= $sekolah->nama ?></h4>
                                    </div>
                                </div>
                            </div>
                            <?php if ((int)$sekolah->status_sekolah_id == 1) { ?>
                                <div class="col-12" style="margin-top: 30px;">
                                    <div class="row">
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="card overflow-hidden">
                                                <div class="card-header border-0">
                                                    <div class="d-flex">
                                                        <span class="mt-2">
                                                            <i class="la la-user-injured" style="font-size: 3vw;"></i>
                                                        </span>
                                                        <div class="invoices">
                                                            <h4 class="jumlah_pendaftar_afirmasi" id="jumlah_pendaftar_afirmasi"><?= $sekolah->kuota_sekolah->afirmasi ?></h4>
                                                            <span>Kuota Afirmasi</span>
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
                                                            <i class="la la-map" style="font-size: 3vw;"></i>
                                                        </span>
                                                        <div class="invoices">
                                                            <h4 class="jumlah_pendaftar_zonasi" id="jumlah_pendaftar_zonasi"><?= $sekolah->kuota_sekolah->zonasi ?></h4>
                                                            <span>Kuota Zonasi</span>
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
                                                            <i class="la la-retweet" style="font-size: 3vw;"></i>
                                                        </span>
                                                        <div class="invoices">
                                                            <h4 class="jumlah_pendaftar_mutasi" id="jumlah_pendaftar_mutasi"><?= $sekolah->kuota_sekolah->mutasi ?></h4>
                                                            <span>Kuota Mutasi</span>
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
                                                            <i class="la la-certificate" style="font-size: 3vw;"></i>
                                                        </span>
                                                        <div class="invoices">
                                                            <h4 class="jumlah_pendaftar_prestasi" id="jumlah_pendaftar_prestasi"><?= $sekolah->kuota_sekolah->prestasi ?></h4>
                                                            <span>Kuota Prestasi</span>
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
                            <?php } else { ?>
                                <div class="col-12" style="margin-top: 30px;">
                                    <div class="row">
                                        <div class="col-xl-6 col-sm-6">
                                            <div class="card overflow-hidden">
                                                <div class="card-header border-0">
                                                    <div class="d-flex">
                                                        <span class="mt-2">
                                                            <i class="la la-users" style="font-size: 3vw;"></i>
                                                        </span>
                                                        <div class="invoices">
                                                            <h4 class="jumlah_pendaftar" id="jumlah_pendaftar"><?= $sekolah->kuota_sekolah->total ?></h4>
                                                            <span>Jumlah Kuota</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body p-0">

                                                    <div id="totalInvoices"></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="card-title">Data Wilayah Zonasi PPDB Sekolah <?= $sekolah->nama ?></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" style="margin-top: 30px;">
                                <div class="table-responsive">
                                    <table id="data-datatables-wilayan-zona-ppdb" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kabupaten</th>
                                                <th>Kecamatan</th>
                                                <th>Desa / Kelurahan</th>
                                                <th>Dusun</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="card-title">Pengumuman Hasil PPDB 2024/2025 Sekolah <?= $sekolah->nama ?></h4>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="_filter_jalur" class="col-form-label">Jalur:</label>
                                                    <select class="form-control filter-kec" id="_filter_jalur" name="_filter_jalur" width="100%" style="width: 100%;">
                                                        <option value="">--Pilih--</option>
                                                        <?php if ((int)$sekolah->status_sekolah_id == 1) { ?>
                                                            <option value="AFIRMASI">AFIRMASI</option>
                                                            <option value="ZONASI">ZONASI</option>
                                                            <option value="MUTASI">MUTASI</option>
                                                            <option value="PRESTASI">PRESTASI</option>
                                                        <?php } else { ?>
                                                            <option value="SWASTA" selected>SWASTA</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12" style="margin-top: 30px;">
                                <div class="table-responsive">
                                    <table id="data-datatables-wilayan-zona-ppdb" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kabupaten</th>
                                                <th>Kecamatan</th>
                                                <th>Desa / Kelurahan</th>
                                                <th>Dusun</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <?= $this->include('t-dashboard/bottom'); ?>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script src="<?= base_url() ?>/assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // initSelect2('_filter_kec', $('.content-body'));
        // initSelect2('_filter_jenjang', $('.content-body'));
        let tableDatatablesPanitia = $('#data-datatables-kepanitian-ppdb').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "./getAllPanitia",
                "type": "POST",
                "data": function(data) {
                    data.id = '<?= $sekolah->sekolah_id ?>';
                }
            },
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            },
            lengthMenu: [
                [10],
                [10]
            ],
            "columnDefs": [{
                "targets": 0,
                "orderable": false,
            }, {
                "targets": 1,
                "orderable": false,
            }, {
                "targets": 2,
                "orderable": false,
            }, {
                "targets": 3,
                "orderable": false,
            }],
        });
        let tableDatatablesWilayah = $('#data-datatables-wilayan-zona-ppdb').DataTable({
            "processing": true,
            "serverSide": false,
            "order": [],
            "ajax": {
                "url": "./getAllWilayahZonasi",
                "type": "POST",
                "data": function(data) {
                    data.id = '<?= $sekolah->sekolah_id ?>';
                }
            },
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            },
            lengthMenu: [
                [10],
                [10]
            ],
            "columnDefs": [{
                "targets": 0,
                "orderable": false,
            }, {
                "targets": 1,
                "orderable": false,
            }, {
                "targets": 2,
                "orderable": false,
            }, {
                "targets": 3,
                "orderable": false,
            }, {
                "targets": 4,
                "orderable": false,
            }],
        });
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/vendor/owl-carousel/owl.carousel.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

<link href="<?= base_url() ?>/assets/vendor/nouislider/nouislider.min.css" rel="stylesheet" type="text/css" />
<?= $this->endSection(); ?>