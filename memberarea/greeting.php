<?php 
session_start();
require_once("model/classSetting.php");
$s = new classSetting();
$sitename = $s->setting('sitename');
$theme = $s->setting('theme_memberarea');
if(isset($_SESSION['session_user_member']) != ""){
    header("location:index.php");
}else{
?>
<!doctype html>
<html lang="en" class="h-100">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="generator" content="">
        <title><?=$lang['member']?> Area - <?=$sitename?></title>

        <!-- manifest meta -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <!-- <link rel="manifest" href="manifest.json" /> -->

        <!-- Favicons -->
        <link rel="icon" href="favicon.png" sizes="16x16" type="image/png">

        <!-- Google fonts-->

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap"
            rel="stylesheet">

        <!-- bootstrap icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

        <!-- style css for this template -->
        <link href="assets/css/style.css" rel="stylesheet" id="style">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <style>
            .g-recaptcha {
                transform:scale(1.08);
                transform-origin:0 0;
            }
            .bg-gradient {
                background: linear-gradient(180deg, rgb(9 99 28) 0%, #000000 100%) !important;
            }
            .loader-wrap:after {    
                background: linear-gradient(180deg, rgb(9 99 28) 0%, #000000 100%) !important;
            }
            .btn-default {
                background-color: #085d1a!important;
            }
            .form-floating.is-valid:before {
                content: "";
                position: absolute;
                left: 0;
                z-index: 1;
                height: 68%;
                top: 16%;
                width: 3px;
                border-radius: 2px;
                background-color: chocolate;
            }
        </style>
    </head>

    <body class="body-scroll d-flex flex-column h-100 theme-<?=$theme?>" data-page="signin">
        <main class="container-fluid h-100">
        <!-- Swiper -->
        <div class="swiper-container introswiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="row h-100">
                        <div class="col-11 col-md-8 col-lg-6 col-xl-4 mx-auto align-self-center text-center">
                            <div class="row">
                                <div class="col-ld-6">
                                    <img src="assets/img/intro1.png" alt="" class="mw-100 mx-auto mb-5">
                                </div>
                                <div class="col-ld-6">
                                    <h1 class="text-color-theme mb-4">Keep your eye on your budget</h1>
                                    <p class="size-18 text-muted">Manage your daily expenses & track your incomes with
                                        easy
                                        steps.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="row h-100">
                        <div class="col-11 col-md-8 col-lg-6 col-xl-4 mx-auto align-self-center text-center">
                            <div class="row">
                                <div class="col-ld-6">
                                    <img src="assets/img/intro2.png" alt="" class="mw-100 mx-auto mb-5">
                                </div>
                                <div class="col-ld-6">
                                    <h1 class="text-color-theme mb-4">Never feel low balance </h1>
                                    <p class="size-18 text-muted">Best tracking & Future investment gives idea about
                                        expenses risk.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="row h-100">
                        <div class="col-11 col-md-8 col-lg-6 col-xl-4 mx-auto align-self-center text-center">
                            <div class="row">
                                <div class="col-ld-6">
                                    <img src="assets/img/intro3.png" alt="" class="mw-100 mx-auto mb-5">
                                </div>
                                <div class="col-ld-6">
                                    <h1 class="text-color-theme mb-4">Ask for money in emergency </h1>
                                    <p class="size-18 text-muted">If you really get tie, Its simple to ask for help
                                        & support from contacts.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </main>


        <!-- Required jquery and libraries -->
        <script src="assets/js/jquery-3.3.1.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/vendor/bootstrap-5/js/bootstrap.bundle.min.js"></script>

        <!-- cookie js -->
        <script src="assets/js/jquery.cookie.js"></script>

        <!-- Customized jquery file  -->
        <script src="assets/js/main.js"></script>
        <script src="assets/js/color-scheme.js"></script>
    </body>

</html>

<?php 
}
?>