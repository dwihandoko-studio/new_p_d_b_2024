<form id="formCekPengumumanData" class="formCekPengumumanData" action="./submitCekPengumuman" method="post">
    <div class="modal-body">
        <div class="row">
            <div class="mb-3 row">
                <div class="input-group   input-primary">
                    <span class="input-group-text">NOMOR PESERTA</span>
                    <input type="text" class="form-control" id="_no_pendaftaran_peng" name="_no_pendaftaran_peng" minlength="6" value="" placeholder="No peserta..." />
                </div>
            </div>
        </div>
        <div class="row">
            <div id="content_hasil_pengumuman" class="content_hasil_pengumuman"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">TUTUP</button>
        <button type="button" onclick="prosesCekPengumuman(this)" class="btn btn-primary">CEK PENGUMUMAN</button>
    </div>
</form>
<script>
    function prosesCekPengumuman(event) {
        const noPesertaPeng = document.getElementsByName('_no_pendaftaran_peng')[0];
        if (noPesertaPeng.value === "" || noPesertaPeng.value === undefined) {
            Swal.fire(
                'Peringatan!',
                "Masukkan no pendaftaran dengan benar",
                'warning'
            );
        }
        $.ajax({
            url: "./submitCekPengumuman",
            type: 'POST',
            data: {
                nopes: noPesertaPeng.value
            },
            dataType: 'JSON',
            beforeSend: function() {
                Swal.fire({
                    title: 'Mengecek data...',
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

                if (response.status !== 200) {
                    Swal.fire(
                        'Peringatan!',
                        resul.message,
                        'warning'
                    ).then((valRes) => {
                        reloadPage();
                    })
                } else {
                    Swal.close();
                    $('.content_hasil_pengumumann').html(response.data);
                    event.style.display = 'none';
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