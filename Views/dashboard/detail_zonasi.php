<div class="modal-body">
    <div class="col-12">
        <div class="table-responsive">
            <table id="data-datatables-detail" class="display" style="min-width: 845px">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Provinsi</th>
                        <th>Kabupaten</th>
                        <th>Kecamatan</th>
                        <th>Kelurahan</th>
                        <th>Dusun</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($data)) { ?>
                        <?php if (count($data) > 0) { ?>
                            <?php foreach ($data as $key => $value) { ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $value->nama_provinsi ?></td>
                                    <td><?= $value->nama_kabupaten ?></td>
                                    <td><?= $value->nama_kecamatan ?></td>
                                    <td><?= $value->nama_kelurahan ?></td>
                                    <td><?= getDusunList($value->kelurahan, $value->sekolah_id) ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
</div>
<script>
    $(document).ready(function() {
        let tableDatatables = $('#data-datatables-detail').DataTable({
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            },
            lengthMenu: [
                [10],
                [10]
            ],
            buttons: ["copy", "excel", "pdf"],
            "columnDefs": [{
                "targets": 0,
                "orderable": false,
            }, {
                "targets": 1,
                "orderable": false,
            }, {
                "targets": 2,
                "orderable": false,
            }, {
                "targets": 3,
                "orderable": false,
            }, {
                "targets": 4,
                "orderable": false,
            }, {
                "targets": 5,
                "orderable": false,
            }],
        });
    });
</script>