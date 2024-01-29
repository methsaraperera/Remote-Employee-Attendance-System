-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 29, 2024 at 08:19 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `colmahr`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `Admin_ID` int(10) NOT NULL,
  `Admin_Name` varchar(64) NOT NULL,
  `Admin_Email` varchar(255) NOT NULL,
  `Admin_Password` varchar(255) NOT NULL,
  `Status` int(16) DEFAULT NULL,
  `type` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `rowid` int(255) NOT NULL,
  `Emp_ID` int(10) NOT NULL,
  `in_date` date NOT NULL,
  `in_time` time NOT NULL,
  `in_location` varchar(255) NOT NULL,
  `out_date` date DEFAULT NULL,
  `out_time` time DEFAULT NULL,
  `out_location` varchar(255) DEFAULT NULL,
  `stat_in` int(2) DEFAULT NULL COMMENT 'Use for system recognition',
  `stat_out` int(2) DEFAULT NULL COMMENT 'Use for system recognition',
  `ot_time` varchar(8) DEFAULT NULL,
  `ot_stat` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee`
--

CREATE TABLE `tbl_employee` (
  `Emp_ID` int(10) NOT NULL,
  `Emp_Name` varchar(64) NOT NULL,
  `Emp_Email` varchar(255) NOT NULL,
  `Emp_Password` varchar(255) NOT NULL,
  `Emp_Type` varchar(64) DEFAULT NULL,
  `SQ1` varchar(128) DEFAULT NULL,
  `SA1` varchar(128) DEFAULT NULL,
  `SQ2` varchar(128) DEFAULT NULL,
  `SA2` varchar(128) DEFAULT NULL,
  `SQ3` varchar(128) DEFAULT NULL,
  `SA3` varchar(128) DEFAULT NULL,
  `supervisor` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_status`
--

CREATE TABLE `tbl_emp_status` (
  `empid` int(10) NOT NULL,
  `status` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_types`
--

CREATE TABLE `tbl_emp_types` (
  `typeid` int(10) NOT NULL,
  `name` varchar(64) NOT NULL,
  `max_ot_hours` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leave_record`
--

CREATE TABLE `tbl_leave_record` (
  `rowid` int(10) NOT NULL,
  `empid` int(10) NOT NULL,
  `date` date NOT NULL,
  `leave_type` varchar(16) NOT NULL,
  `descripition` varchar(512) DEFAULT NULL,
  `status` varchar(16) NOT NULL,
  `stat` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leave_type`
--

CREATE TABLE `tbl_leave_type` (
  `emp_type_id` int(10) NOT NULL,
  `annual` int(2) NOT NULL,
  `casual` int(2) NOT NULL,
  `sick` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`Admin_ID`);

--
-- Indexes for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`rowid`,`in_date`),
  ADD KEY `uid` (`rowid`),
  ADD KEY `fk_empid_attend` (`Emp_ID`);

--
-- Indexes for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  ADD PRIMARY KEY (`Emp_Email`),
  ADD UNIQUE KEY `Emp_ID` (`Emp_ID`),
  ADD KEY `fk_emp_type` (`Emp_Type`);

--
-- Indexes for table `tbl_emp_status`
--
ALTER TABLE `tbl_emp_status`
  ADD UNIQUE KEY `empid` (`empid`);

--
-- Indexes for table `tbl_emp_types`
--
ALTER TABLE `tbl_emp_types`
  ADD PRIMARY KEY (`typeid`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `tbl_leave_record`
--
ALTER TABLE `tbl_leave_record`
  ADD PRIMARY KEY (`empid`,`date`),
  ADD UNIQUE KEY `rowid` (`rowid`);

--
-- Indexes for table `tbl_leave_type`
--
ALTER TABLE `tbl_leave_type`
  ADD UNIQUE KEY `emp_type_id_2` (`emp_type_id`),
  ADD KEY `emp_type_id` (`emp_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `Admin_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  MODIFY `rowid` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  MODIFY `Emp_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_emp_types`
--
ALTER TABLE `tbl_emp_types`
  MODIFY `typeid` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_leave_record`
--
ALTER TABLE `tbl_leave_record`
  MODIFY `rowid` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD CONSTRAINT `fk_empid_attend` FOREIGN KEY (`Emp_ID`) REFERENCES `tbl_employee` (`Emp_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  ADD CONSTRAINT `fk_emp_type` FOREIGN KEY (`Emp_Type`) REFERENCES `tbl_emp_types` (`name`);

--
-- Constraints for table `tbl_emp_status`
--
ALTER TABLE `tbl_emp_status`
  ADD CONSTRAINT `fk_empid_stat` FOREIGN KEY (`empid`) REFERENCES `tbl_employee` (`Emp_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_leave_record`
--
ALTER TABLE `tbl_leave_record`
  ADD CONSTRAINT `fk_empid` FOREIGN KEY (`empid`) REFERENCES `tbl_employee` (`Emp_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_leave_type`
--
ALTER TABLE `tbl_leave_type`
  ADD CONSTRAINT `tbl_leave_type_ibfk_1` FOREIGN KEY (`emp_type_id`) REFERENCES `tbl_emp_types` (`typeid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
