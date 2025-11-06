<?php 
    require_once 'helper/session.php';
    $token = create_token();

    require_once '../model/classMember.php';
    require_once '../model/classBank.php';

    $c = new classMember();
    $cb = new classBank();

    $member = $c->detail($session_member_id);
    $bank = $cb->semua_bank();

    if(!$member){
        redirect('500');
    }
?>

<?php include 'view/layout/header.php'; ?>
<link rel="stylesheet" href="assets/vendor/select2/css/select2.min.css">

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
            <div class="row">                
                <div class="col-12 mb-3">
                    <h5 class="text-center mb-2">Ganti Rekening Bank</h5>
                    <p class="text-center mb-2 text-muted size-12">Rekening digunakan untuk menerima pencairan bonus. Pastikan nomor rekening benar dan milik anda sendiri.</p>
                </div>
            </div>
            <form action="controller/profil/update_rekening.php" id="formUpdateRekening" method="post">
                <input type="hidden" name="token" value="<?=$token?>">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group form-floating-2 mb-3">
                            <select class="select2 form-control" id="bank" name="bank" required="required">
                                <option value="">Pilih Bank</option>
                                <?php while ($row = $bank->fetch_object()) {?>
                                <option value="<?=$row->id?>" <?=$member->id_bank == $row->id ? 'selected="selected"' : ''?> ><?=$row->nama_bank?></option>
                                <?php } ?>
                            </select>
                            <label class="form-control-label" for="bank">Bank</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group form-floating-2 mb-3">
                            <input type="text" class="form-control" id="no_rekening" name="no_rekening" value="<?=$member->no_rekening?>" required="required">
                            <label class="form-control-label" for="no_rekening">No Rekening</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group form-floating-2 mb-3">
                            <input type="text" class="form-control" id="atas_nama_rekening" name="atas_nama_rekening" value="<?=$member->atas_nama_rekening?>" required="required">
                            <label class="form-control-label" for="atas_nama_rekening">Nama Pemilik Rekening</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group form-floating-2 mb-3">
                            <input type="text" class="form-control" id="cabang_rekening" name="cabang_rekening" value="<?=$member->cabang_rekening?>" required="required">
                            <label class="form-control-label" for="cabang_rekening">Cabang</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col d-grid mb-4">
                        <button type="button" class="btn btn-default btn-lg shadow-sm" id="btnUpdate">Simpan</button>
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
    <script>
        $(document).ready(function () {
            var blockFirstForm = $('#blockFirstForm');
            var blockNextForm = $('#blockNextForm');
            var formCekPIN = $('#formCekPIN');
            var formUpdateRekening = $('#formUpdateRekening');
            var btnUpdate = $('#btnUpdate');

            btnUpdate.on("click", function (e) {
                blockFirstForm.hide();
                blockNextForm.show();
                $('input[name=old_pin1]').focus();
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
                            formUpdateRekening.submit();
                        } else {
                            if(result == 'limit') {
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

            formUpdateRekening.on("submit", function (e) {
                var dataString = $(this).serialize();
                $.ajax({
                    type: $(this).attr("method"),
                    url: $(this).attr("action"),
                    data: dataString,
                    beforeSend: function() {
                        loader_open();
                    },
                    success: function (result) {
                        if (result == true) {
                            var message = 'Update rekening bank berhasil. Silahkan cek perubahan di halaman profil.';
                            var redirect_url = 'profil'; 
                            show_success(message, redirect_url);
                        } else {
                            var message = 'Update rekening bank gagal. Silahkan coba beberapa saat lagi atau jika masih gagal hubungi kami untuk pemecahan masalah.';
                            var redirect_url = 'profil'; 
                            show_success(message, redirect_url);
                        }
                    },
                    complete: function() {
                        loader_close();
                    }
                });
                e.preventDefault();
            });

            $('.input_pin').keyup(function (e) {
                var key = e.keyCode || e.charCode;

                if( key == 8 || key == 46 ){
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
                                if($(this).parents('#formCekPIN').length > 0) {
                                    formCekPIN.submit();
                                }
                            }
                        }
                    }
                }
            });
    
            $('.select2').select2();
        });
    </script>
    <?php include 'view/layout/footer.php'; ?>