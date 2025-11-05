<?php 
require_once 'classConnection.php';

class classPengumuman{
	private $judul;
	private $gambar;
	private $isi;
	private $lokasi;
	private $publish_start;
	private $publish_end;
	private $publish_status;
	private $id_admin;


	public function get_judul(){
		return $this->judul;
	}

	public function set_judul($judul){
		$this->judul = $judul;
	}

	public function get_gambar(){
		return $this->gambar;
	}

	public function set_gambar($gambar){
		$this->gambar = $gambar;
	}
    
	public function get_isi(){
		return $this->isi;
	}

	public function set_isi($isi){
		$this->isi = $isi;
	}    

	public function get_lokasi(){
		return $this->lokasi;
	}

	public function set_lokasi($lokasi){
		$this->lokasi = $lokasi;
	}
    
	public function get_publish_start(){
		return $this->publish_start;
	}

	public function set_publish_start($publish_start){
		$this->publish_start = $publish_start;
	}    

	public function get_publish_end(){
		return $this->publish_end;
	}

	public function set_publish_end($publish_end){
		$this->publish_end = $publish_end;
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
		$sql 	= "SELECT p.*, a.nama_admin as penulis FROM mlm_pengumuman as p LEFT JOIN mlm_admin as a ON p.id_admin = a.id WHERE p.deleted_at is null";
		$c 		= new classConnection();
		$c->openConnection();
		$query 	= $c->koneksi->query($sql);
		if($query){
			return $query;
		}else{
			return false;
		}
		$c->closeConnection();
	}

	public function create(){
		$sql 	= "INSERT INTO mlm_pengumuman(judul,gambar,isi,lokasi,publish_start,publish_end,publish_status,created_at,id_admin) values ('".$this->get_judul()."', '".$this->get_gambar()."', '".$this->get_isi()."', '".$this->get_lokasi()."', '".$this->get_publish_start()."', '".$this->get_publish_end()."', '".$this->get_publish_status()."', '".date('Y-m-d H:i:s', time())."', '".$this->get_id_admin()."')";
		$c 		= new classConnection();
		$c->openConnection();
		$query 	= $c->koneksi->query($sql);
		$last_id = $c->koneksi->insert_id;
		if($query){
			return $last_id;
		}else{
			return false;
		}
		$c->closeConnection();
	}

	public function show($id){
		$sql 	= "SELECT * from mlm_pengumuman where id = '$id' and deleted_at is null";
		$c 		= new classConnection();
		$c->openConnection();
		$query 	= $c->koneksi->query($sql);
		$data 	= $query->fetch_object();
		if($query){
			return $data;
		}else{
			return false;
		}
		$c->closeConnection();
	}

	public function edit($id){
		$sql 	= "SELECT * from mlm_pengumuman where id = '$id' and deleted_at is null";
		$c 		= new classConnection();
		$c->openConnection();
		$query 	= $c->koneksi->query($sql);
		$data 	= $query->fetch_object();
		if($query){
			return $data;
		}else{
			return false;
		}
		$c->closeConnection();
	}

	public function update($id){
		$sql 	= "UPDATE mlm_pengumuman set 
		judul = '".$this->get_judul()."', 
		isi = '".$this->get_isi()."', 
		lokasi = '".$this->get_lokasi()."', 
		publish_start = '".$this->get_publish_start()."', 
		publish_end = '".$this->get_publish_end()."', 
		publish_status = '".$this->get_publish_status()."', 
		id_admin = '".$this->get_id_admin()."',
		updated_at='".date('Y-m-d H:i:s',time())."'";
        if($this->get_gambar() <> NULL){
            $sql 	.= ",gambar = '".$this->get_gambar()."'";
        }
        $sql 	.= " where id='$id'";
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

	public function update_publish_status($id, $lokasi){
		$sql 	= "UPDATE mlm_pengumuman set 
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
		$sql 	= "UPDATE mlm_pengumuman set deleted_at='".date('Y-m-d H:i:s',time())."' where id='$id'";
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
}