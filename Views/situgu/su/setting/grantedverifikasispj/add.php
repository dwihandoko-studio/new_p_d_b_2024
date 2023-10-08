<form id="formAddModalData" action="./addSave" method="post">
    <div class="modal-body">

        <div class="mb-3 _pengguna-block">
            <label for="_ptk" class="col-form-label">PTK:</label>
            <select class="form-control ptk" id="_ptk" name="_ptk" style="width: 100%">
                <option value="">&nbsp;</option>
            </select>
            <div class="help-block _ptk"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
    </div>
</form>

<script>
    // initSelect2("_role", ".content-detailModal");
    // initSelect2("_ptk", ".content-detailModal");

    $('#_ptk').select2({
        dropdownParent: ".content-detailModal",
        ajax: {
            url: "./getPtk",
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    keyword: params.term,
                };
            },
            processResults: function(data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                // params.page = params.page || 1;
                if (data.status === 200) {
                    return {
                        results: data.data
                    };
                } else {
                    return {
                        results: []
                    };
                }

                // return {
                //     results: data.items,
                //     pagination: {
                //         more: (params.page * 30) < data.total_count
                //     }
                // };
            },
            cache: true
        },
        placeholder: 'Cari TPK',
        minimumInputLength: 3,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });

    function formatRepo(repo) {
        if (repo.loading) {
            return repo.text;
        }

        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'></div>" +
            "<div class='select2-result-repository__description'></div>" +
            "</div>" +
            "</div>"
        );

        $container.find(".select2-result-repository__title").text(repo.nama);
        $container.find(".select2-result-repository__description").text(repo.nuptk + " (" + repo.npsn + ")");

        return $container;
    }

    function formatRepoSelection(repo) {
        return repo.nama || repo.text;
    }

    $("#formAddModalData").on("submit", function(e) {
        e.preventDefault();
        const ptk = document.getElementsByName('_ptk')[0].value;

        if (ptk === "") {
            $("select#_ptk").css("color", "#dc3545");
            $("select#_ptk").css("border-color", "#dc3545");
            $('._ptk').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih PTK.</li></ul>');
            return false;
        }

        $.ajax({
            url: "./addSave",
            type: 'POST',
            data: {
                id: ptk,
            },
            dataType: 'JSON',
            beforeSend: function() {
                $('div.modal-content-loading').block({
                    message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                });
            },
            success: function(resul) {
                $('div.modal-content-loading').unblock();

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
                        'SELAMAT!',
                        resul.message,
                        'success'
                    ).then((valRes) => {
                        reloadPage();
                    })
                }
            },
            error: function() {
                $('div.modal-content-loading').unblock();
                Swal.fire(
                    'PERINGATAN!',
                    "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                    'warning'
                );
            }
        });
    });
</script>