<?= $this->extend('t-verval/adm/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Masterdata</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Peserta Didik TA Sekolah</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- <div class="card-header">

                    </div> -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title">Data Peserta Didik Tingkat Akhir Sekolah</h4>

                            </div>
                            <div class="col-3">
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
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="_filter_jenjang" class="col-form-label">Filter Jenjang:</label>
                                    <select class="form-control filter-jenjang" id="_filter_jenjang" name="_filter_jenjang" width="100%" style="width: 100%;">
                                        <option value="">--Pilih--</option>
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
                            <div class="col-3">
                                <div class="mb-3">
                                    <button id="btnExcelDownload" class="btn btn-primary mr-2">Export Excel</button>
                                </div>
                            </div>

                        </div>
                        <col-12>
                            <div class="table-responsive">
                                <table id="data-datatables" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Action</th>
                                            <th>Nama Sekolah</th>
                                            <th>NPSN</th>
                                            <th>Jenjang</th>
                                            <th>Kecamatan</th>
                                            <th>Total</th>
                                            <th>Verififed</th>
                                            <th>NotVerififed</th>
                                            <th>Generate</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </col-12>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="content-uploadModal" class="modal fade content-uploadModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-uploadModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="contentBodyUploadModal">
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-html5-3.0.2/datatables.min.js"></script> -->
<script src="<?= base_url() ?>/assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
    $(document).ready(function() {
        initSelect2('_filter_kec', $('.content-body'));
        initSelect2('_filter_jenjang', $('.content-body'));
        let tableDatatables = $('#data-datatables').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "./getAll",
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
            lengthMenu: [
                [10, 25, 50, 100, 200, -1],
                [10, 25, 50, 100, 200, "All"]
            ],
            buttons: [{
                extend: 'copy',
                class: 'button-excel-download',
                // init: function(api, node, config) {
                // $(node).hide();
                // }
            }, {
                extend: 'pdf',
                class: 'buttons-pdf-download',
                init: function(api, node, config) {
                    $(node).hide();
                }
            }],
            "columnDefs": [{
                "targets": 0,
                "orderable": false,
            }],
        });
        $('#_filter_kec').change(function() {
            tableDatatables.draw();
        });
        $('#_filter_jenjang').change(function() {
            tableDatatables.draw();
        });

        $('#btnExcelDownload').on('click', function() {
            const jsonData = tableDatatables.rows().data().toArray();

            if (!jsonData || typeof jsonData !== 'object' || jsonData.length === 0) {
                console.error('Invalid JSON data provided. Please provide valid JSON data for export.');
                return;
            }

            // const XLSX = require('xlsx'); // Assuming you're using a bundler like Webpack

            /*
             * Create a workbook and worksheet with appropriate data types:
             */
            const workbook = XLSX.utils.book_new();
            const worksheet = XLSX.utils.json_to_sheet(jsonData, {
                defval: ''
            }); // Set default value for empty cells

            /*
             * Optionally format headers and data (consider using a library like SheetJS.utils.encode_cell):
             */
            const headerRow = worksheet['!ref'].split(':')[0]; // Get the header row range

            // for (let col = (headerRow.charCodeAt(0) - 65); col <= (headerRow.charCodeAt(headerRow.length - 1) - 65); col++) {
            //     const cellAddress = `${String.fromCharCode(col + 65)}1`; // Construct cell address (e.g., A1, B1, ...)
            //     worksheet[cellAddress].v = customHeaders[col]; // Set value from customHeaders array
            // }

            // Apply bold formatting to headers (example)
            worksheet[headerRow].s = {
                font: {
                    bold: true
                }
            };

            worksheet[`A1`].v = `No`;
            worksheet[`B1`].v = `Aksi`;
            worksheet[`C1`].v = `Nama Sekolah`;
            worksheet[`D1`].v = `NPSN`;
            worksheet[`E1`].v = `Jenjang`;
            worksheet[`F1`].v = `Kecamatan`;
            worksheet[`G1`].v = `Jumlah PD Tingkat Akhir`;
            worksheet[`H1`].v = `PD Tingkat Akhir Terverifikasi`;
            worksheet[`I1`].v = `PD Tingkat Akhir Belum Verifikasi`;
            worksheet[`J1`].v = `PD Tingkat Akhir Tergenerate Akun`;

            // const filteredData = jsonData.map(row => {
            //     const {
            //         1: /* Skip index 1 (column B) */ ,
            //         ...filteredRow
            //     } = row;
            //     return filteredRow;
            // });

            XLSX.utils.book_append_sheet(workbook, worksheet, 'Data'); // Adjust sheet name if desired
            XLSX.writeFile(workbook, 'validasi-pd.xlsx', {
                bookType: 'xlsx',
                type: 'binary'
            }); // Ensure binary type for accurate download

            /*
             * Handle download completion or errors:
             */
            const downloadLink = document.createElement('a');
            downloadLink.href = window.URL.createObjectURL(new Blob([workbook], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            }));
            downloadLink.download = 'validasi-pd.xlsx';
            downloadLink.style.display = 'none'; // Hide the link
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink); // Remove the temporary link

            console.log('Data exported to Excel successfully!');
        });
    });

    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<!-- <link href="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-html5-3.0.2/datatables.min.css" rel="stylesheet"> -->
<link href="<?= base_url() ?>/assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<?= $this->endSection(); ?>