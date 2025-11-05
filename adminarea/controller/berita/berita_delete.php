<?php

require_once '../../../model/classBerita.php';

$obj = new classBerita();


if(isset($_POST['id'])){
	$id = base64_decode($_POST['id']);
	
	$deleted = $obj->delete($id);

	if($deleted){
		?>	
	    	<script language="javascript">
				document.location="../../?go=berita_list&msg=hapus&stat=1";
			</script>
		<?php	
	}else{
		?>	
	    	<script language="javascript">
				document.location="../../?go=berita_list&msg=hapus&stat=0";
			</script>
    	<?php
	}
	
}