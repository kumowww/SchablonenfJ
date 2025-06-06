<?php
session_start();

// Dummy database (replace with real DB in production)
$usersFile = __DIR__ . '/users.json';
if (!file_exists($usersFile)) file_put_contents($usersFile, '{}');
$users = json_decode(file_get_contents($usersFile), true);

// Registrierung
if (isset($_POST['register'])) {
    $username = trim($_POST['reg_username']);
    $password = $_POST['reg_password'];
    if ($username && $password && !isset($users[$username])) {
        $users[$username] = password_hash($password, PASSWORD_DEFAULT);
        file_put_contents($usersFile, json_encode($users));
        $msg = "Registrierung erfolgreich. Bitte anmelden.";
    } else {
        $msg = "Benutzername existiert bereits oder ungültige Eingabe.";
    }
}

// Anmeldung
if (isset($_POST['login'])) {
    $username = trim($_POST['login_username']);
    $password = $_POST['login_password'];
    if (isset($users[$username]) && password_verify($password, $users[$username])) {
        $_SESSION['user'] = $username;
        $msg = "Anmeldung erfolgreich.";
    } else {
        $msg = "Falscher Benutzername oder Passwort.";
    }
}

// Abmeldung
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: Berechtigungssystem.php");
    exit;
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
<body>
    <h1>Berechtigungssystem</h1>
    <?php if (isset($msg)): ?>
        <div class="msg"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['user'])): ?>
        <p>Willkommen, <b><?= htmlspecialchars($_SESSION['user']) ?></b>!</p>
        <a href="?logout=1"><button>Abmelden</button></a>
    <?php else: ?>
        <h2>Registrierung</h2>
        <form method="post">
            <input type="text" name="reg_username" placeholder="Benutzername" required>
            <input type="password" name="reg_password" placeholder="Passwort" required>
            <button type="submit" name="register">Registrieren</button>
        </form>
        <h2>Anmeldung</h2>
        <form method="post">
            <input type="text" name="login_username" placeholder="Benutzername" required>
            <input type="password" name="login_password" placeholder="Passwort" required>
            <button type="submit" name="login">Anmelden</button>
        </form>
    <?php endif; ?>
</body>
</html>