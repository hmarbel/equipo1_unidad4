-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20220510.314f251104
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-05-2023 a las 23:43:18
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hydrus`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `idadmin` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `fechan` date NOT NULL,
  `password` varchar(25) NOT NULL,
  `super` varchar(1) NOT NULL COMMENT '1 - Super\r\n0 - Regular',
  `sexo` varchar(1) NOT NULL COMMENT 'M - Masculino\r\nF - Femenino'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`idadmin`, `username`, `nombre`, `apellido`, `email`, `telefono`, `fechan`, `password`, `super`, `sexo`) VALUES
(1, 'hmarbel', 'Coré', 'Martínez', 'husaimb22@gmail.com', '2382013700', '2001-12-22', '123', '1', 'M'),
(4, 'brianda', 'Brianda', 'Saucedo', 'brianda@gmail.com', '2381235849', '2002-02-02', '123', '1', 'F'),
(5, 'bea.c', 'Beatriz', 'Campbell', 'b.campbel@gmail.com', '2381457236', '2000-01-01', '123', '0', 'F'),
(6, 'mat', 'Matthew', 'Reese', 'm.reese@gmail.com', '2381235849', '2000-01-01', '123', '1', 'M'),
(7, 'chase', 'Chase', 'Ford', 'c.ford@gmail.com', '2385964713', '2000-01-01', '123', '0', 'M');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autobus`
--

