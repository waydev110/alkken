<?php
require_once '../helper/all.php';
require_once '../model/classStokisTransfer.php';
require_once '../model/classStokisMember.php';
require_once '../model/classProduk.php';
$obj = new classStokisTransfer();
$sm = new classStokisMember();
$cp = new classProduk();
$result_stokis = $sm->index_transfer($_SESSION['session_paket_stokis']-1);
$result_produk = $cp->index();
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card-customer">
            <div class="row">
                <div class="col-sm-7">
                    <div class="header-title">
                        <div class="field-title">
                            <h2 class="h2-title">PILIH STOKIS</h2>
                        </div>
                        <select class="form-control select2" id="id_stokis" name="id_stokis" required="required">
                            <option value="">-- Pilih Stokis --</option>
                            <?php
                            while($row = $result_stokis->fetch_object()){
                            ?>
                            <option value="<?=$row->id?>"><?=$row->nama_stokis?> (<?=$row->id_stokis?>)</option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="header-title" style="justify-content: right;">
                        <div class="header-content-right">
                            <input type="text" id="keyword" name="keyword" class="form-control" placeholder="Cari Produk">
                            <a href="?go=<?=$mod_url?>" class="btn btn-sm btn-default btn-rounded">Riwayat Transfer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row" id="list-produk">
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-detail">
            <div class="row">
                <h3 class="col-xs-8 card-title">Detail Transfer
                    <p class="stokis-title"></p>
                </h3>
                <div class="col-xs-4 text-right">
                    <button class="btn btn-sm btn-default btn-rounded px-4" onclick="clearAll()"> Clear All </button>
                </div>
            </div>
            <form class="form-horizontal" enctype="multipart/form-data"
                action="controller/<?=$mod_url?>/<?=$mod_url?>_create.php" method="post" id="formCreate">
                <div class="card-order">
                    <div class="row" id="item">
                    </div>
                </div>
                <div class="card-summary">
                    <div class="row subtotal">
                        <div class="col-xs-6 fw-bold text-white">
                            <span class="">Subtotal</span>
                        </div>
                        <div class="col-xs-6 fw-bold text-white text-right">
                            <span id="subtotal">Rp0,-</span>
                        </div>
                    </div>
                    <div class="row subtotal">
                        <div class="col-xs-6 fw-bold text-white">
                            <span class="">Diskon</span>
                        </div>
                        <div class="col-xs-6 fw-bold text-white text-right">
                            <span id="diskon">Rp0,-</span>
                        </div>
                    </div>
                    <div class="row total">
                        <div class="col-xs-6 fw-bold text-white price">
                            <span class="">Total</span>
                        </div>
                        <div class="col-xs-6 fw-bold text-white price text-right">
                            <span id="total">Rp0,-</span>
                        </div>
                    </div>
                </div>
                <div class="form-footer">
                    <a href="?go=<?=$mod_url?>" class="btn btn-default btn-rounded"> <i class="fa fa-arrow-left"></i>
                        Batal</a>
                    <button type="button" class="btn btn-primary btn-rounded pull-right" onclick="order()">
                        Transfer Stok</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" id="modalSuccess" tabindex="-1" role="dialog" aria-labelledby="modalSuccessLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-none">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <h3>Transfer Stok berhasil senilai</h3>
                <h1 class="jenis-title bg-success text-bold px-4" id="nominalTitle">Rp.0,-</h1>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">Nanti Saja</span></button>
                <a href="#" id="btnInvoice" class="btn btn-success" target="_blank">Invoice</a>
            </div>
        </div>
    </div>
</div>
<script>
    var modalSuccess = $('#modalSuccess');
    function modalProduk(){
        $('#modalProduk').modal('show');
    }
    function plus(id_produk) {
        var qty = parseInt($('#qty'+id_produk).val())+1;
        if(qty > 0){
            $('#qty'+id_produk).val(qty);
        }
    }
    function minus(id_produk) {
        var qty = parseInt($('#qty'+id_produk).val())-1;
        if(qty > 0){
            $('#qty'+id_produk).val(qty);
        }
    }
    function addToCart(id_produk) {
        var id_stokis = $('#id_stokis').val();
        console.log(id_stokis);
        if(id_stokis == undefined || id_stokis == '') {
            alert('Pilih Stokis terlebih dahulu!');
        } else {
            var qty = parseInt($('#qty'+id_produk).val());
            $.ajax({
                url: 'controller/stokis_transfer/add_cart.php',
                type: 'post',
                data: {id_stokis:id_stokis, id_produk:id_produk, qty:qty},
                success: function (result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        $('#item').html(obj.html);
                        $('#subtotal').text(obj.subtotal);
                        $('#diskon').text(obj.diskon);
                        $('#total').text(obj.total);
                    } else {
                        alert(obj.message);
                    }
                }
            });
        }
    }

    function clearAll() {
        var id_stokis = $('#id_stokis').val();
        if(id_stokis == undefined || id_stokis == '') {
            $('#item').html('');
            $('#total').text('Rp0,-');
        } else {
            if(id_stokis !== undefined && id_stokis !== '') {
                $.ajax({
                    url: 'controller/stokis_transfer/delete_cart.php',
                    type: 'post',
                    data: {id_stokis:id_stokis},
                    success: function (result) {
                        const obj = JSON.parse(result);
                        if (obj.status == true) {
                        $('#item').html(obj.html);
                        $('#subtotal').text(obj.subtotal);
                        $('#diskon').text(obj.diskon);
                        $('#total').text(obj.total);
                        } else {
                            alert(obj.message);
                        }
                    }
                });
            }
        }
    }

    function order() {
        var id_stokis = $('#id_stokis').val();
        if(id_stokis == undefined || id_stokis == '') {
            alert('Pilih Stokis terlebih dahulu!');
        } else {
            if(id_stokis !== undefined && id_stokis !== '') {
                $.ajax({
                    url: 'controller/stokis_transfer/stokis_transfer_create.php',
                    type: 'post',
                    data: {id_stokis:id_stokis},
                    success: function (result) {
                        const obj = JSON.parse(result);
                        if (obj.status == true) {
                            $('#nominalTitle').text(obj.nominal);
                            $('#btnInvoice').attr('href', `?go=stokis_transfer_invoice&id_transfer=${obj.id_transfer}`);
                            modalSuccess.modal('show');
                            $('#item').html('');
                            $('#subtotal').text('Rp0,-');
                            $('#diskon').text('Rp0,-');
                            $('#total').text('Rp0,-');
                            $('.stokis-title').text('');
                        } else {
                            alert(obj.message);
                        }
                    }
                });
            }
        }
    }

    function get_produk() {
        var keyword = $('#keyword').val();
        $.ajax({
            url: 'controller/produk/get_produk_stokis_transfer.php',
            type: 'post',
            data: {keyword:keyword},
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('#list-produk').html(obj.html);
                } else {
                    alert(obj.message);
                }
            }
        });
    }

    $(document).ready(function () {
                            // modalSuccess.modal('show');
        var formCreate = $('#formCreate');
        var btnSubmit = $('#btnSubmit');

        $('body').addClass('sidebar-collapse');
        $('#keyword').on('keyup', function (e) {
            get_produk();
        });
        $('#id_stokis').on('change', function (e) {
            var id_stokis = $('#id_stokis').val();
            if(id_stokis !== undefined && id_stokis !== '') {
                var stokis_text = $('#id_stokis option:selected').text();
                if (id_stokis != '0'){
                    $('.stokis-title').text(`STOKIS : ${stokis_text}`);
                }
                $.ajax({
                    url: 'controller/stokis_transfer/get_cart.php',
                    type: 'post',
                    data: {id_stokis:id_stokis},
                    success: function (result) {
                        const obj = JSON.parse(result);
                        if (obj.status == true) {
                            $('#item').html(obj.html);
                            $('#subtotal').text(obj.subtotal);
                            $('#diskon').text(obj.diskon);
                            $('#total').text(obj.total);
                        } else {
                            alert(obj.message);
                        }
                    }
                });
            }
        });
        $('#id_stokis').trigger('change');        
        get_produk();
    });
</script>