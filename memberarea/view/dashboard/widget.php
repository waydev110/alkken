<?php
require_once '../model/classBonus.php';
$cbns = new classBonus();
// $top_sponsor = $cm->top_sponsor(date("Y-m"));
// $top_income = $cbns->top_income(date("Y-m"));
$top_sponsor = $cm->top_sponsor();
$top_income = $cbns->top_income();
$top_ro = $cm->top_ro();

// $total_pending_bonus = $cbns->total_pending_bonus($session_member_id);
// $total_penarikan = $cbns->total_penarikan($session_member_id);
$bonus_sponsor = $cbns->riwayat_bonus('bonus_sponsor', $session_member_id);
$bonus_sponsor_monoleg = $cbns->riwayat_bonus('bonus_sponsor_monoleg', $session_member_id);
$bonus_pasangan = $cbns->riwayat_bonus('bonus_pasangan', $session_member_id);
$bonus_pasangan_level = $cbns->riwayat_bonus('bonus_pasangan_level', $session_member_id);
$bonus_generasi = $cbns->riwayat_bonus('bonus_generasi', $session_member_id);
$bonus_cashback = $cbns->riwayat_bonus('bonus_cashback', $session_member_id);
// $bonus_insentif = $cbns->riwayat_bonus('insentif', $session_member_id);
$bonus_reward = $cbns->riwayat_bonus('bonus_reward', $session_member_id);
// $bonus_reward_ro = $cbns->riwayat_bonus('bonus_reward_ro',$session_member_id);
// $bonus_pasangan_plan_b = $cbns->riwayat_bonus('bonus_pasangan_plan_b', $session_member_id);
$bonus_founder = $cbns->riwayat_bonus('bonus_founder', $session_member_id);
// $bonus_generasi = $cbns->riwayat_bonus('bonus_generasi_ro', $session_member_id);
// $bonus_matching_reward = $cbns->riwayat_bonus('bonus_matching_reward',$session_member_id);
// $bonus_reward_promo_sponsor = $cbns->riwayat_bonus('bonus_reward_promo_sponsor',$session_member_id);
// $bonus_reward_promo_poin_sponsor = $cbns->riwayat_bonus('bonus_reward_promo_poin_sponsor',$session_member_id);
// $bonus_reward_fasttrack = $cbns->riwayat_bonus('bonus_reward_fasttrack',$session_member_id);
// $bonus_reward_reseller = $cbns->riwayat_bonus('bonus_reward_reseller',$session_member_id);
?>
<style>
    .form-floating-2>label.error {
        position: absolute;
        top: 105px !important;
        font-size: 12px;
    }

    .form-textarea {
        display: block;
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 0.7rem;
        font-weight: 400;
        line-height: 1.5;
        color: #686868;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        appearance: none;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .text-testimoni {
        color: #686868;
    }
</style>
<!-- <div class="col-12 col-md-6 col-lg-6 order-lg-2 order-2"> -->
<div class="swiper-container home-swiper mb-0">
    <ul class="nav nav-pills mb-3 filter-button-group swiper-wrapper flex-nowrap" id="pills-tab" role="tablist">
        <li class="swiper-slide nav-item pe-1 w-auto" role="presentation">
            <button class="tag active" id="bonus-member-tab" data-bs-toggle="pill" data-bs-target="#bonusMember" type="button" role="tab" aria-controls="bonus-member" aria-selected="true">Rekap Bonus</button>
        </li>
        <li class="swiper-slide nav-item pe-1 w-auto" role="presentation">
            <button class="tag" id="testi-member-tab" data-bs-toggle="pill" data-bs-target="#testiMember" type="button" role="tab" aria-controls="testi-member" aria-selected="true">Testimonial</button>
        </li>
        <?php
        if ($top_sponsor->num_rows > 0) {
        ?>
            <li class="swiper-slide nav-item pe-1 w-auto" role="presentation">
                <button class="tag" id="top-sponsor-tab" data-bs-toggle="pill" data-bs-target="#topSponsor" type="button" role="tab" aria-controls="top-sponsor" aria-selected="true">Top
                    <?= $lang['sponsor'] ?></button>
            </li>
        <?php
        }
        ?>
        <?php
        if ($top_income->num_rows > 0) {
        ?>
            <li class="swiper-slide nav-item pe-1 w-auto" role="presentation">
                <button class="tag" id="top-income-tab" data-bs-toggle="pill" data-bs-target="#topIncome" type="button" role="tab" aria-controls="top-income" aria-selected="false">Top
                    Income</button>
            </li>
        <?php
        }
        ?>
        <?php
        if ($top_ro->num_rows > 0) {
        ?>
            <li class="swiper-slide nav-item pe-1 w-auto" role="presentation">
                <button class="tag" id="top-ro-tab" data-bs-toggle="pill" data-bs-target="#topRO" type="button" role="tab" aria-controls="top-ro" aria-selected="false">Top
                    RO</button>
            </li>
        <?php
        }
        ?>
    </ul>
