<?php

require_once '../../../model/classSlide.php';

$obj = new classSlide();


if(isset($_POST['id'])){
	$id = base64_decode($_POST['id']);
	$deleted = $obj->delete($id);
	if($deleted){
		?>	
	    	<script language="javascript">
				document.location="../../?go=slide&msg=hapus&stat=1";
			</script>
		<?php	
	}else{
		?>	
	    	<script language="javascript">
				document.location="../../?go=slide&msg=hapus&stat=0";
			</script>
    	<?php
	}
	
}