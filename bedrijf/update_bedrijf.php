<?php
define('SECURE', true);
include '../config/db_connect.php';
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

    // Formateer telefoonnummer
    include '../config/phone_number_formatter.php';
    $formatter = new PhoneNumberFormatter();
    if (!empty($telefoonnummer)) {
        $telefoonnummer = $formatter->format($telefoonnummer, $land);
    }

    // Voorbereiden van een SQL statement
    $stmt = $conn->prepare("UPDATE bedrijven SET bedrijfsnaam=?, straat=?, huisnummer=?, postcode=?, woonplaats=?, land=?, email_facturen=?, website=?, telefoonnummer=?, notities=? WHERE id=?");
    $stmt->bind_param("ssssssssssi", $bedrijfsnaam, $straat, $huisnummer, $postcode, $woonplaats, $land, $email_facturen, $website, $telefoonnummer, $notities, $id);

    // Uitvoeren van het statement
    if ($stmt->execute() === TRUE) {
        echo "<div class='alert alert-success mt-3'>Record updated successfully</div>";
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

<h1 class="mt-5">Bedrijf bijwerken</h1>
<form method="post" action="update_bedrijf.php">
    <input type="hidden" name="id" value="<?php echo isset($bedrijf['id']) ? $bedrijf['id'] : ''; ?>">
    <div class="mb-3">
        <label for="bedrijfsnaam" class="form-label">Bedrijfsnaam</label>
        <input type="text" class="form-control" id="bedrijfsnaam" name="bedrijfsnaam" value="<?php echo isset($bedrijf['bedrijfsnaam']) ? $bedrijf['bedrijfsnaam'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="straat" class="form-label">Straat</label>
        <input type="text" class="form-control" id="straat" name="straat" value="<?php echo isset($bedrijf['straat']) ? $bedrijf['straat'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="huisnummer" class="form-label">Huisnummer</label>
        <input type="text" class="form-control" id="huisnummer" name="huisnummer" value="<?php echo isset($bedrijf['huisnummer']) ? $bedrijf['huisnummer'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="postcode" class="form-label">Postcode</label>
        <input type="text" class="form-control" id="postcode" name="postcode" value="<?php echo isset($bedrijf['postcode']) ? $bedrijf['postcode'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="woonplaats" class="form-label">Woonplaats</label>
        <input type="text" class="form-control" id="woonplaats" name="woonplaats" value="<?php echo isset($bedrijf['woonplaats']) ? $bedrijf['woonplaats'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="land" class="form-label">Land</label>
        <input type="text" class="form-control" id="land" name="land" value="<?php echo isset($bedrijf['land']) ? $bedrijf['land'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="email_facturen" class="form-label">Email Facturen</label>
        <input type="email" class="form-control" id="email_facturen" name="email_facturen" value="<?php echo isset($bedrijf['email_facturen']) ? $bedrijf['email_facturen'] : ''; ?>">
    </div>
    <div class="row mb-3">
        <div class="col">
            <label for="website" class="form-label">Website</label>
            <input type="url" class="form-control" id="website" name="website" value="<?php echo isset($bedrijf['website']) ? htmlspecialchars($bedrijf['website']) : ''; ?>" placeholder="https://www.voorbeeld.nl">
        </div>
        <div class="col">
            <label for="telefoonnummer" class="form-label">Telefoonnummer</label>
            <input type="tel" class="form-control" id="telefoonnummer" name="telefoonnummer" value="<?php echo isset($bedrijf['telefoonnummer']) ? htmlspecialchars($bedrijf['telefoonnummer']) : ''; ?>" placeholder="0599-612346">
        </div>
    </div>
    <div class="mb-3">
        <label for="notities" class="form-label">Notities</label>
        <textarea class="form-control" id="notities" name="notities" rows="3" placeholder="Vrije notities en opmerkingen over dit bedrijf..."><?php echo isset($bedrijf['notities']) ? htmlspecialchars($bedrijf['notities']) : ''; ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Bijwerken</button>
</form>

<?php include '../includes/footer.php'; ?>