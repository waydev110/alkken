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
    <div class="main-container container pt-4 pb-4" id="blockFirstForm">
        <div class="row">
            <div class="col-12 mb-3">
                <h5 class="text-center mb-2">Masukan Username</h5>
                <p class="text-center mb-2">Username digunakan untuk masuk kehalaman member.</p>
            </div>
        </div>
        <form action="controller/auth/update_username.php" id="formUpdateUsername" method="post">
            <div class="row">
                <div class="col">
                    <div class="form-group form-floating-2 mb-3">
                        <input type="hidden" name="session_user_member" value="<?=$session_user_member?>">
                        <input type="text" class="form-control" id="username" name="username" required="required">
                        <label class="form-control-label" for="username">Username</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col d-grid mb-4">
                    <button type="button" class="btn btn-default btn-lg shadow-sm rounded-pill"
                        id="btnUpdate">Simpan</button>
                </div>
            </div>
        </form>
    </div>
    <?php include 'view/auth/form_cek_pin.php'; ?>
</main>
<?php include 'view/layout/assets_js.php'; ?>
<script>
    $(document).ready(function () {
        var blockFirstForm = $('#blockFirstForm');
        var blockNextForm = $('#blockNextForm');
        var formCekPIN = $('#formCekPIN');
        var formUpdateUsername = $('#formUpdateUsername');
        var btnUpdate = $('#btnUpdate');


        $('#username').on("change keyup", function (e) {
            var username = $('#username').val();
            if (username.length >= 4) {
                cek_username(username);
            }
            e.preventDefault();
        });


        btnUpdate.on("click", function (e) {
            e.preventDefault();
            var username = $('#username').val();
            if (username.length < 4) {
                formUpdateUsername.find('.form-error').remove();
                formUpdateUsername.prepend(
                    '<p class="form-error text-center text-danger mb-3">Minimal 4 karakter.</p>'
                );
            } else {
                var kondisi = cek_username(username);
                if (kondisi == true) {
                    blockFirstForm.hide();
                    blockNextForm.show();
                    $('input[name=old_pin1]').focus();
                } else {
                    formUpdateUsername.find('.form-error').remove();
                    formUpdateUsername.prepend(
                        '<p class="form-error text-center text-danger mb-3">Username tidak tersedia.</p>'
                    );
                }
            }
        });

        function cek_username(username) {
            var hasil = false;
            $.ajax({
                type: 'post',
                url: 'controller/auth/cek_username.php',
                data: {
                    username: username
                },
                success: function (result) {
                    const obj = JSON.parse(result);
                    hasil = obj.status;
                },
                async: false
            });
            return hasil;
        }


        formUpdateUsername.on("submit", function (e) {
            var session_user_member = $('#session_user_member').val();
            var username = $('#username').val();
            if (username.length < 4) {
                formUpdateUsername.find('.form-error').remove();
                formUpdateUsername.prepend(
                    '<p class="form-error text-center text-danger mb-3">Minimal 4 karakter.</p>'
                );
            } else {
                var dataString = $(this).serialize();
                $.ajax({
                    type: $(this).attr("method"),
                    url: $(this).attr("action"),
                    data: dataString,
                    beforeSend: function () {
                        loader_open();
                    },
                    success: function (result) {
                        const obj = JSON.parse(result);
                        if (obj.status == true) {
                            var message = obj.message;
                            var redirect_url = 'profil';
                            show_success(message, redirect_url);
                        } else {
                            var message = obj.message;
                            var redirect_url = 'profil';
                            show_error(message, redirect_url);
                        }
                    },
                    complete: function () {
                        loader_close();
                    }
                });
            }
            e.preventDefault();
        });
        
        formCekPIN.on("submit", function (e) {
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                success: function (result) {
                    if (result == true) {
                        formUpdateUsername.submit();
                    } else {
                        if (result == 'limit') {
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

        $('.input_pin').keyup(function (e) {
            var key = e.keyCode || e.charCode;

            if (key == 8 || key == 46) {
                if (this.value == '') {
                    $(this).attr('type', 'text');
                    if (!$(this).is(':first-child')) {
                        $(this).prev('.input_pin').focus();
                    } else {
                        formCekPIN.find('.form-error').remove();
                    }
                }
            } else {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    this.value = '';
                } else {
                    if (this.value.length >= this.maxLength) {
                        $(this).delay(300).queue(function () {
                            $(this).attr('type', 'password').dequeue();
                        });
                        if (!$(this).is(':last-child')) {
                            $(this).next('.input_pin').focus();
                        } else {
                            if ($(this).parents('#formCekPIN').length > 0) {
                                formCekPIN.submit();
                            }
                        }
                    }
                }
            }
        });
    });
</script>
<?php include 'view/layout/footer.php'; ?>