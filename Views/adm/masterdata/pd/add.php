<form id="formCekData" class="formCekData" action="./cekData" method="post">
    <div class="modal-body">
        <div class="row">
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">NISN</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_nisn" name="_nisn" value="" placeholder="NISN..." required />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">NPSN</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_npsn" name="_npsn" placeholder="NPSN..." required />
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">AMBIL DATA</button>
    </div>
</form>
<script>
    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    function validateForm(formElement) {
        const nisn = document.getElementsByName('_nisn')[0];
        const npsn = document.getElementsByName('_npsn')[0];

        if ((nisn.value === "" || nisn.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "NISN tidak boleh kosong.",
                'warning'
            ).then((valRes) => {
                nisn.focus();
            });
            return false;
        }
        if ((npsn.value === "" || npsn.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "NPSN tidak boleh kosong.",
                'warning'
            ).then((valRes) => {
                npsn.focus();
            });
            return false;
        }
        return true;
    }

    // Example usage: attach event listeners to form submission buttons
    const formCek = document.getElementById('formCekData');
    if (formCek) {
        formCek.addEventListener('submit', function(event) { // Prevent default form submission

            if (validateForm(this)) {
                event.preventDefault();
                const nisnData = document.getElementsByName('_nisn')[0].value;
                Swal.fire({
                    title: 'Apakah anda yakin ingin mengecek data ini?',
                    text: "CEK Data: " + nisnData,
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Cek Data!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "./cekData",
                            type: 'POST',
                            data: $(this).serialize(),
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
                            success: function(resul) {
                                if (response.status == 200) {
                                    Swal.close();
                                    $('#content-addModalLabel').html('SIMPAN DATA PD');
                                    $('.contentBodyaddModal').html(response.data);
                                    $('.content-addModal').modal({
                                        backdrop: 'static',
                                        keyboard: false,
                                    });
                                    $('.content-addModal').modal('show');
                                } else {
                                    Swal.fire(
                                        'Failed!',
                                        "gagal mengambil data",
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
            } else {
                event.preventDefault();
            }
        });
    }
</script>