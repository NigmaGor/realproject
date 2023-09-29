-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.51 - MySQL Community Server (GPL)
-- Операционная система:         Win64
-- HeidiSQL Версия:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных projects
CREATE DATABASE IF NOT EXISTS `projects` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `projects`;

-- Дамп структуры для таблица projects.Anketa
CREATE TABLE IF NOT EXISTS `Anketa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phamiliya` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `otchestvo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `id_organize` int(11) DEFAULT NULL,
  `login` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `year_begin` year(4) DEFAULT NULL,
  `logo` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nick` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_dolzhnost` int(11) DEFAULT NULL,
  `role` bit(2) DEFAULT NULL COMMENT '1 - заказчик, 2 - куратор, 3 - студент',
  PRIMARY KEY (`id`),
  KEY `FK_Anketa_Organization` (`id_organize`),
  KEY `FK_Anketa_Dolzhnost` (`id_dolzhnost`),
  CONSTRAINT `FK_Anketa_Dolzhnost` FOREIGN KEY (`id_dolzhnost`) REFERENCES `Dolzhnost` (`id`),
  CONSTRAINT `FK_Anketa_Organization` FOREIGN KEY (`id_organize`) REFERENCES `Organization` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы projects.Anketa: ~2 rows (приблизительно)
DELETE FROM `Anketa`;
INSERT INTO `Anketa` (`id`, `phamiliya`, `name`, `otchestvo`, `id_organize`, `login`, `password`, `year_begin`, `logo`, `nick`, `id_dolzhnost`, `role`) VALUES
	(69, 'Васильев', 'Дмитрий', '', 11, 'vasya1980@mail.ru', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', NULL, NULL, NULL, NULL, b'01'),
	(70, 'Алексеев', 'Петр', '', NULL, 'petro@mail.ru', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', NULL, NULL, NULL, 2, b'10');

-- Дамп структуры для таблица projects.Anketa_Contact
CREATE TABLE IF NOT EXISTS `Anketa_Contact` (
  `id_anketa` int(11) NOT NULL,
  `id_contact` int(11) NOT NULL,
  `znach_contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_anketa`,`id_contact`),
  KEY `FK_Anketa_Contact_Type_contact` (`id_contact`),
  CONSTRAINT `FK_Anketa_Contact_Anketa` FOREIGN KEY (`id_anketa`) REFERENCES `Anketa` (`id`),
  CONSTRAINT `FK_Anketa_Contact_Type_contact` FOREIGN KEY (`id_contact`) REFERENCES `Type_contact` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы projects.Anketa_Contact: ~0 rows (приблизительно)
DELETE FROM `Anketa_Contact`;

-- Дамп структуры для таблица projects.Document
CREATE TABLE IF NOT EXISTS `Document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url_document` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `id_anketa` int(11) NOT NULL DEFAULT '0',
  `id_project` int(11) DEFAULT '0',
  `id_message` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__Anketa` (`id_anketa`),
  KEY `FK__Project` (`id_project`),
  KEY `FK_Document_Message` (`id_message`),
  CONSTRAINT `FK_Document_Message` FOREIGN KEY (`id_message`) REFERENCES `message` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK__Anketa` FOREIGN KEY (`id_anketa`) REFERENCES `Anketa` (`id`),
  CONSTRAINT `FK__Project` FOREIGN KEY (`id_project`) REFERENCES `Project` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы projects.Document: ~14 rows (приблизительно)
DELETE FROM `Document`;
INSERT INTO `Document` (`id`, `url_document`, `name`, `id_anketa`, `id_project`, `id_message`) VALUES
	(5, 'doc/13_47_38.2590a1a6759841581e6e1ed7fc91376d.jpg', '2590a1a6759841581e6e1ed7fc91376d.jpg', 69, NULL, 142),
	(6, 'doc/13_54_52.2590a1a6759841581e6e1ed7fc91376d.jpg', '2590a1a6759841581e6e1ed7fc91376d.jpg', 69, NULL, 143),
	(7, 'doc/14_24_33.Документ Microsoft Word.docx', 'Документ Microsoft Word.docx', 69, NULL, 144),
	(8, 'doc/14_50_46.2590a1a6759841581e6e1ed7fc91376d.jpg', '2590a1a6759841581e6e1ed7fc91376d.jpg', 69, NULL, 168),
	(9, 'doc/15_21_03.2590a1a6759841581e6e1ed7fc91376d.jpg', '2590a1a6759841581e6e1ed7fc91376d.jpg', 69, NULL, 197),
	(10, 'doc/15_21_03.2590a1a6759841581e6e1ed7fc91376d.jpg', '2590a1a6759841581e6e1ed7fc91376d.jpg', 69, NULL, 198),
	(11, 'doc/15_21_03.2590a1a6759841581e6e1ed7fc91376d.jpg', '2590a1a6759841581e6e1ed7fc91376d.jpg', 69, NULL, 199),
	(12, 'doc/15_26_24.2590a1a6759841581e6e1ed7fc91376d.jpg', '2590a1a6759841581e6e1ed7fc91376d.jpg', 69, NULL, 208),
	(13, 'doc/15_26_24.2590a1a6759841581e6e1ed7fc91376d.jpg', '2590a1a6759841581e6e1ed7fc91376d.jpg', 69, NULL, 209),
	(14, 'doc/15_26_33.2590a1a6759841581e6e1ed7fc91376d.jpg', '2590a1a6759841581e6e1ed7fc91376d.jpg', 69, NULL, 210),
	(15, 'doc/15_47_06.2590a1a6759841581e6e1ed7fc91376d.jpg', '2590a1a6759841581e6e1ed7fc91376d.jpg', 69, NULL, 216),
	(16, 'doc/15_48_19.2590a1a6759841581e6e1ed7fc91376d.jpg', '2590a1a6759841581e6e1ed7fc91376d.jpg', 69, NULL, 217),
	(17, 'doc/15_48_19.2590a1a6759841581e6e1ed7fc91376d.jpg', '2590a1a6759841581e6e1ed7fc91376d.jpg', 69, NULL, 218),
	(18, 'doc/16_07_30.Документ Microsoft Word.docx', 'Документ Microsoft Word.docx', 69, NULL, 233);

-- Дамп структуры для таблица projects.Dolzhnost
CREATE TABLE IF NOT EXISTS `Dolzhnost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dolzhnost` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Должность';

-- Дамп данных таблицы projects.Dolzhnost: ~0 rows (приблизительно)
DELETE FROM `Dolzhnost`;
INSERT INTO `Dolzhnost` (`id`, `dolzhnost`) VALUES
	(2, 'Доцент');

-- Дамп структуры для таблица projects.Kompetenciya
CREATE TABLE IF NOT EXISTS `Kompetenciya` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы projects.Kompetenciya: ~19 rows (приблизительно)
DELETE FROM `Kompetenciya`;
INSERT INTO `Kompetenciya` (`id`, `name`) VALUES
	(1, 'C#, JavaScript'),
	(2, 'Python'),
	(3, 'Java'),
	(4, 'C++'),
	(5, 'JavaScript'),
	(12, 'Инженерия'),
	(13, 'программирование'),
	(14, 'автоматизация'),
	(15, 'Медицина'),
	(16, 'информационные технологии'),
	(17, 'Python'),
	(18, 'Java'),
	(19, 'C#'),
	(20, 'SQL'),
	(21, 'UX/UI дизайн'),
	(22, 'Статистический анализ данных'),
	(23, 'Kotlin/Java (для Android)'),
	(24, 'Swift/Objective-C (для iOS)'),
	(25, 'Базы данных'),
	(26, 'UX/UI дизайн');

-- Дамп структуры для таблица projects.Kompetenciya_project
CREATE TABLE IF NOT EXISTS `Kompetenciya_project` (
  `id_kompenetciya` int(11) NOT NULL,
  `id_project` int(11) NOT NULL,
  PRIMARY KEY (`id_kompenetciya`,`id_project`),
  KEY `FK_Kompetenciya_project_Project` (`id_project`),
  CONSTRAINT `FK_Kompetenciya_project_Kompetenciya` FOREIGN KEY (`id_kompenetciya`) REFERENCES `Kompetenciya` (`id`),
  CONSTRAINT `FK_Kompetenciya_project_Project` FOREIGN KEY (`id_project`) REFERENCES `Project` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы projects.Kompetenciya_project: ~18 rows (приблизительно)
DELETE FROM `Kompetenciya_project`;
INSERT INTO `Kompetenciya_project` (`id_kompenetciya`, `id_project`) VALUES
	(2, 2),
	(3, 2),
	(4, 2),
	(5, 2),
	(12, 5),
	(13, 5),
	(14, 5),
	(15, 6),
	(16, 6),
	(17, 7),
	(18, 7),
	(19, 7),
	(20, 7),
	(21, 7),
	(22, 7),
	(23, 8),
	(24, 8),
	(25, 8),
	(26, 8);

-- Дамп структуры для таблица projects.Message
CREATE TABLE IF NOT EXISTS `Message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `id_anketa` int(11) NOT NULL,
  `id_project` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__Anketa2` (`id_anketa`),
  KEY `FK_Message_Project` (`id_project`),
  CONSTRAINT `FK_Message_Project` FOREIGN KEY (`id_project`) REFERENCES `Project` (`id`),
  CONSTRAINT `FK__Anketa2` FOREIGN KEY (`id_anketa`) REFERENCES `Anketa` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=256 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы projects.Message: ~236 rows (приблизительно)
DELETE FROM `Message`;
INSERT INTO `Message` (`id`, `text`, `date`, `id_anketa`, `id_project`) VALUES
	(7, 'sawdsacfdsvs wdas wsafd wdads ', '2023-07-05 15:11:38', 69, NULL),
	(8, 'fgyjjnm', '2023-07-31 15:15:27', 69, NULL),
	(9, 'qwe', '2023-08-03 15:23:30', 69, NULL),
	(10, 'qwe', '2023-08-03 15:24:46', 69, NULL),
	(11, '123', '2023-08-03 15:28:56', 69, NULL),
	(12, 'тоартылаоыю', '2023-08-03 15:30:54', 69, NULL),
	(13, 'рпропирол', '2023-08-03 15:31:02', 69, NULL),
	(14, '76678757', '2023-08-03 15:31:18', 69, NULL),
	(15, '....................', '2023-08-03 15:31:40', 70, NULL),
	(16, 'ттттттттттттттттттттттттт', '2023-08-03 15:31:56', 69, NULL),
	(17, 'яяяяяяяяя', '2023-08-03 15:32:14', 69, NULL),
	(18, 'Привет', '2023-08-03 15:33:51', 69, NULL),
	(19, 'добрый день', '2023-08-03 15:34:07', 70, NULL),
	(20, '123', '2023-08-03 15:36:00', 69, NULL),
	(21, 'xfd', '2023-08-03 15:36:09', 70, NULL),
	(22, '65454', '2023-08-03 15:40:14', 69, NULL),
	(23, 'dew', '2023-08-03 16:53:15', 70, NULL),
	(24, '234', '2023-08-03 16:53:34', 70, NULL),
	(25, 'sac', '2023-08-03 16:53:58', 70, NULL),
	(26, 'dgh', '2023-08-03 16:55:05', 69, NULL),
	(27, '', '2023-08-03 16:55:22', 70, NULL),
	(28, '', '2023-08-03 16:55:28', 70, NULL),
	(29, 'fedrf', '2023-08-03 16:56:59', 70, NULL),
	(30, '123', '2023-08-03 16:57:05', 69, NULL),
	(31, 'drrftfgt', '2023-08-03 16:59:30', 69, NULL),
	(32, '123', '2023-08-03 17:04:40', 69, NULL),
	(33, 'sdfd', '2023-08-03 17:04:47', 70, NULL),
	(34, '123', '2023-08-03 17:06:08', 69, NULL),
	(35, 'dxfr', '2023-08-03 17:07:42', 70, NULL),
	(36, 'cg', '2023-08-03 17:08:01', 70, NULL),
	(37, 'dsrxdf', '2023-08-03 17:08:31', 69, NULL),
	(38, '234', '2023-08-03 17:08:59', 69, NULL),
	(39, 'dfc', '2023-08-03 17:09:33', 69, NULL),
	(40, '123', '2023-08-03 17:11:47', 70, NULL),
	(41, 'sexdf', '2023-08-03 17:12:54', 70, NULL),
	(42, 'xx', '2023-08-03 17:13:15', 69, NULL),
	(43, 'zzz', '2023-08-03 17:13:38', 69, NULL),
	(44, '', '2023-08-03 17:13:50', 70, NULL),
	(45, 'dxfg', '2023-08-03 17:17:14', 69, NULL),
	(46, 'xdf', '2023-08-03 17:17:24', 69, NULL),
	(47, 'wdef', '2023-08-03 17:18:04', 69, NULL),
	(48, 'cfds', '2023-08-03 17:18:33', 69, NULL),
	(49, 'fygth', '2023-08-03 17:19:57', 69, NULL),
	(50, '3456', '2023-08-03 17:20:11', 69, NULL),
	(51, 'vgvhj', '2023-08-03 17:20:27', 69, NULL),
	(52, 'dfgh', '2023-08-03 17:20:35', 69, NULL),
	(53, 'cfgvhbj', '2023-08-03 17:20:52', 69, NULL),
	(54, 'svfgdf', '2023-08-03 17:21:51', 69, NULL),
	(55, 'dsfde', '2023-08-03 17:22:00', 69, NULL),
	(56, 'hhj', '2023-08-03 17:22:36', 69, NULL),
	(57, 'ds', '2023-08-03 17:22:50', 69, NULL),
	(58, 'dfcgh', '2023-08-03 17:24:23', 69, NULL),
	(59, 'fswef', '2023-08-03 17:25:28', 69, NULL),
	(60, 'fgh', '2023-08-03 17:27:29', 70, NULL),
	(61, 'cfds', '2023-08-03 17:27:52', 69, NULL),
	(62, 'scd', '2023-08-03 17:28:03', 69, NULL),
	(63, 'dsacfde', '2023-08-03 17:28:25', 69, NULL),
	(64, 'scfds', '2023-08-03 17:28:41', 69, NULL),
	(65, 'vfer', '2023-08-03 17:29:20', 69, NULL),
	(66, 'dscf', '2023-08-03 17:29:25', 69, NULL),
	(67, 'dsvgfd', '2023-08-03 17:29:35', 69, NULL),
	(68, 'dsvd', '2023-08-03 17:30:54', 69, NULL),
	(69, '123', '2023-08-03 17:31:07', 69, NULL),
	(70, 'w3erew3', '2023-08-03 17:31:15', 69, NULL),
	(71, 'wfrdegf', '2023-08-03 17:31:32', 69, NULL),
	(72, 'dfvfbgf', '2023-08-03 17:31:41', 69, NULL),
	(73, 'dfgh', '2023-08-03 17:34:19', 69, NULL),
	(74, 'fgvhbj', '2023-08-03 17:34:29', 69, NULL),
	(75, 'fghj', '2023-08-03 17:36:05', 69, NULL),
	(76, 'dfcgh', '2023-08-03 17:36:45', 69, NULL),
	(77, '123', '2023-08-08 13:09:02', 70, NULL),
	(78, 'qwe', '2023-08-08 13:09:21', 69, NULL),
	(79, 'zxc', '2023-08-08 13:09:33', 70, NULL),
	(80, 'safds', '2023-08-08 13:10:00', 69, NULL),
	(81, 'zxc', '2023-08-08 13:14:09', 69, NULL),
	(82, 'cvvb', '2023-08-08 13:14:49', 69, NULL),
	(83, 'jnjbh', '2023-08-08 13:15:52', 69, NULL),
	(84, 'hbn', '2023-08-08 13:16:00', 69, NULL),
	(85, ' mbhjbh', '2023-08-08 13:16:07', 69, NULL),
	(86, 'gdfrhgtf', '2023-08-08 13:16:48', 69, NULL),
	(87, 'cvghbj', '2023-08-08 13:17:37', 69, NULL),
	(88, 'gfhv', '2023-08-08 13:17:48', 69, NULL),
	(89, 'dfsvfs', '2023-08-08 13:19:46', 69, NULL),
	(90, 'ccd', '2023-08-08 13:19:50', 69, NULL),
	(91, 'fgc', '2023-08-08 13:20:01', 69, NULL),
	(92, 'xvbn', '2023-08-08 13:20:22', 69, NULL),
	(93, 'cvbnm', '2023-08-08 13:20:37', 69, NULL),
	(94, 'cvbn', '2023-08-08 13:21:45', 69, NULL),
	(95, 'fccgvhbj', '2023-08-08 13:21:50', 69, NULL),
	(96, 'xcvbn', '2023-08-08 13:26:22', 69, NULL),
	(97, 'fedsf', '2023-08-08 13:37:39', 69, NULL),
	(98, 'gdfrg', '2023-08-08 13:38:07', 70, NULL),
	(99, 'fgrde', '2023-08-08 13:38:31', 70, NULL),
	(100, 'gdrfg', '2023-08-08 13:40:16', 70, NULL),
	(101, 'cvds', '2023-08-08 13:40:25', 69, NULL),
	(102, 'fdg', '2023-08-08 13:40:37', 70, NULL),
	(103, 'fdsr', '2023-08-08 13:40:50', 69, NULL),
	(104, 'sdfg', '2023-08-08 15:33:38', 69, NULL),
	(105, 'gh', '2023-08-08 15:33:46', 69, NULL),
	(106, 'dfghj', '2023-08-08 16:04:59', 69, NULL),
	(107, 'sftsr', '2023-08-08 16:05:13', 69, NULL),
	(108, '', '2023-08-08 16:48:23', 69, NULL),
	(109, '', '2023-08-08 16:49:34', 69, NULL),
	(110, '', '2023-08-08 17:04:19', 69, NULL),
	(111, '', '2023-08-08 17:19:52', 69, NULL),
	(112, '', '2023-08-08 17:32:44', 69, NULL),
	(113, '', '2023-08-08 17:33:34', 69, NULL),
	(114, '', '2023-08-08 17:36:51', 69, NULL),
	(115, '', '2023-08-08 17:37:12', 69, NULL),
	(116, '', '2023-08-08 17:37:12', 69, NULL),
	(117, '', '2023-08-08 17:37:12', 69, NULL),
	(118, '', '2023-08-08 17:37:13', 69, NULL),
	(119, '', '2023-08-08 17:37:13', 69, NULL),
	(120, '', '2023-08-08 17:37:13', 69, NULL),
	(121, '', '2023-08-08 17:37:13', 69, NULL),
	(122, '', '2023-08-08 17:37:13', 69, NULL),
	(123, '', '2023-08-08 17:39:02', 69, NULL),
	(124, '', '2023-08-08 17:39:55', 69, NULL),
	(125, '', '2023-08-08 17:42:42', 69, NULL),
	(126, '123', '2023-08-18 14:24:29', 69, NULL),
	(127, '', '2023-08-18 14:25:32', 69, NULL),
	(128, '', '2023-08-18 14:26:50', 69, NULL),
	(129, '000', '2023-08-18 15:07:30', 70, NULL),
	(130, '', '2023-08-18 15:07:50', 70, NULL),
	(131, '', '2023-08-18 15:18:00', 70, NULL),
	(132, '', '2023-08-18 15:18:57', 70, NULL),
	(133, '', '2023-08-18 15:22:22', 70, NULL),
	(134, '', '2023-08-18 15:22:42', 70, NULL),
	(135, '', '2023-08-18 15:25:29', 70, NULL),
	(136, '', '2023-08-18 15:28:00', 70, NULL),
	(137, 'фыфыф', '2023-08-18 15:29:18', 70, NULL),
	(138, '', '2023-08-18 15:42:08', 70, NULL),
	(139, '', '2023-08-18 15:54:38', 70, NULL),
	(140, '', '2023-08-18 15:56:25', 70, NULL),
	(141, '', '2023-08-24 13:47:42', 69, NULL),
	(142, '', '2023-08-24 13:51:21', 69, NULL),
	(143, '', '2023-08-24 13:54:54', 69, NULL),
	(144, '', '2023-08-24 14:24:35', 69, NULL),
	(145, 'ыф', '2023-08-24 14:37:05', 69, NULL),
	(146, '111', '2023-08-24 14:39:21', 69, NULL),
	(147, 'в', '2023-08-24 14:40:12', 69, NULL),
	(148, 'м', '2023-08-24 14:40:30', 69, NULL),
	(149, 'ввв', '2023-08-24 14:40:39', 69, NULL),
	(150, 'сссссссссссссссссссс', '2023-08-24 14:41:17', 69, NULL),
	(151, 'йййййййййййййййййййййй', '2023-08-24 14:41:49', 69, NULL),
	(152, 'эээээээ', '2023-08-24 14:41:57', 69, NULL),
	(153, 'яяяяяяяяяяяяяяяяяя', '2023-08-24 14:42:07', 69, NULL),
	(154, 'ы', '2023-08-24 14:42:20', 69, NULL),
	(155, 'й', '2023-08-24 14:42:25', 69, NULL),
	(156, 'я', '2023-08-24 14:42:30', 69, NULL),
	(157, 'ы', '2023-08-24 14:42:51', 69, NULL),
	(158, '1', '2023-08-24 14:43:26', 69, NULL),
	(159, '2', '2023-08-24 14:43:29', 69, NULL),
	(160, '3', '2023-08-24 14:43:32', 69, NULL),
	(161, 'эээээээээээээээ', '2023-08-24 14:43:36', 69, NULL),
	(162, '2', '2023-08-24 14:44:06', 69, NULL),
	(163, '11111111111', '2023-08-24 14:44:11', 69, NULL),
	(164, 'fff', '2023-08-24 14:50:22', 69, NULL),
	(165, 'w', '2023-08-24 14:50:35', 69, NULL),
	(166, 'q', '2023-08-24 14:50:37', 69, NULL),
	(167, 'e', '2023-08-24 14:50:39', 69, NULL),
	(168, '', '2023-08-24 14:50:47', 69, NULL),
	(169, 'ь', '2023-08-24 15:01:02', 69, NULL),
	(170, 'б', '2023-08-24 15:02:21', 69, NULL),
	(171, 'ы', '2023-08-24 15:03:46', 69, NULL),
	(172, 'й', '2023-08-24 15:03:48', 69, NULL),
	(173, 'й', '2023-08-24 15:03:51', 69, NULL),
	(174, 'яяяяяяяяяяяяяя', '2023-08-24 15:03:57', 69, NULL),
	(175, 'ййй', '2023-08-24 15:04:35', 69, NULL),
	(176, 's', '2023-08-24 15:09:44', 69, NULL),
	(177, 'q', '2023-08-24 15:09:46', 69, NULL),
	(178, 'fffffffffff', '2023-08-24 15:09:50', 69, NULL),
	(179, 'ыыыыыыыыыыыыыыы', '2023-08-24 15:10:52', 69, NULL),
	(180, 'й', '2023-08-24 15:12:31', 69, NULL),
	(181, '', '2023-08-24 15:12:39', 69, NULL),
	(182, 'й', '2023-08-24 15:12:52', 69, NULL),
	(183, 'ыыыыыыыыыыыыыыыыыыыыыыыыыыы', '2023-08-24 15:12:57', 69, NULL),
	(184, '2', '2023-08-24 15:14:48', 69, NULL),
	(185, '1111111', '2023-08-24 15:15:06', 69, NULL),
	(186, '11111', '2023-08-24 15:15:09', 69, NULL),
	(187, '111111111111', '2023-08-24 15:15:10', 69, NULL),
	(188, 'цй', '2023-08-24 15:15:12', 69, NULL),
	(189, '11111111111111111111', '2023-08-24 15:15:58', 69, NULL),
	(190, 'qqqqqqqqqqqqqqqqqqqqqq', '2023-08-24 15:17:08', 69, NULL),
	(191, 'qqqqqqqqqqqqqqq', '2023-08-24 15:17:12', 69, NULL),
	(192, 'qqqqqqqqqqqqqq', '2023-08-24 15:18:08', 69, NULL),
	(193, 'фффф', '2023-08-24 15:20:17', 69, NULL),
	(194, '', '2023-08-24 15:20:27', 69, NULL),
	(195, 'ы', '2023-08-24 15:20:38', 69, NULL),
	(196, 's', '2023-08-24 15:20:54', 69, NULL),
	(197, '', '2023-08-24 15:21:04', 69, NULL),
	(198, '', '2023-08-24 15:21:18', 69, NULL),
	(199, 'sadad', '2023-08-24 15:21:28', 69, NULL),
	(200, 'dada', '2023-08-24 15:21:32', 69, NULL),
	(201, 'adsas', '2023-08-24 15:21:37', 69, NULL),
	(202, '', '2023-08-24 15:21:55', 69, NULL),
	(203, 'dada', '2023-08-24 15:24:24', 69, NULL),
	(204, '', '2023-08-24 15:24:28', 69, NULL),
	(205, '', '2023-08-24 15:25:31', 69, NULL),
	(206, '', '2023-08-24 15:26:09', 69, NULL),
	(207, 'sasa', '2023-08-24 15:26:13', 69, NULL),
	(208, '', '2023-08-24 15:26:25', 69, NULL),
	(209, '', '2023-08-24 15:26:28', 69, NULL),
	(210, '', '2023-08-24 15:26:35', 69, NULL),
	(211, '', '2023-08-24 15:26:49', 69, NULL),
	(212, '', '2023-08-24 15:26:52', 69, NULL),
	(213, '', '2023-08-24 15:27:04', 69, NULL),
	(214, '', '2023-08-24 15:37:29', 69, NULL),
	(215, 'sasa', '2023-08-24 15:46:49', 69, NULL),
	(216, '', '2023-08-24 15:47:06', 69, NULL),
	(217, 'dadad', '2023-08-24 15:48:20', 69, NULL),
	(218, '', '2023-08-24 15:48:21', 69, NULL),
	(219, '', '2023-08-24 15:48:55', 69, NULL),
	(220, '', '2023-08-24 15:48:57', 69, NULL),
	(221, 'sasa', '2023-08-24 15:49:04', 69, NULL),
	(222, 'sas', '2023-08-24 15:49:54', 69, NULL),
	(223, '123', '2023-08-24 15:49:59', 69, NULL),
	(224, 'ssasa', '2023-08-24 15:50:10', 69, NULL),
	(225, 'sasa', '2023-08-24 15:50:36', 69, NULL),
	(226, '1', '2023-08-24 15:51:00', 69, NULL),
	(227, '2', '2023-08-24 15:51:03', 69, NULL),
	(228, 'sssssssssssssssssss', '2023-08-24 15:52:15', 69, NULL),
	(229, 'zzzzzzzzzzzzzzzzzzzzzzz', '2023-08-24 15:52:18', 69, NULL),
	(230, 'xxxxxxxxxxxxxxxxxxxxxx', '2023-08-24 15:52:21', 69, NULL),
	(231, 'vvvvvvv', '2023-08-24 15:52:23', 69, NULL),
	(232, 'aaaaaaaaaaaaaaaa', '2023-08-24 16:07:03', 69, NULL),
	(233, '', '2023-08-24 16:07:31', 69, NULL),
	(234, 'dsdsdsd', '2023-08-24 16:09:01', 69, NULL),
	(235, 'csccs', '2023-08-24 16:10:34', 69, NULL),
	(236, '', '2023-08-24 16:10:57', 69, NULL),
	(237, 'dadad', '2023-08-24 16:11:01', 69, NULL),
	(238, 'adada', '2023-08-24 16:11:09', 69, NULL),
	(239, 'dada', '2023-08-24 16:12:46', 69, NULL),
	(240, 'dadada', '2023-08-24 16:13:29', 69, NULL),
	(241, 'dsfd', '2023-08-24 16:14:13', 69, NULL),
	(242, 'ret', '2023-08-24 16:14:53', 69, NULL),
	(243, 'grtdty', '2023-08-24 16:15:09', 69, NULL),
	(244, 'rdeg', '2023-08-24 16:16:07', 69, NULL),
	(245, 'gfdgft', '2023-08-24 16:17:05', 69, NULL),
	(246, 'dgfrghtf', '2023-08-24 16:17:31', 69, NULL),
	(247, 'dfgh', '2023-08-24 16:20:38', 69, NULL),
	(248, 'dfgvbgf', '2023-08-24 16:20:48', 69, NULL),
	(249, '243243', '2023-08-24 16:21:27', 69, NULL),
	(250, '546', '2023-08-24 16:23:21', 69, NULL),
	(251, 'erdgr', '2023-08-24 16:23:33', 69, NULL),
	(252, 'gtrfhyt', '2023-08-24 16:23:53', 69, NULL),
	(253, 'gfdft', '2023-08-24 16:24:30', 69, NULL),
	(254, 'yug', '2023-08-24 16:35:38', 69, NULL),
	(255, 'rgt', '2023-08-24 16:35:52', 69, NULL);

-- Дамп структуры для таблица projects.Organization
CREATE TABLE IF NOT EXISTS `Organization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы projects.Organization: ~0 rows (приблизительно)
DELETE FROM `Organization`;
INSERT INTO `Organization` (`id`, `name`) VALUES
	(11, 'ООО "ЛУКОЙЛ-КОМИ"'),
	(12, 'ПАО «Газпром»'),
	(13, 'ПАО "Газпром"');

