<?php
$token = create_token();
require_once '../model/classMember.php';
require_once '../model/classMemberProspek.php';
require_once '../model/classKodeAktivasi.php';
require_once '../model/classProvinsi.php';
require_once '../model/classBank.php';

$cm = new classMember();
$cmp = new classMemberProspek();
$cka = new classKodeAktivasi();
$cprov = new classProvinsi();
$cb = new classBank();

$bank = $cb->semua_bank();
$provinsi = $cprov->index();
$member = $cm->detail($session_member_id);
$member_prospek = $cmp->index($session_member_id);
$kode_aktivasi = $cka->index_member_new($session_member_id, 0);

$idsponsor = $session_member_id;
$readonly  = "readonly";
if (isset($_GET['posisi'])) {
    $posisi = $_GET['posisi'];
} else {
    $posisi = 'kiri';
}
if (!isset($_GET['upline']) || empty($_GET['upline'])) {
?>
    <script type="text/javascript">
        window.location = "?go=genealogy";
    </script>
<?php
} else {
    $upline    = $cm->detail(base64_decode($_GET['upline']));
    if (!$upline) {
        redirect('404');
    }
    $upline_id = $upline->id;
    $id_upline = $upline->id_member;
    $nama_upline = $upline->nama_samaran;
}
?>
<?php include 'view/layout/header.php'; ?>
<link rel="stylesheet" href="assets/vendor/intlTelInput/css/intlTelInput.css">
<link rel="stylesheet" href="assets/vendor/select2/css/select2.min.css">
<style>
</style>

<?php include 'view/layout/loader.php'; ?>
<?php include 'view/layout/sidebar.php'; ?>

