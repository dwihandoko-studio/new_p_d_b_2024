<?= $this->extend('t-verval/adm/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Masterdata</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Peserta Didik Sekolah</a></li>
            </ol>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <h4 class="card-title">Data Peserta Didik Sekolah</h4>
                            </div>
                            <div class="col-8">
                                <div class="row">
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
                                    <div class="col-3">
                                        <button type="button" class="btn btn-sm btn-primary waves-effect waves-light btnupload"><i class="fas fa-upload font-size-16 align-middle me-2"></i> UPLOAD</button> &nbsp;&nbsp;
                                    </div>
                                    <div class="col-3">
                                        <button type="button" class="btn btn-sm btn-primary waves-effect waves-light btnaddpd"><i class="las la-plus-circle font-size-16 align-middle me-2"></i> TAMBAH PD</button> &nbsp;&nbsp;
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
                                            <th>Action</th>
                                            <th>Nama Sekolah</th>
                                            <th>NPSN</th>
                                            <th>Jenjang</th>
                                            <th>Kecamatan</th>
                                            <th>Jumlah PD</th>
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

<div id="content-addModal" class="modal fade content-addModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-addModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="contentBodyaddModal">
            </div>
        </div>
    </div>
</div>
<div id="content-mapModal" class="modal fade content-mapModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-mapModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="content-mapBodyModal">
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script src="<?= base_url() ?>/assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script>
    $(document).on('click', '.btnupload', function(e) {
        e.preventDefault();

        $.ajax({
            url: "./upload",
            type: 'POST',
            data: {
                id: 'upload',
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
                    $('#content-uploadModalLabel').html('UPLOAD DATA PD');
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

    $(document).on('click', '.btnaddpd', function(e) {
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
                    $('#content-uploadModalLabel').html('TAMBAH DATA PD');
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
                [10, 25, 50, 100, 200, -1],
                [10, 25, 50, 100, 200, "All"]
            ],
            buttons: ["copy", "excel", "pdf"],
            "columnDefs": [{
                "targets": 0,
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

    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.js"></script>
<?= $this->endSection(); ?>