-- Дамп структуры для таблица projects.Project
CREATE TABLE IF NOT EXISTS `Project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zadacha` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_slozhnost` int(11) DEFAULT NULL,
  `kol-vo_ispol` int(11) NOT NULL,
  `data_prin` date DEFAULT NULL,
  `data_plan_sdach` date NOT NULL,
  `fact_data_sdach` date DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__Slozhnost` (`id_slozhnost`),
  CONSTRAINT `FK_Project_Slozhnost` FOREIGN KEY (`id_slozhnost`) REFERENCES `Slozhnost` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы projects.Project: ~5 rows (приблизительно)
DELETE FROM `Project`;
INSERT INTO `Project` (`id`, `name`, `zadacha`, `id_slozhnost`, `kol-vo_ispol`, `data_prin`, `data_plan_sdach`, `fact_data_sdach`, `logo`) VALUES
	(2, 'Виртуальный помощник', 'Создание программного инструмента, способного автоматизировать рутинные задачи и облегчить жизнь пользователю', 2, 5, NULL, '2023-12-01', NULL, 'http://realproject/photo/project/18_17_24.%D0%92%D0%B8%D1%80%D1%82%D1%83%D0%B0%D0%BB%D1%8C%D0%BD%D1%8B%D0%B9%20%D0%BF%D0%BE%D0%BC%D0%BE%D1%89%D0%BD%D0%B8%D0%BA.webp'),
	(5, 'Иноватикс', 'Разработка инновационной технологии для автоматизации процессов в производственных предприятиях', 2, 8, NULL, '2023-12-01', NULL, 'https://vuzopedia.ru/storage/app/uploads/public/636/41c/bdd/63641cbdde8cc148204354.jpg'),
	(6, 'Smart Health', ' Разработка и внедрение инновационного медицинского решения для улучшения качества и доступности здравоохранения', 2, 6, NULL, '2023-12-06', NULL, 'https://svg-clipart.com/clipart/logo/1eQR0Ue-pharmacy-symbol-clipart.jpg'),
	(7, 'Учет финансов', 'Создание приложения, позволяющего пользователям вести учет доходов и расходов, создавать бюджеты, анализировать данные и получать отчеты о финансовом состоянии', 2, 4, NULL, '2024-01-30', NULL, 'https://applives.ru/wp-content/uploads/2016/12/Fentury-uchet-finansov-android.jpg'),
	(8, 'Фитнес-тренировки', 'Создание мобильного приложения, предоставляющего пользователю доступ к тренировочным программам, видеоурокам, трекеру прогресса, питания и сообществу.', 2, 4, NULL, '2024-02-20', NULL, 'https://dadaviz.ru/wp-content/uploads/2018/05/post_5afe91901f8b2.jpeg');

