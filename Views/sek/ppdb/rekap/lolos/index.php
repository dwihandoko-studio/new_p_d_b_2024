<?= $this->extend('t-ppdb/sek/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Rekap</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Lolos Verifikasi</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title">Data Peserta Didik Lolos Diverifikasi Berkas</h4>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="_filter_jalur" class="col-form-label">Filter Jalur:</label>
                                    <select class="form-control filter-kec" id="_filter_jalur" name="_filter_jalur" width="100%" style="width: 100%;">
                                        <option value="">--Pilih--</option>
                                        <?php if (isset($sekNegeri)) { ?>
                                            <?php if ($sekNegeri) { ?>
                                                <option value="AFIRMASI">JALUR AFIRMASI</option>
                                                <option value="ZONASI">JALUR ZONASI</option>
                                                <option value="MUTASI">JALUR MUTASI</option>
                                                <option value="PRESTASI">JALUR PRESTASI</option>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if (isset($sekSwasta)) { ?>
                                            <?php if ($sekSwasta) { ?>
                                                <option value="SWASTA">SEKOLAH SWASTA</option>
                                            <?php } ?>
                                        <?php } ?>
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
                                        <th>Action</th>
                                        <th>Nama Peserta Didik</th>
                                        <th>NISN</th>
                                        <th>Jalur</th>
                                        <th>Sekolah Asal</th>
                                        <th>Npsn Asal</th>
                                        <th>Jarak</th>
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
    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    $(document).ready(function() {
        initSelect2('_filter_jalur', $('.content-body'));
        let tableDatatables = $('#data-datatables').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "./getAll",
                "type": "POST",
                "data": function(data) {
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