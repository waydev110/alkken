<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$title?></h3>
        <a href="?go=<?=$mod_url?>_transfer" class="btn btn-primary btn-sm pull-right"><i class="fas fa-paper-plane"></i>
            Transfer Bonus</a>
        <a href="?go=<?=$mod_url?>_approved" class="btn btn-primary btn-sm pull-right"><i class="fas fa-paper-plane"></i>
            Riwayat Approve</a>
    </div>
    <div class="box-body">
        <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="dataTable">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">ID <?=$lang['member']?></th>
                    <th class="text-center">Nama <?=$lang['member']?></th>
                    <th class="text-center">Jenis Reward</th>
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
    var modalDetail = $('#modalDetail');
    var dataTable;
    $(document).ready(function () {
        dataTable = $("#dataTable").DataTable({
            sDom: "<'row'<'col-sm-6'l> <'col-sm-6'f>><'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
            AutoWidth: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "controller/bonus_reward/bonus_reward_list.php",
                type: "post",
            },
            columnDefs: [{
                targets: [0,1,2,-1],
                className: 'text-center'
            },{
                targets: [-2],
                className: 'text-right'
            }]
        });
    });

    function approve(id, id_member, tanggal, nominal_bonus, reward, jenis, e){
        $.ajax({
            url: 'controller/bonus_reward/bonus_reward_approve.php',
            type: 'post',
            data: {
                    id:id, 
                    id_member:id_member, 
                    tanggal:tanggal, 
                    nominal_bonus:nominal_bonus, 
                    jenis:jenis, 
                    reward:reward, 
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