-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2017 a las 20:32:28
-- Versión del servidor: 10.1.9-MariaDB
-- Versión de PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `guide_db`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addEventChannels` (IN `eid` VARCHAR(11), IN `cid` INT)  BEGIN
INSERT INTO event_channel
(
    ev_id,
    ch_id
) VALUES (
    eid,
    cid
);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `createEvent` (IN `id` VARCHAR(11), IN `name` VARCHAR(45), IN `sch` DATETIME, IN `ending` DATETIME, IN `des` VARCHAR(45), IN `type` INT)  BEGIN
INSERT INTO event (
	ev_id,
    ev_name,
    ev_sch,
    ev_sch_end,
    ev_des)
VALUES
(
	id,
    name,
    sch,
    ending,
    des
);

INSERT INTO type_event (
	tp_id,
    ev_id)
VALUES
(
	type,
    id
);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getEventInformation` (IN `id` VARCHAR(11))  BEGIN
SELECT
	ev.ev_id,
	ev.ev_name,
    ev.ev_sch,
    ev.ev_sch_end,
    ev.ev_des,
    tp.tp_id
FROM event ev
INNER JOIN type_event te 
ON ev.ev_id = te.ev_id
INNER JOIN types tp
ON te.tp_id = tp.tp_id
WHERE ev.ev_id = id
GROUP BY
	1,2,3,4,5,6;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateEvent` (IN `id` VARCHAR(11), IN `name` VARCHAR(45), IN `sch` DATETIME, IN `sch_end` DATETIME, IN `des` VARCHAR(45), IN `type` INT)  BEGIN
UPDATE event
SET
	ev_name = name,
    ev_sch = sch,
    ev_sch_end = sch_end,
    ev_des = des
WHERE ev_id = id;

UPDATE type_event
SET
	tp_id = type
WHERE ev_id = id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `channels`
--

CREATE TABLE `channels` (
  `ch_id` int(11) NOT NULL,
  `ch_name` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ch_abv` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `ch_img` varchar(400) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `channels`
--

INSERT INTO `channels` (`ch_id`, `ch_name`, `ch_abv`, `ch_img`) VALUES
(1, 'ESPN', 'E1', NULL),
(2, 'ESPN 2', 'E2', NULL),
(3, 'FOX SPORTS', 'FXS1', NULL),
(4, 'FOX SPORTS 2', 'FXS2', NULL),
(5, 'AZTECA 7', 'A7', NULL),
(6, 'CANAL 5', 'C5', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `event`
--

CREATE TABLE `event` (
  `ev_id` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `ev_name` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ev_sch` datetime NOT NULL,
  `ev_sch_end` datetime NOT NULL,
  `ev_des` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Event description'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `event_channel`
--

CREATE TABLE `event_channel` (
  `ev_id` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `ch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pass`
--

CREATE TABLE `pass` (
  `id` varchar(240) COLLATE utf8_spanish_ci NOT NULL,
  `pwd` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pass`
--

INSERT INTO `pass` (`id`, `pwd`) VALUES
('admin@admin.com', 'e516f979536994a14d9b0500bca3a1287b9ea9fe');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `types`
--

CREATE TABLE `types` (
  `tp_id` int(11) NOT NULL,
  `tp_name` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tp_img` varchar(400) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `types`
--

INSERT INTO `types` (`tp_id`, `tp_name`, `tp_img`) VALUES
(1, 'Football', NULL),
(2, 'Soccer', NULL),
(3, 'Basketball', NULL),
(4, 'Baseball', NULL),
(5, 'Music', NULL),
(6, 'Awards', NULL),
(7, 'Other', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_event`
--

CREATE TABLE `type_event` (
  `tp_id` int(11) NOT NULL,
  `ev_id` varchar(11) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` varchar(240) COLLATE utf8_spanish_ci NOT NULL,
  `user_name` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `user_age` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_age`) VALUES
('admin@admin.com', 'Admin', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `channels`
--
ALTER TABLE `channels`
  ADD PRIMARY KEY (`ch_id`);

--
-- Indices de la tabla `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`ev_id`);

--
-- Indices de la tabla `event_channel`
--
ALTER TABLE `event_channel`
  ADD KEY `fk_evch_ev_idx` (`ev_id`),
  ADD KEY `fk_evch_ch_idx` (`ch_id`);

--
-- Indices de la tabla `pass`
--
ALTER TABLE `pass`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`tp_id`);

--
-- Indices de la tabla `type_event`
--
ALTER TABLE `type_event`
  ADD KEY `fk_ev_evtp` (`ev_id`),
  ADD KEY `fk_tp_evtp` (`tp_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `channels`
--
ALTER TABLE `channels`
  MODIFY `ch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `types`
--
ALTER TABLE `types`
  MODIFY `tp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `event_channel`
--
ALTER TABLE `event_channel`
  ADD CONSTRAINT `fk_evch_ch` FOREIGN KEY (`ch_id`) REFERENCES `channels` (`ch_id`),
  ADD CONSTRAINT `fk_evch_ev` FOREIGN KEY (`ev_id`) REFERENCES `event` (`ev_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pass`
--
ALTER TABLE `pass`
  ADD CONSTRAINT `fk_pass_usr` FOREIGN KEY (`id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `type_event`
--
ALTER TABLE `type_event`
  ADD CONSTRAINT `fk_ev_evtp` FOREIGN KEY (`ev_id`) REFERENCES `event` (`ev_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tp_evtp` FOREIGN KEY (`tp_id`) REFERENCES `types` (`tp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
