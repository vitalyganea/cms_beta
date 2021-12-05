-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 05 2021 г., 03:32
-- Версия сервера: 10.4.22-MariaDB
-- Версия PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `admin`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `title`, `description`) VALUES
(1, 'test category', '<p>hahahaha</p>\r\n'),
(2, 'test cat 2', '<p>sdfsdaf</p>\r\n');

-- --------------------------------------------------------

--
-- Структура таблицы `column_settings`
--

CREATE TABLE `column_settings` (
  `id` int(11) NOT NULL,
  `table_title` text NOT NULL,
  `column_title` text NOT NULL,
  `column_type` text NOT NULL,
  `ckeditor` int(11) NOT NULL DEFAULT 0,
  `required` int(11) NOT NULL DEFAULT 0,
  `column_size` int(11) NOT NULL DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `column_settings`
--

INSERT INTO `column_settings` (`id`, `table_title`, `column_title`, `column_type`, `ckeditor`, `required`, `column_size`) VALUES
(1, 'products', 'title', 'short_text', 0, 1, 100),
(2, 'products', 'description', 'long_text', 1, 1, 10),
(3, 'products', 'image', 'image', 0, 1, 10),
(4, 'products', 'pdf', 'file', 0, 0, 10),
(5, 'products', 'category_id', 'relations', 0, 0, 10),
(6, 'categories', 'title', 'short_text', 0, 1, 1000),
(7, 'categories', 'description', 'long_text', 1, 0, 10),
(8, '', '', '', 0, 0, 10),
(9, '', '', '', 0, 0, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `pdf` text NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `image`, `pdf`, `category_id`) VALUES
(1, 'dsfgfds', '<p>dfg</p>\r\n', '9ac96b0aff263b41a4f940b9b36dbc9e.jfif', '', 2),
(2, 'dfgdfgdfg', '', '6d317dbf4b4ec94eab74f38f8ac302cb.jfif', '45d2b32c7689cb7f22e9ca0427746366.txt', 1),
(3, 'test producstfdsgdf', '<p><em>sdafsadfasdfsadfsdfsadfsadf</em></p>\r\n', '7316ce60f414037ca7ce6178635d15de.jfif', '9477dd775bc09fff8c8c72fd21eb8d29.txt', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `tables`
--

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `table_title` text NOT NULL,
  `table_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tables`
--

INSERT INTO `tables` (`id`, `table_title`, `table_text`) VALUES
(1, 'products', 'Produse'),
(2, 'categories', 'Categorii');

-- --------------------------------------------------------

--
-- Структура таблицы `tables_relations`
--

CREATE TABLE `tables_relations` (
  `id` int(11) NOT NULL,
  `parent` text NOT NULL,
  `parent_column` text NOT NULL,
  `child` text NOT NULL,
  `child_column` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tables_relations`
--

INSERT INTO `tables_relations` (`id`, `parent`, `parent_column`, `child`, `child_column`) VALUES
(1, 'products', 'category_id', 'categories', 'title');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `column_settings`
--
ALTER TABLE `column_settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tables_relations`
--
ALTER TABLE `tables_relations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `column_settings`
--
ALTER TABLE `column_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `tables_relations`
--
ALTER TABLE `tables_relations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
