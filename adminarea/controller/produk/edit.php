<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classProduk.php';
    $mod_url = 'produk';

    $obj = new classProduk();
    $nama_produk = addslashes(strip_tags($_POST['nama_produk']));
    $gambar_sebelumnya = $_POST['gambar_sebelumnya'];
    $slug = slug($nama_produk).rand(10, 99);

    if ($_FILES['gambar']['size'] <> 0){
        $ekstensi_diperbolehkan	= array('png','jpg','jpeg');
        $nama_file = $_FILES['gambar']['name'];
        $x = explode('.', $nama_file);
        $ekstensi = strtolower(end($x));
        $ukuran	= $_FILES['gambar']['size'];
        $file_tmp = $_FILES['gambar']['tmp_name'];
        $new_filename = $slug.'.'.$ekstensi;
        $targetDir = '../../../images/produk/';
        $path = $targetDir.$new_filename;
        
        // Pastikan folder upload ada atau buat jika tidak ada
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){	
            move_uploaded_file($file_tmp, $path);
            $gambar = $new_filename;
        }else{
    		?>	
    	    	<script language="javascript">
    				document.location="../../?go=<?=$mod_url?>&msg=edit&stat=0";
    			</script>
    		<?php	
        }
    }
    
    $id = addslashes(strip_tags($_POST['id']));
    $id_produk_jenis = number($_POST['id_produk_jenis']);
    $harga = number($_POST['harga']);
    $nilai_produk = number($_POST['nilai_produk']);
    
    $hpp = number($_POST['hpp']);
	$qty = addslashes(strip_tags($_POST['qty']));
	$satuan = addslashes(strip_tags($_POST['satuan']));
    $keterangan = $_POST['keterangan'];
    $bonus_sponsor = number($_POST['bonus_sponsor']);
    $bonus_cashback = number($_POST['bonus_cashback']);
    $bonus_generasi = number($_POST['bonus_generasi']);
    $bonus_upline = number($_POST['bonus_upline']);
    $poin_reward = number($_POST['poin_reward']);
    $poin_pasangan = number($_POST['poin_pasangan']);
    // $fee_stokis = number($_POST['fee_stokis']);
    $fee_founder = number($_POST['fee_founder']);
    $tampilkan = number($_POST['tampilkan']);
    $updated_at = date('Y-m-d H:i:s');

    if(isset($gambar)){
        $obj->set_gambar($gambar);
    } else {
        $obj->set_gambar($gambar_sebelumnya);
        
    }
    $obj->set_id_produk_jenis($id_produk_jenis);
    $obj->set_nama_produk($nama_produk);
	$obj->set_slug($slug);
    $obj->set_harga($harga);    
    $obj->set_nilai_produk($nilai_produk);    
    $obj->set_poin_pasangan($poin_pasangan);   
    $obj->set_poin_reward($poin_reward);    
    $obj->set_bonus_sponsor($bonus_sponsor);   
    $obj->set_bonus_cashback($bonus_cashback);   
    $obj->set_bonus_generasi($bonus_generasi);    
    $obj->set_bonus_upline($bonus_upline);    
    // $obj->set_fee_stokis($fee_stokis);   
    $obj->set_fee_founder($fee_founder);   
	$obj->set_qty($qty);
	$obj->set_satuan($satuan);
    $obj->set_hpp($hpp);
    $obj->set_keterangan($keterangan);
    $obj->set_tampilkan($tampilkan);
    $obj->set_updated_at($updated_at);
    
    $update = $obj->update($id);
    
    if($update){
        if(isset($_POST['produk_plan'])){
            $produk_plan = $_POST['produk_plan'];
            $obj->insertOrUpdateAndDelete($produk_plan, $id);
        }
    	?>	
        	<script language="javascript">
    			document.location="../../?go=<?=$mod_url?>&msg=edit&stat=1";
    		</script>
    	<?php	
    }else{
    	?>	
        	<script language="javascript">
    			document.location="../../?go=<?=$mod_url?>&msg=edit&stat=0";
    		</script>
    	<?php
    }