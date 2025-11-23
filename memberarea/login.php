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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Modernized, blue/light theme: Bootstrap 4/5 + custom-memberarea.css -->
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/custom-memberarea.css">
    <style>
        body {
            background: linear-gradient(135deg, #eaf1fb 0%, #f8fafc 100%);
            min-height: 100vh;
        }
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: none;
        }
        .login-card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 4px 32px rgba(0,51,160,0.08);
            padding: 2.5rem 2rem 2rem 2rem;
            max-width: 400px;
            width: 100%;
            margin: 2rem 0;
            border: 1px solid #d6e0f5;
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-logo {
            width: 90px;
            height: 90px;
            margin: 0 auto 1rem auto;
            background: #eaf1fb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(0,51,160,0.10);
        }
        .login-logo img {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }
        .login-title h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #0033a0;
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
        }
        .login-title p {
            color: #0033a0;
            font-size: 1rem;
            font-weight: 400;
            margin-bottom: 0;
            opacity: 0.7;
        }
        .login-content {
            margin-top: 0.5rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .input-wrapper {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #0033a0;
            font-size: 1.1rem;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1.5px solid #d6e0f5;
            border-radius: 10px;
            background: #f4f8fd;
            color: #0033a0;
            font-size: 1rem;
            font-weight: 500;
            transition: border 0.2s, box-shadow 0.2s;
            outline: none;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #0033a0;
            box-shadow: 0 0 0 2px #0033a033;
        }
        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #0033a0;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .toggle-password:hover {
            color: #0055d4;
            transform: translateY(-50%) scale(1.2);
        }
        .captcha-group {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .captcha-wrapper {
            flex: 0 0 120px;
            border: 2px solid #0033a0;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .captcha-wrapper:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(0,51,160,0.10);
        }
        .captcha {
            display: block;
            width: 100%;
            height: auto;
        }
        .captcha-input {
            flex: 1;
        }
        .forgot-link {
            display: block;
            text-align: right;
            font-size: 0.85rem;
            margin-top: -0.5rem;
            margin-bottom: 1.5rem;
            color: #0033a0;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .forgot-link:hover {
            color: #0055d4;
            transform: translateX(-5px);
        }
        .btn-login {
            background: #0033a0;
            color: #fff;
            border: none;
            padding: 1rem;
            width: 100%;
            font-weight: 700;
            font-size: 1rem;
            border-radius: 12px;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-login:hover {
            background: #0055d4;
            color: #fff;
            box-shadow: 0 10px 30px rgba(0,51,160,0.10);
        }
        .btn-login:active {
            background: #002266;
        }
        .footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #d6e0f5;
            font-size: 0.85rem;
            color: #0033a0;
        }
        .alert {
            display: none;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .alert-danger {
            background: rgba(220, 53, 69, 0.2);
            color: #ff6b6b;
            padding: 0.75rem;
            border-radius: 12px;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }
        @media (max-width: 480px) {
            .login-card {
                margin: 1rem;
            }
            .login-title h2 {
                font-size: 1.5rem;
            }
            .login-logo {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>

<body class="theme-<?= $theme ?>" data-page="signin">
    <div class="animated-bg"></div>
    <div class="particles" id="particles"></div>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <img src="../logo.png" alt="Logo">
                </div>
                <div class="login-title">
                    <h2><?= strtoupper($lang['member']) ?> Area</h2>
                    <p style="margin: 0.5rem 0 0 0; font-size: 0.85rem; color: var(--black); opacity: 0.8; font-weight: 400;">Selamat datang kembali! Silakan login untuk melanjutkan</p>
                </div>
            </div>

            <div class="login-content">
                <!-- <div style="background: linear-gradient(135deg, rgba(212, 175, 55, 0.1) 0%, rgba(212, 175, 55, 0.05) 100%); border-left: 3px solid var(--gold); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.85rem; color: var(--gold-light);">
                    <i class="bi bi-info-circle-fill" style="margin-right: 0.5rem;"></i>
                    <strong>Info:</strong> Gunakan ID Member atau Username yang telah terdaftar untuk mengakses dashboard Anda.
                </div> -->

                <div class="alert alert-danger" id="psn-gagal"></div>

                <form id="formLogin" action="controller/login/index.php" novalidate>
                    <div class="form-group">
                        <label for="usr"><i class="bi bi-person-badge"></i> ID Member / Username</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person-fill input-icon"></i>
                            <input type="text" id="usr" name="usr" required placeholder="Contoh: MB001234 atau username_anda" autocomplete="username">
                        </div>
                        <small style="color: rgba(212, 175, 55, 0.6); font-size: 0.75rem; margin-top: 0.25rem; display: block;">Masukkan ID Member atau Username yang terdaftar</small>
                    </div>

                    <div class="form-group">
                        <label for="pwd"><i class="bi bi-key"></i> Password</label>
                        <div class="input-wrapper">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" id="pwd" name="pwd" required placeholder="Masukkan password Anda" autocomplete="current-password">
                            <button type="button" class="toggle-password" id="showPassword" title="Tampilkan/Sembunyikan Password">
                                <i class="bi bi-eye-slash-fill"></i>
                            </button>
                        </div>
                        <small style="color: rgba(212, 175, 55, 0.6); font-size: 0.75rem; margin-top: 0.25rem; display: block;">Password bersifat case-sensitive (huruf besar/kecil)</small>
                    </div>

                    <div class="form-group">
                        <label for="captcha"><i class="bi bi-shield-check"></i> Kode Keamanan (Captcha)</label>
                        <div class="captcha-group">
                            <div class="captcha-wrapper" title="Klik untuk refresh captcha">
                                <img src="captcha.php" class="captcha" alt="Captcha">
                            </div>
                            <div class="input-wrapper captcha-input">
                                <i class="bi bi-shield-fill-check input-icon"></i>
                                <input type="text" id="captcha" name="captcha" required placeholder="Ketik kode yang terlihat" autocomplete="off">
                            </div>
                        </div>
                        <small style="color: rgba(212, 175, 55, 0.6); font-size: 0.75rem; margin-top: 0.25rem; display: block;"><i class="bi bi-arrow-clockwise"></i> Klik gambar captcha untuk memperbarui kode</small>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.5rem;">
                        <a href="https://myapps.alkken.netstokisarea/login.php" class="forgot-link" style="margin: 0; text-align: left;">
                            <i class="bi bi-shop"></i> Masuk sebagai Stokis
                        </a>  
                        <a href="lupa_password.php" class="forgot-link" style="margin: 0; text-align: right;">
                            <i class="bi bi-question-circle"></i> Lupa Password?
                        </a>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="bi bi-box-arrow-in-right" style="margin-right: 0.5rem;"></i>
                        <span>Masuk ke Dashboard</span>
                    </button>

                    <!-- <div style="text-align: center; margin-top: 1.5rem; padding: 1rem; background: rgba(212, 175, 55, 0.05); border-radius: 8px;">
                        <p style="margin: 0 0 0.5rem 0; color: var(--gold-light); font-size: 0.85rem;">Belum punya akun member?</p>
                        <a href="register.php" style="color: var(--gold); text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: all 0.3s;">
                            <i class="bi bi-person-plus-fill"></i> Daftar Sekarang <i class="bi bi-arrow-right"></i>
                        </a>
                    </div> -->
                </form>

                <div class="footer">
                    <!-- <p style="margin: 0 0 0.5rem 0;"><i class="bi bi-shield-lock-fill"></i> Keamanan Data Terjamin</p> -->
                    <p style="margin: 0; font-size: 0.8rem; opacity: 0.8;"><i class="bi bi-c-circle"></i> <?= date('Y') ?> <?= $sitename ?>. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <?php include("pengumuman.php"); ?>

    <!-- JS -->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="../assets/theme1/libs/sweetalert2/sweetalert2.min.js"></script>
    <script>
        // Particles Animation
        function createParticles() {
            const particles = document.getElementById('particles');
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 15 + 's';
                particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
                particles.appendChild(particle);
            }
        }
        createParticles();

        $(document).ready(function () {
            // Toggle Password
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

            // Refresh Captcha
            $('.captcha-wrapper').click(function () {
                $(this).find('.captcha').attr('src', 'captcha.php?' + Date.now());
            });

            // Form Submit
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
                                icon: 'success',
                                confirmButtonColor: '#D4AF37'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location = 'index.php';
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Maaf!',
                                text: response,
                                icon: 'error',
                                confirmButtonColor: '#D4AF37'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'Terjadi kesalahan koneksi',
                            icon: 'error',
                            confirmButtonColor: '#D4AF37'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
<?php } ?>
