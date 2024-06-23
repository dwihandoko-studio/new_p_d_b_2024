<?= $this->extend('t-ppdb/pan/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Laporan</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Berita Acara</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title">Data Berita Acara Perubahan Data</h4>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="_filter_jenis" class="col-form-label">Filter Jenis:</label>
                                    <select class="form-control filter-kec" id="_filter_jenis" name="_filter_jenis" width="100%" style="width: 100%;">
                                        <option value="">--Pilih--</option>
                                        <option value="domisili">Domisili Peserta</option>
                                        <option value="domisili">Domisili Peserta</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-datatables" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Nama Pengaju</th>
                                        <th>Status Pengaju</th>
                                        <th>Perubahan Pengaju</th>
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
    function actionDownload(id) {
        $.ajax({
            url: './download_berita_acara',
            type: 'POST',
            data: {
                id: id,
            },
            dataType: 'JSON',
            beforeSend: function() {
                Swal.fire({
                    title: 'Sedang loading...',
                    text: 'Please wait while we process your action.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            complete: function() {},
            success: function(resulsuc) {
                if (resulsuc.status !== 200) {
                    if (resulsuc.status !== 201) {
                        if (resulsuc.status === 401) {
                            Swal.fire(
                                'Failed!',
                                resulsuc.message,
                                'warning'
                            ).then((valRes) => {
                                reloadPage();
                            });
                        } else {
                            Swal.fire(
                                'GAGAL!',
                                resulsuc.message,
                                'warning'
                            );
                        }
                    } else {
                        Swal.fire(
                            'Peringatan!',
                            resulsuc.message,
                            'success'
                        ).then((valRes) => {
                            // reloadPage();
                            const decodedBytes = atob(resulsuc.data);
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
                            link.download = resulsuc.filename; // Set desired filename
                            link.click();

                            // Revoke the object URL after download (optional)
                            URL.revokeObjectURL(link.href);

                            reloadPage();

                        })
                    }
                } else {
                    Swal.fire(
                        'BERHASIL!',
                        resulsuc.message,
                        'success'
                    ).then((valRes) => {
                        // reloadPage();
                        const decodedBytes = atob(resulsuc.data);
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
                        link.download = resulsuc.filename;
                        link.click();
                        URL.revokeObjectURL(resulsuc.href);

                        reloadPage();
                    })
                }
            }
        });
    }

    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    $(document).ready(function() {
        // initSelect2('_filter_jalur', $('.content-body'));
        let tableDatatables = $('#data-datatables').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "./getAll",
                "type": "POST",
                // "data": function(data) {
                //     data.jalur = $('#_filter_jalur').val();
                // }
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
            }, {
                "targets": 1,
                "orderable": false,
            }, {
                "targets": 2,
                "orderable": false,
            }, {
                "targets": 3,
                "orderable": false,
            }],
        });
        // $('#_filter_jalur').change(function() {
        //     tableDatatables.draw();
        // });
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<?= $this->endSection(); ?>