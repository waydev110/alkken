<?php 
    
    require_once '../model/classMemberPeringkat.php';
    require_once '../model/classMember.php';
    $cm = new classMember();
    $genealogy = $cm->genealogy_member($session_member_id);
    $member = $cm->detail($session_member_id);
    
    if($member->kaki_kiri == NULL){
        $link_kiri = '<a href="?go=member_create&upline='.base64_encode($member->id).'" class="text-success"><i class="fa fa-plus"></i></a>';
        $link_kanan = '<span class="text-danger"><i class="fa fa-times"></i></span>';
    } else if($member->kaki_kanan == NULL){
        $link_kiri = $member->kaki_kiri;
        $link_kanan = '<a href="?go=member_create&upline='.base64_encode($member->id).'" class="text-success"><i class="fa fa-plus"></i></a>';
    } else {
        $link_kiri = $member->kaki_kiri;
        $link_kanan = $member->kaki_kanan;
    }
    if($_binary == true){
        $poin_pasangan = $cm->jumlah_poin_pasangan($session_member_id);
    }
?>
<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>

<!-- Sidebar main menu ends -->
<link rel="stylesheet" href="assets/css/style-pohon-jaringan.css">
<style type="text/css">
    .swiper-container {
        overflow-x: auto!important;
    }
    .swiper-slide.current .card-member {
        background: radial-gradient(ellipse at 30% 30%, var(--mlm-theme-color-grad-1) 0%, var(--mlm-theme-color-grad-2) 50%, var(--mlm-theme-color-grad-3) 100%);
        color: #fff!important;
        /* background-color:#080828!important;  */
    }
    .swiper-slide.current .card-member-header h2 {
        /* background: radial-gradient(ellipse at 30% 30%, var(--mlm-theme-color-grad-1) 0%, var(--mlm-theme-color-grad-2) 50%, var(--mlm-theme-color-grad-3) 100%); */
        background-color:#080828!important; 
    }
    .swiper-slide.current .card{
        /* background-color:#ddd!important;     */
        background: radial-gradient(ellipse at 30% 30%, var(--mlm-theme-color-grad-1) 0%, var(--mlm-theme-color-grad-2) 50%, var(--mlm-theme-color-grad-3) 100%);
    
    }
