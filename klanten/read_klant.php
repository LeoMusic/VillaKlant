<?php
define('SECURE', true);
include '../config/db_connect.php';
include '../config/phone_number_formatter.php';
include '../includes/header.php';

$formatter = new PhoneNumberFormatter();

// Voorbereiden van een SQL statement
$sql = "SELECT klanten.id, voornaam, achternaam, telefoonnummer_mobiel, telefoonnummer_vast, email, functies.functienaam AS functie, bedrijfsnaam, bedrijven.land, notities 
        FROM klanten 
        JOIN bedrijven ON klanten.bedrijf_id = bedrijven.id 
        JOIN functies ON klanten.functie_id = functies.id";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$stmt->execute();
$result = $stmt->get_result();
?>

<h1 class="mt-5">Klanten bekijken</h1>
<table class="table table-striped mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Naam</th>
            <th>Telefoonnummer Mobiel</th>
            <th>Telefoonnummer Vast</th>
            <th>Email</th>
            <th>Functie</th>
            <th>Bedrijf</th>
            <th>Notities</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $country = $row["bedrijfsnaam"] == "Bedrijf onbekend" ? null : $row["land"];
                echo "<tr>
                        <td>" . $row["id"]. "</td>
                        <td><a href='update_klant.php?id=" . $row["id"] . "'>" . htmlspecialchars($row["voornaam"], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($row["achternaam"], ENT_QUOTES, 'UTF-8') . "</a></td>
                        <td>" . htmlspecialchars($formatter->formatPhoneNumber($row["telefoonnummer_mobiel"], $country), ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($formatter->formatPhoneNumber($row["telefoonnummer_vast"], $country), ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($row["email"], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($row["functie"], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($row["bedrijfsnaam"], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($row["notities"], ENT_QUOTES, 'UTF-8') . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Geen resultaten</td></tr>";
        }
        $stmt->close();
        $conn->close();
        ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>