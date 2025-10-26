-- SQL script om website, telefoonnummer en notitie velden toe te voegen aan bedrijven tabel

-- Voeg nieuwe velden toe aan bedrijven tabel
ALTER TABLE `bedrijven` 
ADD COLUMN `website` VARCHAR(255) DEFAULT NULL COMMENT 'Website URL van het bedrijf',
ADD COLUMN `telefoonnummer` VARCHAR(20) DEFAULT NULL COMMENT 'Telefoonnummer met Nederlandse formatting',
ADD COLUMN `notities` TEXT DEFAULT NULL COMMENT 'Vrije notities en opmerkingen';


-- Database structuur verificatie
DESCRIBE `bedrijven`;