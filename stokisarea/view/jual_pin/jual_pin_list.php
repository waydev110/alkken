<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$title?></h3>
        <div class="pull-right">
            <a href="?go=<?=$mod_url?>" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> Penjualan</a>
        </div>
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
        <div class="table-responsive">
            <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="dataTable">
                <thead>
                    <tr>
                        <th class="text-center">ID Penjualan</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">ID <?=$lang['member']?></th>
                        <th class="text-center">Nama <?=$lang['member']?></th>
                        <th class="text-center">Paket</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Nominal</th>
                        <th class="text-center">Produk</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include '../helper/detail_produk.php' ?>
<script>
    var modalDetail = $('#modalDetail');
    var dataTable;
    $(document).ready(function () {
        dataTable = $("#dataTable").DataTable({
            // sDom: "<'row'<'col-sm-6'l> <'col-sm-6'f>><'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
            processing: true,
            serverSide: true,
            ajax: {
                url: "controller/jual_pin/jual_pin_list.php",
                type: "post"
            },
            order: [[1, 'desc']],
            columnDefs: [{
                targets: [0, 1, 2, 4, -1],
                // targets: [0,1,-1,-2,-3],
                className: 'text-center'
            }, {
                targets: [-2,-3,-4],
                className: 'text-right'
            }]
        });
    });

    function detail_produk(id_jual_pin) {
        $.ajax({
            url: 'controller/jual_pin/jual_pin_detail.php',
            type: 'post',
            data: {
                id_jual_pin: id_jual_pin
            },
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

function daftar_pin(id_jual_pin) {
    $.ajax({
        url: 'controller/jual_pin/daftar_pin.php',
        type: 'post',
        data: {
            id_jual_pin: id_jual_pin
        },
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
</script>