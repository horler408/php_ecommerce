<?php 
    class Database {
        private $host = "localhost";
        private $db_name = "php_ecommerce_1";
        private $username = "root";
        private $password = "";

        public $conn; 

        public function getConnection() {
            $this->conn = null;

            try {
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            }catch(PDOException $e) {
                echo "Database connection error: " . $e->getMessage();
            }

            return $this->conn;
        }
    }
?>