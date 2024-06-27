<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <h4 class="card-title">Riwayat Perubahan Data</h4>
                    </div>
                </div>
            </div>
            <div class="accordion accordion-solid-bg" id="accordion-eight">
                <?php foreach ($riwayat_perubahan_data as $key => $value) { ?>
                    <?php $dataLama = json_decode($value->data_lama);
                    $dataBaru = json_decode($value->data_baru);
                    ?>
                    <?php if ($key == 0) { ?>
                        <div class="accordion-item">
                            <div class="accordion-header  rounded-lg" id="accord-8One<?= $key ?>" data-bs-toggle="collapse" data-bs-target="#collapse8One<?= $key ?>" aria-controls="collapse8One<?= $key ?>" aria-expanded="true" role="button">
                                <span class="accordion-header-icon"></span>
                                <span class="accordion-header-text"><?= ucwords(strtolower($value->nama_pengaju)) ?> (<?= $value->status_pengaju ?>)</span>
                                <span class="accordion-header-indicator"></span>
                            </div>
                            <div id="collapse8One<?= $key ?>" class="collapse accordion__body show" aria-labelledby="accord-8One<?= $key ?>" data-bs-parent="#accordion-eight">
                                <div class="accordion-body-text">
                                    <h4>Panitia : <?= ucwords(strtolower($value->nama_admin_perubahan)) ?></h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-responsive-sm">
                                            <thead>
                                                <tr>
                                                    <th>Atribut</th>
                                                    <th>Data Lama</th>
                                                    <th>Data Baru</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($dataLama->kab_peserta !== $dataBaru->kab_peserta) { ?>
                                                    <tr>
                                                        <td><span class="badge badge-primary">Kabupaten</span>
                                                        <th><?= getNameKabupaten($dataLama->kab_peserta) ?></th>
                                                        <td><?= getNameKabupaten($dataBaru->kab_peserta) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($dataLama->kec_peserta !== $dataBaru->kec_peserta) { ?>
                                                    <tr>
                                                        <td><span class="badge badge-primary">Kecamatan</span>
                                                        <th><?= getNameKecamatan($dataLama->kec_peserta) ?></th>
                                                        <td><?= getNameKecamatan($dataBaru->kec_peserta) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($dataLama->kel_peserta !== $dataBaru->kel_peserta) { ?>
                                                    <tr>
                                                        <td><span class="badge badge-primary">Kelurahan</span>
                                                        <th><?= getNameKelurahan($dataLama->kel_peserta) ?></th>
                                                        <td><?= getNameKelurahan($dataBaru->kel_peserta) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($dataLama->dusun_peserta !== $dataBaru->dusun_peserta) { ?>
                                                    <tr>
                                                        <td><span class="badge badge-primary">Dusun/Lingkungan</span>
                                                        <th><?= getNameDusun($dataLama->dusun_peserta) ?></th>
                                                        <td><?= getNameDusun($dataBaru->dusun_peserta) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($dataLama->lat_long_peserta !== $dataBaru->lat_long_peserta) { ?>
                                                    <tr>
                                                        <td><span class="badge badge-primary">Titik Koordinat</span>
                                                        <th><?= $dataLama->lat_long_peserta ?></th>
                                                        <td><?= $dataBaru->lat_long_peserta ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($dataLama->jarak_domisili !== $dataBaru->jarak_domisili) { ?>
                                                    <tr>
                                                        <td><span class="badge badge-primary">Jarak Domisili</span>
                                                        <th><?= round($dataLama->jarak_domisili, 3) ?> Km</th>
                                                        <td><?= round($dataBaru->jarak_domisili, 3) ?> Km</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>

                        <div class="accordion-item">
                            <div class="accordion-header collapsed rounded-lg" id="accord-8Two<?= $key ?>" data-bs-toggle="collapse" data-bs-target="#collapse8Two<?= $key ?>" aria-controls="collapse8Two<?= $key ?>" aria-expanded="true" role="button">
                                <span class="accordion-header-icon"></span>
                                <span class="accordion-header-text"><?= ucwords(strtolower($value->nama_pengaju)) ?> (<?= $value->status_pengaju ?>)</span>
                                <span class="accordion-header-indicator"></span>
                            </div>
                            <div id="collapse8Two<?= $key ?>" class="collapse accordion__body" aria-labelledby="accord-8Two<?= $key ?>" data-bs-parent="#accordion-eight">
                                <div class="accordion-body-text">
                                    <h4>Panitia : <?= ucwords(strtolower($value->nama_admin_perubahan)) ?></h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-responsive-sm">
                                            <thead>
                                                <tr>
                                                    <th>Atribut</th>
                                                    <th>Data Lama</th>
                                                    <th>Data Baru</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($dataLama->kab_peserta !== $dataBaru->kab_peserta) { ?>
                                                    <tr>
                                                        <td><span class="badge badge-primary">Kabupaten</span>
                                                        <th><?= getNameKabupaten($dataLama->kab_peserta) ?></th>
                                                        <td><?= getNameKabupaten($dataBaru->kab_peserta) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($dataLama->kec_peserta !== $dataBaru->kec_peserta) { ?>
                                                    <tr>
                                                        <td><span class="badge badge-primary">Kecamatan</span>
                                                        <th><?= getNameKecamatan($dataLama->kec_peserta) ?></th>
                                                        <td><?= getNameKecamatan($dataBaru->kec_peserta) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($dataLama->kel_peserta !== $dataBaru->kel_peserta) { ?>
                                                    <tr>
                                                        <td><span class="badge badge-primary">Kelurahan</span>
                                                        <th><?= getNameKelurahan($dataLama->kel_peserta) ?></th>
                                                        <td><?= getNameKelurahan($dataBaru->kel_peserta) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($dataLama->dusun_peserta !== $dataBaru->dusun_peserta) { ?>
                                                    <tr>
                                                        <td><span class="badge badge-primary">Dusun/Lingkungan</span>
                                                        <th><?= getNameDusun($dataLama->dusun_peserta) ?></th>
                                                        <td><?= getNameDusun($dataBaru->dusun_peserta) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($dataLama->lat_long_peserta !== $dataBaru->lat_long_peserta) { ?>
                                                    <tr>
                                                        <td><span class="badge badge-primary">Titik Koordinat</span>
                                                        <th><?= $dataLama->lat_long_peserta ?></th>
                                                        <td><?= $dataBaru->lat_long_peserta ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($dataLama->jarak_domisili !== $dataBaru->jarak_domisili) { ?>
                                                    <tr>
                                                        <td><span class="badge badge-primary">Jarak Domisili</span>
                                                        <th><?= round($dataLama->jarak_domisili, 3) ?> Km</th>
                                                        <td><?= round($dataBaru->jarak_domisili, 3) ?> Km</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>