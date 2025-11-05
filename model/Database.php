<?php
class Database {
    private static $instance = null;
    private $pdo;

    public function __construct() {
		if($_SERVER['SERVER_NAME'] == 'localhost'){
			$server  = 'localhost';		
			$database= 'netp7474_netlife_mlm';
			$user	 = 'root';	 
			$password= '';
		} else {
			$database= 'netp7474_netlife_mlm';
			$user	 = 'netp7474_netlife_mlm';	
			$password= 'indonesia2020';
		}

        try {
            $this->pdo = new PDO("mysql:host=$server;dbname=$database", $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}
