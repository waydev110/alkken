<?php
    require_once '../../../helper/all_member.php';
    require_once '../../../model/classMember.php';
    require_once '../../../model/classMemberProspek.php';
    require_once '../../../model/classKodeAktivasi.php';
    require_once '../../../model/classSMS.php';

    $cm = new classMember();
    $cmp = new classMemberProspek();
    $cka = new classKodeAktivasi();
    $sms  = new classSMS();
    
    if($_maintenance == true){
        echo json_encode(['status' => false, 'message' => 'Mohon maaf. Sistem sedang Maintenace. Silahkan dicoba beberapa saat lagi.']);
        return false;
    }
    
    $sponsor = $session_member_id;
    
    if(!isset($_POST['id'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Data member tidak ditemukan.']);
        return false;
    }
    if(isset($_POST['id'])){
        $member_id = base64_decode($_POST['id']);
    } else {
        $member_id = $session_member_id;
    }
    
    # CEK PARAMETER POST
    if(!isset($_POST['id_kodeaktivasi'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Kode Aktivasi tidak ditemukan.']);
        return false;
    }
    $member = $cm->detail($member_id);
    $sponsor_id = $member->sponsor;
    $id_member = $member->id_member;
    $user_member = addslashes(strip_tags($member->user_member));
    $member_plan = $member->id_plan;
    $id_paket = $member->id_paket;
    $user_member = addslashes(strip_tags($member->user_member));

    $id_kodeaktivasi = addslashes(strip_tags($_POST['id_kodeaktivasi']));
    
    # CEK KODE AKTIVASI
    // Check if PIN already validated by admin controller
    if(isset($_POST['_admin_validated_pin'])){
        // Use pre-validated PIN from admin
        $pin = unserialize($_POST['_admin_validated_pin']);
        $pin_owner = isset($_POST['_pin_owner']) ? $_POST['_pin_owner'] : $sponsor;
    } else {
        // Normal validation for member area
        $pin = $cka->get_kodeaktivasi_ro($sponsor, $id_kodeaktivasi, 1);
        $pin_owner = $sponsor;
    }
    
    if(!$pin){
        echo json_encode(['status' => false, 'message' => 'Anda tidak memiliki '.$lang['pin_ro']]);
        return false;
    }
    $kode_aktivasi = $pin->kode_aktivasi;
    $id_produk_jenis = $pin->jenis_produk;
    $reposisi = $pin->reposisi;
    $founder = $pin->founder;
    $id_plan = $pin->jenis_aktivasi;
    $id_paket = 1;
    $id_peringkat = 0;
    $jenis_posting = 'posting_ro';
    $type_saldo_wd = 'posting_ro';
    $created_at = date('Y-m-d H:i:s');
    
    // Variables needed by create_bonus.php
    $upline = $member->upline;
    $posisi = $member->posisi;
    $nama_member = $member->nama_member;
    $nama_samaran = $member->nama_samaran;

    // Initialize connection for transaction
    $conn = new classConnection();

    try {
        // Start transaction
        $conn->beginTransaction();
        $current_operation = 'Validasi Data Posting RO';

        if ($member_id > 0) {
            require_once 'create_bonus.php';
        } else {
            throw new Exception('Posting RO gagal.');
        }

        // === TRANSACTION COMPLETE ===
        $current_operation = 'Commit Transaction';
        $conn->commit();
        
        // Success message
        $message = 'Posting RO berhasil untuk member ' . $id_member . ' - ' . $user_member;
    } catch (\Exception $e) {
        // Rollback transaction on error
        $conn->rollback();

        // Detailed error logging
        $error_details = [
            'status' => false,
            'message' => 'Posting RO gagal pada tahap: ' . $current_operation,
            'error' => $e->getMessage(),
            'member_id' => isset($member_id) ? $member_id : 'Belum dibuat',
            'timestamp' => date('Y-m-d H:i:s')
        ];

        // Log to file for debugging
        $log_message = "[" . date('Y-m-d H:i:s') . "] Posting RO Error\n";
        $log_message .= "Operation: " . $current_operation . "\n";
        $log_message .= "Member ID: " . (isset($member_id) ? $member_id : 'N/A') . "\n";
        $log_message .= "Sponsor: " . (isset($sponsor) ? $sponsor : 'N/A') . "\n";
        $log_message .= "Error: " . $e->getMessage() . "\n";
        $log_message .= "-----------------------------------\n";
        @file_put_contents(__DIR__ . '/../../log/posting_ro_errors.log', $log_message, FILE_APPEND);

        echo json_encode($error_details);
        return false;
    }
    echo json_encode(['status' => true, 'message' => $message]);
    return true;
