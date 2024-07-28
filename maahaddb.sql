-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 28, 2024 at 11:46 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maahaddb`
--

-- --------------------------------------------------------

--
-- Table structure for table `clerk`
--

CREATE TABLE `clerk` (
  `CLERKID` int NOT NULL,
  `CLERKNAME` varchar(255) NOT NULL,
  `CLERKPNO` varchar(12) DEFAULT NULL,
  `CLERKDOB` date DEFAULT NULL,
  `CLERKEMAIL` varchar(50) DEFAULT NULL,
  `CLERKTYPE` varchar(10) DEFAULT NULL,
  `CLERKPASSWORD` varchar(30) NOT NULL,
  `CLERKIMAGE` varchar(255) DEFAULT NULL,
  `STATUS` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `clerk`
--

INSERT INTO `clerk` (`CLERKID`, `CLERKNAME`, `CLERKPNO`, `CLERKDOB`, `CLERKEMAIL`, `CLERKTYPE`, `CLERKPASSWORD`, `CLERKIMAGE`, `STATUS`) VALUES
(20001, 'siti badrisyah binti badri', '013-3422212', '2024-07-19', 'badri@gmail.com', 'admin', '123', '40.jpg', 'active'),
(20002, 'Nurul Iman Qasdina Binti Mohd Kairudin', '013-3131233', '2005-01-11', 'imanqas@gmail.com', 'clerk', '123', '22.jpg', 'active'),
(20004, 'Ahmad nurudin', '013-5771231', '2003-10-10', 'nurudin@gmail.com', 'clerk', '123', '', 'active'),
(20005, 'nurul hidayah', '019-9801231', '1999-09-22', 'nurul@gmail.com', 'clerk', '123', 'anime-profile-picture-of-saturo-gojo-3ediej7vuki5543r.jpg', 'active'),
(20006, 'Ahmad Dusuki', '017-7777213', '1993-08-13', 'Dusuki@gmail.com', 'clerk', '123', '71.jpg', 'active'),
(20007, 'Lim wan er', '016-33191123', '2005-10-29', 'Lim@gmail.com', 'clerk', '123', '35.jpg', 'active'),
(20008, 'Aiman bin Dol', '132-1215656', '1999-01-02', 'man@gmail.com', 'clerk', '123', '', 'active'),
(20009, 'zamzuri bin zamari', '018-8832921', '2001-01-01', 'zam@gmail.com', 'clerk', '123', '', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int NOT NULL,
  `stuid` int DEFAULT NULL,
  `message` text,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `stuid`, `message`, `status`, `created_at`) VALUES
(1, 10013, 'Your registration has been approved.', 'read', '2024-07-24 00:36:05'),
(2, 10013, 'Your registration has been rejected.', 'read', '2024-07-24 00:41:38'),
(3, 10013, 'Your registration has been approved.', 'read', '2024-07-24 11:15:57');

-- --------------------------------------------------------

--
-- Table structure for table `principal`
--

CREATE TABLE `principal` (
  `PRINCIPALID` int NOT NULL,
  `PRINCIPALNAME` varchar(50) NOT NULL,
  `PRINCIPALPNO` varchar(12) NOT NULL,
  `PRINCIPALDOB` date DEFAULT NULL,
  `PRINCIPALEMAIL` varchar(30) DEFAULT NULL,
  `PRINCIPALADDRESS` varchar(255) DEFAULT NULL,
  `PRINCIPALPASS` varchar(30) NOT NULL,
  `PRINCIPALIMAGE` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `principal`
--

INSERT INTO `principal` (`PRINCIPALID`, `PRINCIPALNAME`, `PRINCIPALPNO`, `PRINCIPALDOB`, `PRINCIPALEMAIL`, `PRINCIPALADDRESS`, `PRINCIPALPASS`, `PRINCIPALIMAGE`) VALUES
(100, 'Zamari bin Abdul Wahab', '019-9092211', '1998-01-01', 'zamari@gmail.com', 'lot 330, penjara pudu, Selangor', '123', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `REGNO` int NOT NULL,
  `STUID` int DEFAULT NULL,
  `PRINCIPALID` int DEFAULT NULL,
  `REGDATE` date DEFAULT NULL,
  `CLERKID` int DEFAULT NULL,
  `STATUS` varchar(50) DEFAULT NULL,
  `REGSTATUS` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`REGNO`, `STUID`, `PRINCIPALID`, `REGDATE`, `CLERKID`, `STATUS`, `REGSTATUS`) VALUES
(40001, 10001, 100, '2024-05-14', 20008, 'Approved', 'active'),
(40007, 10004, NULL, '2024-07-15', NULL, 'Approved', 'active'),
(40008, 10005, NULL, '2024-07-15', NULL, 'Rejected', 'active'),
(40010, 10007, NULL, '2024-07-20', NULL, 'Pending', 'active'),
(40011, 10008, NULL, '2024-07-20', NULL, 'Pending', 'active'),
(40012, 10009, NULL, '2024-07-20', NULL, 'Pending', 'active'),
(40013, 10010, NULL, '2024-07-20', NULL, 'Pending', 'active'),
(40014, 10011, NULL, '2024-07-20', NULL, 'Pending', 'active'),
(40015, 10012, NULL, '2024-07-20', NULL, 'Pending', 'active'),
(40016, 10013, 100, '2024-07-20', 20007, 'Approved', 'active'),
(40017, 10014, NULL, '2024-07-20', NULL, 'Pending', 'active'),
(40018, 10015, NULL, '2024-07-20', NULL, 'Pending', 'active'),
(40019, 10016, NULL, '2024-07-20', NULL, 'Pending', 'active'),
(40020, 10017, NULL, '2024-07-20', NULL, 'Pending', 'active'),
(40021, 10018, NULL, '2024-07-20', NULL, 'Pending', 'active'),
(40022, 10019, NULL, '2024-07-20', NULL, 'Pending', 'active'),
(40023, 10020, NULL, '2024-07-20', NULL, 'Pending', 'active'),
(40024, 10021, NULL, '2024-07-20', NULL, 'Pending', 'active'),
(40025, 10022, NULL, '2024-07-20', NULL, 'Pending', 'active'),
(40026, 10023, 100, '2024-07-22', 20002, 'Approved', 'active'),
(40027, 10024, NULL, '2024-07-28', NULL, 'Pending', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `STUID` int NOT NULL,
  `STUNAME` varchar(255) NOT NULL,
  `STUPNO` varchar(12) NOT NULL,
  `STUEMAIL` varchar(50) NOT NULL,
  `STUPASSWORD` varchar(30) NOT NULL,
  `STUGENDER` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `STUADDRESS` varchar(255) DEFAULT NULL,
  `STUDOB` date DEFAULT NULL,
  `FATHERNAME` varchar(255) DEFAULT NULL,
  `MOTHERNAME` varchar(255) DEFAULT NULL,
  `SALARY` decimal(10,2) DEFAULT NULL,
  `STUIMAGE` varchar(255) DEFAULT NULL,
  `STATUS` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`STUID`, `STUNAME`, `STUPNO`, `STUEMAIL`, `STUPASSWORD`, `STUGENDER`, `STUADDRESS`, `STUDOB`, `FATHERNAME`, `MOTHERNAME`, `SALARY`, `STUIMAGE`, `STATUS`) VALUES
(10001, 'Danish Haikal Bin Suhaimi', '011-26269760', 'danish@gmail.com', '123', NULL, 'LOT 451, Kampung Chepa, Kubang Kerian,16150, Kota Bharu, Kelantan', '2003-10-25', 'Suhaimi Bin Md Zin', 'Noor Liza Binti Hamzah', 7321.00, 'photo_2023-09-15_16-26-43.jpg', 'active'),
(10004, 'Amir bin Hamzah', '018-12310012', 'amir@gmail.com', '123', 'Male', 'jalan 32, batu berenam, sabah', '1993-07-27', 'Hamzah bin Mamat', 'Siti Mas binti Mat', 3500.00, '22.jpg', 'active'),
(10005, 'Hanif Bin Mohd Bakhtiar', '013-1391991', 'hanif@gmail.com', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
(10007, 'Zaimi Bin Zakaria', '018-77628112', 'zaimi@gmail.com', '123', 'Male', 'LOT 115, Kampung Panji, Kota Bharu, Kelantan', '1990-01-18', 'Zakaria Bin Musa', 'Maidah Binti Awang', 2891.00, NULL, 'active'),
(10008, 'Ramli Bin Che Noh', '017-8291312', 'ramli@gmail.com', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
(10009, 'Salleh Bin Rahim', '011-9990132', 'sall@gmail.com', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
(10010, 'Saadiah Binti Shaari', '014-8871132', 'sadiah@gmail.com', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
(10011, 'Liyana Binti Imran', '013-77199314', 'liy@gmail.com', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
(10012, 'Siti Binti Hafizul', '015-1543123', 'sit55@gmail.com', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
(10013, 'Intan Binti Nukman', '018-9978213', 'intan@gmail.com', '123', 'Female', 'No. 99, Jalan Subaraya, Kuantan, Pahang', '2004-08-17', 'Nukman Bin Mazlan', 'Saadiah Binti Shaari', 9810.00, '35.jpg', 'active'),
(10014, 'Farhan Bin Seman', '018-8890131', 'paan@gmail.com', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
(10015, 'Faruqi Bin Mazlan', '011-1001031', 'farrq@gmail.com', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
(10016, 'Hazman Bin Zain', '010-9913913', 'hazmn@gmail.com', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
(10017, 'Sol Bin Dol', '014-5461312', 'soldol@gmail.com', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
(10018, 'Firdaus Bin Sabri', '012-3313412', 'fird@gmail.com', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
(10019, 'Bahrina Binti Fulan', '011-3901341', 'barhn@gmail.com', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
(10020, 'Tatwina Binti Samon', '014-5594132', 'tawon@gmail.com', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
(10021, 'Ahmad Bin Osman', '015-1320131', 'ahmdosm@gmail.com', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
(10022, 'Andika Bin Mahmud', '018-8980131', 'andi@gmail.com', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
(10023, 'Ahmad Sintol Bin Jeman', '018-1923110', 'sinol@gmail.com', '123', 'Male', 'Jalan Permata Indah, Kuala Pilah, Pahang', '2010-08-17', 'Jeman Bin Naziahudin', 'Suria Binti Stopa', 1875.00, '62.jpg', 'active'),
(10024, 'Amirul Aiman Bin Che Noh', '018-9921032', 'amirul@gmail.com', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clerk`
--
ALTER TABLE `clerk`
  ADD PRIMARY KEY (`CLERKID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `stuid` (`stuid`);

--
-- Indexes for table `principal`
--
ALTER TABLE `principal`
  ADD PRIMARY KEY (`PRINCIPALID`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`REGNO`),
  ADD KEY `STUID` (`STUID`),
  ADD KEY `PRINCIPALID` (`PRINCIPALID`),
  ADD KEY `CLERKID` (`CLERKID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`STUID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clerk`
--
ALTER TABLE `clerk`
  MODIFY `CLERKID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20010;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `REGNO` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40028;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `STUID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10025;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`stuid`) REFERENCES `student` (`STUID`);

--
-- Constraints for table `registration`
--
ALTER TABLE `registration`
  ADD CONSTRAINT `registration_ibfk_1` FOREIGN KEY (`STUID`) REFERENCES `student` (`STUID`),
  ADD CONSTRAINT `registration_ibfk_2` FOREIGN KEY (`PRINCIPALID`) REFERENCES `principal` (`PRINCIPALID`),
  ADD CONSTRAINT `registration_ibfk_3` FOREIGN KEY (`CLERKID`) REFERENCES `clerk` (`CLERKID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
