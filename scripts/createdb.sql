-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Aug 07, 2017 at 10:07 AM
-- Server version: 5.6.35-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `uwalc2`
--

-- --------------------------------------------------------

--
-- Table structure for table `agency`
--

CREATE TABLE IF NOT EXISTS `agency` (
  `agy_id` int(11) NOT NULL AUTO_INCREMENT,
  `agy_name` varchar(30) NOT NULL,
  `agy_street_address` varchar(30) DEFAULT NULL,
  `agy_city` varchar(30) DEFAULT 'Athens',
  `agy_state` char(2) DEFAULT 'AL',
  `agy_zip_code` varchar(15) DEFAULT NULL,
  `agy_phone` varchar(20) DEFAULT NULL,
  `agy_registration_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`agy_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `agency`
--

INSERT INTO `agency` (`agy_id`, `agy_name`, `agy_street_address`, `agy_city`, `agy_state`, `agy_zip_code`, `agy_phone`, `agy_registration_date`, `active`) VALUES
(1, 'United Way', '', 'Athens', 'AL', '', NULL, '0000-00-00 00:00:00', 1),
(2, 'Girl Scouts', '1515 Sparkman Dr NW', 'Huntsville', 'AL', '35816', '(256) 883-1020', '0000-00-00 00:00:00', 1),
(3, 'DHR', '123', 'Athens', 'AL', '55555', '(555) 555-5555', '0000-00-00 00:00:00', 0),
(4, 'American Red Cross Limestone C', '1300 Armory Street', 'Athens', 'AL', '35613', '(256) 232-6820', '2014-02-28 20:45:23', 1),
(5, 'ARC/Birdie Thornton Center', '2305 S Hine St', 'Athens', 'AL', '35611', '(256) 232-0366', '2014-02-28 20:47:07', 1),
(6, 'Athens Limestone Counseling Ce', '1307 E Elm Street', 'Athens', 'AL', '35611', '(256) 232-3661', '2014-02-28 20:48:00', 1),
(7, 'Boys and Girls Club', '13529 Lucas Ferry Road', 'Athens', 'AL', '35611', '(256) 232-4298', '2014-02-28 20:49:33', 1),
(8, 'Boy Scouts of America', '2211 Drake Ave SW', 'Huntsville', 'AL', '35805', '(256) 883-7071', '2014-02-28 20:52:59', 1),
(9, 'CASA', '912 W Pryor Street', 'Athens', 'AL', '35612', '(256) 777-1038', '2014-02-28 20:54:03', 1),
(10, 'Crisis Services of North Alaba', '310 S Marion Street', 'Athens', 'AL', '35611', '(256) 232-0280', '2014-02-28 20:54:58', 1),
(11, 'Habitat for Humanity', '700 Brownsferry St', 'Athens', 'AL', '35611', '(230) 256-6001', '2014-02-28 20:56:48', 1),
(12, 'Hospice of Limestone County', '405 S Marion Street', 'Athens', 'AL', '35611', '(256) 232-5017', '2014-02-28 20:57:41', 1),
(13, 'Learn to Read Council', '110 Thomas St N', 'Athens', 'AL', '35611', '(256) 230-3050', '2014-02-28 20:58:44', 1),
(14, '4-H', 'lat0014@aces.edu', 'Athens', 'AL', '35611', '(256) 232-5510', '2014-02-28 20:59:53', 1),
(15, 'RSVP', '409 West Washington Street', 'Athens', 'AL', '35611', '(256) 232-7207', '2014-02-28 21:00:48', 1),
(16, 'Salvation Army', '699 Hobbs St E', 'Athens', 'AL', '35611', '(256) 233-1614', '2014-02-28 21:01:30', 1),
(17, 'USO', '1', 'Athens', 'AL', '35611', '(555) 555-5555', '2014-02-28 21:02:17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `con_id` int(11) NOT NULL AUTO_INCREMENT,
  `con_firstname` varchar(30) DEFAULT NULL,
  `con_lastname` varchar(30) DEFAULT NULL,
  `con_phone` varchar(20) DEFAULT NULL,
  `con_email` varchar(40) DEFAULT NULL,
  `agy_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`con_id`),
  KEY `agy_id_idx` (`agy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `damage`
--

CREATE TABLE IF NOT EXISTS `damage` (
  `damage_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `middle_initial` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `home_phone` varchar(15) DEFAULT NULL,
  `cell_phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `add_st1` varchar(150) DEFAULT NULL,
  `add_st2` varchar(150) DEFAULT NULL,
  `add_city` varchar(45) DEFAULT NULL,
  `add_state` varchar(2) DEFAULT NULL,
  `add_zip` varchar(10) DEFAULT NULL,
  `health_limitation` bit(1) DEFAULT NULL,
  `health_limit_desc` text,
  `dwelling` varchar(45) DEFAULT NULL,
  `owner_renter_info` varchar(45) DEFAULT NULL,
  `level_of_damage` varchar(45) DEFAULT NULL,
  `creation_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(45) DEFAULT NULL,
  `admin_review` bit(1) DEFAULT b'0',
  PRIMARY KEY (`damage_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `damage`
--

INSERT INTO `damage` (`damage_id`, `first_name`, `middle_initial`, `last_name`, `date_of_birth`, `home_phone`, `cell_phone`, `email`, `add_st1`, `add_st2`, `add_city`, `add_state`, `add_zip`, `health_limitation`, `health_limit_desc`, `dwelling`, `owner_renter_info`, `level_of_damage`, `creation_time`, `ip_address`, `admin_review`) VALUES
(1, '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', b'1', '', '', '', '', '2016-03-29 06:41:22', '69.84.207.246', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `damage_member_names`
--

CREATE TABLE IF NOT EXISTS `damage_member_names` (
  `damage_name_id` int(11) NOT NULL AUTO_INCREMENT,
  `damage_id` int(11) NOT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `gender` varchar(45) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `relationship` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`damage_name_id`),
  KEY `fk_damage_member_names_1_idx` (`damage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `disaster`
--

CREATE TABLE IF NOT EXISTS `disaster` (
  `disaster_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `middle_initial` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `home_phone` varchar(15) DEFAULT NULL,
  `cell_phone` varchar(15) DEFAULT NULL,
  `have_interview` bit(1) DEFAULT NULL,
  `interview_date` date DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `pre_add_st1` varchar(150) DEFAULT NULL,
  `pre_add_st2` varchar(150) DEFAULT NULL,
  `pre_add_city` varchar(45) DEFAULT NULL,
  `pre_add_state` varchar(2) DEFAULT NULL,
  `pre_add_zip` varchar(10) DEFAULT NULL,
  `post_add_st1` varchar(150) DEFAULT NULL,
  `post_add_st2` varchar(150) DEFAULT NULL,
  `post_add_city` varchar(45) DEFAULT NULL,
  `post_add_state` varchar(2) DEFAULT NULL,
  `post_add_zip` varchar(10) DEFAULT NULL,
  `health_limitation` bit(1) DEFAULT NULL,
  `health_limit_desc` text,
  `annual_income` varchar(45) DEFAULT NULL,
  `dwelling` varchar(45) DEFAULT NULL,
  `owner_renter_info` varchar(45) DEFAULT NULL,
  `landlord_first_name` varchar(45) DEFAULT NULL,
  `landlord_last_name` varchar(45) DEFAULT NULL,
  `monthly_rent` decimal(14,2) DEFAULT NULL,
  `monthly_utilities` decimal(14,2) DEFAULT NULL,
  `dwelling_use` varchar(45) DEFAULT NULL,
  `dwelling_insurance_contents` bit(1) DEFAULT NULL,
  `dwelling_insurance_hazzard` bit(1) DEFAULT NULL,
  `dwelling_insurance_structure` bit(1) DEFAULT NULL,
  `insurance_provider_name` varchar(45) DEFAULT NULL,
  `insurance_provider_phone` varchar(15) DEFAULT NULL,
  `level_of_damage` varchar(45) DEFAULT NULL,
  `electricity_on` bit(1) DEFAULT NULL,
  `housing_need` bit(1) DEFAULT NULL,
  `housing_need_type` varchar(45) DEFAULT NULL,
  `creation_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(45) DEFAULT NULL,
  `admin_review` bit(1) DEFAULT NULL,
  PRIMARY KEY (`disaster_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `disaster_member_names`
--

CREATE TABLE IF NOT EXISTS `disaster_member_names` (
  `disaster_name_id` int(11) NOT NULL AUTO_INCREMENT,
  `disaster_id` int(11) NOT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `gender` varchar(45) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `relationship` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`disaster_name_id`),
  KEY `fk_disaster_member_names_1_idx` (`disaster_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE IF NOT EXISTS `donation` (
  `donation_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `middle_initial` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `home_phone` varchar(15) DEFAULT NULL,
  `cell_phone` varchar(15) DEFAULT NULL,
  `household_items` bit(1) DEFAULT NULL,
  `baby_items` bit(1) DEFAULT NULL,
  `misc_items` bit(1) DEFAULT NULL,
  `bulk_items` bit(1) DEFAULT NULL,
  `item_desc` text,
  `item_condition` varchar(5) DEFAULT NULL,
  `used_item_condition` varchar(15) DEFAULT NULL,
  `can_deliver` bit(1) DEFAULT NULL,
  `can_store` bit(1) DEFAULT NULL,
  `address_stored_items_st1` varchar(150) DEFAULT NULL,
  `address_stored_items_st2` varchar(150) DEFAULT NULL,
  `address_stored_items_city` varchar(45) DEFAULT NULL,
  `address_stored_items_state` varchar(2) DEFAULT NULL,
  `address_stored_items_zip` varchar(10) DEFAULT NULL,
  `creation_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(45) DEFAULT NULL,
  `admin_review` bit(1) DEFAULT NULL,
  PRIMARY KEY (`donation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`donation_id`, `first_name`, `middle_initial`, `last_name`, `date_of_birth`, `email`, `home_phone`, `cell_phone`, `household_items`, `baby_items`, `misc_items`, `bulk_items`, `item_desc`, `item_condition`, `used_item_condition`, `can_deliver`, `can_store`, `address_stored_items_st1`, `address_stored_items_st2`, `address_stored_items_city`, `address_stored_items_state`, `address_stored_items_zip`, `creation_time`, `ip_address`, `admin_review`) VALUES
(1, '', '', '', '0000-00-00', '', '', '', b'0', b'0', b'0', b'0', '', '', '', b'0', NULL, '', '', '', '', '', '2016-03-29 06:41:22', '69.84.207.246', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `email_action`
--

CREATE TABLE IF NOT EXISTS `email_action` (
  `email_action_id` int(11) NOT NULL AUTO_INCREMENT,
  `email_action` varchar(45) NOT NULL,
  `email_action_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`email_action_id`),
  UNIQUE KEY `email_action_UNIQUE` (`email_action`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `email_action`
--

INSERT INTO `email_action` (`email_action_id`, `email_action`, `email_action_description`) VALUES
(1, 'new_volunteer', 'A new Volunteer Application has been received.'),
(2, 'new_group', 'A new Group Application has been received.'),
(3, 'new_opp', 'A new Opportunity Application has been received.'),
(4, 'new_disaster', 'A new Disaster Application has been received.'),
(5, 'new_damage', 'A new Disaster Application has been received.'),
(6, 'new_donation', 'A new Donation Form has been received.');

-- --------------------------------------------------------

--
-- Table structure for table `email_forms`
--

CREATE TABLE IF NOT EXISTS `email_forms` (
  `email_id` int(11) NOT NULL AUTO_INCREMENT,
  `email_action_id` int(11) NOT NULL,
  `email_display_name` varchar(100) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  PRIMARY KEY (`email_id`),
  KEY `fk_email_forms_1_idx` (`email_action_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `eventid` int(11) NOT NULL AUTO_INCREMENT,
  `evdate` date NOT NULL,
  `ename` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `edesc` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`eventid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`eventid`, `evdate`, `ename`, `edesc`) VALUES
(1, '2017-04-27', 'Test', 'This is test data');

-- --------------------------------------------------------

--
-- Table structure for table `ev_vols`
--

CREATE TABLE IF NOT EXISTS `ev_vols` (
  `evdate` date NOT NULL,
  `vfname` varchar(45) NOT NULL,
  `vlname` varchar(45) NOT NULL,
  `vpnum` varchar(20) NOT NULL,
  `vemail` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(30) NOT NULL,
  `group_description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_id`, `group_name`, `group_description`) VALUES
(1, 'Administrators', 'Users who administrate the entire application.'),
(2, 'Volunteers', 'Volunteers who enter volunteer information and search for volunteers.'),
(3, 'Agencies', 'Users who submit agency opportunity requests.');

-- --------------------------------------------------------

--
-- Table structure for table `group_skill`
--

CREATE TABLE IF NOT EXISTS `group_skill` (
  `grp_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `group_skill_comments` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`grp_id`,`skill_id`),
  KEY `vol_id_idx` (`grp_id`),
  KEY `skill_id_idx` (`skill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `group_skill`
--

INSERT INTO `group_skill` (`grp_id`, `skill_id`, `group_skill_comments`) VALUES
(1, 2, NULL),
(1, 3, NULL),
(1, 18, NULL),
(1, 19, NULL),
(1, 20, NULL),
(1, 21, NULL),
(1, 22, NULL),
(1, 23, NULL),
(1, 24, NULL),
(1, 26, NULL),
(1, 27, NULL),
(1, 29, NULL),
(1, 30, NULL),
(1, 31, NULL),
(1, 32, NULL),
(1, 40, NULL),
(1, 41, NULL),
(1, 42, NULL),
(1, 43, NULL),
(1, 44, NULL),
(1, 45, NULL),
(1, 46, NULL),
(1, 47, NULL),
(1, 51, NULL),
(1, 55, NULL),
(1, 56, NULL),
(1, 57, NULL),
(2, 3, NULL),
(2, 23, NULL),
(2, 32, NULL),
(2, 40, NULL),
(2, 41, NULL),
(2, 43, NULL),
(2, 44, NULL),
(2, 45, NULL),
(2, 46, NULL),
(2, 47, NULL),
(2, 52, NULL),
(2, 56, NULL),
(2, 57, NULL),
(19, 9, NULL),
(19, 10, NULL),
(19, 11, NULL),
(19, 12, NULL),
(19, 13, NULL),
(19, 14, NULL),
(19, 15, NULL),
(19, 16, NULL),
(19, 17, NULL),
(19, 32, NULL),
(19, 35, NULL),
(19, 40, NULL),
(19, 42, NULL),
(19, 43, NULL),
(19, 44, NULL),
(19, 45, NULL),
(19, 46, NULL),
(19, 47, NULL),
(19, 50, NULL),
(20, 20, NULL),
(20, 22, NULL),
(20, 44, NULL),
(20, 47, NULL),
(20, 51, NULL),
(20, 56, NULL),
(20, 57, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grp_t`
--

CREATE TABLE IF NOT EXISTS `grp_t` (
  `grp_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(30) NOT NULL,
  `contact` varchar(30) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email_address` varchar(40) DEFAULT NULL,
  `phone_num` varchar(20) DEFAULT NULL,
  `cell_phone` varchar(20) DEFAULT NULL,
  `street_address` varchar(30) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `state` char(2) DEFAULT 'AL',
  `zip_code` varchar(15) DEFAULT NULL,
  `health_limits` tinyint(1) NOT NULL DEFAULT '0',
  `health_limits_comment` varchar(250) DEFAULT NULL,
  `affiliated` tinyint(1) NOT NULL DEFAULT '0',
  `affiliated_comment` varchar(250) DEFAULT NULL,
  `location_limestone_county` tinyint(1) NOT NULL DEFAULT '0',
  `location_neighbor_county` tinyint(1) NOT NULL DEFAULT '0',
  `location_anywhere` tinyint(1) NOT NULL DEFAULT '0',
  `emer_con_first_name` varchar(30) DEFAULT NULL,
  `emer_con_last_name` varchar(30) DEFAULT NULL,
  `emer_con_email` varchar(40) DEFAULT NULL,
  `emer_con_phone` varchar(20) DEFAULT NULL,
  `special_skills` tinyint(1) NOT NULL DEFAULT '0',
  `special_skills_comment` varchar(250) DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin_review` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `disaster` tinyint(1) DEFAULT '0',
  `community` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`grp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;


-- --------------------------------------------------------

--
-- Table structure for table `opportunity`
--

CREATE TABLE IF NOT EXISTS `opportunity` (
  `opp_id` int(11) NOT NULL AUTO_INCREMENT,
  `agy_id` int(11) NOT NULL,
  `opp_requestdate` date NOT NULL,
  `opp_name` varchar(50) NOT NULL,
  `opp_description` varchar(250) NOT NULL,
  `opp_startdate` date DEFAULT NULL,
  `opp_enddate` date DEFAULT NULL,
  `opp_starttime` time DEFAULT NULL,
  `opp_endtime` time DEFAULT NULL,
  `opp_streetaddress1` varchar(30) DEFAULT NULL,
  `opp_streetaddress2` varchar(30) DEFAULT NULL,
  `opp_city` varchar(30) DEFAULT NULL,
  `opp_state` char(2) DEFAULT NULL,
  `opp_zipcode` varchar(15) DEFAULT NULL,
  `opp_directions` varchar(250) DEFAULT NULL,
  `admin_review` tinyint(1) NOT NULL DEFAULT '0',
  `open` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`opp_id`),
  KEY `agy_id` (`agy_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `opportunity`
--

INSERT INTO `opportunity` (`opp_id`, `agy_id`, `opp_requestdate`, `opp_name`, `opp_description`, `opp_startdate`, `opp_enddate`, `opp_starttime`, `opp_endtime`, `opp_streetaddress1`, `opp_streetaddress2`, `opp_city`, `opp_state`, `opp_zipcode`, `opp_directions`, `admin_review`, `open`) VALUES
(1, 1, '2015-12-01', 'Toys for Tots', 'We will be sorting toys by age, gender, and quality (Big,Medium,Small).', '2015-11-17', '2015-11-30', '12:00:00', '14:00:00', 'Call United Way', '', '', 'AL', '', '', 1, 1),
(2, 1, '2015-12-02', 'Toys for Tots', 'We will be packing toys in bags by age and gender.', '2015-11-17', '2015-11-30', '09:00:00', '11:30:00', 'Call United Way', '', '', 'AL', '', '', 1, 1),
(3, 1, '2015-12-02', 'Toys for Tots', 'We will be packing family bags for easier distribution and alphabetizing.', '2015-11-17', '2015-11-30', '11:30:00', '14:00:00', 'Call United Way', '', '', 'AL', '', '', 1, 1),
(4, 1, '2015-12-03', 'Toys for Tots', 'We will be distributing the toys to families. There are two shifts.. 9:00-11:30 and 11:30-2:00. We will be serving lunch to all volunteers during shift change.', '2015-11-17', '2015-11-30', '09:00:00', '14:00:00', 'Call United Way', '', '', 'AL', '', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `opp_skill`
--

CREATE TABLE IF NOT EXISTS `opp_skill` (
  `opp_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `opp_skill_comments` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`opp_id`,`skill_id`),
  KEY `opp_id_idx` (`opp_id`),
  KEY `skill_id_idx` (`skill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `opp_skill`
--

INSERT INTO `opp_skill` (`opp_id`, `skill_id`, `opp_skill_comments`) VALUES
(1, 46, NULL),
(1, 47, NULL),
(2, 46, NULL),
(2, 47, NULL),
(3, 46, NULL),
(3, 47, NULL),
(4, 46, NULL),
(4, 47, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `skill`
--

CREATE TABLE IF NOT EXISTS `skill` (
  `skill_id` int(11) NOT NULL AUTO_INCREMENT,
  `skill_name` varchar(40) DEFAULT NULL,
  `skill_group` varchar(250) DEFAULT NULL,
  `skill_comments` varchar(250) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`skill_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `skill`
--

INSERT INTO `skill` (`skill_id`, `skill_name`, `skill_group`, `skill_comments`, `enabled`) VALUES
(1, 'Doctor', 'Medical', '', 1),
(2, 'Clerical', 'Office Support', '', 1),
(3, 'Car', 'Equipment Transportation', '', 1),
(4, 'Nurse', 'Medical', '', 1),
(5, 'EMT', 'Medical', '', 1),
(6, 'Mental Health Counseling', 'Medical', '', 1),
(7, 'Veterinarian', 'Medical', '', 1),
(8, 'Veterinarian Tech', 'Medical', '', 1),
(9, 'Damage Assessment', 'Structural', '', 1),
(10, 'Metal Construction', 'Structural', '', 1),
(11, 'Wood Construction', 'Structural', '', 1),
(12, 'Carpentry', 'Structural', '', 1),
(13, 'Welding', 'Structural', '', 1),
(14, 'Masonry', 'Structural', '', 1),
(15, 'Roofing', 'Structural', '', 1),
(16, 'Plumbing', 'Structural', 'Plumbing Certification Number and Expiration Date:', 1),
(17, 'Electrical', 'Structural', 'Electrical Certification Number and Expiration Date:', 1),
(18, 'Data Entry', 'Office Support', '', 1),
(19, 'Phone Receptionist', 'Office Support', '', 1),
(20, 'Food Distribution', 'Services', '', 1),
(21, 'Cook', 'Services', '', 1),
(22, 'Animal Care', 'Services', '', 1),
(23, 'Elderly/Disabled Assistance', 'Services', '', 1),
(24, 'Counseling: Spiritual', 'Services', '', 1),
(25, 'Social Work', 'Services', '', 1),
(26, 'Search and Rescue', 'Services', '', 1),
(27, 'Errand/Message Runner', 'Services', '', 1),
(28, 'Child Care (certified)', 'Services', '', 1),
(29, 'Station Wagon/Mini Van', 'Equipment Transportation', '', 1),
(30, 'Maxi-Van', 'Equipment Transportation', 'Capacity:', 1),
(31, 'ATV', 'Equipment Transportation', '', 1),
(32, 'Truck', 'Equipment Transportation', '4x4:', 1),
(33, 'Boat', 'Equipment Transportation', '', 1),
(34, 'Camper/RV', 'Equipment Transportation', 'Capacity:', 1),
(35, 'Trailer', 'Equipment Transportation', 'Size:', 1),
(36, 'CDL', 'Equipment Transportation', 'CDL Number and Expiration Date:', 1),
(37, 'Backhoe', 'Equipment', '', 1),
(38, 'Chainsaw', 'Equipment', '', 1),
(39, 'Fork Lift', 'Equipment', '', 1),
(40, 'Power Tools', 'Equipment', '', 1),
(41, 'Skill Saw', 'Equipment', '', 1),
(42, 'Generator', 'Equipment', '', 1),
(43, 'Debris Removal', 'General Labor', '', 1),
(44, 'Clean-up', 'General Labor', '', 1),
(45, 'Heavy Lifting', 'General Labor', '', 1),
(46, 'Loading/Shipping', 'General Labor', '', 1),
(47, 'Sorting/Packing', 'General Labor', '', 1),
(48, 'Auto/Repair/Towing', 'General Labor', '', 1),
(49, 'Counseling: Mental Health', 'Services', '', 1),
(50, 'Spanish', 'Language', NULL, 1),
(51, 'Tutoring/Mentoring', 'Services', '', 1),
(52, 'Fitness and Nutrition', 'Health', '', 1),
(53, 'Board of Directors', 'Leadership', '', 1),
(54, 'Committe Member', 'Leadership', '', 1),
(55, 'Computers', 'Office Support', '', 1),
(56, 'Painting', 'Services', '', 1),
(57, 'Lawn Care', 'Services', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;


-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`user_id`, `group_id`) VALUES
(1, 1),
(4, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(18, 1),
(19, 1),
(20, 1),
(2, 2),
(15, 2),
(16, 2),
(17, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `volunteers`
--

CREATE TABLE IF NOT EXISTS `volunteers` (
  `vol_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) NOT NULL,
  `middle_initial` char(1) DEFAULT NULL,
  `last_name` varchar(30) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email_address` varchar(40) DEFAULT NULL,
  `home_phone` varchar(20) DEFAULT NULL,
  `cell_phone` varchar(20) DEFAULT NULL,
  `street_address1` varchar(30) DEFAULT NULL,
  `street_address2` varchar(30) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `state` char(2) DEFAULT 'AL',
  `zip_code` varchar(15) DEFAULT NULL,
  `occupation` varchar(30) DEFAULT NULL,
  `employer` varchar(30) DEFAULT NULL,
  `health_limits` tinyint(1) NOT NULL DEFAULT '0',
  `health_limits_comment` varchar(250) DEFAULT NULL,
  `affiliated` tinyint(1) NOT NULL DEFAULT '0',
  `affiliated_comment` varchar(250) DEFAULT NULL,
  `location_limestone_county` tinyint(1) NOT NULL DEFAULT '0',
  `location_neighbor_county` tinyint(1) NOT NULL DEFAULT '0',
  `location_anywhere` tinyint(1) NOT NULL DEFAULT '0',
  `emer_con_first_name` varchar(30) DEFAULT NULL,
  `emer_con_last_name` varchar(30) DEFAULT NULL,
  `emer_con_relationship` varchar(30) DEFAULT NULL,
  `emer_con_phone` varchar(20) DEFAULT NULL,
  `special_skills` tinyint(1) NOT NULL DEFAULT '0',
  `special_skills_comment` varchar(250) DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin_review` tinyint(1) DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `disaster` tinyint(1) DEFAULT '0',
  `community` tinyint(1) DEFAULT '0',
  `ssn` int(4) DEFAULT NULL,
  PRIMARY KEY (`vol_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1926 ;


-- --------------------------------------------------------

--
-- Table structure for table `vol_opp`
--

CREATE TABLE IF NOT EXISTS `vol_opp` (
  `vol_id` int(11) NOT NULL,
  `opp_id` int(11) NOT NULL,
  `vol_startdate` date DEFAULT NULL,
  `vol_enddate` date DEFAULT NULL,
  `vol_starttime` time DEFAULT NULL,
  `vol_endtime` time DEFAULT NULL,
  `vol_hoursworked` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`vol_id`,`opp_id`),
  KEY `vol_id_idx` (`vol_id`),
  KEY `opp_id_idx` (`opp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vol_skill`
--

CREATE TABLE IF NOT EXISTS `vol_skill` (
  `vol_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `vol_skill_comments` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`vol_id`,`skill_id`),
  KEY `vol_id_idx` (`vol_id`),
  KEY `skill_id_idx` (`skill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`agy_id`) REFERENCES `agency` (`agy_id`) ON UPDATE CASCADE;

--
-- Constraints for table `damage_member_names`
--
ALTER TABLE `damage_member_names`
  ADD CONSTRAINT `fk_damage_member_names_1` FOREIGN KEY (`damage_id`) REFERENCES `damage` (`damage_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `disaster_member_names`
--
ALTER TABLE `disaster_member_names`
  ADD CONSTRAINT `fk_disaster_member_names_1` FOREIGN KEY (`disaster_id`) REFERENCES `disaster` (`disaster_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `email_forms`
--
ALTER TABLE `email_forms`
  ADD CONSTRAINT `fk_email_forms_1` FOREIGN KEY (`email_action_id`) REFERENCES `email_action` (`email_action_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `group_skill`
--
ALTER TABLE `group_skill`
  ADD CONSTRAINT `group_skill_ibfk_1` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`skill_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `group_skill_ibfk_2` FOREIGN KEY (`grp_id`) REFERENCES `grp_t` (`grp_id`) ON UPDATE CASCADE;

--
-- Constraints for table `opp_skill`
--
ALTER TABLE `opp_skill`
  ADD CONSTRAINT `opp_skill_ibfk_1` FOREIGN KEY (`opp_id`) REFERENCES `opportunity` (`opp_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `opp_skill_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`skill_id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD CONSTRAINT `group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vol_opp`
--
ALTER TABLE `vol_opp`
  ADD CONSTRAINT `vol_opp_ibfk_1` FOREIGN KEY (`vol_id`) REFERENCES `volunteers` (`vol_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `vol_opp_ibfk_2` FOREIGN KEY (`opp_id`) REFERENCES `opportunity` (`opp_id`) ON UPDATE CASCADE;

--
-- Constraints for table `vol_skill`
--
ALTER TABLE `vol_skill`
  ADD CONSTRAINT `vol_skill_ibfk_1` FOREIGN KEY (`vol_id`) REFERENCES `volunteers` (`vol_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `vol_skill_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`skill_id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
