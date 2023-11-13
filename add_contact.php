<?php
require_once('config.php'); // Einbinden der Konfigurationsdatei für Datenbankverbindung und andere Einstellungen

// Überprüfen, ob das Formular abgesendet wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	    // Erfassen der eingegebenen Daten aus dem Formular
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    
    // Standardbildpfad, falls kein Bild hochgeladen wird
    $imagePath = "uploads/defaultimage/defaultimage.png";

    // Überprüfen Sie, ob ein Bild hochgeladen wurde
    if (isset($_FILES["contact_image"]) && $_FILES["contact_image"]["error"] === UPLOAD_ERR_OK) {
        $uploadDir = "uploads/";         // Festlegen des Verzeichnisses für hochgeladene Bilder
        $uploadFile = $uploadDir . basename($_FILES["contact_image"]["name"]);  // Erstellen des vollständigen Pfads für das hochgeladene Bild
        if (move_uploaded_file($_FILES["contact_image"]["tmp_name"], $uploadFile)) {   // Verschieben der hochgeladenen Datei in das Zielverzeichnis
            $imagePath = $uploadFile; // Überschreiben Sie den Standardbildpfad, wenn ein Bild erfolgreich hochgeladen wird
        }
    }

   // SQL-Abfrage vorbereiten, um den neuen Kontakt in die Datenbank einzufügen
    $stmt = $pdo->prepare("INSERT INTO contacts (user_id, first_name, last_name, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $firstName, $lastName, $imagePath]);  // Ausführen der Abfrage mit den eingegebenen und generierten Daten

   // Weiterleitung zur Hauptseite nach dem erfolgreichen Hinzufügen des Kontakts
    header("Location: index.php"); 
    exit;
}
?>
