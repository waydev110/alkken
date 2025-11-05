<?php 
    require_once '../model/classMember.php';
    require_once '../model/classBonusRewardSetting.php';
    require_once '../model/classBonusReward.php';
    
    $cm = new classMember();
    $obj = new classBonusRewardSetting();
    $cbr = new classBonusReward();

    $poin = $cm->poin($session_member_id);
    $reward = $obj->index($session_member_id);
    $peringkat_member = $cm->show_id_peringkat($session_member_id);
?>
<?php include 'view/layout/header.php'; ?>
<?php include 'view/layout/loader.php'; ?>
<?php include 'view/layout/sidebar.php'; ?>
<style>
    .item-reward {
        border: 1px solid #ccc;
        border-radius: 10px;
    }

    .item-reward:hover {
        border: 3px solid #3d7198;
    }
</style>
<main class="h-100 has-header">
    <header class="header position-fixed bg-theme">
        <div class="row">
            <?php include 'view/layout/back.php'; ?>
            <div class="col align-self-center">
                <h5><?=$title?></h5>
            </div>
            <div class="col-auto px-4">
                <a href="<?=site_url('riwayat_klaim_reward')?>"><i class="fa fa-history"></i> Riwayat</a>
            </div>
        </div>
    </header>
    <div class="main-container container pt-4 pb-4" id="blockFirstForm">
        <div class="row">
            <div class="col-sm-12">
                <div class="card p-4 mb-5">
                    <div class="col-sm-12">
                        <h4 class="size-18 text-dark mb-2">Poin Reward anda : <?=poin($poin)?></h4>
                        <!-- <a href="" class="size-12 text-theme">APA YANG DIMAKSUD DENGAN POIN REWARD?</a> -->
                    </div>
                    <div class="row">
                        <?php
                    while($row = $reward->fetch_object()){
                        ?>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="item-reward mt-2 p-3">
                                <div id="reward-desc">
                                    <div class="image">
                                        <img width="100%" class="img-fluid" src="../images/reward/<?=$row->gambar?>"
                                            alt="image">
                                    </div>
                                    <div class="col">                                    
                                        <p class="title size-14 mb-0"><?=$row->reward?></p>
                                        <h5 class="text-dark mb-2"><?=poin($row->poin)?></h5>
                                    </div>

                                </div>
                                <div class="d-grid">
                                <?php
                                if($row->id_peringkat <= $peringkat_member){
                                    if($row->poin <= $poin){
                                        if($cbr->cek_klaim_reward($row->id, $session_member_id)){
                                    ?>
                                    <button type="button" class="btn btn-success fw-bold btn-sm py-2 rounded-pill shadow-sm btn-block text-light" disabled> <i class="fa fa-badge-check"></i> SUDAH DI KLAIM</button>
                                    <?php
                                        } else {                                    
                                    ?>
                                    <button type="button" class="btn btn-default fw-bold btn-sm py-2 rounded-pill shadow-sm btn-block"
                                    onclick="konfirmasi('<?=$row->id?>')">KLAIM REWARD</button>
                                    <?php
                                        }
                                    } else {
                                    ?>
                                    <button type="button" class="btn btn-default fw-bold btn-sm py-2 rounded-pill shadow-sm btn-block" disabled>POIN TIDAK CUKUP</button>
                                    <?php
                                    }
                                }else{
                            ?>
                                <a href="<?=site_url('status_member')?>" class="btn btn-dark fw-bold btn-sm py-2 rounded-pill fw-bold shadow-sm btn-block">CAPAI <?=strtoupper($row->nama_peringkat)?></a>
                                <?php
                                }                    
                            ?>

                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade bs-example-modal-md" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form action="controller/bonus_reward/klaim_reward.php" id="formKlaimReward" method="post">
                    <div class="modal-header border-0">
                        <h5 class="modal-title">Konfirmasi Klaim Reward</h5>
                        <button type="button" class="btn btn-default-warning" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <input type="hidden" id="id_bonus_reward_setting" name="id_bonus_reward_setting">
                        <div id="reward-container">

                        </div>
                        Apa anda yakin akan mengklaim reward ini?
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-default btn-sm py-2 px-4 fw-bold rounded-pill" id="btnSubmit"> Ya, Klaim Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include 'view/auth/form_cek_pin.php'; ?>
</main>
<?php include 'view/layout/nav-bottom.php'; ?>
<?php include 'view/layout/assets_js.php'; ?>
<script>
    var blockFirstForm = $('#blockFirstForm');
    var blockNextForm = $('#blockNextForm');
    var formKlaimReward = $('#formKlaimReward');
    var modalConfirm = $('#modalConfirm');
    var formCekPIN = $('#formCekPIN');
    var btnSubmit = $('#btnSubmit');
    
    $(document).ready(function () {

        btnSubmit.on("click", function (e) {
            modalConfirm.modal('hide');
            blockFirstForm.hide();
            blockNextForm.show();
            $('input[name=old_pin1]').focus();
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
                        formKlaimReward.submit();
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

        formKlaimReward.on("submit", function (e) {
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
                        var redirect_url = 'riwayat_klaim_reward';
                        show_success_html(obj.message, redirect_url);
                    } else {
                        var redirect_url = 'riwayat_klaim';
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

    function konfirmasi(id){
        $("#reward-container").html($("#reward-desc").html());
        $('#id_bonus_reward_setting').val(id);
        modalConfirm.modal('show');
    }
</script>
<?php include 'view/layout/footer.php'; ?>