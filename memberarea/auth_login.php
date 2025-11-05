<?php 
require_once("helper/language.php");
require_once("model/classSetting.php");
$s = new classSetting();
$sitename = $s->setting('sitename');
$theme = $s->setting('theme_memberarea');
session_start();
if(isset($_SESSION['session_user_member']) != ""){
    header("location:index.php");
}else{
?>
<!DOCTYPE html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="assets/theme2/" data-template="vertical-menu-template">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

        <title>Login | <?=$s->setting('sitename')?></title>

        <meta name="description" content="" />

        <!-- Favicon -->
        <link rel="icon" href="../favicon.png" sizes="16x16" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
            rel="stylesheet" />

        <!-- Icons -->
        <link rel="stylesheet" href="assets/theme2/vendor/fonts/materialdesignicons.css" />
        <link rel="stylesheet" href="assets/theme2/vendor/fonts/flag-icons.css" />

        <!-- Menu waves for no-customizer fix -->
        <link rel="stylesheet" href="assets/theme2/vendor/libs/node-waves/node-waves.css" />

        <!-- Core CSS -->
        <link rel="stylesheet" href="assets/theme2/vendor/css/rtl/core.css" class="template-customizer-core-css" />
        <link rel="stylesheet" href="assets/theme2/vendor/css/rtl/theme-default.css"
            class="template-customizer-theme-css" />
        <link rel="stylesheet" href="assets/theme2/css/demo.css" />

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="assets/theme2/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
        <link rel="stylesheet" href="assets/theme2/vendor/libs/typeahead-js/typeahead.css" />
        <!-- Vendor -->
        <link rel="stylesheet" href="assets/theme2/vendor/libs/@form-validation/umd/styles/index.min.css" />

        <!-- Page CSS -->
        <!-- Page -->
        <link rel="stylesheet" href="assets/theme2/vendor/css/pages/page-auth.css" />

        <!-- Helpers -->
        <script src="assets/theme2/vendor/js/helpers.js"></script>
        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
        <script src="assets/theme2/vendor/js/template-customizer.js"></script>
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="assets/theme2/js/config.js"></script>
    </head>

    <body>
        <!-- Content -->

        <div class="position-relative">
            <div class="authentication-wrapper authentication-basic container-p-y">
                <div class="authentication-inner py-2">
                    <!-- Login -->
                    <div class="card p-2">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mt-5">
                            <img src="../logo.png" alt="" width="220">
                        </div>
                        <!-- /Logo -->

                        <div class="card-body mt-2">
                            <h4 class="mb-2">Welcome to <?=$s->setting('sitename')?>! 👋</h4>
                            <p class="mb-4">Please sign-in to your account</p>

                            <form id="formAuthentication" class="mb-3" action="controller/login/login.php" method="POST">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="Enter your email or username" autofocus />
                                    <label for="username">ID or Username</label>
                                </div>
                                <div class="mb-3">
                                    <div class="form-password-toggle">
                                        <div class="input-group input-group-merge">
                                            <div class="form-floating form-floating-outline">
                                                <input type="password" id="password" class="form-control"
                                                    name="password"
                                                    aria-describedby="password" />
                                                <label for="password">Password</label>
                                            </div>
                                            <span class="input-group-text cursor-pointer"><i
                                                    class="mdi mdi-eye-off-outline"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 d-flex justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember-me" />
                                        <label class="form-check-label" for="remember-me"> Remember Me </label>
                                    </div>
                                    <a href="lupa_password.php" class="float-end mb-1">
                                        <span>Lupa Password?</span>
                                    </a>
                                </div>
                                <div class="mb-3">
                                    <button type="button" class="btn btn-primary d-grid w-100" onclick="loginSubmit()">Sign in</button>
                                </div>
                            </form>

                            <p class="text-center">
                                <span>Belum punya akun?</span>
                                <a href="register.php">
                                    <span>Daftar disini</span>
                                </a>
                            </p>
                        </div>
                    </div>
                    <!-- /Login -->
                    <img alt="mask" src="assets/theme2/img/illustrations/auth-basic-login-mask-light.png"
                        class="authentication-image d-none d-lg-block"
                        data-app-light-img="illustrations/auth-basic-login-mask-light.png"
                        data-app-dark-img="illustrations/auth-basic-login-mask-dark.png" />
                </div>
            </div>
        </div>
        <?php require_once("pengumuman.php"); ?>

        <!-- / Content -->

        <!-- Core JS -->
        <!-- build:js assets/vendor/js/core.js -->
        <script src="assets/theme2/vendor/libs/jquery/jquery.js"></script>
        <script src="assets/theme2/vendor/libs/popper/popper.js"></script>
        <script src="assets/theme2/vendor/js/bootstrap.js"></script>
        <script src="assets/theme2/vendor/libs/node-waves/node-waves.js"></script>
        <script src="assets/theme2/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="assets/theme2/vendor/libs/hammer/hammer.js"></script>
        <script src="assets/theme2/vendor/libs/i18n/i18n.js"></script>
        <script src="assets/theme2/vendor/libs/typeahead-js/typeahead.js"></script>
        <script src="assets/theme2/vendor/js/menu.js"></script>

        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="assets/theme2/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
        <script src="assets/theme2/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
        <script src="assets/theme2/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>

        <!-- Main JS -->
        <script src="assets/theme2/js/main.js"></script>

        <!-- Page JS -->
        <script src="assets/theme2/js/pages-auth.js"></script>
        <script>
            $(document).ready(function () {
                if($('#modalAlert').find('.modal-content').length > 0){
                    $('#modalAlert').modal('show');
                }
                $('#psn-sukses').hide();
                $('#psn-gagal').hide();
            });

            function loginSubmit() {
                var username = $('#username').val();
                var password = $('#password').val();
                var url = $(this).attr('action');
                $.ajax({
                    url: 'controller/login/login.php',
                    method:'post',
                    data: {
                        var_usn: username,
                        var_pwd: password
                    },
                    type: 'POST',
                    dataType: 'html',
                    success: function (pesan) {
                        if (pesan == true) {
                            setTimeout(function () {
                                window.location = 'index.php';
                            }, 0);
                        } else {
                            $('#psn-gagal').text(pesan).show(300);
                        }
                    },
                });
            }
        </script>
    </body>

</html>


<?php 
}
?>