<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classBonusPasanganSetting.php';
    $mod_url = 'bonus_pasangan_setting';

    $obj = new classBonusPasanganSetting();
    
    $id_paket = addslashes(strip_tags($_POST['id_paket']));
    $max_pasangan = number($_POST['max_pasangan']);
    $nominal_bonus = number($_POST['nominal_bonus']);
    $updated_at = date('Y-m-d H:i:s');

    $obj->set_max_pasangan($max_pasangan);    
    $obj->set_nominal_bonus($nominal_bonus);    
    $obj->set_updated_at($updated_at);
    
    $update = $obj->update($id_paket);
    
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