<?php

// Datenbank-Verbindungseinstellungen
$host = '127.0.0.1';
$dbname = 'contact_db';
$user = 'benz';
$pass = '';


// Versucht, eine neue Verbindung zur Datenbank herzustellen.
// $pdo ist das PDO-Objekt, das für die Interaktion mit der Datenbank verwendet wird.
try { 
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {   // Wenn beim Herstellen der Verbindung ein Fehler auftritt,
    die("Datenbankverbindung fehlgeschlagen: " . $e->getMessage()); // Die Nachricht des Fehlers wird angezeigt und das Skript beendet.
}

// Session handling (Startet die Seassion when sie nicht schon gestartet wurde
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>