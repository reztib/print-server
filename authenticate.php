<?php
/**
 * @file authenticate.php
 * @brief Authentifiziert den Benutzer auf Grundlage der Umgebungsvariablen.
 *
 * Dieses Skript prüft den Benutzernamen und das Passwort, die in den Umgebungsvariablen gespeichert sind, 
 * und authentifiziert den Benutzer. Bei erfolgreicher Anmeldung wird der Benutzer zur Upload-Seite weitergeleitet. 
 * Andernfalls wird er zur Login-Seite mit einer Fehlermeldung zurückgeleitet.
 *
 * @details 
 * - Holt die Umgebungsvariablen für den Benutzernamen und das Passwort ab.
 * - Überprüft, ob der Benutzer authentifiziert ist.
 * - Leitet den Benutzer weiter basierend auf der Authentifizierung.
 */

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
