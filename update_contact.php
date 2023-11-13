<head>
  
    <style>
        .mdl-button--colored {
            background-color: #009688; /* Wählen Sie eine Farbe, die zu Ihrem Design passt */
            color: white;
        }

        .mdl-button--colored:hover {
            background-color: #00796b; /* Dunklere Farbe für Hover-Effekt */
        }
		    .error-message {
        color: red; /* Rot für Fehlermeldungen */
        margin-bottom: 10px; /* Etwas Abstand unter der Nachricht */
        font-weight: bold; /* Optional: Text fett machen */
    }
    </style>
	
	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

</head>


<?php
// Fehlerberichterstattung aktivieren
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php'); // Einbinden der Konfigurationsdatei

// Überprüfen, ob der Benutzer eingeloggt ist, sonst Weiterleitung zur Login-Seite
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Überprüfen, ob die Anfrage eine POST-Anfrage ist
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Überprüfen, ob alle erforderlichen Felder gesetzt sind
    if (isset($_POST['id'], $_POST['postal_code'], $_POST['street'], $_POST['house_number'], $_POST['city'], $_POST['first_name'], $_POST['last_name'], $_POST['salutation'], $_POST['company'], $_POST['email'], $_POST['country_code'], $_POST['area_code'], $_POST['phone'], $_POST['geo_long'], $_POST['geo_lat'])) {
        // Zuweisung der übermittelten Werte zu Variablen
        $id = $_POST['id'];
        $postal_code = $_POST['postal_code'];
        $street = $_POST['street'];
        $house_number = $_POST['house_number'];
        $city = $_POST['city'];
        $salutation = $_POST['salutation'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $company = $_POST['company'];
        $email = $_POST['email'];
        $country_code = $_POST['country_code'];
        $area_code = $_POST['area_code'];
        $phone = $_POST['phone'];
        $geo_long = str_replace(',', '.', $_POST['geo_long']); // Ersetzt Kommas durch Punkte für Längengrad
        $geo_lat = str_replace(',', '.', $_POST['geo_lat']); // Ersetzt Kommas durch Punkte für Breitengrad
        $address = $street . ' ' . $house_number; // Kombiniert Straße und Hausnummer
        $address2 = $postal_code . ' ' . $city; // Kombiniert Postleitzahl und Stadt

        // Überprüfen der Gültigkeit des Längengrades
        if (!is_numeric($geo_long) || $geo_long < -180 || $geo_long > 180) {
            echo "<p class='error-message'>Ungültiger Längengrad.</p>";
            echo '<a href="http://localhost/server/index.php" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">Zurück zur Startseite</a>';
            exit;
        }

        // Überprüfen der Gültigkeit des Breitengrades
        if (!is_numeric($geo_lat) || $geo_lat < -90 || $geo_lat > 90) {
            echo "<p class='error-message'>Ungültiger Breitengrad.</p>";
            echo '<a href="http://localhost/server/index.php" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">Zurück zur Startseite</a>';
            exit;
        }

        // Initialisierung des Bildpfades
        $imagePath = '';
        // Überprüfen, ob ein Bild hochgeladen wurde und ob keine Fehler aufgetreten sind
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Definieren der erlaubten Dateierweiterungen
            $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'svg');
            $filename = $_FILES['image']['name'];
            $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $fileSize = $_FILES['image']['size'];

            // Überprüfen der Dateierweiterung
            if (!in_array($fileExtension, $allowedExtensions)) {
                echo '<p class="error-message">Nicht unterstützte Dateierweiterung!</p>';
                echo '<a href="http://localhost/server/index.php" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">Zurück zur Startseite</a>';
                exit;
            }

        
// Fehlerberichterstattung aktivieren
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php'); // Einbinden der Konfigurationsdatei

// Überprüfen, ob der Benutzer eingeloggt ist, sonst Weiterleitung zur Login-Seite
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Überprüfen, ob die Anfrage eine POST-Anfrage ist
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Überprüfen, ob alle erforderlichen Felder gesetzt sind
    if (isset($_POST['id'], $_POST['postal_code'], $_POST['street'], $_POST['house_number'], $_POST['city'], $_POST['first_name'], $_POST['last_name'], $_POST['salutation'], $_POST['company'], $_POST['email'], $_POST['country_code'], $_POST['area_code'], $_POST['phone'], $_POST['geo_long'], $_POST['geo_lat'])) {
        // Zuweisung der übermittelten Werte zu Variablen
        $id = $_POST['id'];
        $postal_code = $_POST['postal_code'];
        $street = $_POST['street'];
        $house_number = $_POST['house_number'];
        $city = $_POST['city'];
        $salutation = $_POST['salutation'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $company = $_POST['company'];
        $email = $_POST['email'];
        $country_code = $_POST['country_code'];
        $area_code = $_POST['area_code'];
        $phone = $_POST['phone'];
        $geo_long = str_replace(',', '.', $_POST['geo_long']); // Ersetzt Kommas durch Punkte für Längengrad
        $geo_lat = str_replace(',', '.', $_POST['geo_lat']); // Ersetzt Kommas durch Punkte für Breitengrad
        $address = $street . ' ' . $house_number; // Kombiniert Straße und Hausnummer
        $address2 = $postal_code . ' ' . $city; // Kombiniert Postleitzahl und Stadt

        // Überprüfen der Gültigkeit des Längengrades
        if (!is_numeric($geo_long) || $geo_long < -180 || $geo_long > 180) {
            echo "<p class='error-message'>Ungültiger Längengrad.</p>";
            echo '<a href="http://localhost/server/index.php" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">Zurück zur Startseite</a>';
            exit;
        }

        // Überprüfen der Gültigkeit des Breitengrades
        if (!is_numeric($geo_lat) || $geo_lat < -90 || $geo_lat > 90) {
            echo "<p class='error-message'>Ungültiger Breitengrad.</p>";
            echo '<a href="http://localhost/server/index.php" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">Zurück zur Startseite</a>';
            exit;
        }

        // Initialisierung des Bildpfades
        $imagePath = '';
        // Überprüfen, ob ein Bild hochgeladen wurde und ob keine Fehler aufgetreten sind
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Definieren der erlaubten Dateierweiterungen
            $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'svg');
            $filename = $_FILES['image']['name'];
            $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $fileSize = $_FILES['image']['size'];

            // Überprüfen der Dateierweiterung
            if (!in_array($fileExtension, $allowedExtensions)) {
                echo '<p class="error-message">Nicht unterstützte Dateierweiterung!</p>';
                echo '<a href="http://localhost/server/index.php" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">Zurück zur Startseite</a>';
                exit;
            }

     // SQL-Befehl zur Aktualisierung der Kontaktdaten
$sql = "UPDATE contacts SET salutation = ?, first_name = ?, last_name = ?, company = ?, email = ?, country_code = ?, area_code = ?, phone = ?, address = ?, street = ?, postal_code = ?, city = ?, house_number = ?, address2 = ?, geo_long = ?, geo_lat = ?";
$data = [$salutation, $first_name, $last_name, $company, $email, $country_code, $area_code, $phone, $address, $street, $postal_code, $city, $house_number, $address2, $geo_long, $geo_lat];

// Wenn ein Bildpfad vorhanden ist, wird dieser auch aktualisiert
if (!empty($imagePath)) {
    $sql .= ", image = ?";
    $data[] = $imagePath;
}

// Fügt die ID des Kontakts zur SQL-Anweisung hinzu
$sql .= " WHERE id = ?";
$data[] = $id;

// Vorbereiten und Ausführen des SQL-Befehls mit den gesammelten Daten
$stmt = $pdo->prepare($sql);
$stmt->execute($data);

// Überprüfen auf Datenbankfehler
if ($stmt->errorInfo()[1]) {
    die("Datenbankfehler: " . $stmt->errorInfo()[2]);
}

// Weiterleitung je nachdem, von welcher Seite die Anfrage kam
if (isset($_POST['from_edit']) && $_POST['from_edit'] == "true") {
    header("Location: index.php");
} else {
    header("Location: contact_details.php?id=" . $id);
}
exit;
} else {
    echo "Einige notwendige Felder fehlen.";
}

// Überprüfung des Längengrades
if (!is_numeric($geo_long) || $geo_long < -180 || $geo_long > 180) {
    // Zeigt eine Fehlermeldung an, wenn der Längengrad ungültig ist
    echo '<p class="error-message">Ungültiger Längengrad.</p>';
    // Bietet einen Link zurück zur Startseite
    echo '<a href="http://localhost/server/index.php" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">Zurück zur Startseite</a>';
    // Beendet die Ausführung des Skripts
    exit;
}

// Überprüfung des Breitengrades
if (!is_numeric($geo_lat) || $geo_lat < -90 || $geo_lat > 90) {
    // Zeigt eine Fehlermeldung an, wenn der Breitengrad ungültig ist
    echo '<p class="error-message">Ungültiger Breitengrad.</p>';
    // Bietet einen Link zurück zur Startseite
    echo '<a href="http://localhost/server/index.php" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">Zurück zur Startseite</a>';
    // Beendet die Ausführung des Skripts
    exit;
}


?>
