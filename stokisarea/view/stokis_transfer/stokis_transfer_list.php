<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$title?></h3>
        <a href="?go=<?=$mod_url?>_create" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus-circle"></i>
            Transfer Stok</a>
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
                    <th class="text-center">Tanggal Kirim</th>
                    <th class="text-center">Dikirim Ke</th>
                    <th class="text-center">Nominal</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Invoice</th>
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
                url: "controller/stokis_transfer/stokis_transfer_list.php",
                type: "post"
            },
            columnDefs: [{
                targets: [0,1,3,-1,-2,-3,-4],
                className: 'text-center'
            },{
                targets: [3],
                className: 'text-right'
            }]
        });
    });

    function detail_produk(id_transfer){
        $.ajax({
            url: 'controller/stokis_transfer/stokis_transfer_detail.php',
            type: 'post',
            data: {id_transfer:id_transfer },
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

    function reject(id_transfer){
        $.ajax({
            url: 'controller/stokis_transfer/stokis_transfer_proses.php',
            type: 'post',
            data: {id_transfer:id_transfer},
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