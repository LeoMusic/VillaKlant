<?php
define('SECURE', true);
include '../config/db_connect.php';
include '../includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Voorbereiden van een SQL statement om de klant te verwijderen
    $stmt = $conn->prepare("DELETE FROM klanten WHERE id=?");
    $stmt->bind_param("i", $id);

    // Uitvoeren van het statement
    if ($stmt->execute() === TRUE) {
        echo "<div class='alert alert-success mt-3'>Klant succesvol verwijderd</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Fout bij het verwijderen van de klant: " . $stmt->error . "</div>";
    }

    // Sluiten van het statement
    $stmt->close();
} else {
    echo "<div class='alert alert-danger mt-3'>Ongeldige aanvraag</div>";
}

$conn->close();
include '../includes/footer.php';
?>