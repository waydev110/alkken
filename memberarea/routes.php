<?php 
$maintenance = 0;
if($maintenance == 1){
    header('Location: maintenance.php');    
}

if(isset($_GET['go'])){
	$halaman = $_GET['go'];
}else{
	$halaman = "home";
}
$show_modul = false;
if ($member->id_plan < 200) {
    $show_modul = true;
}


switch ($halaman) {
    case 'top_sponsor':
        $view = "view/member/top_sponsor.php";
        $title= "Top ".$lang['sponsor'];
        break;
    case 'member_prospek':
        $view = "view/member_prospek/member_prospek.php";
        $title= "Member Prospek";
        break;
	case 'member_create':
        if($_binary == true){
            $view = "view/member/member_binary_create.php";
        } else {
            $view = "view/member/member_create.php";
        }
		$title= "Pendaftaran ".$lang['member'];
		break;
    case 'change_tgl_lahir':
            $view = "view/profil/change_tgl_lahir.php";
            $title= "Update Tanggal Lahir"; 
        break;
	case 'posting_ro':
		$view = "view/posting_ro/posting_ro.php";
		$title= "Posting RO";
		break;
    case 'genealogy_level':
        $view = "view/jaringan/genealogy_level.php";
        $title= "Genealogy Level";
        break;
    case 'genealogy_v1':
        $view = "view/jaringan/pohon-jaringan.php";
        $title= "Genealogy";
        break;
    case 'genealogy_netborn':
        $view = "view/jaringan/genealogy_netborn.php";
        $title= "Genealogy Net Reborn";
        break;
    case 'genealogy_sponsor':
        $view = "view/jaringan_sponsor/genealogy.php";
        $title= "Genealogy Sponsor";
        break;

	case 'bonus':
		$view = "view/bonus/index.php";
		$title= "Bonus";
		break;

	case 'bonus_netborn':
		$view = "view/bonus/bonus_netborn.php";
		$title= "Bonus NetReborn";
		break;

	case 'riwayat_bonus':
		$view = "view/bonus/riwayat_bonus.php";
		$title= "Bonus";
		break;

    case 'riwayat_saldo':
        $view = "view/bonus/riwayat_saldo.php";
        $title= "Saldo";
        break;

    case 'riwayat_saldo_wd':
        $view = "view/bonus/riwayat_saldo_wd.php";
        $title= "Saldo Transfer Netborn";
        break;

	case 'statement_bonus':
		$view = "view/bonus/statement_bonus.php";
		$title= "Statement Bonus";
		break;
		
	case 'penarikan':
		$view = "view/wallet/penarikan.php";
		$title= "Penarikan";
		break;
		
    case 'riwayat_penarikan':
        $view = "view/wallet/riwayat_penarikan.php";
        $title= "Riwayat Penarikan";
        break;
		
    case 'penarikan_poin':
        $view = "view/wallet/penarikan_poin.php";
        $title= "Penarikan Autosave";
        break;
        
    case 'riwayat_penarikan_poin':
        $view = "view/wallet/riwayat_penarikan_poin.php";
        $title= "Riwayat Penarikan Autosave";
        break;
		
    case 'riwayat_transfer':
        $view = "view/wallet/riwayat_transfer.php";
        $title= "Riwayat Transfer";
        break;
		
	case 'transfer_wallet':
		$view = "view/wallet/transfer_wallet.php";
		$title= "Transfer Wallet";
		break;

    case 'riwayat_transfer_wallet':
        $view = "view/wallet/riwayat_transfer_wallet.php";
        $title= "Riwayat Transfer Wallet";
        break;

	case 'penukaran':
		$view = "view/wallet/penukaran.php";
		$title= "Penukaran";
		break;

	case 'keranjang_penukaran':
		$view = "view/wallet/keranjang_penukaran.php";
		$title= "Keranjang";
		break;
		
	case 'riwayat-penukaran':
		$view = "view/wallet/riwayat_penukaran.php";
		$title= "Riwayat Penukaran";
		break;
	
	case 'transfer_pin':
		$view = "view/transfer_pin/transfer_pin.php";
		$title= "Transfer ".$lang['kode_aktivasi']."";
		break;
	
	case 'riwayat_transfer_pin':
		$view = "view/transfer_pin/riwayat_transfer_pin.php";
		$title= "Riwayat ".$lang['kode_aktivasi'];
		break;
    case 'riwayat_transfer_pin_ro':
        $view = "view/transfer_pin/riwayat_transfer_pin_ro.php";
		$title= "Riwayat ".$lang['kode_aktivasi']." RO";
        break;
	
	case 'profil':
		$view = "view/profil/profil.php";
		$title= "Profil";
		break;	
	case 'change_username':
		$view = "view/auth/change_username.php";
		$title= "Update Username";
		break;
	case 'change_username_successfull':
		$view = "view/auth/change_username_successfull.php";
		$title= "Update Username";
		break;
	case 'change_password':
		$view = "view/auth/change_password.php";
		$title= "Update Password";
		break;
	case 'change_password_successfull':
		$view = "view/auth/change_password_successfull.php";
		$title= "Update Password";
		break;
	case 'change_pin':
		$view = "view/auth/change_pin.php";
		$title= "Update ".$lang['kode_aktivasi']."";
		break;
	case 'change_pin_successfull':
		$view = "view/auth/change_pin_successfull.php";
		$title= "Update Password";
		break;
	case 'change_profil':
        // if($profile_updated == '0'){
            $view = "view/profil/change_profil.php";
            $title= "Update Profil";            
        // } else {
        //     header("location: index.php");
        // }
		break;
    case 'ubah_alamat':
        // if($profile_updated == '0'){
            $view = "view/profil/change_alamat.php";
            $title= "Update Alamat";            
        // } else {
        //     header("location: index.php");
        // }
        break;

	case 'ubah_rekening':
        if($profile_updated == '0'){
            $view = "view/profil/ubah_rekening.php";
            $title= "Update Rekening";           
        } else {
            header("location: index.php");
        }
		break;
    case 'change_username_marketplace':
            $view = "view/profil/change_username_marketplace.php";
            $title= "Update Profil";   
        break;
		
	case 'berita':
		$view = "view/berita/berita.php";
		$title= "Berita";
		break;
	case 'berita_detail':
		$view = "view/berita/berita_detail.php";
		$title= "Berita";
		break;
	case 'produk':
		$view = "view/produk/produk.php";
		$title= "Produk";
		break;
	case 'produk_detail':
		$view = "view/produk_old/produk_detail.php";
		$title= "Produk";
		break;
	case 'omset_produk':
		$view = "view/omset/omset_produk.php";
		$title= "Omset Produk";
		break;
	case 'data_sponsorisasi':
		$view = "view/member/data_sponsorisasi.php";
		$title= "Data ".$lang['sponsor'];
		break;
        
    case 'stok_pin':
        $view = "view/kode_aktivasi/stok_pin.php";
        $title= "Stok ".$lang['kode_aktivasi'];
        break;
    case 'stok_pin_ro':
        $view = "view/posting_ro/stok_pin_ro.php";
        $title= "Stok ".$lang['kode_aktivasi']." RO";
        break;

    case 'cart':
        $view = "view/member_order/cart.php";
        $title= "Keranjang";
        break;

    case 'checkout':
        $view = "view/member_order/checkout.php";
        $title= "Pembayaran";
        break;

    case 'riwayat_order':
        $view = "view/member_order/riwayat_order.php";
        $title= "Riwayat Pesanan";
        break;

    case 'order_detail':
        $view = "view/member_order/order_detail.php";
        $title= "Detail Riwayat Pesanan";
        break;

    case 'pembayaran':
        $view = "view/member_order/pembayaran.php";
        $title= "Pembayaran";
        break;

    case 'klaim_reward':
        $view = "view/reward/klaim_reward.php";
        $title= "Klaim Reward";
        break;

    case 'klaim_reward_pribadi':
        $view = "view/reward/klaim_reward_pribadi.php";
        $title= "Klaim Reward";
        break;

    case 'status_member':
        $view = "view/member/status_member.php";
        $title= "Status Membership";
        break;

    case 'member_order':
        $view = "view/member_order/member_order.php";
        $title= "Belanja";
        break;

    case 'riwayat_poin_pasangan':
        $view = "view/riwayat/riwayat_poin_pasangan.php";
        $title= "Riwayat Poin Pasangan";
        break;

    case 'riwayat_poin_pasangan_level':
        $view = "view/riwayat/riwayat_poin_pasangan_level.php";
        $title= "Riwayat Poin Pasangan Level";
        break;

    case 'riwayat_poin_reward':
        $view = "view/riwayat/riwayat_poin_reward.php";
        $title= "Riwayat Poin Reward";
        break;

    case 'riwayat_poin_reward_pribadi':
        $view = "view/riwayat/riwayat_poin_reward_pribadi.php";
        $title= "Riwayat Poin Reward";
        break;

    case 'riwayat_ro':
        $view = "view/riwayat/riwayat_ro.php";
        $title= "Belanja";
        break;

    case 'detail_bisnis':
        $view = "view/info_bisnis/detail_bisnis.php";
        $title= "Informasi Bisnis Anda";
        break;

    case 'statistik_member':
        $view = "view/info_bisnis/detail_bisnis.php";
        $title= "Informasi Bisnis Anda";
        break;

    case 'sad_list':
        $view = "view/info_bisnis/sad_list.php";
        $title= "Stokis Auto Dropship";
        break;

    case 'upgrade':
        $view = "view/member/upgrade_member.php";
        $title= "Upgrade";
        break;

    case 'kupon_undian':
        $view = "view/undian/kupon_undian.php";
        $title= "Kupon Undian";
        break;

    case 'pemenang_undian':
        $view = "view/undian/pemenang_undian.php";
        $title= "Pemenang Undian";
        break;

    case 'certificate':
        $view = "view/certificate/certificate.php";
        $title= "Certificate";
        break;

    case 'riwayat_saldo_autosave':
        $view = "view/autosave/riwayat_saldo_autosave.php";
        $title= "Riwayat Saldo Autosave";
        break;

    case 'klaim_autosave':
        $view = "view/autosave/cart.php";
        $title= "Produk Autosave";
        break;

    case 'checkout_autosave':
        $view = "view/autosave/checkout.php";
        $title= "Konfirmasi";
        break;

    case 'riwayat_autosave':
        $view = "view/autosave/riwayat_order.php";
        $title= "Riwayat Klaim Autosave";
        break;

    case 'klaim_autosave_detail':
        $view = "view/autosave/order_detail.php";
        $title= "Detail Riwayat Klaim Autosave";
        break;

    case 'pembayaran_autosave':
        $view = "view/autosave/pembayaran.php";
        $title= "Pembayaran";
        break;
        
    case 'topup_saldo':
        $view = "view/topup_saldo/topup_saldo.php";
        $title= "Topup Saldo Autosave";
        break;
        
    case 'riwayat_topup_saldo':
        $view = "view/topup_saldo/riwayat_topup_saldo.php";
        $title= "Riwayat Topup Saldo Autosave";
        break;

    // case 'klaim_reedem':
    //     $view = "view/reedem/cart.php";
    //     $title= "Produk Reedem Poin";
    //     break;

    // case 'checkout_reedem':
    //     $view = "view/reedem/checkout.php";
    //     $title= "Konfirmasi";
    //     break;

    // case 'riwayat_reedem':
    //     $view = "view/reedem/riwayat_order.php";
    //     $title= "Riwayat Reedem Poin";
    //     break;

    // case 'klaim_reedem_detail':
    //     $view = "view/reedem/order_detail.php";
    //     $title= "Detail Riwayat Reedem Poin";
    //     break;

    // case 'pembayaran_reedem':
    //     $view = "view/reedem/pembayaran.php";
    //     $title= "Pembayaran Reedem Poin";
    //     break;

    // case 'bonus_insentif':
    //     $view = "view/bonus_insentif/list.php";
    //     $title= 'Bonus Insentif';
    //     break;

    // case 'bonus_insentif_detail':
    //     $view = "view/bonus_insentif/detail.php";
    //     $title= 'Bonus Insentif';
    //     break;

    case 'riwayat_aktivasi':
        $view = "view/riwayat/riwayat_aktivasi.php";
        $title= "Riwayat Aktivasi";
        break;

    case 'riwayat_posting':
        $view = "view/riwayat/riwayat_posting.php";
        $title= "Riwayat Posting";
        break;

    case 'link_referral':
        $view = "view/jaringan/link_referral.php";
        $title= "Web Replika";
        break;

    case 'all_menu':
        $view = "view/dashboard/all_menu.php";
        $title= "Daftar Menu";
        break;

    case 'testimoni':
        $view = "view/testimoni/testimoni_member.php";
        $title= "Testimoni ".$lang['member'];
        break;

    case 'product':
        $view = "view/produk/product.php";
        $title= "Produk";
        break;

    case 'riwayat_pesanan':
        $view = "view/beli_pin/riwayat_pesanan.php";
        $title= "Riwayat Pesanan";
        break;
        
    case 'klaim_produk_automaintain':
        $view = "view/automaintain/klaim_produk_automaintain.php";
        $title= "Klaim Produk Automaintain";
        break;
        
    case 'tutup_poin_automaintain':
        $view = "view/automaintain/tutup_poin_automaintain.php";
        $title= "Tutup Poin Automaintain";
        break;
        
    case 'form_tupo_automaintain':
        $view = "view/automaintain/form_tupo_automaintain.php";
        $title= "Tutup Poin Automaintain";
        break;
        
    case 'invoice_tupo':
        $view = "view/automaintain/invoice_auto_maintain.php";
        $title= "Tutup Poin Automaintain";
        break;
        
    case 'slip_bonus':
        $view = "view/bonus/slip_bonus.php";
        $title= "Slip Bonus";
        break;
        
    case 'slip_bonus_netborn':
        $view = "view/bonus/slip_bonus_netborn.php";
        $title= "Slip Bonus Net Reborn";
        break;
    
    case 'net_spin':
        $view = "view/spin/spin_reward.php";
        $title= "Reward";
        break;

    case 'riwayat_wallet_cash':
        $view = "view/riwayat/riwayat_wallet_cash.php";
        $title= "Riwayat Wallet Cash";
        break;

    case 'riwayat_wallet_reward':
        $view = "view/riwayat/riwayat_wallet_reward.php";
        $title= "Riwayat Wallet Reward";
        break;

	default:
		$view = "view/dashboard/home.php";
		$title= "Home";
		break;
}

if($profile_updated == '0'){
    $view = "view/profil/change_profil.php";
    $title= "Update Profil";  
}

if(file_exists($view)){
	require_once($view);	
}else{
	require_once("view/dashboard/home.php");	
}

?>