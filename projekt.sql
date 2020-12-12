-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 12 Gru 2020, 01:10
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `projekt`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `events`
--

CREATE TABLE `events` (
  `EventId` int(11) NOT NULL,
  `Name` text COLLATE utf8_polish_ci NOT NULL,
  `Description` text COLLATE utf8_polish_ci NOT NULL,
  `PlaceID` int(11) NOT NULL,
  `TypeID` int(11) NOT NULL,
  `Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `events`
--

INSERT INTO `events` (`EventId`, `Name`, `Description`, `PlaceID`, `TypeID`, `Date`) VALUES
(1, 'Diuna w Kinie Muza', 'Pokaz najbardziej oczekiwanego filmu roku \"Diuna\" w Kinie Muza', 1, 1, '2021-01-19 20:00:00'),
(6, 'Molchat Doma - koncert', 'Trzeci koncert wielkiego post-punkowego odkrycia ostatnich lat - białoruskiego zespołu Molchat Doma', 2, 2, '2021-01-14 19:00:00'),
(7, 'Noc Muzeów w Muzeum Sztuki w Warszawie', 'Muzeum Sztuki w Warszawie po raz kolejny zaprasza na udział w dorocznej Nocy Muzeów', 3, 3, '2021-02-06 10:00:00'),
(8, '\"Skąpiec\" w Teatrze Nowym', 'Kultowa sztuka Moliera wraca do Teatru Nowego', 4, 4, '2021-02-12 18:00:00'),
(9, 'Noc Horrorów', 'Maraton klasycznych reprezentantów filmowego horroru. \"Koszmar z Ulicy Wiązów\", \"Coś\", \"Halloween\" i inne', 5, 1, '2021-02-14 22:00:00'),
(10, 'Koncert w Arenie', 'Koncert niespodzianka. Dalsze szczegóły wkrótce.', 6, 2, '2020-12-23 17:00:00'),
(11, 'Mecz Pogoń Szczecin - Lech Poznań', 'Pogoń Szczecin podejmuje u siebie Kolejorza', 7, 5, '2021-01-03 18:00:00'),
(12, 'Gala Boksu Zawodowego', 'Noc pełna wrażeń dostarczanych przez emocjonujące walki weteranów ringu', 7, 5, '2021-02-07 01:29:20'),
(14, 'Spotkanie z lamą - wystawa', 'Chcesz zobaczyć lamę na żywo? Wpadnij do nas i ją pogłaskaj!', 11, 3, '2020-12-21 12:00:00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `path` text COLLATE utf8_polish_ci NOT NULL,
  `eventID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `photos`
--

INSERT INTO `photos` (`id`, `path`, `eventID`) VALUES
(5, 'art_7.jpg', 7),
(6, 'cinema_1.png', 1),
(15, 'molchat_doma.jpg', 6),
(16, 'skapiec.jpg', 8),
(17, 'horror.png', 9),
(18, 'stadion.jpg', 11),
(19, 'box.jpg', 12),
(20, '_1.jpg', 1),
(21, 'cinema_1_1.png', 1),
(22, 'skapiec_1.jpg', 1),
(23, 'cinema_1_1.png', 1),
(24, '_1.jpg', 1),
(25, 'cinema_1_1.png', 1),
(26, '_1.jpg', 1),
(27, 'cinema_1_1.png', 1),
(28, 'cinema_1_1.png', 1),
(29, 'lama_14.jpg', 14);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `places`
--

CREATE TABLE `places` (
  `PlaceID` int(11) NOT NULL,
  `City` text COLLATE utf8_polish_ci NOT NULL,
  `Street` text COLLATE utf8_polish_ci NOT NULL,
  `Number` int(11) NOT NULL,
  `PostalCode` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `places`
--

INSERT INTO `places` (`PlaceID`, `City`, `Street`, `Number`, `PostalCode`) VALUES
(1, 'Poznań', 'Św. Marcin', 32, '60-423'),
(2, 'Poznań', 'Nowowiejskiego', 8, '61-731'),
(3, 'Warszawa', 'Fort Wola', 22, '01-258'),
(4, 'Kraków', '3 Maja', 1, '30-062'),
(5, 'Gdańsk', 'Lektykarska', 4, '80-831'),
(6, 'Wrocław', 'Kazimierza Wielkiego', 19, '50-077'),
(7, 'Szczecin', 'Narbutta', 50, '02-541'),
(11, 'Fikcja', 'Fikcyjna', 1, '00-000'),
(12, 'Night City', 'Cyberpunkowa', 2077, '20-777');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `types`
--

CREATE TABLE `types` (
  `TypeID` int(11) NOT NULL,
  `Type` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `types`
--

INSERT INTO `types` (`TypeID`, `Type`) VALUES
(1, 'Kino'),
(2, 'Koncert'),
(3, 'Wystawa'),
(4, 'Teatr'),
(5, 'Sport');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Name` text COLLATE utf8_polish_ci NOT NULL,
  `Password` longtext COLLATE utf8_polish_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`UserID`, `Name`, `Password`, `timestamp`) VALUES
(3, 'test.testowy', '$2y$10$aOnQGAi8cyXNgBh0PhHfleOFaciy5HM0VE9WzsYNz15YNPT0XbBVW', '2020-06-12 15:07:05'),
(4, 'jan.kowalski', '$2y$12$zL7hs9FRBmCsDtx.7SpIJ.oIvQoOoKDgvZtAT5Dwx9CuwLAOL/QXK', '2020-06-13 22:55:08'),
(5, 'anna.nowak', '$2y$12$uMfosGGiZt..MlgZM4bmv..R.2sTRz1gfIajr5uOC45S28/w6VUFq', '2020-06-13 22:56:45'),
(6, 'daniel.sobczak', '$2y$10$IYMW5fmjruYWDGTxPc1fIeJOlpebPD7z8T2mymf0Hyh0P3OPlvtaG', '2020-12-06 21:26:16');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`EventId`),
  ADD KEY `PlaceID` (`PlaceID`),
  ADD KEY `TypeID` (`TypeID`);

--
-- Indeksy dla tabeli `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `eventID` (`eventID`);

--
-- Indeksy dla tabeli `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`PlaceID`);

--
-- Indeksy dla tabeli `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`TypeID`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `events`
--
ALTER TABLE `events`
  MODIFY `EventId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT dla tabeli `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT dla tabeli `places`
--
ALTER TABLE `places`
  MODIFY `PlaceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `types`
--
ALTER TABLE `types`
  MODIFY `TypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`PlaceID`) REFERENCES `places` (`PlaceID`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`TypeID`) REFERENCES `types` (`TypeID`);

--
-- Ograniczenia dla tabeli `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`eventID`) REFERENCES `events` (`EventId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
