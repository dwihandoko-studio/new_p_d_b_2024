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
                                    <a href="javascript:void();;" class="btn btn-primary light btn-xs mb-1"><?= strtolower($data->email_pengadu) ?></a>
                                    <a href="javascript:void();;" class="btn btn-primary light btn-xs mb-1"><?= $data->nohp_pengadu ?></a>
                                </div>
                                <div class="comment-respond" id="respond">
                                    <h4 class="comment-reply-title text-primary mb-3" id="reply-title">Aksi </h4>
                                    <div class="row">
                                        <!-- <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="author" class="text-black font-w600 form-label">Name <span class="required">*</span></label>
                                                <input type="text" class="form-control" value="Author" name="Author" placeholder="Author" id="author">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="email" class="text-black font-w600 form-label">Email <span class="required">*</span></label>
                                                <input type="text" class="form-control" value="Email" placeholder="Email" name="Email" id="email">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="comment" class="text-black font-w600 form-label">Comment</label>
                                                <textarea rows="8" class="form-control" name="comment" placeholder="Comment" id="comment"></textarea>
                                            </div>
                                        </div> -->
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <button class="btn btn-sm btn-primary">Proses Pengaduan</button>
                                                <!-- <input type="submit" value="Post Comment" class="submit btn btn-primary" id="submit" name="submit"> -->
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