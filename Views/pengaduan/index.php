<?= $this->extend('t-dashboard/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">
    <div class="container-fluid" style="padding-top: 0.5rem;">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Layanan Pengaduan</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <a href="javascript:buatPengaduan();" class="btn btn-block btn-primary">Buat Pengaduan</a>
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="javascript:void(0)" class="btn btn-block btn-info">Lacak Tiket Pengaduan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->include('t-dashboard/bottom'); ?>

        </div>
    </div>
</div>
<div id="content-addModal" class="modal fade content-addModal">
    <!-- <div id="content-addModal" class="modal fade content-addModal" tabindex="-1" role="dialog" aria-hidden="true"> -->
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-addModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="content-addModalBody">
            </div>
        </div>
    </div>
</div>
<div id="content-dataPdModal" class="modal fade content-dataPdModal" style="overflow: auto;">
    <!-- <div id="content-dataPdModal" class="modal fade content-dataPdModal" tabindex="-2" role="dialog" aria-hidden="true"> -->
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-dataPdModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="content-dataPdModalBody">
            </div>
        </div>
    </div>
</div>
<!-- <div id="content-mapModal" class="modal fade content-mapModal"> -->
<div id="content-mapModal" class="modal fade content-mapModal" tabindex="-3" role="dialog" aria-hidden="true">
    <input type="hidden" id="_lat_long_sek" name="_lat_long_sek" />
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-mapModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="content-mapBodyModal">
                <div class="modal-body">
                    <p>Silahkan Geser Point Berwarna Merah dan Sesuaikan dengan Alamat Rumah Peserta PPDB Lampung Timur, Pastikan GPS Perangkat Anda Hidup atau cari wilayah menggunakan fitur <i class="fa-solid fa-magnifying-glass"></i> di pojok kanan atas map.</p>
                    <input id="latlng" type="hidden" class="form-control form-control-sm" value="-5.114664,105.307347">
                    <div id="mapid" style="height: 50vh;"></div>
                    <button type="button" class="btn btn-danger btn-sm mt-1" id="getNowLocation"><i class="fa-solid fa-map-location-dot"></i> Ambil Titik Koordinat Anda Saat Ini</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script src="<?= base_url() ?>/assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/assets/vendor/sweetalert2/sweetalert2.min.js"></script>
<script src="<?= base_url() ?>/assets/vendor/select2/js/select2.min.js"></script>
<script src="<?= base_url() ?>/assets/vendor/toastr/js/toastr.min.js"></script>
<script>
    function buatPengaduan() {
        $.ajax({
            url: "./add",
            type: 'POST',
            data: {
                id: 'add',
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
                    $('#content-addModalLabel').html('BUAT PENGADUAN');
                    $('.content-addModalBody').html(response.data);
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
            error: function(xhr, ajaxOptions, thrownError) {
                Swal.fire(
                    'Failed!',
                    "gagal mengambil data (" + xhr.status.toString + ")",
                    'warning'
                );
            }

        });
    }

    // $(document).ready(function() {
    //     // initSelect2('_filter_kec', $('.content-body'));
    //     // initSelect2('_filter_jenjang', $('.content-body'));

    // });
</script>
<script>
    $(document).ready(function() {
        // var lat = document.getElementsByName('_lintang_pd_sekolah')[0].value;
        // var long = document.getElementsByName('_bujur_pd_sekolah')[0].value;
        $('#_lat_long_sek').val('-5.114664,105.307347');
        // $('input[name="_lintang_pd_sekolah"]').val('-5.114664');
        // $('input[name="_bujur_pd_sekolah"]').val('105.307347');

        function showLocation(position) {
            var latitude = position.coords.latitude.toFixed(6);
            var longitude = position.coords.longitude.toFixed(6);
            $('#_lat_long_sek').val(latitude + ',' + longitude);
            // $('input[name="_lintang_pd_sekolah"]').val(latitude);
            // $('input[name="_bujur_pd_sekolah"]').val(longitude);
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


    });

    function getMapShowed() {
        $('#content-mapModal').modal('show');
        // $('input[name="mapValue"]').val('OK');
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
                // $('#latlng').val('-5.114664,105.307347');
            }

            function showPosition(position) {
                // $('#latlng').val(position.coords.latitude.toFixed(6) + ',' + position.coords.longitude.toFixed(6));
                changeCoord();
                var latlngValue = $('#_lat_long_sek').val();
                $('input[name="_lintang_pd_sekolah"]').val(latlngValue.split(",")[0]);
                $('input[name="_bujur_pd_sekolah"]').val(latlngValue.split(",")[1]);
            }
        });
        var latLngInput = $("#_lat_long_sek");
        var latLngInputVal = latLngInput.val();
        $('#mapid').html('<div id="showMap" style="height: 50vh; width:100%;"></div>');
        var mymap = L.map('showMap').setView([latLngInputVal.split(",")[0], latLngInputVal.split(",")[1]], 15);
        var marker = L.marker([latLngInputVal.split(",")[0], latLngInputVal.split(",")[1]], {
            draggable: true,
            icon: redIcon
        });
        marker.on('dragend', function(e) {
            $('input[name="_lintang_pd_sekolah"]').val(e.target._latlng.lat.toFixed(6));
            $('input[name="_bujur_pd_sekolah"]').val(e.target._latlng.lng.toFixed(6));
            latLngInput.val(e.target._latlng.lat.toFixed(6) + "," + e.target._latlng.lng.toFixed(6));
            var lat = e.target._latlng.lat.toFixed(6);
            var lng = e.target._latlng.lng.toFixed(6);
            var newLatLng = new L.LatLng(lat, lng);
            marker.setLatLng(newLatLng);
        });
        var searchControl = L.esri.Geocoding.geosearch().addTo(mymap);
        var results = L.layerGroup().addTo(mymap);
        searchControl.on("results", function(data) {
            $('input[name="_lintang_pd_sekolah"]').val(data.latlng.lat.toFixed(6));
            $('input[name="_bujur_pd_sekolah"]').val(data.latlng.lng.toFixed(6));
            $("#_lat_long_sek").val(data.latlng.lat.toFixed(6) + ',' + data.latlng.lng.toFixed(6));
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
        $('#_lat_long_sek').change(function() {
            changeCoord();
            var latlngValue = $(this).val();
            $('input[name="_lintang_pd_sekolah"]').val(latlngValue.split(",")[0]);
            $('input[name="_bujur_pd_sekolah"]').val(latlngValue.split(",")[1]);
        });
    };
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/vendor/owl-carousel/owl.carousel.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/vendor/nouislider/nouislider.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/vendor/toastr/css/toastr.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="">
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.css">
<script src="https://unpkg.com/esri-leaflet@2.2.4/dist/esri-leaflet.js"></script>
<script src="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.js"></script>

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.js"></script> -->

<!-- ADD new Leaflet -->
<!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="">
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.css">
<script src="https://unpkg.com/esri-leaflet@2.2.4/dist/esri-leaflet.js"></script>
<script src="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exif-js/2.3.0/exif.js"></script> -->
<?= $this->endSection(); ?>