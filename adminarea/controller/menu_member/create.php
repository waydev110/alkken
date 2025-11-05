<?php 
if(isset($_POST['create'])){
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

	$name = addslashes(strip_tags($_POST['name']));
	$id_kategori = number($_POST['id_kategori']);
	$home_menu = addslashes(strip_tags($_POST['home_menu']));
	$url = addslashes(strip_tags($_POST['url']));
	$ordering = number($_POST['ordering']);
	$show_netspin = number($_POST['show_netspin']);
    $created_at = date('Y-m-d H:i:s');

	$cmenu->icon = $gambar;
	$cmenu->name = $name;
	$cmenu->id_kategori = $id_kategori;
	$cmenu->home_menu = $home_menu;
	$cmenu->url = $url;
	$cmenu->ordering = $ordering;
    $cmenu->show_netspin = $show_netspin;
	$cmenu->created_at = $created_at;

	$create = $cmenu->create();
	if($create){
		?>	
	    	<script language="javascript">
				document.location="../../?go=<?=$mod_url?>&msg=create&stat=1";
			</script>
		<?php	
	}else{
		?>	
	    	<script language="javascript">
				document.location="../../?go=<?=$mod_url?>&msg=create&stat=0";
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