<main class="h-100 has-header">
    <header class="header position-fixed bg-theme">
        <div class="row">
            <?php include 'view/layout/back.php'; ?>
            <div class="col align-self-center text-left">
                <h5 class="text-white mb-0"><?= $title ?></h5>
            </div>
        </div>
    </header>

    <div class="main-container container pt-4" id="blockFirstForm">
        <form action="controller/member/member_create.php" id="formPendaftaran" method="post">
            <?php if ($kode_aktivasi->num_rows == 0) { ?>
                <div class="alert alert-danger alert-modern">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>Anda tidak memiliki <?= $lang['kode_aktivasi'] ?>.</span>
                </div>
            <?php } else { ?>
                <input type="hidden" name="token" value="<?= $token ?>">

                <!-- Network Data Card -->
                <div class="form-card">
                    <div class="section-header">
                        <i class="bi bi-diagram-3"></i>
                        <h6>Data Jaringan</h6>
                    </div>

                    <?php
                    $readonly = '';
                    if ($_sponsor_static == true) {
                        $readonly = ' readonly="readonly"';
                    } else { ?>
                        <input type="hidden" id="sponsor" name="sponsor" value="<?= $session_member_id ?>">
                    <?php } ?>

                    <div class="form-group">
                        <label>ID <?= $lang['sponsor'] ?></label>
                        <input type="text" class="form-control" id="id_sponsor" name="id_sponsor" 
                               value="<?= $session_id_member ?>" <?= $readonly ?>>
                    </div>

                    <div class="form-group">
                        <label>Nama <?= $lang['sponsor'] ?></label>
                        <input type="text" id="nama_samaran_sponsor" class="form-control" 
                               value="<?= $session_nama_samaran ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>ID Upline</label>
                        <input type="hidden" name="posisi" id="posisi" value="<?= $posisi ?>">
                        <input type="text" class="form-control" name="cek_upline" id="cek_upline" 
                               value="<?= $id_upline ?>" readonly>
                        <input type="hidden" name="id_upline" id="id_upline" value="<?= base64_encode($upline_id) ?>">
                    </div>

                    <div class="form-group">
                        <label>Nama Upline</label>
                        <input type="text" class="form-control" name="nama_upline" id="nama_upline" 
                               value="<?= $nama_upline ?>" readonly>
                    </div>
                </div>

                <!-- Registration Package Card -->
                <div class="form-card">
                    <div class="section-header">
                        <i class="bi bi-box-seam"></i>
                        <h6>Paket Pendaftaran</h6>
                    </div>

                    <div class="form-group">
                        <label>Paket Join</label>
                        <select class="form-control" id="id_kodeaktivasi" name="id_kodeaktivasi">
                            <option value="">-- Pilih Paket Join --</option>
                            <?php
                            while ($row = $kode_aktivasi->fetch_object()) {
                                echo "<option value='" . $row->id . "'>" . $row->nama_plan . ' - ' . $row->name . ' ' . $row->reposisi . ' ' . $row->founder . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tipe Pendaftaran</label>
                        <select class="form-control" id="tipe_akun" name="tipe_akun">
                            <option value="0"><?= $lang['member'] ?> Baru</option>
                            <option value="1">Tambah Titik</option>
                            <option value="2">Member Prospek</option>
                        </select>
                    </div>
                </div>

                <!-- Member Data Card -->
                <div class="form-card" id="blockDataMember">
                    <div class="section-header">
                        <i class="bi bi-person-badge"></i>
                        <h6>Data <?= $lang['member'] ?></h6>
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>

                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_member" name="nama_member">
                    </div>
                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?=$member->tempat_lahir_member?>">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <div class="input-group">
                            <input type="text" class="form-control datepicker" id="tanggal_lahir" name="tanggal_lahir" autocomplete="off" value="<?=$member->tgl_lahir_member <> '0000-00-00' && $member->tgl_lahir_member <> null && $member->tgl_lahir_member <> '' ? date('d/m/Y', strtotime($member->tgl_lahir_member)) : ''?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>No Whatsapp</label>
                        <input type="text" class="form-control" id="wa_member" name="wa_member">
                        <p class="text-danger size-12 mt-1" id="error-hp"></p>
                        <p class="text-success size-12 mt-1" id="valid-hp"></p>
                    </div>
                </div>

                <!-- Bank Account Card -->
                <div class="form-card" id="blockDataBank">
                    <div class="section-header">
                        <i class="bi bi-bank"></i>
                        <h6>Data Rekening Bank</h6>
                    </div>

                    <div class="form-group">
                        <label>Bank</label>
                        <select class="select2 form-control" id="id_bank" name="id_bank">
                            <option value="">Pilih Bank</option>
                            <?php while ($row = $bank->fetch_object()) { ?>
                                <option value="<?= $row->id ?>"><?= $row->nama_bank ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>No Rekening</label>
                        <input type="text" class="form-control" id="no_rekening" name="no_rekening">
                    </div>

                    <div class="form-group">
                        <label>Nama Pemilik Rekening</label>
                        <input type="text" class="form-control" id="atas_nama_rekening" 
                               name="atas_nama_rekening" readonly>
                    </div>

                    <div class="form-group">
                        <label>Cabang</label>
                        <input type="text" class="form-control" id="cabang_rekening" name="cabang_rekening">
                    </div>
                </div>

                <!-- Member Prospek Card -->
                <div class="form-card" id="blockDataMemberProspek" style="display:none">
                    <div class="section-header">
                        <i class="bi bi-person-check"></i>
                        <h6>Data <?= $lang['member'] ?> Prospek</h6>
                    </div>

                    <div class="form-group">
                        <label>Pilih Member Prospek</label>
                        <select class="form-control select2" id="member_prospek" name="member_prospek">
                            <?php
                            while ($row = $member_prospek->fetch_object()) {
                                echo "<option value='" . $row->id . "'>" . $row->nama_member . " | " . $row->user_member . " | " . $row->hp_member . " | " . $row->nama_produk . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row">
                    <div class="col-12">
                        <button type="button" class="btn-submit" id="btnSubmit">
                            <i class="bi bi-check-circle me-2"></i>DAFTARKAN
                        </button>
                    </div>
                </div>
            <?php } ?>
        </form>
    </div>

    <?php include 'view/auth/form_cek_pin.php'; ?>
</main>

<?php include 'view/layout/assets_js.php'; ?>
<script src="assets/vendor/select2/js/select2.min.js"></script>
<script src="assets/vendor/intlTelInput/js/intlTelInput.js"></script>
<script src="assets/vendor/intlTelInput/js/isValidNumber.js"></script>
<script src="assets/vendor/intlTelInput/js/utils.js"></script>
<script src="assets/vendor/jquery-validation-1.19.5/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        var blockFirstForm = $('#blockFirstForm');
        var blockNextForm = $('#blockNextForm');
        var blockDataMember = $('#blockDataMember');
        var blockDataMemberProspek = $('#blockDataMemberProspek');
        var blockCloningID = $('#blockCloningID');
        var formCekPIN = $('#formCekPIN');
        var formPendaftaran = $('#formPendaftaran');
        var btnSubmit = $('#btnSubmit');
        var tipeAkun = $('#tipe_akun');

        $('#id_sponsor').on("change", function(e) {
            var sponsor = $('#id_sponsor').val();
            var upline = $('#id_upline').val();
            $.ajax({
                type: 'post',
                url: 'controller/member/get_sponsor.php',
                data: {
                    sponsor: sponsor,
                    upline: upline
                },
                beforeSend: function() {
                    loader_open();
                },
                success: function(result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        $('#sponsor').val(obj.sponsor_id);
                        $('#id_sponsor').val(obj.id_sponsor);
                        $('#nama_samaran_sponsor').val(obj.nama_samaran_sponsor);
                    } else {
                        $('#nama_samaran_sponsor').val('Tidak ditemukan');
                    }
                },
                complete: function() {
                    loader_close();
                }
            });
        });

        $('#member_prospek').on("change", function(e) {
            var sponsor = $('#member_prospek').val();
            var upline = $('#id_upline').val();
            $.ajax({
                type: 'post',
                url: 'controller/member/get_sponsor_member_prospek.php',
                data: {
                    sponsor: sponsor,
                    upline: upline
                },
                beforeSend: function() {
                    loader_open();
                },
                success: function(result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        $('#sponsor').val(obj.sponsor_id);
                        $('#id_sponsor').val(obj.id_sponsor);
                        $('#nama_samaran_sponsor').val(obj.nama_samaran_sponsor);
                    } else {
                        $('#nama_samaran_sponsor').val('Tidak ditemukan');
                    }
                },
                complete: function() {
                    loader_close();
                }
            });
        });

        $('#cloning_id').on("change", function(e) {
            var id_member = $(this).val();
            $.ajax({
                type: 'post',
                url: 'controller/member/get_cloning_sponsor.php',
                data: {
                    id_member: id_member
                },
                beforeSend: function() {
                    loader_open();
                },
                success: function(result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        $('#sponsor').val(obj.sponsor_id);
                        $('#id_sponsor').val(obj.id_sponsor).attr('disabled', 'disabled');
                        $('#nama_samaran_sponsor').val(obj.nama_samaran_sponsor);
                    } else {
                        $('#nama_samaran_sponsor').val('Tidak ditemukan');
                    }
                },
                complete: function() {
                    loader_close();
                }
            });
        });


        $('#nama_member').on("keyup", function(e) {
            $('#atas_nama_rekening').val(e.target.value);
        });
        $('.select2').select2();
        tipeAkun.on("change", function(e) {
            if (e.target.value == '0') {
                blockCloningID.hide();
                blockDataMemberProspek.hide();
                blockDataMember.show();
                $('#id_sponsor').removeAttr('disabled');
            } else if (e.target.value == '1') {
                blockCloningID.show();
                blockDataMemberProspek.hide();
                blockDataMember.hide();
                // $.ajax({
                //     type: 'post',
                //     url: 'controller/member/get_data_cloning.php',
                //     beforeSend: function() {
                //         loader_open();
                //     },
                //     success: function(result) {
                //         const obj = JSON.parse(result);
                //         if (obj.status == true) {
                //             $('#cloning_id').html(obj.option);
                //             $(".cloning_id").select2();
                //         }
                //     },
                //     complete: function() {
                //         loader_close();
                //     }
                // });
            } else {
                blockCloningID.hide();
                blockDataMember.hide();
                blockDataMemberProspek.show();
                $('#id_sponsor').removeAttr('disabled');
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
                    required: true,
                    // verifyWA: true
                },
                email_member: {
                    required: true,
                    email: true,
                    // verifyEmail: true
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
                id_bank: {
                    required: true
                },
                no_rekening: {
                    required: true,
                    minlength: 10,
                    maxlength: 16
                },
                username: {
                    required: true,
                    minlength: 4,
                    verifyUsername: true,
                    validUsernameFormat: true
                },
                atas_nama_rekening: "required",
                cabang_rekening: "required"
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
                email: {
                    required: "Email tidak boleh kosong.",
                    email: "Format email tidak valid.",
                },
                user_member: {
                    required: "Username tidak boleh kosong",
                    minlength: "Username minimal {0} karakter",
                    validUsernameFormat: "Format username tidak valid"
                },
                kota: "Kota tidak boleh kosong.",
                alamat: "Alamat tidak boleh kosong.",
                id_bank: "Bank tidak boleh kosong.",
                no_rekening: {
                    required: "Nomor rekening tidak boleh kosong.",
                    minlength: "Nomor rekening minimal 10 digit.",
                    maxlength: "Nomor rekening maksimal 16 digit."
                },
                atas_nama_rekening: "Atas nama rekening tidak boleh kosong.",
                cabang_rekening: "Cabang/Unit rekening tidak boleh kosong.",
            }
        });
        $.validator.addMethod("validUsernameFormat", function(value, element) {
            return /^[a-zA-Z0-9_]+$/.test(value);
        }, "Format username hanya menggunakan alphanumeric dan '_'");

        $.validator.addMethod("verifyUsername", function(value) {
            var response = 'false';
            $.ajax({
                type: 'post',
                url: 'controller/auth/cek_username.php',
                data: {
                    username: value
                },
                async: false,
                success: function(result) {
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

        btnSubmit.on("click", function(e) {
            if (formPendaftaran.valid()) {
                blockFirstForm.hide();
                blockNextForm.show();
                $('input[name=old_pin1]').focus();
            }
            e.preventDefault();
        });

        formCekPIN.on("submit", function(e) {
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                success: function(result) {
                    if (result == true) {
                        formPendaftaran.submit();
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

        formPendaftaran.on("submit", function(e) {

            $('input[name=hp_member').val(iti.getNumber());
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                beforeSend: function() {
                    loader_open();
                },
                success: function(result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        var redirect_url = 'genealogy_v1';
                        show_success_html_message(obj.message, redirect_url);
                    } else {
                        var redirect_url = 'genealogy_v1';
                        show_error(obj.message, redirect_url);
                    }
                },
                complete: function() {
                    loader_close();
                }
            });
            e.preventDefault();
        });

        $.validator.addMethod("verifyWA", function(value) {
            var response = 'false';
            $.ajax({
                type: 'post',
                url: 'controller/profil/cek_wa.php',
                data: {
                    wa: value
                },
                async: false,
                success: function(result) {
                    response = result;
                },
            });
            if (response == 'true') {
                console.log(response);
                return true;
            } else {
                console.log(response);
                return false;
            }
        }, 'Nomor Whatsapp sudah digunakan.');

        $.validator.addMethod("verifyEmail", function(value) {
            var response = 'false';
            $.ajax({
                type: 'post',
                url: 'controller/profil/cek_email.php',
                data: {
                    email: value
                },
                async: false,
                success: function(result) {
                    response = result;
                },
            });
            if (response == 'true') {
                console.log(response);
                return true;
            } else {
                console.log(response);
                return false;
            }
        }, 'Email sudah digunakan.');
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
