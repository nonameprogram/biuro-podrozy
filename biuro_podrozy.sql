-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 05 Sty 2022, 16:08
-- Wersja serwera: 10.4.22-MariaDB
-- Wersja PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `biuro_podrozy`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `grupy`
--

CREATE TABLE `grupy` (
  `id_grupy` int(11) NOT NULL,
  `nazwa_grupy` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `grupy`
--

INSERT INTO `grupy` (`id_grupy`, `nazwa_grupy`) VALUES
(1, 'Administrator'),
(2, 'Użytkownik');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kraje`
--

CREATE TABLE `kraje` (
  `id_kraju` int(11) NOT NULL,
  `nazwa_kraju` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `kraje`
--

INSERT INTO `kraje` (`id_kraju`, `nazwa_kraju`) VALUES
(1, 'Polska'),
(2, 'Japonia'),
(3, 'Ameryka');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `oceny`
--

CREATE TABLE `oceny` (
  `rating_id` int(11) NOT NULL,
  `ocena` float NOT NULL,
  `liczba_glosow` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `oceny`
--

INSERT INTO `oceny` (`rating_id`, `ocena`, `liczba_glosow`) VALUES
(2, 4, 0),
(3, 5, 150),
(4, 4, 0),
(5, 4, 0),
(6, 4, 0),
(7, 4, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `oferty`
--

CREATE TABLE `oferty` (
  `id_oferty` int(11) NOT NULL,
  `nazwa_oferty` text NOT NULL,
  `kraj_oferty` varchar(20) NOT NULL,
  `cena_oferty` float NOT NULL,
  `opis` text NOT NULL,
  `miejscowosc` varchar(30) NOT NULL,
  `ilosc_miejsc` int(3) NOT NULL,
  `wolne_miejsca` int(11) NOT NULL,
  `czas_trwania` int(11) NOT NULL,
  `data_od` date NOT NULL,
  `data_do` date NOT NULL,
  `samolot` int(11) DEFAULT NULL,
  `ocena` int(11) DEFAULT NULL,
  `zdjecia` text NOT NULL,
  `tagi` text DEFAULT NULL,
  `nazwa_promocji` int(11) NOT NULL,
  `wartosc_promocji` int(11) NOT NULL,
  `views` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `oferty`
--

INSERT INTO `oferty` (`id_oferty`, `nazwa_oferty`, `kraj_oferty`, `cena_oferty`, `opis`, `miejscowosc`, `ilosc_miejsc`, `wolne_miejsca`, `czas_trwania`, `data_od`, `data_do`, `samolot`, `ocena`, `zdjecia`, `tagi`, `nazwa_promocji`, `wartosc_promocji`, `views`) VALUES
(2, 'Wycieczka do Krakowa', '1', 1600, 'Przykładowy opis wycieczki do Krakowa.', 'Kraków', 10, 8, 4, '2022-12-16', '2022-12-19', 1, 2, 'krakow.jpg', '', 4, 10, 2),
(3, 'Wycieczka do Gdańska', '1', 2500, 'Przykładowy opis wycieczki objazdowej.', 'Gdańsk', 30, 23, 10, '2022-01-07', '2022-12-16', 1, 3, 'gdansk.png', '', 4, 15, 7),
(4, 'Wycieczka do Japonii', '2', 10000, 'Wycieczka objazdowa po Japonii.', 'Shibuya', 10, 10, 14, '2022-01-13', '2022-12-26', 2, 4, 'japan.jpeg', '', 1, 0, 10),
(5, 'Wycieczka do Japonii', '2', 15000, 'Przykładowy opis wycieczki do Tokyo.', 'Tokyo', 20, 20, 10, '2022-02-10', '2022-02-19', 3, 5, 'tokyo.png', '', 1, 0, 0),
(6, 'Wycieczka do New York', '3', 12000, '', 'New York', 24, 24, 14, '2022-03-10', '2022-03-23', 3, 6, 'new_york2.jpg;new_york.jpg', '', 1, 0, 0),
(7, 'Wycieczka do Gdańska', '1', 2500, 'Przykładowy opis wycieczki do Gdańska.', 'Gdańsk', 10, 10, 10, '2022-12-14', '2022-12-23', 3, 7, 'gdynia.jpeg', '', 1, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `promocje`
--

CREATE TABLE `promocje` (
  `id_promocji` int(11) NOT NULL,
  `nazwa_promocj` varchar(30) DEFAULT NULL,
  `rodzaj_promocji` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `promocje`
--

INSERT INTO `promocje` (`id_promocji`, `nazwa_promocj`, `rodzaj_promocji`) VALUES
(1, 'brak', NULL),
(2, 'LATO 2021', NULL),
(3, 'RABAT', NULL),
(4, 'ZIMA 2021', NULL),
(5, 'JESIEŃ 2021', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `samoloty`
--

CREATE TABLE `samoloty` (
  `id_miejsca` int(11) NOT NULL,
  `nazwa_miejsca` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `samoloty`
--

INSERT INTO `samoloty` (`id_miejsca`, `nazwa_miejsca`) VALUES
(1, 'Dojazd własny'),
(2, 'Katowice'),
(3, 'Warszawa'),
(4, 'Zielona Góra');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id_user` int(11) NOT NULL,
  `user` varchar(20) NOT NULL,
  `haslo` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `numer_telefonu` varchar(12) DEFAULT NULL,
  `imie` varchar(30) NOT NULL,
  `nazwisko` varchar(30) NOT NULL,
  `grupa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id_user`, `user`, `haslo`, `email`, `numer_telefonu`, `imie`, `nazwisko`, `grupa`) VALUES
(1, 'user', 'user2', 'user@wp.pl', NULL, 'Brak', 'Brak', 2),
(2, 'admin', 'bartek', 'bartek@wp.pl', NULL, 'Brak', 'Brak', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `id_zam` int(11) NOT NULL,
  `data_zlozenia` datetime NOT NULL,
  `id_oferty` int(11) NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  `cena_zamowienia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `grupy`
--
ALTER TABLE `grupy`
  ADD PRIMARY KEY (`id_grupy`);

--
-- Indeksy dla tabeli `kraje`
--
ALTER TABLE `kraje`
  ADD PRIMARY KEY (`id_kraju`);

--
-- Indeksy dla tabeli `oceny`
--
ALTER TABLE `oceny`
  ADD PRIMARY KEY (`rating_id`);

--
-- Indeksy dla tabeli `oferty`
--
ALTER TABLE `oferty`
  ADD PRIMARY KEY (`id_oferty`);

--
-- Indeksy dla tabeli `promocje`
--
ALTER TABLE `promocje`
  ADD PRIMARY KEY (`id_promocji`);

--
-- Indeksy dla tabeli `samoloty`
--
ALTER TABLE `samoloty`
  ADD PRIMARY KEY (`id_miejsca`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`id_zam`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `grupy`
--
ALTER TABLE `grupy`
  MODIFY `id_grupy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `kraje`
--
ALTER TABLE `kraje`
  MODIFY `id_kraju` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `oceny`
--
ALTER TABLE `oceny`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `oferty`
--
ALTER TABLE `oferty`
  MODIFY `id_oferty` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `promocje`
--
ALTER TABLE `promocje`
  MODIFY `id_promocji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `samoloty`
--
ALTER TABLE `samoloty`
  MODIFY `id_miejsca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `id_zam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
