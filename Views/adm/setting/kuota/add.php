<form id="formAddData" class="formAddData" action="./addSave" method="post">
    <div class="modal-body">
        <div class="row">
            <div class="mb-3 row">
                <label for="_jenjang" class="col-form-label">Jenjang:</label>
                <select class="form-control" id="_jenjang" name="_jenjang" onchange="changedJenjang(event)" width="100%" style="width: 100%;" required>
                    <option value="">--Pilih--</option>
                    <option value="5">SD</option>
                    <option value="6">SMP</option>
                </select>
            </div>
            <div class="mb-3 row">
                <label for="_kec" class="col-form-label">Kecamatan:</label>
                <select class="form-control" id="_kec" name="_kec" onchange="changedKecamatan(event)" width="100%" style="width: 100%;" required>
                    <option value="">--Pilih--</option>
                    <?php if (isset($kecamatans)) {
                        if (count($kecamatans) > 0) {
                            foreach ($kecamatans as $key => $value) { ?>
                                <option value="<?= $value->id ?>"><?= $value->nama ?></option>
                    <?php }
                        }
                    } ?>
                </select>
            </div>
            <div class="mb-3 row">
                <label for="_sekolah" class="col-form-label">Sekolah:</label>
                <select class="form-control" id="_sekolah" name="_sekolah" onchange="changedSekolah(event)" width="100%" style="width: 100%;" required>
                    <option value="">--Pilih--</option>
                </select>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Jumlah Kebutuhan Rombel</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" id="_kebutuhan" name="_kebutuhan" value="" required />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Radius Zonasi (Dalam Km)</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" id="_radius" name="_radius" value="" required />
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">SIMPAN</button>
    </div>
</form>
<script>
    $('#_kec').select2({
        dropdownParent: ".contentBodycontentModal",
    });
    $('#_jenjang').select2({
        dropdownParent: ".contentBodycontentModal",
    });
    $('#_sekolah').select2({
        dropdownParent: ".contentBodycontentModal",
    });

    function changedKecamatan(event) {
        console.log("Changed Kecamatan");
        const sekolahSelect = $('#_sekolah');
        sekolahSelect.empty(); // Clear existing options
        if (event.value === "" || event.value === undefined) {} else {
            $.ajax({
                url: "./refSekolah",
                type: 'POST',
                data: {
                    kec: event.value,
                    jenjang: document.getElementsByName('_jenjang')[0].value
                },
                dataType: "json",
                beforeSend: function() {
                    Swal.fire({
                        title: 'Sedang Loading . . .',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        onOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                complete: function() {},
                success: function(response) {
                    if (response.status == 200) {
                        Swal.close();
                        // Process and populate the kecamatan dropdown based on the response
                        const sekolahs = response.data; // Assuming response has 'data' key with kecamatans
                        sekolahSelect.append('<option value="">  -- Pilih -- </option>');
                        sekolahs.forEach(sekolah => {
                            const option = $('<option>').val(sekolah.sekolah_id).text(sekolah.nama + " (NPSN: " + sekolah.npsn + ")");
                            // if (kecamatan.id.startsWith(selectedKabId.substring(0, 6))) {
                            //     option.attr('selected', true);
                            // }
                            sekolahSelect.append(option);
                        });
                    } else {
                        Swal.fire(
                            'Failed!',
                            "gagal mengambil data",
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

    function changedJenjang(event) {
        console.log("Changed Jenjang");
        const sekolahSelect = $('#_sekolah');
        sekolahSelect.empty(); // Clear existing options
        if (event.value === "" || event.value === undefined) {} else {
            $.ajax({
                url: "./refSekolah",
                type: 'POST',
                data: {
                    jenjang: event.value,
                },
                dataType: "json",
                beforeSend: function() {
                    Swal.fire({
                        title: 'Sedang Loading . . .',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        onOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                complete: function() {},
                success: function(response) {
                    if (response.status == 200) {
                        Swal.close();
                        // Process and populate the kecamatan dropdown based on the response
                        const sekolahs = response.data; // Assuming response has 'data' key with kecamatans
                        sekolahSelect.append('<option value="">  -- Pilih -- </option>');
                        sekolahs.forEach(sekolah => {
                            const option = $('<option>').val(sekolah.sekolah_id).text(sekolah.nama + " (NPSN: " + sekolah.npsn + ")");
                            // if (kecamatan.id.startsWith(selectedKabId.substring(0, 6))) {
                            //     option.attr('selected', true);
                            // }
                            sekolahSelect.append(option);
                        });
                    } else {
                        Swal.fire(
                            'Failed!',
                            "gagal mengambil data",
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

    function validateForm(formElement) {
        const jenjang = document.getElementsByName('_jenjang')[0];
        const kec = document.getElementsByName('_kec')[0];
        const sekolah = document.getElementsByName('_sekolah')[0];
        const kebutuhan = document.getElementsByName('_kebutuhan')[0];
        const radius = document.getElementsByName('_radius')[0];

        if ((jenjang.value === "" || jenjang.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "jenjang tidak boleh kosong.",
                'warning'
            ).then((valRes) => {});
            return false;
        }

        if ((kec.value === "" || kec.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Kecamatan tidak boleh kosong.",
                'warning'
            ).then((valRes) => {});
            return false;
        }

        if ((sekolah.value === "" || sekolah.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Sekolah tidak boleh kosong.",
                'warning'
            ).then((valRes) => {});
            return false;
        }

        if ((kebutuhan.value === "" || kebutuhan.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Kebutuhan Rombel tidak boleh kosong.",
                'warning'
            ).then((valRes) => {
                kebutuhan.focus();
            });
            return false;
        }

        if ((radius.value === "" || radius.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Radius tidak boleh kosong.",
                'warning'
            ).then((valRes) => {
                radius.focus();
            });
            return false;
        }

        return true;
    }

    // Example usage: attach event listeners to form submission buttons
    const form = document.getElementById('formAddData');
    if (form) {
        form.addEventListener('submit', function(event) { // Prevent default form submission

            if (validateForm(this)) {
                event.preventDefault();
                Swal.fire({
                    title: 'Apakah anda yakin ingin menyimpan data ini?',
                    text: "Tambah Data Kuota Sekolah",
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, SIMPAN!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "./addSave",
                            type: 'POST',
                            data: $(this).serialize(),
                            dataType: 'JSON',
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Menyimpan data ...',
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
            } else {
                event.preventDefault();
            }
        });
    }
</script>