<?php 
require_once '../../../helper/string.php';
require_once '../../../helper/image.php';
require_once '../../../model/classSlideCertificate.php';

if(isset($_POST['simpan_slide'])){
	$cp = new classSlideCertificate();
    $gambar = NULL;    
    $mod_url = 'slide_certificate';
    $dir = 'slide_certificate';

    if ($_FILES['gambar']['size'] <> 0){
        
        $gambar = save_image($_FILES['gambar'], $dir);
        if(!$gambar){
    		?>	
    	    	<script language="javascript">
    				document.location="../../?go=<?=$mod_url?>&msg=tambah&stat=0";
    			</script>
    		<?php	
        }
    }
    session_start();
    $id_admin = $_SESSION['id_login'];

	$ordering = addslashes(strip_tags($_POST['ordering']));
	$publish_status = addslashes(strip_tags($_POST['publish_status']));

	$cp->set_ordering($ordering);
	$cp->set_gambar($gambar);
	$cp->set_publish_status($publish_status);
	$cp->set_id_admin($id_admin);

	$create = $cp->create();
	if($create){
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
}else{
	?>	
    	<script language="javascript">
			document.location="../../?go=<?=$mod_url?>";
		</script>
	<?php	
}