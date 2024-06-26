<?= $this->extend('t-dashboard/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">
    <div class="container-fluid" style="padding-top: 0.5rem;">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Layanan Pengaduan</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <a href="javascript:buatPengaduan();" class="btn btn-block btn-primary">Buat Pengaduan</a>
                                    </div>
                                    <div class="col-lg-6">
                                        <!-- <a href="javascript:lacakPengaduan();" class="btn btn-block btn-info">Lacak Tiket Pengaduan</a> -->
                                        <div class="input-group input-primary search-area">
                                            <input type="text" id="_no_tiket_pengaduan" name="_no_tiket_pengaduan" minlength="6" class="form-control" placeholder="Masukkan no tiket...">
                                            <span class="input-group-text"><a href="javascript:lacakPengaduan();"><i class="flaticon-381-search-2"></i></a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="content-lacak-pengaduan" class="content-lacak-pengaduan" style="margin-top: 30px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->include('t-dashboard/bottom'); ?>

        </div>
    </div>
</div>
<div id="content-lacakModal" class="modal fade content-lacakModal">
    <!-- <div id="content-lacakModal" class="modal fade content-lacakModal" tabindex="-1" role="dialog" aria-hidden="true"> -->
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-lacakModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="content-lacakModalBody">
            </div>
        </div>
    </div>
</div>
<div id="content-changeModal" class="modal fade content-changeModal">
    <!-- <div id="content-changeModal" class="modal fade content-changeModal" tabindex="-1" role="dialog" aria-hidden="true"> -->
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-changeModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="content-changeModalBody">
            </div>
        </div>
    </div>
</div>
<div id="content-addModal" class="modal fade content-addModal">
    <!-- <div id="content-addModal" class="modal fade content-addModal" tabindex="-1" role="dialog" aria-hidden="true"> -->
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-addModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="content-addModalBody">
            </div>
        </div>
    </div>
</div>
<div id="content-dataPdModal" class="modal fade content-dataPdModal" style="overflow: auto;">
    <!-- <div id="content-dataPdModal" class="modal fade content-dataPdModal" tabindex="-2" role="dialog" aria-hidden="true"> -->
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-dataPdModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="content-dataPdModalBody">
            </div>
        </div>
    </div>
</div>
<!-- <div id="content-mapModal" class="modal fade content-mapModal"> -->
<div id="content-mapModal" class="modal fade content-mapModal" tabindex="-3" role="dialog" aria-hidden="true">
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
<script src="<?= base_url() ?>/assets/vendor/sweetalert2/sweetalert2.min.js"></script>
<script src="<?= base_url() ?>/assets/vendor/select2/js/select2.min.js"></script>
<script>
    function buatPengaduan() {
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
                    $('#content-addModalLabel').html('BUAT PENGADUAN');
                    $('.content-addModalBody').html(response.data);
                    $('.content-addModal').modal({
                        backdrop: 'static',
                        keyboard: false,
                    });
                    $('.content-addModal').modal('show');
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

    function lacakPengaduan() {
        const noTiketPengaduan = document.getElementsByName('_no_tiket_pengaduan')[0].value;
        $.ajax({
            url: "./getLacakTiket",
            type: 'POST',
            data: {
                _no_tiket_pengaduan: noTiketPengaduan
            },
            dataType: 'JSON',
            beforeSend: function() {
                $('.content-lacak-pengaduan').html("");
                Swal.fire({
                    title: 'Mengambil data...',
                    text: 'Please wait while we process your action.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            complete: function() {},
            success: async function(response) {
                await sleep(2000);
                if (response.status !== 200) {
                    Swal.fire(
                        'Peringatan!',
                        response.message,
                        'warning'
                    );
                } else {
                    Swal.close();
                    $('.content-lacak-pengaduan').html(response.data);
                }
            },
            error: function() {
                Swal.fire(
                    'PERINGATAN!',
                    "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                    'warning'
                );
            }
        });
    }

    async function sleep(ms) {
        return new Promise((resolve) => setTimeout(resolve, ms));
    }

    // function lacakPengaduan() {
    //     $.ajax({
    //         url: "./lacak_tiket",
    //         type: 'POST',
    //         data: {
    //             id: 'add',
    //         },
    //         dataType: "json",
    //         beforeSend: function() {
    //             Swal.fire({
    //                 title: 'Sedang Loading . . .',
    //                 allowEscapeKey: false,
    //                 allowOutsideClick: false,
    //                 didOpen: () => {
    //                     Swal.showLoading();
    //                 }
    //             });
    //         },
    //         complete: function() {},
    //         success: function(response) {
    //             if (response.status == 200) {
    //                 Swal.close();
    //                 $('#content-lacakModalLabel').html('LACAK TIKET PENGADUAN');
    //                 $('.content-lacakModalBody').html(response.data);
    //                 $('.content-lacakModal').modal({
    //                     backdrop: 'static',
    //                     keyboard: false,
    //                 });
    //                 $('.content-lacakModal').modal('show');
    //             } else {
    //                 Swal.fire(
    //                     'Failed!',
    //                     "gagal mengambil data",
    //                     'warning'
    //                 );
    //             }
    //         },
    //         error: function(xhr, ajaxOptions, thrownError) {
    //             Swal.fire(
    //                 'Failed!',
    //                 "gagal mengambil data (" + xhr.status.toString + ")",
    //                 'warning'
    //             );
    //         }

    //     });
    // }

    $(document).ready(function() {
        // initSelect2('_filter_kec', $('.content-body'));
        // initSelect2('_filter_jenjang', $('.content-body'));

    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/vendor/owl-carousel/owl.carousel.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/vendor/nouislider/nouislider.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url() ?>/assets/vendor/toastr/js/toastr.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.js"></script>

<!-- ADD new Leaflet -->
<!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="">
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.css">
<script src="https://unpkg.com/esri-leaflet@2.2.4/dist/esri-leaflet.js"></script>
<script src="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exif-js/2.3.0/exif.js"></script> -->
<?= $this->endSection(); ?>