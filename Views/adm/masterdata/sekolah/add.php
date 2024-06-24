<form id="formCekData" class="formCekData" action="./cekData" method="post">
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label for="_status_sekolah" class="col-form-label">Pilih Status Sekolah:</label>
                    <select class="form-control" id="_status_sekolah" name="_status_sekolah" width="100%" style="width: 100%;" required>
                        <option value="">--Pilih--</option>
                        <option value="1">NEGERI</option>
                        <option value="2">SWASTA</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label for="_bentuk_pendidikan" class="col-form-label">Pilih Bentuk Pendidikan:</label>
                    <select class="form-control" id="_bentuk_pendidikan" name="_bentuk_pendidikan" width="100%" style="width: 100%;" required>
                        <option value="">--Pilih--</option>
                        <?php if (isset($jenjangs)) {
                            if (count($jenjangs) > 0) {
                                foreach ($jenjangs as $key => $value) { ?>
                                    <option value="<?= $value->bentuk_pendidikan_id ?>"><?= $value->bentuk_pendidikan ?></option>
                        <?php }
                            }
                        } ?>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-12">
                    <div class="input-group   input-primary">
                        <span class="input-group-text" style="width: 150px; min-width: 150px;min-width: 150px;">Sekolah Id</span>
                        <input type="text" class="form-control" id="_id_sekolah" name="_id_sekolah" value="" required />
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-12">
                    <div class="input-group   input-primary">
                        <span class="input-group-text" style="width: 150px; min-width: 150px;min-width: 150px;">Nama Sekolah</span>
                        <input type="text" class="form-control" id="_nama_sekolah" name="_nama_sekolah" value="" required />
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-12">
                    <div class="input-group   input-primary">
                        <span class="input-group-text" style="width: 150px; min-width: 150px;min-width: 150px;">NPSN Sekolah</span>
                        <input type="text" class="form-control" id="_npsn_sekolah" name="_npsn_sekolah" value="" required />
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-12">
                    <div class="input-group   input-primary">
                        <span class="input-group-text" style="width: 150px; min-width: 150px;min-width: 150px;">Kode Pos</span>
                        <input type="text" class="form-control" id="_kode_pos" name="_kode_pos" value="" required />
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Provinsi</label>
                <div class="col-sm-9">
                    <select class="w-100" style="width: 100%;" id="_prov" name="_prov" onchange="changeProv(this)" required>
                        <option value="">-- Pilih --</option>
                        <?php if (isset($props)) { ?>
                            <?php if (count($props) > 0) { ?>
                                <?php foreach ($props as $key => $value) { ?>
                                    <option value="<?= $value->id ?>" <?= (substr($value->id, 0, 2) === substr($data->kode_wilayah, 0, 2)) ? ' selected' : "" ?>><?= $value->nama ?></option>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Kabupaten</label>
                <div class="col-sm-9">
                    <select class="w-100" style="width: 100%;" id="_kab" name="_kab" onchange="changeKab(this)" required>
                        <option value="">-- Pilih --</option>
                        <?php if (isset($kabs)) { ?>
                            <?php if (count($kabs) > 0) { ?>
                                <?php foreach ($kabs as $key => $value) { ?>
                                    <option value="<?= $value->id ?>"><?= $value->nama ?></option>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Kecamatan</label>
                <div class="col-sm-9">
                    <select class="w-100" style="width: 100%;" id="_kec" name="_kec" onchange="changeKec(this)" required>
                        <option value="">-- Pilih --</option>
                        <?php if (isset($kecs)) { ?>
                            <?php if (count($kecs) > 0) { ?>
                                <?php foreach ($kecs as $key => $value) { ?>
                                    <option value="<?= $value->id ?>"><?= $value->nama ?></option>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Desa/Kelurahan</label>
                <div class="col-sm-9">
                    <select class="w-100" style="width: 100%;" id="_kel" name="_kel" onchange="changeKel(this)" required>
                        <option value="">-- Pilih --</option>
                        <?php if (isset($kels)) { ?>
                            <?php if (count($kels) > 0) { ?>
                                <?php foreach ($kels as $key => $value) { ?>
                                    <option value="<?= $value->id ?>"><?= $value->nama ?></option>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-9">
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Lintang</label>
                                <div class="col-sm-9">
                                    <div class="input-group   input-primary">
                                        <span class="input-group-text">Lat</span>
                                        <input type="text" class="form-control" id="_lintang" name="_lintang" value="" required />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Bujur</label>
                                <div class="col-sm-9">
                                    <div class="input-group   input-primary">
                                        <span class="input-group-text">Long</span>
                                        <input type="text" class="form-control" id="_bujur" name="_bujur" value="" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">CEK DATA</button>
    </div>
</form>
<script>
    function changeProv(event) {
        const kabupatenSelect = $('#_kab');
        kabupatenSelect.empty(); // Clear existing options
        if (event.value === "" || event.value === undefined) {} else {
            $.ajax({
                url: "./refkab",
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
                complete: function() {},
                success: function(response) {
                    if (response.status == 200) {
                        Swal.close();
                        // Process and populate the kecamatan dropdown based on the response
                        const kabupatens = response.data; // Assuming response has 'data' key with kabupatens
                        kabupatenSelect.append('<option value="">  -- Pilih -- </option>');
                        kabupatens.forEach(kabupaten => {
                            const option = $('<option>').val(kabupaten.id).text(kabupaten.nama);
                            // if (kecamatan.id.startsWith(selectedKabId.substring(0, 6))) {
                            //     option.attr('selected', true);
                            // }
                            kabupatenSelect.append(option);
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

    function changeKab(event) {
        const kecamatanSelect = $('#_kec');
        kecamatanSelect.empty(); // Clear existing options
        if (event.value === "" || event.value === undefined) {} else {
            $.ajax({
                url: "./refkec",
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
                complete: function() {},
                success: function(response) {
                    if (response.status == 200) {
                        Swal.close();
                        // Process and populate the kecamatan dropdown based on the response
                        const kecamatans = response.data; // Assuming response has 'data' key with kecamatans
                        kecamatanSelect.append('<option value="">  -- Pilih -- </option>');
                        kecamatans.forEach(kecamatan => {
                            const option = $('<option>').val(kecamatan.id).text(kecamatan.nama);
                            // if (kecamatan.id.startsWith(selectedKabId.substring(0, 6))) {
                            //     option.attr('selected', true);
                            // }
                            kecamatanSelect.append(option);
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

    function changeKec(event) {
        const kelurahanSelect = $('#_kel');
        kelurahanSelect.empty();
        if (event.value === "" || event.value === undefined) {} else {
            $.ajax({
                url: "./refkel",
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

                        // Process and populate the kecamatan dropdown based on the response
                        const kelurahans = response.data; // Assuming response has 'data' key with kelurahans
                        kelurahanSelect.append('<option value="">  -- Pilih -- </option>');
                        kelurahans.forEach(kelurahan => {
                            const option = $('<option>').val(kelurahan.id).text(kelurahan.nama);
                            // if (kecamatan.id.startsWith(selectedKabId.substring(0, 6))) {
                            //     option.attr('selected', true);
                            // }
                            kelurahanSelect.append(option);
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

    function changeKel(event) {}


    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    function validateLat(lat) {
        // Define the valid range for latitude and longitude in Indonesia
        const minLat = -11.0; // Southernmost point in Indonesia
        const maxLat = 6.0; // Northernmost point in Indonesia

        // Check if the latitude and longitude are within the valid range
        if (lat >= minLat && lat <= maxLat) {
            return true;
        } else {
            return false;
        }
    }

    function validateLong(lon) {
        const minLon = 95.0; // Westernmost point in Indonesia
        const maxLon = 141.0; // Easternmost point in Indonesia

        // Check if the latitude and longitude are within the valid range
        if (lon >= minLon && lon <= maxLon) {
            return true;
        } else {
            return false;
        }
    }


    function validateForm(formElement) {
        const latitudeInput = formElement.querySelector('#_lintang');
        const longitudeInput = formElement.querySelector('#_bujur');

        if (!validateLat(latitudeInput.value)) {
            Swal.fire(
                'Failed!',
                "Inputan Lintang tidak valid.",
                'warning'
            ).then((valR) => {
                latitudeInput.focus();
            });

            return false; // Prevent form submission if validation fails
        }

        if (!validateLong(longitudeInput.value)) {
            Swal.fire(
                'Failed!',
                "Inputan Bujur tidak valid.",
                'warning'
            ).then((valR) => {
                longitudeInput.focus();
            });

            return false; // Prevent form submission if validation fails
        }

        return true;
    }

    // Example usage: attach event listeners to form submission buttons
    const formCek = document.getElementById('formCekData');
    if (formCek) {
        formCek.addEventListener('submit', function(event) { // Prevent default form submission

            event.preventDefault();
            if (validateForm(this)) {
                const namaSekolah = document.getElementsByName('_nama_sekolah')[0].value;
                Swal.fire({
                    title: 'Apakah anda yakin ingin menyimpan data ini?',
                    text: "SIMPAN DATA SEKOLAH: " + namaSekolah,
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "./addSave",
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
                            success: function(response) {
                                if (response.status == 200) {
                                    Swal.fire(
                                        'SELAMAT!',
                                        response.message,
                                        'success'
                                    ).then((valRes) => {
                                        reloadPage();
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
                });
            }
        });
    }
</script>