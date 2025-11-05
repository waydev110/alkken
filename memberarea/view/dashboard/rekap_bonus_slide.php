<?php
$total_pending_bonus = $cbns->total_pending_bonus($session_member_id);
$total_penarikan = $cbns->total_penarikan($session_member_id);
$bonus_sponsor = $cbns->riwayat_bonus('bonus_sponsor', $session_member_id);
$bonus_cashback = $cbns->riwayat_bonus('bonus_cashback', $session_member_id);
$bonus_pasangan = $cbns->riwayat_bonus('bonus_pasangan', $session_member_id);
$bonus_pasangan_plan_b = $cbns->riwayat_bonus('bonus_pasangan_plan_b', $session_member_id);
$bonus_founder = $cbns->riwayat_bonus('bonus_founder', $session_member_id);
$bonus_generasi = $cbns->riwayat_bonus('bonus_generasi', $session_member_id);
$bonus_support = $cbns->riwayat_bonus('bonus_support',$session_member_id);
$bonus_matching_reward = $cbns->riwayat_bonus('bonus_matching_reward',$session_member_id);
$bonus_reward = $cbns->riwayat_bonus('bonus_reward',$session_member_id);
$bonus_reward_plan_b = $cbns->riwayat_bonus('bonus_reward_plan_b',$session_member_id);
$bonus_reward_promo_sponsor = $cbns->riwayat_bonus('bonus_reward_promo_sponsor',$session_member_id);
$bonus_reward_promo_poin_sponsor = $cbns->riwayat_bonus('bonus_reward_promo_poin_sponsor',$session_member_id);
$bonus_reward_fasttrack = $cbns->riwayat_bonus('bonus_reward_fasttrack',$session_member_id);
$bonus_reward_reseller = $cbns->riwayat_bonus('bonus_reward_reseller',$session_member_id);
?>
<style>
    /* .form-control:disabled, .form-control[readonly] {
        background-color: #1f0000;
        opacity: 1;
        color:#FFFFFF;
    } */
    /* .form-control-label {
        color:#FFFFFF;
    } */
    .poinswiper .swiper-wrapper .swiper-slide {
        width: 270px;
    }
</style>
<div class="">
    <h4 class="size-18 mt-4">Bonus Plan A</h4>
    <div class="swiper-container poinswiper mt-1">
        <div class="swiper-wrapper">
            <?php 
                if($member->founder == '1'){
            ?>
            <?php echo vrekap_bonus($lang['bonus_founder'], $bonus_founder, 'teal') ?>
            <?php 
                }
            ?>
            <?php echo vrekap_bonus($lang['bonus_sponsor'], $bonus_sponsor, 'success') ?>
            <?php echo vrekap_bonus($lang['bonus_pasangan'], $bonus_pasangan, 'danger') ?>
            <?php echo vrekap_bonus($lang['bonus_support'], $bonus_support, 'dark') ?>
            <?php echo vrekap_bonus($lang['bonus_reward'], $bonus_reward, 'warning') ?>
            <?php echo vrekap_bonus($lang['bonus_reward_promo_sponsor'], $bonus_reward_promo_sponsor, 'yellow') ?>
            <?php echo vrekap_bonus($lang['bonus_reward_promo_poin_sponsor'], $bonus_reward_promo_poin_sponsor, 'blue') ?>
        </div>
    </div>
</div>
<div class="">
    <h4 class="size-18 mt-4">Bonus Plan B</h4>
    <div class="swiper-container poinswiper mt-1">
        <div class="swiper-wrapper">
            <?php echo vrekap_bonus($lang['bonus_cashback'], $bonus_cashback, 'success') ?>
            <?php echo vrekap_bonus($lang['bonus_reward_plan_b'], $bonus_reward_plan_b, 'warning') ?>
            <?php echo vrekap_bonus($lang['bonus_matching_reward'], $bonus_matching_reward, 'yellow') ?>
        </div>
    </div>
</div>
<div class="">
    <h4 class="size-18 mt-4">Bonus Fasttrack</h4>
    <div class="swiper-container poinswiper mt-1">
        <div class="swiper-wrapper">
            <?php echo vrekap_bonus($lang['bonus_reward_fasttrack'], $bonus_reward_fasttrack, 'warning') ?>
        </div>
    </div>
</div>