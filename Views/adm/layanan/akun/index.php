<?= $this->extend('t-verval/adm/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Layanan</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Akun PPDB</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Peserta Dididk</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title">Data Akun PPDB Peserta Didik <?= $nama_sekolah ?></h4>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-datatables" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ACTION</th>
                                        <th>NISN</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tempat Lahir</th>
                                        <th>Tanggal Lahir</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
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
            title: 'Apakah anda yakin ingin mendownload Akun PD ini?',
            text: "Download Akun PD: " + nama,
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
                            title: 'Mendownload Akun PD...',
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
                                link.download = resul.filename; // Set desired filename
                                link.click();

                                // Revoke the object URL after download (optional)
                                URL.revokeObjectURL(link.href);
                                // const decodedBytes = atob(resul.data);

                                // const arrayBuffer = new ArrayBuffer(decodedBytes.length);
                                // const intArray = new Uint8Array(arrayBuffer);
                                // for (let i = 0; i < decodedBytes.length; i++) {
                                //     intArray[i] = decodedBytes.charCodeAt(i);
                                // }

                                // const blob = new Blob([intArray], {
                                //     type: 'application/pdf'
                                // });

                                // const url = URL.createObjectURL(blob);
                                // window.open(url, '_blank');
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

    function actionGenerate(id, nama) {
        Swal.fire({
            title: 'Apakah anda yakin ingin mengenerate Akun PD ini?',
            text: "Generate Akun PD: " + nama,
            showCancelButton: true,
            icon: 'question',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Generate!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "./generate",
                    type: 'POST',
                    data: {
                        id: id,
                        nama: nama,
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Mengenerate Akun PD...',
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
                                    reloadPage();
                                })
                            }
                        } else {
                            Swal.fire(
                                'BERHASIL!',
                                resul.message,
                                'success'
                            ).then((valRes) => {
                                reloadPage();
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

    $(document).ready(function() {
        // initSelect2('_filter_kec', $('.content-body'));
        // initSelect2('_filter_jenjang', $('.content-body'));
        let tableDatatables = $('#data-datatables').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "./getAllDetail",
                "type": "POST",
                "data": function(data) {
                    data.id = '<?= $id ?>';
                }
            },
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            },
            lengthMenu: [
                [10, 25, 50, 100, 200, -1],
                [10, 25, 50, 100, 200, "All"]
            ],
            buttons: ["copy", "excel", "pdf"],
            "columnDefs": [{
                "targets": 0,
                "orderable": false,
            }],
        });
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<?= $this->endSection(); ?>