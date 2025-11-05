<?php
require_once ("classConnection.php");

class classSpinReward{
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
        $sql = "INSERT INTO mlm_spin_reward_winner ($columns) VALUES ($values)";
        
        // Koneksi ke database
        $c = new classConnection();
        
        // Jalankan query
        $query = $c->_query_insert($sql);
        
        return $query;
    }

	public function edit($id){
		$sql 	= "SELECT * from mlm_spin_reward_setting where id = '$id' and deleted_at is null";
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
        $sql = "UPDATE mlm_spin_reward_setting SET $columns_sql WHERE id = $id";
    
        // Koneksi ke database
        $c = new classConnection();
        $result = $c->_query($sql);  // Jalankan query langsung
    
        // Return hasil query
        return $result;
    }

	public function delete($id){
		$sql 	= "UPDATE mlm_spin_reward_setting set deleted_at='".date('Y-m-d H:i:s',time())."' where id='$id'";
		$c 		= new classConnection();
		$query 	= $c->_query($sql);
        return $query;
	}

	public function index(){

		$sql = "SELECT * from mlm_spin_reward_setting 
                 where deleted_at IS NULL 
                 order by id ASC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
	}

	public function show($id){

		$sql = "SELECT * from mlm_spin_reward_setting 
                 where id = '$id' 
                 AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query;
	}

    public function getRewards() {
        $sql = "SELECT s.id, s.reward, s.bobot, s.persentase_peluang, s.nominal, COUNT(w.id) AS total_winners 
                FROM mlm_spin_reward_setting s
                LEFT JOIN mlm_spin_reward_winner w ON s.id = w.id_spin_reward
                WHERE s.deleted_at IS NULL 
                  AND s.bobot > 0 
                  AND s.persentase_peluang > 0
                GROUP BY s.id, s.reward, s.bobot, s.persentase_peluang, s.nominal
                HAVING total_winners < s.bobot
                ORDER BY s.persentase_peluang DESC, s.bobot DESC";

        $c = new classConnection();
        $result = $c->_query($sql);

        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }
    
    public function riwayat_spin_reward($id_member, $start){
        $sql  = "SELECT *
                    FROM mlm_spin_reward_winner  
                    WHERE id_member = '$id_member' 
                    AND deleted_at is null
                    ORDER BY created_at DESC
                    LIMIT $start, 10";
                    // echo $sql;
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

}

?>