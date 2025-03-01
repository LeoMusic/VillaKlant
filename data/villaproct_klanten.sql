-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Gegenereerd op: 01 mrt 2025 om 15:10
-- Serverversie: 10.6.20-MariaDB
-- PHP-versie: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `villaproct_klanten`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bedrijven`
--

CREATE TABLE `bedrijven` (
  `id` int(11) NOT NULL,
  `bedrijfsnaam` varchar(255) NOT NULL,
  `straat` varchar(255) NOT NULL,
  `huisnummer` varchar(10) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `woonplaats` varchar(100) NOT NULL,
  `land` varchar(100) NOT NULL,
  `email_facturen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `bedrijven`
--

INSERT INTO `bedrijven` (`id`, `bedrijfsnaam`, `straat`, `huisnummer`, `postcode`, `woonplaats`, `land`, `email_facturen`) VALUES
(1, 'Leo Music & Audio', 'Hoofdstraat', '100', '9501CR', 'Stadskanaal', 'Nederland', 'Leofactuur@leomusic.nl'),
(2, 'Villa ProCtrl', 'Perklaan', '20', '9752 GP', 'Haren', 'Nederland', 'invoiceonly@villaproctrl.com'),
(3, 'NIJM', 'test', '4', '9404KK', 'Assen', 'Estland', 'arjan@nijm.nl'),
(4, 'Gebr. Wichmann GmbH', 'Sophienstr.', '40', '38118', 'Braunschweig', 'Duitsland', 'f.fiechter@wichmann.de'),
(5, 'Dijklander Ziekenhuis Hoorn', 'Maelsonstraat', '3', '1624 NP', 'Hoorn', 'Nederland', 'M.A.A.Nolles-Ligthart@dijklander.nl');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klanten`
--

CREATE TABLE `klanten` (
  `id` int(11) NOT NULL,
  `voornaam` varchar(100) NOT NULL,
  `achternaam` varchar(100) NOT NULL,
  `telefoonnummer` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `functie` varchar(100) NOT NULL,
  `bedrijf_id` int(11) DEFAULT NULL,
  `notities` text DEFAULT NULL,
  `telefoonnummer_vast` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `klanten`
--

INSERT INTO `klanten` (`id`, `voornaam`, `achternaam`, `telefoonnummer`, `email`, `functie`, `bedrijf_id`, `notities`, `telefoonnummer_vast`) VALUES
(2, 'Albert', 'Boddema', '0621819760', 'albert@leomusic.nl', 'Directeur', 1, '4e update ', NULL),
(3, 'Nicole', 'Verhoef', '0648792396', 'nicole@villaproctrl.com', 'Back office', 2, '', NULL),
(4, 'Tonny', 'Koops', '0628788421', 'tonny@villaproctrl.com', 'Directeur', 2, '', NULL),
(5, 'Hans', 'Groenhof', '0612232025', 'hans@leomsic.nl', 'Technicus', 1, '', NULL),
(56, 'Fridolin', 'Fiechter', '004915787813685', 'f.fiechter@wichmann.de', 'Teamleider', 4, '', NULL),
(57, 'Ria', 'Nolles', '0630702401', 'M.A.A.Nolles-Ligthart@dijklander.nl', 'CoÃ¶rdinator Gastvrijheid', 5, '', NULL);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `bedrijven`
--
ALTER TABLE `bedrijven`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `klanten`
--
ALTER TABLE `klanten`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bedrijf_id` (`bedrijf_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `bedrijven`
--
ALTER TABLE `bedrijven`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `klanten`
--
ALTER TABLE `klanten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `klanten`
--
ALTER TABLE `klanten`
  ADD CONSTRAINT `klanten_ibfk_1` FOREIGN KEY (`bedrijf_id`) REFERENCES `bedrijven` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
