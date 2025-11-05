<?php 
    require_once '../helper/session.php';
    
    $token = create_token();

    require_once '../model/classMember.php';
    $c = new classMember();
    $member = $c->detail($session_member_id);

    
    require_once '../model/classProvinsi.php';
    $cpr = new classProvinsi();
    $provinsi = $cpr->index();
    
    require_once '../model/classKota.php';
    $ck = new classKota();
    $kota = $ck->get_kota($member->id_provinsi);
    // $kota = $ck->semua_kota();
    
    require_once '../model/classKecamatan.php';
    $ckec = new classKecamatan();
    $kecamatan = $ckec->get_kecamatan($member->id_kota);
    
    require_once '../model/classKelurahan.php';
    $ckel = new classKelurahan();
    $kelurahan = $ckel->get_kelurahan($member->id_kecamatan);

    require_once '../model/classBank.php';
    $cb = new classBank();
    $bank = $cb->semua_bank();

    if(!$member){
        redirect('500');
    }
    // $tgl_lahir_member = $member->tgl_lahir_member == '' ? date('Y-m-d') : $member->tgl_lahir_member;
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
        <form action="controller/profil/update_alamat.php" id="formUpdateProfil" method="post">
            <input type="hidden" name="token" value="<?=$token?>">
            <div class="row">
                <div class="col-12 mt-3 mb-2">
                    <h6> Data Alamat</h6>
                </div>
                <div class="col-12">
                    <div class="form-group form-floating mb-4">
                        <select class="form-control select2" id="provinsi" name="provinsi">
                            <option value="">Pilih Provinsi</option>
                            <?php while ($row = $provinsi->fetch_object()) {?>
                            <option value="<?=$row->id?>"
                                <?=$member->id_provinsi == $row->id ? 'selected="selected"' : ''?>>
                                <?=$row->nama_provinsi?></option>
                            <?php } ?>
                        </select>
                        <label class="form-control-label" for="provinsi">Provinsi</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group form-floating mb-4">
                        <select class="select2 form-control" id="kota" name="kota">
                            <option value="">Pilih Kab/Kota</option>
                            <?php while ($row = $kota->fetch_object()) {?>
                            <option value="<?=$row->id?>"
                                <?=$member->id_kota == $row->id ? 'selected="selected"' : ''?>>
                                <?=$row->nama_kota?></option>
                            <?php } ?>
                        </select>
                        <label class="form-control-label" for="kota">Kabupaten/Kota</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group form-floating mb-4">
                        <select class="form-control select2" id="kecamatan" name="kecamatan">
                            <option value="">Pilih Kecamatan</option>
                            <?php while ($row = $kecamatan->fetch_object()) {?>
                            <option value="<?=$row->id?>"
                                <?=$member->id_kecamatan == $row->id ? 'selected="selected"' : ''?>>
                                <?=$row->nama_kecamatan?></option>
                            <?php } ?>
                        </select>
                        <label class="form-control-label" for="kecamatan">Kecamatan</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group form-floating mb-4">
                        <select class="form-control select2" id="kelurahan" name="kelurahan">
                            <option value="">Pilih Kelurahan</option>
                            <?php while ($row = $kelurahan->fetch_object()) {?>
                            <option value="<?=$row->id?>"
                                <?=$member->id_kelurahan == $row->id ? 'selected="selected"' : ''?>>
                                <?=$row->nama_kelurahan?></option>
                            <?php } ?>
                        </select>
                        <label class="form-control-label" for="kelurahan">Kelurahan</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group form-floating mb-4">
                        <textarea class="form-control" id="alamat_member"
                            name="alamat_member"><?=$member->alamat_member?></textarea>
                        <label class="form-control-label" for="alamat_member">Alamat</label>
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
    var target = '<?=$_GET['target']?>';
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
                    minlength: 10,
                    maxlength: 16
                },
                nama_samaran: {
                    required: true,
                    verifyUsername: true
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
                    minlength: "Nomor rekening minimal 10 digit.",
                    maxlength: "Nomor rekening maksimal 16 digit."
                },
                atas_nama_rekening: "Atas nama rekening tidak boleh kosong.",
                cabang_rekening: "Cabang/Unit rekening tidak boleh kosong.",
            }
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
                        var message =
                            'Update alamat berhasil.';
                        if(target.length > 0){
                            var redirect_url = target;
                        } else {
                            var redirect_url = 'profil';
                        }

                        show_success(message, redirect_url);
                    } else {
                        var message =
                            'Update profil gagal. Silahkan coba beberapa saat lagi atau jika masih gagal hubungi kami untuk pemecahan masalah.';
                        var redirect_url = 'profil';
                        show_success(message, redirect_url);
                    }
                },
                complete: function () {
                    loader_close();
                }
            });
            e.preventDefault();
        });

        $('.input_pin').keyup(function (e) {
            var key = e.keyCode || e.charCode;

            if (key == 8 || key == 46) {
                if (this.value == '') {
                    $(this).attr('type', 'text');
                    if (!$(this).is(':first-child')) {
                        $(this).prev('.input_pin').focus();
                    } else {
                        formCekPIN.find('.form-error').remove();
                    }
                }
            } else {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    this.value = '';
                } else {
                    if (this.value.length >= this.maxLength) {
                        $(this).delay(300).queue(function () {
                            $(this).attr('type', 'password').dequeue();
                        });
                        if (!$(this).is(':last-child')) {
                            $(this).next('.input_pin').focus();
                        } else {
                            if ($(this).parents('#formCekPIN').length > 0) {
                                formCekPIN.submit();
                            }
                        }
                    }
                }
            }
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