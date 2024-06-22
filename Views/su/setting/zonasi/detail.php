<div class="modal-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-8">
                                    <h4 class="card-title">Data Zonasi Kelurahan <?= $nama_kelurahan ?> | <?= $sekolah ?></h4>
                                    <span>Prov. <?= $data[0]->nama_provinsi ?> | Kab. <?= $data[0]->nama_kabupaten ?> | Kec. <?= $data[0]->nama_kecamatan ?></span>
                                </div>
                                <div class="col-4">
                                    <button type="button" class="btn btn-sm btn-primary waves-effect waves-light btnadddusun"><i class="fas fa-plus-square font-size-16 align-middle me-2"></i> Tambah Dusun</button> &nbsp;&nbsp;
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Dusun</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data as $key => $value) { ?>
                                            <tr id="key-tr-<?= $value->id ?>" class="key-tr-<?= $value->id ?>">
                                                <th><?= $key + 1; ?></th>
                                                <th><?= $value->nama_dusun; ?></th>
                                                <th><button type="button" id="btn-<?= $value->id ?>" class="btn btn-danger btn-rounded waves-effect waves-light btnhapusform"><i class="fas fa-trash"></i></button></th>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
</div>

<script>
    $(document).on('click', '.btnadddusun', function(e) {
        e.preventDefault();

        $.ajax({
            url: "./addDusun",
            type: 'POST',
            data: {
                id: 'add',
            },
            dataType: "json",
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
            complete: function() {},
            success: function(response) {
                if (response.status == 200) {
                    Swal.close();
                    $('#content-editModalLabel').html('TAMBAH PANITIA PPDB');
                    $('.content-editBodyModal').html(response.data);
                    $('.content-editModal').modal({
                        backdrop: 'static',
                        keyboard: false,
                    });
                    $('.content-editModal').modal('show');
                } else {
                    Swal.fire(
                        'Failed!',
                        "gagal mengambil data",
                        'warning'
                    );
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                Swal.fire(
                    'Failed!',
                    "gagal mengambil data (" + xhr.status.toString + ")",
                    'warning'
                );
            }

        });
    });
</script>