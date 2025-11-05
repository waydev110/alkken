<?php
$node = array();
$action = array();
$upline = array();
require_once 'part/function_titik_pohon_jaringan_netborn.php';

$upline_root = null;
$id_member = $session_member_id;
$cm = new classMember();
if (isset($_GET['id_member'])) {
    $id = $_GET['id_member'];
    $member = $cm->genealogy($id, $session_member_id);
    if (!empty($member)) {
        $id_member = $member->id;
        if ($member->id <> $session_member_id) {
            $upline_id = $member->upline;
            $upline_root = $cm->detail($upline_id)->id_member;
        }

        if (!$cm->cek_upline($id_member, $session_member_id)) {
            $id_member = $session_member_id;
        }
    }
}
// $kaki_kiri = $cm->toDownline($id_member, 'kiri');
// $kaki_kanan = $cm->toDownline($id_member, 'kanan');
$member = $cm->detail($id_member);
if($member && $id_member <> $session_member_id){
    $member_search = $_GET['id_member'];
} else {
    $member_search = '';
    $id_member = $session_member_id;
}
?>
<?php include 'view/layout/header.php'; ?>
<style>
    .form-container {
        display: none;
    }
    .form-container.active {
        animation: slideDown 0.5s forwards;
        display: block;
    }
    .mu-contact-form .form-group {
        position: relative;
    }
    .mu-contact-form .form-group input {
        border-radius: 0;
        color: #333;
        font-size: 14px;
        border: 1px #cccccc;
        border-style: none none solid none;
        height: 45px;
        padding: 0 25px;
        margin-bottom: 24px;
        -webkit-transition: all 0.5s;
        -o-transition: all 0.5s;
        transition: all 0.5s;
    }
    .btn-sm span {
        font-size: 14px;
    }
    
    .plan-member {
        font-family: "Satisfy", cursive;
        font-weight: 400;
        font-style: normal;
        /* display: block;
        position: relative;
        top: -35px; */
        text-align: center;
        font-size: 12px;
        margin: 0 auto;
        width: 100%;
    }

    @keyframes slideDown {
        0% {
            transform: translateY(-100%);
        }

        100% {
            transform: translateY(0);
        }
    }
</style>

<link rel="stylesheet" href="assets/css/style-pohon-jaringan.css">
<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>

<!-- Sidebar main menu ends -->

