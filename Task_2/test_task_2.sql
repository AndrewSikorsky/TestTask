-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Квт 09 2017 р., 23:15
-- Версія сервера: 5.6.26-log
-- Версія PHP: 5.6.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `test_task_2`
--

-- --------------------------------------------------------

--
-- Структура таблиці `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`) VALUES
(1, 0, 'Категория 1'),
(2, 0, 'Категория 2'),
(3, 0, 'Категория 3'),
(4, 1, 'Категория 1.1'),
(5, 1, 'Категория 1.2'),
(6, 4, 'Категория 1.1.1'),
(7, 2, 'Категория 2.1'),
(8, 2, 'Категория 2.2'),
(9, 3, 'Категория 3.1'),
(10, 9, 'Категория 3.1.1'),
(11, 9, 'Категория 3.1.2'),
(12, 10, 'Категория 3.1.1.1'),
(13, 10, 'Категория 3.1.1.2');

-- --------------------------------------------------------

--
-- Структура таблиці `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `products`
--

INSERT INTO `products` (`id`, `name`, `price`) VALUES
(1, 'Товар 1', 100),
(2, 'Товар 2', 200),
(3, 'Товар 3', 300),
(4, 'Товар 4', 400),
(5, 'Товар 5', 500),
(6, 'Товар 6', 600),
(7, 'Товар 7', 700),
(8, 'Товар 8', 800),
(9, 'Товар 9', 900),
(10, 'Товар 10', 1000);

-- --------------------------------------------------------

--
-- Структура таблиці `products_to_categories`
--

CREATE TABLE `products_to_categories` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `products_to_categories`
--

INSERT INTO `products_to_categories` (`product_id`, `category_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(1, 4),
(4, 4),
(1, 5),
(5, 5),
(1, 6),
(6, 6),
(3, 9),
(9, 9),
(3, 10),
(9, 10),
(10, 10),
(7, 12);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `products_to_categories`
--
ALTER TABLE `products_to_categories`
  ADD PRIMARY KEY (`product_id`,`category_id`),
  ADD KEY `FK_cat_prod` (`category_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT для таблиці `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `products_to_categories`
--
ALTER TABLE `products_to_categories`
  ADD CONSTRAINT `FK_cat_prod` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_prod_cat` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
