-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2024 at 01:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `matttnt`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(6) UNSIGNED NOT NULL,
  `admin_username` varchar(30) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `category` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `check_in_date` date DEFAULT NULL,
  `check_out_date` date DEFAULT NULL,
  `nights` int(11) DEFAULT NULL,
  `rooms` int(11) DEFAULT NULL,
  `adults` int(11) DEFAULT NULL,
  `kids` int(11) DEFAULT NULL,
  `seniors` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `schedule` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'confirmed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Cancelled','Rebooked','Checked-in','Checked-out') NOT NULL DEFAULT 'Checked-in',
  `category` varchar(50) DEFAULT NULL,
  `paymentMethod` varchar(50) DEFAULT NULL,
  `paymentDetails` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `username`, `email`, `contact_number`, `total_price`, `booking_date`, `status`, `category`, `paymentMethod`, `paymentDetails`) VALUES
(6, 'Raiza Cruz', 'raizanilo11@gmail.com', '09565123683', 4200.00, '2024-10-02 09:49:59', 'Checked-in', NULL, NULL, NULL),
(29, 'Raiza Cruz', 'raizanilo11@gmail.com', '', 1400.00, '2024-10-03 06:34:49', 'Checked-out', NULL, NULL, NULL),
(30, 'Raiza Cruz', 'raizanilo11@gmail.com', '', 1400.00, '2024-10-03 08:13:01', 'Rebooked', NULL, NULL, NULL),
(31, 'client', 'client@gmail.com', '', 4200.00, '2024-10-03 09:25:08', 'Cancelled', NULL, NULL, NULL),
(32, 'client', 'client@gmail.com', '', 9000.00, '2024-10-03 09:26:28', 'Checked-out', NULL, NULL, NULL),
(33, 'Raiza Cruz', 'raizanilo11@gmail.com', '', 4200.00, '2024-10-03 10:30:24', 'Checked-out', NULL, NULL, NULL),
(34, 'Raiza Cruz', 'raizanilo11@gmail.com', '', 4200.00, '2024-10-03 10:31:02', 'Checked-in', NULL, NULL, NULL),
(35, 'Raiza Cruz', 'raizanilo11@gmail.com', '', 4200.00, '2024-10-03 10:44:33', 'Checked-in', NULL, NULL, NULL),
(36, 'Raiza Cruz', 'raizanilo11@gmail.com', '', 4200.00, '2024-10-03 10:45:34', 'Checked-in', NULL, NULL, NULL),
(37, 'Raiza Cruz', 'raizanilo11@gmail.com', '', 4200.00, '2024-10-04 10:17:36', 'Checked-in', NULL, NULL, NULL),
(38, 'Raiza Cruz', 'raizanilo11@gmail.com', '', 3900.00, '2024-10-04 13:25:33', 'Checked-in', NULL, NULL, NULL),
(39, 'Raiza Cruz', 'raizanilo11@gmail.com', '', 4200.00, '2024-10-04 13:26:32', 'Checked-in', NULL, NULL, NULL),
(40, 'Raiza Cruz', 'raizanilo11@gmail.com', '', 1400.00, '2024-10-04 13:58:40', 'Checked-in', NULL, NULL, NULL),
(41, 'Raiza Cruz', 'raizanilo11@gmail.com', '', 9800.00, '2024-10-07 02:56:35', 'Checked-in', NULL, NULL, NULL),
(42, 'Raiza Cruz', 'raizanilo11@gmail.com', '', 1400.00, '2024-10-07 03:38:38', 'Checked-in', NULL, NULL, NULL),
(43, 'Raiza Cruz', 'raizanilo11@gmail.com', '', 1400.00, '2024-10-07 04:04:07', 'Checked-in', NULL, NULL, NULL),
(44, 'Raiza Cruz', 'raizanilo11@gmail.com', '', 1400.00, '2024-10-07 04:11:06', 'Checked-in', NULL, NULL, NULL),
(45, 'Raiza Cruz', 'raizanilo11@gmail.com', '', 1400.00, '2024-10-07 04:12:32', 'Checked-in', NULL, NULL, NULL),
(46, 'Raiza Cruz', 'raizanilo11@gmail.com', '9565123863', 4900.00, '2024-10-07 07:26:21', 'Checked-in', NULL, NULL, NULL),
(47, 'Raiza Cruz', 'raizanilo11@gmail.com', '', 6940.00, '2024-10-07 07:29:17', 'Checked-in', NULL, NULL, NULL),
(48, 'Raiza Cruz', 'raizanilo11@gmail.com', '9565123863', 185453.00, '2024-10-07 07:53:19', 'Checked-in', NULL, NULL, NULL),
(49, 'Raiza Cruz', 'raizanilo11@gmail.com', '', 1400.00, '2024-10-31 11:01:55', 'Checked-in', NULL, NULL, NULL),
(50, 'Raiza Cruz', 'raizanilo11@gmail.com', '0956512863', 4200.00, '2024-11-01 02:27:05', 'Checked-in', NULL, NULL, NULL),
(51, 'Raiza Cruz', 'raizanilo11@gmail.com', '09565123863', 2800.00, '2024-11-01 02:28:08', 'Checked-in', NULL, NULL, NULL),
(52, 'Joselle', 'test@gmail.com', '09123456789', 4200.00, '2024-11-03 09:42:55', 'Checked-in', NULL, NULL, NULL),
(53, 'Joselle', 'test@gmail.com', '09565123863', 1400.00, '2024-11-03 09:59:03', 'Checked-in', NULL, NULL, NULL),
(54, 'Joselle', 'test@gmail.com', '', 2800.00, '2024-11-03 10:05:44', 'Checked-in', NULL, NULL, NULL),
(55, 'Joselle', 'test@gmail.com', '', 1400.00, '2024-11-03 10:30:49', 'Checked-in', NULL, NULL, NULL),
(56, 'Joselle', 'test@gmail.com', '', 1400.00, '2024-11-03 10:30:53', 'Checked-in', NULL, NULL, NULL),
(57, 'Joselle', 'test@gmail.com', '', 1950.00, '2024-11-03 10:32:29', 'Checked-in', NULL, NULL, NULL),
(58, 'Joselle', 'test@gmail.com', '', 3250.00, '2024-11-03 10:33:22', 'Checked-in', NULL, NULL, NULL),
(59, 'Joselle', 'test@gmail.com', '', 8400.00, '2024-11-03 10:34:03', 'Checked-in', NULL, NULL, NULL),
(60, 'Raiza Cruz', 'raizanilo11@gmail.com', '', 1400.00, '2024-11-04 22:04:20', 'Checked-in', NULL, NULL, NULL),
(61, 'Raiza Cruz', 'raizanilo11@gmail.com', '', 650.00, '2024-11-04 22:38:47', 'Checked-in', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `booking_items`
--

CREATE TABLE `booking_items` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `check_in_date` date DEFAULT NULL,
  `check_out_date` date DEFAULT NULL,
  `nights` int(11) DEFAULT NULL,
  `rooms` int(11) DEFAULT NULL,
  `adults` int(11) DEFAULT NULL,
  `kids` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cartitems`
--

CREATE TABLE `cartitems` (
  `cart_item_id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `check_in_date` date DEFAULT NULL,
  `check_out_date` date DEFAULT NULL,
  `nights` int(11) DEFAULT NULL,
  `rooms` int(11) DEFAULT NULL,
  `adults` int(11) DEFAULT NULL,
  `kids` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `schedule` varchar(255) DEFAULT NULL,
  `seniors` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ferry_tickets`
--

CREATE TABLE `ferry_tickets` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `route` varchar(255) NOT NULL,
  `schedule` text NOT NULL,
  `vessel` enum('Fast Craft','RORO') NOT NULL,
  `description` text NOT NULL,
  `travel_time` varchar(255) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tourist_adult_price` decimal(10,2) DEFAULT NULL,
  `tourist_senior_price` decimal(10,2) DEFAULT NULL,
  `tourist_kid_price` decimal(10,2) DEFAULT NULL,
  `tourist_toddler_price` decimal(10,2) DEFAULT NULL,
  `business_adult_price` decimal(10,2) DEFAULT NULL,
  `business_senior_price` decimal(10,2) DEFAULT NULL,
  `business_kid_price` decimal(10,2) DEFAULT NULL,
  `business_toddler_price` decimal(10,2) DEFAULT NULL,
  `economy_adult_price` decimal(10,2) DEFAULT NULL,
  `economy_senior_price` decimal(10,2) DEFAULT NULL,
  `economy_kid_price` decimal(10,2) DEFAULT NULL,
  `economy_toddler_price` decimal(10,2) DEFAULT NULL,
  `vip_adult_price` decimal(10,2) DEFAULT NULL,
  `vip_senior_price` decimal(10,2) DEFAULT NULL,
  `vip_kid_price` decimal(10,2) DEFAULT NULL,
  `vip_toddler_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ferry_tickets`
--

INSERT INTO `ferry_tickets` (`id`, `name`, `route`, `schedule`, `vessel`, `description`, `travel_time`, `image_url`, `created_at`, `updated_at`, `tourist_adult_price`, `tourist_senior_price`, `tourist_kid_price`, `tourist_toddler_price`, `business_adult_price`, `business_senior_price`, `business_kid_price`, `business_toddler_price`, `economy_adult_price`, `economy_senior_price`, `economy_kid_price`, `economy_toddler_price`, `vip_adult_price`, `vip_senior_price`, `vip_kid_price`, `vip_toddler_price`) VALUES
(6, 'Island Water ', 'Batangas - Puerto Galera', '7:00AM, 1:00PM', 'Fast Craft', 'M/V Island Calaguas', '1hr and 30mins', 'images/1727681992_calaguas.jpg', '2024-09-30 07:39:52', '2024-09-30 07:39:52', 670.00, 536.00, 335.00, 0.00, 900.00, 720.00, 450.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(7, 'Island Water ', 'Batangas - Puerto Galera', '11:00AM, 3:30PM', 'Fast Craft', 'M/V Island Panda 2', '1hr and 30mins', 'images/1727682250_pandan.jpg', '2024-09-30 07:44:10', '2024-09-30 07:44:10', 670.00, 536.00, 335.00, 0.00, 900.00, 720.00, 450.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(8, 'Island Water', 'Batangas - Puerto Galera', '10:00AM', 'RORO', 'M/V Simara', '2hrs', 'images/1727682395_simara.jpg', '2024-09-30 07:46:35', '2024-09-30 07:46:35', 670.00, 536.00, 335.00, 0.00, 900.00, 720.00, 450.00, 0.00, 550.00, 440.00, 275.00, 0.00, 1050.00, 840.00, 525.00, 0.00),
(9, 'Island Water', 'Puerto Galera - Batangas', '11:00AM, 3:00PM', 'Fast Craft', 'M/V Island Calaguas', '1hr and 30mins', 'images/1727682533_calaguas.jpg', '2024-09-30 07:48:53', '2024-09-30 07:48:53', 670.00, 536.00, 335.00, 0.00, 900.00, 720.00, 450.00, 0.00, 550.00, 440.00, 275.00, 0.00, 1050.00, 840.00, 525.00, 0.00),
(11, 'Island Water', 'Puerto Galera - Batangas', '11:00AM, 3:30PM', 'Fast Craft', 'M/V Island Water Pandan 2', '1hr and 30mins', 'images/1727682732_pandan.jpg', '2024-09-30 07:52:12', '2024-09-30 07:52:12', 670.00, 536.00, 335.00, 0.00, 900.00, 720.00, 450.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(12, 'Island Water', 'Puerto Galera - Batangas', '1:00PM', 'RORO', 'M/V Simara', '2hrs', 'images/1727682815_simara.jpg', '2024-09-30 07:53:35', '2024-09-30 07:53:35', 670.00, 536.00, 335.00, 0.00, 900.00, 720.00, 450.00, 0.00, 550.00, 440.00, 275.00, 0.00, 1050.00, 840.00, 525.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `fully_booked_dates`
--

CREATE TABLE `fully_booked_dates` (
  `id` int(11) NOT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `fully_booked_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fully_booked_dates`
--

INSERT INTO `fully_booked_dates` (`id`, `hotel_id`, `fully_booked_date`) VALUES
(1, 70, '2024-10-05'),
(2, 70, '2024-10-06'),
(3, 70, '2024-10-05'),
(4, 70, '2024-10-06'),
(5, 70, '2024-10-07'),
(6, 70, '2024-10-08');

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE `hotel` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price_2d1n_adult` decimal(10,2) NOT NULL,
  `price_2d1n_kid` decimal(10,2) NOT NULL,
  `price_3d2n_adult` decimal(10,2) NOT NULL,
  `price_3d2n_kid` decimal(10,2) NOT NULL,
  `price_4d3n_adult` decimal(10,2) NOT NULL,
  `price_4d3n_kid` decimal(10,2) NOT NULL,
  `capacity` enum('2 pax','3 pax','4 pax','5 pax','6 pax') NOT NULL,
  `inclusions` longtext DEFAULT NULL,
  `exclusions` text DEFAULT NULL,
  `policy` text DEFAULT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `description` text DEFAULT NULL,
  `fully_booked_dates` text DEFAULT NULL,
  `features` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `features` text DEFAULT NULL,
  `capacity` enum('2 pax','3 pax','4 pax','5 pax','6 pax') NOT NULL,
  `description` text DEFAULT NULL,
  `inclusions` longtext DEFAULT NULL,
  `exclusions` text DEFAULT NULL,
  `policy` text DEFAULT NULL,
  `fully_booked_dates` text DEFAULT NULL,
  `price_2d1n_adult` decimal(10,2) NOT NULL,
  `price_2d1n_kid` decimal(10,2) NOT NULL,
  `price_3d2n_adult` decimal(10,2) NOT NULL,
  `price_3d2n_kid` decimal(10,2) NOT NULL,
  `price_4d3n_adult` decimal(10,2) NOT NULL,
  `price_4d3n_kid` decimal(10,2) NOT NULL,
  `gallery_images` text DEFAULT NULL,
  `thumbnail_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `check_in`, `check_out`, `features`, `capacity`, `description`, `inclusions`, `exclusions`, `policy`, `fully_booked_dates`, `price_2d1n_adult`, `price_2d1n_kid`, `price_3d2n_adult`, `price_3d2n_kid`, `price_4d3n_adult`, `price_4d3n_kid`, `gallery_images`, `thumbnail_image`) VALUES
(48, 'Villa Monica Hotel', '13:00:00', '11:00:00', 'Free Wifi, Free Breakfast, Pet Friendly, Non Beachfront, With Kitchen, Double Sized Bed', '2 pax', 'Hotel Accommodation + Snorkeling Tour', 'Inclusions\r\nFREE Daily Filipino Breakfast with Coffee or Juice\r\n\r\nRoundtrip Hotel/Port Shuttle Service Balatero - Hotel - Balatero\r\n\r\nComplete Snorkeling Tour Activities: Coral Garden Snorkeling with Free Snorkeling Gear & Mask\r\n\r\nIncludes:\r\n\r\nUse of Small Boat for Coral Garden Snorkeling Experience\r\n\r\nThree Main Activities with Guide Banca:\r\n\r\nCoral Garden Snorkeling\r\n\r\nUnderwater Cave\r\n\r\nCentury Old Giant Clam Shell\r\n\r\nSightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nSwim & Snorkeling at Coral Garden\r\n\r\nPicture taking & sightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nAll Fees included (terminal & entrance fees)\r\n\r\nMuelle Bay Cultural & Heritage Park (One of the most beautiful bays in the world)\r\n\r\nYou’ll see:\r\n\r\nSpanish Galleon Life-size Replica\r\n\r\nMangrove Conservation Area\r\n\r\nCannon Replica\r\n\r\nPuerto Galera Yacht Club Moorings\r\n\r\nFood stalls & souvenir items\r\n\r\nShuttle Services During the Tour, Tour Guide/Driver, and Entrance Fees Included\r\n\r\nSouvenir: Puerto Galera T-shirt, Keychain & Unlimited Sandcastle Pictures\r\n\r\nTour Coordinator & Licensed Tour Guide\r\n\r\nTaxes and Service Charges\r\n\r\nTravel Itinerary & Requirements Assistance', 'BUS/FERRY TICKETS NOT INCLUDED\r\n\r\nAssistance with booking ferry tickets is available upon request.\r\n\r\nPort Terminal Fee & Environmental Fee\r\n\r\nPayable inside the port.', 'Deposit Requirements\r\n20% Down Payment: To confirm your reservation, a minimum deposit of 20% of the total cost is required. This can be paid through Gcash or Metrobank.\r\n\r\nBalance Payment: The remaining balance must be paid upon arrival at the hotel.\r\n\r\nNon-Refundable Deposits: Please note that deposits are non-refundable. However, they are transferable or rebookable, allowing flexibility in your travel plans.\r\n\r\nCancellation Policy\r\nRebooking: Reservations can be rebooked but are non-refundable. Changes to your reservation will depend on availability and any differences in the current rates will apply.\r\n\r\nCancellation Notice: To avoid forfeiting your deposit, cancellations must be made at least three (3) days prior to the scheduled date of arrival. Failing to cancel within this period will result in the full amount being deducted from your down payment.\r\n\r\nAdditional Notes\r\nPort Terminal Fee and Environmental Fee: These fees are payable directly at the port upon your arrival and are not included in the reservation cost.\r\n\r\nAssistance with Travel Arrangements: We can assist with booking ferry tickets and provide guidance on any travel requirements to ensure a smooth and enjoyable trip.\r\n\r\nCommon Kitchen: A common kitchen is available for use with an additional charge. This allows guests the convenience of preparing their meals while staying at the hotel.\r\n\r\nBy adhering to these policies, we aim to provide a seamless and satisfying experience for all our guests. Thank you for choosing Matt Destinations Travel and Tours for your travel needs. If you have any further questions or require assistance, please do not hesitate to contact us.', '', 2450.00, 1960.00, 3250.00, 2600.00, 4100.00, 2600.00, 'images/1727661362_0_2 pax(2).jpg,images/1727661362_1_2 pax.jpg,images/1727661362_2_common kitchen.jpg,images/1727661362_3_cr.jpg,images/1727661362_4_front.jpg,images/1727661362_5_kitchen2.jpg,images/1727661362_6_snorkeling (1).jpg,images/1727661362_7_snorkeling (2).jpg,images/1727661362_8_snorkeling (3).jpg,images/1727661362_9_snorkeling (4).jpg,images/1727661362_10_snorkeling (5).jpg', 'images/1727661362_thumbnail_2 pax(2).jpg'),
(49, 'Villa Monica Hotel', '13:00:00', '11:00:00', 'Free Wifi, Free Breakfast, Pet Friendly, Non Beachfront, With Kitchen, Double Sized Bed', '3 pax', 'Hotel Accommodation + Snorkeling Tour', 'Inclusions\r\nFREE Daily Filipino Breakfast with Coffee or Juice\r\n\r\nRoundtrip Hotel/Port Shuttle Service Balatero - Hotel - Balatero\r\n\r\nComplete Snorkeling Tour Activities: Coral Garden Snorkeling with Free Snorkeling Gear & Mask\r\n\r\nIncludes:\r\n\r\nUse of Small Boat for Coral Garden Snorkeling Experience\r\n\r\nThree Main Activities with Guide Banca:\r\n\r\nCoral Garden Snorkeling\r\n\r\nUnderwater Cave\r\n\r\nCentury Old Giant Clam Shell\r\n\r\nSightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nSwim & Snorkeling at Coral Garden\r\n\r\nPicture taking & sightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nAll Fees included (terminal & entrance fees)\r\n\r\nMuelle Bay Cultural & Heritage Park (One of the most beautiful bays in the world)\r\n\r\nYou’ll see:\r\n\r\nSpanish Galleon Life-size Replica\r\n\r\nMangrove Conservation Area\r\n\r\nCannon Replica\r\n\r\nPuerto Galera Yacht Club Moorings\r\n\r\nFood stalls & souvenir items\r\n\r\nShuttle Services During the Tour, Tour Guide/Driver, and Entrance Fees Included\r\n\r\nSouvenir: Puerto Galera T-shirt, Keychain & Unlimited Sandcastle Pictures\r\n\r\nTour Coordinator & Licensed Tour Guide\r\n\r\nTaxes and Service Charges\r\n\r\nTravel Itinerary & Requirements Assistance', 'BUS/FERRY TICKETS NOT INCLUDED\r\n\r\nAssistance with booking ferry tickets is available upon request.\r\n\r\nPort Terminal Fee & Environmental Fee\r\n\r\nPayable inside the port.', 'Deposit Requirements:\r\n\r\n20% Down Payment: To confirm your reservation, a minimum deposit of 20% of the total cost is required. This can be paid through Gcash or Metrobank.\r\n\r\nBalance Payment: The remaining balance must be paid upon arrival at the hotel.\r\n\r\nNon-Refundable Deposits: Please note that deposits are non-refundable. However, they are transferable or rebookable, allowing flexibility in your travel plans.\r\n\r\nCancellation Policy\r\nRebooking: Reservations can be rebooked but are non-refundable. Changes to your reservation will depend on availability and any differences in the current rates will apply.\r\n\r\nCancellation Notice: To avoid forfeiting your deposit, cancellations must be made at least three (3) days prior to the scheduled date of arrival. Failing to cancel within this period will result in the full amount being deducted from your down payment.\r\n\r\nAdditional Notes\r\nPort Terminal Fee and Environmental Fee: These fees are payable directly at the port upon your arrival and are not included in the reservation cost.\r\n\r\nAssistance with Travel Arrangements: We can assist with booking ferry tickets and provide guidance on any travel requirements to ensure a smooth and enjoyable trip.\r\n\r\nBy adhering to these policies, we aim to provide a seamless and satisfying experience for all our guests. Thank you for choosing Matt Destinations Travel and Tours for your travel needs. If you have any further questions or require assistance, please do not hesitate to contact us.', '', 2100.00, 1680.00, 2780.00, 2224.00, 3450.00, 2760.00, 'images/1727662182_0_4pax.jpg,images/1727662182_1_common kitchen.jpg,images/1727662182_2_cr.jpg,images/1727662182_3_front.jpg,images/1727662182_4_kitchen2.jpg,images/1727662182_5_snorkeling (1).jpg,images/1727662182_6_snorkeling (2).jpg,images/1727662182_7_snorkeling (3).jpg,images/1727662182_8_snorkeling (4).jpg,images/1727662182_9_snorkeling (5).jpg', 'images/1727662182_thumbnail_4pax.jpg'),
(50, 'Villa Monica Hotel', '13:00:00', '11:00:00', 'Free Wifi, Free Breakfast, Pet Friendly, Non Beachfront, With Kitchen, Double Sized Bed', '4 pax', 'Hotel Accommodation + Snorkeling Tour', 'Inclusions\r\nFREE Daily Filipino Breakfast with Coffee or Juice\r\n\r\nRoundtrip Hotel/Port Shuttle Service Balatero - Hotel - Balatero\r\n\r\nComplete Snorkeling Tour Activities: Coral Garden Snorkeling with Free Snorkeling Gear & Mask\r\n\r\nIncludes:\r\n\r\nUse of Small Boat for Coral Garden Snorkeling Experience\r\n\r\nThree Main Activities with Guide Banca:\r\n\r\nCoral Garden Snorkeling\r\n\r\nUnderwater Cave\r\n\r\nCentury Old Giant Clam Shell\r\n\r\nSightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nSwim & Snorkeling at Coral Garden\r\n\r\nPicture taking & sightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nAll Fees included (terminal & entrance fees)\r\n\r\nMuelle Bay Cultural & Heritage Park (One of the most beautiful bays in the world)\r\n\r\nYou’ll see:\r\n\r\nSpanish Galleon Life-size Replica\r\n\r\nMangrove Conservation Area\r\n\r\nCannon Replica\r\n\r\nPuerto Galera Yacht Club Moorings\r\n\r\nFood stalls & souvenir items\r\n\r\nShuttle Services During the Tour, Tour Guide/Driver, and Entrance Fees Included\r\n\r\nSouvenir: Puerto Galera T-shirt, Keychain & Unlimited Sandcastle Pictures\r\n\r\nTour Coordinator & Licensed Tour Guide\r\n\r\nTaxes and Service Charges\r\n\r\nTravel Itinerary & Requirements Assistance', 'BUS/FERRY TICKETS NOT INCLUDED\r\n\r\nAssistance with booking ferry tickets is available upon request.\r\n\r\nPort Terminal Fee & Environmental Fee\r\n\r\nPayable inside the port.', 'Deposit Requirements\r\n20% Down Payment: To confirm your reservation, a minimum deposit of 20% of the total cost is required. This can be paid through Gcash or Metrobank.\r\n\r\nBalance Payment: The remaining balance must be paid upon arrival at the hotel.\r\n\r\nNon-Refundable Deposits: Please note that deposits are non-refundable. However, they are transferable or rebookable, allowing flexibility in your travel plans.\r\n\r\nCancellation Policy\r\nRebooking: Reservations can be rebooked but are non-refundable. Changes to your reservation will depend on availability and any differences in the current rates will apply.\r\n\r\nCancellation Notice: To avoid forfeiting your deposit, cancellations must be made at least three (3) days prior to the scheduled date of arrival. Failing to cancel within this period will result in the full amount being deducted from your down payment.\r\n\r\nAdditional Notes\r\nPort Terminal Fee and Environmental Fee: These fees are payable directly at the port upon your arrival and are not included in the reservation cost.\r\n\r\nAssistance with Travel Arrangements: We can assist with booking ferry tickets and provide guidance on any travel requirements to ensure a smooth and enjoyable trip.\r\n\r\nCommon Kitchen: A common kitchen is available for use with an additional charge. This allows guests the convenience of preparing their meals while staying at the hotel.\r\n\r\nBy adhering to these policies, we aim to provide a seamless and satisfying experience for all our guests. Thank you for choosing Matt Destinations Travel and Tours for your travel needs. If you have any further questions or require assistance, please do not hesitate to contact us.', '', 1950.00, 1560.00, 2550.00, 2040.00, 3100.00, 2480.00, 'images/1727662674_0_4pax.jpg,images/1727662674_1_common kitchen.jpg,images/1727662674_2_cr.jpg,images/1727662674_3_front.jpg,images/1727662674_4_kitchen2.jpg,images/1727662674_5_snorkeling (1).jpg,images/1727662674_6_snorkeling (2).jpg,images/1727662674_7_snorkeling (3).jpg,images/1727662674_8_snorkeling (4).jpg,images/1727662674_9_snorkeling (5).jpg', 'images/1727662674_thumbnail_4pax.jpg'),
(51, 'Villa Monica Hotel', '13:00:00', '11:00:00', 'Free Wifi, Free Breakfast, Pet Friendly, Non Beachfront, With Kitchen, Double Sized Bed', '5 pax', 'Hotel Accommodation + Island Hopping Tour', 'FREE Daily Filipino Breakfast with Coffee or Juice\r\n\r\nRoundtrip Hotel/Port Shuttle Service Balatero - Hotel - Balatero\r\n\r\nIsland Hopping Tour with Free Snorkeling Gear & Mask\r\n\r\nIncludes:\r\n\r\nUse of Big Boat for Island Hopping Experience (Lahat ng beach pwede babaan 😍)\r\n\r\nThree Beach Destinations:\r\n\r\nHaligi Beach\r\n\r\nHeart (Agas) Beach\r\n\r\nLong Beach or Bukana Beach\r\n\r\nSwim & Snorkeling at the beach\r\n\r\nPicture taking & sightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nCoral Garden (Optional)\r\n\r\nAll Fees included (terminal & entrance fees)\r\n\r\nMuelle Bay Cultural & Heritage Park (One of the most beautiful bays in the world)\r\n\r\nYou’ll see:\r\n\r\nSpanish Galleon Life-size Replica\r\n\r\nMangrove Conservation Area\r\n\r\nCannon Replica\r\n\r\nPuerto Galera Yacht Club Moorings\r\n\r\nFood stalls & souvenir items\r\n\r\nShuttle Services During the Tour, Tour Guide/Driver, and Entrance Fees Included\r\n\r\nSouvenir: Puerto Galera T-shirt, Keychain & Unlimited Sandcastle Pictures\r\n\r\nTour Coordinator & Licensed Tour Guide\r\n\r\nTaxes and Service Charges\r\n\r\nTravel Itinerary & Requirements Assistance', 'BUS/FERRY TICKETS NOT INCLUDED\r\n\r\nAssistance with booking ferry tickets is available upon request.\r\n\r\nPort Terminal Fee & Environmental Fee\r\n\r\nPayable inside the port.', 'Deposit Requirements\r\n20% Down Payment: To confirm your reservation, a minimum deposit of 20% of the total cost is required. This can be paid through Gcash or Metrobank.\r\n\r\nBalance Payment: The remaining balance must be paid upon arrival at the hotel.\r\n\r\nNon-Refundable Deposits: Please note that deposits are non-refundable. However, they are transferable or rebookable, allowing flexibility in your travel plans.\r\n\r\nCancellation Policy\r\nRebooking: Reservations can be rebooked but are non-refundable. Changes to your reservation will depend on availability and any differences in the current rates will apply.\r\n\r\nCancellation Notice: To avoid forfeiting your deposit, cancellations must be made at least three (3) days prior to the scheduled date of arrival. Failing to cancel within this period will result in the full amount being deducted from your down payment.\r\n\r\nAdditional Notes\r\nPort Terminal Fee and Environmental Fee: These fees are payable directly at the port upon your arrival and are not included in the reservation cost.\r\n\r\nAssistance with Travel Arrangements: We can assist with booking ferry tickets and provide guidance on any travel requirements to ensure a smooth and enjoyable trip.\r\n\r\nCommon Kitchen: A common kitchen is available for use with an additional charge. This allows guests the convenience of preparing their meals while staying at the hotel.\r\n\r\nBy adhering to these policies, we aim to provide a seamless and satisfying experience for all our guests. Thank you for choosing Matt Destinations Travel and Tours for your travel needs. If you have any further questions or require assistance, please do not hesitate to contact us.', '', 1750.00, 1400.00, 2350.00, 1880.00, 2850.00, 2280.00, 'images/1727662947_0_5 pax.jpg,images/1727662947_1_common kitchen.jpg,images/1727662947_2_cr.jpg,images/1727662947_3_front.jpg,images/1727662947_4_hopping (1).jpg,images/1727662947_5_hopping (2).jpg,images/1727662947_6_hopping (3).jpg,images/1727662947_7_hopping (4).jpg,images/1727662947_8_hopping (5).jpg,images/1727662947_9_hopping (6).jpg,images/1727662947_10_hopping (7).jpg,images/1727662947_11_hopping (8).jpg,images/1727662947_12_hopping (9).jpg,images/1727662947_13_hopping (10).jpg,images/1727662947_14_hopping (11).jpg,images/1727662947_15_hopping (12).jpg,images/1727662947_16_hopping (13).jpg,images/1727662947_17_hopping (14).jpg,images/1727662947_18_hopping (15).jpg', 'images/1727662947_thumbnail_5 pax.jpg'),
(52, 'Villa Monica Hotel', '13:00:00', '11:00:00', 'Free Wifi, Free Breakfast, Pet Friendly, Non Beachfront, With Kitchen, Double Sized Bed', '6 pax', 'Hotel Accommodation + Island Hopping Activity', 'FREE Daily Filipino Breakfast with Coffee or Juice\r\n\r\nRoundtrip Hotel/Port Shuttle Service Balatero - Hotel - Balatero\r\n\r\nIsland Hopping Tour with Free Snorkeling Gear & Mask\r\n\r\nIncludes:\r\n\r\nUse of Big Boat for Island Hopping Experience (Lahat ng beach pwede babaan 😍)\r\n\r\nThree Beach Destinations:\r\n\r\nHaligi Beach\r\n\r\nHeart (Agas) Beach\r\n\r\nLong Beach or Bukana Beach\r\n\r\nSwim & Snorkeling at the beach\r\n\r\nPicture taking & sightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nCoral Garden (Optional)\r\n\r\nAll Fees included (terminal & entrance fees)\r\n\r\nMuelle Bay Cultural & Heritage Park (One of the most beautiful bays in the world)\r\n\r\nYou’ll see:\r\n\r\nSpanish Galleon Life-size Replica\r\n\r\nMangrove Conservation Area\r\n\r\nCannon Replica\r\n\r\nPuerto Galera Yacht Club Moorings\r\n\r\nFood stalls & souvenir items\r\n\r\nShuttle Services During the Tour, Tour Guide/Driver, and Entrance Fees Included\r\n\r\nSouvenir: Puerto Galera T-shirt, Keychain & Unlimited Sandcastle Pictures\r\n\r\nTour Coordinator & Licensed Tour Guide\r\n\r\nTaxes and Service Charges\r\n\r\nTravel Itinerary & Requirements Assistance', 'BUS/FERRY TICKETS NOT INCLUDED\r\n\r\nAssistance with booking ferry tickets is available upon request.\r\n\r\nPort Terminal Fee & Environmental Fee\r\n\r\nPayable inside the port.', 'Deposit Requirements\r\n20% Down Payment: To confirm your reservation, a minimum deposit of 20% of the total cost is required. This can be paid through Gcash or Metrobank.\r\n\r\nBalance Payment: The remaining balance must be paid upon arrival at the hotel.\r\n\r\nNon-Refundable Deposits: Please note that deposits are non-refundable. However, they are transferable or rebookable, allowing flexibility in your travel plans.\r\n\r\nCancellation Policy\r\nRebooking: Reservations can be rebooked but are non-refundable. Changes to your reservation will depend on availability and any differences in the current rates will apply.\r\n\r\nCancellation Notice: To avoid forfeiting your deposit, cancellations must be made at least three (3) days prior to the scheduled date of arrival. Failing to cancel within this period will result in the full amount being deducted from your down payment.\r\n\r\nAdditional Notes\r\nPort Terminal Fee and Environmental Fee: These fees are payable directly at the port upon your arrival and are not included in the reservation cost.\r\n\r\nAssistance with Travel Arrangements: We can assist with booking ferry tickets and provide guidance on any travel requirements to ensure a smooth and enjoyable trip.\r\n\r\nCommon Kitchen: A common kitchen is available for use with an additional charge. This allows guests the convenience of preparing their meals while staying at the hotel.\r\n\r\nBy adhering to these policies, we aim to provide a seamless and satisfying experience for all our guests. Thank you for choosing Matt Destinations Travel and Tours for your travel needs. If you have any further questions or require assistance, please do not hesitate to contact us.', '', 1650.00, 1320.00, 2250.00, 1824.00, 2850.00, 2280.00, 'images/1727663769_0_6 pax - Copy.jpg,images/1727663769_1_6-8pax - Copy.jpg,images/1727663769_2_common kitchen - Copy.jpg,images/1727663769_3_cr - Copy.jpg,images/1727663769_4_front - Copy.jpg,images/1727663769_5_hopping (1) - Copy.jpg,images/1727663769_6_hopping (2) - Copy.jpg,images/1727663769_7_hopping (3) - Copy.jpg,images/1727663769_8_hopping (4) - Copy.jpg,images/1727663769_9_hopping (5) - Copy.jpg,images/1727663769_10_hopping (6) - Copy.jpg,images/1727663769_11_hopping (7) - Copy.jpg,images/1727663769_12_hopping (8) - Copy.jpg,images/1727663769_13_hopping (9) - Copy.jpg,images/1727663769_14_hopping (10) - Copy.jpg,images/1727663769_15_hopping (11) - Copy.jpg,images/1727663769_16_hopping (12) - Copy.jpg', 'images/1727663768_thumbnail_6 pax.jpg'),
(53, 'White Beach Hotel', '13:00:00', '11:00:00', 'Free Wifi, Free Breakfast, Pet Friendly, Beachfront, With Grilling Area, Double Sized Bed', '2 pax', 'Hotel Accommodation + Snorkeling Activity', 'Inclusions\r\nFREE Daily Filipino Breakfast with Coffee or Juice\r\n\r\nRoundtrip Hotel/Port Shuttle Service Balatero - Hotel - Balatero\r\n\r\nComplete Snorkeling Tour Activities: Coral Garden Snorkeling with Free Snorkeling Gear & Mask\r\n\r\nIncludes:\r\n\r\nUse of Small Boat for Coral Garden Snorkeling Experience\r\n\r\nThree Main Activities with Guide Banca:\r\n\r\nCoral Garden Snorkeling\r\n\r\nUnderwater Cave\r\n\r\nCentury Old Giant Clam Shell\r\n\r\nSightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nSwim & Snorkeling at Coral Garden\r\n\r\nPicture taking & sightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nAll Fees included (terminal & entrance fees)\r\n\r\nMuelle Bay Cultural & Heritage Park (One of the most beautiful bays in the world)\r\n\r\nYou’ll see:\r\n\r\nSpanish Galleon Life-size Replica\r\n\r\nMangrove Conservation Area\r\n\r\nCannon Replica\r\n\r\nPuerto Galera Yacht Club Moorings\r\n\r\nFood stalls & souvenir items\r\n\r\nShuttle Services During the Tour, Tour Guide/Driver, and Entrance Fees Included\r\n\r\nSouvenir: Puerto Galera T-shirt, Keychain & Unlimited Sandcastle Pictures\r\n\r\nTour Coordinator & Licensed Tour Guide\r\n\r\nTaxes and Service Charges\r\n\r\nTravel Itinerary & Requirements Assistance', 'BUS/FERRY TICKETS NOT INCLUDED\r\n\r\nAssistance with booking ferry tickets is available upon request.\r\n\r\nPort Terminal Fee & Environmental Fee\r\n\r\nPayable inside the port.', 'Deposit Requirements\r\n20% Down Payment: To confirm your reservation, a minimum deposit of 20% of the total cost is required. This can be paid through Gcash or Metrobank.\r\n\r\nBalance Payment: The remaining balance must be paid upon arrival at the hotel.\r\n\r\nNon-Refundable Deposits: Please note that deposits are non-refundable. However, they are transferable or rebookable, allowing flexibility in your travel plans.\r\n\r\nCancellation Policy\r\nRebooking: Reservations can be rebooked but are non-refundable. Changes to your reservation will depend on availability and any differences in the current rates will apply.\r\n\r\nCancellation Notice: To avoid forfeiting your deposit, cancellations must be made at least three (3) days prior to the scheduled date of arrival. Failing to cancel within this period will result in the full amount being deducted from your down payment.\r\n\r\nAdditional Notes\r\nPort Terminal Fee and Environmental Fee: These fees are payable directly at the port upon your arrival and are not included in the reservation cost.\r\n\r\nAssistance with Travel Arrangements: We can assist with booking ferry tickets and provide guidance on any travel requirements to ensure a smooth and enjoyable trip.\r\n\r\nCommon Kitchen: A common kitchen is available for use with an additional charge. This allows guests the convenience of preparing their meals while staying at the hotel.\r\n\r\nBy adhering to these policies, we aim to provide a seamless and satisfying experience for all our guests. Thank you for choosing Matt Destinations Travel and Tours for your travel needs. If you have any further questions or require assistance, please do not hesitate to contact us.', '', 2650.00, 2120.00, 3680.00, 2944.00, 4750.00, 3800.00, 'images/1727664595_0_front.jpg,images/1727664595_1_front2.jpg,images/1727664595_2_hallway.jpg,images/1727664595_3_hallway2.jpg,images/1727664595_4_outside.jpg,images/1727664595_5_rooftop.jpg,images/1727664595_6_snorkeling (1).jpg,images/1727664595_7_snorkeling (2).jpg,images/1727664595_8_snorkeling (3).jpg,images/1727664595_9_snorkeling (4).jpg,images/1727664595_10_snorkeling (5).jpg', 'images/1727664595_thumbnail_couple.jpg'),
(56, 'White Beach Hotel', '13:00:00', '11:00:00', 'Free Wifi, Free Breakfast, Pet Friendly, Beachfront, With Grilling Area, Double Sized Bed', '3 pax', 'Hotel Accommodation + Snorkeling Tour', 'FREE Daily Filipino Breakfast with Coffee or Juice\r\n\r\nRoundtrip Hotel/Port Shuttle Service Balatero - Hotel - Balatero\r\n\r\nComplete Snorkeling Tour Activities: Coral Garden Snorkeling with Free Snorkeling Gear & Mask\r\n\r\nIncludes:\r\n\r\nUse of Small Boat for Coral Garden Snorkeling Experience\r\n\r\nThree Main Activities with Guide Banca:\r\n\r\nCoral Garden Snorkeling\r\n\r\nUnderwater Cave\r\n\r\nCentury Old Giant Clam Shell\r\n\r\nSightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nSwim & Snorkeling at Coral Garden\r\n\r\nPicture taking & sightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nAll Fees included (terminal & entrance fees)\r\n\r\nMuelle Bay Cultural & Heritage Park (One of the most beautiful bays in the world)\r\n\r\nYou’ll see:\r\n\r\nSpanish Galleon Life-size Replica\r\n\r\nMangrove Conservation Area\r\n\r\nCannon Replica\r\n\r\nPuerto Galera Yacht Club Moorings\r\n\r\nFood stalls & souvenir items\r\n\r\nShuttle Services During the Tour, Tour Guide/Driver, and Entrance Fees Included\r\n\r\nSouvenir: Puerto Galera T-shirt, Keychain & Unlimited Sandcastle Pictures\r\n\r\nTour Coordinator & Licensed Tour Guide\r\n\r\nTaxes and Service Charges\r\n\r\nTravel Itinerary & Requirements Assistance\r\n\r\n\r\n', 'BUS/FERRY TICKETS NOT INCLUDED\r\n\r\nAssistance with booking ferry tickets is available upon request.\r\n\r\nPort Terminal Fee & Environmental Fee\r\n\r\nPayable inside the port.\r\n', 'Deposit Requirements\r\n20% Down Payment: To confirm your reservation, a minimum deposit of 20% of the total cost is required. This can be paid through Gcash or Metrobank.\r\n\r\nBalance Payment: The remaining balance must be paid upon arrival at the hotel.\r\n\r\nNon-Refundable Deposits: Please note that deposits are non-refundable. However, they are transferable or rebookable, allowing flexibility in your travel plans.\r\n\r\nCancellation Policy\r\nRebooking: Reservations can be rebooked but are non-refundable. Changes to your reservation will depend on availability and any differences in the current rates will apply.\r\n\r\nCancellation Notice: To avoid forfeiting your deposit, cancellations must be made at least three (3) days prior to the scheduled date of arrival. Failing to cancel within this period will result in the full amount being deducted from your down payment.\r\n\r\nAdditional Notes\r\nPort Terminal Fee and Environmental Fee: These fees are payable directly at the port upon your arrival and are not included in the reservation cost.\r\n\r\nAssistance with Travel Arrangements: We can assist with booking ferry tickets and provide guidance on any travel requirements to ensure a smooth and enjoyable trip.\r\nBy adhering to these policies, we aim to provide a seamless and satisfying experience for all our guests. Thank you for choosing Matt Destinations Travel and Tours for your travel needs. If you have any further questions or require assistance, please do not hesitate to contact us.\r\n', '', 2280.00, 1824.00, 3150.00, 2520.00, 3950.00, 3160.00, 'images/1727675117_0_front.jpg,images/1727675117_1_front2.jpg,images/1727675117_2_hallway.jpg,images/1727675117_3_hallway2.jpg,images/1727675117_4_hallway3.jpg,images/1727675117_5_outside.jpg,images/1727675117_6_rooftop.jpg,images/1727675117_7_snorkeling (1).jpg,images/1727675117_8_snorkeling (2).jpg,images/1727675117_9_snorkeling (3).jpg,images/1727675117_10_snorkeling (4).jpg,images/1727675117_11_snorkeling (5).jpg', 'images/1727675117_thumbnail_3 pax.jpg'),
(58, 'White Beach Hotel', '13:00:00', '11:00:00', 'Free Wifi, Free Breakfast, Pet Friendly, Beachfront, With Grilling Area, Double Sized Bed', '4 pax', 'Hotel Accommodation + Snorkeling Tour', 'FREE Daily Filipino Breakfast with Coffee or Juice\r\n\r\nRoundtrip Hotel/Port Shuttle Service Balatero - Hotel - Balatero\r\n\r\nComplete Snorkeling Tour Activities: Coral Garden Snorkeling with Free Snorkeling Gear & Mask\r\n\r\nIncludes:\r\n\r\nUse of Small Boat for Coral Garden Snorkeling Experience\r\n\r\nThree Main Activities with Guide Banca:\r\n\r\nCoral Garden Snorkeling\r\n\r\nUnderwater Cave\r\n\r\nCentury Old Giant Clam Shell\r\n\r\nSightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nSwim & Snorkeling at Coral Garden\r\n\r\nPicture taking & sightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nAll Fees included (terminal & entrance fees)\r\n\r\nMuelle Bay Cultural & Heritage Park (One of the most beautiful bays in the world)\r\n\r\nYou’ll see:\r\n\r\nSpanish Galleon Life-size Replica\r\n\r\nMangrove Conservation Area\r\n\r\nCannon Replica\r\n\r\nPuerto Galera Yacht Club Moorings\r\n\r\nFood stalls & souvenir items\r\n\r\nShuttle Services During the Tour, Tour Guide/Driver, and Entrance Fees Included\r\n\r\nSouvenir: Puerto Galera T-shirt, Keychain & Unlimited Sandcastle Pictures\r\n\r\nTour Coordinator & Licensed Tour Guide\r\n\r\nTaxes and Service Charges\r\n\r\nTravel Itinerary & Requirements Assistance\r\n', 'BUS/FERRY TICKETS NOT INCLUDED\r\n\r\nAssistance with booking ferry tickets is available upon request.\r\n\r\nPort Terminal Fee & Environmental Fee\r\n\r\nPayable inside the port.\r\n\r\n\r\n', 'Deposit Requirements\r\n20% Down Payment: To confirm your reservation, a minimum deposit of 20% of the total cost is required. This can be paid through Gcash or Metrobank.\r\n\r\nBalance Payment: The remaining balance must be paid upon arrival at the hotel.\r\n\r\nNon-Refundable Deposits: Please note that deposits are non-refundable. However, they are transferable or rebookable, allowing flexibility in your travel plans.\r\n\r\nCancellation Policy\r\nRebooking: Reservations can be rebooked but are non-refundable. Changes to your reservation will depend on availability and any differences in the current rates will apply.\r\n\r\nCancellation Notice: To avoid forfeiting your deposit, cancellations must be made at least three (3) days prior to the scheduled date of arrival. Failing to cancel within this period will result in the full amount being deducted from your down payment.\r\n\r\nAdditional Notes\r\nPort Terminal Fee and Environmental Fee: These fees are payable directly at the port upon your arrival and are not included in the reservation cost.\r\n\r\nAssistance with Travel Arrangements: We can assist with booking ferry tickets and provide guidance on any travel requirements to ensure a smooth and enjoyable trip.\r\nBy adhering to these policies, we aim to provide a seamless and satisfying experience for all our guests. Thank you for choosing Matt Destinations Travel and Tours for your travel needs. If you have any further questions or require assistance, please do not hesitate to contact us.\r\n', '', 2100.00, 1680.00, 2850.00, 2280.00, 3680.00, 2944.00, 'images/1727676061_0_front.jpg,images/1727676061_1_front2.jpg,images/1727676061_2_hallway.jpg,images/1727676061_3_hallway2.jpg,images/1727676061_4_hallway3.jpg,images/1727676061_5_quad.jpg,images/1727676061_6_\'quad2.jpg,images/1727676061_7_quad3.jpg,images/1727676061_8_quad4.jpg,images/1727676061_9_rooftop.jpg,images/1727676061_10_snorkeling (1).jpg,images/1727676061_11_snorkeling (2).jpg,images/1727676061_12_snorkeling (3).jpg,images/1727676061_13_snorkeling (4).jpg,images/1727676061_14_snorkeling (5).jpg', 'images/1727676061_thumbnail_deluxe.jpg'),
(60, 'White Beach Hotel', '13:00:00', '11:00:00', 'Free Wifi, Free Breakfast, Pet Friendly, Beachfront, With Grilling Area, Double Sized Bed', '5 pax', 'Hotel Accommodation + Island Hopping Tour', 'FREE Daily Filipino Breakfast with Coffee or Juice\r\n\r\nRoundtrip Hotel/Port Shuttle Service Balatero - Hotel - Balatero\r\n\r\nIsland Hopping Tour with Free Snorkeling Gear & Mask\r\n\r\nIncludes:\r\n\r\nUse of Big Boat for Island Hopping Experience (Lahat ng beach pwede babaan 😍)\r\n\r\nThree Beach Destinations:\r\n\r\nHaligi Beach\r\n\r\nHeart (Agas) Beach\r\n\r\nLong Beach or Bukana Beach\r\n\r\nSwim & Snorkeling at the beach\r\n\r\nPicture taking & sightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nCoral Garden (Optional)\r\n\r\nAll Fees included (terminal & entrance fees)\r\n\r\nMuelle Bay Cultural & Heritage Park (One of the most beautiful bays in the world)\r\n\r\nYou’ll see:\r\n\r\nSpanish Galleon Life-size Replica\r\n\r\nMangrove Conservation Area\r\n\r\nCannon Replica\r\n\r\nPuerto Galera Yacht Club Moorings\r\n\r\nFood stalls & souvenir items\r\n\r\nShuttle Services During the Tour, Tour Guide/Driver, and Entrance Fees Included\r\n\r\nSouvenir: Puerto Galera T-shirt, Keychain & Unlimited Sandcastle Pictures\r\n\r\nTour Coordinator & Licensed Tour Guide\r\n\r\nTaxes and Service Charges\r\n\r\nTravel Itinerary & Requirements Assistance\r\n', 'BUS/FERRY TICKETS NOT INCLUDED\r\n\r\nAssistance with booking ferry tickets is available upon request.\r\n\r\nPort Terminal Fee & Environmental Fee\r\n\r\nPayable inside the port.\r\n', 'Deposit Requirements\r\n20% Down Payment: To confirm your reservation, a minimum deposit of 20% of the total cost is required. This can be paid through Gcash or Metrobank.\r\n\r\nBalance Payment: The remaining balance must be paid upon arrival at the hotel.\r\n\r\nNon-Refundable Deposits: Please note that deposits are non-refundable. However, they are transferable or rebookable, allowing flexibility in your travel plans.\r\n\r\nCancellation Policy\r\nRebooking: Reservations can be rebooked but are non-refundable. Changes to your reservation will depend on availability and any differences in the current rates will apply.\r\n\r\nCancellation Notice: To avoid forfeiting your deposit, cancellations must be made at least three (3) days prior to the scheduled date of arrival. Failing to cancel within this period will result in the full amount being deducted from your down payment.\r\n\r\nAdditional Notes\r\nPort Terminal Fee and Environmental Fee: These fees are payable directly at the port upon your arrival and are not included in the reservation cost.\r\n\r\nAssistance with Travel Arrangements: We can assist with booking ferry tickets and provide guidance on any travel requirements to ensure a smooth and enjoyable trip.\r\nBy adhering to these policies, we aim to provide a seamless and satisfying experience for all our guests. Thank you for choosing Matt Destinations Travel and Tours for your travel needs. If you have any further questions or require assistance, please do not hesitate to contact us.\r\n', '', 1890.00, 1512.00, 2650.00, 2120.00, 3380.00, 2704.00, 'images/1727676898_0_front.jpg,images/1727676898_1_front2.jpg,images/1727676898_2_hallway.jpg,images/1727676898_3_hallway2.jpg,images/1727676898_4_hallway3.jpg,images/1727676898_5_hopping (1).jpg,images/1727676898_6_hopping (2).jpg,images/1727676898_7_hopping (3).jpg,images/1727676898_8_hopping (4).jpg,images/1727676898_9_hopping (5).jpg,images/1727676898_10_hopping (6).jpg,images/1727676898_11_hopping (7).jpg,images/1727676898_12_hopping (8).jpg,images/1727676898_13_hopping (9).jpg,images/1727676898_14_hopping (10).jpg,images/1727676898_15_hopping (11).jpg,images/1727676898_16_hopping (12).jpg,images/1727676898_17_hopping (13).jpg,images/1727676898_18_hopping (14).jpg', 'images/1727676898_thumbnail_5 pax.jpg'),
(61, 'White Beach Hotel', '13:00:00', '11:00:00', 'Free Wifi, Free Breakfast, Pet Friendly, Beachfront, With Grilling Area, Double Sized Bed', '6 pax', 'Hotel Accommodation + Island Hopping Tour', 'FREE Daily Filipino Breakfast with Coffee or Juice\r\n\r\nRoundtrip Hotel/Port Shuttle Service Balatero - Hotel - Balatero\r\n\r\nIsland Hopping Tour with Free Snorkeling Gear & Mask\r\n\r\nIncludes:\r\n\r\nUse of Big Boat for Island Hopping Experience (Lahat ng beach pwede babaan 😍)\r\n\r\nThree Beach Destinations:\r\n\r\nHaligi Beach\r\n\r\nHeart (Agas) Beach\r\n\r\nLong Beach or Bukana Beach\r\n\r\nSwim & Snorkeling at the beach\r\n\r\nPicture taking & sightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nCoral Garden (Optional)\r\n\r\nAll Fees included (terminal & entrance fees)\r\n\r\nMuelle Bay Cultural & Heritage Park (One of the most beautiful bays in the world)\r\n\r\nYou’ll see:\r\n\r\nSpanish Galleon Life-size Replica\r\n\r\nMangrove Conservation Area\r\n\r\nCannon Replica\r\n\r\nPuerto Galera Yacht Club Moorings\r\n\r\nFood stalls & souvenir items\r\n\r\nShuttle Services During the Tour, Tour Guide/Driver, and Entrance Fees Included\r\n\r\nSouvenir: Puerto Galera T-shirt, Keychain & Unlimited Sandcastle Pictures\r\n\r\nTour Coordinator & Licensed Tour Guide\r\n\r\nTaxes and Service Charges\r\n\r\nTravel Itinerary & Requirements Assistance\r\n', 'BUS/FERRY TICKETS NOT INCLUDED\r\n\r\nAssistance with booking ferry tickets is available upon request.\r\n\r\nPort Terminal Fee & Environmental Fee\r\n\r\nPayable inside the port.\r\n', 'Deposit Requirements\r\n20% Down Payment: To confirm your reservation, a minimum deposit of 20% of the total cost is required. This can be paid through Gcash or Metrobank.\r\n\r\nBalance Payment: The remaining balance must be paid upon arrival at the hotel.\r\n\r\nNon-Refundable Deposits: Please note that deposits are non-refundable. However, they are transferable or rebookable, allowing flexibility in your travel plans.\r\n\r\nCancellation Policy\r\nRebooking: Reservations can be rebooked but are non-refundable. Changes to your reservation will depend on availability and any differences in the current rates will apply.\r\n\r\nCancellation Notice: To avoid forfeiting your deposit, cancellations must be made at least three (3) days prior to the scheduled date of arrival. Failing to cancel within this period will result in the full amount being deducted from your down payment.\r\n\r\nAdditional Notes\r\nPort Terminal Fee and Environmental Fee: These fees are payable directly at the port upon your arrival and are not included in the reservation cost.\r\n\r\nAssistance with Travel Arrangements: We can assist with booking ferry tickets and provide guidance on any travel requirements to ensure a smooth and enjoyable trip.\r\nBy adhering to these policies, we aim to provide a seamless and satisfying experience for all our guests. Thank you for choosing Matt Destinations Travel and Tours for your travel needs. If you have any further questions or require assistance, please do not hesitate to contact us.\r\n\r\n', '', 1780.00, 1424.00, 2550.00, 2040.00, 3380.00, 2704.00, 'images/1727677138_0_family.jpg,images/1727677138_1_front.jpg,images/1727677138_2_front2.jpg,images/1727677138_3_hallway.jpg,images/1727677138_4_hallway2.jpg,images/1727677138_5_hallway3.jpg,images/1727677138_6_hopping (1).jpg,images/1727677138_7_hopping (2).jpg,images/1727677138_8_hopping (3).jpg,images/1727677138_9_hopping (4).jpg,images/1727677138_10_hopping (5).jpg,images/1727677138_11_hopping (6).jpg,images/1727677138_12_hopping (7).jpg,images/1727677138_13_hopping (8).jpg,images/1727677138_14_hopping (9).jpg,images/1727677138_15_hopping (10).jpg,images/1727677138_16_hopping (11).jpg,images/1727677138_17_hopping (12).jpg,images/1727677138_18_hopping (13).jpg', 'images/1727677138_thumbnail_6pax.jpg'),
(62, 'The Mang-Yan Grand Hotel', '14:00:00', '11:00:00', 'Free Wifi, Free Breakfast, Swimming Pool, Non Beachfront, Non Smoking, Double Sized Bed', '2 pax', 'Hotel Accommodation + Snorkeling Tour', 'FREE Daily Filipino Breakfast with Coffee or Juice\r\n\r\nRoundtrip Hotel/Port Shuttle Service Balatero - Hotel - Balatero\r\n\r\nComplete Snorkeling Tour Activities: Coral Garden Snorkeling with Free Snorkeling Gear & Mask\r\n\r\nIncludes:\r\n\r\nUse of Small Boat for Coral Garden Snorkeling Experience\r\n\r\nThree Main Activities with Guide Banca:\r\n\r\nCoral Garden Snorkeling\r\n\r\nUnderwater Cave\r\n\r\nCentury Old Giant Clam Shell\r\n\r\nSightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nSwim & Snorkeling at Coral Garden\r\n\r\nPicture taking & sightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nAll Fees included (terminal & entrance fees)\r\n\r\nMuelle Bay Cultural & Heritage Park (One of the most beautiful bays in the world)\r\n\r\nYou’ll see:\r\n\r\nSpanish Galleon Life-size Replica\r\n\r\nMangrove Conservation Area\r\n\r\nCannon Replica\r\n\r\nPuerto Galera Yacht Club Moorings\r\n\r\nFood stalls & souvenir items\r\n\r\nShuttle Services During the Tour, Tour Guide/Driver, and Entrance Fees Included\r\n\r\nSouvenir: Puerto Galera T-shirt, Keychain & Unlimited Sandcastle Pictures\r\n\r\nTour Coordinator & Licensed Tour Guide\r\n\r\nTaxes and Service Charges\r\n\r\nTravel Itinerary & Requirements Assistance\r\n', 'BUS/FERRY TICKETS NOT INCLUDED\r\n\r\nAssistance with booking ferry tickets is available upon request.\r\n\r\nPort Terminal Fee & Environmental Fee\r\n\r\nPayable inside the port.\r\n', 'General Hotel Policies:\r\n\r\n1. Booking and Check-in/Check-out\r\nNo pencil booking.\r\nEarly check-in and late check-out: ₱200/room/hour.\r\n\"No EFP\" policy (likely refers to no extra food policy).\r\n\r\n2. Prohibited Actions and Fees\r\nNo electrical appliances (₱500 charge per appliance/day).\r\n\r\nNo smoking inside the room or hotel premises.\r\nBringing food and beverages incurs a corkage fee.\r\nDamage or missing items (₱1,000 charge for cleaning).\r\n\r\n3. Room Key and Security\r\nGuests must secure their room keys at the front desk when leaving.\r\nGuests cannot interfere with hotel equipment.\r\n\r\n4. Visitors and Non-Guests:\r\nVisitors are not allowed in guest rooms unless approved by the hotel.\r\nHotel not liable for loss of personal belongings.\r\n\r\n5. Swimming and Pool Area:\r\nNo swimming after 10 p.m.\r\nProper swimming attire required.\r\n\r\n6. Additional Charges:\r\nExtra person: ₱900/head/night (one extra person only).\r\n\r\n7. Room Extension and Stay Rules:\r\nCheck-out time: 12 p.m.\r\nThe hotel can remove guests’ belongings for late checkout without proper notice.\r\n\r\n8. Special Considerations:\r\nDiscounts for senior citizens and PWDs (Philippine law applies).\r\nDiscounts not applicable for online rates and promos.\r\n\r\n\r\n\r\n\r\nCancellation and Rebooking Policies\r\n1. No Refunds or Changes:\r\nNon-refundable, non-cancellable, and non-amendable booking policy.\r\nNo-show is considered a 100% charge.\r\n\r\n2. Rebooking Fees:\r\nRebooking requires 14 working days\' notice prior to arrival.\r\nRebooking fee: ₱500/room/night.\r\nValid for 3 months, subject to additional charges based on current rates.\r\n', '', 2950.00, 2360.00, 4550.00, 3640.00, 6150.00, 4920.00, 'images/1727678267_0_alobby.jpg,images/1727678267_1_apool 1.jpg,images/1727678267_2_apool.jpg,images/1727678267_3_cr (2).jpg,images/1727678267_4_cr.jpg,images/1727678267_5_front.jpg,images/1727678267_6_snorkeling (1).jpg,images/1727678267_7_snorkeling (2).jpg,images/1727678267_8_snorkeling (3).jpg,images/1727678267_9_snorkeling (4).jpg,images/1727678267_10_snorkeling (5).jpg', 'images/1727678267_thumbnail_couple room.jpg'),
(63, 'The Mang-Yan Grand Hotel', '14:00:00', '11:00:00', 'Free Wifi, Free Breakfast, Swimming Pool, Non Beachfront, Non Smoking, Double Sized Bed', '3 pax', 'Hotel Accommodation + Snorkeling Tour', 'FREE Daily Filipino Breakfast with Coffee or Juice\r\n\r\nRoundtrip Hotel/Port Shuttle Service Balatero - Hotel - Balatero\r\n\r\nComplete Snorkeling Tour Activities: Coral Garden Snorkeling with Free Snorkeling Gear & Mask\r\n\r\nIncludes:\r\n\r\nUse of Small Boat for Coral Garden Snorkeling Experience\r\n\r\nThree Main Activities with Guide Banca:\r\n\r\nCoral Garden Snorkeling\r\n\r\nUnderwater Cave\r\n\r\nCentury Old Giant Clam Shell\r\n\r\nSightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nSwim & Snorkeling at Coral Garden\r\n\r\nPicture taking & sightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nAll Fees included (terminal & entrance fees)\r\n\r\nMuelle Bay Cultural & Heritage Park (One of the most beautiful bays in the world)\r\n\r\nYou’ll see:\r\n\r\nSpanish Galleon Life-size Replica\r\n\r\nMangrove Conservation Area\r\n\r\nCannon Replica\r\n\r\nPuerto Galera Yacht Club Moorings\r\n\r\nFood stalls & souvenir items\r\n\r\nShuttle Services During the Tour, Tour Guide/Driver, and Entrance Fees Included\r\n\r\nSouvenir: Puerto Galera T-shirt, Keychain & Unlimited Sandcastle Pictures\r\n\r\nTour Coordinator & Licensed Tour Guide\r\n\r\nTaxes and Service Charges\r\n\r\nTravel Itinerary & Requirements Assistance\r\n', 'BUS/FERRY TICKETS NOT INCLUDED\r\n\r\nAssistance with booking ferry tickets is available upon request.\r\n\r\nPort Terminal Fee & Environmental Fee\r\n\r\nPayable inside the port.\r\n\r\n', 'BUS/FERRY TICKETS NOT INCLUDED\r\n\r\nAssistance with booking ferry tickets is available upon request.\r\n\r\nPort Terminal Fee & Environmental Fee\r\n\r\nPayable inside the port.\r\n\r\n', '', 2850.00, 2280.00, 4250.00, 3400.00, 5650.00, 4520.00, 'images/1727678674_0_3 pax.jpg,images/1727678674_1_alobby.jpg,images/1727678674_2_apool 1.jpg,images/1727678674_3_apool.jpg,images/1727678674_4_cr (2).jpg,images/1727678674_5_cr.jpg,images/1727678674_6_front.jpg,images/1727678674_7_snorkeling (1).jpg,images/1727678674_8_snorkeling (2).jpg,images/1727678674_9_snorkeling (3).jpg,images/1727678674_10_snorkeling (4).jpg,images/1727678674_11_snorkeling (5).jpg', 'images/1727678674_thumbnail_3 pax.jpg'),
(64, 'The Mang-Yan Grand Hotel', '14:00:00', '11:00:00', 'Free Wifi, Free Breakfast, Swimming Pool, Non Beachfront, Non Smoking, Double Sized Bed', '4 pax', 'Hotel Accommodation + Snorkeling Tour', 'FREE Daily Filipino Breakfast with Coffee or Juice\r\n\r\nRoundtrip Hotel/Port Shuttle Service Balatero - Hotel - Balatero\r\n\r\nComplete Snorkeling Tour Activities: Coral Garden Snorkeling with Free Snorkeling Gear & Mask\r\n\r\nIncludes:\r\n\r\nUse of Small Boat for Coral Garden Snorkeling Experience\r\n\r\nThree Main Activities with Guide Banca:\r\n\r\nCoral Garden Snorkeling\r\n\r\nUnderwater Cave\r\n\r\nCentury Old Giant Clam Shell\r\n\r\nSightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nSwim & Snorkeling at Coral Garden\r\n\r\nPicture taking & sightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nAll Fees included (terminal & entrance fees)\r\n\r\nMuelle Bay Cultural & Heritage Park (One of the most beautiful bays in the world)\r\n\r\nYou’ll see:\r\n\r\nSpanish Galleon Life-size Replica\r\n\r\nMangrove Conservation Area\r\n\r\nCannon Replica\r\n\r\nPuerto Galera Yacht Club Moorings\r\n\r\nFood stalls & souvenir items\r\n\r\nShuttle Services During the Tour, Tour Guide/Driver, and Entrance Fees Included\r\n\r\nSouvenir: Puerto Galera T-shirt, Keychain & Unlimited Sandcastle Pictures\r\n\r\nTour Coordinator & Licensed Tour Guide\r\n\r\nTaxes and Service Charges\r\n\r\nTravel Itinerary & Requirements Assistance\r\n\r\n', '\r\nBUS/FERRY TICKETS NOT INCLUDED\r\n\r\nAssistance with booking ferry tickets is available upon request.\r\n\r\nPort Terminal Fee & Environmental Fee\r\n\r\nPayable inside the port.\r\n', 'General Hotel Policies:\r\n\r\n1. Booking and Check-in/Check-out\r\nNo pencil booking.\r\nEarly check-in and late check-out: ₱200/room/hour.\r\n\"No EFP\" policy (likely refers to no extra food policy).\r\n\r\n2. Prohibited Actions and Fees\r\nNo electrical appliances (₱500 charge per appliance/day).\r\n\r\nNo smoking inside the room or hotel premises.\r\nBringing food and beverages incurs a corkage fee.\r\nDamage or missing items (₱1,000 charge for cleaning).\r\n\r\n3. Room Key and Security\r\nGuests must secure their room keys at the front desk when leaving.\r\nGuests cannot interfere with hotel equipment.\r\n\r\n4. Visitors and Non-Guests:\r\nVisitors are not allowed in guest rooms unless approved by the hotel.\r\nHotel not liable for loss of personal belongings.\r\n\r\n5. Swimming and Pool Area:\r\nNo swimming after 10 p.m.\r\nProper swimming attire required.\r\n\r\n6. Additional Charges:\r\nExtra person: ₱900/head/night (one extra person only).\r\n\r\n7. Room Extension and Stay Rules:\r\nCheck-out time: 12 p.m.\r\nThe hotel can remove guests’ belongings for late checkout without proper notice.\r\n\r\n8. Special Considerations:\r\nDiscounts for senior citizens and PWDs (Philippine law applies).\r\nDiscounts not applicable for online rates and promos.\r\n\r\n\r\n\r\n\r\nCancellation and Rebooking Policies\r\n1. No Refunds or Changes:\r\nNon-refundable, non-cancellable, and non-amendable booking policy.\r\nNo-show is considered a 100% charge.\r\n\r\n2. Rebooking Fees:\r\nRebooking requires 14 working days\' notice prior to arrival.\r\nRebooking fee: ₱500/room/night.\r\nValid for 3 months, subject to additional charges based on current rates.\r\n\r\n', '', 2550.00, 2040.00, 3750.00, 3000.00, 4900.00, 3920.00, 'images/1727678964_0_3 pax.jpg,images/1727678964_1_alobby.jpg,images/1727678964_2_apool 1.jpg,images/1727678964_3_apool.jpg,images/1727678964_4_couple room.jpg,images/1727678964_5_cr (2).jpg,images/1727678964_6_cr.jpg,images/1727678964_7_front.jpg,images/1727678964_8_snorkeling (1).jpg,images/1727678964_9_snorkeling (2).jpg,images/1727678964_10_snorkeling (3).jpg,images/1727678964_11_snorkeling (4).jpg,images/1727678964_12_snorkeling (5).jpg', 'images/1727678964_thumbnail_3 pax.jpg');
INSERT INTO `hotels` (`id`, `name`, `check_in`, `check_out`, `features`, `capacity`, `description`, `inclusions`, `exclusions`, `policy`, `fully_booked_dates`, `price_2d1n_adult`, `price_2d1n_kid`, `price_3d2n_adult`, `price_3d2n_kid`, `price_4d3n_adult`, `price_4d3n_kid`, `gallery_images`, `thumbnail_image`) VALUES
(66, 'The Mang-Yan Grand Hotel', '14:00:00', '11:00:00', 'Free Wifi, Free Breakfast, Swimming Pool, Non Beachfront, Non Smoking, Double Sized Bed', '6 pax', 'Hotel Accommodation + Island Hopping Tour', 'FREE Daily Filipino Breakfast with Coffee or Juice\r\n\r\nRoundtrip Hotel/Port Shuttle Service Balatero - Hotel - Balatero\r\n\r\nIsland Hopping Tour with Free Snorkeling Gear & Mask\r\n\r\nIncludes:\r\n\r\nUse of Big Boat for Island Hopping Experience (Lahat ng beach pwede babaan 😍)\r\n\r\nThree Beach Destinations:\r\n\r\nHaligi Beach\r\n\r\nHeart (Agas) Beach\r\n\r\nLong Beach or Bukana Beach\r\n\r\nSwim & Snorkeling at the beach\r\n\r\nPicture taking & sightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nCoral Garden (Optional)\r\n\r\nAll Fees included (terminal & entrance fees)\r\n\r\nMuelle Bay Cultural & Heritage Park (One of the most beautiful bays in the world)\r\n\r\nYou’ll see:\r\n\r\nSpanish Galleon Life-size Replica\r\n\r\nMangrove Conservation Area\r\n\r\nCannon Replica\r\n\r\nPuerto Galera Yacht Club Moorings\r\n\r\nFood stalls & souvenir items\r\n\r\nShuttle Services During the Tour, Tour Guide/Driver, and Entrance Fees Included\r\n\r\nSouvenir: Puerto Galera T-shirt, Keychain & Unlimited Sandcastle Pictures\r\n\r\nTour Coordinator & Licensed Tour Guide\r\n\r\nTaxes and Service Charges\r\n\r\nTravel Itinerary & Requirements Assistance\r\n', 'BUS/FERRY TICKETS NOT INCLUDED\r\n\r\nAssistance with booking ferry tickets is available upon request.\r\n\r\nPort Terminal Fee & Environmental Fee\r\n\r\nPayable inside the port.\r\n', 'BUS/FERRY TICKETS NOT INCLUDED\r\n\r\nAssistance with booking ferry tickets is available upon request.\r\n\r\nPort Terminal Fee & Environmental Fee\r\n\r\nPayable inside the port.\r\n', '', 2250.00, 1800.00, 3495.00, 2796.00, 3380.00, 2704.00, 'images/1727679626_0_alobby.jpg,images/1727679626_1_apool 1.jpg,images/1727679626_2_apool.jpg,images/1727679626_3_cr (2).jpg,images/1727679626_4_cr.jpg,images/1727679626_5_family.jpg,images/1727679626_6_front.jpg,images/1727679626_7_hopping (1).jpg,images/1727679626_8_hopping (2).jpg,images/1727679626_9_hopping (3).jpg,images/1727679626_10_hopping (4).jpg,images/1727679626_11_hopping (5).jpg,images/1727679626_12_hopping (6).jpg,images/1727679626_13_hopping (7).jpg,images/1727679626_14_hopping (8).jpg,images/1727679626_15_hopping (9).jpg,images/1727679626_16_hopping (10).jpg,images/1727679626_17_hopping (11).jpg,images/1727679626_18_hopping (12).jpg', 'images/1727679626_thumbnail_family.jpg'),
(67, 'The Mang-Yan Grand Hotel', '14:00:00', '11:00:00', 'Free Wifi, Free Breakfast, Swimming Pool, Non Beachfront, Non Smoking, Double Sized Bed', '5 pax', 'Hotel Accommodation + Island Hopping Tour', 'FREE Daily Filipino Breakfast with Coffee or Juice\r\n\r\nRoundtrip Hotel/Port Shuttle Service Balatero - Hotel - Balatero\r\n\r\nIsland Hopping Tour with Free Snorkeling Gear & Mask\r\n\r\nIncludes:\r\n\r\nUse of Big Boat for Island Hopping Experience (Lahat ng beach pwede babaan 😍)\r\n\r\nThree Beach Destinations:\r\n\r\nHaligi Beach\r\n\r\nHeart (Agas) Beach\r\n\r\nLong Beach or Bukana Beach\r\n\r\nSwim & Snorkeling at the beach\r\n\r\nPicture taking & sightseeing around beautiful beaches and sceneries in Puerto Galera\r\n\r\nCoral Garden (Optional)\r\n\r\nAll Fees included (terminal & entrance fees)\r\n\r\nMuelle Bay Cultural & Heritage Park (One of the most beautiful bays in the world)\r\n\r\nYou’ll see:\r\n\r\nSpanish Galleon Life-size Replica\r\n\r\nMangrove Conservation Area\r\n\r\nCannon Replica\r\n\r\nPuerto Galera Yacht Club Moorings\r\n\r\nFood stalls & souvenir items\r\n\r\nShuttle Services During the Tour, Tour Guide/Driver, and Entrance Fees Included\r\n\r\nSouvenir: Puerto Galera T-shirt, Keychain & Unlimited Sandcastle Pictures\r\n\r\nTour Coordinator & Licensed Tour Guide\r\n\r\nTaxes and Service Charges\r\n\r\nTravel Itinerary & Requirements Assistance\r\n', 'BUS/FERRY TICKETS NOT INCLUDED\r\n\r\nAssistance with booking ferry tickets is available upon request.\r\n\r\nPort Terminal Fee & Environmental Fee\r\n\r\nPayable inside the port.\r\n\r\n', 'General Hotel Policies:\r\n\r\n1. Booking and Check-in/Check-out\r\nNo pencil booking.\r\nEarly check-in and late check-out: ₱200/room/hour.\r\n\"No EFP\" policy (likely refers to no extra food policy).\r\n\r\n2. Prohibited Actions and Fees\r\nNo electrical appliances (₱500 charge per appliance/day).\r\n\r\nNo smoking inside the room or hotel premises.\r\nBringing food and beverages incurs a corkage fee.\r\nDamage or missing items (₱1,000 charge for cleaning).\r\n\r\n3. Room Key and Security\r\nGuests must secure their room keys at the front desk when leaving.\r\nGuests cannot interfere with hotel equipment.\r\n\r\n4. Visitors and Non-Guests:\r\nVisitors are not allowed in guest rooms unless approved by the hotel.\r\nHotel not liable for loss of personal belongings.\r\n\r\n5. Swimming and Pool Area:\r\nNo swimming after 10 p.m.\r\nProper swimming attire required.\r\n\r\n6. Additional Charges:\r\nExtra person: ₱900/head/night (one extra person only).\r\n\r\n7. Room Extension and Stay Rules:\r\nCheck-out time: 12 p.m.\r\nThe hotel can remove guests’ belongings for late checkout without proper notice.\r\n\r\n8. Special Considerations:\r\nDiscounts for senior citizens and PWDs (Philippine law applies).\r\nDiscounts not applicable for online rates and promos.\r\n\r\n\r\n\r\n\r\nCancellation and Rebooking Policies\r\n1. No Refunds or Changes:\r\nNon-refundable, non-cancellable, and non-amendable booking policy.\r\nNo-show is considered a 100% charge.\r\n\r\n2. Rebooking Fees:\r\nRebooking requires 14 working days\' notice prior to arrival.\r\nRebooking fee: ₱500/room/night.\r\nValid for 3 months, subject to additional charges based on current rates.\r\n', '', 2350.00, 1880.00, 3550.00, 2840.00, 3380.00, 2704.00, 'images/1727679889_0_alobby.jpg,images/1727679889_1_apool 1.jpg,images/1727679889_2_apool.jpg,images/1727679889_3_cr (2).jpg,images/1727679889_4_cr.jpg,images/1727679889_5_family.jpg,images/1727679889_6_front.jpg,images/1727679889_7_hopping (1).jpg,images/1727679889_8_hopping (2).jpg,images/1727679889_9_hopping (3).jpg,images/1727679889_10_hopping (4).jpg,images/1727679889_11_hopping (5).jpg,images/1727679889_12_hopping (6).jpg,images/1727679889_13_hopping (7).jpg,images/1727679889_14_hopping (8).jpg,images/1727679889_15_hopping (9).jpg,images/1727679889_16_hopping (10).jpg,images/1727679889_17_hopping (11).jpg,images/1727679889_18_hopping (12).jpg', 'images/1727679889_thumbnail_family.jpg'),
(70, 'Villa Monica Hotel', '20:48:00', '08:04:00', 'Free Wifi, Free Breakfast, Swimming Pool, Pet Friendly', '2 pax', 'rtyiuoio\'', 'tyiuoipo\'', 'tyuijokpl[;]', 'vbnimo', '', 184.00, 48484.00, 88484.00, 8485.00, 484.00, 8481.00, 'images/1728091435_0_vm11.jpg', 'images/1728091435_thumbnail_vm8.jpg'),
(71, 'Villa Monica Hotel', '15:23:00', '10:22:00', 'Free Wifi, Free Breakfast, Swimming Pool, Non Beachfront, Beachfront, With Kitchen, Double Sized Bed, Fully Airconditioned, With Television', '4 pax', 'dfghjkl', 'dfghujiko', 'yhjkl;', 'bhjkl', '', 6549.00, 4949.00, 99.00, 99.00, 994.00, 9798.00, 'images/1730791393_0_att.njHBGj9ly-B9xFE0jtwPweMb90FF2H1npg40DTjWijY.jpg,images/1730791393_1_att.ISbjTj_Np2J4HCglyUtHt25IsoLHG3nv45VHPdJGf0w.jpg', 'images/1730791393_thumbnail_att.lIlnyUG8UHrR4xeG23u7rSNmD8zkhSxeCUQQpxAepw8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_availability`
--

CREATE TABLE `hotel_availability` (
  `id` int(11) NOT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `fully_booked` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`id`, `name`, `price`, `description`, `image_url`) VALUES
(2, 'Barkada Boodle', 2800.00, 'Good for 10 persons.', 'images/66fa4f15339333.52363584.jpg'),
(3, 'Bilaong Bukid Boodle', 1400.00, 'Good for 4 persons.', 'images/66fa5185c28028.19821111.jpg'),
(4, 'Seafood Boodle', 4900.00, 'Good for 8 persons.', 'images/66fa51d56c7e53.70003280.jpg'),
(5, 'Mix Boodle', 4300.00, 'Good for 10 persons.', 'images/66fa5208de63b8.98958444.jpg'),
(6, 'Pinoy All Time Favorite Boodle', 1750.00, 'Good for 5 persons.', 'images/66fa5234599cc7.59220161.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `newbookings`
--

CREATE TABLE `newbookings` (
  `booking_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `down_payment` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `price_adult` decimal(10,2) DEFAULT NULL,
  `price_senior_pwd_student` decimal(10,2) DEFAULT NULL,
  `price_kid` decimal(10,2) DEFAULT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `hotel` varchar(255) DEFAULT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `inclusion` text DEFAULT NULL,
  `exclusion` text DEFAULT NULL,
  `policy` text DEFAULT NULL,
  `features` varchar(255) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `schedule` varchar(255) DEFAULT NULL,
  `vessel` varchar(255) DEFAULT NULL,
  `class` varchar(50) DEFAULT NULL,
  `capacity` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `price_adult`, `price_senior_pwd_student`, `price_kid`, `description`, `image_url`, `hotel`, `check_in`, `check_out`, `inclusion`, `exclusion`, `policy`, `features`, `route`, `schedule`, `vessel`, `class`, `capacity`) VALUES
(1, 'SKJDNJ', 'Hotel', 0.00, 1234.00, NULL, 1234.00, 'ANSKL', 'uploads/66e4ec1c233b88.51583240.jpg', '', '13:00:00', '11:00:00', NULL, NULL, NULL, 'Free Wi-Fi, Pet Friendly, Free Breakfast, Beachfront', NULL, NULL, NULL, NULL, '2 pax');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `review_text` text NOT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `sales_date` date DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `booking_id`, `total_price`, `sales_date`, `payment_method`) VALUES
(1, 29, 1400.00, '2024-10-03', 'Credit Card'),
(2, 6, 4200.00, '2024-10-02', 'Credit Card'),
(3, 30, 1400.00, '2024-10-03', 'GCash'),
(4, 32, 9000.00, '2024-10-03', 'GCash'),
(5, 31, 4200.00, '2024-10-03', 'GCash'),
(6, 33, 4200.00, '2024-10-03', 'GCash'),
(7, 34, 4200.00, '2024-10-03', 'GCash');

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tour_type` enum('Snorkeling','Island Hopping','Land Tour') NOT NULL,
  `price_adult` decimal(10,2) DEFAULT NULL,
  `price_kid` decimal(10,2) DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `itinerary` text DEFAULT NULL,
  `inclusion` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `thumbnail_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tours`
--

INSERT INTO `tours` (`id`, `name`, `tour_type`, `price_adult`, `price_kid`, `duration`, `itinerary`, `inclusion`, `description`, `thumbnail_image`) VALUES
(7, 'Tamaraw Falls', 'Land Tour', 650.00, 350.00, '4 to 5 hrs', ' 🚌 Tour Destinations \r\n 📍 Tamarraw Falls - 423 ft cascading waterfalls with Man-made swimming pool \r\n 📍 Puerto Galera Overview Deck\r\n 📍 Virgin Mary Beach Grotto \r\n 📍 Aplayang Munti Beach & Restaurant (Pax account)\r\n📍Town Proper (ATM & Shopping)\r\n📍 Acacia Promenade\r\n📍 Immaculate Parish Church\r\n📍 MUELLE BAY CULTURAL & HERITAGE PARK (One of the most beautiful bays in the world )\r\n𝐘𝐨𝐮\'𝐥𝐥 𝐬𝐞𝐞 📷: \r\n ⛵ Spanish Galleon Life-size Replica, \r\n 🪧 Mangrove Conservation area, \r\n 🚀 Cannon Replica, \r\n 🛥️ Puerto Galera Yacht Club Mourings\r\n 🍱 Food stalls & souviner shops   \r\n 📍 Extreme Adventure Sports Park (OWN Expense: ATV, GO Kart, Mud Cart, Cross Bow, Paintball)\r\n 📍 Tourguide/Driver, Transportation', NULL, 'PUERTO GALERA TAMARAW FALLS INLAND TOUR', 'images/1727946696_thumbnail_tamaraw.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` varchar(10) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `reg_date`, `role`) VALUES
(1, 'Joselle', '$2y$10$.AfVERHss12HQJvBQvElAOk647spxf5NA92vaDYBWjXFA0ik9qrjC', 'test@gmail.com', '2024-09-13 13:01:10', 'user'),
(2, 'yhesha', '$2y$10$.P16Ds9NpRO493HOmaTn6.DyU9btDOqq3vVzRDDlvAYOeMqaLBuKC', 'test2@gmail.com', '2024-09-13 13:23:24', 'admin'),
(3, 'jjjj', '$2y$10$FBlILPylrgHDiV94BOlRA.xZSzOTrJURNtZwCx6ulQ5zQYTR1ena6', 'j@gmail.com', '2024-09-13 13:20:22', 'user'),
(4, 'client', '$2y$10$ccp.EA50b5a0qLlUOxmAruIAWU2iyDH9UX0edlpfD6/1r2zO6cmC6', 'client@gmail.com', '2024-09-13 13:48:11', 'user'),
(5, 'Joselle Marie Laurio', '$2y$10$jfFY9W.Cp.gwvThYZ0aW0OKE5aF9aFO8jLaEJQJpo0TvWiGmHZ9p.', 'laurio195@gmail.com', '2024-09-26 03:37:11', 'user'),
(6, 'test1', '$2y$10$wG8W0UMllGoVxIh6Az/9mufJde8EgnG90mbQST.ig4hp6xCVZXyam', 'test@gmail.com', '2024-09-26 03:49:09', 'user'),
(7, 'Raiza Cruz', '$2y$10$PpR8ws.MPUUFn0J3LeF4VeuA5AbAWcFk9QtcHjb1yYWKuRpnV34iC', 'raizanilo11@gmail.com', '2024-09-27 05:58:01', 'user'),
(8, 'Joselle', '$2y$10$wxu2bGqmY7nLLdjq/KtGPOcbm0f86V7I5U1IbtB5BCj.PtUquUU2a', 'akosijoselle@gmail.com', '2024-11-03 09:41:49', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_items`
--
ALTER TABLE `booking_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `ferry_tickets`
--
ALTER TABLE `ferry_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fully_booked_dates`
--
ALTER TABLE `fully_booked_dates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotel_availability`
--
ALTER TABLE `hotel_availability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newbookings`
--
ALTER TABLE `newbookings`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
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
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `booking_items`
--
ALTER TABLE `booking_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cartitems`
--
ALTER TABLE `cartitems`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ferry_tickets`
--
ALTER TABLE `ferry_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `fully_booked_dates`
--
ALTER TABLE `fully_booked_dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hotel`
--
ALTER TABLE `hotel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `hotel_availability`
--
ALTER TABLE `hotel_availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `newbookings`
--
ALTER TABLE `newbookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_items`
--
ALTER TABLE `booking_items`
  ADD CONSTRAINT `booking_items_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD CONSTRAINT `cartitems_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `newbookings` (`booking_id`);

--
-- Constraints for table `fully_booked_dates`
--
ALTER TABLE `fully_booked_dates`
  ADD CONSTRAINT `fully_booked_dates_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hotel_availability`
--
ALTER TABLE `hotel_availability`
  ADD CONSTRAINT `hotel_availability_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
