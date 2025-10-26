<?php
define('SECURE', true);
include '../config/db_connect.php';
include '../config/phone_number_formatter.php';
include '../includes/header.php';

$formatter = new PhoneNumberFormatter();
$search_query = isset($_GET['query']) ? trim($_GET['query']) : '';
$bedrijf_id = isset($_GET['bedrijf_id']) ? (int)$_GET['bedrijf_id'] : 0;
$klant_id = isset($_GET['klant_id']) ? (int)$_GET['klant_id'] : 0;
$bedrijven_results = [];
$klanten_results = [];
$selected_bedrijf = null;
$search_situation = 'no_results'; // Default: geen resultaten
$original_klanten_count = 0; // Voor display van collega's aantal

// Direct navigation naar specifieke klant (Situatie 1)
if ($klant_id > 0) {
    // Haal specifieke klant op
    $klant_sql = "SELECT klanten.*, bedrijven.bedrijfsnaam, bedrijven.land, functies.functienaam 
                  FROM klanten 
                  JOIN bedrijven ON klanten.bedrijf_id = bedrijven.id 
                  JOIN functies ON klanten.functie_id = functies.id 
                  WHERE klanten.id = ?";
    $klant_stmt = $conn->prepare($klant_sql);
    $klant_stmt->bind_param("i", $klant_id);
    $klant_stmt->execute();
    $klant_result = $klant_stmt->get_result();
    
    if ($row = $klant_result->fetch_assoc()) {
        $klanten_results[] = $row;
        $bedrijf_id = $row['bedrijf_id']; // Zet bedrijf_id voor verdere verwerking
    }
    $klant_stmt->close();
    
    // Update search_query voor display
    if (!empty($klanten_results)) {
        $search_query = $klanten_results[0]['voornaam'] . ' ' . $klanten_results[0]['achternaam'];
    }
}

// Direct navigation naar specifiek bedrijf (Situatie 2)
if ($bedrijf_id > 0 && empty($klanten_results)) {
    // Haal specifiek bedrijf op
    $bedrijf_sql = "SELECT * FROM bedrijven WHERE id = ?";
    $bedrijf_stmt = $conn->prepare($bedrijf_sql);
    $bedrijf_stmt->bind_param("i", $bedrijf_id);
    $bedrijf_stmt->execute();
    $bedrijf_result = $bedrijf_stmt->get_result();
    
    if ($row = $bedrijf_result->fetch_assoc()) {
        $bedrijven_results[] = $row;
        $search_query = $row['bedrijfsnaam'];
        
        // Haal alle werknemers van dit bedrijf op voor het template
        $klant_sql = "SELECT klanten.*, bedrijven.bedrijfsnaam, bedrijven.land, functies.functienaam 
                      FROM klanten 
                      JOIN bedrijven ON klanten.bedrijf_id = bedrijven.id 
                      LEFT JOIN functies ON klanten.functie_id = functies.id 
                      WHERE bedrijven.id = ?";
        
        $klant_stmt = $conn->prepare($klant_sql);
        $klant_stmt->bind_param("i", $bedrijf_id);
        $klant_stmt->execute();
        $klant_result = $klant_stmt->get_result();
        
        while ($klant_row = $klant_result->fetch_assoc()) {
            $klanten_results[] = $klant_row;
        }
        $klant_stmt->close();
    }
    $bedrijf_stmt->close();
}

