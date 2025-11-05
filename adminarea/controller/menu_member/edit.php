<?php 
if(isset($_POST['update'])){
    require_once '../../../helper/string.php';
    require_once '../../../helper/image.php';
    require_once '../../../model/classMenu.php';
	$cmenu = new classMenu();
    $gambar = NULL;    
    $mod_url = 'menu_member';
    $dir = 'icons';

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

	$id = addslashes(strip_tags($_POST['id']));
	$name = addslashes(strip_tags($_POST['name']));
	$id_kategori = number($_POST['id_kategori']);
	$home_menu = addslashes(strip_tags($_POST['home_menu']));
	$url = addslashes(strip_tags($_POST['url']));
	$ordering = number($_POST['ordering']);
	$show_netspin = number($_POST['show_netspin']);
    $updated_at = date('Y-m-d H:i:s');

    if($gambar) {
        $cmenu->icon = $gambar;
    }
	$cmenu->name = $name;
	$cmenu->id_kategori = $id_kategori;
	$cmenu->home_menu = $home_menu;
	$cmenu->url = $url;
	$cmenu->ordering = $ordering;
    $cmenu->show_netspin = $show_netspin;
	$cmenu->updated_at = $updated_at;

	$edit = $cmenu->update($id);
	if($edit){
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