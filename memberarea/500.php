<?php 
    require_once ("model/classSetting.php");

    $s = new classSetting();
    $sitename = $s->setting('sitename');
    $site_pt = $s->setting('site_pt');
    $theme = $s->setting('theme_memberarea');
?>
<?php require_once("view/layout/header.php"); ?>
    <!-- Begin page -->
    <main class="h-100 has-header">
        <!-- Header -->
        <header class="header position-fixed bg-theme">
            <div class="row">
                <?php require_once("view/layout/back.php"); ?>
                <div class="col align-self-center text-left">
                    <h5>Kembali</h5>
                </div>
            </div>
        </header>
        <!-- Header ends -->

        <!-- main page content -->
        <div class="main-container container pt-0">

            <div class="row h-100 ">
                <div class="col-12 col-md-6 col-lg-5 col-xl-3 mx-auto py-4 text-center align-self-center">
                    <figure class="mw-100 text-center p-5 mt-4 mb-3">
                        <img src="assets/img/500.png" alt="" class="mw-100">
                    </figure>
                    <h1 class="mb-0 text-color-theme">Oops!...</h1>
                    <h5 class="mb-4">Internal Server Error</h5>
                    <p class="text-muted mb-0">Something went wrong.</p>
                    <p class="text-muted mb-4">Please contact us if the problem persists.</p>

                    <a href="index.php" target="_self" class="btn btn-default btn-lg mb-4">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
    <!-- main page content ends -->
</main>
<?php require_once("view/layout/footer.php"); ?>