<?php 
require_once 'classConnection.php';

class classBerita {
	private $judul;
	private $slug;
	private $gambar;
	private $isi;
	private $publish_status;
	private $id_admin;


	public function get_judul(){
		return $this->judul;
	}

	public function set_judul($judul){
		$this->judul = $judul;
	}
	public function get_slug(){
		return $this->slug;
	}

	public function set_slug($slug){
		$this->slug = $slug;
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
		$sql 	= "SELECT p.*, a.nama_admin as penulis FROM mlm_berita as p LEFT JOIN mlm_admin as a ON p.id_admin = a.id WHERE p.deleted_at is null";
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
		$sql 	= "INSERT INTO mlm_berita(slug,judul,gambar,isi, publish_status,created_at,id_admin) values ('".$this->get_slug()."', '".$this->get_judul()."', '".$this->get_gambar()."', '".$this->get_isi()."', '".$this->get_publish_status()."', '".date('Y-m-d H:i:s', time())."', '".$this->get_id_admin()."')";
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
		$sql 	= "SELECT * from mlm_berita where id = '$id' and deleted_at is null";
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
		$sql 	= "SELECT * from mlm_berita where id = '$id' and deleted_at is null";
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
		$sql 	= "UPDATE mlm_berita set 
		judul = '".$this->get_judul()."', 
		slug = '".$this->get_slug()."', 
		isi = '".$this->get_isi()."',  
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
		$sql 	= "UPDATE mlm_berita set 
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
		$sql 	= "UPDATE mlm_berita set deleted_at='".date('Y-m-d H:i:s',time())."' where id='$id'";
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

	public function dashboard(){
		$sql 	= "SELECT b.*, a.nama_admin as penulis FROM mlm_berita as b LEFT JOIN mlm_admin as a ON b.id_admin = a.id WHERE publish_status = 'Y' and b.deleted_at is null ORDER BY b.created_at DESC LIMIT 3";
		$c 		= new classConnection();
		$query 	= $c->_query($sql);
		return $query;
	}
	public function index_member(){
		$sql 	= "SELECT b.*, a.nama_admin as penulis FROM mlm_berita as b LEFT JOIN mlm_admin as a ON b.id_admin = a.id WHERE publish_status = 'Y' and b.deleted_at is null ORDER BY b.created_at DESC";
		$c 		= new classConnection();
		$query 	= $c->_query($sql);
		return $query;
	}

	public function show_member($slug){
		$sql 	= "SELECT * from mlm_berita where slug = '$slug' and publish_status = 'Y' and deleted_at is null";
		$c 		= new classConnection();
		$query 	= $c->_query_fetch($sql);
		return $query;
	}
}