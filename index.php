<?php
/**
 * @file index.php
 * @brief Startseite des Print-Servers, auf der sich Benutzer anmelden können.
 *
 * Diese Seite dient als Login-Seite für den Print-Server. 
 * Angemeldete Benutzer werden automatisch zur Upload-Seite weitergeleitet.
 *
 * @details 
 * - Überprüft, ob der Benutzer bereits eingeloggt ist.
 * - Leitet eingeloggt Benutzer zur Upload-Seite weiter.
 */

session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    header('Location: upload.html');
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
    <div class="container">
        <h2>Login</h2>
        <form action="authenticate.php" method="post">
            <label for="username">Benutzername:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Passwort:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Anmelden">
        </form>
        <?php
        if (isset($_GET['error']) && $_GET['error'] == '1') {
            echo '<p class="error-messages">Ungültiger Benutzername oder Passwort.</p>';
        }
        ?>
    </div>
</body>
</html>
