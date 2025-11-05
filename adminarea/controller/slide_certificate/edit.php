<?php 
require_once '../../../helper/string.php';
require_once '../../../helper/image.php';
require_once '../../../model/classSlideCertificate.php';
$cp = new classSlideCertificate();
if(isset($_POST['update_slide'])){
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

	$id = base64_decode($_POST['id']);
	$ordering = addslashes(strip_tags($_POST['ordering']));
	$publish_status = addslashes(strip_tags($_POST['publish_status']));

	$cp->set_ordering($ordering);
    if($gambar){
        $cp->set_gambar($gambar);
    }
	$cp->set_publish_status($publish_status);
	$cp->set_id_admin($id_admin);

	$update = $cp->update($id);
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
}else{
	?>	
    	<script language="javascript">
			document.location="../../?go=<?=$mod_url?>";
		</script>
	<?php	
}