<?php
  
require_once("database.php");
if (!isset($_POST["user"] ) || $_POST["user"]==''  ){

header("Location: utenti.php");
exit();
}
     

if ($_SERVER["REQUEST_METHOD"]=='POST'){

    

   $user = $_POST["user"];
   $password = $_POST["password"];
   $nome = $_POST["nome"];
   $email = $_POST["email"];
   $ruolo = $_POST["ruolo"];
   //var_dump($_POST);
   if (isset($_POST['azione'])) {
        if ($_POST['azione'] == 'inserisci') {
            // Passiamo i dati direttamente alla funzione
          $msg =   Inserisci($user, $password, $nome, $email, $ruolo);
        } elseif ($_POST['azione'] == 'modifica') {
          $msg =   Modifica($user, $password, $nome, $email, $ruolo);
        }


        header("Location: utenti.php?msg=" . urlencode($msg));
    exit();

    }
}
  


function Inserisci ($user, $password, $nome, $email, $ruolo){
     $db = new DataBase;

   $sql = "Select * from utenti where utente = '$user'";

   $rs = $db->query($sql);
    
    if (!$rs)
        {
                 $msg= "Errore nell'esecuzione della query ".$sql;
        }
        else
        {
                if($rs->num_rows==1)
                    $msg = "  user $user già presente.";
                
        }

        $msg = $db->NuovoUtente($user,$password,$nome,$email,$ruolo);
        return $msg ;

       

}
function Modifica ($user, $password, $nome, $email, $ruolo){
     $db = new DataBase;
    
     $variabile = ($password == '') ? "" : "password = '$password',"; 
     
     $sql= "
        UPDATE utenti 
        SET ".$variabile." nome = '$nome', 
        email = '$email', 
        ruolo = '$ruolo' 
        WHERE utente = '$user';
     ";
     
     $rs = $db->query($sql);
    
    if (!$rs)
        {
                 $msg= "Errore nell'esecuzione della query ".$sql;
        }
        else
                $msg= "Utente $nome($user) aggiornato con successo!!";
     return $msg ;


}

?>



