<?php 
include 'header.php';
$db = new DataBase();
?>

<body>
<?php if (isset($_GET['msg'])) {
         $messaggio = $_GET['msg'];
            echo " 
            <div class=\"alert alert-success alert-dismissible\" role=\"alert\">
            $messaggio
            </div>
      ";
    } ?>

    <div class="card mb-4 border-info">
    <div class="card-header bg-info text-white">Carica Articoli da CSV</div>
    <div class="card-body">
        <form action="import_articoli_csv.php" method="POST" enctype="multipart/form-data">
            <div class="row align-items-end">
                <div class="col-md-6">
                    <label>Seleziona file .csv (Formato: CODART;DESCRIZIONE;UM;PRZACQ;PRZVEN;CODIVA;REP)</label>
                    <input type="file" name="fileCSV" class="form-control" accept=".csv" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-info text-white">Importa Dati</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
        $sql = "SELECT articoli.*,reparto.descrizione as desReparto FROM articoli,reparto,iva
        where 
        articoli.id_articolo = reparto.id_reparto
        and
        articoli.id = iva.id_iva 
        ";
        $rs = $db->query($sql);
        $totale_articoli = $rs->num_rows;
        ?>

        <div class="row mb-3">
            <div class="col-md-3">
                <div class="alert alert-info p-2" role="alert">
                    Totale Articoli = <?php echo $totale_articoli; ?>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th></th>
                    <th>Reparto</th>
                    <th>Codice</th>
                    <th>Descrizione</th>
                    <th>UM</th>
                    <th>Prz Acquisto</th>
                    <th>IVA</th>
                    <th>Prz Vendita</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                <?php while($riga = $rs->fetch_assoc()){ ?>
                <tr>

                    <td class="text-center">
                    <img src="http://cediperronesrl.com/index.php/site/image.html?coart=<?php echo $riga['codart']; ?>" 
                    alt="Foto" 
                    style="width: 50px; height: auto; border-radius: 4px; border: 1px solid #ddd;">
                    </a>
                    </td>
                    <td><?php echo $riga['desReparto']; ?></td>
                    <td><?php echo $riga['id_articolo']; ?></td>
                    <td><?php echo $riga['descrizione']; ?></td>
                    <td><?php echo $riga['unità_di_misura']; ?></td>
                    <td><?php echo $riga['prezzo_acquisto']; ?></td>
                    <td><?php echo $riga['id_iva']; ?></td>
                    <td><?php echo $riga['prezzo_vendita']; ?></td>  
                    
                    
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>