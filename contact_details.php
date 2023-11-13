<?php
// Einbinden der Konfigurationsdatei
require_once('config.php');

// Überprüfen, ob der Benutzer angemeldet ist. Wenn nicht, Umleitung zur Login-Seite
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Überprüfen, ob eine Kontakt-ID in der URL übergeben wurde
if (!isset($_GET['id'])) {
    die("Keine Kontakt-ID angegeben."); // Beenden des Skripts, wenn keine ID vorhanden ist
}

// Speichern der Kontakt-ID aus der GET-Anfrage
$contactId = $_GET['id'];

// Vorbereiten und Ausführen der SQL-Abfrage, um den Kontakt aus der Datenbank zu holen
$stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
$stmt->execute([$contactId]);
$contact = $stmt->fetch(); // Speichern des abgerufenen Kontakts in einer Variablen

// Überprüfen, ob der Kontakt existiert
if (!$contact) {
    die("Kontakt nicht gefunden."); // Beenden des Skripts, wenn der Kontakt nicht gefunden wird
} 

// Zusammenstellen der vollständigen Telefonnummer aus den einzelnen Teilen
$fullPhoneNumber = $contact['country_code'] . ' ' . $contact['area_code'] . ' ' . $contact['phone'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kontaktdetails</title>
	    <!-- Einbindung von Google Icons und Material Design Lite CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <style>
	        /* Stildefinitionen für verschiedene Elemente der Seite */
			
	.contact-details, #map {
    display: inline-block;
    vertical-align: top;
}

.contact-details {
    width: 45%;
    margin-right: 5%;
}

#map {
    width: 50%;
    height: 400px; /* Höhe der Karte anpassen */
}



        body {
            background-color: #f4f4f4;
        }
        .mdl-card {
            border-radius: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        .contact-info {
            font-size: 24px;
            text-align: center;
        }
        .edit-icon {
            color: #555;
            position: absolute;
            right: 15px;
            top: 15px;
        }
        .delete-icon {
            color: red;
            position: absolute;
            right: 50px;
            top: 15px;
            display: none; /* Versteckt den Mülleimer-Icon zu Beginn */
        }
        .mdl-button--blue {
            color: blue;
            border: 1px solid blue;
            border-radius: 15px;
            margin-top: 20px;
            display: block;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }
        img {
            display: block;
            margin-left: auto;
            margin-right: auto;
            border-radius: 50%;
            margin-top: 20px;
            margin-bottom: 10px;
            width: 150px;
            height: 150px;
        }
        p {
            text-align: center;
            font-size: 18px;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        /* CSS für das Modal */
        .modal {
            display: none; /* Standardmäßig versteckt */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%; /* Volle Breite */
            height: 100%; /* Volle Höhe */
            overflow: auto; /* Scrollen erlauben, falls erwünscht */
            background-color: rgb(0,0,0); /
            background-color: rgba(0,0,0,0.9); 
        }
        /* Modal Content (Bild) */
   .modal-content {
    display: block;
	 border-radius: 0; 
    max-width: 700px; /* Maximale Breite des Bildes */
    width: 25%; 
    margin: 15% auto; /* 15% von oben und zentriert */
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19); /* Optional: Schatten für das Bild */
}

    .modal {
        /* andere Stile beibehalten */
        display: flex; /* Verwendung von Flexbox für die Zentrierung */
        align-items: center; /* vertikal zentrieren */
        justify-content: center; /* horizontal zentrieren */
    }
        /* Hinzufügen von Animation - Zoom in das Modal */
        .modal-content, #caption { 
            animation-name: zoom;
            animation-duration: 0.6s;
        }
        @keyframes zoom {
            from {transform:scale(0)}
            to {transform:scale(1)}
        }
        /* Der 'close' Button */
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }
        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
		   #osm-map {
            width: 45%; /* oder eine andere geeignete Breite */
            height: 300px; /* Höhe der Karte */
            margin: 1em auto; /* Zentriert die Karte auf der Seite */
        }
    </style>
</head>
<body>


