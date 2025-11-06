<?php     
    $token = create_token();

    require_once('../model/classMember.php');
    require_once("../model/classWallet.php");
    require_once("../model/classWithdraw.php");
    require_once("../model/classBank.php");
    require_once("../model/classPlan.php");

    $cm = new classMember();
    $cw = new classWallet();
    $cwd = new classWithdraw();
    $cb = new classBank();
    $cpl = new classPlan();

    $cek_pending_wd = $cwd->cek_pending_wd($session_member_id, 'cash');
    $member = $cm->detail($session_member_id);
    $plan = $cpl->show($member->id_plan);
    $limit_penarikan = $cwd->limit_penarikan($session_member_id, 'cash');
    $total_wd = $cwd->total_wd($session_member_id, 'cash');

    $minimal_penarikan = $plan->minimal_wd;
    $maksimal_penarikan = $limit_penarikan-$total_wd;
    if($maksimal_penarikan <= 0){
        $maksimal_penarikan = 0;
    }

    $percent_admin = $plan->persentase_admin;
    $admin = $maksimal_penarikan * $percent_admin/100;

    $member = $cm->detail($session_member_id);
    $nama_bank = $cb->show_nama_bank($member->id_bank);

    $saldo = $cw->saldo($session_member_id, 'cash');
    if($saldo > $maksimal_penarikan){
        $penarikan = $maksimal_penarikan;
        $admin = $penarikan * $percent_admin/100;
        $total = $penarikan - $admin;        
    } else if($saldo >= $minimal_penarikan){
        $penarikan = $saldo;
        $admin = $penarikan * $percent_admin/100;
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
    $sisa_saldo = 0;
?>

<?php require_once("view/layout/header.php"); ?>
<?php require_once("view/layout/loader.php"); ?>
<?php require_once("view/layout/sidebar.php"); ?>

<style>

    .withdrawal-container {
        background: linear-gradient(135deg, var(--black-primary) 0%, var(--black-secondary) 100%);
        min-height: 100vh;
    }

    .header-gold {
        background: linear-gradient(135deg, var(--black-primary) 0%, var(--black-secondary) 100%);
        border-bottom: 2px solid var(--gold-primary);
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
    }

    .header-gold h5 {
        color: var(--gold-primary);
        font-weight: 600;
        letter-spacing: 1px;
    }

    .amount-input-wrapper {
        background: var(--black-secondary);
        border-radius: 20px;
        padding: 40px 20px;
        margin: 30px 0;
        border: 2px solid var(--gold-primary);
        box-shadow: 0 8px 30px rgba(212, 175, 55, 0.15);
        position: relative;
        overflow: hidden;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }

    .trasparent-input {
        font-size: 3rem;
        font-weight: 700;
        color: var(--gold-primary);
        background: transparent;
        border: none;
        text-align: center;
        width: 100%;
        letter-spacing: 2px;
        text-shadow: 0 2px 10px rgba(212, 175, 55, 0.3);
    }

    .trasparent-input::placeholder {
        color: rgba(212, 175, 55, 0.4);
    }

    .trasparent-input:focus {
        outline: none;
        color: var(--dark);
    }

    .info-card {
        background: var(--black-light);
        border-radius: 15px;
        padding: 20px;
        margin: 15px 0;
        border-left: 4px solid var(--gold-primary);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateX(5px);
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.2);
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid rgba(212, 175, 55, 0.2);
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #ccc;
        font-size: 0.95rem;
        font-weight: 400;
    }

    .info-value {
        color: var(--gold-primary);
        font-size: 1.1rem;
        font-weight: 600;
    }

    .total-section {
        background: linear-gradient(135deg, var(--gold-dark) 0%, var(--gold-primary) 100%);
        border-radius: 15px;
        padding: 25px;
        margin: 25px 0;
        box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);
    }

    .total-section .info-label {
        color: var(--black-primary);
        font-size: 1rem;
        font-weight: 600;
    }

    .total-section .info-value {
        color: var(--black-primary);
        font-size: 1.5rem;
        font-weight: 700;
    }

    .bank-card {
        background: var(--black-light);
        border-radius: 20px;
        padding: 25px;
        margin: 20px 0;
        border: 2px solid var(--gold-primary);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
    }

    .bank-card h6 {
        color: var(--gold-primary);
        font-weight: 600;
        margin-bottom: 20px;
    }

    .bank-info {
        background: var(--black-secondary);
        border-radius: 15px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .bank-icon {
        width: 50px;
        height: 50px;
        background: var(--gold-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--black-primary);
        font-size: 1.5rem;
    }

    .bank-details p {
        margin: 0;
        color: #ccc;
    }

    .bank-details .bank-name {
        color: var(--gold-primary);
        font-weight: 600;
        font-size: 1rem;
    }

    .bank-details .account-number {
        color: var(--gold-light);
        font-size: 1.2rem;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--gold-dark) 0%, var(--gold-primary) 100%);
        color: var(--black-primary);
        border: none;
        padding: 18px;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 15px;
        letter-spacing: 1px;
        text-transform: uppercase;
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(212, 175, 55, 0.6);
        background: linear-gradient(135deg, var(--gold-primary) 0%, var(--gold-light) 100%);
    }

    .alert-card {
        background: var(--black-light);
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        border: 2px solid var(--gold-primary);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
    }

    .alert-card h5 {
        color: var(--gold-primary);
        font-weight: 600;
        margin-bottom: 15px;
    }

    .alert-card p {
        color: #ccc;
        margin-bottom: 10px;
    }

    .btn-profile {
        background: var(--gold-primary);
        color: var(--black-primary);
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-profile:hover {
        background: var(--gold-light);
        transform: scale(1.05);
    }

    #error {
        color: #caa62e;
        font-weight: 600;
        text-shadow: 0 2px 8px rgba(255, 107, 107, 0.3);
    }

    .amount-currency {
        color: var(--gold-light);
        font-size: 1.5rem;
        font-weight: 600;
        margin-right: 10px;
    }
