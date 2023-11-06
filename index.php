<?php
require_once('config.php');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM contacts WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$contacts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adressbuch</title>
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
    <header class="mdl-layout__header">
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
            <?php foreach ($contacts as $contact) { ?>
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
        </ul>
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

<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dialog-polyfill/0.5.10/dialog-polyfill.min.js"></script>
<script>
    var dialog = document.querySelector('dialog');
    if (!dialog.showModal) {
        dialogPolyfill.registerDialog(dialog);
    }

    document.getElementById('addContactButton').addEventListener('click', function () {
        document.getElementById('addContactForm').reset();
        dialog.showModal();
    });

    dialog.querySelector('.close').addEventListener('click', function () {
        dialog.close();
    });

    function deleteContact(contactId) {
        if (confirm('Möchten Sie diesen Kontakt wirklich löschen?')) {
            window.location.href = 'delete_contact.php?id=' + contactId;
        }
    }

    function searchContacts() {
        var input, filter, ul, li, span, i, txtValue;
        input = document.getElementById('search');
        filter = input.value.toUpperCase();
        ul = document.getElementById('contactList');
        li = ul.getElementsByTagName('li');

        for (i = 0; i < li.length; i++) {
            span = li[i].getElementsByClassName('mdl-list__item-primary-content')[0];
            txtValue = span.textContent || span.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = '';
            } else {
                li[i].style.display = 'none';
            }
        }
    }
</script>
</body>
</html>
