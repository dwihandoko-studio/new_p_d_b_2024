<?= $this->extend('t-ppdb/sek/index'); ?>

<?= $this->section('content'); ?>
<?php $dokument = json_decode($data->lampiran); ?>
<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Data Detail Pendaftaran Tertolak</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?= $koreg ?></a></li>
            </ol>
        </div>
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
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Kode Pendaftaran</span>
                                            <input type="text" class="form-control" id="_kode_pendaftaran" name="_kode_pendaftaran" value="<?= $data->kode_pendaftaran ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Nama</span>
                                            <input type="text" class="form-control" id="_nama_peserta" name="_nama_peserta" value="<?= $data->nama_peserta ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">NISN</span>
                                            <input type="text" class="form-control" id="_nisn_peserta" name="_nisn_peserta" value="<?= $data->nisn_peserta ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">NIK</span>
                                            <input type="text" class="form-control" value="<?= $data->nik ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">KK</span>
                                            <input type="text" class="form-control" value="<?= $data->no_kk ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Tempat Lahir </span>
                                            <input type="text" class="form-control" value="<?= $data->tempat_lahir_peserta ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Tanggal lahir </span>
                                            <input type="text" class="form-control" value="<?= tgl_indo($data->tanggal_lahir_peserta) ?>" readonly />
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
                                            <input type="text" class="form-control" value="<?= $data->jenis_kelamin_peserta ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Sekolah Asal</span>
                                            <input type="text" class="form-control" value="<?= $data->nama_sekolah_asal ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">NPSN Asal</span>
                                            <input type="text" class="form-control" value="<?= $data->npsn_sekolah_asal ?>" readonly />
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
                                            <input type="text" class="form-control" value="<?= getNameProvinsi($data->kab_peserta) ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Kabupaten</span>
                                            <input type="text" class="form-control" value="<?= getNameKabupaten($data->kab_peserta) ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Kecamatan</span>
                                            <input type="text" class="form-control" value="<?= getNameKecamatan($data->kec_peserta) ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Desa/Kelurahan</span>
                                            <input type="text" class="form-control" value="<?= getNameKelurahan($data->kel_peserta) ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Dusun/Lingkungan</span>
                                            <input type="text" class="form-control" value="<?= getNameDusun($data->dusun_peserta) ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Koordinat</span>
                                            <input type="text" class="form-control" value="<?= $data->lat_long_peserta ?>" readonly />
                                            <span class="input-group-text lihatPetanya" data-id="https://www.google.com/maps/@<?= $data->lat_long_peserta ?>,17z?q=<?= $data->lat_long_peserta ?>(Target Location)">Lihat</span>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Email</span>
                                            <input type="email" class="form-control" id="_email" name="_email" placeholder="example@example.com" value="<?= $data->email ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group   input-primary">
                                            <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">No HP</span>
                                            <input type="phone" class="form-control" id="_nohp" name="_nohp" placeholder="628xxxxxxxxxxx" value="<?= $data->nohp ?>" readonly />
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
                        <div class="col-12 mb-2">
                            <div class="input-group   input-primary">
                                <span class="input-group-text" style="width: 110px; min-width: 110px;min-width: 110px;">Jarak Domisili</span>
                                <input type="text" class="form-control" value="<?= round($data->jarak_domisili, 3) . ' Km' ?>" readonly />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-6">
                            <h4 class="card-title">Keterangan Penolakan</h4>
                        </div>
                        <div class="col-12 mb-2">
                            <p><?= $data->keterangan_penolakan ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 mb-2">
                                <a href="<?= base_url('sek/ppdb/rekap/lolos') ?>" class="btn btn-block btn-xs btn-primary waves-effect waves-light"><i class="las la-undo font-size-16 align-middle me-2" style="font-size: 1.5rem !important;"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="content-tolakModal" class="modal fade content-tolakModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-tolakModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="content-tolakBodyModal">
            </div>
        </div>
    </div>
</div>
<div id="content-editModal" class="modal fade content-editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 90vw !important;">
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