<?= $this->extend('t-verval/adm/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Pengaduan</a></li>
                <!-- <li class="breadcrumb-item"><a href="javascript:void(0)">Peserta Didik Tingkat Akhir Sekolah</a></li> -->
            </ol>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <h4 class="card-title">Layanan Data Pengaduan</h4>
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="mb-3">
                                            <label for="_filter_jenis_pengaduan" class="col-form-label">Jenis Pengaduan:</label>
                                            <select class="form-control filter-kec" id="_filter_jenis_pengaduan" name="_filter_jenis_pengaduan" width="100%" style="width: 100%;">
                                                <option value="">--Pilih--</option>
                                                <option value="belum punya akun">Belum Punya Akun</option>
                                                <option value="tidak bisa melakukan pendaftaran ke sekolah">Tidak Bisa Melakukan Pendaftaran Ke Sekolah</option>
                                                <option value="lupa password">Lupa Password</option>
                                                <option value="tidak bisa melakukan pengkinian data">Tidak Bisa Melakukan Pengkinian Data</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="col-3">
                                        <button type="button" class="btn btn-sm btn-primary waves-effect waves-light btnupload"><i class="fas fa-upload font-size-16 align-middle me-2"></i> UPLOAD</button> &nbsp;&nbsp;
                                    </div> -->
                                    <!-- <div class="col-3">
                                        <button type="button" class="btn btn-sm btn-primary waves-effect waves-light btnaddpd"><i class="las la-plus-circle font-size-16 align-middle me-2"></i> TAMBAH PD</button> &nbsp;&nbsp;
                                    </div> -->
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
                                            <th>Jenis Pengaduan</th>
                                            <th>Nama Pengadu</th>
                                            <th>No Tiket</th>
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
    $(document).ready(function() {
        // initSelect2('_filter_kec', $('.content-body'));
        // initSelect2('_filter_jenjang', $('.content-body'));
        let tableDatatables = $('#data-datatables').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "./getAll",
                "type": "POST",
                "data": function(data) {
                    data.jenis_pengaduan = $('#_filter_jenis_pengaduan').val();
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
            }],
        });
        $('#_filter_jenis_pengaduan').change(function() {
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
<?= $this->endSection(); ?>