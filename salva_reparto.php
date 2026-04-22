<?php 
require_once("database.php");

// Controllo se il codice reparto è presente
if (!isset($_POST["id_reparto"]) || $_POST["id_reparto"] == '') {
    header("Location: reparti.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $db = new DataBase();
    
    // Recupero dati e pulizia minima per SQL
    $id_reparto = $_POST["id_reparto"];
    $descrizione = str_replace("'", "''", $_POST["descrizione"]); // Gestisce l'apostrofo

    if (isset($_POST['azione'])) {
        if ($_POST['azione'] == 'inserisci') {
            $msg = InserisciReparto($db, $id_reparto, $descrizione);
        } elseif ($_POST['azione'] == 'modifica') {
            $msg = ModificaReparto($db, $id_reparto, $descrizione);
        }

        header("Location: reparti.php?msg=" . urlencode($msg));
        exit();
    }
}

function InserisciReparto($db, $id_reparto, $descrizione) {
    // 1. Controllo se esiste già
    $sql_check = "SELECT * FROM reparto WHERE id_reparto = '$id_reparto'";
    $rs = $db->query($sql_check);
    
    if ($rs && $rs->num_rows > 0) {
        return "Errore: Il codice reparto $id_reparto è già esistente.";
    }

    // 2. Inserimento
    $sql = "INSERT INTO reparto (id_reparto, descrizione) VALUES ('$id_reparto', '$descrizione')";
    $rs = $db->query($sql);

    if (!$rs) {
        return "Errore nell'inserimento: " . $sql;
    } else {
        return "Reparto $id_reparto inserito con successo!";
    }
}

function ModificaReparto($db, $id_reparto, $descrizione) {
    $sql = "UPDATE reparto 
            SET descrizione = '$descrizione' 
            WHERE id_reparto = '$id_reparto'";
    
    $rs = $db->query($sql);

    if (!$rs) {
        return "Errore nell'aggiornamento: " . $sql;
    } else {
        return "Reparto $id_reparto aggiornato con successo!";
    }
}
?>