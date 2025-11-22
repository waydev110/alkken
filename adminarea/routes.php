<?php 

if(isset($_GET['go'])){
	$halaman = $_GET['go'];
}else{
	$halaman = "home";
}

switch ($halaman) {
	case 'home':
		$view = "view/dashboard/home.php";
		$title= "Home";
		break;

    case 'menu_member':
        $mod_url= "menu_member";
        $view = "view/menu_member/list.php";
        $title= "Menu Member";
        break;
    case 'menu_member_create':
        $mod_url= "menu_member";
        $view = "view/menu_member/create.php";
        $title= "Menu Member";
        break;
    case 'menu_member_edit':
        $mod_url= "menu_member";
        $view = "view/menu_member/edit.php";
        $title= "Menu Member";
        break;
    #-----------------------------------------------------------------------------#
    #BERITA
    #-----------------------------------------------------------------------------#
    case 'berita_list':
        $view = "view/berita/berita_list.php";
        $title= "Home";
        break;
    case 'berita_create':
        $view = "view/berita/berita_create.php";
        $title= "Home";
        break;
    case 'berita_edit':
        $view = "view/berita/berita_edit.php";
        $title= "Home";
        break;
    case 'berita_detail':
        $view = "view/berita/berita_detail.php";
        $title= "Home";
        break;

    case 'pengumuman_list':
        $view = "view/pengumuman/pengumuman_list.php";
        $title= "Home";
        break;
    case 'pengumuman_create':
        $view = "view/pengumuman/pengumuman_create.php";
        $title= "Home";
        break;
    case 'pengumuman_edit':
        $view = "view/pengumuman/pengumuman_edit.php";
        $title= "Home";
        break;

    case 'testimoni':
        $view = "view/testimoni/testimoni_list.php";
        $title= "Testimoni";
        break;
    #-----------------------------------------------------------------------------#
    #SLIDE
    #-----------------------------------------------------------------------------#
    case 'slide':
        $view = "view/slide/slide.php";
        $title= "Home";
        break;
    case 'slide_create':
        $view = "view/slide/slide_create.php";
        $title= "Home";
        break;
    case 'slide_edit':
        $view = "view/slide/slide_edit.php";
        $title= "Home";
        break;
    #-----------------------------------------------------------------------------#
    #SLIDE
    #-----------------------------------------------------------------------------#
    case 'slide_certificate':
        $view = "view/slide_certificate/list.php";
        $title= "Home";
        break;
    case 'slide_certificate_create':
        $view = "view/slide_certificate/create.php";
        $title= "Home";
        break;
    case 'slide_certificate_edit':
        $view = "view/slide_certificate/edit.php";
        $title= "Home";
        break;
        
	case 'produk':
		$view = "view/produk/list.php";
		$mod_url= "produk";
		$title= "Daftar Produk";
		break;
    case 'produk_create':
        $view = "view/produk/create.php";
		$mod_url= "produk";
        $title= "Tambah Produk";
        break;
    case 'produk_edit':
        $view = "view/produk/edit.php";
		$mod_url= "produk";
        $title= "Edit Produk";
        break;
        
	case 'produk_reseller':
		$view = "view/produk_reseller/list.php";
		$mod_url= "produk_reseller";
		$title= "Daftar Produk Reseller";
		break;
    case 'produk_reseller_create':
        $view = "view/produk_reseller/create.php";
		$mod_url= "produk_reseller";
        $title= "Tambah Produk Reseller";
        break;
    case 'produk_reseller_edit':
        $view = "view/produk_reseller/edit.php";
		$mod_url= "produk_reseller";
        $title= "Edit Produk Reseller";
        break;
    
    case 'paket':
        $view = "view/paket/paket_list.php";
        $mod_url= "paket";
        $title= "Daftar ".$lang['paket']." ".$lang['member'];
        break;
    case 'paket_create':
        $view = "view/paket/paket_create.php";
        $mod_url= "paket";
        $title= "Tambah ".$lang['paket']." ".$lang['member'];
        break;
    case 'paket_edit':
        $view = "view/paket/paket_edit.php";
        $mod_url= "paket";
        $title= "Edit ".$lang['paket']." ".$lang['member'];
        break;
            
    case 'bank':
        $view = "view/bank/bank_list.php";
        $mod_url= "bank";
        $title= "Daftar Bank";
        break;
    case 'bank_create':
        $view = "view/bank/bank_create.php";
        $mod_url= "bank";
        $title= "Tambah Bank";
        break;
    case 'bank_edit':
        $view = "view/bank/bank_edit.php";
        $mod_url= "bank";
        $title= "Edit Bank";
        break;
    
    case 'rekening':
        $view = "view/rekening/rekening_list.php";
        $mod_url= "rekening";
        $title= "Daftar Rekening Perusahaan";
        break;
    case 'rekening_create':
        $view = "view/rekening/rekening_create.php";
        $mod_url= "rekening";
        $title= "Tambah Rekening Perusahaan";
        break;
    case 'rekening_edit':
        $view = "view/rekening/rekening_edit.php";
        $mod_url= "rekening";
        $title= "Edit Rekening Perusahaan";
        break;
            
    case 'bonus_sponsor_setting':
        $view = "view/bonus_sponsor_setting/bonus_sponsor_setting_list.php";
        $mod_url= "bonus_sponsor_setting";
        $title= "Setting Bonus ".$lang['sponsor'];
        break;
    case 'bonus_sponsor_setting_create':
        $view = "view/bonus_sponsor_setting/bonus_sponsor_setting_create.php";
        $mod_url= "bonus_sponsor_setting";
        $title= "Tambah Setting Bonus ".$lang['sponsor'];
        break;
    case 'bonus_sponsor_setting_edit':
        $view = "view/bonus_sponsor_setting/bonus_sponsor_setting_edit.php";
        $mod_url= "bonus_sponsor_setting";
        $title= "Edit Setting Bonus ".$lang['sponsor'];
        break;
            
    case 'bonus_pasangan_setting':
        $view = "view/bonus_pasangan_setting/bonus_pasangan_setting_list.php";
        $mod_url= "bonus_pasangan_setting";
        $title= "Setting Bonus ".$lang['pasangan'];
        break;
    case 'bonus_pasangan_setting_create':
        $view = "view/bonus_pasangan_setting/bonus_pasangan_setting_create.php";
        $mod_url= "bonus_pasangan_setting";
        $title= "Tambah Setting Bonus ".$lang['pasangan'];
        break;
    case 'bonus_pasangan_setting_edit':
        $view = "view/bonus_pasangan_setting/bonus_pasangan_setting_edit.php";
        $mod_url= "bonus_pasangan_setting";
        $title= "Edit Setting Bonus ".$lang['pasangan'];
        break;
            
    case 'bonus_reward_setting':
        $view = "view/bonus_reward_setting/bonus_reward_setting_list.php";
        $mod_url= "bonus_reward_setting";
        $title= "Setting Bonus Reward";
        break;
    case 'bonus_reward_setting_create':
        $view = "view/bonus_reward_setting/bonus_reward_setting_create.php";
        $mod_url= "bonus_reward_setting";
        $title= "Tambah Setting Bonus Reward";
        break;
    case 'bonus_reward_setting_edit':
        $view = "view/bonus_reward_setting/bonus_reward_setting_edit.php";
        $mod_url= "bonus_reward_setting";
        $title= "Edit Setting Bonus Reward";
        break;
            
    case 'bonus_cashback_setting':
        $view = "view/bonus_cashback_setting/bonus_cashback_setting_list.php";
        $mod_url= "bonus_cashback_setting";
        $title= "Setting Bonus Cashback";
        break;
    case 'bonus_cashback_setting_create':
        $view = "view/bonus_cashback_setting/bonus_cashback_setting_create.php";
        $mod_url= "bonus_cashback_setting";
        $title= "Tambah Setting Bonus Cashback";
        break;
    case 'bonus_cashback_setting_edit':
        $view = "view/bonus_cashback_setting/bonus_cashback_setting_edit.php";
        $mod_url= "bonus_cashback_setting";
        $title= "Edit Setting Bonus Cashback";
        break;

    case 'bonus_generasi_setting':
        $view = "view/bonus_generasi_setting/bonus_generasi_setting_list.php";
        $mod_url= "bonus_generasi_setting";
        $title= "Setting Bonus Generasi";
        break;
    case 'bonus_generasi_setting_create':
        $view = "view/bonus_generasi_setting/bonus_generasi_setting_create.php";
        $mod_url= "bonus_generasi_setting";
        $title= "Tambah Setting Bonus Generasi";
        break;
    case 'bonus_generasi_setting_edit':
        $view = "view/bonus_generasi_setting/bonus_generasi_setting_edit.php";
        $mod_url= "bonus_generasi_setting";
        $title= "Edit Setting Bonus Generasi";
        break;
    case 'bonus_generasi_persentase':
        $view = "view/bonus_generasi_persentase/bonus_generasi_persentase_list.php";
        $mod_url= "bonus_generasi_persentase";
        $title= "Persentase Bonus Generasi";
        break;
    case 'bonus_generasi_persentase_create':
        $view = "view/bonus_generasi_persentase/bonus_generasi_persentase_create.php";
        $mod_url= "bonus_generasi_persentase";
        $title= "Tambah Persentase Bonus Generasi";
        break;
    case 'bonus_generasi_persentase_edit':
        $view = "view/bonus_generasi_persentase/bonus_generasi_persentase_edit.php";
        $mod_url= "bonus_generasi_persentase";
        $title= "Edit Persentase Bonus Generasi";
        break;
    
    case 'stokis_paket':
        $view = "view/stokis_paket/stokis_paket_list.php";
        $mod_url= "stokis_paket";
        $title= "Daftar ".$lang['paket']." ".$lang['stokis'];
        break;
    case 'stokis_paket_create':
        $view = "view/stokis_paket/stokis_paket_create.php";
        $mod_url= "stokis_paket";
        $title= "Tambah ".$lang['paket']." ".$lang['stokis'];
        break;
    case 'stokis_paket_edit':
        $view = "view/stokis_paket/stokis_paket_edit.php";
        $mod_url= "stokis_paket";
        $title= "Edit ".$lang['paket']." ".$lang['stokis'];
        break;

    case 'stokis_member':
        $view = "view/stokis_member/stokis_member_list.php";
        $mod_url= "stokis_member";
        $title= "Daftar ".$lang['stokis'];
        break;
    case 'stokis_member_create':
        $view = "view/stokis_member/stokis_member_create.php";
        $mod_url= "stokis_member";
        $title= "Tambah ".$lang['stokis'];
        break;
    case 'stokis_member_edit':
        $view = "view/stokis_member/stokis_member_edit.php";
        $mod_url= "stokis_member";
        $title= "Edit ".$lang['stokis'];
        break;
        
    case 'stokis_deposit':
        $view = "view/stokis_deposit/stokis_deposit_list.php";
        $mod_url= "stokis_deposit";
        $title= "Deposit ".$lang['stokis'];
        break;
    case 'stokis_deposit_riwayat':
        $view = "view/stokis_deposit/stokis_deposit_riwayat.php";
        $mod_url= "stokis_deposit";
        $title= "Riwayat Deposit ".$lang['stokis'];
        break;
        
    case 'stokis_order_list':
        $view = "view/stokis_order/stokis_order_list.php";
        $mod_url= "stokis_deposit";
        $title= "Pembayaran Order ".$lang['stokis'];
        break;
    case 'stokis_order_pending':
        $view = "view/stokis_order/stokis_order_pending.php";
        $mod_url= "stokis_deposit";
        $title= "Menunggu Proses ".$lang['stokis'];
        break;
        
    case 'stokis_order_kirim':
        $view = "view/stokis_order/stokis_order_kirim.php";
        $mod_url= "stokis_deposit";
        $title= "Kirim Produk ke ".$lang['stokis'];
        break;

    case 'stokis_order_riwayat':
        $view = "view/stokis_order/stokis_order_riwayat.php";
        $mod_url= "stokis_deposit";
        $title= "Riwayat Order ".$lang['stokis'];
        break;
    case 'stokis_order_invoice':
        $view = "view/stokis_order/stokis_order_invoice.php";
        $mod_url= "stokis_deposit";
        $title= "Detail Order";
        break; 
    // case 'stokis_deposit_create':
    //     $view = "view/stokis_deposit/stokis_deposit_create.php";
    //     $mod_url= "stokis_deposit";
    //     $title= "Tambah Deposit ".$lang['stokis'];
    //     break;
        
    case 'stokis_deposit_invoice':
        $view = "view/stokis_deposit/stokis_deposit_invoice.php";
        $mod_url= "stokis_deposit";
        $title= "Invoice Deposit";
        break;        
        
    case 'stokis_cashback_list':
        $view = "view/stokis_cashback/list.php";
        $mod_url= "stokis_cashback";
        $title= "Fee Stokis ";
        break;        
    case 'stokis_cashback_transfer':
        $view = "view/stokis_cashback/transfer.php";
        $mod_url= "stokis_cashback";
        $title= "Transfer Fee Stokis";
        break;        
    case 'stokis_cashback_laporan':
        $view = "view/stokis_cashback/laporan.php";
        $mod_url= "stokis_cashback";
        $title= "Laporan Fee Stokis";
        break;

    case 'peringkat':
        $view = "view/peringkat/peringkat_list.php";
        $mod_url= "peringkat";
        $title= "Daftar Peringkat";
        break;
    case 'peringkat_create':
        $view = "view/peringkat/peringkat_create.php";
        $mod_url= "peringkat";
        $title= "Tambah Peringkat";
        break;
    case 'peringkat_edit':
        $view = "view/peringkat/peringkat_edit.php";
        $mod_url= "peringkat";
        $title= "Edit Peringkat";
        break;

    case 'member_list':
        $view = "view/member/member_list.php";
        $mod_url= "member";
        $title= "Daftar ".$lang['member'];
        break;

    case 'member_download':
        $view = "view/member/member_download.php";
        $mod_url= "member";
        $title= "Daftar ".$lang['member'];
        break;
    
    case 'member_elemen':
        $view = "view/member/member_elemen.php";
        $title= "Member";
        break;

    case 'member_edit':
        $view = "view/member/member_edit.php";
        $mod_url= "member";
        $title= "Edit ".$lang['member'];
        break;
    
    case 'member_pohon_jaringan':
        $view = "view/member/pohon_jaringan.php";
        $mod_url= "member";
        $title= "Pohon Jaringan - Daftar ".$lang['member'];
        break;
    
    case 'member_register':
        $view = "view/member/member_register.php";
        $mod_url= "member";
        $title= "Daftar ".$lang['member']." Baru";
        break;

    case 'member_ro':
        $view = "view/member_ro/member_ro.php";
        $mod_url= "member_ro";
        $title= "Daftar ".$lang['member'].' RO';
        break;
        
    case 'bypass_login':
        $view = "controller/member/bypass_login.php";
        $title= "Member";
        break;   
        
    case 'bypass_login_stokis':
        $view = "controller/stokis_member/bypass_login.php";
        $title= "Member";
        break;    

    case 'bonus_transfer':
        $view = "view/bonus/bonus_transfer.php";
        $mod_url= "bonus";
        $title= "Transfer Bonus";
        break;   
             
    case 'bonus_laporan':
        $view = "view/bonus/bonus_laporan.php";
        $mod_url= "bonus";
        $title= "Riwayat Transfer Bonus";
        break;
        
    case 'bonus_sponsor_list':
        $view = "view/bonus_sponsor/list.php";
        $mod_url= "bonus_sponsor";
        $title= $lang['bonus_sponsor'];
        break;        
    case 'bonus_sponsor_transfer':
        $view = "view/bonus_sponsor/transfer.php";
        $mod_url= "bonus_sponsor";
        $title= $lang['bonus_sponsor'];
        break;        
    case 'bonus_sponsor_reject_list':
        $view = "view/bonus_sponsor/reject_list.php";
        $mod_url= "bonus_sponsor";
        $title= $lang['bonus_sponsor'];
        break;     
    case 'bonus_sponsor_laporan':
        $view = "view/bonus_sponsor/laporan.php";
        $mod_url= "bonus_sponsor";
        $title= $lang['bonus_sponsor'];
        break;
        
    case 'bonus_pasangan_list':
        $view = "view/bonus_pasangan/list.php";
        $mod_url= "bonus_pasangan";
        $title= $lang['bonus_pasangan'];
        break;        
    case 'bonus_pasangan_transfer':
        $view = "view/bonus_pasangan/transfer.php";
        $mod_url= "bonus_pasangan";
        $title= $lang['bonus_pasangan'];
        break;        
    case 'bonus_pasangan_reject_list':
        $view = "view/bonus_pasangan/reject_list.php";
        $mod_url= "bonus_pasangan";
        $title= $lang['bonus_pasangan'];
        break;     
    case 'bonus_pasangan_laporan':
        $view = "view/bonus_pasangan/laporan.php";
        $mod_url= "bonus_pasangan";
        $title= $lang['bonus_pasangan'];
        break;
        
    case 'bonus_cashback_list':
        $view = "view/bonus_cashback/list.php";
        $mod_url= "bonus_cashback";
        $title= $lang['bonus_cashback'];
        break;        
    case 'bonus_cashback_transfer':
        $view = "view/bonus_cashback/transfer.php";
        $mod_url= "bonus_cashback";
        $title= $lang['bonus_cashback'];
        break;        
    case 'bonus_cashback_reject_list':
        $view = "view/bonus_cashback/reject_list.php";
        $mod_url= "bonus_cashback";
        $title= $lang['bonus_cashback'];
        break;     
    case 'bonus_cashback_laporan':
        $view = "view/bonus_cashback/laporan.php";
        $mod_url= "bonus_cashback";
        $title= $lang['bonus_cashback'];
        break;
        
        
    case 'bonus_reward_list':
        $view = "view/bonus_reward/list.php";
        $mod_url= "bonus_reward";
        $title= $lang['bonus_reward'];
        break;        
    case 'bonus_reward_transfer':
        $view = "view/bonus_reward/transfer.php";
        $mod_url= "bonus_reward";
        $title= $lang['bonus_reward'];
        break;        
    case 'bonus_reward_reject_list':
        $view = "view/bonus_reward/reject_list.php";
        $mod_url= "bonus_reward";
        $title= $lang['bonus_reward'];
        break;     
    case 'bonus_reward_laporan':
        $view = "view/bonus_reward/laporan.php";
        $mod_url= "bonus_reward";
        $title= $lang['bonus_reward'];
        break;
        
        
    case 'bonus_reward_pribadi_list':
        $view = "view/bonus_reward_pribadi/list.php";
        $mod_url= "bonus_reward_pribadi";
        $title= $lang['bonus_reward_pribadi'];
        break;        
    case 'bonus_reward_pribadi_transfer':
        $view = "view/bonus_reward_pribadi/transfer.php";
        $mod_url= "bonus_reward_pribadi";
        $title= $lang['bonus_reward_pribadi'];
        break;        
    case 'bonus_reward_pribadi_reject_list':
        $view = "view/bonus_reward_pribadi/reject_list.php";
        $mod_url= "bonus_reward_pribadi";
        $title= $lang['bonus_reward_pribadi'];
        break;     
    case 'bonus_reward_pribadi_laporan':
        $view = "view/bonus_reward_pribadi/laporan.php";
        $mod_url= "bonus_reward_pribadi";
        $title= $lang['bonus_reward_pribadi'];
        break;
        
    case 'bonus_generasi_list':
        $view = "view/bonus_generasi/list.php";
        $mod_url= "bonus_generasi";
        $title= $lang['bonus_generasi_ro'];
        break;        
    case 'bonus_generasi_transfer':
        $view = "view/bonus_generasi/transfer.php";
        $mod_url= "bonus_generasi";
        $title= $lang['bonus_generasi_ro'];
        break;        
    case 'bonus_generasi_reject_list':
        $view = "view/bonus_generasi/reject_list.php";
        $mod_url= "bonus_generasi";
        $title= $lang['bonus_generasi_ro'];
        break;     
    case 'bonus_generasi_laporan':
        $view = "view/bonus_generasi/laporan.php";
        $mod_url= "bonus_generasi";
        $title= $lang['bonus_generasi_ro'];
        break;
        
    case 'member_autosave':
        $view = "view/bonus_unilevel/member_autosave.php";
        $mod_url= "bonus_unilevel";
        $title= 'Member Autosave';
        break;  
        
    case 'bonus_unilevel_list':
        $view = "view/bonus_unilevel/list.php";
        $mod_url= "bonus_unilevel";
        $title= $lang['bonus_unilevel'];
        break;        
    case 'bonus_unilevel_transfer':
        $view = "view/bonus_unilevel/transfer.php";
        $mod_url= "bonus_unilevel";
        $title= $lang['bonus_unilevel'];
        break;        
    case 'bonus_unilevel_reject_list':
        $view = "view/bonus_unilevel/reject_list.php";
        $mod_url= "bonus_unilevel";
        $title= $lang['bonus_unilevel'];
        break;     
    case 'bonus_unilevel_laporan':
        $view = "view/bonus_unilevel/laporan.php";
        $mod_url= "bonus_unilevel";
        $title= $lang['bonus_unilevel'];
        break;

    case 'topup_saldo':
        $view = "view/topup_saldo/topup_saldo.php";
        $title= "Topup Saldo Autosave";
        break;
    case 'topup_saldo_laporan':
        $view = "view/topup_saldo/topup_saldo_laporan.php";
        $title= "Laporan Topup Saldo Autosave";
        break;

    case 'laporan_rekap_bonus':
        $view = "view/laporan/laporan_rekap_bonus.php";
        $mod_url= "laporan_rekap_bonus";
        $title= "Laporan Rekap Bonus";
        break;

    case 'kodeaktivasi_list':
        $view = "view/kodeaktivasi/kodeaktivasi_list.php";
        $mod_url= "kodeaktivasi";
        $title= "Daftar ".$lang['kode_aktivasi']."";
        break;

    case 'aktivasi_list':
        $view = "view/kodeaktivasi/aktivasi_list.php";
        $mod_url= "kodeaktivasi";
        $title= "Riwayat Aktivasi";
        break;
    case 'kodeaktivasi_detail':
        $view = "view/kodeaktivasi/kodeaktivasi_detail.php";
        $mod_url= "kodeaktivasi";
        $title= "Tracking Kode Aktivasi";
        break;
    case 'kodeaktivasi_create':
        $view = "view/kodeaktivasi/kodeaktivasi_create.php";
        $mod_url= "kodeaktivasi";
        $title= "Create Kode Aktivasi";
        break;
    case 'member_order':
		$view = "view/member_order/member_order.php";
		$title= "Member";
		break;	
    case 'member_order_detail':
        $view = "view/member_order/member_order_detail.php";
        $title= "Member";
        break;	
    case 'transfer_penarikan':
        $view = "view/penarikan/transfer.php";
        $title= "Transfer Penarikan";
        break;	
    case 'riwayat_transfer':
        $view = "view/penarikan/riwayat_transfer.php";
        $title= "Riwayat Transfer";
        break;	
    case 'riwayat_reject':
        $view = "view/penarikan/riwayat_reject.php";
        $title= "Riwayat Reject";
        break;	
    case 'transfer_penarikan_market':
        $view = "view/penarikan_market/transfer.php";
        $title= "Transfer Penarikan";
        break;	
    case 'riwayat_transfer_market':
        $view = "view/penarikan_market/riwayat_transfer.php";
        $title= "Riwayat Transfer";
        break;	
    case 'riwayat_reject_market':
        $view = "view/penarikan_market/riwayat_reject.php";
        $title= "Riwayat Reject";
        break;	
    case 'transfer_penarikan_coin':
        $view = "view/penarikan_coin/transfer.php";
        $title= "Transfer Penarikan";
        break;	
    case 'riwayat_transfer_coin':
        $view = "view/penarikan_coin/riwayat_transfer.php";
        $title= "Riwayat Transfer";
        break;	
    case 'riwayat_reject_coin':
        $view = "view/penarikan_coin/riwayat_reject.php";
        $title= "Riwayat Reject";
        break;	

    case 'dashboard_undian':
        $view = "view/undian/dashboard_undian.php";
        $title= "Dashboard Undian";
        break;	
    case 'kupon_bulanan':
        $view = "view/undian/kupon_bulanan.php";
        $title= "Kupon Undian Bulanan";
        break;	
    case 'kupon_tiga_bulanan':
        $view = "view/undian/kupon_tiga_bulanan.php";
        $title= "Kupon Undian Tiga Bulanan";
        break;	
    case 'kupon_tahunan':
        $view = "view/undian/kupon_tahunan.php";
        $title= "Kupon Undian Tahunan";
        break;	
    case 'pemenang_undian':
        $view = "view/undian/pemenang_list.php";
        $title= "Pemenang Undian";
        break;	
    case 'pemenang_proses':
        $view = "view/undian/pemenang_proses.php";
        $title= "Proses Pemenang Undian";
        break;
    case 'pemenang_laporan':
        $view = "view/undian/pemenang_laporan.php";
        $title= "Laporan Proses Pemenang Undian";
        break;            
    case 'rate_coin':
        $view = "view/rate_coin/list.php";
        $mod_url= "rate_coin";
        $title= "Rate Coin";
        break;
    case 'rate_coin_create':
        $view = "view/rate_coin/create.php";
        $mod_url= "rate_coin";
        $title= "Update Rate Coin";
        break;
    case 'klaim_autosave':
        $view = "view/autosave/member_order.php";
        $title= "Member";
        break;	
    case 'member_autosave_detail':
        $view = "view/autosave/member_order_detail.php";
        $title= "Member";
        break;
    case 'riwayat_saldo_autosave':
        $view = "view/autosave/riwayat_saldo_autosave.php";
        $title= "Member";
        break;
            
    case 'user':
        $view = "view/user/list.php";
        $mod_url= "user";
        $title= "Setting User Admin";
        break;
    case 'user_create':
        $view = "view/user/create.php";
        $mod_url= "user";
        $title= "Tambah User Admin";
        break;
    case 'user_edit':
        $view = "view/user/edit.php";
        $mod_url= "user";
        $title= "Edit User Admin";
        break;
    case 'omset_bulanan':
        $view = "view/statistik/omset_bulanan.php";
        $title= "Omset";
        break;
    case 'statistik_harian':
		$view = "view/statistik/statistik_harian.php";
		$title= "Statistik Harian";
		break;
        
    case 'bonus_sponsor_ro_aktif_list':
        $view = "view/bonus_sponsor_ro_aktif/list.php";
        $mod_url= "bonus_sponsor_ro_aktif";
        $title= $lang['bonus_sponsor_ro_aktif'];
        break;        
    case 'bonus_sponsor_ro_aktif_transfer':
        $view = "view/bonus_sponsor_ro_aktif/transfer.php";
        $mod_url= "bonus_sponsor_ro_aktif";
        $title= $lang['bonus_sponsor_ro_aktif'];
        break;        
    case 'bonus_sponsor_ro_aktif_reject_list':
        $view = "view/bonus_sponsor_ro_aktif/reject_list.php";
        $mod_url= "bonus_sponsor_ro_aktif";
        $title= $lang['bonus_sponsor_ro_aktif'];
        break;     
    case 'bonus_sponsor_ro_aktif_laporan':
        $view = "view/bonus_sponsor_ro_aktif/laporan.php";
        $mod_url= "bonus_sponsor_ro_aktif";
        $title= $lang['bonus_sponsor_ro_aktif'];
        break;
    case 'bonus_cashback_ro_aktif_list':
        $view = "view/bonus_cashback_ro_aktif/list.php";
        $mod_url= "bonus_cashback_ro_aktif";
        $title= $lang['bonus_cashback_ro_aktif'];
        break;        
    case 'bonus_cashback_ro_aktif_transfer':
        $view = "view/bonus_cashback_ro_aktif/transfer.php";
        $mod_url= "bonus_cashback_ro_aktif";
        $title= $lang['bonus_cashback_ro_aktif'];
        break;        
    case 'bonus_cashback_ro_aktif_reject_list':
        $view = "view/bonus_cashback_ro_aktif/reject_list.php";
        $mod_url= "bonus_cashback_ro_aktif";
        $title= $lang['bonus_cashback_ro_aktif'];
        break;     
    case 'bonus_cashback_ro_aktif_laporan':
        $view = "view/bonus_cashback_ro_aktif/laporan.php";
        $mod_url= "bonus_cashback_ro_aktif";
        $title= $lang['bonus_cashback_ro_aktif'];
        break;
        
    case 'bonus_generasi_ro_aktif_list':
        $view = "view/bonus_generasi_ro_aktif/list.php";
        $mod_url= "bonus_generasi_ro_aktif";
        $title= $lang['bonus_generasi_ro_aktif'];
        break;        
    case 'bonus_generasi_ro_aktif_transfer':
        $view = "view/bonus_generasi_ro_aktif/transfer.php";
        $mod_url= "bonus_generasi_ro_aktif";
        $title= $lang['bonus_generasi_ro_aktif'];
        break;        
    case 'bonus_generasi_ro_aktif_reject_list':
        $view = "view/bonus_generasi_ro_aktif/reject_list.php";
        $mod_url= "bonus_generasi_ro_aktif";
        $title= $lang['bonus_generasi_ro_aktif'];
        break;     
    case 'bonus_generasi_ro_aktif_laporan':
        $view = "view/bonus_generasi_ro_aktif/laporan.php";
        $mod_url= "bonus_generasi_ro_aktif";
        $title= $lang['bonus_generasi_ro_aktif'];
        break;
        
    case 'bonus_titik_ro_aktif_list':
        $view = "view/bonus_titik_ro_aktif/list.php";
        $mod_url= "bonus_titik_ro_aktif";
        $title= $lang['bonus_titik_ro_aktif'];
        break;        
    case 'bonus_titik_ro_aktif_transfer':
        $view = "view/bonus_titik_ro_aktif/transfer.php";
        $mod_url= "bonus_titik_ro_aktif";
        $title= $lang['bonus_titik_ro_aktif'];
        break;        
    case 'bonus_titik_ro_aktif_reject_list':
        $view = "view/bonus_titik_ro_aktif/reject_list.php";
        $mod_url= "bonus_titik_ro_aktif";
        $title= $lang['bonus_titik_ro_aktif'];
        break;     
    case 'bonus_titik_ro_aktif_laporan':
        $view = "view/bonus_titik_ro_aktif/laporan.php";
        $mod_url= "bonus_titik_ro_aktif";
        $title= $lang['bonus_titik_ro_aktif'];
        break;
        
    case 'bonus_royalti_omset_list':
        $view = "view/bonus_royalti_omset/list.php";
        $mod_url= "bonus_royalti_omset";
        $title= $lang['bonus_royalti_omset'];
        break;        
    case 'bonus_royalti_omset_transfer':
        $view = "view/bonus_royalti_omset/transfer.php";
        $mod_url= "bonus_royalti_omset";
        $title= $lang['bonus_royalti_omset'];
        break;        
    case 'bonus_royalti_omset_reject_list':
        $view = "view/bonus_royalti_omset/reject_list.php";
        $mod_url= "bonus_royalti_omset";
        $title= $lang['bonus_royalti_omset'];
        break;     
    case 'bonus_royalti_omset_laporan':
        $view = "view/bonus_royalti_omset/laporan.php";
        $mod_url= "bonus_royalti_omset";
        $title= $lang['bonus_royalti_omset'];
        break;

    case 'bonus_ro_aktif_transfer':
        $view = "view/bonus_ro_aktif/transfer.php";
        $mod_url= "bonus_ro_aktif";
        $title= "Transfer Bonus RO Aktif";
        break;   

    case 'bonus_ro_aktif_reject':
        $view = "view/bonus_ro_aktif/reject.php";
        $mod_url= "bonus_ro_aktif";
        $title= "Hidden Bonus RO Aktif";
        break;   
             
    case 'bonus_ro_aktif_laporan':
        $view = "view/bonus_ro_aktif/laporan.php";
        $mod_url= "bonus_ro_aktif";
        $title= "Riwayat Transfer Bonus RO Aktif";
        break;    
             
    case 'bonus_netborn_transfer':
        $view = "view/bonus_netborn/transfer.php";
        $mod_url= "bonus_netborn";
        $title= $lang['bonus_netborn'];
        break;   
    case 'bonus_netborn_limit':
        $view = "view/bonus_netborn/limit.php";
        $mod_url= "bonus_netborn";
        $title= $lang['bonus_netborn'];
        break;        
    case 'bonus_netborn_reject_list':
        $view = "view/bonus_netborn/reject.php";
        $mod_url= "bonus_netborn";
        $title= $lang['bonus_netborn'];
        break;     
    case 'bonus_netborn_laporan':
        $view = "view/bonus_netborn/laporan.php";
        $mod_url= "bonus_netborn";
        $title= $lang['bonus_netborn'];
        break;    
        
    case 'bonus_sponsor_netborn_list':
        $view = "view/bonus_sponsor_netborn/list.php";
        $mod_url= "bonus_sponsor_netborn";
        $title= $lang['bonus_sponsor_netborn'];
        break;        
    case 'bonus_sponsor_netborn_transfer':
        $view = "view/bonus_sponsor_netborn/transfer.php";
        $mod_url= "bonus_sponsor_netborn";
        $title= $lang['bonus_sponsor_netborn'];
        break;        
    case 'bonus_sponsor_netborn_reject_list':
        $view = "view/bonus_sponsor_netborn/reject_list.php";
        $mod_url= "bonus_sponsor_netborn";
        $title= $lang['bonus_sponsor_netborn'];
        break;     
    case 'bonus_sponsor_netborn_laporan':
        $view = "view/bonus_sponsor_netborn/laporan.php";
        $mod_url= "bonus_sponsor_netborn";
        $title= $lang['bonus_sponsor_netborn'];
        break;
        
    case 'bonus_pasangan_netborn_list':
        $view = "view/bonus_pasangan_netborn/list.php";
        $mod_url= "bonus_pasangan_netborn";
        $title= $lang['bonus_pasangan_netborn'];
        break;        
    case 'bonus_pasangan_netborn_transfer':
        $view = "view/bonus_pasangan_netborn/transfer.php";
        $mod_url= "bonus_pasangan_netborn";
        $title= $lang['bonus_pasangan_netborn'];
        break;        
    case 'bonus_pasangan_netborn_reject_list':
        $view = "view/bonus_pasangan_netborn/reject_list.php";
        $mod_url= "bonus_pasangan_netborn";
        $title= $lang['bonus_pasangan_netborn'];
        break;     
    case 'bonus_pasangan_netborn_laporan':
        $view = "view/bonus_pasangan_netborn/laporan.php";
        $mod_url= "bonus_pasangan_netborn";
        $title= $lang['bonus_pasangan_netborn'];
        break;
        
    case 'bonus_pasangan_level_netborn_list':
        $view = "view/bonus_pasangan_level_netborn/list.php";
        $mod_url= "bonus_pasangan_level_netborn";
        $title= $lang['bonus_pasangan_level_netborn'];
        break;        
    case 'bonus_pasangan_level_netborn_transfer':
        $view = "view/bonus_pasangan_level_netborn/transfer.php";
        $mod_url= "bonus_pasangan_level_netborn";
        $title= $lang['bonus_pasangan_level_netborn'];
        break;        
    case 'bonus_pasangan_level_netborn_reject_list':
        $view = "view/bonus_pasangan_level_netborn/reject_list.php";
        $mod_url= "bonus_pasangan_level_netborn";
        $title= $lang['bonus_pasangan_level_netborn'];
        break;     
    case 'bonus_pasangan_level_netborn_laporan':
        $view = "view/bonus_pasangan_level_netborn/laporan.php";
        $mod_url= "bonus_pasangan_level_netborn";
        $title= $lang['bonus_pasangan_level_netborn'];
        break;
        
    case 'bonus_generasi_netborn_list':
        $view = "view/bonus_generasi_netborn/list.php";
        $mod_url= "bonus_generasi_netborn";
        $title= $lang['bonus_generasi_netborn'];
        break;        
    case 'bonus_generasi_netborn_transfer':
        $view = "view/bonus_generasi_netborn/transfer.php";
        $mod_url= "bonus_generasi_netborn";
        $title= $lang['bonus_generasi_netborn'];
        break;        
    case 'bonus_generasi_netborn_reject_list':
        $view = "view/bonus_generasi_netborn/reject_list.php";
        $mod_url= "bonus_generasi_netborn";
        $title= $lang['bonus_generasi_netborn'];
        break;     
    case 'bonus_generasi_netborn_laporan':
        $view = "view/bonus_generasi_netborn/laporan.php";
        $mod_url= "bonus_generasi_netborn";
        $title= $lang['bonus_generasi_netborn'];
        break;        
        
    case 'bonus_titik_netborn_list':
        $view = "view/bonus_titik_netborn/list.php";
        $mod_url= "bonus_titik_netborn";
        $title= $lang['bonus_titik_netborn'];
        break;        
    case 'bonus_titik_netborn_transfer':
        $view = "view/bonus_titik_netborn/transfer.php";
        $mod_url= "bonus_titik_netborn";
        $title= $lang['bonus_titik_netborn'];
        break;        
    case 'bonus_titik_netborn_reject_list':
        $view = "view/bonus_titik_netborn/reject_list.php";
        $mod_url= "bonus_titik_netborn";
        $title= $lang['bonus_titik_netborn'];
        break;     
    case 'bonus_titik_netborn_laporan':
        $view = "view/bonus_titik_netborn/laporan.php";
        $mod_url= "bonus_titik_netborn";
        $title= $lang['bonus_titik_netborn'];
        break;
        
    case 'bonus_reward_netborn_list':
        $view = "view/bonus_reward_netborn/list.php";
        $mod_url= "bonus_reward";
        $title= $lang['bonus_reward_netborn'];
        break;        
    case 'bonus_reward_netborn_transfer':
        $view = "view/bonus_reward_netborn/transfer.php";
        $mod_url= "bonus_reward";
        $title= $lang['bonus_reward_netborn'];
        break;        
    case 'bonus_reward_netborn_reject_list':
        $view = "view/bonus_reward_netborn/reject_list.php";
        $mod_url= "bonus_reward";
        $title= $lang['bonus_reward_netborn'];
        break;     
    case 'bonus_reward_netborn_laporan':
        $view = "view/bonus_reward_netborn/laporan.php";
        $mod_url= "bonus_reward";
        $title= $lang['bonus_reward_netborn'];
        break;

        
    case 'bonus_balik_modal_list':
        $view = "view/bonus_balik_modal/list.php";
        $mod_url= "bonus_balik_modal";
        $title= $lang['bonus_balik_modal'];
        break;        
    case 'bonus_balik_modal_transfer':
        $view = "view/bonus_balik_modal/transfer.php";
        $mod_url= "bonus_balik_modal";
        $title= $lang['bonus_balik_modal'];
        break;        
    case 'bonus_balik_modal_reject_list':
        $view = "view/bonus_balik_modal/reject_list.php";
        $mod_url= "bonus_balik_modal";
        $title= $lang['bonus_balik_modal'];
        break;     
    case 'bonus_balik_modal_laporan':
        $view = "view/bonus_balik_modal/laporan.php";
        $mod_url= "bonus_balik_modal";
        $title= $lang['bonus_balik_modal'];
        break; 
        
    case 'netspin_setting':
        $view = "view/netspin_setting/list.php";
        $mod_url= "netspin_setting";
        $title= "Setting NetSpin Reward";
        break;
    case 'netspin_setting_create':
        $view = "view/netspin_setting/create.php";
        $mod_url= "netspin_setting";
        $title= "Create NetSpin Reward";
        break;
    case 'netspin_setting_edit':
        $view = "view/netspin_setting/edit.php";
        $mod_url= "netspin_setting";
        $title= "Edit Setting NetSpin Reward";
        break;
	default:
		$view = "view/dashboard/home.php";
		$title= "Home";
		break;
}

require_once($view);

?>
