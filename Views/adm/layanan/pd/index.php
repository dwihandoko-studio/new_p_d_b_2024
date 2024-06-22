<?= $this->extend('t-verval/adm/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Layanan</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Peserta Didik</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Tingkat Akhir</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title">Data Peserta Didik Tingkat Akhir</h4>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-datatables" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Action</th>
                                        <th>Nama Peserta Didik</th>
                                        <th>NISN</th>
                                        <th>NIK</th>
                                        <th>NO KK</th>
                                        <th>Tgl Lahir</th>
                                        <th>Tkt Pen</th>
                                        <th>Nama Ibu</th>
                                        <th>Lokasi</th>
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

<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script src="<?= base_url() ?>/assets/vendor/datatables/js/jquery.dataTables.min.js"></script>

<script src="https://code.jquery.com/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.buttons.min.js"></script>

<script>
    $(document).ready(function() {
        // initSelect2('_filter_kec', $('.content-body'));
        // initSelect2('_filter_jenjang', $('.content-body'));
        let tableDatatables = $('#data-datatables').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "./getAllTkAkhir",
                "type": "POST",
                "data": function(data) {
                    data.id = <?= $id ?>;
                    data.role = $('#_filter_role').val();
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
            dom: 'Bfrtip',
            buttons: ["copy", "excel", "pdf"],
            layout: {
                topStart: 'buttons'
            },
            "columnDefs": [{
                    "targets": 0,
                    "orderable": false,
                },
                {
                    "targets": 2,
                    "type": 'string',
                },
                {
                    "targets": 3,
                    "type": 'string',
                },
                {
                    "targets": 4,
                    "type": 'string',
                },
                {
                    "targets": 5,
                    "type": 'string',
                }
            ]
            // "columnDefs": [],
        });
        $('#_filter_role').change(function() {
            tableDatatables.draw();
        });
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/buttons.dataTables.min.css">

<?= $this->endSection(); ?>