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

    public function query($sql){
        return $this->conn->query($sql);
    }

    public function eliminazione($del_user){
        $sql_del = "DELETE FROM utenti WHERE utente='$del_user'";
        $this->query($sql_del);
    }
    public function modifica($utente, $password, $email, $nome, $ruolo){
        $sql_mod = "UPDATE utenti SET password='$password', email='$email', nome='$nome', ruolo='$ruolo' WHERE utente='$utente'";
        $this->query($sql_mod);
    }

}
?>