<!-- Begin page -->
<main class="h-100 has-header">
    <!-- Header -->
    <header class="header position-fixed bg-theme">
        <div class="row">
            <?php include 'view/layout/back.php'; ?>
            <div class="col align-self-center">
                <h5><?= $title ?></h5>
            </div>
            <div class="col-auto align-self-center text-end">
                <div class="form-group">
                    <button type="button" class="btn btn-sm btn-transparent rounded-pill text-light d-flex align-items-center gap-2" id="btnSearch"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
    </header>
    <div class="form-container <?=$member_search == '' ? '' : 'active'?>">
        <form id="frmSearch" class="mu-contact-form" action="<?= $_SERVER['PHP_SELF'] ?>" method="get" accept-charset="utf-8">
            <!-- Search -->
            <div class="form-group">
                <input type="hidden" name="go" value="genealogy_netborn">
                <input type="text" class="form-control" id="id_member" name="id_member" value="<?=$member_search?>" placeholder="Cari Member..">
            </div>
        </form>
    </div>

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4">
        <div class="row">
            <div class="col-12">
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <?php
                // if ($kaki_kiri) {
                    // echo '<a href="?go=genealogy_netborn&id_member=' . $kaki_kiri->id_member . '" class="btn btn-sm btn-outline-primary fw-bold" style="width:100px">KAKI KIRI<br><i class="fa fa-arrow-left"></i></a>';
                // }
                // if ($member->kaki_kiri) {
                    // $get_downline = $cm->getEndLevel($member->kaki_kiri);
                    // if ($get_downline) {
                        // echo '<br><br><a href="?go=genealogy_netborn&id_member=' . $get_downline->id_member . '" class="btn btn-sm btn-outline-primary fw-bold" style="width:100px">END LEVEL<br><i class="fa fa-arrow-down"></i></a>';
                    // }
                // }
                ?>

            </div>
            <div class="col-4 align-self-center text-center">
                <?php
                echo $upline_root === null ? '' : '<a href="?go=genealogy_netborn&id_member=' . $upline_root . '" class="btn btn-sm btn-outline-primary fw-bold" style="width:100px"><i class="fa fa-angle-up"></i><br>UPLINE</a>';
                ?>
            </div>
            <div class="col-4 text-end">
                <?php
                // if ($kaki_kanan) {
                //     echo '<a href="?go=genealogy_netborn&id_member=' . $kaki_kanan->id_member . '" class="btn btn-sm btn-outline-primary fw-bold" style="width:100px">KAKI KANAN<br><i class="fa fa-arrow-right"></i></a>';
                // }
                // if ($member->kaki_kanan) {
                    // $get_downline = $cm->getEndLevel($member->kaki_kanan);
                    // if ($get_downline) {
                    //     echo '<br><br><a href="?go=genealogy_netborn&id_member=' . $get_downline->id_member . '" class="btn btn-sm btn-outline-primary fw-bold" style="width:100px">END LEVEL<br><i class="fa fa-arrow-down"></i></a>';
                    // }
                // }
                ?>
            </div>
        </div>

        <!-- chat user list -->
        <div class="row">
            <div class="col-12 px-2 border-0">
                <div class="table-responsive text-center">
                    <ul class="tree mt-2">
                        <li>
                            <?php

                            titik($id_member, $upline_root, true, 1);
                            ?>
                            <ul>
                                <li>
                                    <?php
                                    titik($node[1][1], $upline[1][1], $action[1][1], 2);
                                    ?>
                                    <ul class="hidden-xs">
                                        <li>
                                            <?php
                                            titik($node[2][1], $upline[2][1], $action[2][1], 3);
                                            ?>
                                            <ul class="hidden-md hidden-sm">
                                                <li>
                                                    <?php
                                                    titik($node[3][1], $upline[3][1], $action[3][1]);
                                                    ?>
                                                </li>
                                                <li>
                                                    <?php
                                                    titik($node[3][2], $upline[3][2], $action[3][2]);
                                                    ?>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <?php
                                            titik($node[2][2], $upline[2][2], $action[2][2], 3);
                                            ?>
                                            <ul class="hidden-md hidden-sm">
                                                <li>
                                                    <?php
                                                    titik($node[3][1], $upline[3][1], $action[3][1]);
                                                    ?>
                                                </li>
                                                <li>
                                                    <?php
                                                    titik($node[3][2], $upline[3][2], $action[3][2]);
                                                    ?>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <?php
                                    titik($node[1][2], $upline[1][2], $action[1][2], 2);
                                    ?>
                                    <ul class="hidden-xs">
                                        <li>
                                            <?php
                                            titik($node[2][1], $upline[2][1], $action[2][1], 3);
                                            ?>
                                            <ul class="hidden-md hidden-sm">
                                                <li>
                                                    <?php
                                                    titik($node[3][1], $upline[3][1], $action[3][1]);
                                                    ?>
                                                </li>
                                                <li>
                                                    <?php
                                                    titik($node[3][2], $upline[3][2], $action[3][2]);
                                                    ?>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <?php
                                            titik($node[2][2], $upline[2][2], $action[2][2], 3);
                                            ?>
                                            <ul class="hidden-md hidden-sm">
                                                <li>
                                                    <?php
                                                    titik($node[3][1], $upline[3][1], $action[3][1]);
                                                    ?>
                                                </li>
                                                <li>
                                                    <?php
                                                    titik($node[3][2], $upline[3][2], $action[3][2]);
                                                    ?>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div style='clear:both'></div><br>
        </div>
    </div>
    </div>
    <?php include 'view/layout/nav-bottom.php'; ?>
    <!-- Page ends-->
    <?php include 'view/layout/assets_js.php'; ?>
    <script>
        $(document).ready(function() {
            var btnSearch = $('#btnSearch');
            var frmSearch = $('#frmSearch');

            btnSearch.on("click", function(e) {
                if($('.form-container').hasClass('active')){
                    frmSearch.submit();
                } else {
                    btnSearch.html('<span>Cari Member</span> <i class="fa fa-search"></i>');
                    $('#id_member').text('');
                    $('.form-container').addClass('active');
                }
            });
        });
    </script>
    <?php include 'view/layout/footer.php'; ?>