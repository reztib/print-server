<?php
session_start();

// Überprüfen, ob der Benutzer bereits eingeloggt ist
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    header('Location: upload.html'); // Weiterleitung zur Upload-Seite, wenn bereits eingeloggt
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Login</h2>
    <form action="authenticate.php" method="post">
        <label for="username">Benutzername:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Passwort:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Anmelden">
    </form>

    <?php
    // Zeigt eine Fehlermeldung an, wenn der Fehlerparameter in der URL vorhanden ist
    if (isset($_GET['error']) && $_GET['error'] == '1') {
        echo '<p style="color:red;">Ungültiger Benutzername oder Passwort.</p>';
    }
    ?>
</body>
</html>
