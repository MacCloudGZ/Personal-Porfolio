-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2025 at 08:14 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maccloud`
--
CREATE DATABASE IF NOT EXISTS `maccloud` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `maccloud`;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `username`, `password_hash`) VALUES
(1, 'admin', 'MacCloud');

-- --------------------------------------------------------

--
-- Table structure for table `accounts_bind`
--

DROP TABLE IF EXISTS `accounts_bind`;
CREATE TABLE IF NOT EXISTS `accounts_bind` (
  `account_bind_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_link` varchar(512) NOT NULL,
  `verify_code` varchar(32) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`account_bind_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts_bind`
--

INSERT INTO `accounts_bind` (`account_bind_id`, `account_link`, `verify_code`, `is_verified`) VALUES
(1, 'https://github.com/MacCloudGZ', '591314', 1);

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) DEFAULT NULL,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `country` varchar(100) NOT NULL,
  `show_Address` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`address_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address_id`, `id`, `address_line1`, `address_line2`, `city`, `state`, `zip_code`, `country`, `show_Address`) VALUES
(2, 1, 'Santa Lucia', 'Zone 5', 'Nabua', 'Camarines Sur', '4434', 'Philippines', 1);

-- --------------------------------------------------------

--
-- Table structure for table `add_project_manual`
--

DROP TABLE IF EXISTS `add_project_manual`;
CREATE TABLE IF NOT EXISTS `add_project_manual` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date_creation` date NOT NULL,
  `isvisible` enum('public','private','partially') DEFAULT 'public',
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_project_manual`
--

INSERT INTO `add_project_manual` (`project_id`, `project_name`, `description`, `date_creation`, `isvisible`) VALUES
(1, 'Tumbang-Preso', 'A game of Tomrbang Preso using unity games', '2025-11-28', 'private'),
(2, 'Project:LaURAh', 'Laurah is a private passion project made for maintaining and pushing the locally run helper', '2019-06-06', 'private');

-- --------------------------------------------------------

--
-- Table structure for table `config_update`
--

DROP TABLE IF EXISTS `config_update`;
CREATE TABLE IF NOT EXISTS `config_update` (
  `update_time` time NOT NULL,
  `schedule` enum('day','week','month') DEFAULT 'day'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `config_update`
--

INSERT INTO `config_update` (`update_time`, `schedule`) VALUES
('03:00:00', 'day');

-- --------------------------------------------------------

--
-- Table structure for table `contact_info`
--

DROP TABLE IF EXISTS `contact_info`;
CREATE TABLE IF NOT EXISTS `contact_info` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) DEFAULT NULL,
  `contact_type` varchar(50) NOT NULL,
  `contact_value` varchar(255) NOT NULL,
  PRIMARY KEY (`contact_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_info`
--

INSERT INTO `contact_info` (`contact_id`, `id`, `contact_type`, `contact_value`) VALUES
(1, 1, 'Email', 'kuzabala@my.cspc.edu.ph'),
(2, 1, 'Phone', '+63 9774 751 322'),
(3, 1, 'Gmail', 'kuzabala@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `educational_background`
--

DROP TABLE IF EXISTS `educational_background`;
CREATE TABLE IF NOT EXISTS `educational_background` (
  `education_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) DEFAULT NULL,
  `institution_name` varchar(255) NOT NULL,
  `degree` varchar(100) DEFAULT NULL,
  `field_of_study` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`education_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `educational_background`
--

INSERT INTO `educational_background` (`education_id`, `id`, `institution_name`, `degree`, `field_of_study`, `start_date`, `end_date`) VALUES
(1, 1, 'University of Saint Anthony', '', 'Junior High School', '2017-06-05', '2021-04-09'),
(3, 1, 'University of Saint Anthony', '', 'Elementary Graduate', '2013-06-03', '2017-04-07'),
(4, 1, 'Nabua National High School', '', 'Senior High School', '2021-07-05', '2023-06-23'),
(5, 1, 'Camarines Sur Polytechnic Colleges', 'Bachelor of Science in Information Technology', 'College of Computer Study', '2023-09-04', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `file_manager`
--

DROP TABLE IF EXISTS `file_manager`;
CREATE TABLE IF NOT EXISTS `file_manager` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `current_use` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`file_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `file_manager`
--

