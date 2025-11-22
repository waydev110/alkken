<?php
/**
 * Admin Member Registration Controller - WRAPPER ONLY
 * 
 * ┌─────────────────────────────────────────────────────────────────┐
 * │  CRITICAL: This file is a THIN WRAPPER that includes            │
 * │  memberarea/controller/member/member_create.php                 │
 * │                                                                  │
 * │  ⚠️  DO NOT add bonus/poin calculation logic here!              │
 * │  ⚠️  DO NOT duplicate registration logic!                       │
 * │                                                                  │
 * │  This file ONLY:                                                │
 * │  1. Maps admin form data to member_create.php format            │
 * │  2. Finds correct activation code ID from sponsor's PINs        │
 * │  3. Sets session context                                        │
 * │  4. Includes member_create.php                                  │
 * │                                                                  │
 * │  ALL registration logic (16+ steps) is in member_create.php     │
 * │  Changes there automatically apply to both admin & member       │
 * └─────────────────────────────────────────────────────────────────┘
 */

// Set context flag
define('ADMIN_REGISTRATION_CONTEXT', true);

// Load helper
require_once '../../../helper/all.php';
require_once '../../../model/classMember.php';
require_once '../../../model/classKodeAktivasi.php';

// ============================================================
// STEP 1: VALIDATION
// ============================================================
if(!isset($_POST['upline']) || !isset($_POST['sponsor']) || !isset($_POST['paket_join'])) {
    echo json_encode([
        'status' => false, 
        'message' => 'Data tidak lengkap. Mohon isi semua field yang diperlukan.'
    ]);
    exit;
}

$sponsor_id = number($_POST['sponsor']);
$id_plan_selected = number($_POST['paket_join']);

// ============================================================
// STEP 2: FIND ACTIVATION CODE FROM SPONSOR
// ============================================================
$cka = new classKodeAktivasi();
$kode_aktivasi_list = $cka->index_member_new($sponsor_id, 0);

$id_kodeaktivasi_found = null;
if($kode_aktivasi_list && $kode_aktivasi_list->num_rows > 0) {
    while($row = $kode_aktivasi_list->fetch_object()) {
        if($row->jenis_aktivasi == $id_plan_selected && $row->total > 0) {
            // Get first available PIN for this plan
            $pin_check = $cka->get_kodeaktivasi($sponsor_id, $row->id_kodeaktivasi, 0);
            if($pin_check) {
                $id_kodeaktivasi_found = $pin_check->id;
                break;
            }
        }
    }
}

if(!$id_kodeaktivasi_found) {
    echo json_encode([
        'status' => false, 
        'message' => 'Kode aktivasi tidak tersedia untuk paket yang dipilih. Sponsor tidak memiliki PIN untuk paket ini.'
    ]);
    exit;
}

// ============================================================
// STEP 3: SET SESSION CONTEXT
// member_create.php uses session_member_id as the sponsor
// ============================================================
$_SESSION['session_member_id'] = $sponsor_id;
$_SESSION['session_user_member'] = 'ADMIN_REGISTRATION';

// ============================================================
// STEP 4: MAP FORM DATA TO MEMBER_CREATE.PHP FORMAT
// ============================================================
$_POST['sponsor'] = $sponsor_id;
$_POST['id_upline'] = isset($_POST['upline']) ? base64_encode($_POST['upline']) : null;
$_POST['posisi'] = isset($_POST['posisi']) ? $_POST['posisi'] : null;
$_POST['id_kodeaktivasi'] = $id_kodeaktivasi_found;
$_POST['tipe_akun'] = '0'; // Always new member

// Member data - pass through as-is
$_POST['username'] = isset($_POST['username']) ? $_POST['username'] : null;
$_POST['nama_member'] = isset($_POST['nama_member']) ? $_POST['nama_member'] : null;
$_POST['hp_member'] = isset($_POST['hp_member']) ? $_POST['hp_member'] : null;
$_POST['email_member'] = isset($_POST['email_member']) ? $_POST['email_member'] : null;
$_POST['tanggal_lahir'] = isset($_POST['tanggal_lahir']) ? $_POST['tanggal_lahir'] : '01/01/1990';
$_POST['tempat_lahir'] = isset($_POST['tempat_lahir']) ? $_POST['tempat_lahir'] : '';
$_POST['no_rekening'] = isset($_POST['no_rekening']) ? $_POST['no_rekening'] : null;
$_POST['atas_nama_rekening'] = isset($_POST['atas_nama_rekening']) ? $_POST['atas_nama_rekening'] : null;
$_POST['id_bank'] = isset($_POST['id_bank']) ? $_POST['id_bank'] : null;
$_POST['cabang_rekening'] = '';

// Location data
$_POST['provinsi'] = isset($_POST['provinsi']) ? $_POST['provinsi'] : null;
$_POST['kota'] = isset($_POST['kota']) ? $_POST['kota'] : null;
$_POST['kecamatan'] = isset($_POST['kecamatan']) ? $_POST['kecamatan'] : null;
$_POST['kelurahan'] = isset($_POST['kelurahan']) ? $_POST['kelurahan'] : null;

// ============================================================
// STEP 5: INCLUDE MEMBER_CREATE.PHP
// This executes the FULL registration logic (16+ steps)
// ============================================================
// Log admin action
$log_message = "[" . date('Y-m-d H:i:s') . "] Admin Registration Initiated\n";
$log_message .= "Admin: " . (isset($_SESSION['user_login']) ? $_SESSION['user_login'] : 'Unknown') . "\n";
$log_message .= "Sponsor: " . $sponsor_id . "\n";
$log_message .= "Plan: " . $id_plan_selected . "\n";
$log_message .= "Activation Code ID: " . $id_kodeaktivasi_found . "\n";
$log_message .= "-----------------------------------\n";
@file_put_contents(__DIR__ . '/../log/admin_registration.log', $log_message, FILE_APPEND);

// Include the SINGLE SOURCE OF TRUTH for registration logic
// This will execute ALL 16+ steps: validation, member creation, bonus calculations,
// poin distribution, SMS notifications, etc.
require_once '../../../memberarea/controller/member/member_create.php';

// ============================================================
// NOTE: Everything after this line is handled by member_create.php
// - No need to duplicate transaction logic
// - No need to duplicate bonus calculations
// - No need to duplicate SMS notifications
// - member_create.php will return JSON response automatically
// ============================================================
?>
