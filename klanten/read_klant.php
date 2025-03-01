<?php
define('SECURE', true);
include '../config/db_connect.php';
include '../includes/header.php';

// Voorbereiden van een SQL statement
$stmt = $conn->prepare("SELECT klanten.id, voornaam, achternaam, telefoonnummer, email, functie, bedrijfsnaam, notities FROM klanten JOIN bedrijven ON klanten.bedrijf_id = bedrijven.id");
$stmt->execute();
$result = $stmt->get_result();
?>

<h1 class="mt-5">Klanten bekijken</h1>
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
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"]. "</td>
                        <td><a href='update_klant.php?id=" . $row["id"] . "'>" . $row["voornaam"]. " " . $row["achternaam"]. "</a></td>
                        <td>" . $row["telefoonnummer"]. "</td>
                        <td>" . $row["email"]. "</td>
                        <td>" . $row["functie"]. "</td>
                        <td>" . $row["bedrijfsnaam"]. "</td>
                        <td>" . $row["notities"]. "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>0 results</td></tr>";
        }
        $stmt->close();
        $conn->close();
        ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>