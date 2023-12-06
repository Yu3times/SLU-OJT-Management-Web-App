-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 06, 2023 at 11:43 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ojt_monitoring`
--

-- --------------------------------------------------------

--
-- Table structure for table `advisor`
--

DROP TABLE IF EXISTS `advisor`;
CREATE TABLE IF NOT EXISTS `advisor` (
  `advisorId` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`advisorId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `companyID` int NOT NULL AUTO_INCREMENT,
  `companyName` varchar(255) NOT NULL,
  `companyAddress` varchar(255) NOT NULL,
  `website` varchar(50) NOT NULL,
  `contact` varchar(50) NOT NULL,
  PRIMARY KEY (`companyID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `internship`
--

DROP TABLE IF EXISTS `internship`;
CREATE TABLE IF NOT EXISTS `internship` (
  `studentId` int NOT NULL AUTO_INCREMENT,
  `companyId` int NOT NULL,
  `teacherId` int NOT NULL,
  `advisorId` int NOT NULL,
  `dateStarted` date NOT NULL,
  `dateEnded` date NOT NULL,
  PRIMARY KEY (`studentId`),
  KEY `internship_companyId` (`companyId`),
  KEY `internship_advisorId` (`advisorId`),
  KEY `internship_teacherId` (`teacherId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
CREATE TABLE IF NOT EXISTS `reports` (
  `reportId` int NOT NULL AUTO_INCREMENT,
  `studentId` int NOT NULL,
  `weekNum` int NOT NULL,
  `hoursWorked` int NOT NULL,
  `reportFile` varchar(255) NOT NULL,
  `submittedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`reportId`),
  KEY `userId_reports` (`studentId`),
  KEY `report_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requirements`
--

DROP TABLE IF EXISTS `requirements`;
CREATE TABLE IF NOT EXISTS `requirements` (
  `requirementId` int NOT NULL AUTO_INCREMENT,
  `studentId` int NOT NULL,
  `moc` tinyint(1) NOT NULL DEFAULT '0',
  `medCert` tinyint(1) NOT NULL DEFAULT '0',
  `waiver` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`requirementId`),
  KEY `studentId_requirements` (`studentId`),
  KEY `moc_status` (`moc`),
  KEY `medCert_status` (`medCert`),
  KEY `waiver_status` (`waiver`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `code` tinyint(1) NOT NULL,
  `status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`code`, `status`) VALUES
(0, 'MISSING'),
(1, 'REVIEWING'),
(2, 'APPROVED');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `studentId` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `classCode` int NOT NULL,
  PRIMARY KEY (`studentId`),
  KEY `userId_student` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

DROP TABLE IF EXISTS `teacher`;
CREATE TABLE IF NOT EXISTS `teacher` (
  `teacherId` int NOT NULL,
  `userId` int NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  PRIMARY KEY (`teacherId`),
  KEY `userId_advisor` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userId` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` int NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `internship`
--
ALTER TABLE `internship`
  ADD CONSTRAINT `internship_advisorId` FOREIGN KEY (`advisorId`) REFERENCES `advisor` (`advisorId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `internship_companyId` FOREIGN KEY (`companyId`) REFERENCES `company` (`companyID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `internship_studentId` FOREIGN KEY (`studentId`) REFERENCES `student` (`studentId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `internship_teacherId` FOREIGN KEY (`teacherId`) REFERENCES `teacher` (`teacherId`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `report_status` FOREIGN KEY (`status`) REFERENCES `status` (`code`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `userId_reports` FOREIGN KEY (`studentId`) REFERENCES `student` (`studentId`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `requirements`
--
ALTER TABLE `requirements`
  ADD CONSTRAINT `medCert_status` FOREIGN KEY (`medCert`) REFERENCES `status` (`code`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `moc_status` FOREIGN KEY (`moc`) REFERENCES `status` (`code`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `studentId_requirements` FOREIGN KEY (`studentId`) REFERENCES `student` (`studentId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `waiver_status` FOREIGN KEY (`waiver`) REFERENCES `status` (`code`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `userId_student` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `userId_teacherId` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
