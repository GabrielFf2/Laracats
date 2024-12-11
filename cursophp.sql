-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: mariadb:3306
-- Tiempo de generación: 10-12-2024 a las 22:20:40
-- Versión del servidor: 11.2.6-MariaDB-ubu2204
-- Versión de PHP: 8.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cursophp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `body` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notes`
--

INSERT INTO `notes` (`id`, `body`, `user_id`) VALUES
(35, 'aad', 8),
(36, 'xadada', 5),
(39, 'sdasdasdasd', 15),
(40, 'Hola asdasdasdasdasd', 15),
(41, 'joe@example.com asdasdasd', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `apiKey` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `apiKey`) VALUES
(5, 'andreu4567@gmail.com', '$2y$10$aQfOY61d4bhABNPXeGL2h.FJK0QEuy..hLGmorq0l9HODGWakcC06', 'cc3f0a746b7d800202a7fcbc3357573d70e6374e721696c0cf7b0f591b6a61fa'),
(6, 'TheAndreu44@gmail.com', '$2y$10$P19s3n8hqbfGpTUHTrz0NOTDhH93PuWUlt7huJC/faACf/dcXSgnC', '27f25479592387ccf5d04dd35b73e7a336dccfd448226fc024fc6878fd14a6d2'),
(7, 'afons11231@alumnes.iesmanacor.cat', '$2y$10$51Sg01.O2x4v9QCJtttmhuStlMCtErqPr1yIU2rNBnAXiNHb0LRbu', '3770ccbc32bbca339fd3e500ae847f643e174973559ac69dc36bba403c4727e2'),
(8, 'afons313@alumnes.politecnicllevant.cat', '$2y$10$Wa96zaCnvNVkVJQdskLvSOCWyvm4zrS7KuwUHI6bdGXTsZPMy2eti', '913af2b5292d4f52585cc7df594d56e7b46dcbc74235d6c2efa1b4ce407967db'),
(15, 'gfont407@alumnes.politecnicllevant.cat', '$2y$10$LRp.cTX6ZF8tZVSZ1jTtROoG4gXIvjCpuME8VwlX79D2WT62OGExe', 'e73003005e054623d8af13d120c43086');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
