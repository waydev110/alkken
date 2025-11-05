<!doctype html>
<html lang="en">
<head>        
    <meta charset="utf-8" />
    <title>Login | Adminarea</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Halaman Login" />
    <link rel="shortcut icon" href="../favicon.png" />

    <!-- Bootstrap Css -->
    <link href="../assets/theme1/css/bootstrap-dark.custom.css" rel="stylesheet" />
    <link href="../assets/theme1/css/icons.min.css" rel="stylesheet" />
    <link href="../assets/theme1/css/app-dark.custom.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/theme1/libs/sweetalert2/sweetalert2.min.css" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0a0a0a;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
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
            background: rgba(218, 165, 32, 0.1);
            animation: animate 25s linear infinite;
            bottom: -150px;
        }

        .bg-animation span:nth-child(1) {
            left: 25%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
        }

        .bg-animation span:nth-child(2) {
            left: 10%;
            width: 20px;
            height: 20px;
            animation-delay: 2s;
            animation-duration: 12s;
        }

        .bg-animation span:nth-child(3) {
            left: 70%;
            width: 20px;
            height: 20px;
            animation-delay: 4s;
        }

        .bg-animation span:nth-child(4) {
            left: 40%;
            width: 60px;
            height: 60px;
            animation-delay: 0s;
            animation-duration: 18s;
        }

        .bg-animation span:nth-child(5) {
            left: 65%;
            width: 20px;
            height: 20px;
            animation-delay: 0s;
        }

        .bg-animation span:nth-child(6) {
            left: 75%;
            width: 110px;
            height: 110px;
            animation-delay: 3s;
        }

        .bg-animation span:nth-child(7) {
            left: 35%;
            width: 150px;
            height: 150px;
            animation-delay: 7s;
        }

        .bg-animation span:nth-child(8) {
            left: 50%;
            width: 25px;
            height: 25px;
            animation-delay: 15s;
            animation-duration: 45s;
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
            background: rgba(20, 20, 20, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid rgba(218, 165, 32, 0.3);
            box-shadow: 0 20px 60px rgba(218, 165, 32, 0.2);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: linear-gradient(135deg, rgba(218, 165, 32, 0.15) 0%, rgba(184, 134, 11, 0.1) 100%);
            padding: 2.5rem 2rem 2rem;
            text-align: center;
            position: relative;
            border-bottom: 1px solid rgba(218, 165, 32, 0.2);
        }

        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .logo-container img {
            max-width: 100px;
            height: auto;
            filter: drop-shadow(0 4px 12px rgba(218, 165, 32, 0.5));
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .login-header h5 {
            margin: 0 0 0.5rem;
            font-weight: 700;
            font-size: 1.75rem;
            color: #DAA520;
            text-shadow: 0 2px 10px rgba(218, 165, 32, 0.4);
        }

        .login-header p {
            margin: 0;
            font-size: 0.95rem;
            color: #c4c4c4;
        }

        .login-body {
            padding: 2.5rem 2rem 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        label.form-label {
            font-weight: 600;
            color: #DAA520;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            letter-spacing: 0.3px;
        }

        label.form-label i {
            margin-right: 0.5rem;
            color: #DAA520;
            font-size: 1.1rem;
        }

        input.form-control {
            background: rgba(0, 0, 0, 0.6);
            border: 2px solid rgba(218, 165, 32, 0.3);
            border-radius: 12px;
            color: #f1f1f1;
            padding: 0.85rem 1.25rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        input.form-control::placeholder {
            color: #6a6a6a;
        }

        input.form-control:focus {
            border-color: #DAA520;
            box-shadow: 0 0 0 4px rgba(218, 165, 32, 0.15);
            background: rgba(0, 0, 0, 0.8);
            color: #fff;
            outline: none;
            transform: translateY(-2px);
        }

        .input-group {
            position: relative;
        }

        .input-group .btn-light {
            position: absolute;
            right: 4px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(218, 165, 32, 0.2);
            color: #DAA520;
            border-radius: 8px;
            border: none;
            padding: 0.5rem 0.75rem;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .input-group .btn-light:hover {
            background: #DAA520;
            color: #000;
            transform: translateY(-50%) scale(1.05);
        }

        .btn-primary {
            background: linear-gradient(135deg, #DAA520 0%, #B8860B 100%);
            border: none;
            padding: 1rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            width: 100%;
            margin-top: 1rem;
            color: #000;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(218, 165, 32, 0.4);
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #FFD700 0%, #DAA520 100%);
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(218, 165, 32, 0.6);
        }

        .btn-primary:active {
            transform: translateY(0);
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
                        <div class="input-group">
                            <input id="password" name="password" type="password" class="form-control" placeholder="Masukkan password" required autocomplete="current-password" />
                            <button class="btn btn-light" type="button" id="password-addon" aria-label="Toggle password visibility">
                                <i class="mdi mdi-eye-outline"></i>
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
    <script src="../assets/theme1/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="../assets/theme1/plugins/loadingoverlay/loadingoverlay.min.js"></script>
    <script src="../assets/theme1/js/app.js"></script>

    <script>
        $('#password-addon').on('click', function() {
            const input = $('#password');
            const icon = $(this).find('i');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('mdi-eye-outline').addClass('mdi-eye-off-outline');
            } else {
                input.attr('type', 'password');
                icon.removeClass('mdi-eye-off-outline').addClass('mdi-eye-outline');
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
