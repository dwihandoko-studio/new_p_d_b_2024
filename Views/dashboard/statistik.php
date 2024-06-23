<?= $this->extend('t-dashboard/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">
    <div class="container-fluid" style="padding-top: 0.5rem;">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-block d-sm-flex border-0 transactions-tab">
                        <div class="me-3">
                            <h4 class="card-title mb-2">Statistik</h4>
                            <span class="fs-12">PPDB Kab. Lampung Tengah Tahun 2024/2025</span>
                        </div>
                    </div>
                    <div class="card-body tab-content p-0">
                        <div class="tab-pane fade active show" id="monthly" role="tabpanel">
                            <div id="accordion-one" class="accordion style-1">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h4 class="card-title">&nbsp;</h4>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="mb-3">
                                                                    <label for="_filter_kec" class="col-form-label">Filter Kecamatan:</label>
                                                                    <select class="form-control filter-kec" id="_filter_kec" name="_filter_kec" width="100%" style="width: 100%;">
                                                                        <option value="">--Pilih--</option>
                                                                        <?php if (isset($kecamatans)) {
                                                                            if (count($kecamatans) > 0) {
                                                                                foreach ($kecamatans as $key => $value) { ?>
                                                                                    <option value="<?= $value->id ?>"><?= $value->nama ?></option>
                                                                        <?php }
                                                                            }
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="mb-3">
                                                                    <label for="_filter_jenjang" class="col-form-label">Filter Jenjang:</label>
                                                                    <select class="form-control filter-jenjang" id="_filter_jenjang" name="_filter_jenjang" width="100%" style="width: 100%;">
                                                                        <option value="">--Pilih--</option>
                                                                        <option value="5">SD</option>
                                                                        <option value="6">SMP</option>
                                                                        <?php if (isset($jenjangs)) {
                                                                            if (count($jenjangs) > 0) {
                                                                                foreach ($jenjangs as $key => $value) { ?>
                                                                                    <option value="<?= $value->bentuk_pendidikan_id ?>"><?= $value->bentuk_pendidikan ?></option>
                                                                        <?php }
                                                                            }
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="table-responsive">
                                            <table id="data-datatables" class="display" style="min-width: 845px">
                                                <thead>
                                                    <tr class="_tampilan-display-inherit">
                                                        <th data-orderable="false" class="_tampilan-display-inherit">#</th>
                                                        <th class="_tampilan-display-inherit">Nama Sekolah</th>
                                                        <th data-orderable="false">Jalur Afirmasi</th>
                                                        <th data-orderable="false">Jalur Zonasi</th>
                                                        <th data-orderable="false">Jalur Mutasi</th>
                                                        <th data-orderable="false">Jalur Prestasi</th>
                                                        <th data-orderable="false">Swasta</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
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

<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script src="<?= base_url() ?>/assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/assets/vendor/select2/js/select2.min.js"></script>
<script src="<?= base_url() ?>/assets/vendor/sweetalert2/sweetalert2.min.js"></script>

<script>
    function formatDataPendaftar(d) {
        let cRekapD = '';
        cRekapD += '<div class="col-md-12"><table cellpadding="5" cellspacing="0" border="1" style="padding-left:50px; width: 100%;">';
        cRekapD += '<thead>';
        cRekapD += '<tr>';
        cRekapD += '<th colspan="5" style="text-align: center; align-items: center;">DATA PENDAFTAR YANG TERVERIFIKASI</th>';
        cRekapD += '</tr>';
        cRekapD += '<tr>';
        cRekapD += '<th>';
        cRekapD += 'Jalur';
        cRekapD += '</th>';
        cRekapD += '<th>';
        cRekapD += 'No Pendaftaran';
        cRekapD += '</th>';
        cRekapD += '<th>';
        cRekapD += 'Nama Peserta';
        cRekapD += '</th>';
        cRekapD += '<th>';
        cRekapD += 'NISN';
        cRekapD += '</th>';
        cRekapD += '<th>';
        cRekapD += 'Asal Sekolah';
        cRekapD += '</th>';
        cRekapD += '</tr>';
        cRekapD += '</thead>';
        cRekapD += '<tbody class="data-rekap-verifikasi-';
        cRekapD += d.id;
        cRekapD += '">';
        cRekapD += '<tr>';
        cRekapD += '<td colspan="5" style="text-align: center; align-items: center;">';
        cRekapD += '......LOADING.......';
        cRekapD += '</td>';
        cRekapD += '</tr>';
        cRekapD += '</tbody>';
        cRekapD += '</table>';

        cRekapD += '<br>';
        cRekapD += '<div class="col-md-12"><table cellpadding="5" cellspacing="0" border="1" style="padding-left:50px; width: 100%;">';
        cRekapD += '<thead>';
        cRekapD += '<tr>';
        cRekapD += '<th colspan="4" style="text-align: center; align-items: center;">DATA PENDAFTAR YANG BELUM TERVERIFIKASI</th>';
        cRekapD += '</tr>';
        cRekapD += '<tr>';
        // cRekapD +=              '<th>';
        // cRekapD +=                  'No';
        // cRekapD +=              '</th>';
        cRekapD += '<th>';
        cRekapD += 'Jalur';
        cRekapD += '</th>';
        cRekapD += '<th>';
        cRekapD += 'Nama Peserta';
        cRekapD += '</th>';
        cRekapD += '<th>';
        cRekapD += 'NISN';
        cRekapD += '</th>';
        cRekapD += '<th>';
        cRekapD += 'Asal Sekolah';
        cRekapD += '</th>';
        cRekapD += '</tr>';
        cRekapD += '</thead>';
        cRekapD += '<tbody class="data-rekap-belum-verifikasi-';
        cRekapD += d.id;
        cRekapD += '">';
        cRekapD += '<tr>';
        cRekapD += '<td colspan="4" style="text-align: center; align-items: center;">';
        cRekapD += '......LOADING.......';
        cRekapD += '</td>';
        cRekapD += '</tr>';
        cRekapD += '</tbody>';
        cRekapD += '</table>';

        return cRekapD;
        // `d` is the original data object for the row

    }


    function actionDetailPendaftar(event, title) {
        // console.log(event);

        $.ajax({
            "url": "./getDetailStatistikWeb",
            type: 'POST',
            data: {
                id: event,
                name: title,
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
            success: function(msg) {
                Swal.close();
                // $('div.main-content').unblock();
                if (msg.status != 200) {
                    console.log(msg.message);
                } else {
                    if (msg.data_terverifikasi.length > 0) {
                        let htmlRekap = "";
                        for (let stepr = 0; stepr < msg.data_terverifikasi.length; stepr++) {
                            // const numberBer = stepr +1;
                            htmlRekap += '<tr>';
                            htmlRekap += '<td>';
                            htmlRekap += msg.data_terverifikasi[stepr].via_jalur;
                            htmlRekap += '</td>';
                            htmlRekap += '<td>';
                            htmlRekap += msg.data_terverifikasi[stepr].kode_pendaftaran;
                            htmlRekap += '</td>';
                            htmlRekap += '<td>';
                            htmlRekap += msg.data_terverifikasi[stepr].fullname;
                            htmlRekap += '</td>';
                            htmlRekap += '<td>';
                            htmlRekap += msg.data_terverifikasi[stepr].nisn;
                            htmlRekap += '</td>';
                            htmlRekap += '<td>';
                            htmlRekap += msg.data_terverifikasi[stepr].nama_sekolah_asal;
                            htmlRekap += '</td>';
                            htmlRekap += '</tr>';
                        }

                        $('.data-rekap-verifikasi-' + event).html(htmlRekap);

                    } else {
                        let htmlRekap = '<tr>';
                        htmlRekap += '<td colspan="5" style="text-align: center; align-items: center;">';
                        htmlRekap += 'Tidak ada data.';
                        htmlRekap += '</td>';
                        htmlRekap += '</tr>';

                        $('.data-rekap-verifikasi-' + event).html(htmlRekap);
                    }

                    if (msg.data_belum_verifikasi.length > 0) {

                        let htmlRekapB = "";
                        for (let stepb = 0; stepb < msg.data_belum_verifikasi.length; stepb++) {
                            // const numberBer = stepb +1;
                            htmlRekapB += '<tr>';
                            // htmlRekapB +=              '<td>';
                            // htmlRekapB +=                  numberBer;
                            // htmlRekapB +=              '</td>';
                            htmlRekapB += '<td>';
                            htmlRekapB += msg.data_belum_verifikasi[stepb].via_jalur;
                            htmlRekapB += '</td>';
                            htmlRekapB += '<td>';
                            htmlRekapB += msg.data_belum_verifikasi[stepb].fullname;
                            htmlRekapB += '</td>';
                            htmlRekapB += '<td>';
                            htmlRekapB += msg.data_belum_verifikasi[stepb].nisn;
                            htmlRekapB += '</td>';
                            htmlRekapB += '<td>';
                            htmlRekapB += msg.data_belum_verifikasi[stepb].nama_sekolah_asal;
                            htmlRekapB += '</td>';
                            htmlRekapB += '</tr>';
                        }

                        $('.data-rekap-belum-verifikasi-' + event).html(htmlRekapB);
                    } else {
                        let htmlRekapB = '<tr>';
                        htmlRekapB += '<td colspan="4" style="text-align: center; align-items: center;">';
                        htmlRekapB += 'Tidak ada data.';
                        htmlRekapB += '</td>';
                        htmlRekapB += '</tr>';

                        $('.data-rekap-belum-verifikasi-' + event).html(htmlRekapB);
                    }

                }
            },
            error: function(e) {
                Swal.close();
                console.log(e);
            }
        });

    }

    $(document).ready(function() {
        initSelect2('_filter_kec', $('.content-body'));
        initSelect2('_filter_jenjang', $('.content-body'));

        let tableZonasiSekolah = $('#data-datatables').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "./getAllStatistikWeb",
                "type": "POST",
                "data": function(data) {
                    data.kec = $('#_filter_kec').val();
                    data.jenjang = $('#_filter_jenjang').val();
                }
            },
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            },
            'columns': [{
                    className: 'dt-control _tampilan-display-inherit',
                    orderable: false,
                    data: 'button',
                    defaultContent: '',
                },
                {
                    className: '_tampilan-display-inherit',
                    data: 'nama'
                },
                {
                    data: 'afirmasi',
                    orderable: false
                },
                {
                    data: 'zonasi',
                    orderable: false
                },
                {
                    data: 'mutasi',
                    orderable: false
                },
                {
                    data: 'prestasi',
                    orderable: false
                },
                {
                    data: 'swasta',
                    orderable: false
                }
            ],
            "columnDefs": [{
                "targets": 0,
                "orderable": false,
            }],
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 Data', '25 Data', '50 Data', 'Show All']
            ],
        });


        $('#data-datatables tbody').on('click', 'td.dt-control', function() {
            var tr = $(this).closest('tr');
            var row = tableZonasiSekolah.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row

                row.child(formatDataPendaftar(row.data())).show();
                tr.addClass('shown');
            }
        });

        $('#_filter_kec').change(function() {
            tableZonasiSekolah.draw();
        });
        $('#_filter_jenjang').change(function() {
            tableZonasiSekolah.draw();
        });
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/vendor/owl-carousel/owl.carousel.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

<link href="<?= base_url() ?>/assets/vendor/nouislider/nouislider.min.css" rel="stylesheet" type="text/css" />
<style>
    ._tampilan-display-inherit {
        vertical-align: inherit !important;
    }
</style>
<?= $this->endSection(); ?>