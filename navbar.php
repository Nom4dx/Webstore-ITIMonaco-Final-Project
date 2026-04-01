<?php
require_once 'DataBase.php';
session_start();
$db = new DataBase();

if ($_SESSION["ruolo"] == "admin") {
    $gestione_utenti = '<a class="nav-item nav-link active" href="Utenti.php">Gestione Utenti</a>';
} else {
    $gestione_utenti = '<a class="nav-link disabled" aria-disabled="true">Gestione Utenti</a>';
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">
        <img src="web_logo.png" alt="Logo" width="90" height="90" class="d-inline-block align-top">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav" style="font-size:25px">
            <a class="nav-item nav-link active" href="home.php">Home</a>
            <a class="nav-item nav-link active" href="#">articoli</a>
            <?php echo $gestione_utenti ?>
            <a style="color: red;" class="nav-item nav-link active" href='logout.php'>Logout</a>
        </div>
    </div>
</nav>