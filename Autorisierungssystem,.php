
<?php

// Autorisierungssystem: Registrierung & Anmeldung (mit Sitzungen und Passwort-Hashing)

session_start();

// Datenbankverbindung (SQLite für Einfachheit)
$db = new PDO('sqlite:auth_system.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Tabelle erstellen, falls nicht vorhanden
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    password TEXT
)");

// Registrierung / reg
function register($username, $password) {
    global $db;
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    try {
        $stmt->execute([$username, $hash]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// Anmeldung
function login($username, $password) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        return true;
    }
    return false;
}

// Abmelden
function logout() {
    session_destroy();
}

// Registrierung und Anmeldung
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        $success = register($_POST['username'], $_POST['password']);
        echo $success ? "Registrierung erfolgreich!" : "Benutzername existiert bereits!";
    }
    if (isset($_POST['login'])) {
        $success = login($_POST['username'], $_POST['password']);
        echo $success ? "Anmeldung erfolgreich!" : "Falsche Zugangsdaten!";
    }
    if (isset($_POST['logout'])) {
        logout();
        echo "Abgemeldet!";
    }
}


if (isset($_SESSION['user'])) {
    echo "Angemeldet als: " . htmlspecialchars($_SESSION['user']);
}
?>

<!DOCTYPE html>
<html lang="de">
    <head>
    <meta charset="UTF-8">
    <title>Berechtigungssystem</title>
    <style>
        body {
            background: #000;
            color: #fff;
            font-family: Arial, sans-serif;
        }
        form {
            margin: 20px 0;
        }
        input, button {
            background: #222;
            color: #fff;
            border: 1px solid #444;
            padding: 8px;
            margin: 5px 0;
        }
        .msg { color: #0f0; }
    </style>
</head>
<form method="post">
    <h2>Registrierung</h2>
    <input name="username" placeholder="Benutzername" required>
    <input name="password" type="password" placeholder="Passwort" required>
    <button name="register">Registrieren</button>
</form>
<form method="post">
    <h2>Anmeldung</h2>
    <input name="username" placeholder="Benutzername" required>
    <input name="password" type="password" placeholder="Passwort" required>
    <button name="login">Anmelden</button>
</form>
<form method="post">
    <button name="logout">Abmelden</button>
</form>

</html>