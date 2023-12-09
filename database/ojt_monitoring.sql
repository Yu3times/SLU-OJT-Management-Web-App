-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 09, 2023 at 04:08 AM
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

use ojt_monitoring;
-- --------------------------------------------------------

--
-- Table structure for table `advisor`
--

DROP TABLE IF EXISTS `advisor`;
CREATE TABLE IF NOT EXISTS `advisor` (
  `advisorId` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`advisorId`)
) ENGINE=InnoDB AUTO_INCREMENT=333006 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `advisor`
--

INSERT INTO `advisor` (`advisorId`, `firstName`, `lastName`, `email`, `contact`) VALUES
(333001, 'Adriano', 'Ramos', 'advisor1@gmail.com', '123-456-7890'),
(333002, 'Lorena', 'Ackerman', 'advisor2@gmail.com', '234-567-8901'),
(333003, 'Gabriel', 'Silva', 'advisor3@gmail.com', '345-678-9012'),
(333004, 'Daniela', 'Ortega', 'advisor4@gmail.com', '456-789-0123'),
(333005, 'Mateo', 'Yaeger', 'advisor5@gmail.com', '567-890-1234');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE IF NOT EXISTS `announcements` (
  `announcementId` int NOT NULL AUTO_INCREMENT,
  `advisorId` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `datePosted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`announcementId`),
  KEY `announcements_advisorId` (`advisorId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`companyID`, `companyName`, `companyAddress`, `website`, `contact`) VALUES
(1, 'Accenture Philippines', '6750 Ayala Avenue, Makati City', 'www.accenture.com/ph-en', '02-988-7000'),
(2, 'IBM Philippines', '32nd Street, Bonifacio Global City, Taguig', 'www.ibm.com/ph-en', '02-995-6400'),
(3, 'Tata Consultancy Services (TCS)', '28th Street, Bonifacio Global City, Taguig', 'www.tcs.com/ph-en', '02-886-9999'),
(4, 'Tech Mahindra Philippines', '9th Avenue, Bonifacio Global City, Taguig', 'www.techmahindra.com/ph-en', '02-792-9000'),
(5, 'Infosys BPM Philippines', 'Uptown Parade, Bonifacio Global City, Taguig', 'www.infosysbpm.com/ph', '02-883-7000');

-- --------------------------------------------------------

--
-- Table structure for table `internship`
--

