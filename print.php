<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file']['tmp_name'];
    $destination = '/var/www/html/print-server/uploads/' . basename($_FILES['file']['name']);

    if (move_uploaded_file($file, $destination)) {
        echo "Datei erfolgreich hochgeladen.<br>";
        $printer = 'Canon_MG2500_series'; // Dein Druckername
        $command = escapeshellcmd("lp -d $printer " . escapeshellarg($destination));
        echo "Auszuführender Befehl: $command<br>";
        exec($command, $output, $return_var);
        echo "Rückgabewert: $return_var<br>";
        echo "Ausgabe:<br>" . implode("<br>", $output);
    } else {
        echo "Fehler beim Hochladen der Datei.";
    }
} else {
    echo "Keine Datei hochgeladen.";
}
?>
