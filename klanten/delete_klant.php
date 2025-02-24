<?php
define('SECURE', true);
include '../config/db_connect.php';
include '../includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Voorbereiden van een SQL statement
    $stmt = $conn->prepare("DELETE FROM klanten WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Uitvoeren van het statement
    if ($stmt->execute() === TRUE) {
        echo "<div class='alert alert-success mt-3'>Record deleted successfully</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Error deleting record: " . $stmt->error . "</div>";
    }

    // Sluiten van het statement
    $stmt->close();
    $conn->close();
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Voorbereiden van een SQL statement
        $stmt = $conn->prepare("SELECT * FROM klanten WHERE id = ?");
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Klant verwijderen</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Klant verwijderen</h1>
        <form method="post" action="delete_klant.php">
            <input type="hidden" name="id" value="<?php echo $klant['id']; ?>">
            <div class="mb-3">
                <label for="voornaam" class="form-label">Voornaam</label>
                <input type="text" class="form-control" id="voornaam" name="voornaam" value="<?php echo $klant['voornaam']; ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="achternaam" class="form-label">Achternaam</label>
                <input type="text" class="form-control" id="achternaam" name="achternaam" value="<?php echo $klant['achternaam']; ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="telefoonnummer" class="form-label">Telefoonnummer</label>
                <input type="text" class="form-control" id="telefoonnummer" name="telefoonnummer" value="<?php echo $klant['telefoonnummer']; ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $klant['email']; ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="functie" class="form-label">Functie</label>
                <input type="text" class="form-control" id="functie" name="functie" value="<?php echo $klant['functie']; ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="bedrijf_id" class="form-label">Bedrijf</label>
                <select class="form-control" id="bedrijf_id" name="bedrijf_id" disabled>
                    <option value="">Selecteer een bedrijf</option>
                    <?php
                    $bedrijven_result = $conn->query("SELECT id, bedrijfsnaam FROM bedrijven");
                    if ($bedrijven_result->num_rows > 0) {
                        while($row = $bedrijven_result->fetch_assoc()) {
                            $selected = $row["id"] == $klant['bedrijf_id'] ? 'selected' : '';
                            echo "<option value='" . $row["id"] . "' $selected>" . $row["bedrijfsnaam"] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="notities" class="form-label">Notities</label>
                <textarea class="form-control" id="notities" name="notities" rows="3" disabled><?php echo $klant['notities']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-danger">Verwijderen</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>