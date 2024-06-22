<form id="formAddData" class="formAddData" action="./addSave" method="post">
    <input type="hidden" name="_id" id="_id" value="<?= $id ?>" />
    <div class="modal-body">
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">Provinsi</label>
            <div class="col-sm-9">
                <select class="w-100" style="width: 100%;" id="_prov" name="_prov" onchange="changeProv(this)" required>
                    <option value="">-- Pilih --</option>
                    <?php if (isset($provinsis)) { ?>
                        <?php if (count($provinsis) > 0) { ?>
                            <?php foreach ($provinsis as $key => $value) { ?>
                                <option value="<?= $value->id ?>"><?= $value->nama ?></option>
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
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">Kecamatan</label>
            <div class="col-sm-9">
                <select class="w-100" style="width: 100%;" id="_kec" name="_kec" onchange="changeKec(this)" required>
                    <option value="">-- Pilih --</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">Desa/Kelurahan</label>
            <div class="col-sm-9">
                <select class="w-100" style="width: 100%;" id="_kel" name="_kel" onchange="changeKel(this)" required>
                    <option value="">-- Pilih --</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">Dusun</label>
            <div class="col-sm-9">
                <div class="form-check custom-checkbox mb-3">
                    <input type="checkbox" class="form-check-input _dusun_all" name="_dusun_all" id="_dusun_all">
                    <label class="form-check-label" for="_dusun_all">Pilih Semua Dusun</label>
                </div>
            </div>
            <label class="col-sm-3 col-form-label">&nbsp;</label>
            <div class="col-sm-9">
                <div class="row">
                    <?php if (isset($dusuns)) { ?>
                        <?php if (count($dusuns) > 0) { ?>
                            <?php foreach ($dusuns as $key => $value) { ?>
                                <div class="col-xl-3 col-xxl-4 col-4">
                                    <div class="form-check custom-checkbox mb-3">
                                        <input type="checkbox" class="form-check-input _dusun_value" name="_dusun_value" value="<?= $value->id ?>" id="_dusun<?= $value->urut ?>">
                                        <label class="form-check-label" for="_dusun<?= $value->urut ?>"><?= $value->nama ?></label>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
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
    $('#_dusun_all').click(function() {
        $('input:checkbox').prop('checked', this.checked);
    });

    function changeProv(event) {
        const kabupatenSelect = $('#_kab');
        const kecSelect = $('#_kec');
        const kelSelect = $('#_kel');
        kabupatenSelect.empty(); // Clear existing options
        kecSelect.empty(); // Clear existing options
        kelSelect.empty(); // Clear existing options
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
        const kelSelect = $('#_kel');
        kelSelect.empty(); // Clear existing options
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

    $('#_prov').select2({
        dropdownParent: ".content-editBodyModal",
    });

    $('#_kab').select2({
        dropdownParent: ".content-editBodyModal",
    });
    $('#_kec').select2({
        dropdownParent: ".content-editBodyModal",
    });
    $('#_kel').select2({
        dropdownParent: ".content-editBodyModal",
    });

    function validateForm(formElement) {
        const prov = document.getElementsByName('_prov')[0];
        const kab = document.getElementsByName('_kab')[0];
        const kec = document.getElementsByName('_kec')[0];
        const kel = document.getElementsByName('_kel')[0];

        var dusun = $('input:checkbox:checked._dusun_value').map(function() {
            return this.value;
        }).get().join(",");

        if ((prov.value === "" || prov.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Silahkan pilih provinsi.",
                'warning'
            ).then((valRes) => {});
            return false;
        }
        if ((kab.value === "" || kab.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Silahkan pilih kabupaten.",
                'warning'
            ).then((valRes) => {});
            return false;
        }
        if ((kec.value === "" || kec.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Silahkan pilih kecamatan.",
                'warning'
            ).then((valRes) => {});
            return false;
        }
        if ((kel.value === "" || kel.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Silahkan pilih kelurahan.",
                'warning'
            ).then((valRes) => {});
            return false;
        }
        if ((dusun === "")) {
            Swal.fire(
                'Peringatan!',
                "Silahkan pilih dusun minimal 1.",
                'warning'
            ).then((valRes) => {});
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
                // const nama = document.getElementsByName('_nama')[0].value;
                var dusuns = $('input:checkbox:checked._dusun_value').map(function() {
                    return this.value;
                }).get().join(",");
                const provs = document.getElementsByName('_prov')[0].value;
                const kabs = document.getElementsByName('_kab')[0].value;
                const kecs = document.getElementsByName('_kec')[0].value;
                const kels = document.getElementsByName('_kel')[0].value;
                const id = document.getElementsByName('_id')[0].value;
                Swal.fire({
                    title: 'Apakah anda yakin ingin menyimpan data ini?',
                    text: "Tambah Wilayah Zonasi",
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
                            data: {
                                prov: provs,
                                kab: kabs,
                                kec: kecs,
                                kel: kels,
                                id: id,
                                dusun: dusuns,
                            },
                            dataType: 'JSON',
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Menyimpan data Panitia...',
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
            } else {
                event.preventDefault();
            }
        });
    }
</script>