<?php
session_start();

// Benutzername und Passwort aus Umgebungsvariablen abrufen
$correctUsername = getenv('PRINT_SERVER_USERNAME');
$correctPassword = getenv('PRINT_SERVER_PASSWORD');

// Überprüfen, ob die Umgebungsvariablen gesetzt sind
if (!$correctUsername || !$correctPassword) {
    die('Benutzername und Passwort sind nicht korrekt konfiguriert.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $correctUsername && $password === $correctPassword) {
        $_SESSION['loggedin'] = true;
        header('Location: upload.html'); // Weiterleitung zur Upload-Seite
        exit;
    } else {
        // Weiterleitung zur Login-Seite mit Fehlerparameter
        header('Location: index.php?error=1');
        exit;
    }
} else {
    // Falls jemand versucht, direkt auf diese Seite zuzugreifen, wird er zur Login-Seite weitergeleitet
    header('Location: index.php');
    exit;
}
?>
