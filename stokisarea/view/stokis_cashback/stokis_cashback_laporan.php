<div class="box box-primary">
    <div class="box-body">
        <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="dataTable">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Nominal</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Tanggal Proses</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    var modalDetail = $('#modalDetail');
    var dataTable;
    $(document).ready(function () {
        dataTable = $("#dataTable").DataTable({
            sDom: "<'row'<'col-sm-6'l> <'col-sm-6'f>><'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
            AutoWidth: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "controller/stokis_cashback/stokis_cashback_laporan.php",
                type: "post"
            },
            columnDefs: [{
                targets: [0,1,-1,-2],
                className: 'text-center'
            },{
                targets: [2],
                className: 'text-right'
            }]
        });
    });
</script>