<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$title?></h3>
        <a href="?go=<?=$mod_url?>_laporan" class="btn btn-primary btn-sm pull-right"><i class="fa fa-history"></i>
            Riwayat Transfer</a>
    </div>
    <div class="box-body">
        <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="dataTable">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center"><?=$lang['member']?></th>
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
<script>
    var dataTable;
    $(document).ready(function () {
        dataTable = $("#dataTable").DataTable({
            sDom: "<'row'<'col-sm-6'l> <'col-sm-6'f>><'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
            AutoWidth: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "controller/bonus_support/transfer.php",
                type: "post"
            },
            columnDefs: [{
                targets: [0,2,3,4,-1,-2],
                className: 'text-center'
            },{
                targets: [-3,-4,-5],
                className: 'text-right'
            }]
        });
    });

    function transfer(id_member, tanggal, nominal_bonus, e){
        $.ajax({
            url: 'controller/bonus_support/proses.php',
            type: 'post',
            data: {
                    id_member:id_member, 
                    tanggal:tanggal, 
                    nominal_bonus:nominal_bonus, 
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