<?= $this->extend('t-dashboard/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">
    <div class="container-fluid" style="padding-top: 0.5rem;">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-block d-sm-flex border-0 transactions-tab">
                        <div class="me-3">
                            <h4 class="card-title mb-2">Kuota PPDB Sekolah Yang Belum Tercukupi</h4>
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
                                                            <div class="col-4">
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
                                                            <div class="col-4">
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
                                                            <div class="col-4">
                                                                <div class="mb-3">
                                                                    <label for="_filter_status" class="col-form-label">Filter Status:</label>
                                                                    <select class="form-control filter-status" id="_filter_status" name="_filter_status" width="100%" style="width: 100%;">
                                                                        <option value="">--Pilih--</option>
                                                                        <option value="1">NEGERI</option>
                                                                        <option value="2">SWASTA</option>
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
                                                        <th>#</th>
                                                        <th>NPSN</th>
                                                        <th>Nama Sekolah</th>
                                                        <th>Jenjang</th>
                                                        <th>Status</th>
                                                        <th>Kecamatan</th>
                                                        <th>Sisa Kuota</th>
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

            <?= $this->include('t-dashboard/bottom'); ?>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script src="<?= base_url() ?>/assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/assets/vendor/select2/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        initSelect2('_filter_kec', $('.content-body'));
        initSelect2('_filter_jenjang', $('.content-body'));
        let tableDatatables = $('#data-datatables').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "./getAllSisaKuota",
                "type": "POST",
                "data": function(data) {
                    data.kec = $('#_filter_kec').val();
                    data.jenjang = $('#_filter_jenjang').val();
                    data.status = $('#_filter_status').val();
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
            }, {
                "targets": 5,
                "orderable": false,
            }, {
                "targets": 6,
                "orderable": false,
            }],
            // "rowCallback": function(row, data, index) {
            //     console.log(data[3]);
            //     // $(row).attr("id", "tr-" + index);
            //     $(row).click(function() {
            //         const urlSekolah = data.url_sekolah;
            //         window.open(urlSekolah, '_blank');
            //         // window.location.href = urlSekolah;
            //     });
            //     // $(row).hover(function() {
            //     //     $(this).addClass('hovered'); // Add a CSS class for hover effect
            //     // }, function() {
            //     //     $(this).removeClass('hovered'); // Remove the CSS class on mouse out
            //     // });
            //     // if (data.grade == 'A') {
            //     //     $('td:eq(4)', row).html('<b>A</b>');
            //     // }
            // }
        });
        $('#_filter_kec').change(function() {
            tableDatatables.draw();
        });
        $('#_filter_jenjang').change(function() {
            tableDatatables.draw();
        });
        $('#_filter_status').change(function() {
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