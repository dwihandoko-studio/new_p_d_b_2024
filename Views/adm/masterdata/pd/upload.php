<style>
    .swal2-modal {
        /* width: auto !important; */
        width: 90% !important;
        /* max-height: 80vh !important; */
        overflow-y: auto !important;
    }

    .dataTables_wrapper {
        width: 100%;
    }

    .dataTables_scrollBody {
        max-height: 400px !important;
    }
</style>
<form id="formUploadModalData" class="formUploadModalData" action="./uploadSave" method="post" enctype="multipart/form-data">
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="mt-3">
                    <label for="_jenjang" class="form-label">Jenjang Pendidikan: </label>
                    <select id="_jenjang" name="_jenjang" class="default-select form-control wide mb-3" required>
                        <option value="">-- Pilih --</option>
                        <option value="73">KB</option>
                        <option value="71">RA</option>
                        <option value="72">TK</option>
                        <option value="6">SD/MI</option>
                        <option value="9">SMP/MTs</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mt-3">
                            <label for="_file" class="form-label">Upload Data PD: </label>
                            <input class="form-control" type="file" id="_file" name="_file" onFocus="inputFocus(this);" accept=".xls, .xlsx, .csv">
                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="xls, xlsx, csv">Files</code> and Maximum File Size <code>10 Mb</code></p>
                            <div class="help-block _file" for="_file"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 output_upload" id="output_upload" style="display: none;">
            </div>
        </div>
    </div>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
<script>
    document.getElementById('_file').addEventListener('change', handleFile, false);

    function handleFile(e) {
        const file = e.target.files[0];

        const extensionFile = file.name.split('.').pop().toLowerCase();

        Swal.fire({
            title: 'Mengambil data...',
            text: 'Please wait while we process your file.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const reader = new FileReader();

        if (extensionFile !== undefined && extensionFile === 'csv') {
            reader.onload = function(e) {
                const csvData = e.target.result;
                Papa.parse(csvData, {
                    header: true,
                    skipEmptyLines: true,
                    complete: function(jsonsData) {
                        displayTableUpload(jsonsData.data);
                    }
                });

            };

            reader.readAsText(file);
        } else {
            reader.onload = function(e) {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, {
                    type: 'array'
                });

                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];

                const json = XLSX.utils.sheet_to_json(worksheet);

                setTimeout(() => {
                    displayTableUpload(json);
                }, 2000);
            };

            reader.readAsArrayBuffer(file);
        }
    }

    function displayTableUpload(data) {
        const output = document.getElementById('output_upload');
        output.innerHTML = '';

        if (data.length === 0) {
            output.innerHTML = '<p>No data found in the file.</p>';
            return;
        }

        const table = document.createElement('table');
        table.id = 'dataTableUpload';
        table.className = 'display';
        table.style.width = '100%';
        const thead = document.createElement('thead');
        const tbody = document.createElement('tbody');

        const headers = Object.keys(data[0]);
        const trHead = document.createElement('tr');
        headers.forEach(header => {
            const th = document.createElement('th');
            th.textContent = header;
            trHead.appendChild(th);
        });
        thead.appendChild(trHead);

        const dataJsonUpload = data.map(row => {
            const rowData = {};
            headers.forEach((header, indexRow) => {
                const keyHeader = header.replace(/ /g, "_");
                rowData[indexRow] = row[header] || '';
            });
            return rowData;
        });

        data.forEach(row => {
            const trBody = document.createElement('tr');
            headers.forEach(header => {
                const td = document.createElement('td');
                td.textContent = row[header] || '';
                trBody.appendChild(td);
            });
            tbody.appendChild(trBody);
        });

        table.appendChild(thead);
        table.appendChild(tbody);
        output.appendChild(table);
        // swal.close();

        Swal.fire({
            title: 'DATA YANG DIUPLOAD',
            html: '<div id="swal-table-container"></div>',
            width: '90%',
            showCloseButton: false,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Upload..!",
            cancelButtonText: "Batal",
            didOpen: () => {
                const swalContainer = document.getElementById('swal-table-container');
                swalContainer.appendChild(output.firstChild);
                $('#dataTableUpload').DataTable({
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
                });
            },
        }).then((result) => {
            if (result.isConfirmed) {
                const jenjang = document.getElementsByName('_jenjang')[0].value;

                if (jenjang === "" || jenjang === undefined || dataJsonUpload === undefined) {
                    Swal.fire(
                        'Peringatan!',
                        "Data yang akan dikirim tidak valid.",
                        'warning'
                    );
                    return;
                }

                Swal.close();

                if (dataJsonUpload === undefined) {
                    Swal.fire(
                        'Peringatan!',
                        "Data yang akan dikirim tidak valid.",
                        'warning'
                    );
                    return;
                }

                try {
                    if (dataJsonUpload.length < 1) {
                        Swal.fire(
                            'Peringatan!',
                            "Tidak ada data yang akan dikirim.",
                            'warning'
                        );
                        return;
                    }
                } catch (error) {
                    Swal.fire(
                        'Peringatan!',
                        "Data yang akan dikirim tidak valid. Terjadi kesalahan dalam pembacaan file.",
                        'warning'
                    );
                    return;
                }

                const jsonData = JSON.stringify(dataJsonUpload);

                Swal.fire({
                    title: 'Apakah anda yakin ingin mengupload data peserta didik ini?',
                    text: `Upload Data Peserta Didik Untuk :  ${dataJsonUpload.length} PD`,
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Upload Data!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: './saveupload',
                            // url: $(this).attr('action'),
                            type: 'POST',
                            data: {
                                data: jsonData,
                                jenjang: jenjang,
                                format: "json"
                            },
                            dataType: "json",
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Uploading...',
                                    text: 'Please wait while we process your file.',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    didOpen: () => {
                                        swal.showLoading();
                                    }
                                });
                            },
                            complete: function() {
                                // swal.close();
                                // $('.btnsimpanbanyak').removeAttr('disable')
                                // $('.btnsimpanbanyak').html('<i class="bx bx-save font-size-16 align-middle me-2"></i> SIMPAN');
                            },
                            success: function(response) {
                                if (response.status == 200) {
                                    Swal.fire(
                                        'SELAMAT!',
                                        response.message + " " + response.data,
                                        'success'
                                    ).then((valRes) => {
                                        reloadPage();
                                    })
                                } else {
                                    $('.output_upload').html("");
                                    const _inputFile = document.getElementsByName('_file')[0];
                                    _inputFile.value = "";
                                    dataJsonUpload.length = 0;
                                    $('.content-uploadModal').modal('hide');
                                    Swal.fire(
                                        'Gagal!',
                                        response.message,
                                        'warning'
                                    );
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                $('.output_upload').html("");
                                const _inputFile = document.getElementsByName('_file')[0];
                                _inputFile.value = "";
                                dataJsonUpload.length = 0;
                                $('.content-uploadModal').modal('hide');
                                Swal.fire(
                                    'Failed!',
                                    "gagal mengambil data (" + xhr.status.toString + ")",
                                    'warning'
                                );
                            }

                        });

                    } else {
                        $('.output_upload').html("");
                        const _inputFile = document.getElementsByName('_file')[0];
                        _inputFile.value = "";
                        dataJsonUpload.length = 0;
                        $('.content-uploadModal').modal('hide');
                    }
                });
            } else {
                $('.output_upload').html("");
                const _inputFile = document.getElementsByName('_file')[0];
                _inputFile.value = "";
                dataJsonUpload.length = 0;
                Swal.close();
                $('.content-uploadModal').modal('hide');
            }
        });
    }
</script>