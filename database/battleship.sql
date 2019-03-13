-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 13 2019 г., 22:25
-- Версия сервера: 5.5.53
-- Версия PHP: 7.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `battleship`
--

-- --------------------------------------------------------

--
-- Структура таблицы `gamers`
--

CREATE TABLE `gamers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(100) NOT NULL DEFAULT '',
  `code` varchar(64) DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `wins` int(11) UNSIGNED DEFAULT '0',
  `fails` int(11) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `gamers`
--

INSERT INTO `gamers` (`id`, `fullname`, `code`, `email`, `wins`, `fails`) VALUES
(1, 'Javid Karimov', '', 'k.cavidd@gmail.com', 5, 1),
(2, 'Test player', '', 'ceki2490@gmail.com', 6, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `games`
--

CREATE TABLE `games` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gamer_id` int(11) DEFAULT '0',
  `has_won` int(2) UNSIGNED DEFAULT '0',
  `game_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `game_end` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `games`
--

INSERT INTO `games` (`id`, `gamer_id`, `has_won`, `game_start`, `game_end`) VALUES
(1, 1, 1, '2019-03-12 23:43:20', '2019-03-12 23:43:43'),
(2, 1, 1, '2019-03-12 23:45:32', '2019-03-12 23:46:08'),
(3, 1, 0, '2019-03-12 23:46:46', '2019-03-12 23:47:29'),
(4, 1, 1, '2019-03-12 23:51:05', '2019-03-12 23:51:24'),
(5, 1, 1, '2019-03-12 23:53:48', '2019-03-12 23:54:15'),
(6, 1, 0, '2019-03-12 23:54:17', '2019-03-12 23:54:50'),
(7, 1, 0, '2019-03-12 23:57:22', '2019-03-12 23:57:46'),
(8, 2, 1, '2019-03-13 17:38:56', '2019-03-13 17:39:13'),
(9, 2, 1, '2019-03-13 17:39:25', '2019-03-13 17:39:35'),
(10, 2, 1, '2019-03-13 17:39:37', '2019-03-13 17:39:54'),
(11, 2, 1, '2019-03-13 17:39:55', '2019-03-13 17:40:11'),
(12, 2, 1, '2019-03-13 17:40:12', '2019-03-13 17:40:23'),
(13, 2, 0, '2019-03-13 17:42:25', '2019-03-13 17:42:49'),
(14, 2, 1, '2019-03-13 17:42:50', '2019-03-13 17:43:07');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `gamers`
--
ALTER TABLE `gamers`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `games`
--
ALTER TABLE `games`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `gamers`
--
ALTER TABLE `gamers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `games`
--
ALTER TABLE `games`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
