<?php
define('SECURE', true);
include '../config/db_connect.php';
include '../includes/header.php';

$search_results = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_term = $_POST['search_term'];
    $search_type = $_POST['search_type'];

    // Voorbereiden van een SQL statement
    $stmt = $conn->prepare("SELECT * FROM bedrijven WHERE $search_type LIKE ?");
    $like_search_term = "%$search_term%";
    $stmt->bind_param("s", $like_search_term);

    // Uitvoeren van het statement
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $search_results[] = $row;
        }
    }

    // Sluiten van het statement
    $stmt->close();
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
            <option value="website">Website</option>
            <option value="telefoonnummer">Telefoonnummer</option>
            <option value="woonplaats">Woonplaats</option>
            <option value="land">Land</option>
            <option value="notities">Notities</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Zoeken</button>
</form>

<?php if (!empty($search_results)): ?>
    <h2 class="mt-5">Zoekresultaten</h2>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Bedrijfsnaam</th>
                <th>Adres</th>
                <th>Contact</th>
                <th>Notities</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($search_results as $row): ?>
                <tr>
                    <td><a href="update_bedrijf.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row["bedrijfsnaam"]); ?></a></td>
                    <td>
                        <?php echo htmlspecialchars($row["straat"]) . " " . htmlspecialchars($row["huisnummer"]); ?><br>
                        <?php echo htmlspecialchars($row["postcode"]) . " " . htmlspecialchars($row["woonplaats"]); ?><br>
                        <?php echo htmlspecialchars($row["land"]); ?>
                    </td>
                    <td>
                        <?php if (!empty($row["telefoonnummer"])): ?>
                            <strong>Tel:</strong> <?php echo htmlspecialchars($row["telefoonnummer"]); ?><br>
                        <?php endif; ?>
                        <?php if (!empty($row["email_facturen"])): ?>
                            <strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($row["email_facturen"]); ?>"><?php echo htmlspecialchars($row["email_facturen"]); ?></a><br>
                        <?php endif; ?>
                        <?php if (!empty($row["website"])): ?>
                            <strong>Website:</strong> <a href="<?php echo htmlspecialchars($row["website"]); ?>" target="_blank"><?php echo htmlspecialchars($row["website"]); ?></a>
                        <?php endif; ?>
                    </td>
                    <td><?php echo !empty($row["notities"]) ? nl2br(htmlspecialchars($row["notities"])) : '-'; ?></td>
                    <td>
                        <a href="update_bedrijf.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Bewerken</a>
                        <a href="read_bedrijf.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">Details</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <h5>Contacten bij dit bedrijf:</h5>
                        <?php
                        $bedrijf_id = $row['id'];
                        $klanten_stmt = $conn->prepare("SELECT voornaam, achternaam, telefoonnummer, email, functie FROM klanten WHERE bedrijf_id = ?");
                        $klanten_stmt->bind_param("i", $bedrijf_id);
                        $klanten_stmt->execute();
                        $klanten_result = $klanten_stmt->get_result();

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
                        <?php $klanten_stmt->close(); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <p class="mt-3">Geen resultaten gevonden.</p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>