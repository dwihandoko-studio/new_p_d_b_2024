<form id="formDonwloadData" class="formDonwloadData" action="./download" method="post">
    <div class="modal-body">
        <div class="row">
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Pilih Jalur :</label>
                <div class="col-sm-9">
                    <select class="default-select form-control wide mb-3" id="_jalur_download" name="_jalur_download" required>
                        <option value=""> -- Pilih -- </option>
                        <?php if (isset($sekNegeri)) { ?>
                            <?php if ($sekNegeri) { ?>
                                <option value="all"> SEMUA JALUR </option>
                                <option value="AFIRMASI">JALUR AFIRMASI</option>
                                <option value="ZONASI">JALUR ZONASI</option>
                                <option value="MUTASI">JALUR MUTASI</option>
                                <option value="PRESTASI">JALUR PRESTASI</option>
                            <?php } ?>
                        <?php } ?>
                        <?php if (isset($sekSwasta)) { ?>
                            <?php if ($sekSwasta) { ?>
                                <option value="SWASTA">SEKOLAH SWASTA</option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">DOWNLOAD DATA</button>
    </div>
</form>
<script>
    const formDownload = document.getElementById('formDonwloadData');
    if (formDownload) {
        formDownload.addEventListener('submit', function(event) { // Prevent default form submission

            event.preventDefault();
            const cJalur = document.getElementsByName('_jalur_download')[0].value;

            window.open('<?= base_url('sek/ppdb/pendaftar') ?>/download?j=' + cJalur, '_blank').focus();
            reloadPage();
            // $.ajax({
            //     url: "./download",
            //     type: 'POST',
            //     data: $(this).serialize(),
            //     dataType: 'JSON',
            //     beforeSend: function() {
            //         Swal.fire({
            //             title: 'Mengambil data...',
            //             text: 'Please wait while we process your action.',
            //             allowOutsideClick: false,
            //             allowEscapeKey: false,
            //             didOpen: () => {
            //                 Swal.showLoading();
            //             }
            //         });
            //     },
            //     complete: function() {},
            //     success: function(response) {

            //         if (response.status !== 200) {
            //             Swal.fire(
            //                 'Peringatan!',
            //                 resul.message,
            //                 'warning'
            //             ).then((valRes) => {
            //                 reloadPage();
            //             })
            //         } else {
            //             Swal.close();
            //             $('.content-lacak-pengaduan').html(response.data);
            //             $('.content-lacakModal').modal('hide');
            //         }
            //     },
            //     error: function() {
            //         Swal.fire(
            //             'PERINGATAN!',
            //             "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
            //             'warning'
            //         );
            //     }
            // });

        });
    }

    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }
</script>