-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2019 at 04:18 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carrent`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ชื่อผู้ใช้',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'รหัสผ่าน',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ชื่อ - นามสกุล',
  `tel` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT 'เบอร์โทร'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ผู้ดูแลระบบ';

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ยี่ห้อ',
  `brand_logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'โลโก้'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ยี่ห้อ';

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brand_id`, `brand_name`, `brand_logo`) VALUES
(1, 'Toyota', '1562989184_toyota.png'),
(2, 'BMW', '1562988150_bmw.png'),
(3, 'Suzuki', '1562988195_suzuki.png'),
(4, 'Mazda', '1562988236_mazda.png'),
(5, 'Mercedes benz', '1562988263_mercedes-benz.png'),
(6, 'Honda', '1562988277_honda.png'),
(7, 'Chevrolet', '1562988291_chevrolet.png');

-- --------------------------------------------------------

--
-- Table structure for table `car`
--

CREATE TABLE `car` (
  `car_id` int(11) NOT NULL,
  `license` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ทะเบียนรถ',
  `color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'สี',
  `car_year` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ปีรถ',
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'รูปรถ',
  `cc` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ซีซี',
  `seat` int(11) DEFAULT NULL COMMENT 'จำนวนที่นั่ง',
  `model_id` int(11) NOT NULL COMMENT 'รุ่นรถ',
  `price` decimal(6,2) NOT NULL COMMENT 'ราคาต่อวัน',
  `member_id` int(11) NOT NULL COMMENT 'เจ้าของรถ',
  `status` int(11) DEFAULT NULL COMMENT 'เปิด/ปิด การใช้งาน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='รถยนต์';

--
-- Dumping data for table `car`
--

