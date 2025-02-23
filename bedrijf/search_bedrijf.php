<?php
define('SECURE', true);
include '../config/db_connect.php';
include '../includes/header.php';

$search_results = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_term = $_POST['search_term'];
    $search_type = $_POST['search_type'];

    $sql = "SELECT * FROM bedrijven WHERE $search_type LIKE '%$search_term%'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $search_results[] = $row;
        }
    }
}
?>

<h1 class="mt-5">Bedrijf zoeken</h1>
<form method="post" action="search_bedrijf.php">
    <div class="mb-3">
        <label for="search_term" class="form-label">Zoekterm</label>
        <input type="text" class="form-control" id="search_term" name="search_term" required>
    </div>
    <div class="mb-3">
        <label for="search_type" class="form-label">Zoek op</label>
        <select class="form-control" id="search_type" name="search_type" required>
            <option value="bedrijfsnaam">Bedrijfsnaam</option>
            <option value="email_facturen">Email</option>
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
                <th>Bedrijfsnaam</th>
                <th>Straat</th>
                <th>Huisnummer</th>
                <th>Postcode</th>
                <th>Woonplaats</th>
                <th>Land</th>
                <th>Email Facturen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($search_results as $row): ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><a href="update_bedrijf.php?id=<?php echo $row['id']; ?>"><?php echo $row["bedrijfsnaam"]; ?></a></td>
                    <td><?php echo $row["straat"]; ?></td>
                    <td><?php echo $row["huisnummer"]; ?></td>
                    <td><?php echo $row["postcode"]; ?></td>
                    <td><?php echo $row["woonplaats"]; ?></td>
                    <td><?php echo $row["land"]; ?></td>
                    <td><?php echo $row["email_facturen"]; ?></td>
                </tr>
                <tr>
                    <td colspan="8">
                        <h5>Contacten bij dit bedrijf:</h5>
                        <?php
                        $bedrijf_id = $row['id'];
                        $klanten_sql = "SELECT voornaam, achternaam, telefoonnummer, email, functie FROM klanten WHERE bedrijf_id = $bedrijf_id";
                        $klanten_result = $conn->query($klanten_sql);

                        if ($klanten_result->num_rows > 0): ?>
                            <ul class="list-group">
                                <?php while($klant = $klanten_result->fetch_assoc()): ?>
                                    <li class="list-group-item">
                                        <?php echo $klant['voornaam'] . ' ' . $klant['achternaam'] . ' - ' . $klant['telefoonnummer'] . ' - ' . $klant['email'] . ' - ' . $klant['functie']; ?>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php else: ?>
                            <p>Geen klanten gevonden.</p>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <p class="mt-3">Geen resultaten gevonden.</p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>