<?= $this->extend('t-ppdb/pd/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Daftar</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Zonasi</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-primary notification">
                            <p class="notificaiton-title mb-2"><strong>INFORMASI !!!</strong></p>
                            <p><?= $message ?></p>
                            <button onclick="actionDownload('<?= $koreg ?>', 'Download')" class="btn btn-primary btn-sm">Download Bukti Pendaftaran</button>
                            <!-- <button class="btn btn-link btn-sm">Cancel</button> -->
                        </div>
                        <!-- <div class="alert alert-primary solid alert-square"><strong>INFORMASI !!!</strong> <br /><?= $message ?></div> -->
                    </div>
                </div>
            </div>
            <!-- <div class="col-12">
                <div class="card">
                    <div class="card-body">

                    </div>
                </div>
            </div> -->
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
<script src="<?= base_url() ?>/assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script>
    function actionDownload(id, nama) {
        Swal.fire({
            title: 'Apakah anda yakin ingin mendownload Bukti Pendaftaran ini?',
            text: "Download Bukti Pendaftaran",
            showCancelButton: true,
            icon: 'question',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Download!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "./download",
                    type: 'POST',
                    data: {
                        id: id,
                        nama: nama,
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Mendownload Data...',
                            text: 'Please wait while we process your action.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    complete: function() {},
                    success: function(resul) {

                        if (resul.status !== 200) {
                            if (resul.status !== 201) {
                                if (resul.status === 401) {
                                    Swal.fire(
                                        'Failed!',
                                        resul.message,
                                        'warning'
                                    ).then((valRes) => {
                                        reloadPage();
                                    });
                                } else {
                                    Swal.fire(
                                        'GAGAL!',
                                        resul.message,
                                        'warning'
                                    );
                                }
                            } else {
                                Swal.fire(
                                    'Peringatan!',
                                    resul.message,
                                    'success'
                                ).then((valRes) => {
                                    // reloadPage();
                                    const decodedBytes = atob(resul.data);
                                    const arrayBuffer = new ArrayBuffer(decodedBytes.length);
                                    const intArray = new Uint8Array(arrayBuffer);
                                    for (let i = 0; i < decodedBytes.length; i++) {
                                        intArray[i] = decodedBytes.charCodeAt(i);
                                    }

                                    const blob = new Blob([intArray], {
                                        type: 'application/pdf'
                                    });
                                    const link = document.createElement('a');
                                    link.href = URL.createObjectURL(blob);
                                    link.download = resul.filename; // Set desired filename
                                    link.click();

                                    // Revoke the object URL after download (optional)
                                    URL.revokeObjectURL(link.href);

                                })
                            }
                        } else {
                            Swal.fire(
                                'BERHASIL!',
                                resul.message,
                                'success'
                            ).then((valRes) => {
                                // reloadPage();
                                const decodedBytes = atob(resul.data);
                                const arrayBuffer = new ArrayBuffer(decodedBytes.length);
                                const intArray = new Uint8Array(arrayBuffer);
                                for (let i = 0; i < decodedBytes.length; i++) {
                                    intArray[i] = decodedBytes.charCodeAt(i);
                                }

                                const blob = new Blob([intArray], {
                                    type: 'application/pdf'
                                });
                                const link = document.createElement('a');
                                link.href = URL.createObjectURL(blob);
                                link.download = resul.filename;
                                link.click();
                                URL.revokeObjectURL(link.href);
                            })
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

    $('#_kec').select2({
        dropdownParent: ".container-fluid",
    });

    function changeKec(event) {
        const selectedOption = event.value;

        if (selectedOption === "" || selectedOption === undefined) {
            $('.contentForm').html("");
        } else {
            $.ajax({
                url: "./changedKec",
                type: 'POST',
                data: {
                    id: selectedOption,
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
                        $('.contentForm').html(response.data);
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
        }
    }

    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    $(document).ready(function() {});
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<?= $this->endSection(); ?>