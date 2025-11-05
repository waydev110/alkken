<?php 
    require_once 'helper/session.php';
    
    $token = create_token();

    require_once '../model/classMember.php';
    require_once '../model/classWallet.php';
    require_once '../model/classBank.php';
    require_once '../model/classSetBonus.php';



    $cm = new classMember();
    
    $cb = new classBank();
    $csb = new classSetBonus();
    $setbonus = $csb->index();

    $member = $cm->detail($session_member_id);
?>

<?php include 'view/layout/header.php'; ?>
<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->
<?php include 'view/layout/sidebar.php'; ?>
<!-- Begin page -->
<style>
    .border-bottom-2{
        border-bottom: 2px solid #1f0000
    }
    .trasparent-input {
        font-size: 2.5rem;
    }
</style>
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
        <?php
// if (date('D', time()) !== 'Sun' && date('D', time()) !== 'Sat') {
//     $jam_mulai = date('Y-m-d 08:00:00');
//     $jam_selesai = date('Y-m-d 16:00:00');
//     if (strtotime(date('Y-m-d H:i:s')) >= strtotime($jam_mulai) && strtotime(date('Y-m-d H:i:s')) <= strtotime($jam_selesai)) {
?>
        <form action="controller/wallet/transfer_wallet.php" id="formTransferWallet" method="post">
            <input type="hidden" name="token" value="<?=$token?>">   
            <div class="row mb-1 justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row mb-2"> 
                                        <h6 class="title mb-1">Dari Wallet</h6>
                                        <div class="col">  
                                            <select class="form-control rounded-0" name="wallet_asal" id="wallet_asal">
                                                <option value=""></option>
                                                <option value="bonus">Wallet Bonus</option>
                                                <option value="cash">Wallet Cash</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2" id="fieldSaldoBonus" style="display: none"> 
                                        <h6 class="title mb-1">Saldo Bonus</h6>
                                        <div class="col">  
                                            <select class="form-control rounded-0" name="saldo_bonus" id="saldo_bonus">
                                                <option value=""></option>
                                                <option value="bonus_sponsor"><?=type('bonus_sponsor')?></option>
                                                <option value="bonus_pasangan"><?=type('bonus_pasangan')?></option>
                                                <option value="bonus_reward"><?=type('bonus_reward')?></option>
                                                <option value="bonus_generasi_sponsor"><?=type('bonus_generasi_sponsor')?></option>
                                                <option value="bonus_generasi_upline"><?=type('bonus_generasi_upline')?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2"> 
                                        <h6 class="title mb-1">Sisa Saldo</h6>
                                        <div class="col"> 
                                            <input type="text" class="form-control rounded-0 autonumeric" name="sisa_saldo" id="sisa_saldo" value="" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-2"> 
                                        <h6 class="title mb-1">Transfer ke</h6>
                                        <div class="col">  
                                            <select class="form-control rounded-0" name="wallet_tujuan" id="wallet_tujuan">
                                                <option value=""></option>
                                                <option value="cash">Wallet Cash</option>
                                                <option value="ppob">Saldo Belanja</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <h6 class="title mb-1">Nominal Transfer</h6>
                                        <div class="col-12 text-center mb-2">
                                            <input type="text" class="trasparent-input text-center autonumeric  rounded-0" id="nominal_transfer"
                                                name="nominal_transfer" value="0" placeholder="Masukan Jumlah"> 
                                            <div class="text-center">
                                                <span class="text-red" id="error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-lg btn-default shadow-sm w-100" id="btnSubmit">
                                Transfer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php 
    // } else {
    ?>
        <!-- <div class="row mb-4">
            <div class="col">
                <div class="px-2 py-4 bg-warning text-center">
                    <h5>Mohon maaf Penarikan tidak dapat dilakukan.</h5>
                    <p>Untuk penarikan saldo dapat dilakukan pada:</p>
                    <p>Hari : Senin s/d Jum'at
                    <p>Pukul : 08.00 s/d 16.00 WIB</p>
                    <p>Terima Kasih.</p>
                </div>
            </div>
        </div> -->
        <?php
//     }
// } else {
?>
        <!-- <div class="row mb-4">
            <div class="col">
                <div class="px-2 py-4 bg-warning text-center">
                    <h5>Mohon maaf Penarikan tidak dapat dilakukan.</h5>
                    <p>Untuk penarikan saldo dapat dilakukan pada:</p>
                    <p>Hari : Senin s/d Jum'at
                    <p>Pukul : 08.00 s/d 16.00 WIB</p>
                    <p>Terima Kasih.</p>
                </div>
            </div>
        </div> -->
        <?php
// }
?>
    </div>


    <?php include 'view/auth/form_cek_pin.php'; ?>
    <!-- main page content ends -->
</main>
<!-- Page ends-->
<?php include 'view/layout/assets_js.php'; ?>

