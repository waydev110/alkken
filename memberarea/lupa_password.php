<?php 
date_default_timezone_set("Asia/Jakarta");
require_once '../model/classSetting.php';

$s = new classSetting();
$sitename = $s->setting('sitename');
$site_pt = $s->setting('site_pt');
$theme = $s->setting('theme_memberarea');
?>
<?php require_once("view/layout/header.php"); ?>
<?php require_once("view/layout/loader.php"); ?>

<style>
    body {
        background: url('../background.jpg') center center fixed;
        background-size: cover;
        font-family: 'Nunito', sans-serif;
        position: relative;
        margin: 0;
    }

    body::before {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 0;
    }

    main {
        position: relative;
        z-index: 1;
    }

    .header {
        background: linear-gradient(to right, rgba(74,144,226,0.9), rgba(34,193,195,0.9));
        padding: 1rem 0.5rem;
        border-radius: 0 0 12px 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    .logo-login img {
        width: 80px;
        border-radius: 8px;
    }

    .main-container {
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(6px);
        padding: 1.5rem 1rem;
        margin-top: 1.5rem;
        border-radius: 12px;
        max-width: 360px;
        margin-left: auto;
        margin-right: auto;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    h5, p {
        margin-bottom: 0.75rem;
        color: #333;
    }

    .form-group .form-control {
        border-radius: 10px;
        padding: 0.6rem 0.75rem;
        font-size: 0.95rem;
    }

    label {
        font-size: 0.85rem;
    }

    .btn {
        border-radius: 10px;
        font-size: 0.95rem;
        padding: 0.6rem 1rem;
    }

    .form-error {
        font-weight: 500;
        font-size: 0.9rem;
    }
</style>

<main class="h-100 has-header">
    <div class="text-center pt-3">
        <header class="header">
            <div class="logo-login">
                <img src="../logo.png" alt="Logo">
            </div>
        </header>
    </div>

    <!-- main content -->
    <div class="main-container" id="blockFirstForm">
        <h5 class="text-center">Lupa Password</h5>
        <p class="text-center">Masukkan ID akun Anda</p>

        <form action="controller/auth/lupa_password.php" id="formForgotPassword" method="post">
            <div class="form-group form-floating-2 mb-3">
                <input type="text" class="form-control" id="id_member" name="id_member" placeholder="ID Member">
                <label for="id_member">ID Member</label>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary">Kirim</button>
            </div>
            <div class="d-grid">
                <a href="login.php" class="btn btn-outline-secondary">Login</a>
            </div>
        </form>
    </div>
</main>

<?php require_once("view/layout/assets_js.php"); ?>

<script>
    $(document).ready(function () {
        var formForgotPassword = $('#formForgotPassword');
        formForgotPassword.on("submit", function (e) {
            e.preventDefault();
            formForgotPassword.find('.form-error').remove();
            var id_member = $('#id_member').val();

            if (id_member.trim() === '') {
                formForgotPassword.prepend(
                    '<p class="form-error text-center text-danger mb-3">ID Member tidak boleh kosong.</p>'
                );
                return;
            }

            $.ajax({
                url: $(this).attr('action'),
                data: { id_member },
                type: 'POST',
                dataType: 'html',
                success: function (pesan) {
                    if (pesan == true) {
                        setTimeout(() => {
                            window.location = 'lupa_password_successfull.php';
                        }, 1500);
                    } else {
                        formForgotPassword.prepend(
                            `<p class="form-error text-center text-danger mb-3">${pesan}</p>`
                        );
                    }
                }
            });
        });
    });
</script>

<?php require_once("view/layout/footer.php"); ?>
