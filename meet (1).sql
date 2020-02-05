-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2019 at 11:18 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `meet`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(255) NOT NULL,
  `ac_name` varchar(200) NOT NULL,
  `ac_number` int(255) NOT NULL,
  `b_name` varchar(200) NOT NULL,
  `type` varchar(200) NOT NULL,
  `balance` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `ac_name`, `ac_number`, `b_name`, `type`, `balance`) VALUES
(1, 'ipulb Account', 2147483647, 'gtb', 'Savings', 37666);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(255) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `bank_log`
--

CREATE TABLE `bank_log` (
  `id` int(255) NOT NULL,
  `title` varchar(200) NOT NULL,
  `by_user` varchar(200) NOT NULL,
  `type` varchar(200) NOT NULL,
  `amount` double NOT NULL,
  `account` varchar(255) NOT NULL,
  `date` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank_log`
--

INSERT INTO `bank_log` (`id`, `title`, `by_user`, `type`, `amount`, `account`, `date`) VALUES
(3, 'Bank Transfer', 'Chinaza', 'Income', 5666, 'ipulb Account', ''),
(6, '', '', 'Income', 2000, 'Cash', ''),
(7, '', '', 'Income', 3000, 'Cash', ''),
(8, '', '', 'Income', 3000, 'Cash', ''),
(9, 'Okechukwu Burial Levy', '', 'Income', 3000, 'Cash', ''),
(10, 'Okechukwu Burial Levy', ' ', 'Income', 3000, 'Cash', ''),
(11, 'Okechukwu Burial Levy 3', '', 'Income', 23456, 'Cash', ''),
(12, 'Okechukwu Burial Levy 3', '', 'Income', 23456, 'Cash', ''),
(13, 'Okechukwu Burial Levy 2', 'Chinazamekpere Chimbo', 'Income', 3000, 'Cash', ''),
(14, 'Okechukwu Burial Levy 2', 'Ifeanyichukwu Chimbo', 'Income', 3000, 'Cash', ''),
(16, 'Deposit', 'chi chi', 'Income', 444, 'ipulb Account', '30/Nov/2019'),
(17, 'Bank Withdrawal', 'chi chi', 'Expenditure', 444, 'ipulb Account', '30/Nov/2019');

-- --------------------------------------------------------

--
-- Table structure for table `cash`
--

CREATE TABLE `cash` (
  `id` int(255) NOT NULL,
  `title` varchar(200) NOT NULL,
  `by_user` varchar(200) NOT NULL,
  `amount` double NOT NULL,
  `date` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cash`
--

INSERT INTO `cash` (`id`, `title`, `by_user`, `amount`, `date`) VALUES
(1, 'Cash', 'Chinaza', 2000, '30/Nov/2019'),
(2, 'Cash', 'Chinaza', 20000, '30/Nov/2019'),
(3, 'Check', '4534534534234', 3000, '30/Nov/2019'),
(4, 'Cash4', 'Chinaza', 4000, '30/Nov/2019'),
(5, 'Check', '45645645', 3000, '30/Nov/2019'),
(6, 'Okechukwu Burial Levy 2', 'Ifeanyichukwu Chimbo', 3000, '30/Nov/2019'),
(7, 'Group A levy', 'Chinazamekpere Chimbo', 23456, '30/Nov/2019'),
(8, 'Group A levy', 'Ifeanyichukwu Chimbo', 23456, '30/Nov/2019');

-- --------------------------------------------------------

--
-- Table structure for table `cheque`
--

CREATE TABLE `cheque` (
  `id` int(255) NOT NULL,
  `by_user` varchar(200) NOT NULL,
  `check_no` int(255) NOT NULL,
  `amount` double NOT NULL,
  `date` varchar(60) NOT NULL,
  `bounced` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cheque`
--

INSERT INTO `cheque` (`id`, `by_user`, `check_no`, `amount`, `date`, `bounced`) VALUES
(1, 'Chinaza', 2147483647, 5000, '30/Nov/2019', 0),
(2, 'Chinaza', 2147483647, 3000, '30/Nov/2019', 0),
(3, 'Chinaza', 45645645, 3000, '30/Nov/2019', 0);

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(255) NOT NULL,
  `name` varchar(200) NOT NULL,
  `handled_by` varchar(200) NOT NULL,
  `amount` int(255) NOT NULL,
  `date` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`id`, `name`, `handled_by`, `amount`, `date`) VALUES
(1, 'Burial Levy', 'Mr Okonkwo', 5000, '23/Nov/2019');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(255) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'Group A'),
(2, 'Group B');

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `id` int(255) NOT NULL,
  `title` varchar(200) NOT NULL,
  `amount` int(255) NOT NULL,
  `date` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`id`, `title`, `amount`, `date`) VALUES
(1, 'Okechukwu Burial Levy payment by chinaza', 3000, '20/Nov/2019'),
(2, 'Okechukwu Burial Levy', 34345, '20/Nov/2019');

-- --------------------------------------------------------

--
-- Table structure for table `levy`
--

CREATE TABLE `levy` (
  `id` int(255) NOT NULL,
  `name` varchar(400) NOT NULL,
  `category` int(255) NOT NULL,
  `amount` int(255) NOT NULL,
  `member_id` int(255) NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `date` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `levy`
--

INSERT INTO `levy` (`id`, `name`, `category`, `amount`, `member_id`, `paid`, `date`) VALUES
(1, 'Old Debts', 1, 2000, 2, 1, '30/Nov/2019'),
(2, 'Okechukwu Burial Levy', 2, 3000, 1, 1, '30/Nov/2019'),
(3, 'Okechukwu Burial Levy', 2, 3000, 2, 1, '30/Nov/2019'),
(4, 'Okechukwu Burial Levy 2', 2, 3000, 1, 1, '30/Nov/2019'),
(5, 'Okechukwu Burial Levy 2', 2, 3000, 2, 1, '30/Nov/2019'),
(6, 'Hospital Levy', 3, 4000, 1, 1, '15/Nov/2019'),
(7, 'Hospital Levy', 3, 4000, 2, 1, '15/Nov/2019'),
(8, 'Chinaza Chimbo Levy', 3, 3000, 1, 1, '30/Nov/2019'),
(9, 'Chinaza Chimbo Levy', 3, 3000, 2, 1, '30/Nov/2019'),
(10, 'Chinaza Chimbo Levy', 2, 3000, 1, 1, '30/Nov/2019'),
(11, 'Chinaza Chimbo Levy', 2, 3000, 2, 1, '30/Nov/2019'),
(12, 'Chinaza Chimbo Levy', 2, 3000, 1, 1, '30/Nov/2019'),
(13, 'Chinaza Chimbo Levy', 2, 3000, 2, 1, '30/Nov/2019'),
(14, 'Okechukwu Burial Levy 3', 2, 23456, 1, 1, '30/Nov/2019'),
(15, 'Okechukwu Burial Levy 3', 2, 23456, 2, 1, '30/Nov/2019'),
(16, 'Group A levy', 3, 23456, 1, 1, '30/Nov/2019'),
(17, 'Group A levy', 3, 23456, 2, 1, '30/Nov/2019');

-- --------------------------------------------------------

--
-- Table structure for table `levy_categories`
--

CREATE TABLE `levy_categories` (
  `id` int(255) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `levy_categories`
--

INSERT INTO `levy_categories` (`id`, `name`) VALUES
(1, 'Old Debts'),
(2, 'Burial Levy'),
(3, 'Building Levy');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(255) NOT NULL,
  `title` varchar(60) NOT NULL,
  `fname` varchar(60) NOT NULL,
  `sname` varchar(60) NOT NULL,
  `oname` varchar(60) NOT NULL,
  `dob` varchar(60) NOT NULL,
  `marital_status` varchar(30) NOT NULL,
  `village` varchar(200) NOT NULL,
  `lagos_address` varchar(200) NOT NULL,
  `email` varchar(60) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `wa_number` varchar(12) NOT NULL,
  `challenge` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `yoe` varchar(60) NOT NULL,
  `group_no` int(255) NOT NULL,
  `mem_number` int(255) NOT NULL,
  `pro_pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `title`, `fname`, `sname`, `oname`, `dob`, `marital_status`, `village`, `lagos_address`, `email`, `phone`, `wa_number`, `challenge`, `username`, `password`, `yoe`, `group_no`, `mem_number`, `pro_pic`) VALUES
(1, 'Mr', 'Chinazamekpere', 'Chimbo', 'Nkemjika', '1994-06-22', 'Single', 'Ikwuano', 'No 4 Lagos Street', 'chinazachimbo@gmail.com', '07035483087', '07035483087', 'NONE', 'chinazachimbo', 'flashmaru', '2019', 1, 1, 'open-bible.jpg'),
(2, 'Mr', 'Ifeanyichukwu', 'Chimbo', 'Kenechukwu', '1995-11-11', 'Single', 'Ikwuano', 'No 4 dfgdfgdgkdfgdfdfkgdfgfj dfndfjg dfjg dfj', 'chinazachimbo@gmail.com', '07035483087', '07035483087', '', 'ifeanyichimbo', '12345', '2019', 1, 2, 'default.png'),
(3, 'Mr', 'Uchechukwu', 'Chimbo', 'Onyiyechi', '2019-11-07', 'Single', 'Ikwuano', '4 Egede Close New Haven Enugu', 'chinazachimbo@gmail.com', '07035483087', '07035483087', 'None', 'uchechimbo', '12345', '2019', 1, 3, 'Bro Uche2 20160830_135407.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `next_of_kin`
--

CREATE TABLE `next_of_kin` (
  `id` int(255) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `relationship` varchar(200) NOT NULL,
  `member_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `next_of_kin`
--

INSERT INTO `next_of_kin` (`id`, `name`, `address`, `phone`, `relationship`, `member_id`) VALUES
(1, 'Ikemba Ransom Chimbo', '4 Egede Close New Haven Enugu', '08033191874', 'Father', 1),
(2, 'Ikemba Ransom Chimbo', '4 Egede Close New Haven Enugu', '08033191874', 'Father', 2),
(3, 'Chinazamekpere Chimbo', '4 Egede Close New Haven Enugu', '07035483087', 'Father', 3);

-- --------------------------------------------------------

--
-- Table structure for table `print_log`
--

CREATE TABLE `print_log` (
  `id` int(255) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transfer`
--

CREATE TABLE `transfer` (
  `id` int(255) NOT NULL,
  `by_user` varchar(200) NOT NULL,
  `bank` int(255) NOT NULL,
  `amount` double NOT NULL,
  `date` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transfer`
--

INSERT INTO `transfer` (`id`, `by_user`, `bank`, `amount`, `date`) VALUES
(2, 'Chinaza', 1, 2000, '30/Nov/2019'),
(3, 'Chinaza', 1, 5666, '30/Nov/2019');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_log`
--
ALTER TABLE `bank_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash`
--
ALTER TABLE `cash`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cheque`
--
ALTER TABLE `cheque`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levy`
--
ALTER TABLE `levy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levy_categories`
--
ALTER TABLE `levy_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `next_of_kin`
--
ALTER TABLE `next_of_kin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `print_log`
--
ALTER TABLE `print_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer`
--
ALTER TABLE `transfer`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bank_log`
--
ALTER TABLE `bank_log`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `cash`
--
ALTER TABLE `cash`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cheque`
--
ALTER TABLE `cheque`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `levy`
--
ALTER TABLE `levy`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `levy_categories`
--
ALTER TABLE `levy_categories`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `next_of_kin`
--
ALTER TABLE `next_of_kin`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `print_log`
--
ALTER TABLE `print_log`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfer`
--
ALTER TABLE `transfer`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
