-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 14 2019 г., 08:07
-- Версия сервера: 5.6.41
-- Версия PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `invoiceplane`
--

-- --------------------------------------------------------

--
-- Структура таблицы `ip_upfront_payments`
--

CREATE TABLE `ip_upfront_payments` (
  `upfront_payments_id` int(11) NOT NULL,
  `upfront_payments_name` text NOT NULL,
  `upfront_payments_category` longtext NOT NULL,
  `upfront_payments_date` date NOT NULL,
  `upfront_payments_amount` decimal(20,2) DEFAULT NULL,
  `upfront_payments_discount` decimal(20,2) DEFAULT NULL,
  `upfront_payments_document_link` longtext NOT NULL,
  `upfront_payments_discount_total` decimal(20,2) DEFAULT '0.00',
  `upfront_payments_description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `ip_upfront_payments`
--
ALTER TABLE `ip_upfront_payments`
  ADD PRIMARY KEY (`upfront_payments_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `ip_upfront_payments`
--
ALTER TABLE `ip_upfront_payments`
  MODIFY `upfront_payments_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
