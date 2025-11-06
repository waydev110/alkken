<?php 
    
    require_once '../model/classKodeAktivasi.php';
    $cka= new classKodeAktivasi();
    require_once '../model/classMember.php';
    $cm= new classMember();
 
    $kode_aktivasi = $cka->index_member_ro($session_member_id, 1);  
    if(isset($_GET['id_member'])){
        $id = base64_decode($_GET['id_member']);
        $member = $cm->detail($id);
        if(!$member){
            $id = $session_member_id;
            $member = $cm->detail($id);
        }
    } else {
        $id = $session_member_id;
        $member = $cm->detail($id);
    }
?>

<?php include 'view/layout/header.php'; ?>
<style>
    .form-floating-2-fix label.error {
        position: absolute;
        top: 60px !important;
        left: 0;
        color: red;
        font-size: 12px
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
        <form action="controller/posting_ro/posting_ro.php" id="formRO" method="post">
            <?php
                if($kode_aktivasi->num_rows == 0 ){
            ?>
                <div class="alert alert-danger alert-modern">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>Anda tidak memiliki <?= $lang['kode_aktivasi'] ?>.</span>
                </div>
            <?php
                } else {
            ?>
            <div class="row mb-3">
                <div class="col-12">
                    <h6>Data <?=$lang['member']?></h6>
                </div>
            </div>
            <div class="row mb-3">
                <input type="hidden" id="id" name="id" value="<?=base64_encode($member->id)?>">
                <div class="col align-self-center">
                    <div class="form-group form-floating-2">
                        <input type="text" class="form-control pt-4 pb-2" id="id_member" value="<?=$member->id_member?>" readonly="readonly">
                        <label class="form-control-label">ID <?=$lang['member']?></label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col align-self-center">
                    <div class="form-group form-floating-2">
                        <input type="text" class="form-control pt-4 pb-2" value="<?=$member->nama_samaran?>" readonly="readonly">
                        <label class="form-control-label">Nama
                            <?=$lang['member']?></label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <h6><?=$lang['kode_aktivasi']?></h6>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group form-floating-2 mb-4">
                        <select class="form-control" id="id_kodeaktivasi" name="id_kodeaktivasi">
                            <option value="">-- Pilih Paket --</option>
                            <?php
                            while ($row   = $kode_aktivasi->fetch_object()) {
                                echo "<option value='" . $row->id . "'>" . $row->nama_plan .' - '.$row->name. ' ' . $row->reposisi . ' ' . $row->founder . "</option>";
                            }
                            ?>
                        </select>
                        <label class="form-control-label" for="id_kodeaktivasi"><?=$lang['kode_aktivasi']?></label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col d-grid mb-4 mt-2">
                    <button type="button" class="btn btn-default btn-lg shadow-sm" id="btnSubmit">SUBMIT</button>
                </div>
            </div>
            <?php } ?>
        </form>
    </div>


    <?php include 'view/auth/form_cek_pin.php'; ?>
    <!-- main page content ends -->
</main>
<?php include 'view/layout/nav-bottom.php'; ?>
<!-- Page ends-->
<?php include 'view/layout/assets_js.php'; ?>
<script src="assets/vendor/jquery-validation-1.19.5/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        var blockFirstForm = $('#blockFirstForm');
        var blockNextForm = $('#blockNextForm');
        var blockDataMember = $('#blockDataMember');
        var formCekPIN = $('#formCekPIN');
        var formRO = $('#formRO');
        var btnSubmit = $('#btnSubmit');
        formRO.validate({
            rules: {
                kode_aktivasi: "required"
            },
            messages: {
                kode_aktivasi: "Silahkan pilih PIN RO."
            }
        });

        btnSubmit.on("click", function (e) {
            if (formRO.valid()) {
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
                        formRO.submit();
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

        formRO.on("submit", function (e) {

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
                        var redirect_url = 'history_posting_ro';
                        show_success_html(obj.message, redirect_url);
                    } else {
                        var redirect_url = 'history_posting_ro';
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
    });
</script>
<?php include 'view/layout/footer.php'; ?>