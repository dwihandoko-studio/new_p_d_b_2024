<div class="mb-3 row">
    <h3>DATA PENGAJUAN VERVAL DAN AKUN</h3>
</div>
<form id="formVerifikasiData" class="formVerifikasiData" action="./verifikasiBelumSave" method="post">
    <input type="hidden" id="_no_tiket_pd" name="_no_tiket_pd" value="<?= $data->no_tiket ?>" readonly />

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Nama Pd</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="_nama_pd" name="_nama_pd" value="<?= $data->nama ?>" readonly />
        </div>
    </div>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Tempat Lahir Pd</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="_tempat_lahir_pd" name="_tempat_lahir_pd" value="<?= $data->tempat_lahir ?>" readonly />
        </div>
    </div>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Tanggal Lahir Pd</label>
        <div class="col-sm-9">
            <input type="date" class="form-control" id="_tanggal_lahir_pd" name="_tanggal_lahir_pd" value="<?= $data->tanggal_lahir ?>" readonly />
        </div>
    </div>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Jenis Kelamin Pd</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="_jenis_kelamin_pd" name="_jenis_kelamin_pd" value="<?= $data->jenis_kelamin ?>" readonly />
        </div>
    </div>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Nama Ibu Kandung Pd</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="_nama_ibu_kandung_pd" name="_nama_ibu_kandung_pd" value="<?= $data->nama_ibu_kandung ?>" readonly />
        </div>
    </div>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Tingkat Pendidikan Pd</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="_tingkat_pendidikan_pd" name="_tingkat_pendidikan_pd" value="<?= $data->tingkat_pendidikan_id ?>" readonly />
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
            <select class="w-100" style="width: 100%;" id="_kec" name="_kec" onchange="changeKec(this)" required>
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
            <select class="w-100" style="width: 100%;" id="_kel" name="_kel" onchange="changeKel(this)" required>
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
            <select class="w-100" style="width: 100%;" id="_dusun" name="_dusun" onchange="changeDus(this)" required>
                <option value="">-- Pilih --</option>
                <?php if (isset($dusuns)) { ?>
                    <?php if (count($dusuns) > 0) { ?>
                        <?php foreach ($dusuns as $key => $value) { ?>
                            <option value="<?= $value->id ?>" <?= ($value->id === $data->dusun) ? ' selected' : "" ?>><?= $value->nama ?></option>
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
                                <input type="text" class="form-control" id="_lintang" name="_lintang" value="<?= $data->lintang ?>" required />
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Bujur</label>
                        <div class="col-sm-9">
                            <div class="input-group   input-primary">
                                <span class="input-group-text">Long</span>
                                <input type="text" class="form-control" id="_bujur" name="_bujur" value="<?= $data->bujur ?>" required />
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
        <label class="col-sm-3 col-form-label">NIK</label>
        <div class="col-sm-9">
            <div class="input-group   input-primary">
                <span class="input-group-text">NIK</span>
                <input type="text" class="form-control" id="_nik" name="_nik" value="<?= $data->nik ?>" required />
            </div>
        </div>
    </div>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Kartu Keluarga</label>
        <div class="col-sm-9">
            <div class="input-group   input-primary">
                <span class="input-group-text">KK</span>
                <input type="text" class="form-control" id="_kk" name="_kk" value="<?= $data->no_kk ?>" required />
            </div>
        </div>
    </div>
</form>
<script>
    function validateFormVerifikasi(events) {
        for (const event of events) {
            if (!event.checkValidity()) {
                Swal.fire(
                    'Peringatan!',
                    "Silahkan lengkapi isian.",
                    'warning'
                ).then((valRes) => {});
                return false;
            }
        }
        return true;
    }

    function selesaiPengaduan(id, nama) {
        const formVerifikasi = document.getElementById('formVerifikasiData');
        if (formVerifikasi) {
            const formElementsVerifikasi = formVerifikasi.querySelectorAll('input, select, textarea');

            if (validateFormVerifikasi(formElementsVerifikasi)) {
                Swal.fire({
                    title: 'Apakah anda yakin ingin memverifikasi dan generate akun data pengaduan ' + nama + '?',
                    text: "Verifikasi dan generate akun pengaduan",
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, VERIFIKASI & SIMPAN!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "./verifikasiBelumSave",
                            type: 'POST',
                            data: $(formVerifikasi).serialize(),
                            dataType: 'JSON',
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Sedang loading...',
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
                                    Swal.fire(
                                        'GAGAL!',
                                        resul.message,
                                        'warning'
                                    );
                                } else {
                                    Swal.fire({
                                        title: "<strong>VERIFIKASI DAN GENERATE AKUN BERHASIL</strong>",
                                        icon: "info",
                                        html: '<center><b>Proses Verifikasi dan Generate Aku Peserta Didik Via Pengaduan</b><br/>Atas Nama: ' + resul.nama + ' Berhasil</center>',
                                        showCloseButton: false,
                                        showCancelButton: true,
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        focusConfirm: false,
                                        confirmButtonText: "Tidak",
                                        confirmButtonText: `<i class="las la-file-download"></i> Download Akun PD?`,
                                        confirmButtonAriaLabel: "File, Download"
                                    }).then((confm) => {
                                        if (confm.isConfirmed) {
                                            $.ajax({
                                                url: "./download",
                                                type: 'POST',
                                                data: {
                                                    id: resul.peserta_didik_id,
                                                    nama: resul.nama,
                                                },
                                                dataType: 'JSON',
                                                beforeSend: function() {
                                                    Swal.fire({
                                                        title: 'Mendowload Akun...',
                                                        text: 'Please wait while we process your action.',
                                                        allowOutsideClick: false,
                                                        allowEscapeKey: false,
                                                        didOpen: () => {
                                                            Swal.showLoading();
                                                        }
                                                    });
                                                },
                                                complete: function() {},
                                                success: function(resul1) {
                                                    if (resul1.status !== 200) {
                                                        Swal.fire(
                                                            'GAGAL!',
                                                            resul1.message,
                                                            'warning'
                                                        );
                                                    } else {
                                                        Swal.fire(
                                                            'BERHASIL!',
                                                            resul1.message,
                                                            'success'
                                                        ).then((valResT) => {

                                                            const decodedBytes = atob(resul1.data);
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
                                                            link.download = resul1.filename; // Set desired filename
                                                            link.click();
                                                            URL.revokeObjectURL(link.href);

                                                            Swal.fire({
                                                                title: "<strong>KIRIM AKUN KE WA & EMAIL</strong>",
                                                                icon: "question",
                                                                html: '<center><b>Kirim akun peserta didik ke</b><br/>No WA: ' + resul.nohp + ' & Email: ' + resul.email + '</center>',
                                                                showCloseButton: false,
                                                                showCancelButton: true,
                                                                allowOutsideClick: false,
                                                                allowEscapeKey: false,
                                                                focusConfirm: false,
                                                                confirmButtonText: "Tidak",
                                                                confirmButtonText: `<i class="las la-hand-point-right"></i> Kirim Pesan?`,
                                                                confirmButtonAriaLabel: "Send, Pesan"
                                                            }).then((confm) => {
                                                                if (confm.isConfirmed) {
                                                                    sendPesan(resul.nohp, resul.email, resul.peserta_didik_id, resul.nama, resul.url, resul.url_pdf);
                                                                } else {
                                                                    reloadPage(resul.url);
                                                                }
                                                            })

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
                                        } else {
                                            reloadPage(resul.url);
                                        }
                                    });



                                    // Swal.fire(
                                    //     'BERHASIL!',
                                    //     resul.message,
                                    //     'success'
                                    // ).then((valRes) => {
                                    //     reloadPage(resul.url);
                                    // })
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
            } else {}
        }
    }

    function ambilKoordinat(event) {
        var lat = document.getElementsByName('_lintang')[0].value;
        var long = document.getElementsByName('_bujur')[0].value;

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

        document.getElementById('_lintang').value = latitu;
        document.getElementById('_bujur').value = longitu;

        $('#content-mapModal').modal('hide');
    }

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

    $('#_prov').select2({
        dropdownParent: ".content_data_pengaduan_detail",
    });

    $('#_kab').select2({
        dropdownParent: ".content_data_pengaduan_detail",
    });
    $('#_kec').select2({
        dropdownParent: ".content_data_pengaduan_detail",
    });
    $('#_kel').select2({
        dropdownParent: ".content_data_pengaduan_detail",
    });
    $('#_dusun').select2({
        dropdownParent: ".content_data_pengaduan_detail",
    });
</script>