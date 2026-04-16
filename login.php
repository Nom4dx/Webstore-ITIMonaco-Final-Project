<?php
require_once('database.php');
session_start();
   $errore = "";
  if($_SERVER["REQUEST_METHOD"]=='POST'){

              $db= new DataBase();

                $user = $_POST['user'];
                $password = $_POST['password'];

                $sql = "Select * from utenti where utente='$user' and password='$password'";

              $rs = $db->query($sql);
              if (!$rs) {
        die( "Errore nel database: la query è fallita.".$sql);
        }

              if($rs->num_rows==1){
                  
                      $info = $rs->fetch_assoc();

                      $_SESSION['utente']=$user;
                      $_SESSION['nome']= $info['nome'];
                      $_SESSION['ruolo']= $info['ruolo'];
                      header('Location:home.php');
                      exit();
              }else{

                  $errore="Username o password errati";
              }

              


  }
     

?>

<html>
<head>

<title>Home</title>
  <!-- CSS di Bootstrap -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 <!--
mt (Margin Top): Crea spazio sopra la scatola (la spinge giù).
mb (Margin Bottom): Crea spazio sotto la scatola (allontana quella che viene dopo).
ms (Margin Start - Sinistra): Spazio a sinistra.
me (Margin End - Destra): Spazio a destra.

Bootstrap vede lo schermo come una torta tagliata sempre in 12 fette uguali
Se scrivi col-md-12, prendi tutta la riga.
Se scrivi col-md-6, prendi metà schermo.

-->
</head>
<body>
  <div class="container mt-5"> <!-- sposta tutto più in basso-->
    <div class="mx-auto p-2"><!-- centra-->
        <div class="col-md-4"> <!-- utilizza 4 colonne di 12-->
                <form action="" method="POST" class="border p-4 shadow-sm rounded">
                  
                  <div class="mb-3">
                    <label class="form-label">user</label>
                    <input class="form-control" type="text" id="user" name="user">
                  </div>
                  <div class="mb-3">
                      <label class="form-label">password</label>
                      <input class="form-control" type="password" id="password" name="password">
                      
                  <div class="mb-3">
                     <div class="container mt-3">
                     <input class="btn btn-primary " type="submit" value="login" name="login"> 
                    </div >  
                    <?php if ($errore != ""): ?>
                        <div class="alert alert-danger text-center mt-3" role="alert">
                        <?php echo $errore; ?>
                        </div>
                    <?php endif; ?>
                    
                </form>

      </div>
    </div>
</div>


</body>

</html>