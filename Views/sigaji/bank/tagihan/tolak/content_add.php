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
            <th data-orderable="false" width="20%">Keterangan</th>
        </tr>
    </thead>
    <tbody class="formtambah">
        <?php if (isset($datas)) { ?>
            <?php if (count($datas) > 0) { ?>
                <?php foreach ($datas as $key => $value) { ?>
                    <tr>
                        <td>
                            <?= $value->nama; ?>
                        </td>
                        <td>
                            <?= $value->nip; ?>
                        </td>
                        <td>
                            <?= $value->nama_instansi; ?>
                        </td>
                        <td>
                            <?= $value->nama_kecamatan; ?>
                        </td>
                        <td>
                            <?= number_rupiah($value->besar_pinjaman); ?>
                        </td>
                        <td>
                            <?= number_rupiah($value->jumlah_tagihan); ?>
                        </td>
                        <td>
                            <?= $value->jumlah_bulan_angsuran; ?>
                        </td>
                        <td>
                            <?= $value->angsuran_ke; ?>
                        </td>
                        <td>
                            <?= $value->keterangan_penolakan; ?>
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