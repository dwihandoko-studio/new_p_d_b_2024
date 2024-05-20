<?php if (isset($data)) { ?>
    <form id="formEditModalData" action="./editsavedatatagihan" method="post">
        <input type="hidden" id="_id" name="_id" value="<?= $data->id ?>" />
        <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
            <div class="mb-3">
                <label for="_fullname" class="form-label">NAMA LENGKAP</label>
                <input type="text" class="form-control fullname" value="<?= $data->nama ?>" id="_fullname" name="_fullname" placeholder="Nama Lengkap..." onfocusin="inputFocus(this);" readonly>
                <div class="help-block _fullname"></div>
            </div>
            <div class="mb-3">
                <label for="_nip" class="form-label">NIP</label>
                <input type="text" class="form-control nip" value="<?= $data->nip ?>" id="_nip" name="_nip" placeholder="NIP..." onfocusin="inputFocus(this);" readonly>
                <div class="help-block _nip"></div>
            </div>
            <div class="mb-3">
                <label for="_nama_instansi" class="form-label">Instansi</label>
                <input type="text" class="form-control nama_instansi" value="<?= $data->nama_instansi ?>" id="_nama_instansi" name="_nama_instansi" placeholder="Nama instansi..." onfocusin="inputFocus(this);" readonly>
                <div class="help-block _nama_instansi"></div>
            </div>
            <div class="mb-3">
                <label for="_kecamatan" class="form-label">Kecamatan</label>
                <input type="text" class="form-control kecamatan" value="<?= $data->nama_kecamatan ?>" id="_kecamatan" name="_kecamatan" placeholder="Kecamatan..." onfocusin="inputFocus(this);" readonly>
                <div class="help-block _kecamatan"></div>
            </div>
            <div class="mb-3">
                <label for="_jumlah_pinjaman" class="form-label">Jumlah Pinjaman</label>
                <input type="text" class="form-control jumlah-pinjaman jumlah_pinjaman" value="<?= number_rupiah($data->besar_pinjaman); ?>" id="_jumlah_pinjaman" name="_jumlah_pinjaman" required>
                <div class="help-block _jumlah_pinjaman"></div>
            </div>
            <div class="mb-3">
                <label for="_jumlah_tagihan" class="form-label">Jumlah Tagihan</label>
                <input type="text" class="form-control jumlah-pinjaman jumlah_tagihan" value="<?= number_rupiah($data->jumlah_tagihan); ?>" id="_jumlah_tagihan" name="_jumlah_tagihan" required>
                <div class="help-block _jumlah_tagihan"></div>
            </div>
            <div class="mb-3">
                <label for="_jumlah_bulan_angsuran" class="form-label">Jumlah Bulan Angsuran</label>
                <input type="number" class="form-control jumlah_bulan_angsuran" value="<?= $data->jumlah_bulan_angsuran ?>" id="_jumlah_bulan_angsuran" name="_jumlah_bulan_angsuran" required>
                <div class="help-block _jumlah_bulan_angsuran"></div>
            </div>
            <div class="mb-3">
                <label for="_angsuran_ke" class="form-label">Angsuran Ke</label>
                <input type="number" class="form-control angsuran_ke" value="<?= $data->angsuran_ke ?>" id="_angsuran_ke" name="_angsuran_ke" required>
                <div class="help-block _angsuran_ke"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
        </div>
    </form>

    <script>
        $('.formEditModalData').on('keyup', '.jumlah-pinjaman', function() {
            $(this).val(formatRupiah($(this).val()));
        });

        $("#formEditModalData").on("submit", function(e) {
            e.preventDefault();
            const id = document.getElementsByName('_id')[0].value;
            const fullname = document.getElementsByName('_fullname')[0].value;
            const nip = document.getElementsByName('_nip')[0].value;
            const nama_instansi = document.getElementsByName('_nama_instansi')[0].value;
            const kecamatan = document.getElementsByName('_kecamatan')[0].value;
            const jumlah_pinjaman = document.getElementsByName('_jumlah_pinjaman')[0].value;
            const jumlah_tagihan = document.getElementsByName('_jumlah_tagihan')[0].value;
            const jumlah_bulan_angsuran = document.getElementsByName('_jumlah_bulan_angsuran')[0].value;
            const angsuran_ke = document.getElementsByName('_angsuran_ke')[0].value;

            Swal.fire({
                title: 'Apakah anda yakin ingin mengupdate data ini?',
                text: "Update Data Tagihan Pegawai: <?= $data->nama ?>",
                showCancelButton: true,
                icon: 'question',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Update!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "./editsavedatatagihan",
                        type: 'POST',
                        data: {
                            id: id,
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
                                    'SELAMAT!',
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

<?php } ?>