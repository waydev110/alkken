<?php
    require_once '../model/classCart.php';
    $cc = new classCart();
    $total_harga = $cc->total_harga($session_member_id);
    $carts = $cc->index($session_member_id);
?>
<?php include 'view/layout/header.php'; ?>
<link rel="stylesheet" href="assets/css/style-product.css">
<style>
    .main-container {
        background: transparent;
    }

    .cart-list .card {
        background: linear-gradient(135deg, var(--black-secondary) 0%, var(--black-light) 100%);
        border: 1px solid rgba(255, 215, 0, 0.15);
        transition: all 0.3s ease;
        margin-bottom: 1rem;
        border-radius: 15px;
        overflow: hidden;
    }

    .cart-list .card-body {
        padding: 1.25rem;
    }

    /* Checkbox Styling */
    .cart-list input[type="checkbox"] {
        width: 22px;
        height: 22px;
        cursor: pointer;
        accent-color: var(--gold-primary);
        border: 2px solid var(--gold-primary);
    }

    .cart-list input[type="checkbox"]:checked {
        background-color: var(--gold-primary);
    }

    /* Image Container */
    .avatar.rounded-10 {
        border: 2px solid rgba(255, 215, 0, 0.3);
        border-radius: 10px;
        overflow: hidden;
        background: var(--black-primary);
    }

    /* Product Title */
    .cart-list h3 {
        color: #ffffff;
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

    /* Price */
    .new-price span {
        color: var(--gold);
        font-weight: 700;
        font-size: 1.05rem;
    }

    /* Delete Button */
    .btn-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        border: none;
        color: #ffffff;
        font-weight: 500;
        padding: 0.35rem 1rem;
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
        color: #ffffff;
    }

    /* Quantity Controls */
    .input-group {
        gap: 6px;
        justify-content: flex-end;
        flex-wrap: nowrap;
    }

    .input-group .btn-default {
        background: var(--gold-primary);
        color: var(--black-primary);
        border: none;
        width: 34px;
        height: 34px;
        padding: 0;
        font-size: 13px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input-group .btn-default:hover {
        background: var(--gold-dark);
        color: var(--black-primary);
    }

    .input-group input[type="number"] {
        background: var(--black-primary);
        color: #1a1a1a;
        border: 1px solid rgba(255, 215, 0, 0.3);
        max-width: 65px;
        height: 34px;
        text-align: center;
        font-weight: 600;
    }

    .input-group input[type="number"]:focus {
        border-color: var(--gold-primary);
        box-shadow: none;
        outline: none;
    }

    /* Empty Cart Message */
    .card.mb-3 {
        background: linear-gradient(135deg, var(--black-secondary) 0%, var(--black-light) 100%);
        border: 1px solid rgba(255, 215, 0, 0.15);
        border-radius: 12px;
    }

    .card.mb-3 .text-muted {
        color: #cccccc !important;
        font-size: 1rem;
    }

    /* Product Info Layout */
    .product-info {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .product-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        align-items: flex-end;
    }
    .footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        z-index: 9;
        border-radius: var(--mlm-rounded) var(--mlm-rounded) 0 0;
        background-color: #1a1a1a;
    }

    @media (max-width: 768px) {
        .cart-list .card-body {
            padding: 1rem;
        }

        .avatar.rounded-10 {
            width: 70px !important;
        }

        .cart-list h3 {
            font-size: 0.9rem;
        }

        .new-price span {
            font-size: 0.95rem;
        }

        .btn-danger {
            padding: 0.3rem 0.8rem;
            font-size: 0.85rem;
        }

        .footer .container {
            padding: 1rem !important;
        }

        .text-price {
            font-size: 1.3rem !important;
        }

        .input-group .btn-default {
            width: 30px;
            height: 30px;
            font-size: 11px;
        }

        .input-group input[type="number"] {
            max-width: 55px;
            height: 30px;
        }
    }
</style>

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
                    <div class="card mb-0 border-0 rounded-15 border-bottom" id="cart_item<?=$row->id?>">
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
                                        <div class="col-12 col-md-7 product-info">
                                            <p class="size-18 mb-1"><?=$row->nama_produk?></p>
                                            <p class="size-14 new-price mb-0"><span><?=rp($row->harga)?></span></p>
                                        </div>
                                        <div class="col-12 col-md-5 product-actions">
                                            <button class="btn btn-sm size-9 btn-danger rounded-pill text-white"
                                                onclick="hapus('<?=$row->id?>')">Hapus</button>
                                            <div class="input-group">
                                                <button class="btn btn-sm rounded-circle btn-default"
                                                    onclick="kurang('<?=$row->id?>')"><i
                                                        class="fa-solid fa-minus"></i></button>
                                                <input type="number" name="qty[<?=$row->id?>]" id="qty<?=$row->id?>"
                                                    value="<?=$row->qty?>"
                                                    class="form-control rounded-pill size-14 py-0 text-center"
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
                <p class="size-14 mb-0">Subtotal</p>
                <p class="size-18 mb-1 new-price" id="total_harga"><span>Rp<?=currency($total_harga)?></span></p>
            </div>
            <div class="col-auto align-content-center">
                <a href="index.php" class="btn btn-md btn-primary rounded-pill">Batal</a>
                <a href="?go=checkout" class="btn btn-md btn-primary rounded-pill">Checkout</a>
            </div>
        </div>
    </div>
</footer>
<?php } ?>
<!-- Footer ends-->

<!-- Page ends-->
<?php include 'view/layout/assets_js.php'; ?>

<script>

    // Add keyup event listener to all quantity inputs
    $(document).on('keyup keydown', 'input[name^="qty"]', function() {
        var id = $(this).attr('id').replace('qty', '');
        var qty = parseInt($(this).val());
        
        if (qty < 1 || isNaN(qty)) {
            hapus(id);
        }
    });

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
        if (qty > 1) {
            qty = qty - 1;
            $('#qty' + id).val(qty);
            $('#qty' + id).trigger('change');
        } else if (qty === 1) {
            hapus(id);
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

    function updateCheck(id) {
        var checked = $('#check' + id).prop('checked');
        var check = checked ? '1' : '0';
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
        Swal.fire({
            title: 'Hapus Item?',
            text: "Item akan dihapus dari keranjang",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
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
                            $('#cart_item' + id).fadeOut(300, function() {
                                $(this).remove();
                            });
                            $('#total_harga').text(obj.total_harga);
                            Swal.fire(
                                'Terhapus!',
                                'Item berhasil dihapus dari keranjang.',
                                'success'
                            );
                        }
                    },
                    complete: function () {
                        loader_close();
                    }
                });
            }
        });
    }
</script>
<?php include 'view/layout/footer.php'; ?>