<?php

if(isset($_POST['jual_pin'])){
	require_once '../../../model/classKodeAktivasiFasttrack.php';
	require_once '../../../model/classPaketFasttrack.php';
	require_once '../../../model/classMember.php';
	require_once '../../../model/classDepositTransaksi.php';
	require_once '../../../model/classDepositOrderFasttrack.php';
	require_once '../../../model/classCashbackStokis.php';


	$obj = new classKodeAktivasiFasttrack();
	$cp = new classPaketFasttrack();
	$cm = new classMember();
	$cdt = new classDepositTransaksi();
	$cdo = new classDepositOrderFasttrack();
	$cbs = new classCashbackStokis();

	session_start();
	$prosentase_bonus = $_SESSION['prosentase_bonus'];
	$id_paket_stokist = $_SESSION['id_paket_stokist'];
	$jumlah_paket = addslashes(strip_tags($_POST['jumlah_paket']));
	$jenis_paket = addslashes(strip_tags($_POST['jenis_paket']));
	$id_membere = addslashes(strip_tags(strtoupper($_POST['id_member'])));
	$id_member = $cm->get_id($id_membere);
	$id = addslashes(strip_tags($_POST['id']));

	$data = $cp->show($jenis_paket);

	for ($i=1; $i <= $jumlah_paket ; $i++) { 
		$kode_aktivasi = $obj->generate_code(12);
		$obj->set_kode_aktivasi($kode_aktivasi);
		$obj->set_jumlah_hu($data->jumlah_hu);
		$obj->set_harga_paket($data->harga_paket);
		$obj->set_status_aktivasi(0);
		$obj->set_id_paket($jenis_paket);
		$obj->set_id_member($id_member->id);
		$obj->set_id_stokis($id);
		$insert = $obj->create();
		
		if($insert){
			#input ke tabel deposittrans sebagai kredit
			#ambil ID deposit terakhir dengan stokis tersebut
			$id_depositorder = $cdo->get_max_id($id);
			$cdt->set_id_depositorder($id_depositorder);
			$cdt->set_debet('0');
			#ambil harga paket
			$cdt->set_kredit($data->harga_paket);
			$cdt->set_id_paket($jenis_paket);
			$cdt->set_kode_aktivasi($kode_aktivasi);
			$cdt->set_id_member($id_member->id);
			$cdt->set_id_stokis($id);

			$cdt->create();

			$query_reposisi = $cp->show($jenis_paket);
			$cek_reposisi = $query_reposisi->reposisi;
			#input juga bonus cashback
			// $nominal_cashback = $prosentase_bonus / 100 * $data->harga_paket;
			
			if($id_paket_stokist == 1){
			    
				# jika dia reposisi maka abaikan
				if($cek_reposisi == 0){
				   
					switch ($data->tingkat) {
						case '1':
							$nominal_cashback = 0;
							break;
						// case '2':
						// 	$nominal_cashback = 50000;
						// 	break;
						// case '3':
						// 	$nominal_cashback = 150000;
						// 	break;
						// case '4':
						// 	$nominal_cashback = 450000;
						// 	break;
						
						default:
							$nominal_cashback = 0;
							break;
					}
					 if($insert){
		?>	
	    	<script language="javascript">
	    	    alert('Jual PIN Fasttrack Berhasil');
				document.location="../../?go=jual_pin_list_fasttrack&msg=penjualan&stat=1";
				
			</script>
		<?php
	}else{
		?>	
	    	<script language="javascript">
	    	alert('Jual PIN Fasttrack gagal');
				document.location="../../?go=jual_pin_list_fasttrack&msg=penjualan&stat=0";
			</script>
		<?php
	}
				}else{
					$nominal_cashback = 0;
				}
				
			}else{
				if($cek_reposisi == 0){
					switch ($data->tingkat) {
						case '1':
							$nominal_cashback = 0;
							break;
						// case '2':
						// 	$nominal_cashback = 30000;
						// 	break;
						// case '3':
						// 	$nominal_cashback = 90000;
						// 	break;
						// case '4':
						// 	$nominal_cashback = 270000;
						// 	break;
						
						default:
							$nominal_cashback = 0;
							break;
					}
				}else{
					$nominal_cashback = 0;
				}
			}
			
			
			$cbs->set_nominal_cashback($nominal_cashback);
			$cbs->set_status_rekap('0');
			$cbs->set_status_transfer('0');
			$cbs->set_id_paket($jenis_paket);
			$cbs->set_id_paket_stokist($id_paket_stokist);
			$cbs->set_id_stokis($id);
			$cbs->set_jenis_cashback('0');
			// $cbs->create();
		}
	}
    
	if($insert){
		?>	
	    	<script language="javascript">
	    	    alert('Jual PIN Fasttrack Berhasil');
				document.location="../../?go=jual_pin_list_fasttrack&msg=penjualan&stat=1";
				
			</script>
		<?php
	}else{
		?>	
	    	<script language="javascript">
	    	alert('Jual PIN Fasttrack gagal');
				document.location="../../?go=jual_pin_list_fasttrack&msg=penjualan&stat=0";
			</script>
		<?php
	}
}else{
	?>	
    	<script language="javascript">
			document.location="../../?go=jual_pin_list";
		</script>
	<?php
}
