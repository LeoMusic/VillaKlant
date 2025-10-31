<?php
define('SECURE', true);
include '../config/db_connect.php';
include '../config/phone_number_formatter.php';
include '../includes/header.php';

$formatter = new PhoneNumberFormatter();

// Voorbereiden van een SQL statement
$sql = "SELECT klanten.id, voornaam, achternaam, telefoonnummer_mobiel, telefoonnummer_vast, email, functies.functienaam AS functie, bedrijfsnaam, bedrijven.id AS bedrijf_id, bedrijven.land, klanten.notities 
        FROM klanten 
        JOIN bedrijven ON klanten.bedrijf_id = bedrijven.id 
        JOIN functies ON klanten.functie_id = functies.id
        ORDER BY klanten.achternaam ASC, klanten.voornaam ASC";
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
            <th>Naam</th>
            <th>Contact</th>
            <th>Functie</th>
            <th>Bedrijf</th>
            <th>Notities</th>
            <th>Acties</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $country = $row["bedrijfsnaam"] == "Bedrijf onbekend" ? null : $row["land"];
                echo "<tr>
                        <td><a href='../relatie/search_results.php?klant_id=" . $row["id"] . "'>" . htmlspecialchars($row["voornaam"], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($row["achternaam"], ENT_QUOTES, 'UTF-8') . "</a></td>
                        <td>";
                
                // Contact informatie gegroepeerd
                if (!empty($row["telefoonnummer_mobiel"])) {
                    echo "<strong>Mobiel:</strong> " . htmlspecialchars($formatter->formatPhoneNumber($row["telefoonnummer_mobiel"], $country), ENT_QUOTES, 'UTF-8') . "<br>";
                }
                if (!empty($row["telefoonnummer_vast"])) {
                    echo "<strong>Vast:</strong> " . htmlspecialchars($formatter->formatPhoneNumber($row["telefoonnummer_vast"], $country), ENT_QUOTES, 'UTF-8') . "<br>";
                }
                if (!empty($row["email"])) {
                    echo "<strong>Email:</strong> <a href='mailto:" . htmlspecialchars($row["email"], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row["email"], ENT_QUOTES, 'UTF-8') . "</a>";
                }
                
                echo "</td>
                        <td>" . htmlspecialchars($row["functie"], ENT_QUOTES, 'UTF-8') . "</td>
                        <td><a href='../relatie/search_results.php?bedrijf_id=" . $row["bedrijf_id"] . "'>" . htmlspecialchars($row["bedrijfsnaam"], ENT_QUOTES, 'UTF-8') . "</a></td>
                        <td>" . (!empty($row["notities"]) ? nl2br(htmlspecialchars($row["notities"], ENT_QUOTES, 'UTF-8')) : '-') . "</td>
                        <td>
                            <a href='update_klant.php?id=" . $row["id"] . "' class='btn btn-sm btn-primary'>Bewerken</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Geen resultaten</td></tr>";
        }
        $stmt->close();
        $conn->close();
        ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>