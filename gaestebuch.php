
<?php
// Datei zum Speichern der Einträge
$filename = "gaestebuch.txt";

// Nachricht speichern
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['name']) && !empty($_POST['nachricht'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $nachricht = htmlspecialchars(trim($_POST['nachricht']));
    $eintrag = date("d.m.Y H:i") . " | " . "Name: " . $name . ": ". "Nachricht: " . $nachricht . "\n";
    file_put_contents($filename, $eintrag, FILE_APPEND);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Einträge laden
$eintraege = file_exists($filename) ? file($filename, FILE_IGNORE_NEW_LINES) : [];
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Gästebuch</title>
</head>
<body>
    <h1>Gästebuch</h1>
    <form method="post">
        Name: <input type="text" name="name" required><br>
        Nachricht:<br>
        <textarea name="nachricht" rows="4" cols="40" required></textarea><br>
        <button type="submit">Absenden</button>
    </form>
    <h2>Einträge</h2>
    <div>
        <?php if (empty($eintraege)): ?>
            <p>Noch keine Einträge.</p>
        <?php else: ?>
            <?php foreach (array_reverse($eintraege) as $eintrag): ?>
                <div style="border-bottom:1px solid #ccc; margin-bottom:10px; padding-bottom:5px;">
                    <?= nl2br($eintrag) ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>