<div class="mdl-layout mdl-js-layout">
    <main class="mdl-layout__content">
	        <!-- Anzeige der Kontaktinformationen -->
        <div class="mdl-card mdl-shadow--2dp" style="margin: 2em; padding: 2em;" id="details">
              <!-- Bild des Kontakts, das beim Klicken das Modal öffnet -->
            <img id="myImg" src="<?php echo !empty($contact['image']) ? $contact['image'] : 'server/contacts.png'; ?>" alt="Kontaktbild">
            <h2 class="contact-info"> 
                <?php echo $contact['salutation'] . ' ' . $contact['first_name'] . ' ' . $contact['last_name']; ?> 
			<!-- Bearbeitungs-Button -->
                <button onclick="toggleEdit()" class="mdl-button mdl-js-button mdl-button--icon">
    <i class="material-icons edit-icon">edit</i>
</button>
            </h2>
			 <!-- Weitere Kontaktinformationen -->
            <p>Firma: <?php echo $contact['company']; ?></p>
            <p>Email: <?php echo $contact['email']; ?></p>
            <p>Telefonnummer: <?php echo $fullPhoneNumber; ?></p>
            <p>Adresse: <?php echo $contact['address']; ?></p>
			<p><?php echo $contact['address2']; ?></p>
			<!-- Zurück zur Kontaktliste -->
            <a href="index.php" class="mdl-button mdl-js-button mdl-button--blue">Zurück zur Kontaktliste</a>
        </div>
        <!-- Bearbeitungsformular, standardmäßig versteckt -->
        <div class="mdl-card mdl-shadow--2dp" style="margin: 2em; padding: 2em; display:none;" id="editForm">
		 <!-- Lösch-Button -->
            <button onclick="confirmDelete()" class="mdl-button mdl-js-button mdl-button--icon">
                <i class="material-icons delete-icon">delete</i>
            </button>
		  <!-- Formular zum Aktualisieren der Kontaktinformationen -->
            <form action="update_contact.php" method="post" enctype="multipart/form-data">
                <div class="mdl-textfield mdl-js-textfield">
                    Anrede: <input class="mdl-textfield__input" type="text" name="salutation" value="<?php echo $contact['salutation']; ?>">
                </div>
                <div class="mdl-textfield mdl-js-textfield">
                    Vorname: <input class="mdl-textfield__input" type="text" name="first_name" value="<?php echo $contact['first_name']; ?>">
                </div>
                <div class="mdl-textfield mdl-js-textfield">
                    Nachname: <input class="mdl-textfield__input" type="text" name="last_name" value="<?php echo $contact['last_name']; ?>">
                </div>
                <div class="mdl-textfield mdl-js-textfield">
                    Firma:
                    <input class="mdl-textfield__input" type="text" name="company" value="<?php echo $contact['company']; ?>">
                </div>
                <div class="mdl-textfield mdl-js-textfield">
                    Email: <input class="mdl-textfield__input" type="text" name="email" value="<?php echo $contact['email']; ?>">
                </div>
                <div class="mdl-textfield mdl-js-textfield">
                    Telefonnummer: <input class="mdl-textfield__input" type="text" name="phone" value="<?php echo $contact['phone']; ?>">
                </div>
                <div class="mdl-textfield mdl-js-textfield">
                    Landesvorwahl: <input class="mdl-textfield__input" type="text" name="country_code" value="<?php echo $contact['country_code']; ?>">
                </div>
                <div class="mdl-textfield mdl-js-textfield">
                    Ortsvorwahl: <input class="mdl-textfield__input" type="text" name="area_code" value="<?php echo $contact['area_code']; ?>">
                </div>
				 <div class="mdl-textfield mdl-js-textfield">
                    Straße: <input class="mdl-textfield__input" type="text" name="street" value="<?php echo $contact['street']; ?>">
                </div>
				 <div class="mdl-textfield mdl-js-textfield">
                    Hausnummer: <input class="mdl-textfield__input" type="text" name="house_number" value="<?php echo $contact['house_number']; ?>">
                </div>
				 <div class="mdl-textfield mdl-js-textfield">
                    Postleitzahl: <input class="mdl-textfield__input" type="text" name="postal_code" value="<?php echo $contact['postal_code']; ?>">
                </div>
				<div class="mdl-textfield mdl-js-textfield">
                    Ort: <input class="mdl-textfield__input" type="text" name="city" value="<?php echo $contact['city']; ?>">
                </div>
				
	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="text" id="geo_long" name="geo_long" value="<?php echo $contact['geo_long']; ?>" oninput="validateGeoInput(event)">
    <label class="mdl-textfield__label" for="geo_long">Geografische Länge (Longitude)</label>
