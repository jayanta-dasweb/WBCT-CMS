-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2022 at 06:58 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wbctcms`
--

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `empId` int(11) NOT NULL,
  `areaName` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`empId`, `areaName`) VALUES
(2, 'Machkhowa F. A. Road '),
(8, 'Garchuk Chariali'),
(2, 'Natunbasti, Datalpara'),
(8, 'Panbazar Pani Tanki'),
(8, 'Fatashil Ambari');

-- --------------------------------------------------------

--
-- Table structure for table `cable_operator`
--

CREATE TABLE `cable_operator` (
  `empId` int(11) NOT NULL,
  `empName` varchar(50) NOT NULL,
  `phNumber` varchar(10) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'employee',
  `psw` varchar(30) NOT NULL DEFAULT 'Employee123*',
  `otp` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cable_operator`
--

INSERT INTO `cable_operator` (`empId`, `empName`, `phNumber`, `role`, `psw`, `otp`) VALUES
(1, 'Jayanta Das', '7002911685', 'admin', 'Jayanta123*', 4733),
(2, 'Rahul Roy', '8876074993', 'employee', 'Rahul123*', 8520),
(8, 'John', '9954006206', 'employee', 'Employee123*', NULL),
(11, 'Nilima', '6000165007', 'employee', 'Employee123*', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `channels`
--

CREATE TABLE `channels` (
  `pkgId` int(11) DEFAULT NULL,
  `chnlName` varchar(100) NOT NULL,
  `chnlAmt` varchar(5) NOT NULL,
  `logo` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `channels`
--

INSERT INTO `channels` (`pkgId`, `chnlName`, `chnlAmt`, `logo`) VALUES
(16, 'ABP News', '8', 'abp_news.jpg'),
(16, 'BBC World News', '21', 'bbc_world_news.jpg'),
(16, 'CNN News18', '20', 'cnn-news18.jpg'),
(16, 'DD News', '16', 'dd-news.jpg'),
(16, 'DY365', '16', 'dy365.jpg'),
(16, 'News Live', '20', ' news_live.jpg'),
(16, 'News18 India', '19', 'news18_india.jpg'),
(16, 'Republic TV', '16', 'republic_tv.jpg'),
(16, 'Zee News', '9', 'zee-news.jpg'),
(16, 'Aaj Tak', '6', 'Aaj_tak.jpg'),
(17, 'Sony Espn', '8', 'sony_espn.jpg'),
(17, 'Sony Espn HD', '10', 'sony_espn_hd.jpg'),
(17, 'Sony Six', '10', 'sony_six.jpg'),
(17, 'Sony Ten 1', '8', 'sony_ten_1.jpg'),
(17, 'Sony Ten 2', '12', 'sony_ten_2.jpg'),
(17, 'Sony Ten 2 HD', '18', 'sony_ten_2_hd.jpg'),
(17, 'Sony Ten 3 HD', '20', 'sony_ten_3_hd.jpg'),
(17, 'Sony Ten 3', '13', 'sony-ten-3.jpg'),
(17, 'Star Sports', '3', 'star_sports.jpg'),
(18, 'Disney', '10', 'disney.jpg'),
(18, 'Hungama TV', '5', 'hungama_tv.jpg'),
(18, 'Nickelodeon', '14', 'nickelodeon.jpg'),
(18, 'Pogo', '11', 'pogo.jpg'),
(18, 'Toon Disney', '5', 'toon_disney.jpg'),
(19, 'Colors Tv', '21', 'colors_tv.jpg'),
(19, 'India TV', '10', 'india-tv.jpg'),
(19, 'NDTV India', '9', 'ndtv_india.jpg'),
(19, 'Sony Enterainment TV', '6', 'sony_enterainment_tv.jpg'),
(19, 'Sony Sab', '9', 'sony_sab.jpg'),
(19, 'Star Plus', '2', 'star_plus.jpg'),
(19, 'Star Vijay', '6', 'star_vijay-01.jpg'),
(19, 'Sun TV', '10', 'sun_tv.jpg'),
(19, 'Zee Cinema', '8', 'zee_cinema.jpg'),
(19, 'Zee TV', '3', 'zee_tv.jpg'),
(20, 'Discovery', '6', 'discovery.jpg'),
(20, 'TLC', '13', 'tlc.jpg'),
(20, 'CNN News18', '20', 'cnn-news18.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `complaintsId` int(11) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'pending',
  `description` varchar(1000) DEFAULT NULL,
  `subject` varchar(500) NOT NULL,
  `custId` int(11) NOT NULL,
  `empId` int(11) DEFAULT NULL,
  `complaintsDt` timestamp NOT NULL DEFAULT current_timestamp(),
  `resolveDt` datetime DEFAULT NULL,
  `complaintNo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`complaintsId`, `status`, `description`, `subject`, `custId`, `empId`, `complaintsDt`, `resolveDt`, `complaintNo`) VALUES
(2, 'resolved', 'bla bla bla', 'somthing .....', 4, 2, '2021-12-29 11:35:21', '2021-12-29 18:45:55', 'COM122'),
(4, 'resolved', 'joy joy bla bla ', 'bla bla bla', 6, 8, '2022-01-01 08:50:58', '2022-01-01 14:29:42', 'COM894');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `custId` int(11) NOT NULL,
  `email` varchar(300) DEFAULT NULL,
  `STBNumber` varchar(20) DEFAULT NULL,
  `pincode` varchar(10) NOT NULL,
  `houseNo` int(11) NOT NULL,
  `areaName` varchar(500) NOT NULL,
  `phNumber` varchar(10) NOT NULL,
  `custName` varchar(100) NOT NULL,
  `connId` int(11) DEFAULT NULL,
  `otp` varchar(5) DEFAULT NULL,
  `psw` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`custId`, `email`, `STBNumber`, `pincode`, `houseNo`, `areaName`, `phNumber`, `custName`, `connId`, `otp`, `psw`) VALUES
(4, 'ndas4982@gmail.com', 'N91234786594', '781009', 26, 'Garchuk Chariali', '6000165007', 'Gita Das', 4, '2985', 'Gita123*'),
(6, 'joy56@gmail.com', 'N00812345674', '781025', 29, 'Panbazar Pani Tanki', '9954006206', 'joy Hazarika', 6, NULL, 'Joy123*'),
(25, 'ankitchoudhoury@gmail.com', 'N897456123789', '781025', 26, 'Natunbasti, Datalpara', '9706961344', 'Pinak', 25, NULL, 'pinak');

-- --------------------------------------------------------

--
-- Table structure for table `custompkgids`
--

CREATE TABLE `custompkgids` (
  `pkgId` int(11) NOT NULL,
  `pkgIds` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `custompkgids`
--

INSERT INTO `custompkgids` (`pkgId`, `pkgIds`) VALUES
(42, 16),
(42, 18),
(42, 19),
(45, 16),
(45, 17),
(46, 18),
(46, 20),
(49, 16),
(49, 17),
(50, 19),
(50, 20),
(51, 19),
(51, 20);

-- --------------------------------------------------------

--
-- Table structure for table `includes`
--

CREATE TABLE `includes` (
  `pkgId` int(11) NOT NULL,
  `payId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `includes`
--

INSERT INTO `includes` (`pkgId`, `payId`) VALUES
(42, 1),
(42, 2),
(46, 4);

-- --------------------------------------------------------

--
-- Table structure for table `new_connection`
--

CREATE TABLE `new_connection` (
  `connId` int(11) NOT NULL,
  `empId` int(11) DEFAULT NULL,
  `custId` int(11) NOT NULL,
  `connStatus` varchar(30) NOT NULL DEFAULT 'pending',
  `applyDt` timestamp NOT NULL DEFAULT current_timestamp(),
  `approveDt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `new_connection`
--

INSERT INTO `new_connection` (`connId`, `empId`, `custId`, `connStatus`, `applyDt`, `approveDt`) VALUES
(4, 8, 4, 'active', '2021-12-29 10:28:23', '2021-12-29 15:58:23'),
(6, 8, 6, 'active', '2022-01-01 08:42:33', '2022-01-01 14:19:26'),
(25, 2, 25, 'active', '2022-01-06 08:22:50', '2022-01-06 14:03:55');

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `pkgId` int(11) NOT NULL,
  `amount` varchar(5) DEFAULT NULL,
  `pkgName` varchar(50) NOT NULL,
  `pkgType` varchar(50) NOT NULL DEFAULT 'custom'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`pkgId`, `amount`, `pkgName`, `pkgType`) VALUES
(16, '151', 'News', 'default'),
(17, '102', 'Sports', 'default'),
(18, '45', 'Cartoon', 'default'),
(19, '84', 'Entertainment And Lifestyle  ', 'default'),
(20, '39', 'Science And Discovery', 'default'),
(42, '280', 'Family Package-1', 'defaultcust'),
(45, '253', 'Tmp- 4', 'custom'),
(46, '84', 'Tmptwo- 4', 'custom'),
(49, '253', 'Pkg1-8', 'custom'),
(50, '123', 'Pkg2-8', 'custom'),
(51, '123', 'Pkgt-23', 'custom');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payId` int(11) NOT NULL,
  `billAmt` varchar(10) NOT NULL,
  `expiredDt` timestamp NULL DEFAULT NULL,
  `rechargeDt` timestamp NULL DEFAULT NULL,
  `custId` int(11) NOT NULL,
  `payStatus` varchar(30) NOT NULL DEFAULT 'pending',
  `payNo` varchar(20) DEFAULT NULL,
  `payType` varchar(100) NOT NULL DEFAULT 'monthlyRecharge'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payId`, `billAmt`, `expiredDt`, `rechargeDt`, `custId`, `payStatus`, `payNo`, `payType`) VALUES
(1, '500', '2022-01-29 07:26:43', '2022-01-01 07:26:43', 4, 'done', 'PAY121', 'monthlyRecharge'),
(2, '300', '2022-01-26 20:23:43', '2021-12-29 20:23:43', 4, 'done', 'PAY222', 'monthlyRecharge'),
(4, '100', '2022-01-27 04:00:43', '2021-12-30 04:00:43', 4, 'done', 'PAY144', 'monthlyRecharge');

-- --------------------------------------------------------

--
-- Table structure for table `pkg_manage_co`
--

CREATE TABLE `pkg_manage_co` (
  `pkgId` int(11) NOT NULL,
  `empId` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pkg_manage_co`
--

INSERT INTO `pkg_manage_co` (`pkgId`, `empId`, `date`) VALUES
(16, 1, '2021-12-21 14:49:02'),
(17, 1, '2021-12-21 14:49:16'),
(18, 1, '2021-12-21 14:49:29'),
(19, 1, '2021-12-21 14:50:40'),
(20, 1, '2021-12-21 14:51:20'),
(42, 1, '2021-12-28 14:29:17');

-- --------------------------------------------------------

--
-- Table structure for table `pkg_manage_cust`
--

CREATE TABLE `pkg_manage_cust` (
  `pkgId` int(11) NOT NULL,
  `custId` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pkg_manage_cust`
--

INSERT INTO `pkg_manage_cust` (`pkgId`, `custId`, `date`) VALUES
(45, 4, '2021-12-30 11:22:48'),
(46, 4, '2021-12-30 11:23:34');

-- --------------------------------------------------------

--
-- Table structure for table `temp_cust`
--

CREATE TABLE `temp_cust` (
  `custId` int(11) NOT NULL,
  `custName` varchar(100) NOT NULL,
  `phNumber` varchar(10) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `houseNo` varchar(10) DEFAULT NULL,
  `areaName` varchar(100) DEFAULT NULL,
  `empId` int(11) DEFAULT NULL,
  `psw` varchar(20) NOT NULL,
  `otp` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `temp_cust`
--

INSERT INTO `temp_cust` (`custId`, `custName`, `phNumber`, `email`, `pincode`, `houseNo`, `areaName`, `empId`, `psw`, `otp`) VALUES
(25, 'Pinak', '9706961344', 'ankitchoudhoury@gmail.com', '781025', '26', 'Natunbasti, Datalpara', 2, 'pinak', '9723');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD KEY `empId` (`empId`);

--
-- Indexes for table `cable_operator`
--
ALTER TABLE `cable_operator`
  ADD PRIMARY KEY (`empId`);

--
-- Indexes for table `channels`
--
ALTER TABLE `channels`
  ADD KEY `pkgId` (`pkgId`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`complaintsId`),
  ADD KEY `custId` (`custId`),
  ADD KEY `empId` (`empId`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`custId`),
  ADD KEY `connId` (`connId`);

--
-- Indexes for table `custompkgids`
--
ALTER TABLE `custompkgids`
  ADD KEY `pkgId` (`pkgId`);

--
-- Indexes for table `includes`
--
ALTER TABLE `includes`
  ADD KEY `pkgId` (`pkgId`),
  ADD KEY `payId` (`payId`);

--
-- Indexes for table `new_connection`
--
ALTER TABLE `new_connection`
  ADD PRIMARY KEY (`connId`),
  ADD KEY `empId` (`empId`),
  ADD KEY `custId` (`custId`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`pkgId`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payId`),
  ADD KEY `custId` (`custId`);

--
-- Indexes for table `pkg_manage_co`
--
ALTER TABLE `pkg_manage_co`
  ADD KEY `pkgId` (`pkgId`),
  ADD KEY `empId` (`empId`);

--
-- Indexes for table `pkg_manage_cust`
--
ALTER TABLE `pkg_manage_cust`
  ADD KEY `pkgId` (`pkgId`),
  ADD KEY `custId` (`custId`);

--
-- Indexes for table `temp_cust`
--
ALTER TABLE `temp_cust`
  ADD PRIMARY KEY (`custId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cable_operator`
--
ALTER TABLE `cable_operator`
  MODIFY `empId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `complaintsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `custId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `new_connection`
--
ALTER TABLE `new_connection`
  MODIFY `connId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `pkgId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `temp_cust`
--
ALTER TABLE `temp_cust`
  MODIFY `custId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `area`
--
ALTER TABLE `area`
  ADD CONSTRAINT `area_ibfk_1` FOREIGN KEY (`empId`) REFERENCES `cable_operator` (`empId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `channels`
--
ALTER TABLE `channels`
  ADD CONSTRAINT `channels_ibfk_1` FOREIGN KEY (`pkgID`) REFERENCES `package` (`pkgId`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`custId`) REFERENCES `customer` (`custId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `complaints_ibfk_2` FOREIGN KEY (`empId`) REFERENCES `cable_operator` (`empId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`connId`) REFERENCES `new_connection` (`connId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `custompkgids`
--
ALTER TABLE `custompkgids`
  ADD CONSTRAINT `custompkgids_ibfk_1` FOREIGN KEY (`pkgId`) REFERENCES `package` (`pkgId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `includes`
--
ALTER TABLE `includes`
  ADD CONSTRAINT `includes_ibfk_1` FOREIGN KEY (`payId`) REFERENCES `payment` (`payId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `includes_ibfk_2` FOREIGN KEY (`pkgId`) REFERENCES `package` (`pkgId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `new_connection`
--
ALTER TABLE `new_connection`
  ADD CONSTRAINT `new_connection_ibfk_1` FOREIGN KEY (`empId`) REFERENCES `cable_operator` (`empId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `new_connection_ibfk_2` FOREIGN KEY (`custId`) REFERENCES `customer` (`custId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`custId`) REFERENCES `customer` (`custId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pkg_manage_co`
--
ALTER TABLE `pkg_manage_co`
  ADD CONSTRAINT `pkg_manage_co_ibfk_1` FOREIGN KEY (`empId`) REFERENCES `cable_operator` (`empId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pkg_manage_co_ibfk_2` FOREIGN KEY (`pkgId`) REFERENCES `package` (`pkgId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pkg_manage_cust`
--
ALTER TABLE `pkg_manage_cust`
  ADD CONSTRAINT `pkg_manage_cust_ibfk_1` FOREIGN KEY (`pkgId`) REFERENCES `package` (`pkgId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pkg_manage_cust_ibfk_2` FOREIGN KEY (`custId`) REFERENCES `customer` (`custId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
