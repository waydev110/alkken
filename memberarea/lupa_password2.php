<!doctype html>
<html lang="en">
    <head>        
        <meta charset="utf-8" />
        <!-- App favicon -->
        <title>Login | Memberarea</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Halaman Login" />
        <meta name="author" content="" />
        <link rel="shortcut icon" href="../favicon.png">

        <!-- Development Mode -->

        <!-- Bootstrap Css -->
        <link href="assets/member_area/css/bootstrap-dark.custom.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/member_area/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/member_area/css/app-dark.custom.css" id="app-style" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="assets/member_area/libs/sweetalert2/sweetalert2.min.css">
    </head>
    <style>
        body {
              background-image: url('bg.jpg'); /* Ganti dengan path gambar latar belakang Anda */
              background-size: cover;
              background-repeat: no-repeat;
              background-position: center;
        }
    </style>

    <body>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="p-3">
                	<div class="row justify-content-center">
                		<div class="col-md-12 col-lg-4 p-0">
                			<div class="card overflow-hidden rounded-0 h-100 bg-black">
                				<div class="bg-soft">
                					<div class="row">
                						<div class="col-8">
                							<div class="text-primary p-4">
                								<h5 class="text-primary">Lupa Password?</h5>
                								<p>Silahkan Masukan ID Anda.</p>
                							</div>
                						</div>
                						<div class="col-4 align-self-top text-right">
                							<!-- <img src="../logo.png" alt="" class="p-2 img-fluid" width="80" > -->
                						</div>
                					</div>
                				</div>
                				<div class="card-body pt-2"> 
                					<div class="p-2">
                						<form id="formForgotPassword" class="form-horizontal" action="controller/auth/lupa_password.php" method="post">

                							<div class="mb-3">
                								<label for="id_member" class="form-label">ID/User Member</label>
                								<input name="id_member" type="text" class="form-control" id="id_member" placeholder="Enter ID/User Member">
                							</div>
                							
                							<div class="mt-3 d-grid">
                								<button class="btn btn-primary waves-effect waves-light" type="submit">Kirim</button>
                							</div>

                							<div class="mt-4 text-center">
                								<a href="login.php" class="text-muted"><i class="mdi mdi-lock me-1"></i> Login</a>
                							</div>
                						</form>
                					</div>

                				</div>
                			</div>
                		</div>
                	</div>
                </div>
            </div>
        </div>
        <!-- end account-pages -->

        <!-- JAVASCRIPT -->
        <script src="assets/member_area/libs/jquery/jquery.min.js"></script>
        <script src="assets/member_area/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/member_area/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/member_area/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/member_area/libs/node-waves/waves.min.js"></script>
        <script src="assets/member_area/libs/sweetalert2/sweetalert2.min.js"></script>
        <script src="assets/member_area/plugins/loadingoverlay/loadingoverlay.min.js"></script>
        <!-- App js -->
        <script src="assets/member_area/js/app.js"></script>
        <script>
            $(document).ready(function () {
                var blockFirstForm = $('#blockFirstForm');
                var formForgotPassword = $('#formForgotPassword');

                formForgotPassword.on("submit", function (e) {
                    formForgotPassword.find('.form-error').remove();
                    var id_member = $('#id_member').val();

                    if (id_member == '') {
                        if (formForgotPassword.find('.form-error').length == 0) {
                            formForgotPassword.prepend(
                                '<p class="form-error text-center text-danger mb-3">ID Member tidak boleh kosong.</p>'
                                );
                        }
                    } else {
                        e.preventDefault();
                        //Gunakan jquery AJAX
                        var id_member = $('#id_member').val();
                        // var g_recaptcha_response = '';
                        // if (typeof grecaptcha === 'undefined') {
                        //     // alert('Please Connect to Internet');
                        //     // return false;
                        // } else {
                        //     g_recaptcha_response = grecaptcha.getResponse();
                        // }
                        var url = $(this).attr('action');
                        $.ajax({
                            url: url,
                            // data: 'id_member=' + id_member + '&recaptcha=' + g_recaptcha_response,
                            data: 'id_member=' + id_member, 
                            type: 'POST',
                            dataType: 'html',
                            success: function (pesan) {
                                if (pesan == true) {
                        			Swal.fire({
                        				title: 'Berhasil!',
                        				text: 'Permintaan Lupa Password Berhasil.',
                        				icon: 'success',
                        				confirmButtonColor: false,
                        				cancelButtonText: 'Batal'
                        			}).then((result) => {
                        				if (result.isConfirmed) {
                        					location.replace('login.php');
                        				}
                        			});
                                } else {
                                    formForgotPassword.prepend(`<p class="form-error text-center text-danger mb-3">${pesan}</p>`);
                                }
                            },
                        });
                    }
                    e.preventDefault();
                });
            });
        </script>
    </body>
</html>
