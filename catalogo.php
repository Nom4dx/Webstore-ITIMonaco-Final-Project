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
$sql = "SELECT articoli.*, reparto.descrizione as desReparto 
        FROM articoli 
        JOIN reparto ON articoli.codrep = reparto.codrep 
        JOIN iva ON articoli.codiva = iva.codiva 
        WHERE 1=1";
$msg= "Filtro = ";
// Applichiamo i filtri se inviati tramite POST
if (isset($_POST['btnFiltra'])) {
    if (!empty($_POST['codart'])) {
        $cod = $_POST['codart'];
        $sql .= " AND articoli.codart LIKE '%$cod%'";
        $msg.= " codart = $cod ";
    }
    if (!empty($_POST['descrizione'])) {
        $des = ($_POST['descrizione']);
        $sql .= " AND articoli.desart LIKE '%$des%'";
        $msg.= " Descrizione = $des ";
    }
    if (!empty($_POST['ean'])) {
        $bar = $_POST['ean'];
        $sql .= " AND articoli.barcode LIKE '%$bar%'";
        $msg.= " Descrizione = $des ";
    }
    if (!empty($_POST['codrep'])) {
        $rep = $_POST['codrep'];
        $sql .= " AND articoli.codrep = '$rep'";
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
$sqlReparti = "SELECT codrep, descrizione FROM reparto ORDER BY descrizione";
$rsReparti = $db->query($sqlReparti);
?>
        <!-- form ricerca -->
        <div class="card mb-4 shadow-sm">
    <div class="card-body">
        <h5 class="card-title">Filtri di Ricerca</h5>
        <form action="" method="POST" >
            <div class="row g-3">
                <div class="col-md-2">
                    <input type="text" name="codart" class="form-control" placeholder="Cod. Articolo" value="<?php echo $_POST['codart'] ?? ''; ?>">
                </div>
                <div class="col-md-3">
                    <input type="text" name="descrizione" class="form-control" placeholder="Descrizione..." value="<?php echo $_POST['descrizione'] ?? ''; ?>">
                </div>
                <div class="col-md-2">
                    <input type="text" name="ean" class="form-control" placeholder="Barcode" value="<?php echo $_POST['ean'] ?? ''; ?>">
                </div>
                <div class="col-md-3">
                    <select name="codrep" class="form-select">
                        <option value="">Tutti i Reparti</option>
                        <?php while($rep = $rsReparti->fetch_assoc()): ?>
                            <option value="<?php echo $rep['codrep']; ?>" <?php echo (isset($_POST['codrep']) && $_POST['codrep'] == $rep['codrep']) ? 'selected' : ''; ?>>
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
                    <td><?php echo $riga['codart']; ?></td>
                    <td><?php echo $riga['desart']; ?></td>
                    <td><?php echo $riga['um']; ?></td>
                    <td><?php echo $riga['przacq']; ?></td>
                    <td><?php echo $riga['codiva']; ?></td>
                    <td><?php echo $riga['przven']; ?></td>
                    <td><input style="width: 100px;" Class="form-control" type="number" id="<?php echo $riga['codart']; ?>" name="qta[<?php echo $riga['codart']; ?>]"></td> 
                    
                    
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