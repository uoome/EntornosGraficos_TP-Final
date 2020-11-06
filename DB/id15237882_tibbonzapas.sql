-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 05, 2020 at 10:30 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id15237882_tibbonzapas`
--

-- --------------------------------------------------------

--
-- Table structure for table `carro_compra`
--

CREATE TABLE `carro_compra` (
  `id_carro` int(11) NOT NULL,
  `total` double NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `carro_compra`
--

INSERT INTO `carro_compra` (`id_carro`, `total`, `id_usuario`) VALUES
(1, 13850, 8),
(2, 10, 8),
(3, 13850, 8),
(4, 13850, 8),
(5, 13850, 8),
(6, 13850, 8),
(7, 13850, 8),
(8, 13850, 8),
(9, 13850, 8),
(10, 13850, 8),
(11, 13850, 8),
(12, 13850, 8),
(13, 13850, 8),
(14, 13850, 8),
(15, 13850, 8),
(16, 0, 8),
(17, 0, 8),
(18, 6850, 1),
(19, 6850, 1),
(20, 6850, 1),
(21, 6850, 1),
(22, 1700, 1),
(23, 18250, 1),
(24, 18250, 1),
(25, 18250, 1),
(26, 18250, 1),
(27, 18250, 1),
(28, 18250, 1),
(29, 18250, 1),
(30, 18250, 1),
(31, 18250, 1),
(32, 18250, 1),
(33, 18250, 1),
(34, 18250, 1),
(35, 18250, 1),
(36, 18250, 1),
(37, 18250, 1),
(38, 18250, 1),
(39, 7100, 12),
(40, 7100, 12),
(41, 5100, 1),
(42, 1750, 1),
(43, 32287.100000000002, 1),
(44, 20891.4, 1),
(45, 13962, 1),
(46, 3450, 1),
(47, 12950, 1),
(48, 1650, 1),
(49, 1750, 1),
(50, 1700, 1),
(51, 1750, 1),
(52, 13400, 1),
(53, 6950, 1),
(54, 8500, 1);

-- --------------------------------------------------------

--
-- Table structure for table `carro_zapatilla`
--

CREATE TABLE `carro_zapatilla` (
  `id_carro_zapatilla` int(11) NOT NULL,
  `id_carro` int(11) NOT NULL,
  `id_zapatilla` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT 0,
  `subtotal_linea` double DEFAULT 0,
  `color` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `talle` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `carro_zapatilla`
--

INSERT INTO `carro_zapatilla` (`id_carro_zapatilla`, `id_carro`, `id_zapatilla`, `cantidad`, `subtotal_linea`, `color`, `talle`) VALUES
(1, 11, 34, 5, 8500, 'Blanco', 41),
(2, 12, 34, 5, 8500, 'Blanco', 41),
(3, 13, 34, 5, 8500, 'Blanco', 41),
(4, 14, 34, 5, 8500, 'Blanco', 41),
(5, 14, 30, 1, 1650, NULL, NULL),
(6, 14, 32, 2, 3700, NULL, NULL),
(7, 15, 34, 5, 8500, 'Blanco', 41),
(8, 15, 30, 1, 1650, NULL, NULL),
(9, 15, 32, 2, 3700, NULL, NULL),
(10, 18, 37, 1, 1750, NULL, NULL),
(11, 18, 31, 3, 5100, 'Negro', 40),
(12, 19, 37, 1, 1750, NULL, NULL),
(13, 19, 31, 3, 5100, 'Negro', 40),
(14, 20, 37, 1, 1750, NULL, NULL),
(15, 20, 31, 3, 5100, 'Negro', 40),
(16, 21, 37, 1, 1750, NULL, NULL),
(17, 21, 31, 3, 5100, 'Negro', 40),
(18, 22, 31, 1, 1700, 'Blanco', 36),
(19, 23, 33, 1, 1750, NULL, NULL),
(20, 23, 30, 10, 16500, NULL, NULL),
(21, 24, 33, 1, 1750, NULL, NULL),
(22, 24, 30, 10, 16500, NULL, NULL),
(23, 25, 33, 1, 1750, NULL, NULL),
(24, 25, 30, 10, 16500, NULL, NULL),
(25, 26, 33, 1, 1750, NULL, NULL),
(26, 26, 30, 10, 16500, NULL, NULL),
(27, 27, 33, 1, 1750, NULL, NULL),
(28, 27, 30, 10, 16500, NULL, NULL),
(29, 28, 33, 1, 1750, NULL, NULL),
(30, 28, 30, 10, 16500, NULL, NULL),
(31, 29, 33, 1, 1750, NULL, NULL),
(32, 29, 30, 10, 16500, NULL, NULL),
(33, 30, 33, 1, 1750, NULL, NULL),
(34, 30, 30, 10, 16500, NULL, NULL),
(35, 31, 33, 1, 1750, NULL, NULL),
(36, 31, 30, 10, 16500, NULL, NULL),
(37, 32, 33, 1, 1750, NULL, NULL),
(38, 32, 30, 10, 16500, NULL, NULL),
(39, 33, 33, 1, 1750, NULL, NULL),
(40, 33, 30, 10, 16500, NULL, NULL),
(41, 34, 33, 1, 1750, NULL, NULL),
(42, 34, 30, 10, 16500, NULL, NULL),
(43, 35, 33, 1, 1750, NULL, NULL),
(44, 35, 30, 10, 16500, NULL, NULL),
(45, 36, 33, 1, 1750, NULL, NULL),
(46, 36, 30, 10, 16500, NULL, NULL),
(47, 37, 33, 1, 1750, NULL, NULL),
(48, 37, 30, 10, 16500, NULL, NULL),
(49, 38, 33, 1, 1750, NULL, NULL),
(50, 38, 30, 10, 16500, NULL, NULL),
(51, 39, 36, 1, 1850, NULL, NULL),
(52, 39, 31, 2, 3400, NULL, NULL),
(53, 39, 32, 1, 1850, NULL, NULL),
(54, 40, 36, 1, 1850, NULL, NULL),
(55, 40, 31, 2, 3400, NULL, NULL),
(56, 40, 32, 1, 1850, NULL, NULL),
(57, 41, 33, 1, 1750, NULL, NULL),
(58, 41, 30, 1, 1650, NULL, NULL),
(59, 41, 31, 1, 1700, NULL, NULL),
(60, 42, 33, 1, 1750, NULL, NULL),
(61, 43, 30, 1, 1650, NULL, NULL),
(62, 43, 44, 3, 28787.100000000002, 'Blanco', 44),
(63, 43, 36, 1, 1850, 'Negro', 40),
(64, 44, 44, 2, 19191.4, 'Negro', 39),
(65, 44, 31, 1, 1700, 'Blanco', 38),
(66, 45, 30, 1, 1650, 'Blanco', 40),
(67, 45, 42, 1, 1212, NULL, NULL),
(68, 45, 32, 6, 11100, NULL, NULL),
(69, 46, 33, 1, 1750, NULL, NULL),
(70, 46, 31, 1, 1700, NULL, NULL),
(71, 47, 32, 7, 12950, NULL, NULL),
(72, 48, 30, 1, 1650, NULL, NULL),
(73, 49, 33, 1, 1750, NULL, NULL),
(74, 50, 31, 1, 1700, NULL, NULL),
(75, 51, 33, 1, 1750, NULL, NULL),
(76, 52, 32, 1, 1850, NULL, NULL),
(77, 52, 30, 7, 11550, NULL, NULL),
(78, 53, 33, 1, 1750, NULL, NULL),
(79, 53, 31, 1, 1700, NULL, NULL),
(80, 53, 32, 1, 1850, NULL, NULL),
(81, 53, 30, 1, 1650, NULL, NULL),
(82, 54, 35, 5, 8500, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `compra`
--

CREATE TABLE `compra` (
  `id_compra` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `carro` int(11) NOT NULL,
  `total` double DEFAULT 0,
  `fecha_compra` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo_pago` tinyint(4) NOT NULL DEFAULT 1,
  `tarjeta` int(11) DEFAULT NULL,
  `direccion_entrega` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `compra`
