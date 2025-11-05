<?php 
    require_once 'helper/session.php';
    
    $token = create_token();

    require_once '../model/classMember.php';
    require_once '../model/classWallet.php';
    require_once '../model/classWithdraw.php';
    require_once '../model/classBank.php';
    require_once '../model/classPlan.php';



    $cm = new classMember();
    $cw = new classWallet();
    $cwd = new classWithdraw();
    
    $rupiah = $cwd->rate_coin();
    
    $cb = new classBank();
    $cpl = new classPlan();

    $cek_pending_wd = $cwd->cek_pending_wd($session_member_id, 'poin');

    $member = $cm->detail($session_member_id);
    $plan = $cpl->show($member->id_plan);
    $total_wd_today = $cwd->total_wd_today($session_member_id, 'poin', date('Y-m-d'));

    $minimal_penarikan = $plan->minimal_wd_poin;
    $maksimal_penarikan = $plan->maximal_wd_poin-$total_wd_today;
    $percent_admin = $plan->admin;
    $admin = $maksimal_penarikan * $percent_admin/100;

    $member = $cm->detail($session_member_id);
    $nama_bank = $cb->show_nama_bank($member->id_bank);

    $saldo = $cw->saldo($session_member_id, 'poin');
    if($saldo > $maksimal_penarikan){
        $penarikan = $maksimal_penarikan;
        $total = $penarikan - $admin;        
    } else if($saldo >= $minimal_penarikan){
        $penarikan = $saldo;
        $total = $penarikan - $admin;
    } else {
        $admin = 0;
        $penarikan = 0;
        $total = 0;
    }
    if($total <= 0){
        $admin = 0;
        $penarikan = 0;
        $total = 0;
    }
    // $sisa_saldo = $saldo%10000;
    $sisa_saldo = 0;
?>

