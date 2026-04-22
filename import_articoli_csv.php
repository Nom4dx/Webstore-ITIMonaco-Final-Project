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
        $sql ="delete from  articoli ;";
  
        $db->query($sql);

       while($nrecord = fgets($file))
           {
             $riga = explode(";",$nrecord);

            
       
            $codice =  $riga[0] ;
            $descrizione =  $riga[1];
            $um =  $riga[2];
            $przacq =  $riga[3];
            $przven =  $riga[4];
            $codiva =  $riga[5];
            $codrep =  $riga[6];
                   
         echo $nrecord;
         echo "<br>";
       

          $sql ="INSERT INTO articoli (id_articolo, descrizione,unità_di_misura,prezzo_acquisto,prezzo_vendita,id_iva,id_reparto)
          VALUES ($codice, '$descrizione','$um',$przacq,$przven,$codiva,$codrep);";
  
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
        
          header("Location: articoli.php?msg=" . urlencode($msg));
          exit();

       }
    

    

?>