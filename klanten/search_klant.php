<?php
define('SECURE', true);
include '../config/db_connect.php';
include '../includes/header.php';

$search_results = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_term_naam = $_POST['search_term_naam'];
    $search_term_email = $_POST['search_term_email'];
    $search_term_telefoonnummer_mobiel = $_POST['search_term_telefoonnummer_mobiel'];
    $search_term_telefoonnummer_vast = $_POST['search_term_telefoonnummer_vast'];

    $conditions = [];
    $params = [];
    $types = '';

    if (!empty($search_term_naam)) {
        $conditions[] = "(voornaam LIKE ? OR achternaam LIKE ?)";
        $params[] = "%$search_term_naam%";
        $params[] = "%$search_term_naam%";
        $types .= 'ss';
    }
    if (!empty($search_term_email)) {
        $conditions[] = "email LIKE ?";
        $params[] = "%$search_term_email%";
        $types .= 's';
    }
    if (!empty($search_term_telefoonnummer_mobiel)) {
        $conditions[] = "telefoonnummer_mobiel LIKE ?";
        $params[] = "%$search_term_telefoonnummer_mobiel%";
        $types .= 's';
    }
    if (!empty($search_term_telefoonnummer_vast)) {
        $conditions[] = "telefoonnummer_vast LIKE ?";
        $params[] = "%$search_term_telefoonnummer_vast%";
        $types .= 's';
    }

    $sql = "SELECT klanten.id, voornaam, achternaam, telefoonnummer_mobiel, telefoonnummer_vast, email, functies.functienaam AS functie, bedrijfsnaam 
            FROM klanten 
            JOIN bedrijven ON klanten.bedrijf_id = bedrijven.id 
            JOIN functies ON klanten.functie_id = functies.id";

    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    if (count($params) > 0) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $search_results[] = $row;
        }
    }

    $stmt->close();
}
?>

<h1 class="mt-5">Klant zoeken</h1>
<form method="post" action="search_klant.php">
    <div class="mb-3">
        <label for="search_term_naam" class="form-label">Naam</label>
        <input type="text" class="form-control" id="search_term_naam" name="search_term_naam">
    </div>
    <div class="mb-3">
        <label for="search_term_email" class="form-label">Email</label>
        <input type="text" class="form-control" id="search_term_email" name="search_term_email">
    </div>
    <div class="mb-3">
        <label for="search_term_telefoonnummer_mobiel" class="form-label">Telefoonnummer Mobiel</label>
        <input type="text" class="form-control" id="search_term_telefoonnummer_mobiel" name="search_term_telefoonnummer_mobiel">
    </div>
    <div class="mb-3">
        <label for="search_term_telefoonnummer_vast" class="form-label">Telefoonnummer Vast</label>
        <input type="text" class="form-control" id="search_term_telefoonnummer_vast" name="search_term_telefoonnummer_vast">
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
                <th>Telefoonnummer Mobiel</th>
                <th>Telefoonnummer Vast</th>
                <th>Email</th>
                <th>Functie</th>
                <th>Bedrijf</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($search_results as $row): ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><a href="update_klant.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row["voornaam"], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($row["achternaam"], ENT_QUOTES, 'UTF-8'); ?></a></td>
                    <td><?php echo htmlspecialchars($row["telefoonnummer_mobiel"], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row["telefoonnummer_vast"], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row["email"], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row["functie"], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row["bedrijfsnaam"], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <p class="mt-3">Geen resultaten gevonden.</p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>