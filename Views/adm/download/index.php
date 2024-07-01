<?= $this->extend('t-verval/adm/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Download</a></li>
                <!-- <li class="breadcrumb-item"><a href="javascript:void(0)">Peserta Didik Tingkat Akhir Sekolah</a></li> -->
            </ol>

        </div>
        <div class="row">
            <div class="col-xl-4 mb-3">
                <a href="<?= base_url('adm/download/pelenggara') ?>" target="_blank" class="btn btn-rounded btn-primary"><span class="btn-icon-start text-primary"><i class="fa fa-download color-primary"></i>
                    </span>Download Data Penyelenggara</a>
            </div>
            <div class="col-xl-4 mb-3">
                <a href="<?= base_url('adm/download/kuota') ?>" target="_blank" class="btn btn-rounded btn-info"><span class="btn-icon-start text-info"><i class="fa fa-download color-info"></i>
                    </span>Download Kapasitas Daya Tampung</a>
            </div>
            <div class="col-xl-4 mb-3">
                <a href="<?= base_url('adm/download/usia') ?>" target="_blank" class="btn btn-rounded btn-warning"><span class="btn-icon-start text-warning"><i class="fa fa-download color-warning"></i>
                    </span>Download Pendaftar Berdasarkan Usia</a>
            </div>
            <div class="col-xl-4 mb-3">
                <a href="<?= base_url('adm/download/afirmasi') ?>" target="_blank" class="btn btn-rounded btn-danger"><span class="btn-icon-start text-danger"><i class="fa fa-download color-danger"></i>
                    </span>Download Rekapitulasi Jalur Afirmasi</a>
            </div>
            <div class="col-xl-4 mb-3">
                <a href="<?= base_url('adm/download/zonasi') ?>" target="_blank" class="btn btn-rounded btn-secondary"><span class="btn-icon-start text-secondary"><i class="fa fa-download color-secondary"></i>
                    </span>Download Rekapitulasi Jalur Zonasi</a>
            </div>
            <div class="col-xl-4 mb-3">
                <a href="<?= base_url('adm/download/mutasi') ?>" target="_blank" class="btn btn-rounded btn-light"><span class="btn-icon-start text-light"><i class="fa fa-download color-light"></i>
                    </span>Download Rekapitulasi Jalur Mutasi</a>
            </div>
            <div class="col-xl-4 mb-3">
                <a href="<?= base_url('adm/download/prestasi') ?>" target="_blank" class="btn btn-rounded btn-primary"><span class="btn-icon-start text-primary"><i class="fa fa-download color-primary"></i>
                    </span>Download Rekapitulasi Jalur Prestasi</a>
            </div>
            <div class="col-xl-4 mb-3">
                <a href="<?= base_url('adm/download/swasta') ?>" target="_blank" class="btn btn-rounded btn-info"><span class="btn-icon-start text-info"><i class="fa fa-download color-info"></i>
                    </span>Download Rekapitulasi Sekolah Swasta</a>
            </div>
            <div class="col-xl-4 mb-3">
                <a href="<?= base_url('adm/download/belumsekolah') ?>" target="_blank" class="btn btn-rounded btn-warning"><span class="btn-icon-start text-warning"><i class="fa fa-download color-warning"></i>
                    </span>Download Rekapitulasi Belum Sekolah</a>
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