<?php
define('SECURE', true);
include '../config/db_connect.php';
include '../includes/header.php';

$klant = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $telefoonnummer = $_POST['telefoonnummer'];
    $email = $_POST['email'];
    $functie = $_POST['functie'];
    $bedrijf_id = $_POST['bedrijf_id'];
    $notities = $_POST['notities'];

    // Voorbereiden van een SQL statement
    $stmt = $conn->prepare("UPDATE klanten SET voornaam=?, achternaam=?, telefoonnummer=?, email=?, functie=?, bedrijf_id=?, notities=? WHERE id=?");
    $stmt->bind_param("sssssis", $voornaam, $achternaam, $telefoonnummer, $email, $functie, $bedrijf_id, $notities, $id);

    // Uitvoeren van het statement
    if ($stmt->execute() === TRUE) {
        echo "<div class='alert alert-success mt-3'>Record updated successfully</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Error updating record: " . $stmt->error . "</div>";
    }

    // Sluiten van het statement
    $stmt->close();

    // Haal de bijgewerkte klantgegevens opnieuw op
    $stmt = $conn->prepare("SELECT * FROM klanten WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $klant = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger mt-3'>Klant niet gevonden</div>";
        exit;
    }

    // Sluiten van het statement
    $stmt->close();
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM klanten WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $klant = $result->fetch_assoc();
        } else {
            echo "<div class='alert alert-danger mt-3'>Klant niet gevonden</div>";
            exit;
        }

        // Sluiten van het statement
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger mt-3'>Geen klant ID opgegeven</div>";
        exit;
    }
}

// Haal de lijst van bedrijven op
$bedrijven_result = $conn->query("SELECT id, bedrijfsnaam FROM bedrijven");
?>

<h1 class="mt-5">Klant bijwerken</h1>
<form method="post" action="update_klant.php">
    <input type="hidden" name="id" value="<?php echo isset($klant['id']) ? $klant['id'] : ''; ?>">
    <div class="mb-3">
        <label for="voornaam" class="form-label">Voornaam</label>
        <input type="text" class="form-control" id="voornaam" name="voornaam" value="<?php echo isset($klant['voornaam']) ? $klant['voornaam'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="achternaam" class="form-label">Achternaam</label>
        <input type="text" class="form-control" id="achternaam" name="achternaam" value="<?php echo isset($klant['achternaam']) ? $klant['achternaam'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="telefoonnummer" class="form-label">Telefoonnummer</label>
        <input type="text" class="form-control" id="telefoonnummer" name="telefoonnummer" value="<?php echo isset($klant['telefoonnummer']) ? $klant['telefoonnummer'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($klant['email']) ? $klant['email'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="functie" class="form-label">Functie</label>
        <input type="text" class="form-control" id="functie" name="functie" value="<?php echo isset($klant['functie']) ? $klant['functie'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="bedrijf_id" class="form-label">Bedrijf</label>
        <select class="form-control" id="bedrijf_id" name="bedrijf_id" required>
            <option value="">Selecteer een bedrijf</option>
            <?php
            if ($bedrijven_result->num_rows > 0) {
                while($row = $bedrijven_result->fetch_assoc()) {
                    $selected = isset($klant['bedrijf_id']) && $row["id"] == $klant['bedrijf_id'] ? 'selected' : '';
                    echo "<option value='" . $row["id"] . "' $selected>" . $row["bedrijfsnaam"] . "</option>";
                }
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="notities" class="form-label">Notities</label>
        <textarea class="form-control" id="notities" name="notities" rows="3"><?php echo isset($klant['notities']) ? $klant['notities'] : ''; ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Bijwerken</button>
</form>

<?php include '../includes/footer.php'; ?>