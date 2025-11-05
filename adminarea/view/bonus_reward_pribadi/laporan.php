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
        <h3 class="box-title">Laporan Transfer <?=$title?></h3>
        <a href="?go=<?=$mod_url?>_transfer&plan_reward=<?=$_plan_id?>" class="btn btn-primary btn-sm pull-right"><i class="fa fa-paper-plane"></i>
            Transfer Bonus</a>
    </div>
    <div class="box-body">
        <?=vrekap_bonus()?>
        <div class="row mb-4">
            <label for="" class="control-label col-sm-4 text-right align-self-center">Tanggal Transfer</label>
            <div class="col-sm-6">
                <div class="input-group">
                    <input type="date" class="form-control" name="start_date" id="start_date" value="<?=date('Y-m-d')?>">
                    <span class="input-group-addon">s/d</span>
                    <input type="date" class="form-control" name="end_date" id="end_date">
                </div>
            </div>
            <div class="col-sm-2 text-right">
                <div class="input-group">
                    <div class="input-group-btn">
                        <!-- <div class="btn-group" id="btn-group"> -->
                        <button type="button" class="btn btn-primary" id="btnFilter">
                            <i class="fa fa-search"></i>
                            Filter</button>
                        <button type="reset" class="btn btn-primary" id="btnReset">Clear</button>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="dataTable">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">ID <?= $lang['member'] ?></th>
                    <th class="text-center">Nama <?= $lang['member'] ?></th>
                    <th class="text-center">Bank</th>
                    <th class="text-center">Kode</th>
                    <th class="text-center">No Rekening</th>
                    <th class="text-center">Cabang</th>
                    <th class="text-center">Nominal</th>
                    <th class="text-center">Admin</th>
                    <th class="text-center">Jumlah Tranfer</th>
                    <th class="text-center">Tgl Transfer</th>
                    <th class="text-center" width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-none">
                <h3 class="modal-title">Detail Bonus</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="detail">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">Close</span></button>
            </div>
        </div>
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
            order: [[8, 'desc']],
            ajax: {
                url: `controller/${mod_url}/laporan.php`,
                type: "post",
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.id_plan = id_plan
                },
                complete: function (event, xhr, options) {
                    $('#total_bonus').text(event['responseJSON']['total_bonus']);
                    $('#total_admin').text(event['responseJSON']['total_admin']);
                    $('#total_transfer').text(event['responseJSON']['total_transfer']);
                },
            },
            order: [[8, 'desc']],
            columnDefs: [{
                targets: [0,2,3,4,-1,-2],
                className: 'text-center'
            },{
                targets: [-3,-4,-5],
                className: 'text-right'
            }]
        });
        $('#btnFilter').click(function() {
            dataTable.ajax.reload();
        });
        $('#btnReset').click(function() {
            // Mengatur tanggal hari ini
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
            var yyyy = today.getFullYear();

            // Format tanggal menjadi YYYY-MM-DD
            var formattedToday = yyyy + '-' + mm + '-' + dd;
            console.log(formattedToday);
            // Mengatur nilai input
            $('#start_date').val(formattedToday);
            $('#end_date').val(''); // Tetap kosong untuk end_date

            // Reload dataTable
            dataTable.ajax.reload();
        });

    });

    function notif(id_member, tanggal, nominal_bonus, e){
        $.ajax({
            url: `controller/${mod_url}/notif.php`,
            type: 'post',
            data: {
                    id_member:id_member, 
                    tanggal:tanggal, 
                    nominal_bonus:nominal_bonus
                },
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $(e).closest('td').text(obj.message);
                } else {
                    alert(obj.message);
                }
            }
        });
    }
</script>