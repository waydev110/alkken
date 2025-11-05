<?php
require_once '../model/classStokisDeposit.php';
require_once '../model/classStokisMember.php';
require_once '../model/classProdukJenis.php';
$obj = new classStokisDeposit();
$sm = new classStokisMember();
$cpj = new classProdukJenis();

$stokis_id = $_SESSION['session_stokis_id'];
$stokis = $sm->show($stokis_id);
// $stokis_id_paket = $stokis->id_paket;
$stokis_id_paket = 1;
if($stokis_id_paket > 1) {
    $result_stokis = $sm->show($stokis_id_paket);
}

$produk_jenis = $cpj->index();
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card-customer">
            <div class="row" style="padding-bottom:10px">
                <div class="col-sm-5 col-xs-12">
                    <div class="header-title">
                        <div class="field-title">
                            <h2 class="h2-title" style="margin-top:5px">DEPOSIT ORDER</h2>
                        </div>
                        <input type="hidden" id="id_stokis" value="0">
                    </div>
                </div>
                <div class="col-sm-7 col-xs-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <select class="form-control" style="margin-top:5px" name="jenis_produk" id="jenis_produk">
                                <option value="">Semua Jenis Produk</option>                            
                                <?php
                                while($row = $produk_jenis->fetch_object()){
                                ?>
                                <option value="<?=$row->id?>"><?=$row->name?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <div class="row" style="margin-top:5px">
                                <div class="col-xs-7">
                                    <input type="text" id="keyword" name="keyword" class="form-control" placeholder="Cari Produk">
                                </div>
                                <div class="col-xs-5">
                                    <a href="?go=<?=$mod_url?>" class="btn btn-sm btn-default btn-block btn-rounded">History Order</a>
                                </div>
                            </div>
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
                <h3 class="col-xs-8 card-title">Detail Order
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
                        Buat Order</button>
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
            <div class="modal-body text-center" id="message">
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
                url: 'controller/stokis_deposit/add_cart.php',
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
                    url: 'controller/stokis_deposit/delete_cart.php',
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
                    url: 'controller/stokis_deposit/stokis_deposit_create.php',
                    type: 'post',
                    data: {id_stokis:id_stokis},
                    success: function (result) {
                        const obj = JSON.parse(result);
                        if (obj.status == true) {
                            $('#message').html(obj.message);
                            $('#btnInvoice').attr('href', `?go=stokis_deposit_invoice&id_deposit=${obj.id_deposit}`);
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
    
    $('#jenis_produk').on('change', function(e) {
        get_produk();
    });

    function get_produk() {
        var keyword = $('#keyword').val();
        var jenis_produk = $('#jenis_produk').val();
        $.ajax({
            url: 'controller/produk/get_produk.php',
            type: 'post',
            data: {
                    jenis_produk:jenis_produk,
                    keyword:keyword
                    },
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
                    url: 'controller/stokis_deposit/get_cart.php',
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