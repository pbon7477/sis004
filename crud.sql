-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-05-2025 a las 05:32:52
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
-- Base de datos: `crud`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int(10) NOT NULL,
  `usuario_nombre` varchar(70) NOT NULL,
  `usuario_apellido` varchar(70) NOT NULL,
  `usuario_email` varchar(100) NOT NULL,
  `usuario_usuario` varchar(30) NOT NULL,
  `usuario_clave` varchar(200) NOT NULL,
  `usuario_foto` varchar(535) NOT NULL,
  `usuario_creado` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_actualizado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_email`, `usuario_usuario`, `usuario_clave`, `usuario_foto`, `usuario_creado`, `usuario_actualizado`) VALUES
(1, 'admin', 'admin', 'admin@sis.com', 'admin', '$2y$10$5U86UT7Ac9IbPcZttO1YielR7Hl1oe2ycKM5Gc9JYvyX.2NL2xo3m', 'Pablo_1746584005.png', '2025-04-20 05:54:37', '2025-05-12 22:41:36'),
(15, 'Hank', 'Shrader', 'hank_shreder@gmail.com', 'hank', '$2y$10$WB.r6VxzbZbpU0awy1v7tO..2/uDOJlWWEQa4lyzTkX3O1R94KE0S', 'Hank_1745401177.jpeg', '2025-04-23 09:39:37', '2025-05-07 02:12:25'),
(16, 'Casian', 'Andor', 'casian_andor@gmail.com', 'casian', '$2y$10$m9IIG3HsvqfAQhAHhk.AP.hvW40.Cxf56LELMELgyznRvx5N5nXdu', 'Casian_1746664113.jpeg', '2025-04-24 07:16:23', '2025-05-08 00:28:34'),
(17, 'Floor', 'Jansen', 'floor@gmail.com', 'floor', '$2y$10$qDR80n.qlUclyyYi2z0e4uiciWpEggYKOkMD44I476yRzV.Mw2hR2', '', '2025-04-24 07:23:13', '2025-05-08 00:38:19'),
(18, 'Howard', 'Hambling', 'howie@gmail.com', 'howie', '$2y$10$3u6pFx368uVsw8W2LaGEC.Py21rIVuZ2hx7jqx9/hq64bu6sUaZeC', 'Howard_1745577294.jpeg', '2025-04-25 10:34:54', '2025-04-25 10:34:54'),
(19, 'Tech', 'Clon', 'tech@camino.com', 'tech', '$2y$10$hZXeESrdisPW3LPa/HPaNeGX9SBs/BFyDXh0dtaXKI0bUjiX..3Mi', 'tech_1747101469.jpeg', '2025-04-26 11:16:18', '2025-05-13 01:57:49'),
(20, 'Junior', 'Soprano', 'junior_soprano@soprano.cs', 'junior', '$2y$10$thLPApliP3QtdhpTa7RyI.p/WJWBGD8BmomGGdXKQuMX2cQB5U04m', 'Junior_1747089830.jpeg', '2025-05-12 22:43:50', '2025-05-12 22:43:50'),
(21, 'Osbald', 'Ozz', 'osvald_ozz@gothica.com', 'pinguino', '$2y$10$COBFal3iVI06EMtv2oQAxegxQ1OOiHNoDdHPUGUodCS6UK1yTDDjW', 'Osbald_1747102894.jpeg', '2025-05-13 02:21:34', '2025-05-13 02:24:30');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
