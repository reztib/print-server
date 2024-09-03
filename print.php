<?php
session_start();

// Überprüfe, ob der Benutzer angemeldet ist
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Fehlerprotokollierung aktivieren
ini_set('display_errors', 0); // Fehler auf der Webseite nicht anzeigen
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Verzeichnisse und Log-Dateien
$uploadDir = '/var/www/html/print-server/uploads/';
$errorLogFile = '/var/www/html/print-server/errors/error_log.txt';
$printCommand = 'lp -d Canon_MG2500_series'; // Kommando für den Drucker

// Funktion zum Protokollieren von Fehlern
function log_error($message) {
    global $errorLogFile;
    $timestamp = date('Y-m-d H:i:s');
    $formattedMessage = "[{$timestamp}] {$message}" . PHP_EOL;
    file_put_contents($errorLogFile, $formattedMessage, FILE_APPEND);
}

// Erfolgsmeldung initialisieren
$successMessage = '';

// Verarbeite den Datei-Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['upload']) && $_FILES['upload']['error'] === UPLOAD_ERR_OK) {
    $uploadFile = $uploadDir . basename($_FILES['upload']['name']);

    // Verzeichnis erstellen, falls nicht vorhanden
    if (!file_exists($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            $errorMessage = 'Das Upload-Verzeichnis konnte nicht erstellt werden.';
            log_error($errorMessage);
            echo "<p>$errorMessage</p>";
            exit;
        }
    }

    try {
        // Datei verschieben
        if (!move_uploaded_file($_FILES['upload']['tmp_name'], $uploadFile)) {
            throw new Exception('Die Datei konnte nicht verschoben werden. Überprüfe die Verzeichnisberechtigungen.');
        }

        // Druckbefehl ausführen
        $printCommandResult = shell_exec($printCommand . ' ' . escapeshellarg($uploadFile));
        if ($printCommandResult === null) {
            throw new Exception('Fehler beim Drucken der Datei. Überprüfe die Drucker-Konfiguration.');
        }

        $successMessage = "Datei erfolgreich hochgeladen und zum Drucken bereitgestellt.";
        log_error("Datei erfolgreich hochgeladen und zum Drucker gesendet: " . $_FILES['upload']['name']);
    } catch (Exception $e) {
        $errorMessage = "Fehler: " . $e->getMessage();
        log_error($errorMessage);
        echo "<p>$errorMessage</p>";
    }
} else {
    if (isset($_FILES['upload']) && $_FILES['upload']['error'] !== UPLOAD_ERR_OK) {
        $errorMessage = 'Fehler beim Hochladen der Datei: ' . $_FILES['upload']['error'];
        log_error($errorMessage);
        echo "<p>$errorMessage</p>";
    }
}

// Erfolgsbereich anzeigen
if (!empty($successMessage)) {
    echo "<div class='success-message'>";
    echo "<p>" . htmlspecialchars($successMessage) . "</p>";
    echo "</div>";
}
?>
