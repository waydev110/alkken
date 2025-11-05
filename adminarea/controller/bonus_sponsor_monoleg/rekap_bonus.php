<?php 
    require_once '../../../helper/all.php';
    require_once '../../../model/classBonusSponsorMonoleg.php';
    require_once '../../../model/classPlan.php';
    require_once '../../../model/classWallet.php';
    $obj = new classBonusSponsorMonoleg();
    $cpl = new classPlan();
    $cw = new classWallet();

    $created_at = date('Y-m-d H:i:s');
    $rekap_bonus = $obj->rekap_bonus($created_at);
    while($row = $rekap_bonus->fetch_object()){
        $id_member = $row->id_member;
        $nominal = $row->nominal;
        $id_plan = $row->id_plan;
        $plan = $cpl->show($id_plan);
        if($plan){
            $persentase_cash = $plan->persentase_cash;
            $persentase_poin = $plan->persentase_poin;
            $persentase_admin = $plan->admin;
        } else {
            $persentase_cash = 90;
            $persentase_admin = 10;
            $persentase_poin = 0;
        }
        $nominal_cash = floor($nominal * $persentase_cash/100);
        if($nominal_cash > 0){      
            $keterangan = 'Cash '.percent($persentase_cash).' dari Bonus Sponsor';      
            $cw->set_id_member($id_member);
            $cw->set_jenis_saldo('cash');
            $cw->set_nominal($nominal_cash);
            $cw->set_type('bonus_sponsor');
            $cw->set_keterangan($keterangan);
            $cw->set_status('d');
            $cw->set_status_transfer('0');
            $cw->set_dari_member($id_member);
            $cw->set_id_kodeaktivasi('0');
            $cw->set_dibaca('0');
            $cw->set_created_at($created_at);                 
            $create = $cw->create();
        }
        $nominal_admin = floor($nominal * $persentase_admin/100);
        if($nominal_admin > 0){      
            $keterangan = 'Admin '.percent($persentase_admin).' dari Bonus Sponsor';      
            $cw->set_id_member($id_member);
            $cw->set_jenis_saldo('admin');
            $cw->set_nominal($nominal_admin);
            $cw->set_type('bonus_sponsor');
            $cw->set_keterangan($keterangan);
            $cw->set_status('d');
            $cw->set_status_transfer('0');
            $cw->set_dari_member($id_member);
            $cw->set_id_kodeaktivasi('0');
            $cw->set_dibaca('0');
            $cw->set_created_at($created_at);                 
            $create = $cw->create();
        }
        $nominal_poin = floor($nominal * $persentase_poin/100);
        if($nominal_poin > 0){            
            $keterangan = 'Autosave '.percent($persentase_poin).' dari Bonus Sponsor';    
            $cw->set_id_member($id_member);
            $cw->set_jenis_saldo('poin');
            $cw->set_nominal($nominal_poin);
            $cw->set_type('bonus_sponsor');
            $cw->set_keterangan($keterangan);
            $cw->set_status('d');
            $cw->set_status_transfer('0');
            $cw->set_dari_member($id_member);
            $cw->set_id_kodeaktivasi('0');
            $cw->set_dibaca('0');
            $cw->set_created_at($created_at);                 
            $create = $cw->create();
        }
    }
    $obj->update_rekap($created_at);
    echo json_encode(['status' => true, 
                        'message' => 'Rekap Selesai.']);
    return true;
?>