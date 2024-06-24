<form id="formLacakData" class="formLacakData" action="./getLacakTiket" method="post">
    <div class="modal-body">
        <div class="row">
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">NO TIKET</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_no_tiket_pengaduan" name="_no_tiket_pengaduan" minlength="9" value="" placeholder="No tiket..." required />
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">CEK TIKET</button>
    </div>
</form>
<script>
    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }
    const formLacakTiket = document.getElementById('formLacakData');
    if (formLacakTiket) {
        formLacakTiket.addEventListener('submit', function(event) { // Prevent default form submission

            event.preventDefault();
            const noTiketPengaduan = document.getElementsByName('_no_tiket_pengaduan')[0].value;
            $.ajax({
                url: "./getLacakTiket",
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'JSON',
                beforeSend: function() {
                    Swal.fire({
                        title: 'Mengambil data...',
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
                        $('.content-lacak-pengaduan').html(response.data);
                        $('.content-lacakModal').modal('hide');
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

        });
    }
</script>