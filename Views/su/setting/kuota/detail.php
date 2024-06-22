<div class="modal-body">
    <div class="row">
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">Nama Sekolah</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="_nama" name="_nama" value="<?= $data->nama ?>" readonly />
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">NPSN</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="_email" name="_email" value="<?= $data->npsn ?>" readonly />
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">Jenjang Pendidikan</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="_jenjang" name="_jenjang" value="<?= $data->bentuk_pendidikan ?>" readonly />
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">Kecamatan</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="_kecamatan" name="_kecamatan" value="<?= $data->kecamatan ?>" readonly />
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">Jumlah Kebutuhan Rombel</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="_kecamatan" name="_kecamatan" value="<?= $data->jumlah_rombel_kebutuhan ?>" readonly />
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">Afirmasi</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="_afirmasi" name="_afirmasi" value="<?= $data->afirmasi ?>" readonly />
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">Zonasi</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="_zonasi" name="_zonasi" value="<?= $data->zonasi ?>" readonly />
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">Mutasi</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="_mutasi" name="_mutasi" value="<?= $data->mutasi ?>" readonly />
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">Prestasi</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="_prestasi" name="_prestasi" value="<?= $data->prestasi ?>" readonly />
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">Radius Zonasi</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="_radius" name="_radius" value="<?= $data->radius_zonasi ?> Km" readonly />
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">Status Terkunci</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="_status" name="_status" value="<?= (int)$data->is_locked == 1 ? 'Terkunci' : 'Tidak Terkunci' ?>" readonly />
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
</div>