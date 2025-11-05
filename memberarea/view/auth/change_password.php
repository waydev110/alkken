<?php include 'view/layout/header.php'; ?>
    <!-- loader section -->
    <?php include 'view/layout/loader.php'; ?>
    <!-- loader section ends -->
    <?php include 'view/layout/sidebar.php'; ?>
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
        <div class="main-container container pt-4 pb-4" id="blockFirstForm">
            <div class="row">
                <div class="col-12 mb-3">
                    <h5 class="text-center mb-2">Masukan Password Anda Saat Ini</h5>
                    <p class="text-center mb-2">Password digunakan untuk masuk kehalaman member.</p>
                </div>
            </div>
            <form action="controller/auth/cek_password.php" id="formCekPassword" method="post">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group form-floating mb-3">
                            <input type="password" class="form-control" id="old_password" name="old_password" required="required">
                            <label class="form-control-label" for="old_password">Password</label>
                            <button type="button" class="btn btn-link text-black-50 tooltip-btn show_password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col">
                    </div>
                </div>
                <div class="row">
                    <div class="col d-grid mb-4">
                        <button class="btn btn-default btn-lg shadow-sm">Selanjutnya</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="main-container container pt-4 pb-4" style="display:none" id="blockNextForm">
            <div class="row">                
                <div class="col-12 mb-3">
                    <h5 class="text-center mb-2">Buat Password Baru</h5>
                    <p class="text-center mb-2">Password digunakan untuk masuk kehalaman member.</p>
                </div>
            </div>
            <form action="controller/auth/update_password.php" id="formUpdatePassword" method="post">
                <div class="row">
                    <div class="col">
                        <div class="form-group form-floating mb-3">
                            <input type="password" class="form-control" id="new_password" name="new_password" required="required">
                            <label class="form-control-label" for="new_password">Password Baru</label>
                            <button type="button" class="btn btn-link text-black-50 tooltip-btn show_password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-group form-floating mb-3">
                            <input type="password" class="form-control" id="conf_password" name="conf_password">
                            <label class="form-control-label" for="conf_password">Konfirmasi Password Baru</label>
                            <button type="button" class="btn btn-link text-black-50 tooltip-btn show_password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col d-grid mb-4">
                        <button class="btn btn-default btn-lg shadow-sm">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- main page content ends -->
    </main>
    <!-- Page ends-->
    <?php include 'view/layout/assets_js.php'; ?>
    <script>
        $(document).ready(function() {
            var blockFirstForm = $('#blockFirstForm');
            var blockNextForm = $('#blockNextForm');
            var formCekPassword = $('#formCekPassword');
            var formUpdatePassword = $('#formUpdatePassword');

            formCekPassword.on( "submit", function(e) {
                var dataString = $(this).serialize();
                $.ajax({
                    type: $(this).attr("method"),
                    url : $(this).attr("action"),
                    data: dataString,
                    success: function (result) {
                        if(result == true){
                            formCekPassword.find('.form-error').remove();
                            blockFirstForm.hide();
                            blockNextForm.show();
                        } else {
                            if(formCekPassword.find('.form-error').length == 0){
                                formCekPassword.prepend('<p class="form-error text-center text-danger mb-3">Password yang anda masukan salah.</p>');
                            }
                        }
                    }
                });
                e.preventDefault();
            });

            formUpdatePassword.on( "submit", function(e) {
                formUpdatePassword.find('.form-error').remove();
                var new_password  = $('#new_password').val();
                var conf_password = $('#conf_password').val();
                
                if(new_password != conf_password){
                    if(formUpdatePassword.find('.form-error').length == 0){
                        formUpdatePassword.prepend('<p class="form-error text-center text-danger mb-3">Konfirmasi Password Baru tidak sama.</p>');
                    }
                } else {
                    formUpdatePassword.submit();
                }
                e.preventDefault();
            });

            $('.show_password').on("click", function(e){
                var input = $(this).parent('.form-group').find('input');
                if(input.attr('type') == 'password'){
                    input.attr('type', 'text');
                    $(this).html('<i class="fa-solid fa-eye-slash"></i>');
                } else {
                    input.attr('type', 'password');
                    $(this).html('<i class="fa-solid fa-eye"></i>');
                }
                e.preventDefault();
            });
        });
    </script>
    <?php include 'view/layout/footer.php'; ?>