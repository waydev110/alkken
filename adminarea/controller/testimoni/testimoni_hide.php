<?php 
require_once '../../../model/classTestimoni.php';
if(isset($_POST['id_testimoni'])){
	$ct = new classTestimoni();
	
	$id_testimoni = $_POST['id_testimoni'];
	$approved = $_POST['approved'];
	
	$ct->set_approved($approved);
	$hide = $ct->hide($id_testimoni);
	
	if($hide){
	    echo json_encode(['status' => 'true', 'approved' => $approved]);
	} else {
	    echo json_encode(['status' => 'false', 'approved' => $approved]);
	}
}