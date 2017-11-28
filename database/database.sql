SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


DELIMITER $$
CREATE PROCEDURE `addChannel` (IN `chname` VARCHAR(45), IN `chabv` VARCHAR(4), IN `chimg` VARCHAR(400), IN `country` INT)  BEGIN
INSERT INTO channels (
    ch_name,
    ch_abv,
    ch_img,
    ch_country
) VALUES (
    chname,
    chabv,
    chimg,
    country
);
END$$

CREATE PROCEDURE `addCountry` (IN `name` VARCHAR(25), IN `abv` VARCHAR(4), IN `lang` INT)  BEGIN
INSERT INTO countries
(
	country_name,
	country_abv,
	country_lang
)
VALUES (
	name,
	abv,
	lang
);

END$$

CREATE PROCEDURE `addEventChannels` (IN `eid` VARCHAR(11), IN `cid` INT)  BEGIN
INSERT INTO event_channel
(
    ev_id,
    ch_id
) VALUES (
    eid,
    cid
);
END$$

CREATE PROCEDURE `createEvent` (IN `id` VARCHAR(11), IN `name` VARCHAR(45), IN `sch` DATETIME, IN `ending` DATETIME, IN `des` VARCHAR(45), IN `type` INT, IN `country` INT)  BEGIN
INSERT INTO events (
	ev_id,
    ev_name,
    ev_sch,
    ev_sch_end,
    ev_des,
    ev_country
)
VALUES
(
	id,
    name,
    sch,
    ending,
    des,
    country
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

CREATE PROCEDURE `getChannelList` ()  BEGIN
SELECT 
ch.ch_id,
ch.ch_name,
ch.ch_abv,
ch.ch_img,
co.country_name,
la.lang_name
FROM channels ch
INNER JOIN countries co
ON ch.ch_country = co.country_id
INNER JOIN languages la
ON co.country_lang = la.lang_id
GROUP BY
1,2,3,4,5,6;
END$$

CREATE PROCEDURE `getCountryInformation` (IN `id` VARCHAR(11))  BEGIN
SELECT 
country_id,
country_name,
country_abv,
country_lang
FROM countries
WHERE country_id = id;
END$$

CREATE PROCEDURE `getCountryList` ()  BEGIN
SELECT 
c.country_id,
c.country_name,
c.country_abv,
l.lang_name
FROM countries c
INNER JOIN languages l
ON c.country_lang = l.lang_id;
END$$

CREATE PROCEDURE `getEventInformation` (IN `id` VARCHAR(11))  BEGIN
SELECT
	ev.ev_id,
	ev.ev_name,
    ev.ev_sch,
    ev.ev_sch_end,
    ev.ev_des,
    ev.ev_country,
    tp.tp_id
FROM events ev
INNER JOIN type_event te 
ON ev.ev_id = te.ev_id
INNER JOIN types tp
ON te.tp_id = tp.tp_id
WHERE ev.ev_id = id
GROUP BY
	1,2,3,4,5,6,7;
    
END$$

CREATE PROCEDURE `getEventList` ()  BEGIN
SELECT 
ev.ev_id, 
ev.ev_name,
ev.ev_sch,
ev.ev_sch_end,
co.country_name
FROM events ev
INNER JOIN countries co
ON ev.ev_country = co.country_id;
END$$

CREATE PROCEDURE `getLanguagesList` ()  BEGIN
SELECT 
l.lang_id,
l.lang_name,
COUNT(c.country_lang)
FROM languages l
LEFT JOIN countries c
ON l.lang_id = c.country_lang
GROUP BY
1,2;
END$$

CREATE PROCEDURE `modifyChannel` (`id` INT, `chname` VARCHAR(45), `chabv` VARCHAR(4), `chimg` VARCHAR(400), `chcountry` INT)  BEGIN 
UPDATE channels 
SET
    ch_name = chname, 
    ch_abv = chabv, 
    ch_img = chimg,
    ch_country = chcountry
WHERE ch_id = id;    
END$$

CREATE PROCEDURE `modifyCountry` (IN `id` VARCHAR(11), IN `name` VARCHAR(25), IN `abv` VARCHAR(4), IN `lang` INT)  BEGIN
UPDATE countries
SET 
country_name = name,
country_abv = abv,
country_lang = lang
WHERE country_id = id;
END$$

CREATE PROCEDURE `restReq_getChannelInfo` (IN `id` INT)  BEGIN
SELECT
ch_id,
ch_name,
ch_abv,
ch_img
FROM channels
WHERE ch_id = id;
END$$

CREATE PROCEDURE `restReq_getEventChannelList` (IN `id` VARCHAR(11))  BEGIN
SELECT 
ch.ch_id, 
ch.ch_name, 
ch.ch_abv, 
ch.ch_img
FROM channels ch
INNER JOIN event_channel evc
ON evc.ch_id = ch.ch_id
WHERE evc.ev_id = id;
END$$

CREATE PROCEDURE `updateEvent` (IN `id` VARCHAR(11), IN `name` VARCHAR(45), IN `sch` DATETIME, IN `sch_end` DATETIME, IN `des` VARCHAR(45), IN `country` INT, IN `type` INT)  BEGIN
UPDATE events
SET
	ev_name = name,
    ev_sch = sch,
    ev_sch_end = sch_end,
    ev_des = des,
    ev_country = country
WHERE ev_id = id;

UPDATE type_event
SET
	tp_id = type
WHERE ev_id = id;
END$$

DELIMITER ;

CREATE TABLE `channels` (
  `ch_id` int(11) NOT NULL,
  `ch_name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ch_abv` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ch_img` varchar(400) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ch_country` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `country_abv` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `country_lang` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `countries` (`country_id`, `country_name`, `country_abv`, `country_lang`) VALUES
(1, 'Mexico', 'MX', 2),
(2, 'Spain', 'SP', 2);

CREATE TABLE `events` (
  `ev_id` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `ev_name` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ev_sch` datetime DEFAULT NULL,
  `ev_sch_end` datetime DEFAULT NULL,
  `ev_des` varchar(140) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ev_country` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `event_channel` (
  `ev_id` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `ch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `languages` (
  `lang_id` int(11) NOT NULL,
  `lang_name` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `languages` (`lang_id`, `lang_name`) VALUES
(1, 'English'),
(2, 'Spanish'),
(3, 'French'),
(4, 'Portuguese');

CREATE TABLE `types` (
  `tp_id` int(11) NOT NULL,
  `tp_name` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `types` (`tp_id`, `tp_name`) VALUES
(0, 'Generic'),
(1, 'Football'),
(2, 'Soccer'),
(3, 'Basketball'),
(4, 'Baseball'),
(5, 'Music'),
(6, 'Awards');

CREATE TABLE `type_event` (
  `tp_id` int(11) NOT NULL,
  `ev_id` varchar(11) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


ALTER TABLE `channels`
  ADD PRIMARY KEY (`ch_id`),
  ADD KEY `fk_channel_country_idx` (`ch_country`);

ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`),
  ADD KEY `fk_country_language_idx` (`country_lang`);

ALTER TABLE `events`
  ADD PRIMARY KEY (`ev_id`),
  ADD KEY `fk_event_country_idx` (`ev_country`);

ALTER TABLE `event_channel`
  ADD KEY `fk_event_channel_event_idx` (`ev_id`),
  ADD KEY `fk_event_channel_channel_idx` (`ch_id`);

ALTER TABLE `languages`
  ADD PRIMARY KEY (`lang_id`);

ALTER TABLE `types`
  ADD PRIMARY KEY (`tp_id`);

ALTER TABLE `type_event`
  ADD KEY `fk_type_event_event_idx` (`ev_id`),
  ADD KEY `fk_type_event_type_idx` (`tp_id`);


ALTER TABLE `channels`
  MODIFY `ch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
ALTER TABLE `countries`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `languages`
  MODIFY `lang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `types`
  MODIFY `tp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `channels`
  ADD CONSTRAINT `fk_channel_country` FOREIGN KEY (`ch_country`) REFERENCES `countries` (`country_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `countries`
  ADD CONSTRAINT `fk_country_language` FOREIGN KEY (`country_lang`) REFERENCES `languages` (`lang_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `events`
  ADD CONSTRAINT `fk_event_country` FOREIGN KEY (`ev_country`) REFERENCES `countries` (`country_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `event_channel`
  ADD CONSTRAINT `fk_event_channel_channel` FOREIGN KEY (`ch_id`) REFERENCES `channels` (`ch_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_event_channel_event` FOREIGN KEY (`ev_id`) REFERENCES `events` (`ev_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `type_event`
  ADD CONSTRAINT `fk_type_event_event` FOREIGN KEY (`ev_id`) REFERENCES `events` (`ev_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_type_event_type` FOREIGN KEY (`tp_id`) REFERENCES `types` (`tp_id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