</style>
<!-- Begin page -->
<main class="h-100 has-header">
    <!-- Header -->
    <header class="header position-fixed bg-theme">
        <div class="row">
            <?php include 'view/layout/back.php'; ?>
            <div class="col align-self-center">
                <h5><?=$title?></h5>
            </div>
            <div class="col-auto px-4">
                <button class="btn btn-default btn-sm rounded-pill" onclick="resetFilter()">Reset Filter</button>
            </div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4">
        <div class="generasi-container">
            <div class="row mb-3">
                <div class="col">
                    <h6 class="title">Root</h6>
                </div>
            </div>    
            <div class="row mb-3">
                <div class="col">
                    <!-- swiper users connections -->
                    <div class="card-member ms-0">
                        <div class="card-member-header">
                            <h2 class="bg-theme text-white"><strong><?=$member->id?></strong></h2>
                        </div>
                        <div class="btn btn-transparent p-0 avatar avatar-80 btn-member">
                            <img src="../images/plan/<?=$member->icon_plan?>" alt="" width="100%">
                        </div>
                        <div class="card-member-body">
                            <div class="member-profile">
                                <p class="fw-semibold size-12 mb-0"><?=$member->id_member?></p>
                                <p class="size-10 text-uppercase"><?=$member->nama_samaran?></p>
                            </div>
                            <div class="member-info">
                                <span class="fw-bolder"><?=currency($member->jumlah_kiri)?></span>
                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Jumlah <?=$lang['member']?>"><i class="fas fa-users"></i></span>
                                <span class="fw-bolder"><?=currency($member->jumlah_kanan)?></span>
                            </div>
                            <?php if($_binary == true){ ?>
                            <div class="member-info">
                                <span class="fw-bolder"><?=currency($poin_pasangan->potensi_kiri)?></span>
                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Poin Pasangan"><i class="fas fa-people-arrows"></i></span>
                                <span class="fw-bolder"><?=currency($poin_pasangan->potensi_kanan)?></span>
                            </div>
                            <?php } ?>
                            <div class="member-profile px-3">
                                <a href="<?=site_url('posting_ro')?>&id_member=<?=base64_encode($session_member_id)?>" class="btn btn-sm btn-default size-10 rounded-pill">Posting RO</a>
                                <div class="row bg-light py-2 text-theme rounded-pill mt-2">
                                    <div class="col-6">
                                        <?=$link_kiri?>
                                    </div>
                                    <div class="col-6">
                                        <?=$link_kanan?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-member-body" style="display:none">
                            <div class="member-info">
                                <span>0</span>
                                <span><i class="fas fa-people-arrows"></i></span>
                                <span>0</span>
                            </div>
                            <div class="member-info">
                                <span>0</span>
                                <span><i class="fas fa-gift"></i></span>
                                <span>0</span>
                            </div>
                            <div class="member-info">
                                <span>0</span>
                                <span><i class="fas fa-repeat"></i></span>
                                <span>0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  

        </div>
        <?php 
        if($genealogy->num_rows > 0){
            $generasi = 0;
            $no = 0;
            while($row = $genealogy->fetch_object()) {
                if($row->kaki_kiri == NULL){
                    $link_kiri = '<a href="?go=member_create&upline='.base64_encode($row->id).'" class="text-success"><i class="fa fa-plus"></i></a>';
                    $link_kanan = '<span class="text-danger"><i class="fa fa-times"></i></span>';
                } else if($row->kaki_kanan == NULL){
                    $link_kiri = $row->kaki_kiri;
                    $link_kanan = '<a href="?go=member_create&upline='.base64_encode($row->id).'" class="text-success"><i class="fa fa-plus"></i></a>';
                } else {
                    $link_kiri = $row->kaki_kiri;
                    $link_kanan = $row->kaki_kanan;
                }
                // $link1 = '<a href="?go=member_create&upline='.base64_encode($row->upline).'">Register</a>';
                // $link2 = '<a href="?go=posting_ro&id_member='.base64_encode($row->id).'">Aktivasi</a>';
                $generasi = $row->generasi;
                $no++;
                $card_member[$generasi][$no] = '<div class="swiper-slide generasi-child-'.$row->generasi.' upline-'.$row->upline.'" id="'.$row->id.'" data-id="'.$row->id.'" data-upline="'.$row->upline.'" data-posisi="'.$row->posisi.'" data-level="'.$row->generasi.'">
                                                    <div class="card-member">
                                                        <div class="card-member-header">
                                                            <h2 class="bg-theme text-white"><strong>'.$row->id.'</strong></h2>
                                                        </div>
                                                        <button class="btn btn-transparent p-0 avatar avatar-80 btn-member">
                                                            <img src="../images/paket/'.$row->gambar.'" alt="" width="100%">
                                                        </button>
                                                        <div class="card-member-body">
                                                            <div class="member-profile">
                                                                <p class="fw-semibold size-12 mb-0" onclick="copyToClipboard(this)">'.$row->id_member.'</p>
                                                                <p class="size-10 text-uppercase">'.$row->nama_samaran.'</p>
                                                            </div>
                                                            <div class="member-info">
                                                                <span class="fw-bolder">'.currency($row->jumlah_kiri).'</span>
                                                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Jumlah '.$lang['member'].'"><i class="fas fa-users"></i></span>
                                                                <span class="fw-bolder">'.currency($row->jumlah_kanan).'</span>
                                                            </div>';
                                                            
                            if($_binary == true){             
                            $poin_pasangan = $cm->jumlah_poin_pasangan($row->id);
                            $card_member[$generasi][$no] .= '<div class="member-info">
                                                                <span class="fw-bolder">'.currency($poin_pasangan->potensi_kiri).'</span>
                                                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Poin Pasangan"><i class="fas fa-people-arrows"></i></span>
                                                                <span class="fw-bolder">'.currency($poin_pasangan->potensi_kanan).'</span>
                                                            </div>';
                            }
                            $card_member[$generasi][$no] .= '<div class="member-profile px-3">
                                                                <a href="'.site_url('posting_ro').'&id_member='.base64_encode($row->id).'" class="btn btn-sm btn-default size-10 rounded-pill">Posting RO</a>
                                                                <div class="row bg-light py-2 text-theme rounded-pill mt-2">
                                                                    <div class="col-6">
                                                                        '.$link_kiri.'
                                                                    </div>
                                                                    <div class="col-6">
                                                                        '.$link_kanan.'
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-member-body" style="display:none">
                                                            <div class="member-info">
                                                                <span>0</span>
                                                                <span><i class="fas fa-people-arrows"></i></span>
                                                                <span>0</span>
                                                            </div>
                                                            <div class="member-info">
                                                                <span>0</span>
                                                                <span><i class="fas fa-gift"></i></span>
                                                                <span>0</span>
                                                            </div>
                                                            <div class="member-info">
                                                                <span>0</span>
                                                                <span><i class="fas fa-repeat"></i></span>
                                                                <span>0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
            }
            ?>
            <?php 
            foreach($card_member as $key => $value){
            ?>
            <!-- connection -->
            <div class="generasi-container">
                <div class="row mb-3">
                    <div class="col">
                        <h6 class="title">Level <?=$key?></h6>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="small data-text" data-text="<?=currency(count($value))?> <?=$lang['member']?>"><?=currency(count($value))?> <?=$lang['member']?></a>
                    </div>
                </div>    
                <div class="row mb-3">
                    <div class="col-12 px-0">
                        <!-- swiper users connections -->
                        <div class="swiper-container connectionwiper" navigation="true">
                            <div class="swiper-wrapper">
                                <?php 
                                foreach($value as $index => $card){
                                    echo $card;
                                } ?>  
                            </div>
                        </div>
                    </div>
                </div>  

            </div>
            <?php
            } 
        }?>
    </div>
