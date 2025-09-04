-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:3306
-- サーバのバージョン： 10.11.11-MariaDB-0ubuntu0.24.04.2
-- PHP のバージョン: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS mydb CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE mydb;

-- --------------------------------------------------------

-- ユーザーテーブル
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 初期ユーザー
INSERT INTO `users` (`id`, `username`, `password`, `is_admin`) VALUES
(1, 'user1', '$2y$10$JUVEU6xv5GAHbgXIt7.8Q.N6ciSNdAFCyzwS7PHlanUqr1Phcn1La', 0)
ON DUPLICATE KEY UPDATE username=username;

-- --------------------------------------------------------

-- スコアテーブル
CREATE TABLE `score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `play_time` int(11) NOT NULL,
  `played_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `score_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;
