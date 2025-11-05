<?php
    require_once("../model/classStokisPaket.php");
    require_once("../model/classStokisMember.php");
    require_once("../model/classMember.php");
    require_once("../model/classProduk.php");
    $csp = new classStokisPaket();
    $csm = new classStokisMember();
    $cm = new classMember();
    $cp = new classProduk();
    $stokis_paket = $csp->index();
    $stokis = $csm->index();
    $stokis_tujuan = $csm->index();
    $produk = $cp->index();
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$title?></h3>
        <!-- <a href="?go=<?=$mod_url?>_create" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus-circle"></i>
            Tambah</a> -->
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                <div class="small-box bg-green">
                    <div class="inner text-right">
                        <h4 id="subtotal">Rp0,-</h4>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">Total Nominal</a>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="small-box bg-green">
                    <div class="inner text-right">
                        <h4 id="diskon">Rp0,-</h4>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">Total Diskon</a>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="small-box bg-red">
                    <div class="inner text-right">
                        <h4 id="nominal">Rp0,-</h4>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">Total Order</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1">
                <label for="" class="control-label">Show</label>
                <select name="custom_length" id="custom_length" class="form-control">
                    <option value='10' selected='selected'>10</option>
                    <option value='20'>20</option>
                    <option value='50'>50</option>
                    <option value='100'>100</option>
                    <option value='-1'>All</option>
                </select>
            </div>
            <div class="col-sm-2">
                <label for="" class="control-label">Bulan</label>
                <select name="bulan" id="bulan" class="form-control">
                    <option value='' selected='selected'>Semua Bulan</option>
                    <?php 
                    $star_date = date('Y-m-d', strtotime('2023-01-01'));
                    $tanggal = date('Y-m-d');
                    while(strtotime($tanggal) > strtotime($star_date)){
                    ?>
                    <option value="<?=date('Y-m', strtotime($tanggal))?>"><?=bulan_tahun($tanggal)?></option>
                    <?php
                    $tanggal = date('Y-m-d', strtotime("-1 month", strtotime($tanggal)));
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-2">
                <label for="" class="control-label">Stokis</label>
                <select name="id_stokis" id="id_stokis" class="form-control select2">
                    <option value='' selected='selected'>Semua Stokis</option>
                    <?php 
                        while ($option = $stokis->fetch_object()) {
                        echo '<option value="'.$option->id.'">'.$option->nama_stokis .' ('.$option->id_stokis.')</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-2">
                <label for="" class="control-label">Stokis Tujuan</label>
                <select name="id_stokis_tujuan" id="id_stokis_tujuan" class="form-control select2">
                    <option value='' selected='selected'>Semua Stokis</option>
                    <?php 
                        while ($option = $stokis_tujuan->fetch_object()) {
                        echo '<option value="'.$option->id.'">'.$option->nama_stokis .' ('.$option->id_stokis.')</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-2">
                <label for="" class="control-label">Produk</label>
                <select name="id_produk" id="id_produk" class="form-control select2">
                    <option value='' selected='selected'>Semua Produk</option>
                    <?php 
                        while ($option = $produk->fetch_object()) {
                            echo '<option value="'.$option->id.'">'.$option->nama_produk.'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="col-sm-3">
                <label for="" class="control-label">Pencarian</label>
                <div class="input-group" id="btn-group">
                    <input type="text" class="form-control" id="keyword" name="keyword">
                    <dinv class="input-group-btn">
                        <button type="button" class="btn btn-primary" id="btnFilter">
                            <i class="fa fa-search"></i></button>
                        <button type="reset" class="btn btn-primary" id="btnReset"><i class="fa fa-history"></i></button>
                    </dinv>
                </div>
            </div>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="dataTable">
            <thead>
                <tr>
                    <th class="text-center">ID Order</th>
                    <th class="text-center">Tanggal Order</th>
                    <th class="text-center">Stokis</th>
                    <th class="text-center">Stokis Tujuan</th>
                    <th class="text-center">Nominal</th>
                    <th class="text-center">Diskon</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Tanggal Proses</th>
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
            sDom: "<<'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
            AutoWidth: true,
            processing: true,
            serverSide: true,
            order: [[2, 'desc']],
            ajax: {
                url: "controller/stokis_order/stokis_order_riwayat.php",
                type: "post",
                data: function (d) {
                    d.bulan = $('#bulan').val();
                    d.id_stokis = $('#id_stokis').val();
                    d.id_stokis_tujuan = $('#id_stokis_tujuan').val();
                    d.id_produk = $('#id_produk').val();
                    d.keyword = $('#keyword').val();
                },
                complete: function (event, xhr, options) {
                    $('#subtotal').text(event['responseJSON']['subtotal']);
                    $('#diskon').text(event['responseJSON']['diskon']);
                    $('#nominal').text(event['responseJSON']['nominal']);
                },
            },
            columnDefs: [{
                targets: [0,1,-1,-2,-3],
                className: 'text-center'
            },{
                targets: [3,4,5],
                className: 'text-right'
            }]
        });
    });

    $('#keyword').on('keyup', function () {
        dataTable.ajax.reload();
    });

    $('#custom_length').on('change', function () {
        dataTable.page.len($(this).val()).draw();
    });
    $('#btnFilter').click(function () {
        dataTable.ajax.reload();
    });
    $('#btnReset').click(function () {
        $('#bulan').val('');
        $('#id_stokis').val('');
        $('#id_produk').val('');
        $('#keyword').val('');
        dataTable.ajax.reload();
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
                } else {
                    alert(obj.message);
                }
            }
        });
    }

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
    
    function reject(id_deposit){
        var status = '2';
        $.ajax({
            url: 'controller/stokis_order/stokis_order_proses.php',
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