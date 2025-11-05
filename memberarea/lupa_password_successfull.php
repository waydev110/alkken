<?php 
    date_default_timezone_set("Asia/Jakarta");
    
    require_once ("../model/classSetting.php");

    $s = new classSetting();
    $sitename = $s->setting('sitename');
    $site_pt = $s->setting('site_pt');
    $theme = $s->setting('theme_memberarea');
?>
<?php require_once("view/layout/header.php"); ?>

<main class="h-100 has-header">
    <div class="row h-100 overflow-auto">
        <div class="col-12 text-center px-0">
            <header class="header">
                <div class="row">
                    <div class="col">
                        <div class="logo-login">
                            <img src="../logo.png" width="140">
                        </div>
                    </div>
                </div>
            </header>
        </div>
    </div>
    <!-- main page content -->
    <div class="main-container container pt-0 d-flex flex-column h-100 ">
        <div class="row">
            <div class="col-12 mt-5 mb-3">
                <h5 class="text-center mb-2">Permintaan lupa password berhasil dikirim</h5>
                <p class="text-center mb-2">Silahkan coba login kembali.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-grid mb-4 ">
                <a href="login.php" class="btn btn-primary btn-lg shadow-sm">Login</a>
            </div>
        </div>
    </div>
    <!-- main page content ends -->
</main>
<!-- Page ends-->
<?php require_once("view/layout/assets_js.php"); ?>
<?php require_once("view/layout/footer.php"); ?>