<?php
define('SECURE', true);
include '../config/db_connect.php';
include '../includes/header.php';

$search_results = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_term = $_POST['search_term'];
    $search_type = $_POST['search_type'];

    if ($search_type == 'naam') {
        $sql = "SELECT klanten.id, voornaam, achternaam, telefoonnummer, email, functie, bedrijfsnaam, notities 
                FROM klanten 
                JOIN bedrijven ON klanten.bedrijf_id = bedrijven.id 
                WHERE voornaam LIKE '%$search_term%' OR achternaam LIKE '%$search_term%'";
    } else {
        $sql = "SELECT klanten.id, voornaam, achternaam, telefoonnummer, email, functie, bedrijfsnaam, notities 
                FROM klanten 
                JOIN bedrijven ON klanten.bedrijf_id = bedrijven.id 
                WHERE $search_type LIKE '%$search_term%'";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $search_results[] = $row;
        }
    }
}
?>

<h1 class="mt-5">Klant zoeken</h1>
<form method="post" action="search_klant.php">
    <div class="mb-3">
        <label for="search_term" class="form-label">Zoekterm</label>
        <input type="text" class="form-control" id="search_term" name="search_term" required>
    </div>
    <div class="mb-3">
        <label for="search_type" class="form-label">Zoek op</label>
        <select class="form-control" id="search_type" name="search_type" required>
            <option value="naam">Naam</option>
            <option value="email">Email</option>
            <option value="telefoonnummer">Telefoonnummer</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Zoeken</button>
</form>

<?php if (!empty($search_results)): ?>
    <h2 class="mt-5">Zoekresultaten</h2>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Telefoonnummer</th>
                <th>Email</th>
                <th>Functie</th>
                <th>Bedrijf</th>
                <th>Notities</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($search_results as $row): ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["voornaam"] . " " . $row["achternaam"]; ?></td>
                    <td><?php echo $row["telefoonnummer"]; ?></td>
                    <td><?php echo $row["email"]; ?></td>
                    <td><?php echo $row["functie"]; ?></td>
                    <td><?php echo $row["bedrijfsnaam"]; ?></td>
                    <td><?php echo $row["notities"]; ?></td>
                    <td>
                        <a href="update_klant.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Bewerken</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="mt-5">
        <h3>Asana Taken</h3>
        <div class="btn-group mb-3" role="group" aria-label="Asana Taken">
            <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#offerteForm" aria-expanded="false" aria-controls="offerteForm">Offerte</button>
            <button type="button" class="btn btn-secondary">Terugbelverzoek</button>
            <button type="button" class="btn btn-secondary">Service verzoek</button>
        </div>
        <div class="collapse" id="offerteForm">
            <div class="card card-body">
                <form>
                    <div class="mb-3">
                        <label for="onderwerp" class="form-label">Onderwerp</label>
                        <input type="text" class="form-control" id="onderwerp" name="onderwerp" required>
                    </div>
                    <div class="mb-3">
                        <label for="omschrijving" class="form-label">Omschrijving</label>
                        <textarea class="form-control" id="omschrijving" name="omschrijving" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="afspraken" class="form-label">Afspraken</label>
                        <textarea class="form-control" id="afspraken" name="afspraken" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Verstuur</button>
                </form>
            </div>
        </div>
        <div class="input-group mt-3">
            <button type="button" class="btn btn-secondary">Reactie op</button>
            <input type="text" class="form-control" placeholder="Voer reactie in">
        </div>
    </div>
<?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <p class="mt-3">Geen resultaten gevonden.</p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>