<?php
class vendor_connectdb_model {
    private static $instance = null;
    private $conn;
 
    private function __construct() {
        $this->conn = null;
		$this->conn =  mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
 
        if ($this->conn->connect_error) {
            throw new Exception("Connection DB error!");
        }
    }
 
    private function __clone() {}
 
    public function __sleep() {}
 
    public function __wakeup() {}
 
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new vendor_connectdb_model();
        }
   
        return self::$instance;
    }
  
    public function getConnection() {
        return $this->conn;
    }
}
?>