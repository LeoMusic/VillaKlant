<?php
define('SECURE', true);
include '../config/db_connect.php';
include '../config/form_helpers.php';
include '../includes/header.php';

// Voeg het placeholder bedrijf toe als het nog niet bestaat
$placeholder_bedrijf_id = 1;
$placeholder_bedrijf_naam = 'Bedrijf onbekend';
$conn->query("INSERT IGNORE INTO bedrijven (id, bedrijfsnaam, straat, huisnummer, postcode, woonplaats, land, email_facturen) VALUES ($placeholder_bedrijf_id, '$placeholder_bedrijf_naam', '', '', '', '', '', '')");

// Voeg de placeholder functie toe als deze nog niet bestaat
$placeholder_functie_id = 1;
$placeholder_functie_naam = 'Onbekend';
$conn->query("INSERT IGNORE INTO functies (id, functienaam) VALUES ($placeholder_functie_id, '$placeholder_functie_naam')");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $telefoonnummer_mobiel = $_POST['telefoonnummer_mobiel'];
    $telefoonnummer_vast = $_POST['telefoonnummer_vast'];
    $email = $_POST['email'];
    $functie_id = $_POST['functie_id'];
    $nieuwe_functie = $_POST['nieuwe_functie'];
    $bedrijf_id = $_POST['bedrijf_id'];
    $notities = $_POST['notities'];

    // Gebruik de nieuwe functie als deze is ingevoerd
    if (!empty($nieuwe_functie)) {
        // Voeg de nieuwe functie toe aan de tabel functies
        $stmt = $conn->prepare("INSERT INTO functies (functienaam) VALUES (?)");
        $stmt->bind_param("s", $nieuwe_functie);
        $stmt->execute();
        $functie_id = $stmt->insert_id;
        $stmt->close();
    }

    // Controleer of functie_id is ingevuld, anders zet het op het ID van de placeholder functie
    if (empty($functie_id)) {
        $functie_id = $placeholder_functie_id; // ID van de placeholder functie "Onbekend"
    }

    // Controleer of bedrijf_id is ingevuld, anders zet het op het ID van het placeholder bedrijf
    if (empty($bedrijf_id)) {
        $bedrijf_id = $placeholder_bedrijf_id; // ID van het placeholder bedrijf "Bedrijf onbekend"
    }

    // Voorbereiden van een SQL statement
    $stmt = $conn->prepare("INSERT INTO klanten (voornaam, achternaam, telefoonnummer_mobiel, telefoonnummer_vast, email, functie_id, bedrijf_id, notities) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("sssssiis", $voornaam, $achternaam, $telefoonnummer_mobiel, $telefoonnummer_vast, $email, $functie_id, $bedrijf_id, $notities);

    // Uitvoeren van het statement
    if ($stmt->execute() === TRUE) {
        echo "<div class='alert alert-success mt-3'>New record created successfully</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Error: " . $stmt->error . "</div>";
    }

    // Sluiten van het statement
    $stmt->close();
}

// Haal de lijst van bedrijven op (alfabetisch gesorteerd)
$bedrijven_result = $conn->query("SELECT id, bedrijfsnaam FROM bedrijven ORDER BY bedrijfsnaam ASC");

