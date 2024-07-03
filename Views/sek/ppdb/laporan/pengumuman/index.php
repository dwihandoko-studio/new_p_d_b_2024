<?= $this->extend('t-ppdb/sek/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Laporan</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Pengumuman PPDB</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <?php if (isset($sekNegeri)) { ?>
                                        <?php if ($sekNegeri) { ?>
                                            <div class="col-lg-6 mb-3">
                                                <a href="javascript:downloadSptjmAfirmasi();" class="btn btn-block btn-primary">Download SPTJM AFIRMASI</a>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <a href="javascript:downloadLampiranAfirmasi();" class="btn btn-block btn-info">Download LAMPIRAN SPTJM AFIRMASI</a>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <a href="javascript:downloadSptjmZonmupres();" class="btn btn-block btn-warning">Download SPTJM Zonasi, Mutasi & Prestasi</a>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <a href="javascript:downloadLampiranZonmupres();" class="btn btn-block btn-secondary">Download LAMPIRAN SPTJM Zonasi, Mutasi & Prestasi</a>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (isset($sekSwasta)) { ?>
                                        <?php if ($sekSwasta) { ?>
                                            <div class="col-lg-6 mb-3">
                                                <a href="javascript:downloadSptjmSwasta();" class="btn btn-block btn-primary">Download SPTJM SWASTA</a>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <a href="javascript:downloadLampiranSwasta();" class="btn btn-block btn-info">Download LAMPIRAN SPTJM SWASTA</a>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <div id="content-lacak-pengaduan" class="content-lacak-pengaduan" style="margin-top: 30px;"></div>
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
    function downloadSptjm(id) {
        $.ajax({
            url: './download_sptjm',
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

    function downloadSptjmAfirmasi() {
        window.open('<?= base_url('sek/ppdb/laporan/pengumuman/downloadsptjmafirmasi') ?>', '_blank').focus();
    }

    function downloadLampiranAfirmasi() {
        window.open('<?= base_url('sek/ppdb/laporan/pengumuman/downloadlampiranafirmasi') ?>', '_blank').focus();
    }

    function downloadSptjmZonmupres() {
        window.open('<?= base_url('sek/ppdb/laporan/pengumuman/downloadsptjmzonmupres') ?>', '_blank').focus();
    }

    function downloadLampiranZonmupres() {
        window.open('<?= base_url('sek/ppdb/laporan/pengumuman/downloadlampiranzonmupres') ?>', '_blank').focus();
    }

    function downloadSptjmSwasta() {
        window.open('<?= base_url('sek/ppdb/laporan/pengumuman/downloadsptjmswasta') ?>', '_blank').focus();
    }

    function downloadLampiranSwasta() {
        window.open('<?= base_url('sek/ppdb/laporan/pengumuman/downloadlampiranswasta') ?>', '_blank').focus();
    }

    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    $(document).ready(function() {

    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<?= $this->endSection(); ?>