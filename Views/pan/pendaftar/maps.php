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