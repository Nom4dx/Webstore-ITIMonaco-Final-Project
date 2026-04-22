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

    <div class="container mt-4">
        <div class="card mb-4">
            <div class="card-header">Gestione Reparto</div>
            <div class="card-body">
                <form id="formReparto" action="salva_reparto.php" method="POST">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Codice Reparto (ID)</label>
                            <input type="text" name="codrep" id="codrep" class="form-control" required>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label>Descrizione</label>
                            <input type="text" name="descrizione" id="descrizione" class="form-control" required>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" name="azione" value="inserisci" class="btn btn-primary">Inserisci Nuovo</button>
                        <button type="submit" name="azione" value="modifica" class="btn btn-warning">Salva Modifica</button>
                        <button type="reset" class="btn btn-secondary" onclick="pulisciForm()">Annulla</button>
                    </div>
                </form>
            </div>
        </div>
<!-- per importare da csv -->
        <div class="card mb-4 border-info">
    <div class="card-header bg-info text-white">Carica Reparti da CSV</div>
    <div class="card-body">
        <form action="import_reparto_csv.php" method="POST" enctype="multipart/form-data">
            <div class="row align-items-end">
                <div class="col-md-6">
                    <label>Seleziona file .csv (Formato: codrep;descrizione)</label>
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
        $sql = "SELECT * FROM reparto";
        $rs = $db->query($sql);
        $totale_reparti = $rs->num_rows;
        ?>

        <div class="row mb-3">
            <div class="col-md-3">
                <div class="alert alert-info p-2" role="alert">
                    Totale Reparti = <?php echo $totale_reparti; ?>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>Codice</th>
                    <th>Descrizione</th>
                    <th style="width: 200px;">Azione</th>
                </tr>
            </thead>
            <tbody>
                <?php while($riga = $rs->fetch_assoc()){ ?>
                <tr>
                    <td><?php echo $riga['id_reparto']; ?></td>
                    <td><?php echo $riga['descrizione']; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" 
                                onclick="caricaDati('<?php echo addslashes($riga['id_reparto']); ?>', '<?php echo addslashes($riga['descrizione']); ?>')">
                            Modifica
                        </button>
                        <button class="btn btn-danger btn-sm" 
                                onclick="eliminaReparto('<?php echo addslashes($riga['id_reparto']); ?>')">
                            Elimina
                        </button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
    function caricaDati(id_reparto, descrizione) {
        document.getElementById('id_reparto').value = id_reparto;
        document.getElementById('descrizione').value = descrizione;
        // Impedisce la modifica del codice reparto (chiave primaria) in fase di update
        document.getElementById('id_reparto').setAttribute('readonly', true);
    }

    function pulisciForm() {
        document.getElementById('id_reparto').removeAttribute('readonly');
    }

    function eliminaReparto(id_reparto) {
        if (confirm("Sei sicuro di voler eliminare il reparto " + id_reparto + "?")) {
            window.location.href = "elimina_reparto.php?id_reparto=" + id_reparto;
        }
    }
    </script>
</body>
</html>