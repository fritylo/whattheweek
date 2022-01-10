-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Янв 11 2022 г., 01:42
-- Версия сервера: 8.0.27-0ubuntu0.20.04.1
-- Версия PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `just-field-cms`
--

-- --------------------------------------------------------

--
-- Структура таблицы `jf-cms_account`
--

CREATE TABLE `jf-cms_account` (
  `id_account` int NOT NULL,
  `account_email` varchar(75) NOT NULL,
  `account_login` varchar(35) NOT NULL,
  `account_password` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `jf-cms_account`
--

INSERT INTO `jf-cms_account` (`id_account`, `account_email`, `account_login`, `account_password`) VALUES
(1, 'nikonovfedor36936@gmail.com', 'frity', '6918c6cfd0dead1f0f0b4783949d8359'),
(2, '', 'mart', '25d55ad283aa400af464c76d713c07ad');

-- --------------------------------------------------------

--
-- Структура таблицы `jf-cms_db-access`
--

CREATE TABLE `jf-cms_db-access` (
  `id_db-access` int NOT NULL,
  `db-access_id_account` int NOT NULL,
  `db-access_id_db-item` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `jf-cms_db-item`
--

CREATE TABLE `jf-cms_db-item` (
  `id_db-item` int NOT NULL,
  `db-item_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `db-item_name` varchar(255) NOT NULL,
  `db-item_value` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `db-item_value-type` int NOT NULL,
  `db-item_value-subtype` int DEFAULT NULL,
  `db-item_parent` int DEFAULT NULL,
  `db-item_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `jf-cms_db-item`
--

INSERT INTO `jf-cms_db-item` (`id_db-item`, `db-item_key`, `db-item_name`, `db-item_value`, `db-item_value-type`, `db-item_value-subtype`, `db-item_parent`, `db-item_path`) VALUES
(1, '/', '/', '48,47,42,162,195,206,210,220', 4, NULL, NULL, '/'),
(42, 'pages', 'Страницы', '46,177,184', 4, NULL, 1, '/pages'),
(46, 'home', 'Главная', '54,62,66', 4, NULL, 42, '/pages/home'),
(47, 'logo', 'Логотип', '2', 3, NULL, 1, '/logo'),
(48, 'header', 'Шапка', '49,50', 4, NULL, 1, '/header'),
(49, 'slogan_1', 'Первая часть слогана', '7', 1, NULL, 48, '/header/slogan_1'),
(50, 'slogan_2', 'Вторая часть слогана', '8', 1, NULL, 48, '/header/slogan_2'),
(54, 'sections', 'Секции', '55,76,125,132,139,146,153', 4, NULL, 46, '/pages/home/sections'),
(55, 'about-me', 'Обо мне', '56,58,57,59,60,61', 4, NULL, 54, '/pages/home/sections/about-me'),
(56, 'title', 'Заголовок', '12', 1, NULL, 55, '/pages/home/sections/about-me/title'),
(57, 'text', 'Текст', '2', 2, NULL, 55, '/pages/home/sections/about-me/text'),
(58, 'image', 'Фото', '3', 3, NULL, 55, '/pages/home/sections/about-me/image'),
(59, 'icon', 'Картинка за текстом', '4', 3, NULL, 55, '/pages/home/sections/about-me/icon'),
(60, 'is_main', 'Секция главная?', '2', 7, NULL, 55, '/pages/home/sections/about-me/is_main'),
(61, 'is_image_right', 'Картинка справа?', '3', 7, NULL, 55, '/pages/home/sections/about-me/is_image_right'),
(62, 'sales', 'Плашка \"Акция\"', '63,64,65', 4, NULL, 46, '/pages/home/sales'),
(63, 'link', 'Ссылка подробнее', '13', 1, NULL, 62, '/pages/home/sales/link'),
(64, 'text', 'Текст', '3', 2, NULL, 62, '/pages/home/sales/text'),
(65, 'is_shown', 'Показывать плашку?', '4', 7, NULL, 62, '/pages/home/sales/is_shown'),
(66, 'contacts', 'Контакты', '67,70,73,160,161', 4, NULL, 46, '/pages/home/contacts'),
(67, 'facebook', 'Фейсбук', '68,69', 4, NULL, 66, '/pages/home/contacts/facebook'),
(68, 'link', 'Ссылка', '14', 1, NULL, 67, '/pages/home/contacts/facebook/link'),
(69, 'text', 'Текст', '15', 1, NULL, 67, '/pages/home/contacts/facebook/text'),
(70, 'instagram', 'Инстаграм', '71,72', 4, NULL, 66, '/pages/home/contacts/instagram'),
(71, 'link', 'Ссылка', '16', 1, NULL, 70, '/pages/home/contacts/instagram/link'),
(72, 'text', 'Текст', '17', 1, NULL, 70, '/pages/home/contacts/instagram/text'),
(73, 'skype', 'Скайп', '74,75', 4, NULL, 66, '/pages/home/contacts/skype'),
(74, 'link', 'Ссылка', '18', 1, NULL, 73, '/pages/home/contacts/skype/link'),
(75, 'text', 'Текст', '19', 1, NULL, 73, '/pages/home/contacts/skype/text'),
(76, 'about-project', 'О проекте', '77,78,165,79,80,81,82', 4, NULL, 54, '/pages/home/sections/about-project'),
(77, 'title', 'Заголовок', '20', 1, NULL, 76, '/pages/home/sections/about-project/title'),
(78, 'image', 'Фото', '5', 3, NULL, 76, '/pages/home/sections/about-project/image'),
(79, 'text', 'Текст', '4', 2, NULL, 76, '/pages/home/sections/about-project/text'),
(80, 'icon', 'Картинка за текстом', '6', 3, NULL, 76, '/pages/home/sections/about-project/icon'),
(81, 'is_main', 'Секция главная?', '5', 7, NULL, 76, '/pages/home/sections/about-project/is_main'),
(82, 'is_image_right', 'Картинка справа?', '6', 7, NULL, 76, '/pages/home/sections/about-project/is_image_right'),
(125, 'consult', 'Консультации', '126,127,128,129,130,131', 4, NULL, 54, '/pages/home/sections/consult'),
(126, 'title', 'Заголовок', '23', 1, NULL, 125, '/pages/home/sections/consult/title'),
(127, 'image', 'Фото', '45', 3, NULL, 125, '/pages/home/sections/consult/image'),
(128, 'text', 'Текст', '5', 2, NULL, 125, '/pages/home/sections/consult/text'),
(129, 'icon', 'Картинка за текстом', '46', 3, NULL, 125, '/pages/home/sections/consult/icon'),
(130, 'is_main', 'Секция главная?', '7', 7, NULL, 125, '/pages/home/sections/consult/is_main'),
(131, 'is_image_right', 'Картинка справа?', '8', 7, NULL, 125, '/pages/home/sections/consult/is_image_right'),
(132, 'event', 'Ближ мероприятия', '133,134,169,135,136,137,138', 4, NULL, 54, '/pages/home/sections/event'),
(133, 'title', 'Заголовок', '24', 1, NULL, 132, '/pages/home/sections/event/title'),
(134, 'image', 'Фото', '47', 3, NULL, 132, '/pages/home/sections/event/image'),
(135, 'text', 'Текст', '6', 2, NULL, 132, '/pages/home/sections/event/text'),
(136, 'icon', 'Картинка за текстом', '48', 3, NULL, 132, '/pages/home/sections/event/icon'),
(137, 'is_main', 'Секция главная?', '9', 7, NULL, 132, '/pages/home/sections/event/is_main'),
(138, 'is_image_right', 'Картинка справа?', '10', 7, NULL, 132, '/pages/home/sections/event/is_image_right'),
(139, 'numerology', 'Нумерология', '140,141,173,142,143,144,145', 4, NULL, 54, '/pages/home/sections/numerology'),
(140, 'title', 'Заголовок', '25', 1, NULL, 139, '/pages/home/sections/numerology/title'),
(141, 'image', 'Фото', '49', 3, NULL, 139, '/pages/home/sections/numerology/image'),
(142, 'text', 'Текст', '7', 2, NULL, 139, '/pages/home/sections/numerology/text'),
(143, 'icon', 'Картинка за текстом', '50', 3, NULL, 139, '/pages/home/sections/numerology/icon'),
(144, 'is_main', 'Секция главная?', '11', 7, NULL, 139, '/pages/home/sections/numerology/is_main'),
(145, 'is_image_right', 'Картинка справа?', '12', 7, NULL, 139, '/pages/home/sections/numerology/is_image_right'),
(146, 'shop', 'Магазин', '147,148,149,150,151,152', 4, NULL, 54, '/pages/home/sections/shop'),
(147, 'title', 'Заголовок', '26', 1, NULL, 146, '/pages/home/sections/shop/title'),
(148, 'image', 'Фото', '51', 3, NULL, 146, '/pages/home/sections/shop/image'),
(149, 'text', 'Текст', '8', 2, NULL, 146, '/pages/home/sections/shop/text'),
(150, 'icon', 'Картинка за текстом', '52', 3, NULL, 146, '/pages/home/sections/shop/icon'),
(151, 'is_main', 'Секция главная?', '13', 7, NULL, 146, '/pages/home/sections/shop/is_main'),
(152, 'is_image_right', 'Картинка справа?', '14', 7, NULL, 146, '/pages/home/sections/shop/is_image_right'),
(153, 'blog', 'Блог', '154,155,156,157,158,159', 4, NULL, 54, '/pages/home/sections/blog'),
(154, 'title', 'Заголовок', '27', 1, NULL, 153, '/pages/home/sections/blog/title'),
(155, 'image', 'Фото', '53', 3, NULL, 153, '/pages/home/sections/blog/image'),
(156, 'text', 'Текст', '9', 2, NULL, 153, '/pages/home/sections/blog/text'),
(157, 'icon', 'Картинка за текстом', '54', 3, NULL, 153, '/pages/home/sections/blog/icon'),
(158, 'is_main', 'Секция главная?', '15', 7, NULL, 153, '/pages/home/sections/blog/is_main'),
(159, 'is_image_right', 'Картинка справа?', '16', 7, NULL, 153, '/pages/home/sections/blog/is_image_right'),
(160, 'phone', 'Телефон', '28', 1, NULL, 66, '/pages/home/contacts/phone'),
(161, 'email', 'Email', '29', 1, NULL, 66, '/pages/home/contacts/email'),
(162, 'copywrite', 'Копирайт', '163,164', 4, NULL, 1, '/copywrite'),
(163, 'text', 'Текст', '30', 1, NULL, 162, '/copywrite/text'),
(164, 'date', 'Дата', '31', 1, NULL, 162, '/copywrite/date'),
(165, 'image_pos', 'Позиция фото', '166,167,168', 4, NULL, 76, '/pages/home/sections/about-project/image_pos'),
(166, NULL, '', '3', 6, NULL, 165, '/pages/home/sections/about-project/image_pos/'),
(167, 'x', 'Горизонталь', '32', 1, NULL, 165, '/pages/home/sections/about-project/image_pos/x'),
(168, 'y', 'Вертикаль', '33', 1, NULL, 165, '/pages/home/sections/about-project/image_pos/y'),
(169, 'image_pos', 'Позиция фото', '170,171,172', 4, NULL, 132, '/pages/home/sections/event/image_pos'),
(170, '', '', '4', 6, NULL, 169, '/pages/home/sections/event/image_pos/'),
(171, 'x', 'Горизонталь', '34', 1, NULL, 169, '/pages/home/sections/event/image_pos/x'),
(172, 'y', 'Вертикаль', '35', 1, NULL, 169, '/pages/home/sections/event/image_pos/y'),
(173, 'image_pos', 'Позиция фото', '174,175,176', 4, NULL, 139, '/pages/home/sections/numerology/image_pos'),
(174, '', '', '5', 6, NULL, 173, '/pages/home/sections/numerology/image_pos/'),
(175, 'x', 'Горизонталь', '36', 1, NULL, 173, '/pages/home/sections/numerology/image_pos/x'),
(176, 'y', 'Вертикаль', '37', 1, NULL, 173, '/pages/home/sections/numerology/image_pos/y'),
(177, 'about-me', 'Обо мне', '178,179,180,181,182,183', 4, NULL, 42, '/pages/about-me'),
(178, 'title', 'Заголовок', '38', 1, NULL, 177, '/pages/about-me/title'),
(179, 'image', 'Фото', '55', 3, NULL, 177, '/pages/about-me/image'),
(180, 'text', 'Текст', '10', 2, NULL, 177, '/pages/about-me/text'),
(181, 'icon', 'Картинка за текстом', '56', 3, NULL, 177, '/pages/about-me/icon'),
(182, 'is_main', 'Секция главная?', '17', 7, NULL, 177, '/pages/about-me/is_main'),
(183, 'is_image_right', 'Картинка справа?', '18', 7, NULL, 177, '/pages/about-me/is_image_right'),
(184, 'about-project', 'О проекте', '185,186,187,191,192,193,194', 4, NULL, 42, '/pages/about-project'),
(185, 'title', 'Заголовок', '39', 1, NULL, 184, '/pages/about-project/title'),
(186, 'image', 'Фото', '57', 3, NULL, 184, '/pages/about-project/image'),
(187, 'image_pos', 'Позиция фото', '188,189,190', 4, NULL, 184, '/pages/about-project/image_pos'),
(188, '', '', '6', 6, NULL, 187, '/pages/about-project/image_pos/'),
(189, 'x', 'Горизонталь', '40', 1, NULL, 187, '/pages/about-project/image_pos/x'),
(190, 'y', 'Вертикаль', '41', 1, NULL, 187, '/pages/about-project/image_pos/y'),
(191, 'text', 'Текст', '11', 2, NULL, 184, '/pages/about-project/text'),
(192, 'icon', 'Картинка за текстом', '58', 3, NULL, 184, '/pages/about-project/icon'),
(193, 'is_main', 'Секция главная?', '19', 7, NULL, 184, '/pages/about-project/is_main'),
(194, 'is_image_right', 'Картинка справа?', '20', 7, NULL, 184, '/pages/about-project/is_image_right'),
(195, 'products', 'Продукты', '196', 4, NULL, 1, '/products'),
(196, '__tpl__', 'Шаблон', '197,198,199,200,201,202,204,208,203', 4, NULL, 195, '/products/__tpl__'),
(197, 'title', 'Название', '42', 1, NULL, 196, '/products/__tpl__/title'),
(198, 'image', 'Картинка', '59', 3, NULL, 196, '/products/__tpl__/image'),
(199, 'tags', 'Тэги', '', 4, NULL, 196, '/products/__tpl__/tags'),
(200, 'type', 'Тип продукта', '43', 1, NULL, 196, '/products/__tpl__/type'),
(201, 'price', 'Цена', '44', 1, NULL, 196, '/products/__tpl__/price'),
(202, 'price_sale', 'Цена со скидкой', '45', 1, NULL, 196, '/products/__tpl__/price_sale'),
(203, 'text', 'Описание', '12', 2, NULL, 196, '/products/__tpl__/text'),
(204, 'annotation', 'Краткое описание', '13', 2, NULL, 196, '/products/__tpl__/annotation'),
(206, 'mailing', 'Рассылки', '207', 4, NULL, 1, '/mailing'),
(207, '__tpl__', 'Шаблон', '', 4, NULL, 206, '/mailing/__tpl__'),
(208, 'annotation_image', '', '60', 3, NULL, 196, '/products/__tpl__/annotation_image'),
(210, 'excel_tmp', 'Проба по экселю', '211', 4, NULL, 1, '/excel_tmp'),
(220, 'wtw', 'WhatTheWeek', '221', 4, NULL, 1, '/wtw'),
(221, 'excel', 'Excel for processing', '8', 12, NULL, 220, '/wtw/excel');

-- --------------------------------------------------------

--
-- Структура таблицы `jf-cms_type`
--

CREATE TABLE `jf-cms_type` (
  `id_type` int NOT NULL,
  `type_is-basic` tinyint(1) NOT NULL,
  `type_has-children` tinyint(1) NOT NULL DEFAULT '0',
  `type_name` varchar(75) NOT NULL,
  `type_descr` json DEFAULT NULL,
  `type_icon` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `jf-cms_type`
--

INSERT INTO `jf-cms_type` (`id_type`, `type_is-basic`, `type_has-children`, `type_name`, `type_descr`, `type_icon`) VALUES
(1, 1, 0, 'field', '\"string\"', 'field.png'),
(2, 1, 0, 'text', '{\"html\": \"string\", \"value\": \"string\"}', 'text.png'),
(3, 1, 0, 'image', '{\"src\": \"string\", \"name\": \"string\"}', 'image.png'),
(4, 1, 1, 'object', NULL, 'object.png'),
(5, 1, 1, 'list', NULL, ''),
(6, 1, 0, 'space', '\"string\"', 'space.png'),
(7, 1, 0, 'boolean', '\"int\"', 'boolean.png'),
(8, 1, 0, 'file', '{\"src\": \"string\", \"name\": \"string\"}', 'file.png'),
(9, 1, 0, 'audio', '{\"src\": \"string\", \"name\": \"string\"}', 'audio.png'),
(10, 1, 0, 'video', '{\"src\": \"string\", \"name\": \"string\"}', 'video.png'),
(11, 1, 0, 'mirror', NULL, 'mirror.png'),
(12, 0, 0, 'excel', '{\"src\": \"string\", \"name\": \"string\"}', 'excel.png');

-- --------------------------------------------------------

--
-- Структура таблицы `jf-cms_T_audio`
--

CREATE TABLE `jf-cms_T_audio` (
  `id_audio` int NOT NULL,
  `audio_src` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `jf-cms_T_boolean`
--

CREATE TABLE `jf-cms_T_boolean` (
  `id_boolean` int NOT NULL,
  `boolean_value` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `jf-cms_T_boolean`
--

INSERT INTO `jf-cms_T_boolean` (`id_boolean`, `boolean_value`) VALUES
(2, 1),
(3, 1),
(4, 1),
(5, 0),
(6, 0),
(7, 0),
(8, 1),
(9, 0),
(10, 0),
(11, 0),
(12, 1),
(13, 0),
(14, 0),
(15, 0),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `jf-cms_T_excel`
--

CREATE TABLE `jf-cms_T_excel` (
  `id_excel` int NOT NULL,
  `excel_src` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `jf-cms_T_excel`
--

INSERT INTO `jf-cms_T_excel` (`id_excel`, `excel_src`) VALUES
(1, 'excel1.xlsx'),
(8, 'excel8.xlsx');

-- --------------------------------------------------------

--
-- Структура таблицы `jf-cms_T_field`
--

CREATE TABLE `jf-cms_T_field` (
  `id_field` int NOT NULL,
  `field_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `jf-cms_T_field`
--

INSERT INTO `jf-cms_T_field` (`id_field`, `field_value`) VALUES
(7, 'Сайт психолога'),
(8, 'Ирены Беркуты'),
(12, 'Обо мне'),
(13, '../sales'),
(14, '#'),
(15, 'Facebook'),
(16, '#'),
(17, '@inst.account'),
(18, '#'),
(19, 'skypelogin'),
(20, ' О проекте'),
(23, 'Консультации психолога'),
(24, 'Мероприятия'),
(25, 'Нумерология'),
(26, 'Магазин шпаргалок'),
(27, 'Блог'),
(28, '70001234567'),
(29, 'email.email@email.email'),
(30, 'Ирена Беркута'),
(31, '2022'),
(32, '25'),
(33, '50'),
(34, '50'),
(35, '75'),
(36, '35'),
(37, '50'),
(38, 'Обо мне'),
(39, ' О проекте'),
(40, '25'),
(41, '50'),
(42, ''),
(43, ''),
(44, ''),
(45, '');

-- --------------------------------------------------------

--
-- Структура таблицы `jf-cms_T_file`
--

CREATE TABLE `jf-cms_T_file` (
  `id_file` int NOT NULL,
  `file_src` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `jf-cms_T_image`
--

CREATE TABLE `jf-cms_T_image` (
  `id_image` int NOT NULL,
  `image_src` varchar(20000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `jf-cms_T_image`
--

INSERT INTO `jf-cms_T_image` (`id_image`, `image_src`) VALUES
(2, '2.png'),
(3, '3.jpg'),
(4, '4.svg'),
(5, '5.jpg'),
(6, '6.svg'),
(45, '45.jpeg'),
(46, '46.svg'),
(47, '47.jpeg'),
(48, '48.svg'),
(49, '49.jpeg'),
(50, '50.svg'),
(51, '51.jpg'),
(52, '52.svg'),
(53, '53.jpeg'),
(54, '54.svg'),
(55, '55.jpg'),
(56, '56.svg'),
(57, '57.jpg'),
(58, '58.svg'),
(59, ''),
(60, '');

-- --------------------------------------------------------

--
-- Структура таблицы `jf-cms_T_space`
--

CREATE TABLE `jf-cms_T_space` (
  `id_space` int NOT NULL,
  `space_value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `jf-cms_T_space`
--

INSERT INTO `jf-cms_T_space` (`id_space`, `space_value`) VALUES
(3, 'Положение картинки задаётся в процентах. Значения полей - число от 0 до 100. Значение 50 - по центру.'),
(4, 'Положение картинки задаётся в процентах. Значения полей - число от 0 до 100. Значение 50 - по центру.'),
(5, 'Положение картинки задаётся в процентах. Значения полей - число от 0 до 100. Значение 50 - по центру.'),
(6, 'Положение картинки задаётся в процентах. Значения полей - число от 0 до 100. Значение 50 - по центру.');

-- --------------------------------------------------------

--
-- Структура таблицы `jf-cms_T_text`
--

CREATE TABLE `jf-cms_T_text` (
  `id_text` int NOT NULL,
  `text_value` text NOT NULL,
  `text_html` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `jf-cms_T_text`
--

INSERT INTO `jf-cms_T_text` (`id_text`, `text_value`, `text_html`) VALUES
(2, '{&quot;time&quot;:1641650446980,&quot;blocks&quot;:[{&quot;id&quot;:&quot;juFZVi1ZV9&quot;,&quot;type&quot;:&quot;paragraph&quot;,&quot;data&quot;:{&quot;text&quot;:&quot;\\u042d\\u0442\\u043e \\u043f\\u0440\\u043e\\u0441\\u0442\\u043e\\u0439 \\u0442\\u0435\\u043a\\u0441\\u0442, \\u0430 \\u044d\\u0442\\u043e&amp;nbsp;&lt;b&gt;\\u0436\\u0438\\u0440\\u043d\\u044b\\u0439&lt;\\/b&gt;, \\u0442\\u0435\\u043f\\u0435\\u0440\\u044c&amp;nbsp;&lt;i&gt;\\u043a\\u0443\\u0440\\u0441\\u0438\\u0432&lt;\\/i&gt;,&amp;nbsp;&lt;mark class=\\&quot;cdx-marker\\&quot;&gt;\\u043c\\u0430\\u0440\\u043a\\u0435\\u0440&lt;\\/mark&gt;,&amp;nbsp;&lt;a href=\\&quot;http:\\/\\/google.com\\/\\&quot;&gt;\\u0441\\u0441\\u044b\\u043b\\u043a\\u0430&lt;\\/a&gt;, \\u043f\\u043e\\u0434\\u0447\\u0435\\u0440\\u043a\\u0438\\u0432\\u0430\\u043d\\u0438\\u0435&quot;},&quot;tunes&quot;:{&quot;alignment&quot;:{&quot;alignment&quot;:&quot;left&quot;}}},{&quot;id&quot;:&quot;jQM-I8isqG&quot;,&quot;type&quot;:&quot;paragraph&quot;,&quot;data&quot;:{&quot;text&quot;:&quot;\\u0422\\u0435\\u043a\\u0441\\u0442 \\u043f\\u043e \\u0446\\u0435\\u043d\\u0442\\u0440\\u0443&quot;},&quot;tunes&quot;:{&quot;alignment&quot;:{&quot;alignment&quot;:&quot;center&quot;}}},{&quot;id&quot;:&quot;2MbR_x0vBr&quot;,&quot;type&quot;:&quot;paragraph&quot;,&quot;data&quot;:{&quot;text&quot;:&quot;\\u0422\\u0435\\u043a\\u0441\\u0442 \\u043f\\u043e \\u043f\\u0440\\u0430\\u0432\\u043e\\u043c\\u0443 \\u043a\\u0440\\u0430\\u044e&quot;},&quot;tunes&quot;:{&quot;alignment&quot;:{&quot;alignment&quot;:&quot;right&quot;}}},{&quot;id&quot;:&quot;zZhZchaW8z&quot;,&quot;type&quot;:&quot;list&quot;,&quot;data&quot;:{&quot;style&quot;:&quot;ordered&quot;,&quot;items&quot;:[&quot;\\u041f\\u0440\\u043e\\u0441\\u0442\\u043e\\u0439 \\u043d\\u0443\\u043c\\u0435\\u0440\\u043e\\u0432\\u0430\\u043d\\u043d\\u044b\\u0439 \\u0441\\u043f\\u0438\\u0441\\u043e\\u043a&quot;,&quot;\\u0415\\u0449\\u0451 \\u0440\\u0430\\u0437&quot;]}},{&quot;id&quot;:&quot;u7pPH1B7kL&quot;,&quot;type&quot;:&quot;header&quot;,&quot;data&quot;:{&quot;text&quot;:&quot;\\u0420\\u0430\\u0437\\u0440\\u044b\\u0432 \\u0437\\u0430\\u0433\\u043e\\u043b\\u043e\\u0432\\u043a\\u043e\\u043c&quot;,&quot;level&quot;:2,&quot;anchor&quot;:&quot;&quot;},&quot;tunes&quot;:{&quot;alignment&quot;:{&quot;alignment&quot;:&quot;left&quot;}}},{&quot;id&quot;:&quot;CqQh-S-EpQ&quot;,&quot;type&quot;:&quot;list&quot;,&quot;data&quot;:{&quot;style&quot;:&quot;unordered&quot;,&quot;items&quot;:[&quot;\\u041d\\u0435\\u043d\\u0443\\u043c\\u0435\\u0440\\u043e\\u0432\\u0430\\u043d\\u043d\\u044b\\u0439 \\u0441\\u043f\\u0438\\u0441\\u043e\\u043a&quot;,&quot;\\u0415\\u0449\\u0451 \\u0440\\u0430\\u0437&quot;]}},{&quot;id&quot;:&quot;J26tfAcc8C&quot;,&quot;type&quot;:&quot;paragraph&quot;,&quot;data&quot;:{&quot;text&quot;:&quot;Lacus in iaculis ut ut facilisi suspendisse pharetra. Scelerisque convallis ac tellus felis mauris egestas amet, aenean urna. Scelerisque egestas sed cursus at felis urna nullam. Ut rutrum adipiscing hendrerit consectetur nulla cursus non gravida. Quam venenatis amet ultrices quam massa faucibus maecenas pellentesque. Orci neque ultrices pretium est et lectus enim vitae pellentesque.&quot;},&quot;tunes&quot;:{&quot;alignment&quot;:{&quot;alignment&quot;:&quot;left&quot;}}}],&quot;version&quot;:&quot;2.22.2&quot;}', '<p style=\"text-align: left\">Это простой текст, а это&nbsp;<b>жирный</b>, теперь&nbsp;<i>курсив</i>,&nbsp;<mark class=\"cdx-marker\">маркер</mark>,&nbsp;<a href=\"http://google.com/\">ссылка</a>, подчеркивание</p><p style=\"text-align: center\">Текст по центру</p><p style=\"text-align: right\">Текст по правому краю</p><ol><li>Простой нумерованный список</li><li>Ещё раз</li></ol><h2 style=\"text-align: left\" id=\"\">Разрыв заголовком</h2><ul><li>Ненумерованный список</li><li>Ещё раз</li></ul><p style=\"text-align: left\">Lacus in iaculis ut ut facilisi suspendisse pharetra. Scelerisque convallis ac tellus felis mauris egestas amet, aenean urna. Scelerisque egestas sed cursus at felis urna nullam. Ut rutrum adipiscing hendrerit consectetur nulla cursus non gravida. Quam venenatis amet ultrices quam massa faucibus maecenas pellentesque. Orci neque ultrices pretium est et lectus enim vitae pellentesque.</p>'),
(3, '{&quot;time&quot;:1641649905547,&quot;blocks&quot;:[{&quot;id&quot;:&quot;RsIEKjCdcD&quot;,&quot;type&quot;:&quot;paragraph&quot;,&quot;data&quot;:{&quot;text&quot;:&quot;\\u0422\\u043e\\u043b\\u044c\\u043a\\u043e \\u0441\\u0435\\u0433\\u043e\\u0434\\u043d\\u044f \\u0441\\u043a\\u0438\\u0434\\u043a\\u0430 \\u043d\\u0430 \\u0432\\u0441\\u0435 \\u043a\\u0443\\u0440\\u0441\\u044b&quot;},&quot;tunes&quot;:{&quot;alignment&quot;:{&quot;alignment&quot;:&quot;center&quot;}}},{&quot;id&quot;:&quot;Pxv2hl_ejP&quot;,&quot;type&quot;:&quot;header&quot;,&quot;data&quot;:{&quot;text&quot;:&quot;20%&quot;,&quot;level&quot;:1,&quot;anchor&quot;:&quot;&quot;},&quot;tunes&quot;:{&quot;alignment&quot;:{&quot;alignment&quot;:&quot;center&quot;}}}],&quot;version&quot;:&quot;2.22.2&quot;}', '<p style=\"text-align: center\">Только сегодня скидка на все курсы</p><h1 style=\"text-align: center\" id=\"\">20%</h1>'),
(4, '{&quot;time&quot;:1641738941366,&quot;blocks&quot;:[{&quot;id&quot;:&quot;MUG_a1u5xb&quot;,&quot;type&quot;:&quot;paragraph&quot;,&quot;data&quot;:{&quot;text&quot;:&quot;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&quot;},&quot;tunes&quot;:{&quot;alignment&quot;:{&quot;alignment&quot;:&quot;left&quot;}}}],&quot;version&quot;:&quot;2.22.2&quot;}', '<p style=\"text-align: left\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'),
(5, '{&quot;time&quot;:1641738941366,&quot;blocks&quot;:[{&quot;id&quot;:&quot;MUG_a1u5xb&quot;,&quot;type&quot;:&quot;paragraph&quot;,&quot;data&quot;:{&quot;text&quot;:&quot;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&quot;},&quot;tunes&quot;:{&quot;alignment&quot;:{&quot;alignment&quot;:&quot;left&quot;}}}],&quot;version&quot;:&quot;2.22.2&quot;}', '<p style=\"text-align: left\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'),
(6, '{&quot;time&quot;:1641738941366,&quot;blocks&quot;:[{&quot;id&quot;:&quot;MUG_a1u5xb&quot;,&quot;type&quot;:&quot;paragraph&quot;,&quot;data&quot;:{&quot;text&quot;:&quot;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&quot;},&quot;tunes&quot;:{&quot;alignment&quot;:{&quot;alignment&quot;:&quot;left&quot;}}}],&quot;version&quot;:&quot;2.22.2&quot;}', '<p style=\"text-align: left\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'),
(7, '{&quot;time&quot;:1641738941366,&quot;blocks&quot;:[{&quot;id&quot;:&quot;MUG_a1u5xb&quot;,&quot;type&quot;:&quot;paragraph&quot;,&quot;data&quot;:{&quot;text&quot;:&quot;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&quot;},&quot;tunes&quot;:{&quot;alignment&quot;:{&quot;alignment&quot;:&quot;left&quot;}}}],&quot;version&quot;:&quot;2.22.2&quot;}', '<p style=\"text-align: left\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'),
(8, '{&quot;time&quot;:1641738941366,&quot;blocks&quot;:[{&quot;id&quot;:&quot;MUG_a1u5xb&quot;,&quot;type&quot;:&quot;paragraph&quot;,&quot;data&quot;:{&quot;text&quot;:&quot;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&quot;},&quot;tunes&quot;:{&quot;alignment&quot;:{&quot;alignment&quot;:&quot;left&quot;}}}],&quot;version&quot;:&quot;2.22.2&quot;}', '<p style=\"text-align: left\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'),
(9, '{&quot;time&quot;:1641738941366,&quot;blocks&quot;:[{&quot;id&quot;:&quot;MUG_a1u5xb&quot;,&quot;type&quot;:&quot;paragraph&quot;,&quot;data&quot;:{&quot;text&quot;:&quot;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&quot;},&quot;tunes&quot;:{&quot;alignment&quot;:{&quot;alignment&quot;:&quot;left&quot;}}}],&quot;version&quot;:&quot;2.22.2&quot;}', '<p style=\"text-align: left\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'),
(10, '{&quot;time&quot;:1641751930551,&quot;blocks&quot;:[{&quot;id&quot;:&quot;oXxZc8jlHZ&quot;,&quot;type&quot;:&quot;paragraph&quot;,&quot;data&quot;:{&quot;text&quot;:&quot;Lacus in iaculis ut ut facilisi suspendisse pharetra. Scelerisque convallis ac tellus felis mauris egestas amet, aenean urna. Scelerisque egestas sed cursus at felis urna nullam. Ut rutrum adipiscing hendrerit consectetur nulla cursus non gravida. Quam venenatis amet ultrices quam massa faucibus maecenas pellentesque. Orci neque ultrices pretium est et lectus enim vitae pellentesque.&quot;},&quot;tunes&quot;:{&quot;alignment&quot;:{&quot;alignment&quot;:&quot;left&quot;}}},{&quot;id&quot;:&quot;dk__xX88hC&quot;,&quot;type&quot;:&quot;paragraph&quot;,&quot;data&quot;:{&quot;text&quot;:&quot;Lacus in iaculis ut ut facilisi suspendisse pharetra. Scelerisque convallis ac tellus felis mauris egestas amet, aenean urna. Scelerisque egestas sed cursus at felis urna nullam. Ut rutrum adipiscing hendrerit consectetur nulla cursus non gravida. Quam venenatis amet ultrices quam massa faucibus maecenas pellentesque. Orci neque ultrices pretium est et lectus enim vitae pellentesque.&quot;},&quot;tunes&quot;:{&quot;alignment&quot;:{&quot;alignment&quot;:&quot;left&quot;}}}],&quot;version&quot;:&quot;2.22.2&quot;}', '<p style=\"text-align: left\">Lacus in iaculis ut ut facilisi suspendisse pharetra. Scelerisque convallis ac tellus felis mauris egestas amet, aenean urna. Scelerisque egestas sed cursus at felis urna nullam. Ut rutrum adipiscing hendrerit consectetur nulla cursus non gravida. Quam venenatis amet ultrices quam massa faucibus maecenas pellentesque. Orci neque ultrices pretium est et lectus enim vitae pellentesque.</p><p style=\"text-align: left\">Lacus in iaculis ut ut facilisi suspendisse pharetra. Scelerisque convallis ac tellus felis mauris egestas amet, aenean urna. Scelerisque egestas sed cursus at felis urna nullam. Ut rutrum adipiscing hendrerit consectetur nulla cursus non gravida. Quam venenatis amet ultrices quam massa faucibus maecenas pellentesque. Orci neque ultrices pretium est et lectus enim vitae pellentesque.</p>'),
(11, '{&quot;time&quot;:1641742429664,&quot;blocks&quot;:[{&quot;id&quot;:&quot;XErbyrnEse&quot;,&quot;type&quot;:&quot;paragraph&quot;,&quot;data&quot;:{&quot;text&quot;:&quot;Lacus in iaculis ut ut facilisi suspendisse pharetra. Scelerisque convallis ac tellus felis mauris egestas amet, aenean urna. Scelerisque egestas sed cursus at felis urna nullam. Ut rutrum adipiscing hendrerit consectetur nulla cursus non gravida. Quam venenatis amet ultrices quam massa faucibus maecenas pellentesque. Orci neque ultrices pretium est et lectus enim vitae pellentesque.&quot;},&quot;tunes&quot;:{&quot;alignment&quot;:{&quot;alignment&quot;:&quot;left&quot;}}},{&quot;id&quot;:&quot;K--n4Y7LC9&quot;,&quot;type&quot;:&quot;paragraph&quot;,&quot;data&quot;:{&quot;text&quot;:&quot;Lacus in iaculis ut ut facilisi suspendisse pharetra. Scelerisque convallis ac tellus felis mauris egestas amet, aenean urna. Scelerisque egestas sed cursus at felis urna nullam. Ut rutrum adipiscing hendrerit consectetur nulla cursus non gravida. Quam venenatis amet ultrices quam massa faucibus maecenas pellentesque. Orci neque ultrices pretium est et lectus enim vitae pellentesque.&amp;nbsp;&quot;},&quot;tunes&quot;:{&quot;alignment&quot;:{&quot;alignment&quot;:&quot;left&quot;}}}],&quot;version&quot;:&quot;2.22.2&quot;}', '<p style=\"text-align: left\">Lacus in iaculis ut ut facilisi suspendisse pharetra. Scelerisque convallis ac tellus felis mauris egestas amet, aenean urna. Scelerisque egestas sed cursus at felis urna nullam. Ut rutrum adipiscing hendrerit consectetur nulla cursus non gravida. Quam venenatis amet ultrices quam massa faucibus maecenas pellentesque. Orci neque ultrices pretium est et lectus enim vitae pellentesque.</p><p style=\"text-align: left\">Lacus in iaculis ut ut facilisi suspendisse pharetra. Scelerisque convallis ac tellus felis mauris egestas amet, aenean urna. Scelerisque egestas sed cursus at felis urna nullam. Ut rutrum adipiscing hendrerit consectetur nulla cursus non gravida. Quam venenatis amet ultrices quam massa faucibus maecenas pellentesque. Orci neque ultrices pretium est et lectus enim vitae pellentesque.&nbsp;</p>'),
(12, '', ''),
(13, '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `jf-cms_T_video`
--

CREATE TABLE `jf-cms_T_video` (
  `id_video` int NOT NULL,
  `video_src` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `jf-cms_account`
--
ALTER TABLE `jf-cms_account`
  ADD PRIMARY KEY (`id_account`);

--
-- Индексы таблицы `jf-cms_db-access`
--
ALTER TABLE `jf-cms_db-access`
  ADD PRIMARY KEY (`id_db-access`),
  ADD KEY `db-access_id_account` (`db-access_id_account`,`db-access_id_db-item`),
  ADD KEY `db-access_id_db-item` (`db-access_id_db-item`);

--
-- Индексы таблицы `jf-cms_db-item`
--
ALTER TABLE `jf-cms_db-item`
  ADD PRIMARY KEY (`id_db-item`),
  ADD KEY `db-item_id_type` (`db-item_value-type`) USING BTREE,
  ADD KEY `db-item_value-subtype` (`db-item_value-subtype`);

--
-- Индексы таблицы `jf-cms_type`
--
ALTER TABLE `jf-cms_type`
  ADD PRIMARY KEY (`id_type`);

--
-- Индексы таблицы `jf-cms_T_audio`
--
ALTER TABLE `jf-cms_T_audio`
  ADD PRIMARY KEY (`id_audio`);

--
-- Индексы таблицы `jf-cms_T_boolean`
--
ALTER TABLE `jf-cms_T_boolean`
  ADD PRIMARY KEY (`id_boolean`);

--
-- Индексы таблицы `jf-cms_T_excel`
--
ALTER TABLE `jf-cms_T_excel`
  ADD PRIMARY KEY (`id_excel`);

--
-- Индексы таблицы `jf-cms_T_field`
--
ALTER TABLE `jf-cms_T_field`
  ADD PRIMARY KEY (`id_field`);

--
-- Индексы таблицы `jf-cms_T_file`
--
ALTER TABLE `jf-cms_T_file`
  ADD PRIMARY KEY (`id_file`);

--
-- Индексы таблицы `jf-cms_T_image`
--
ALTER TABLE `jf-cms_T_image`
  ADD PRIMARY KEY (`id_image`);

--
-- Индексы таблицы `jf-cms_T_space`
--
ALTER TABLE `jf-cms_T_space`
  ADD PRIMARY KEY (`id_space`);

--
-- Индексы таблицы `jf-cms_T_text`
--
ALTER TABLE `jf-cms_T_text`
  ADD PRIMARY KEY (`id_text`);

--
-- Индексы таблицы `jf-cms_T_video`
--
ALTER TABLE `jf-cms_T_video`
  ADD PRIMARY KEY (`id_video`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `jf-cms_account`
--
ALTER TABLE `jf-cms_account`
  MODIFY `id_account` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `jf-cms_db-access`
--
ALTER TABLE `jf-cms_db-access`
  MODIFY `id_db-access` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `jf-cms_db-item`
--
ALTER TABLE `jf-cms_db-item`
  MODIFY `id_db-item` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT для таблицы `jf-cms_type`
--
ALTER TABLE `jf-cms_type`
  MODIFY `id_type` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `jf-cms_T_audio`
--
ALTER TABLE `jf-cms_T_audio`
  MODIFY `id_audio` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `jf-cms_T_boolean`
--
ALTER TABLE `jf-cms_T_boolean`
  MODIFY `id_boolean` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `jf-cms_T_excel`
--
ALTER TABLE `jf-cms_T_excel`
  MODIFY `id_excel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `jf-cms_T_field`
--
ALTER TABLE `jf-cms_T_field`
  MODIFY `id_field` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT для таблицы `jf-cms_T_file`
--
ALTER TABLE `jf-cms_T_file`
  MODIFY `id_file` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `jf-cms_T_image`
--
ALTER TABLE `jf-cms_T_image`
  MODIFY `id_image` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT для таблицы `jf-cms_T_space`
--
ALTER TABLE `jf-cms_T_space`
  MODIFY `id_space` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `jf-cms_T_text`
--
ALTER TABLE `jf-cms_T_text`
  MODIFY `id_text` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `jf-cms_T_video`
--
ALTER TABLE `jf-cms_T_video`
  MODIFY `id_video` int NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `jf-cms_db-access`
--
ALTER TABLE `jf-cms_db-access`
  ADD CONSTRAINT `jf-cms_db-access_ibfk_1` FOREIGN KEY (`db-access_id_account`) REFERENCES `jf-cms_account` (`id_account`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `jf-cms_db-access_ibfk_2` FOREIGN KEY (`db-access_id_db-item`) REFERENCES `jf-cms_db-item` (`id_db-item`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `jf-cms_db-item`
--
ALTER TABLE `jf-cms_db-item`
  ADD CONSTRAINT `jf-cms_db-item_ibfk_1` FOREIGN KEY (`db-item_value-type`) REFERENCES `jf-cms_type` (`id_type`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `jf-cms_db-item_ibfk_2` FOREIGN KEY (`db-item_value-subtype`) REFERENCES `jf-cms_type` (`id_type`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
