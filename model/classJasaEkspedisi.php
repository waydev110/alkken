<?php 
/**
* 
*/
require_once 'classConnection.php';

class classJasaEkspedisi{
  private $jasa_ekspedisi;
  private $status;

#------------------------------------------------------------------------#
	public function get_jasa_ekspedisi(){
		return $this->jasa_ekspedisi;
	}

	public function set_jasa_ekspedisi($jasa_ekspedisi){
		$this->jasa_ekspedisi = $jasa_ekspedisi;
	}
#------------------------------------------------------------------------#
	public function get_kode_bank(){
		return $this->status;
	}

	public function set_status($status){
		$this->status = $status;
	}
#------------------------------------------------------------------------#


	public function index(){
        $sql ="SELECT * FROM mlm_jasa_ekspedisi WHERE status = '1'";
		$c 		= new classConnection();
		$query 	= $c->_query($sql);
        return $query;
  	}

	public function show($id){
		$sql 	= "SELECT * from mlm_jasa_ekspedisi where id = '$id'";
		$c 		= new classConnection();
		$query 	= $c->_query_fetch($sql);
        return $query;
	}
}