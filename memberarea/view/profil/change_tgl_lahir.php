<?php 
    $token = create_token();

    require_once '../model/classMember.php';
    $c = new classMember();
    $member = $c->detail($session_member_id);
    $tgl_lahir_member = $member->tgl_lahir_member == '' || $member->tgl_lahir_member == null ? '' : $member->tgl_lahir_member;
?>
<?php include 'view/layout/header.php'; ?>
<link rel="stylesheet" href="assets/vendor/select2/css/select2.min.css">
<style>
    .form-floating>label.error {
        position: absolute;
        top: auto !important;
        bottom: -42px;
        left: 0;
        color: red;
    }
</style>
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
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4" id="blockFirstForm">
        <form action="controller/profil/update_tgl_lahir.php" id="formUpdateProfil" method="post">
            <input type="hidden" name="token" value="<?=$token?>">
            <div class="row">
                <div class="col-12 mt-3 mb-2">
                    <h6> Data Diri</h6>
                </div>
                <div class="col-12">
                    <div class="form-group form-floating mb-4">
                        <input type="text" class="form-control" id="nama_samaran" name="nama_samaran"
                            value="<?=$member->nama_samaran?>">
                        <label class="form-control-label" for="nama_samaran">Nama Samaran</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group form-floating-fix mb-4">
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?=$member->tempat_lahir_member?>">
                        <label class="form-control-label" for="tempat_lahir">Tempat Lahir</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group form-floating-fix mb-4">
                        <div class="input-group">
                            <input type="text" class="form-control datepicker" id="tanggal_lahir" name="tanggal_lahir" autocomplete="off" value="<?=$member->tgl_lahir_member <> '0000-00-00' && $member->tgl_lahir_member <> null && $member->tgl_lahir_member <> '' ? date('d/m/Y', strtotime($member->tgl_lahir_member)) : ''?>">
                        </div>
                        <label class="form-control-label" for="tanggal_lahir">Tanggal Lahir</label>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12 align-self-center text-end mt-2 d-xs-grid">
                    <a href="<?=site_url('profil')?>" class="btn btn-outline-primary btn-lg rounded-pill px-5 mb-2"
                        id="btnKembali">BATAL</a>
                    <button type="button" class="btn btn-primary btn-lg rounded-pill px-5 mb-2 shadow-sm order-xs-first"
                        id="btnUpdate">Perbaharui</button>
                </div>
            </div>
        </form>
    </div>
    <?php include 'view/auth/form_cek_pin.php'; ?>
    <!-- main page content ends -->
