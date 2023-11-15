<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Usulan TAMSIL Lolos Berkas Tahun <?= $tw->tahun ?> - TW. <?= $tw->tw ?></title>
</head>

<body>
    <?php
    header('Content-Type: application/vnd-ms-excel');
    header('Content-Disposition: attachment; filename=Data Usulan TAMSIL Lolos Berkas Tahun ' . $tw->tahun . ' - Tw ' . $tw->tw . '.xls');
    ?>

    <center>
        <h2>Data Usulan TAMSIL Lolos Berkas Tahun <?= $tw->tahun ?> - TW. <?= $tw->tw ?></h2>
    </center>

    <table border="1">
        <tr>
            <th>NO</th>
            <th>NAMA</th>
            <th>NIK</th>
            <th>NUPTK</th>
            <th>JENIS PTK</th>
            <th>NO REKENING</th>
            <th>CABANG BANK</th>
            <th>TANGGAL USULAN</th>
        </tr>
        <?php if (isset($datas)) { ?>
            <?php if (count($datas) > 0) { ?>
                <?php foreach ($datas as $key => $item) { ?>
                    <tr>
                        <td><?= $key + 1 ?> </td>
                        <td><?= $item->nama ?> </td>
                        <td><?= substr($item->nik, 0) ?> </td>
                        <td><?= substr($item->nuptk, 0) ?> </td>
                        <td><?= $item->jenis_ptk ?> </td>
                        <td><?= substr($item->no_rekening, 0) ?> </td>
                        <td><?= $item->cabang_bank ?> </td>
                        <td><?= $item->created_usulan ?> </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </table>
</body>

</html>