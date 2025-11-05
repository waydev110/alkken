<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$title?></h3>
        <!-- <a href="?go=<?=$mod_url?>_create" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus-circle"></i>
            Tambah</a> -->
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
                    <th class="text-center">ID Order</th>
                    <th class="text-center">Tanggal Order</th>
                    <th class="text-center">Stokis</th>
                    <th class="text-center">Nominal</th>
                    <th class="text-center">Status Bayar</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Tanggal Proses</th>
                    <th class="text-center">Produk</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<?php include '../helper/detail_produk.php' ?>
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
                url: "controller/stokis_deposit/stokis_deposit_list.php",
                type: "post"
            },
            order:[[1, 'desc']],
            columnDefs: [{
                targets: [0,1,2,4,5,-1,-2,-3],
                className: 'text-center'
            },{
                targets: [3],
                className: 'text-right'
            }]
        });
    });

    function detail_produk(id_deposit){
        $.ajax({
            url: 'controller/stokis_deposit/stokis_deposit_detail.php',
            type: 'post',
            data: {id_deposit:id_deposit },
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('#detail_produk').html(obj.html);
                    modalDetail.modal('show');
                } else {
                    alert(obj.message);
                }
            }
        });
    }

    function approve(id_deposit){
        var status = '1';
        $.ajax({
            url: 'controller/stokis_deposit/stokis_deposit_proses.php',
            type: 'post',
            data: {id_deposit:id_deposit, status:status},
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    dataTable.ajax.reload(); 
                } else {
                    alert(obj.message);
                }
            }
        });
    }

    function approve_bayar(id_deposit){
        var status_bayar = '1';
        $.ajax({
            url: 'controller/stokis_deposit/stokis_deposit_bayar.php',
            type: 'post',
            data: {id_deposit:id_deposit, status_bayar:status_bayar},
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    dataTable.ajax.reload(); 
                } else {
                    alert(obj.message);
                }
            }
        });
    }

    function reject(id_deposit){
        var status = '2';
        $.ajax({
            url: 'controller/stokis_deposit/stokis_deposit_proses.php',
            type: 'post',
            data: {id_deposit:id_deposit, status:status},
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    dataTable.ajax.reload(); 
                } else {
                    alert(obj.message);
                }
            }
        });
    }
</script>