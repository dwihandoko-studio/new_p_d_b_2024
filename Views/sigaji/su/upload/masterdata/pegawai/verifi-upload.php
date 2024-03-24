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
                                <th rowspan="2">#</th>
                                <th colspan="6">DATA UPLOAD</th>
                                <th colspan="6">DATA DATABASE</th>
                            </tr>
                            <tr>
                                <th>NAMA</th>
                                <th>NIP</th>
                                <th>NIK</th>
                                <th>GOLONGAN</th>
                                <th>MK</th>
                                <th>NO REKENING</th>
                                <th>NAMA</th>
                                <th>NIP</th>
                                <th>NIK</th>
                                <th>GOLONGAN</th>
                                <th>MK</th>
                                <th>NO REKENING</th>
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
        let idFileName;
        let tahun_bulan;

        // fetch("./get_data_json?id=<?= $id ?>")
        //     .then(response => response.json())
        //     .then(data => {
        //         buttonAksiMatching.removeAttribute("disabled");

        //         const result_total = document.getElementById("result_total");
        //         result_total.textContent = data.total.toString();
        //         const result_update = document.getElementById("result_update");
        //         result_update.textContent = data.update.toString();
        //         const result_insert = document.getElementById("result_insert");
        //         result_insert.textContent = data.insert.toString();
        //         const result_sama = document.getElementById("result_sama");
        //         result_sama.textContent = data.sama.toString();

        //         for (let i = 0; i < data.aksi.length; i++) {
        //             const row = document.createElement("tr");
        //             const numberCell = document.createElement("td");

        //             const nipCell = document.createElement("td");
        //             const namaCell = document.createElement("td");
        //             const nikCell = document.createElement("td");
        //             const golonganCell = document.createElement("td");
        //             const mkCell = document.createElement("td");
        //             const noregCell = document.createElement("td");

        //             const nipCellDb = document.createElement("td");
        //             const namaCellDb = document.createElement("td");
        //             const nikCellDb = document.createElement("td");
        //             const golonganCellDb = document.createElement("td");
        //             const mkCellDb = document.createElement("td");
        //             const noregCellDb = document.createElement("td");

        //             numberCell.textContent = 1 + i;

        //             nipCell.textContent = data.aksi[i].nip;
        //             namaCell.textContent = data.aksi[i].nama;
        //             nikCell.textContent = data.aksi[i].nik;
        //             golonganCell.textContent = data.aksi[i].golongan;
        //             mkCell.textContent = data.aksi[i].mk_golongan;
        //             noregCell.textContent = data.aksi[i].no_rekening_bank;

        //             nipCellDb.textContent = data.aksi[i].nip_db;
        //             namaCellDb.textContent = data.aksi[i].nama_db;
        //             nikCellDb.textContent = data.aksi[i].nik_db;
        //             golonganCellDb.textContent = data.aksi[i].golongan_db;
        //             mkCellDb.textContent = data.aksi[i].mk_golongan_db;
        //             noregCellDb.textContent = data.aksi[i].no_rekening_bank_db;

        //             row.appendChild(numberCell);
        //             row.appendChild(nipCell);
        //             row.appendChild(namaCell);
        //             row.appendChild(nikCell);
        //             row.appendChild(golonganCell);
        //             row.appendChild(mkCell);
        //             row.appendChild(noregCell);
        //             row.appendChild(nipCellDb);
        //             row.appendChild(namaCellDb);
        //             row.appendChild(nikCellDb);
        //             row.appendChild(golonganCellDb);
        //             row.appendChild(mkCellDb);
        //             row.appendChild(noregCellDb);
        //             row.classList.add(data.aksi[i].status);
        //             tbody.appendChild(row);
        //         }

        idFileName = '<?= $id ?>';
        tahun_bulan = '<?= $tahun_bulan ?>';
        buttonAksiMatching.removeAttribute("disabled");
        // });

        function aksiMatching() {

            $.ajax({
                url: "./prosesmatching",
                type: 'POST',
                data: {
                    filename: idFileName,
                    tahun_bulan: tahun_bulan,
                },
                dataType: 'JSON',
                beforeSend: function() {
                    $('div.modal-content-loading').block({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                    });
                    buttonAksiMatching.setAttribute("disabled", true);
                },
                success: function(resul) {
                    $('div.modal-content-loading').unblock();
                    if (resul.status !== 200) {

                        Swal.fire(
                            'Failed!',
                            resul.message,
                            'warning'
                        );
                        buttonAksiMatching.removeAttribute("disabled");
                    } else {
                        Swal.fire(
                            'SUKSES!',
                            "Proses Import Data Berhasil Disimpan.",
                            'success'
                        ).then((valRes) => {
                            document.location.href = "<?= base_url('sigaji/su/masterdata/pegawai'); ?>";
                        })
                    }
                },
                error: function() {
                    buttonAksiMatching.removeAttribute("disabled");
                    $('div.modal-content-loading').unblock();
                    Swal.fire(
                        'Failed!',
                        "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                        'warning'
                    );
                }
            });
        }
    </script>
<?php } ?>