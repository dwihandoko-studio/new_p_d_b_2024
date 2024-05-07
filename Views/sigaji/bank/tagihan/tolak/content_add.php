<table id="data-datatables" class="table table-bordered w-100 tb-datatables">
    <thead>
        <tr>
            <th data-orderable="false" width="19%">Nama</th>
            <th data-orderable="false" width="14.5%">NIP</th>
            <th data-orderable="false">Instansi</th>
            <th data-orderable="false">Kecamatan</th>
            <th data-orderable="false" width="11%">Besar Pinjaman</th>
            <th data-orderable="false" width="10%">Jumlah Tagihan</th>
            <th data-orderable="false" width="7.5%">Jml Bulan<br>Angs</th>
            <th data-orderable="false" width="7%">Angs Ke</th>
        </tr>
    </thead>
    <tbody class="formtambah">
        <?php if (isset($datas)) { ?>
            <?php if (count($datas) > 0) { ?>
                <?php foreach ($datas as $key => $value) { ?>
                    <tr>
                        <td>
                            <input class="form-control" type="text" value="<?= $value->nama; ?>" id="nama_<?= $key + 1; ?>" name="nama[]" readonly>
                        </td>
                        <td>
                            <input class="form-control" type="text" value="<?= $value->nip; ?>" id="nip_<?= $key + 1; ?>" name="nip[]" readonly>
                        </td>
                        <td>
                            <input class="form-control" type="text" value="<?= $value->nama_instansi; ?>" id="instansi_<?= $key + 1; ?>" name="instansi[]" readonly>
                        </td>
                        <td>
                            <input class="form-control" type="text" value="<?= $value->nama_kecamatan; ?>" id="kecamatan_<?= $key + 1; ?>" name="kecamatan[]" readonly>
                        </td>
                        <td>
                            <input class="form-control jumlah-pinjaman" type="text" value="<?= number_rupiah($value->besar_pinjaman); ?>" id="jumlah_pinjaman_<?= $key + 1; ?>" name="jumlah_pinjaman[]" readonly>
                        </td>
                        <td>
                            <input class="form-control jumlah-pinjaman" type="text" value="<?= number_rupiah($value->jumlah_tagihan); ?>" id="jumlah_tagihan_<?= $key + 1; ?>" name="jumlah_tagihan[]" readonly>
                        </td>
                        <td>
                            <input class="form-control" type="number" value="<?= $value->jumlah_bulan_angsuran; ?>" id="jumlah_bulan_angsuran_<?= $key + 1; ?>" name="jumlah_bulan_angsuran[]" readonly>
                        </td>
                        <td>
                            <input class="form-control" type="number" value="<?= $value->angsuran_ke; ?>" id="angsuran_ke_<?= $key + 1; ?>" name="angsuran_ke[]" readonly>
                        </td>
                    </tr>

                <?php } ?>
            <?php } else { ?>

            <?php } ?>
        <?php } else { ?>

            </tr>
        <?php } ?>
    </tbody>
</table>

<script>

</script>