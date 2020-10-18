-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 18, 2020 at 01:27 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tibbonzapas`
--

-- --------------------------------------------------------

--
-- Table structure for table `carro_compra`
--

CREATE TABLE IF NOT EXISTS `carro_compra` (
  `id_carro` int(11) NOT NULL AUTO_INCREMENT,
  `total` double NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `forma_pago` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_carro`),
  KEY `usuario_idx` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;

--
-- Dumping data for table `carro_compra`
--

INSERT INTO `carro_compra` (`id_carro`, `total`, `id_usuario`, `forma_pago`) VALUES
(1, 13850, 8, 1),
(2, 10, 8, 1),
(3, 13850, 8, 1),
(4, 13850, 8, 1),
(5, 13850, 8, 1),
(6, 13850, 8, 1),
(7, 13850, 8, 1),
(8, 13850, 8, 1),
(9, 13850, 8, 1),
(10, 13850, 8, 1),
(11, 13850, 8, 1),
(12, 13850, 8, 1),
(13, 13850, 8, 1),
(14, 13850, 8, 1),
(15, 13850, 8, 3),
(16, 0, 8, 3),
(17, 0, 8, 3),
(18, 6850, 1, 1),
(19, 6850, 1, 1),
(20, 6850, 1, 1),
(21, 6850, 1, 1),
(22, 1700, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `carro_zapatilla`
--

CREATE TABLE IF NOT EXISTS `carro_zapatilla` (
  `id_carro_zapatilla` int(11) NOT NULL AUTO_INCREMENT,
  `id_carro` int(11) NOT NULL,
  `id_zapatilla` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT '0',
  `subtotal_linea` double DEFAULT '0',
  `color` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `talle` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_carro_zapatilla`),
  KEY `carro_idx` (`id_carro`),
  KEY `zapatilla_idx` (`id_zapatilla`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

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
(18, 22, 31, 1, 1700, 'Blanco', 36);

-- --------------------------------------------------------

--
-- Table structure for table `compra`
--

CREATE TABLE IF NOT EXISTS `compra` (
  `id_compra` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `carro` int(11) NOT NULL,
  `total` double DEFAULT '0',
  `fecha_compra` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo_pago` tinyint(4) NOT NULL,
  `tarjeta` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_compra`),
  KEY `usuario_idx` (`usuario`),
  KEY `carro_idx` (`carro`),
  KEY `tarjeta_idx` (`tarjeta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tarjeta_credito`
--

CREATE TABLE IF NOT EXISTS `tarjeta_credito` (
  `id_tarjeta` int(11) NOT NULL,
  `fecha_alta` date NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_tarjeta`),
  KEY `usuario_idx` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `tipo_usuario` smallint(6) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `username`, `password`, `email`, `telefono`, `tipo_usuario`) VALUES
(1, 'Nicolas', 'Gomez', 'NicoTibbon', 'sarasa', 'nicogomezwp@gmail.com', 2147483647, 1),
(4, 'Diego', 'Milito', 'DiegoAlbertoMilito', 'la', 'diegomilito@gmail.com', 202010, 2),
(5, 'sarasa', 'sarasa', 'sarasa', 'lala', 'sarasa@sarasa.com', 0, 2),
(7, 'Fabiana', 'Rizzutti', 'FabiTibbon', 'fabi', 'fabi@yahoo.com', 515151, 1),
(8, 'Franco', 'Vicini', 'FranTibbon', 'fran', 'franvici@gmail.com', 0, 2),
(9, 'Nuevo', 'Usuario', 'NuevoNuevo', 'nuevo', 'nuevo@nuevo.nuevo', 0, 2),
(10, 'TEST', 'ADMIN', 'TestAdmin', 'test', 'test@correcto.bien', 0, 1),
(11, 'Todo', 'Bien', 'Error', 'error', 'menos@el.telef', 0, 2),
(12, 'Usuario', 'Cliente', 'UserClient', 'client', 'user@client.test', 0, 2),
(13, 'Carga', 'Correcto', 'Redirect', 'carga', 'redirect@login.com', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `zapatilla`
--

CREATE TABLE IF NOT EXISTS `zapatilla` (
  `id_zapatilla` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `precio` double DEFAULT '0',
  `descripcion` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img_path` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_zapatilla`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=45 ;

--
-- Dumping data for table `zapatilla`
--

INSERT INTO `zapatilla` (`id_zapatilla`, `nombre`, `precio`, `descripcion`, `img_path`) VALUES
(30, 'Mistery Plus', 1650, NULL, 'Uploads/mistery-plus.jpg'),
(31, 'Mode', 1700, NULL, 'Uploads/mode-negro.jpg'),
(32, 'Glod Black', 1850, NULL, 'Uploads/gold-black.jpg'),
(33, 'Animal Imprint', 1750, NULL, 'Uploads/animal-imprint.jpg'),
(34, 'Clasica Rosa', 1700, NULL, 'Uploads/clasica-rosa.jpg'),
(35, 'Clasica Negro', 1700, NULL, 'Uploads/clasica-negro.jpg'),
(36, 'Mode Elegante', 1850, NULL, 'Uploads/mode-elegante-habano.jpg'),
(37, 'Clasica Espigado', 1750, NULL, 'Uploads/clasica-espigado.jpg'),
(38, 'Test', 1650, '1650', NULL),
(41, 'Test', 1700, '', NULL),
(42, 'Test', NULL, 'Sin precio y con talle, sin img', NULL),
(43, 'Prueba', 1515, 'sgdagldhgs', NULL),
(44, 'Test', NULL, 'Test mensaje de exito', NULL);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
