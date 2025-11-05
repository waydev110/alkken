<?php 
require_once '../model/classMember.php';
require_once '../model/classLoginMember.php';
$cm = new classMember();
$obj = new classLoginMember();
$id = base64_decode($_GET['id']);
$data = $cm->show($id);
$id_member = $data->id_member;
$pass_member = $data->pass_member;
$login = $obj->LoginSubmit($id_member, base64_decode($pass_member), true);
if($login){
?>
<script>
    window.location = '../memberarea/';
</script>
<?php

}else{
	?>
	<?php
}

?>