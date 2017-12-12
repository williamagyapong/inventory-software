-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2017 at 05:36 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `napol_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `quantity` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `unit` varchar(32) NOT NULL,
  `date_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='stock of materials';

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `name`, `quantity`, `unit`, `date_added`) VALUES
(1, 'Iron rods', 1000, '', '0000-00-00'),
(2, 'Roofing sheets', 674, 'pieces', '0000-00-00'),
(3, 'cement', 1000, 'bags', '0000-00-00'),
(4, 'sand', 215, '', '0000-00-00'),
(6, 'gravels', 100, 'trips', '0000-00-00'),
(7, 'wood', 0, '', '0000-00-00'),
(8, 'shoes', 0, '', '0000-00-00'),
(9, 'shovels', 0, '', '0000-00-00'),
(11, 'wall tiles', 0, '', '0000-00-00'),
(13, 'sandcrete', 0, '', '0000-00-00'),
(15, 'plywood', 0, '', '0000-00-00'),
(16, 'Door frame', 50, '', '2017-09-21'),
(17, 'tank', 0, '', '2017-11-21'),
(24, 'this material', 0, '', '2017-11-24'),
(25, 'new one', 400, 'new unit', '2017-11-24'),
(26, 'aSDFG', 0, 'SASA', '2017-11-24'),
(27, 'matatata', 123, 'this unit', '2017-11-24'),
(28, 'wertrturt', 60, 'true', '2017-11-24'),
(29, 'my my', 60, 'true', '2017-11-24'),
(30, 'asdfdgfhg', 60, '1234', '2017-11-24'),
(31, 'aaaa', 1000, 'uuuu', '2017-11-24'),
(32, 'kkkkkkk', 134, 'ddd', '2017-11-24'),
(33, 'ttttttt', 56, 'ssss', '2017-11-24'),
(34, 'asdad', 0, 'assdfdas', '2017-11-28'),
(35, 'wqreww', 0, 'awaw', '2017-12-02');

-- --------------------------------------------------------

--
-- Table structure for table `material_flow`
--

