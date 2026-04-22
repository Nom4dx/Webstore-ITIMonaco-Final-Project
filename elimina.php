<?php
require_once("database.php");
$db = new DataBase();
$user = $_GET['user'];
// echo $user;
// exit();
$sql = "DELETE FROM utenti WHERE utente = '$user'";
$db->query($sql);
$msg= "Utente Eliminato";
header("Location:utenti.php?msg=" . urlencode($msg)); 
?>