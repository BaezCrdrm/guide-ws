SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `guide_db`
--

-- --------------------------------------------------------

CREATE TABLE `channels` (
  `ch_id` int(11) NOT NULL,
  `ch_name` varchar(45) NOT NULL,
  `ch_abv` varchar(4) NOT NULL,
  `ch_img` varchar(400) DEFAULT NULL
);

INSERT INTO `channels` (`ch_id`, `ch_name`, `ch_abv`, `ch_img`) VALUES
(1, 'ESPN', 'E1', NULL),
(2, 'ESPN 2', 'E2', NULL),
(3, 'FOX SPORTS', 'FXS1', NULL),
(4, 'FOX SPORTS 2', 'FXS2', NULL),
(5, 'AZTECA 7', 'A7', NULL),
(6, 'CANAL 5', 'C5', NULL);

-- --------------------------------------------------------

CREATE TABLE `event` (
  `ev_id` varchar(11) NOT NULL,
  `ev_name` varchar(45) NOT NULL,
  `ev_sch` datetime NOT NULL,
  `ev_des` varchar(45) DEFAULT NULL COMMENT 'Event description'
);

-- --------------------------------------------------------

CREATE TABLE `event_channel` (
  `ev_id` varchar(11) NOT NULL,
  `ch_id` int(11) NOT NULL
);

-- --------------------------------------------------------

CREATE TABLE `pass` (
  `id` varchar(240) NOT NULL,
  `pwd` varchar(60) NOT NULL
);

INSERT INTO `pass` (`id`, `pwd`) VALUES
('admin@admin.com', '459567d3bde4418b7fe302ff9809c4b0befaf7dd');

-- --------------------------------------------------------

CREATE TABLE `types` (
  `tp_id` int(11) NOT NULL,
  `tp_name` varchar(50) NOT NULL,
  `tp_img` varchar(400) DEFAULT NULL
);

INSERT INTO `types` (`tp_id`, `tp_name`, `tp_img`) VALUES
(1, 'Football', NULL),
(2, 'Soccer', NULL),
(3, 'Basketball', NULL),
(4, 'Baseball', NULL),
(5, 'Music', NULL),
(6, 'Awards', NULL),
(7, 'Other', NULL);

-- --------------------------------------------------------

CREATE TABLE `type_event` (
  `tp_id` int(11) NOT NULL,
  `ev_id` varchar(11) NOT NULL
);

-- --------------------------------------------------------

CREATE TABLE `users` (
  `user_id` varchar(240) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_age` int(11) DEFAULT NULL
);


INSERT INTO `users` (`user_id`, `user_name`, `user_age`) VALUES
('admin@admin.com', 'Admin', NULL);


ALTER TABLE `channels`
  ADD PRIMARY KEY (`ch_id`);


ALTER TABLE `event`
  ADD PRIMARY KEY (`ev_id`);


ALTER TABLE `event_channel`
  ADD KEY `fk_evch_ev_idx` (`ev_id`),
  ADD KEY `fk_evch_ch_idx` (`ch_id`);


ALTER TABLE `pass`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `types`
  ADD PRIMARY KEY (`tp_id`);


ALTER TABLE `type_event`
  ADD KEY `fk_ev_evtp` (`ev_id`),
  ADD KEY `fk_tp_evtp` (`tp_id`);


ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);


ALTER TABLE `channels`
  MODIFY `ch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `types`
  MODIFY `tp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `event_channel`
  ADD CONSTRAINT `fk_evch_ch` FOREIGN KEY (`ch_id`) REFERENCES `channels` (`ch_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_evch_ev` FOREIGN KEY (`ev_id`) REFERENCES `event` (`ev_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `pass`
  ADD CONSTRAINT `fk_pass_usr` FOREIGN KEY (`id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `type_event`
  ADD CONSTRAINT `fk_ev_evtp` FOREIGN KEY (`ev_id`) REFERENCES `event` (`ev_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tp_evtp` FOREIGN KEY (`tp_id`) REFERENCES `types` (`tp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
