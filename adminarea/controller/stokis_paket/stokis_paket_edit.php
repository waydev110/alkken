<?php 
    require_once '../../../helper/string.php';
    require_once '../../../model/classStokisPaket.php';
    $mod_url = 'stokis_paket';
    
    $obj = new classStokisPaket();
	$id = addslashes(strip_tags($_POST['id']));
    $nama_paket = addslashes(strip_tags($_POST['nama_paket']));
    $kode_id = addslashes(strip_tags($_POST['kode_id']));
    $harga_paket = number($_POST['harga_paket']);
    $persentase_fee = number($_POST['persentase_fee']);
    $updated_at = date('Y-m-d H:i:s');
    
    $obj->set_nama_paket($nama_paket);
    $obj->set_kode_id($kode_id);
    $obj->set_harga_paket($harga_paket);
    $obj->set_persentase_fee($persentase_fee);
    $obj->set_updated_at($updated_at);

    $update = $obj->update($id);

    if($update){
        ?>	
            <script language="javascript">
                document.location="../../index.php?go=<?=$mod_url?>&msg=edit&stat=1";
            </script>
        <?php	
    }else{
        ?>	
            <script language="javascript">
                document.location="../../?go=<?=$mod_url?>&msg=edit&stat=0";
            </script>
        <?php
    }
?>