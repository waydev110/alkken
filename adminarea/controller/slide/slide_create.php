<?php 
require_once '../../../helper/string.php';
require_once '../../../helper/image.php';
require_once '../../../model/classSlide.php';

if(isset($_POST['simpan_slide'])){
	$obj = new classSlide();
    $gambar = NULL;    
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

	$ordering = addslashes(strip_tags($_POST['ordering']));
	$publish_status = addslashes(strip_tags($_POST['publish_status']));
	$url = addslashes(strip_tags($_POST['url']));

	$obj->ordering = $ordering;
	$obj->gambar = $gambar;
	$obj->publish_status = $publish_status;
	$obj->url = $url;
	$obj->id_admin = $id_admin;

	$create = $obj->create();
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