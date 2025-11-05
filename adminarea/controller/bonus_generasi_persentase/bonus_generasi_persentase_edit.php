<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classBonusGenerasiPersentase.php';
    $mod_url = 'bonus_generasi_persentase';

    $obj = new classBonusGenerasiPersentase();

    $id = $_POST['id'];
    $id_plan = number($_POST['id_plan']);
    $persentase = number($_POST['persentase']);
    $generasi = number($_POST['generasi']);
    $updated_at = date('Y-m-d H:i:s');

    $obj->set_id_plan($id_plan);    
    $obj->set_persentase($persentase);    
    $obj->set_generasi($generasi);
    $obj->set_updated_at($updated_at);
    
    $update = $obj->update($id);
    
    if($update){
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