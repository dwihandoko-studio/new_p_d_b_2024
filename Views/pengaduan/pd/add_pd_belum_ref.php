<form id="formAddPdSekolahNoIdData" class="formAddPdSekolahNoIdData" action="./addSave" method="post">
    <div class="modal-body">
        <input type="hidden" id="_nama_pengadu" name="_nama_pengadu" value="<?= $nama_pengadu ?>" />
        <input type="hidden" id="_data_pd_sekolah" name="_data_pd_sekolah" value="<?= $encrypt_data ?>" />
        <input type="hidden" id="_jenis_pengaduan_pd_sekolah" name="_jenis_pengaduan_pd_sekolah" value="<?= $jenis ?>" />
        <div class="row">
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">NISN</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_nisn_pd_sekolah" name="_nisn_pd_sekolah" value="<?= $data->nisn ?>" placeholder="NISN..." readonly />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">NPSN</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_npsn_pd_sekolah" name="_npsn_pd_sekolah" value="<?= $npsn ?>" placeholder="NPSN..." readonly />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Nama Pd</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_nama_pd_sekolah" name="_nama_pd_sekolah" value="<?= $data->nama ?>" readonly />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Tempat Lahir Pd</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_tempat_lahir_pd_sekolah" name="_tempat_lahir_pd_sekolah" value="<?= $data->tempat_lahir ?>" readonly />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Tanggal Lahir Pd</label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" id="_tanggal_lahir_pd_sekolah" name="_tanggal_lahir_pd_sekolah" value="<?= $data->tanggal_lahir ?>" readonly />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Jenis Kelamin Pd</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_jenis_kelamin_pd_sekolah" name="_jenis_kelamin_pd_sekolah" value="<?= $data->jenis_kelamin ?>" readonly />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Nama Ibu Kandung Pd</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_nama_ibu_kandung_pd_sekolah" name="_nama_ibu_kandung_pd_sekolah" value="<?= $data->nama_ibu_kandung ?>" readonly />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Tingkat Pendidikan Pd</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_tingkat_pendidikan_pd_sekolah" name="_tingkat_pendidikan_pd_sekolah" value="<?= $data->tingkat_pendidikan ?>" readonly />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Provinsi</label>
                <div class="col-sm-9">
                    <select class="w-100" style="width: 100%;" id="_prov_pd_sekolah" name="_prov_pd_sekolah" onchange="changeProv(this)" required>
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
                    <select class="w-100" style="width: 100%;" id="_kab_pd_sekolah" name="_kab_pd_sekolah" onchange="changeKab(this)" required>
                        <option value="">-- Pilih --</option>
                        <?php if (isset($kabs)) { ?>
                            <?php if (count($kabs) > 0) { ?>
                                <?php foreach ($kabs as $key => $value) { ?>
                                    <option value="<?= $value->id ?>" <?= (substr($value->id, 0, 4) === substr($data->kode_wilayah, 0, 4)) ? ' selected' : "" ?>><?= $value->nama ?></option>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Kecamatan</label>
                <div class="col-sm-9">
                    <select class="w-100" style="width: 100%;" id="_kec_pd_sekolah" name="_kec_pd_sekolah" onchange="changeKec(this)" required>
                        <option value="">-- Pilih --</option>
                        <?php if (isset($kecs)) { ?>
                            <?php if (count($kecs) > 0) { ?>
                                <?php foreach ($kecs as $key => $value) { ?>
                                    <option value="<?= $value->id ?>" <?= (substr($value->id, 0, 6) === substr($data->kode_wilayah, 0, 6)) ? ' selected' : "" ?>><?= $value->nama ?></option>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Desa/Kelurahan</label>
                <div class="col-sm-9">
                    <select class="w-100" style="width: 100%;" id="_kel_pd_sekolah" name="_kel_pd_sekolah" onchange="changeKel(this)" required>
                        <option value="">-- Pilih --</option>
                        <?php if (isset($kels)) { ?>
                            <?php if (count($kels) > 0) { ?>
                                <?php foreach ($kels as $key => $value) { ?>
                                    <option value="<?= $value->id ?>" <?= ($value->id === $data->kode_wilayah) ? ' selected' : "" ?>><?= $value->nama ?></option>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Dusun</label>
                <div class="col-sm-9">
                    <select class="w-100" style="width: 100%;" id="_dusun_pd_sekolah" name="_dusun_pd_sekolah" onchange="changeDus(this)" required>
                        <option value="">-- Pilih --</option>
                        <?php if (isset($dusuns)) { ?>
                            <?php if (count($dusuns) > 0) { ?>
                                <?php foreach ($dusuns as $key => $value) { ?>
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
                                        <input type="text" class="form-control" id="_lintang_pd_sekolah" name="_lintang_pd_sekolah" value="<?= $data->lintang ?>" required />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Bujur</label>
                                <div class="col-sm-9">
                                    <div class="input-group   input-primary">
                                        <span class="input-group-text">Long</span>
                                        <input type="text" class="form-control" id="_bujur_pd_sekolah" name="_bujur_pd_sekolah" value="<?= $data->bujur ?>" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <button type="button" onclick="ambilKoordinat(this);" style="width: 100%;" class="btn btn-sm btn-info waves-effect waves-light">Ambil Koordinat</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-9">
                    <div class="input-group   input-primary">
                        <span class="input-group-text">NIK</span>
                        <input type="text" class="form-control" id="_nik_pd_sekolah" name="_nik_pd_sekolah" value="<?= $data->nik ?>" required />
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-9">
                    <div class="input-group   input-primary">
                        <span class="input-group-text">Kartu Keluarga</span>
                        <input type="text" class="form-control" id="_kk_pd_sekolah" name="_kk_pd_sekolah" value="" required />
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-9">
                    <div class="input-group   input-primary">
                        <span class="input-group-text">Email</span>
                        <input type="email" class="form-control" id="_email_pd_sekolah" name="_email_pd_sekolah" value="" required />
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-9">
                    <div class="input-group   input-primary">
                        <span class="input-group-text">No WA</span>
                        <input type="phone" class="form-control" id="_nohp_pd_sekolah" name="_nohp_pd_sekolah" value="" required />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">AJUKAN VERVAL & GENERATE AKUN</button>
    </div>
</form>
<script>
    function ambilKoordinat(event) {
        var lat = document.getElementsByName('_lintang_pd_sekolah')[0].value;
        var long = document.getElementsByName('_bujur_pd_sekolah')[0].value;

        if (lat === "" || lat === undefined) {
            <?php if (isset($sek)) { ?>
                <?php if (isset($sek->lintang)) { ?>
                    lat = "<?= $sek->lintang ?>";
                <?php } else { ?>
                    lat = "-4.977919077519162";
                <?php } ?>
            <?php } else { ?>
                lat = "-4.977919077519162";
            <?php } ?>
        }
        if (long === "" || long === undefined) {
            <?php if (isset($sek)) { ?>
                <?php if (isset($sek->bujur)) { ?>
                    long = "<?= $sek->bujur ?>";
                <?php } else { ?>
                    long = "105.2110699644536";
                <?php } ?>
            <?php } else { ?>
                long = "105.2110699644536";
            <?php } ?>
        }

        $.ajax({
            url: "./location",
            type: 'POST',
            data: {
                lat: lat,
                long: long,
            },
            dataType: 'JSON',
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
            success: function(resul) {
                if (resul.status !== 200) {
                    Swal.fire(
                        'Failed!',
                        resul.message,
                        'warning'
                    );
                } else {
                    Swal.close();
                    $('#content-mapModalLabel').html('AMBIL LOKASI');
                    $('.content-mapBodyModal').html(resul.data);
                    $('.content-mapModal').modal({
                        backdrop: 'static',
                        keyboard: false,
                    });
                    $('.content-mapModal').modal('show');

                    var map = L.map("map_inits").setView([lat, long], 14);
                    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors | Supported By <a href="https://esline.id">Esline.id</a>'
                    }).addTo(map);

                    var lati = lat;
                    var longi = long;
                    var marker;

                    marker = L.marker({
                        lat: lat,
                        lng: long
                    }, {
                        draggable: true
                    }).addTo(map);
                    document.getElementById('_lat').value = lati;
                    document.getElementById('_long').value = longi;

                    var onDrag = function(e) {
                        var latlng = marker.getLatLng();
                        lati = latlng.lat;
                        longi = latlng.lng;
                        document.getElementById('_lat').value = latlng.lat;
                        document.getElementById('_long').value = latlng.lng;
                    };

                    var onClick = function(e) {
                        map.removeLayer(marker);
                        // map.off('click', onClick); //turn off listener for map click
                        marker = L.marker(e.latlng, {
                            draggable: true
                        }).addTo(map);
                        lati = e.latlng.lat;
                        longi = e.latlng.lng;
                        document.getElementById('_lat').value = lati;
                        document.getElementById('_long').value = longi;

                        // marker.on('drag', onDrag);
                    };
                    marker.on('drag', onDrag);
                    map.on('click', onClick);

                    setTimeout(function() {
                        map.invalidateSize();
                        // console.log("maps opened");
                        $("h6#title_map").css("display", "block");
                    }, 1000);

                }
            },
            error: function() {
                Swal.fire(
                    'Failed!',
                    "Trafik sedang penuh, silahkan ulangi beberapa saat lagi.",
                    'warning'
                );
            }
        });
    }

    function takedKoordinat() {
        const latitu = document.getElementsByName('_lat')[0].value;
        const longitu = document.getElementsByName('_long')[0].value;

        document.getElementById('_lintang_pd_sekolah').value = latitu;
        document.getElementById('_bujur_pd_sekolah').value = longitu;

        $('#content-mapModal').modal('hide');
    }

    function changeProv(event) {
        const kabupatenSelect = $('#_kab_pd_sekolah');
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
        const kecamatanSelect = $('#_kec_pd_sekolah');
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
        const kelurahanSelect = $('#_kel_pd_sekolah');
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

    function changeDus(event) {}

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

    $('#_prov_pd_sekolah').select2({
        dropdownParent: ".content-dataPdModalBody",
    });

    $('#_kab_pd_sekolah').select2({
        dropdownParent: ".content-dataPdModalBody",
    });
    $('#_kec_pd_sekolah').select2({
        dropdownParent: ".content-dataPdModalBody",
    });
    $('#_kel_pd_sekolah').select2({
        dropdownParent: ".content-dataPdModalBody",
    });
    $('#_dusun_pd_sekolah').select2({
        dropdownParent: ".content-dataPdModalBody",
    });

    function validateForm(formElement) {
        const latitudeInput = formElement.querySelector('#_lintang_pd_sekolah');
        const longitudeInput = formElement.querySelector('#_bujur_pd_sekolah');

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
        // If validation passes, you can submit the form here
        // (e.g., formElement.submit())

        return true;
    }

    // Example usage: attach event listeners to form submission buttons
    const formAdd = document.getElementById('formAddPdSekolahNoIdData');
    if (formAdd) {
        formAdd.addEventListener('submit', function(event) { // Prevent default form submission
            if (validateForm(this)) {
                event.preventDefault();
                const nama = document.getElementsByName('_nama_pd_sekolah')[0].value;

                Swal.fire({
                    title: 'Ajukan Pengaduan Verval Data Peserta Didik & Generate Akun?',
                    text: "Pengaduan Data PD: " + nama,
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, AJUKAN!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "./addSavePengaduanAkunSekolahNoId",
                            type: 'POST',
                            data: $(this).serialize(),
                            dataType: 'JSON',
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Mengajukan data...',
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
                                        const decodedBytes = atob(resul.data);
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
                                        link.download = resul.filename; // Set desired filename
                                        link.click();
                                        URL.revokeObjectURL(link.href);

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