<?php include 'view/layout/header.php'; ?>
<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->
<?php include 'view/layout/sidebar.php'; ?>
<!-- Begin page -->
<style>
    .border-bottom-2 {
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
// if (date('D', time()) !== 'DD' && date('D', time()) !== 'DD') {
if($cek_pending_wd == 0){
    if (date('D', time()) !== 'Sun' && date('D', time()) !== 'Sat') {
        $jam_mulai = date('Y-m-d 08:00:00');
        $jam_selesai = date('Y-m-d 16:00:00');
        if (strtotime(date('Y-m-d H:i:s')) >= strtotime($jam_mulai) && strtotime(date('Y-m-d H:i:s')) <= strtotime($jam_selesai)) {
?>
            <form action="controller/wallet/penarikan_poin.php" id="formPenarikan" method="post">
                <input type="hidden" name="token" value="<?=$token?>">
                <input type="hidden" class="autonumeric" id="numeric">
                <!-- select Amount -->
                <div class="row">
                    <div class="col-12 text-center mb-4">
                        <input type="text" class="trasparent-input text-center autonumeric" id="jumlah" name="jumlah"
                            value="<?=$penarikan?>" placeholder="Masukan Jumlah">
                        <input type="hidden" name="saldo" class="autonumeric" id="saldo" value="<?=$saldo?>">
                        <input type="hidden" name="percent_admin" class="autonumeric" id="percent_admin" value="<?=$percent_admin?>">
                        <input type="hidden" name="admin" class="autonumeric" id="admin" value="<?=$admin?>">
                        <input type="hidden" name="total" class="autonumeric" id="total" value="<?=$total?>">
                        <input type="hidden" name="numeric" class="autonumeric" id="numeric" value="<?=$sisa_saldo?>">
                        <input type="hidden" name="minimal_penarikan" class="autonumeric" id="minimal_penarikan"
                        value="<?=$minimal_penarikan?>">
                        <input type="hidden" name="maksimal_penarikan" class="autonumeric" id="maksimal_penarikan"
                            value="<?=$maksimal_penarikan?>">
                        <div class="text-center">
                            <span class="text-muted text-red" id="error"></span>
                        </div>
                    </div>
                </div>
                <!-- amount breakdown -->
                <div class="row mt-2 mb-3">
                    <div class="col">
                        <p>Jumlah Penarikan</p>
                    </div>
                    <div class="col-auto text-end">
                        <p class="text-muted" id="penarikan"><?=currency($penarikan)?></p>
                    </div>
                </div>
                <div class="row mt-2 mb-3 border-bottom-2">
                    <div class="col mb-3">
                        <p>Admin</p>
                    </div>
                    <div class="col-auto text-end">
                        <p class="text-muted" id="admin_text"><?=currency($admin)?></p>
                    </div>
                </div>
                <div class="row mt-2 mb-3">
                    <div class="col">
                        <p>Total</p>
                    </div>
                    <div class="col-auto text-end">
                        <p class="text-muted" id="total_text"><?=currency($total)?></p>
                    </div>
                </div>
                <?php
                    if($member->address_coin <> '' && $member->username_marketplace <> ''){
                ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="mt-2 p-4 bg-green-light">
                            <h6>Penarikan ke </h6>
                            <input type="radio" name="jenis_penarikan" id="market" value="market" checked="checked"> <label for="market"> Alexa Shop</label>
                            <input type="radio" name="jenis_penarikan" id="coin" value="coin"> <label for="coin"> Alexa Coin</label>
                            <div class="price mt-2">
                                <div class="row">
                                    <div class="col-auto align-self-center">
                                        <span class="text-dark" id="total_ditransfer"><?=currency($total)?></span>
                                    </div>
                                    <div class="col-auto ps-0 pe-0 align-self-center">
                                        <span class="text-dark mx-2"><i class="fa-duotone fa-arrow-right"></i></span>
                                    </div>
                                    <div class="col" id="blockMarket">
                                        <p class="text-dark mb-0"><small class="size-12">Username Marketplace</small></p>
                                        <p class="text-danger fw-bold"><?=$member->username_marketplace?></p>
                                    </div>
                                    <div class="col" id="blockCoin" style="display:none">
                                        <p class="text-dark mb-0"><small class="size-12">Address Coin</small></p>
                                        <p class="text-danger fw-bold"><?=$member->address_coin?></p>
                                        <p class="size-11 text-danger">*)Jumlah coin yang diterima dapat berbeda sesuai dengan rate coin yang berlaku.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col d-grid mb-4 mt-2">
                        <button type="button" class="btn btn-default btn-lg shadow-sm" id="btnSubmit">Permintaan</button>
                    </div>
                </div>
                <?php
                    } else {
                ?>
                <div class="row mb-4">
                    <div class="col">
                        <div class="px-2 py-4 bg-green-light text-center">
                            <h6>Anda belum melengkapi alamat nushealth coin dan nushealth shop anda.</h6>
                            <p>Lengkapi profil terlebih dahulu untuk dapat melakukan penarikan poin.</p>
                            <a href="<?=site_url('change_username_marketplace')?>" class="btn btn-sm btn-primary  shadow-sm">Update</a>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>
            </form>
            <?php 
        } else {
        ?>
            <div class="row mb-4">
                <div class="col">
                    <div class="px-2 py-4 bg-warning text-center">
                        <h5>Mohon maaf Penarikan tidak dapat dilakukan.</h5>
                        <p>Untuk penarikan saldo dapat dilakukan pada:</p>
                        <p>Hari : Senin s/d Jum'at
                        <p>Pukul : 08.00 s/d 16.00 WIB</p>
                        <p>Terima Kasih.</p>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
    ?>
            <div class="row mb-4">
                <div class="col">
                    <div class="px-2 py-4 bg-warning text-center">
                        <h5>Mohon maaf Penarikan tidak dapat dilakukan.</h5>
                        <p>Untuk penarikan saldo dapat dilakukan pada:</p>
                        <p>Hari : Senin s/d Jum'at
                        <p>Pukul : 08.00 s/d 16.00 WIB</p>
                        <p>Terima Kasih.</p>
                    </div>
                </div>
            </div>
            <?php
    }
} else {
    ?>
        <div class="row mb-4">
            <div class="col">
                <div class="px-2 py-4 bg-warning text-center">
                    <h5>Mohon maaf Penarikan tidak dapat dilakukan.</h5>
                    <p>Masih ada penarikan pending.</p>
                    <p>Terima Kasih.</p>
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

<script src="assets/vendor/autoNumeric/autoNumeric.js"></script>

<script>
    $(document).ready(function () {
        var blockFirstForm = $('#blockFirstForm');
        var blockNextForm = $('#blockNextForm');
        var formCekPIN = $('#formCekPIN');
        var formPenarikan = $('#formPenarikan');
        var btnSubmit = $('#btnSubmit');

        $('.autonumeric').autoNumeric('init', {
            "aSep": ".",
            "aDec": ",",
            "mDec": "0",
        });


        $('#jumlah').on("keyup", function (e) {
            cek_data();
        });

        $("input[name='jenis_penarikan']").on("click", function (e) {
            if($("#market").prop("checked")){
                $('#blockCoin').hide();
                $('#blockMarket').show();
                cek_data();
            }
            if($("#coin").prop("checked")){
                $('#blockCoin').show();
                $('#blockMarket').hide();
                cek_data();
            }
        });

        function cek_data() {
            var penarikan = parseInt($('#jumlah').autoNumeric('get'));
            var saldo = parseInt($('#saldo').autoNumeric('get'));
            var minimal_penarikan = parseInt($('#minimal_penarikan').autoNumeric('get'));
            var maksimal_penarikan = parseInt($('#maksimal_penarikan').autoNumeric('get'));
            var percent_admin = parseInt($('#percent_admin').autoNumeric('get'));
            var admin = parseInt($('#admin').autoNumeric('get'));
            var rupiah = parseInt(<?=$rupiah?>);

            console.log(maksimal_penarikan);
            console.log(penarikan);
            // var admin = Math.floor(penarikan * persen_admin / 100);
            if(penarikan > maksimal_penarikan) {
                admin = maksimal_penarikan * percent_admin/100;
                var total = maksimal_penarikan - admin;
            } else if (penarikan >= minimal_penarikan) {
                admin = penarikan * percent_admin/100;
                var total = penarikan - admin;
            } else  {
                var total = 0;
            }
            if(total <= 0){
                var total = 0;
            }
            $('#admin').autoNumeric('set', admin);
            $('#total').autoNumeric('set', total);
            var kelipatan = penarikan % 10000;

            if($("#coin").prop("checked")){
                var rate_coin = 1/rupiah;
                var total_ditransfer = rate_coin * total;
            } else {
                var total_ditransfer = $('#total').val();
            }
            // if (penarikan <= saldo && penarikan >= minimal_penarikan && kelipatan == 0) {
            if (penarikan <= saldo && penarikan >= minimal_penarikan && penarikan <= maksimal_penarikan) {

                $('#error').html('');
                $('#jumlah').removeClass('error');
                $('#penarikan').text(currency($('#jumlah').val()));
                $('#admin_text').text(currency($('#admin').val()));
                $('#total_text').text(currency($('#total').val()));
                $('#total_ditransfer').text(total_ditransfer);
                return true;
            } else {
                if (penarikan > maksimal_penarikan) {
                    var maksimal_penarikan_text = $('#maksimal_penarikan').val();
                    var error = `<p class="text-danger mb-0 size-14 fw-bold">Maksimal penarikan:</p>
                                <p class="text-danger mb-0 size-22 fw-bold">${maksimal_penarikan_text}</p>`;
                } else if (penarikan < minimal_penarikan) {
                    var minimal = $('#minimal_penarikan').val();
                    var error = `<p class="text-danger mb-0 size-14 fw-bold">Minimal penarikan:</p>
                                <p class="text-danger mb-0 size-22 fw-bold">${minimal}</p>`;
                } else if (penarikan > saldo) {
                    var maksimal_penarikan_text = $('#saldo').val();
                    var error = `<p class="text-danger mb-0 size-14 fw-bold">Autosave tidak cukup. Maksimal penarikan:</p>
                                <p class="text-danger mb-0 size-22 fw-bold">${maksimal_penarikan_text}</p>`;
                } 
                // else if (kelipatan > 0) {
                //     var error = `<p class="text-danger mb-0 size-14 fw-bold">Penarikan harus kelipatan:</p>
                //                 <p class="text-danger mb-0 size-22 fw-bold">10.000</p>`;

                // }
                $('#error').html(error);
                $('#jumlah').addClass('error');
                $('#penarikan').text('0');
                $('#admin_text').text('0');
                $('#total_text').text('0');
                $('#total_ditransfer').text('0');
                return false;
            }
        };

        btnSubmit.on("click", function (e) {
            if (cek_data()) {
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
                        formPenarikan.submit();
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
                }
            });
        });

        formPenarikan.on("submit", function (e) {
            e.preventDefault();
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                success: function (result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        var redirect_url = 'riwayat_penarikan_poin';
                        show_success_html(obj.message, redirect_url);
                    } else {
                        var redirect_url = 'penarikan_poin';
                        show_error(obj.message, redirect_url);
                    }
                },
                complete: function () {
                    btn_finish();
                }
            });
        });

        function currency(numeric) {
            return 'Rp' + numeric + ',-';
        }
    });
</script>
<?php include 'view/layout/footer.php'; ?>