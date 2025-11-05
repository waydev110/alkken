<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$title?></h3>
        <a href="?go=<?=$mod_url?>_laporan" class="btn btn-primary btn-sm pull-right"><i class="fa fa-history"></i>
            Riwayat Transfer</a>
    </div>
    <div class="box-body">
        <?=vrekap_bonus()?>
        <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="dataTable">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">ID <?=$lang['member']?></th>
                    <th class="text-center">Nama <?=$lang['member']?></th>
                    <th class="text-center">Bank</th>
                    <th class="text-center">Kode Bank</th>
                    <th class="text-center">No Rekening</th>
                    <th class="text-center">Nominal</th>
                    <th class="text-center">Admin</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Aksi</th>
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
    var modalDetail = $('#modalDetail');
    var dataTable;
    $(document).ready(function () {
        dataTable = $("#dataTable").DataTable({
            sDom: "<'row'<'col-sm-6'l> <'col-sm-6'f>><'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
            AutoWidth: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "controller/bonus_reward/bonus_reward_transfer.php",
                type: "post",
                complete: function (event, xhr, options) {
                    $('#total_bonus').text(event['responseJSON']['total_bonus']);
                    $('#total_admin').text(event['responseJSON']['total_admin']);
                    $('#total_transfer').text(event['responseJSON']['total_transfer']);
                },
            },
            columnDefs: [{
                targets: [0,1,3,4,-1],
                className: 'text-center'
            },{
                targets: [-2,-3,-4],
                className: 'text-right'
            }]
        });
    });

    function transfer(id, id_member, tanggal, nominal_bonus, keterangan, e){
        $.ajax({
            url: 'controller/bonus_reward/bonus_reward_proses.php',
            type: 'post',
            data: {
                    id:id,
                    id_member:id_member, 
                    tanggal:tanggal, 
                    nominal_bonus:nominal_bonus, 
                    keterangan:keterangan 
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