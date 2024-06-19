<div class="table-responsive">
    <table id="data-datatables" class="display data-datatables" style="min-width: 845px">
        <thead>
            <tr>
                <th></th>
                <th>Nama Sekolah</th>
                <th>Kuota Swasta</th>
                <th>Jarak</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($data)) { ?>
                <?php if (count($data) > 0) { ?>
                    <?php foreach ($data as $key => $value) { ?>
                        <tr>
                            <td><img class="rounded-circle" width="35" src="<?= base_url() ?>/assets/images/sekolah.png" alt=""></td>
                            <td>
                                <?= $value->nama ?><br />
                                <?= $value->npsn ?><br />
                                <?= $value->desa_kelurahan . ' - ' . $value->kecamatan ?><br />
                            </td>
                            <td><span><?= $value->total ?></span></td>
                            <td><span><?= round($value->distance_in_km, 3) ?> Km</span></td>
                            <td>
                                <div class="d-flex">
                                    <?php $namaSek = str_replace('&#039;', "`", str_replace("'", "`", $value->nama)); ?>
                                    <button type="button" onclick="aksiDaftar('<?= $value->sekolah_id ?>', '<?= $namaSek . ' (' . $value->npsn . ')' ?>')" class="btn btn-xs btn-primary waves-effect waves-light"><i class="las la-pager font-size-16 align-middle me-2" style="font-size: 1.5rem !important;"></i> DAFTAR KESINI</button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>
<script>
    function aksiDaftar(id, name) {
        Swal.fire({
            title: 'Apakah anda yakin ingin mendaftar ke sekolah ini?',
            text: "Daftar Kesekolah: " + name, 
            showCancelButton: true,
            icon: 'question',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, DAFTAR'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "./pilihsekolah",
                    type: 'POST',
                    data: {
                        id: id,
                        nama: name
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Sedang Loading...',
                            text: 'Please wait while we process your action.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    complete: function() {},
                    success: function(response) {

                        if (response.status == 200) {
                            Swal.close();
                            $('#content-mapModalLabel').html(response.title);
                            $('.content-mapBodyModal').html(response.data);
                            $('.content-mapModal').modal({
                                backdrop: 'static',
                                keyboard: false,
                            });
                            $('.content-mapModal').modal('show');
                        } else {
                            Swal.fire(
                                'Peringatan!',
                                response.message,
                                'warning'
                            );
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

    $(document).ready(function() {
        let tableDatatables = $('.data-datatables').DataTable({
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            },
            lengthMenu: [
                [10, 25, 50],
                [10, 25, 50]
            ],
            "columnDefs": [{
                    "targets": 0,
                    "orderable": false,
                },
                {
                    "targets": 1,
                    "orderable": false,
                },
                {
                    "targets": 2,
                    "orderable": false,
                },
                {
                    "targets": 3,
                    "orderable": false,
                },
                {
                    "targets": 4,
                    "orderable": false,
                }
            ],
        });
    });
</script>