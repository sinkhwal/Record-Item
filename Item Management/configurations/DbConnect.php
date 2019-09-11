<?php  
    class DbConnect { 
        public $error;
        public $conn; 
        public function __construct() {  
            require_once('config.php');  
            $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE); 
            
           // mysqli_select_db($conn,DB_DATABASE);  
            if($this->conn->connect_error)// testing the connection  
            {  
                die ("Cannot connect to the database");  
            }   
            return  $this->conn;  
        }
    
        public function Close(){  
            mysql_close();  
        }  
    }  
?> 