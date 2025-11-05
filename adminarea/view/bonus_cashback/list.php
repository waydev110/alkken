<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Daftar <?=$title?></h3>
        <a href="?go=<?=$mod_url?>_transfer" class="btn btn-primary btn-sm pull-right"><i class="fas fa-paper-plane"></i>
            Transfer Bonus</a>
    </div>
    <div class="box-body">
        <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="dataTable">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">ID <?=$lang['member']?></th>
                    <th class="text-center">Nama <?=$lang['member']?></th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Nominal</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    var mod_url = '<?=$mod_url?>';
    var modalDetail = $('#modalDetail');
    var dataTable;
    $(document).ready(function () {
        dataTable = $("#dataTable").DataTable({
            sDom: "<'row'<'col-sm-6'l><'col-sm-6'<'d-flex justify-content-end'fB>>><'table-responsive't><'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                {
                    extend: 'copyHtml5',
                    exportOptions: { orthogonal: 'export' }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: { orthogonal: 'export' }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: { orthogonal: 'export' }
                }
            ],
            aLengthMenu: [
                [10,25, 50, 100, 200, -1],
                [10,25, 50, 100, 200, "All"]
            ],
            iDisplayLength: 10,
            AutoWidth: true,
            processing: true,
            serverSide: true,
            order: [[1, 'desc']],
            ajax: {
                url: `controller/${mod_url}/list.php`,
                type: "post",
            },
            columnDefs: [{
                targets: [0,1,2,4,-1],
                className: 'text-center'
            },{
                targets: [5],
                className: 'text-right'
            }]
        });
    });
</script>