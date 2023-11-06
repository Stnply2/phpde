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
(32, 6, 'yyy', 'y', 'uploads/6528fb78d06d8_contacts.png', 'qqdaddaa 13', '', 'Stuttgarter', '', '+49', '0', '1314');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(4, 'a', '$2y$10$DSSGobvWvVotDITwDzSvpu8uXxENO2A.zSH6UoQdUxwVLoqJ9Xt5u'),
(5, 'b', '$2y$10$jPJjTbClPHpvj5IUQEKLOuO8QlRlOZgJdg0nwbfNTMdxr4wtHxfwS'),
(6, 'ad', '$2y$10$EhhEcUDxZr7gdEqeTip1U..uLyZQ0g9oPg//COXh.yJVoad4Gam16');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `username_2` (`username`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
