-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 13, 2021 at 08:36 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aseds`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_inf`
--

CREATE TABLE `admin_inf` (
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_inf`
--

INSERT INTO `admin_inf` (`name`, `email`, `password`) VALUES
('hassan el amrani \r\n', 'helamrani382@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `client_id` int(11) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `client_cname` varchar(100) NOT NULL,
  `client_email` varchar(100) NOT NULL,
  `client_phone` varchar(50) NOT NULL,
  `client_country` varchar(25) NOT NULL,
  `client_address` text NOT NULL,
  `client_city` varchar(100) NOT NULL,
  `client_state` varchar(100) NOT NULL,
  `client_zip` varchar(30) NOT NULL,
  `client_s_name` varchar(100) NOT NULL,
  `client_s_phone` varchar(50) NOT NULL,
  `client_s_country` varchar(25) NOT NULL,
  `client_s_address` text NOT NULL,
  `client_s_city` varchar(100) NOT NULL,
  `client_s_state` varchar(100) NOT NULL,
  `client_s_zip` varchar(30) NOT NULL,
  `client_password` varchar(100) NOT NULL,
  `client_token` varchar(255) NOT NULL,
  `client_datetime` varchar(100) NOT NULL,
  `client_timestamp` varchar(100) NOT NULL,
  `client_status` int(1) NOT NULL,
  `photo_name` varchar(255) NOT NULL DEFAULT 'default.jpeg',
  `description` varchar(500) NOT NULL DEFAULT 'A seller',
  `account_flag` int(1) DEFAULT '0',
  `amount` int(25) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`client_id`, `client_name`, `client_cname`, `client_email`, `client_phone`, `client_country`, `client_address`, `client_city`, `client_state`, `client_zip`, `client_s_name`, `client_s_phone`, `client_s_country`, `client_s_address`, `client_s_city`, `client_s_state`, `client_s_zip`, `client_password`, `client_token`, `client_datetime`, `client_timestamp`, `client_status`, `photo_name`, `description`, `account_flag`, `amount`) VALUES
(77, 'Elbatouri badr-eddine', 'ASEDS', 'elbatouri.b@gmail.com', '0524649803', 'Morocco', '46300 MARWEKOS', 'YOUSSOUFIA', 'YOUSSOUFIA', '46300', 'Elbatouri badr-eddine', '0524649803', 'Morocco', '46300 MARWEKOS', 'YOUSSOUFIA', 'YOUSSOUFIA', '46300', 'e10adc3949ba59abbe56e057f20f883e', '', '2021-02-13 05:04:47', '1613235887', 1, '77.jpeg', 'A seller', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `followed_id` int(20) NOT NULL,
  `following_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `images_table`
--

CREATE TABLE `images_table` (
  `p_id` int(10) NOT NULL,
  `images` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images_table`
--

INSERT INTO `images_table` (`p_id`, `images`) VALUES
(1, 'product_1_desc_photo_1'),
(2, 'product_2_desc_photo_1.jpeg'),
(3, 'product_3_desc_photo_1.jpeg'),
(4, 'product_4_desc_photo_1.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `option_id` int(11) NOT NULL,
  `option_name` text NOT NULL,
  `is_unified` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`option_id`, `option_name`, `is_unified`) VALUES
(1, 'ssd', 0);

-- --------------------------------------------------------

--
-- Table structure for table `option_values`
--

CREATE TABLE `option_values` (
  `option_values_id` int(11) NOT NULL,
  `value_id` int(11) NOT NULL,
  `value_name` varchar(255) NOT NULL,
  `option_added_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `option_values`
--

INSERT INTO `option_values` (`option_values_id`, `value_id`, `value_name`, `option_added_price`) VALUES
(1, 1, '256gb', 100),
(1, 2, '512gb', 250),
(1, 3, '1tb', 500),
(1, 4, '256gb', 100),
(1, 5, '512gb', 250),
(1, 6, '1tb', 500),
(1, 7, '256gb', 100),
(1, 8, '512gb', 250),
(1, 9, '1tb', 500),
(1, 10, '256gb', 100),
(1, 11, '512gb', 250),
(1, 12, '1tb', 500);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `payment_date` varchar(50) NOT NULL,
  `bank_transaction_info` text NOT NULL,
  `payment_method` varchar(20) NOT NULL DEFAULT 'Visa card',
  `payment_status` varchar(25) NOT NULL,
  `total_amount_paid` int(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `payment_id` int(30) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_buyed_quantity` int(100) NOT NULL,
  `product_chosen_options` text NOT NULL,
  `product_total_price` int(30) NOT NULL,
  `product_shipping_status` varchar(30) NOT NULL DEFAULT 'on traitemant',
  `seller_id` int(20) NOT NULL,
  `Shipping adresse` text NOT NULL,
  `payment_detail_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` varchar(10) NOT NULL,
  `product_qty` int(10) NOT NULL,
  `product_featured_photo` varchar(255) NOT NULL,
  `product_description` text NOT NULL,
  `product_slogan` text NOT NULL,
  `product_total_view` int(11) NOT NULL,
  `product_is_featured` int(1) NOT NULL,
  `product_is_active` int(1) NOT NULL,
  `ecat_id` int(11) NOT NULL,
  `product_seller_id` int(20) NOT NULL,
  `product_total_sells` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_price`, `product_qty`, `product_featured_photo`, `product_description`, `product_slogan`, `product_total_view`, `product_is_featured`, `product_is_active`, `ecat_id`, `product_seller_id`, `product_total_sells`) VALUES
(1, 'Lenovo legion y720', '15000', 30, 'product_1_principale_photo.jpeg', 'This is not just a pc, this is a gamer tool to become the best. Gaming is a craft and right tools are needed', 'Lenovo Is next  generation', 2, 0, 1, 105, 77, 0),
(2, 'Lenovo legion y720', '15000', 30, 'product_2_principale_photo.jpeg', 'This is not just a pc, this is a gamer tool to become the best. Gaming is a craft and right tools are needed', 'Lenovo Is next  generation', 4, 0, 1, 105, 77, 0),
(3, 'Lenovo legion y720', '15000', 30, 'product_3_principale_photo.jpeg', 'This is not just a pc, this is a gamer tool to become the best. Gaming is a craft and right tools are needed', 'Lenovo Is next  generation', 3, 0, 1, 105, 77, 0),
(4, 'Lenovo legion y720', '15000', 30, 'product_4_principale_photo.jpeg', 'This is not just a pc, this is a gamer tool to become the best. Gaming is a craft and right tools are needed', 'Lenovo Is next  generation', 0, 0, 1, 105, 77, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_options`
--

CREATE TABLE `product_options` (
  `product_option_values_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `option_value` int(11) NOT NULL,
  `is_unified` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_options`
--

INSERT INTO `product_options` (`product_option_values_id`, `option_id`, `option_value`, `is_unified`) VALUES
(1, 1, 1, 0),
(1, 1, 2, 0),
(1, 1, 3, 0),
(2, 1, 4, 0),
(2, 1, 5, 0),
(2, 1, 6, 0),
(3, 1, 7, 0),
(3, 1, 8, 0),
(3, 1, 9, 0),
(4, 1, 10, 0),
(4, 1, 11, 0),
(4, 1, 12, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(20) NOT NULL,
  `reported_item_id` int(20) NOT NULL,
  `reported_item_type` int(1) NOT NULL,
  `report_content` text NOT NULL,
  `reporte_date` date NOT NULL,
  `report_is_seen` int(11) NOT NULL DEFAULT '0',
  `reporter_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `seller_id` int(11) NOT NULL,
  `tag` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_end_category`
--

CREATE TABLE `tbl_end_category` (
  `ecat_id` int(11) NOT NULL,
  `ecat_name` varchar(255) NOT NULL,
  `mcat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_end_category`
--

INSERT INTO `tbl_end_category` (`ecat_id`, `ecat_name`, `mcat_id`) VALUES
(8, 'Watches', 4),
(9, 'Sunglasses', 4),
(12, 'Sandals', 6),
(13, 'Flat Shoes', 6),
(14, 'Hoodies', 7),
(15, 'Coats & Jackets', 7),
(17, 'Jeans', 8),
(20, 'T-shirts', 9),
(21, 'Casual Shirts', 9),
(22, 'Formal Shirts', 9),
(23, 'Polo Shirts', 9),
(24, 'Vests', 9),
(29, 'Girls', 11),
(31, 'Girls', 12),
(32, 'Dresses', 7),
(33, 'Tops', 7),
(34, 'T-Shirts & Vests', 7),
(35, 'Pants & Leggings', 7),
(36, 'Sportswear', 7),
(37, 'Plus Size Clothing', 7),
(38, 'Socks & Hosiery', 7),
(42, 'Jewellery', 4),
(47, 'Scarves & Headwear', 4),
(48, 'Multipacks', 4),
(49, 'Other Accessories', 4),
(50, 'Pumps', 6),
(51, 'Sneakers', 6),
(52, 'Sports Shoes', 6),
(53, 'Boots', 6),
(54, 'Comfort Shoes', 6),
(55, 'Slippers & Casual Shoes', 6),
(60, 'Bags', 4),
(102, '', 102),
(103, 'house decoration trees', 103),
(104, 'Hot jeans', 8),
(105, 'laptops', 104);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mid_category`
--

CREATE TABLE `tbl_mid_category` (
  `mcat_id` int(11) NOT NULL,
  `mcat_name` varchar(255) NOT NULL,
  `tcat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_mid_category`
--

INSERT INTO `tbl_mid_category` (`mcat_id`, `mcat_name`, `tcat_id`) VALUES
(4, 'Accessories', 12),
(6, 'Shoes', 2),
(7, 'Clothing', 2),
(8, 'Bottoms', 1),
(9, 'T-shirts & Shirts', 1),
(10, 'Clothing', 3),
(11, 'Shoes', 3),
(100, 'Accessories', 100),
(102, 'ORABORAS', 2),
(103, 'planets', 8),
(104, 'pc', 9);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_top_category`
--

CREATE TABLE `tbl_top_category` (
  `tcat_id` int(11) NOT NULL,
  `tcat_name` varchar(255) NOT NULL,
  `show_on_menu` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_top_category`
--

INSERT INTO `tbl_top_category` (`tcat_id`, `tcat_name`, `show_on_menu`) VALUES
(1, 'Entrtainement', 1),
(2, 'Clothing', 1),
(3, 'Music', 1),
(4, 'Fitness&Sport', 1),
(5, 'Pet&Animals', 1),
(6, 'Kitchen&Accessories', 1),
(7, 'HeavyEquipment', 1),
(8, 'GardenTools', 1),
(9, 'Electronics', 1),
(10, 'BabyCare', 1),
(11, 'Hygen&Skincare', 1),
(12, 'Medicals', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`payment_detail_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `tbl_end_category`
--
ALTER TABLE `tbl_end_category`
  ADD PRIMARY KEY (`ecat_id`);

--
-- Indexes for table `tbl_mid_category`
--
ALTER TABLE `tbl_mid_category`
  ADD PRIMARY KEY (`mcat_id`);

--
-- Indexes for table `tbl_top_category`
--
ALTER TABLE `tbl_top_category`
  ADD PRIMARY KEY (`tcat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `payment_detail_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_end_category`
--
ALTER TABLE `tbl_end_category`
  MODIFY `ecat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `tbl_mid_category`
--
ALTER TABLE `tbl_mid_category`
  MODIFY `mcat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `tbl_top_category`
--
ALTER TABLE `tbl_top_category`
  MODIFY `tcat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
