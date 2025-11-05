<?php 
    require_once '../model/classBerita.php';
    $cb = new classBerita();
    $berita = $cb->index_member();
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
                <div class="col align-self-center">
                    <h5><?=$title?></h5>
                </div>
            </div>
        </header>      
        <!-- Header ends -->

        <!-- main page content -->
        <div class="main-container container pt-4 pb-4">   
            <div class="row">
                <?php
                if($berita->num_rows > 0) {
                    while($row = $berita->fetch_object()){
                ?>
                <div class="col-12 col-md-6 mb-3">
                    <div class="row">
                        <div class="col-12">
                            <figure class="rounded-15 position-relative h-190 overflow-hidden shadow-sm">
                                <div class="coverimg h-100 w-100 position-absolute start-0 top-0">
                                    <img src="../images/berita/<?=$row->gambar?>" alt="">
                                </div>
                            </figure>
                        </div>
                        <div class="col-12">
                            <a href="?go=berita_detail&title=<?=$row->slug?>" class="h5 d-block text-normal mb-2"><?=$row->judul?></a>
                            <p class="small text-muted"><?=substr($row->isi,0,180)?></p>
                            <a href="?go=berita_detail&title=<?=$row->slug?>" class="text-normal small">Selengkapnya <i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <?php
                    }
                } else {
                ?>
                <div class="col-12 col-md-6 mb-3">
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
    <?php include 'view/layout/nav-bottom.php'; ?>
    <?php include 'view/layout/assets_js.php'; ?>
    <?php include 'view/layout/footer.php'; ?>