// Haal de lijst van functies op (alfabetisch gesorteerd)
$functies_result = $conn->query("SELECT id, functienaam FROM functies ORDER BY functienaam ASC");
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klant toevoegen</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php echo FormHelpers::getRequiredFieldsCSS(); ?>
    
    <style>
    #bedrijf_dropdown {
        position: absolute;
        z-index: 1000;
        border: 1px solid #ccc;
        border-radius: 4px;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-top: 2px;
    }
    
    #bedrijf_dropdown .dropdown-item {
        padding: 8px 12px;
        cursor: pointer;
        border-bottom: 1px solid #f8f9fa;
    }
    
    #bedrijf_dropdown .dropdown-item:hover {
        background-color: #f8f9fa;
    }
    
    #bedrijf_dropdown .dropdown-item:last-child {
        border-bottom: none;
    }
    
    .mb-3 {
        position: relative;
    }
    </style>
    
    <div class="container mt-3">
        <h2>Prikbord</h2>
        <textarea class="form-control" placeholder="Ruimte om even gegevens te plakken. Ctrl + V... deze info wordt niet bewaard!" style="width: 1000px; height: 200px;"></textarea>
    </div>

    <h1 class="mt-5">Klant toevoegen</h1>
    
    <?php echo FormHelpers::createRequiredFieldsInfo(); ?>
    
    <form method="post" action="create_klant.php">
        <div class="row mb-3">
            <div class="col">
                <?php echo FormHelpers::createLabel('voornaam', 'Voornaam', false); ?>
                <input type="text" class="form-control" id="voornaam" name="voornaam">
            </div>
            <div class="col">
                <?php echo FormHelpers::createLabel('achternaam', 'Achternaam', true); ?>
                <input type="text" class="form-control" id="achternaam" name="achternaam" required>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col">
                <?php echo FormHelpers::createTelInput('telefoonnummer_mobiel', 'Telefoonnummer Mobiel', false, '', '+31 6 12 34 56 78'); ?>
            </div>
            <div class="col">
                <?php echo FormHelpers::createTelInput('telefoonnummer_vast', 'Telefoonnummer Vast', false, '', '+31 20 123 45 67'); ?>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col">
                <?php echo FormHelpers::createEmailInput('email', 'Email', false, '', 'naam@voorbeeld.nl'); ?>
            </div>
            <div class="col">
                <?php echo FormHelpers::createLabel('functie_id', 'Functie', false); ?>
                <div class="input-group">
                    <select class="form-control" id="functie_id" name="functie_id">
                        <option value="">Selecteer een functie</option>
                        <?php
                        if ($functies_result->num_rows > 0) {
                            while($row = $functies_result->fetch_assoc()) {
                                echo "<option value='" . htmlspecialchars($row["id"], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row["functienaam"], ENT_QUOTES, 'UTF-8') . "</option>";
                            }
                        }
                        ?>
                        <option value="other">Nieuwe functie toevoegen</option>
                    </select>
                    <input type="text" class="form-control d-none" id="nieuwe_functie" name="nieuwe_functie" placeholder="Voer nieuwe functie in">
                </div>
            </div>
        </div>
        
        <div class="mb-3">
            <?php echo FormHelpers::createLabel('bedrijf_id', 'Bedrijf', false); ?>
            <div class="input-group">
                <input type="text" class="form-control" id="bedrijf_search" placeholder="Typ om te zoeken naar bedrijf..." autocomplete="off">
                <select class="form-control d-none" id="bedrijf_id" name="bedrijf_id">
                    <option value="1">Bedrijf onbekend</option>
                    <?php
                    if ($bedrijven_result->num_rows > 0) {
                        while($row = $bedrijven_result->fetch_assoc()) {
                            echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["bedrijfsnaam"], ENT_QUOTES, 'UTF-8') . "</option>";
                        }
                    }
                    ?>
                </select>
                <div class="input-group-append">
                    <a href="../bedrijf/create_bedrijf.php" class="btn btn-outline-secondary">Nieuw bedrijf</a>
                </div>
            </div>
            <div id="bedrijf_dropdown" class="dropdown-menu w-100" style="max-height: 200px; overflow-y: auto; display: none;">
                <!-- Zoekresultaten worden hier dynamisch ingeladen -->
            </div>
        </div>
        
        <?php echo FormHelpers::createTextarea('notities', 'Notities', false, '', 3, 'Vrije notities en opmerkingen over deze klant...'); ?>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <script>
    // Functie selectie - nieuwe functie toevoegen
    document.getElementById('functie_id').addEventListener('change', function() {
        var nieuweFunctieInput = document.getElementById('nieuwe_functie');
        if (this.value === 'other') {
            nieuweFunctieInput.classList.remove('d-none');
            nieuweFunctieInput.required = true;
        } else {
            nieuweFunctieInput.classList.add('d-none');
            nieuweFunctieInput.required = false;
        }
    });

    // Bedrijf zoekfunctionaliteit
    const bedrijfSearch = document.getElementById('bedrijf_search');
    const bedrijfSelect = document.getElementById('bedrijf_id');
    const bedrijfDropdown = document.getElementById('bedrijf_dropdown');
    
    // Haal alle bedrijven op uit de select opties
    const allBedrijven = [];
    for (let i = 0; i < bedrijfSelect.options.length; i++) {
        const option = bedrijfSelect.options[i];
        allBedrijven.push({
            id: option.value,
            naam: option.text
        });
    }

    bedrijfSearch.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        
        if (searchTerm.length === 0) {
            bedrijfDropdown.style.display = 'none';
            bedrijfSelect.value = '1'; // Reset naar "Bedrijf onbekend"
            return;
        }

        // Filter bedrijven
        const filteredBedrijven = allBedrijven.filter(bedrijf => 
            bedrijf.naam.toLowerCase().includes(searchTerm)
        );

        // Bouw dropdown HTML
        let dropdownHTML = '';
        if (filteredBedrijven.length > 0) {
            filteredBedrijven.forEach(bedrijf => {
                dropdownHTML += `<a class="dropdown-item" href="#" data-id="${bedrijf.id}" data-naam="${bedrijf.naam}">${bedrijf.naam}</a>`;
            });
        } else {
            dropdownHTML = '<div class="dropdown-item text-muted">Geen bedrijven gevonden</div>';
        }

        bedrijfDropdown.innerHTML = dropdownHTML;
        bedrijfDropdown.style.display = 'block';
    });

    // Klik op dropdown item
    bedrijfDropdown.addEventListener('click', function(e) {
        e.preventDefault();
        if (e.target.classList.contains('dropdown-item') && e.target.dataset.id) {
            bedrijfSearch.value = e.target.dataset.naam;
            bedrijfSelect.value = e.target.dataset.id;
            bedrijfDropdown.style.display = 'none';
        }
    });

    // Verberg dropdown bij klik buiten het element
    document.addEventListener('click', function(e) {
        if (!bedrijfSearch.contains(e.target) && !bedrijfDropdown.contains(e.target)) {
            bedrijfDropdown.style.display = 'none';
        }
    });

    // Focus op bedrijf search veld
    bedrijfSearch.addEventListener('focus', function() {
        if (this.value.trim().length > 0) {
            bedrijfDropdown.style.display = 'block';
        }
    });
    </script>

    <?php include '../includes/footer.php'; ?>
</body>
</html>