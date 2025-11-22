<?php
    require_once '../../../helper/all_member.php';
    require_once '../../../model/classMember.php';
    require_once '../../../model/classMemberProspek.php';
    require_once '../../../model/classKodeAktivasi.php';
    require_once '../../../model/classPlan.php';
    require_once '../../../model/classSMS.php';

    $cm = new classMember();
    $cmp = new classMemberProspek();
    $cka = new classKodeAktivasi();
    $cpl = new classPlan();
    $sms  = new classSMS();
    
    if($_maintenance == true){
        echo json_encode(['status' => false, 'message' => 'Mohon maaf. Sistem sedang Maintenace. Silahkan dicoba beberapa saat lagi.']);
        return false;
    }

    $member = $cm->detail($session_member_id);
    if(!$member){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $member_id = $session_member_id;
    $id_member = $member->id_member;
    $sponsor_id = $member->sponsor;
    $nama_samaran = $member->nama_samaran;
    $user_member = $member->user_member;
    $current_plan = $member->id_plan;
    $current_tingkat = $member->tingkat;
    
    $id_plan = addslashes(strip_tags($_POST['id_upgrade']));
    $plan = $cpl->show($id_plan);
    if(!$plan){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $nama_plan = $plan->nama_plan;
    if(!isset($_POST['id_kodeaktivasi'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. PIN tidak ditemukan']);
        return false;
    }
    $id_kodeaktivasi = number($_POST['id_kodeaktivasi']);
    $pin = $cka->get_kodeaktivasi($member_id, $id_kodeaktivasi, 0);
    if(!$pin){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. PIN tidak ditemukan.']);
        return false;
    }
    $kode_aktivasi = $pin->kode_aktivasi;
    $id_produk_jenis = $pin->jenis_produk;
    $reposisi = $pin->reposisi;
    $founder = $pin->founder;
    $id_plan = $pin->jenis_aktivasi;
    $id_paket = 1;
    $id_peringkat = 0;
    $jenis_posting = 'upgrade_paket';
    $type_saldo_wd = 'upgrade_paket';
    $created_at = date('Y-m-d H:i:s');
    
    // Initialize SMS queue
    $sms_queue = [];

    // Initialize connection for transaction
    $conn = new classConnection();

    try {
        // Start transaction
        $conn->beginTransaction();
        $current_operation = 'Upgrade Member Plan';
        
        // Update member plan
        $cm->upgrade_plan($session_member_id, $id_plan, $current_plan, $id_kodeaktivasi, $reposisi, $created_at);
        
        // Update member kaki count
        $current_operation = 'Update Member Kaki Count';
        $cm->upgrade_jumlah_kaki($session_member_id, $current_plan, $id_plan);
        
        // Update member product type
        $current_operation = 'Update Member Product Type';
        $cm->upgrade_produk_jenis($session_member_id, $id_produk_jenis);

        // Calculate bonuses (akan populate $sms_queue)
        $current_operation = 'Calculate Bonuses';
        if ($member_id > 0) {
            require_once 'create_bonus.php';
        } else {
            throw new Exception('Upgrade Paket gagal.');
        }

        // === TRANSACTION COMPLETE ===
        $current_operation = 'Commit Transaction';
        $conn->commit();
        
        // === SEND SMS/WA AFTER SUCCESSFUL COMMIT ===
        // Kirim SMS bonus dari queue (dari create_bonus.php)
        if(isset($sms_queue) && is_array($sms_queue)) {
            foreach($sms_queue as $notification) {
                if($notification['type'] == 'bonus') {
                    $sms->smsBonusNew(
                        $notification['member_id'], 
                        $notification['nominal'], 
                        $notification['keterangan'], 
                        $notification['created_at']
                    );
                }
            }
        }
        
        // Success message
        $message = '<p class="text-center text-muted mb-2 size-18">Upgrade '.$nama_plan.' Berhasil.</p>';
        echo json_encode(['status' => true, 'message' => $message]);
        return true;
        
    } catch (\Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        
        $error_message = "Gagal upgrade paket pada tahap: {$current_operation}. ";
        $error_message .= "Error: " . $e->getMessage();

        // Detailed error logging
        $error_details = [
            'status' => false,
            'message' => 'Upgrade paket gagal pada tahap: ' . $current_operation,
            'error' => $e->getMessage(),
            'member_id' => isset($member_id) ? $member_id : 'Belum dibuat',
            'timestamp' => date('Y-m-d H:i:s')
        ];

        // Log to file for debugging
        $log_message = "[" . date('Y-m-d H:i:s') . "] Upgrade Paket Error\n";
        $log_message .= "Operation: " . $current_operation . "\n";
        $log_message .= "Member ID: " . (isset($member_id) ? $member_id : 'N/A') . "\n";
        $log_message .= "Error: " . $e->getMessage() . "\n";
        $log_message .= "-----------------------------------\n";
        @file_put_contents(__DIR__ . '/../../log/upgrade_member_errors.log', $log_message, FILE_APPEND);

        echo json_encode($error_details);
        return false;
    }
