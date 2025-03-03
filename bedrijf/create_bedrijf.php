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

    // Gebruik het nieuwe land als deze is ingevoerd
    if (!empty($nieuw_land)) {
        $land = $nieuw_land;
    }

    // Voorbereiden van een SQL statement
    $stmt = $conn->prepare("INSERT INTO bedrijven (bedrijfsnaam, straat, huisnummer, postcode, woonplaats, land, email_facturen) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $bedrijfsnaam, $straat, $huisnummer, $postcode, $woonplaats, $land, $email_facturen);

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
            <input type="email" class="form-control" id="email_facturen" name="email_facturen" required>
        </div>
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