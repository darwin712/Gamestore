-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 04-06-2026 a las 18:44:18
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.3.10

CREATE DATABASE cimagames;

USE cimagames;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cimagames`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `Cod_Categoria` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`Cod_Categoria`, `Nombre`) VALUES
(1, 'Videojuego'),
(2, 'Consola'),
(3, 'Accesorios'),
(4, 'Juguetes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleintercambio`
--

CREATE TABLE `detalleintercambio` (
  `Cod_Intercambio` int(11) NOT NULL,
  `Cod_Producto` int(11) NOT NULL,
  `Precio_Unitario` decimal(10,2) NOT NULL,
  `Estado_Producto` enum('Excelente','Bueno') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Cantidad` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleventa`
--

CREATE TABLE `detalleventa` (
  `Cod_Venta` int(11) NOT NULL,
  `Cod_Producto` int(11) NOT NULL,
  `Precio_Unitario` decimal(10,2) NOT NULL,
  `Cantidad` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `Cod_Empleado` int(11) NOT NULL,
  `Apellido_Paterno` varchar(50) NOT NULL,
  `Apellido_Materno` varchar(50) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Telefono` varchar(15) NOT NULL,
  `Turno` enum('Matutino','Vespertino','Mixto') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`Cod_Empleado`, `Apellido_Paterno`, `Apellido_Materno`, `Nombre`, `Telefono`, `Turno`, `Activo`) VALUES
(9, 'Ordorica', 'Ruiz', 'David Rey', '31532131', 'Vespertino', 1),
(10, 'Trujillo', 'Vega', 'Andre Neftali', '1231312325', 'Mixto', 1),
(11, 'Gaxiola', 'Davalos', 'Santiago Emanuel', '7317325216', 'Matutino', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiqueta`
--

CREATE TABLE `etiqueta` (
  `Cod_Etiqueta` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `etiqueta`
--

INSERT INTO `etiqueta` (`Cod_Etiqueta`, `Nombre`) VALUES
(1, 'Accion'),
(2, 'Aventura'),
(3, 'RPG'),
(4, 'Deportes'),
(5, 'Terror'),
(6, 'Online'),
(7, 'Cooperativo'),
(8, 'Mundo Abierto'),
(9, 'Historia'),
(10, 'Indie');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intercambio`
--

CREATE TABLE `intercambio` (
  `Cod_Intercambio` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Monto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Cod_Empleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `Cod_Producto` int(11) NOT NULL,
  `Imagen` varchar(255) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `Unidades` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `Clasificacion` enum('E','T','M') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Condicion` enum('NUEVO','SEMINUEVO') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `Cod_Categoria` int(11) NOT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`Cod_Producto`, `Imagen`, `Nombre`, `Precio`, `Unidades`, `Clasificacion`, `Condicion`, `Descripcion`, `Cod_Categoria`, `Activo`) VALUES
(25, '_Portadas_/Mario-Kart-World-boxart.jpg', 'Mario Kart World', '1799.99', 21, 'E', 'NUEVO', 'Mario carreras', 1, 1),
(26, '_Portadas_/81N0cxaqEYL._AC_SL1500_.jpg', 'Resident Evil 2', '599.99', 51, 'M', 'NUEVO', 'residente malo', 1, 1),
(27, '_Portadas_/81p2yT3GJIL.jpg', 'Minecraft', '399.99', 46, 'E', 'NUEVO', 'cubos', 1, 1),
(28, '_Portadas_/Super_Smash_Bros_Melee_box_art.png', 'Super Smash Bros. Melee', '599.99', 3, 'T', 'SEMINUEVO', 'luchas peleas', 1, 1),
(29, '_Portadas_/616X8zng9wS.jpg', 'Playstation 5', '10899.99', 3, 'E', 'NUEVO', 'gaming a otro nivel', 2, 1),
(30, '_Portadas_/61rUMbRaMtL.jpg', 'Mando de Xbox', '999.99', 22, 'E', 'NUEVO', 'Color blanco, sin drift', 3, 1),
(31, '_Portadas_/sanshee_five-nights-at-fredd_s_freddy-plush_updated.webp', 'Peluche de Freddy Fazbear', '259.99', 49, 'E', 'NUEVO', 'haur haur haur haur', 4, 1),
(32, '_Portadas_/D_NQ_NP_771279-MLA99538697354_122025-O.webp', 'Nintendo Switch 2', '12999.99', 0, 'E', 'NUEVO', 'consola para toda la familia', 2, 1),
(33, '_Portadas_/images.jfif', 'Wii Party', '899.00', 66, 'E', 'SEMINUEVO', 'Videojuego', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productoetiqueta`
--

CREATE TABLE `productoetiqueta` (
  `Cod_Producto` int(11) NOT NULL,
  `Cod_Etiqueta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `productoetiqueta`
--

INSERT INTO `productoetiqueta` (`Cod_Producto`, `Cod_Etiqueta`) VALUES
(26, 1),
(28, 1),
(33, 1),
(27, 2),
(33, 4),
(26, 5),
(25, 6),
(27, 6),
(25, 7),
(27, 7),
(33, 7),
(25, 8),
(27, 8),
(26, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `Cod_Venta` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Cod_Empleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`Cod_Categoria`);

--
-- Indices de la tabla `detalleintercambio`
--
ALTER TABLE `detalleintercambio`
  ADD PRIMARY KEY (`Cod_Intercambio`,`Cod_Producto`,`Estado_Producto`) USING BTREE,
  ADD KEY `fk_di_producto` (`Cod_Producto`);

--
-- Indices de la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  ADD PRIMARY KEY (`Cod_Venta`,`Cod_Producto`),
  ADD KEY `fk_dv_producto` (`Cod_Producto`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`Cod_Empleado`);

--
-- Indices de la tabla `etiqueta`
--
ALTER TABLE `etiqueta`
  ADD PRIMARY KEY (`Cod_Etiqueta`);

--
-- Indices de la tabla `intercambio`
--
ALTER TABLE `intercambio`
  ADD PRIMARY KEY (`Cod_Intercambio`),
  ADD KEY `fk_intercambio_empleado` (`Cod_Empleado`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`Cod_Producto`),
  ADD KEY `fk_producto_categoria` (`Cod_Categoria`);

--
-- Indices de la tabla `productoetiqueta`
--
ALTER TABLE `productoetiqueta`
  ADD PRIMARY KEY (`Cod_Producto`,`Cod_Etiqueta`),
  ADD KEY `fk_pe_etiqueta` (`Cod_Etiqueta`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`Cod_Venta`),
  ADD KEY `fk_venta_empleado` (`Cod_Empleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `Cod_Categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `Cod_Empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `etiqueta`
--
ALTER TABLE `etiqueta`
  MODIFY `Cod_Etiqueta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `intercambio`
--
ALTER TABLE `intercambio`
  MODIFY `Cod_Intercambio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `Cod_Producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `Cod_Venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalleintercambio`
--
ALTER TABLE `detalleintercambio`
  ADD CONSTRAINT `fk_di_intercambio` FOREIGN KEY (`Cod_Intercambio`) REFERENCES `intercambio` (`Cod_Intercambio`),
  ADD CONSTRAINT `fk_di_producto` FOREIGN KEY (`Cod_Producto`) REFERENCES `producto` (`Cod_Producto`);

--
-- Filtros para la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  ADD CONSTRAINT `fk_dv_producto` FOREIGN KEY (`Cod_Producto`) REFERENCES `producto` (`Cod_Producto`),
  ADD CONSTRAINT `fk_dv_venta` FOREIGN KEY (`Cod_Venta`) REFERENCES `venta` (`Cod_Venta`);

--
-- Filtros para la tabla `intercambio`
--
ALTER TABLE `intercambio`
  ADD CONSTRAINT `fk_intercambio_empleado` FOREIGN KEY (`Cod_Empleado`) REFERENCES `empleado` (`Cod_Empleado`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`Cod_Categoria`) REFERENCES `categoria` (`Cod_Categoria`);

--
-- Filtros para la tabla `productoetiqueta`
--
ALTER TABLE `productoetiqueta`
  ADD CONSTRAINT `fk_pe_etiqueta` FOREIGN KEY (`Cod_Etiqueta`) REFERENCES `etiqueta` (`Cod_Etiqueta`),
  ADD CONSTRAINT `fk_pe_producto` FOREIGN KEY (`Cod_Producto`) REFERENCES `producto` (`Cod_Producto`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `fk_venta_empleado` FOREIGN KEY (`Cod_Empleado`) REFERENCES `empleado` (`Cod_Empleado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
