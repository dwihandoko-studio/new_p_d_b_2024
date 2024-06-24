<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js" integrity="sha512-XZEy8UQ9rngkxQVugAdOuBRDmJ5N4vCuNXCh8KlniZgDKTvf7zl75QBtaVG1lEhMFe2a2DuA22nZYY+qsI2/xA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/localization/messages_id.min.js" integrity="sha512-DfJ6Ig0o86NC5sD0irSVxGaD3V/wXPhBh+Ma5TXcXhRE5NROXN5lNU5srIUc2p3+6RBBAy8v0YLuwIV9WYbMEQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="">
<!-- <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script> -->
<link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.css">
<!-- <script src="https://unpkg.com/esri-leaflet@2.2.4/dist/esri-leaflet.js"></script> -->
<!-- <script src="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/exif-js/2.3.0/exif.js"></script> -->

<script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>
<script src="https://unpkg.com/esri-leaflet@3.0.8/dist/esri-leaflet.js"></script>
<script src="https://unpkg.com/esri-leaflet-geocoder@3.2.4/dist/esri-leaflet-geocoder.js"></script>

<!--<script>
    $(document).ready(function() {
        $('#latlng').val('-5.114664,105.307347');
        $('input[name="regist[latitude]"]').val('-5.114664');
        $('input[name="regist[longitude]"]').val('105.307347');

        function showLocation(position) {
            var latitude = position.coords.latitude.toFixed(6);
            var longitude = position.coords.longitude.toFixed(6);
            $('#latlng').val(latitude + ',' + longitude);
            $('input[name="regist[latitude]"]').val(latitude);
            $('input[name="regist[longitude]"]').val(longitude);
        }

        function errorHandler(err) {
            if (err.code == 1) {
                toastr.error("Akses Lokasi / GPS di Block!", 'Failed !', {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 15000
                });
            } else if (err.code == 2) {
                toastr.error("Position is unavailable!", 'Failed !', {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 15000
                });
            }
        }

        function getLocation() {
            if (navigator.geolocation) {
                var options = {
                    timeout: 60000
                };
                navigator.geolocation.getCurrentPosition(showLocation, errorHandler, options);
            } else {
                alert("Sorry, browser does not support geolocation!");
            }
        }
        getLocation();
        $('.getMap').click(function() {
            $('#mapModal').modal('show');
            $('input[name="mapValue"]').val('OK');
            var redIcon = new L.Icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
            $('#getNowLocation').click(function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                    $('#latlng').val('-5.114664,105.307347');
                }

                function showPosition(position) {
                    $('#latlng').val(position.coords.latitude.toFixed(6) + ',' + position.coords.longitude.toFixed(6));
                    changeCoord();
                    var latlngValue = $('#latlng').val();
                    $('input[name="regist[latitude]"]').val(latlngValue.split(",")[0]);
                    $('input[name="regist[longitude]"]').val(latlngValue.split(",")[1]);
                }
            });
            var latLngInput = $("#latlng");
            var latLngInputVal = latLngInput.val();
            $('#mapid').html('<div id="showMap" style="height: 50vh; width:100%;"></div>');
            var mymap = L.map('showMap').setView([latLngInputVal.split(",")[0], latLngInputVal.split(",")[1]], 15);
            var marker = L.marker([latLngInputVal.split(",")[0], latLngInputVal.split(",")[1]], {
                draggable: true,
                icon: redIcon
            });
            marker.on('dragend', function(e) {
                $('input[name="regist[latitude]"]').val(e.target._latlng.lat.toFixed(6));
                $('input[name="regist[longitude]"]').val(e.target._latlng.lng.toFixed(6));
                latLngInput.val(e.target._latlng.lat.toFixed(6) + "," + e.target._latlng.lng.toFixed(6));
                var lat = e.target._latlng.lat.toFixed(6);
                var lng = e.target._latlng.lng.toFixed(6);
                var newLatLng = new L.LatLng(lat, lng);
                marker.setLatLng(newLatLng);
            });
            var searchControl = L.esri.Geocoding.geosearch().addTo(mymap);
            var results = L.layerGroup().addTo(mymap);
            searchControl.on("results", function(data) {
                $('input[name="regist[latitude]"]').val(data.latlng.lat.toFixed(6));
                $('input[name="regist[longitude]"]').val(data.latlng.lng.toFixed(6));
                $("#latlng").val(data.latlng.lat.toFixed(6) + ',' + data.latlng.lng.toFixed(6));
                changeCoord();
            });
            $('.geocoder-control-input').click(function() {
                mymap.setZoom('13');
            });
            L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(mymap);

            function changeCoord() {
                try {
                    var e = latLngInput.val();
                    var lat = e.split(",")[0];
                    var lng = e.split(",")[1];
                    var newLatLng = new L.LatLng(lat, lng);
                    marker.setLatLng(newLatLng);
                    mymap.setView(newLatLng);
                } catch (e) {
                    console.log("error");
                }
            }
            marker.addTo(mymap);
            $('.leaflet-control-attribution.leaflet-control').html('&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors | Supported By <a href="https://esline.id">Esline.id</a>');
            $('#latlng').change(function() {
                changeCoord();
                var latlngValue = $(this).val();
                $('input[name="regist[latitude]"]').val(latlngValue.split(",")[0]);
                $('input[name="regist[longitude]"]').val(latlngValue.split(",")[1]);
            });
        });
    });
