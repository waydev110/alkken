<?php 
require_once 'classConnection.php';

class classSlide {
    protected $attributes = [];

    // Magic method untuk mengakses properti
    public function __get($property) {
        if (array_key_exists($property, $this->attributes)) {
            return $this->attributes[$property];
        }
        return null;
    }

    // Magic method untuk mengatur properti
    public function __set($property, $value) {
        $this->attributes[$property] = $value;
    }

	public function index(){
		$sql 	= "SELECT p.*, a.nama_admin as penulis FROM mlm_slide_show as p LEFT JOIN mlm_admin as a ON p.id_admin = a.id WHERE p.deleted_at is null";
		$c 		= new classConnection();
		$query 	= $c->_query($sql);
        return $query;
	}

    public function create(){
        // Ambil kolom dan nilai dari atribut
        $columns = implode(", ", array_keys($this->attributes));
        
        // Buat array untuk menampung nilai yang telah disanitasi
        $sanitized_values = [];
        
        // Sanitasi nilai-nilai atribut
        foreach ($this->attributes as $value) {
            $sanitized_values[] = "'" . addslashes($value) . "'"; // Sanitasi dengan addslashes
        }
        
        // Gabungkan nilai-nilai tersebut untuk dimasukkan ke dalam query
        $values = implode(", ", $sanitized_values);
        
        // Query SQL untuk insert
        $sql = "INSERT INTO mlm_slide_show ($columns) VALUES ($values)";
        
        // Koneksi ke database
        $c = new classConnection();
        
        // Jalankan query
        $query = $c->_query_insert($sql);
        
        return $query;
    }
    

	public function show($id){
		$sql 	= "SELECT * from mlm_slide_show where id = '$id' and deleted_at is null";
		$c 		= new classConnection();
		$query 	= $c->_query_fetch($sql);
        return $query;
	}

	public function edit($id){
		$sql 	= "SELECT * from mlm_slide_show where id = '$id' and deleted_at is null";
		$c 		= new classConnection();
		$query 	= $c->_query_fetch($sql);
        return $query;
	}

    public function update($id) {
        // Array dari attributes yang ingin di-update
        $columns = [];
        foreach ($this->attributes as $key => $value) {
            // Buat query dengan menyisipkan nilai langsung
            // Pastikan nilai disanitasi dengan addslashes atau strip_tags jika perlu
            $safe_value = addslashes($value);
            $columns[] = "$key = '$safe_value'";
        }
        $columns_sql = implode(", ", $columns);
    
        // Query SQL untuk update
        $sql = "UPDATE mlm_slide_show SET $columns_sql WHERE id = $id";
    
        // Koneksi ke database
        $c = new classConnection();
        $result = $c->_query($sql);  // Jalankan query langsung
    
        // Return hasil query
        return $result;
    }
    

	public function update_publish_status($id, $lokasi){
		$sql 	= "UPDATE mlm_slide_show set 
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
		$sql 	= "UPDATE mlm_slide_show set deleted_at='".date('Y-m-d H:i:s',time())."' where id='$id'";
		$c 		= new classConnection();
		$query 	= $c->_query($sql);
        return $query;
	}
}