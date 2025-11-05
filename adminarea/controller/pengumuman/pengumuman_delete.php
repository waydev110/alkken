<?php

require_once '../../../model/classPengumuman.php';

$obj = new classPengumuman();


if(isset($_POST['id'])){
	$id = base64_decode($_POST['id']);
	
	$deleted = $obj->delete($id);

	if($deleted){
		?>	
	    	<script language="javascript">
				document.location="../../?go=pengumuman_list&msg=hapus&stat=1";
			</script>
		<?php	
	}else{
		?>	
	    	<script language="javascript">
				document.location="../../?go=pengumuman_list&msg=hapus&stat=0";
			</script>
    	<?php
	}
	
}