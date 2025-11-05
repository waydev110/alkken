<?php 
require_once 'classConnection.php';

class classSaldoPenarikan {
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
		$sql 	= "SELECT p.*, a.nama_admin as penulis FROM mlm_saldo_penarikan as p LEFT JOIN mlm_admin as a ON p.id_admin = a.id WHERE p.deleted_at is null";
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
        $sql = "INSERT INTO mlm_saldo_penarikan ($columns) VALUES ($values)";
        // echo $sql;
        
        // Koneksi ke database
        $c = new classConnection();
        
        // Jalankan query
        $query = $c->_query_insert($sql);
        
        return $query;
    }
    

	public function show($id){
		$sql 	= "SELECT * from mlm_saldo_penarikan where id = '$id' and deleted_at is null";
		$c 		= new classConnection();
		$query 	= $c->_query_fetch($sql);
        return $query;
	}

	public function edit($id){
		$sql 	= "SELECT * from mlm_saldo_penarikan where id = '$id' and deleted_at is null";
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
        $sql = "UPDATE mlm_saldo_penarikan SET $columns_sql WHERE id = $id";
    
        // Koneksi ke database
        $c = new classConnection();
        $result = $c->_query($sql);  // Jalankan query langsung
    
        // Return hasil query
        return $result;
    }

	public function delete($id){
		$sql 	= "UPDATE mlm_saldo_penarikan set deleted_at='".date('Y-m-d H:i:s',time())."' where id='$id'";
		$c 		= new classConnection();
		$query 	= $c->_query($sql);
        return $query;
	}

    public function riwayat_saldo($jenis_saldo, $id){
        $sql = "SELECT 
                COALESCE(SUM(CASE 
                    WHEN w.status = 'd' 
                    THEN w.nominal
                    ELSE 0 
                END),0) AS debit,
                COALESCE(SUM(CASE 
                    WHEN w.status = 'k'
                    THEN w.nominal
                    ELSE 0 
                END),0) AS kredit,                
                COALESCE(SUM(CASE 
                    WHEN w.status = 'd' 
                    THEN w.nominal
                    ELSE 0 
                END) - SUM(CASE 
                    WHEN w.status = 'k'
                    THEN w.nominal
                    ELSE 0 
                END),0) AS sisa                
                FROM mlm_saldo_penarikan w
                WHERE w.id_member = '$id'
                AND CASE WHEN LENGTH('$jenis_saldo') > 0 THEN w.jenis_saldo = '$jenis_saldo' ELSE 1 END
                AND w.deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query;
    }

    public function ajax_wallet($id, $start, $jenis_saldo){
        $sql = "SELECT *
                FROM mlm_saldo_penarikan
                WHERE  id_member = '$id'
                AND CASE WHEN LENGTH('$jenis_saldo') > 0 THEN jenis_saldo = '$jenis_saldo' ELSE 1 END
                AND deleted_at IS NULL
                ORDER BY created_at DESC
                LIMIT $start, 10";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function cek_saldo_wd($id_member, $id_kodeaktivasi){
        $sql = "SELECT COUNT(*) AS total
                FROM mlm_saldo_penarikan
                WHERE id_member = '$id_member'
                AND id_kodeaktivasi = '$id_kodeaktivasi'
                AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }
}