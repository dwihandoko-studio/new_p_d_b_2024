<?= $this->extend('t-verval/su/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Masterdata</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Sekolah</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title">Data Sekolah</h4>

                            </div>
                            <div class="col-3">
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
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="_filter_jenjang" class="col-form-label">Filter Jenjang:</label>
                                    <select class="form-control filter-jenjang" id="_filter_jenjang" name="_filter_jenjang" width="100%" style="width: 100%;">
                                        <option value="">--Pilih--</option>
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-datatables" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Action</th>
                                        <th>Nama Sekolah</th>
                                        <th>NPSN</th>
                                        <th>Jenjang</th>
                                        <th>Kecamatan</th>
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
<script>
    $(document).ready(function() {
        initSelect2('_filter_kec', $('.content-body'));
        initSelect2('_filter_jenjang', $('.content-body'));
        let tableDatatables = $('#data-datatables').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "./getAll",
                "type": "POST",
                "data": function(data) {
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
            buttons: ["copy", "excel", "pdf"],
            "columnDefs": [{
                "targets": 0,
                "orderable": false,
            }],
        });
        $('#_filter_role').change(function() {
            tableDatatables.draw();
        });
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<?= $this->endSection(); ?>