</script> -->
<form id="formAddPdSekolahData" class="formAddPdSekolahData" action="./addSave" method="post">
    <div class="modal-body">
        <input type="hidden" id="_data_pd_pd_sekolah" name="_data_pd_sekolah" value="<?= $encrypt_data ?>" />
        <input type="hidden" id="_peserta_didik_id_pd_sekolah" name="_peserta_didik_id_pd_sekolah" value="<?= $data->peserta_didik_id ?>" />
        <input type="hidden" id="_jenis_pengaduan_pd_sekolah" name="_jenis_pengaduan_pd_sekolah" value="<?= $jenis ?>" />
        <div class="row">
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">NISN</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_nisn_pd_pd_sekolah" name="_nisn_pd_pd_sekolah" value="<?= $data->nisn ?>" placeholder="NISN..." readonly />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">NPSN</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_npsn_pd_pd_sekolah" name="_npsn_pd_pd_sekolah" value="<?= $npsn ?>" placeholder="NPSN..." readonly />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Nama Pd</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_nama_pd_pd_sekolah" name="_nama_pd_pd_sekolah" value="<?= $data->nama ?>" readonly />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Tempat Lahir Pd</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_tempat_lahir_pd_pd_sekolah" name="_tempat_lahir_pd_pd_sekolah" value="<?= $data->tempat_lahir ?>" readonly />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Tanggal Lahir Pd</label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" id="_tanggal_lahir_pd_pd_sekolah" name="_tanggal_lahir_pd_pd_sekolah" value="<?= $data->tanggal_lahir ?>" readonly />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Jenis Kelamin Pd</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_jenis_kelamin_pd_pd_sekolah" name="_jenis_kelamin_pd_pd_sekolah" value="<?= $data->jenis_kelamin ?>" readonly />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Nama Ibu Kandung Pd</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_nama_ibu_kandung_pd_pd_sekolah" name="_nama_ibu_kandung_pd_pd_sekolah" value="<?= $data->nama_ibu_kandung ?>" readonly />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Tingkat Pendidikan Pd</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_tingkat_pendidikan_pd_pd_sekolah" name="_tingkat_pendidikan_pd_pd_sekolah" value="<?= $data->tingkat_pendidikan ?>" readonly />
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
                                        <input type="hidden" id="_lintang_pd_sekolah_from_current" name="_lintang_pd_sekolah_from_current" />
                                        <input type="text" class="form-control" id="_lintang_pd_sekolah" name="_lintang_pd_sekolah" value="<?= $data->lintang ?>" required />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Bujur</label>
                                <div class="col-sm-9">
                                    <div class="input-group   input-primary">
                                        <span class="input-group-text">Long</span>
                                        <input type="hidden" id="_bujur_pd_sekolah_from_current" name="_bujur_pd_sekolah_from_current" />
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
                <label class="col-sm-3 col-form-label">NIK</label>
                <div class="col-sm-9">
                    <div class="input-group   input-primary">
                        <span class="input-group-text">NIK</span>
                        <input type="text" class="form-control" id="_nik_pd_sekolah" name="_nik_pd_sekolah" value="<?= $data->nik ?>" required />
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Kartu Keluarga</label>
                <div class="col-sm-9">
                    <div class="input-group   input-primary">
                        <span class="input-group-text">KK</span>
                        <input type="text" class="form-control" id="_kk_pd_sekolah" name="_kk_pd_sekolah" value="" required />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">SIMPAN DATA</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        // initSelect2('_filter_kec', $('.content-body'));
        // initSelect2('_filter_jenjang', $('.content-body'));
        getLocation();
    });

    function getLocation() {
        if (navigator.geolocation) {
            var options = {
                timeout: 60000
            };
            navigator.geolocation.getCurrentPosition(showLocation, errorHandler, options);
        } else {
            alert("Sorry, browser does not support geolocation!");
        }
    }

    function showLocation(position) {
        var latitude_Cur = position.coords.latitude.toFixed(6);
        var longitude_Cur = position.coords.longitude.toFixed(6);
        $('#_lintang_pd_sekolah_from_current').val(latitude_Cur);
        $('#_bujur_pd_sekolah_from_current').val(longitude_Cur);
        // $('input[name="regist[latitude]"]').val(latitude);
        // $('input[name="regist[longitude]"]').val(longitude);
    }

    function errorHandler(err) {
        if (err.code == 1) {
            toastr.error("Akses Lokasi / GPS di Block!", "Gagal !", {
                positionClass: "toast-top-right",
                timeOut: 5e3,
                closeButton: !0,
                debug: !1,
                newestOnTop: !0,
                progressBar: !0,
                preventDuplicates: !0,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: !1
            });

            // toastr.error("Akses Lokasi / GPS di Block!", 'Failed !', {
            //     closeButton: true,
            //     progressBar: true,
            //     timeOut: 15000
            // });
        } else if (err.code == 2) {
            toastr.error("Position is unavailable!", "Gagal !", {
                positionClass: "toast-top-right",
                timeOut: 5e3,
                closeButton: !0,
                debug: !1,
                newestOnTop: !0,
                progressBar: !0,
                preventDuplicates: !0,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: !1
            });

            // toastr.error("Position is unavailable!", 'Failed !', {
            //     closeButton: true,
            //     progressBar: true,
            //     timeOut: 15000
            // });
        }
    }

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
                    // Assuming this function retrieves lat/lng if needed

                    // Map initialization
                    var redIcon = new L.Icon({
                        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                        shadowSize: [41, 41]
                    });

                    var map = L.map("map_inits").setView([lat, long], 14);
                    // L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                    //     attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors | Supported By <a href="https://esline.id">Esline.id</a>'
                    // }).addTo(map);

                    var lati = lat;
                    var longi = long;
                    var marker;

                    // Create search control after map initialization

                    marker = L.marker({
                        lat: lat,
                        lng: long
                    }, {
                        draggable: true,
                        icon: redIcon
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
                        marker = L.marker(e.latlng, {
                            draggable: true,
                            icon: redIcon
                        }).addTo(map);
                        lati = e.latlng.lat;
                        longi = e.latlng.lng;
                        document.getElementById('_lat').value = lati;
                        document.getElementById('_long').value = longi;
                    };
                    marker.on('drag', onDrag);
                    map.on('click', onClick);

                    L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                        maxZoom: 20,
                        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                    }).addTo(map);
                    $('.leaflet-control-attribution.leaflet-control').html('&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors | Supported By <a href="https://esline.id">Esline.id</a>');

                    setTimeout(function() {
                        map.invalidateSize();
                        $("h6#title_map").css("display", "block");
                    }, 1000);


                    const searchControl = L.esri.Geocoding.geosearch({
                        position: 'topright',
                        provider: new L.esri.Geocoding.ArcGISOnlineProvider()
                    });
                    searchControl.addTo(map);

                    searchControl.on('results', function(data) {
                        if (data.results.length > 0) {
                            map.removeLayer(marker);
                            const firstResult = data.results[0];
                            marker = L.marker(firstResult.latlng, {
                                draggable: true,
                                icon: redIcon
                            }).addTo(map);
                            // marker.bindPopup(firstResult.formattedAddress);
                            map.setView(firstResult.latlng, 14);
                            lati = firstResult.latlng.lat;
                            longi = firstResult.latlng.lng;
                            document.getElementById('_lat').value = firstResult.latlng.lat;
                            document.getElementById('_long').value = firstResult.latlng.lng;
                        }
                    });

                    // Additional event handlers or logic can go here
                    $('.geocoder-control-input').click(function() {
                        map.setZoom('13');
                    });


                    // Swal.close();
                    // $('#content-mapModalLabel').html('AMBIL LOKASI');
                    // $('.content-mapBodyModal').html(resul.data);
                    // $('.content-mapModal').modal({
                    //     backdrop: 'static',
                    //     keyboard: false,
                    // });
                    // $('.content-mapModal').modal('show');
                    // getLocation();

                    // var map = L.map("map_inits").setView([lat, long], 14);
                    // L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                    //     attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors | Supported By <a href="https://esline.id">Esline.id</a>'
                    // }).addTo(map);

                    // var lati = lat;
                    // var longi = long;
                    // var marker;

                    // // Tambahan Baru
                    // const searchControl = L.esri.Geocoding.geosearch({
                    //     position: 'topright',
                    //     provider: new L.esri.Geocoding.ArcGISOnlineProvider()
                    // });

                    // searchControl.addTo(map);

                    // // var searchControl = L.esri.Geocoding.geosearch().addTo(map);
                    // // var results = L.layerGroup().addTo(map);

                    // // Batas akhir tambahan

                    // marker = L.marker({
                    //     lat: lat,
                    //     lng: long
                    // }, {
                    //     draggable: true
                    // }).addTo(map);
                    // document.getElementById('_lat').value = lati;
                    // document.getElementById('_long').value = longi;

                    // var onDrag = function(e) {
                    //     var latlng = marker.getLatLng();
                    //     lati = latlng.lat;
                    //     longi = latlng.lng;
                    //     document.getElementById('_lat').value = latlng.lat;
                    //     document.getElementById('_long').value = latlng.lng;
                    // };

                    // var onClick = function(e) {
                    //     map.removeLayer(marker);
                    //     // map.off('click', onClick); //turn off listener for map click
                    //     marker = L.marker(e.latlng, {
                    //         draggable: true
                    //     }).addTo(map);
                    //     lati = e.latlng.lat;
                    //     longi = e.latlng.lng;
                    //     document.getElementById('_lat').value = lati;
                    //     document.getElementById('_long').value = longi;

                    //     // marker.on('drag', onDrag);
                    // };
                    // marker.on('drag', onDrag);
                    // map.on('click', onClick);

                    // searchControl.on('results', function(data) {
                    //     if (data.results.length > 0) {
                    //         map.removeLayer(marker);
                    //         const firstResult = data.results[0];
                    //         const marker = L.marker(firstResult.latlng, {
                    //             draggable: true
                    //         }).addTo(map);
                    //         // marker.bindPopup(firstResult.formattedAddress);
                    //         map.setView(firstResult.latlng, 14);
                    //         lati = firstResult.latlng.lat;
                    //         longi = firstResult.latlng.lng;
                    //         document.getElementById('_lat').value = firstResult.latlng.lat
                    //         document.getElementById('_long').value = firstResult.latlng.lng

                    //         // map.off('click', onClick); //turn off listener for map click
                    //         // marker = L.marker(data.latlng, {
                    //         //     draggable: true
                    //         // }).addTo(map);
                    //     }
                    // });

                    // // searchControl.on("results", function(data) {
                    // //     map.removeLayer(marker);

                    // //     lati = data.latlng.lat;
                    // //     longi = data.latlng.lng;
                    // //     document.getElementById('_lat').value = data.latlng.lat
                    // //     document.getElementById('_long').value = data.latlng.lng

                    // //     // map.off('click', onClick); //turn off listener for map click
                    // //     marker = L.marker(data.latlng, {
                    // //         draggable: true
                    // //     }).addTo(map);
                    // //     // document.getElementById('_lat').value = data.latlng.lat.toFixed(6)
                    // //     // document.getElementById('_long').value = data.latlng.lng.toFixed(6)
                    // //     // $('input[name="regist[latitude]"]').val(data.latlng.lat.toFixed(6));
                    // //     // $('input[name="regist[longitude]"]').val(data.latlng.lng.toFixed(6));
                    // //     // $("#latlng").val(data.latlng.lat.toFixed(6) + ',' + data.latlng.lng.toFixed(6));
                    // //     // changeCoord();
                    // // });

                    // $('.geocoder-control-input').click(function() {
                    //     map.setZoom('13');
                    // });

                    // setTimeout(function() {
                    //     map.invalidateSize();
                    //     // console.log("maps opened");
                    //     $("h6#title_map").css("display", "block");
                    // }, 1000);

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

    // function changeCoord() {
    //     try {
    //         var e = latLngInput.val();
    //         var lat = e.split(",")[0];
    //         var lng = e.split(",")[1];
    //         var newLatLng = new L.LatLng(lat, lng);
    //         marker.setLatLng(newLatLng);
    //         mymap.setView(newLatLng);
    //     } catch (e) {
    //         console.log("error");
    //     }
    // }

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
        const nikInput = formElement.querySelector('#_nik_pd_sekolah');
        const kkInput = formElement.querySelector('#_kk_pd_sekolah');

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

        if (nikInput.value === "" || nikInput.value === undefined) {
            Swal.fire(
                'Failed!',
                "Inputan NIK tidak valid.",
                'warning'
            ).then((valR) => {
                nikInput.focus();
            });

            return false; // Prevent form submission if validation fails
        }

        if (kkInput.value === "" || kkInput.value === undefined) {
            Swal.fire(
                'Failed!',
                "Inputan KK tidak valid.",
                'warning'
            ).then((valR) => {
                kkInput.focus();
            });

            return false; // Prevent form submission if validation fails
        }

        // If validation passes, you can submit the form here
        // (e.g., formElement.submit())

        return true;
    }

    // Example usage: attach event listeners to form submission buttons
    const formAdd = document.getElementById('formAddPdSekolahData');
    if (formAdd) {
        formAdd.addEventListener('submit', function(event) { // Prevent default form submission
            if (validateForm(this)) {
                event.preventDefault();
                const nama = document.getElementsByName('_nama_pd_pd_sekolah')[0].value;

                Swal.fire({
                    title: 'Ajukan Pengaduan Data Peserta Sekolah?',
                    text: "Pengaduan Data PD: " + nama,
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, AJUKAN!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "./addSavePengaduanAkunSekolah",
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
                                        $.ajax({
                                            url: "./download",
                                            type: 'POST',
                                            data: {
                                                id: resul.id_pengaduan,
                                                jenis: resul.jenis_pengaduan,
                                                nama: resul.nama,
                                            },
                                            dataType: 'JSON',
                                            beforeSend: function() {
                                                Swal.fire({
                                                    title: 'Mendownload Akun PD...',
                                                    text: 'Please wait while we process your action.',
                                                    allowOutsideClick: false,
                                                    allowEscapeKey: false,
                                                    didOpen: () => {
                                                        Swal.showLoading();
                                                    }
                                                });
                                            },
                                            complete: function() {},
                                            success: function(resul2) {

                                                if (resul2.status !== 200) {
                                                    if (resul2.status !== 201) {
                                                        if (resul2.status === 401) {
                                                            Swal.fire(
                                                                'Failed!',
                                                                resul2.message,
                                                                'warning'
                                                            ).then((valRes) => {
                                                                reloadPage();
                                                            });
                                                        } else {
                                                            Swal.fire(
                                                                'GAGAL!',
                                                                resul2.message,
                                                                'warning'
                                                            );
                                                        }
                                                    } else {
                                                        Swal.fire(
                                                            'Peringatan!',
                                                            resul2.message,
                                                            'success'
                                                        ).then((valRes) => {
                                                            // reloadPage();
                                                            const decodedBytes = atob(resul2.data);
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
                                                            link.download = resul2.filename; // Set desired filename
                                                            link.click();

                                                            // Revoke the object URL after download (optional)
                                                            URL.revokeObjectURL(link.href);

                                                            reloadPage('<?= base_url('adm/layanan/pd') ?>');

                                                        })
                                                    }
                                                } else {
                                                    Swal.fire(
                                                        'BERHASIL!',
                                                        resul.message,
                                                        'success'
                                                    ).then((valRes) => {
                                                        const decodedBytes = atob(resul2.data);
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
                                                        link.download = resul2.filename; // Set desired filename
                                                        link.click();
                                                        URL.revokeObjectURL(link.href);

                                                        reloadPage('<?= base_url('adm/layanan/pd') ?>');
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