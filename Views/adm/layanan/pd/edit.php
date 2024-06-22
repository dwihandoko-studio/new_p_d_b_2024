<?= $this->extend('t-verval/adm/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Layanan</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Peserta Didik Tingkat Akhir</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Edit Domisili</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <?php if (isset($error_tutup)) { ?>
                    <?php if ($error_tutup) { ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
                            </button>
                            <div class="media">
                                <div class="media-body">
                                    <h5 class="mt-1 mb-1">Peringatan!!!</h5>
                                    <p class="mb-0"><?= $error_tutup ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="contentEditForm" id="contentEditForm"></div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="contentEditForm" id="contentEditForm"></div>
                        </div>
                    </div>
                <?php } ?>

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
<script>
    function changePd(id, sek) {
        $.ajax({
            url: "./changedPd",
            type: 'POST',
            data: {
                id: id,
                sekolah_id: sek,
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
                    $('.contentEditForm').html(response.data);
                } else {
                    Swal.fire(
                        'Failed!',
                        response.message,
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

    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    $(document).ready(function() {
        changePd('<?= $id ?>', '<?= $sekolah_id ?>');
        // initSelect2('_filter_kec', $('.content-body'));
        // initSelect2('_filter_jenjang', $('.content-body'));
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.js"></script>
<?= $this->endSection(); ?>