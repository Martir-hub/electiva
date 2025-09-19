-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-09-2025 a las 22:39:29
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `uni`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `ID_Ciudad` int(11) NOT NULL,
  `Ciudad` varchar(50) DEFAULT NULL,
  `ID_Estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`ID_Ciudad`, `Ciudad`, `ID_Estado`) VALUES
(1, 'Valencia', 1),
(2, 'Los Guayos', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `ID_Curso` int(11) NOT NULL,
  `Nombre_curso` varchar(60) DEFAULT NULL,
  `creditos` varchar(3) DEFAULT NULL,
  `descripcion` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`ID_Curso`, `Nombre_curso`, `creditos`, `descripcion`) VALUES
(1, 'Programación', '3', 'Curso de programacion.'),
(2, 'Matemáticas', '4', 'curso de matematicas.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

CREATE TABLE `direccion` (
  `ID_Direccion` int(11) NOT NULL,
  `calle` varchar(100) DEFAULT NULL,
  `ID_Ciudad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `direccion`
--

INSERT INTO `direccion` (`ID_Direccion`, `calle`, `ID_Ciudad`) VALUES
(1, 'J', 1),
(2, 'C', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `ID_Estado` int(11) NOT NULL,
  `Estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`ID_Estado`, `Estado`) VALUES
(1, 'Carabobo'),
(2, 'Carabobo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `ID_Std` int(11) NOT NULL,
  `Nombres` varchar(60) NOT NULL,
  `Apellidos` varchar(60) NOT NULL,
  `fecha_n` date NOT NULL,
  `ID_Direccion` int(11) DEFAULT NULL,
  `correo_electronico` varchar(100) NOT NULL,
  `telefono` decimal(11,0) NOT NULL,
  `contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`ID_Std`, `Nombres`, `Apellidos`, `fecha_n`, `ID_Direccion`, `correo_electronico`, `telefono`, `contraseña`) VALUES
(1, 'Carlos', 'López', '1999-10-22', 1, 'nombrefalso1@gmail.com', 4244359507, 'abc123'),
(2, 'María', 'Rodríguez', '2001-03-08', 2, 'nombrefalso22@hotmail.com', 4123234567, '1234'),
(10, 'Juan', 'Josefino', '2025-09-05', 1, 'asdsad@gmail.com', 42443581234, '$2y$10$QjtzveNf.tHOQ/EEcBDkwekLnsLps0r3BOhvJppgmNKt9s2VKtpZm'),
(11, 'António', 'Josué', '2025-09-06', 1, 'add@gmail.com', 4244358003, '$2y$10$u5o0mYFfWopGKfgDzAswuOJUJ7Jy6hB.PIqYR0UnwDJMmiRUvoMnC'),
(12, 'Prueba', 'Postman', '2025-09-19', NULL, 'prueba@ejemplo.com', 1234567890, '$2y$10$As688epbDFuqghf7rEKYhej3Tx.CjXyaBNFIws/jRDWtoIkGMOoQm'),
(13, 'António', 'Josué', '2025-09-19', NULL, 'marting@gmail.com', 42443581234, '$2y$10$EMlCjrvv537el2HxWEQqo.U/FMkFsVgol2CbAc/RAoWBsiiyaqqv6'),
(14, 'António', 'Josué', '2025-09-19', NULL, 'asddddddd@gmail.com', 99999999999, '$2y$10$bOUzKLXWnGh8MkYVSCuVle/qCfcWcVcMwsXh1vbR4MWRINavTxcSG'),
(15, 'andres', 'markez', '2025-09-19', NULL, 'jugemos24@gmail.com', 12345678, '$2y$10$fPAG4OLkchYA0GCHMev.eO/IqUcnxVVZj7QpbpzzWZSO5wn235WrO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `ID_Inscripcion` int(11) NOT NULL,
  `ID_Std` int(11) NOT NULL,
  `ID_Curso` int(11) NOT NULL,
  `Fecha_Inscripcion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripcion`
--

INSERT INTO `inscripcion` (`ID_Inscripcion`, `ID_Std`, `ID_Curso`, `Fecha_Inscripcion`) VALUES
(5, 1, 1, '2025-01-03'),
(6, 2, 2, '2025-02-04');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`ID_Ciudad`),
  ADD KEY `ID_Estado` (`ID_Estado`);

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`ID_Curso`);

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`ID_Direccion`),
  ADD KEY `ID_Ciudad` (`ID_Ciudad`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`ID_Estado`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`ID_Std`),
  ADD UNIQUE KEY `correo_electronico` (`correo_electronico`),
  ADD KEY `ID_Direccion` (`ID_Direccion`),
  ADD KEY `correo_electronico_2` (`correo_electronico`);

--
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`ID_Inscripcion`),
  ADD KEY `ID_Std` (`ID_Std`),
  ADD KEY `ID_Curso` (`ID_Curso`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `ID_Curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  MODIFY `ID_Std` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `ID_Inscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD CONSTRAINT `ciudad_ibfk_1` FOREIGN KEY (`ID_Estado`) REFERENCES `estado` (`ID_Estado`);

--
-- Filtros para la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD CONSTRAINT `direccion_ibfk_1` FOREIGN KEY (`ID_Ciudad`) REFERENCES `ciudad` (`ID_Ciudad`);

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `estudiante_ibfk_1` FOREIGN KEY (`ID_Direccion`) REFERENCES `direccion` (`ID_Direccion`);

--
-- Filtros para la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD CONSTRAINT `inscripcion_ibfk_1` FOREIGN KEY (`ID_Std`) REFERENCES `estudiante` (`ID_Std`),
  ADD CONSTRAINT `inscripcion_ibfk_2` FOREIGN KEY (`ID_Curso`) REFERENCES `curso` (`ID_Curso`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
