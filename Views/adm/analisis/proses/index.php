<?= $this->extend('t-verval/adm/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Analisis</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Proses</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?= $nama_sekolah ?></a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title">Data Proses Analisis</h4>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <h4 class="card-title">Analisis Proses Data PPDB</h4>
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="mb-3">
                                            <label for="_filter_jalur" class="col-form-label">Filter Jalur:</label>
                                            <select class="form-control filter-jalur" id="_filter_jalur" name="_filter_jalur" width="100%" style="width: 100%;">
                                                <option value="">--Pilih--</option>
                                                <option value="AFIRMASI">AFIRMASI</option>
                                                <option value="ZONASI">ZONASI</option>
                                                <option value="MUTASI">MUTASI</option>
                                                <option value="SWASTA">SWASTA</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <a href="<?= $url_prestasi ?>" class="btn btn-sm btn-primary waves-effect waves-light btnupload"><i class="fas fa-trophy font-size-16 align-middle me-2"></i> JALUR PRESTASI</a> &nbsp;&nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="data-datatables" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <!-- <th>Action</th> -->
                                            <th>Nama Peserta Didik</th>
                                            <th>NISN</th>
                                            <th>JALUR</th>
                                            <th>JARAK</th>
                                            <th>SEKOLAH ASAL</th>
                                            <th>NPSN ASAL</th>
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

<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script src="<?= base_url() ?>/assets/vendor/datatables/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        // initSelect2('_filter_kec', $('.content-body'));
        // initSelect2('_filter_jenjang', $('.content-body'));
        let tableDatatables = $('#data-datatables').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "./getAllDetail",
                "type": "POST",
                "data": function(data) {
                    data.id = '<?= $id ?>';
                    data.jalur = $('#_filter_jalur').val();
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
                [10, 25, 50, 100, 200, -1],
                [10, 25, 50, 100, 200, "All"]
            ],
            "columnDefs": [{
                    "targets": 0,
                    "orderable": false,
                },
                {
                    "targets": 2,
                    "orderable": false,
                    "type": 'string',
                },
                {
                    "targets": 3,
                    "orderable": false,
                    "type": 'string',
                },
                {
                    "targets": 4,
                    "orderable": false,
                    "type": 'string',
                },
                {
                    "targets": 5,
                    "orderable": false,
                    "type": 'string',
                },
                {
                    "targets": 6,
                    "orderable": false,
                    "type": 'string',
                }
            ]
            // "columnDefs": [],
        });
        $('#_filter_jalur').change(function() {
            tableDatatables.draw();
        });
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

<?= $this->endSection(); ?>