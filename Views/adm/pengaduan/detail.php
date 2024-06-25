<?= $this->extend('t-verval/adm/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Pengaduan</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Detail</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?= isset($data) ? $data->no_tiket : "" ?></a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <?php if (isset($error_tutup)) { ?>
                        <div class="alert alert-danger fade show">
                            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
                            </button> -->
                            <div class="media">
                                <div class="media-body">
                                    <h5 class="mt-1 mb-1">Peringatan!!!</h5>
                                    <p class="mb-0"><?= $error_tutup ?></p>
                                    <a href="<?= $error_url ?>" class="btn btn-primary">Kembali</a>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="card-body">
                            <div class="post-details">
                                <h3 class="mb-2 text-black"><?= strtoupper($data->jenis_pengaduan) ?></h3>
                                <ul class="mb-4 post-meta d-flex flex-wrap">
                                    <li class="post-author me-3"><button class="btn btn-xxs <?= getStatusTicketPengaduanButton($data->status) ?>"><?= getStatusTicketPengaduan($data->status) ?></button></li>
                                    <li class="post-author me-3">By <?= ucfirst(strtolower($data->nama_pengadu)) ?></li>
                                    <li class="post-date me-3"><i class="far fa-calendar-plus me-2"></i><?= tgl_indo($data->created_at) ?></li>
                                    <li class="post-comment"><i class="fas fa-clock"></i> <?= make_time_long_ago_new($data->created_at) ?></li>
                                </ul>
                                <?php if (isset($data->file)) { ?>
                                    <?php if ($data->file == null || $data->file == "") { ?>
                                    <?php } else { ?>
                                        <img src="https://invome.dexignlab.com/codeigniter/demo/public/assets/images/profile/8.jpg" alt="" class="img-fluid mb-3 w-100 rounded">
                                    <?php } ?>
                                <?php } ?>
                                <div class="content_data_pengaduan_detail" id="content_data_pengaduan_detail"></div>
                                <div class="profile-skills mt-5 mb-5">
                                    <h4 class="text-primary mb-2">Informasi Pengadu</h4>
                                    <a href="javascript:void(0);" class="btn btn-primary light btn-xs mb-1"><?= strtolower($data->email_pengadu) ?></a>
                                    <a href="javascript:void(0);" class="btn btn-primary light btn-xs mb-1"><?= $data->nohp_pengadu ?></a>
                                </div>
                                <div class="comment-respond" id="respond">
                                    <h4 class="comment-reply-title text-primary mb-3" id="reply-title">Aksi </h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <?php if ((int)$data->status == 0) { ?>
                                                    <button onclick="prosesPengaduan('<?= $data->no_tiket ?>', '<?= ucfirst(strtolower($data->nama_pengadu)) ?>')" class="btn btn-sm btn-primary">Proses Pengaduan</button>
                                                <?php } else { ?>
                                                    <?php if ((int)$data->status == 3) { ?>
                                                    <?php } else { ?>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <button onclick="tolakPengaduan('<?= $data->no_tiket ?>', '<?= ucfirst(strtolower($data->nama_pengadu)) ?>')" class="btn btn-block btn-sm btn-warning">Tolak Pengaduan</button>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <button onclick="selesaiPengaduan('<?= $data->no_tiket ?>', '<?= ucfirst(strtolower($data->nama_pengadu)) ?>')" class="btn btn-block btn-sm btn-primary">Verifikasi & Generate Akun</button>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="content-editModal" class="modal fade content-editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-editModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="content-editBodyModal">
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
    function tolakPengaduan(id, nama) {
        Swal.fire({
            title: 'Apakah anda yakin ingin menolak data pengaduan ini?',
            text: "Tolak pengaduan: " + nama,
            showCancelButton: true,
            icon: 'question',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Tolak!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "./formTolak",
                    type: 'POST',
                    data: {
                        id: id,
                        nama: nama
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Memproses data...',
                            text: 'Please wait while we process your action.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    complete: function() {},
                    success: function(resul) {
                        if (resul.status == 200) {
                            Swal.close();
                            $('#content-editModalLabel').html(resul.title);
                            $('.content-editBodyModal').html(resul.data);
                            $('.content-editModal').modal({
                                backdrop: 'static',
                                keyboard: false,
                            });
                            $('.content-editModal').modal('show');
                        } else {
                            Swal.fire(
                                'Failed!',
                                resul.message,
                                'warning'
                            );
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
        });
    };

    function prosesPengaduan(id, nama) {
        Swal.fire({
            title: 'Apakah anda yakin ingin memproses data pengaduan ini?',
            text: "Proses pengaduan: " + nama,
            showCancelButton: true,
            icon: 'question',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Proses!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "./proses",
                    type: 'POST',
                    data: {
                        id: id,
                        nama: nama
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Memproses data...',
                            text: 'Please wait while we process your action.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    complete: function() {},
                    success: function(resul) {

                        if (resul.status !== 200) {
                            if (resul.status !== 201) {
                                if (resul.status === 401) {
                                    Swal.fire(
                                        'Failed!',
                                        resul.message,
                                        'warning'
                                    ).then((valRes) => {
                                        reloadPage();
                                    });
                                } else {
                                    Swal.fire(
                                        'GAGAL!',
                                        resul.message,
                                        'warning'
                                    );
                                }
                            } else {
                                Swal.fire(
                                    'Peringatan!',
                                    resul.message,
                                    'success'
                                ).then((valRes) => {
                                    reloadPage();
                                })
                            }
                        } else {
                            Swal.fire(
                                'BERHASIL!',
                                resul.message,
                                'success'
                            ).then((valRes) => {
                                reloadPage();
                            })
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
        });
    };

    function getContentPengaduan(tiket, jenis) {
        $.ajax({
            url: "./getPengaduan",
            type: 'POST',
            data: {
                tiket: tiket,
                jenis: jenis,
            },
            dataType: 'JSON',
            beforeSend: function() {
                Swal.fire({
                    title: 'Sedang Loading...',
                    text: 'Please wait while we process your action.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            complete: function() {},
            success: function(response) {
                if (response.status == 200) {
                    Swal.close();
                    $('.content_data_pengaduan_detail').html(response.data);
                } else {
                    Swal.fire(
                        'Failed!',
                        response.message,
                        'warning'
                    );
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

    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    $(document).ready(function() {

        <?php if (isset($data)) { ?>
            getContentPengaduan('<?= $data->no_tiket ?>', '<?= $data->jenis_pengaduan ?>');
        <?php } ?>

        // initSelect2('_filter_kec', $('.content-body'));
        // initSelect2('_filter_jenjang', $('.content-body'));
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<?= $this->endSection(); ?>