<?php
define('SECURE', true);
include '../config/db_connect.php';
include '../config/phone_number_formatter.php';
include '../includes/header.php';

$formatter = new PhoneNumberFormatter();

$bedrijf_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($bedrijf_id) {
    $sql = "SELECT * FROM bedrijven WHERE id=$bedrijf_id AND id != 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $bedrijf = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger mt-3'>Bedrijf niet gevonden</div>";
        exit;
    }
} else {
    $sql = "SELECT * FROM bedrijven WHERE id != 1";
    $result = $conn->query($sql);
}
?>

<h1 class="mt-5">Bedrijven bekijken</h1>
<?php if ($bedrijf_id && isset($bedrijf)): ?>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Bedrijfsnaam</th>
                <th>Straat</th>
                <th>Huisnummer</th>
                <th>Postcode</th>
                <th>Woonplaats</th>
                <th>Land</th>
                <th>Email voor facturen</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><a href="update_bedrijf.php?id=<?php echo $bedrijf['id']; ?>"><?php echo $bedrijf["bedrijfsnaam"]; ?></a></td>
                <td><?php echo $bedrijf["straat"]; ?></td>
                <td><?php echo $bedrijf["huisnummer"]; ?></td>
                <td><?php echo $bedrijf["postcode"]; ?></td>
                <td><?php echo $bedrijf["woonplaats"]; ?></td>
                <td><?php echo $bedrijf["land"]; ?></td>
                <td><?php echo $bedrijf["email_facturen"]; ?></td>
            </tr>
            <tr>
                <td colspan="7">
                    <h5>Contacten bij dit bedrijf:</h5>
                    <?php
                    $klanten_sql = "SELECT klanten.id, klanten.voornaam, klanten.achternaam, klanten.telefoonnummer_mobiel, klanten.telefoonnummer_vast, klanten.email, functies.functienaam 
                                    FROM klanten 
                                    JOIN functies ON klanten.functie_id = functies.id 
                                    WHERE klanten.bedrijf_id = $bedrijf_id";
                    $klanten_result = $conn->query($klanten_sql);

                    if ($klanten_result->num_rows > 0): ?>
                        <table class="table table-striped mt-3">
                            <thead>
                                <tr>
                                    <th>Naam</th>
                                    <th>Telefoonnummer Mobiel</th>
                                    <th>Telefoonnummer Vast</th>
                                    <th>Email</th>
                                    <th>Functie</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($klant = $klanten_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><a href="../klanten/update_klant.php?id=<?php echo $klant['id']; ?>"><?php echo htmlspecialchars($klant['voornaam'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($klant['achternaam'], ENT_QUOTES, 'UTF-8'); ?></a></td>
                                        <td><?php echo htmlspecialchars($formatter->formatPhoneNumber($klant['telefoonnummer_mobiel'], $bedrijf['land']), ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($formatter->formatPhoneNumber($klant['telefoonnummer_vast'], $bedrijf['land']), ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($klant['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($klant['functienaam'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Geen klanten gevonden.</p>
                    <?php endif; ?>
                </td>
            </tr>
        </tbody>
    </table>
<?php else: ?>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Bedrijfsnaam</th>
                <th>Straat</th>
                <th>Huisnummer</th>
                <th>Postcode</th>
                <th>Woonplaats</th>
                <th>Land</th>
                <th>Email voor facturen</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td><a href='read_bedrijf.php?id=" . $row["id"] . "'>" . $row["bedrijfsnaam"]. "</a></td>
                            <td>" . $row["straat"]. "</td>
                            <td>" . $row["huisnummer"]. "</td>
                            <td>" . $row["postcode"]. "</td>
                            <td>" . $row["woonplaats"]. "</td>
                            <td>" . $row["land"]. "</td>
                            <td>" . $row["email_facturen"]. "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>0 results</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>