<style>
    .menu-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .main-menu {
        width: 70px;
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

$home_menu = $cmenu->home_menu($show_modul);

if($home_menu->num_rows > 0) {
?>
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mt-4 mb-0">
            <div class="card-body">
                <div class="menu-container rounded-0 text-center">
                    <?php 
                        require_once '../model/classMember.php';
                        $cm = new classMember();
                        $member_akun = $cm->detail($session_member_id);
                        while ($row = $home_menu->fetch_object()) {
                            // if($row->url == 'genealogy_level') {
                                // if ($member_akun->id_plan >= 15 && $member_akun->id_plan <= 17 ) {
                            ?>
                            <div class="main-menu">
                                <a href="<?= site_url($row->url) ?>" class="size-32">
                                    <div class="icon-menu icon-menu-30">
                                        <img src="../images/icons/<?=$row->icon?>" alt="">
                                    </div>
                                    <p class="text-black fw-normal size-11 mt-m-5"><?=$row->name?></p>
                                </a>
                            </div>
                            <?php
                                // }
                            // } else {
                            ?>
                            <!--<div class="main-menu">-->
                            <!--    <a href="<?= site_url($row->url) ?>" class="size-32">-->
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
<?php } ?>