<?php
#---------------VALIDASI------------------------#
    # 1. CEK TOKEN EXPIRED = YES
    # 2. CEK PARAMETER POST = YES
    # 3. CEK DUPLIKAT AKTIVASI = YES
    # 4. CEK KODE AKTIVASI AKTIF = YES
#-----------------------------------------------#

#---------------AKSI------------------------#
    # 1. CREATE HISTORY REPEAT ORDER = YES
    # 2. UPDATE KODE AKTIVASI = YES
    # 3. UPDATE POTENSI RO = YES
    # 4. CREATE CASHBACK RO = YES
#-----------------------------------------------#


date_default_timezone_set("Asia/Jakarta");
require_once '../../../helper/all_member.php';    
if(!cek_token()){
    echo json_encode(['status' => false, 'message' => 'Token Expired.']);
    return false;
}
    require_once '../../../model/classMember.php';
    require_once '../../../model/classKodeAktivasi.php';
    require_once '../../../model/classHistoryRO.php';
    
    require_once '../../../model/classSMS.php';
	require_once '../../../model/classSetBonusGenerasi.php';
    
    $cm = new classMember();
    $cka = new classKodeAktivasi();
    $chro = new classHistoryRO();
    $csb  = new classSetBonusGenerasi();
    $sms  = new classSMS();
    
    $id_member = $session_member_id;
    # CEK PARAMETER POST
    if(!isset($_POST['kode_aktivasi'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Silahkan coba lagi.']);
        return false;
    }

    $kode_aktivasi = addslashes(strip_tags($_POST['kode_aktivasi']));
    

    # CEK KODE AKTIVASI
    $pin = $cka->get_kodeaktivasi($id_member, $kode_aktivasi, '1');
    if(!$pin){
        echo json_encode(['status' => false, 'message' => 'Anda tidak memiliki Kode Aktivasi Repeat Order.']);
        return false;
    }

    # CEK DUPLIKAT AKTIVASI
    $history = $chro->cek_duplikat($kode_aktivasi);
    if(!$history){
        echo json_encode(['status' => false, 'message' => 'Kode Aktivasi Duplikat.']);
        return false;
    }

    try {
        # CREATE HISTORY REPEAT ORDER
		$chro->set_id_member($id_member);
		$chro->set_kode_aktivasi($kode_aktivasi);

		$insert = $chro->create();

        if($insert > 0){
            # UPDATE KODE AKTIVASI
        	$cka->update_aktivasi($kode_aktivasi);

            # UPDATE REWARD RO
            $cm->update_jumlah_potensi_ro($id_member, 0, $pin->jumlah_hu);
            
            # CREATE BONUS CASHBACK
            $bonus_cashback_ro = $pin->bonus_cashback_ro;
            $cw->set_id_member($id_member);
            $cw->set_dari_member($id_member);
            $cw->set_poin($bonus_cashback_ro);
            $cw->set_type('bonus_cashback_ro');
            $cw->set_status('d');
            $cw->set_id_origin($insert);
            $cw->set_keterangan('Bonus Cashback RO');
            $cw->create();

            
            $generasi_poin_ro = $csb->get_setbonus();
            if($generasi_poin_ro){
                $cw->create_poin_generasi_ro($id_member, $insert, 0, $pin->harga_peringkat, $id_member, $generasi_poin_ro);
            }

            // $now = date('Y-m-d H:i:s', time());
            // $sms->smsBonusPoin($id_member, 'Poin Cashback RO', $bonus_cashback_ro, $now);
        } else {
            echo json_encode(['status' => false, 'message' => 'Repeat Order Gagal.']);
            return false;
        }
    } catch (\Exception $e) {
        echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        return false;
    }
    $message = '<p class="text-center text-muted mb-2 size-18">Repeat Order Berhasil</p>
                <p class="text-center text-muted mb-2 size-12">Selamat anda mendapatkan Saldo Autosave</p>
                <p class="text-theme size-32">'.currency($bonus_cashback_ro).'</p>';
    echo json_encode(['status' => true, 'message' => $message]);
    return true;