DROP TABLE IF EXISTS `internship`;
CREATE TABLE IF NOT EXISTS `internship` (
  `internshipId` int NOT NULL AUTO_INCREMENT,
  `studentId` int NOT NULL,
  `companyId` int NOT NULL,
  `teacherId` int NOT NULL,
  `advisorId` int NOT NULL,
  `dateStarted` date NOT NULL,
  `dateEnded` date NOT NULL,
  PRIMARY KEY (`internshipId`),
  KEY `internship_companyId` (`companyId`),
  KEY `internship_advisorId` (`advisorId`),
  KEY `internship_teacherId` (`teacherId`),
  KEY `studentId` (`studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`reportId`, `studentId`, `weekNum`, `hoursWorked`, `reportFile`, `submittedAt`, `comment`, `status`) VALUES
(11, 222001, 1, 20, 'juan_santos_w1_report.pdf', '2023-01-10 00:00:00', 'Great progress!', 2),
(12, 222002, 2, 15, 'maria_gonzales_w2_report.pdf', '2023-01-17 01:30:00', 'Meeting expectations', 2),
(13, 222003, 3, 25, 'jose_lopez_w3_report.pdf', '2023-01-24 02:45:00', 'Exceeding expectations!', 2),
(14, 222004, 4, 18, 'ana_cruz_w4_report.pdf', '2023-01-31 03:15:00', 'Good effort.', 1),
(15, 222005, 5, 30, 'ramon_reyes_w5_report.pdf', '2023-02-07 04:00:00', 'Outstanding work!', 2);

-- --------------------------------------------------------

--
-- Table structure for table `requirements`
--

DROP TABLE IF EXISTS `requirements`;
CREATE TABLE IF NOT EXISTS `requirements` (
  `requirementId` int NOT NULL AUTO_INCREMENT,
  `studentId` int NOT NULL,
  `jobResume` tinyint NOT NULL DEFAULT '0',
  `curriVitae` tinyint NOT NULL DEFAULT '0',
  `coverLetter` tinyint NOT NULL DEFAULT '0',
  `moa` tinyint(1) NOT NULL DEFAULT '0',
  `medCert` tinyint(1) NOT NULL DEFAULT '0',
  `waiver` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`requirementId`),
  KEY `studentId_requirements` (`studentId`),
  KEY `moc_status` (`moa`),
  KEY `medCert_status` (`medCert`),
  KEY `waiver_status` (`waiver`),
  KEY `jobResume_status` (`jobResume`),
  KEY `curriVitae_status` (`curriVitae`),
  KEY `coverLetter_status` (`coverLetter`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requirements`
--

INSERT INTO `requirements` (`requirementId`, `studentId`, `jobResume`, `curriVitae`, `coverLetter`, `moa`, `medCert`, `waiver`) VALUES
(11, 222001, 0, 0, 0, 1, 1, 0),
(12, 222002, 0, 0, 0, 1, 0, 1),
(13, 222003, 0, 0, 0, 1, 1, 0),
(14, 222004, 0, 0, 0, 0, 1, 1),
(15, 222005, 0, 0, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `code` tinyint(1) NOT NULL,
  `status` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB AUTO_INCREMENT=222011 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentId`, `userId`, `firstName`, `lastName`, `course`, `classCode`) VALUES
(222001, 1, 'Juan', 'Santos', 'BSCS', 9373),
(222002, 2, 'Maria', 'Gonzales', 'BSCS', 9373),
(222003, 3, 'Jose', 'Lopez', 'BSCS', 9374),
(222004, 4, 'Ana', 'Cruz', 'BSCS', 9374),
(222005, 5, 'Ramon', 'Reyes', 'BSCS', 9373),
(222006, 6, 'Sofia', 'Torres', 'BSCS', 9375),
(222007, 7, 'Miguel', 'Dela Cruz', 'BSCS', 9373),
(222008, 8, 'Carmen', 'Rivera', 'BSCS', 9375),
(222009, 9, 'Pedro', 'Santiago', 'BSCS', 9375),
(222010, 10, 'Bella', 'Fernando', 'BSCS', 9374);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacherId`, `userId`, `firstName`, `lastName`) VALUES
(111011, 11, ' Carlos', 'Gomez'),
(111012, 12, 'Elena', 'Perez'),
(111013, 13, 'Luis', 'Ramirez'),
(111014, 14, 'Isabel', 'Gutirrez'),
(111015, 15, 'Antonio', 'Diaz');

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `email`, `password`, `type`) VALUES
(1, 'student1@slu.edu.ph', 'student1pass', 1),
(2, 'student2@slu.edu.ph', 'student2pass', 1),
(3, 'student3@slu.edu.ph', 'student3pass', 1),
(4, 'student4@slu.edu.ph', 'student4pass', 1),
(5, 'student5@slu.edu.ph', 'student5pass', 1),
(6, 'student6@slu.edu.ph', 'student6pass', 1),
(7, 'student7@slu.edu.ph', 'student7pass', 1),
(8, 'student8@slu.edu.ph', 'student8pass', 1),
(9, 'student9@slu.edu.ph', 'student9pass', 1),
(10, 'student10@slu.edu.ph', 'student10pass', 1),
(11, 'teacher1@slu.edu.ph', 'teacher1pass', 2),
(12, 'teacher2@slu.edu.ph', 'teacher2pass', 2),
(13, 'teacher3@slu.edu.ph', ' teacher3pass', 2),
(14, 'teacher4@slu.edu.ph', 'teacher4pass', 2),
(15, 'teacher5@slu.edu.ph', 'teacher5pass', 2),
(16, 'advisor1@gmail.com', 'advisor1pass', 3),
(17, 'advisor2@gmail.com', 'advisor2pass', 3),
(18, 'advisor3@gmail.com', 'advisor3pass', 3),
(19, 'advisor4@gmail.com', 'advisor4pass', 3),
(20, 'advisor5@gmail.com', 'advisor5pass', 3);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_advisorId` FOREIGN KEY (`advisorId`) REFERENCES `advisor` (`advisorId`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
  ADD CONSTRAINT `coverLetter_status` FOREIGN KEY (`coverLetter`) REFERENCES `status` (`code`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `curriVitae_status` FOREIGN KEY (`curriVitae`) REFERENCES `status` (`code`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `jobResume_status` FOREIGN KEY (`jobResume`) REFERENCES `status` (`code`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `medCert_status` FOREIGN KEY (`medCert`) REFERENCES `status` (`code`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `moa_status` FOREIGN KEY (`moa`) REFERENCES `status` (`code`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `studentId_requirements` FOREIGN KEY (`studentId`) REFERENCES `student` (`studentId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `waiver_status` FOREIGN KEY (`waiver`) REFERENCES `status` (`code`) ON DELETE RESTRICT ON UPDATE CASCADE;

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
