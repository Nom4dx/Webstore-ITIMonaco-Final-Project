<?php 
require_once('database.php');
session_start();

if(isset($_SESSION['user'])){
 $user = $_SESSION['user'];
 }
//  else
//     {
//         header ('location:login.php');
//     }
 if(isset($_SESSION['nome']))
    $nome = $_SESSION['nome'];

 if(isset($_SESSION['ruolo']))
    $ruolo = $_SESSION['ruolo'];

 if($ruolo == "admin")
  // verifico se admin non disabilito il link
     $nav_link = "class=\"nav-link \"" ;
    else
  // se non è admin disabilito i link 
    $nav_link=$isadmin = "class=\"nav-link disabled\" aria-disabled=\"true\"";

   


?>
<html>
    <head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- As a link -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="home.php"><?php echo "$nome ($ruolo)";?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
         <li class="nav-item">
         
          <a <?php echo $nav_link;?> href="utenti.php">Gestione Utenti</a>
        </li>
         <li class="nav-item">
          <a <?php echo $nav_link;?> href="reparti.php">Gestione reparti</a>
        </li>
        <li class="nav-item">
          <a <?php echo $nav_link;?> href="articoli.php">Gestione Articoli</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="catalogo.php">Catalogo prodotti</a>
        </li>
            
      </ul>
        <!-- fuori dal "ul" con ms-auto va a destra-->
        <button type="button" class="btn btn-light ms-auto" onclick="logout()">
        Logout (<?php echo "$nome ($ruolo)"; ?>)
        </button>
    </div>
  </div>
</nav>

</head>


<script>
function logout() {
    if (confirm("Sei sicuro di voler uscire?")) {
        // Reindirizza al file PHP che distrugge la sessione
        window.location.href = "logout.php";
    }
}
</script>



