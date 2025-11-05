<?php
    require_once '../model/classCart.php';
    $cc = new classCart();
    $total_harga = $cc->total_harga($session_member_id);
    $carts = $cc->index($session_member_id);
?>
<?php include 'view/layout/header.php'; ?>
<link rel="stylesheet" href="assets/css/style-product.css">

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>
<!-- Begin page -->
<main class="h-100 has-header">
    <!-- Header -->
    <header class="header position-fixed bg-theme">
        <div class="row">
            <div class="col-auto">
                <a href="index.php" class="btn btn-light btn-44 back-btn">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="col align-self-center text-left">
                <h5><?=$title?></h5>
            </div>
            <?php include 'view/layout/cart.php'; ?>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4">
        <?php 
            if($carts->num_rows > 0) {
        ?>
        <div class="row mb-4">
            <div class="col">
                <div class="cart-list" id="cartList">
                    <?php
                while($row = $carts->fetch_object()){
                    $tanggal = $row->created_at;
                ?>
                    <div class="card mb-0 border-0 rounded-0 border-bottom" id="cart_item<?=$row->id?>">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto align-self-center">
                                    <input type="checkbox" name="check[<?=$row->id?>]" id="check<?=$row->id?>"
                                        <?=$row->checked == '1' ? 'checked':''?> onclick="updateCheck('<?=$row->id?>')">
                                    <input type="hidden" name="id_cart[<?=$row->id?>]" value="<?=$row->id?>">
                                </div>
                                <div class="col-auto align-self-center ps-0">
                                    <div class="avatar avatar-80 rounded-10">
                                        <img src="../images/produk/<?=$row->gambar?>" alt="" width="80">
                                    </div>
                                </div>
                                <div class="col align-self-center">
                                    <div class="row">
                                        <div class="col align-self-center pe-0">
                                            <h3 class="size-18"><?=$row->nama_produk?></h3>
                                            <p class="size-14 new-price mb-2"><span><?=rp($row->harga)?></span></p>
                                        </div>
                                        <div class="col-auto ps-0 text-end">
                                            <button class="btn btn-sm size-9 btn-danger rounded-pill text-white"
                                                onclick="hapus('<?=$row->id?>')"> Hapus</button>
                                            <div class="input-group mt-2">
                                                <button class="btn btn-sm rounded-circle btn-default"
                                                    onclick="kurang('<?=$row->id?>')"><i
                                                        class="fa-solid fa-minus"></i></button>
                                                <input type="number" name="qty[<?=$row->id?>]" id="qty<?=$row->id?>"
                                                    value="<?=$row->qty?>"
                                                    class="form-control rounded-pill size-14 py-0 w-25 text-center"
                                                    onchange="changeQty('<?=$row->id?>')">
                                                <button class="btn btn-sm rounded-circle btn-default"
                                                    onclick="tambah('<?=$row->id?>')"><i
                                                        class="fa-solid fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                </div>
            </div>
        </div>
        <?php
        } else {
        ?>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col text-center ps-0">
                        <p class="mb-0"><span class="text-muted size-12">Keranjang kosong.</span></p>

                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
    <!-- main page content ends -->
</main>

<!-- Footer -->
<?php
if($carts->num_rows > 0) {
?>
<footer class="footer rounded-0">
    <div class="container py-2 pt-4">
        <div class="row">
            <div class="col">
                <h3 class="size-14">Total Belanja</h3>
                <h3 class="size-18 text-price" id="total_harga">Rp<?=currency($total_harga)?></h3>
            </div>
            <div class="col-auto align-content-center">
                <!-- <a href="index.php" class="btn btn-sm btn-light rounded-pill">MAINTENANCE</a> -->
                <a href="index.php" class="btn btn-sm btn-light rounded-pill">Batal</a>
                <a href="?go=checkout" class="btn btn-sm btn-default rounded-pill">Checkout</a>
            </div>
        </div>
    </div>
</footer>
<?php } ?>
<!-- Footer ends-->

<!-- Page ends-->
<?php include 'view/layout/assets_js.php'; ?>

<script>
    function tambah(id) {
        var qty = parseInt($('#qty' + id).val());
        if (qty >= 0) {
            qty = qty + 1;
            $('#qty' + id).val(qty);
            $('#qty' + id).trigger('change');
        }
    }

    function kurang(id) {
        var qty = parseInt($('#qty' + id).val());
        if (qty > 0) {
            qty = qty - 1;
            $('#qty' + id).val(qty);
            $('#qty' + id).trigger('change');
        }
    }

    function changeQty(id) {
        var qty = parseInt($('#qty' + id).val());
        $.ajax({
            url: "controller/member_order/edit_qty.php",
            data: {
                id: id,
                qty: qty
            },
            type: "POST",
            beforeSend: function () {
                loader_open();
            },
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('#qty' + id).val(qty);
                    $('#total_harga').text(obj.total_harga);
                }
            },
            complete: function () {
                loader_close();
            }
        });
    }

    function updateCheckStokis(id) {
        var checked = $('#checkStokis' + id).prop('checked');
        var check;
        console.log(checked);
        if (checked == true) {
            check = '1';
        } else {
            check = '0';
        }
        $.ajax({
            url: "controller/member_order/update_check_stokis.php",
            data: {
                id: id,
                check: check
            },
            type: "POST",
            beforeSend: function () {
                loader_open();
            },
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('#total_harga').text(obj.total_harga);
                    if (check == '1') {
                        $('#cartList' + id).find('input[type="checkbox"]').prop('checked', true);
                    } else {
                        $('#cartList' + id).find('input[type="checkbox"]').prop('checked', false);
                    }
                }
            },
            complete: function () {
                loader_close();
            }
        });
    }

    function updateCheck(id) {
        var checked = $('#check' + id).prop('checked');
        var check;
        console.log(checked);
        if (checked == true) {
            check = '1';
        } else {
            check = '0';
        }
        $.ajax({
            url: "controller/member_order/update_check.php",
            data: {
                id: id,
                check: check
            },
            type: "POST",
            beforeSend: function () {
                loader_open();
            },
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('#total_harga').text(obj.total_harga);
                }
            },
            complete: function () {
                loader_close();
            }
        });
    }

    function hapus(id) {
        $.ajax({
            url: "controller/member_order/hapus_keranjang.php",
            data: {
                id: id
            },
            type: "POST",
            beforeSend: function () {
                loader_open();
            },
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('#cart_item' + id).remove();
                    $('#total_harga').text(obj.total_harga);
                }
            },
            complete: function () {
                loader_close();
            }
        });
    }

    function addToCart(id_produk) {
        var qty = $("#qty").val();
        $.ajax({
            url: "controller/member_order/add_to_cart.php",
            data: {
                id_produk: id_produk,
                qty: qty
            },
            type: "POST",
            beforeSend: function () {
                loader_open();
            },
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('.count-indicator').text(obj.count);
                }
            },
            complete: function () {
                loader_close();
            }
        });
    }
</script>
<?php include 'view/layout/footer.php'; ?>