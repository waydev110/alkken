<?php 
    require_once '../../../helper/string.php';
    require_once '../../../model/classRekening.php';
    $mod_url = 'rekening';
    
    $obj = new classRekening();
	$id = addslashes(strip_tags($_POST['id']));
    $id_bank = addslashes(strip_tags($_POST['id_bank']));
    $atas_nama_rekening = addslashes(strip_tags($_POST['atas_nama_rekening']));
    $no_rekening = addslashes(strip_tags($_POST['no_rekening']));
    $cabang_rekening = addslashes(strip_tags($_POST['cabang_rekening']));
    $status = 1;
    $updated_at = date('Y-m-d H:i:s');

    $obj->set_id_bank($id_bank);
    $obj->set_atas_nama_rekening($atas_nama_rekening);
    $obj->set_no_rekening($no_rekening);    
    $obj->set_cabang_rekening($cabang_rekening);
    $obj->set_status($status);
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