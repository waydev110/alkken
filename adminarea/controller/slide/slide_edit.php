<?php 
require_once '../../../helper/string.php';
require_once '../../../helper/image.php';
require_once '../../../model/classSlide.php';
$obj = new classSlide();
if(isset($_POST['update_slide'])){
    $mod_url = 'slide';
    $dir = 'slide_show';
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
	$url = addslashes(strip_tags($_POST['url']));

    if($gambar){
        $obj->gambar = $gambar;
    }
	$obj->ordering = $ordering;
	$obj->publish_status = $publish_status;
	$obj->url = $url;
	$obj->id_admin = $id_admin;

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
}else{
	?>	
    	<script language="javascript">
			document.location="../../?go=<?=$mod_url?>";
		</script>
	<?php	
}