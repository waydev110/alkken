<?php 
    remove_session("session_cek_pin");
    $token = create_token();
?>
    <?php include 'view/layout/header.php'; ?>

        <!-- loader section -->
        <?php include 'view/layout/loader.php'; ?>
        <!-- loader section ends -->

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
                        <h5 class="text-center mb-2">Masukan PIN Anda Saat Ini</h5>
                        <p class="text-center mb-2">PIN digunakan untuk keamanan dalam bertransaksi.</p>
                    </div>
                </div>
                <form action="controller/auth/cek_pin.php" id="formCekPIN" method="post">
                    <!-- <div class="d-flex mb-4">
                        <input type="text" class="form-control text-center mx-2 py-3 input_pin" name="old_pin1"
                            required="required" maxlength="1">
                        <input type="text" class="form-control text-center mx-2 py-3 input_pin" name="old_pin2"
                            required="required" maxlength="1">
                        <input type="text" class="form-control text-center mx-2 py-3 input_pin" name="old_pin3"
                            required="required" maxlength="1">
                        <input type="text" class="form-control text-center mx-2 py-3 input_pin" name="old_pin4"
                            required="required" maxlength="1">
                    </div> -->
                    <div class="col-6 mb-3 offset-3">
                        <input type="text" class="form-control text-center py-3" name="cek_pin" required="required">
                    </div>
                    <div class="col-6 d-grid offset-3">
                        <button class="btn btn-default btn-lg btn-block rounded-pill" id="btnSubmitPIN">Submit</button>
                    </div>
                </form>
            </div>
            <div class="main-container container pt-4 pb-4" style="display:none" id="blockNextForm">
                <div class="row">
                    <div class="col-12 mb-3">
                        <h5 class="text-center mb-2">Buat PIN Baru</h5>
                        <p class="text-center mb-2">PIN digunakan untuk keamanan dalam bertransaksi.</p>
                    </div>
                </div>
                <form action="controller/auth/update_pin.php" id="formUpdatePIN" method="post">
                    <input type="hidden" name="token" value="<?=$token?>">
                    <!-- <div class="d-flex mb-4">
                        <input type="text" class="form-control text-center mx-2 py-3 input_pin" name="new_pin1"
                            required="required" maxlength="1">
                        <input type="text" class="form-control text-center mx-2 py-3 input_pin" name="new_pin2"
                            required="required" maxlength="1">
                        <input type="text" class="form-control text-center mx-2 py-3 input_pin" name="new_pin3"
                            required="required" maxlength="1">
                        <input type="text" class="form-control text-center mx-2 py-3 input_pin" name="new_pin4"
                            required="required" maxlength="1">
                    </div> -->
                    
                    <div class="col-6 mb-3 offset-3">
                        <input type="text" class="form-control text-center py-3" name="new_pin" required="required">
                    </div>
                    <div class="row">
                        <div class="col d-grid mb-4 px-4">
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
            $(document).ready(function () {
                var blockFirstForm = $('#blockFirstForm');
                var blockNextForm = $('#blockNextForm');
                var formCekPIN = $('#formCekPIN');
                var formUpdatePIN = $('#formUpdatePIN');

                formCekPIN.on("submit", function (e) {
                    var dataString = $(this).serialize();
                    $.ajax({
                        type: $(this).attr("method"),
                        url: $(this).attr("action"),
                        data: dataString,
                        success: function (result) {
                            if (result == true) {
                                formCekPIN.find('.form-error').remove();
                                blockFirstForm.hide();
                                blockNextForm.show();
                                $('input[name=new_pin]').focus();
                            } else {
                                if(result == 'limit') {
                                    formCekPIN.html('');
                                    formCekPIN.prepend(
                                            '<p class="form-error text-center text-danger mb-1">Anda salah memasukan PIN sebanyak 3 kali.</p><p class="form-error text-center text-danger mb-3">Silahkan coba beberapa saat lagi.</p>'
                                            );
                                    
                                } else {
                                    if (formCekPIN.find('.form-error').length == 0) {
                                        formCekPIN.prepend(
                                            '<p class="form-error text-center text-danger mb-3">PIN yang anda masukan salah.</p>'
                                            );

                                    }
                                }
                            }
                        }
                    });
                    e.preventDefault();
                });
            });
        </script>
        <?php include 'view/layout/footer.php'; ?>