<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all the required fields are set
    if (isset($_POST['id'], $_POST['postal_code'], $_POST['street'], $_POST['house_number'],$_POST['city'], $_POST['first_name'], $_POST['last_name'], $_POST['salutation'], $_POST['company'], $_POST['email'], $_POST['country_code'], $_POST['area_code'], $_POST['phone'])) {
        // Assigning posted values to variables
       
	    $id = $_POST['id'];
        $postal_code = $_POST['postal_code'];
       $street =  $_POST['street'];
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
        $address =  $_POST['street'].' '.$_POST['house_number'];
		$address2 = $_POST['postal_code'].' '.$_POST['city'];
  

     $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Define allowed extensions
            $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'svg');
            $filename = $_FILES['image']['name'];
            $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $fileSize = $_FILES['image']['size'];

            // Validate file extension
          // Validate file extension
if (!in_array($fileExtension, $allowedExtensions)) {
    // Instead of terminating the script with die(), we display an error message and provide a button to go back to the homepage
    echo '<p>Nicht unterstützte Dateierweiterung!</p>'; // Display error message
    echo '<a href="http://localhost/server/index.php"><button>Zurück zur Startseite</button></a>'; // Display return button
    exit; // Ensure script stops executing further
}


            // Validate file size (5MB maximum)
         $maxSize = 5 * 1024 * 1024; // 5MB in bytes
            if ($fileSize > $maxSize) {
                die('Die Datei ist zu groß!');
            }

            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . basename($_FILES['image']['name']);

            // Move the file to the upload directory and set the $imagePath
         if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $imagePath = $uploadFile;
            } else {
                die('Fehler beim Hochladen der Datei.');
            }
        }

    $sql = "UPDATE contacts SET salutation = ?, first_name = ?, last_name = ?, company = ?, email = ?, country_code = ?, area_code = ?, phone = ?, address = ? , street = ? , postal_code = ? , city = ? , house_number = ?, address2 = ?";
        $data = [$salutation, $first_name, $last_name, $company, $email, $country_code, $area_code, $phone, $address , $street , $postal_code , $city, $house_number, $address2];

        if (!empty($imagePath)) {
            $sql .= ", image = ?";
            $data[] = $imagePath;
        }

        $sql .= " WHERE id = ?";
        $data[] = $id;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

        // Überprüfen von Datenbankfehlern
        if ($stmt->errorInfo()[1]) {
            die("Datenbankfehler: " . $stmt->errorInfo()[2]);
        }

        if (isset($_POST['from_edit']) && $_POST['from_edit'] == "true") {
            header("Location: index.php");
        } else {
            header("Location: contact_details.php?id=" . $id);
        }
        exit;
    } else {
        echo "Einige notwendige Felder fehlen.";
    }
}
?>
