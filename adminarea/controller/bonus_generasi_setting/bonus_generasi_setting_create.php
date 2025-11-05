<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classBonusGenerasiSetting.php';
    $mod_url = 'bonus_generasi_setting';

    $obj = new classBonusGenerasiSetting();
    
    $id_plan = number($_POST['id_plan']);
    $max = $_POST['max'];
    $created_at = date('Y-m-d H:i:s');

    $obj->set_id_plan($id_plan);    
    $obj->set_max($max);
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