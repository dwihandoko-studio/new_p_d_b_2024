<?php if (isset($tahun)) { ?>
    <form id="formUploadModalData" class="formUploadModalData" action="./uploadSave" method="post" enctype="multipart/form-data">
        <input type="hidden" value="<?= $tahun ?>" id="id" name="id" readonly>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mt-3">
                                <label for="_file" class="form-label">Upload Data TAGIHAN: </label>
                                <input class="form-control" type="file" id="_file" name="_file" onFocus="inputFocus(this);" accept=".xls, .xlsx">
                                <!-- <input class="form-control" type="file" id="_file" name="_file" onFocus="inputFocus(this);" accept=".xls, .xlsx" onchange="loadFile()"> -->
                                <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="xls, xlsx">Files</code> and Maximum File Size <code>5 Mb</code></p>
                                <div class="help-block _file" for="_file"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 output_upload" id="output_upload" style="display: none;">
                </div>
            </div>
        </div>
        <!-- <div class="modal-footer">
            <div class="col-8">
                <div>
                    <progress id="progressBar" value="0" max="100" style="width:100%; display: none;"></progress>
                </div>
                <div>
                    <h3 id="status" style="font-size: 15px; margin: 8px auto;"></h3>
                </div>
                <div>
                    <p id="loaded_n_total" style="margin-bottom: 0px;"></p>
                </div>
            </div>
            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary waves-effect waves-light">UPLOAD</button>
        </div> -->
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script>
        if (typeof dataJsonUpload === 'undefined') {
            let dataJsonUpload;
        }
        document.getElementById('_file').addEventListener('change', handleFile, false);

        function handleFile(e) {
            const file = e.target.files[0];

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

            reader.onload = function(e) {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, {
                    type: 'array'
                });

                // Assuming the data is in the first sheet
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];

                // Convert the worksheet to JSON
                const json = XLSX.utils.sheet_to_json(worksheet);

                setTimeout(() => {
                    // Hide loading dialog
                    Swal.close();

                    // Display the table
                    displayTableUpload(json);
                }, 2000);

                // Output the JSON data
                // console.log(json);
                // You can also use the JSON data as needed
            };

            reader.readAsArrayBuffer(file);
        }

        function displayTableUpload(data) {
            const output = document.getElementById('output_upload');
            output.innerHTML = '';

            if (data.length === 0) {
                output.innerHTML = '<p>No data found in the file.</p>';
                return;
            }

            // Create a table element
            const table = document.createElement('table');
            table.id = 'dataTableUpload';
            const thead = document.createElement('thead');
            const tbody = document.createElement('tbody');

            // Add table headers
            const headers = Object.keys(data[0]);
            const trHead = document.createElement('tr');
            headers.forEach(header => {
                const th = document.createElement('th');
                th.textContent = header;
                trHead.appendChild(th);
            });
            thead.appendChild(trHead);

            // Add table rows
            data.forEach(row => {
                const trBody = document.createElement('tr');
                const rowData = [];
                headers.forEach(header => {
                    const td = document.createElement('td');
                    td.textContent = row[header] || '';
                    trBody.appendChild(td);
                    rowData.push(row[header]);
                });
                tbody.appendChild(trBody);
                dataJsonUpload.push(rowData);
            });

            table.appendChild(thead);
            table.appendChild(tbody);
            output.appendChild(table);

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
                    $('#dataTableUpload').DataTable();
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.close();
                    const tahun = document.getElementsByName('id')[0].value;

                    if (tahun === "" || tahun === undefined || dataJsonUpload === undefined) {
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
                        title: 'Apakah anda yakin ingin mengupload data tagihan ini?',
                        text: `Upload Data Tagihan Untuk :  ${dataJsonUpload.length} Pegawai`,
                        showCancelButton: true,
                        icon: 'question',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Upload Data Tagihan!'
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: './savetagihanupload',
                                // url: $(this).attr('action'),
                                type: 'POST',
                                data: {
                                    data: jsonData,
                                    tahun: tahun,
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
                                            Swal.showLoading();
                                        }
                                    });
                                },
                                complete: function() {
                                    Swal.close();
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
                                            reloadPage("<?= base_url('sigaji/bank/tagihan/antrian/datadetail?d=' . $tahun) ?>");
                                        })
                                    } else {
                                        $('.output_upload').html("");
                                        const _inputFile = document.getElementsByName('_file')[0];
                                        _inputFile.value = "";
                                        dataJsonUpload = [];
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
                                    dataJsonUpload = [];
                                    $('.content-uploadModal').modal('hide');
                                    Swal.fire(
                                        'Failed!',
                                        "gagal mengambil data (" + xhr.status.toString + ")",
                                        'warning'
                                    );
                                }

                            });




                        }
                    });
                } else {
                    $('.output_upload').html("");
                    const _inputFile = document.getElementsByName('_file')[0];
                    _inputFile.value = "";
                    dataJsonUpload = [];
                    Swal.close();
                    $('.content-uploadModal').modal('hide');
                }
            });
        }

        // $('.formUploadModalData').submit(function(e) {
        //     e.preventDefault();



        //     // const jsonData = JSON.stringify(formData);

        // })
    </script>



    <!-- <script>
        function loadFile() {
            const input = document.getElementsByName('_file')[0];
            if (input.files && input.files[0]) {
                var file = input.files[0];

                var mime_types = ['application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel', 'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel', 'application/xls', 'application/x-xls', 'application/excel', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

                if (mime_types.indexOf(file.type) == -1) {
                    input.value = "";
                    Swal.fire(
                        'Warning!!!',
                        "Hanya file type xls dan xlsx yang diizinkan.",
                        'warning'
                    );
                    return false;
                }

                if (file.size > 5 * 1024 * 1000) {
                    input.value = "";
                    Swal.fire(
                        'Warning!!!',
                        "Ukuran file tidak boleh lebih dari 5 Mb.",
                        'warning'
                    );
                    return false;
                }
            } else {
                console.log("failed Load");
            }
        }

        $("#formAddModalData").on("submit", function(e) {
            e.preventDefault();
            const id = document.getElementsByName('id')[0].value;
            const fileName = document.getElementsByName('_file')[0].value;

            const formUpload = new FormData();
            if (fileName !== "") {
                const file = document.getElementsByName('_file')[0].files[0];
                formUpload.append('_file', file);
            }
            formUpload.append('tahun', id);

            $.ajax({
                xhr: function() {
                    let xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            ambilId("loaded_n_total").innerHTML = "Uploaded " + evt.loaded + " bytes of " + evt.total;
                            var percent = (evt.loaded / evt.total) * 100;
                            ambilId("progressBar").value = Math.round(percent);
                            // ambilId("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
                        }
                    }, false);
                    return xhr;
                },
                url: "./uploadSave",
                type: 'POST',
                data: formUpload,
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                beforeSend: function() {
                    ambilId("progressBar").style.display = "block";
                    // ambilId("status").innerHTML = "Mulai mengupload . . .";
                    ambilId("status").style.color = "blue";
                    ambilId("progressBar").value = 0;
                    ambilId("loaded_n_total").innerHTML = "";
                    $('div.modal-content-loading').block({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                    });
                },
                success: function(resul) {
                    $('div.modal-content-loading').unblock();

                    if (resul.status !== 200) {
                        // ambilId("status").innerHTML = "gagal";
                        ambilId("status").style.color = "red";
                        ambilId("progressBar").value = 0;
                        ambilId("loaded_n_total").innerHTML = "";
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
                        ambilId("status").innerHTML = resul.message;
                        ambilId("status").style.color = "green";
                        ambilId("progressBar").value = 100;
                        Swal.fire(
                            'SELAMAT!',
                            resul.message,
                            'success'
                        ).then((valRes) => {
                            reloadPage();
                        })

                        // $('.contentBodyModal').html(resul.data);
                    }
                },
                error: function(erro) {
                    console.log(erro);
                    // ambilId("status").innerHTML = "Upload Failed";
                    ambilId("status").style.color = "red";
                    $('div.modal-content-loading').unblock();
                    Swal.fire(
                        'PERINGATAN!',
                        "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                        'warning'
                    );
                }
            });
        });
    </script> -->

<?php } ?>