INSERT INTO `file_manager` (`file_id`, `id`, `file_name`, `file_path`, `current_use`) VALUES
(1, 1, 'Resume.pdf', 'Properties/files/Resume.pdf', 0),
(2, 1, 'ModuleA_network_layout.pdf', 'Properties/files/ModuleA_network_layout.pdf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fun_personal_touch`
--

DROP TABLE IF EXISTS `fun_personal_touch`;
CREATE TABLE IF NOT EXISTS `fun_personal_touch` (
  `touch_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`touch_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fun_personal_touch`
--

INSERT INTO `fun_personal_touch` (`touch_id`, `id`, `description`) VALUES
(1, 1, 'I never commit a unfinish code'),
(2, 1, 'gonna love networking cuz i need to '),
(3, 1, 'give me coffee and i print 50% project finished XD'),
(4, 1, 'you, me team up yehey'),
(5, 1, 'up, up, down, down, left, right, left, right. a. b');

-- --------------------------------------------------------

--
-- Table structure for table `job_status`
--

DROP TABLE IF EXISTS `job_status`;
CREATE TABLE IF NOT EXISTS `job_status` (
  `status_id` int(11) NOT NULL,
  `status_label` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_status`
--

INSERT INTO `job_status` (`status_id`, `status_label`) VALUES
(1, 'Employed'),
(2, 'Free-Lance'),
(3, 'Unemployed'),
(4, 'Retired');

-- --------------------------------------------------------

--
-- Table structure for table `main_images`
--

DROP TABLE IF EXISTS `main_images`;
CREATE TABLE IF NOT EXISTS `main_images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `current_user` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`image_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `main_images`
--

INSERT INTO `main_images` (`image_id`, `id`, `image_path`, `current_user`) VALUES
(1, 1, 'Properties/Images/Default_Profile.webp', 0),
(2, 1, 'Properties/Images/image-error404.webp', 0),
(4, 1, 'Properties/Images/profile_1_20251202_121418_380c33f5.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `message_data`
--

DROP TABLE IF EXISTS `message_data`;
CREATE TABLE IF NOT EXISTS `message_data` (
  `id` int(11) DEFAULT NULL,
  `message_text` text DEFAULT NULL,
  `message_type` int(11) NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message_data`
--

INSERT INTO `message_data` (`id`, `message_text`, `message_type`) VALUES
(1, 'I like coding for fun and pushing my limits', 1),
(1, 'my motto is \'If you\'re gonna dream big, always drink coffee, cuz we don\'t dream, we work.\'', 2);

-- --------------------------------------------------------

--
-- Table structure for table `personal_data`
--

DROP TABLE IF EXISTS `personal_data`;
CREATE TABLE IF NOT EXISTS `personal_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) NOT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `sex` enum('Male','Female','Other') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personal_data`
--

INSERT INTO `personal_data` (`id`, `firstname`, `middlename`, `lastname`, `suffix`, `birthdate`, `status_id`, `sex`) VALUES
(1, 'Kurt Gabrielle', 'Bermejo', 'Zabala', NULL, '2005-05-09', 2, 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `profession`
--

DROP TABLE IF EXISTS `profession`;
CREATE TABLE IF NOT EXISTS `profession` (
  `profession_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) DEFAULT NULL,
  `job_title` varchar(100) NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_current` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`profession_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profession`
--

INSERT INTO `profession` (`profession_id`, `id`, `job_title`, `company_name`, `start_date`, `end_date`, `is_current`) VALUES
(1, 1, 'Web Developer', 'Tech Solutions', '2020-06-01', '0000-00-00', 0),
(2, 1, 'Intern', 'Web Startups', '2019-06-01', '2019-08-31', 0);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
CREATE TABLE IF NOT EXISTS `skills` (
  `skill_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) DEFAULT NULL,
  `skill_name` varchar(100) NOT NULL,
  `proficiency_level` int(11) DEFAULT NULL,
  `skills_shown` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`skill_id`),
  KEY `id` (`id`)
) ;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`skill_id`, `id`, `skill_name`, `proficiency_level`, `skills_shown`) VALUES
(1, 1, 'HTML', 10, 1),
(2, 1, 'CSS', 10, 1),
(3, 1, 'JavaScript', 10, 1),
(4, 1, 'C++', 8, 1),
(5, 1, 'Linux CLI', 3, 1),
(6, 1, 'PHP', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `table_arranger`
--

DROP TABLE IF EXISTS `table_arranger`;
CREATE TABLE IF NOT EXISTS `table_arranger` (
  `table_id` int(11) NOT NULL,
  `table_name` varchar(255) DEFAULT NULL,
  `table_possition` int(11) DEFAULT NULL,
  PRIMARY KEY (`table_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_arranger`
--

INSERT INTO `table_arranger` (`table_id`, `table_name`, `table_possition`) VALUES
(1, 'PERSONAL INFORMATION', 1),
(2, 'CONTACT INFO', 2),
(3, 'EDUCATIONAL BACKGROUND', 3),
(4, 'SKILLS', 4),
(5, 'FUN / PERSONAL TOUCH', 5),
(6, 'PROFESSION', 6);

-- --------------------------------------------------------

--
-- Table structure for table `temp_github_project`
--

DROP TABLE IF EXISTS `temp_github_project`;
CREATE TABLE IF NOT EXISTS `temp_github_project` (
  `account_bind_id` int(11) DEFAULT NULL,
  `gitproject_id` int(11) NOT NULL,
  `gitproject_name` varchar(255) NOT NULL,
  `gitdescription` text DEFAULT NULL,
  `gitdate_creation` date NOT NULL,
  `gitisvisible` enum('public','private','partially') DEFAULT 'public',
  PRIMARY KEY (`gitproject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `temp_github_project`
--

INSERT INTO `temp_github_project` (`account_bind_id`, `gitproject_id`, `gitproject_name`, `gitdescription`, `gitdate_creation`, `gitisvisible`) VALUES
(1, 752598605, 'Ice-cream-latte', 'Web-tech-project', '2024-02-04', 'public'),
(1, 757836737, 'Skill-for-all-old', NULL, '2024-02-15', 'public'),
(1, 758952123, 'skill4-all', NULL, '2024-02-17', 'public'),
(1, 767316027, 'ROAM-PH', NULL, '2024-03-05', 'public'),
(1, 848149107, 'PhoneApp-no.1', 'Phone Data', '2024-08-27', 'public'),
(1, 860722738, 'Peko-List-Manager', 'Just a list manager with bunny as a cute console gui', '2024-09-21', 'public'),
(1, 871877807, 'Java', 'Just saving my progress on JAVA', '2024-10-13', 'public'),
(1, 871879337, 'MacCloudGZ', NULL, '2024-10-13', 'public'),
(1, 872548696, 'AlertandGo', NULL, '2024-10-14', 'public'),
(1, 875526322, 'Billing', 'Project for OOp', '2024-10-20', 'public'),
(1, 903248415, 'PET--Personal-Expense-Tracker', 'Information Management Project', '2024-12-14', 'public'),
(1, 906835419, 'Library-Management-System', NULL, '2024-12-22', 'public'),
(1, 940312412, 'php_Journey', 'My Php Journey', '2025-02-28', 'public'),
(1, 951224061, 'XML', NULL, '2025-03-19', 'public'),
(1, 984848971, 'Hackno', NULL, '2025-05-16', 'public'),
(1, 1006049404, 'Chat_Laura', 'Just a thing that can motivate me on being a software dev', '2025-06-21', 'public'),
(1, 1037686373, 'appdev2025', NULL, '2025-08-14', 'public'),
(1, 1037941672, 'Personal-Porfolio', 'Personal Project as showing a my knowledge on making a dynamic portfolio', '2025-08-14', 'public'),
(1, 1045935266, 'CCIT106_Zabala', NULL, '2025-08-28', 'public'),
(1, 1056444933, 'KeyloggerDetector', 'a personal projects ', '2025-09-14', 'public'),
(1, 1081560141, 'Activity1', 'Code igniter 4 activity, on which makeing student attendance management system', '2025-10-23', 'public');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`id`) REFERENCES `personal_data` (`id`);

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`id`) REFERENCES `personal_data` (`id`);

--
-- Constraints for table `contact_info`
--
ALTER TABLE `contact_info`
  ADD CONSTRAINT `contact_info_ibfk_1` FOREIGN KEY (`id`) REFERENCES `personal_data` (`id`);

--
-- Constraints for table `educational_background`
--
ALTER TABLE `educational_background`
  ADD CONSTRAINT `educational_background_ibfk_1` FOREIGN KEY (`id`) REFERENCES `personal_data` (`id`);

--
-- Constraints for table `file_manager`
--
ALTER TABLE `file_manager`
  ADD CONSTRAINT `file_manager_ibfk_1` FOREIGN KEY (`id`) REFERENCES `personal_data` (`id`);

--
-- Constraints for table `fun_personal_touch`
--
ALTER TABLE `fun_personal_touch`
  ADD CONSTRAINT `fun_personal_touch_ibfk_1` FOREIGN KEY (`id`) REFERENCES `personal_data` (`id`);

--
-- Constraints for table `main_images`
--
ALTER TABLE `main_images`
  ADD CONSTRAINT `main_images_ibfk_1` FOREIGN KEY (`id`) REFERENCES `personal_data` (`id`);

--
-- Constraints for table `message_data`
--
ALTER TABLE `message_data`
  ADD CONSTRAINT `message_data_ibfk_1` FOREIGN KEY (`id`) REFERENCES `personal_data` (`id`);

--
-- Constraints for table `personal_data`
--
ALTER TABLE `personal_data`
  ADD CONSTRAINT `personal_data_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `job_status` (`status_id`);

--
-- Constraints for table `profession`
--
ALTER TABLE `profession`
  ADD CONSTRAINT `profession_ibfk_1` FOREIGN KEY (`id`) REFERENCES `personal_data` (`id`);

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_ibfk_1` FOREIGN KEY (`id`) REFERENCES `personal_data` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
