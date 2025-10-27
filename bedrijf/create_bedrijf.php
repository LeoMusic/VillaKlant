<?php
define('SECURE', true);
include '../config/db_connect.php';
include '../config/form_helpers.php';
include '../includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bedrijfsnaam = $_POST['bedrijfsnaam'];
    $straat = $_POST['straat'];
    $huisnummer = $_POST['huisnummer'];
    $postcode = $_POST['postcode'];
    $woonplaats = $_POST['woonplaats'];
    $land = $_POST['land'];
    $nieuw_land = $_POST['nieuw_land'];
    $email_facturen = $_POST['email_facturen'];
    $website = $_POST['website'];
    $telefoonnummer = $_POST['telefoonnummer'];
    $notities = $_POST['notities'];

    // Gebruik het nieuwe land als deze is ingevoerd
    if (!empty($nieuw_land)) {
        $land = $nieuw_land;
    }

    // Formateer telefoonnummer
    include '../config/phone_number_formatter.php';
    $formatter = new PhoneNumberFormatter();
    if (!empty($telefoonnummer)) {
        $telefoonnummer = $formatter->format($telefoonnummer, $land);
    }

    // Voorbereiden van een SQL statement
    $stmt = $conn->prepare("INSERT INTO bedrijven (bedrijfsnaam, straat, huisnummer, postcode, woonplaats, land, email_facturen, website, telefoonnummer, notities) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $bedrijfsnaam, $straat, $huisnummer, $postcode, $woonplaats, $land, $email_facturen, $website, $telefoonnummer, $notities);

    // Uitvoeren van het statement
    if ($stmt->execute() === TRUE) {
        echo "<div class='alert alert-success mt-3'>Nieuw bedrijf succesvol aangemaakt</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Fout: " . $stmt->error . "</div>";
    }

    // Sluiten van het statement en de verbinding
    $stmt->close();
    $conn->close();
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

<?php echo FormHelpers::getRequiredFieldsCSS(); ?>

<h1 class="mt-5">Bedrijf toevoegen</h1>

<?php echo FormHelpers::createRequiredFieldsInfo(); ?>

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
            echo FormHelpers::createSelect('land', 'Land', $land_options, false); 
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