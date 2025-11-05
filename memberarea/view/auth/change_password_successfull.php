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
                <div class="col-12 mt-5 mb-3">
                    <h5 class="text-center mb-2">Password Berhasil di Update</h5>
                    <p class="text-center mb-2">Password digunakan untuk masuk kehalaman member dan bertransaksi.</p>
                </div>
            </div>
            <div class="row">
                <div class="col d-grid mb-4">
                    <a href="<?=site_url('profil')?>" class="btn btn-default btn-lg shadow-sm">Kembali</a>
                </div>
            </div>
        </div>
        <!-- main page content ends -->
    </main>
    <!-- Page ends-->
    <?php include 'view/layout/assets_js.php'; ?>
    <script>
        $(document).ready(function() {
            setTimeout(function () {
                window.location.href = "<?=site_url('profil')?>";
            }, 5000);
        });
    </script>
    <?php include 'view/layout/footer.php'; ?>