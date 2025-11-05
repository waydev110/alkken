<?php 
if(isset($_GET['go'])){
	$halaman = $_GET['go'];
}else{
	$halaman = "home";
}
$view = "view/dashboard/home.php";
$title= "Home";

switch ($halaman) {
	case 'home':
		$view = "view/dashboard/home.php";
		$title= "Home";
		break;    
    case 'rekening':
        $view = "view/rekening/rekening_list.php";
        $mod_url= "rekening";
        $title= "Daftar Rekening Stokis";
        break;
    case 'rekening_create':
        $view = "view/rekening/rekening_create.php";
        $mod_url= "rekening";
        $title= "Tambah Rekening Stokis";
        break;
    case 'rekening_edit':
        $view = "view/rekening/rekening_edit.php";
        $mod_url= "rekening";
        $title= "Edit Rekening Stokis";
        break;
    case 'stokis_deposit':
        if($_SESSION['session_paket_stokis'] >= 1){ 
        $view = "view/stokis_deposit/stokis_deposit_list.php";
        $mod_url= "stokis_deposit";
        $title= "Riwayat Deposit Order";
        }
        break;
    case 'stokis_deposit_create':
        if($_SESSION['session_paket_stokis'] >= 1){ 
        $view = "view/stokis_deposit/stokis_deposit_create.php";
        $mod_url= "stokis_deposit";
        $title= "Deposit Order";
        }
        break;
    case 'stokis_deposit_invoice':
        if($_SESSION['session_paket_stokis'] >= 1){ 
        $view = "view/stokis_deposit/stokis_deposit_invoice.php";
        $mod_url= "stokis_deposit";
        $title= "Invoice Deposit";
        }
        break;
    // case 'stokis_order_list':
    //     $view = "view/stokis_order/stokis_order_list.php";
    //     $mod_url= "stokis_order";
    //     $title= "Deposit Order";
    //     break;
    // case 'stokis_order_riwayat':
    //     $view = "view/stokis_order/stokis_order_riwayat.php";
    //     $mod_url= "stokis_order";
    //     $title= "Riwayat Stokis Order";
    //     break;
    // case 'stokis_order_invoice':
    //     $view = "view/stokis_order/stokis_order_invoice.php";
    //     $mod_url= "stokis_order";
    //     $title= "Invoice Order";
    //     break;
        
    case 'stokis_transfer':
        if($_SESSION['session_paket_stokis'] < 3){
        $view = "view/stokis_transfer/stokis_transfer_list.php";
        $mod_url= "stokis_transfer";
        $title= "Riwayat Transfer Stok";
        }
        break;
    case 'stokis_terima':
        $view = "view/stokis_transfer/stokis_terima_list.php";
        $mod_url= "stokis_terima";
        $title= "Riwayat Terima Stok";
        break;
    case 'stokis_transfer_create':
        if($_SESSION['session_paket_stokis'] < 3){
        $view = "view/stokis_transfer/stokis_transfer_create.php";
        $mod_url= "stokis_transfer";
        $title= "Transfer Stok";
        }
        break;
    case 'stokis_transfer_invoice':
        if($_SESSION['session_paket_stokis'] < 3){
        $view = "view/stokis_transfer/stokis_transfer_invoice.php";
        $mod_url= "stokis_transfer";
        $title= "Invoice Transfer Stok";
        }
        break;
    case 'stokis_terima_invoice':
        $view = "view/stokis_transfer/stokis_terima_invoice.php";
        $mod_url= "stokis_transfer";
        $title= "Invoice Terima Stok";
        break;
        
    case 'jual_pin':
        $view = "view/jual_pin/jual_pin.php";
        $mod_url= "jual_pin";
        $title= "Jual PIN";
        break;
        
    case 'jual_pin_list':
        $view = "view/jual_pin/jual_pin_list.php";
        $mod_url= "jual_pin";
        $title= "Riwayat Penjualan";
        break;
        
    case 'stok_produk':
        $view = "view/stok_produk/stok_produk.php";
        $mod_url= "stok_produk";
        $title= "Stok Produk";
        break;
    
    case 'mutasi_stok_produk':
        $view = "view/stok_produk/mutasi_stok_produk.php";
        $mod_url= "mutasi_stok_produk";
        $title= "Mutasi Stok Produk";
        break;
        
    case 'stokis_cashback':
        $view = "view/stokis_cashback/stokis_cashback.php";
        $mod_url= "stokis_cashback";
        $title= "Fee Penjualan";
        break;
    case 'stokis_cashback_laporan':
        $view = "view/stokis_cashback/stokis_cashback_laporan.php";
        $mod_url= "stokis_cashback";
        $title= "Laporan Transfer Fee Penjualan";
        break;

    case 'profil':
        $view = "view/profil/profil.php";
        $mod_url= "profil";
        $title= "Profil";
        break;
        
    case 'member_order':
		$view = "view/member_order/member_order.php";
		$title= "Member Order";
		break;	

    case 'member_order_detail':
        $view = "view/member_order/member_order_detail.php";
        $title= "Member Order";
        break;	

	default:
		$view = "view/dashboard/home.php";
		$title= "Home";
		break;
}

require_once($view);

?>
