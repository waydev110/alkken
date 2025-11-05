<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classAdmin.php';
    $mod_url = 'user';

    $obj = new classAdmin();
    $id = number($_POST['id']);
    $nama_admin = addslashes(strip_tags($_POST['nama_admin']));
    $user_admin = addslashes(strip_tags($_POST['user_admin']));
    $pass_admin = base64_encode($_POST['pass_admin']);
    $level_admin = number($_POST['level_admin']);
    $status_admin = number($_POST['status_admin']);
    $updated_at = date('Y-m-d H:i:s');

    $obj->set_nama_admin($nama_admin);
    $obj->set_user_admin($user_admin);    
    $obj->set_pass_admin($pass_admin);    
    $obj->set_level_admin($level_admin);    
    $obj->set_status_admin($status_admin);    
    $obj->set_updated_at($updated_at);
    
    $update = $obj->update($id);
    
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