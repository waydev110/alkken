<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classRekening.php';
    $mod_url = 'rekening';

    $obj = new classRekening();
    
    $id_bank = addslashes(strip_tags($_POST['id_bank']));
    $atas_nama_rekening = addslashes(strip_tags($_POST['atas_nama_rekening']));
    $no_rekening = addslashes(strip_tags($_POST['no_rekening']));
    $cabang_rekening = addslashes(strip_tags($_POST['cabang_rekening']));
    $status = 1;
    $created_at = date('Y-m-d H:i:s');

    $obj->set_id_bank($id_bank);
    $obj->set_atas_nama_rekening($atas_nama_rekening);
    $obj->set_no_rekening($no_rekening);    
    $obj->set_cabang_rekening($cabang_rekening);
    $obj->set_status($status);
    $obj->set_created_at($created_at);
    
    $create = $obj->create();
    
    if($create){
    	?>	
        	<script language="javascript">
    			document.location="../../?go=<?=$mod_url?>&msg=tambah&stat=1";
    		</script>
    	<?php	
    }else{
    	?>	
        	<script language="javascript">
    			document.location="../../?go=<?=$mod_url?>&msg=tambah&stat=0";
    		</script>
    	<?php
    }