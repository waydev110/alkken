<?php 
require_once 'classConnection.php';

class classProvinsi{
	
	public function index(){
		$sql  = "SELECT * FROM mlm_provinsi WHERE nama_provinsi != '' ORDER BY nama_provinsi ASC";
		$c    = new classConnection();
		$query  = $c->_query($sql);
        return $query;
	}
}