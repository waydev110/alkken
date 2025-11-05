<?php
require_once '../model/classPlan.php';
$cpl = new classPlan();
$reward = $cpl->index_reward();
$reward_pribadi = $cpl->index_reward_pribadi();
?>
<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>
<style>
    .menu-container {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-wrap: wrap;
    }

    .main-menu {
        width: 100px;
        text-align: center;
    }

    .main-menu a {
        display: block;
        margin: 0 auto;
        text-align: center;
    }
</style>
<?php
require_once '../model/classMenu.php';

$cmenu = new classMenu();

$kategori_menu = $cmenu->kategori_menu();
?>
<!-- Begin page -->
<main class="h-100 has-header">
    <!-- Header -->
    <header class="header position-fixed bg-theme">
        <div class="row">
            <?php include 'view/layout/back.php'; ?>
            <div class="col align-self-center pt-1">
                <h5><?= $title ?></h5>
            </div>
            <div class="col-auto px-4"></div>
        </div>
    </header>
    <div class="main-container container mt-4 mb-4">
        <?php
        if ($kategori_menu->num_rows > 0) {
            while ($data = $kategori_menu->fetch_object()) {
                $menus = $cmenu->menu_by_kategori($data->id, $show_modul);
                if ($menus->num_rows > 0) {
        ?>
                <div class="row mt-3">
                    <div class="col py-2">
                        <h5 class="title text-primary"><?= $data->kategori ?></h5>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow-sm mt-0 mb-0">
                                <div class="card-body">
                                    <div class="menu-container rounded-0">
                                        <?php
                                        require_once '../model/classMember.php';
                                        $cm = new classMember();
                                        $member_akun = $cm->detail($session_member_id);
                                        while ($row = $menus->fetch_object()) {
                                            // if($row->url == 'genealogy_level') {
                                            //     if ($member_akun->id_plan >= 15 && $member_akun->id_plan <= 17 ) {
                                        ?>
                                            <div class="main-menu">
                                                <a href="<?= site_url($row->url) ?>">
                                                    <div class="icon-menu icon-menu-30">
                                                        <img src="../images/icons/<?=$row->icon?>" alt="">
                                                    </div>
                                                    <p class="text-black fw-normal size-11 mt-m-5"><?=$row->name?></p>
                                                </a>
                                            </div>
                                        <?php
                                            //     }
                                            // } else {
                                        ?>
                                            <!--<div class="main-menu">-->
                                            <!--    <a href="<?= site_url($row->url) ?>">-->
                                            <!--        <div class="icon-menu icon-menu-30">-->
                                            <!--            <img src="../images/icons/<?=$row->icon?>" alt="">-->
                                            <!--        </div>-->
                                            <!--        <p class="text-black fw-normal size-11 mt-m-5"><?=$row->name?></p>-->
                                            <!--    </a>-->
                                            <!--</div>-->
                                        <?php
                                            // }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
        <?php
            }
        }
        ?>
    </div>
</main>
<!-- Page ends-->
<?php include 'view/layout/nav-bottom.php'; ?>
<?php include 'view/layout/assets_js.php'; ?>
<script src="assets/js/jquery.isotope.min.js"></script>
<?php include 'view/layout/footer.php'; ?>