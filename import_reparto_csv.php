<?php
require_once("database.php");
$db = new DataBase();

       if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileCSV"])) {
        //var_dump($_FILES);
        // exit();

           $file = $_FILES["fileCSV"]["tmp_name"];
          

   if(file_exists($file))
   {
      $file = fopen($file,'r');
      if($file)
      {

      $numriga =1;
       while($nrecord = fgets($file))
           {
             $riga = explode(";",$nrecord);

            
       
            $codice =  $riga[0] ;
            $descrizione =  $riga[1];
                  

          $sql ="INSERT INTO reparto (id_reparto, descrizione)
          VALUES ($codice, '$descrizione')
          ON DUPLICATE KEY UPDATE descrizione = VALUES(descrizione);";
  
           $db->query($sql);

            $numriga++;
           }


           }
           fclose($file);
          
      }
      else
      {
       echo " Errore nell'apertura del file";


      }

        
         $msg = "Importazione completata: $numriga record inseriti.";
        
          header("Location: reparti.php?msg=" . urlencode($msg));
          exit();

       }
    

    

?>