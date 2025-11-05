<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classBonusCashbackSetting.php';
    $mod_url = 'bonus_cashback_setting';

    $obj = new classBonusCashbackSetting();
    
    $id_peringkat = addslashes(strip_tags($_POST['id_peringkat']));
    $persentase_bonus = number($_POST['persentase_bonus']);
    $updated_at = date('Y-m-d H:i:s');

    $obj->set_persentase_bonus($persentase_bonus);    
    $obj->set_updated_at($updated_at);
    
    $update = $obj->update($id_peringkat);
    
    if($update){
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