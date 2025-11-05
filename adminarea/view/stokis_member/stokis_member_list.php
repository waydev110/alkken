<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$title?></h3>
        <a href="?go=<?=$mod_url?>_create" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus-circle"></i>
            Tambah</a>
    </div>
    <div class="box-body">
        <?php 
        if(isset($_GET['stat'])){
            if($_GET['stat']== 1){
        ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Info!</h4>
            <?=ucwords($_GET['msg']);?> sukses
        </div>
        <?php
            }else{
        ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Info!</h4>
            <?=ucwords($_GET['msg']);?> gagal
        </div>
        <?php
            }
        }
      ?>
        <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="dataTable">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">ID Stokis</th>
                    <th class="text-center">Stokis</th>
                    <th class="text-center">Paket Stokis</th>
                    <th class="text-center">Kota</th>
                    <th class="text-center">No Handphone</th>
                    <th class="text-center">Total Deposit</th> 
                    <th class="text-center">Stok</th>
                    <th class="text-center">Auth</th>
                    <th class="text-center">Status</th>
                    <th class="text-center" width="50">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        var dataTable = $("#dataTable").DataTable({
            sDom: "<'row'<'col-sm-6'l> <'col-sm-6'f>><'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
            AutoWidth: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "controller/stokis_member/stokis_member_list.php",
                type: "post"
            },
            columnDefs: [{
                targets: [-1, -2, 0],
                className: 'text-center'
            }
            ,{
                targets: [6,7],
                className: 'text-right text-bold text-danger'
            }
            ]
        });
    });
</script>