if (!empty($search_query) && $klant_id == 0 && $bedrijf_id == 0) {
    // Zoeken in bedrijven
    $bedrijf_sql = "SELECT * FROM bedrijven WHERE 
                   bedrijfsnaam LIKE ? OR 
                   straat LIKE ? OR 
                   woonplaats LIKE ? OR 
                   email_facturen LIKE ? OR 
                   website LIKE ? OR 
                   telefoonnummer LIKE ? OR 
                   notities LIKE ? OR 
                   land LIKE ?";
    
    $bedrijf_stmt = $conn->prepare($bedrijf_sql);
    $search_param = "%$search_query%";
    $bedrijf_stmt->bind_param("ssssssss", $search_param, $search_param, $search_param, $search_param, $search_param, $search_param, $search_param, $search_param);
    $bedrijf_stmt->execute();
    $bedrijf_result = $bedrijf_stmt->get_result();
    
    while ($row = $bedrijf_result->fetch_assoc()) {
        $bedrijven_results[] = $row;
    }
    $bedrijf_stmt->close();
    
    // Zoeken in klanten
    $klant_sql = "SELECT klanten.*, bedrijven.bedrijfsnaam, bedrijven.land, functies.functienaam 
                  FROM klanten 
                  JOIN bedrijven ON klanten.bedrijf_id = bedrijven.id 
                  JOIN functies ON klanten.functie_id = functies.id 
                  WHERE voornaam LIKE ? OR 
                        achternaam LIKE ? OR 
                        email LIKE ? OR 
                        telefoonnummer_mobiel LIKE ? OR 
                        telefoonnummer_vast LIKE ? OR 
                        functies.functienaam LIKE ? OR 
                        bedrijven.bedrijfsnaam LIKE ? OR 
                        klanten.notities LIKE ?";
    
    $klant_stmt = $conn->prepare($klant_sql);
    $klant_stmt->bind_param("ssssssss", $search_param, $search_param, $search_param, $search_param, $search_param, $search_param, $search_param, $search_param);
    $klant_stmt->execute();
    $klant_result = $klant_stmt->get_result();
    
    while ($row = $klant_result->fetch_assoc()) {
        $klanten_results[] = $row;
    }
    $klant_stmt->close();
    
    // Voor unique_person situatie: zorg dat het bedrijf van de gevonden persoon beschikbaar is
    if (count($klanten_results) == 1 && count($bedrijven_results) == 0) {
        $gevonden_klant = $klanten_results[0];
        $bedrijf_sql = "SELECT * FROM bedrijven WHERE id = ?";
        $bedrijf_stmt = $conn->prepare($bedrijf_sql);
        $bedrijf_stmt->bind_param("i", $gevonden_klant['bedrijf_id']);
        $bedrijf_stmt->execute();
        $bedrijf_result = $bedrijf_stmt->get_result();
        
        if ($bedrijf_row = $bedrijf_result->fetch_assoc()) {
            $bedrijven_results[] = $bedrijf_row;
        }
        $bedrijf_stmt->close();
    }

    // Bepaal de zoek situatie
    $total_bedrijven = count($bedrijven_results);
    $total_klanten = count($klanten_results);
    $total_results = $total_bedrijven + $total_klanten;

    // Directe navigatie overschrijft situatie detectie
    if (isset($_GET['klant_id']) && $klant_id > 0) {
        $search_situation = 'unique_person'; // Situatie 1: directe klant selectie
    } elseif (isset($_GET['bedrijf_id']) && $bedrijf_id > 0) {
        $search_situation = 'unique_company'; // Situatie 2: directe bedrijf selectie
    } elseif ($total_results == 0) {
        $search_situation = 'no_results'; // Situatie 4
    } elseif ($total_klanten == 1 && $total_bedrijven <= 1) {
        $search_situation = 'unique_person'; // Situatie 1
    } elseif ($total_bedrijven == 1 && $total_klanten == 0) {
        $search_situation = 'unique_company'; // Situatie 2
    } elseif ($total_bedrijven == 1 && $total_klanten > 0) {
        // EERST controleren of het 1 bedrijf + zijn werknemers is
        // Als er 1 bedrijf is en werknemers gevonden, controleer of ze van hetzelfde bedrijf zijn
        $same_company_workers = true;
        $company_id = $bedrijven_results[0]['id'];
        
        foreach ($klanten_results as $klant) {
            if ($klant['bedrijf_id'] != $company_id) {
                $same_company_workers = false;
                break;
            }
        }
        
        if ($same_company_workers) {
            // Alle gevonden werknemers zijn van hetzelfde bedrijf = bedrijfszoekopdracht
            $search_situation = 'unique_company'; // Situatie 2
            // Bewaar het aantal collega's voor de display
            $original_klanten_count = count($klanten_results);
            // Clear klanten_results zodat ze niet als "gevonden werknemers" getoond worden
            $klanten_results = [];
        } else {
            // Werknemers van verschillende bedrijven = persoonszoekopdracht  
            $search_situation = 'unique_person'; // Situatie 1
        }
    } elseif ($total_results > 3 && ($total_bedrijven > 1 || $total_klanten > 1)) {
        // Meerdere bedrijven OF veel resultaten = multiple_results
        $search_situation = 'multiple_results'; // Situatie 3
    } else {
        // Fallback: als we hier komen, kijk naar wat we hebben
        if ($total_klanten > 0 && $total_bedrijven > 0) {
            $search_situation = 'unique_person'; // Waarschijnlijk persoon zoeken
        } elseif ($total_bedrijven > 0) {
            $search_situation = 'unique_company'; // Waarschijnlijk bedrijf zoeken
        } else {
            $search_situation = 'multiple_results'; // Echte fallback
        }
    }
}

// BELANGRIJK: Selecteer het juiste bedrijf - MOET ALTIJD gebeuren na situatie detectie
if ($bedrijf_id > 0) {
    // Als bedrijf_id gegeven, zoek dat specifieke bedrijf
    $bedrijf_stmt = $conn->prepare("SELECT * FROM bedrijven WHERE id = ?");
    $bedrijf_stmt->bind_param("i", $bedrijf_id);
    $bedrijf_stmt->execute();
    $bedrijf_result = $bedrijf_stmt->get_result();
    $selected_bedrijf = $bedrijf_result->fetch_assoc();
    $bedrijf_stmt->close();
} elseif (!empty($bedrijven_results)) {
    $selected_bedrijf = $bedrijven_results[0];
} elseif (!empty($klanten_results)) {
    // Als geen bedrijf gevonden, selecteer bedrijf van eerste klant
    $bedrijf_id_from_klant = $klanten_results[0]['bedrijf_id'];
    $bedrijf_stmt = $conn->prepare("SELECT * FROM bedrijven WHERE id = ?");
    $bedrijf_stmt->bind_param("i", $bedrijf_id_from_klant);
    $bedrijf_stmt->execute();
    $bedrijf_result = $bedrijf_stmt->get_result();
    $selected_bedrijf = $bedrijf_result->fetch_assoc();
    $bedrijf_stmt->close();
}

