<?php
require_once('config.php');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Keine Kontakt-ID angegeben.");
}

$contactId = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
$stmt->execute([$contactId]);
$contact = $stmt->fetch();

if (!$contact) {
    die("Kontakt nicht gefunden.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kontakt bearbeiten</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
<style>

        .right-shift {
            margin-left: 50px; /* oder die gewünschte Entfernung */
        }
    </style>

</head>
<body>
<div class="mdl-layout mdl-js-layout">
    <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title">Kontakt bearbeiten</span>
        </div>
    </header>
    <main class="mdl-layout__content">
        <form action="update_contact.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
            <input type="hidden" name="from_edit" value="true">
           
		   <div class="right-shift">
		             <div class="mdl-textfield mdl-js-textfield">
                <input class="mdl-textfield__input" type="text" id="salutation" name="salutation" value="<?php echo $contact['salutation']; ?>">
                <label class="mdl-textfield__label" for="salutation">Anrede</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield">
                <input class="mdl-textfield__input" type="text" id="first_name" name="first_name" value="<?php echo $contact['first_name']; ?>">
                <label class="mdl-textfield__label" for="first_name">Vorname</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield">
                <input class="mdl-textfield__input" type="text" id="last_name" name="last_name" value="<?php echo $contact['last_name']; ?>">
                <label class="mdl-textfield__label" for="last_name">Nachname</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield">
                <input class="mdl-textfield__input" type="text" id="company" name="company" value="<?php echo $contact['company']; ?>">
                <label class="mdl-textfield__label" for="company">Firma</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield">
                <input class="mdl-textfield__input" type="email" id="email" name="email" value="<?php echo $contact['email']; ?>">
                <label class="mdl-textfield__label" for="email">Email</label>
            </div>

            <!-- Telefonnummer in Teile aufgeteilt -->
            <div class="mdl-textfield mdl-js-textfield">
                Ländercode: <input class="mdl-textfield__input" type="text" id="country_code" name="country_code" value="<?php echo $contact['country_code']; ?>">
            </div>
            <div class="mdl-textfield mdl-js-textfield">
                Vorwahl: <input class="mdl-textfield__input" type="text" id="area_code" name="area_code" value="<?php echo $contact['area_code']; ?>">
            </div>
            <div class="mdl-textfield mdl-js-textfield">
                Telefon: <input class="mdl-textfield__input" type="text" id="phone" name="phone" value="<?php echo $contact['phone']; ?>">
            </div>
			  <div class="mdl-textfield mdl-js-textfield">
                <input class="mdl-textfield__input" type="text" id="street" name="street" value="<?php echo $contact['street']; ?>">
                <label class="mdl-textfield__label" for="street">Straße</label>
            </div>
			  <div class="mdl-textfield mdl-js-textfield">
                <input class="mdl-textfield__input" type="text" id="house_number" name="house_number" value="<?php echo $contact['house_number']; ?>">
                <label class="mdl-textfield__label" for="house_number">Hausnummer</label>
            </div>
			  <div class="mdl-textfield mdl-js-textfield">
                <input class="mdl-textfield__input" type="text" id="postal_code" name="postal_code" value="<?php echo $contact['postal_code']; ?>">
                <label class="mdl-textfield__label" for="postal_code">Postleitzahl</label>
            </div>
			  <div class="mdl-textfield mdl-js-textfield">
                <input class="mdl-textfield__input" type="text" id="city" name="city" value="<?php echo $contact['city']; ?>">
                <label class="mdl-textfield__label" for="city">Ort</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield">
                Bild:(Max. 5MB, JPEG, PNG, GIF, SVG) <input type="file" name="image"> <!-- Changed the name attribute to "image" to match update_contact.php -->
            </div>
			
			

            <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                Änderungen speichern
            </button>
        </form>
    </main>
</div>

<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>
