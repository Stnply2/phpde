<?php
require_once('config.php');

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: index.php");
    exit;
}
?>
