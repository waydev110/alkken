<?php 
// if(isset($_GET['berita_detail']) && isset($_GET['title'])){
    require_once '../model/classBerita.php';
    $cb = new classBerita();
    $berita = $cb->show_member($_GET['title']);
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
                <div class="col align-self-center text-left">
                    <h5><?=$title?></h5>
                </div>
            </div>
        </header>      
        <!-- Header ends -->

        <!-- main page content -->
        <div class="main-container container pt-4 pb-4">   
            <div class="row">
                <?php
                if($berita) {
                ?>
                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <figure class="rounded-15 position-relative h-auto overflow-hidden shadow-sm">
                                <img src="../images/berita/<?=$berita->gambar?>" alt="<?=$berita->gambar?>" width="100%">
                            </figure>
                        </div>
                        <div class="col-12">
                            <h2 class="mb-0"><?=$berita->judul?></h2>
                            <h6 class="mb-4 text-muted"><?=tgl_indo($berita->created_at)?></h6>
                            <?=$berita->isi?>
                        </div>
                    </div>
                </div>
                <?php
                } else {
                ?>
                <div class="col-12">
                    <p class="small text-muted">Belum ada berita.</p>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
        <!-- main page content ends -->
    </main>
    <!-- Page ends-->
    <?php include 'view/layout/assets_js.php'; ?>
    <?php include 'view/layout/footer.php'; ?>
<?php
// } else {
//     header("Location:index.php?go=berita");
// }
?>