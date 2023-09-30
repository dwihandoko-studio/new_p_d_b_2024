<form id="formAddModalData" action="./addSave" method="post" enctype="multipart/form-data">
    <div class="modal-body loading-get-data">
        <div class="row">
            <div class="col-lg-6">
                <label for="_tahun" class="col-form-label">Tahun:</label>
                <input type="number" class="form-control tahun" id="_tahun" name="_tahun" placeholder="Tahun..." onfocusin="inputFocus(this);" required />
                <div class="help-block _tahun"></div>
            </div>
            <div class="col-lg-6">
                <label for="_tw" class="col-form-label">TW:</label>
                <input type="number" class="form-control nip" id="_tw" name="_tw" placeholder="TW..." onfocusin="inputFocus(this);" required />
                <div class="help-block _tw"></div>
            </div>
            <div class="col-lg-6">
                <label for="_semester" class="col-form-label">Semester:</label>
                <input type="number" class="form-control email" id="_semester" name="_semester" placeholder="Semester..." onfocusin="inputFocus(this);" required />
                <div class="help-block _semester"></div>
            </div>
            <div class="col-lg-12 text-end">
                <h5 class="font-size-14 mb-3">Status Aktif</h5>
                <div>
                    <input type="checkbox" id="status_active" name="status_active" switch="success" checked />
                    <label for="status_active" data-on-label="Yes" data-off-label="No"></label>
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
        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
    </div>
</form>

<script>
    $("#formAddModalData").on("submit", function(e) {
        e.preventDefault();
        const tahun = document.getElementsByName('_tahun')[0].value;
        const tw = document.getElementsByName('_tw')[0].value;
        const semester = document.getElementsByName('_semester')[0].value;

        let status;
        if ($('#status_active').is(":checked")) {
            status = "1";
        } else {
            status = "0";
        }

        if (tahun === "") {
            $("input#_tahun").css("color", "#dc3545");
            $("input#_tahun").css("border-color", "#dc3545");
            $('._tahun').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Tahun tidak boleh kosong.</li></ul>');
            return false;
        }

        if (tw.length === "") {
            $("input#_tw").css("color", "#dc3545");
            $("input#_tw").css("border-color", "#dc3545");
            $('._tw').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Tw tidak boleh kosong.</li></ul>');
            return false;
        }

        if (semester === "") {
            $("input#_semester").css("color", "#dc3545");
            $("input#_semester").css("border-color", "#dc3545");
            $('._semester').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Semester tidak boleh kosong. </li></ul>');
            return false;
        }

        const formUpload = new FormData();
        formUpload.append('tahun', tahun);
        formUpload.append('tw', tw);
        formUpload.append('semester', semester);
        formUpload.append('status', status);

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
            url: "./addSave",
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
                    ambilId("status").innerHTML = "";
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
                    ambilId("status").innerHTML = "";
                    ambilId("status").style.color = "green";
                    ambilId("progressBar").value = 100;
                    Swal.fire(
                        'SELAMAT!',
                        resul.message,
                        'success'
                    ).then((valRes) => {
                        reloadPage();
                    })
                }
            },
            error: function(erro) {
                console.log(erro);
                ambilId("status").innerHTML = "";
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
</script>