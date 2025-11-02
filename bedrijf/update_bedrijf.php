<?php
define('SECURE', true);
include '../config/db_connect.php';
include '../config/form_helpers.php';
include '../includes/header.php';

$bedrijf = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $bedrijfsnaam = $_POST['bedrijfsnaam'];
    $straat = $_POST['straat'];
    $huisnummer = $_POST['huisnummer'];
    $postcode = $_POST['postcode'];
    $woonplaats = $_POST['woonplaats'];
    $land = $_POST['land'];
    $email_facturen = $_POST['email_facturen'];
    $website = $_POST['website'];
    $telefoonnummer = $_POST['telefoonnummer'];
    $notities = $_POST['notities'];
    $status = isset($_POST['status']) ? $_POST['status'] : 'Actief';

    // Formateer telefoonnummer
    include '../config/phone_number_formatter.php';
    $formatter = new PhoneNumberFormatter();
    if (!empty($telefoonnummer)) {
        $telefoonnummer = $formatter->format($telefoonnummer, $land);
    }

    // Voorbereiden van een SQL statement
    $stmt = $conn->prepare("UPDATE bedrijven SET bedrijfsnaam=?, straat=?, huisnummer=?, postcode=?, woonplaats=?, land=?, email_facturen=?, website=?, telefoonnummer=?, notities=?, status=? WHERE id=?");
    $stmt->bind_param("sssssssssssi", $bedrijfsnaam, $straat, $huisnummer, $postcode, $woonplaats, $land, $email_facturen, $website, $telefoonnummer, $notities, $status, $id);

    // Uitvoeren van het statement
    if ($stmt->execute() === TRUE) {
        echo "<div class='alert alert-success mt-3'>
                <strong>✅ Gelukt!</strong> De gegevens van " . htmlspecialchars($bedrijfsnaam) . " zijn succesvol bijgewerkt.
                <div class='mt-2'>
                    <a href='../relatie/search_results.php?bedrijf_id=" . $id . "' class='btn btn-sm btn-success'>← Terug naar bedrijfskaart</a>
                    <a href='read_bedrijf.php' class='btn btn-sm btn-secondary'>Naar bedrijvenlijst</a>
                </div>
              </div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Error updating record: " . $stmt->error . "</div>";
    }

    // Sluiten van het statement
    $stmt->close();

    // Haal de bijgewerkte bedrijfsgegevens opnieuw op
    $stmt = $conn->prepare("SELECT * FROM bedrijven WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $bedrijf = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger mt-3'>Bedrijf niet gevonden</div>";
        exit;
    }

    // Sluiten van het statement
    $stmt->close();
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM bedrijven WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $bedrijf = $result->fetch_assoc();
        } else {
            echo "<div class='alert alert-danger mt-3'>Bedrijf niet gevonden</div>";
            exit;
        }

        // Sluiten van het statement
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger mt-3'>Geen bedrijf ID opgegeven</div>";
        exit;
    }
}
?>

<?php echo FormHelpers::getRequiredFieldsCSS(); ?>

<h1 class="mt-5">Bedrijf bijwerken</h1>

<?php echo FormHelpers::createRequiredFieldsInfo(); ?>

<form method="post" action="update_bedrijf.php">
    <input type="hidden" name="id" value="<?php echo isset($bedrijf['id']) ? $bedrijf['id'] : ''; ?>">
    
    <?php echo FormHelpers::createTextInput('bedrijfsnaam', 'Bedrijfsnaam', true, isset($bedrijf['bedrijfsnaam']) ? $bedrijf['bedrijfsnaam'] : ''); ?>
    
    <div class="row mb-3">
        <div class="col">
            <?php echo FormHelpers::createLabel('straat', 'Straat', false); ?>
            <input type="text" class="form-control" id="straat" name="straat" value="<?php echo isset($bedrijf['straat']) ? htmlspecialchars($bedrijf['straat']) : ''; ?>">
        </div>
        <div class="col-2">
            <?php echo FormHelpers::createLabel('huisnummer', 'Huisnummer', false); ?>
            <input type="text" class="form-control" id="huisnummer" name="huisnummer" value="<?php echo isset($bedrijf['huisnummer']) ? htmlspecialchars($bedrijf['huisnummer']) : ''; ?>">
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col">
            <?php echo FormHelpers::createTextInput('postcode', 'Postcode', false, isset($bedrijf['postcode']) ? $bedrijf['postcode'] : ''); ?>
        </div>
        <div class="col">
            <?php echo FormHelpers::createTextInput('woonplaats', 'Woonplaats', false, isset($bedrijf['woonplaats']) ? $bedrijf['woonplaats'] : ''); ?>
        </div>
    </div>
    
    <?php echo FormHelpers::createTextInput('land', 'Land', false, isset($bedrijf['land']) ? $bedrijf['land'] : ''); ?>
    
    <?php echo FormHelpers::createEmailInput('email_facturen', 'Email voor facturen', false, isset($bedrijf['email_facturen']) ? $bedrijf['email_facturen'] : '', 'bijvoorbeeld@bedrijf.nl'); ?>
    
    <div class="row mb-3">
        <div class="col">
            <?php echo FormHelpers::createUrlInput('website', 'Website', false, isset($bedrijf['website']) ? $bedrijf['website'] : '', 'https://www.voorbeeld.nl'); ?>
        </div>
        <div class="col">
            <?php echo FormHelpers::createTelInput('telefoonnummer', 'Telefoonnummer', false, isset($bedrijf['telefoonnummer']) ? $bedrijf['telefoonnummer'] : '', '+31 6 12 34 56 78'); ?>
        </div>
    </div>
    
    <?php 
    // Fix voor notities die als '0' zijn opgeslagen
    $notities_value = isset($bedrijf['notities']) && $bedrijf['notities'] !== '0' ? $bedrijf['notities'] : '';
    echo FormHelpers::createTextarea('notities', 'Notities', false, $notities_value, 4, 'Vrije notities en opmerkingen over dit bedrijf...'); 
    ?>
    
    <?php echo FormHelpers::createBedrijfStatusSelect(true, isset($bedrijf['status']) ? $bedrijf['status'] : 'Actief'); ?>
    
    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Bijwerken</button>
        <?php 
        // Slimme terug knop: als je vanuit bedrijfskaart komt, ga terug naar kaart, anders naar lijst
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        if (strpos($referer, 'search_results.php') !== false && isset($bedrijf['id'])) {
            echo '<a href="../relatie/search_results.php?bedrijf_id=' . $bedrijf['id'] . '" class="btn btn-secondary">Annuleren</a>';
        } else {
            echo '<a href="../bedrijf/read_bedrijf.php" class="btn btn-secondary">Annuleren</a>';
        }
        ?>
    </div>
</form>

<?php include '../includes/footer.php'; ?>