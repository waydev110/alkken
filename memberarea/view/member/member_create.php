<?php 
    
    
    $token = create_token();

    require_once '../model/classMember.php';
    require_once '../model/classMemberProspek.php';
    require_once '../model/classKodeAktivasi.php';
    require_once '../model/classProvinsi.php';    
    require_once '../model/classBank.php';

    $cm = new classMember();
    $cmp = new classMemberProspek();
    $cka= new classKodeAktivasi();
    $cprov = new classProvinsi();
    $cb = new classBank();

    $bank = $cb->semua_bank();
    $provinsi = $cprov->index();

    $member_prospek = $cmp->index($session_member_id);

    $kode_aktivasi = $cka->index_member_new($session_member_id, 0);  

    $idsponsor = $session_member_id;
    $readonly  = "readonly";
?>

<?php include 'view/layout/header.php'; ?>
<link rel="stylesheet" href="assets/vendor/intlTelInput/css/intlTelInput.css">
<link rel="stylesheet" href="assets/vendor/select2/css/select2.min.css">
<!-- All form styles moved to assets/css/custom-memberarea.css -->
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
        <form action="controller/member/member_create.php" id="formPendaftaran" method="post">
            <?php
                if($kode_aktivasi->num_rows == 0 ){
            ?>
            <div class="alert alert-danger text-center">
                Anda tidak memiliki <?=$lang['kode_aktivasi']?>.
            </div>
            <?php
                } else {
            ?>
            <input type="hidden" name="token" value="<?=$token?>">
            <div class="row mb-3">
                <div class="col-12">
                    <h6>Data Pendaftaran</h6>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="avatar avatar-50 shadow-sm rounded-10 bg-warning text-white">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </div>
                                </div>
                                <div class="col align-self-center ps-0">
                                    <div class="row mb-2 position-relative">
                                        <?php 
                                        $readonly = '';
                                        if($_sponsor_static == true) { 
                                            $readonly = ' readonly="readonly"';                                    
                                        ?> 
                                        <input type="hidden" id="sponsor" name="sponsor" value="<?=$session_member_id?>">
                                        <?php } ?> 
                                        <div class="col pe-0">
                                            <div class="form-group form-floating-2">
                                                <input type="text" class="form-control pt-4 pb-2 text-left" id="id_sponsor" value="<?=$session_id_member?>" <?=$readonly?>>
                                                <label class="form-control-label">ID <?=$lang['sponsor']?></label>
                                            </div>
                                        </div>
                                        <div class="col align-self-center ps-0">
                                            <div class="form-group form-floating-2">
                                                <input type="text" class="form-control pt-4 pb-2 text-end" value="<?=$session_nama_samaran?>" readonly="readonly">>
                                                <label class="form-control-label text-end pe-1 end-0 start-auto">Nama
                                                    <?=$lang['sponsor']?></label>
                                            </div>
                                        </div>
                                        <span
                                            class="btn btn-34 bg-warning text-white shadow-sm position-absolute start-50 top-50 translate-middle">
                                            <i class="fas fa-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group form-floating-2 mb-4">
                        <select class="form-control" id="paket_join" name="paket_join">
                            <?php 
                            while ($row   = $kode_aktivasi->fetch_object()) {
                                echo "<option value='".$row->jenis_aktivasi."'>".$row->nama_plan."</option>";
                            }
                            ?>
                        </select>
                        <label class="form-control-label" for="paket_join">Paket Join</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group form-floating-2 mb-3">
                        <select class="form-control" id="tipe_akun" name="tipe_akun">
                            <option value="0"><?=$lang['member']?> Baru</option>
                        </select>
                        <label class="form-control-label" for="tipe_akun">Tipe Pendaftaran</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3" id="blockDataMember">
                <div class="col-12 mt-2 mb-3">
                    <h6>Data <?=$lang['member']?></h6>
                </div>
                <div class="col-12">
                    <div class="form-group form-floating-2 mb-4">
                        <input type="text" class="form-control" id="username" name="username" required="required">
                        <label class="form-control-label" for="username">Username</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group form-floating-2-fix mb-4">
                        <input type="text" class="form-control" id="nama_member" name="nama_member" value="">
                        <label class="form-control-label" for="nama_member">Nama Lengkap</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group form-floating-2-fix mb-4">
                        <input type="text" class="form-control" id="nama_samaran" name="nama_samaran" value="">
                        <label class="form-control-label" for="nama_samaran">Nama Samaran</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group form-floating-2-fix mb-4">
                        <input type="text" class="form-control" id="wa_member" name="wa_member" value="">
                        <label class="form-control-label" for="wa_member">No Whatsapp <?=$lang['member']?></label>
                    </div>
                    <p class="text-danger size-12" id="error-hp"></p>
                    <p class="text-success size-12" id="valid-hp"></p>
                </div>
                <div class="col-12 mt-2 mb-3">
                    <h6>Data Alamat</h6>
                </div>
                <div class="col-12">
                   <div class="form-group form-floating-2 mb-4">
                       <select class="form-control select2" id="provinsi" name="provinsi">
                           <option value="">Pilih Provinsi</option>
                           <?php while ($row = $provinsi->fetch_object()) {?>
                           <option value="<?=$row->id?>"><?=$row->nama_provinsi?></option>
                           <?php } ?>
                       </select>
                       <label class="form-control-label" for="provinsi">Provinsi</label>
                   </div>
                </div>
                <div class="col-12">
                   <div class="form-group form-floating-2 mb-4">
                       <select class="form-control select2" id="kota" name="kota">
                           <option value="">Pilih Kab/Kota</option>
                       </select>
                       <label class="form-control-label" for="kota">Kabupaten/Kota</label>
                   </div>
                </div>
                <div class="col-12">
                   <div class="form-group form-floating-2 mb-4">
                       <select class="form-control select2" id="kecamatan" name="kecamatan">
                           <option value="">Pilih Kecamatan</option>
                       </select>
                       <label class="form-control-label" for="kecamatan">Kecamatan</label>
                   </div>
                </div>
                <div class="col-12">
                   <div class="form-group form-floating-2 mb-4">
                       <select class="form-control select2" id="kelurahan" name="kelurahan">
                           <option value="">Pilih Kelurahan</option>
                       </select>
                       <label class="form-control-label" for="kelurahan">Kelurahan</label>
                   </div>
                </div>
                <div class="col-12">
                   <div class="form-group form-floating-2 mb-4">
                       <textarea class="form-control" id="alamat_member" name="alamat_member"></textarea>
                       <label class="form-control-label" for="alamat_member">Alamat</label>
                   </div>
                </div>
                <div class="col-12 mt-3 mb-2">
                    <h6>Data Bank</h6>
                </div>
                <div class="col-12">
                    <div class="form-group form-floating-2 mb-4">
                        <select class="select2 form-control" id="bank" name="bank" required="required">
                            <option value="">Pilih Bank</option>
                            <?php while ($row = $bank->fetch_object()) {?>
                            <option value="<?=$row->id?>"?><?=$row->nama_bank?></option>
                            <?php } ?>
                        </select>
                        <label class="form-control-label" for="bank">Bank</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group form-floating-2 mb-4">
                        <input type="text" class="form-control" id="no_rekening" name="no_rekening" value="" required="required">
                        <label class="form-control-label" for="no_rekening">No Rekening</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group form-floating-2 mb-4">
                        <input type="text" class="form-control" id="atas_nama_rekening" name="atas_nama_rekening" value="" required="required" disabled="disabled">
                        <label class="form-control-label" for="atas_nama_rekening">Nama Pemilik Rekening</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group form-floating-2 mb-4">
                        <input type="text" class="form-control" id="cabang_rekening" name="cabang_rekening" value="" required="required">
                        <label class="form-control-label" for="cabang_rekening">Cabang</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3" id="blockDataMemberProspek" style="display:none">
                <div class="col-12 mb-3">
                    <h6>Data <?=$lang['member']?> Prospek</h6>
                </div>
                <div class="col-12">
                    <div class="form-group form-floating-2-fix mb-4">
                        <select class="form-control" id="member_prospek" name="member_prospek">
                        <?php 
                            while ($row = $member_prospek->fetch_object()) {
                                echo "<option value='".$row->id."'>". $row->nama_member."</option>";
                            }
                            ?>
                    </select>
                        <label class="form-control-label" for="member_prospek"><?=$lang['member']?> Prospek</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col d-grid mb-4 mt-2">
                    <button type="button" class="btn btn-default btn-lg shadow-sm" id="btnSubmit">Submit</button>
                </div>
            </div>
            <?php } ?>
        </form>
    </div>
    <?php include 'view/auth/form_cek_pin.php'; ?>
    <!-- main page content ends -->
