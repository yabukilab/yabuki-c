-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2021-07-14 09:24:32
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
(9, 'shimomura', 501, 5, 'おすすめ！', '2021-05-23'),
(10, 'seki', 600, 5, 'おすすめ！', '2021-05-23'),
(11, 'seki', 601, 5, 'おすすめ！', '2021-05-23'),
(12, 'takuma', 700, 5, 'おすすめ！', '2021-05-23'),
(14, 'takeda', 800, 5, 'おすすめ！', '2021-05-23'),
(15, 'takeda', 801, 5, 'おすすめ！', '2021-05-23'),
(16, 'tanimoto', 900, 5, 'おすすめ！', '2021-05-23'),
(18, 'tooyama', 1000, 5, 'おすすめ！', '2021-05-23'),
(19, 'tooyama', 1001, 5, 'おすすめ！', '2021-05-23'),
(20, 'yabuki', 1100, 5, 'おすすめ！', '2021-05-23'),
(21, 'yabuki', 1101, 5, 'おすすめ！', '2021-05-23'),
(34, 'ogasawara', 100, 3, '面白かった', '2021-07-05'),
(35, 'ogasawara', 100, 4, 'おもしろかった', '2021-07-05'),
(36, 'ogasawara', 100, 4, 'おもしろかった', '2021-07-05'),
(37, 'ogasawara', 100, 3, '面白かった！', '2021-07-05'),
(44, 'katou', 201, 1, 'おもしろい', '2021-07-05'),
(48, 'shimoda', 400, 5, 'いいね', '2021-07-05'),
(54, 'takeda', 800, 4, '良い', '2021-07-05'),
(56, 'tanimoto', 900, 5, '最高', '2021-07-05'),
(58, 'tooyama', 1001, 5, 'いいね', '2021-07-05'),
(59, 'yabuki', 1100, 4, 'おもしろい！', '2021-07-05'),
(61, 'ogasawara', 100, 4, '先生が面白い！', '2021-07-05'),
(62, 'katou', 200, 4, '面白かった！', '2021-07-06'),
(63, 'ogasawara', 100, 4, '分かりやすい！', '2021-07-06'),
(64, 'katou', 200, 5, '分かりやすい', '2021-07-06'),
(66, 'katou', 200, 4, '良い', '2021-07-06'),
(67, 'ogasawara', 100, 4, '良かった', '2021-07-09'),
(68, 'ogasawara', 100, 4, '面白かった', '2021-07-09'),
(69, 'seki', 600, 5, '良かった', '2021-07-09'),
(71, 'takuma', 700, 3, 'よい', '0000-00-00');

-- --------------------------------------------------------

--
-- テーブルの構造 `userinfo`
--

CREATE TABLE `userinfo` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `passwd` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `userinfo`
--

INSERT INTO `userinfo` (`id`, `username`, `passwd`) VALUES
(1, '2242097', '1234');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `kutikomi`
--
ALTER TABLE `kutikomi`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `kutikomi`
--
ALTER TABLE `kutikomi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- テーブルの AUTO_INCREMENT `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
