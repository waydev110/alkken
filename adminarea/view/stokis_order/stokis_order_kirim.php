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
<div class="modal fade bs-example-modal-lg" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-none">
                <h3 class="modal-title">Detail Produk</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Jenis Produk</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody id="detail_produk">

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
                url: "controller/stokis_order/stokis_order_kirim.php",
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
                    dataTable.ajax.reload(); 
                }
                alert(obj.message);
            }
        });
    }

    function approve(id_deposit){
        var status = '1';
        $.ajax({
            url: 'controller/stokis_order/stokis_order_proses.php',
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