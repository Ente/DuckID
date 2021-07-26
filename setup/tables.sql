-- Please use the following SQL Statements to create the DataBase for DuckID

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE `duckid`;

CREATE TABLE `tickets` (
  `ticket_id` int(255) NOT NULL,
  `ticket_infos` text NOT NULL,
  `ticket_message` varchar(256) NOT NULL,
  `ticket_attachements` varchar(256) DEFAULT NULL,
  `alt_id` bigint(255) DEFAULT NULL,
  `creator` varchar(256) NOT NULL,
  `status` text NOT NULL,
  `agent` text DEFAULT NULL,
  `messages` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

CREATE TABLE `users` (
  `user_id` varchar(256) NOT NULL,
  `username` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `status` varchar(256) NOT NULL,
  `banned` int(11) NOT NULL,
  `reg_date` text NOT NULL,
  `infos` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD UNIQUE KEY `alt_id` (`alt_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

 ALTER TABLE `tickets`
  MODIFY `ticket_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;