<?php
class DataBase {
    private $host = "localhost";
    private $db_name = "ITIStore";
    private $username = "root";
    private $password = "root";
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
    }

    public function connesso() {
        if ($this->conn && $this->conn->connect_error == null) {
            return true;
        }

        return false;
    }

    public function query($sql){
        return $this->conn->query($sql);
    }

    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }


}
?>
