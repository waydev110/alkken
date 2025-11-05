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
    <link rel="stylesheet" href="../assets/theme1/libs/sweetalert2/sweetalert2.min.css" />

    <!-- Custom CSS -->
    <style>
        :root {
            --gold: #D4AF37;
            --gold-light: #F4E5B1;
            --gold-dark: #B8941E;
            --black: #0A0A0A;
            --black-soft: #1A1A1A;
            --black-light: #2A2A2A;
        }

        * { 
            box-sizing: border-box; 
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--black);
            overflow-x: hidden;
            position: relative;
            min-height: 100vh;
        }

        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--black) 0%, var(--black-soft) 50%, var(--black-light) 100%);
            z-index: 0;
        }

        .particles {
            position: fixed;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: var(--gold);
            border-radius: 50%;
            opacity: 0;
            animation: float 15s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { 
                opacity: 0;
                transform: translateY(0) translateX(0) scale(0);
            }
            10% {
                opacity: 0.8;
            }
            50% { 
                opacity: 1;
                transform: translateY(-100vh) translateX(50px) scale(1);
            }
            90% {
                opacity: 0.3;
            }
        }

        /* Login Container */
        .login-wrapper {
            position: relative;
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            z-index: 10;
        }

        .login-card {
            background: linear-gradient(135deg, var(--black-soft) 0%, var(--black-light) 100%);
            border: 2px solid var(--gold);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(212, 175, 55, 0.3),
                        0 0 100px rgba(212, 175, 55, 0.1);
            padding: 0;
            width: 100%;
            max-width: 450px;
            position: relative;
            overflow: hidden;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Glowing Border Effect */
        .login-card::before {
            content: "";
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, var(--gold), var(--gold-light), var(--gold), var(--gold-dark));
            border-radius: 24px;
            z-index: -1;
            opacity: 0;
            animation: glow 3s infinite;
        }

        @keyframes glow {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.8; }
        }

        /* Header */
        .login-header {
            background: linear-gradient(135deg, var(--gold-dark) 0%, var(--gold) 100%);
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .login-logo {
            width: 100px;
            height: 100px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            border: 3px solid var(--black);
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            animation: pulse 2s infinite;
            position: relative;
            z-index: 1;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .login-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .login-title {
            position: relative;
            z-index: 1;
        }

        .login-title h2 {
            font-size: 1.8rem;
            margin: 0;
            font-weight: 700;
            color: var(--black);
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        /* Form Content */
        .login-content {
            padding: 2.5rem 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
            animation: fadeIn 0.8s ease-out backwards;
        }

        .form-group:nth-child(1) { animation-delay: 0.2s; }
        .form-group:nth-child(2) { animation-delay: 0.4s; }
        .form-group:nth-child(3) { animation-delay: 0.6s; }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--gold);
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gold);
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .form-group input {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 3rem;
            border-radius: 12px;
            border: 2px solid var(--black-light);
            background: var(--black);
            font-size: 0.95rem;
            color: var(--gold-light);
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
        }

        .form-group input:focus + .input-icon {
            color: var(--gold-light);
            transform: translateY(-50%) scale(1.1);
        }

        .form-group input::placeholder {
            color: rgba(212, 175, 55, 0.4);
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--gold);
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .toggle-password:hover {
            color: var(--gold-light);
            transform: translateY(-50%) scale(1.2);
        }

        .captcha-group {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .captcha-wrapper {
            flex: 0 0 120px;
            border: 2px solid var(--gold);
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .captcha-wrapper:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.4);
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
            color: var(--gold);
            text-decoration: none;
            transition: all 0.3s ease;
            animation: fadeIn 0.8s ease-out 0.8s backwards;
        }

        .forgot-link:hover {
            color: var(--gold-light);
            transform: translateX(-5px);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--gold-dark) 0%, var(--gold) 100%);
            color: var(--black);
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
            animation: fadeIn 0.8s ease-out 1s backwards;
        }

        .btn-login::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-login:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.4);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--black-light);
            font-size: 0.85rem;
            color: var(--gold);
            animation: fadeIn 0.8s ease-out 1.2s backwards;
        }

        /* Alert */
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

        /* Responsive */
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
                <div style="background: linear-gradient(135deg, rgba(212, 175, 55, 0.1) 0%, rgba(212, 175, 55, 0.05) 100%); border-left: 3px solid var(--gold); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.85rem; color: var(--gold-light);">
                    <i class="bi bi-info-circle-fill" style="margin-right: 0.5rem;"></i>
                    <strong>Info:</strong> Gunakan ID Member atau Username yang telah terdaftar untuk mengakses dashboard Anda.
                </div>

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
                    <p style="margin: 0 0 0.5rem 0;"><i class="bi bi-shield-lock-fill"></i> Keamanan Data Terjamin</p>
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
