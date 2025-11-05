<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classAdmin.php';
    $mod_url = 'user';

    $obj = new classAdmin();
    
    $nama_admin = addslashes(strip_tags($_POST['nama_admin']));
    $user_admin = addslashes(strip_tags($_POST['user_admin']));
    $pass_admin = base64_encode($_POST['pass_admin']);
    $level_admin = number($_POST['level_admin']);
    $status_admin = number($_POST['status_admin']);
    $created_at = date('Y-m-d H:i:s');

    $obj->set_nama_admin($nama_admin);
    $obj->set_user_admin($user_admin);    
    $obj->set_pass_admin($pass_admin);    
    $obj->set_level_admin($level_admin);    
    $obj->set_status_admin($status_admin);    
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