<?php
define('SECURE', true);
include '../config/db_connect.php';
include '../includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $telefoonnummer = $_POST['telefoonnummer'];
    $email = $_POST['email'];
    $functie = $_POST['functie'];
    $nieuwe_functie = $_POST['nieuwe_functie'];
    $bedrijf_id = $_POST['bedrijf_id'];
    $notities = $_POST['notities'];

    // Gebruik de nieuwe functie als deze is ingevoerd
    if (!empty($nieuwe_functie)) {
        $functie = $nieuwe_functie;
    }

    $sql = "INSERT INTO klanten (voornaam, achternaam, telefoonnummer, email, functie, bedrijf_id, notities) VALUES ('$voornaam', '$achternaam', '$telefoonnummer', '$email', '$functie', '$bedrijf_id', '$notities')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success mt-3'>New record created successfully</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

// Haal de lijst van bedrijven op
$bedrijven_result = $conn->query("SELECT id, bedrijfsnaam FROM bedrijven");

// Haal de lijst van functies op
$functies_result = $conn->query("SELECT DISTINCT functie FROM klanten");
?>

<h1 class="mt-5">Klant toevoegen</h1>
<form method="post" action="create_klant.php">
    <div class="mb-3">
        <label for="voornaam" class="form-label">Voornaam</label>
        <input type="text" class="form-control" id="voornaam" name="voornaam" required>
    </div>
    <div class="mb-3">
        <label for="achternaam" class="form-label">Achternaam</label>
        <input type="text" class="form-control" id="achternaam" name="achternaam" required>
    </div>
    <div class="mb-3">
        <label for="telefoonnummer" class="form-label">Telefoonnummer</label>
        <input type="text" class="form-control" id="telefoonnummer" name="telefoonnummer" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="functie" class="form-label">Functie</label>
        <div class="input-group">
            <select class="form-control" id="functie" name="functie">
                <option value="">Selecteer een functie</option>
                <?php
                if ($functies_result->num_rows > 0) {
                    while($row = $functies_result->fetch_assoc()) {
                        echo "<option value='" . $row["functie"] . "'>" . $row["functie"] . "</option>";
                    }
                }
                ?>
                <option value="other">Nieuwe functie toevoegen</option>
            </select>
            <input type="text" class="form-control d-none" id="nieuwe_functie" name="nieuwe_functie" placeholder="Voer nieuwe functie in">
        </div>
    </div>
    <div class="mb-3">
        <label for="bedrijf_id" class="form-label">Bedrijf</label>
        <div class="input-group">
            <select class="form-control" id="bedrijf_id" name="bedrijf_id" required>
                <option value="">Selecteer een bedrijf</option>
                <?php
                if ($bedrijven_result->num_rows > 0) {
                    while($row = $bedrijven_result->fetch_assoc()) {
                        echo "<option value='" . $row["id"] . "'>" . $row["bedrijfsnaam"] . "</option>";
                    }
                }
                ?>
            </select>
            <div class="input-group-append">
                <a href="../bedrijf/create_bedrijf.php" class="btn btn-outline-secondary">Nieuw bedrijf</a>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <label for="notities" class="form-label">Notities</label>
        <textarea class="form-control" id="notities" name="notities" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
document.getElementById('functie').addEventListener('change', function() {
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