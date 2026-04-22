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

    

<?php
        
      // Query base
$sql = "SELECT articolo.*, reparto.descrizione as desReparto 
        FROM articolo 
        JOIN reparto ON articolo.id_reparto = reparto.id_reparto 
        JOIN iva ON articolo.id_iva = iva.id_iva 
        WHERE 1=1";
$msg= "Filtro = ";
// Applichiamo i filtri se inviati tramite POST
if (isset($_POST['btnFiltra'])) {
    if (!empty($_POST['id_articolo'])) {
        $cod = $_POST['id_articolo'];
        $sql .= " AND articolo.id_articolo = $cod";
        $msg.= " id_articolo = $cod ";
    }
    if (!empty($_POST['descrizione'])) {
        $des = ($_POST['descrizione']);
        $sql .= " AND articolo.descrizione LIKE '%$des%'";
        $msg.= " Descrizione = $des ";
    }
    if (!empty($_POST['ean'])) {
        $bar = $_POST['ean'];
        $sql .= " AND ean.id_ean LIKE '%$bar%'";
        $msg.= " Barcode = $bar ";
    }
    if (!empty($_POST['id_reparto'])) {
        $rep = $_POST['id_reparto'];
        $sql .= " AND articolo.id_reparto = $rep";
    }
}


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


        <?php
// Recupero tutti i reparti per la select del filtro
$sqlReparti = "SELECT id_reparto, descrizione FROM reparto ORDER BY descrizione";
$rsReparti = $db->query($sqlReparti);
?>
        <!-- form ricerca -->
        <div class="card mb-4 shadow-sm">
    <div class="card-body">
        <h5 class="card-title">Filtri di Ricerca</h5>
        <form action="" method="POST" >
            <div class="row g-3">
                <div class="col-md-2">
                    <input type="text" name="id_articolo" class="form-control" placeholder="Cod. Articolo" value="<?php echo $_POST['id_articolo'] ?? ''; ?>">
                </div>
                <div class="col-md-3">
                    <input type="text" name="descrizione" class="form-control" placeholder="Descrizione..." value="<?php echo $_POST['descrizione'] ?? ''; ?>">
                </div>
                <div class="col-md-2">
                    <input type="text" name="ean" class="form-control" placeholder="Barcode" value="<?php echo $_POST['ean'] ?? ''; ?>">
                </div>
                <div class="col-md-3">
                    <select name="id_reparto" class="form-select">
                        <option value="">Tutti i Reparti</option>
                        <?php while($rep = $rsReparti->fetch_assoc()): ?>
                            <option value="<?php echo $rep['id_reparto']; ?>" <?php echo (isset($_POST['id_reparto']) && $_POST['id_reparto'] == $rep['id_reparto']) ? 'selected' : ''; ?>>
                                <?php echo $rep['descrizione']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="btnFiltra" class="btn btn-primary w-100">Cerca</button>
                </div>
            </div>
        </form>
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
                    <th>Qta ORDINE</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                <?php echo "<form action =\"ordinato.php\" method=\"POST\">" ?>;
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
                    <td><input style="width: 100px;" Class="form-control" type="number" id="<?php echo $riga['id_articolo']; ?>" name="qta[<?php echo $riga['id_articolo']; ?>]"></td>  
                    
                    
                </tr>
                <?php } ?>
            </tbody>
        </table>
       <?php 
echo '<input class="btn btn-primary float-end" type="submit" value="Ordina" name="btnOrdina">'; 
?>
    </div>
</body>
</html>