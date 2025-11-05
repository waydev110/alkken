<?php 
session_start();
if(isset($_SESSION['session_stokis_id'])  != ""){
  header("location:index.php");
}else{
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Administrator</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="../assets/plugins/iCheck/square/blue.css">
        <style type="text/css">
            .login-page,
            .register-page {
                background-image: url("../assets/dist/img/1.jpg");
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;

            }
        </style>
        <link rel="icon" href="../favicon.png" sizes="16x16" type="image/png">
    </head>

    <body class="hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="login-box-body">
                <div class="login-logo">
                    <b>STOKIS AREA</b>
                </div>
                <div class="alert alert-success alert-dismissible" id="psn-sukses">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Login sukses
                </div>
                <div class="alert alert-danger alert-dismissible" id="psn-gagal">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Login gagal
                </div>


                <form action="" method="post" id="form-login" autocomplete="false">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Username" name="usr" id="usr">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Password" name="pwd" id="pwd">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <!-- <a href="/">Beranda</a> -->
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-rounded" id="btn-login">Login</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>


            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 2.2.3 -->
        <script src="../assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="../assets/plugins/iCheck/icheck.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#psn-sukses').hide();
                $('#psn-gagal').hide();
                $('#form-login').on('submit', function (e) {
                    e.preventDefault();
                    //Gunakan jquery AJAX
                    var username = $('#usr').val();
                    var password = $('#pwd').val();
                    $.ajax({
                        url: 'controller/login/index.php?',
                        //mengirimkan username dan password ke script login.php
                        data: 'var_usn=' + username + '&var_pwd=' + password,
                        //Method pengiriman
                        type: 'POST',
                        //Data yang akan diambil dari script pemroses
                        dataType: 'html',
                        //Respon jika data berhasil dikirim
                        success: function (pesan) {
                            if (pesan == true) {
                                //Arahkan ke halaman admin jika script pemroses mencetak kata ok
                                $('#psn-gagal').hide();
                                $('#psn-sukses').show(300);

                                setTimeout(function () {
                                    window.location = 'index.php';
                                }, 2000);
                            } else {
                                //Cetak peringatan untuk username & password salah
                                $('#psn-gagal').show(300);
                            }
                        },
                    });
                });
            });
        </script>
    </body>

</html>

<?php 
}
?>