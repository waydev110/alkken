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

    .main-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 1.5rem;
    }

    .form-card {
        background: linear-gradient(145deg, #1e1e1e, #252525);
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        padding: 2rem;
        margin-bottom: 1.5rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #333;
    }

    .form-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(212, 175, 55, 0.2);
    }

    .section-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #333;
    }

    .section-header i {
        font-size: 1.5rem;
        background: var(--gold-gradient);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-right: 0.75rem;
    }

    .section-header h6 {
        margin: 0;
        font-weight: 700;
        font-size: 1.1rem;
        background: var(--gold-gradient);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        color: #d4af37;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        height: 50px;
        border: 2px solid #333;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #eef1fa;
        color: #1a1a1a;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #d4af37;
        box-shadow: var(--input-focus);
        background: #faf6eeff;
        outline: none;
    }

    .form-group input::placeholder {
        color: #666;
    }

    .form-group input:read-only {
        background: #252525;
        color: #888;
        cursor: not-allowed;
    }

    .form-group label.error {
        color: #ef4444;
        font-size: 0.75rem;
        font-weight: 500;
        margin-top: 0.25rem;
        text-transform: none;
        letter-spacing: normal;
    }

    .select2-container--default .select2-selection--single {
        height: 50px;
        border: 2px solid #333;
        border-radius: 12px;
        background: #1a1a1a;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 46px;
        padding-left: 1rem;
        color: #fff;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #d4af37;
        box-shadow: var(--input-focus);
    }

    .select2-dropdown {
        background: #1a1a1a;
        border: 2px solid #333;
        border-radius: 12px;
    }

    .select2-container--default .select2-results__option {
        color: #fff;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background: #d4af37;
        color: #000;
    }

    .btn-submit {
        width: 100%;
        height: 56px;
        background: var(--gold-gradient);
        border: none;
        border-radius: 12px;
        color: #000;
        font-weight: 700;
        font-size: 1rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.6);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .alert-modern {
        border-radius: 12px;
        border: 1px solid #333;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        background: #1e1e1e;
        color: #fff;
    }

    .alert-modern i {
        font-size: 1.5rem;
        margin-right: 1rem;
    }

    .alert-danger {
        border-color: #ef4444;
    }

    .header {
        background: var(--primary-gradient) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .info-badge {
        display: inline-block;
        background: #252525;
        color: #d4af37;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        border: 1px solid #333;
    }

    .text-danger {
        color: #ef4444 !important;
    }

    .text-success {
        color: #10b981 !important;
    }

    @media (max-width: 768px) {
        .main-container {
            padding: 1rem;
        }

        .form-card {
            padding: 1.5rem;
        }

        .section-header h6 {
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .form-card {
            padding: 1rem;
            border-radius: 15px;
        }

        .form-group input,
        .form-group select {
            height: 45px;
            font-size: 0.9rem;
        }

        .btn-submit {
            height: 50px;
            font-size: 0.9rem;
        }
    }
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
        $('#tipe_akun').on("change", function(e) {
            if (e.target.value == '0') {
                $('#blockDataMemberProspek').slideUp();
                $('#blockDataMember, #blockDataBank').slideDown();
            } else if (e.target.value == '2') {
                $('#blockDataMember, #blockDataBank').slideUp();
                $('#blockDataMemberProspek').slideDown();
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
