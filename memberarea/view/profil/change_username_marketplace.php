<?php 
    $token = create_token();

    require_once '../model/classMember.php';
    $c = new classMember();
    $member = $c->detail($session_member_id);
?>
<?php include 'view/layout/header.php'; ?>
<link rel="stylesheet" href="assets/vendor/select2/css/select2.min.css">
<style>
    .form-floating-2>label.error {
        position: absolute;
        top: auto !important;
        bottom: -42px;
        left: 0;
        color: red;
    }
</style>
<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->
<?php include 'view/layout/sidebar.php'; ?>
<!-- Begin page -->
<main class="h-100 has-header">
    <!-- Header -->
    <header class="header position-fixed bg-theme">
        <div class="row">
            <?php include 'view/layout/back.php'; ?>
            <div class="col align-self-center text-left">
                <h5><?=$title?></h5>
            </div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4" id="blockFirstForm">
        <form action="controller/profil/update_username_marketplace.php" id="formUpdateProfil" method="post">
            <input type="hidden" name="token" value="<?=$token?>">
            <div class="row">
                <div class="col-12">
                    <div class="form-group form-floating-2 mb-4">
                        <input type="text" class="form-control" id="username_marketplace" name="username_marketplace"
                            value="<?=$member->username_marketplace?>">
                        <label class="form-control-label" for="username_marketplace">Username Marketplace</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group form-floating-2 mb-4">
                        <input type="text" class="form-control" id="address_coin" name="address_coin"
                            value="<?=$member->address_coin?>">
                        <label class="form-control-label" for="address_coin">Wallet Address BEP20</label>
                    </div>
                </div>
                <div class="col-12">
                    <p>Smart Contract BEP20</p>
                    <p>0x9A58178cf5cD713DE4A98672a77a903815630bfc</p>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12 align-self-center text-end mt-2 d-xs-grid">
                    <a href="<?=site_url('profil')?>" class="btn btn-outline-default btn-lg rounded-pill px-5 mb-2"
                        id="btnKembali">BATAL</a>
                    <button type="button" class="btn btn-default btn-lg rounded-pill px-5 mb-2 shadow-sm order-xs-first"
                        id="btnUpdate">Update</button>
                </div>
            </div>
        </form>
    </div>
    <?php include 'view/auth/form_cek_pin.php'; ?>
    <!-- main page content ends -->
</main>
<!-- Page ends-->
<?php include 'view/layout/assets_js.php'; ?>
<script src="assets/vendor/select2/js/select2.min.js"></script>
<script src="assets/vendor/jquery-validation-1.19.5/jquery.validate.min.js"></script>
<?php include 'view/layout/wilayah.php'; ?>
<script>
    $(document).ready(function () {
        var blockFirstForm = $('#blockFirstForm');
        var blockNextForm = $('#blockNextForm');
        var formCekPIN = $('#formCekPIN');
        var formUpdateProfil = $('#formUpdateProfil');
        var btnUpdate = $('#btnUpdate');

        formUpdateProfil.validate({
            rules: {
                address_coin: {
                    required: true,
                    verifyAddressCoin: true
                },
                username_marketplace: {
                    required: true,
                    verifyUsernameMarketplace: true
                },
            },
            messages: {
                address_coin: {
                    required: "Address Coin tidak boleh kosong.",
                },
                username_marketplace: {
                    required: "Username Marketplace tidak boleh kosong.",
                },
            }
        });
        btnUpdate.on("click", function (e) {
            if (formUpdateProfil.valid()) {
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
                        formUpdateProfil.submit();
                    } else {
                        if (result == 'limit') {
                            formCekPIN.html('');
                            formCekPIN.prepend(
                                '<p class="form-error text-center text-danger mb-1">Anda salah memasukan PIN sebanyak 3 kali.</p><p class="form-error text-center text-danger mb-4">Silahkan coba beberapa saat lagi.</p>'
                            );

                        } else {
                            if (formCekPIN.find('.form-error').length == 0) {
                                formCekPIN.prepend(
                                    '<p class="form-error text-center text-danger mb-4">PIN yang anda masukan salah.</p>'
                                );

                            }
                        }
                    }
                }
            });
            e.preventDefault();
        });

        formUpdateProfil.on("submit", function (e) {
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                beforeSend: function () {
                    loader_open();
                },
                success: function (result) {
                    if (result == true) {
                        var message =
                            'Update profil berhasil. Silahkan cek perubahan di halaman profil.';
                        var redirect_url = 'profil';
                        show_success(message, redirect_url);
                    } else {
                        var message =
                            'Update profil gagal. Silahkan coba beberapa saat lagi atau jika masih gagal hubungi kami untuk pemecahan masalah.';
                        var redirect_url = 'profil';
                        show_error(message, redirect_url);
                    }
                },
                complete: function () {
                    loader_close();
                }
            });
            e.preventDefault();
        });


        $.validator.addMethod("verifyAddressCoin", function(value) {
            var response = 'false';
            $.ajax({
                type: 'post',
                url: 'controller/profil/cek_address_coin.php',
                data: {address_coin: value},
                async:false,
                success: function (result) {
                    response = result;
                },
            });
            if(response == 'true'){
                console.log(response);
                return true;
            } else {
                console.log(response);
                return false;
            }
    	}, 'Address Coin sudah digunakan.');

        $.validator.addMethod("verifyUsernameMarketplace", function(value) {
            var response = 'false';
            $.ajax({
                type: 'post',
                url: 'controller/profil/cek_username_marketplace.php',
                data: {username_marketplace: value},
                async:false,
                success: function (result) {
                    response = result;
                },
            });
            if(response == 'true'){
                console.log(response);
                return true;
            } else {
                console.log(response);
                return false;
            }
    	}, 'Username Marketplace sudah digunakan.');
    });
</script>
<?php include 'view/layout/footer.php'; ?>