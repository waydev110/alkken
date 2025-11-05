<?php 
    require_once '../../../model/classMember.php';
    require_once '../../../model/classMemberAutosave.php';
    require_once '../../../model/classMemberAutosaveDetail.php';
    require_once '../../../model/classKodeAktivasi.php';
    require_once '../../../model/classSMS.php';	
    require_once '../../../model/classBonusSponsor.php';
    require_once '../../../model/classBonusGenerasi.php';
    require_once '../../../model/classWallet.php';

    $cm = new classMember();
    $obj = new classMemberAutosave();
    $cmod = new classMemberAutosaveDetail();
    $cka = new classKodeAktivasi();
    $csms= new classSMS();	
    $cks= new classBonusSponsor();
    $ckg= new classBonusGenerasi();
    $cw= new classWallet();

    $id_order = addslashes(strip_tags($_POST['id']));
    $order = $obj->show($id_order);
    if(!$order){
        echo json_encode(['status' => false, 'message' => 'Transaksi gagal.']);
        return false;
    }

    $created_at = date('Y-m-d H:i:s');
    $obj->set_status('1');
    $obj->set_updated_at($created_at);
    $obj->set_tgl_proses($created_at);
    $update = $obj->update_status($id_order);
    if($update){ 
        $nominal = number($order->nominal);
        $saldo_poin = number($order->saldo_poin);
        $id_member = $order->id_member;
    
        if($nominal > 0){
            $keterangan = 'Tutup Poin Autosave ID :  '.$id_order;
            $cek_tupo = $cw->cek_tupo($id_order, $id_member);
            if($cek_tupo == 0){
                $cw->set_id_member($id_member);
                $cw->set_jenis_saldo('poin');
                $cw->set_nominal($nominal);
                $cw->set_type('tupo_automaintain');
                $cw->set_keterangan($keterangan);
                $cw->set_status('d');
                $cw->set_status_transfer('0');
                $cw->set_dari_member($id_member);
                $cw->set_id_kodeaktivasi($id_order);
                $cw->set_dibaca('0');
                $cw->set_created_at($created_at);                 
                $id_wallet = $cw->create();
    
                $keterangan = ' poin dan Cash sebesar '.currency($nominal);
                $id = $order->id_wallet;
                $cw->update_nominal($id, $nominal, $keterangan, $created_at);
            }
            

        }
        echo json_encode(['status' => true, 'message' => 'Transaksi berhasil.']);
        return false;
    }else{
        echo json_encode(['status' => false, 'message' => 'Transaksi gagal.']);
        return false;
    }
?>