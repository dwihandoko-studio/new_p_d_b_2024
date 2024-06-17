<?= $this->extend('t-dashboard/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">
    <div class="container-fluid" style="padding-top: 0.5rem;">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-block d-sm-flex border-0 transactions-tab">
                        <div class="me-3">
                            <h4 class="card-title mb-2">Zonasi Wilayah</h4>
                            <span class="fs-12">PPDB Kab. Lampung Tengah Tahun 2024/2025</span>
                        </div>
                    </div>
                    <div class="card-body tab-content p-0">
                        <div class="tab-pane fade active show" id="monthly" role="tabpanel">
                            <div id="accordion-one" class="accordion style-1">
                                <div class="card">
                                    <div class="card-header">

                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h4 class="card-title">&nbsp;</h4>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="mb-3">
                                                                    <label for="_filter_kec" class="col-form-label">Filter Kecamatan:</label>
                                                                    <select class="form-control filter-kec" id="_filter_kec" name="_filter_kec" width="100%" style="width: 100%;">
                                                                        <option value="">--Pilih--</option>
                                                                        <?php if (isset($kecamatans)) {
                                                                            if (count($kecamatans) > 0) {
                                                                                foreach ($kecamatans as $key => $value) { ?>
                                                                                    <option value="<?= $value->id ?>"><?= $value->nama ?></option>
                                                                        <?php }
                                                                            }
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="mb-3">
                                                                    <label for="_filter_jenjang" class="col-form-label">Filter Jenjang:</label>
                                                                    <select class="form-control filter-jenjang" id="_filter_jenjang" name="_filter_jenjang" width="100%" style="width: 100%;">
                                                                        <option value="">--Pilih--</option>
                                                                        <option value="5">SD</option>
                                                                        <option value="6">SMP</option>
                                                                        <?php if (isset($jenjangs)) {
                                                                            if (count($jenjangs) > 0) {
                                                                                foreach ($jenjangs as $key => $value) { ?>
                                                                                    <option value="<?= $value->bentuk_pendidikan_id ?>"><?= $value->bentuk_pendidikan ?></option>
                                                                        <?php }
                                                                            }
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="table-responsive">
                                            <table id="data-datatables" class="display" style="min-width: 845px">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2">#</th>
                                                        <th rowspan="2">Nama Sekolah</th>
                                                        <th rowspan="2">NPSN</th>
                                                        <th colspan="2">Wilayah Zonasi</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Kelurahan</th>
                                                        <th>Dusun / Lingkungan</th>
                                                    </tr>
                                                </thead>
                                            </table>
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
<div id="content-detailModal" class="modal fade content-detailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-detailModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="content-detailBodyModal">
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script src="<?= base_url() ?>/assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/assets/vendor/select2/js/select2.min.js"></script>

<script>
    function getDetailZonasi(id, nama) {
        $.ajax({
            url: "./detailZonasi",
            type: 'POST',
            data: {
                id: id,
                nama: nama,
            },
            dataType: "json",
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
            complete: function() {},
            success: function(response) {
                if (response.status == 200) {
                    Swal.close();
                    $('#content-detailModalLabel').html(response.title);
                    $('.contentBodydetailModal').html(response.data);
                    $('.content-detailModal').modal({
                        backdrop: 'static',
                        keyboard: false,
                    });
                    $('.content-detailModal').modal('show');
                } else {
                    Swal.fire(
                        'Failed!',
                        "gagal mengambil data",
                        'warning'
                    );
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                Swal.fire(
                    'Failed!',
                    "gagal mengambil data (" + xhr.status.toString + ")",
                    'warning'
                );
            }

        });
    }

    $(document).ready(function() {
        initSelect2('_filter_kec', $('.content-body'));
        initSelect2('_filter_jenjang', $('.content-body'));
        let tableDatatables = $('#data-datatables').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "./getAllZonasi",
                "type": "POST",
                "data": function(data) {
                    data.kec = $('#_filter_kec').val();
                    data.jenjang = $('#_filter_jenjang').val();
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
            buttons: ["copy", "excel", "pdf"],
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
        $('#_filter_kec').change(function() {
            tableDatatables.draw();
        });
        $('#_filter_jenjang').change(function() {
            tableDatatables.draw();
        });
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/vendor/owl-carousel/owl.carousel.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

<link href="<?= base_url() ?>/assets/vendor/nouislider/nouislider.min.css" rel="stylesheet" type="text/css" />
<?= $this->endSection(); ?>