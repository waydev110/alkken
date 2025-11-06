<?php 
    require_once '../model/classReferall.php';
    $r = new classReferall();
    $top_sponsor = $r->top_sponsor();
?>
<?php include 'view/layout/header.php'; ?>
    <!-- loader section -->
    <?php include 'view/layout/loader.php'; ?>
    <!-- loader section ends -->


    <!-- Sidebar main menu -->
    <?php include 'view/layout/sidebar.php'; ?>

    <!-- Sidebar main menu ends -->

    <!-- Begin page -->
    <main class="h-100 has-header">
        <!-- Header -->
        <header class="header position-fixed bg-theme">
            <div class="row">
                <?php include 'view/layout/back.php'; ?>
                <div class="col align-self-center text-center">
                    <h5><?=$title?></h5>
                </div>
            </div>
        </header>      
        <!-- Header ends -->

        <!-- main page content -->
        <div class="main-container container pt-4 pb-4">
            <!-- Search -->
            <div class="form-group form-floating-2 mb-3">
                <input type="text" class="form-control " id="search" placeholder="Search">
                <label class="form-control-label" for="search">Search User</label>
                <button type="button" class="text-color-theme tooltip-btn">
                    <i class="fa-solid fa-search"></i>
                </button>
            </div>

            <!-- chat user list -->
            <div class="row">
                <div class="col-12 px-0">
                <?php
                if($top_sponsor){
                ?>
                    <div class="list-group rounded-0 bg-none">
                        <?php
                        while($row = $top_sponsor->fetch_object()){
                        ?>
                        <a href="chat-message.html" class="list-group-item">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="avatar avatar-50 coverimg rounded-10">
                                        <img src="images/<?=icon_peringkat($row->nama_peringkat)?>" alt="">
                                    </div>
                                </div>
                                <div class="col align-self-center ps-0">
                                    <p class="mb-1"><?=get_full_name($row->nama_member)?> <span class="float-end small text-muted"><?=$row->jumlah?> Referral</span></p>
                                    <p class="small text-muted"><?=$row->nama_kota?></p>
                                </div>
                            </div>
                        </a>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                }
                ?>
                </div>
            </div>

        </div>
        <!-- main page content ends -->
    </main>
    <!-- Page ends-->
    <?php include 'view/layout/nav-bottom.php'; ?>
    <?php include 'view/layout/assets_js.php'; ?>
    <?php include 'view/layout/footer.php'; ?>