<?= $this->extend('t-ppdb/pd/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
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
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="card-title">Data Peserta</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" style="margin-top: 30px;">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">NISN</span>
                                            <input type="text" class="form-control" value="<?= $data->nisn ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">NIK</span>
                                            <input type="text" class="form-control" id="_nik" name="_nik" value="<?= $data->nik ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">KK</span>
                                            <input type="text" class="form-control" id="_kk" name="_kk" value="<?= $data->no_kk ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Nama</span>
                                            <input type="text" class="form-control" id="_nama" name="_nama" value="<?= $data->nama ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Tempat Lahir </span>
                                            <input type="text" class="form-control" value="<?= $data->tempat_lahir ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Tanggal lahir </span>
                                            <input type="text" class="form-control" value="<?= $data->tanggal_lahir ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Nama Ibu</span>
                                            <input type="text" class="form-control" value="<?= $data->nama_ibu_kandung ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Jenis Kelamin</span>
                                            <input type="text" class="form-control" value="<?= $data->jenis_kelamin ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Sekolah Asal</span>
                                            <input type="text" class="form-control" value="<?= $data->sekolah_asal ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">NPSN Asal</span>
                                            <input type="text" class="form-control" value="<?= $data->npsn_asal ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Alamat Domisili</span>
                                            <input type="text" class="form-control" value="<?= $data->alamat_jalan ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Provinsi</span>
                                            <input type="text" class="form-control" value="<?= getNameProvinsi($data->kab) ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Kabupaten</span>
                                            <input type="text" class="form-control" value="<?= getNameKabupaten($data->kab) ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Kecamatan</span>
                                            <input type="text" class="form-control" value="<?= getNameKecamatan($data->kec) ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Desa/Kelurahan</span>
                                            <input type="text" class="form-control" value="<?= getNameKelurahan($data->kel) ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Dusun/Lingkungan</span>
                                            <input type="text" class="form-control" value="<?= getNameDusun($data->dusun) ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Koordinat</span>
                                            <input type="text" class="form-control" value="<?= $data->lintang . ',' . $data->bujur ?>" readonly />
                                            <span class="input-group-text lihatPetanya" data-id="https://www.google.com/maps/@<?= $data->lintang ?>,<?= $data->bujur ?>,17z?q=<?= $data->lintang ?>,<?= $data->bujur ?>(Target Location)">Lihat</span>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Email</span>
                                            <input type="email" class="form-control" id="_email" name="_email" placeholder="example@example.com" value="<?= $user->email ?>" required />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">No HP</span>
                                            <input type="phone" class="form-control" id="_nohp" name="_nohp" placeholder="628xxxxxxxxxxx" value="<?= $user->nohp ?>" required />
                                        </div>
                                        <p>&nbsp;&nbsp;Bisa menggunakan No Handphone Wali. Digunakan untuk menghubungi peserta / Wali oleh Sekolah Tujuan.<br />
                                            <span style="color: blue;">&nbsp;&nbsp;Pastikan No Handphone aktif (diutamakan yang tertaut Whatsapp / Telegram)</span>
                                        </p>
                                    </div>
                                    <div class="col-12 mb-3 ">
                                        <?php if (isset($error_tutup)) { ?>
                                            <?php if ($error_tutup !== "") { ?>
                                                <a href="<?= base_url('pd/home') ?>" class="btn btn-block btn-xs btn-primary waves-effect waves-light"><i class="las la-reply-all font-size-16 align-middle me-2" style="font-size: 1.5rem !important;"></i> KEMBALI</a>
                                            <?php } else { ?>
                                                <button type="button" onclick="aksiConfirm()" class="btn btn-block btn-xs btn-primary waves-effect waves-light"><i class="las la-check-circle font-size-16 align-middle me-2" style="font-size: 1.5rem !important;"></i> KONFIRMASI & LANJUTKAN</button>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <button type="button" onclick="aksiConfirm()" class="btn btn-block btn-xs btn-primary waves-effect waves-light"><i class="las la-check-circle font-size-16 align-middle me-2" style="font-size: 1.5rem !important;"></i> KONFIRMASI & LANJUTKAN</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="content-firsloginModal" class="modal fade content-firsloginModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-firsloginModalLabel">Modal title</h5>
                </button>
            </div>
            <div class="content-firsloginBodyModal">
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>

<script>
    function aksiConfirm() {
        const email = document.querySelector('#_email');
        const nohp = document.querySelector('#_nohp');

        if ((email.value === "" || email === undefined)) {
            Swal.fire(
                'Failed!',
                "Silahkan masukan email terlebih dahulu.",
                'warning'
            ).then((valR) => {
                email.focus();
            });

            return false;
        }

        if ((nohp.value === "" || nohp === undefined)) {
            Swal.fire(
                'Failed!',
                "Silahkan masukan no handphone terlebih dahulu.",
                'warning'
            ).then((valR) => {
                email.focus();
            });

            return false;
        }
        Swal.fire({
            title: 'Apakah anda yakin ingin melanjutkan dengan data?',
            text: "Email: " + email.value + " No Handphone: " + nohp.value,
            showCancelButton: true,
            icon: 'question',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Konfirmasi & Lanjutkan'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "./validasiData",
                    type: 'POST',
                    data: {
                        email: email.value,
                        nohp: nohp.value,
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Sedang loading ...',
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
                            reloadPage(resul.url);
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
    }

    $(document).on('click', '.lihatPetanya', function(e) {
        // const dataId = e.getAttribute('data-id');
        const url = this.dataset.id;

        // Open the URL in a new tab
        window.open(url, '_blank');
    });

    $(document).ready(function() {

    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<style>
    .lihatPetanya {
        background-color: #407d4a !important;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .lihatPetanya:hover {
        background-color: #d653c1 !important;
    }
</style>
<?= $this->endSection(); ?>