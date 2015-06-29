-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 10, 2015 at 07:58 PM
-- Server version: 5.5.43-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `kiosk`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `login`, `password`) VALUES
(1, 'admin', '$2y$14$1dXBAwrKn9UP6n0jERgrFuoFBcykxGv3M/BxX2v7L2JlTHD3sMJI2');



--
-- Table structure for table `announcements`
--

CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `available` set('Y','N') NOT NULL DEFAULT 'Y',
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `available` set('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `ord` int(10) NOT NULL,
  `available` set('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` varchar(32) NOT NULL,
  `ord` int(2) NOT NULL,
  `title` varchar(255) NOT NULL,
  `teaser` text NOT NULL,
  `text` text NOT NULL,
  `date_str` varchar(255) NOT NULL,
  `img_list` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE IF NOT EXISTS `schedule` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `class_num` tinyint(2) NOT NULL,
  `class_letter` char(1) NOT NULL,
  `day_of_week` int(1) NOT NULL,
  `time_slot` int(2) NOT NULL,
  `time_slot_interval` varchar(20) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `group_id` varchar(10) DEFAULT NULL,
  `teacher_name` varchar(50) DEFAULT NULL,
  `room` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `class_num` (`class_num`,`class_letter`,`day_of_week`,`time_slot`,`group_id`),
  KEY `teacher_name` (`teacher_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `schedule_changes`
--

CREATE TABLE IF NOT EXISTS `schedule_changes` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `class_num` tinyint(2) NOT NULL,
  `class_letter` char(1) NOT NULL,
  `date` date NOT NULL,
  `time_slot` int(2) NOT NULL,
  `time_slot_interval` varchar(20) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `new_subject` varchar(50) NOT NULL,
  `group_id` varchar(10) DEFAULT NULL,
  `teacher_name` varchar(50) NOT NULL,
  `room` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `class_num` (`class_num`,`class_letter`,`date`,`time_slot`,`group_id`),
  KEY `teacher_name` (`teacher_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
