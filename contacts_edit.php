<?php
require_once('config.php'); // Einbinden der Konfigurationsdatei für Datenbankverbindung und andere Einstellungen

// Überprüfen, ob der Benutzer eingeloggt ist. Falls nicht, Weiterleitung zur Login-Seite
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Überprüfen, ob eine Kontakt-ID in der URL übergeben wurde. Falls nicht, Skript beenden
if (!isset($_GET['id'])) {
    die("Keine Kontakt-ID angegeben.");
}

// Speichern der übergebenen Kontakt-ID in einer Variablen
$contactId = $_GET['id'];

// Vorbereiten und Ausführen einer SQL-Abfrage, um den Kontakt mit der gegebenen ID aus der Datenbank zu holen
$stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
$stmt->execute([$contactId]);
$contact = $stmt->fetch();

// Überprüfen, ob der Kontakt in der Datenbank existiert. Falls nicht, Skript beenden
if (!$contact) {
    die("Kontakt nicht gefunden.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kontakt bearbeiten</title>
            <!-- Formular für das Aktualisieren des Kontakts -->
</head>
<body>
    <div class="mdl-card mdl-shadow--2dp" style="margin: 2em; padding: 2em;">
        <h2>Kontakt bearbeiten</h2>
        <form action="update_contact.php" method="post" enctype="multipart/form-data">
            <!-- Die restlichen Formularelemente, ähnlich wie die in Ihrer contact_details.php, aber zur Bearbeitung -->
            <!-- ... -->
            <input type="hidden" name="id" value="<?php echo $contactId; ?>">             <!-- Verstecktes Feld für die Kontakt-ID -->
            <button type="submit" class="mdl-button mdl-js-button mdl-button--blue">Änderungen speichern</button>  <!-- Button zum Speichern der Änderungen -->
        </form>
        <a href="contact_details.php?id=<?php echo $contactId; ?>">Zurück zu den Details</a>  <!-- Link zurück zu den Kontakt-Details -->
    </div>
</body>
</html>
