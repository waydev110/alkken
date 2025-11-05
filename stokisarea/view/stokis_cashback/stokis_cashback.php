<div class="box box-primary">
    <div class="box-body">
        <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="dataTable">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Nominal</th>
                    <th class="text-center">Status</th>
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
                <h3 class="modal-title">Detail Fee Stokis</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Paket</th>
                            <th>Jenis Paket</th>
                            <th>Fee Stokis</th>
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
                url: "controller/stokis_cashback/stokis_cashback_list.php",
                type: "post"
            },
            columnDefs: [{
                targets: [0,1,-1,-2],
                className: 'text-center'
            },{
                targets: [2],
                className: 'text-right'
            }]
        });
    });

    function detail_produk(id_jual_pin){
        $.ajax({
            url: 'controller/stokis_cashback/stokis_cashback_detail.php',
            type: 'post',
            data: {id_jual_pin:id_jual_pin },
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