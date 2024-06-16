<form id="formEditPassData" class="formEditPassData" action="./passSave" method="post">
    <input type="hidden" id="_id" name="_id" value="<?= $sekolah_id ?>" />
    <div class="modal-body">
        <p><i>Validasi Dokumen Syarat Pendaftaran PPDB Jalur Afirmasi Ke <b><?= $nama_sekolah ?></b></i></p>
        <div class="row">
            <div class="col-9 col-12">
                <h4>Kepemilikan dokumen persyaratan sebagai berikut :</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-responsive-sm">
                        <tr>
                            <td>1.</td>
                            <td>Ijazah Sekolah Asal</td>
                            <td>
                                <div class="radio">
                                    <label for="_ijazah"><input type="radio" id="_ijazah" name="_ijazah" value="1"> Ada</label>
                                </div>
                            </td>
                            <td>
                                <div class="radio">
                                    <label for="_ijazah_no"><input type="radio" id="_ijazah_no" name="_ijazah" value="0"> Tidak</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>Surat Keterangan Lulus</td>
                            <td>
                                <div class="radio">
                                    <label for="_skl"><input type="radio" id="_skl" name="_skl" value="1"> Ada</label>
                                </div>
                            </td>
                            <td>
                                <div class="radio">
                                    <label for="_skl_no"><input type="radio" id="_skl_no" name="_skl" value="0"> Tidak</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td>Kartu Keluarga</td>
                            <td>
                                <div class="radio">
                                    <label for="_kk"><input type="radio" id="_kk" name="_kk" value="1"> Ada</label>
                                </div>
                            </td>
                            <td>
                                <div class="radio">
                                    <label for="_kk_no"><input type="radio" id="_kk_no" name="_kk" value="0"> Tidak</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>4.</td>
                            <td>Akta Kelahiran</td>
                            <td>
                                <div class="radio">
                                    <label for="_aktakel"><input type="radio" id="_aktakel" name="_aktakel" value="1"> Ada</label>
                                </div>
                            </td>
                            <td>
                                <div class="radio">
                                    <label for="_aktakel_no"><input type="radio" id="_aktakel_no" name="_aktakel" value="0"> Tidak</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>5.</td>
                            <td>Kartu Jaminan Sosial <br />(PIP/KIP/PKH/Surat Ket DTKS)</td>
                            <td>
                                <div class="radio">
                                    <label for="_jamsos"><input type="radio" id="_jamsos" name="_jamsos" value="1"> Ada</label>
                                </div>
                            </td>
                            <td>
                                <div class="radio">
                                    <label for="_jamsos_no"><input type="radio" id="_jamsos_no" name="_jamsos" value="0"> Tidak</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>6.</td>
                            <td>Surat Keterangan Penyandang<br />Disabilitas</td>
                            <td>
                                <div class="radio">
                                    <label for="_disabilitas"><input type="radio" id="_disabilitas" name="_disabilitas" value="1"> Ada</label>
                                </div>
                            </td>
                            <td>
                                <div class="radio">
                                    <label for="_disabilitas_no"><input type="radio" id="_disabilitas_no" name="_disabilitas" value="0"> Tidak</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>7.</td>
                            <td>Surat Pernyataan Keaslian Dokumen</td>
                            <td>
                                <div class="radio">
                                    <label for="_keaslian"><input type="radio" id="_keaslian" name="_keaslian" value="1"> Ada</label>
                                </div>
                            </td>
                            <td>
                                <div class="radio">
                                    <label for="_keaslian_no"><input type="radio" id="_keaslian_no" name="_keaslian" value="0"> Tidak</label>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-3 col-12 mt-5">
                <h4>Keterangan :</h4>
                <p>Peserta tidak berkenan untuk menceklis memiliki dokumen,
                    namun sesungguhnya dokumen tersebut tidak di miliki oleh
                    peserta tersebut. Karena akan mempengaruhi nilai validasi
                    pada saat verifikasi berkas di sekolah tujuan berlangsung.</p>
            </div>
        </div>
        <div class="col-12 mt-4">
            <div class="form-check custom-checkbox mb-3">
                <input type="checkbox" class="form-check-input" id="_has_confirmed" name="_has_confirmed" required>
                <label class="form-check-label" for="_has_confirmed">Saya menyatakan dengan sesungguhnya, bahwa saya memiliki
                    dokumen syarat PPDB Jalur Afirmasi yang saya pilih. Dan
                    selanjutnya akan saya buktikan pada saat verifikasi dokumen
                    pendaftaran.</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">DAFTAR</button>
    </div>
</form>
<script>
    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    function validateForm(formElement) {
        const selectedIjazah = document.querySelector('input[type="radio"][name^="_ijazah"]:checked');
        const selectedSkl = document.querySelector('input[type="radio"][name^="_skl"]:checked');
        const selectedKk = document.querySelector('input[type="radio"][name^="_kk"]:checked');
        const selectedAktakel = document.querySelector('input[type="radio"][name^="_aktakel"]:checked');
        const selectedJamsos = document.querySelector('input[type="radio"][name^="_jamsos"]:checked');
        const selectedDisabilitas = document.querySelector('input[type="radio"][name^="_disabilitas"]:checked');
        const selectedKeaslian = document.querySelector('input[type="radio"][name^="_keaslian"]:checked');

        if (!(selectedIjazah)) {

            Swal.fire(
                'Peringatan!',
                "Silahkan pilih validasi kepemilikan ijazah.",
                'warning'
            ).then((valRes) => {});
            return false;
        }
        if (!(selectedSkl)) {
            Swal.fire(
                'Peringatan!',
                "Silahkan pilih validasi kepemilikan surat keterangan lulus.",
                'warning'
            ).then((valRes) => {});
            return false;
        }
        if (!(selectedKk)) {
            Swal.fire(
                'Peringatan!',
                "Silahkan pilih validasi kepemilikan kartu keluarga.",
                'warning'
            ).then((valRes) => {});
            return false;
        }
        if (!(selectedAktakel)) {
            Swal.fire(
                'Peringatan!',
                "Silahkan pilih validasi kepemilikan akta kelahiran.",
                'warning'
            ).then((valRes) => {});
            return false;
        }
        if (!(selectedJamsos)) {
            Swal.fire(
                'Peringatan!',
                "Silahkan pilih validasi kepemilikan jaminan sosial.",
                'warning'
            ).then((valRes) => {});
            return false;
        }
        if (!(selectedDisabilitas)) {
            Swal.fire(
                'Peringatan!',
                "Silahkan pilih validasi surat penyandang disabilitas.",
                'warning'
            ).then((valRes) => {});
            return false;
        }
        if (!(selectedKeaslian)) {
            Swal.fire(
                'Peringatan!',
                "Silahkan pilih validasi kepemilikan surat pernyataan keaslian dokumen.",
                'warning'
            ).then((valRes) => {});
            return false;
        }

        return true;
    }

    // Example usage: attach event listeners to form submission buttons
    const form = document.getElementById('formEditPassData');
    if (form) {
        form.addEventListener('submit', function(event) { // Prevent default form submission

            event.preventDefault();
            if (validateForm(this)) {

                $.ajax({
                    url: "./exeDaftar",
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'JSON',
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Sedang loading ...',
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
</script>