</main>
<!-- Page ends-->
<?php include 'view/layout/nav-bottom.php'; ?>
<?php include 'view/layout/assets_js.php'; ?>
<script src="assets/js/jquery.isotope.min.js"></script>
<script>
    $(document).ready(function () {
        
        var swiper2 = new Swiper(".connectionwiper", {
            slidesPerView: "auto",
            spaceBetween: 0,
        });
        $('.btn-member').click(function(){
            loader_open();
            $('.swiper-slide').removeClass('active').removeClass('current');
            var id = $(this).closest('.swiper-slide').data('id');
            $('#'+id).addClass('active').addClass('current');
            $('.upline-'+id).addClass('active');

            var upline = $(this).closest('.swiper-slide').data('upline');
            
            while($('#'+upline).length > 0){
                var e = $('#'+upline);
                // var index = $('#'+upline).closest('.swiper-slide').index();
                e.addClass('active');
                upline = e.closest('.swiper-slide').data('upline');
            }

            var downline = [id];
            // console.log(downline.length);
            while(downline.length > 0){
                var temp = [];
                $.each(downline, function(index, value){
                    // console.log(value);
                    var e = $('#'+value);
                    // var index = $('#'+upline).closest('.swiper-slide').index();
                    e.addClass('active');
                    if ($('.upline-'+value).length > 0) {
                        $('.upline-'+value).each(function(){
                            var newID = $(this).data('id');
                            temp.push(newID);
                        });
                    }
                });
                downline = temp;
                // console.log(downline);
                }
            $('.swiper-slide').show();
            $('.swiper-slide').not('.active').hide();
            loader_close();
        });
    });
    function resetFilter() {
        loader_open();
        $('.swiper-slide').removeClass('active').removeClass('current');
        $('.swiper-slide').show();
        loader_close();
    }
    
</script>
<?php include 'view/layout/footer.php'; ?>