</main>
<!-- Page ends-->
<?php include 'view/layout/assets_js.php'; ?>
<?php include 'view/layout/wilayah.php'; ?>
<script src="assets/vendor/select2/js/select2.min.js"></script>
<script src="assets/vendor/intlTelInput/js/intlTelInput.js?1638200991544"></script>
<script src="assets/vendor/intlTelInput/js/isValidNumber.js?1638200991544"></script>
<script class="iti-load-utils" async src="assets/vendor/intlTelInput/js/utils.js?1638200991544"></script>
<script src="assets/vendor/jquery-validation-1.19.5/jquery.validate.min.js"></script>

<script>
    $(document).ready(function () {
        var blockFirstForm = $('#blockFirstForm');
        var blockNextForm = $('#blockNextForm');
        var blockDataMember = $('#blockDataMember');
        var blockDataMemberProspek = $('#blockDataMemberProspek');
        var formCekPIN = $('#formCekPIN');
        var formPendaftaran = $('#formPendaftaran');
        var btnSubmit = $('#btnSubmit');
        var tipeAkun = $('#tipe_akun');


        $('#nama_member').on("keyup", function (e) {
            $('#atas_nama_rekening').val(e.target.value);
        });
        $('.select2').select2();
        tipeAkun.on("change", function (e) {
            if(e.target.value == '0'){
                blockDataMemberProspek.hide();
                blockDataMember.show();
            } else if(e.target.value == '1') {
                blockDataMemberProspek.hide();
                blockDataMember.hide();
            } else {
                blockDataMember.hide();
                blockDataMemberProspek.show();
            }
        });
        formPendaftaran.validate({
            rules: {
                kode_aktivasi: "required",
                nama_member: {
                    required: true,
                    minlength: 3
                },
                nama_samaran: {
                    required: true,
                    minlength: 3
                },
                wa_member: {
                    required: true
                },
                tempat_lahir:"required",
                tanggal_lahir:"required",
                nik:{
                    required:true,
                    minlength:16
                },
                kota:"required",
                kecamatan:"required",
                kelurahan:"required",
                rtrw:"required",
                kodepos:{
                    required:true,
                    minlength:5,
                    maxlength:5
                },
                alamat:"required",
                bank:"required",
                no_rekening:{
                    required:true,
                    minlength:10,
                    maxlength:16
                },
                username:{
                    required:true,
                    verifyUsername:true
                },
                atas_nama_rekening:"required",
                cabang_rekening:"required"
            },
            messages: {
                kode_aktivasi: "Silahkan pilih PIN.",
                nama_member: {
                    required: "Nama tidak boleh kosong.",
                    minlength: "Nama minimal 3 karakter."
                },
                nama_samaran: {
                    required: "Nama tidak boleh kosong.",
                    minlength: "Nama minimal 3 karakter."
                },
                wa_member: {
                    required: "Nomor Whatsapp tidak boleh kosong."
                },
                kota:"Kota tidak boleh kosong.",
                alamat:"Alamat tidak boleh kosong.",
                bank:"Bank tidak boleh kosong.",
                no_rekening:{
                    required:"Nomor rekening tidak boleh kosong.",
                    minlength:"Nomor rekening minimal 10 digit.",
                    maxlength:"Nomor rekening maksimal 16 digit."
                },
                atas_nama_rekening:"Atas nama rekening tidak boleh kosong.",
                cabang_rekening:"Cabang/Unit rekening tidak boleh kosong.",
            }
        });

        $.validator.addMethod("verifyUsername", function(value) {
            var response = 'false';
            $.ajax({
                type: 'post',
                url: 'controller/auth/cek_username.php',
                data: {username: value},
                async:false,
                success: function (result) {
                    const obj = JSON.parse(result);
                    response = obj.status;
                },
            });
            if(response == true){
                console.log(response);
                return true;
            } else {
                console.log(response);
                return false;
            }
        }, 'Username tidak tersedia.');

        btnSubmit.on("click", function (e) {
            if (formPendaftaran.valid()) {
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
                        formPendaftaran.submit();
                    } else {
                        if (result == 'limit') {
                            formCekPIN.html('');
                            formCekPIN.prepend(
                                '<p class="form-error text-center text-danger mb-1">Anda salah memasukan PIN sebanyak 3 kali.</p><p class="form-error text-center text-danger mb-3">Silahkan coba beberapa saat lagi.</p>'
                            );

                        } else {
                            if (formCekPIN.find('.form-error').length == 0) {
                                formCekPIN.prepend(
                                    '<p class="form-error text-center text-danger mb-3">PIN yang anda masukan salah.</p>'
                                );

                            }
                        }
                    }
                }
            });
            e.preventDefault();
        });

        formPendaftaran.on("submit", function (e) {

            $('input[name=hp_member').val(iti.getNumber());
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                beforeSend: function () {
                    loader_open();
                },
                success: function (result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        var redirect_url = 'genealogy';
                        show_success_html(obj.message, redirect_url);
                    } else {
                        var redirect_url = 'genealogy';
                        show_error(obj.message, redirect_url);
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

        // $.validator.addMethod("verifyWA", function(value) {
        //     var response = 'false';
        //     $.ajax({
        //         type: 'post',
        //         url: 'controller/profil/cek_wa.php',
        //         data: {wa: value},
        //         async:false,
        //         success: function (result) {
        //             response = result;
        //         },
        //     });
        //     if(response == 'true'){
        //         console.log(response);
        //         return true;
        //     } else {
        //         console.log(response);
        //         return false;
        //     }
        // }, 'Nomor Whatsapp sudah digunakan.');
    });
    // function get_member_prospek(){
    //     $.ajax({
    //         type: 'post',
    //         url: 'controller/member_prospek/get_member_prospek.php',
    //         dataType: 'html',
    //         // beforeSend: function () {
    //         //     loader_open();
    //         // },
    //         success: function (html) {
    //             if(html == '') {
    //                 alert('Tidak ada prospek');
    //             } else {
    //                 $('#member_prospek').html(html);
    //             }
    //         },
    //         // complete: function () {
    //         //     loader_close();
    //         // }
    //     });
    // }
</script>
<?php include 'view/layout/footer.php'; ?>