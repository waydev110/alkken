<?php
    require_once '../model/classBonusPasangan.php';
    
    $cbp = new classBonusPasangan();
    $id_plan_pasangan = 4;
    $plan = $cpl->show($id_plan_pasangan);
    $bonus_pasangan = $plan->bonus_pasangan;
    $show_name = $plan->show_name;
    $created_at = date('Y-m-d H:i:s');
    $tanggal_last_rekap = $cbp->tanggal_last_rekap();
    $total_terpasang_member = $cbp->total_terpasang_member($id_plan_pasangan, $created_at);
    // $total_aktivasi = $cka->total_aktivasi($tanggal_last_rekap, $created_at);
    $total_aktivasi_register = $cka->total_aktivasi($tanggal_last_rekap, $created_at, 0);
    $total_aktivasi_ro = $cka->total_aktivasi($tanggal_last_rekap, $created_at, 1);
    
    $total_aktivasi = $total_aktivasi_register + $total_aktivasi_ro;
    // $total_aktivasi = $cka->total_aktivasi($tanggal_last_rekap, $created_at);
    $index_pasangan = 0;
    if($total_terpasang_member > 0){
        $index_pasangan = $total_aktivasi/$total_terpasang_member;
    }
    $nominal_bonus = floor($bonus_pasangan*$index_pasangan);
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
<!-- <div class="row"> -->
    <!-- <div class="swiper-container poinswiper mt-1">
        <div class="swiper-wrapper">
            <div class="swiper-slide"> -->
                <div class="card shadow-sm mt-4 mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col text-center align-self-center">
                                <p class="text-theme fw-bold size-12 mb-0">Pairing</p>
                                <p><?=currency($total_terpasang_member)?></p>
                            </div>
                            <div class="col text-center align-self-center">
                                <p class="text-theme fw-bold size-12 mb-0">Member : <?=currency($total_aktivasi_register)?></p>
                                <p class="text-theme fw-bold size-12 mb-0">RO Plan B : <?=currency($total_aktivasi_ro)?></p>
                                <p class="text-theme fw-bold size-12 mb-0">Total : <?=currency($total_aktivasi)?></p>
                            </div>
                            <div class="col text-center align-self-center">
                                <p class="text-theme fw-bold size-12 mb-0">Prediksi Bonus Pasangan</p>
                                <p><?=rp($nominal_bonus)?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- </div>
        </div>
    </div> -->
<!-- </div> -->