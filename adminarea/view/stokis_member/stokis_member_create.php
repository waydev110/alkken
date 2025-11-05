<?php
require_once("../model/classStokisMember.php");
require_once("../model/classStokisPaket.php");
$obj = new classStokisMember();
$cp = new classStokisPaket();
require_once("../model/classKota.php");
$classKota = new classKota();
$kota = $classKota->index();
$result_paket = $cp->index();
?>
<link rel="stylesheet" href="../assets/plugins/intlTelInput/css/intlTelInput.css">
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?=$title?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body box-profile">
                <form class="form-horizontal" enctype="multipart/form-data"
                    action="controller/<?=$mod_url?>/<?=$mod_url?>_create.php" method="post" id="formCreate">
                    <div class="box-body">
                        <div class="form-group border-bottom-1">
                            <label for="" class="col-sm-3 control-title">Data Stokis</label>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Pilih Paket</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" id="id_paket" name="id_paket" required="required">
                                    <option>-- Pilih Paket --</option>
                                    <?php
                                    while($row = $result_paket->fetch_object()){
                                    ?>
                                    <option value="<?=$row->id?>"><?=$row->nama_paket?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Nama Stokis</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama_stokis" name="nama_stokis">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="no_handphone" class="col-sm-3 control-label">No WhatsApp</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="wa_stokis" id="wa_stokis" placeholder="">
                                <span class="text-danger size-12" id="error_hp"></span>
                                <span class="text-success size-12" id="valid_hp"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="email" id="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="id_kota" class="col-sm-3 control-label">Kabupaten/Kota</label>
                            <div class="col-sm-9">
                                <select class="select2 form-control" id="id_kota" name="id_kota">
                                    <option value="">Pilih Kab/Kota</option>
                                    <?php while ($row = $kota->fetch_object()) {?>
                                    <option value="<?=$row->id?>">
                                        <?=$row->nama_kota?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="form-group border-bottom-1">
                            <label for="" class="col-sm-3 control-title">Data Alamat</label>
                        </div> -->
                        <?php 
                        // require_once("view/component/alamat_create.php"); 
                        ?>
                        <div class="form-group border-bottom-1">
                            <label for="" class="col-sm-3 control-title">Data Login</label>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Username</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="username" id="username">
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Password</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="password" id="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Ulangi Password</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="ulangi_password" id="ulangi_password">
                            </div>
                        </div> -->
                        <div class="bottom">
                            <a href="?go=<?=$mod_url?>" class="btn btn-default"> <i class="fa fa-arrow-left"></i>
                                Batal</a>
                            <button type="button" class="btn btn-primary pull-right" id="btnSubmit"><i
                                    class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="../assets/plugins/intlTelInput/js/intlTelInput.js?1638200991544"></script>
<script src="../assets/plugins/intlTelInput/js/isValidNumber.js?1638200991544"></script>
<script class="iti-load-utils" async src="../assets/plugins/intlTelInput/js/utils.js?1638200991544"></script>
<script src="../assets/plugins/jquery-validation-1.19.5/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        var formCreate = $('#formCreate');
        var btnSubmit = $('#btnSubmit');

        btnSubmit.on("click", function (e) {
            if (formCreate.valid()) {
                formCreate.submit();
            }
        });

        formCreate.validate({
            rules: {
                nama_stokis: {
                    required: true,
                    minlength: 5,
                    maxlength: 50
                },
                wa_stokis: {
                    required: true
                },
                email: {
                    email: true
                },
                // id_provinsi: "required",
                // id_kota: "required",
                // id_kecamatan: "required",
                // id_kelurahan: "required",
                // rt: {
                //     required: true,
                //     minlength: 3,
                //     maxlength: 3
                // },
                // rw: {
                //     required: true,
                //     minlength: 3,
                //     maxlength: 3
                // },
                // kodepos: {
                //     required: true,
                //     minlength: 5,
                //     maxlength: 5
                // },
                // alamat: {
                //     required: true,
                //     minlength: 10,
                //     maxlength: 100
                // },
                username: {
                    required: true,
                    minlength: 5,
                    maxlength: 15,
                    verifyUsername: true
                },
                password: "required",
                ulangi_password: {
                    equalTo: "#password"
                }
            },
            messages: {
                nama_stokis: {
                    required: "Nama Stokis tidak boleh kosong.",
                    minlength: "Nama Stokis minimal 5 karakter.",
                    maxlength: "Nama Stokis minimal 50 karakter."
                },
                nomor_hp: {
                    required: "Nomor Whatsapp tidak boleh kosong."
                },
                email: {
                    required: "Email tidak valid."
                },
                // id_provinsi: "Provinsi tidak boleh kosong.",
                // id_kota: "Kota tidak boleh kosong.",
                // id_kecamatan: "Kecamatan tidak boleh kosong.",
                // id_kelurahan: "Kelurahan tidak boleh kosong.",
                // alamat: "Alamat tidak boleh kosong.",
                // rt: {
                //     required: "RT tidak boleh kosong.",
                //     minlength: "RT harus 3 karakter.",
                //     maxlength: "RT harus 3 karakter."
                // },
                // rw: {
                //     required: "RW tidak boleh kosong.",
                //     minlength: "RW harus 3 karakter.",
                //     maxlength: "RW harus 3 karakter."
                // },
                username: {
                    required: "Username tidak boleh kosong.",
                    minlength: "Username minimal 5 karakter.",
                    maxlength: "Username maksimal 15 karakter."
                },
                password: {
                    required: "Password tidak boleh kosong."
                },
                ulangi_password: {
                    equalTo: "Password tidak sama."
                },
            }
        });

        $.validator.addMethod("verifyUsername", function (value) {
            var response = 'false';
            $.ajax({
                type: 'post',
                url: 'controller/stokis_member/cek_username.php',
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
        
        formCreate.on("submit", function (e) {
            $('input[name=no_handphone').val(iti.getNumber());
        });
    });
</script>