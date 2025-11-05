<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$title?></h3>
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
                    <th class="text-center">Nominal</th>
                    <th class="text-center">Dari</th>
                    <th class="text-center">Generasi</th>
                    <th class="text-center">Status</th>
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
                url: "controller/bonus_generasi_ro/bonus_generasi_list.php",
                type: "post",
            },
            order: [[2, 'desc']],
            columnDefs: [{
                targets: [0,1,2,-1,-2,-3,-4],
                className: 'text-center'
            },{
                targets: [4],
                className: 'text-right'
            }]
        });
    });
</script>