</div>
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="bonusMember" role="tabpanel" aria-labelledby="bonus-member-tab">
        <div class="card bg-white shadow-sm mb-4">
            <div class="card-body p-0">
                <ul class="list-group list-group-flush border-0 border-bottom bg-none py-2">

                    <?php
                    if ($member->founder == '1') {
                    ?>
                        <?php echo vrekap_bonus($lang['bonus_founder'], $bonus_founder, 'teal') ?>
                    <?php
                    }
                    ?>
                    <?php echo vrekap_bonus($lang['bonus_sponsor'], $bonus_sponsor, 'success') ?>
                    <?php echo vrekap_bonus($lang['bonus_sponsor_monoleg'], $bonus_sponsor_monoleg, 'success') ?>
                    <?php echo vrekap_bonus($lang['bonus_pasangan'], $bonus_pasangan, 'danger') ?>
                    <?php echo vrekap_bonus($lang['bonus_pasangan_level'], $bonus_pasangan_level, 'danger') ?>
                    <!--<?php echo vrekap_bonus($lang['bonus_reward_promo_sponsor'], $bonus_reward_promo_sponsor, 'yellow') ?>-->
                    <!--<?php echo vrekap_bonus($lang['bonus_reward_promo_poin_sponsor'], $bonus_reward_promo_poin_sponsor, 'blue') ?>-->
                    <?php echo vrekap_bonus($lang['bonus_cashback'], $bonus_cashback, 'success') ?>
                    <?php echo vrekap_bonus($lang['bonus_generasi'], $bonus_generasi, 'blue') ?>
                    <?php echo vrekap_bonus($lang['bonus_reward'], $bonus_royalti_omset, 'warning') ?>
                    <?php 
                        if($_member_plan == '6'){
                            echo vrekap_bonus($lang['bonus_royalti_omset'], $bonus_support, 'dark');
                        }
                    ?>
                    <!-- <?php echo vrekap_bonus($lang['bonus_reward_ro'], $bonus_reward_plan_b, 'warning') ?> -->
                    <!-- <?php echo vrekap_bonus($lang['bonus_matching_reward'], $bonus_matching_reward, 'yellow') ?> -->
                    <!-- <?php echo vrekap_bonus($lang['bonus_reward_fasttrack'], $bonus_reward_fasttrack, 'warning') ?> -->
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="testiMember" role="tabpanel" aria-labelledby="testi-member-tab">
        <div class="card bg-white shadow-sm mb-4">
            <div class="card-body p-0">
                <ul class="list-group list-group-flush border-0 border-bottom bg-none py-2">
                    <?php
                    while ($row = $testimonies->fetch_object()) {
                    ?>
                        <li class="list-group-item py-1">
                            <div class="row">
                                <div class="col-auto pe-1">
                                    <div class="avatar avatar-40">
                                        <img src="../images/plan/<?= $row->gambar ?>" alt="">
                                    </div>
                                </div>
                                <div class="col align-self-center ps-0">
                                    <p class="text-color-theme fw-bold size-12 mb-0">
                                        <?= strtoupper($row->nama_samaran) ?>
                                    </p>
                                    <p class="fw-bold text-muted size-12"><?= $row->id_member ?></p>
                                </div>
                                <div class="col align-self-center text-end">
                                    <p class="text-color-theme size-12 mb-0">
                                        <?= tgl_indo_jam($row->created_at) ?></p>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <p class="text-testimoni size-12">
                                        <?= substr($row->testimoni, 0, 150) ?><span class="text-readmore" id="text<?= $row->id ?>" style="display:none"><?= substr($row->testimoni, 150) ?></span>
                                        <?= substr($row->testimoni, 150) <> '' ? '<a href="javascript:void(0);" class="text-bold comment-link" onclick="showComment(this, ' . "'text" . $row->id . "'" . ')">Baca Selengkapnya</a>' : '' ?>
                                    </p>
                                </div>
                            </div>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
                <span class="last-id" data-id=""></span>
                <div class="row px-3 py-2">
                    <div class="col-auto pe-0 pe-0">
                        <div class="avatar avatar-40">
                            <img src="../images/plan/<?= $member->icon_plan ?>" alt="">
                        </div>
                    </div>
                    <div class="col align-self-center ps-0">
                        <p class="text-color-theme fw-bold size-12 mb-0">
                            <?= strtoupper($member->nama_samaran) ?>
                        </p>
                        <p class="fw-bold text-muted size-12"><?= $member->id_member ?></p>
                    </div>
                </div>
                <div class="row px-3 pb-3">
                    <form action="controller/testimoni/create_testimoni.php" method="post" id="frmTestimoni">
                        <div class="col-12">
                            <div class="form-group mb-1 pb-0">
                                <textarea class="form-textarea" id="testimoni" name="testimoni" placeholder="Add a testimoni..." rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-12 text-end">
                            <button type="reset" class="btn btn-light rounded-pill">Reset</button>
                            <button type="submit" class="btn btn-default rounded-pill" id="btnSubmitTestimoni">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    if ($top_sponsor->num_rows > 0) {
    ?>
        <div class="tab-pane fade" id="topSponsor" role="tabpanel" aria-labelledby="top-sponsor-tab">
            <div class="card bg-white shadow-sm mb-4">
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush bg-none">
                        <?php
                        while ($row = $top_sponsor->fetch_object()) {
                        ?>
                            <li class="list-group-item py-1">
                                <div class="row">
                                    <div class="col-auto pe-1">
                                        <div class="avatar avatar-60">
                                            <img src="../images/plan/<?= $row->gambar ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="col align-self-center ps-0">
                                        <p class="text-color-theme size-12 mb-0">
                                            <?= strtoupper($row->nama_samaran) ?>
                                        </p>
                                        <p class="text-muted size-11"><?= $row->id_member ?></p>
                                    </div>
                                    <div class="col align-self-center text-end">
                                        <p class="text-color-theme size-12 mb-0"><?= number($row->jumlah) ?>
                                            Referral</p>
                                        <p class="text-muted size-11"><?= get_kota($row->nama_kota) ?></p>
                                    </div>
                                </div>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <?php
    if ($top_income->num_rows > 0) {
    ?>
        <div class="tab-pane fade" id="topIncome" role="tabpanel" aria-labelledby="top-income-tab">
            <div class="card bg-white shadow-sm mb-4">
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush bg-none">
                        <?php
                        while ($row = $top_income->fetch_object()) {
                        ?>
                            <li class="list-group-item py-1">
                                <div class="row">
                                    <div class="col-auto pe-1">
                                        <div class="avatar avatar-60">
                                            <img src="../images/plan/<?= $row->gambar ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="col align-self-center ps-0">
                                        <p class="text-color-theme size-12 mb-0">
                                            <?= capital_word($row->nama_samaran) ?>
                                        </p>
                                        <p class="text-muted size-11"><?= $row->id_member ?></p>
                                    </div>
                                    <div class="col align-self-center text-end">
                                        <p class="text-color-theme size-12 mb-0">
                                            <?= rp($row->total) ?></p>
                                        <p class="text-muted size-11"><?= get_kota($row->nama_kota) ?></p>
                                    </div>
                                </div>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <?php
    if ($top_ro->num_rows > 0) {
    ?>
        <div class="tab-pane fade" id="topRO" role="tabpanel" aria-labelledby="top-ro-tab">
            <div class="card bg-white shadow-sm mb-4">
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush bg-none">
                        <?php
                        while ($row = $top_ro->fetch_object()) {
                        ?>
                            <li class="list-group-item py-1">
                                <div class="row">
                                    <div class="col-auto">
                                        <div class="avatar avatar-60 ">
                                            <img src="../images/plan/<?= $row->gambar ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="col align-self-center ps-0">
                                        <p class="text-color-theme size-12 mb-0">
                                            <?= capital_word($row->nama_samaran) ?>
                                        </p>
                                        <p class="text-muted size-11"><?= $row->id_member ?></p>
                                    </div>
                                    <div class="col align-self-center text-end">
                                        <p class="text-color-theme size-12 mb-0">
                                            <?= rp($row->jumlah) ?></p>
                                        <p class="text-muted size-11"><?= get_kota($row->nama_kota) ?></p>
                                    </div>
                                </div>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>
<!-- </div> -->