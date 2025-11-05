<?php
session_start();
$id_stokis = $_SESSION['session_stokis_id'];
require_once '../model/classStokisMember.php';
require_once '../model/classStokisPaket.php';
$obj = new classStokisMember();
$cp = new classStokisPaket();
$data = $obj->show($id_stokis);
$paket_stokis = $cp->show($data->id_paket)->nama_paket;
?>
<link rel="stylesheet" href="../assets/vendor/intlTelInput/css/intlTelInput.css">
<div class="row">
    <div class="col-md-12">
        <div class="box-body">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#biodata" data-toggle="tab">Data Stokis</a></li>
                    <li><a href="#data_alamat" data-toggle="tab">Data Alamat</a></li>
                    <li><a href="#data_login" data-toggle="tab">Data Login</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="biodata">
                        <?php require_once("data_stokis.php"); ?>
                    </div>
                    <div class="tab-pane" id="data_alamat">
                        <?php require_once("data_alamat.php"); ?>
                    </div>
                    <div class="tab-pane" id="data_login">
                        <?php require_once("data_login.php"); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../assets/vendor/intlTelInput/js/intlTelInput.js?1638200991544"></script>
<script src="../assets/vendor/intlTelInput/js/isValidNumber.js?1638200991544"></script>
<script class="iti-load-utils" async src="../assets/vendor/intlTelInput/js/utils.js?1638200991544"></script>
<script src="../assets/vendor/jquery-validation-1.19.5/jquery.validate.min.js"></script>
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
                nomor_hp: {
                    required: true
                },
                email: {
                    email: true
                },
                id_provinsi: "required",
                id_kota: "required",
                id_kecamatan: "required",
                id_kelurahan: "required",
                rt: {
                    required: true,
                    minlength: 3,
                    maxlength: 3
                },
                rw: {
                    required: true,
                    minlength: 3,
                    maxlength: 3
                },
                kodepos: {
                    required: true,
                    minlength: 5,
                    maxlength: 5
                },
                alamat: {
                    required: true,
                    minlength: 10,
                    maxlength: 100
                },
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
                id_provinsi: "Provinsi tidak boleh kosong.",
                id_kota: "Kota tidak boleh kosong.",
                id_kecamatan: "Kecamatan tidak boleh kosong.",
                id_kelurahan: "Kelurahan tidak boleh kosong.",
                alamat: "Alamat tidak boleh kosong.",
                rt: {
                    required: "RT tidak boleh kosong.",
                    minlength: "RT harus 3 karakter.",
                    maxlength: "RT harus 3 karakter."
                },
                rw: {
                    required: "RW tidak boleh kosong.",
                    minlength: "RW harus 3 karakter.",
                    maxlength: "RW harus 3 karakter."
                },
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
    });
</script>