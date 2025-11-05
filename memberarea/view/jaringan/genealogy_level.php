<?php
$cm = new classMember();
$member = $cm->genealogy_level($session_member_id);
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
        <div class="row pt-4 mt-4">
            <div class="col-12">
                <table class="table table-bordered">
                <tr>
                    <th>ID Member</th>
                    <th>Nama Member</th>
                    <th>Posisi</th>
                </tr>
                
            <?php
                $generasi = 0;
                while($row = $member->fetch_object()){
                    if($row->generasi > $generasi){
                ?>
                    <tr>
                        <th colspan="3">Level : <?=$row->generasi?></th>
                    </tr>
                <?php
                        $generasi = $row->generasi;
                    }
                ?>
                    <tr>
                        <td><?=$row->id_member?></td>
                        <td><?=$row->nama_samaran?></td>
                        <td><?=$row->root_posisi?></td>
                    </tr>
                <?php
                }
            ?>
                </table>
            </div>
        </div>
    </div>
    </div>
    <?php include 'view/layout/nav-bottom.php'; ?>
    <?php include 'view/layout/footer.php'; ?>