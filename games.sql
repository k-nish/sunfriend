-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016 年 1 月 25 日 15:04
-- サーバのバージョン： 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sunfriend`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `gamename` text NOT NULL,
  `gameday` text NOT NULL,
  `result` text NOT NULL,
  `years` text NOT NULL,
  `date` datetime NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `games`
--

INSERT INTO `games` (`id`, `gamename`, `gameday`, `result`, `years`, `date`, `message`) VALUES
(1, '団体戦vsCAFT MD1', '2015/10/21', '', '', '0000-00-00 00:00:00', ''),
(11, '', '', '', '2女', '2016-01-25 21:22:55', ''),
(12, '', '', '', '2女', '2016-01-25 21:24:08', ''),
(13, '', '', '結果は途中', '2年', '2016-01-25 21:30:45', ''),
(14, '', '', '完全勝利です!', '3年', '2016-01-25 21:45:12', ''),
(15, '', '', '完全勝利です!', '3年', '2016-01-25 21:46:04', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
