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

    $sql = "UPDATE bedrijven SET bedrijfsnaam='$bedrijfsnaam', straat='$straat', huisnummer='$huisnummer', postcode='$postcode', woonplaats='$woonplaats', land='$land', email_facturen='$email_facturen' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success mt-3'>Record updated successfully</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Error updating record: " . $conn->error . "</div>";
    }

    // Haal de bijgewerkte bedrijfsgegevens opnieuw op
    $sql = "SELECT * FROM bedrijven WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $bedrijf = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger mt-3'>Bedrijf niet gevonden</div>";
        exit;
    }
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM bedrijven WHERE id=$id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $bedrijf = $result->fetch_assoc();
        } else {
            echo "<div class='alert alert-danger mt-3'>Bedrijf niet gevonden</div>";
            exit;
        }
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
        <input type="email" class="form-control" id="email_facturen" name="email_facturen" value="<?php echo isset($bedrijf['email_facturen']) ? $bedrijf['email_facturen'] : ''; ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Bijwerken</button>
</form>

<?php include '../includes/footer.php'; ?>