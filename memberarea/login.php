<?php 
require_once '../helper/language.php';
require_once '../model/classSetting.php';
$s = new classSetting();
$sitename = $s->setting('sitename');
$theme = $s->setting('theme_memberarea');
if(isset($_SESSION['session_user_member']) != ""){
    header("location:index.php");
}else{
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang['member'] ?> Area - <?= $sitename ?></title>
    <link rel="icon" href="../favicon.png" type="image/png" sizes="16x16">

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/theme1/libs/sweetalert2/sweetalert2.min.css" />

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4a90e2;
            --text-muted: #6c757d;
            --bg-light: rgba(255, 255, 255, 0.9);
            --border-radius: 16px;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Nunito', sans-serif;
            background: url('../background.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }

        .login-wrapper {
            position: relative;
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            z-index: 1;
        }

        .login-card {
            background: var(--bg-light);
            backdrop-filter: blur(12px);
            border-radius: var(--border-radius);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            width: 100%;
            max-width: 420px;
            position: relative;
        }

        .login-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-image: url('../assets/img/pattern.png'), linear-gradient(135deg, rgba(74,144,226,0.85), rgba(34,193,195,0.85));
            background-size: cover;
            background-blend-mode: overlay;
            padding: 1.5rem;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            margin: -2rem -2rem 2rem;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .login-header-row::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.25);
            z-index: 0;
        }

        .login-header-row > * {
            position: relative;
            z-index: 1;
        }

        .login-title h2 {
            font-size: 1.25rem;
            margin: 0;
            font-weight: 700;
        }

        .login-logo img {
            width: 80px;
        }

        .form-group {
            margin-bottom: 1.25rem;
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: var(--border-radius);
            border: 1px solid #ccc;
            font-size: 0.95rem;
            background-color: #fff;
        }

        .form-group label {
            margin-bottom: 0.3rem;
            font-weight: 600;
            display: block;
            font-size: 0.85rem;
            color: #444;
        }

        .form-group .toggle-password {
            position: absolute;
            right: 1rem;
            top: 45%;
            background: none;
            border: none;
            cursor: pointer;
        }

        .captcha-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .captcha {
            border-radius: 6px;
            cursor: pointer;
            border: 1px solid #ccc;
        }

        .alert {
            display: none;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            padding: 0.75rem;
            border-radius: var(--border-radius);
        }

        .btn-login {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            padding: 0.75rem;
            width: 100%;
            font-weight: 700;
            font-size: 1rem;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-login:hover {
            background-color: #3b7dc4;
        }

        .forgot-link {
            display: block;
            text-align: right;
            font-size: 0.85rem;
            margin-top: -0.5rem;
            margin-bottom: 1.25rem;
            color: var(--primary-color);
            text-decoration: none;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: #555;
        }
    </style>
</head>

<body class="theme-<?= $theme ?>" data-page="signin">
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header-row">
                <div class="login-title">
                    <h2><?= strtoupper($lang['member']) ?> Area</h2>
                </div>
                <div class="login-logo">
                    <img src="../logo.png" alt="Logo">
                </div>
            </div>

            <div class="alert alert-danger" id="psn-gagal"></div>

            <form id="formLogin" action="controller/login/index.php" novalidate>
                <div class="form-group">
                    <label for="usr">ID/Username</label>
                    <input type="text" id="usr" name="usr" required placeholder="Masukkan ID / Username">
                </div>

                <div class="form-group">
                    <label for="pwd">Password</label>
                    <input type="password" id="pwd" name="pwd" required placeholder="Masukkan Password">
                    <button type="button" class="toggle-password" id="showPassword"><i class="bi bi-eye-slash-fill"></i></button>
                </div>

                <div class="form-group captcha-group">
                    <img src="captcha.php" class="captcha" alt="Captcha">
                    <input type="text" id="captcha" name="captcha" required placeholder="Masukkan Captcha">
                </div>
                <a href="https://new.netlife.my.id/stokisarea/login.php" class="forgot-link">Login Stokis</a>  
                <a href="lupa_password.php" class="forgot-link">Lupa Password?</a>

                <button type="submit" class="btn-login">Log in</button>
            </form>

            <div class="footer">&copy; <?= $sitename ?></div>
        </div>
    </div>

    <?php include("pengumuman.php"); ?>

    <!-- JS -->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="../assets/theme1/libs/sweetalert2/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#showPassword').click(function () {
                const input = $('#pwd');
                const icon = $(this).find('i');
                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('bi-eye-slash-fill').addClass('bi-eye-fill');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('bi-eye-fill').addClass('bi-eye-slash-fill');
                }
            });

            $('.captcha').click(function () {
                $(this).attr('src', 'captcha.php?' + Date.now());
            });

            $('#formLogin').submit(function (e) {
                e.preventDefault();
                const identity = $('#usr').val();
                const password = $('#pwd').val();
                const captcha = $('#captcha').val();
                const url = $(this).attr('action');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: { identity, password, captcha },
                    success: function (response) {
                        if (response == true) {
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
                            Swal.fire('Maaf!', response, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Terjadi kesalahan koneksi', 'error');
                    }
                });
            });
        });
    </script>
</body>
</html>
<?php } ?>
