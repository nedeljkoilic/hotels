-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2022 at 10:51 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `itp2`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `ID_ADMINISTRATOR` bigint(20) NOT NULL,
  `IME` varchar(1024) NOT NULL,
  `PREZIME` varchar(1024) NOT NULL,
  `email` varchar(1024) DEFAULT NULL,
  `sifra` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`ID_ADMINISTRATOR`, `IME`, `PREZIME`, `email`, `sifra`) VALUES
(1, 'Jovan', 'Jovanovic', 'jovanjovanovic@gmail.com', 'jovanjovanovic');

-- --------------------------------------------------------

--
-- Table structure for table `broj_soba_po_tipu`
--

CREATE TABLE `broj_soba_po_tipu` (
  `ID_BROJ_SOBA_PO_TIPU` int(11) NOT NULL,
  `ID_TIP_SOBE` int(11) NOT NULL,
  `ID_HOTEL` bigint(20) NOT NULL,
  `KOLICINA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `broj_soba_po_tipu`
--

INSERT INTO `broj_soba_po_tipu` (`ID_BROJ_SOBA_PO_TIPU`, `ID_TIP_SOBE`, `ID_HOTEL`, `KOLICINA`) VALUES
(1, 1, 1, 10),
(2, 2, 1, 5),
(3, 3, 1, 5),
(4, 4, 1, 10),
(5, 1, 2, 10),
(6, 2, 2, 5),
(7, 3, 2, 5),
(8, 4, 2, 10),
(9, 1, 3, 10),
(10, 2, 3, 5),
(11, 3, 3, 5),
(12, 4, 3, 10),
(13, 1, 4, 10),
(14, 2, 4, 8),
(15, 3, 4, 8),
(16, 4, 4, 9);

-- --------------------------------------------------------

--
-- Table structure for table `drzava`
--

CREATE TABLE `drzava` (
  `ID_DRZAVA` int(11) NOT NULL,
  `NAZIV` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `drzava`
--

INSERT INTO `drzava` (`ID_DRZAVA`, `NAZIV`) VALUES
(1, 'Srbija'),
(3, 'Bosna i Hercegovina'),
(4, 'Crna Gora'),
(5, 'Hrvatska');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `ID_FEEDBACK` bigint(20) NOT NULL,
  `ID_KORISNIK` bigint(20) NOT NULL,
  `ID_HOTEL` bigint(20) NOT NULL,
  `KOMENTAR` varchar(1024) NOT NULL,
  `OCJENA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`ID_FEEDBACK`, `ID_KORISNIK`, `ID_HOTEL`, `KOMENTAR`, `OCJENA`) VALUES
