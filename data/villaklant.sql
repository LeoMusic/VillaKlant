-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 01 mrt 2025 om 21:04
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `villaklant`
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
(1, 'Bedrijf onbekend', '', '', '', '', '', ''),
(2, 'Villa ProCtrl ', 'Perklaan ', '20', '9752 GP', 'Haren', 'Nederland', 'Invoiceonly@villaproctrl.com'),
(3, 'Leo Music & Audio', 'Hoofdstraat ', '100', '9501CR', 'Stadskanaal', 'Nederland', 'Leofactuur@leomusic.nl');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `functies`
--

CREATE TABLE `functies` (
  `id` int(11) NOT NULL,
  `functienaam` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `functies`
--

INSERT INTO `functies` (`id`, `functienaam`) VALUES
(1, 'Onbekend'),
(2, 'Directeur'),
(3, 'Technicus');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klanten`
--

CREATE TABLE `klanten` (
  `id` int(11) NOT NULL,
  `voornaam` varchar(255) NOT NULL,
  `achternaam` varchar(255) NOT NULL,
  `telefoonnummer_mobiel` varchar(20) DEFAULT NULL,
  `telefoonnummer_vast` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `functie_id` int(11) DEFAULT NULL,
  `bedrijf_id` int(11) DEFAULT NULL,
  `notities` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `klanten`
--

INSERT INTO `klanten` (`id`, `voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
(1, 'Tonny', 'Koops', '0628788421', '', 'Tonny@villaproctrl.com', 2, 2, ''),
(2, 'Albert', 'Boddema', '0621819760', '0599612346', 'albert@leomusic.nl', 2, 3, ''),
(3, 'Hans', 'Groenhof', '0612232025', '', 'Hans@leomusic.nl', 3, 3, '');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `bedrijven`
--
ALTER TABLE `bedrijven`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `functies`
--
ALTER TABLE `functies`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `klanten`
--
ALTER TABLE `klanten`
  ADD PRIMARY KEY (`id`),
  ADD KEY `functie_id` (`functie_id`),
  ADD KEY `bedrijf_id` (`bedrijf_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `bedrijven`
--
ALTER TABLE `bedrijven`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `functies`
--
ALTER TABLE `functies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `klanten`
--
ALTER TABLE `klanten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `klanten`
--
ALTER TABLE `klanten`
  ADD CONSTRAINT `klanten_ibfk_1` FOREIGN KEY (`functie_id`) REFERENCES `functies` (`id`),
  ADD CONSTRAINT `klanten_ibfk_2` FOREIGN KEY (`bedrijf_id`) REFERENCES `bedrijven` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
