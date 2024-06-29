<form id="formAddData" class="formAddData" action="./addSave" method="post">
    <div class="modal-body">
        <div class="row">
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Role</label>
                <div class="col-sm-9">
                    <select class="default-select form-control wide mb-3" id="_role" name="_role" required>
                        <option value="">--Pilih--</option>
                        <?php if (isset($roles)) {
                            if (count($roles) > 0) {
                                foreach ($roles as $key => $value) { ?>
                                    <option value="<?= $value->id ?>"><?= $value->role ?></option>
                        <?php }
                            }
                        } ?>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-12">
                    <div class="mb-3">
                        <label for="_filter_pengguna" class="col-form-label">Pilih User:</label>
                        <select class="js-data-pengguna-ajax w-100" style="width: 100%;" id="_filter_pengguna" name="_filter_pengguna" required>
                        </select>
                    </div>
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
    $('#_filter_pengguna').select2({
        dropdownParent: ".contentBodyUploadModal",
        allowClear: true,
        width: "100%",
        ajax: {
            url: "./getPengguna",
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    keyword: params.term,
                    role: $('#_role').val()
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
        placeholder: 'Cari User (USERNAME 4 karakter)',
        minimumInputLength: 4,
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
        markup.find(".select2-result-repository__description").text("NPSN: " + repo.npsn);

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.nama || repo.text;
    }

    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    function validateForm(formElement) {
        const role = document.getElementsByName('_role')[0];
        const pengguna = document.getElementsByName('_filter_pengguna')[0];

        if ((role.value === "" || role.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Role tidak boleh kosong.",
                'warning'
            ).then((valRes) => {});
            return false;
        }

        if ((pengguna.value === "" || pengguna.value === undefined)) {
            Swal.fire(
                'Peringatan!',
                "Pengguna tidak boleh kosong.",
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

            event.preventDefault();
            if (validateForm(this)) {
                // const role = document.getElementsByName('_role')[0].value;
                Swal.fire({
                    title: 'Apakah anda yakin ingin menyimpan data ini?',
                    text: "Tambah Acess Verifi",
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