<?php
if(!isset($_GET['plan_reward'])){
    echo 'Terjadi Kesalahan Parameter';
    exit();
}
$_plan_id = $_GET['plan_reward'];
require_once '../model/classProdukJenis.php';
$cpl = new classProdukJenis();
$_plan_reward = $cpl->show($_plan_id);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Daftar <?=$title?> <?=$_plan_reward->nama_reward?></h3>
        <a href="?go=<?=$mod_url?>_transfer&plan_reward=<?=$_plan_id?>" class="btn btn-primary btn-sm pull-right"><i class="fas fa-paper-plane"></i>
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
                    <th class="text-center">Reward</th>
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
    var id_plan = '<?=$_plan_id?>';
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
                data:function(d){
                    d.id_plan = id_plan
                }
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