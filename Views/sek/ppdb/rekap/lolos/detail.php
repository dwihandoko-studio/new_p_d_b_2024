<?= $this->extend('t-ppdb/sek/index'); ?>

<?= $this->section('content'); ?>
<?php $dokument = json_decode($data->lampiran); ?>
<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Data Detail Pendaftaran</a></li>
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
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="card-title">Valida Data & Dokumen <?= $data->via_jalur == "SWASTA" ? 'Sekolah ' . ucwords(strtolower($data->via_jalur)) : 'Jalur ' . ucwords(strtolower($data->via_jalur)) ?></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <h4>Kesesuaian Data Dan Kepemilikan Dokumen Persyaratan :</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th colspan="2">Data / Dokumen</th>
                                                <th>Isian Peserta</th>
                                                <th>Validasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1.</td>
                                                <td colspan="2">Data Peserta</td>
                                                <td>Diatas</td>
                                                <td>
                                                    <!-- <div class="radio">
                                                        <label for="_data_peserta"><input type="radio" id="_data_peserta" name="_data_peserta" value="ya"> Sesuai</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label for="_data_peserta_no"><input type="radio" id="_data_peserta_no" name="_data_peserta" value="tidak"> Tidak</label>
                                                    </div> -->
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" id="_data_peserta" name="_data_peserta" value="ya">
                                                        <label class="form-check-label" for="_data_peserta">
                                                            Sesuai
                                                        </label>
                                                    </div>
                                                    <!-- <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="_data_peserta_no" name="_data_peserta" value="tidak">
                                                            <label class="form-check-label" for="_data_peserta_no">
                                                                Tidak
                                                            </label>
                                                        </div> -->
                                                </td>
                                            </tr>

                                            <?php if (isset($dokument->dokumen)) { ?>
                                                <?php if (count($dokument->dokumen) > 0) { ?>
                                                    <?php foreach ($dokument->dokumen as $key => $value) { ?>
                                                        <tr>
                                                            <td><?= $key + 2 ?>.</td>
                                                            <td colspan="2"><?= getTitleDokumenPersyaratan($value->key) ?></td>
                                                            <td><?= (int)$value->value == 1 ? 'Ada' : 'Tidak ada' ?></td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" id="_<?= $value->key ?>" name="_<?= $value->key ?>" name="gridRadios" value="ya">
                                                                    <label class="form-check-label" for="_<?= $value->key ?>">
                                                                        Sesuai
                                                                    </label>
                                                                </div>
                                                                <!-- <div class="form-check">
                                                                        <input class="form-check-input" type="radio" id="_<?= $value->key ?>_no" name="_<?= $value->key ?>" name="gridRadios" value="tidak">
                                                                        <label class="form-check-label" for="_<?= $value->key ?>_no">
                                                                            Tidak
                                                                        </label>
                                                                    </div> -->
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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
                            <div class="col-4 mb-2">
                                <a href="<?= base_url('sek/ppdb/rekap/lolos') ?>" class="btn btn-block btn-xs btn-primary waves-effect waves-light"><i class="las la-tasks font-size-16 align-middle me-2" style="font-size: 1.5rem !important;"></i> Verifikasi</a>
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
    $(document).ready(function() {

    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<?= $this->endSection(); ?>