-- Дамп структуры для таблица projects.Project_Anketa
CREATE TABLE IF NOT EXISTS `Project_Anketa` (
  `id_project` int(11) NOT NULL,
  `id_anketa` int(11) NOT NULL,
  `role` bit(2) DEFAULT NULL COMMENT '1 - заказчик проекта, 2 - наставник, 3 - исполнитель',
  PRIMARY KEY (`id_project`,`id_anketa`),
  KEY `FK__Anketa3` (`id_anketa`),
  CONSTRAINT `FK__Anketa3` FOREIGN KEY (`id_anketa`) REFERENCES `Anketa` (`id`),
  CONSTRAINT `FK__Project2` FOREIGN KEY (`id_project`) REFERENCES `Project` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы projects.Project_Anketa: ~5 rows (приблизительно)
DELETE FROM `Project_Anketa`;
INSERT INTO `Project_Anketa` (`id_project`, `id_anketa`, `role`) VALUES
	(2, 69, b'01'),
	(5, 69, b'01'),
	(6, 69, b'01'),
	(7, 69, b'01'),
	(8, 69, b'01');

-- Дамп структуры для таблица projects.Slozhnost
CREATE TABLE IF NOT EXISTS `Slozhnost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы projects.Slozhnost: ~3 rows (приблизительно)
DELETE FROM `Slozhnost`;
INSERT INTO `Slozhnost` (`id`, `name`) VALUES
	(1, 'Низкая'),
	(2, 'Средняя'),
	(3, 'Высокая');

-- Дамп структуры для таблица projects.Type_contact
CREATE TABLE IF NOT EXISTS `Type_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы projects.Type_contact: ~2 rows (приблизительно)
DELETE FROM `Type_contact`;
INSERT INTO `Type_contact` (`id`, `name`) VALUES
	(1, 'Телефон'),
	(2, 'email');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
