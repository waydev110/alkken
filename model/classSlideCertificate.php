<?php 
require_once 'classConnection.php';

class classSlideCertificate {
	private $gambar;
	private $ordering;
	private $publish_status;
	private $id_admin;

	public function get_gambar(){
		return $this->gambar;
	}

	public function set_gambar($gambar){
		$this->gambar = $gambar;
	}
    
	public function get_ordering(){
		return $this->ordering;
	}

	public function set_ordering($ordering){
		$this->ordering = $ordering;
	}   

	public function get_publish_status(){
		return $this->publish_status;
	}

	public function set_publish_status($publish_status){
		$this->publish_status = $publish_status;
	}

	public function get_id_admin(){
		return $this->id_admin;
	}

	public function set_id_admin($id_admin){
		$this->id_admin = $id_admin;
	}

	public function index(){
		$sql 	= "SELECT p.*, a.nama_admin as penulis FROM mlm_slide_certificate as p LEFT JOIN mlm_admin as a ON p.id_admin = a.id WHERE p.deleted_at is null";
		$c 		= new classConnection();
		$query 	= $c->_query($sql);
        return $query;
	}

	public function create(){
		$sql 	= "INSERT INTO mlm_slide_certificate(gambar, ordering, publish_status,created_at,id_admin) values ('".$this->get_gambar()."', '".$this->get_ordering()."', '".$this->get_publish_status()."', '".date('Y-m-d H:i:s', time())."', '".$this->get_id_admin()."')";
		$c 		= new classConnection();
		$query 	= $c->_query_insert($sql);
        return $query;
	}

	public function show($id){
		$sql 	= "SELECT * from mlm_slide_certificate where id = '$id' and deleted_at is null";
		$c 		= new classConnection();
		$query 	= $c->_query_fetch($sql);
        return $query;
	}

	public function edit($id){
		$sql 	= "SELECT * from mlm_slide_certificate where id = '$id' and deleted_at is null";
		$c 		= new classConnection();
		$query 	= $c->_query_fetch($sql);
        return $query;
	}

	public function update($id){
		$sql 	= "UPDATE mlm_slide_certificate set 
		ordering = '".$this->get_ordering()."', 
		publish_status = '".$this->get_publish_status()."', 
		id_admin = '".$this->get_id_admin()."',
		updated_at='".date('Y-m-d H:i:s',time())."'";
        if($this->get_gambar() <> NULL){
            $sql 	.= ",gambar = '".$this->get_gambar()."'";
        }
        $sql 	.= " where id='$id'";
		$c 		= new classConnection();
		$query 	= $c->_query($sql);
        return $query;
	}

	public function update_publish_status($id, $lokasi){
		$sql 	= "UPDATE mlm_slide_certificate set 
		publish_status = 'N' where id <> '$id' and lokasi = '$lokasi'";
		$c 		= new classConnection();
		$c->openConnection();
		$query 	= $c->koneksi->query($sql);
		if($query){
			return true;
		}else{
			return false;
		}
		$c->closeConnection();
	}

	public function delete($id){
		$sql 	= "UPDATE mlm_slide_certificate set deleted_at='".date('Y-m-d H:i:s',time())."' where id='$id'";
		$c 		= new classConnection();
		$query 	= $c->_query($sql);
        return $query;
	}
}