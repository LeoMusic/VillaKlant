<?php
define('SECURE', true);
include '../config/db_connect.php';
include '../config/form_helpers.php';
include '../includes/header.php';

$klant = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $telefoonnummer_mobiel = $_POST['telefoonnummer_mobiel'];
    $telefoonnummer_vast = $_POST['telefoonnummer_vast'];
    $email = $_POST['email'];
    $functie_id = $_POST['functie_id'];
    $nieuwe_functie = $_POST['nieuwe_functie'];
    $bedrijf_id = $_POST['bedrijf_id'];
    $notities = $_POST['notities'];

    // Gebruik de nieuwe functie als deze is ingevoerd
    if (!empty($nieuwe_functie)) {
        // Voeg de nieuwe functie toe aan de tabel functies
        $stmt = $conn->prepare("INSERT INTO functies (functienaam) VALUES (?)");
        $stmt->bind_param("s", $nieuwe_functie);
        $stmt->execute();
        $functie_id = $stmt->insert_id;
        $stmt->close();
    }

    // Voorbereiden van een SQL statement
    $stmt = $conn->prepare("UPDATE klanten SET voornaam=?, achternaam=?, telefoonnummer_mobiel=?, telefoonnummer_vast=?, email=?, functie_id=?, bedrijf_id=?, notities=? WHERE id=?");
    $stmt->bind_param("sssssiisi", $voornaam, $achternaam, $telefoonnummer_mobiel, $telefoonnummer_vast, $email, $functie_id, $bedrijf_id, $notities, $id);

    // Uitvoeren van het statement
    if ($stmt->execute() === TRUE) {
        echo "<div class='alert alert-success mt-3'>Record updated successfully</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Error updating record: " . $stmt->error . "</div>";
    }

    // Sluiten van het statement
    $stmt->close();
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Voorbereiden van een SQL statement om de klantgegevens op te halen
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

// Haal de lijst van bedrijven op (alfabetisch gesorteerd)
$bedrijven_result = $conn->query("SELECT id, bedrijfsnaam FROM bedrijven ORDER BY bedrijfsnaam ASC");

// Haal de lijst van functies op (alfabetisch gesorteerd)
$functies_result = $conn->query("SELECT id, functienaam FROM functies ORDER BY functienaam ASC");
?>

<?php echo FormHelpers::getRequiredFieldsCSS(); ?>

<h1 class="mt-5">Klant bijwerken</h1>

<?php echo FormHelpers::createRequiredFieldsInfo(); ?>

<form method="post" action="update_klant.php">
    <input type="hidden" name="id" value="<?php echo isset($klant['id']) ? $klant['id'] : ''; ?>">
    
    <div class="row mb-3">
        <div class="col">
            <?php echo FormHelpers::createTextInput('voornaam', 'Voornaam', false, isset($klant['voornaam']) ? $klant['voornaam'] : ''); ?>
        </div>
        <div class="col">
            <?php echo FormHelpers::createTextInput('achternaam', 'Achternaam', true, isset($klant['achternaam']) ? $klant['achternaam'] : ''); ?>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col">
            <?php echo FormHelpers::createTelInput('telefoonnummer_mobiel', 'Telefoonnummer Mobiel', false, isset($klant['telefoonnummer_mobiel']) ? $klant['telefoonnummer_mobiel'] : '', '+31 6 12 34 56 78'); ?>
        </div>
        <div class="col">
            <?php echo FormHelpers::createTelInput('telefoonnummer_vast', 'Telefoonnummer Vast', false, isset($klant['telefoonnummer_vast']) ? $klant['telefoonnummer_vast'] : '', '+31 20 123 45 67'); ?>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col">
            <?php echo FormHelpers::createEmailInput('email', 'Email', false, isset($klant['email']) ? $klant['email'] : '', 'naam@voorbeeld.nl'); ?>
        </div>
        <div class="col">
            <?php echo FormHelpers::createLabel('functie_id', 'Functie', false); ?>
            <div class="input-group">
                <select class="form-control" id="functie_id" name="functie_id">
                    <option value="">Selecteer een functie</option>
                    <?php
                    if ($functies_result->num_rows > 0) {
                        while($row = $functies_result->fetch_assoc()) {
                            $selected = isset($klant['functie_id']) && $row["id"] == $klant['functie_id'] ? 'selected' : '';
                            echo "<option value='" . $row["id"] . "' $selected>" . htmlspecialchars($row["functienaam"], ENT_QUOTES, 'UTF-8') . "</option>";
                        }
                    }
                    ?>
                    <option value="other">Nieuwe functie toevoegen</option>
                </select>
                <input type="text" class="form-control d-none" id="nieuwe_functie" name="nieuwe_functie" placeholder="Voer nieuwe functie in">
            </div>
        </div>
    </div>
    
    <div class="mb-3">
        <?php echo FormHelpers::createLabel('bedrijf_id', 'Bedrijf', false); ?>
        <select class="form-control" id="bedrijf_id" name="bedrijf_id">
            <option value="">Selecteer een bedrijf</option>
            <?php
            if ($bedrijven_result->num_rows > 0) {
                while($row = $bedrijven_result->fetch_assoc()) {
                    $selected = isset($klant['bedrijf_id']) && $row["id"] == $klant['bedrijf_id'] ? 'selected' : '';
                    echo "<option value='" . $row["id"] . "' $selected>" . htmlspecialchars($row["bedrijfsnaam"], ENT_QUOTES, 'UTF-8') . "</option>";
                }
            }
            ?>
        </select>
    </div>
    
    <?php echo FormHelpers::createTextarea('notities', 'Notities', false, isset($klant['notities']) ? $klant['notities'] : '', 3, 'Vrije notities en opmerkingen over deze klant...'); ?>
    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary">Bijwerken</button>
        <form method="post" action="delete_klant.php" onsubmit="return confirm('Weet u zeker dat u deze klant wilt verwijderen?');">
            <input type="hidden" name="id" value="<?php echo isset($klant['id']) ? $klant['id'] : ''; ?>">
            <button type="submit" class="btn btn-danger">Verwijder Klant</button>
        </form>
    </div>
</form>

<script>
document.getElementById('functie_id').addEventListener('change', function() {
    var nieuweFunctieInput = document.getElementById('nieuwe_functie');
    if (this.value === 'other') {
        nieuweFunctieInput.classList.remove('d-none');
        nieuweFunctieInput.required = true;
    } else {
        nieuweFunctieInput.classList.add('d-none');
        nieuweFunctieInput.required = false;
    }
});
</script>

<?php include '../includes/footer.php'; ?>