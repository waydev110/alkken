<?php
    require_once '../model/classMember.php';
    $cm = new classMember();

    $member = $cm->detail($session_member_id);
    $sponsori = $cm->sponsori($session_member_id);
    $sponsori_reposisi = $cm->sponsori_reposisi($row->id);
    $info_ro = $cm->info_ro($session_member_id, 14);
    if($info_ro->total > 0){
        $jumlah_ro = '<span class="size-11 text-success fw-bold">Jumlah RO Aktif : '.$info_ro->total.'</span>';
        $tgl_ro = '<span class="size-11 text-success fw-bold">'.tgl_indo($info_ro->created_at).'</span>';
    } else {
        $jumlah_ro = '<span class="size-11 text-danger fw-bold">Belum RO Aktif</span>';
        $tgl_ro = '';
    }
    $jumlah_ro = '';
    $tgl_ro = '';
    // $downline = $cm->get_downline($session_member_id);
?>
<?php include 'view/layout/header.php'; ?>

<link rel="stylesheet" href="assets/vendor/listree/listree.min.css">
<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>

<!-- Sidebar main menu ends -->
<style>
    .card-downline{
        width: 450px;
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
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4">
        <form action="<?=$_SERVER['PHP_SELF']?>" method="get" accept-charset="utf-8">
            <!-- Search -->
            <div class="form-group form-floating-2 mb-3">
                <input type="hidden" name="go" value="genealogy_sponsor">
                <input type="text" class="form-control " id="id_member" name="id_member" placeholder="Search">
                <label class="form-control-label" for="search">Pencairan</label>
                <button type="submit" class="text-color-theme tooltip-btn">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>

        <!-- chat user list -->
        <div class="row">
            <div class="col-12 px-2 border-0">
                <ul class="listree">
                    <li>
                        <div class="listree-submenu-heading">
                            <div class="card rounded-0 bg-white w-auto" onclick="getDownline('<?=base64_encode($session_member_id)?>', 0, this)">
                                <div class="card-body pt-2 ps-4 pb-0">
                                    <div class="row mb-2 ps-2">
                                        <?php
                                        echo '<div class="col-auto align-self-center text-start">
                                                <p class="rounded-pill px-2 py-4 bg-theme text-white size-32">0</p>
                                            </div>
                                            <div class="col align-self-center ps-0">
                                                <p class="mb-0 size-12 fw-bold text-dark">'.$member->id_member.'</p>
                                                <p class="mb-0 size-12 fw-semibold text-dark">'.strtoupper($member->nama_member).'</p>
                                                <p class="mb-0 size-12 text-primary fw-bold">'.$member->nama_plan.' '.$member->short_name.'</p>
                                                '.$jumlah_ro.'
                                            </div>
                                            <div class="col-auto align-self-center text-end">
                                                <p class="mb-0 size-12 text-dark">'.tgl_indo($member->created_at).'</p>
                                                <p class="mb-0 size-12 text-dark">Jumlah Sponsori:</p>
                                                <p class="mb-0 fw-bold text-primary"><span class="size-11">B : '.currency($sponsori).' </span> | <span class="size-11">R : ('.currency($sponsori_reposisi).')</span></p>
                                                '.$tgl_ro.'
                                            </div>';
                                        ?>
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
    function getDownline(sponsor, generasi, el) {
        if ($(el).closest('.listree-submenu-heading').hasClass('expanded')) {
            $(el).closest('.listree-submenu-heading').removeClass('expanded');
            $(el).closest('.listree-submenu-heading').find('ul').remove();

        } else {
            $.ajax({
                url: "controller/member/get_downline.php",
                data: {
                    sponsor: sponsor,
                    generasi : generasi
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