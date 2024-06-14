<form id="formGenerateModalData" class="formGenerateModalData" action="./generateSave" method="post">
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="mt-3">
                    <label for="_jenis" class="form-label">Jenis Pengguna: </label>
                    <input type="hidden" id="_jenjang" name="_jenjang" />
                    <select id="_jenis" name="_jenis" class="default-select form-control wide mb-3" onchange="changedVal(this)" required>
                        <option value="">-- Pilih --</option>
                        <?php if (isset($jenjangs)) { ?>
                            <?php if (count($jenjangs) > 0) { ?>
                                <?php foreach ($jenjangs as $key => $value) { ?>
                                    <option value="<?= $value->bentuk_pendidikan_id ?>"><?= $value->bentuk_pendidikan ?></option>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">GENERATE</button>
    </div>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
<script>
    function changedVal(event) {
        const color = $(event).attr('name');
        if (event.value !== "") {
            const selectedIndex = event.selectedIndex;
            const selectedOption = event.options[selectedIndex];
            if (selectedOption) {
                const selectedText = selectedOption.textContent;
                $('#_jenjang').val(selectedText);
            } else {
                $('#_jenjang').val("");
            }
        } else {
            $('#_jenjang').val("");
        }
    }

    $("#formGenerateModalData").on("submit", function(e) {
        e.preventDefault();
        const jenis = document.getElementsByName('_jenis')[0].value;
        const jenjang = document.getElementsByName('_jenjang')[0].value;

        Swal.fire({
            title: 'Apakah anda yakin ingin mengenerate pengguna?',
            text: "Generate pengguna sekolah jenjang pendidikan: " + jenjang,
            showCancelButton: true,
            icon: 'question',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, GENERATE!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "./generateSave",
                    type: 'POST',
                    data: {
                        jenis: jenis,
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Mengenerate data pengguna...',
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
                                resul.data,
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
        })
    });
</script>