<form id="formAddModalData" class="formAddModalData" action="./addsavedatatagihan" method="post">
    <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
        <div class="mb-3">
            <label for="_fullname_add" class="col-form-label">NAMA LENGKAP</label>
            <select width="100%" class="form-control filter-fullname" id="_fullname_add" name="_fullname_add" data-id="1" onchange="changePegawaiAddNew(this)" required>
                <option value="">&nbsp;</option>
            </select>
            <script>
                $('#_fullname_add').select2({
                    dropdownParent: ".formAddModalData",
                    allowClear: true,
                    ajax: {
                        url: "./getPegawai",
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
                    placeholder: 'Cari Pegawai',
                    minimumInputLength: 3,
                    templateResult: formatRepo,
                    templateSelection: formatRepoSelection
                });
            </script>
            <div class="help-block _fullname_add"></div>
        </div>
        <div class="mb-3">
            <label for="_nip_add" class="form-label">NIP</label>
            <input type="text" class="form-control nip_add" id="_nip_add" name="_nip_add" placeholder="NIP..." onfocusin="inputFocus(this);" readonly>
            <div class="help-block _nip_add"></div>
        </div>
        <div class="mb-3">
            <label for="_nama_instansi_add" class="form-label">Instansi</label>
            <input type="text" class="form-control nama_instansi_add" id="_nama_instansi_add" name="_nama_instansi_add" placeholder="Nama instansi..." onfocusin="inputFocus(this);" readonly>
            <div class="help-block _nama_instansi_add"></div>
        </div>
        <div class="mb-3">
            <label for="_kecamatan_add" class="form-label">Kecamatan</label>
            <input type="text" class="form-control kecamatan_add" id="_kecamatan_add" name="_kecamatan_add" placeholder="Kecamatan..." onfocusin="inputFocus(this);" readonly>
            <div class="help-block _kecamatan_add"></div>
        </div>
        <div class="mb-3">
            <label for="_jumlah_pinjaman_add" class="form-label">Jumlah Pinjaman</label>
            <input type="text" class="form-control jumlah-pinjaman jumlah_pinjaman_add" value="<?= number_rupiah($data->besar_pinjaman); ?>" id="_jumlah_pinjaman_add" name="_jumlah_pinjaman_add" required>
            <div class="help-block _jumlah_pinjaman_add"></div>
        </div>
        <div class="mb-3">
            <label for="_jumlah_tagihan_add" class="form-label">Jumlah Tagihan</label>
            <input type="text" class="form-control jumlah-pinjaman jumlah_tagihan_add" value="<?= number_rupiah($data->jumlah_tagihan); ?>" id="_jumlah_tagihan_add" name="_jumlah_tagihan_add" required>
            <div class="help-block _jumlah_tagihan_add"></div>
        </div>
        <div class="mb-3">
            <label for="_jumlah_bulan_angsuran_add" class="form-label">Jumlah Bulan Angsuran</label>
            <input type="number" class="form-control jumlah_bulan_angsuran_add" value="<?= $data->jumlah_bulan_angsuran ?>" id="_jumlah_bulan_angsuran_add" name="_jumlah_bulan_angsuran_add" required>
            <div class="help-block _jumlah_bulan_angsuran_add"></div>
        </div>
        <div class="mb-3">
            <label for="_angsuran_ke_add" class="form-label">Angsuran Ke</label>
            <input type="number" class="form-control angsuran_ke_add" value="<?= $data->angsuran_ke ?>" id="_angsuran_ke_add" name="_angsuran_ke_add" required>
            <div class="help-block _angsuran_ke_add"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary waves-effect waves-light">SIMPAN</button>
    </div>
</form>

<script>
    function changePegawaiAddNew(event) {
        const selectedOption = $('#_fullname_add').find(':selected');

        $('#_nip_add').val(selectedOption.data('custom-nip'));
        $('#_nama_instansi_add').val(selectedOption.data('custom-instansi'));
        $('#_kecamatan_add').val(selectedOption.data('custom-kecamatan'));
    }

    $('.formEditModalData').on('keyup', '.jumlah-pinjaman', function() {
        $(this).val(formatRupiah($(this).val()));
    });

    $("#formEditModalData").on("submit", function(e) {
        e.preventDefault();
        const fullname = document.getElementsByName('_fullname_add')[0].value;
        const nip = document.getElementsByName('_nip_add')[0].value;
        const nama_instansi = document.getElementsByName('_nama_instansi_add')[0].value;
        const kecamatan = document.getElementsByName('_kecamatan_add')[0].value;
        const jumlah_pinjaman = document.getElementsByName('_jumlah_pinjaman_add')[0].value;
        const jumlah_tagihan = document.getElementsByName('_jumlah_tagihan_add')[0].value;
        const jumlah_bulan_angsuran = document.getElementsByName('_jumlah_bulan_angsuran_add')[0].value;
        const angsuran_ke = document.getElementsByName('_angsuran_ke_add')[0].value;

        Swal.fire({
            title: 'Apakah anda yakin ingin menyimpan data ini?',
            text: "Simpan Data Baru Tagihan " + fullname,
            showCancelButton: true,
            icon: 'question',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, SIMPAN!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "./addsavedatatagihan",
                    type: 'POST',
                    data: {
                        tahun: '<?= isset($tw_active) ? $tw_active : '' ?>',
                        fullname: fullname,
                        nip: nip,
                        nama_instansi: nama_instansi,
                        kecamatan: kecamatan,
                        jumlah_pinjaman: jumlah_pinjaman,
                        jumlah_tagihan: jumlah_tagihan,
                        jumlah_bulan_angsuran: jumlah_bulan_angsuran,
                        angsuran_ke: angsuran_ke,
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('div.modal-content-loading').block({
                            message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                        });
                    },
                    complete: function() {
                        $('div.modal-content-loading').unblock();
                    },
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
            }
        })
    });
</script>