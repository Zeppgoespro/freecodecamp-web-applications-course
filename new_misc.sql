-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: mysql-wa4e
-- Время создания: Сен 12 2023 г., 19:21
-- Версия сервера: 8.0.34
-- Версия PHP: 8.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `new_misc`
--

-- --------------------------------------------------------

--
-- Структура таблицы `educations`
--

CREATE TABLE `educations` (
  `profile_id` int NOT NULL,
  `institution_id` int NOT NULL,
  `rank` int DEFAULT NULL,
  `year` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `educations`
--

INSERT INTO `educations` (`profile_id`, `institution_id`, `rank`, `year`) VALUES
(8, 24, 1, 1990),
(8, 32, 2, 2000),
(9, 30, 1, 1990),
(9, 31, 2, 2000),
(10, 25, 1, 1990),
(10, 26, 2, 2000),
(11, 27, 1, 1990),
(12, 27, 1, 1990),
(12, 31, 2, 2000),
(13, 33, 1, 1990),
(15, 28, 1, 1990),
(16, 33, 1, 1990),
(23, 28, 1, 1990),
(23, 29, 2, 2000),
(24, 24, 1, 1990),
(24, 25, 2, 2000);

-- --------------------------------------------------------

--
-- Структура таблицы `institutions`
--

CREATE TABLE `institutions` (
  `institution_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `institutions`
--

INSERT INTO `institutions` (`institution_id`, `name`) VALUES
(29, 'Duke University'),
(33, 'Jedi Temple'),
(30, 'Michigan State University'),
(31, 'Mississippi State University'),
(32, 'Montana State University'),
(28, 'Stanford University'),
(27, 'University of Cambridge'),
(24, 'University of Michigan'),
(26, 'University of Oxford'),
(25, 'University of Virginia');

-- --------------------------------------------------------

--
-- Структура таблицы `positions`
--

CREATE TABLE `positions` (
  `position_id` int NOT NULL,
  `profile_id` int DEFAULT NULL,
  `rank` int DEFAULT NULL,
  `year` int DEFAULT NULL,
  `description` mediumtext COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `positions`
--

INSERT INTO `positions` (`position_id`, `profile_id`, `rank`, `year`, `description`) VALUES
(22, 8, 1, 747, 'Born'),
(23, 23, 1, 747, 'Born April 2, 747?'),
(24, 23, 2, 814, 'Died January 28, 814, Aachen, Austrasia (now in Germany)'),
(25, 23, 3, 800, 'Becomes first emperor of the Holy Roman Empire'),
(29, 11, 1, 1999, 'Great year!'),
(30, 11, 2, 2000, 'Legendary year'),
(31, 15, 1, 1991, 'Epic hunt'),
(32, 9, 1, 1990, 'Good year'),
(33, 9, 2, 2022, 'Best year'),
(34, 9, 3, 2023, 'Super year'),
(35, 10, 1, 1983, 'Guba-buba! >=('),
(36, 12, 1, 1983, 'Great year! =))'),
(37, 24, 1, 1138, 'Born'),
(38, 24, 2, 1193, 'Died');

-- --------------------------------------------------------

--
-- Структура таблицы `profiles`
--

CREATE TABLE `profiles` (
  `profile_id` int NOT NULL,
  `user_id` int NOT NULL,
  `first_name` mediumtext COLLATE utf8mb4_general_ci,
  `last_name` mediumtext COLLATE utf8mb4_general_ci,
  `email` mediumtext COLLATE utf8mb4_general_ci,
  `headline` mediumtext COLLATE utf8mb4_general_ci,
  `link` mediumtext COLLATE utf8mb4_general_ci NOT NULL,
  `summary` mediumtext COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `profiles`
--

INSERT INTO `profiles` (`profile_id`, `user_id`, `first_name`, `last_name`, `email`, `headline`, `link`, `summary`) VALUES
(8, 4, 'Bingo', 'Bongo', 'bingo@bookex.com', 'Mega Bingo', '', 'Very smart Bingo'),
(9, 5, 'Buba', 'Smith', 'buba@bookex.com', 'Super Buba', '', 'Very strong Buba'),
(10, 4, 'Jabba', 'Hutt', 'jaba@bookex.com', 'Big Jabba', 'https://static.wikia.nocookie.net/disney/images/d/df/Profile_-_Jabba_the_Hutt.jpg/revision/latest?cb=20190728025948', 'Angry Jabba'),
(11, 5, 'Benj', 'Bables', 'benj@bookex.com', 'Wise Benj', 'https://static.wikia.nocookie.net/sonypicturesanimation/images/4/4e/Benjamin_Bunny.png', 'Benj Dollars'),
(12, 4, 'Obi-Wan', 'Kenobi', 'obi-wan@bookex.com', 'Hello there!', 'https://static.wikia.nocookie.net/disney/images/e/eb/Profile_-_Obi-Wan_Kenobi.jpg/revision/latest?cb=20220611143255', 'Very smart and intelligent jedi master'),
(13, 4, 'Grogu', 'Baby Yoda', 'grogu@bookex.com', 'Lovely Grogu', 'https://static.wikia.nocookie.net/disney/images/5/5e/Grogu-profile.png/revision/latest?cb=20220219035747', 'Good Grogu'),
(14, 4, 'Boba', 'Fett', 'boba@bookex.com', 'Tough Boba', 'https://static.wikia.nocookie.net/starwars/images/a/a7/TBBF_Boba_Fett.png/revision/latest?cb=20211123232055', 'Bounty hunter with big hart'),
(15, 5, 'Cad', 'Bane', 'cad@bookex.com', 'Best bounty hunter', 'https://static.wikia.nocookie.net/rustarwars/images/9/96/CadBane_BOBF.png/revision/latest?cb=20220209181617', 'Very reserved'),
(16, 5, 'Ahsoka', 'Tano', 'tano@bookex.com', 'Not a jedi', 'https://static.wikia.nocookie.net/rustarwars/images/1/12/Ahsoka_Tano_TWJ.png/revision/latest?cb=20170127131319', 'Don\'t like some blue guy with red eyes'),
(17, 5, 'Master', 'Yoda', 'yoda@bookex.com', 'Very wise jedi master', 'https://static.wikia.nocookie.net/rustarwars/images/3/37/Yoda_infobox.png/revision/latest?cb=20180607090744', 'Turns into blue force ghost'),
(18, 4, 'Mace', 'Windu', 'mace@bookex.com', 'Jedi with purple lightsaber', 'https://static.wikia.nocookie.net/p__/images/f/fc/Mace_Windu.jpg/revision/latest?cb=20180519160844&path-prefix=protagonist', 'Samuel L. Jackson'),
(19, 4, 'Zinso', 'Pumpkins', 'zinso@bookex.com', 'Unlucky marauder', '', 'Makes things more complicated and messed'),
(20, 5, 'Han', 'Solo', 'han@bookex.com', 'The Millennium Falcon', 'https://static.wikia.nocookie.net/rustarwars/images/f/f4/HanSolo.jpg/revision/latest?cb=20160718074241', 'With Chewbacca'),
(21, 5, 'Chew', 'Bacca', 'bacca@bookex.com', 'Wookie', 'https://static.wikia.nocookie.net/starwars/images/4/48/Chewbacca_TLJ.png/revision/latest/scale-to-width-down/1200?cb=20221108044917', 'Big hairy hulk'),
(23, 5, 'Charlemagne', 'The Great', 'charles@bookex.com', 'Emperor of the West', 'https://cdn.britannica.com/50/209350-050-1CF0398A/oil-Charlemagne-limewood-collection-Albrecht-Durer-Nurnberg.jpg', 'Father of Europe'),
(24, 4, 'Saladin', 'ibn Ayyūb', 'saladin@bookex', 'Great Sultan', 'https://cdn.britannica.com/75/160175-050-1F177A2A/Saladin.jpg', 'Great crusaders enemy');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`) VALUES
(4, 'Mando', 'mando@bookex.com', 'd279256fe9776d733a31af1b81c50cf7'),
(5, 'Jiga', 'jiga@bookex.com', '51b8dbbbd386cb24b3376bf639ccaacc');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `educations`
--
ALTER TABLE `educations`
  ADD PRIMARY KEY (`profile_id`,`institution_id`),
  ADD KEY `educations_ibfk_2` (`institution_id`);

--
-- Индексы таблицы `institutions`
--
ALTER TABLE `institutions`
  ADD PRIMARY KEY (`institution_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`position_id`),
  ADD KEY `position_ibfk_1` (`profile_id`);

--
-- Индексы таблицы `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `profile_ibfk_2` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `email` (`email`),
  ADD KEY `password` (`password`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `institutions`
--
ALTER TABLE `institutions`
  MODIFY `institution_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT для таблицы `positions`
--
ALTER TABLE `positions`
  MODIFY `position_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT для таблицы `profiles`
--
ALTER TABLE `profiles`
  MODIFY `profile_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `educations`
--
ALTER TABLE `educations`
  ADD CONSTRAINT `educations_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`profile_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `educations_ibfk_2` FOREIGN KEY (`institution_id`) REFERENCES `institutions` (`institution_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `positions`
--
ALTER TABLE `positions`
  ADD CONSTRAINT `position_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`profile_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
