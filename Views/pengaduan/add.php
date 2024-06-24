<form id="formAddData" class="formAddData" action="./addSave" method="post">
    <div class="modal-body">
        <div class="row">
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_nama" name="_nama" value="" placeholder="Nama Lengkap" required />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Pilih Klasifikasi :</label>
                <div class="col-sm-9">
                    <select class="default-select form-control wide mb-3" onchange="changedKlasifikasi(this)" id="_klasifikasi" name="_klasifikasi" required>
                        <option value=""> -- Pilih --</option>
                        <option value="belum punya akun">Belum Punya Akun</option>
                        <option value="tidak bisa melakukan pendaftaran ke sekolah">Tidak Bisa Melakukan Pendaftaran Ke Sekolah</option>
                        <option value="lupa password">Lupa Password</option>
                        <option value="tidak bisa melakukan pengkinian data">Tidak Bisa Melakukan Pengkinian Data</option>
                    </select>
                </div>
            </div>
            <div class="content_pengaduan_baru" id="content_pengaduan_baru">

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">SIMPAN</button>
    </div>
</form>
<script>
    function changedKlasifikasi(event) {
        if (event.value === "" || event.value === undefined) {} else {
            $.ajax({
                url: "./form_add",
                type: 'POST',
                data: {
                    id: event.value,
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
                complete: function() {

                },
                success: function(response) {
                    if (response.status == 200) {
                        Swal.close();
                        $('.content_pengaduan_baru').html(response.data);
                    } else {
                        Swal.fire(
                            'Failed!',
                            response.message,
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
</script>