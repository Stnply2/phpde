<?php
require_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    
    // Setzen Sie den Standardbildpfad
    $imagePath = "uploads/defaultimage/defaultimage.png";

    // Überprüfen Sie, ob ein Bild hochgeladen wurde
    if (isset($_FILES["contact_image"]) && $_FILES["contact_image"]["error"] === UPLOAD_ERR_OK) {
        $uploadDir = "uploads/";
        $uploadFile = $uploadDir . basename($_FILES["contact_image"]["name"]);
        if (move_uploaded_file($_FILES["contact_image"]["tmp_name"], $uploadFile)) {
            $imagePath = $uploadFile; // Überschreiben Sie den Standardbildpfad, wenn ein Bild hochgeladen wird
        }
    }

    // Fügen Sie den Kontakt in die Datenbank ein
    $stmt = $pdo->prepare("INSERT INTO contacts (user_id, first_name, last_name, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $firstName, $lastName, $imagePath]);

    // Weiterleitung zur Hauptseite nach dem Hinzufügen des Kontakts
    header("Location: index.php");
    exit;
}
?>
