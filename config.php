<?php

// Datenbank-Verbindungseinstellungen
$host = '127.0.0.1';
$dbname = 'contact_db';
$user = 'benz';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Datenbankverbindung fehlgeschlagen: " . $e->getMessage());
}

// Session handling (start the session if not already started)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>