<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$title?></h3>
        <a href="?go=<?=$mod_url?>_transfer" class="btn btn-primary btn-sm pull-right"><i class="fas fa-paper-plane"></i>
            Transfer Bonus</a>
    </div>
    <div class="box-body">
        <?=vrekap_bonus()?>
        <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="dataTable">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">ID <?=$lang['stokis']?></th>
                    <th class="text-center">Nama <?=$lang['stokis']?></th>
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
    var modalDetail = $('#modalDetail');
    var dataTable;
    $(document).ready(function () {
        dataTable = $("#dataTable").DataTable({
            sDom: "<'row'<'col-sm-6'l> <'col-sm-6'f>><'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
            AutoWidth: true,
            processing: true,
            serverSide: true,
            order: [[1, 'desc']],
            ajax: {
                url: "controller/stokis_cashback/list.php",
                type: "post",
                complete: function (event, xhr, options) {
                    $('#total_bonus').text(event['responseJSON']['total_bonus']);
                    $('#total_admin').text(event['responseJSON']['total_admin']);
                    $('#total_transfer').text(event['responseJSON']['total_transfer']);
                },
            },
            columnDefs: [{
                targets: [0,1,2,-1,-2],
                className: 'text-center'
            },{
                targets: [4],
                className: 'text-right'
            }]
        });
    });
</script>