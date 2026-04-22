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

    }
     

?>
    <div class="container mt-4">
        <div class="card mb-4">
            <div class="card-header">Gestione Utente</div>
            <div class="card-body">
                <form id="formUtente" action="salva_utente.php" method="POST">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label>Username (ID)</label>
                            <input type="text" name="user" id="user" class="form-control" >
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>password</label>
                            <input type="password" name="password" id="password" class="form-control" >
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Nome</label>
                            <input type="text" name="nome" id="nome" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Ruolo</label>
                            <select name="ruolo" id="ruolo" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
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

        <?php
        $sql = "select * from utenti";
        $rs = $db->query($sql);
        /* per prova       
        $riga = $rs->fetch_assoc();
        var_dump($riga);
        exit();
         */
        $Totale_utenti = $rs->num_rows;
        ?>

        <div class="row mb-3">
            <div class="col-md-3">
                <div class="alert alert-success p-2" role="alert">
                    Totale Utenti = <?php echo $Totale_utenti; ?>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>User</th><th>Nome</th><th>Email</th><th>Ruolo</th><th>Azione</th>
                </tr>
            </thead>
            <tbody>
                <?php while($riga = $rs->fetch_assoc()){ ?>
                <tr>
                    <td><?php echo $riga['utente']; ?></td>
                    <td><?php echo $riga['nome']; ?></td>
                    <td><?php echo $riga['email']; ?></td>
                    <td><?php echo $riga['ruolo']; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" 
                                onclick="caricaDati('<?php echo $riga['utente']; ?>', '<?php echo $riga['nome']; ?>', '<?php echo $riga['email']; ?>', '<?php echo $riga['ruolo']; ?>')">
                            Modifica
                        </button>
                        <button class="btn btn-danger btn-sm" 
                                onclick="eliminaUtente('<?php echo $riga['utente']; ?>')">
                            Elimina
                        </button>
                    </td>
                </tr>
                <?php }; ?>
            </tbody>
        </table>
    </div>

    <script>
    // Funzione per portare i dati dalla tabella al form sopra
    function caricaDati(user, nome, email, ruolo) {
        document.getElementById('user').value = user;
        document.getElementById('nome').value = nome;
        document.getElementById('email').value = email;
        document.getElementById('ruolo').value = ruolo;
        // Rendiamo lo username readonly durante la modifica  è la chiave primaria non può essere modificata
        document.getElementById('user').setAttribute('readonly', true);
    }

    function pulisciForm() {
        document.getElementById('user').removeAttribute('readonly');
    }

    // Funzione per eliminazione con conferma
    function eliminaUtente(user) {
        if (confirm("Sei sicuro di voler eliminare l'utente " + user + "?")) {
            
            window.location.href = "elimina.php?user=" + user;
        }
    }
    </script>
</body>
</html>