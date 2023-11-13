
<?php
require_once 'config.php'; // // Lädt die Konfigurationsdatei für die Datenbankverbindung und andere Einstellungen


// Überprüft, ob das Formular per POST-Methode gesendet wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Überprüft, ob das 'not_robot' Feld gesetzt ist und den Wert 1 hat
    if (!isset($_POST['not_robot']) || $_POST['not_robot'] != 1) {
        $login_error = "Bitte bestätige, dass du kein Roboter bist.";
    } else {
        // Verarbeitet die Login-Anfrage, wenn das 'login' Feld gesetzt ist
        if (isset($_POST['login'])) {
            $username = $_POST["username"]; // Nimmt den Benutzernamen aus dem Formular
            $password = $_POST["password"]; // Nimmt das Passwort aus dem Formular

            // Bereitet eine SQL-Abfrage vor, um den Benutzer in der Datenbank zu suchen
            $stmt = $pdo->prepare("SELECT id, password, username FROM users WHERE username = ?");
            $stmt->execute([$username]); // Führt die Abfrage mit dem Benutzernamen aus
            $user = $stmt->fetch(); // Holt die Benutzerdaten

            // Überprüft, ob der Benutzer existiert und das Passwort korrekt ist
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['loggedin'] = true; // Setzt die Session als 'eingeloggt'
                $_SESSION['user_id'] = $user['id']; // Speichert die Benutzer-ID in der Session
                $_SESSION['username'] = $user['username']; // Speichert den Benutzernamen in der Session
                header("Location: index.php"); // Leitet zur Hauptseite um
                exit;
            } else {
                $login_error = "Falscher Benutzername oder Passwort!"; // Fehlermeldung bei falschen Anmeldedaten
            }
        }
    }
}


  // Überprüft, ob das Registrierungsformular gesendet wurde
if (isset($_POST['register'])) {
    $registerUsername = $_POST["registerUsername"]; // Nimmt den Benutzernamen aus dem Formular
    $registerPassword = password_hash($_POST["registerPassword"], PASSWORD_DEFAULT); // Verschlüsselt das Passwort

    // Bereitet eine SQL-Abfrage vor, um zu überprüfen, ob der Benutzername bereits existiert
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$registerUsername]); // Führt die Abfrage mit dem Benutzernamen aus
    $user = $stmt->fetch(); // Holt die Benutzerdaten

    // Überprüft, ob der Benutzername bereits vergeben ist
    if ($user) {
        $register_error = "Benutzername bereits vergeben!"; // Fehlermeldung, wenn der Benutzername existiert
    } else {
        // Fügt den neuen Benutzer in die Datenbank ein
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$registerUsername, $registerPassword]); // Führt die Einfüge-Abfrage aus
        $register_success = "Erfolgreich registriert! Sie können sich jetzt anmelden."; // Erfolgsmeldung
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- Material Design Lite CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
</head>
<body>

<div class="mdl-layout mdl-js-layout mdl-color--grey-100">
    <div class="mdl-card mdl-shadow--6dp">
        <div class="mdl-card__title mdl-color--primary mdl-color-text--white">
            <h2 class="mdl-card__title-text">Login</h2>
        </div>
        <div class="mdl-card__supporting-text">
            <form action="" method="post">
                <div class="mdl-textfield mdl-js-textfield">
                    <input class="mdl-textfield__input" type="text" id="username" name="username" required>
                    <label class="mdl-textfield__label" for="username">Username</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield">
                    <input class="mdl-textfield__input" type="password" id="password" name="password" required>
                    <label class="mdl-textfield__label" for="password">Password</label>
                </div>
                <label>
                    <input type="checkbox" name="not_robot" value="1">
                    Ich bin kein Roboter
                </label>
                <button type="submit" name="login" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                    Anmelden
                </button>
            </form>
            <?php if (isset($login_error)) { ?>
                <p style="color: red;"><?php echo $login_error; ?></p>
            <?php } ?>
            <p>Noch kein Konto? <a href="#" id="showRegisterForm">Jetzt registrieren</a></p>
            <div id="registerForm" style="display:none;">
                <h3>Registrieren</h3>
                <form action="" method="post">
                    <div class="mdl-textfield mdl-js-textfield">
                        <input class="mdl-textfield__input" type="text" id="registerUsername" name="registerUsername" required>
                        <label class="mdl-textfield__label" for="registerUsername">Username</label>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield">
                        <input class="mdl-textfield__input" type="password" id="registerPassword" name="registerPassword" required>
                        <label class="mdl-textfield__label" for="registerPassword">Password</label>
                    </div>
                    <label>
                        <input type="checkbox" name="not_robot" value="1">
                        Ich bin kein Roboter
                    </label>
                    <button type="submit" name="register" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                        Registrieren
                    </button>
                </form>
                <?php if (isset($register_error)) { ?>
                    <p style="color: red;"><?php echo $register_error; ?></p>
                <?php } ?>
                <?php if (isset($register_success)) { ?>
                    <p style="color: green;"><?php echo $register_success; ?></p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Material Design Lite JS -->
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script>
    document.getElementById('showRegisterForm').addEventListener('click', function(e) { // Steuert das Registrierungsformular
        e.preventDefault();
        var registerForm = document.getElementById('registerForm');
        if (registerForm.style.display === 'none' || registerForm.style.display === '') {
            registerForm.style.display = 'block';
        } else {
            registerForm.style.display = 'none';
        }
    });
</script>

</body>
</html>
