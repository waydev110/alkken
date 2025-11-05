<?php

require_once '../../../model/classMenu.php';

$cmenu = new classMenu();
$mod_url = 'menu_member';

if(isset($_POST['id'])){
	$id = base64_decode($_POST['id']);
    $deleted_at = date('Y-m-d H:i:s');
    $cmenu->deleted_at = $deleted_at;
	$deleted = $cmenu->update($id);
	if($deleted){
		?>	
	    	<script language="javascript">
				document.location="../../?go=<?=$mod_url?>&msg=hapus&stat=1";
			</script>
		<?php	
	}else{
		?>	
	    	<script language="javascript">
				document.location="../../?go=<?=$mod_url?>&msg=hapus&stat=0";
			</script>
    	<?php
	}
}else{
    ?>	
        <script language="javascript">
            document.location="../../?go=<?=$mod_url?>&msg=hapus&stat=0";
        </script>
    <?php
}