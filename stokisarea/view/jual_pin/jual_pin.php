<?php
require_once '../model/classStokisProduk.php';
$csp = new classStokisProduk();
require_once '../model/classPlan.php';
$cpl = new classPlan();
$plan = $cpl->index();
?>
<div class="row">
    <!-- <div class="col-sm-12">
        <div class="header-content-right">
            <a href="?go=<?= $mod_url ?>_list" class="btn btn-sm btn-default btn-rounded">Riwayat</a>
            <a href="?go=stokis_deposit_create" class="btn btn-sm btn-default btn-rounded">Tambah Produk</a>
        </div>
    </div> -->
    <div class="col-md-8">
        <div class="card-customer">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label class="control-label"><?= $lang['member'] ?></label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="id_member" name="id_member" placeholder="ID <?= $lang['member'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label class="control-label">Nama <?= $lang['member'] ?></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama_member" name="nama_member" placeholder="Nama <?= $lang['member'] ?>" readonly="readonly">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label class="control-label">Paket</label>
                                </div>
                                <div class="col-sm-8">
                                    <select class="form-control" name="id_plan" id="id_plan">

                                        <option value='' selected='selected'></option>
                                        <?php
                                        while ($row = $plan->fetch_object()) {
                                            echo '<option value="' . $row->id . '">' . $row->nama_plan . ' (NP:' . currency($row->nilai_produk) . ')</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group row">
                                <div class="col-sm-5">
                                    <label class="control-label">Jenis Produk</label>
                                </div>
                                <div class="col-sm-7">
                                    <select class="form-control" name="jenis_produk" id="jenis_produk">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label class="control-label">Qty Paket</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" id="qty_paket" name="qty_paket" value="1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom:20px">
            <div class="col-sm-12">
                <input type="text" id="keyword" name="keyword" class="form-control" placeholder="Cari Produk">
            </div>
        </div>
        <div class="row" id="list-produk">
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-detail">
            <div class="row">
                <h3 class="col-xs-8 card-title">Detail Order</h3>
                <div class="col-xs-4 text-right">
                    <button class="btn btn-sm btn-default btn-rounded px-4" onclick="clearAll()"> Hapus Semua </button>
                </div>
            </div>
            <div class="row bg-warning d-flex align-self-center py-2">
                <div class="col-xs-6">Member : <span class="member-title"></span></div>
                <div class="col-xs-6">Total Nilai Produk : <span class="np-title" id="total_nilai_produk">0</span></div>
            </div>
            <form class="form-horizontal" enctype="multipart/form-data" action="controller/<?= $mod_url ?>/<?= $mod_url ?>_create.php" method="post" id="formCreate">
                <div class="card-order">
                    <div class="row" id="item">
                    </div>
                </div>
                <div class="card-summary">
                    <!-- <div class="row subtotal">
                        <div class="col-xs-6 fw-bold text-white">
                            <span class="">Subtotal</span>
                        </div>
                        <div class="col-xs-6 fw-bold text-white text-right">
                            <span class="" id="subtotal">Rp0,-</span>
                        </div>
                    </div> -->
                    <!-- <div class="form-group mt-2">   
                        <div class="col-xs-6">
                            <label class="control-label">Jumlah PIN</label>
                        </div>
                        <div class="col-xs-6 text-right"> 
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-primary" onclick="minus_pin()"><i class="fa fa-minus"></i></button>
                                </span>
                                <input type="text" class="form-control input-sm text-center" id="qty_pin" name="qty_pin" value="1">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-primary" onclick="plus_pin()"><i class="fa fa-plus"></i></button>
                                </span>
                            </div>
                        </div>
                    </div> -->
                    <div class="row total">
                        <div class="col-xs-6 fw-bold text-white">
                            <span class="">Total</span>
                        </div>
                        <div class="col-xs-6 fw-bold text-white text-right">
                            <span id="subtotal">Rp0,-</span>
                        </div>
                    </div>
                    <!-- <div class="row" id="cashbackPoin" style="display:none">
                        <div class="col-xs-6 fw-bold text-white">
                            <span class="">Cashback Saldo Autosave</span>
                        </div>
                        <div class="col-xs-6 fw-bold text-white text-right">
                            <span id="diskon">0,-</span>
                        </div>
                    </div> -->
                    <div class="row total" style="display:none">
                        <div class="col-xs-6 fw-bold text-white">
                            <span class="">Total</span>
                        </div>
                        <div class="col-xs-6 fw-bold text-white text-right">
                            <span id="total">Rp0,-</span>
                        </div>
                    </div>
                </div>
                <div class="form-footer">
                    <a href="?go=<?= $mod_url ?>" class="btn btn-default btn-rounded"> <i class="fa fa-arrow-left"></i>
                        Batal</a>
                    <button type="button" class="btn btn-primary btn-rounded pull-right" onclick="order()">
                        Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" id="modalProduk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="myModalLabel">Tambah Produk</h5>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-sm" id="modalSuccess" tabindex="-1" role="dialog" aria-labelledby="modalSuccessLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header border-none">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-center" id="message">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Close</span></button>
            </div>
        </div>
    </div>
</div>
<script>
    var modalSuccess = $('#modalSuccess');

    $(document).ready(function() {
        // modalSuccess.modal('show');
        var formCreate = $('#formCreate');
        var btnSubmit = $('#btnSubmit');

        $('#keyword').on('keyup', function(e) {
            get_produk();
        });

        $('body').addClass('sidebar-collapse');
        $('#id_member').on('keyup', function(e) {
            var id_member = $('#id_member').val();
            var id_plan = $('#id_plan').val();
            if (id_member !== undefined && id_member !== '') {
                $.ajax({
                    url: 'controller/member/member_search.php',
                    type: 'post',
                    delay: 250,
                    data: {
                        id_member: id_member
                    },
                    success: function(result) {
                        const obj = JSON.parse(result);
                        $('#nama_member').val(obj.nama_member);
                        if (obj.status == true) {
                            var member_text = obj.nama_member;
                            if (id_member != '0') {
                                $('.member-title').text(`${member_text}`);
                            }
                            getCart();
                        } else {
                            $('.member-title').text(``);
                        }
                    }
                });
            }
        });
        get_produk();
    });
    $('#id_plan').on('change', function(e) {
        getJenisProduk();
        get_produk();
        getCart();
    });
    $('#jenis_produk').on('change', function(e) {
        get_produk();
        getCart();
    });

    function get_produk() {
        var keyword = $('#keyword').val();
        var id_plan = $('#id_plan').val();
        var jenis_produk = $('#jenis_produk').val();
        $.ajax({
            url: 'controller/produk/get_produk_stokis.php',
            type: 'post',
            data: {
                keyword: keyword,
                id_plan: id_plan,
                jenis_produk: jenis_produk
            },
            success: function(result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('#list-produk').html(obj.html);
                } else {
                    alert(obj.message);
                }
            }
        });
    }

    function getJenisProduk() {
        var id_plan = $('#id_plan').val();
        $.ajax({
            url: 'controller/produk/get_jenis_produk.php',
            type: 'post',
            data: {
                id_plan: id_plan
            },
            success: function(result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('#jenis_produk').html(obj.html);
                } else {
                    alert(obj.message);
                }
            }
        });
    }

    function cek_nilai_produk() {
        var id_member = $('#id_member').val();
        var id_plan = $('#id_plan').val();
        var qty_paket = $('#qty_paket').val();
        $.ajax({
            url: 'controller/jual_pin/cek_nilai_produk.php',
            type: 'post',
            data: {
                id_member: id_member,
                id_plan: id_plan,
                qty_paket: qty_paket
            },
            success: function(result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    order();
                } else {
                    alert(obj.message);
                }
            }
        });
    }

    function getCart(id_member) {
        var id_member = $('#id_member').val();
        var id_plan = $('#id_plan').val();
        $.ajax({
            url: 'controller/jual_pin/get_cart.php',
            type: 'post',
            data: {
                id_member: id_member,
                id_plan: id_plan
            },
            success: function(result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    tampilkan(obj);
                } else {
                    alert(obj.message);
                }
            }
        });
    }

    function modalProduk() {
        $('#modalProduk').modal('show');
    }

    function plus(id_produk) {
        var qty = parseInt($('#qty' + id_produk).val()) + 1;
        if (qty > 0) {
            $('#qty' + id_produk).val(qty);
        }
    }

    function minus(id_produk) {
        var qty = parseInt($('#qty' + id_produk).val()) - 1;
        if (qty > 0) {
            $('#qty' + id_produk).val(qty);
        }
    }

    function addToCart(id_produk) {
        var id_member = $('#id_member').val();
        var id_plan = $('#id_plan').val();
        console.log(id_member);
        if (id_member == undefined || id_member == '') {
            alert('Pilih Member terlebih dahulu!');
        } else {
            var qty = parseInt($('#qty' + id_produk).val());
            $.ajax({
                url: 'controller/jual_pin/add_cart.php',
                type: 'post',
                data: {
                    id_member: id_member,
                    id_produk: id_produk,
                    qty: qty,
                    id_plan: id_plan
                },
                success: function(result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        tampilkan(obj);
                    } else {
                        alert(obj.message);
                    }
                }
            });
        }
    }

    function clearAll() {
        var id_member = $('#id_member').val();
        if (id_member == undefined || id_member == '') {
            $('#item').html('');
            $('#subtotal').text('Rp0,-');
            $('#diskon').text('0');
            $('#total').text('Rp0,-');
        } else {
            if (id_member !== undefined && id_member !== '') {
                $.ajax({
                    url: 'controller/jual_pin/delete_cart.php',
                    type: 'post',
                    data: {
                        id_member: id_member
                    },
                    success: function(result) {
                        const obj = JSON.parse(result);
                        if (obj.status == true) {
                            tampilkan(obj);
                        } else {
                            alert(obj.message);
                        }
                    }
                });
            }
        }
    }

    function cancel(id_produk) {
        var id_member = $('#id_member').val();
        var id_plan = $('#id_plan').val();
        if (id_member == undefined || id_member == '') {
            $('#item').html('');
            $('#subtotal').text('Rp0,-');
            $('#diskon').text('0');
            $('#total').text('Rp0,-');
        } else {
            if (id_member !== undefined && id_member !== '') {
                $.ajax({
                    url: 'controller/jual_pin/delete_produk_cart.php',
                    type: 'post',
                    data: {
                        id_member: id_member,
                        id_produk: id_produk,
                        id_plan: id_plan
                    },
                    success: function(result) {
                        const obj = JSON.parse(result);
                        if (obj.status == true) {
                            tampilkan(obj);
                        } else {
                            alert(obj.message);
                        }
                    }
                });
            }
        }
    }

    function order() {
        if ($('.stok-kurang').length > 0) {
            alert('Kurangi atau hapus produk yang stok nya kurang.');
        } else {
            var id_member = $('#id_member').val();
            var id_plan = $('#id_plan').val();
            var qty_paket = $('#qty_paket').val();
            $.ajax({
                url: 'controller/jual_pin/jual_pin_create.php',
                type: 'post',
                data: {
                    id_member: id_member,
                    id_plan: id_plan,
                    qty_paket: qty_paket
                },
                success: function(result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        $('#message').html(obj.message);
                        modalSuccess.modal('show');
                        $('#item').html('');
                        $('#subtotal').text('Rp0,-');
                        $('#diskon').text('0');
                        $('#total').text('Rp0,-');
                        $('.member-title').text('');
                        $('#total_nilai_produk').text('0');
                        // $('#id_member').val('');
                        // $('#nama_member').val('Nama Member');
                        // $('#id_plan').val('');
                        // aktivasi_pin();
                    } else {
                        alert(obj.message);
                    }
                    get_produk();
                }
            });
        }
    }

    function aktivasi_pin() {
        $.ajax({
            url: '../memberarea/controller/posting_ro/posting_ro_auto.php',
            type: 'post',
            success: function(result) {}
        });
    }

    function tampilkan(obj) {
        $('#item').html(obj.html);
        $('#subtotal').text(obj.subtotal);
        $('#total_nilai_produk').text(obj.total_nilai_produk);
        if (obj.diskon == '0') {
            $('#cashbackPoin').hide();
        } else {
            $('#cashbackPoin').show();
            $('#diskon').text(obj.diskon);
        }
        $('#total').text(obj.total);
    }
</script>