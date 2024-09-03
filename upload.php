<?php
$target_dir = "uploads/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if(isset($_POST["submit"])) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "Die Datei ". basename( $_FILES["fileToUpload"]["name"]). " wurde hochgeladen.";
        exec("lp " . escapeshellarg($target_file));
        echo "Druckauftrag wurde gesendet.";
    } else {
        echo "Entschuldigung, es gab ein Problem beim Hochladen Ihrer Datei.";
    }
}
?>
