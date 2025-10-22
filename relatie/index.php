<?php
define('SECURE', true);
include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatie Zoeken - VillaKlant</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .search-container {
            min-height: 70vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .search-logo {
            font-size: 4rem;
            font-weight: 300;
            color: #4285f4;
            margin-bottom: 2rem;
            text-align: center;
        }
        .search-box {
            width: 100%;
            max-width: 600px;
            position: relative;
        }
        .search-input {
            width: 100%;
            border: 1px solid #dfe1e5;
            border-radius: 24px;
            padding: 12px 45px 12px 20px;
            font-size: 16px;
            outline: none;
            box-shadow: 0 2px 5px 1px rgba(64,60,67,.16);
            transition: box-shadow 0.3s ease;
        }
        .search-input:focus {
            box-shadow: 0 2px 8px 1px rgba(64,60,67,.24);
            border-color: transparent;
        }
        .search-button {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: #4285f4;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .search-button:hover {
            background: #3367d6;
        }
        .search-button svg {
            width: 20px;
            height: 20px;
            fill: white;
        }
        .search-suggestions {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px 1px rgba(64,60,67,.16);
            margin-top: 8px;
            padding: 8px 0;
            display: none;
        }
        .suggestion-item {
            padding: 8px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .suggestion-item:hover {
            background-color: #f8f9fa;
        }
        .help-text {
            color: #70757a;
            margin-top: 2rem;
            text-align: center;
            font-size: 14px;
        }
        .quick-actions {
            margin-top: 2rem;
            text-align: center;
        }
        .quick-action-btn {
            background: #f8f9fa;
            border: 1px solid #f8f9fa;
            border-radius: 4px;
            color: #3c4043;
            font-size: 14px;
            margin: 11px 4px;
            padding: 0 16px;
            line-height: 27px;
            height: 36px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .quick-action-btn:hover {
            box-shadow: 0 1px 1px rgba(0,0,0,.1);
            background-color: #f1f3f4;
            border: 1px solid #dadce0;
            color: #202124;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="search-container">
            <!-- Logo/Title -->
            <div class="search-logo">
                VillaKlant<span style="color: #ea4335;">Relatie</span>
            </div>
            
            <!-- Search Form -->
            <div class="search-box">
                <form action="search_results.php" method="GET" id="searchForm">
                    <div class="input-group">
                        <input 
                            type="text" 
                            class="search-input" 
                            name="query" 
                            id="searchQuery"
                            placeholder="Zoek naar bedrijven, werknemers, functies..."
                            autocomplete="off"
                            required
                        >
                        <button type="submit" class="search-button">
                            <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
                
                <!-- Search Suggestions (hidden by default) -->
                <div class="search-suggestions" id="suggestions">
                    <div class="suggestion-item">Villa ProCtrl</div>
                    <div class="suggestion-item">Leo Music & Audio</div>
                    <div class="suggestion-item">Directeur</div>
                    <div class="suggestion-item">Technicus</div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="../klanten/read_klant.php" class="quick-action-btn">Alle Klanten</a>
                <a href="../bedrijf/read_bedrijf.php" class="quick-action-btn">Alle Bedrijven</a>
                <a href="../bedrijf/wie_wat_waar.php" class="quick-action-btn">Wie Wat Waar</a>
            </div>
            
            <!-- Help Text -->
            <div class="help-text">
                Zoek naar bedrijfsnamen, werknemers, functies, email adressen of telefoonnummers
            </div>
        </div>
    </div>
    
    <script>
        // Search suggestions functionality
        const searchInput = document.getElementById('searchQuery');
        const suggestions = document.getElementById('suggestions');
        
        searchInput.addEventListener('focus', function() {
            if (this.value.length > 0) {
                suggestions.style.display = 'block';
            }
        });
        
        searchInput.addEventListener('blur', function() {
            // Delay hiding to allow clicking on suggestions
            setTimeout(() => {
                suggestions.style.display = 'none';
            }, 200);
        });
        
        searchInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                suggestions.style.display = 'block';
                // Here you could add AJAX calls to get real suggestions
            } else {
                suggestions.style.display = 'none';
            }
        });
        
        // Handle suggestion clicks
        document.querySelectorAll('.suggestion-item').forEach(item => {
            item.addEventListener('click', function() {
                searchInput.value = this.textContent;
                suggestions.style.display = 'none';
                document.getElementById('searchForm').submit();
            });
        });
        
        // Handle Enter key
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('searchForm').submit();
            }
        });
    </script>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>