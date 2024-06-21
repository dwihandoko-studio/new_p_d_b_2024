<?= $this->extend('t-ppdb/pd/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Daftar</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Prestasi</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <?php if (isset($error_tutup)) { ?>
                                <?php if ($error_tutup !== "") { ?>
                                <?php } else { ?>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="_kec" class="col-form-label">Pilih Kecamatan:</label>
                                            <select class="js-data-pd-ajax w-100" style="width: 100%;" id="_kec" name="_kec" onchange="changeKec(this)">
                                                <option value="">-- Pilih --</option>
                                                <?php if (isset($kecamatans)) { ?>
                                                    <?php if (count($kecamatans) > 0) { ?>
                                                        <?php foreach ($kecamatans as $key => $value) { ?>
                                                            <option value="<?= $value->id ?>"><?= $value->nama ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="_kec" class="col-form-label">Pilih Kecamatan:</label>
                                        <select class="js-data-pd-ajax w-100" style="width: 100%;" id="_kec" name="_kec" onchange="changeKec(this)">
                                            <option value="">-- Pilih --</option>
                                            <?php if (isset($kecamatans)) { ?>
                                                <?php if (count($kecamatans) > 0) { ?>
                                                    <?php foreach ($kecamatans as $key => $value) { ?>
                                                        <option value="<?= $value->id ?>"><?= $value->nama ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (isset($error_tutup)) { ?>
                                <?php if ($error_tutup !== "") { ?>
                                    <div class="col-12">
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
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="contentForm" id="contentForm"></div>
                    </div>
                </div>
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
    $('#_kec').select2({
        dropdownParent: ".container-fluid",
    });

    function changeKec(event) {
        const selectedOption = event.value;

        if (selectedOption === "" || selectedOption === undefined) {
            $('.contentForm').html("");
        } else {
            $.ajax({
                url: "./changedKec",
                type: 'POST',
                data: {
                    id: selectedOption,
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
                        $('.contentForm').html(response.data);
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
        }
    }

    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    $(document).ready(function() {});
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<?= $this->endSection(); ?>