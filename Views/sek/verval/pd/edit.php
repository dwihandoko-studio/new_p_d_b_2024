<?= $this->extend('t-verval/sek/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Peserta Didik</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Tingkat Akhir</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="_filter_pd" class="col-form-label">Pilih PD:</label>
                                    <select class="js-data-pd-ajax w-100" style="width: 100%;" id="_filter_pd" name="_filter_pd" onchange="changePd(this)">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="contentEditForm" id="contentEditForm"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="content-mapModal" class="modal fade content-mapModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-mapModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="content-mapBodyModal">
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script>
    $('#_filter_pd').select2({
        dropdownParent: ".container-fluid",
        allowClear: true,
        width: "100%",
        ajax: {
            url: "./getPd",
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
        placeholder: 'Cari Peserta Didik (NISN / Nama minimal 4 karakter)',
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
        markup.find(".select2-result-repository__description").text("NISN: " + repo.nisn);

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

    function changePd(event) {
        const selectedOption = event.value;

        if (selectedOption === "" || selectedOption === undefined) {
            $('.contentBodyUploadModal').html("");
        } else {
            $.ajax({
                url: "./changedPd",
                type: 'POST',
                data: {
                    id: selectedOption,
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
                        $('.contentEditForm').html(response.data);
                    } else {
                        Swal.fire(
                            'Failed!',
                            response.message,
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

    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    $(document).ready(function() {
        // initSelect2('_filter_kec', $('.content-body'));
        // initSelect2('_filter_jenjang', $('.content-body'));
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.js"></script>
<?= $this->endSection(); ?>