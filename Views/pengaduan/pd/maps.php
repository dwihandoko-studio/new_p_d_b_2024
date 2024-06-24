<div class="modal-body">
    <h6 id="title_map" class="title_map" style="display:none;">Loaded Map</h6>
    <div id="map_inits" style="width: 100%; height: 400px;"></div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group _lat-block">
                <label for="_lat" class="form-control-label">Latitude</label>
                <input type="text" class="form-control" id="_lat" name="_lat" placeholder="Latitude . . ." onFocus="inputFocus(this);" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group _long-block">
                <label for="_long" class="form-control-label">Longitude</label>
                <input type="text" class="form-control" id="_long" name="_long" placeholder="Longitude . . ." onFocus="inputFocus(this);" readonly>
            </div>
        </div>
    </div>
    <script>
    </script>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" onclick="takedKoordinat()" class="btn btn-primary">Ambil Koordinat</button>
</div>
<!-- <script>
    $(document).ready(function() {
        // var lat = document.getElementsByName('_lintang_pd_sekolah')[0].value;
        // var long = document.getElementsByName('_bujur_pd_sekolah')[0].value;
        // $('#_lintang_pd_sekolah').val('-5.114664,105.307347');
        $('input[name="_lintang_pd_sekolah"]').val('-5.114664');
        $('input[name="_bujur_pd_sekolah"]').val('105.307347');

        function showLocation(position) {
            var latitude = position.coords.latitude.toFixed(6);
            var longitude = position.coords.longitude.toFixed(6);
            // $('#latlng').val(latitude + ',' + longitude);
            $('input[name="_lintang_pd_sekolah"]').val(latitude);
            $('input[name="_bujur_pd_sekolah"]').val(longitude);
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
            $('.leaflet-control-attribution.leaflet-control').html('&copy; <a href="http://ginktech.net/">Gink Technology</a>');
            $('#latlng').change(function() {
                changeCoord();
                var latlngValue = $(this).val();
                $('input[name="regist[latitude]"]').val(latlngValue.split(",")[0]);
                $('input[name="regist[longitude]"]').val(latlngValue.split(",")[1]);
            });
        });
    });
</script> -->