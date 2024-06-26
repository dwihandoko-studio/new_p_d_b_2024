<form id="formEditPassData" class="formEditPassData" action="./passSave" method="post">
    <input type="hidden" id="_id" name="_id" value="<?= $sekolah_id ?>" />
    <div class="modal-body">
        <p><i>Validasi Dokumen Syarat Pendaftaran PPDB Jalur Prestasi Ke <b><?= $nama_sekolah ?></b></i></p>
        <div class="row">
            <div class="col-9 col-12 mt-4">
                <h4>Jenis Prestasi yang Dimiliki :</h4>
                <div class="input-group mb-3">
                    <select class="default-select form-control wide" style="width: 100%;" id="_prestasi_dimiliki" name="_prestasi_dimiliki" onchange="changeJenisPrestasi(this)" required>
                        <option value="">-- Pilih --</option>
                        <option value="akademik">Prestasi Akademik</option>
                        <option value="nonakademik">Prestasi Non Akademik</option>
                        <option value="tidakada">Prestasi Sekolah</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-12 prestasi-akademik-content" id="prestasi-akademik-content" style="display: none;">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <label for="_kec" class="col-form-label">Kategori:</label>
                                    <select onchange="kategoriAkademik(this)" class="default-select form-control wide" style="width: 100%;" id="_kategori_akademik" name="_kategori_akademik">
                                        <option value="">-- Pilih --</option>
                                        <option value="sains">Sains</option>
                                        <option value="teknologi">Teknologi</option>
                                        <option value="riset">Riset</option>
                                        <option value="inovasi">Inovasi</option>
                                    </select>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="_kec" class="col-form-label">Tingkat:</label>
                                    <select onchange="tingkatAkademik(this)" class="default-select form-control wide" style="width: 100%;" id="_tingkat_akademik" name="_tingkat_akademik">

                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <label for="_kec" class="col-form-label">Penyelenggara:</label>
                                    <select onchange="penyelenggaraAkademik(this)" class="default-select form-control wide" style="width: 100%;" id="_penyelenggara_akademik" name="_penyelenggara_akademik">

                                    </select>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="_kec" class="col-form-label">Juara:</label>
                                    <select onchange="juaraAkademik(this)" class="default-select form-control wide" style="width: 100%;" id="_juara_akademik" name="_juara_akademik">

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 prestasi-nonakademik-content" id="prestasi-nonakademik-content" style="display: none;">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <label for="_kec" class="col-form-label">Kategori:</label>
                                    <select onchange="kategoriNonakademik(this)" class="default-select form-control wide" style="width: 100%;" id="_kategori_nonakademik" name="_kategori_nonakademik">
                                        <option value="">-- Pilih --</option>
                                        <option value="senibudaya">Seni Budaya</option>
                                        <option value="olahraga">Olah Raga</option>
                                        <option value="pramuka">Pramuka</option>
                                        <option value="tahfidz">Tahfidz</option>
                                    </select>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="_kec" class="col-form-label">Tingkat:</label>
                                    <select onchange="tingkatNonakademik(this)" class="default-select form-control wide" style="width: 100%;" id="_tingkat_nonakademik" name="_tingkat_nonakademik">

                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <label for="_kec" class="col-form-label">Penyelenggara:</label>
                                    <select onchange="penyelenggaraNonakademik(this)" class="default-select form-control wide" style="width: 100%;" id="_penyelenggara_nonakademik" name="_penyelenggara_nonakademik">

                                    </select>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="_kec" class="col-form-label">Juara:</label>
                                    <select onchange="juaraNonakademik(this)" class="default-select form-control wide" style="width: 100%;" id="_juara_nonakademik" name="_juara_nonakademik">

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="col-9 col-12 mt-3">
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
                            <td>Dokumen Prestasi / Juara / <br />Surat Keterangan Prestasi Sekolah</td>
                            <td>
                                <div class="radio">
                                    <label for="_prestasi"><input type="radio" id="_prestasi" name="_prestasi" value="1"> Ada</label>
                                </div>
                            </td>
                            <td>
                                <div class="radio">
                                    <label for="_prestasi_no"><input type="radio" id="_prestasi_no" name="_prestasi" value="0"> Tidak</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>6.</td>
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
                        <?php if (isset($pengecualian_umur)) { ?>
                            <?php if ($pengecualian_umur !== "") { ?>
                                <tr>
                                    <td>7.</td>
                                    <td>Rekomendasi tertulis dari psikolog<br>profesional/dewan guru Sekolah</td>
                                    <td>
                                        <div class="radio">
                                            <label for="_kecumur"><input type="radio" id="_kecumur" name="_kecumur" value="1"> Ada</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="radio">
                                            <label for="_kecumur_no"><input type="radio" id="_kecumur_no" name="_kecumur" value="0"> Tidak</label>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
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
                    dokumen syarat PPDB Jalur Prestasi yang saya pilih. Dan
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
    function changeJenisPrestasi(event) {
        const selectedOption = event.value;
        if (selectedOption === "" || selectedOption === undefined) {
            $('.prestasi-akademik-content').css('display', 'none');
            $('.prestasi-nonakademik-content').css('display', 'none');
        } else {
            if (selectedOption === "akademik") {
                $('.prestasi-akademik-content').css('display', 'block');
                $('.prestasi-nonakademik-content').css('display', 'none');
            } else if (selectedOption === "nonakademik") {
                $('.prestasi-akademik-content').css('display', 'none');
                $('.prestasi-nonakademik-content').css('display', 'block');
            } else {
                $('.prestasi-akademik-content').css('display', 'none');
                $('.prestasi-nonakademik-content').css('display', 'none');
            }
        }
    }

    function kategoriAkademik(event) {
        const tingkatAkademikSelects = $('#_tingkat_akademik');
        tingkatAkademikSelects.empty();
        const penyelenggaraAkademikSelects = $('#_penyelenggara_akademik');
        penyelenggaraAkademikSelects.empty();
        const juaraAkademikSelects = $('#_juara_akademik');
        juaraAkademikSelects.empty();
        if (event.value === "" || event.value === undefined) {} else {
            tingkatAkademikSelects.append('<option value="">-- Pilih --</option>');
            tingkatAkademikSelects.append('<option value="kecamatan">Tingkat Kecamatan</option>');
            tingkatAkademikSelects.append('<option value="kabupaten">Tingkat Kabupaten / Kota</option>');
            tingkatAkademikSelects.append('<option value="provinsi">Tingkat Provinsi</option>');
            tingkatAkademikSelects.append('<option value="nasional">Tingkat Nasional</option>');
            tingkatAkademikSelects.append('<option value="internasional">Tingkat Internasional</option>');
        }
    }

    function tingkatAkademik(event) {
        const penyelenggaraAkademikSelects = $('#_penyelenggara_akademik');
        penyelenggaraAkademikSelects.empty();
        const juaraAkademikSelects = $('#_juara_akademik');
        juaraAkademikSelects.empty();
        if (event.value === "" || event.value === undefined) {} else {
            penyelenggaraAkademikSelects.append('<option value="">-- Pilih --</option>');
            penyelenggaraAkademikSelects.append('<option value="pusat">Pemerintah Pusat</option>');
            penyelenggaraAkademikSelects.append('<option value="daerah">Pemerintah Daerah</option>');
            penyelenggaraAkademikSelects.append('<option value="bumn">Badan Usaha Milik Negara (BUMN)</option>');
            penyelenggaraAkademikSelects.append('<option value="bumd">Badan Usaha Milik Daerah (BUMD)</option>');
            penyelenggaraAkademikSelects.append('<option value="lainnya">Lembaga Lainnya</option>');
        }
    }

    function penyelenggaraAkademik(event) {
        const juaraAkademikSelects = $('#_juara_akademik');
        juaraAkademikSelects.empty();
        if (event.value === "" || event.value === undefined) {} else {

            juaraAkademikSelects.append('<option value="">-- Pilih --</option>');
            juaraAkademikSelects.append('<option value="1">Juara 1</option>');
            juaraAkademikSelects.append('<option value="2">Juara 2</option>');
            juaraAkademikSelects.append('<option value="3">Juara 3</option>');
        }
    }

    function juaraAkademik(event) {}

    function kategoriNonakademik(event) {
        const tingkatNonAkademikSelects = $('#_tingkat_nonakademik');
        tingkatNonAkademikSelects.empty();
        const penyelenggaraNonakademikSelects = $('#_penyelenggara_nonakademik');
        penyelenggaraNonakademikSelects.empty();
        const juaraNonakademikSelects = $('#_juara_nonakademik');
        juaraNonakademikSelects.empty();
        if (event.value === "" || event.value === undefined) {} else {
            tingkatNonAkademikSelects.append('<option value="">-- Pilih --</option>');
            tingkatNonAkademikSelects.append('<option value="kecamatan">Tingkat Kecamatan</option>');
            tingkatNonAkademikSelects.append('<option value="kabupaten">Tingkat Kabupaten / Kota</option>');
            tingkatNonAkademikSelects.append('<option value="provinsi">Tingkat Provinsi</option>');
            tingkatNonAkademikSelects.append('<option value="nasional">Tingkat Nasional</option>');
            tingkatNonAkademikSelects.append('<option value="internasional">Tingkat Internasional</option>');
        }
    }

    function tingkatNonakademik(event) {
        const penyelenggaraNonakademikSelects = $('#_penyelenggara_nonakademik');
        penyelenggaraNonakademikSelects.empty();
        const juaraNonakademikSelects = $('#_juara_nonakademik');
        juaraNonakademikSelects.empty();
        if (event.value === "" || event.value === undefined) {} else {
            penyelenggaraNonakademikSelects.append('<option value="">-- Pilih --</option>');
            penyelenggaraNonakademikSelects.append('<option value="pusat">Pemerintah Pusat</option>');
            penyelenggaraNonakademikSelects.append('<option value="daerah">Pemerintah Daerah</option>');
            penyelenggaraNonakademikSelects.append('<option value="bumn">Badan Usaha Milik Negara (BUMN)</option>');
            penyelenggaraNonakademikSelects.append('<option value="bumd">Badan Usaha Milik Daerah (BUMD)</option>');
            penyelenggaraNonakademikSelects.append('<option value="lainnya">Lembaga Lainnya</option>');
        }
    }

    function penyelenggaraNonakademik(event) {
        const juaraNonakademikSelects = $('#_juara_nonakademik');
        juaraNonakademikSelects.empty();
        if (event.value === "" || event.value === undefined) {} else {

            juaraNonakademikSelects.append('<option value="">-- Pilih --</option>');
            juaraNonakademikSelects.append('<option value="1">Juara 1</option>');
            juaraNonakademikSelects.append('<option value="2">Juara 2</option>');
            juaraNonakademikSelects.append('<option value="3">Juara 3</option>');
        }
    }

    function juaraNonakademik(event) {}

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
        const selectedPrestasi = document.querySelector('input[type="radio"][name^="_prestasi"]:checked');
        const selectedKeaslian = document.querySelector('input[type="radio"][name^="_keaslian"]:checked');
        const prestasiDimiliki = formElement.querySelector('#_prestasi_dimiliki');

        if ((prestasiDimiliki.value === "" || prestasiDimiliki === undefined)) {
            Swal.fire(
                'Failed!',
                "Silahkan pilih prestasi yang dimiliki terlebih dahulu.",
                'warning'
            ).then((valR) => {
                // latitudeInput.focus();
            });

            return false; // Prevent form submission if validation fails
        }

        if ((prestasiDimiliki.value === "akademik")) {
            const kategoriDimiliki = formElement.querySelector('#_kategori_akademik');
            if ((kategoriDimiliki.value === "" || kategoriDimiliki === undefined)) {
                Swal.fire(
                    'Failed!',
                    "Silahkan pilih kategori akademik terlebih dahulu.",
                    'warning'
                ).then((valR) => {
                    // latitudeInput.focus();
                });

                return false; // Prevent form submission if validation fails
            }
            const tingkatDimiliki = formElement.querySelector('#_tingkat_akademik');
            if ((tingkatDimiliki.value === "" || tingkatDimiliki === undefined)) {
                Swal.fire(
                    'Failed!',
                    "Silahkan pilih tingkat akademik terlebih dahulu.",
                    'warning'
                ).then((valR) => {
                    // latitudeInput.focus();
                });

                return false; // Prevent form submission if validation fails
            }
            const penyelenggaraDimiliki = formElement.querySelector('#_penyelenggara_akademik');
            if ((penyelenggaraDimiliki.value === "" || penyelenggaraDimiliki === undefined)) {
                Swal.fire(
                    'Failed!',
                    "Silahkan pilih penyelenggara akademik terlebih dahulu.",
                    'warning'
                ).then((valR) => {
                    // latitudeInput.focus();
                });

                return false; // Prevent form submission if validation fails
            }
            const juaraDimiliki = formElement.querySelector('#_juara_akademik');
            if ((juaraDimiliki.value === "" || juaraDimiliki === undefined)) {
                Swal.fire(
                    'Failed!',
                    "Silahkan pilih juara akademik terlebih dahulu.",
                    'warning'
                ).then((valR) => {
                    // latitudeInput.focus();
                });

                return false; // Prevent form submission if validation fails
            }
        }

        if ((prestasiDimiliki.value === "nonakademik")) {
            const kategoriDimiliki = formElement.querySelector('#_kategori_nonakademik');
            if ((kategoriDimiliki.value === "" || kategoriDimiliki === undefined)) {
                Swal.fire(
                    'Failed!',
                    "Silahkan pilih kategori non akademik terlebih dahulu.",
                    'warning'
                ).then((valR) => {
                    // latitudeInput.focus();
                });

                return false; // Prevent form submission if validation fails
            }
            const tingkatDimiliki = formElement.querySelector('#_tingkat_nonakademik');
            if ((tingkatDimiliki.value === "" || tingkatDimiliki === undefined)) {
                Swal.fire(
                    'Failed!',
                    "Silahkan pilih tingkat non akademik terlebih dahulu.",
                    'warning'
                ).then((valR) => {
                    // latitudeInput.focus();
                });

                return false; // Prevent form submission if validation fails
            }
            const penyelenggaraDimiliki = formElement.querySelector('#_penyelenggara_nonakademik');
            if ((penyelenggaraDimiliki.value === "" || penyelenggaraDimiliki === undefined)) {
                Swal.fire(
                    'Failed!',
                    "Silahkan pilih penyelenggara non akademik terlebih dahulu.",
                    'warning'
                ).then((valR) => {
                    // latitudeInput.focus();
                });

                return false; // Prevent form submission if validation fails
            }
            const juaraDimiliki = formElement.querySelector('#_juara_nonakademik');
            if ((juaraDimiliki.value === "" || juaraDimiliki === undefined)) {
                Swal.fire(
                    'Failed!',
                    "Silahkan pilih juara non akademik terlebih dahulu.",
                    'warning'
                ).then((valR) => {
                    // latitudeInput.focus();
                });

                return false; // Prevent form submission if validation fails
            }
        }

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
        if (!(selectedPrestasi)) {
            Swal.fire(
                'Peringatan!',
                "Silahkan pilih validasi kepemilikan dokumen prestasi.",
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
                    url: "./exeDaftarS",
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
                                reloadPage(resul.url);
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