(0, 1, 1, 'jhs', 4),
(1, 1, 1, 'pohvala kritika...', 5),
(2, 2, 2, 'pohvala kritika...', 4),
(3, 3, 3, 'pohvala kritika...', 3),
(4, 1, 4, 'pohvala kritika...', 2),
(5, 4, 1, 'asd  asd as asd ', 2),
(6, 4, 1, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `grad`
--

CREATE TABLE `grad` (
  `ID_DRZAVA` int(11) NOT NULL,
  `ID_GRAD` int(11) NOT NULL,
  `NAZIV` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grad`
--

INSERT INTO `grad` (`ID_DRZAVA`, `ID_GRAD`, `NAZIV`) VALUES
(1, 1, 'Beograd'),
(3, 2, 'Sarajevo'),
(4, 3, 'Podgorica'),
(5, 4, 'Zagreb');

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE `hotel` (
  `ID_HOTEL` bigint(20) NOT NULL,
  `ID_DRZAVA` int(11) DEFAULT NULL,
  `ID_GRAD` int(11) DEFAULT NULL,
  `NAZIV` varchar(1024) NOT NULL,
  `ADRRESA` varchar(1024) NOT NULL,
  `BR_ZVJEZDICA` int(11) NOT NULL,
  `DNEVNA_CIJENA` float NOT NULL,
  `PARKING` tinyint(1) NOT NULL,
  `INTERNET` tinyint(1) NOT NULL,
  `DORUCAK` tinyint(1) NOT NULL,
  `slika` varchar(1024) DEFAULT NULL,
  `opis` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`ID_HOTEL`, `ID_DRZAVA`, `ID_GRAD`, `NAZIV`, `ADRRESA`, `BR_ZVJEZDICA`, `DNEVNA_CIJENA`, `PARKING`, `INTERNET`, `DORUCAK`, `slika`, `opis`) VALUES
(1, 1, 1, 'Hotel King Beograd', 'Vojvode Stepe Stepanovica 36', 5, 20, 1, 1, 1, 'https://images.unsplash.com/photo-1517840901100-8179e982acb7?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8aG90ZWx8ZW58MHx8MHx8&w=1000&q=80', 'Hotel u centru Beograda'),
(2, 3, 2, 'Hotel King Sarajevo', 'marsala tita 28', 4, 15, 1, 1, 0, 'https://images.unsplash.com/photo-1455587734955-081b22074882?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTN8fGhvdGVsfGVufDB8fDB8fA%3D%3D&w=1000&q=80', 'Hotel u centru Sarajeva'),
(3, 4, 3, 'Hotel King Podgorica', 'Kralja Nikole, 25', 4, 25, 0, 1, 0, 'https://images.unsplash.com/photo-1562133567-b6a0a9c7e6eb?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mjh8fGhvdGVsfGVufDB8fDB8fA%3D%3D&w=1000&q=80', 'Hotel u centru Podgorice'),
(4, 5, 4, 'Hotel King Zagreb', 'Kralja Zvonimira 117', 5, 30, 0, 1, 1, 'https://images.unsplash.com/photo-1537572263231-4314a30d444f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8NDF8fGhvdGVsfGVufDB8fDB8fA%3D%3D&w=1000&q=80', 'Hotel u centru Zagreba');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `ID_KORISNIK` bigint(20) NOT NULL,
  `IME` varchar(1024) NOT NULL,
  `PREZIME` varchar(1024) NOT NULL,
  `BR_TEL` varchar(1024) NOT NULL,
  `EMAIL` varchar(1024) DEFAULT NULL,
  `sifra` varchar(255) DEFAULT NULL,
  `REGISTROVAN` tinyint(1) NOT NULL,
  `BLOKIRAN` tinyint(1) DEFAULT NULL,
  `vkey` varchar(225) DEFAULT NULL,
  `verifikovano` tinyint(1) NOT NULL,
  `vrijeme_kreiranja` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`ID_KORISNIK`, `IME`, `PREZIME`, `BR_TEL`, `EMAIL`, `sifra`, `REGISTROVAN`, `BLOKIRAN`, `vkey`, `verifikovano`, `vrijeme_kreiranja`) VALUES
(1, 'Nedeljko', 'Ilic', '065862848', 'nedeljkoilic999@gmail.com', 'nedeljkoilic', 1, 0, NULL, 1, '2022-02-23 16:11:21.326567'),
(2, 'Andjela', 'Andrijasevic', '066731115', 'andrijasevicandjela244@gmail.com', 'andjelaandrijasevic', 0, 1, NULL, 0, '2022-02-23 16:50:39.662254'),
(3, 'Aleksandar', 'Radic', '066224224', 'aleksandarradic12@gmail.com', 'aleksandarradic', 0, 1, NULL, 0, '2022-02-23 10:06:58.706998'),
(4, 'marko', 'miljanov', '056655665', 'markomiljanov@gmail.com', 'markomiljanov', 1, 0, NULL, 1, '2022-02-23 10:06:58.706998'),
(5, 'stefan', 'stefanovic', '056655558', 'stefanstefanovic@gmail.com', 'stefanstefanovic', 1, 0, NULL, 1, '2022-02-23 10:06:58.706998'),
(6, 'nikola', 'nikolic', '065862862', NULL, NULL, 0, 0, NULL, 0, '2022-02-23 10:06:58.706998'),
(7, 'pavle', 'pavlovic', '123456789', NULL, NULL, 0, 0, NULL, 0, '2022-02-23 10:06:58.706998'),
(8, 'nedeljko', 'nedeljkovic', '789654123', NULL, NULL, 0, 0, NULL, 0, '2022-02-23 10:06:58.706998'),
(9, 'milan', 'milanovic', '741852963', NULL, NULL, 0, 0, NULL, 0, '2022-02-23 10:06:58.706998'),
(10, 'mitar', 'mitrovic', '123654789', NULL, NULL, 0, 0, NULL, 0, '2022-02-23 10:06:58.706998'),
(11, 'natasa', 'bekvalac', '789456321', NULL, NULL, 0, 0, NULL, 0, '2022-02-23 10:06:58.706998'),
(12, 'nedeljko', 'rajkovic', '555666888', NULL, NULL, 0, 0, NULL, 0, '2022-02-23 10:06:58.706998'),
(13, 'nedeljko', 'ilic', '056655', 'nedeljkoilic998@gmail.com', 'asdf', 1, 0, '4d512423a79cd2403a6bac30b69148ef', 1, '2022-02-23 16:46:56.108559'),
(14, 'andjela', 'andrijasevic', '056655', 'andrijasevicandjela24@gmail.com', 'qwer', 1, 0, 'b63aca78a580c20e56cad09dc2449584', 1, '2022-02-23 16:55:51.061689'),
(15, 'Radic', 'Aleksandar', '54545454', 'radicaleksandar4@gmail.com', 'aco', 1, 0, '58abd94afcb097aaa4d80e16934d0e63', 0, '2022-02-23 21:12:18.329444');

-- --------------------------------------------------------

--
-- Table structure for table `menadzer`
--

CREATE TABLE `menadzer` (
  `ID_MENADZER` bigint(20) NOT NULL,
  `IME` varchar(1024) NOT NULL,
  `PREZIME` varchar(1024) NOT NULL,
  `BR_TEL` varchar(1024) NOT NULL,
  `EMAIL` varchar(1024) NOT NULL,
  `sifra` varchar(255) NOT NULL,
  `odobreno` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menadzer`
--

INSERT INTO `menadzer` (`ID_MENADZER`, `IME`, `PREZIME`, `BR_TEL`, `EMAIL`, `sifra`, `odobreno`) VALUES
(2, 'Srdjan', 'Zeljic', '066693852', 'srdjansrdjo@gmail.com', 'srdjanzeljic', 1),
(3, 'miljan', 'miljanic', '123456789', 'miljanmiljanic@gmail.com', 'miljanmiljanic', 0),
(4, 'Aleksa', 'Perisic', '6541316', 'aleksaperisic745@gmail.com', 'radenska', 1);

-- --------------------------------------------------------

--
-- Table structure for table `menadzeri_hotela`
--

CREATE TABLE `menadzeri_hotela` (
  `ID_HOTEL` bigint(20) NOT NULL,
  `ID_MENADZER` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menadzeri_hotela`
--

INSERT INTO `menadzeri_hotela` (`ID_HOTEL`, `ID_MENADZER`) VALUES
(1, 2),
(1, 3),
(2, 2),
(3, 4),
(4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `poruke`
--

CREATE TABLE `poruke` (
  `ID_PORUKE` bigint(20) NOT NULL,
  `ID_HOTEL` bigint(20) DEFAULT NULL,
  `ID_KORISNIK` bigint(20) NOT NULL,
  `id_menadzer` int(11) DEFAULT NULL,
  `TEKST_PORUKE` varchar(1024) NOT NULL,
  `datum` date DEFAULT NULL,
  `vrijeme` time DEFAULT NULL,
  `poslao_korisnik` tinyint(1) DEFAULT NULL,
  `procitano` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `poruke`
--

INSERT INTO `poruke` (`ID_PORUKE`, `ID_HOTEL`, `ID_KORISNIK`, `id_menadzer`, `TEKST_PORUKE`, `datum`, `vrijeme`, `poslao_korisnik`, `procitano`) VALUES
(1, 1, 1, 2, 'neka poruka od korisnika menadzeru', '2022-01-19', '08:34:41', 1, 1),
(2, 1, 1, 2, 'neka poruka od menadzera korisniku', '2022-01-21', '08:35:41', 0, 0),
(3, 1, 1, 2, 'poruka', '2022-02-15', '08:30:34', 1, 1),
(4, 1, 1, 2, 'casdasd', '2022-02-15', '08:43:40', 1, 1),
(5, 1, 1, 2, 'porukica mala', '2022-02-15', '08:54:12', 1, 1),
(6, 1, 1, 2, 'porukica mala', '2022-02-15', '08:57:59', 1, 1),
(7, 1, 1, 2, 'poruka', '2022-02-15', '09:02:42', 1, 1),
(8, 1, 1, 2, 'cao', '2022-02-15', '09:03:51', 1, 1),
(9, 1, 1, 2, 'nedjo budala', '2022-02-15', '10:35:01', 1, 1),
(10, 1, 1, 2, 'zdravo', '2022-02-15', '11:00:04', 1, 1),
(11, 1, 1, 2, 'dsaads', '2022-02-16', '12:35:40', 0, 0),
(12, 1, 1, 2, 'as', '2022-02-16', '12:35:45', 0, 0),
(13, 1, 1, 2, 'as', '2022-02-16', '12:35:48', 0, 0),
(14, 1, 1, 2, 'qwerty', '2022-02-16', '12:36:46', 0, 0),
(15, 1, 1, 2, 'acer', '2022-02-16', '12:42:06', 0, 0),
(16, 1, 1, 2, 'acer12', '2022-02-16', '12:42:11', 0, 0),
(17, 1, 1, 2, 'acer12', '2022-02-16', '12:42:15', 0, 0),
(18, 1, 1, 2, 'acer12', '2022-02-16', '12:42:17', 0, 0),
(19, 1, 1, 2, 'aspire', '2022-02-16', '12:44:52', 0, 0),
(20, 1, 1, 2, 'oiu', '2022-02-16', '12:45:43', 0, 0),
(21, 1, 1, 2, 'kkko', '2022-02-16', '12:49:48', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `prituzbe`
--

CREATE TABLE `prituzbe` (
  `ID_PRITUZBE` bigint(20) NOT NULL,
  `ID_KORISNIK` bigint(20) NOT NULL,
  `KOR_ID_KORISNIK` bigint(20) DEFAULT NULL,
  `ID_HOTEL` bigint(20) DEFAULT NULL,
  `TEKST_PRITUZBE` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prituzbe`
--

INSERT INTO `prituzbe` (`ID_PRITUZBE`, `ID_KORISNIK`, `KOR_ID_KORISNIK`, `ID_HOTEL`, `TEKST_PRITUZBE`) VALUES
(1, 1, 2, NULL, 'neki tekst prituzbe na korisnika'),
(2, 2, NULL, 1, ' neki tekst prituzbe na hotel'),
(3, 4, 1, NULL, 'nepristojan'),
(4, 4, 5, NULL, 'ometanje mira'),
(5, 4, 5, NULL, 'kijk'),
(6, 4, 1, NULL, 'khujg'),
(7, 4, 1, NULL, ''),
(8, 4, NULL, 1, 'losa usluga'),
(9, 4, 1, NULL, 'fsamaskfja aksfjas');

-- --------------------------------------------------------

--
-- Table structure for table `rezervacija`
--

CREATE TABLE `rezervacija` (
  `ID_REZERVACIJA` bigint(20) NOT NULL,
  `ID_HOTEL` bigint(20) NOT NULL,
  `ID_TIP_SOBE` int(11) NOT NULL,
  `ID_KORISNIK` bigint(20) NOT NULL,
  `OD` date NOT NULL,
  `DO` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rezervacija`
--

INSERT INTO `rezervacija` (`ID_REZERVACIJA`, `ID_HOTEL`, `ID_TIP_SOBE`, `ID_KORISNIK`, `OD`, `DO`) VALUES
(1, 1, 1, 1, '2022-01-04', '2022-01-07'),
(2, 3, 3, 2, '2021-12-23', '2021-12-25'),
(3, 1, 1, 3, '2022-01-27', '2022-01-28'),
(4, 1, 1, 2, '2022-01-27', '2022-01-29'),
(5, 1, 1, 4, '2022-01-27', '2022-01-30'),
(6, 1, 1, 5, '2022-01-29', '2022-01-31'),
(7, 1, 1, 1, '2022-01-27', '2022-01-31'),
(8, 1, 1, 1, '2022-01-27', '2022-01-31'),
(9, 1, 1, 1, '2022-01-27', '2022-01-31'),
(10, 1, 1, 1, '2022-01-27', '2022-01-31'),
(11, 1, 1, 1, '2022-01-27', '2022-01-31'),
(12, 1, 1, 7, '2022-01-27', '2022-01-30'),
(13, 1, 1, 8, '2022-01-27', '2022-01-30'),
(14, 3, 3, 9, '2022-01-27', '2022-01-30'),
(15, 1, 3, 10, '2022-01-27', '2022-01-30'),
(16, 1, 1, 4, '2022-02-11', '2022-02-15'),
(17, 1, 1, 4, '2022-02-11', '2022-02-15'),
(18, 1, 1, 4, '2022-02-11', '2022-02-15'),
(19, 3, 3, 12, '2022-02-19', '2022-02-21');

-- --------------------------------------------------------

--
-- Table structure for table `slike_soba`
--

CREATE TABLE `slike_soba` (
  `id_slike_soba` int(11) NOT NULL,
  `id_hotel` int(11) NOT NULL,
  `id_tip_sobe` int(11) NOT NULL,
  `slika` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tip_sobe`
--

CREATE TABLE `tip_sobe` (
  `ID_TIP_SOBE` int(11) NOT NULL,
  `vrsta_sobe` varchar(1024) DEFAULT NULL,
  `koeficijent` float(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tip_sobe`
--

INSERT INTO `tip_sobe` (`ID_TIP_SOBE`, `vrsta_sobe`, `koeficijent`) VALUES
(1, 'jednokrevetna', 1.00),
(2, 'dvokrevetna', 1.85),
(3, 'trokrevetna', 2.75),
(4, 'cetvorokrevetna', 3.65);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`ID_ADMINISTRATOR`);

--
-- Indexes for table `broj_soba_po_tipu`
--
ALTER TABLE `broj_soba_po_tipu`
  ADD PRIMARY KEY (`ID_BROJ_SOBA_PO_TIPU`),
  ADD KEY `FK_BROJ_SOB_HOTEL_SA__HOTEL` (`ID_HOTEL`),
  ADD KEY `FK_BROJ_SOB_TIP_SOBE__TIP_SOBE` (`ID_TIP_SOBE`);

--
-- Indexes for table `drzava`
--
ALTER TABLE `drzava`
  ADD PRIMARY KEY (`ID_DRZAVA`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`ID_FEEDBACK`),
  ADD KEY `FK_FEEDBACK_KORISNIKO_KORISNIK` (`ID_KORISNIK`),
  ADD KEY `FK_FEEDBACK_OCJENA_HO_HOTEL` (`ID_HOTEL`);

--
-- Indexes for table `grad`
--
ALTER TABLE `grad`
  ADD PRIMARY KEY (`ID_DRZAVA`,`ID_GRAD`);

--
-- Indexes for table `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`ID_HOTEL`),
  ADD KEY `FK_HOTEL_HOTELI_U__GRAD` (`ID_DRZAVA`,`ID_GRAD`);

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`ID_KORISNIK`);

--
-- Indexes for table `menadzer`
--
ALTER TABLE `menadzer`
  ADD PRIMARY KEY (`ID_MENADZER`);

--
-- Indexes for table `menadzeri_hotela`
--
ALTER TABLE `menadzeri_hotela`
  ADD PRIMARY KEY (`ID_HOTEL`,`ID_MENADZER`),
  ADD KEY `FK_MENADZER_MENADZERI_MENADZER` (`ID_MENADZER`);

--
-- Indexes for table `poruke`
--
ALTER TABLE `poruke`
  ADD PRIMARY KEY (`ID_PORUKE`),
  ADD KEY `FK_PORUKE_KORISNIK__KORISNIK` (`ID_KORISNIK`),
  ADD KEY `FK_PORUKE_PORUKA_HO_HOTEL` (`ID_HOTEL`);

--
-- Indexes for table `prituzbe`
--
ALTER TABLE `prituzbe`
  ADD PRIMARY KEY (`ID_PRITUZBE`),
  ADD KEY `FK_PRITUZBE_HOTEL_NA__HOTEL` (`ID_HOTEL`),
  ADD KEY `FK_PRITUZBE_KORISNIK__KORISNIK` (`ID_KORISNIK`),
  ADD KEY `FK_PRITUZBE_KORISNIK__KORISNIK1` (`KOR_ID_KORISNIK`);

--
-- Indexes for table `rezervacija`
--
ALTER TABLE `rezervacija`
  ADD PRIMARY KEY (`ID_REZERVACIJA`),
  ADD KEY `FK_REZERVAC_KORISNIK__KORISNIK` (`ID_KORISNIK`),
  ADD KEY `FK_REZERVAC_REZERVISA_HOTEL` (`ID_HOTEL`),
  ADD KEY `FK_REZERVAC_TIP_REZER_TIP_SOBE` (`ID_TIP_SOBE`);

--
-- Indexes for table `slike_soba`
--
ALTER TABLE `slike_soba`
  ADD PRIMARY KEY (`id_slike_soba`);

--
-- Indexes for table `tip_sobe`
--
ALTER TABLE `tip_sobe`
  ADD PRIMARY KEY (`ID_TIP_SOBE`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `drzava`
--
ALTER TABLE `drzava`
  MODIFY `ID_DRZAVA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `slike_soba`
--
ALTER TABLE `slike_soba`
  MODIFY `id_slike_soba` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `broj_soba_po_tipu`
--
ALTER TABLE `broj_soba_po_tipu`
  ADD CONSTRAINT `FK_BROJ_SOB_HOTEL_SA__HOTEL` FOREIGN KEY (`ID_HOTEL`) REFERENCES `hotel` (`ID_HOTEL`),
  ADD CONSTRAINT `FK_BROJ_SOB_TIP_SOBE__TIP_SOBE` FOREIGN KEY (`ID_TIP_SOBE`) REFERENCES `tip_sobe` (`ID_TIP_SOBE`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `FK_FEEDBACK_KORISNIKO_KORISNIK` FOREIGN KEY (`ID_KORISNIK`) REFERENCES `korisnik` (`ID_KORISNIK`),
  ADD CONSTRAINT `FK_FEEDBACK_OCJENA_HO_HOTEL` FOREIGN KEY (`ID_HOTEL`) REFERENCES `hotel` (`ID_HOTEL`);

--
-- Constraints for table `grad`
--
ALTER TABLE `grad`
  ADD CONSTRAINT `FK_GRAD_GRAD_U_DR_DRZAVA` FOREIGN KEY (`ID_DRZAVA`) REFERENCES `drzava` (`ID_DRZAVA`);

--
-- Constraints for table `hotel`
--
ALTER TABLE `hotel`
  ADD CONSTRAINT `FK_HOTEL_HOTELI_U__GRAD` FOREIGN KEY (`ID_DRZAVA`,`ID_GRAD`) REFERENCES `grad` (`ID_DRZAVA`, `ID_GRAD`);

--
-- Constraints for table `menadzeri_hotela`
--
ALTER TABLE `menadzeri_hotela`
  ADD CONSTRAINT `FK_MENADZER_MENADZERI_HOTEL` FOREIGN KEY (`ID_HOTEL`) REFERENCES `hotel` (`ID_HOTEL`),
  ADD CONSTRAINT `FK_MENADZER_MENADZERI_MENADZER` FOREIGN KEY (`ID_MENADZER`) REFERENCES `menadzer` (`ID_MENADZER`);

--
-- Constraints for table `poruke`
--
ALTER TABLE `poruke`
  ADD CONSTRAINT `FK_PORUKE_KORISNIK__KORISNIK` FOREIGN KEY (`ID_KORISNIK`) REFERENCES `korisnik` (`ID_KORISNIK`),
  ADD CONSTRAINT `FK_PORUKE_PORUKA_HO_HOTEL` FOREIGN KEY (`ID_HOTEL`) REFERENCES `hotel` (`ID_HOTEL`);

--
-- Constraints for table `prituzbe`
--
ALTER TABLE `prituzbe`
  ADD CONSTRAINT `FK_PRITUZBE_HOTEL_NA__HOTEL` FOREIGN KEY (`ID_HOTEL`) REFERENCES `hotel` (`ID_HOTEL`),
  ADD CONSTRAINT `FK_PRITUZBE_KORISNIK__KORISNIK` FOREIGN KEY (`ID_KORISNIK`) REFERENCES `korisnik` (`ID_KORISNIK`),
  ADD CONSTRAINT `FK_PRITUZBE_KORISNIK__KORISNIK1` FOREIGN KEY (`KOR_ID_KORISNIK`) REFERENCES `korisnik` (`ID_KORISNIK`);

--
-- Constraints for table `rezervacija`
--
ALTER TABLE `rezervacija`
  ADD CONSTRAINT `FK_REZERVAC_KORISNIK__KORISNIK` FOREIGN KEY (`ID_KORISNIK`) REFERENCES `korisnik` (`ID_KORISNIK`),
  ADD CONSTRAINT `FK_REZERVAC_REZERVISA_HOTEL` FOREIGN KEY (`ID_HOTEL`) REFERENCES `hotel` (`ID_HOTEL`),
  ADD CONSTRAINT `FK_REZERVAC_TIP_REZER_TIP_SOBE` FOREIGN KEY (`ID_TIP_SOBE`) REFERENCES `tip_sobe` (`ID_TIP_SOBE`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
