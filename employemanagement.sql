-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 05, 2015 at 04:51 PM
-- Server version: 5.5.43
-- PHP Version: 5.3.10-1ubuntu3.18

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `employemanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login_tbl`
--

CREATE TABLE IF NOT EXISTS `admin_login_tbl` (
  `userid` varchar(500) NOT NULL,
  `pass` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_login_tbl`
--

INSERT INTO `admin_login_tbl` (`userid`, `pass`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'dept_id',
  `name` varchar(500) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `created`, `modified`) VALUES
(49, 'Human Resources', '2015-05-05 05:49:54', '2015-05-05 05:49:54'),
(50, 'IT', '2015-05-05 05:50:05', '2015-05-05 05:50:05'),
(51, 'Marketing', '2015-05-05 05:50:22', '2015-05-05 05:50:22'),
(52, 'Financial', '2015-05-05 05:50:34', '2015-05-05 05:50:34'),
(53, 'Sales', '2015-05-05 05:50:51', '2015-05-05 05:50:51');

-- --------------------------------------------------------

--
-- Table structure for table `departments_employees`
--

CREATE TABLE IF NOT EXISTS `departments_employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `departments_employees`
--

INSERT INTO `departments_employees` (`id`, `employee_id`, `department_id`, `from_date`, `to_date`, `created`, `modified`) VALUES
(3, 7, 50, '2015-02-01', '2016-02-01', '2015-05-05 15:01:01', '2015-05-05 15:01:01');

-- --------------------------------------------------------

--
-- Table structure for table `departments_managers`
--

CREATE TABLE IF NOT EXISTS `departments_managers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manager_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `departments_managers`
--

INSERT INTO `departments_managers` (`id`, `manager_id`, `department_id`, `from_date`, `to_date`, `created`, `modified`) VALUES
(1, 2, 50, '2015-02-01', '2015-05-03', '2015-05-05 00:00:00', '2015-05-05 00:00:00'),
(4, 3, 49, '2015-01-12', '2015-05-04', '2015-05-05 00:00:00', '2015-05-05 08:37:45');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'emp_id',
  `name` varchar(500) NOT NULL,
  `manager_id` int(11) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `hire_date` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `manager_id`, `dob`, `gender`, `hire_date`, `created`, `modified`) VALUES
(2, 'Sunil rai', 0, '1987-03-06', 'M', '2014-05-01', '2015-05-05 13:07:24', '2015-05-05 13:07:24'),
(3, 'Anil Sharma', 0, '1986-02-12', 'M', '2015-02-06', '2015-05-05 13:08:22', '2015-05-05 13:08:22'),
(7, 'ankur sharma', 2, '1987-01-01', 'M', '2015-03-03', '2015-05-05 15:01:01', '2015-05-05 15:01:01');

-- --------------------------------------------------------

--
-- Table structure for table `employees_titles`
--

CREATE TABLE IF NOT EXISTS `employees_titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `job_title_id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `employees_titles`
--

INSERT INTO `employees_titles` (`id`, `employee_id`, `job_title_id`, `from_date`, `to_date`, `created`, `modified`) VALUES
(2, 7, 7, '2015-02-01', '2016-02-01', '2015-05-05 15:01:01', '2015-05-05 15:01:01');

-- --------------------------------------------------------

--
-- Table structure for table `job_titles`
--

CREATE TABLE IF NOT EXISTS `job_titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `job_titles`
--

INSERT INTO `job_titles` (`id`, `title`, `created`, `modified`) VALUES
(7, 'Developer', '2015-05-05 11:21:35', '2015-05-05 11:21:35'),
(8, 'Front End Developer', '2015-05-05 11:22:02', '2015-05-05 11:22:02'),
(9, 'Team Lead', '2015-05-05 11:22:22', '2015-05-05 11:22:22'),
(10, 'Manager', '2015-05-05 11:22:32', '2015-05-05 11:22:32'),
(11, 'Associate', '2015-05-05 11:23:52', '2015-05-05 11:23:52'),
(12, 'VP', '2015-05-05 11:24:26', '2015-05-05 11:24:26');

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE IF NOT EXISTS `salaries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `salary` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `salaries`
--

INSERT INTO `salaries` (`id`, `employee_id`, `salary`, `from_date`, `to_date`, `created`, `modified`) VALUES
(1, 7, 40000, '2015-02-01', '2016-01-02', '2015-05-05 15:01:01', '2015-05-05 15:01:01');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
