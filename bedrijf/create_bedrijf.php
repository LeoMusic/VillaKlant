<?php
define('SECURE', true);
include '../config/db_connect.php';
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

<h1 class="mt-5">Bedrijf toevoegen</h1>
<form method="post" action="create_bedrijf.php">
    <div class="mb-3">
        <label for="bedrijfsnaam" class="form-label">Bedrijfsnaam</label>
        <input type="text" class="form-control" id="bedrijfsnaam" name="bedrijfsnaam" required>
    </div>
    <div class="row mb-3">
        <div class="col">
            <label for="straat" class="form-label">Straat</label>
            <input type="text" class="form-control" id="straat" name="straat" required>
        </div>
        <div class="col-2">
            <label for="huisnummer" class="form-label">Huisnummer</label>
            <input type="text" class="form-control" id="huisnummer" name="huisnummer" required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <label for="postcode" class="form-label">Postcode</label>
            <input type="text" class="form-control" id="postcode" name="postcode" required>
        </div>
        <div class="col">
            <label for="woonplaats" class="form-label">Woonplaats</label>
            <input type="text" class="form-control" id="woonplaats" name="woonplaats" required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <label for="land" class="form-label">Land</label>
            <select class="form-control" id="land" name="land" required>
                <option value="">Selecteer een land</option>
                <?php foreach ($landen as $land): ?>
                    <option value="<?php echo $land; ?>"><?php echo $land; ?></option>
                <?php endforeach; ?>
                <option value="other">Ander land toevoegen</option>
            </select>
            <input type="text" class="form-control d-none mt-2" id="nieuw_land" name="nieuw_land" placeholder="Voer nieuw land in">
        </div>
        <div class="col">
            <label for="email_facturen" class="form-label">Email voor facturen</label>
            <input type="email" class="form-control" id="email_facturen" name="email_facturen">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <label for="website" class="form-label">Website</label>
            <input type="url" class="form-control" id="website" name="website" placeholder="https://www.voorbeeld.nl">
        </div>
        <div class="col">
            <label for="telefoonnummer" class="form-label">Telefoonnummer</label>
            <input type="tel" class="form-control" id="telefoonnummer" name="telefoonnummer">
        </div>
    </div>
    <div class="mb-3">
        <label for="notities" class="form-label">Notities</label>
        <textarea class="form-control" id="notities" name="notities" rows="3" placeholder="Vrije notities en opmerkingen over dit bedrijf..."></textarea>
    </div>
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