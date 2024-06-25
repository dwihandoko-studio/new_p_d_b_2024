<h3>Hasil Lacak Tiket Dengan Nomor: <strong class="text-secondary"><u><?= $data->no_tiket ?></u></strong></h3>
<h5>Berikut, informasi detail status tiket anda.</h5>
<div id="DZ_W_TimeLine" class="widget-timeline dlab-scroll height370" style="margin-top: 20px;">
    <ul class="timeline">
        <li>
            <div class="timeline-badge primary"></div>
            <a class="timeline-panel text-muted" href="#">
                <span><?= make_time_long_ago_new($data->created_at) ?></span>
                <h6 class="mb-0"><?= strtoupper($data->jenis_pengaduan) ?> - Status <strong class="text-primary"><?= getStatusTicketPengaduan($data->status) ?></strong>.</h6>
                <span><?= $data->nama_pengadu ?></span>
                <span><?= $data->email_pengadu ?></span>
                <span><?= $data->nohp_pengadu ?>
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<button class="btn btn-xxs btn-light" onclick="changeKontak('<?= $data->no_tiket ?>')">Edit Kontak</button></span>
                <?php if ((int)$data->status == 3) { ?>
                    <span>Keterangan Penolakan:</span>
                    <span><?= $data->keterangan ?></span>
                <?php } ?>
                <?php if ((int)$data->status == 2) { ?>
                    <span><button class="btn btn-xxs btn-primary" onclick="downloadHasilPengaduan('<?= $data->no_tiket ?>')">Download Hasil Pengaduan</button></span>
                <?php } ?>
            </a>
        </li>
        <!-- <li>
            <div class="timeline-badge info">
            </div>
            <a class="timeline-panel text-muted" href="#">
                <span>20 minutes ago</span>
                <h6 class="mb-0">New order placed <strong class="text-info">#XF-2356.</strong></h6>
                <p class="mb-0">Quisque a consequat ante Sit amet magna at volutapt...</p>
            </a>
        </li>
        <li>
            <div class="timeline-badge danger">
            </div>
            <a class="timeline-panel text-muted" href="#">
                <span>30 minutes ago</span>
                <h6 class="mb-0">john just buy your product <strong class="text-warning">Sell $250</strong></h6>
            </a>
        </li>
        <li>
            <div class="timeline-badge success">
            </div>
            <a class="timeline-panel text-muted" href="#">
                <span>15 minutes ago</span>
                <h6 class="mb-0">StumbleUpon is acquired by eBay. </h6>
            </a>
        </li>
        <li>
            <div class="timeline-badge warning">
            </div>
            <a class="timeline-panel text-muted" href="#">
                <span>20 minutes ago</span>
                <h6 class="mb-0">Mashable, a news website and blog, goes live.</h6>
            </a>
        </li>
        <li>
            <div class="timeline-badge dark">
            </div>
            <a class="timeline-panel text-muted" href="#">
                <span>20 minutes ago</span>
                <h6 class="mb-0">Mashable, a news website and blog, goes live.</h6>
            </a>
        </li> -->
    </ul>
</div>
<script>
    function changeKontak(id) {
        $.ajax({
            url: "./changeKontak",
            type: 'POST',
            data: {
                id: id,
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
                    $('#content-changeModalLabel').html('EDIT KONTAK TIKET');
                    $('.content-changeModalBody').html(response.data);
                    $('.content-changeModal').modal({
                        backdrop: 'static',
                        keyboard: false,
                    });
                    $('.content-changeModal').modal('show');
                } else {
                    Swal.fire(
                        'Failed!',
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

    function downloadHasilPengaduan(id) {
        $.ajax({
            url: "./downloadHasilPengaduan",
            type: 'POST',
            data: {
                id: id,
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
                    Swal.fire(
                        'BERHASIL!',
                        response.message,
                        'success'
                    ).then((valResT) => {

                        const decodedBytes = atob(response.data);
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
                        link.download = response.filename; // Set desired filename
                        link.click();
                        URL.revokeObjectURL(link.href);

                        reloadPage(resul.url);

                    })
                } else {
                    Swal.fire(
                        'Failed!',
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
</script>