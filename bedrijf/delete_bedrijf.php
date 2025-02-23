<?php
define('SECURE', true);
include '../config/db_connect.php';
include '../includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $sql = "DELETE FROM bedrijven WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success mt-3'>Record deleted successfully</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Error deleting record: " . $conn->error . "</div>";
    }

    $conn->close();
}
?>

<h1 class="mt-5">Bedrijf verwijderen</h1>
<form method="post" action="delete_bedrijf.php">
    <div class="mb-3">
        <label for="id" class="form-label">ID</label>
        <input type="text" class="form-control" id="id" name="id" required>
    </div>
    <button type="submit" class="btn btn-danger">Delete</button>
</form>

<?php include '../includes/footer.php'; ?>