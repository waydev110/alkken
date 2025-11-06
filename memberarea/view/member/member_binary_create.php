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
        // Initialize Select2 with custom styling
        $('.select2').select2({
            theme: 'default',
            width: '100%'
        });

        // Auto-fill account holder name
        $('#nama_member').on("keyup", function(e) {
            $('#atas_nama_rekening').val(e.target.value);
        });

        // Toggle forms based on account type
        $('#tipe_akun').on("change", function() {
            var tipeAkun = $(this).val();
            if (tipeAkun == '0') {
                $('#blockDataMember, #blockDataBank').show();
                $('#blockDataMemberProspek').hide();
            } else if (tipeAkun == '1') {
                $('#blockDataMemberProspek').hide();
                $('#blockDataMember, #blockDataBank').hide();
            } else if (tipeAkun == '2') {
                $('#blockDataMember, #blockDataBank').hide();
                $('#blockDataMemberProspek').show();
            }
        });

        // Form validation setup
        $('#formPendaftaran').validate({
            errorPlacement: function(error, element) {
                error.appendTo(element.parent());
            },
            highlight: function(element) {
                $(element).css('border-color', '#ef4444');
            },
            unhighlight: function(element) {
                $(element).css('border-color', '#333');
            }
        });

        // Submit button handler
        $('#btnSubmit').on("click", function(e) {
            if ($('#formPendaftaran').valid()) {
                $('#blockFirstForm').hide();
                $('#blockNextForm').show();
                $('input[name=old_pin1]').focus();
            }
            e.preventDefault();
        });
    });
</script>
<?php include 'view/layout/footer.php'; ?>
