<?php
require_once('config.php'); // Einbinden der Konfigurationsdatei

if (isset($_GET["id"])) {  // Überprüfen, ob eine ID über GET-Anfrage übermittelt wurde
    $id = $_GET["id"];     // Zuweisen der übermittelten ID zu einer Variablen

    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");  // Vorbereiten des SQL-Statements zum Löschen des Kontakts
    $stmt->execute([$id]);     // Ausführen des SQL-Statements mit der übermittelten ID


    // Weiterleitung zurück zur Hauptseite nach dem Löschen
    header("Location: index.php");
    exit; // Beenden des Skripts, um weitere Ausführungen zu verhindern
}
?>
