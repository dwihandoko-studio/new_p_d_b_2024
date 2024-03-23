<?php if (isset($data)) { ?>
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="row">
                    <div class="col-lg-10 align-self-center">
                        <div class="text-lg-center mt-4 mt-lg-0">
                            <div class="row">
                                <div class="col-3">
                                    <div>
                                        <p class="text-muted text-truncate mb-2">Jumlah Data Pegawai Upload</p>
                                        <h5 class="mb-0 text-info result_total" id="result_total"><i class="mdi mdi-reload mdi-spin"></i></h5>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div>
                                        <p class="text-muted text-truncate mb-2">Jumlah Update</p>
                                        <h5 class="mb-0 text-success result_update" id="result_update"><i class="mdi mdi-reload mdi-spin"></i></h5>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div>
                                        <p class="text-muted text-truncate mb-2">Jumlah Insert</p>
                                        <h5 class="mb-0 text-warning result_insert" id="result_insert"><i class="mdi mdi-reload mdi-spin"></i></h5>

                                    </div>
                                </div>
                                <div class="col-3">
                                    <div>
                                        <p class="text-muted text-truncate mb-2">Jumlah Sama</p>
                                        <h5 class="mb-0 text-primary result_sama" id="result_sama"><i class="mdi mdi-reload mdi-spin"></i></h5>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 d-none d-lg-block">
                        <div class="clearfix mt-4 mt-lg-0">
                            <div class="dropdown float-end">
                                <button class="btn btn-primary button_aksi_matching" id="button_aksi_matching" type="button" onclick="aksiMatching()">
                                    <i class="mdi mdi-relation-zero-or-many-to-zero-or-many align-middle me-1"></i> Proses Data
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 d-none d-lg-block mb-2 mt-2">
                        <div>
                            <progress id="progressBar" value="0" max="100" style="width:100%; display: none;"></progress>
                        </div>
                        <div>
                            <h3 id="status" style="font-size: 12px; margin: 8px auto;"></h3>
                        </div>
                        <div>
                            <p id="loaded_n_total" style="margin-bottom: 0px;"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-bordered border-primary mb-0 modals-datatables-datanya" id="modals-datatables-datanya">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th colspan="5">DATA UPLOAD</th>
                                <th colspan="5">DATA DATABASE</th>
                            </tr>
                            <tr>
                                <th>NAMA</th>
                                <th>NIP</th>
                                <th>NIK</th>
                                <th>GOLONGAN</th>
                                <th>NAMA</th>
                                <th>NIP</th>
                                <th>NIK</th>
                                <th>GOLONGAN</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
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
        <!-- <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button> -->
    </div>
    </form>

    <script>
        const table = document.getElementById("modals-datatables-datanya");
        const tbody = table.getElementsByTagName("tbody")[0];
        const buttonAksiMatching = document.getElementById("button_aksi_matching");
        buttonAksiMatching.setAttribute("disabled", true);

        // let dataSendMatching;

        fetch("./get_data_json?id=<?= $id ?>")
            .then(response => response.json())
            .then(data => {
                // dataSendMatching = data;
                buttonAksiMatching.removeAttribute("disabled");

                const result_total = document.getElementById("result_total");
                result_total.textContent = data.total.toString();
                const result_update = document.getElementById("result_update");
                result_update.textContent = data.update.toString();
                const result_insert = document.getElementById("result_insert");
                result_insert.textContent = data.insert.toString();
                const result_sama = document.getElementById("result_sama");
                result_sama.textContent = data.sama.toString();

                for (let i = 0; i < data.aksi.length; i++) {
                    const row = document.createElement("tr");
                    const numberCell = document.createElement("td");

                    const nipCell = document.createElement("td");
                    const namaCell = document.createElement("td");
                    const nikCell = document.createElement("td");
                    const golonganCell = document.createElement("td");
                    const mkCell = document.createElement("td");

                    const nipCellDb = document.createElement("td");
                    const namaCellDb = document.createElement("td");
                    const nikCellDb = document.createElement("td");
                    const golonganCellDb = document.createElement("td");
                    const mkCellDb = document.createElement("td");

                    numberCell.textContent = 1 + i;

                    nipCell.textContent = data.aksi[i].nip;
                    namaCell.textContent = data.aksi[i].nama;
                    nikCell.textContent = data.aksi[i].nik;
                    golonganCell.textContent = data.aksi[i].golongan;
                    mkCell.textContent = data.aksi[i].golongan;

                    nipCellDb.textContent = data.aksi[i].nip_db;
                    namaCellDb.textContent = data.aksi[i].nama_db;
                    nikCellDb.textContent = data.aksi[i].nik_db;
                    golonganCellDb.textContent = data.aksi[i].golongan_db;
                    mkCellDb.textContent = data.aksi[i].mk_db;

                    row.appendChild(numberCell);
                    row.appendChild(nipCell);
                    row.appendChild(namaCell);
                    row.appendChild(nikCell);
                    row.appendChild(golonganCell);
                    row.appendChild(mkCell);
                    row.appendChild(nipCellDb);
                    row.appendChild(namaCellDb);
                    row.appendChild(nikCellDb);
                    row.appendChild(golonganCellDb);
                    row.classList.add(data.aksi[i].status);
                    tbody.appendChild(row);
                }
            });

        // function aksiMatching() {
        //     buttonAksiMatching.setAttribute("disabled", true);
        //     // console.log(dataSendMatching);
        //     const progBar = document.getElementById("progressBar");

        //     progBar.style.display = "block";

        //     ambilId("status").innerHTML = "Menyimpan Data . . .";

        //     let jumlahDataBerhasil = 0;
        //     let jumlahDataGagal = 0;

        //     let sendToServer = function(lines, index) {
        //         if (index > lines.length - 1) {
        //             ambilId("progressBar").style.display = "none";
        //             ambilId("status").innerHTML = "Proses Matching Berhasil.";
        //             ambilId("status").style.color = "green";
        //             ambilId("progressBar").value = 0;

        //             Swal.fire(
        //                 'SELAMAT!',
        //                 "Proses Matching Data Berhasil.",
        //                 'success'
        //             ).then((valRes) => {
        //                 document.location.href = "<?= base_url('su/masterdata/pegawai'); ?>";
        //             })
        //             return; // guard condition
        //         }

        //         item = lines[index];
        //         let total = ((index + 1) / lines.length) * 100;
        //         total = total.toFixed(2);

        //         $.ajax({
        //             url: "./prosesmatching",
        //             type: 'POST',
        //             data: item,
        //             dataType: 'JSON',
        //             success: function(msg) {
        //                 if (msg.code != 200) {
        //                     ambilId("status").style.color = "blue";
        //                     ambilId("progressBar").value = total;
        //                     ambilId("loaded_n_total").innerHTML = total + '%';
        //                     console.log(msg.message);
        //                     if (index + 1 === lines.length) {
        //                         ambilId("progressBar").style.display = "none";
        //                         ambilId("status").innerHTML = msg.message;
        //                         ambilId("status").style.color = "green";
        //                         ambilId("progressBar").value = 0;

        //                         Swal.fire(
        //                             'SELAMAT!',
        //                             "Proses Matching Data Berhasil.",
        //                             'success'
        //                         ).then((valRes) => {
        //                             document.location.href = "<?= base_url('su/masterdata/pegawai'); ?>";
        //                         })
        //                     }
        //                 } else {
        //                     ambilId("status").style.color = "blue";
        //                     ambilId("progressBar").value = total;
        //                     ambilId("loaded_n_total").innerHTML = total + '%';

        //                     if (index + 1 === lines.length) {
        //                         ambilId("progressBar").style.display = "none";
        //                         ambilId("status").innerHTML = msg.message;
        //                         ambilId("status").style.color = "green";
        //                         ambilId("progressBar").value = 0;

        //                         Swal.fire(
        //                             'SELAMAT!',
        //                             "Proses Matching Data Berhasil.",
        //                             'success'
        //                         ).then((valRes) => {
        //                             document.location.href = "<?= base_url('su/masterdata/pegawai'); ?>";
        //                         })
        //                     }
        //                 }

        //                 setTimeout(
        //                     function() {
        //                         sendToServer(lines, index + 1);
        //                     },
        //                     350 // delay in ms
        //                 );
        //             },
        //             error: function(error) {
        //                 ambilId("progressBar").style.display = "none";
        //                 ambilId("status").innerHTML = msg.message;
        //                 ambilId("status").style.color = "green";
        //                 ambilId("progressBar").value = 0;
        //                 buttonAksiMatching.removeAttribute("disabled");
        //                 Swal.fire(
        //                     'Failed!',
        //                     "Gagal.",
        //                     'warning'
        //                 );
        //             }
        //         });
        //     };

        //     sendToServer(dataSendMatching.aksi, 0);
        // }
    </script>
<?php } ?>