</div>

<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="text" id="geo_lat" name="geo_lat" value="<?php echo $contact['geo_lat']; ?>" oninput="validateGeoInput(event)">
    <label class="mdl-textfield__label" for="geo_lat">Geografische Breite (Latitude)</label>
</div>
		
				
                <div class="mdl-textfield mdl-js-textfield">
                    Bild:(Max. 5MB, JPEG, PNG, GIF, SVG) <input class="mdl-textfield__input" type="file" name="image">
                    <img src="<?php echo !empty($contact['image']) ? $contact['image'] : 'server/contacts.png'; ?>" alt="Kontaktbild" style="width:100px;">
                </div>
                <input type="hidden" name="id" value="<?php echo $contactId; ?>">
                <button type="submit" class="mdl-button mdl-js-button mdl-button--blue">Speichern</button>
            </form>
        </div>
    </main>
</div>

<!-- Kartencontainer für OpenStreetMap -->
<div id="osm-map"></div>
<!-- Einbindung der Leaflet-Bibliothek für die Kartenfunktionalität -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<!-- Material Design Lite Bibliothek -->
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script>

// Event-Listener, der darauf wartet, dass das DOM vollständig geladen ist
document.addEventListener('DOMContentLoaded', function() {
// Geografische Daten des Kontakts aus PHP-Variablen holen
    var lat = <?php echo json_encode($contact['geo_lat']); ?>;
    var lng = <?php echo json_encode($contact['geo_long']); ?>;
    
// Überprüfen, ob die geografischen Daten gültig sind
    if (!lat || !lng || isNaN(lat) || isNaN(lng) || lat < -90 || lat > 90 || lng < -180 || lng > 180) {
        console.error("Ungültige oder fehlende geografische Daten.");
        return;
    }

// OpenStreetMap-Karte initialisieren und auf die geografischen Daten des Kontakts zentrieren
    var map = L.map('osm-map').setView([lat, lng], 13);

// OpenStreetMap-Layer zur Karte hinzufügen
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

// Marker auf der Karte an der Position des Kontakts platzieren und Popup mit Informationen anzeigen
    L.marker([lat, lng]).addTo(map)
        .bindPopup('Hier ist der Kontakt: ' + <?php echo json_encode($contact['first_name'] . ' ' . $contact['last_name']); ?> + '.<br> Adresse: ' + <?php echo json_encode($contact['address']); ?>)
        .openPopup();
});




// Funktion zur Validierung der Eingabe geografischer Daten
   function validateGeoInput(event) {
        // Ersetzt Kommas durch Punkte
        event.target.value = event.target.value.replace(/,/g, '.');
    }
	
// Funktion zum Umschalten zwischen Detailansicht und Bearbeitungsformular
       function toggleEdit() {
        var details = document.getElementById('details');
        var editForm = document.getElementById('editForm');
        var deleteIcon = document.querySelector('.delete-icon');

// Umschalten zwischen Anzeigen und Verbergen des Bearbeitungsformulars
        if (editForm.style.display === 'none') {
            editForm.style.display = 'block';
            details.style.display = 'none';
            deleteIcon.style.display = 'block';
        } else {
            editForm.style.display = 'none';
            details.style.display = 'block';
            deleteIcon.style.display = 'none';
        }
    }


// Funktion zur Bestätigung des Löschens eines Kontakts
     function confirmDelete() {
        var confirmation = confirm("Sind Sie sicher, dass Sie diesen Kontakt löschen möchten?");
        if (confirmation) {
// Bei Bestätigung zur Lösch-URL weiterleiten
            window.location.href = 'delete_contact.php?id=<?php echo $contactId; ?>';
        }
    }
</script>
</body>
</html>
