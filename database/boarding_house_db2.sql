-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2020 at 07:07 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `house_rental_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--


-- --------------------------------------------------------

--
-- Table structure for table `houses`
--

CREATE TABLE `rooms` (
  `id` int(30) NOT NULL,
  `room_no` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `houses`
--

INSERT INTO `rooms` (`id`, `room_no`, `description`) VALUES
(1, '4','Sample');

-- --------------------------------------------------------
CREATE TABLE `images` (
  `id` int(30) NOT NULL,
  `BedName` varchar(50) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `uploaded_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `houses`
--

INSERT INTO `images` (`id`, `bedName`, `file_name`, `uploaded_on`) VALUES
(1, 'BD-001', 'images/BD-001.jpg', '2022-08-25 09:43:00');



CREATE TABLE `ptenants` (
  `id` int(30) NOT NULL,
  `fullame` varchar(100) NOT NULL,
  `bed_id` varchar(100) NOT NULL,
  `date_in` date NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `houses`
--

INSERT INTO `ptenants` (`id`, `fullname`, `bed_id`, `date_in`, `status`) VALUES
(1, 'Abegail Quirong', '2', '2022-08-25 09:43:00', 'pending');



CREATE TABLE `beds` (
  `id` int(30) NOT NULL,
  `bed_no` varchar(50) NOT NULL,
  `room_id` varchar(50) NOT NULL,
  `daily_rate` double NOT NULL,
  `monthly_rate` double NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT pending
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `beds`
--

INSERT INTO `beds` (`id`, `bed_no`, `room_id`, `daily_rate`, `monthly_rate`,  `status`) VALUES
(1, '8', '4', 50, 1500, 'occupied');
--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(30) NOT NULL,
  `tenant_id` int(30) NOT NULL,
  `InvoiceAmount` float NOT NULL,
  `amount` float NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `due_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `tenant_id`, `InvoiceAmount`, `amount`, `invoice`, `date_created`, `due_date`, `status`) VALUES
(1, 2, 2500, 0 'INVC-01', '2020-10-26 11:29:35', '2022-10-26 11:29:35', 'open'),


-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
(1, 'Boarding House Management System', 'info@sample.comm', '+6948 8542 623', '1603344720_1602738120_pngtree-purple-hd-business-banner-image_5493.jpg', '&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-weight: 400; text-align: justify;&quot;&gt;&amp;nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&rsquo;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` int(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `bed_id`  varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1= active, 0=inactive',
  `date_in` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `name`, `bed_id`, `status`, `date_in`) VALUES
(2, 'Smith, John C.', '1', 1, '2020-07-02');


CREATE TABLE `electricity_bill` (
  `id` int(30) NOT NULL,
  `ebill_amount` varchar(100) NOT NULL,
  `deu_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--

INSERT INTO `electricity_bill` (`id`, `ebill_amount`, `due_date`) VALUES
(2, '2000', '2020-07-02');



CREATE TABLE `water_bill` (
  `id` int(30) NOT NULL,
  `wbill_amount` varchar(100) NOT NULL,
  `deu_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--

INSERT INTO `water_bill` (`id`, `wbill_amount`, `due_date`) VALUES
(2, '2000', '2020-07-02');


CREATE TABLE `tenants_profile` (
  `id` int(30) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `gender` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `tenants_profile` (`id`, `firstname`, `middlename`, `lastname`, `email`, `contact`, `address`, `gender`) VALUES
(2, 'John', 'C', 'Smith', 'jsmith@sample.com', '+18456-5455-55', 'new born', 'male');


CREATE TABLE `prospective_tenants` (
  `id` int(30) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,


) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tenants`
--

INSERT INTO `prospective_tenants` (`id`, `fullname`, `email`, `contact`, `address`, `gender`, `username`, `password`) VALUES
(2, 'John C. Smith', 'jsmith@sample.com', '+18456-5455-55', 'new born', 'male', 'john123', 'hello123');

-- --------------------------------------------------------
--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1=Admin,2=Staff,3=Tenant,4=ProspectiveTenant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(1, 'Administrator', 'admin', '0192023a7bbd73250516f069df18b500', 1);



-- Indexes for table `houses`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `electricity_bill`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `water_bill`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ptenants`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `beds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `tenants_profile`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `prospective_tenants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--


--
-- AUTO_INCREMENT for table `houses`
--
ALTER TABLE `rooms`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `beds`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `images`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `electricity_bill`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `water_bill`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `ptenants`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

ALTER TABLE `tenants_profile`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `prospective_tenants`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
