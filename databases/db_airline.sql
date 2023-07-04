-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-06-2023 a las 20:10:58
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_airline`
--
CREATE DATABASE IF NOT EXISTS `db_airline` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_airline`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `airport`
--

CREATE TABLE `airport` (
  `id_airport` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `ubication` varchar(255) DEFAULT NULL,
  `image` varbinary(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `airport`
--

INSERT INTO `airport` (`id_airport`, `name`, `ubication`, `image`) VALUES
(1, 'Teniente Luis Candelaria', 'San Carlos de Bariloche, Rio Negro', 0x68747470733a2f2f6d656469612e74726176656c65722e65732f70686f746f732f3631333736633132643439323366363765323938656261662f6d61737465722f775f31363030253243635f6c696d69742f3134363730342e6a7067),
(2, 'Martín Miguel de Güemes', 'Salta, Salta', 0x68747470733a2f2f766f6c656d6f732e6e7963332e6469676974616c6f6365616e7370616365732e636f6d2f626c6f672f77702d636f6e74656e742f75706c6f6164732f323032302f30382f496d7065726469626c65732d64652d73616c74612e6a7067),
(3, 'El Plumerillo', 'San Rafael, Mendoza', 0x68747470733a2f2f6469622e636f6d2e61722f77702d636f6e74656e742f75706c6f6164732f323032312f30392f72616674696e672e6a7067),
(4, 'General José de San Martín', 'Posadas, Misiones', 0x68747470733a2f2f74726970696e2e74726176656c2f77702d636f6e74656e742f75706c6f6164732f323032302f30322f6361746172617461732d696775617a752d70616e6f72616d6963612e6a7067),
(5, 'Aeropuerto Río Cuarto', 'Rio Cuarto, Cordoba', 0x68747470733a2f2f6d65646961696d2e657870656469612e636f6d2f64657374696e6174696f6e2f312f65623333383161303930653033303839613633396532313639343765373737302e6a7067);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `flight`
--

CREATE TABLE `flight` (
  `id_flight` int(11) NOT NULL,
  `destination` int(11) DEFAULT NULL,
  `price` double NOT NULL,
  `duration` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `flight`
--

INSERT INTO `flight` (`id_flight`, `destination`, `price`, `duration`) VALUES
(1, 3, 25500, '02:25:00'),
(2, 5, 28000, '02:00:00'),
(3, 2, 19850, '02:33:00'),
(4, 1, 20000, '01:40:00'),
(5, 1, 20000, '01:40:00'),
(6, 5, 24550, '02:00:00'),
(7, 4, 21200, '02:40:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`) VALUES
(22, 'federico', '$2y$10$ukxBIJAj5iqLE4CgZqwyjedPvmBvDQbCZcQoGcKyZF/w3u2Q8VvwO');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `airport`
--
ALTER TABLE `airport`
  ADD PRIMARY KEY (`id_airport`),
  ADD KEY `name` (`name`);

--
-- Indices de la tabla `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`id_flight`),
  ADD KEY `destination` (`destination`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `airport`
--
ALTER TABLE `airport`
  MODIFY `id_airport` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `flight`
--
ALTER TABLE `flight`
  MODIFY `id_flight` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `flight`
--
ALTER TABLE `flight`
  ADD CONSTRAINT `flight_ibfk_1` FOREIGN KEY (`destination`) REFERENCES `airport` (`id_airport`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
