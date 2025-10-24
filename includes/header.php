<!DOCTYPE html>
<html>
<head>
    <title>VillaKlant</title>
    <?php
    // Eenvoudige en betrouwbare path detectie
    $current_file = $_SERVER['SCRIPT_NAME'];
    $base_path = '';
    
    // Als we in een subdirectory zijn (bevat / na VillaKlant of niet in root)
    if (strpos($current_file, '/klanten/') !== false || 
        strpos($current_file, '/bedrijf/') !== false || 
        strpos($current_file, '/relatie/') !== false) {
        $base_path = '../';
    }
    
    // Debug info (kan later weggehaald worden)
    // echo "<!-- Current file: $current_file, Base path: '$base_path' -->";
    ?>
    <link rel="stylesheet" href="<?php echo $base_path; ?>CSS/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?php echo $base_path; ?>index.php">
            <img src="<?php echo $base_path; ?>CSS/Villa-ProCtrl-Logo.svg" alt="Villa-ProCtrl Logo" class="logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_path; ?>klanten/create_klant.php">Klant toevoegen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_path; ?>klanten/read_klant.php">Klanten bekijken</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_path; ?>klanten/search_klant.php">Klant zoeken</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_path; ?>bedrijf/create_bedrijf.php">Bedrijf toevoegen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_path; ?>bedrijf/read_bedrijf.php">Bedrijven bekijken</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_path; ?>bedrijf/search_bedrijf.php">Bedrijf zoeken</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_path; ?>relatie/index.php">Relatie Zoeken</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">