-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:8889
-- Час створення: Трв 14 2024 р., 10:11
-- Версія сервера: 5.7.39
-- Версія PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `teamupstart`
--

-- --------------------------------------------------------

--
-- Структура таблиці `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `user1_id` int(11) DEFAULT NULL,
  `user2_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `like_resume`
--

CREATE TABLE `like_resume` (
  `id` int(11) NOT NULL,
  `id_resume` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `chat_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `message` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `resume`
--

CREATE TABLE `resume` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `adress` varchar(255) NOT NULL,
  `education` varchar(255) NOT NULL,
  `lang` varchar(255) NOT NULL,
  `certifications` varchar(255) NOT NULL,
  `skills` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `schedule` varchar(255) NOT NULL,
  `from_price` int(11) NOT NULL,
  `age_user` varchar(255) NOT NULL,
  `experience` varchar(255) NOT NULL,
  `languages` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `team`
--

CREATE TABLE `team` (
  `id_team` int(11) NOT NULL,
  `id_user_1` int(11) NOT NULL,
  `id_user_2` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user1_id` (`user1_id`),
  ADD KEY `user2_id` (`user2_id`);

--
-- Індекси таблиці `like_resume`
--
ALTER TABLE `like_resume`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_resume` (`id_resume`),
  ADD KEY `id_user` (`id_user`);

--
-- Індекси таблиці `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_id` (`chat_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Індекси таблиці `resume`
--
ALTER TABLE `resume`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id_team`),
  ADD KEY `id_user_1` (`id_user_1`),
  ADD KEY `id_user_2` (`id_user_2`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблиці `like_resume`
--
ALTER TABLE `like_resume`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблиці `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблиці `resume`
--
ALTER TABLE `resume`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблиці `team`
--
ALTER TABLE `team`
  MODIFY `id_team` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`user1_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`user2_id`) REFERENCES `users` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `like_resume`
--
ALTER TABLE `like_resume`
  ADD CONSTRAINT `like_resume_ibfk_1` FOREIGN KEY (`id_resume`) REFERENCES `resume` (`id`),
  ADD CONSTRAINT `like_resume_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `team_ibfk_1` FOREIGN KEY (`id_user_1`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `team_ibfk_2` FOREIGN KEY (`id_user_2`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
