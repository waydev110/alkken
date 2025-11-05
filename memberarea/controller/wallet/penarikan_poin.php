<?php
    require_once '../../../helper/all_member.php';   
    require_once '../../../model/classMember.php';
    require_once '../../../model/classBank.php';
	require_once '../../../model/classWallet.php';
	require_once '../../../model/classWithdraw.php';
    require_once '../../../model/classPlan.php';
    require_once '../../../model/classSMS.php';
    
    $cm = new classMember();
    $cb = new classBank();
    $cw  = new classWallet();
    $cwd  = new classWithdraw();
    $cpl = new classPlan();
    $sms  = new classSMS();

    # CEK PARAMETER POST
    if(!isset($_POST['jumlah'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Silahkan coba lagi.']);
        return false;
    }
    if(!isset($_POST['jenis_penarikan'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Silahkan coba lagi.']);
        return false;
    }
    $jumlah = number($_POST['jumlah']);
    $jenis_penarikan = $_POST['jenis_penarikan'];
    # CEK MINIMAL PENARIKAN
    $member = $cm->detail($session_member_id);
    $plan = $cpl->show($member->id_plan);
    $total_wd_today = $cwd->total_wd_today($session_member_id, 'poin', date('Y-m-d'));

    $minimal_penarikan = $plan->minimal_wd_poin;
    $maksimal_penarikan = $plan->maximal_wd_poin-$total_wd_today;
    // $admin = $plan->admin;
    $percent_admin = $plan->admin;
    $admin = $maksimal_penarikan * $percent_admin/100;
    
    if($jumlah < $minimal_penarikan ){
        echo json_encode(['status' => false, 'message' => 'Minimal penarikan : .'.currency($minimal_penarikan)]);
        return false;
    }

    if($jumlah > $maksimal_penarikan ){
        echo json_encode(['status' => false, 'message' => 'Maksimal penarikan : .'.currency($maksimal_penarikan)]);
        return false;
    }

    $saldo = $cw->saldo($session_member_id, 'poin');
    if($jumlah > $saldo ){
        echo json_encode(['status' => false, 'message' => 'Saldo tidak cukup. Maksimal penarikan : '.currency($saldo)]);
        return false;
    }

    try {
        $created_at = date('Y-m-d H:i:s');
        $status_transfer = '0';
        $now = date('Y-m-d H:i:s', time());
        $admin = floor($jumlah*$percent_admin/100);
        // $admin = 5000;
        $nominal = $jumlah - $admin;

        $keterangan = 'Penarikan Saldo Autosave, Admin '.rp($admin);    
        $cw->set_id_member($session_member_id);
        $cw->set_jenis_saldo('poin');
        $cw->set_nominal($jumlah);
        $cw->set_type('penarikan'); 
        $cw->set_keterangan($keterangan);
        $cw->set_status('k');
        $cw->set_status_transfer('0');
        $cw->set_dari_member($session_member_id);
        $cw->set_id_kodeaktivasi('0');
        $cw->set_dibaca('0');
        $cw->set_created_at($created_at);                 
        $create = $cw->create();

        if($create <= 0){
            echo json_encode(['status' => false, 'message' => 'Permintaan Penarikan Gagal.']);
            return false;
        }
        
        $cwd->set_id_member($session_member_id);
        $cwd->set_jenis_saldo('poin');  
        $cwd->set_jenis_penarikan($jenis_penarikan);
        $cwd->set_jumlah($jumlah);  
        $cwd->set_admin($admin);  
        $cwd->set_total($nominal);  
        $cwd->set_status_transfer('0');
        $cwd->set_id_wallet($create);
        $cwd->set_created_at($created_at);

        $create_penarikan = $cwd->create(); 
    } catch (\Exception $e) {
        echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        return false;
    }
    $jumlah = rp($nominal);
    $type = 'Saldo Wallet';
    $sms->smsPenarikanAdmin($session_member_id, $type, $jumlah);
    $message = '<p class="text-center mb-2 size-18 text-success fw-bold">Permintaan Penarikan Berhasil</p>
                <p class="text-center text-muted mb-2 size-12">Penarikan biasanya membutuhkan waktu 1-3 jam, tetapi terkadang bisa membutuhkan waktu hingga 3 hari kerja</p>';
    echo json_encode(['status' => true, 'message' => $message]);
    return true;
