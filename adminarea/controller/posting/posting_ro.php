<?php
/**
 * Admin Posting RO Controller - WRAPPER ONLY
 * 
 * ┌─────────────────────────────────────────────────────────────────┐
 * │  This file is a THIN WRAPPER that includes                      │
 * │  memberarea/controller/posting/posting_ro.php                   │
 * │                                                                  │
 * │  ⚠️  DO NOT add bonus/poin calculation logic here!              │
 * │                                                                  │
 * │  This file ONLY:                                                │
 * │  1. Maps admin form data to posting_ro.php format               │
 * │  2. Validates member and PIN ownership                          │
 * │  3. Sets session context                                        │
 * │  4. Includes posting_ro.php                                     │
 * └─────────────────────────────────────────────────────────────────┘
 */

// Set context flag
define('ADMIN_POSTING_RO_CONTEXT', true);

// Load helper
require_once '../../../helper/all.php';
require_once '../../../model/classMember.php';
require_once '../../../model/classKodeAktivasi.php';

// ============================================================
// STEP 1: VALIDATION
// ============================================================
if(!isset($_POST['member_id']) || !isset($_POST['id_kodeaktivasi']) || !isset($_POST['pin_owner'])) {
    echo json_encode([
        'status' => false, 
        'message' => 'Data tidak lengkap. Mohon isi semua field yang diperlukan.'
    ]);
    exit;
}

$member_id = number($_POST['member_id']);
$id_kodeaktivasi = number($_POST['id_kodeaktivasi']);
$pin_owner = $_POST['pin_owner']; // 'member' or 'sponsor'

// ============================================================
// STEP 2: VERIFY MEMBER
// ============================================================
$cm = new classMember();
$member = $cm->detail($member_id);

if(!$member) {
    echo json_encode([
        'status' => false,
        'message' => 'Member tidak ditemukan.'
    ]);
    exit;
}

// ============================================================
// STEP 3: DETERMINE PIN OWNER
// ============================================================
if($pin_owner === 'member') {
    $sponsor = $member_id;
} elseif($pin_owner === 'sponsor') {
    $sponsor = $member->sponsor;
} else {
    echo json_encode([
        'status' => false,
        'message' => 'Pemilik PIN tidak valid.'
    ]);
    exit;
}

// ============================================================
// STEP 4: VERIFY PIN OWNERSHIP
// ============================================================
$cka = new classKodeAktivasi();
$pin = $cka->get_kodeaktivasi_ro($sponsor, $id_kodeaktivasi, 1);

if(!$pin) {
    $owner_name = $pin_owner === 'member' ? 'Member' : 'Sponsor';
    echo json_encode([
        'status' => false,
        'message' => $owner_name . ' tidak memiliki PIN RO dengan ID tersebut.'
    ]);
    exit;
}

// ============================================================
// STEP 5: SET SESSION CONTEXT FOR POSTING_RO.PHP
// ============================================================
// Simulate member session for posting_ro.php
$_SESSION['session_member_id'] = $sponsor;
$session_member_id = $sponsor;

// Prepare POST data for posting_ro.php
$_POST['id'] = base64_encode($member_id);
$_POST['id_kodeaktivasi'] = $id_kodeaktivasi;

// Pass pre-validated PIN data to skip re-validation
$_POST['_admin_validated_pin'] = serialize($pin);
$_POST['_pin_owner'] = $sponsor;

// ============================================================
// STEP 6: INCLUDE MEMBERAREA POSTING_RO.PHP
// ============================================================
// All bonus calculation logic is handled there
require_once '../../../memberarea/controller/posting/posting_ro.php';
