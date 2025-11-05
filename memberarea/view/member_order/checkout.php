<?php
    require_once '../model/classStokisMember.php';
    require_once '../model/classMember.php';
    require_once '../model/classCart.php';

    $csm = new classStokisMember();
    $cm = new classMember();
    $cc = new classCart();

    $member = $cm->detail($session_member_id);
    $carts = $cc->index_checkout($session_member_id);
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
                <a href="?go=cart" class="btn btn-light btn-44 back-btn">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="col align-self-center text-left">
                <h5><?=$title?></h5>
            </div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4" id="blockFirstForm">
        <?php
        if($carts->num_rows > 0) {
        ?>
        <form class="cart-list" action="controller/member_order/order.php" method="post" id="formOrder">
            <div class="row mb-4">
                <div class="col">
                    <div class="card mb-4 rounded-15 border-0 border-bottom">
                        <?php
                        $total_harga = 0;
                        while($row = $carts->fetch_object()){
                            $total_harga += $row->harga*$row->qty;
                            $tanggal = $row->created_at;
                        ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto align-self-center">
                                    <input type="hidden" name="id_cart[<?=$row->id?>]" value="<?=$row->id?>">
                                    <div class="avatar avatar-50">
                                        <img src="../images/produk/<?=$row->gambar?>" alt="" width="100%">
                                    </div>
                                </div>
                                <div class="col align-self-center">
                                    <h3 class="size-18 text-dark"><?=$row->nama_produk?></h3>
                                    <h3 class="size-14 text-price mb-2"><?=rp($row->harga)?> x <?=currency($row->qty)?>
                                    </h3>
                                </div>
                                <div class="col-auto align-self-center">
                                    <h3 class="size-18 text-price"><?=rp($row->harga*$row->qty)?></h3>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                        <div class="card mb-0 rounded-15 border-0 border-bottom">
                            <div class="card-body pt-4">
                                <div class="row border-0">
                                    <div class="col-auto align-self-left">
                                        <h3 class="size-18 text-dark">Total Bayar</h3>
                                    </div>
                                    <div class="col align-self-center">
                                        <h3 class="size-18 text-price mb-2 text-end"><?=rp($total_harga)?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4 rounded-15 border-0 border-bottom pb-0">
                        <div class="card-body rounded-15 bg-white text-dark">
                            <label for="id_stokis" class="control-label mb-2">Stokis Tujuan</label>
                            <select class="form-control select2" name="id_stokis" id="id_stokis">
                                <option value="">Pilih Stokis</option>
                                <?php
                                $stokis = $csm->index();
                                while($row = $stokis->fetch_object()){
                                    echo '<option value="'.$row->id.'">'.$row->nama_stokis.' ['.$row->nama_kota.']</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="card mb-0 rounded-15 border-0 border-bottom pb-0">
                        <div class="card-body rounded-15 bg-white text-dark">
                            <label for="id_stokis" class="control-label mb-2">Alamat Pengiriman</label>
                            <div class="row" id="alamat">
                                <div class="col align-self-center">
                                    <p>Dikirim ke :</p>
                                    <p><?=$member->nama_provinsi?>, <?=$member->nama_kota?></p>
                                    <p><?=$member->nama_kecamatan?>, <?=$member->nama_kelurahan?></p>
                                    <p><?=$member->alamat_member?></p>
                                    <p><?=$member->kodepos_member?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col d-grid mb-4 mt-2">
                    <button type="button" class="btn btn-default btn-lg shadow-sm" id="btnSubmit">Submit</button>
                </div>
            </div>
        </form>
        <?php
        } else {
        ?>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col text-center ps-0">
                        <p class="mb-0"><span class="text-muted size-12">Minimal order 1 produk.</span></p>

                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>

    <?php include 'view/auth/form_cek_pin.php'; ?>
    <!-- main page content ends -->
</main>

<!-- Page ends-->
<?php include 'view/layout/assets_js.php'; ?>
<script src="assets/vendor/jquery-validation-1.19.5/jquery.validate.min.js"></script>

<script>
    $(document).ready(function () {
        var blockFirstForm = $('#blockFirstForm');
        var blockNextForm = $('#blockNextForm');
        var formCekPIN = $('#formCekPIN');
        var formOrder = $('#formOrder');
        var btnSubmit = $('#btnSubmit');

        formOrder.validate({
            rules: {
                alamat_kirim: {
                    required: true
                }
            },
            messages: {
                alamat_kirim: {
                    required: "Alamat pengiriman tidak boleh kosong."
                }
            },
            errorElement: 'div',
            errorLabelContainer: '.error'
        });

        btnSubmit.on("click", function (e) {
            if (formOrder.valid()) {
                blockFirstForm.hide();
                blockNextForm.show();
                $('input[name=old_pin1]').focus();
            }
            e.preventDefault();
        });

        formCekPIN.on("submit", function (e) {
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                success: function (result) {
                    if (result == true) {
                        formOrder.submit();
                    } else {
                        if (result == 'limit') {
                            formCekPIN.html('');
                            formCekPIN.prepend(
                                '<p class="form-error text-center text-danger mb-1">Anda salah memasukan PIN sebanyak 3 kali.</p><p class="form-error text-center text-danger mb-3">Silahkan coba beberapa saat lagi.</p>'
                            );

                        } else {
                            if (formCekPIN.find('.form-error').length == 0) {
                                formCekPIN.prepend(
                                    '<p class="form-error text-center text-danger mb-3">PIN yang anda masukan salah.</p>'
                                );

                            }
                        }
                    }
                }
            });
            e.preventDefault();
        });

        formOrder.on("submit", function (e) {
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                beforeSend: function () {
                    loader_open();
                },
                success: function (result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        var redirect_url = 'riwayat_order';
                        show_success_html(obj.message, redirect_url);
                    } else {
                        var redirect_url = 'home';
                        show_error(obj.message, redirect_url);
                    }
                },
                complete: function () {
                    loader_close();
                }
            });
            e.preventDefault();
        });
    });
</script>
<?php include 'view/layout/footer.php'; ?>