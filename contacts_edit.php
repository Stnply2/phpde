<?php
require_once('config.php');

// Session-Check und Umleitung, wenn nicht angemeldet
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Überprüfen Sie, ob eine Kontakt-ID übergeben wurde
if (!isset($_GET['id'])) {
    die("Keine Kontakt-ID angegeben.");
}

$contactId = $_GET['id'];

// Holen Sie sich die Kontaktinformationen aus der Datenbank
$stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
$stmt->execute([$contactId]);
$contact = $stmt->fetch();

// Prüfen Sie, ob der Kontakt existiert
if (!$contact) {
    die("Kontakt nicht gefunden.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kontakt bearbeiten</title>
    <!-- Hier können Sie zusätzliche CSS oder JavaScript-Dateien einbinden -->
</head>
<body>
    <div class="mdl-card mdl-shadow--2dp" style="margin: 2em; padding: 2em;">
        <h2>Kontakt bearbeiten</h2>
        <form action="update_contact.php" method="post" enctype="multipart/form-data">
            <!-- Die restlichen Formularelemente, ähnlich wie die in Ihrer contact_details.php, aber zur Bearbeitung -->
            <!-- ... -->
            <input type="hidden" name="id" value="<?php echo $contactId; ?>">
            <button type="submit" class="mdl-button mdl-js-button mdl-button--blue">Änderungen speichern</button>
        </form>
        <a href="contact_details.php?id=<?php echo $contactId; ?>">Zurück zu den Details</a>
    </div>
</body>
</html>
