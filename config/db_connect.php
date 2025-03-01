<?php
if (!defined('SECURE')) {
    die('Direct access not permitted');
}

// Database verbinding code
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "villaklant";

// Maak verbinding
$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer verbinding
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Stel de tekenset in op utf8mb4
$conn->set_charset("utf8mb4");
?>