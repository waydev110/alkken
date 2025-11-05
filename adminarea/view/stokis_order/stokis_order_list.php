<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$title?></h3>
    </div>
    <div class="box-body">
        <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="dataTable">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tanggal Order</th>
                    <th class="text-center">Stokis</th>
                    <th class="text-center">Stokis Tujuan</th>
                    <th class="text-center">Nominal</th>
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
                url: "controller/stokis_order/stokis_order_list.php",
                type: "post"
            },
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
            url: 'controller/stokis_order/stokis_order_detail.php',
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

    function approve_bayar(id_deposit){
        var status_bayar = '1';
        $.ajax({
            url: 'controller/stokis_order/stokis_order_bayar.php',
            type: 'post',
            data: {id_deposit:id_deposit, status_bayar:status_bayar},
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    dataTable.ajax.reload(); 
                }
                alert(obj.message);
            }
        });
    }

    function reject(id_deposit){
        var status = '2';
        $.ajax({
            url: 'controller/stokis_order/stokis_order_bayar.php',
            type: 'post',
            data: {id_deposit:id_deposit, status:status},
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    dataTable.ajax.reload(); 
                }
                alert(obj.message);
            }
        });
    }
</script>