<?php 
    require_once '../model/classMember.php';
    $cm = new classMember();
    require_once '../model/classPaket.php';
    $obj = new classPaket();
    $paket = $obj->index_status();
    $member = $cm->detail($session_member_id);
    $paket_member = $member->id_paket;
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
        border: 3px solid #1f0000;
    }
    table.table-status tr td {
        padding : 1.5rem;
    }
    @media (max-width: 1199.97px) {
        .accordion-title {
            display:none
        }
    }
    @media (min-width: 1199.98px) {
        .accordion{
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: wrap;
            margin-right: calc(var(--mlm-padding) * -1);
            margin-left: calc(var(--mlm-padding) * -1);
        }
        .accordion-item {
            flex: 0 0 auto;
            width: 12%;
        }
        .accordion-title{
            width: 28%;
        }
        .accordion-flush .accordion-item:first-child {
            border-top: 3px solid #ffffff;
        }
        .accordion-item.current-status {
            border-top: 3px solid #15374c!important;
        }
        .accordion-item.another-status {
            border-top: 3px solid #ffffff;
        }
       .accordion-item .collapse:not(.show) {
            display: block;
        }
        .accordion-button {
            padding: 1rem 1rem
        }
        .accordion-button::after {
            display:none !important;
        }
        .accordion-header {
            height:90px;
        }
        .accordion-header .size-18 {
            font-size: 14px;
        }
        .accordion-body {
            padding:1rem 0;
        }
        .accordion-body .size-18 {
            font-size: 12px;
        }
        .accordion-body .mt-4 {
            margin-top:20px
        }
        .accordion-body .status-member{
            display:none;
        }
        table.table-status tr td:first-child{
            display:none
        }
        table.table-status tr td:last-child{
            display:block;
            height: 65px;
            width: 100%;
            padding:20px 0;
            text-align:center;
            font-size:14px;
        }
        table.table-label tr td:last-child{
            display: flex;
            align-items: center;
            height: 65px;
            width: 100%;
            padding:0 20px;
            text-align:center;
            font-size:14px;
        }
        .height-100 {
            height: 100%;
        }
        .accordion-title .accordion-header {
            padding-top:25px;
            padding-left:20px;
            padding-right:20px;
        }
        .accordion-title table tr td {
            padding-left:20px;
            padding-right:20px;
            text-align:left!important;
        }
        .collapsing{
            transition:none !important;
        }
        .label-status {
            display:none
        }
        .accordion-header .row, .accordion-button {
            display:block;
        }
        .accordion-header .row .col-auto {
            padding:0 0 10px 0;
            margin:0 auto;
            text-align:center;
        }
        .accordion-header .row .col-auto .avatar {
            margin-right:0;
        }
        .accordion-header .row .col {
            padding:0 0 10px 0;
            margin:0 auto;
            text-align:center;
        }
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
            </div>
        </div>
    </header>
    <div class="main-container container pt-4 pb-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="accordion accordion-flush overflow-hidden"
                    id="statusMember">
                    <div class="accordion-item mb-2 bg-white rounded-15 accordion-title">
                        <h2 class="accordion-header ">
                            <div class="accordion-button bg-white d-flex align-content-center align-self-center align-bottom height-100"> 
                                Status <?=$lang['member']?>
                            </div>
                        </h2>
                        <div>
                            <div class="accordion-body">
                                <table class="table table-borderless table-striped table-primary table-label mt-4">
                                    <tbody>
                                        <tr>
                                            <td><span class="text-warning pe-2"><i class="fad fa-check-double"></i></span> Syarat Poin RO</td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-warning pe-2"><i class="fad fa-check-double"></i></span> Syarat Sponsori</td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-theme pe-2"><i class="fad fa-percent"></i></span> Bonus <?=$lang['sponsor']?></td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-theme pe-2"><i class="fad fa-percent"></i></span> Bonus Cashback setiap belanja ulang</td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-theme pe-1"><i class="fad fa-chart-network"></i></span> Bonus Generasi</td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-theme pe-1"><i class="fad fa-gift"></i></span> Klaim Reward</td>
                                        </tr>
                                        <!-- <tr>
                                            <td><div class="row"><div class="col-auto align-self-center pe-0"><span class="text-theme"><i class="fad fa-chart-mixed"></i></span></div><div class="col ps-2">Poin Reward</div></div></td>
                                        </tr> -->
                                        <!-- <tr>
                                            <td><span class="text-theme pe-1"><i class="fad fa-headset"></i></span> Manager Support</td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-theme pe-1"><i class="fad fa-star-shooting"></i></span> Acara VIP</td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php 
                    while($row = $paket->fetch_object()) {
                        $expanded = $row->id == $paket_member ? 'true' : 'false';
                        $collapsed = $row->id == $paket_member ? 'show' : '';
                    ?>
                    <div class="accordion-item mb-2 bg-white rounded-15 <?=$row->id == $paket_member ? 'current-status':'another-status' ?>">
                        <h2 class="accordion-header " id="flush-<?=$row->id?>">
                            <div class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapse<?=$row->id?>" aria-expanded="<?=$expanded?>"
                                aria-controls="flush-collapse<?=$row->id?>">                                
                                <div class="row">
                                    <div class="col-auto align-self-center pe-0">
                                        <div class="avatar avatar-60">
                                            <img src="../images/paket/<?=$row->gambar?>" alt="">
                                        </div>
                                    </div>
                                    <div class="col align-self-center ps-0">
                                        <p class="size-11 mb-0 label-status">Status</p>
                                        <p class="text-color-theme size-18 mb-0">
                                            <?=$row->nama_paket?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </h2>
                        <div id="flush-collapse<?=$row->id?>" class="accordion-collapse collapse <?=$collapsed?>"
                            aria-labelledby="flush-<?=$row->id?>" data-bs-parent="#statusMember">
                            <div class="accordion-body">
                                <?php 
                                    if($row->id == $paket_member) {
                                ?>
                                <p class="text-color-theme size-18 mb-0 fw-bold status-member">Status anda saat ini</p>
                                <?php 
                                    }
                                ?>
                                <table class="table table-borderless table-striped table-primary table-status mt-4">
                                    <tbody>
                                        <tr>
                                            <td><span class="text-warning pe-2"><i class="fad fa-check-double"></i></span> Syarat poin</td>
                                            <td width="120"><?=poin($row->poin)?></td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-warning pe-2"><i class="fad fa-check-double"></i></span> Syarat Referral</td>
                                            <td><?=currency($row->sponsori)?></td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-theme pe-2"><i class="fad fa-percent"></i></span> Bonus <?=$lang['sponsor']?></td>
                                            <?php if($row->persentase_bonus_sponsor <= 0) { ?>
                                                <td><span class="text-danger size-18"><i class="fa fa-times"></i></span></td>
                                            <?php } else if($row->persentase_bonus_sponsor == 100) { ?>
                                                <td><span class="text-success size-18"><i class="fa fa-check"></i></span></td>
                                            <?php } else { ?>
                                                <td><?=percent($row->persentase_bonus_sponsor)?></span></td>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <td><span class="text-theme pe-2"><i class="fad fa-percent"></i></span> Bonus Cashback setiap belanja ulang</td>
                                            <?php if($row->persentase_bonus_cashback <= 0) { ?>
                                                <td><span class="text-danger size-18"><i class="fa fa-times"></i></span></td>
                                            <?php } else if($row->persentase_bonus_cashback == 100) { ?>
                                                <td><span class="text-success size-18"><i class="fa fa-check"></i></span></td>
                                            <?php } else { ?>
                                                <td><?=percent($row->persentase_bonus_cashback)?></span></td>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <td><span class="text-theme pe-0"><i class="fad fa-chart-network"></i></span> Bonus Generasi</td>
                                            <td><?=$row->id == 1 ? '' : '<span class="text-success size-18"><i class="fa fa-check"></i></span>'?></td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-theme pe-1"><i class="fad fa-gift"></i></span> Klaim Reward</td>
                                            <td><span class="text-success size-18"><i class="fa fa-check"></i></span></td>
                                        </tr>
                                        <!-- <tr>
                                            <td><span class="text-theme pe-1"><i class="fad fa-headset"></i></span> Manager Support</td>
                                            <td><?=$row->id == 1 ? '' : '<span class="text-success size-18"><i class="fa fa-check"></i></span>'?></td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-theme pe-1"><i class="fad fa-star-shooting"></i></span> Acara VIP</td>
                                            <td><?=$row->id == 1 ? '' : '<span class="text-success size-18"><i class="fa fa-check"></i></span>'?></td>
                                        </tr> -->
                                    </tbody>
                                </table>
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
</main>
<?php include 'view/layout/nav-bottom.php'; ?>
<?php include 'view/layout/assets_js.php'; ?>
<script>
    function addToCartReward(id_produk) {
        var qty = $("#qty").val();
        $.ajax({
            url: "controller/member_order/add_to_cart.php",
            data: {
                id_produk: id_produk,
                qty: qty
            },
            type: "POST",
            beforeSend: function () {
                loader_open();
            },
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('.count-indicator').text(obj.count);
                }
            },
            complete: function () {
                loader_close();
            }
        });
    }
</script>
<?php include 'view/layout/footer.php'; ?>