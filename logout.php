<?php 
session_start();
$_SESSION = array(); // svuota tutto
session_destroy();
 header('Location:login.php');





?>