CREATE TABLE `material_flow` (
  `id` int(10) UNSIGNED NOT NULL,
  `material_id` int(11) NOT NULL,
  `quantity_received` int(11) NOT NULL,
  `quantity_sent` int(11) NOT NULL,
  `flow_date` date NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `receiving_dept` varchar(100) NOT NULL,
  `receiving_officer` text NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material_flow`
--

INSERT INTO `material_flow` (`id`, `material_id`, `quantity_received`, `quantity_sent`, `flow_date`, `purpose`, `receiving_dept`, `receiving_officer`, `project_id`) VALUES
(1, 2, 50, 0, '2017-09-20', '', '', '', 0),
(2, 1, 50, 0, '2017-09-20', '', '', '', 0),
(3, 2, 12, 0, '2017-09-21', '', '', '', 0),
(4, 4, 15, 0, '2017-09-21', '', '', '', 0),
(5, 1, 0, 20, '2017-09-22', 'For construction of project', 'Materials Department', '{\"name\":\"William Amanor\",\"position\":\"Project Supervisor\"}', 6),
(6, 2, 0, 30, '2017-09-22', 'For construction of project', 'Materials Department', '{\"name\":\"William Amanor\",\"position\":\"Project Supervisor\"}', 6),
(7, 2, 12, 0, '2017-12-02', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `material_returns`
--

CREATE TABLE `material_returns` (
  `id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `material_id` int(11) NOT NULL,
  `inwards_quantity` int(11) NOT NULL DEFAULT '0',
  `outwards_quantity` int(11) NOT NULL DEFAULT '0',
  `narration` int(11) NOT NULL,
  `event_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `date_begun` date NOT NULL,
  `date_completion` date NOT NULL,
  `company_in_charge` varchar(100) NOT NULL,
  `project_manager` text NOT NULL,
  `stores_admin` text NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT '0',
  `bill_status` varchar(10) NOT NULL DEFAULT 'none',
  `d_notes` text NOT NULL,
  `date_registered` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `location`, `date_begun`, `date_completion`, `company_in_charge`, `project_manager`, `stores_admin`, `status`, `bill_status`, `d_notes`, `date_registered`) VALUES
(1, 'Odorna Bridge', 'Bridge over the odorna lagoon', 'Accra', '2017-09-16', '2018-04-26', 'Geroz Construction', '{\"name\":\"Daniel Asiamah\",\"phone\":\"0343434343\"}', '{\"name\":\"Isaac Boakye\",\"phone\":\"0121313212\"}', '0', 'none', '', '2017-08-08'),
(2, 'A lecture theatre for the department of Agric science, KNUST', 'Five storey lecture theatre', 'KNUST', '2017-06-05', '2018-03-21', 'Nadaco construction Limited', '{\"name\":\"Agyemang Prempeh\",\"phone\":\"0245678545\"}', '{\"name\":\"Pasty Asamoah\",\"phone\":\"0234125345\"}', '3', 'none', 'Please note that talks on the site and manager of this project has not yet been finalised.', '2017-08-09'),
(3, 'Four storey classroom block for SDA SHS, Ahodwo', 'Four storey classroom block', 'Ahodwo, Kumasi', '2017-09-02', '2018-05-02', 'T & G construction company LTD', '{\"name\":\"Agyemang Sampson\",\"phone\":\"0245657890\"}', '{\"name\":\"Frimpong Mandy\",\"phone\":\"0234125345\"}', '1', '3', 'This is a sample message from the manager', '2017-08-19'),
(4, 'Accra to Kumasi dual carriage road', 'A highway linking Accra and Kumasi', 'Accra - Kumasi road, Ghana', '2017-09-07', '2018-04-11', 'Geostruct Company LTD', '{\"name\":\"Osafo Douglas\",\"phone\":\"0234556546\"}', '{\"name\":\"Agyemang Badu\",\"phone\":\"0257474848\"}', '1', '2', '', '2017-08-20'),
(5, 'Kejetia Market', 'Ultra modern  market in  the Kumasi Metropolis', 'Kumasi, Ashanti Region', '2017-09-07', '2017-12-31', 'Veep construction ', '{\"name\":\"erftyryujy\",\"phone\":\"0234556546\"}', '{\"name\":\"defgerfghyhj\",\"phone\":\"0234125345\"}', '1', '3', 'Please add 200 door frames to the list', '2017-08-28'),
(6, 'Five star hotel building', 'rredfdssdg rgredged', 'ertgryjhtykt', '2017-09-07', '2017-12-26', 'Access Bank Ghana', '{\"name\":\"esdgfghbtfygh\",\"phone\":\"0234556546\"}', '{\"name\":\"asfsdgdf\",\"phone\":\"0257474848\"}', '1', '1', '', '2017-08-29'),
(7, 'Kwame Nkrumah Circle over pass', '500 Kilometers overpass', 'Circle, Greater-Accra', '2017-09-09', '2018-01-19', 'Geroz Construction', '{\"name\":\"asfderghjkl\",\"phone\":\"0245657890\"}', '{\"name\":\"sdfghjkldf\",\"phone\":\"0234562365\"}', '1', 'none', '', '2017-09-03'),
(8, '1000 kilometers dual carriage road', '1000 kilometers dual carriage linking Accra and Cape Coast', 'Accra -Cape Coast highway', '2017-09-21', '2018-09-20', 'Jackson construction Limited', '{\"name\":\"Asane Frimpong\",\"phone\":\"0234556546\"}', '{\"name\":\"Ameyaw Dennis\",\"phone\":\"0257474848\"}', '1', 'none', '', '2017-09-05');

-- --------------------------------------------------------

--
-- Table structure for table `project_material`
--

CREATE TABLE `project_material` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `quantity_needed` int(11) UNSIGNED NOT NULL,
  `date_prepared` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_material`
--

INSERT INTO `project_material` (`id`, `project_id`, `material_id`, `quantity_needed`, `date_prepared`) VALUES
(1, 6, 2, 12, '0000-00-00'),
(2, 6, 1, 100, '0000-00-00'),
(3, 6, 4, 10, '0000-00-00'),
(4, 6, 6, 5, '0000-00-00'),
(5, 3, 13, 100, '2017-10-04'),
(6, 3, 2, 100, '2017-10-04'),
(7, 4, 4, 5, '2017-10-18'),
(8, 4, 2, 30, '2017-10-18'),
(9, 4, 13, 15, '2017-10-18'),
(10, 5, 2, 20000, '2017-11-09'),
(11, 5, 11, 12, '2017-11-09'),
(12, 5, 15, 345, '2017-11-09'),
(13, 5, 7, 700, '2017-11-09'),
(14, 5, 13, 15, '2017-11-09'),
(23, 7, 2, 23, '2017-11-24'),
(24, 7, 11, 67, '2017-11-24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(64) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `role`, `date`) VALUES
(1, 'Agyapong William', 'william', 'd383ca25641d58227410a9ae98bd54d5', 'manager', '2017-08-23 00:00:00'),
(2, 'Agyapong Collins', 'collins', '7ce38bf6811a96afd3411188577b08ee', 'storekeeper', '2017-08-23 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_flow`
--
ALTER TABLE `material_flow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_returns`
--
ALTER TABLE `material_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_material`
--
ALTER TABLE `project_material`
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
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `material_flow`
--
ALTER TABLE `material_flow`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `material_returns`
--
ALTER TABLE `material_returns`
  MODIFY `id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `project_material`
--
ALTER TABLE `project_material`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