</style>

<main class="h-100 has-header withdrawal-container">
    <header class="header header-gold position-fixed">
        <div class="row">
            <?php require_once("view/layout/back.php"); ?>
            <div class="col align-self-center text-left">
                <h5><?=$title?></h5>
            </div>
        </div>
    </header>

    <div class="main-container container pt-5" id="blockFirstForm">
        <form action="controller/wallet/penarikan.php" id="formPenarikan" method="post">
            <input type="hidden" name="token" value="<?=$token?>">
            <input type="hidden" class="autonumeric" id="numeric">
            
            <div class="amount-input-wrapper">
                <input type="text" class="trasparent-input autonumeric" id="jumlah" name="jumlah" value="<?=$penarikan?>" placeholder="0">
                <input type="hidden" name="saldo" class="autonumeric" id="saldo" value="<?=$saldo?>">
                <input type="hidden" name="percent_admin" class="autonumeric" id="percent_admin" value="<?=$percent_admin?>">
                <input type="hidden" name="admin" class="autonumeric" id="admin" value="<?=$admin?>">
                <input type="hidden" name="total" class="autonumeric" id="total" value="<?=$total?>">
                <input type="hidden" name="numeric" class="autonumeric" id="numeric" value="<?=$sisa_saldo?>">
                <input type="hidden" name="minimal_penarikan" class="autonumeric" id="minimal_penarikan" value="<?=$minimal_penarikan?>">
                <input type="hidden" name="maksimal_penarikan" class="autonumeric" id="maksimal_penarikan" value="<?=$maksimal_penarikan?>">
                <div class="text-center mt-3">
                    <span id="error"></span>
                </div>
            </div>

            <div class="info-card">
                <div class="info-row">
                    <span class="info-label">Limit Penarikan</span>
                    <span class="info-value" id="maksimal_penarikan"><?=rp($maksimal_penarikan)?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Jumlah Penarikan</span>
                    <span class="info-value" id="penarikan"><?=rp($penarikan)?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Biaya Admin</span>
                    <span class="info-value" id="admin_text"><?=rp($admin)?></span>
                </div>
            </div>

            <div class="total-section">
                <div class="info-row">
                    <span class="info-label">TOTAL TRANSFER</span>
                    <span class="info-value" id="total_text"><?=rp($total)?></span>
                </div>
            </div>

            <?php if($member->id_bank <> '' && $member->no_rekening <> '' && $member->atas_nama_rekening): ?>
            <div class="bank-card">
                <h6>REKENING TUJUAN</h6>
                <div class="bank-info">
                    <div class="bank-icon">
                        <i class="fa-light fa-building-columns"></i>
                    </div>
                    <div class="bank-details flex-grow-1">
                        <p class="bank-name"><?=$nama_bank?></p>
                        <p class="account-number"><?=$member->no_rekening?></p>
                        <p style="color: var(--gold-light); font-size: 0.9rem;"><?=$member->atas_nama_rekening?></p>
                    </div>
                    <div class="text-end">
                        <span style="color: var(--gold-primary); font-size: 1.8rem;">
                            <span id="total_ditransfer"><?=rp($total)?></span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col d-grid">
                    <button type="button" class="btn btn-submit" id="btnSubmit">
                        Ajukan Penarikan
                    </button>
                </div>
            </div>
            <?php else: ?>
            <div class="alert-card">
                <h5>Profil Belum Lengkap</h5>
                <p>Lengkapi data rekening bank Anda</p>
                <p>untuk melakukan penarikan dana</p>
                <a href="<?=site_url('change_profil')?>" class="btn btn-profile mt-3">
                    Update Profil
                </a>
            </div>
            <?php endif; ?>
        </form>
    </div>

    <?php require_once("view/auth/form_cek_pin.php"); ?>
