<?php 

require_once 'classConnection.php';



class classSlideShow {

	public function index(){

		$sql 	= "SELECT p.*, a.nama_admin as penulis FROM mlm_slide_show as p LEFT JOIN mlm_admin as a ON p.id_admin = a.id WHERE p.publish_status = 'Y' and p.deleted_at is null ORDER BY p.ordering ASC";
		$c 		= new classConnection();
		$query 	= $c->_query($sql);
		return $query;

	}

}