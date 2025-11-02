<?php
define('SECURE', true);
include '../config/db_connect.php';
include '../config/form_helpers.php';
include '../includes/header.php';

$success_message = '';
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Haal POST data veilig op met isset check
    $bedrijfsnaam = isset($_POST['bedrijfsnaam']) ? trim($_POST['bedrijfsnaam']) : '';
    $straat = isset($_POST['straat']) ? trim($_POST['straat']) : '';
    $huisnummer = isset($_POST['huisnummer']) ? trim($_POST['huisnummer']) : '';
    $postcode = isset($_POST['postcode']) ? trim($_POST['postcode']) : '';
    $woonplaats = isset($_POST['woonplaats']) ? trim($_POST['woonplaats']) : '';
    $land = isset($_POST['land']) ? trim($_POST['land']) : '';
    $nieuw_land = isset($_POST['nieuw_land']) ? trim($_POST['nieuw_land']) : '';
    $email_facturen = isset($_POST['email_facturen']) ? trim($_POST['email_facturen']) : '';
    $website = isset($_POST['website']) ? trim($_POST['website']) : '';
    $telefoonnummer = isset($_POST['telefoonnummer']) ? trim($_POST['telefoonnummer']) : '';
    $notities = isset($_POST['notities']) ? trim($_POST['notities']) : '';
    $status = isset($_POST['status']) ? trim($_POST['status']) : 'Actief';

    // Valideer verplichte velden
    if (empty($bedrijfsnaam)) {
        $error_message = "Bedrijfsnaam is verplicht";
    } else {
        // Gebruik het nieuwe land als deze is ingevoerd
        if (!empty($nieuw_land)) {
            $land = $nieuw_land;
        }

        // Formateer telefoonnummer
        if (!empty($telefoonnummer)) {
            if (!class_exists('PhoneNumberFormatter')) {
                include_once '../config/phone_number_formatter.php';
            }
            $formatter = new PhoneNumberFormatter();
            $telefoonnummer = $formatter->format($telefoonnummer, $land);
        }

        // Voorbereiden van een SQL statement
        $stmt = $conn->prepare("INSERT INTO bedrijven (bedrijfsnaam, straat, huisnummer, postcode, woonplaats, land, email_facturen, website, telefoonnummer, notities, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        if ($stmt === false) {
            $error_message = "Database fout bij prepare: " . htmlspecialchars($conn->error);
        } else {
            $stmt->bind_param("sssssssssss", $bedrijfsnaam, $straat, $huisnummer, $postcode, $woonplaats, $land, $email_facturen, $website, $telefoonnummer, $notities, $status);

            // Uitvoeren van het statement
            if ($stmt->execute()) {
                $success_message = "Nieuw bedrijf succesvol aangemaakt";
            } else {
                $error_message = "Fout bij opslaan: " . htmlspecialchars($stmt->error);
            }

            // Sluiten van het statement (maar NIET de connectie!)
            $stmt->close();
        }
    }
}

// Array met landen
$landen = [
    "Nederland", "België", "Duitsland", "Frankrijk", "Verenigd Koninkrijk", "Spanje", "Italië", "Zwitserland", "Oostenrijk", "Zweden", "Noorwegen", "Denemarken", "Finland", "Ierland", "Portugal", "Griekenland", "Polen", "Tsjechië", "Hongarije", "Roemenië", "Bulgarije", "Kroatië", "Slovenië", "Slowakije", "Litouwen", "Letland", "Estland", "Luxemburg", "IJsland", "Cyprus", "Malta", "Israël", "Turkije", "Verenigde Arabische Emiraten", "Saoedi-Arabië", "Qatar", "Koeweit", "Bahrein", "Oman", "Egypte", "Jordanië", "Libanon", "Canada", "USA"
];
?>

<div class="container mt-3">
    <h2>Prikbord</h2>
    <textarea class="form-control" placeholder="Ruimte om even gegevens te plakken. Ctrl + V... deze info wordt niet bewaard!" style="width: 1000px; height: 200px;"></textarea>
</div>

<h1 class="mt-5">Bedrijf toevoegen</h1>

<?php 
// Toon success/error berichten
if (!empty($success_message)) {
    echo "<div class='alert alert-success mt-3'>" . htmlspecialchars($success_message) . "</div>";
}
if (!empty($error_message)) {
    echo "<div class='alert alert-danger mt-3'>" . htmlspecialchars($error_message) . "</div>";
}

echo FormHelpers::createRequiredFieldsInfo(); 
?>

<form method="post" action="create_bedrijf.php">
    
    <?php echo FormHelpers::createTextInput('bedrijfsnaam', 'Bedrijfsnaam', true); ?>
    
    <div class="row mb-3">
        <div class="col">
            <?php echo FormHelpers::createLabel('straat', 'Straat', false); ?>
            <input type="text" class="form-control" id="straat" name="straat">
        </div>
        <div class="col-2">
            <?php echo FormHelpers::createLabel('huisnummer', 'Huisnummer', false); ?>
            <input type="text" class="form-control" id="huisnummer" name="huisnummer">
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col">
            <?php echo FormHelpers::createLabel('postcode', 'Postcode', false); ?>
            <input type="text" class="form-control" id="postcode" name="postcode">
        </div>
        <div class="col">
            <?php echo FormHelpers::createLabel('woonplaats', 'Woonplaats', false); ?>
            <input type="text" class="form-control" id="woonplaats" name="woonplaats">
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col">
            <?php 
            $land_options = [];
            foreach ($landen as $land) {
                $land_options[$land] = $land;
            }
            $land_options['other'] = 'Ander land toevoegen';
            // Standaard selectie: Nederland
            echo FormHelpers::createSelect('land', 'Land', $land_options, false, 'Nederland', 'Selecteer een land'); 
            ?>
            <input type="text" class="form-control d-none mt-2" id="nieuw_land" name="nieuw_land" placeholder="Voer nieuw land in">
        </div>
        <div class="col">
            <?php echo FormHelpers::createEmailInput('email_facturen', 'Email voor facturen', false, '', 'bijvoorbeeld@bedrijf.nl'); ?>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col">
            <?php echo FormHelpers::createUrlInput('website', 'Website', false, '', 'https://www.voorbeeld.nl'); ?>
        </div>
        <div class="col">
            <?php echo FormHelpers::createTelInput('telefoonnummer', 'Telefoonnummer', false, '', '+31 6 12 34 56 78'); ?>
        </div>
    </div>
    
    <?php echo FormHelpers::createTextarea('notities', 'Notities', false, '', 4, 'Vrije notities en opmerkingen over dit bedrijf...'); ?>
    
    <?php echo FormHelpers::createBedrijfStatusSelect(true, 'Actief'); ?>
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
document.getElementById('land').addEventListener('change', function() {
    var nieuwLandInput = document.getElementById('nieuw_land');
    if (this.value === 'other') {
        nieuwLandInput.classList.remove('d-none');
        nieuwLandInput.required = true;
    } else {
        nieuwLandInput.classList.add('d-none');
        nieuwLandInput.required = false;
    }
});
</script>

<?php include '../includes/footer.php'; ?>