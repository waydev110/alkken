<?php 
if(isset($_GET['go'])){
	$halaman = $_GET['go'];
}else{
	$halaman = "home";
}

$maintenance = 0;

switch ($halaman) {
    case 'certificate':
        $view = "view/certificate/certificate.php";
        $title= "Certificate";
        break;

    case 'detail_bisnis':
        $view = "view/info_bisnis/detail_bisnis.php";
        $title= "Informasi Bisnis Anda";
        break;
        
    case 'genealogy_sponsor':
        $view = "view/jaringan_sponsor/genealogy.php";
        $title= "Genealogy Sponsor";
        break;

    case 'klaim_reward':
        $view = "view/reward/klaim_reward.php";
        $title= "Klaim Reward";
        break;

    case 'klaim_reward_pribadi':
        $view = "view/reward/klaim_reward_pribadi.php";
        $title= "Klaim Reward";
        break;

	case 'riwayat_bonus':
		$view = "view/bonus/riwayat_bonus.php";
		$title= "Bonus";
		break;

	case 'riwayat_bonus_reward':
		$view = "view/bonus/riwayat_bonus_reward.php";
		$title= "Bonus";
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
        $view = "view/produk/produk_detail.php";
        $title= "Produk";
        break;

	case 'statement_bonus':
		$view = "view/bonus/statement_bonus.php";
		$title= "Statement Bonus";
		break;
        
    case 'genealogy_v1':
        $view = "view/jaringan/pohon-jaringan.php";
        $title= "Genealogy";
        break;
    case 'genealogy_sponsor':
        $view = "view/jaringan_sponsor/genealogy.php";
        $title= "Genealogy Sponsor";
        break;

	case 'member_create':
        if($_binary == true){
            $view = "view/member/member_binary_create.php";
        } else {
            $view = "view/member/member_create.php";
        }
		$title= "Pendaftaran ".$lang['member'];
		break;
	case 'posting_ro':
		$view = "view/posting_ro/posting_ro.php";
		$title= "Posting RO";
		break;

    case 'member_order':
        $view = "view/member_order/member_order.php";
        $title= "Belanja";
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
	
	case 'profil':
		$view = "view/profil/profil.php";
		$title= "Profil";
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