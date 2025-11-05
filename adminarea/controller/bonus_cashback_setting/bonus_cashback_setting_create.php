<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classBonusCashbackSetting.php';
    $mod_url = 'bonus_cashback_setting';

    $obj = new classBonusCashbackSetting();
    
    $id_peringkat = addslashes(strip_tags($_POST['id_peringkat']));
    $persentase_bonus = number($_POST['persentase_bonus']);
    $created_at = date('Y-m-d H:i:s');

    $obj->set_id_peringkat($id_peringkat);
    $obj->set_persentase_bonus($persentase_bonus);    
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