<?php
    require_once '../model/classMemberPeringkat.php';
    require_once '../model/classMember.php';

    $csp = new classMemberPeringkat();
    $cm = new classMember();

    $member = $cm->show($session_member_id);
    $downline = $cm->getDownline($session_member_id);
?>
<?php include 'view/layout/header.php'; ?>

<link rel="stylesheet" href="assets/vendor/listree/listree.min.css">
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
                <h5><?=$title?></h5>
            </div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4">
        <form action="<?=$_SERVER['PHP_SELF']?>" method="get" accept-charset="utf-8">
            <!-- Search -->
            <div class="form-group form-floating-2 mb-3">
                <input type="hidden" name="go" value="genealogy">
                <input type="text" class="form-control " id="id_member" name="id_member" placeholder="Search">
                <label class="form-control-label" for="search">Search Member</label>
                <button type="submit" class="text-color-theme tooltip-btn">
                    <i class="fa-solid fa-search"></i>
                </button>
            </div>
        </form>

        <!-- chat user list -->
        <div class="row">
            <div class="col-12 px-2 border-0">
                <ul class="listree">
                    <li>
                        <div class="listree-submenu-heading">
                            <div class="card bg-white" onclick="getDownline('<?=base64_encode($session_member_id)?>', this)">
                                <div class="card-body pt-2 ps-2 pb-0">
                                    <div class="row mb-2">
                                        <div class="col py-2 ps-4">
                                            <div class="row">
                                                <div class="col-auto pe-0">
                                                    <div class="avatar avatar-30 shadow rounded-circle">
                                                        <img src="../images/peringkat/<?=$row->gambar?>" alt="">
                                                    </div>
                                                </div>
                                                <div class="col ps-2">
                                                    <p class="mb-0 size-12"><?=$csp->show_peringkat($member->id_peringkat)?>
                                                        <?=reposisi($member->reposisi)?>
                                                    </p>
                                                        <span class="mb-0 text-dark">
                                                        <?=$member->id_member.' - '.$member->nama_member?></span>
                                                    <p class="mb-0 size-12">Tanggal Daftar : <?=tgl_indo_jam($member->created_at)?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="row mt-2 mb-2 position-relative">
                                                <div class="col pe-0">
                                                    <div class="form-group form-floating-2">
                                                        <input type="text" class="form-control pt-3 pb-2 text-left"
                                                            value="<?=$cm->sponsori($session_member_id)?>" disabled="disabled">
                                                        <label class="form-control-label pt-2">Referral</label>
                                                    </div>
                                                </div>
                                                <div class="col align-self-center ps-0">
                                                    <div class="form-group form-floating-2">
                                                        <input type="text" class="form-control pt-3 pb-2 text-end"
                                                            value="<?=$cm->total_omset($session_member_id)?>" disabled="disabled">
                                                        <label class="form-control-label text-end pt-2 pe-1 end-0 start-auto">Omset</label>
                                                    </div>
                                                </div>
                                                <button
                                                    class="btn btn-34 bg-orange text-white shadow-sm position-absolute start-50 top-50 translate-middle">
                                                    <span>0</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- main page content ends -->
</main>
<?php include 'view/layout/nav-bottom.php'; ?>
<!-- Page ends-->
<?php include 'view/layout/assets_js.php'; ?>
<!-- <script src="assets/vendor/listree/listree.umd.min.js"></script> -->
<script>
    $(document).ready(function () {
        $('.listree-submenu-heading').trigger('click');
    });

    // listree();
    function getDownline(upline, el) {
        if ($(el).closest('.listree-submenu-heading').hasClass('expanded')) {
            $(el).closest('.listree-submenu-heading').removeClass('expanded');
            $(el).closest('.listree-submenu-heading').find('ul').remove();

        } else {
            $.ajax({
                url: "controller/member/get_downline.php",
                data: {
                    upline: upline
                },
                type: "POST",
                dataType: "html",
                cache: false,
                success: function (data) {
                    $(el).closest('.listree-submenu-heading').addClass('expanded').append(data);
                }
            });
        }
    }
</script>
<?php include 'view/layout/footer.php'; ?>