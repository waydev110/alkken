<?php
error_reporting(~E_NOTICE);
date_default_timezone_set("Asia/Jakarta");
class classConnection{
	
	var $koneksi;
	
	public function closeConnection(){
		// mysqli_close($this->koneksi);
        $this->koneksi->close();
	}	
	
	public function openConnection(){
		if($_SERVER['SERVER_NAME'] == 'localhost'){
			$server  = 'localhost';		
			$database= 'alkken';
			$user	 = 'root';	 
			$password= '';
		} else {
			$database= 'alks7968_alkken';
			$user	 = 'alks7968_alkken';	
			$password= 'indonesia2020';
		}
		
		$this->koneksi = new mysqli($server, $user, $password, $database);

		if($this->koneksi->connect_errno){
			echo "Failed to connect to MySQL: (" . $this->koneksi->connect_errno . ") " . $this->koneksi->connect_error;
		}
	}

    public function _query($sql){    
        $this->openConnection();
        $query  = $this->koneksi->query($sql);
        $this->closeConnection();
        return $query;

    }

    public function _query_affected_rows($sql){    
        $this->openConnection();
    
        // Menjalankan query dan cek apakah berhasil
        if ($this->koneksi->query($sql) === TRUE) {
            $affectedRows = $this->koneksi->affected_rows; // Mengambil affected_rows dari koneksi
        } else {
            // Jika terjadi kesalahan, Anda dapat menangani error di sini
            $affectedRows = -1; // Misalnya, -1 jika terjadi error
        }
        
        $this->closeConnection();
        return $affectedRows;
    }

    public function _query_insert($sql){    
        $this->openConnection();
        $query  = $this->koneksi->query($sql);
		$insert_id = $this->koneksi->insert_id;
        $this->closeConnection();
        return $insert_id;

    }

    public function _query_fetch($sql){    
        $query  = $this->_query($sql);
		if($query){
			if($query->num_rows > 0){
				return $query->fetch_object();
			}
		}
		return false;
    }

    public function _query_assoc($sql){    
        $query  = $this->_query($sql);
		if($query){
			if($query->num_rows > 0){
				return $query->fetch_assoc();
			}
		}
		return false;
    }

    // Prepared statement method
    public function _queryPrepared($sql, $params, $types = null) {
        $this->openConnection();

        // Prepare statement
        if ($stmt = $this->koneksi->prepare($sql)) {
            // Bind parameters dynamically
            if (!empty($params)) {
                if ($types === null) {
                    // If no types are provided, assume all are strings
                    $types = str_repeat('s', count($params));
                }
                $stmt->bind_param($types, ...$params);
            }

            // Execute query
            $stmt->execute();
            $result = $stmt->get_result();

            $this->closeConnection();
            return $result;
        } else {
            echo "Prepare failed: (" . $this->koneksi->errno . ") " . $this->koneksi->error;
            return false;
        }
    }

    public function debugQuery($sql, $params) {
        foreach ($params as $key => $value) {
            $sql = preg_replace('/\?/', "'$value'", $sql, 1);
        }
        echo "Final query: " . $sql;
    }
	
}

?>
