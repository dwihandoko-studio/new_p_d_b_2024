<table id="data-datatables" class="table table-bordered w-100 tb-datatables">
    <thead>
        <tr>
            <th data-orderable="false">#</th>
            <th data-orderable="false" width="20%">Nama</th>
            <th data-orderable="false">NIP</th>
            <th data-orderable="false">Instansi</th>
            <th data-orderable="false">Kecamatan</th>
            <th data-orderable="false">Besar Pinjaman</th>
            <th data-orderable="false">Jumlah Tagihan</th>
            <th data-orderable="false">Jml Bulan<br>Angs</th>
            <th data-orderable="false">Angs Ke</th>
            <th data-orderable="false"> </th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($datas)) { ?>
            <?php if (count($datas) > 0) { ?>
                <?php foreach ($variable as $key => $value) { ?>
                    <?php if ($key < 1) { ?>

                    <?php } else { ?>

                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td>
                        <input class="form-check-input" type="checkbox" id="formCheck1">
                    </td>
                    <td>
                        <select class="form-control filter-pegawai" id="_filter_pegawai" name="_filter_pegawai" required>
                            <option value="">--Pilih--</option>
                            <?php if (isset($tws)) {
                                if (count($tws) > 0) {
                                    foreach ($tws as $key => $value) { ?>
                                        <option value="<?= $value->id ?>">Tahun <?= $value->tahun ?> - Bulan. <?= $value->bulan ?></option>
                            <?php }
                                }
                            } ?>
                        </select>
                        <script>
                            initSelect2('_filter_pegawai', 'tb-datatables');
                        </script>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="Nip" id="example-text-input">
                    </td>
                    <td>
                        <input class="form-control" type="text" value="instansi" id="example-text-input">
                    </td>
                    <td>
                        <input class="form-control" type="text" value="kecamatan" id="example-text-input">
                    </td>
                    <td>
                        <input class="form-control" type="number" value="1" id="example-text-input">
                    </td>
                    <td>
                        <input class="form-control" type="number" value="1" id="example-text-input">
                    </td>
                    <td>
                        <input class="form-control" type="number" value="1" id="example-text-input">
                    </td>
                    <td>
                        <input class="form-control" type="number" value="1" id="example-text-input">
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light">+</button>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td>
                    <input class="form-check-input" type="checkbox" id="formCheck1">
                </td>
                <td>
                    <select class="form-control filter-pegawai" id="_filter_pegawai" name="_filter_pegawai" required>
                        <option value="">--Pilih--</option>
                        <?php if (isset($tws)) {
                            if (count($tws) > 0) {
                                foreach ($tws as $key => $value) { ?>
                                    <option value="<?= $value->id ?>">Tahun <?= $value->tahun ?> - Bulan. <?= $value->bulan ?></option>
                        <?php }
                            }
                        } ?>
                    </select>
                    <script>
                        initSelect2('_filter_pegawai', 'data-contens');
                    </script>
                </td>
                <td>
                    <input class="form-control" type="text" value="Nip" id="example-text-input">
                </td>
                <td>
                    <input class="form-control" type="text" value="instansi" id="example-text-input">
                </td>
                <td>
                    <input class="form-control" type="text" value="kecamatan" id="example-text-input">
                </td>
                <td>
                    <input class="form-control" type="number" value="1" id="example-text-input">
                </td>
                <td>
                    <input class="form-control" type="number" value="1" id="example-text-input">
                </td>
                <td>
                    <input class="form-control" type="number" value="1" id="example-text-input">
                </td>
                <td>
                    <input class="form-control" type="number" value="1" id="example-text-input">
                </td>
                <td>
                    <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light">+</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>