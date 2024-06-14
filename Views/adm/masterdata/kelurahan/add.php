<form id="formAddData" class="formAddData" action="./addSave" method="post">
    <div class="modal-body">
        <div class="row">
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Kecamatan :</label>
                <div class="col-sm-9">
                    <select class="default-select form-control wide mb-3" id="_kecamatan" name="_kecamatan">
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Kode Kelurahan</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_kode" name="_kode" value="" placeholder="Kode Kelurahan" required />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Nama Kelurahan</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_nama" name="_nama" value="" placeholder="Nama Kelurahan" required />
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
    $('#_kecamatan').select2({
        dropdownParent: ".contentBodycontentModal",
        allowClear: true,
        width: "100%",
        ajax: {
            url: "./getKecamatan",
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    keyword: params.term,
                };
            },
            processResults: function(data, params) {
                if (data.status === 200) {
                    return {
                        results: data.data
                    };
                } else {
                    return {
                        results: []
                    };
                }
            },
            cache: true
        },
        placeholder: 'Cari kecamatan minimal 3 karakter)',
        minimumInputLength: 3,
        escapeMarkup: function(markup) {
            return markup;
        },
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });

    function formatRepo(repo) {
        if (repo.loading) {
            return repo.text;
        }

        var markup = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'></div>" +
            "<div class='select2-result-repository__description'></div>" +
            "</div>" +
            "</div>"
        );

        markup.find(".select2-result-repository__title").text(repo.nama);
        markup.find(".select2-result-repository__description").text("Kab. " + repo.kabupaten);

        return markup;
    }

    function formatRepoSelection(repo) {
        // $(repo.element).attr('data-custom-pesertadidikid', repo.peserta_didik_id);
        // $(repo.element).attr('data-custom-nisn', repo.nisn);
        // $(repo.element).attr('data-custom-nik', repo.nik);
        // $(repo.element).attr('data-custom-nama', repo.nama);
        // $(repo.element).attr('data-custom-tempatlahir', repo.tempat_lahir);
        // $(repo.element).attr('data-custom-tanggallahir', repo.tanggal_lahir);
        // $(repo.element).attr('data-custom-namaibukandung', repo.nama_ibu_kandung);
        // $(repo.element).attr('data-custom-jeniskelamin', repo.jenis_kelamin);
        // // $(repo.element).attr('data-custom-kabupaten', repo.kabupaten);
        // // $(repo.element).attr('data-custom-kecamatan', repo.kecamatan);
        // $(repo.element).attr('data-custom-desakelurahan', repo.desa_kelurahan);
        // $(repo.element).attr('data-custom-dusun', repo.nama_dusun);
        // $(repo.element).attr('data-custom-lintang', repo.lintang);
        // $(repo.element).attr('data-custom-bujur', repo.bujur);
        return repo.nama || repo.text;
    }

    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    function validateForm(formElement) {
        const nama = document.getElementsByName('_nama')[0];
        const kode = document.getElementsByName('_kode')[0];
        const kecamatan = document.getElementsByName('_kecamatan')[0];

        if ((nama.value === "" || nama.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Nama kelurahan tidak boleh kosong.",
                'warning'
            ).then((valRes) => {
                nama.focus();
            });
            return false;
        }
        if ((kode.value === "" || kode.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Kode kelurahan tidak boleh kosong.",
                'warning'
            ).then((valRes) => {
                kode.focus();
            });
            return false;
        }
        if ((kecamatan.value === "" || kecamatan.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Kecamatan tidak boleh kosong.",
                'warning'
            ).then((valRes) => {
                // nama.focus();
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
                const nama = document.getElementsByName('_nama')[0].value;
                Swal.fire({
                    title: 'Apakah anda yakin ingin menyimpan data ini?',
                    text: "Tambah Data Kelurahan: " + nama,
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
                                    title: 'Menyimpan data...',
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