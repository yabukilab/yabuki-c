-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2021-07-02 09:45:19
-- サーバのバージョン： 10.4.19-MariaDB
-- PHP のバージョン: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `mydb2`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `kutikomi`
--

CREATE TABLE `kutikomi` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `class` int(11) NOT NULL,
  `point` int(11) NOT NULL,
  `thoughts` varchar(150) NOT NULL,
  `day` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `kutikomi`
--

INSERT INTO `kutikomi` (`id`, `name`, `class`, `point`, `thoughts`, `day`) VALUES
(1, 'ogasawara', 100, 5, 'おすすめ！', '2021-05-23'),
(2, 'ogasawara', 101, 5, 'おすすめ！', '2021-05-23'),
(3, 'katou', 200, 5, 'おすすめ！', '2021-05-23'),
(4, 'katou', 201, 5, 'おすすめ！', '2021-05-23'),
(5, 'kounosu', 300, 5, 'おすすめ！', '2021-05-23'),
(6, 'kounosu', 301, 5, 'おすすめ！', '2021-05-23'),
(7, 'shimoda', 400, 5, 'おすすめ！', '2021-05-23'),
(8, 'shimomura', 500, 5, 'おすすめ！', '2021-05-23'),
(9, 'shimomura', 501, 5, 'おすすめ！', '2021-05-23');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `kutikomi`
--
ALTER TABLE `kutikomi`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `kutikomi`
--
ALTER TABLE `kutikomi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
