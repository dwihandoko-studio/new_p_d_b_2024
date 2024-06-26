<?= $this->extend('t-ppdb/pd/index'); ?>

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
                                        <h4 class="card-title">Profil Peserta</h4>
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
                                            <input type="email" class="form-control" id="_email" name="_email" placeholder="example@example.com" value="<?= $user->email ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">No HP</span>
                                            <input type="phone" class="form-control" id="_nohp" name="_nohp" placeholder="628xxxxxxxxxxx" value="<?= $user->nohp ?>" readonly />
                                        </div>
                                        </p>
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