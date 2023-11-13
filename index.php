<?php
require_once('config.php'); // Einbinden der Konfigurationsdatei für Datenbankverbindung und andere Einstellungen

// Überprüfen, ob der Benutzer angemeldet ist, sonst Umleitung zur Login-Seite
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Überprüfen, ob die Benutzer-ID in der Session vorhanden ist, sonst Umleitung zur Login-Seite
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Logout-Funktion
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Abrufen aller Kontakte des angemeldeten Benutzers aus der Datenbank
$stmt = $pdo->prepare("SELECT * FROM contacts WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$contacts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adressbuch</title>
	    <!-- Einbinden von externen Stylesheets und Schriftarten -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dialog-polyfill/0.5.10/dialog-polyfill.min.css">
    <style>
        .contact-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            cursor: pointer;
        }

        .delete-contact, .edit-contact, .details-contact, .info-contact {
            cursor: pointer;
            margin-left: 10px;
        }

        .mdl-layout-title {
            font-size: 28px; /* Erhöhte Schriftgröße */
            text-align: center;
            flex-grow: 2;
        }

        .search-container {
            position: relative;
            display: inline-block;
        }

        .search-icon::before {
            content: 'search';
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            font-family: 'Material Icons';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }

        #search {
            padding-left: 40px; /* Platz für das Such-Icon */
            width: 200px; /* Breite des Suchfelds */
            background-color: transparent;
            border: none;
            border-bottom: 1px solid rgba(0,0,0,.12);
        }

        #search::placeholder {
            color: gray;
        }
    </style>
</head>
<body>
<div class="mdl-layout mdl-js-layout">
    <header class="mdl-layout__header">   <!-- Kopfzeile mit Benutzername, Suchfeld und Logout-Button -->
        <div class="mdl-layout__header-row">
            <span class="username-display">Benutzername: <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Unbekannt'; ?></span>
            <span class="mdl-layout-title">Kontakte</span>
            <div class="mdl-layout-spacer"></div>
            <div class="search-container">
                <input class="mdl-textfield__input" type="text" id="search" onkeyup="searchContacts()" placeholder="Suchen..." />
                <span class="search-icon"></span>
            </div>
            <button id="addContactButton" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
                <i class="material-icons">add</i>
            </button>
            <form action="" method="post" style="margin-left: 20px;">
                <button type="submit" name="logout" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
                    Logout
                </button>
            </form>
        </div>
    </header>
    <main class="mdl-layout__content">
        <ul class="mdl-list" id="contactList">
            <?php foreach ($contacts as $contact) { ?>     <!-- Anzeigen jedes Kontakts in der Liste mit Optionen zum Anzeigen, Bearbeiten und Löschen -->
                <li class="mdl-list__item">
                    <img src="<?php echo !empty($contact['image']) ? $contact['image'] : 'https://www.fonetool.com/screenshot/de/others/contacts-sync/contacts.png'; ?>" class="contact-image" onclick="window.location.href='contact_details.php?id=<?php echo $contact['id']; ?>'" />
                    <span class="mdl-list__item-primary-content" onclick="window.location.href='contact_details.php?id=<?php echo $contact['id']; ?>'">
                        <?php echo $contact['first_name'] . ' ' . $contact['last_name']; ?>
                    </span>
                    <span class="info-contact material-icons" onclick="window.location.href='contact_details.php?id=<?php echo $contact['id']; ?>'">info</span>
                    <span class="edit-contact material-icons" onclick="window.location.href='edit_contact.php?id=<?php echo $contact['id']; ?>'">settings</span>
                    <span class="delete-contact material-icons" onclick="deleteContact(<?php echo $contact['id']; ?>)">delete</span>
                </li>
            <?php } ?>
        </ul>      <!-- Dialog zum Hinzufügen eines neuen Kontakts -->
        <dialog class="mdl-dialog"> 
            <h4 class="mdl-dialog__title">Kontakt hinzufügen</h4>
            <div class="mdl-dialog__content">
                <form id="addContactForm" action="add_contact.php" method="post" enctype="multipart/form-data">
                    <div class="mdl-textfield mdl-js-textfield">
                        <input class="mdl-textfield__input" type="text" id="first_name" name="first_name" placeholder="Vorname" required />
                    </div>
                    <div class="mdl-textfield mdl-js-textfield">
                        <input class="mdl-textfield__input" type="text" id="last_name" name="last_name" placeholder="Nachname" required />
                    </div>
                    <div class="mdl-textfield mdl-js-textfield">
                        <input type="file" id="contact_image" name="contact_image" accept=".jpg, .jpeg, .png" />
                        <label for="contact_image">Bild auswählen (max. 5MB, JPG/PNG)</label>
                    </div>
                    <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">Kontakt hinzufügen</button>
                </form>
            </div>
            <div class="mdl-dialog__actions">
                <button type="button" class="mdl-button close">Abbrechen</button>
            </div>
        </dialog>
    </main>
</div>
<!-- Einbinden von externen JavaScript-Dateien und Skripten für Dialog- und Suchfunktionalität -->
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dialog-polyfill/0.5.10/dialog-polyfill.min.js"></script>
<script>
    var dialog = document.querySelector('dialog');  // Dialog-Element auswählen
    if (!dialog.showModal) {  // Polyfill für den Dialog, falls die showModal-Funktion nicht unterstützt wird
        dialogPolyfill.registerDialog(dialog);
    }

// Event-Listener für den "Kontakt hinzufügen"-Button
    document.getElementById('addContactButton').addEventListener('click', function () {
        document.getElementById('addContactForm').reset();  // Formular zurücksetzen, bevor der Dialog angezeigt wird
        dialog.showModal();  // Dialog zum Hinzufügen eines neuen Kontakts anzeigen
    });

    dialog.querySelector('.close').addEventListener('click', function () { // Event-Listener für den Schließen-Button im Dialog
        dialog.close(); //Dialog schließen
    });

    function deleteContact(contactId) { // Funktion zum Löschen eines Kontakts
        if (confirm('Möchten Sie diesen Kontakt wirklich löschen?')) {  // Bestätigungsdialog anzeigen
            window.location.href = 'delete_contact.php?id=' + contactId;  // Bei Bestätigung zur Lösch-URL weiterleiten
        }
    }

    function searchContacts() {  // Funktion zur Suche nach Kontakten
        var input, filter, ul, li, span, i, txtValue;
        input = document.getElementById('search');  // Suchfeld-Element und Filtertext holen
        filter = input.value.toUpperCase();
        ul = document.getElementById('contactList');  // Liste der Kontaktelemente holen
        li = ul.getElementsByTagName('li');

        for (i = 0; i < li.length; i++) {  // Durch alle Listenelemente iterieren
            span = li[i].getElementsByClassName('mdl-list__item-primary-content')[0]; //Text des Kontakts holen
            txtValue = span.textContent || span.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {  // Kontaktelement anzeigen oder verstecken, basierend auf Suchtext
                li[i].style.display = '';
            } else {
                li[i].style.display = 'none';
            }
        }
    }
</script>
</body>
</html>
