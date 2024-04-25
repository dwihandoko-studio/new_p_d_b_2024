<table id="data-datatables" class="table table-bordered w-100 tb-datatables">
    <thead>
        <tr>
            <th data-orderable="false">#</th>
            <th data-orderable="false" width="20%">Nama</th>
            <th data-orderable="false">NIP</th>
            <th data-orderable="false">Instansi</th>
            <th data-orderable="false">Kecamatan</th>
            <th data-orderable="false">Besar Pinjaman</th>
            <th data-orderable="false">Jumlah Tagihan</th>
            <th data-orderable="false">Jml Bulan<br>Angs</th>
            <th data-orderable="false">Angs Ke</th>
            <th data-orderable="false"> </th>
        </tr>
    </thead>
    <tbody>
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
                        <input class="form-check-input" type="checkbox" id="formCheck1">
                    </td>
                    <td>
                        <select class="form-control filter-pegawai" id="_filter_pegawai" name="_filter_pegawai" required>
                            <option value="">&nbsp;</option>
                        </select>
                        <script>
                            $('#_filter_pegawai').select2({
                                dropdownParent: ".data-contens",
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
                                        // parse the results into the format expected by Select2
                                        // since we are using custom formatting functions we do not need to
                                        // alter the remote JSON data, except to indicate that infinite
                                        // scrolling can be used
                                        // params.page = params.page || 1;
                                        if (data.status === 200) {
                                            return {
                                                results: data.data
                                            };
                                        } else {
                                            return {
                                                results: []
                                            };
                                        }

                                        // return {
                                        //     results: data.items,
                                        //     pagination: {
                                        //         more: (params.page * 30) < data.total_count
                                        //     }
                                        // };
                                    },
                                    cache: true
                                },
                                placeholder: 'Cari Pegawai',
                                minimumInputLength: 3,
                                templateResult: formatRepo,
                                templateSelection: formatRepoSelection
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
                                $container.find(".select2-result-repository__description").text(repo.nip + "\n" + repo.nama_instansi + " ( Kec. " + repo.nama_kecamatan + ")");

                                return $container;
                            }

                            function formatRepoSelection(repo) {
                                return repo.fullname || repo.text;
                            }
                        </script>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="Nip" id="example-text-input">
                    </td>
                    <td>
                        <input class="form-control" type="text" value="instansi" id="example-text-input">
                    </td>
                    <td>
                        <input class="form-control" type="text" value="kecamatan" id="example-text-input">
                    </td>
                    <td>
                        <input class="form-control" type="number" value="1" id="example-text-input">
                    </td>
                    <td>
                        <input class="form-control" type="number" value="1" id="example-text-input">
                    </td>
                    <td>
                        <input class="form-control" type="number" value="1" id="example-text-input">
                    </td>
                    <td>
                        <input class="form-control" type="number" value="1" id="example-text-input">
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light">+</button>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td>
                    <input class="form-check-input" type="checkbox" id="formCheck1">
                </td>
                <td>
                    <select class="form-control filter-pegawai" id="_filter_pegawai" name="_filter_pegawai" required>
                        <option value="">&nbsp;</option>
                    </select>
                    <script>
                        $('#_filter_pegawai').select2({
                            dropdownParent: ".data-contens",
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
                                    // parse the results into the format expected by Select2
                                    // since we are using custom formatting functions we do not need to
                                    // alter the remote JSON data, except to indicate that infinite
                                    // scrolling can be used
                                    // params.page = params.page || 1;
                                    if (data.status === 200) {
                                        return {
                                            results: data.data
                                        };
                                    } else {
                                        return {
                                            results: []
                                        };
                                    }

                                    // return {
                                    //     results: data.items,
                                    //     pagination: {
                                    //         more: (params.page * 30) < data.total_count
                                    //     }
                                    // };
                                },
                                cache: true
                            },
                            placeholder: 'Cari Pegawai',
                            minimumInputLength: 3,
                            templateResult: formatRepo,
                            templateSelection: formatRepoSelection
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
                            return repo.fullname || repo.text;
                        }
                    </script>
                </td>
                <td>
                    <input class="form-control" type="text" value="Nip" id="example-text-input">
                </td>
                <td>
                    <input class="form-control" type="text" value="instansi" id="example-text-input">
                </td>
                <td>
                    <input class="form-control" type="text" value="kecamatan" id="example-text-input">
                </td>
                <td>
                    <input class="form-control" type="number" value="1" id="example-text-input">
                </td>
                <td>
                    <input class="form-control" type="number" value="1" id="example-text-input">
                </td>
                <td>
                    <input class="form-control" type="number" value="1" id="example-text-input">
                </td>
                <td>
                    <input class="form-control" type="number" value="1" id="example-text-input">
                </td>
                <td>
                    <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light">+</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>