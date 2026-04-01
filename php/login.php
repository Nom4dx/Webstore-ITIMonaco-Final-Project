<?php
require_once('database.php');
session_start();

$errore = "";
$user = "";
$password = "";
$php_base_url = dirname($_SERVER['PHP_SELF']);

if (isset($_SESSION['user'])) {
    header("Location: " . $php_base_url . "/home/");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new DataBase();

    if (isset($_POST['user'])) {
        $user = trim($_POST['user']);
    }

    if (isset($_POST['password'])) {
        $password = trim($_POST['password']);
    }

    if ($user == "" || $password == "") {
        $errore = "Compila tutti i campi";
    } elseif (!$db->connesso()) {
        $errore = "Errore di connessione al database";
    } else {
        $stmt = $db->prepare("SELECT username, nome, ruolo FROM utenti WHERE username = ? AND pwd = ?");

        if ($stmt) {
            if ($stmt->bind_param("ss", $user, $password)) {
                if ($stmt->execute()) {
                    $risultato = $stmt->get_result();

                    if ($risultato) {
                        if ($risultato->num_rows == 1) {
                            $info = $risultato->fetch_assoc();

                            $_SESSION['user'] = $info['username'];
                            $_SESSION['nome'] = $info['nome'];
                            $_SESSION['ruolo'] = $info['ruolo'];

                            header("Location: " . $php_base_url . "/home/");
                            exit();
                        } else {
                            $errore = "Username o password errati";
                        }
                    } else {
                        $errore = "Errore nel recupero dei dati";
                    }
                } else {
                    $errore = "Errore durante l'accesso";
                }
            } else {
                $errore = "Errore nei parametri della query";
            }

            $stmt->close();
        } else {
            $errore = "Errore nella preparazione della query";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center login-box">
            <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">
                <div class="card login-card p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h1 class="h3 mb-2">Login</h1>
                        <p class="text-secondary mb-0">Inserisci username e password</p>
                    </div>

                    <?php if ($errore != "") { ?>
                        <div class="alert alert-danger text-center">
                            <?php echo htmlspecialchars($errore); ?>
                        </div>
                    <?php } ?>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="user" class="form-label">Username</label>
                            <input type="text" class="form-control" id="user" name="user" value="<?php echo htmlspecialchars($user); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-login">Accedi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
