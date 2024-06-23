<?= $this->extend('t-ppdb/pd/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">App</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Profile</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="profile card card-body px-3 pt-3 pb-0">
                    <div class="profile-head">
                        <div class="photo-content">
                            <div class="cover-photo rounded"></div>
                        </div>
                        <div class="profile-info">
                            <div class="profile-photo">
                                <img style="max-width: 100px; max-height: 100px; width: 100px; height: 100px;" src="<?= $user->image ? base_url('uploads/user') . '/' . $user->image : base_url() . '/assets/images/profile/profile.png' ?>" class="img-fluid rounded-circle" alt="">
                            </div>
                            <div class="profile-details">
                                <div class="profile-name px-3 pt-2">
                                    <h4 class="text-primary mb-0"><?= $user->nama ?></h4>
                                    <p><?= $user->username ?></p>
                                </div>
                                <div class="profile-email px-2 pt-2">
                                    <h4 class="text-muted mb-0"><?= $user->email ?? '-' ?></h4>
                                    <p>Email</p>
                                </div>
                                <div class="profile-email px-2 pt-2">
                                    <h4 class="text-muted mb-0"><?= $user->nohp ?? '-' ?></h4>
                                    <p>No Handphone</p>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a href="#" class="btn btn-primary light sharp" data-bs-toggle="dropdown" aria-expanded="true"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                                <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                                <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                            </g>
                                        </svg></a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li class="dropdown-item"><a href="javascript:aksiEdit(this);"><i class="fas fa-user-edit text-primary me-2"></i> Edit</a></li>
                                        <li class="dropdown-item"><a href="javascript:aksiChangePassword(this);"><i class="fas fa-lock text-primary me-2"></i> Ganti Password</a></li>
                                        <li class="dropdown-item"><a href="javascript:aksiChangeFoto(this);"><i class="fas fa-image text-primary me-2"></i> Ganti Foto</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
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

<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script>
    function aksiEdit(action) {
        $.ajax({
            url: "./edit",
            type: 'POST',
            data: {
                id: 'profile',
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
                    $('#content-editModalLabel').html(response.title);
                    $('.content-editBodyModal').html(response.data);
                    $('.content-editModal').modal({
                        backdrop: 'static',
                        keyboard: false,
                    });
                    $('.content-editModal').modal('show');
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

    function aksiChangePassword(action) {
        $.ajax({
            url: "./edit",
            type: 'POST',
            data: {
                id: 'password',
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
                    $('#content-editModalLabel').html(response.title);
                    $('.content-editBodyModal').html(response.data);
                    $('.content-editModal').modal({
                        backdrop: 'static',
                        keyboard: false,
                    });
                    $('.content-editModal').modal('show');
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

    function aksiChangeFoto(action) {
        $.ajax({
            url: "./edit",
            type: 'POST',
            data: {
                id: 'image',
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
                    $('#content-editModalLabel').html(response.title);
                    $('.content-editBodyModal').html(response.data);
                    $('.content-editModal').modal({
                        backdrop: 'static',
                        keyboard: false,
                    });
                    $('.content-editModal').modal('show');
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

    function initSelect2(event, parrent) {
        $('#' + event).select2({
            width: "100%",
            dropdownParent: parrent
        });
    }

    function reloadPage(action = "") {
        if (action === "") {
            document.location.href = "<?= current_url(true); ?>";
        } else {
            document.location.href = action;
        }
    }

    function aksiLogout(e) {
        // e.preventDefault();
        const href = BASE_URL + "/auth/logout";
        Swal.fire({
            title: 'Apakah anda yakin ingin keluar?',
            text: "Keluar Dari Aplikasi.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Sign Out!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: href,
                    type: 'GET',
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        // $('body.loading-logout').block({
                        //     message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                        // });
                        Swal.fire({
                            title: 'Sedang Loading . . .',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                swal.showLoading();
                            }
                        });
                    },
                    success: function(resMsg) {
                        Swal.fire(
                            'Berhasil!',
                            "Anda berhasil logout.",
                            'success'
                        ).then((valRes) => {
                            document.location.href = BASE_URL + "/home";
                        })
                    },
                    error: function() {
                        $('body.loading-logout').unblock();
                        Swal.fire(
                            'Gagal!',
                            "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                            'warning'
                        );
                    }
                })
            }
        })
    };

    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<?= $this->endSection(); ?>