<?= $this->extend('t-verval/pd/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
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
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="input-group   input-primary">
                                                    <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">NISN</span>
                                                    <input type="text" class="form-control" value="<?= $data->nisn ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group   input-primary">
                                                    <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">NIK</span>
                                                    <input type="text" class="form-control" id="_nik" name="_nik" value="<?= $data->nik ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group   input-primary">
                                                    <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">KK</span>
                                                    <input type="text" class="form-control" id="_kk" name="_kk" value="<?= $data->no_kk ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group   input-primary">
                                                    <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Nama</span>
                                                    <input type="text" class="form-control" id="_nama" name="_nama" value="<?= $data->nama ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group   input-primary">
                                                    <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Tempat Lahir </span>
                                                    <input type="text" class="form-control" value="<?= $data->tempat_lahir ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group   input-primary">
                                                    <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Tanggal lahir </span>
                                                    <input type="text" class="form-control" value="<?= $data->tanggal_lahir ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group   input-primary">
                                                    <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Nama Ibu</span>
                                                    <input type="text" class="form-control" value="<?= $data->nama_ibu_kandung ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group   input-primary">
                                                    <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Jenis Kelamin</span>
                                                    <input type="text" class="form-control" value="<?= $data->jenis_kelamin ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group   input-primary">
                                                    <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">No HP</span>
                                                    <input type="text" class="form-control" value="<?= $user->nohp ?>" readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="input-group   input-primary">
                                                    <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Sekolah Asal</span>
                                                    <input type="text" class="form-control" value="<?= $data->sekolah_asal ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group   input-primary">
                                                    <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">NPSN Asal</span>
                                                    <input type="text" class="form-control" value="<?= $data->npsn_asal ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group   input-primary">
                                                    <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Alamat Domisili</span>
                                                    <input type="text" class="form-control" value="<?= $data->alamat_jalan ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group   input-primary">
                                                    <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Provinsi</span>
                                                    <input type="text" class="form-control" value="<?= getNameProvinsi($data->kab) ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group   input-primary">
                                                    <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Kabupaten</span>
                                                    <input type="text" class="form-control" value="<?= getNameKabupaten($data->kab) ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group   input-primary">
                                                    <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Kecamatan</span>
                                                    <input type="text" class="form-control" value="<?= getNameKecamatan($data->kec) ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group   input-primary">
                                                    <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Desa/Kelurahan</span>
                                                    <input type="text" class="form-control" value="<?= getNameKelurahan($data->kel) ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group   input-primary">
                                                    <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Dusun/Lingkungan</span>
                                                    <input type="text" class="form-control" value="<?= getNameDusun($data->dusun) ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group   input-primary">
                                                    <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Koordinat</span>
                                                    <input type="text" class="form-control" value="<?= $data->lintang . ',' . $data->bujur ?>" readonly />
                                                    <span class="input-group-text lihatPetanya" data-id="https://www.google.com/maps/@<?= $data->lintang ?>,<?= $data->bujur ?>,17z?q=<?= $data->lintang ?>,<?= $data->bujur ?>(Target Location)">Lihat</span>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                                <a href="<?= base_url('pd/daftar/afirmasi') ?>">
                                    <div class="widget-stat card bg-primary">
                                        <div class="card-body  p-4">
                                            <div class="media">
                                                <span class="me-3">
                                                    <i class="las la-school"></i>
                                                </span>
                                                <div class="media-body text-white">
                                                    <p class="mb-1">JALUR AFIRMASI</p>
                                                    <small>Daftar Via Jalur Afirmasi</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                                <a href="<?= base_url('pd/daftar/zonasi') ?>">
                                    <div class="widget-stat card bg-warning">
                                        <div class="card-body  p-4">
                                            <div class="media">
                                                <span class="me-3">
                                                    <i class="las la-map-marked-alt"></i>
                                                </span>
                                                <div class="media-body text-white">
                                                    <p class="mb-1">JALUR ZONASI</p>
                                                    <small>Daftar Via Jalur Zonasi</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                                <a href="<?= base_url('pd/daftar/mutasi') ?>">
                                    <div class="widget-stat card bg-danger">
                                        <div class="card-body  p-4">
                                            <div class="media">
                                                <span class="me-3">
                                                    <i class="las la-bezier-curve"></i>
                                                </span>
                                                <div class="media-body text-white">
                                                    <p class="mb-1">JALUR MUTASI</p>
                                                    <small>Daftar Via Jalur Mutasi</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                                <a href="<?= base_url('pd/daftar/prestasi') ?>">
                                    <div class="widget-stat card bg-info">
                                        <div class="card-body  p-4">
                                            <div class="media">
                                                <span class="me-3">
                                                    <i class="las la-trophy"></i>
                                                </span>
                                                <div class="media-body text-white">
                                                    <p class="mb-1">JALUR PRESTASI</p>
                                                    <small>Daftar Via Jalur Prestasi</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                                <a href="<?= base_url('pd/daftar/swasta') ?>">
                                    <div class="widget-stat card bg-blue">
                                        <div class="card-body  p-4">
                                            <div class="media">
                                                <span class="me-3">
                                                    <i class="las la-university"></i>
                                                </span>
                                                <div class="media-body text-white">
                                                    <p class="mb-1">SEKOLAH SWASTA</p>
                                                    <small>Daftar Ke Sekolah Swasta</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php if (isset($canAccessPPDB)) { ?>
                                <?php if ($canAccessPPDB) { ?>
                                    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                                        <a href="<?= base_url('sek/ppdb/home') ?>">
                                            <div class="widget-stat card bg-info">
                                                <div class="card-body  p-4">
                                                    <div class="media">
                                                        <span class="me-3">
                                                            <i class="la la-users"></i>
                                                        </span>
                                                        <div class="media-body text-white">
                                                            <p class="mb-1">PPDB 2024/2025</p>
                                                            <small>Aplikasi PPDB</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                            <?php } ?>
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

<script src="<?= base_url() ?>/assets/vendor/chart.js/Chart.bundle.min.js"></script>
<script src="<?= base_url() ?>/assets/vendor/apexchart/apexchart.js"></script>
<script src="<?= base_url() ?>/assets/vendor/peity/jquery.peity.min.js"></script>
<script src="<?= base_url() ?>/assets/vendor/nouislider/nouislider.min.js"></script>
<script src="<?= base_url() ?>/assets/vendor/wnumb/wNumb.js"></script>
<script src="<?= base_url() ?>/assets/js/dashboard/dashboard-1.js"></script>
<script src="<?= base_url() ?>/assets/vendor/owl-carousel/owl.carousel.js"></script>
<script>
    $(document).on('click', '.lihatPetanya', function(e) {
        // const dataId = e.getAttribute('data-id');
        const url = this.dataset.id;

        // Open the URL in a new tab
        window.open(url, '_blank');
    });

    $(document).ready(function() {
        <?php if ($firs_login) { ?>
            $.ajax({
                url: "./edit",
                type: 'POST',
                data: {
                    id: 'edit',
                },
                dataType: 'JSON',
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
                success: function(resul) {
                    if (resul.status !== 200) {
                        Swal.fire(
                            'Failed!',
                            resul.message,
                            'warning'
                        );
                    } else {
                        Swal.close();
                        $('#content-firsloginModalLabel').html('LENGKAPI DATA');
                        $('.content-firsloginBodyModal').html(resul.data);
                        $('.content-firsloginModal').modal({
                            backdrop: 'static',
                            keyboard: false,
                        });
                        $('.content-firsloginModal').modal('show');
                    }
                }
            });
        <?php } ?>
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