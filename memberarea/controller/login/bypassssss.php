<?php
if(isset($_GET['token']) &&  $_GET['token'] == md5('b15m1ll4h')){
	require_once '../../../model/classLoginMember.php';

	$obj = new classLoginMember();

	$_username = addslashes(strip_tags($_GET['var_usn']));
	$_password = addslashes(strip_tags($_GET['var_pwd']));

	$cek = $obj->CekLogin($_username, base64_decode($_password));
	if($cek > 0){
		$login = $obj->LoginSubmit($_username, base64_decode($_password), true);
		if($login){
			header("location:../../");
		}
	}else{
		echo "false";
	}	
}else{
	?>
	<script>
		window.location="../../../../"
	</script>
	<?php
}
