<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Login | StokisArea</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Halaman Login" />
    <link rel="shortcut icon" href="../favicon.png">

    <!-- Bootstrap -->
    <link href="../assets/theme1/css/bootstrap-dark.custom.css" rel="stylesheet" />
    <link href="../assets/theme1/css/icons.min.css" rel="stylesheet" />
    <link href="../assets/theme1/css/app-dark.custom.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/theme1/libs/sweetalert2/sweetalert2.min.css">

    <style>
        body {
            background: url('../background.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            backdrop-filter: blur(15px);
            background: rgba(0, 0, 0, 0.6);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        }

        .login-card h5 {
            font-size: 1.5rem;
            color: #fff;
        }

        .login-card p {
            font-size: 0.95rem;
            color: #ccc;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #fff;
        }

        .form-control::placeholder {
            color: #aaa;
        }

        .form-label {
            color: #ddd;
        }

        .btn-primary {
            background: #5c6bc0;
            border: none;
        }

        .btn-primary:hover {
            background: #3f51b5;
        }

        .logo {
            max-width: 120px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<div class="d-flex align-items-center justify-content-center vh-100">
    <div class="col-11 col-sm-8 col-md-6 col-lg-4">
        <div class="login-card">
            <div class="text-center">
                <img src="../logo.png" class="logo" alt="Logo">
                <h5>Selamat Datang!</h5>
                <p>Silakan masuk ke Stokisarea</p>
            </div>
            <form id="form" action="controller/login/index.php" method="POST" class="mt-4">
                <div class="mb-3">
                    <label for="identity" class="form-label">Username</label>
                    <input type="text" name="identity" id="identity" class="form-control" placeholder="Masukkan username" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group auth-pass-inputgroup">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" aria-label="Password" aria-describedby="password-addon">
                        <button class="btn btn-light" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                    </div>
                </div>
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">Masuk</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="../assets/theme1/libs/jquery/jquery.min.js"></script>
<script src="../assets/theme1/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/theme1/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="../assets/theme1/plugins/loadingoverlay/loadingoverlay.min.js"></script>
<script>
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
                    Swal.fire('Gagal!', pesan, 'error');
                }
            }
        });
    });
</script>

</body>
</html>