// Situatie detectie ook voor directe navigatie (buiten search_query)
if (empty($search_query) || (!empty($search_query) && ($klant_id > 0 || $bedrijf_id > 0))) {
    $total_bedrijven = count($bedrijven_results);
    $total_klanten = count($klanten_results);
    
    // Directe navigatie overschrijft situatie detectie
    if (isset($_GET['klant_id']) && $klant_id > 0) {
        $search_situation = 'unique_person'; // Situatie 1: directe klant selectie
    } elseif (isset($_GET['bedrijf_id']) && $bedrijf_id > 0 && empty($klanten_results)) {
        $search_situation = 'unique_company'; // Situatie 2: directe bedrijf selectie
    } elseif ($total_klanten > 0) {
        $search_situation = 'unique_person'; // Situatie 1
    } elseif ($total_bedrijven > 0) {
        $search_situation = 'unique_company'; // Situatie 2  
    }
}

// Haal werknemers op van geselecteerd bedrijf 
$bedrijf_werknemers = [];
if ($selected_bedrijf) {
    if ($search_situation == 'unique_company' && !empty($klanten_results)) {
        // Situatie 2: Exclusief gevonden werknemers van collega's lijst (ze zijn nu geleegd voor display)
        // Maar dit scenario komt niet voor omdat klanten_results leeg is in situatie 2
        $werknemers_sql = "SELECT klanten.*, functies.functienaam 
                           FROM klanten 
                           JOIN functies ON klanten.functie_id = functies.id 
                           WHERE klanten.bedrijf_id = ?";
        $werknemers_stmt = $conn->prepare($werknemers_sql);
        $werknemers_stmt->bind_param("i", $selected_bedrijf['id']);
    } else {
        // Situatie 1 of geen gevonden werknemers: toon alle collega's (inclusief gevonden personen)
        $werknemers_sql = "SELECT klanten.*, functies.functienaam 
                           FROM klanten 
                           JOIN functies ON klanten.functie_id = functies.id 
                           WHERE klanten.bedrijf_id = ?";
        $werknemers_stmt = $conn->prepare($werknemers_sql);
        $werknemers_stmt->bind_param("i", $selected_bedrijf['id']);
    }
    
    $werknemers_stmt->execute();
    $werknemers_result = $werknemers_stmt->get_result();
    
    while ($row = $werknemers_result->fetch_assoc()) {
        $bedrijf_werknemers[] = $row;
    }
    $werknemers_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoekresultaten - VillaKlant Relatie</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .search-header {
            background: white;
            padding: 15px 0;
            border-bottom: 1px solid #dadce0;
            margin-bottom: 20px;
        }
        .search-input-small {
            border: 1px solid #dfe1e5;
            border-radius: 24px;
            padding: 8px 40px 8px 15px;
            font-size: 14px;
            width: 400px;
        }
        .search-results-info {
            color: #70757a;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .bedrijf-info-card {
            background: white;
            border: 1px solid #dadce0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 1px 6px rgba(32,33,36,.28);
        }
        .werknemers-list {
            background: white;
            border: 1px solid #dadce0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            max-height: 400px;
            overflow-y: auto;
        }
        .werknemer-item {
            padding: 10px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: background-color 0.3s ease;
            border-radius: 4px;
            margin-bottom: 5px;
        }
        .werknemer-item:hover {
            background-color: #f8f9fa;
        }
        .werknemer-item:last-child {
            border-bottom: none;
        }
        .werknemer-item.selected {
            background-color: #e3f2fd;
            border-left: 4px solid #4285f4;
        }
        .werknemer-details {
            background: white;
            border: 1px solid #dadce0;
            border-radius: 8px;
            padding: 20px;
            min-height: 200px;
            display: none;
        }
        .werknemer-details.active {
            display: block;
        }
        .bedrijf-title {
            color: #1a73e8;
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 10px;
        }
        .bedrijf-address {
            color: #5f6368;
            font-size: 14px;
            margin-bottom: 8px;
        }
        .bedrijf-email {
            color: #1a73e8;
            font-size: 14px;
        }
        .bedrijf-phone {
            color: #5f6368;
            font-size: 14px;
            margin-top: 4px;
        }
        .bedrijf-website {
            color: #1a73e8;
            font-size: 14px;
            margin-top: 4px;
        }
        .bedrijf-notes {
            color: #5f6368;
            font-size: 13px;
            margin-top: 8px;
            font-style: italic;
            background-color: #f8f9fa;
            padding: 8px;
            border-radius: 4px;
        }
        .werknemer-name {
            font-weight: 500;
            color: #202124;
        }
        .werknemer-functie {
            color: #5f6368;
            font-size: 13px;
        }
        .werknemer-contact {
            color: #1a73e8;
            font-size: 13px;
        }
        .no-results {
            text-align: center;
            padding: 40px;
            color: #5f6368;
        }
        .back-to-search {
            color: #1a73e8;
            text-decoration: none;
            font-size: 14px;
        }
        .back-to-search:hover {
            text-decoration: underline;
            color: #1a73e8;
        }
        .detail-label {
            font-weight: 600;
            color: #202124;
            margin-bottom: 5px;
        }
        .detail-value {
            color: #5f6368;
            margin-bottom: 15px;
        }
        .contact-item {
            background: #f8f9fa;
            padding: 8px 12px;
            border-radius: 4px;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .bedrijf-selector {
            margin-bottom: 20px;
        }
        .bedrijf-option {
            background: white;
            border: 1px solid #dadce0;
            border-radius: 4px;
            padding: 10px 15px;
            margin-right: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .bedrijf-option:hover {
            background: #f8f9fa;
            border-color: #4285f4;
        }
        .bedrijf-option.active {
            background: #e3f2fd;
            border-color: #4285f4;
            color: #1a73e8;
        }
        .werknemer-card {
            background: white;
            border: 1px solid #dadce0;
            border-radius: 8px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(32,33,36,.1);
        }
        .werknemer-card:hover {
            box-shadow: 0 2px 8px rgba(32,33,36,.15);
            border-color: #4285f4;
        }
        .werknemer-card.selected {
            background: #e3f2fd;
            border-color: #4285f4;
        }
        .werknemer-bedrijf {
            color: #5f6368;
            font-size: 13px;
            margin-bottom: 5px;
        }
        .gevonden-werknemers {
            background: white;
            border: 1px solid #dadce0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
        }
        .search-result-item {
            background: white;
            border: 1px solid #dadce0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .search-result-item:hover {
            box-shadow: 0 2px 8px rgba(32,33,36,.15);
            border-color: #4285f4;
        }
        .company-link {
            color: #1a73e8 !important;
            cursor: pointer;
            text-decoration: underline;
            font-weight: 500;
        }
        .company-link:hover {
            color: #174ea6 !important;
        }
        .result-title {
            color: #1a73e8;
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 5px;
        }
        .result-subtitle {
            color: #5f6368;
            font-size: 14px;
            margin-bottom: 8px;
        }
        .result-description {
            color: #202124;
            font-size: 14px;
            line-height: 1.4;
        }
        .create-new-section {
            background: white;
            border: 1px solid #dadce0;
            border-radius: 8px;
            padding: 30px;
            margin-bottom: 20px;
            text-align: center;
        }
        .create-options {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .create-option {
            background: #f8f9fa;
            border: 2px solid #dadce0;
            border-radius: 8px;
            padding: 20px;
            width: 300px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .create-option:hover {
            border-color: #4285f4;
            background: #f1f3f4;
        }
        .create-option h6 {
            color: #1a73e8;
            margin-bottom: 10px;
        }
        .create-option p {
            color: #5f6368;
            font-size: 14px;
            margin-bottom: 0;
        }
    </style>
</head>
<body style="background-color: #f8f9fa;">
    
    <!-- Search Header -->
    <div class="search-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-auto">
                    <a href="index.php" class="back-to-search">← Terug naar zoeken</a>
                </div>
                <div class="col">
                    <form action="search_results.php" method="GET" class="d-flex align-items-center">
                        <input type="text" name="query" value="<?php echo htmlspecialchars($search_query, ENT_QUOTES, 'UTF-8'); ?>" 
                               class="form-control search-input-small" placeholder="Zoeken...">
                        <button type="submit" class="btn btn-link ml-2">🔍</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <?php if (!empty($search_query) || $klant_id > 0 || $bedrijf_id > 0): ?>
            <div class="search-results-info">
                <?php if (!empty($search_query)): ?>
                    Zoekresultaten voor: <strong><?php echo htmlspecialchars($search_query, ENT_QUOTES, 'UTF-8'); ?></strong>
                    (<?php echo count($bedrijven_results); ?> bedrijven, 
                    <?php 
                    if ($search_situation == 'unique_company' && $original_klanten_count > 0) {
                        echo $original_klanten_count . ' collega\'s gevonden';
                    } else {
                        echo count($klanten_results) . ' werknemers gevonden';
                    }
                    ?>)
                <?php elseif ($klant_id > 0): ?>
                    Persoon details: <strong><?php echo !empty($klanten_results) ? htmlspecialchars($klanten_results[0]['voornaam'] . ' ' . $klanten_results[0]['achternaam'], ENT_QUOTES, 'UTF-8') : 'Onbekend'; ?></strong>
                <?php elseif ($bedrijf_id > 0): ?>
                    Bedrijf details: <strong><?php echo $selected_bedrijf ? htmlspecialchars($selected_bedrijf['bedrijfsnaam'], ENT_QUOTES, 'UTF-8') : 'Onbekend'; ?></strong>
                <?php endif; ?>
                <small class="ml-3 text-muted">Situatie: <?php echo $search_situation; ?></small>
            </div>

            <?php if ($search_situation == 'no_results'): ?>
                <!-- SITUATIE 4: Geen resultaten - Aanmaak formulier -->
                <div class="create-new-section">
                    <h4>Geen resultaten gevonden</h4>
                    <p>Er zijn geen bedrijven of werknemers gevonden die overeenkomen met "<?php echo htmlspecialchars($search_query, ENT_QUOTES, 'UTF-8'); ?>"</p>
                    <p>Wilt u een nieuwe invoer toevoegen?</p>
                    
                    <div class="create-options">
                        <div class="create-option" onclick="window.location.href='../bedrijf/create_bedrijf.php'">
                            <h6>🏢 Nieuw Bedrijf</h6>
                            <p>Voeg een nieuw bedrijf toe aan het systeem</p>
                        </div>
                        <div class="create-option" onclick="window.location.href='../klanten/create_klant.php'">
                            <h6>👤 Nieuwe Werknemer</h6>
                            <p>Voeg een nieuwe werknemer toe aan een bestaand bedrijf</p>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="index.php" class="btn btn-primary">← Nieuwe zoekopdracht</a>
                    </div>
                </div>

            <?php elseif ($search_situation == 'multiple_results'): ?>
                <!-- SITUATIE 3: Meerdere resultaten - Google-achtige lijst -->
                <div class="multiple-results-section">
                    <h5>Meerdere resultaten gevonden</h5>
                    <p class="text-muted">Klik op een persoon of bedrijf voor meer details</p>
                    
                    <?php if (!empty($bedrijven_results)): ?>
                        <h6 class="mt-4">🏢 Bedrijven</h6>
                        <?php foreach ($bedrijven_results as $bedrijf): ?>
                            <div class="search-result-item" onclick="selectSpecificResult('company', <?php echo $bedrijf['id']; ?>)">
                                <div class="result-title"><?php echo htmlspecialchars($bedrijf['bedrijfsnaam'], ENT_QUOTES, 'UTF-8'); ?></div>
                                <div class="result-subtitle">
                                    📍 <?php echo htmlspecialchars($bedrijf['woonplaats'], ENT_QUOTES, 'UTF-8') . ', ' . htmlspecialchars($bedrijf['land'], ENT_QUOTES, 'UTF-8'); ?>
                                </div>
                                <div class="result-description">
                                    <?php echo htmlspecialchars($bedrijf['straat'], ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($bedrijf['huisnummer'], ENT_QUOTES, 'UTF-8') . ', ' . htmlspecialchars($bedrijf['postcode'], ENT_QUOTES, 'UTF-8'); ?>
                                    <?php if (!empty($bedrijf['email_facturen'])): ?>
                                        <br>📧 <?php echo htmlspecialchars($bedrijf['email_facturen'], ENT_QUOTES, 'UTF-8'); ?>
                                    <?php endif; ?>
                                    <?php if (!empty($bedrijf['telefoonnummer'])): ?>
                                        <?php if (!empty($bedrijf['email_facturen'])): ?> | <?php else: ?><br><?php endif; ?>📞 <?php echo htmlspecialchars($bedrijf['telefoonnummer'], ENT_QUOTES, 'UTF-8'); ?>
                                    <?php endif; ?>
                                    <?php if (!empty($bedrijf['website'])): ?>
                                        <br>
                                        <?php
                                        // Extract domain for favicon
                                        $website_url = $bedrijf['website'];
                                        $parsed_url = parse_url($website_url);
                                        $domain = isset($parsed_url['host']) ? $parsed_url['host'] : '';
                                        if (empty($domain) && !empty($parsed_url['path'])) {
                                            // Handle URLs without protocol
                                            $domain = parse_url('https://' . $website_url, PHP_URL_HOST);
                                        }
                                        ?>
                                        <?php if (!empty($domain)): ?>
                                            <img src="https://www.google.com/s2/favicons?sz=16&domain=<?php echo urlencode($domain); ?>" 
                                                 alt="Favicon" 
                                                 style="width: 16px; height: 16px; margin-right: 4px; vertical-align: middle;"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                                            <span style="display: none;">🌐 </span>
                                        <?php else: ?>
                                            🌐 
                                        <?php endif; ?>
                                        <?php echo htmlspecialchars($bedrijf['website'], ENT_QUOTES, 'UTF-8'); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <?php if (!empty($klanten_results)): ?>
                        <h6 class="mt-4">👤 Werknemers</h6>
                        <?php foreach ($klanten_results as $klant): ?>
                            <div class="search-result-item" onclick="selectSpecificResult('person', <?php echo $klant['id']; ?>)">
                                <div class="result-title"><?php echo htmlspecialchars($klant['voornaam'], ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($klant['achternaam'], ENT_QUOTES, 'UTF-8'); ?></div>
                                <div class="result-subtitle">
                                    💼 <?php echo htmlspecialchars($klant['functienaam'], ENT_QUOTES, 'UTF-8'); ?> bij 
                                    <span class="company-link" onclick="event.stopPropagation(); selectSpecificResult('company', <?php echo $klant['bedrijf_id']; ?>)">
                                        <?php echo htmlspecialchars($klant['bedrijfsnaam'], ENT_QUOTES, 'UTF-8'); ?>
                                    </span>
                                </div>
                                <div class="result-description">
                                    <?php if (!empty($klant['email'])): ?>📧 <?php echo htmlspecialchars($klant['email'], ENT_QUOTES, 'UTF-8'); ?><?php endif; ?>
                                    <?php if (!empty($klant['telefoonnummer_mobiel'])): ?>
                                        <?php if (!empty($klant['email'])): ?> | <?php endif; ?>📱 <?php echo htmlspecialchars($formatter->formatPhoneNumber($klant['telefoonnummer_mobiel'], $klant['land']), ENT_QUOTES, 'UTF-8'); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <!-- SITUATIE 1 & 2: Unieke persoon of uniek bedrijf -->
                
                <!-- Rij 1: Bedrijfsinformatie (4/5) + Collega's lijst (1/5) -->
                <div class="row">
                    <!-- Bedrijfsinformatie - 4/5 breed -->
                    <div class="col-lg-8 col-md-7">
                        <?php if ($selected_bedrijf): ?>
                            <div class="bedrijf-info-card" id="bedrijfInfo">
                                <div class="bedrijf-title"><?php echo htmlspecialchars($selected_bedrijf['bedrijfsnaam'], ENT_QUOTES, 'UTF-8'); ?></div>
                                <div class="bedrijf-address">
                                    <?php 
                                    echo htmlspecialchars($selected_bedrijf['straat'], ENT_QUOTES, 'UTF-8') . " " . 
                                         htmlspecialchars($selected_bedrijf['huisnummer'], ENT_QUOTES, 'UTF-8') . "<br>" .
                                         htmlspecialchars($selected_bedrijf['postcode'], ENT_QUOTES, 'UTF-8') . " " . 
                                         htmlspecialchars($selected_bedrijf['woonplaats'], ENT_QUOTES, 'UTF-8') . "<br>" .
                                         htmlspecialchars($selected_bedrijf['land'], ENT_QUOTES, 'UTF-8');
                                    ?>
                                </div>
                                <div class="bedrijf-email">
                                    📧 <a href="mailto:<?php echo htmlspecialchars($selected_bedrijf['email_facturen'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <?php echo htmlspecialchars($selected_bedrijf['email_facturen'], ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                </div>
                                <?php if (!empty($selected_bedrijf['telefoonnummer'])): ?>
                                <div class="bedrijf-phone">
                                    📞 <?php echo htmlspecialchars($selected_bedrijf['telefoonnummer'], ENT_QUOTES, 'UTF-8'); ?>
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($selected_bedrijf['website'])): ?>
                                <div class="bedrijf-website">
                                    <?php
                                    // Extract domain for favicon
                                    $website_url = $selected_bedrijf['website'];
                                    $parsed_url = parse_url($website_url);
                                    $domain = isset($parsed_url['host']) ? $parsed_url['host'] : '';
                                    if (empty($domain) && !empty($parsed_url['path'])) {
                                        // Handle URLs without protocol
                                        $domain = parse_url('https://' . $website_url, PHP_URL_HOST);
                                    }
                                    ?>
                                    <?php if (!empty($domain)): ?>
                                        <img src="https://www.google.com/s2/favicons?sz=16&domain=<?php echo urlencode($domain); ?>" 
                                             alt="Favicon" 
                                             style="width: 16px; height: 16px; margin-right: 6px; vertical-align: middle;"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                                        <span style="display: none;">🌐 </span>
                                    <?php else: ?>
                                        🌐 
                                    <?php endif; ?>
                                    <a href="<?php echo htmlspecialchars($selected_bedrijf['website'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank">
                                        <?php echo htmlspecialchars($selected_bedrijf['website'], ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($selected_bedrijf['notities'])): ?>
                                <div class="bedrijf-notes">
                                    📝 <?php echo nl2br(htmlspecialchars($selected_bedrijf['notities'], ENT_QUOTES, 'UTF-8')); ?>
                                </div>
                                <?php endif; ?>
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <strong><?php echo count($bedrijf_werknemers); ?></strong> 
                                        <?php if ($search_situation == 'unique_person'): ?>
                                            collega's in dit bedrijf
                                            <br><em>(inclusief gevonden persoon in onderstaand overzicht)</em>
                                        <?php else: ?>
                                            andere collega's in dit bedrijf
                                        <?php endif; ?>
                                    </small>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Collega's lijst - 1/5 breed -->
                    <div class="col-lg-4 col-md-5">
                        <div class="werknemers-list">
                            <h6 class="mb-3">
                                Collega's
                            </h6>
                            <?php if (!empty($bedrijf_werknemers)): ?>
                                <?php foreach ($bedrijf_werknemers as $index => $werknemer): ?>
                                    <div class="werknemer-item" onclick="showWerknemerDetails(<?php echo $werknemer['id']; ?>, this)" 
                                         data-werknemer='<?php echo json_encode($werknemer); ?>'>
                                        <div class="werknemer-name">
                                            <?php echo htmlspecialchars($werknemer['voornaam'], ENT_QUOTES, 'UTF-8') . " " . 
                                                      htmlspecialchars($werknemer['achternaam'], ENT_QUOTES, 'UTF-8'); ?>
                                        </div>
                                        <div class="werknemer-functie">
                                            <?php echo htmlspecialchars($werknemer['functienaam'], ENT_QUOTES, 'UTF-8'); ?>
                                        </div>
                                        <?php if (!empty($werknemer['telefoonnummer_mobiel'])): ?>
                                            <div class="werknemer-contact">
                                                📱 <?php echo htmlspecialchars($formatter->formatPhoneNumber($werknemer['telefoonnummer_mobiel'], $selected_bedrijf['land']), ENT_QUOTES, 'UTF-8'); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-muted">
                                    Geen collega's gevonden
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Rij 2: Gevonden werknemers of geselecteerde details - 4/5 breed -->
                <div class="row">
                    <div class="col-lg-8 col-md-7">
                        <!-- RELATIE-BLOK: Consistent voor alle situaties -->
                        <div class="werknemer-details" id="werknemerDetails" style="display: block;">
                            <?php if ($search_situation == 'unique_person' && !empty($klanten_results)): ?>
                                <!-- Situatie 1: Toon automatisch de eerste gevonden werknemer -->
                                <?php 
                                $first_klant = $klanten_results[0];
                                ?>
                                <h5><?php echo htmlspecialchars($first_klant['voornaam'], ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($first_klant['achternaam'], ENT_QUOTES, 'UTF-8'); ?></h5>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="detail-label">Functie</div>
                                        <div class="detail-value"><?php echo htmlspecialchars($first_klant['functienaam'], ENT_QUOTES, 'UTF-8'); ?></div>
                                        
                                        <div class="detail-label">Bedrijf</div>
                                        <div class="detail-value"><?php echo htmlspecialchars($first_klant['bedrijfsnaam'], ENT_QUOTES, 'UTF-8'); ?></div>
                                        
                                        <div class="detail-label">Email</div>
                                        <div class="detail-value">
                                            <?php if (!empty($first_klant['email'])): ?>
                                                <a href="mailto:<?php echo htmlspecialchars($first_klant['email'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($first_klant['email'], ENT_QUOTES, 'UTF-8'); ?></a>
                                            <?php else: ?>
                                                <span class="text-muted">Niet opgegeven</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="detail-label">Contactgegevens</div>
                                        <?php if (!empty($first_klant['telefoonnummer_mobiel'])): ?>
                                            <div class="contact-item">📱 Mobiel: <?php echo htmlspecialchars($formatter->formatPhoneNumber($first_klant['telefoonnummer_mobiel'], $first_klant['land']), ENT_QUOTES, 'UTF-8'); ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($first_klant['telefoonnummer_vast'])): ?>
                                            <div class="contact-item">☎️ Vast: <?php echo htmlspecialchars($formatter->formatPhoneNumber($first_klant['telefoonnummer_vast'], $first_klant['land']), ENT_QUOTES, 'UTF-8'); ?></div>
                                        <?php endif; ?>
                                        <?php if (empty($first_klant['telefoonnummer_mobiel']) && empty($first_klant['telefoonnummer_vast'])): ?>
                                            <div class="text-muted">Geen telefoonnummers opgegeven</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <?php if (!empty($first_klant['notities'])): ?>
                                    <div class="mt-3">
                                        <div class="detail-label">Notities</div>
                                        <div class="detail-value"><?php echo htmlspecialchars($first_klant['notities'], ENT_QUOTES, 'UTF-8'); ?></div>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="mt-4">
                                    <a href="../klanten/update_klant.php?id=<?php echo $first_klant['id']; ?>" class="btn btn-primary btn-sm">Bewerken</a>
                                    <?php if (!empty($first_klant['email'])): ?>
                                        <a href="mailto:<?php echo htmlspecialchars($first_klant['email'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-secondary btn-sm">Email sturen</a>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <!-- Situatie 2: Click-to-show instructie -->
                                <h6>Selecteer een collega voor meer details</h6>
                                <p class="text-muted">Klik op een collega in de lijst rechts om de volledige informatie te bekijken.</p>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Details van geselecteerde werknemer (altijd aanwezig maar verborgen) -->
                        <div class="werknemer-details" id="werknemerDetailsSecondary" style="display:none;">
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="no-results">
                <h5>Voer een zoekterm in</h5>
                <p>Gebruik de zoekbalk bovenaan om te zoeken naar bedrijven of werknemers.</p>
                <a href="index.php" class="btn btn-primary">Terug naar zoeken</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function showWerknemerDetails(werknemerId, element) {
            // Remove selection from all items
            document.querySelectorAll('.werknemer-item').forEach(item => {
                item.classList.remove('selected');
            });
            
            // Add selection to clicked item
            element.classList.add('selected');
            
            // Hide gevonden werknemers section
            const gevondenSection = document.getElementById('gevondenWerknemers');
            if (gevondenSection) {
                gevondenSection.style.display = 'none';
            }
            
            // Get werknemer data
            const werknemerData = JSON.parse(element.getAttribute('data-werknemer'));
            
            // Update details panel
            showWerknemerDetailsContent(werknemerData);
        }
        
        function showWerknemerDetailsFromSearch(werknemerId, element) {
            // Remove selection from all search result cards
            document.querySelectorAll('.werknemer-card').forEach(item => {
                item.classList.remove('selected');
            });
            
            // Add selection to clicked card
            element.classList.add('selected');
            
            // Get werknemer data
            const werknemerData = JSON.parse(element.getAttribute('data-werknemer'));
            
            // Update details panel
            showWerknemerDetailsContent(werknemerData);
        }
        
        function showWerknemerDetailsContent(werknemerData) {
            const detailsPanel = document.getElementById('werknemerDetails');
            detailsPanel.innerHTML = `
                <h5>${werknemerData.voornaam} ${werknemerData.achternaam}</h5>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-label">Functie</div>
                        <div class="detail-value">${werknemerData.functienaam}</div>
                        
                        <div class="detail-label">Bedrijf</div>
                        <div class="detail-value">${werknemerData.bedrijfsnaam || 'Onbekend'}</div>
                        
                        <div class="detail-label">Email</div>
                        <div class="detail-value">
                            ${werknemerData.email ? 
                                `<a href="mailto:${werknemerData.email}">${werknemerData.email}</a>` : 
                                '<span class="text-muted">Niet opgegeven</span>'
                            }
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="detail-label">Contactgegevens</div>
                        ${werknemerData.telefoonnummer_mobiel ? 
                            `<div class="contact-item">📱 Mobiel: ${werknemerData.telefoonnummer_mobiel}</div>` : ''
                        }
                        ${werknemerData.telefoonnummer_vast ? 
                            `<div class="contact-item">☎️ Vast: ${werknemerData.telefoonnummer_vast}</div>` : ''
                        }
                        ${!werknemerData.telefoonnummer_mobiel && !werknemerData.telefoonnummer_vast ? 
                            '<div class="text-muted">Geen telefoonnummers opgegeven</div>' : ''
                        }
                    </div>
                </div>
                
                ${werknemerData.notities ? `
                    <div class="mt-3">
                        <div class="detail-label">Notities</div>
                        <div class="detail-value">${werknemerData.notities}</div>
                    </div>
                ` : ''}
                
                <div class="mt-4">
                    <a href="../klanten/update_klant.php?id=${werknemerData.id}" class="btn btn-primary btn-sm">Bewerken</a>
                    <a href="mailto:${werknemerData.email}" class="btn btn-outline-secondary btn-sm">Email sturen</a>
                </div>
            `;
            
            detailsPanel.style.display = 'block';
            detailsPanel.classList.add('active');
        }
        
        function selectBedrijf(bedrijfId, element) {
            // Remove active class from all bedrijf options
            document.querySelectorAll('.bedrijf-option').forEach(option => {
                option.classList.remove('active');
            });
            
            // Add active class to selected option
            element.classList.add('active');
            
            // Reload page with selected bedrijf
            const url = new URL(window.location.href);
            url.searchParams.set('bedrijf_id', bedrijfId);
            window.location.href = url.toString();
        }

        // Nieuwe functie voor het selecteren van specifieke resultaten in multi-result view (Situatie 3)
        function selectSpecificResult(type, id) {
            const currentUrl = new URL(window.location);
            
            if (type === 'company') {
                // Selecteer specifiek bedrijf
                currentUrl.searchParams.set('bedrijf_id', id);
                currentUrl.searchParams.delete('klant_id'); // Remove any person selection
            } else if (type === 'person') {
                // Selecteer specifieke persoon
                currentUrl.searchParams.set('klant_id', id);
                // Keep bedrijf_id if set, otherwise let backend determine it
            }
            
            window.location.href = currentUrl.toString();
        }
    </script>

    <?php include '../includes/footer.php'; ?>
</body>
</html>

<?php
$conn->close();
?>