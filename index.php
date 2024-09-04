<?php
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
