<?php
session_start();

// Beispiel-Benutzername und Passwort
$correctUsername = 'admin';
$correctPassword = 'password123';

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