CREATE TABLE `autobus` (
  `idautobus` int(11) NOT NULL,
  `placas` varchar(9) NOT NULL,
  `tipoviaje` varchar(1) NOT NULL COMMENT '1 - Regular\r\n2 - Galaxy',
  `activo` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `autobus`
--

INSERT INTO `autobus` (`idautobus`, `placas`, `tipoviaje`, `activo`) VALUES
(1, '01-ABC-10', '1', '0'),
(3, '02-CBA-20', '2', '1'),
(4, '03-DEF-30', '1', '1'),
(5, '04-FED-40', '2', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boleto`
--

CREATE TABLE `boleto` (
  `idboleto` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idviaje` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `tipo` varchar(1) NOT NULL,
  `asiento` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `boleto`
--

INSERT INTO `boleto` (`idboleto`, `idcliente`, `idviaje`, `nombre`, `apellido`, `tipo`, `asiento`, `subtotal`) VALUES
(1, 1, 3, 'Coré', 'Martínez', '1', 18, 250),
(4, 1, 13, 'Ángel', 'Salas', '1', 4, 350),
(5, 1, 13, 'David', 'Mendoza', '1', 5, 350),
(6, 3, 17, 'Tiana', 'Larson', '1', 5, 100),
(7, 3, 17, 'Harry', 'Mendel', '1', 6, 100),
(8, 3, 17, 'Jack', 'Nelson', '1', 9, 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `central`
--

CREATE TABLE `central` (
  `idcentral` int(11) NOT NULL,
  `estado` varchar(35) NOT NULL,
  `ciudad` varchar(35) NOT NULL,
  `calle` varchar(35) NOT NULL,
  `colonia` varchar(35) NOT NULL,
  `noedificio` varchar(6) NOT NULL,
  `cp` varchar(5) NOT NULL,
  `nombre` varchar(35) NOT NULL,
  `activo` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `central`
--

INSERT INTO `central` (`idcentral`, `estado`, `ciudad`, `calle`, `colonia`, `noedificio`, `cp`, `nombre`, `activo`) VALUES
(1, 'Puebla', 'Puebla', 'Calle', 'Colonia', 'A', '75486', 'Puebla CAPU', '0'),
(2, 'Veracruz', 'Orizaba', 'Calle', 'Colonia', 'C', '92458', 'Orizaba', '1'),
(4, 'Puebla', 'Tehuacán', 'Calle', 'Colonia', 'A', '75741', 'Tehuacán', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chofer`
--

CREATE TABLE `chofer` (
  `idchofer` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `fechan` date NOT NULL,
  `sexo` varchar(1) NOT NULL,
  `activo` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `chofer`
--

INSERT INTO `chofer` (`idchofer`, `nombre`, `apellido`, `email`, `telefono`, `fechan`, `sexo`, `activo`) VALUES
(1, 'Joss', 'Meneses', 'joss@gmail.com', '2385741369', '2002-07-11', 'F', '0'),
(2, 'Andrea', 'Romero', 'andrea@gmail.com', '2387415742', '2002-05-05', 'F', '1'),
(4, 'Verónica', 'Saucedo', 'veronica@gmail.com', '2381345678', '1977-02-01', 'F', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `activo` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idcliente`, `nombre`, `apellido`, `email`, `password`, `activo`) VALUES
(1, 'Ángel', 'Salas', 'angel@gmail.com', '123', '1'),
(2, 'Sebastian', 'Shaw', 's.shaw@gmail.com', '123', '1'),
(3, 'Emma', 'Frost', 'e.frost@gmail.com', '123', '1'),
(4, 'Charles', 'Blanc', 'c.blanc@gmail.com', '123', '1'),
(5, 'Brenda', 'Ríos', 'b.rios@gmail.com', '123', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `idpago` int(11) NOT NULL,
  `expedido` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viaje`
--

CREATE TABLE `viaje` (
  `idviaje` int(11) NOT NULL,
  `origen` int(11) NOT NULL,
  `destino` int(11) NOT NULL,
  `idchofer` int(11) NOT NULL,
  `idautobus` int(11) NOT NULL,
  `salida` datetime NOT NULL,
  `llegada` datetime NOT NULL,
  `tipoviaje` varchar(1) NOT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `viaje`
--

INSERT INTO `viaje` (`idviaje`, `origen`, `destino`, `idchofer`, `idautobus`, `salida`, `llegada`, `tipoviaje`, `precio`) VALUES
(1, 1, 2, 1, 1, '2023-05-15 09:00:00', '2023-05-15 11:30:00', '1', 220),
(2, 2, 4, 2, 3, '2023-05-15 21:00:00', '2023-05-15 23:15:00', '2', 350),
(3, 1, 2, 1, 1, '2023-05-15 17:39:00', '2023-05-15 19:39:00', '1', 250),
(13, 1, 2, 1, 3, '2023-05-16 21:00:00', '2023-05-16 23:30:00', '2', 350),
(16, 2, 4, 2, 4, '2023-05-27 15:10:00', '2023-05-27 15:12:00', '1', 1),
(17, 2, 4, 2, 4, '2023-05-27 22:12:00', '2023-05-27 23:30:00', '1', 100);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`idadmin`);

--
-- Indices de la tabla `autobus`
--
ALTER TABLE `autobus`
  ADD PRIMARY KEY (`idautobus`);

--
-- Indices de la tabla `boleto`
--
ALTER TABLE `boleto`
  ADD PRIMARY KEY (`idboleto`),
  ADD KEY `idcliente` (`idcliente`),
  ADD KEY `idviaje` (`idviaje`);

--
-- Indices de la tabla `central`
--
ALTER TABLE `central`
  ADD PRIMARY KEY (`idcentral`);

--
-- Indices de la tabla `chofer`
--
ALTER TABLE `chofer`
  ADD PRIMARY KEY (`idchofer`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`idpago`);

--
-- Indices de la tabla `viaje`
--
ALTER TABLE `viaje`
  ADD PRIMARY KEY (`idviaje`),
  ADD KEY `origen` (`origen`),
  ADD KEY `destino` (`destino`),
  ADD KEY `idchofer` (`idchofer`),
  ADD KEY `idautobus` (`idautobus`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `idadmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `autobus`
--
ALTER TABLE `autobus`
  MODIFY `idautobus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `boleto`
--
ALTER TABLE `boleto`
  MODIFY `idboleto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `central`
--
ALTER TABLE `central`
  MODIFY `idcentral` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `chofer`
--
ALTER TABLE `chofer`
  MODIFY `idchofer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `idpago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `viaje`
--
ALTER TABLE `viaje`
  MODIFY `idviaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `boleto`
--
ALTER TABLE `boleto`
  ADD CONSTRAINT `idcliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`),
  ADD CONSTRAINT `idviaje` FOREIGN KEY (`idviaje`) REFERENCES `viaje` (`idviaje`);

--
-- Filtros para la tabla `viaje`
--
ALTER TABLE `viaje`
  ADD CONSTRAINT `viaje_ibfk_1` FOREIGN KEY (`origen`) REFERENCES `central` (`idcentral`),
  ADD CONSTRAINT `viaje_ibfk_2` FOREIGN KEY (`destino`) REFERENCES `central` (`idcentral`),
  ADD CONSTRAINT `viaje_ibfk_3` FOREIGN KEY (`idchofer`) REFERENCES `chofer` (`idchofer`),
  ADD CONSTRAINT `viaje_ibfk_4` FOREIGN KEY (`idautobus`) REFERENCES `autobus` (`idautobus`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



