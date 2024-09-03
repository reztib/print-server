<?php
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ergebnisse</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            width: 100%;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .message {
            font-size: 18px;
            color: #333;
        }
        .output {
            margin-top: 20px;
            padding: 10px;
            background-color: #e9ecef;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: left;
            white-space: pre-wrap; /* Erhält Zeilenumbrüche */
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ergebnisse</h1>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
            $file = $_FILES['file']['tmp_name'];
            $destination = '/var/www/html/print-server/uploads/' . basename($_FILES['file']['name']);

            if (move_uploaded_file($file, $destination)) {
                // Druckername und Befehl vorbereiten
                $printer = 'Canon_MG2500_series'; // Dein Druckername
                $command = escapeshellcmd("lp -d $printer " . escapeshellarg($destination));

                // Druckbefehl ausführen
                exec($command, $output, $return_var);

                echo "<div class='message'>Druckauftrag erfolgreich gesendet.</div>";
                echo "<div class='output'>";
                echo "Rückgabewert: " . htmlspecialchars($return_var) . "<br>";
                echo "Ausgabe:<br>" . htmlspecialchars(implode("\n", $output));
                echo "</div>";
            } else {
                echo "<div class='message'>Fehler beim Hochladen der Datei.</div>";
            }
        } else {
            echo "<div class='message'>Keine Datei hochgeladen.</div>";
        }
        ?>
        <a href="upload.html">Zurück zum Upload</a>
    </div>
</body>
</html>
