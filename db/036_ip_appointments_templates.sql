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
-- Структура таблицы `ip_appointments_templates`
--

CREATE TABLE `ip_appointments_templates` (
  `appointment_id` int(11) NOT NULL,
  `appointment_title` text,
  `appointment_description` longtext,
  `appointment_recurring_checked` int(2) DEFAULT NULL,
  `appointment_recurring` varchar(25) DEFAULT NULL,
  `appointments_recur_start_date` date DEFAULT NULL,
  `appointments_recur_end_date` date DEFAULT NULL,
  `appointment_address` text,
  `appointment_date` date DEFAULT NULL,
  `appointment_starting_time` time DEFAULT NULL,
  `appointment_end_time` time DEFAULT NULL,
  `appointment_total_time_of` varchar(250) DEFAULT NULL,
  `appointment_url_document` varchar(1200) DEFAULT NULL,
  `appointment_invoice_checked` int(2) DEFAULT NULL,
  `appointment_product_id` varchar(250) DEFAULT NULL,
  `appointment_price` decimal(20,2) NOT NULL DEFAULT '0.00',
  `appointment_departure_location` varchar(1200) DEFAULT NULL,
  `appointment_pickup_start_time` time DEFAULT NULL,
  `appointment_departure_end_location` varchar(1200) DEFAULT NULL,
  `appointment_pickup_end_time` time DEFAULT NULL,
  `appointment_pickup_stop_time` longtext,
  `appointment_stop_during_ride` varchar(1200) DEFAULT NULL,
  `appointment_kilometers` int(11) DEFAULT NULL,
  `appointment_price_per_kilometer` decimal(20,2) NOT NULL DEFAULT '0.00',
  `appointment_total_price_kilometer` decimal(20,2) NOT NULL DEFAULT '0.00',
  `appointment_invoice_kilometer_checked` int(2) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `create_date` date DEFAULT NULL,
  `appointment_update_date` datetime NOT NULL,
  `appointment_user_id` int(11) NOT NULL,
  `appointment_status` tinyint(4) NOT NULL,
  `appointment_add_people` text CHARACTER SET utf8,
  `appointment_url_key` char(32) DEFAULT NULL,
  `appointment_stayawaykey_checked` int(2) DEFAULT NULL,
  `appointment_starting_price_per_kilometer` decimal(20,2) DEFAULT '0.00',
  `appointment_how_many_seats_can_you_offer` int(11) DEFAULT NULL,
  `appointment_wek` text,
  `appointment_stayawaykey_price_kilometor_total` decimal(20,2) DEFAULT '0.00',
  `appointment_old_mileage` int(50) DEFAULT '0',
  `appointment_current_mileage` int(50) DEFAULT '0',
  `appointment_expenses_tax_office` decimal(20,2) DEFAULT '0.00',
  `appointment_carpool_checked` int(2) DEFAULT '0',
  `appointment_stayawaykey_price_per_kilometer` decimal(20,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `ip_appointments_templates`
--
ALTER TABLE `ip_appointments_templates`
  ADD PRIMARY KEY (`appointment_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `ip_appointments_templates`
--
ALTER TABLE `ip_appointments_templates`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