</main>
<!-- Page ends-->
<?php include 'view/layout/assets_js.php'; ?>
<script src="assets/vendor/select2/js/select2.min.js"></script>
<script src="assets/vendor/jquery-validation-1.19.5/jquery.validate.min.js"></script>
<?php include 'view/layout/wilayah.php'; ?>
<script>
    $(document).ready(function () {
        var blockFirstForm = $('#blockFirstForm');
        var blockNextForm = $('#blockNextForm');
        var formCekPIN = $('#formCekPIN');
        var formUpdateProfil = $('#formUpdateProfil');
        var btnUpdate = $('#btnUpdate');

        // jQuery.validator.setDefaults({
        //     submitHandler: function (){

        //     }
        // });

        formUpdateProfil.validate({
            rules: {
                nama_member: {
                    required: true,
                    minlength: 3
                },
                tempat_lahir: "required",
                tanggal_lahir: "required",
                nik: {
                    required: true,
                    minlength: 16
                },
                kota: "required",
                kecamatan: "required",
                kelurahan: "required",
                rtrw: "required",
                kodepos: {
                    required: true,
                    minlength: 5,
                    maxlength: 5
                },
                alamat: "required",
                bank: "required",
                no_rekening: {
                    required: true,
                    minlength: 9,
                    maxlength: 16
                },
                nama_samaran: {
                    required: true
                },
                atas_nama_rekening: "required",
                cabang_rekening: "required"
            },
            messages: {
                nama_member: {
                    required: "Masukan nama lengkap anda.",
                    minlength: "Nama lengkap minimal 3 karakter."
                },
                tempat_lahir: "Masukan tempat lahir anda.",
                tanggal_lahir: "Masukan tanggal lahir anda.",
                nik: {
                    required: "Masukan Nomor KTP anda.",
                    minlength: "Nomor NIK minimal 16 digit."
                },
                provinsi: "provinsi tidak boleh kosong.",
                kota: "Kota tidak boleh kosong.",
                kecamatan: "Kecamatan tidak boleh kosong.",
                kelurahan: "Kelurahan tidak boleh kosong",
                rtrw: "RT/RW tidak boleh kosong",
                kodepos: {
                    required: "Kodepos tidak boleh kosong.",
                    minlength: "Kodepos harus 5 digit.",
                    maxlength: "Kodepos harus 5 digit."
                },
                alamat: "Alamat tidak boleh kosong.",
                bank: "Bank tidak boleh kosong.",
                no_rekening: {
                    required: "Nomor rekening tidak boleh kosong.",
                    minlength: "Nomor rekening minimal 9 digit.",
                    maxlength: "Nomor rekening maksimal 16 digit."
                },
                atas_nama_rekening: "Atas nama rekening tidak boleh kosong.",
                cabang_rekening: "Cabang/Unit rekening tidak boleh kosong.",
            }
        });
        $('#nama_member').on("keyup", function (e) {
            $('#atas_nama_rekening').val(this.value);
            e.preventDefault();
        });
        btnUpdate.on("click", function (e) {
            if (formUpdateProfil.valid()) {
                blockFirstForm.hide();
                blockNextForm.show();
                $('input[name=old_pin1]').focus();
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
                        formUpdateProfil.submit();
                    } else {
                        if (result == 'limit') {
                            formCekPIN.html('');
                            formCekPIN.prepend(
                                '<p class="form-error text-center text-danger mb-1">Anda salah memasukan PIN sebanyak 3 kali.</p><p class="form-error text-center text-danger mb-4">Silahkan coba beberapa saat lagi.</p>'
                            );

                        } else {
                            if (formCekPIN.find('.form-error').length == 0) {
                                formCekPIN.prepend(
                                    '<p class="form-error text-center text-danger mb-4">PIN yang anda masukan salah.</p>'
                                );

                            }
                        }
                    }
                }
            });
            e.preventDefault();
        });

        formUpdateProfil.on("submit", function (e) {
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                beforeSend: function () {
                    loader_open();
                },
                success: function (result) {
                    if (result == true) {
                        var message = `Update tempat tanggal lahir berhasil. Silahkan cek perubahan di halaman profil`;
                        var redirect_url = 'profil';
                        show_success(message, redirect_url);
                    } else {
                        var message =
                            'Update profil gagal. Silahkan coba beberapa saat lagi atau jika masih gagal hubungi kami untuk pemecahan masalah.';
                        var redirect_url = 'profil';
                        show_error(message, redirect_url);
                    }
                },
                complete: function () {
                    loader_close();
                }
            });
            e.preventDefault();
        });

        $.validator.addMethod("verifyUsername", function (value) {
            var response = 'false';
            $.ajax({
                type: 'post',
                url: 'controller/auth/cek_username.php',
                data: {
                    username: value
                },
                async: false,
                success: function (result) {
                    const obj = JSON.parse(result);
                    response = obj.status;
                },
            });
            if (response == true) {
                console.log(response);
                return true;
            } else {
                console.log(response);
                return false;
            }
        }, 'Username tidak tersedia.');

        //     $.validator.addMethod("verifyNIK", function(value) {
        //         var response = 'false';
        //         $.ajax({
        //             type: 'post',
        //             url: 'controller/profil/cek_nik.php',
        //             data: {nik: value},
        //             async:false,
        //             success: function (result) {
        //                 response = result;
        //             },
        //         });
        //         if(response == 'true'){
        //             console.log(response);
        //             return true;
        //         } else {
        //             console.log(response);
        //             return false;
        //         }
        // 	}, 'NIK sudah digunakan.');

        //     $.validator.addMethod("verifyRekening", function(value) {
        //         var response = 'false';
        //         $.ajax({
        //             type: 'post',
        //             url: 'controller/profil/cek_no_rekening.php',
        //             data: {no_rekening: value},
        //             async:false,
        //             success: function (result) {
        //                 response = result;
        //             },
        //         });
        //         if(response == 'true'){
        //             console.log(response);
        //             return true;
        //         } else {
        //             console.log(response);
        //             return false;
        //         }
        // 	}, 'Rekening sudah digunakan.');

        $('.select2').select2();
    });
</script>
<?php include 'view/layout/footer.php'; ?>