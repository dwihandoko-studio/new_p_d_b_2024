<table id="data-datatables" class="table table-bordered w-100 tb-datatables">
    <thead>
        <tr>
            <th data-orderable="false">#</th>
            <th data-orderable="false" width="20%">Nama</th>
            <th data-orderable="false" width="14.5%">NIP</th>
            <th data-orderable="false">Instansi</th>
            <th data-orderable="false">Kecamatan</th>
            <th data-orderable="false" width="11%">Besar Pinjaman</th>
            <th data-orderable="false" width="10%">Jumlah Tagihan</th>
            <th data-orderable="false" width="7.5%">Jml Bulan<br>Angs</th>
            <th data-orderable="false" width="7%">Angs Ke</th>
            <th data-orderable="false"> </th>
        </tr>
    </thead>
    <tbody class="formtambah">
        <?php if (isset($datas)) { ?>
            <?php if (count($datas) > 0) { ?>
                <?php foreach ($variable as $key => $value) { ?>
                    <?php if ($key < 1) { ?>

                    <?php } else { ?>

                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td>
                        <input class="form-check-input" type="checkbox" id="formCheck_1" name="check[]" value="">
                    </td>
                    <td>
                        <select class="form-control filter-pegawai" id="_filter_pegawai_1" name="_filter_pegawai[]" data-id="1" onchange="changePegawai(this)" required>
                            <option value="">&nbsp;</option>
                        </select>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="" id="nip_1" name="nip[]" readonly>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="" id="instansi_1" name="instansi[]" readonly>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="" id="kecamatan_1" name="kecamatan[]" readonly>
                    </td>
                    <td>
                        <input class="form-control jumlah-pinjaman" type="text" value="" id="jumlah_pinjaman_1" name="jumlah_pinjaman[]" required>
                    </td>
                    <td>
                        <input class="form-control jumlah-pinjaman" type="text" value="" id="jumlah_tagihan_1" name="jumlah_tagihan[]" required>
                    </td>
                    <td>
                        <input class="form-control" type="number" value="" id="jumlah_bulan_angsuran_1" name="jumlah_bulan_angsuran[]" required>
                    </td>
                    <td>
                        <input class="form-control" type="number" value="" id="angsuran_ke_1" name="angsuran_ke[]" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light btnaddform">+</button>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td>
                    <input class="form-check-input" type="checkbox" id="formCheck1">
                </td>
                <td>
                    <select class="form-control filter-pegawai" id="_filter_pegawai_1" name="_filter_pegawai[]" data-id="1" onchange="changePegawai(this)" required>
                        <option value="">&nbsp;</option>
                    </select>
                    <script>
                        $('#_filter_pegawai_1').select2({
                            dropdownParent: ".data-contens",
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

                        // function formatRepo(repo) {
                        //     if (repo.loading) {
                        //         return repo.text;
                        //     }

                        //     var $container = $(
                        //         "<div class='select2-result-repository clearfix'>" +
                        //         "<div class='select2-result-repository__meta'>" +
                        //         "<div class='select2-result-repository__title'></div>" +
                        //         "<div class='select2-result-repository__description'></div>" +
                        //         "</div>" +
                        //         "</div>"
                        //     );

                        //     $container.find(".select2-result-repository__title").text(repo.nama);
                        //     $container.find(".select2-result-repository__description").text(repo.nip + " - " + repo.nama_instansi + " ( Kec. " + repo.nama_kecamatan + ")");

                        //     return $container;
                        // }

                        // function formatRepoSelection(repo) {
                        //     $(repo.element).attr('data-custom-nip', repo.nip);
                        //     $(repo.element).attr('data-custom-instansi', repo.nama_instansi);
                        //     $(repo.element).attr('data-custom-kecamatan', repo.nama_kecamatan);
                        //     return repo.nama || repo.text;
                        // }
                    </script>
                </td>
                <td>
                    <input class="form-control" type="text" value="" id="nip_1" name="nip[]" readonly>
                </td>
                <td>
                    <input class="form-control" type="text" value="" id="instansi_1" name="instansi[]" readonly>
                </td>
                <td>
                    <input class="form-control" type="text" value="" id="kecamatan_1" name="kecamatan[]" readonly>
                </td>
                <td>
                    <input class="form-control" type="text" value="" onchange="aksiChangeInput(this)" id="jumlah_pinjaman_1" name="jumlah_pinjaman[]" required>
                    <script>
                        let jumlah_pinjaman_1 = document.getElementById('jumlah_pinjaman_1');
                        jumlah_pinjaman_1.addEventListener('keyup', function(e) {
                            jumlah_pinjaman_1.value = formatRupiah(this.value);
                        });
                    </script>
                </td>
                <td>
                    <input class="form-control" type="text" value="" id="jumlah_tagihan_1" name="jumlah_tagihan[]" required>
                </td>
                <td>
                    <input class="form-control" type="text" value="" id="jumlah_bulan_angsuran_1" name="jumlah_bulan_angsuran[]" required>
                </td>
                <td>
                    <input class="form-control" type="text" value="" id="angsuran_ke_1" name="angsuran_ke[]" required>
                </td>
                <td>
                    <button type="button" onclick="aksiTambah(this)" class="btn btn-primary btn-rounded waves-effect waves-light">+</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    // Function untuk mengubah data pegawai saat dipilih
    function changePegawai(event) {
        const getId = $(event).data('id');
        const selectedOption = $('#_filter_pegawai_' + getId).find(':selected');

        $('#formCheck_' + getId).val(selectedOption.data('custom-idpegawai'));
        $('#nip_' + getId).val(selectedOption.data('custom-nip'));
        $('#instansi_' + getId).val(selectedOption.data('custom-instansi'));
        $('#kecamatan_' + getId).val(selectedOption.data('custom-kecamatan'));
    }

    // Function untuk memformat angka menjadi Rupiah
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        // rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        // return 'Rp. ' + rupiah;
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
    }

    let rowBody = 1;

    $(document).ready(function() {
        $('#_filter_pegawai_' + rowBody).select2({
            dropdownParent: ".data-contens",
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
        // Tambahkan event handler untuk tombol tambah baris
        $('.btnaddform').click(function(e) {
            e.preventDefault();
            rowBody++;

            // Tambahkan baris baru ke dalam tabel
            let newRow = `
                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" id="formCheck_${rowBody}" name="check[]" value="">
                        </td>
                        <td>
                            <select class="form-control filter-pegawai" id="_filter_pegawai_${rowBody}" name="_filter_pegawai[]" data-id="${rowBody}" onchange="changePegawai(this)" required>
                                <option value="">&nbsp;</option>
                            </select>
                        </td>
                        <td>
                            <input class="form-control" type="text" value="" id="nip_${rowBody}" name="nip[]" readonly>
                        </td>
                        <td>
                            <input class="form-control" type="text" value="" id="instansi_${rowBody}" name="instansi[]" readonly>
                        </td>
                        <td>
                            <input class="form-control" type="text" value="" id="kecamatan_${rowBody}" name="kecamatan[]" readonly>
                        </td>
                        <td>
                            <input class="form-control jumlah-pinjaman" type="text" value="" id="jumlah_pinjaman_${rowBody}" name="jumlah_pinjaman[]" required>
                        </td>
                        <td>
                            <input class="form-control  jumlah-pinjaman" type="text" value="" id="jumlah_tagihan_${rowBody}" name="jumlah_tagihan[]" required>
                        </td>
                        <td>
                            <input class="form-control" type="number" value="" id="jumlah_bulan_angsuran_${rowBody}" name="jumlah_bulan_angsuran[]" required>
                        </td>
                        <td>
                            <input class="form-control" type="number" value="" id="angsuran_ke_${rowBody}" name="angsuran_ke[]" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-rounded waves-effect waves-light btnhapusform"><i class="bx bxs-trash"></i></button>
                        </td>
                    </tr>`;

            // Tambahkan baris baru ke tabel
            $('.formtambah').append(newRow);

            // Inisialisasi Select2 pada elemen terbaru
            $('#_filter_pegawai_' + rowBody).select2({
                dropdownParent: ".data-contens",
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
        });

        // Event delegation untuk memformat input jumlah pinjaman
        $('.formtambah').on('keyup', '.jumlah-pinjaman', function() {
            $(this).val(formatRupiah($(this).val()));
        });
    });

    $(document).on('click', '.btnhapusform', function(e) {
        e.preventDefault();
        $(this).parents('tr').remove();
    });

    function formatRepo(repo) {
        if (repo.loading) {
            return repo.text;
        }

        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'></div>" +
            "<div class='select2-result-repository__description'></div>" +
            "</div>" +
            "</div>"
        );

        $container.find(".select2-result-repository__title").text(repo.nama);
        $container.find(".select2-result-repository__description").text(repo.nip + " - " + repo.nama_instansi + " ( Kec. " + repo.nama_kecamatan + ")");

        return $container;
    }

    function formatRepoSelection(repo) {
        $(repo.element).attr('data-custom-idpegawai', repo.id);
        $(repo.element).attr('data-custom-nip', repo.nip);
        $(repo.element).attr('data-custom-instansi', repo.nama_instansi);
        $(repo.element).attr('data-custom-kecamatan', repo.nama_kecamatan);
        return repo.nama || repo.text;
    }
</script>

<!-- <script>
    function changePegawai(event) {
        const getId = $(event).data('id');
        const getNip = $('#_filter_pegawai_' + getId).find(':selected').data('custom-nip');
        const getInstansi = $('#_filter_pegawai_' + getId).find(':selected').data('custom-instansi');
        const getKecamatan = $('#_filter_pegawai_' + getId).find(':selected').data('custom-kecamatan');

        $('#nip_' + getId).val(getNip);
        $('#instansi_' + getId).val(getInstansi);
        $('#kecamatan_' + getId).val(getKecamatan);
    }

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    let rowBody = 1;

    $(document).ready(function(e) {
                $('.btnaddform').click(function(e) {
                            rowBody++;
                            e.preventDefault();
                            $('.formtambah').append(`
            <tr>
                    <td>
                        <input class="form-check-input" type="checkbox" id="formCheck1">
                    </td>
                    <td>
                        <select class="form-control filter-pegawai" id="_filter_pegawai_` + rowBody + `" name="_filter_pegawai[]" data-id="` + rowBody + `" onchange="changePegawai(this)" required>
                            <option value="">&nbsp;</option>
                        </select>
                        <script>
                            $('#_filter_pegawai_` + rowBody + `').select2({
                                dropdownParent: ".data-contens",
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
</td>
<td>
    <input class="form-control" type="text" value="" id="nip_` + rowBody + `" name="nip[]" readonly />
</td>
<td>
    <input class="form-control" type="text" value="" id="instansi_` + rowBody + `" name="instansi[]" readonly />
</td>
<td>
    <input class="form-control" type="text" value="" id="kecamatan_` + rowBody + `" name="kecamatan[]" readonly />
</td>
<td>
    <input class="form-control" type="text" value="" onchange="aksiChangeInput(this)" id="jumlah_pinjaman_` + rowBody + `" name="jumlah_pinjaman[]" required />
    <script>
        let jumlah_pinjaman_` + rowBody + ` = document.getElementById('jumlah_pinjaman_` + rowBody + `');
        jumlah_pinjaman_` + rowBody + `.addEventListener('keyup', function(e) {
            jumlah_pinjaman_` + rowBody + `.value = formatRupiah(this.value);
        });
    </script>
</td>
<td>
    <input class="form-control" type="text" value="" id="jumlah_tagihan_` + rowBody + `" name="jumlah_tagihan[]" required />
</td>
<td>
    <input class="form-control" type="text" value="" id="jumlah_bulan_angsuran_` + rowBody + `" name="jumlah_bulan_angsuran[]" required />
</td>
<td>
    <input class="form-control" type="text" value="" id="angsuran_ke_` + rowBody + `" name="angsuran_ke[]" required />
</td>
<td>
    <button type="button" onclick="aksiTambah(this)" class="btn btn-primary btn-rounded waves-effect waves-light">+</button>
</td>
</tr>
`);
});
});
</script> -->