<?= $this->extend('t-verval/adm/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-6" style="margin-bottom: 0px !important; padding-bottom: 0px !important;">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Masterdata</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Pengguna</a></li>
                </ol>
            </div>
            <div class="col-6">
                <button type="button" class="btn btn-sm btn-primary waves-effect waves-light btngenerate"><i class="fas fa-users font-size-16 align-middle me-2"></i> GENERATE PENGGUNA</button> &nbsp;&nbsp;
                <button type="button" class="btn btn-sm btn-info waves-effect waves-light btnadd"><i class="fas fa-user-plus font-size-16 align-middle me-2"></i> TAMBAH PENGGUNA</button> &nbsp;&nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title">Data Pengguna</h4>

                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="_filter_role" class="col-form-label">Filter Role:</label>
                                    <select class="form-control filter-role" id="_filter_role" name="_filter_role" width="100%" style="width: 100%;">
                                        <option value="">--Pilih--</option>
                                        <?php if (isset($roles)) {
                                            if (count($roles) > 0) {
                                                foreach ($roles as $key => $value) { ?>
                                                    <option value="<?= $value->id ?>"><?= $value->role ?></option>
                                        <?php }
                                            }
                                        } ?>
                                    </select>
                                    <div class="help-block _filter_role"></div>
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
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Ver Email</th>
                                        <th>Ver WA</th>
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

<div id="content-uploadModal" class="modal fade content-uploadModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-uploadModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="contentBodyUploadModal">
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script src="<?= base_url() ?>/assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script>
    $(document).on('click', '.btnadd', function(e) {
        e.preventDefault();

        $.ajax({
            url: "./add",
            type: 'POST',
            data: {
                id: 'add',
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
                    $('#content-uploadModalLabel').html('TAMBAH PENGGUNA');
                    $('.contentBodyUploadModal').html(response.data);
                    $('.content-uploadModal').modal({
                        backdrop: 'static',
                        keyboard: false,
                    });
                    $('.content-uploadModal').modal('show');
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
    });

    $(document).on('click', '.btngenerate', function(e) {
        e.preventDefault();

        $.ajax({
            url: "./generate",
            type: 'POST',
            data: {
                id: 'generate',
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
                    $('#content-uploadModalLabel').html('GENERATE PENGGUNA');
                    $('.contentBodyUploadModal').html(response.data);
                    $('.content-uploadModal').modal({
                        backdrop: 'static',
                        keyboard: false,
                    });
                    $('.content-uploadModal').modal('show');
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
    });

    $(document).ready(function() {
        initSelect2('_filter_role', $('.content-body'));
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