<script src="assets/vendor/autoNumeric/autoNumeric.js"></script>

<script>
    $(document).ready(function () {
        var blockFirstForm = $('#blockFirstForm');
        var blockNextForm = $('#blockNextForm');
        var formCekPIN = $('#formCekPIN');
        var formTransferWallet = $('#formTransferWallet');
        var btnSubmit = $('#btnSubmit');

        $('.autonumeric').autoNumeric('init', {
            "aSep": ".",
            "aDec": ",",
            "mDec": "0",
        });
        
        $('#wallet_asal').on("change", function (e) {
            var jenis_saldo = $(this).val();
            console.log(jenis_saldo);
            if(jenis_saldo == "bonus"){
                $("#fieldSaldoBonus").show();
            } else {
                $('#saldo_bonus').val('');
                $("#fieldSaldoBonus").hide();
                cek_saldo();
            }
            if($(this).val() == 'cash'){
                var option = `<option value=""></option>
                            <option value="cash">Wallet Cash</option>
                            <option value="ppob">Saldo Belanja</option>`;
            } else {
                var option = `<option value=""></option>
                            <option value="ppob">Saldo Belanja</option>`;
            }
            $('#wallet_tujuan').html(option);
        });

        $('#saldo_bonus').on("change", function (e) {
            cek_saldo_bonus();

        });
        
        $('#nominal_transfer').on("keyup", function (e) {
            cek_data();
        });

        function cek_saldo(){
            var jenis_saldo = $('#wallet_asal').val();
            $.ajax({
                url: "controller/wallet/cek_saldo.php",
                data: {jenis_saldo:jenis_saldo},
                type: "POST",
                success: function (sisa_saldo) {
                    $("#sisa_saldo").autoNumeric('set', sisa_saldo);
                }
            });
        }
        function cek_saldo_bonus(){
            var jenis_saldo = $('#wallet_asal').val();
            var saldo_bonus = $('#saldo_bonus').val();
            $.ajax({
                url: "controller/wallet/cek_saldo.php",
                data: {jenis_saldo:jenis_saldo, saldo_bonus:saldo_bonus},
                type: "POST",
                success: function (sisa_saldo) {
                    $("#sisa_saldo").autoNumeric('set', sisa_saldo);
                }
            });
        }

        function cek_data() {
            var sisa_saldo = parseInt($('#sisa_saldo').autoNumeric('get'));
            var sisa_saldo_text = $('#sisa_saldo').val();
            var nominal_transfer = parseInt($('#nominal_transfer').autoNumeric('get'));

            if (nominal_transfer > sisa_saldo) {
                var error = `<p class="text-danger mb-0 size-14 fw-bold">Saldo tidak cukup. Maksimal Transfer:</p>
                            <p class="text-danger mb-0 size-22 fw-bold">${sisa_saldo_text}</p>`;
                $('#nominal_transfer').addClass('error');
                $('#error').html(error);
                return false;
            } else {
                $('#nominal_transfer').removeClass('error');
                $('#error').html('');
                return true;
            }
        };

        btnSubmit.on("click", function (e) {
            if(cek_data()){
                blockFirstForm.hide();
                blockNextForm.show();
                $('input[name=old_pin1]').focus();
            }
            e.preventDefault();
        });

        formCekPIN.on("submit", function (e) {
            e.preventDefault();
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                beforeSend: function () {
                    btn_start();
                },
                success: function (result) {
                    if (result == true) {
                        formTransferWallet.submit();
                    } else {
                        btn_finish();
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
                },
            });
        });

        formTransferWallet.on("submit", function (e) {
            e.preventDefault();
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                success: function (result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        var redirect_url = 'riwayat_transfer_wallet';
                        show_success_html(obj.message, redirect_url);
                    } else {
                        var redirect_url = 'transfer_wallet';
                        show_error(obj.message, redirect_url);
                    }
                },
                complete: function () {
                    btn_finish();
                }
            });
        });

        $('.input_pin').keyup(function (e) {
            var key = e.keyCode || e.charCode;

            if (key == 8 || key == 46) {
                if (this.value == '') {
                    $(this).attr('type', 'text');
                    if (!$(this).is(':first-child')) {
                        $(this).prev('.input_pin').focus();
                    } else {
                        formCekPIN.find('.form-error').remove();
                    }
                }
            } else {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    this.value = '';
                } else {
                    if (this.value.length >= this.maxLength) {
                        $(this).delay(300).queue(function () {
                            $(this).attr('type', 'password').dequeue();
                        });
                        if (!$(this).is(':last-child')) {
                            $(this).next('.input_pin').focus();
                        } else {
                            if ($(this).parents('#formCekPIN').length > 0) {
                                formCekPIN.submit();
                            }
                        }
                    }
                }
            }
        });

        function rp(numeric){
            return 'Rp'+numeric+',-';
        }
    });
</script>
<?php include 'view/layout/footer.php'; ?>