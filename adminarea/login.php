<!doctype html>
<html lang="en">
<head>        
    <meta charset="utf-8" />
    <title>Login | Adminarea</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Halaman Login" />
    <link rel="shortcut icon" href="../favicon.png" />

    <!-- Modernized, blue/light theme: Bootstrap 4/5 + custom-memberarea.css -->
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../memberarea/assets/css/custom-memberarea.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome-pro-6.2.0/css/all.css" />
    <link rel="stylesheet" href="../assets/theme1/libs/sweetalert2/sweetalert2.min.css" />
    <style>
        body {
            background: linear-gradient(135deg, #eaf1fb 0%, #f8fafc 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        /* Animated Background */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }
        .bg-animation span {
            position: absolute;
            display: block;
            width: 20px;
            height: 20px;
            background: rgba(0,51,160,0.08);
            animation: animate 25s linear infinite;
            bottom: -150px;
            border-radius: 50%;
        }
        .bg-animation span:nth-child(1) {
            left: 25%; width: 80px; height: 80px; animation-delay: 0s;
        }
        .bg-animation span:nth-child(2) {
            left: 10%; width: 20px; height: 20px; animation-delay: 2s; animation-duration: 12s;
        }
        .bg-animation span:nth-child(3) {
            left: 70%; width: 20px; height: 20px; animation-delay: 4s;
        }
        .bg-animation span:nth-child(4) {
            left: 40%; width: 60px; height: 60px; animation-delay: 0s; animation-duration: 18s;
        }
        .bg-animation span:nth-child(5) {
            left: 65%; width: 20px; height: 20px; animation-delay: 0s;
        }
        .bg-animation span:nth-child(6) {
            left: 75%; width: 110px; height: 110px; animation-delay: 3s;
        }
        .bg-animation span:nth-child(7) {
            left: 35%; width: 150px; height: 150px; animation-delay: 7s;
        }
        .bg-animation span:nth-child(8) {
            left: 50%; width: 25px; height: 25px; animation-delay: 15s; animation-duration: 45s;
        }
        @keyframes animate {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
                border-radius: 0;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
                border-radius: 50%;
            }
        }
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 450px;
            padding: 0 1.5rem;
        }
        .login-card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 4px 32px rgba(0,51,160,0.08);
            border: 1px solid #d6e0f5;
            overflow: hidden;
        }
        .login-header {
            background: #eaf1fb;
            padding: 2.5rem 2rem 2rem;
            text-align: center;
            border-bottom: 1px solid #d6e0f5;
        }
        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        .logo-container img {
            max-width: 100px;
            height: auto;
            filter: drop-shadow(0 4px 12px rgba(0,51,160,0.10));
        }
        .login-header h5 {
            margin: 0 0 0.5rem;
            font-weight: 700;
            font-size: 1.75rem;
            color: #0033a0;
            text-shadow: none;
        }
        .login-header p {
            margin: 0;
            font-size: 0.95rem;
            color: #0033a0;
            opacity: 0.7;
        }
        .login-body {
            padding: 2.5rem 2rem 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        /* Make password input full width in input-group */
        .input-group .form-control {
            padding-right: 3rem;
        }
        input.form-control {
            background: #f4f8fd;
            border: 1.5px solid #d6e0f5;
            border-radius: 40px;
            color: #0033a0;
            padding: 0.85rem 1.25rem;
            font-size: 12px !important;
            transition: all 0.3s ease;
        }
        input.form-control::placeholder {
            color: #b0b8c9;
        }
        input.form-control:focus {
            border-color: #0033a0;
            box-shadow: 0 0 0 2px #0033a033;
            background: #fff;
            color: #0033a0;
            outline: none;
        }
        .input-group .btn-light {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            color: #0033a0;
            border-radius: 8px;
            border: none;
            padding: 0.5rem 0.75rem;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
            z-index: 20;
            opacity: 1;
        }
        .input-group .btn-light:hover {
            background: #0033a0;
            color: #fff;
            transform: translateY(-50%) scale(1.05);
        }
        .btn-primary {
            background: #0033a0;
            border: none;
            padding: 1rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            width: 100%;
            margin-top: 1rem;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(0,51,160,0.10);
            position: relative;
            overflow: hidden;
        }
        .btn-primary:hover {
            background: #0055d4;
            color: #fff;
            box-shadow: 0 12px 28px rgba(0,51,160,0.15);
        }
        .btn-primary:active {
            background: #002266;
        }
        @media (max-width: 480px) {
            .login-header {
                padding: 2rem 1.5rem 1.5rem;
            }
            .login-body {
                padding: 2rem 1.5rem 1.5rem;
            }
            .login-header h5 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="bg-animation">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-container">
                    <img src="../logo.png" alt="Logo Adminarea" />
                </div>
                <h5>Selamat Datang Kembali!</h5>
                <p>Silakan masuk untuk melanjutkan</p>
            </div>
            <div class="login-body">
                <form id="form" action="controller/login/index.php" method="POST" novalidate>
                    <div class="form-group">
                        <input id="identity" name="identity" type="text" class="form-control" placeholder="Masukkan username" required autocomplete="username" />
                    </div>
                    <div class="form-group">
                        <div class="input-group" style="width:100%;">
                            <input id="password" name="password" type="password" class="form-control" placeholder="Masukkan password" required autocomplete="current-password" style="width:100%;" />
                            <button class="btn btn-light" type="button" id="password-addon" aria-label="Toggle password visibility" style="right:10px;">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Masuk</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="../assets/theme1/libs/jquery/jquery.min.js"></script>
    <script src="../assets/theme1/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/theme1/libs/metismenu/metisMenu.min.js"></script>
    <script src="../assets/theme1/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/theme1/libs/node-waves/waves.min.js"></script>
    <script src="../assets/theme1/plugins/loadingoverlay/loadingoverlay.min.js"></script>
    <script src="../assets/theme1/js/app.js"></script>
    <script src="../assets/theme1/libs/sweetalert2/sweetalert2.min.js"></script>    

    <script>
        $('#password-addon').off('click').on('click', function(e) {
            e.preventDefault();
            var input = $('#password');
            var icon = $(this).find('i');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        $("#form").submit(function(event) {
            event.preventDefault();
            $.LoadingOverlay("show");
            var identity = $('#identity').val();
            var password = $('#password').val();
            $.ajax({
                url: this.action,
                type: 'POST',
                data: { identity: identity, password: password },
                dataType: 'html',
                success: function (pesan) {
                    $.LoadingOverlay("hide");
                    if (pesan == true) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Login Berhasil',
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = 'index.php';
                            }
                        });
                    } else {
                        Swal.fire('Maaf!', pesan, 'error');
                    }
                },
                error: function() {
                    $.LoadingOverlay("hide");
                    Swal.fire('Error', 'Terjadi kesalahan koneksi', 'error');
                }
            });
        });
    </script>
</body>
</html>