--

INSERT INTO `compra` (`id_compra`, `usuario`, `carro`, `total`, `fecha_compra`, `tipo_pago`, `tarjeta`, `direccion_entrega`) VALUES
(1, 1, 26, 18250, '2020-10-30 00:12:11', 1, NULL, NULL),
(2, 1, 29, 18250, '2020-10-30 00:16:19', 3, NULL, NULL),
(3, 1, 30, 18250, '2020-10-30 00:16:35', 3, NULL, NULL),
(4, 1, 31, 18250, '2020-10-30 00:19:54', 2, NULL, NULL),
(5, 1, 32, 18250, '2020-10-30 00:20:31', 2, NULL, NULL),
(6, 1, 33, 18250, '2020-10-30 00:25:24', 2, NULL, NULL),
(7, 1, 34, 18250, '2020-10-30 00:26:43', 1, NULL, NULL),
(8, 1, 35, 18250, '2020-10-30 00:33:04', 1, NULL, NULL),
(9, 1, 36, 18250, '2020-10-30 00:33:46', 1, NULL, NULL),
(10, 1, 37, 18250, '2020-10-30 00:34:34', 1, NULL, NULL),
(11, 1, 38, 18250, '2020-10-30 00:36:43', 3, NULL, NULL),
(12, 12, 39, 7100, '2020-11-03 03:49:18', 2, 1, 'Corrientes 1855'),
(13, 12, 40, 7100, '2020-11-03 03:50:28', 2, 2, 'Corrientes 1855'),
(14, 1, 41, 5100, '2020-11-03 23:12:14', 1, NULL, ''),
(15, 1, 42, 1750, '2020-11-04 02:38:17', 1, NULL, NULL),
(16, 1, 43, 32287.100000000002, '2020-11-05 00:45:32', 1, NULL, NULL),
(17, 1, 44, 20891.4, '2020-11-05 03:02:49', 3, NULL, 'Corrientes 1855'),
(18, 1, 45, 13962, '2020-11-05 03:04:36', 1, NULL, NULL),
(19, 1, 46, 3450, '2020-11-05 03:07:39', 2, 3, NULL),
(20, 1, 47, 12950, '2020-11-05 03:17:36', 2, 4, NULL),
(21, 1, 48, 1650, '2020-11-05 03:30:25', 1, NULL, NULL),
(22, 1, 49, 1750, '2020-11-05 03:40:12', 1, NULL, NULL),
(23, 1, 50, 1700, '2020-11-05 03:43:38', 1, NULL, NULL),
(24, 1, 51, 1750, '2020-11-05 03:52:01', 1, NULL, 'Corrientes 1855'),
(25, 1, 52, 13400, '2020-11-05 22:04:46', 2, NULL, NULL),
(26, 1, 53, 6950, '2020-11-05 22:11:06', 2, NULL, 'Corrientes 1855'),
(27, 1, 54, 8500, '2020-11-05 22:13:52', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tarjeta_credito`
--

CREATE TABLE `tarjeta_credito` (
  `id_tarjeta` int(11) NOT NULL,
  `nombre_tarjeta` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `nro_tarjeta` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_vencimiento` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cvv` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tarjeta_credito`
--

INSERT INTO `tarjeta_credito` (`id_tarjeta`, `nombre_tarjeta`, `nro_tarjeta`, `fecha_vencimiento`, `cvv`, `id_usuario`) VALUES
(1, 'NICOLAS J GOMEZ', '2147483647', '0000-00-00', '333', 12),
(2, 'NICOLAS J GOMEZ', '2147483647', '0000-00-00', '333', 12),
(3, 'NICOLAS J GOMEZ', '0', '05/22', '13', 1),
(4, 'NICOLAS J GOMEZ', '0', '04/25', '111', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo_usuario` smallint(6) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `username`, `password`, `email`, `telefono`, `tipo_usuario`) VALUES
(1, 'Nicolas', 'Gomez', 'NicoTibbon', 'sarasa', 'nicogomezwp@gmail.com', '3413532237', 1),
(4, 'Diego', 'Milito', 'DiegoAlbertoMilito', 'la', 'diegomilito@gmail.com', '202010', 2),
(5, 'sarasa', 'sarasa', 'sarasa', 'lala', 'sarasa@sarasa.com', '2147483647', 2),
(7, 'Fabiana', 'Rizzutti', 'FabiTibbon', 'fabi', 'fabi@yahoo.com', '515151', 1),
(8, 'Franco', 'Vicini', 'FranTibbon', 'fran', 'franvici@gmail.com', NULL, 2),
(9, 'Nuevo', 'Usuario', 'NuevoNuevo', 'nuevo', 'nuevo@nuevo.nuevo', NULL, 2),
(10, 'TEST', 'ADMIN', 'TestAdmin', 'test', 'test@correcto.bien', NULL, 1),
(11, 'Update', 'User', 'NoError', 'lalala', 'menos@el.telef', NULL, 2),
(12, 'Usuario', 'Cliente', 'UserClient', 'client', 'user@client.test', NULL, 2),
(14, 'Diego', 'SinPassUpdate', 'Diego22', 'redirect', 'diego@diego.com', '3413500014', 2);

-- --------------------------------------------------------

--
-- Table structure for table `zapatilla`
--

CREATE TABLE `zapatilla` (
  `id_zapatilla` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `precio` double DEFAULT 0,
  `descripcion` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img_path` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo` char(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `zapatilla`
--

INSERT INTO `zapatilla` (`id_zapatilla`, `nombre`, `precio`, `descripcion`, `img_path`, `tipo`) VALUES
(30, 'Mistery Plus', 1650, NULL, 'Uploads/mistery-plus.jpg', 'M'),
(31, 'Mode', 1700, NULL, 'Uploads/mode-negro.jpg', 'M'),
(32, 'Glod Black', 1850, NULL, 'Uploads/gold-black.jpg', 'M'),
(33, 'Animal Imprint', 1750, 'Update description', 'Uploads/animal-imprint.jpg', NULL),
(34, 'Clasica Rosa', 1700, NULL, 'Uploads/clasica-rosa.jpg', 'M'),
(35, 'Clasica Negro', 1700, NULL, 'Uploads/clasica-negro.jpg', NULL),
(36, 'Mode Elegante', 1850, NULL, 'Uploads/mode-elegante-habano.jpg', 'H'),
(37, 'Clasica Espigado', 1750, NULL, 'Uploads/clasica-espigado.jpg', NULL),
(38, 'Test', 1650, '1650', NULL, NULL),
(41, 'Test', 1700, '', NULL, NULL),
(42, 'No More Test', 1212, 'Test Update', NULL, NULL),
(44, 'Zapa Kim Taean', 9595.7, 'Designed especially for BTS fans like Julieta.', 'Uploads/blackAndGold.jpg', 'M');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carro_compra`
--
ALTER TABLE `carro_compra`
  ADD PRIMARY KEY (`id_carro`),
  ADD KEY `usuario_idx` (`id_usuario`);

--
-- Indexes for table `carro_zapatilla`
--
ALTER TABLE `carro_zapatilla`
  ADD PRIMARY KEY (`id_carro_zapatilla`),
  ADD KEY `carro_idx` (`id_carro`),
  ADD KEY `zapatilla_idx` (`id_zapatilla`);

--
-- Indexes for table `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `usuario_idx` (`usuario`),
  ADD KEY `carro_idx` (`carro`),
  ADD KEY `tarjeta_idx` (`tarjeta`);

--
-- Indexes for table `tarjeta_credito`
--
ALTER TABLE `tarjeta_credito`
  ADD PRIMARY KEY (`id_tarjeta`),
  ADD KEY `usuario_idx` (`id_usuario`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indexes for table `zapatilla`
--
ALTER TABLE `zapatilla`
  ADD PRIMARY KEY (`id_zapatilla`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carro_compra`
--
ALTER TABLE `carro_compra`
  MODIFY `id_carro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `carro_zapatilla`
--
ALTER TABLE `carro_zapatilla`
  MODIFY `id_carro_zapatilla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `compra`
--
ALTER TABLE `compra`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tarjeta_credito`
--
ALTER TABLE `tarjeta_credito`
  MODIFY `id_tarjeta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `zapatilla`
--
ALTER TABLE `zapatilla`
  MODIFY `id_zapatilla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carro_compra`
--
ALTER TABLE `carro_compra`
  ADD CONSTRAINT `usuario_carro` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `carro_zapatilla`
--
ALTER TABLE `carro_zapatilla`
  ADD CONSTRAINT `carro` FOREIGN KEY (`id_carro`) REFERENCES `carro_compra` (`id_carro`),
  ADD CONSTRAINT `zapatilla` FOREIGN KEY (`id_zapatilla`) REFERENCES `zapatilla` (`id_zapatilla`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `carro_compra` FOREIGN KEY (`carro`) REFERENCES `carro_compra` (`id_carro`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tarjeta` FOREIGN KEY (`tarjeta`) REFERENCES `tarjeta_credito` (`id_tarjeta`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id_usuario`) ON UPDATE CASCADE;

--
-- Constraints for table `tarjeta_credito`
--
ALTER TABLE `tarjeta_credito`
  ADD CONSTRAINT `usuario_tarjeta` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
