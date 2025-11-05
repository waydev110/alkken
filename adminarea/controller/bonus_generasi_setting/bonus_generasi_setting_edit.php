<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classBonusGenerasiSetting.php';
    $mod_url = 'bonus_generasi_setting';

    $obj = new classBonusGenerasiSetting();

    $id = $_POST['id'];
    $id_plan = number($_POST['id_plan']);
    $max = $_POST['max'];
    $updated_at = date('Y-m-d H:i:s');

    $obj->set_id_plan($id_plan);    
    $obj->set_max($max);
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