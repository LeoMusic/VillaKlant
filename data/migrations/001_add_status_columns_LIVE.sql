-- =====================================================
-- LIVE SERVER DEPLOYMENT - Status Kolommen
-- Voer dit uit via phpMyAdmin of MySQL console
-- Database: villaproct_klanten
-- Datum: 2 november 2025
-- =====================================================

-- STAP 1: Voeg status kolom toe aan bedrijven
ALTER TABLE bedrijven 
ADD COLUMN status ENUM('Actief', 'Prospect', 'Inactief', 'Gesloten', 'Gearchiveerd') 
NOT NULL DEFAULT 'Actief' 
COMMENT 'Status van het bedrijf voor soft delete functionaliteit'
AFTER notities;

-- STAP 2: Zet alle bestaande bedrijven op Actief
UPDATE bedrijven SET status = 'Actief' WHERE status IS NULL OR status = '';

-- STAP 3: Voeg status kolom toe aan klanten
ALTER TABLE klanten 
ADD COLUMN status ENUM('Actief', 'Inactief', 'Uit dienst', 'Gearchiveerd') 
NOT NULL DEFAULT 'Actief'
COMMENT 'Status van de klant voor soft delete functionaliteit'
AFTER notities;

-- STAP 4: Zet alle bestaande klanten op Actief
UPDATE klanten SET status = 'Actief' WHERE status IS NULL OR status = '';

-- =====================================================
-- VERIFICATIE (optioneel - run na deployment)
-- =====================================================
-- SHOW COLUMNS FROM bedrijven LIKE 'status';
-- SHOW COLUMNS FROM klanten LIKE 'status';
-- SELECT status, COUNT(*) as count FROM bedrijven GROUP BY status;
-- SELECT status, COUNT(*) as count FROM klanten GROUP BY status;

-- =====================================================
-- KLAAR! Status management systeem is nu actief.
-- =====================================================