</main>

<?php require_once("view/layout/assets_js.php"); ?>

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

        function cek_data() {
            var penarikan = parseInt($('#jumlah').autoNumeric('get'));
            var saldo = parseInt($('#saldo').autoNumeric('get'));
            var minimal_penarikan = parseInt($('#minimal_penarikan').autoNumeric('get'));
            var maksimal_penarikan = parseInt($('#maksimal_penarikan').autoNumeric('get'));
            var percent_admin = parseInt($('#percent_admin').autoNumeric('get'));
            var admin = parseInt($('#admin').autoNumeric('get'));

            if (penarikan % 10000 !== 0) {
                $('#error').html(`<p class="mb-0">Jumlah harus kelipatan 10.000</p>`);
                $('#admin').autoNumeric('set', 0);
                $('#total').autoNumeric('set', 0);
                return;
            } else {
                $('#error').html('');
            }

            if(penarikan > maksimal_penarikan) {
                admin = maksimal_penarikan * percent_admin/100;
                var total = maksimal_penarikan - admin;
            } else if (penarikan >= minimal_penarikan) {
                admin = penarikan * percent_admin/100;
                var total = penarikan - admin;
            } else {
                var total = 0;
            }
            if(total <= 0){
                var total = 0;
            }
            $('#admin').autoNumeric('set', admin);
            $('#total').autoNumeric('set', total);

            if (penarikan <= saldo && penarikan >= minimal_penarikan && penarikan <= maksimal_penarikan) {
                $('#error').html('');
                $('#jumlah').removeClass('error');
                $('#penarikan').text(rp($('#jumlah').val()));
                $('#admin_text').text(rp($('#admin').val()));
                $('#total_text').text(rp($('#total').val()));
                $('#total_ditransfer').text($('#total').val());
                return true;
            } else {
                if (penarikan > maksimal_penarikan) {
                    var error = `<p class="mb-0 size-14">Maksimal: ${$('#maksimal_penarikan').val()}</p>`;
                } else if (penarikan < minimal_penarikan) {
                    var error = `<p class="mb-0 size-14">Minimal: ${$('#minimal_penarikan').val()}</p>`;
                } else if (penarikan > saldo) {
                    var error = `<p class="mb-0 size-14">Saldo tidak cukup</p>`;
                }
                $('#error').html(error);
                $('#jumlah').addClass('error');
                $('#penarikan').text('0');
                $('#admin_text').text('0');
                $('#total_text').text('0');
                $('#total_ditransfer').text('0');
                return false;
            }
        }

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
                        var redirect_url = 'riwayat_penarikan';
                        show_success_html(obj.message, redirect_url);
                    } else {
                        var redirect_url = 'penarikan';
                        show_error(obj.message, redirect_url);
                    }
                },
                complete: function () {
                    btn_finish();
                }
            });
        });

        function rp(numeric) {
            return 'Rp' + numeric + ',-';
        }
    });
</script>
<?php require_once("view/layout/footer.php"); ?>