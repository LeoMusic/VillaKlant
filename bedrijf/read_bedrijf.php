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
                <th>Adres</th>
                <th>Contact</th>
                <th>Notities</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><a href="update_bedrijf.php?id=<?php echo $bedrijf['id']; ?>"><?php echo htmlspecialchars($bedrijf["bedrijfsnaam"]); ?></a></td>
                <td>
                    <?php echo htmlspecialchars($bedrijf["straat"]) . " " . htmlspecialchars($bedrijf["huisnummer"]); ?><br>
                    <?php echo htmlspecialchars($bedrijf["postcode"]) . " " . htmlspecialchars($bedrijf["woonplaats"]); ?><br>
                    <?php echo htmlspecialchars($bedrijf["land"]); ?>
                </td>
                <td>
                    <?php if (!empty($bedrijf["telefoonnummer"])): ?>
                        <strong>Tel:</strong> <?php echo htmlspecialchars($bedrijf["telefoonnummer"]); ?><br>
                    <?php endif; ?>
                    <?php if (!empty($bedrijf["email_facturen"])): ?>
                        <strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($bedrijf["email_facturen"]); ?>"><?php echo htmlspecialchars($bedrijf["email_facturen"]); ?></a><br>
                    <?php endif; ?>
                    <?php if (!empty($bedrijf["website"])): ?>
                        <strong>Website:</strong> <a href="<?php echo htmlspecialchars($bedrijf["website"]); ?>" target="_blank"><?php echo htmlspecialchars($bedrijf["website"]); ?></a>
                    <?php endif; ?>
                </td>
                <td><?php echo !empty($bedrijf["notities"]) ? nl2br(htmlspecialchars($bedrijf["notities"])) : '-'; ?></td>
            </tr>
            <tr>
                <td colspan="4">
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
                <th>Adres</th>
                <th>Contact</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td><a href='read_bedrijf.php?id=" . $row["id"] . "'>" . htmlspecialchars($row["bedrijfsnaam"]). "</a></td>
                            <td>" . htmlspecialchars($row["straat"]) . " " . htmlspecialchars($row["huisnummer"]) . "<br>" . 
                                     htmlspecialchars($row["postcode"]) . " " . htmlspecialchars($row["woonplaats"]) . "<br>" .
                                     htmlspecialchars($row["land"]) . "</td>
                            <td>";
                    
                    if (!empty($row["telefoonnummer"])) {
                        echo "<strong>Tel:</strong> " . htmlspecialchars($row["telefoonnummer"]) . "<br>";
                    }
                    if (!empty($row["email_facturen"])) {
                        echo "<strong>Email:</strong> <a href='mailto:" . htmlspecialchars($row["email_facturen"]) . "'>" . htmlspecialchars($row["email_facturen"]) . "</a><br>";
                    }
                    if (!empty($row["website"])) {
                        echo "<strong>Website:</strong> <a href='" . htmlspecialchars($row["website"]) . "' target='_blank'>" . htmlspecialchars($row["website"]) . "</a>";
                    }
                    
                    echo "</td>
                            <td>
                                <a href='update_bedrijf.php?id=" . $row["id"] . "' class='btn btn-sm btn-primary'>Bewerken</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>0 results</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>