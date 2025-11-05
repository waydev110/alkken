<?php 
    require_once '../../../helper/string.php';
    require_once '../../../helper/date.php';
    require_once '../../../model/classBonusUnilevel.php';
    require_once '../../../model/classWallet.php';
    require_once '../../../model/classMember.php';
    $obj = new classBonusUnilevel();
    $cw = new classWallet();
    $cm = new classMember();

    $bulan = date('Y-m', strtotime('-1 month'));
    // $bulan = date('Y-m');
    $log_file = '../../../log/bonus_unilevel/log-'.$bulan.'.txt';
    $log = '';

    $member_saldo_autosave = $cw->member_saldo_autosave($bulan);

    $log .= "Bulan. :".$bulan."\n";
    $log .= "Jumlah member Autosave :".$member_saldo_autosave->num_rows."\n";
    file_put_contents($log_file, $log, FILE_APPEND);

    $no = 1;
    while($row = $member_saldo_autosave->fetch_object()){
        $log = '';
        $member_id = $row->id_member;
        $saldo = $row->saldo;
        $member = $cm->detail($member_id);
        if($member){
            $max_autosave = $member->max_autosave;
            $id_member = $member->id_member;
            $user_member = addslashes(strip_tags($member->user_member));
            // $keterangan = 'Bonus Unilevel dari ( ID: '.$id_member.' / '.$user_member.' )';
            $max = 10;
            $created_at = date('Y-m-d H:i:s');
    
            // Menulis log ke buffer
            $log .= "No. :".$no++."\n";
            $log .= "Member ID :".$member_id."\n";
            $log .= "ID Member :".$id_member."\n";
            $log .= "User Member :".$user_member."\n";
            $log .= "Saldo Autosave :".rp($saldo)."\n";
            $log .= "Max Autosave :".rp($max_autosave)."\n";
    
            $nominal = floor(($saldo/$max_autosave)*10000); 
            $log .= "Nominal Bonus :".rp($nominal)."\n";
            file_put_contents($log_file, $log, FILE_APPEND);
    
            $create_bonus = $obj->create($member_id, $nominal, $bulan, $max, $max_autosave, $created_at);	
            if($create_bonus){
                // $cw->update_status($member_id, $bulan);
            }
        }
    }
    // Menulis pesan akhir ke log dan output JSON
    $create_rekap = $obj->update_status_transfer($bulan);	
    $log .= "Rekap Selesai\n";
    file_put_contents($log_file, $log, FILE_APPEND);
?>