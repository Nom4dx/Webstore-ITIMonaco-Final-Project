<?php 

Class DataBase {
private $user = 'root';
private $password = 'disel';
private $server = '127.0.0.1';
private $nomedb = 'webstore';
private  $conn ;

  public Function __construct()
  {
    $this->conn = new mysqli($this->server,$this->user,$this->password,$this->nomedb);
    if ($this->conn->error){

    die("Errore nella connessione del server ".$this->conn->error);
    }
  }




    public Function query($sql){

    return $this->conn->query(($sql));
    }
    
    public Function EliminaUtente($user){
      $sql = "DELETE FROM utenti WHERE utente = '$user'";
      $this->conn->query(($sql));

    }

    public function NuovoUtente($user, $password, $nome, $email, $ruolo) {
    $sql = "INSERT INTO utenti (utente, password, nome, email, ruolo) 
            VALUES ('$user', '$password', '$nome', '$email', '$ruolo')";

    if ($this->conn->query($sql)) {
        return "Utente $user ($nome) inserito con successo!!";
    } else {
        return "Errore database: " . $this->conn->error;
    }
}
  }
















?>