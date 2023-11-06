-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 13. Okt 2023 um 10:21
-- Server-Version: 10.4.28-MariaDB
-- PHP-Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `contact_db`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `salutation` varchar(50) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `country_code` varchar(5) NOT NULL DEFAULT '+49',
  `area_code` varchar(5) NOT NULL DEFAULT '0',
  `phone` varchar(15) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `contacts`
--

INSERT INTO `contacts` (`id`, `user_id`, `first_name`, `last_name`, `image`, `address`, `salutation`, `company`, `email`, `country_code`, `area_code`, `phone`) VALUES
(11, 5, 'TestaccD', 'a', 'uploads/contacts.png', 'Die Straße 11', 'dra', 'dad', 'wi22259@lehre.dhbw-stuttgart.de', '+49', '178', '32744444'),
(12, 5, 'TesmBild', 'BBBB', 'uploads/Standardbild-Datenschutz-1024x446-removebg-preview.png', '', 'dr', '', '', '+49', '0', ''),
(18, 4, 'img', 'img', 'uploads/contacts.png', '', 'dr', 'aa', '', '+49', '0', ''),
(19, 4, 'imggfff', 'img', 'uploads/Standardbild-Datenschutz-1024x446-removebg-preview.png', 'a', '', '', '', '+49', '0', ''),
(32, 6, 'y', 'y', 'uploads/65509034156.png', 'qqdaddaa 13', '', 'Stuttgarter', '', '+49', '0', '1314'),
(33, 7, 'Max', 'Mustermann', 'uploads/defaultimage/defaultimage.png', 'Bolzstraße 1\r\n70173 Stuttgart', 'Herr', 'Musterfirma', 'maxmustermann@hotmail.com', '+49', '0711', '123456'),
(34, 7, 'Anna', 'Zirme', 'uploads/defaultimage/defaultimage.png', 'Tiergartenweg 5\r\n70174 Stuttgart', 'Frau', 'Sauer AG', 'amalia.zirma@yahoo.com', '+49', '0711', '2864761'),
(35, 7, 'Hans', 'Noack', 'uploads/defaultimage/defaultimage.png', 'Traubenstraße 10\r\n70176 Stuttgart', 'Herr', 'Schüler GmbH', 'hansnoack@web.de', '+49', '0711', '492436'),
(36, 7, 'Rafael', 'Kieler', 'uploads/defaultimage/defaultimage.png', 'Tübinger Straße 7\r\n79178 Stuttgart', 'Herr', 'Schuhmann AG', 'rafaelkieler@gmail.com', '+49', '0711', '146274'),
(37, 7, 'Sarah', 'Lehmann', 'uploads/defaultimage/defaultimage.png', 'Römerstraße 16\r\n70178 Stuttgart', 'Frau', 'Rohrbach KG', 's.lehmann@yahoo.com', '+49', '0711', ' 58605'),
(38, 7, 'Patrick', 'Häring', 'uploads/defaultimage/defaultimage.png', 'Silberburgstraße 3\r\n70178 Stuttgart', 'Herr', 'Werner GbR', 'patrickhaering@web.de', '+49', '0711', '140030'),
(39, 7, 'Marie', 'Ruppert', 'uploads/defaultimage/defaultimage.png', 'Turmstraße 2\r\n71364 Winnenden', 'Frau', 'Müller GmbH', 'mruppert@gmail.com', '+49', '07195', '211973'),
(40, 7, 'Lena', 'Schönland', 'uploads/defaultimage/defaultimage.png', 'Kappelbergstraße 8\r\n71332 Waiblingen', 'Frau', 'Sauer AG', 'lena.schoenland@hotmail.com', '+49', '07151', '930891'),
(41, 7, 'Roman', 'Dietz', 'uploads/defaultimage/defaultimage.png', 'Christofstraße 9\r\n71332 Waiblingen', 'Herr', 'Sauer AG', 'roman.dietz@web.de', '+49', '07151', '565454'),
(42, 7, 'Stefanie', 'Jäckel', 'uploads/defaultimage/defaultimage.png', 'Wilhelmstraße 2\r\n76137 Karlsruhe', 'Frau', 'Städtisches Klinikum Karlsruhe gGmbH', 'stefaniejaeckel@gmail.com', '+49', '0721', '812205');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