INSERT INTO `car` (`car_id`, `license`, `color`, `car_year`, `image`, `cc`, `seat`, `model_id`, `price`, `member_id`, `status`) VALUES
(1, 'ก 111', 'ดำ', '2015', '1563019649_2019-bmw-x1.jpg', '2500', 7, 1, '1200.00', 1, 1),
(2, 'ก 112', 'น้ำเงิน', '2018', '1563019665_x3_msport_phytonicblue_1920x1080.jpeg', '2000', 7, 4, '1000.00', 1, 1),
(3, 'ข 1111', 'ดำ', '2012', '1563024108_chevrolet_canada_chevrolet_cruze.jpg', '1600', 5, 7, '800.00', 1, 1),
(4, 'ค 1', 'บลอนด์ทอง', '2018', '1563024218_honda-accord-2018-all-new-01.png', '2200', 5, 8, '1000.00', 1, 1),
(5, 'ค 3', 'ขาว', '2017', '1563024590_maxresdefault.jpg', '1600', 5, 9, '700.00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `detail`
--

CREATE TABLE `detail` (
  `detail_id` int(11) NOT NULL,
  `rent_id` int(11) NOT NULL COMMENT 'ใบยืม',
  `car_id` int(11) NOT NULL COMMENT 'รถยนต์',
  `price_unit` decimal(10,2) DEFAULT NULL COMMENT 'ราคาต่อวัน',
  `price_total` decimal(10,2) DEFAULT NULL COMMENT 'ราคารวม',
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่ยืม'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='รายการการยืม';

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ชื่อ - นามสกุล',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '''อีเมล',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'รหัสผ่าน',
  `tel` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT 'เบอร์โทร',
  `address` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'ที่อยู่',
  `province` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'จังหวัด',
  `zipcode` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'รหัสไปรษณีย์',
  `regsiter_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่สมัคร',
  `status` int(11) DEFAULT '1' COMMENT 'สถานะ {0: ปิดใช้งาน, 1: เปิดใช้งาน}'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='สมาชิก';

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `name`, `email`, `password`, `tel`, `address`, `province`, `zipcode`, `regsiter_date`, `status`) VALUES
(1, 'คณาพล อมรรัตนเกศ', 'kanaphol.a@gmail.com', '1234', '+66844726400', 'มหาวิทยาลัย', 'นครราชสีมา', '30000', '2019-07-12 17:51:38', 0);

-- --------------------------------------------------------

--
-- Table structure for table `model`
--

CREATE TABLE `model` (
  `model_id` int(11) NOT NULL,
  `model_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ชื่อรุ่น',
  `model_logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'โลโก้',
  `brand_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='รุ่น';

--
-- Dumping data for table `model`
--

INSERT INTO `model` (`model_id`, `model_name`, `model_logo`, `brand_id`) VALUES
(1, '‎BMW X1', '', 2),
(2, 'BMW X5', '', 2),
(3, 'BMW X7', '', 2),
(4, 'BMW X3', '', 2),
(5, 'Trailblazer', '', 7),
(6, 'Colorado', '', 7),
(7, 'Cruze', '', 7),
(8, 'Accord', '', 6),
(9, 'City', '', 6),
(10, 'Civic', '', 6),
(11, 'CR-V', '', 6),
(12, 'Brio', '', 6),
(13, 'Mazda 3', '', 4),
(14, 'Mazda 2', '', 4),
(15, 'Mazda 6', '', 4),
(16, 'MX-5', '', 4),
(17, 'C-Class Coupe', '', 5),
(18, 'CLA-Class', '', 5),
(19, 'A-Class', '', 5),
(20, 'B-Class', '', 5),
(21, 'C-Class Estate', '', 5),
(22, 'Swift', '', 3),
(23, 'Celerio', '', 3),
(24, 'Ciaz', '', 3),
(25, 'Ertiga', '', 3),
(26, 'Carry', '', 3),
(27, 'Camry', '', 1),
(28, 'C-HR', '', 1),
(29, 'Fortuner', '', 1),
(30, 'Altis', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rent`
--

CREATE TABLE `rent` (
  `rent_id` int(11) NOT NULL,
  `rent_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่ยืม',
  `start_date` timestamp NULL DEFAULT NULL COMMENT 'วันแรกที่ยืม',
  `end_date` timestamp NULL DEFAULT NULL COMMENT 'วันสุดท้าย',
  `total_price` decimal(10,2) DEFAULT NULL COMMENT 'ราคารวม',
  `status` int(11) DEFAULT NULL COMMENT 'สถานะการยืม',
  `slipt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'หลักฐานการชำระเงิน',
  `slipt_date` timestamp NULL DEFAULT NULL COMMENT 'วันที่แนบหลักฐานการชำระเงิน',
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ใบยืม';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`car_id`),
  ADD UNIQUE KEY `license_UNIQUE` (`license`),
  ADD KEY `fk_car_model1_idx` (`model_id`),
  ADD KEY `fk_car_member1_idx` (`member_id`);

--
-- Indexes for table `detail`
--
ALTER TABLE `detail`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `fk_detail_rent1_idx` (`rent_id`),
  ADD KEY `fk_detail_car1_idx` (`car_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indexes for table `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`model_id`),
  ADD KEY `fk_model_brand_idx` (`brand_id`);

--
-- Indexes for table `rent`
--
ALTER TABLE `rent`
  ADD PRIMARY KEY (`rent_id`),
  ADD KEY `fk_rent_member1_idx` (`member_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `car`
--
ALTER TABLE `car`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `detail`
--
ALTER TABLE `detail`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `model`
--
ALTER TABLE `model`
  MODIFY `model_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `rent`
--
ALTER TABLE `rent`
  MODIFY `rent_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `car`
--
ALTER TABLE `car`
  ADD CONSTRAINT `fk_car_member1` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_car_model1` FOREIGN KEY (`model_id`) REFERENCES `model` (`model_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `detail`
--
ALTER TABLE `detail`
  ADD CONSTRAINT `fk_detail_car1` FOREIGN KEY (`car_id`) REFERENCES `car` (`car_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detail_rent1` FOREIGN KEY (`rent_id`) REFERENCES `rent` (`rent_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `model`
--
ALTER TABLE `model`
  ADD CONSTRAINT `fk_model_brand` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`brand_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rent`
--
ALTER TABLE `rent`
  ADD CONSTRAINT `fk_rent_member1` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
