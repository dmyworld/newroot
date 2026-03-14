-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 12, 2026 at 06:49 AM
-- Server version: 8.4.7
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newroot`
--

-- --------------------------------------------------------

--
-- Table structure for table `aauth_groups`
--

DROP TABLE IF EXISTS `aauth_groups`;
CREATE TABLE IF NOT EXISTS `aauth_groups` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `definition` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `aauth_perms`
--

DROP TABLE IF EXISTS `aauth_perms`;
CREATE TABLE IF NOT EXISTS `aauth_perms` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `definition` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `aauth_perm_to_group`
--

DROP TABLE IF EXISTS `aauth_perm_to_group`;
CREATE TABLE IF NOT EXISTS `aauth_perm_to_group` (
  `perm_id` int UNSIGNED NOT NULL,
  `group_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`perm_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `aauth_perm_to_user`
--

DROP TABLE IF EXISTS `aauth_perm_to_user`;
CREATE TABLE IF NOT EXISTS `aauth_perm_to_user` (
  `perm_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`perm_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `aauth_user_to_group`
--

DROP TABLE IF EXISTS `aauth_user_to_group`;
CREATE TABLE IF NOT EXISTS `aauth_user_to_group` (
  `user_id` int UNSIGNED NOT NULL,
  `group_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `aauth_user_variables`
--

DROP TABLE IF EXISTS `aauth_user_variables`;
CREATE TABLE IF NOT EXISTS `aauth_user_variables` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `data_key` varchar(100) NOT NULL,
  `value` text,
  PRIMARY KEY (`id`),
  KEY `user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `consumer_orders`
--

DROP TABLE IF EXISTS `consumer_orders`;
CREATE TABLE IF NOT EXISTS `consumer_orders` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` int UNSIGNED DEFAULT '0',
  `approval_status` enum('not_required','pending_owner','approved','rejected') DEFAULT 'not_required',
  `order_number` varchar(20) DEFAULT NULL,
  `customer_id` int UNSIGNED DEFAULT '0',
  `customer_name` varchar(150) NOT NULL,
  `customer_phone` varchar(30) NOT NULL,
  `customer_email` varchar(150) DEFAULT NULL,
  `customer_address` text,
  `lot_id` int UNSIGNED NOT NULL,
  `lot_type` varchar(30) NOT NULL,
  `species` varchar(100) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT '1.00',
  `unit` varchar(20) DEFAULT 'pieces',
  `thickness_inches` decimal(8,2) DEFAULT NULL,
  `width_inches` decimal(8,2) DEFAULT NULL,
  `length_ft` decimal(8,2) DEFAULT NULL,
  `custom_size_note` text,
  `volume_cuft` decimal(10,4) DEFAULT NULL,
  `quoted_price` decimal(12,2) DEFAULT NULL,
  `final_price` decimal(12,2) DEFAULT NULL,
  `payment_method` enum('cash','bank_transfer','online') DEFAULT 'cash',
  `status` enum('quote','confirmed','processing','ready','delivered','cancelled') DEFAULT 'quote',
  `delivery_required` tinyint(1) DEFAULT '0',
  `delivery_address` text,
  `seller_note` text,
  `customer_note` text,
  `branch_id` int UNSIGNED DEFAULT '0',
  `assigned_to` int UNSIGNED DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_number` (`order_number`),
  KEY `customer_id` (`customer_id`),
  KEY `status` (`status`),
  KEY `lot_id` (`lot_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `generated_media`
--

DROP TABLE IF EXISTS `generated_media`;
CREATE TABLE IF NOT EXISTS `generated_media` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ad_id` int UNSIGNED NOT NULL,
  `ad_type` varchar(30) DEFAULT 'logs',
  `media_type` enum('poster','video','audio') NOT NULL,
  `template_slot` tinyint UNSIGNED DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `caption` text,
  `hashtags` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ad_id` (`ad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_accounts`
--

DROP TABLE IF EXISTS `geopos_accounts`;
CREATE TABLE IF NOT EXISTS `geopos_accounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `acn` varchar(35) NOT NULL,
  `holder` varchar(100) NOT NULL,
  `adate` datetime NOT NULL,
  `lastbal` decimal(16,2) DEFAULT '0.00',
  `code` varchar(30) DEFAULT NULL,
  `loc` int DEFAULT NULL,
  `account_type` enum('Assets','Expenses','Income','Liabilities','Equity','Basic') NOT NULL DEFAULT 'Basic',
  PRIMARY KEY (`id`),
  UNIQUE KEY `acn` (`acn`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_accounts_backup`
--

DROP TABLE IF EXISTS `geopos_accounts_backup`;
CREATE TABLE IF NOT EXISTS `geopos_accounts_backup` (
  `id` int NOT NULL DEFAULT '0',
  `acn` varchar(35) CHARACTER SET utf8mb3 NOT NULL,
  `holder` varchar(100) CHARACTER SET utf8mb3 NOT NULL,
  `adate` datetime NOT NULL,
  `lastbal` decimal(16,2) DEFAULT '0.00',
  `code` varchar(30) CHARACTER SET utf8mb3 DEFAULT NULL,
  `loc` int DEFAULT NULL,
  `account_type` enum('Assets','Expenses','Income','Liabilities','Equity','Basic') CHARACTER SET utf8mb3 NOT NULL DEFAULT 'Basic'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_alert_logs`
--

DROP TABLE IF EXISTS `geopos_alert_logs`;
CREATE TABLE IF NOT EXISTS `geopos_alert_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `old_alert_qty` decimal(10,4) DEFAULT '0.0000',
  `new_alert_qty` decimal(10,4) DEFAULT '0.0000',
  `reason` text,
  `changed_by` int DEFAULT NULL,
  `changed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `changed_by` (`changed_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_assets`
--

DROP TABLE IF EXISTS `geopos_assets`;
CREATE TABLE IF NOT EXISTS `geopos_assets` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `serial` varchar(255) DEFAULT NULL,
  `qty` int NOT NULL DEFAULT '1',
  `value` decimal(16,2) NOT NULL DEFAULT '0.00',
  `status` varchar(50) NOT NULL DEFAULT 'Available',
  `assigned_to` int DEFAULT NULL,
  `note` text,
  `date_acquired` date DEFAULT NULL,
  `loc` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_attendance`
--

DROP TABLE IF EXISTS `geopos_attendance`;
CREATE TABLE IF NOT EXISTS `geopos_attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `emp` int NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `adate` date NOT NULL,
  `tfrom` time NOT NULL,
  `tto` time NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `actual_hours` int DEFAULT NULL,
  `clock_in_lat` decimal(10,8) DEFAULT NULL,
  `clock_in_lng` decimal(11,8) DEFAULT NULL,
  `clock_out_lat` decimal(10,8) DEFAULT NULL,
  `clock_out_lng` decimal(11,8) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `emp` (`emp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_bank_ac`
--

DROP TABLE IF EXISTS `geopos_bank_ac`;
CREATE TABLE IF NOT EXISTS `geopos_bank_ac` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `bank` varchar(50) NOT NULL,
  `acn` varchar(50) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `note` varchar(2000) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `branch` varchar(100) DEFAULT NULL,
  `enable` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_branch_kpi_snapshots`
--

DROP TABLE IF EXISTS `geopos_branch_kpi_snapshots`;
CREATE TABLE IF NOT EXISTS `geopos_branch_kpi_snapshots` (
  `id` int NOT NULL AUTO_INCREMENT,
  `branch_id` int NOT NULL,
  `date` date NOT NULL,
  `sales` decimal(16,2) NOT NULL DEFAULT '0.00',
  `profit` decimal(16,2) NOT NULL DEFAULT '0.00',
  `cash_in_hand` decimal(16,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_business_health`
--

DROP TABLE IF EXISTS `geopos_business_health`;
CREATE TABLE IF NOT EXISTS `geopos_business_health` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `score` int NOT NULL DEFAULT '85',
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_cheques`
--

DROP TABLE IF EXISTS `geopos_cheques`;
CREATE TABLE IF NOT EXISTS `geopos_cheques` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tid` int DEFAULT '0',
  `cheque_number` varchar(100) DEFAULT NULL,
  `date` date NOT NULL,
  `payee` varchar(255) NOT NULL,
  `amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `issue_date` date DEFAULT NULL,
  `clear_date` date DEFAULT NULL,
  `status` enum('Pending','Signed','Issued','Cleared','Bounced','Void') NOT NULL DEFAULT 'Pending',
  `party_id` int DEFAULT '0',
  `party_type` enum('Customer','Supplier') DEFAULT 'Customer',
  `bank` varchar(200) DEFAULT NULL,
  `branch` varchar(200) DEFAULT NULL,
  `type` enum('Incoming','Outgoing') NOT NULL DEFAULT 'Outgoing',
  `ref_no` varchar(100) DEFAULT NULL,
  `note` text,
  `branch_id` int DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `doc_id` int DEFAULT '0',
  `doc_type` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_config`
--

DROP TABLE IF EXISTS `geopos_config`;
CREATE TABLE IF NOT EXISTS `geopos_config` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` int NOT NULL,
  `val1` varchar(50) NOT NULL,
  `val2` varchar(200) NOT NULL,
  `val3` varchar(100) NOT NULL,
  `val4` varchar(100) NOT NULL,
  `rid` int NOT NULL,
  `other` int NOT NULL,
  `fb_profile_id` varchar(255) DEFAULT '',
  `access_token` text,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `fb_profile_id` (`fb_profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_currencies`
--

DROP TABLE IF EXISTS `geopos_currencies`;
CREATE TABLE IF NOT EXISTS `geopos_currencies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `symbol` varchar(3) DEFAULT NULL,
  `rate` decimal(10,2) NOT NULL,
  `thous` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `dpoint` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `decim` int NOT NULL,
  `cpos` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_customers`
--

DROP TABLE IF EXISTS `geopos_customers`;
CREATE TABLE IF NOT EXISTS `geopos_customers` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `region` varchar(30) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `postbox` varchar(20) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `picture` varchar(100) NOT NULL DEFAULT 'example.png',
  `gid` int NOT NULL DEFAULT '1',
  `company` varchar(100) DEFAULT NULL,
  `taxid` varchar(100) DEFAULT NULL,
  `name_s` varchar(100) DEFAULT NULL,
  `phone_s` varchar(100) DEFAULT NULL,
  `email_s` varchar(100) DEFAULT NULL,
  `address_s` varchar(100) DEFAULT NULL,
  `city_s` varchar(100) DEFAULT NULL,
  `region_s` varchar(100) DEFAULT NULL,
  `country_s` varchar(100) DEFAULT NULL,
  `postbox_s` varchar(100) DEFAULT NULL,
  `balance` decimal(16,2) DEFAULT '0.00',
  `loc` int DEFAULT '0',
  `docid` varchar(255) DEFAULT NULL,
  `custom1` varchar(255) DEFAULT NULL,
  `discount_c` decimal(16,2) DEFAULT NULL,
  `reg_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `delete_status` tinyint(1) NOT NULL DEFAULT '0',
  `business_id` int UNSIGNED DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `gid` (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_custom_data`
--

DROP TABLE IF EXISTS `geopos_custom_data`;
CREATE TABLE IF NOT EXISTS `geopos_custom_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `field_id` int NOT NULL,
  `rid` int NOT NULL,
  `module` int NOT NULL,
  `data` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fid` (`field_id`,`rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_custom_fields`
--

DROP TABLE IF EXISTS `geopos_custom_fields`;
CREATE TABLE IF NOT EXISTS `geopos_custom_fields` (
  `id` int NOT NULL AUTO_INCREMENT,
  `f_module` int NOT NULL,
  `f_type` varchar(30) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `placeholder` varchar(30) DEFAULT NULL,
  `value_data` text NOT NULL,
  `f_view` int NOT NULL,
  `other` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `f_module` (`f_module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_cust_group`
--

DROP TABLE IF EXISTS `geopos_cust_group`;
CREATE TABLE IF NOT EXISTS `geopos_cust_group` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(60) DEFAULT NULL,
  `summary` varchar(250) DEFAULT NULL,
  `disc_rate` decimal(9,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_deduction_types`
--

DROP TABLE IF EXISTS `geopos_deduction_types`;
CREATE TABLE IF NOT EXISTS `geopos_deduction_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `calculation_type` enum('Percentage','Fixed Amount') NOT NULL,
  `default_value` decimal(10,2) NOT NULL DEFAULT '0.00',
  `is_pre_tax` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `category` varchar(50) DEFAULT 'Other',
  `statutory_type` varchar(20) DEFAULT 'None',
  `employer_match_percent` decimal(10,2) DEFAULT '0.00',
  `salary_ceiling` decimal(15,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_documents`
--

DROP TABLE IF EXISTS `geopos_documents`;
CREATE TABLE IF NOT EXISTS `geopos_documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `cdate` date NOT NULL,
  `permission` int DEFAULT NULL,
  `cid` int NOT NULL,
  `fid` int NOT NULL,
  `rid` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_draft`
--

DROP TABLE IF EXISTS `geopos_draft`;
CREATE TABLE IF NOT EXISTS `geopos_draft` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tid` int NOT NULL,
  `invoicedate` date NOT NULL,
  `invoiceduedate` date NOT NULL,
  `subtotal` decimal(16,2) DEFAULT '0.00',
  `shipping` decimal(16,2) DEFAULT '0.00',
  `ship_tax` decimal(16,2) DEFAULT NULL,
  `ship_tax_type` enum('incl','excl','off') DEFAULT 'off',
  `discount` decimal(16,2) DEFAULT '0.00',
  `tax` decimal(16,2) DEFAULT '0.00',
  `total` decimal(16,2) DEFAULT '0.00',
  `pmethod` varchar(14) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `status` enum('paid','due','canceled','partial') NOT NULL DEFAULT 'due',
  `csd` int NOT NULL DEFAULT '0',
  `eid` int NOT NULL,
  `pamnt` decimal(16,2) DEFAULT '0.00',
  `items` decimal(10,2) NOT NULL,
  `taxstatus` enum('yes','no','cgst','igst') NOT NULL DEFAULT 'yes',
  `discstatus` tinyint(1) NOT NULL,
  `format_discount` enum('%','flat') NOT NULL DEFAULT '%',
  `refer` varchar(20) DEFAULT NULL,
  `term` int NOT NULL,
  `multi` int DEFAULT NULL,
  `i_class` int NOT NULL DEFAULT '0',
  `loc` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `eid` (`eid`),
  KEY `csd` (`csd`),
  KEY `invoice` (`tid`) USING BTREE,
  KEY `i_class` (`i_class`),
  KEY `loc` (`loc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_draft_items`
--

DROP TABLE IF EXISTS `geopos_draft_items`;
CREATE TABLE IF NOT EXISTS `geopos_draft_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tid` int NOT NULL,
  `pid` int NOT NULL DEFAULT '0',
  `product` varchar(255) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `qty` decimal(10,2) NOT NULL DEFAULT '0.00',
  `price` decimal(16,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(16,2) DEFAULT '0.00',
  `discount` decimal(16,2) DEFAULT '0.00',
  `subtotal` decimal(16,2) DEFAULT '0.00',
  `totaltax` decimal(16,2) DEFAULT '0.00',
  `totaldiscount` decimal(16,2) DEFAULT '0.00',
  `product_des` text,
  `i_class` int NOT NULL DEFAULT '0',
  `unit` varchar(5) DEFAULT NULL,
  `sqft` decimal(10,4) NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`id`),
  KEY `invoice` (`tid`),
  KEY `i_class` (`i_class`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_employees`
--

DROP TABLE IF EXISTS `geopos_employees`;
CREATE TABLE IF NOT EXISTS `geopos_employees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `hourly_rate` decimal(10,2) DEFAULT '0.00',
  `name` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `region` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `postbox` varchar(20) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `phonealt` varchar(15) DEFAULT NULL,
  `picture` varchar(50) NOT NULL DEFAULT 'example.png',
  `sign` varchar(100) DEFAULT 'sign.png',
  `joindate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dept` int DEFAULT NULL,
  `degis` int DEFAULT NULL,
  `salary` decimal(16,2) DEFAULT '0.00',
  `clock` int DEFAULT NULL,
  `clockin` int DEFAULT NULL,
  `clockout` int DEFAULT NULL,
  `c_rate` decimal(16,2) DEFAULT NULL,
  `cola_amount` decimal(16,2) DEFAULT '0.00',
  `epf_no` varchar(100) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_ac` varchar(100) DEFAULT NULL,
  `overtime_eligible` tinyint(1) DEFAULT '1',
  `verified` tinyint(1) DEFAULT '0',
  `insurance_id` varchar(100) DEFAULT NULL,
  `security_service` tinyint(1) DEFAULT '0',
  `delete_status` tinyint(1) NOT NULL DEFAULT '0',
  `business_id` int UNSIGNED DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_employee_loans`
--

DROP TABLE IF EXISTS `geopos_employee_loans`;
CREATE TABLE IF NOT EXISTS `geopos_employee_loans` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL,
  `amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(16,2) NOT NULL DEFAULT '0.00',
  `installment` decimal(16,2) NOT NULL DEFAULT '0.00',
  `account_id` int NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Due',
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `note` text,
  `type` varchar(50) DEFAULT 'Personal',
  `interest_rate` decimal(5,2) DEFAULT '0.00',
  `guarantor` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_employee_loan_payments`
--

DROP TABLE IF EXISTS `geopos_employee_loan_payments`;
CREATE TABLE IF NOT EXISTS `geopos_employee_loan_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `loan_id` int NOT NULL,
  `amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `date` date NOT NULL,
  `method` varchar(50) NOT NULL DEFAULT 'Cash',
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_emp_deductions`
--

DROP TABLE IF EXISTS `geopos_emp_deductions`;
CREATE TABLE IF NOT EXISTS `geopos_emp_deductions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL,
  `deduction_type_id` int NOT NULL,
  `amount_override` decimal(10,2) DEFAULT '0.00',
  `percentage_override` decimal(5,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_events`
--

DROP TABLE IF EXISTS `geopos_events`;
CREATE TABLE IF NOT EXISTS `geopos_events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#3a87ad',
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `allDay` varchar(50) NOT NULL DEFAULT 'true',
  `rel` int NOT NULL DEFAULT '0',
  `rid` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `rel` (`rel`),
  KEY `rid` (`rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_fb_automation`
--

DROP TABLE IF EXISTS `geopos_fb_automation`;
CREATE TABLE IF NOT EXISTS `geopos_fb_automation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `fb_profile_id` varchar(100) DEFAULT NULL,
  `access_token` text,
  `linked_groups` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_gateways`
--

DROP TABLE IF EXISTS `geopos_gateways`;
CREATE TABLE IF NOT EXISTS `geopos_gateways` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `enable` enum('Yes','No') NOT NULL,
  `key1` varchar(255) NOT NULL,
  `key2` varchar(255) DEFAULT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `dev_mode` enum('true','false') NOT NULL,
  `ord` int NOT NULL,
  `surcharge` decimal(16,2) NOT NULL,
  `extra` varchar(40) NOT NULL DEFAULT 'none',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_goals`
--

DROP TABLE IF EXISTS `geopos_goals`;
CREATE TABLE IF NOT EXISTS `geopos_goals` (
  `id` int NOT NULL,
  `income` bigint NOT NULL,
  `expense` bigint NOT NULL,
  `sales` bigint NOT NULL,
  `netincome` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_guides`
--

DROP TABLE IF EXISTS `geopos_guides`;
CREATE TABLE IF NOT EXISTS `geopos_guides` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `module` varchar(100) NOT NULL,
  `lang` varchar(20) NOT NULL DEFAULT 'english',
  `permission` varchar(50) DEFAULT 'all',
  `start_url` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_guide_steps`
--

DROP TABLE IF EXISTS `geopos_guide_steps`;
CREATE TABLE IF NOT EXISTS `geopos_guide_steps` (
  `id` int NOT NULL AUTO_INCREMENT,
  `guide_id` int NOT NULL,
  `step_order` int NOT NULL,
  `element_selector` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `position` varchar(50) DEFAULT 'bottom',
  `highlight` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `guide_id` (`guide_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_hp_contracts`
--

DROP TABLE IF EXISTS `geopos_hp_contracts`;
CREATE TABLE IF NOT EXISTS `geopos_hp_contracts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `invoice_id` int DEFAULT NULL,
  `total_amount` decimal(16,2) NOT NULL,
  `down_payment` decimal(16,2) NOT NULL,
  `interest_rate` decimal(5,2) NOT NULL,
  `interest_amount` decimal(16,2) NOT NULL,
  `installment_amount` decimal(16,2) NOT NULL,
  `num_installments` int NOT NULL,
  `frequency` enum('daily','weekly','monthly') NOT NULL DEFAULT 'monthly',
  `start_date` date NOT NULL,
  `status` enum('pending','active','completed','defaulted') NOT NULL DEFAULT 'pending',
  `loc` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `loc` (`loc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_hp_guarantors`
--

DROP TABLE IF EXISTS `geopos_hp_guarantors`;
CREATE TABLE IF NOT EXISTS `geopos_hp_guarantors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `contract_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `nic` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text,
  PRIMARY KEY (`id`),
  KEY `contract_id` (`contract_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_hp_installments`
--

DROP TABLE IF EXISTS `geopos_hp_installments`;
CREATE TABLE IF NOT EXISTS `geopos_hp_installments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `contract_id` int NOT NULL,
  `installment_num` int NOT NULL,
  `due_date` date NOT NULL,
  `amount` decimal(16,2) NOT NULL,
  `paid_amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `status` enum('unpaid','partially_paid','paid') NOT NULL DEFAULT 'unpaid',
  `payment_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contract_id` (`contract_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_hrm`
--

DROP TABLE IF EXISTS `geopos_hrm`;
CREATE TABLE IF NOT EXISTS `geopos_hrm` (
  `id` int NOT NULL AUTO_INCREMENT,
  `typ` int NOT NULL,
  `rid` int NOT NULL,
  `val1` varchar(255) DEFAULT NULL,
  `val2` varchar(255) DEFAULT NULL,
  `val3` varchar(255) DEFAULT NULL,
  `category_icon` varchar(100) DEFAULT 'fa-tools',
  `commission_rate` decimal(5,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_invoices`
--

DROP TABLE IF EXISTS `geopos_invoices`;
CREATE TABLE IF NOT EXISTS `geopos_invoices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tid` int NOT NULL,
  `invoicedate` date NOT NULL,
  `invoiceduedate` date NOT NULL,
  `subtotal` decimal(16,2) DEFAULT '0.00',
  `shipping` decimal(16,2) DEFAULT '0.00',
  `ship_tax` decimal(16,2) DEFAULT NULL,
  `ship_tax_type` enum('incl','excl','off') DEFAULT 'off',
  `planing` decimal(16,2) DEFAULT '0.00',
  `planing_tax` decimal(16,2) DEFAULT NULL,
  `planing_taxtype` enum('incl','excl','off') DEFAULT 'off',
  `cuttingsawing` decimal(16,2) DEFAULT '0.00',
  `cuttingsawing_tax` decimal(16,2) DEFAULT NULL,
  `cuttingsawing_taxtype` enum('incl','excl','off') DEFAULT 'off',
  `loadingunloading` decimal(16,2) DEFAULT '0.00',
  `loadingunloading_tax` decimal(16,2) DEFAULT NULL,
  `loadingunloading_taxtype` enum('incl','excl','off') DEFAULT 'off',
  `discount` decimal(16,2) DEFAULT '0.00',
  `discount_rate` decimal(10,2) DEFAULT '0.00',
  `tax` decimal(16,2) DEFAULT '0.00',
  `total` decimal(16,2) DEFAULT '0.00',
  `localtotal` decimal(16,2) DEFAULT '0.00',
  `importedtotal` decimal(16,2) DEFAULT '0.00',
  `pmethod` varchar(14) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `status` enum('paid','due','canceled','partial') NOT NULL DEFAULT 'due',
  `csd` int NOT NULL DEFAULT '0',
  `eid` int NOT NULL,
  `pamnt` decimal(16,2) DEFAULT '0.00',
  `items` decimal(10,2) NOT NULL,
  `taxstatus` enum('yes','no','incl','cgst','igst') NOT NULL DEFAULT 'yes',
  `discstatus` tinyint(1) NOT NULL,
  `format_discount` enum('%','flat') NOT NULL DEFAULT '%',
  `refer` varchar(20) DEFAULT NULL,
  `term` int NOT NULL,
  `multi` int DEFAULT NULL,
  `i_class` int NOT NULL DEFAULT '0',
  `loc` int NOT NULL,
  `r_time` varchar(10) DEFAULT NULL,
  `hiding` int NOT NULL DEFAULT '0',
  `local` decimal(16,2) DEFAULT NULL,
  `imported` decimal(16,2) DEFAULT NULL,
  `escrow_id` int DEFAULT NULL COMMENT 'Blueprint: Linked escrow vault entry',
  `contract_ref` varchar(100) DEFAULT NULL COMMENT 'Blueprint: Auto-generated contract reference',
  `ring_request_id` int DEFAULT NULL COMMENT 'Originated from a Ring service request',
  `delete_status` tinyint(1) NOT NULL DEFAULT '0',
  `business_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `eid` (`eid`),
  KEY `csd` (`csd`),
  KEY `invoice` (`tid`) USING BTREE,
  KEY `i_class` (`i_class`),
  KEY `loc` (`loc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_invoice_items`
--

DROP TABLE IF EXISTS `geopos_invoice_items`;
CREATE TABLE IF NOT EXISTS `geopos_invoice_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tid` int NOT NULL,
  `pid` int NOT NULL DEFAULT '0',
  `product` varchar(255) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `qty` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `qty2` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `price` decimal(16,2) NOT NULL DEFAULT '0.00',
  `rate` decimal(16,2) DEFAULT '0.00',
  `tax` decimal(16,2) DEFAULT '0.00',
  `discount` decimal(16,2) DEFAULT '0.00',
  `subtotal` decimal(16,2) DEFAULT '0.00',
  `totaltax` decimal(16,2) DEFAULT '0.00',
  `totaldiscount` decimal(16,2) DEFAULT '0.00',
  `product_des` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `i_class` int NOT NULL DEFAULT '0',
  `unit` varchar(5) DEFAULT NULL,
  `pwith` int DEFAULT NULL,
  `pthickness` decimal(10,4) NOT NULL,
  `pquick` decimal(10,4) NOT NULL,
  `pquick_code` varchar(30) DEFAULT NULL,
  `local_imported` varchar(30) DEFAULT NULL,
  `o_pquick` decimal(10,4) NOT NULL,
  `group_id` int DEFAULT NULL,
  `alert` int DEFAULT NULL,
  `sqft` decimal(10,4) NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_jobs`
--

DROP TABLE IF EXISTS `geopos_jobs`;
CREATE TABLE IF NOT EXISTS `geopos_jobs` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `dept_id` int NOT NULL,
  `hourly_rate_min` decimal(16,2) NOT NULL DEFAULT '0.00',
  `hourly_rate_max` decimal(16,2) NOT NULL DEFAULT '0.00',
  `location` varchar(255) NOT NULL,
  `loc` int NOT NULL DEFAULT '0',
  `status` enum('open','closed','filled') NOT NULL DEFAULT 'open',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_job_applications`
--

DROP TABLE IF EXISTS `geopos_job_applications`;
CREATE TABLE IF NOT EXISTS `geopos_job_applications` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `job_id` int UNSIGNED NOT NULL,
  `worker_id` int UNSIGNED NOT NULL,
  `status` enum('pending','shortlisted','rejected','hired') NOT NULL DEFAULT 'pending',
  `applied_at` datetime DEFAULT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `cover_letter` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_job_codes`
--

DROP TABLE IF EXISTS `geopos_job_codes`;
CREATE TABLE IF NOT EXISTS `geopos_job_codes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `is_active` tinyint(1) DEFAULT '1',
  `hourly_rate` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_job_requests`
--

DROP TABLE IF EXISTS `geopos_job_requests`;
CREATE TABLE IF NOT EXISTS `geopos_job_requests` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `job_title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `district` varchar(50) NOT NULL,
  `budget` decimal(15,2) NOT NULL,
  `status` enum('open','assigned','completed','closed') NOT NULL DEFAULT 'open',
  `loc` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_job_sites`
--

DROP TABLE IF EXISTS `geopos_job_sites`;
CREATE TABLE IF NOT EXISTS `geopos_job_sites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postbox` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_labor_logs`
--

DROP TABLE IF EXISTS `geopos_labor_logs`;
CREATE TABLE IF NOT EXISTS `geopos_labor_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `work_order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `duration_minutes` int DEFAULT '0',
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wo_user` (`work_order_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_locations`
--

DROP TABLE IF EXISTS `geopos_locations`;
CREATE TABLE IF NOT EXISTS `geopos_locations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cname` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `region` varchar(40) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `postbox` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `taxid` varchar(40) DEFAULT NULL,
  `logo` varchar(50) DEFAULT 'logo.png',
  `cur` int NOT NULL,
  `ware` int DEFAULT '0',
  `ext` varchar(255) DEFAULT NULL,
  `gps_lat` decimal(10,8) DEFAULT NULL COMMENT 'Blueprint: Location GPS latitude',
  `gps_lng` decimal(11,8) DEFAULT NULL COMMENT 'Blueprint: Location GPS longitude',
  `district` varchar(100) DEFAULT NULL COMMENT 'Administrative district',
  `province` varchar(100) DEFAULT NULL COMMENT 'Administrative province',
  `contact_whatsapp` varchar(20) DEFAULT NULL COMMENT 'WhatsApp number for this location',
  `location_type` enum('warehouse','showroom','office','depot','hub') NOT NULL DEFAULT 'warehouse' COMMENT 'Blueprint: Location classification',
  `delete_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_log`
--

DROP TABLE IF EXISTS `geopos_log`;
CREATE TABLE IF NOT EXISTS `geopos_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `note` mediumtext NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_login_attempts`
--

DROP TABLE IF EXISTS `geopos_login_attempts`;
CREATE TABLE IF NOT EXISTS `geopos_login_attempts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(39) DEFAULT '0',
  `timestamp` datetime DEFAULT NULL,
  `login_attempts` tinyint DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_logistics_fleet`
--

DROP TABLE IF EXISTS `geopos_logistics_fleet`;
CREATE TABLE IF NOT EXISTS `geopos_logistics_fleet` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `vehicle_no` varchar(50) NOT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `driver_name` varchar(100) NOT NULL,
  `driver_phone` varchar(30) NOT NULL,
  `capacity` varchar(50) NOT NULL,
  `loc` int NOT NULL DEFAULT '0',
  `status` enum('active','maintenance','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_logistics_orders`
--

DROP TABLE IF EXISTS `geopos_logistics_orders`;
CREATE TABLE IF NOT EXISTS `geopos_logistics_orders` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `vehicle_id` int NOT NULL,
  `pickup_loc` varchar(255) NOT NULL,
  `delivery_loc` varchar(255) NOT NULL,
  `status` enum('dispatched','in_transit','delivered','returned') NOT NULL DEFAULT 'dispatched',
  `loc` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_loss_logs`
--

DROP TABLE IF EXISTS `geopos_loss_logs`;
CREATE TABLE IF NOT EXISTS `geopos_loss_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `branch_id` int NOT NULL,
  `type` varchar(50) NOT NULL,
  `amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_marketplace_hardware`
--

DROP TABLE IF EXISTS `geopos_marketplace_hardware`;
CREATE TABLE IF NOT EXISTS `geopos_marketplace_hardware` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lot_name` varchar(255) DEFAULT NULL,
  `seller_id` int DEFAULT NULL,
  `warehouse_id` int DEFAULT NULL,
  `selling_price` decimal(15,2) DEFAULT '0.00',
  `total_price` decimal(15,2) DEFAULT '0.00',
  `district` varchar(100) DEFAULT NULL,
  `status` enum('available','sold','deleted') DEFAULT 'available',
  `photos` text,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_marketplace_requests`
--

DROP TABLE IF EXISTS `geopos_marketplace_requests`;
CREATE TABLE IF NOT EXISTS `geopos_marketplace_requests` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `budget` decimal(10,2) NOT NULL DEFAULT '0.00',
  `location` varchar(255) NOT NULL,
  `status` enum('active','closed') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_marketplace_services`
--

DROP TABLE IF EXISTS `geopos_marketplace_services`;
CREATE TABLE IF NOT EXISTS `geopos_marketplace_services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lot_name` varchar(255) DEFAULT NULL,
  `seller_id` int DEFAULT NULL,
  `warehouse_id` int DEFAULT NULL,
  `selling_price` decimal(15,2) DEFAULT '0.00',
  `total_price` decimal(15,2) DEFAULT '0.00',
  `district` varchar(100) DEFAULT NULL,
  `status` enum('available','sold','deleted') DEFAULT 'available',
  `photos` text,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_marketplace_settings`
--

DROP TABLE IF EXISTS `geopos_marketplace_settings`;
CREATE TABLE IF NOT EXISTS `geopos_marketplace_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `auto_share_enabled` tinyint(1) DEFAULT '0',
  `platforms` text COMMENT 'JSON array of enabled platforms',
  `share_template` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_marketplace_shares`
--

DROP TABLE IF EXISTS `geopos_marketplace_shares`;
CREATE TABLE IF NOT EXISTS `geopos_marketplace_shares` (
  `id` int NOT NULL AUTO_INCREMENT,
  `listing_id` int NOT NULL,
  `listing_type` varchar(20) NOT NULL COMMENT 'logs, standing, sawn',
  `user_id` int DEFAULT NULL,
  `platform` varchar(50) NOT NULL COMMENT 'facebook, twitter, linkedin, whatsapp, telegram, email',
  `share_url` varchar(255) DEFAULT NULL,
  `clicks` int DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `listing_id` (`listing_id`),
  KEY `user_id` (`user_id`),
  KEY `platform` (`platform`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_market_requests`
--

DROP TABLE IF EXISTS `geopos_market_requests`;
CREATE TABLE IF NOT EXISTS `geopos_market_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `quantity_needed` decimal(10,2) DEFAULT '0.00',
  `budget_range` varchar(100) DEFAULT NULL,
  `description` text,
  `status` enum('active','closed','fulfilled') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_metadata`
--

DROP TABLE IF EXISTS `geopos_metadata`;
CREATE TABLE IF NOT EXISTS `geopos_metadata` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` int NOT NULL,
  `rid` int NOT NULL,
  `col1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `col2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `d_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `rid` (`rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_milestones`
--

DROP TABLE IF EXISTS `geopos_milestones`;
CREATE TABLE IF NOT EXISTS `geopos_milestones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pid` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `sdate` date NOT NULL,
  `edate` date NOT NULL,
  `exp` text NOT NULL,
  `color` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_modules`
--

DROP TABLE IF EXISTS `geopos_modules`;
CREATE TABLE IF NOT EXISTS `geopos_modules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `module` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_movers`
--

DROP TABLE IF EXISTS `geopos_movers`;
CREATE TABLE IF NOT EXISTS `geopos_movers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `d_type` int NOT NULL,
  `rid1` int NOT NULL,
  `rid2` int NOT NULL,
  `rid3` int NOT NULL,
  `d_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `note` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `d_type` (`d_type`,`rid1`,`rid2`,`rid3`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_notes`
--

DROP TABLE IF EXISTS `geopos_notes`;
CREATE TABLE IF NOT EXISTS `geopos_notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `cdate` date NOT NULL,
  `last_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cid` int NOT NULL DEFAULT '0',
  `fid` int NOT NULL DEFAULT '0',
  `rid` int NOT NULL DEFAULT '0',
  `ntype` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_overtime_rules`
--

DROP TABLE IF EXISTS `geopos_overtime_rules`;
CREATE TABLE IF NOT EXISTS `geopos_overtime_rules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `multiplier` decimal(4,2) NOT NULL DEFAULT '1.50',
  `is_active` tinyint(1) DEFAULT '1',
  `type` varchar(50) DEFAULT 'daily',
  `threshold_hours` decimal(10,2) DEFAULT '8.00',
  `rate_multiplier` decimal(4,2) NOT NULL DEFAULT '1.50',
  `eligible_departments` json DEFAULT NULL,
  `requires_approval` tinyint(1) DEFAULT '0',
  `calculation_basis` enum('Basic','Hourly','Daily') DEFAULT 'Hourly',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_packages`
--

DROP TABLE IF EXISTS `geopos_packages`;
CREATE TABLE IF NOT EXISTS `geopos_packages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `package_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `location_limit` int NOT NULL DEFAULT '1',
  `commission_rate` decimal(5,2) NOT NULL DEFAULT '0.00',
  `ai_ads_limit` int NOT NULL DEFAULT '0',
  `delete_status` tinyint(1) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_payroll`
--

DROP TABLE IF EXISTS `geopos_payroll`;
CREATE TABLE IF NOT EXISTS `geopos_payroll` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `emp_id` int NOT NULL,
  `month` int NOT NULL,
  `year` int NOT NULL,
  `basic_salary` decimal(16,2) NOT NULL,
  `overtime_amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `deductions` decimal(16,2) NOT NULL DEFAULT '0.00',
  `bonus` decimal(16,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(16,2) NOT NULL DEFAULT '0.00',
  `net_pay` decimal(16,2) NOT NULL,
  `payment_date` datetime NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Paid',
  `note` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_payroll_approvals`
--

DROP TABLE IF EXISTS `geopos_payroll_approvals`;
CREATE TABLE IF NOT EXISTS `geopos_payroll_approvals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `run_id` int NOT NULL,
  `approver_id` int NOT NULL,
  `status` varchar(20) NOT NULL,
  `comments` text,
  `approved_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_payroll_bonuses`
--

DROP TABLE IF EXISTS `geopos_payroll_bonuses`;
CREATE TABLE IF NOT EXISTS `geopos_payroll_bonuses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL,
  `amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `type` varchar(50) NOT NULL COMMENT 'Performance, Annual, Spot',
  `note` varchar(255) DEFAULT NULL,
  `date_effective` date NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_payroll_config`
--

DROP TABLE IF EXISTS `geopos_payroll_config`;
CREATE TABLE IF NOT EXISTS `geopos_payroll_config` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `value` text,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_payroll_config_old`
--

DROP TABLE IF EXISTS `geopos_payroll_config_old`;
CREATE TABLE IF NOT EXISTS `geopos_payroll_config_old` (
  `id` int NOT NULL AUTO_INCREMENT,
  `config_key` varchar(100) NOT NULL,
  `config_value` json DEFAULT NULL,
  `description` text,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `config_key` (`config_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_payroll_general_settings`
--

DROP TABLE IF EXISTS `geopos_payroll_general_settings`;
CREATE TABLE IF NOT EXISTS `geopos_payroll_general_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pay_frequency` enum('Daily','Weekly','Bi-Weekly','Monthly') DEFAULT 'Daily',
  `pay_period_start_day` int DEFAULT '1',
  `pay_period_end_day` int DEFAULT '31',
  `payment_day` int DEFAULT '5',
  `currency` varchar(10) DEFAULT 'LKR',
  `work_days_per_week` decimal(3,1) DEFAULT '5.0',
  `work_hours_per_day` decimal(4,2) DEFAULT '8.00',
  `overtime_auto_detect` tinyint(1) DEFAULT '1',
  `leave_encashment_enabled` tinyint(1) DEFAULT '0',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_payroll_items`
--

DROP TABLE IF EXISTS `geopos_payroll_items`;
CREATE TABLE IF NOT EXISTS `geopos_payroll_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `run_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `total_hours` decimal(10,2) DEFAULT '0.00',
  `gross_pay` decimal(16,2) DEFAULT '0.00',
  `tax` decimal(16,2) DEFAULT '0.00',
  `total_deductions` decimal(16,2) DEFAULT '0.00',
  `net_pay` decimal(16,2) DEFAULT '0.00',
  `deduction_details` json DEFAULT NULL,
  `cola_amount` decimal(10,2) DEFAULT '0.00',
  `overtime_pay` decimal(10,2) DEFAULT '0.00',
  `epf_employee` decimal(10,2) DEFAULT '0.00',
  `epf_employer` decimal(10,2) DEFAULT '0.00',
  `etf_employer` decimal(10,2) DEFAULT '0.00',
  `loan_deduction` decimal(10,2) DEFAULT '0.00',
  `other_deductions` decimal(10,2) DEFAULT '0.00',
  `basic_salary` decimal(10,2) DEFAULT '0.00',
  `bonus_amount` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `run_id` (`run_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_payroll_runs`
--

DROP TABLE IF EXISTS `geopos_payroll_runs`;
CREATE TABLE IF NOT EXISTS `geopos_payroll_runs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_created` date NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_amount` decimal(16,2) DEFAULT '0.00',
  `total_tax` decimal(16,2) DEFAULT '0.00',
  `status` varchar(20) DEFAULT 'Draft',
  `approval_status` varchar(20) DEFAULT 'Draft',
  `accounting_posted` tinyint(1) DEFAULT '0',
  `accounting_posted_date` datetime DEFAULT NULL,
  `payment_posted` tinyint(1) DEFAULT '0',
  `payment_posted_date` datetime DEFAULT NULL,
  `approved_by` int DEFAULT NULL,
  `approved_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_payroll_statutory`
--

DROP TABLE IF EXISTS `geopos_payroll_statutory`;
CREATE TABLE IF NOT EXISTS `geopos_payroll_statutory` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `rate` decimal(5,2) NOT NULL,
  `type` enum('Employee_Deduction','Employer_Contribution') NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_payroll_workflow`
--

DROP TABLE IF EXISTS `geopos_payroll_workflow`;
CREATE TABLE IF NOT EXISTS `geopos_payroll_workflow` (
  `id` int NOT NULL AUTO_INCREMENT,
  `run_id` int NOT NULL,
  `approver_id` int NOT NULL,
  `action` enum('Submitted','Approved','Rejected') DEFAULT 'Submitted',
  `comments` text,
  `action_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `run_id` (`run_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_pms`
--

DROP TABLE IF EXISTS `geopos_pms`;
CREATE TABLE IF NOT EXISTS `geopos_pms` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `sender_id` int UNSIGNED NOT NULL,
  `receiver_id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text,
  `date_sent` datetime DEFAULT NULL,
  `date_read` datetime DEFAULT NULL,
  `pm_deleted_sender` int NOT NULL,
  `pm_deleted_receiver` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `full_index` (`id`,`sender_id`,`receiver_id`,`date_read`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_production_bom`
--

DROP TABLE IF EXISTS `geopos_production_bom`;
CREATE TABLE IF NOT EXISTS `geopos_production_bom` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `company_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_production_bom_items`
--

DROP TABLE IF EXISTS `geopos_production_bom_items`;
CREATE TABLE IF NOT EXISTS `geopos_production_bom_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bom_id` int NOT NULL,
  `product_id` int NOT NULL,
  `qty` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `unit` varchar(20) DEFAULT NULL,
  `type` enum('raw_material','sub_assembly') DEFAULT 'raw_material',
  `waste_percent` decimal(5,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `bom_id` (`bom_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_production_orders`
--

DROP TABLE IF EXISTS `geopos_production_orders`;
CREATE TABLE IF NOT EXISTS `geopos_production_orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `bom_id` int DEFAULT NULL,
  `qty_to_produce` int NOT NULL,
  `status` enum('Planned','In Progress','Completed','Cancelled') DEFAULT 'Planned',
  `due_date` date DEFAULT NULL,
  `priority` enum('Normal','High','Urgent') DEFAULT 'Normal',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `company_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_production_qc_logs`
--

DROP TABLE IF EXISTS `geopos_production_qc_logs`;
CREATE TABLE IF NOT EXISTS `geopos_production_qc_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `work_order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `result` enum('Pass','Fail') NOT NULL,
  `notes` text,
  `checklist_response` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_production_qc_templates`
--

DROP TABLE IF EXISTS `geopos_production_qc_templates`;
CREATE TABLE IF NOT EXISTS `geopos_production_qc_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `product_id` int DEFAULT NULL,
  `checklist_data` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_production_skills`
--

DROP TABLE IF EXISTS `geopos_production_skills`;
CREATE TABLE IF NOT EXISTS `geopos_production_skills` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `skill_name` varchar(100) NOT NULL,
  `proficiency_level` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_production_stages`
--

DROP TABLE IF EXISTS `geopos_production_stages`;
CREATE TABLE IF NOT EXISTS `geopos_production_stages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `stage_order` int NOT NULL DEFAULT '0',
  `description` text,
  `company_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_production_stage_history`
--

DROP TABLE IF EXISTS `geopos_production_stage_history`;
CREATE TABLE IF NOT EXISTS `geopos_production_stage_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `work_order_id` int NOT NULL,
  `prev_stage` varchar(50) DEFAULT NULL,
  `new_stage` varchar(50) NOT NULL,
  `user_id` int NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_products`
--

DROP TABLE IF EXISTS `geopos_products`;
CREATE TABLE IF NOT EXISTS `geopos_products` (
  `pid` int NOT NULL AUTO_INCREMENT,
  `pcat` int NOT NULL DEFAULT '1',
  `warehouse` int NOT NULL DEFAULT '1',
  `product_name` varchar(160) NOT NULL,
  `product_code` varchar(30) DEFAULT NULL,
  `product_price` decimal(16,2) DEFAULT '0.00',
  `rate` decimal(16,2) DEFAULT '0.00',
  `fproduct_price` decimal(16,2) DEFAULT '0.00',
  `taxrate` decimal(16,2) DEFAULT '0.00',
  `disrate` decimal(16,2) DEFAULT '0.00',
  `qty` decimal(10,4) NOT NULL,
  `qty_reserved` decimal(16,4) DEFAULT '0.0000',
  `qty2` decimal(10,4) NOT NULL,
  `product_des` text NOT NULL,
  `alert` int DEFAULT NULL,
  `unit` varchar(6) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `image` varchar(120) DEFAULT 'default.png',
  `barcode` varchar(16) DEFAULT NULL,
  `merge` int NOT NULL,
  `sub` int NOT NULL,
  `vb` int NOT NULL,
  `expiry` date DEFAULT NULL,
  `code_type` varchar(8) DEFAULT 'EAN13',
  `sub_id` int DEFAULT '0',
  `b_id` int DEFAULT '0',
  `wastage` decimal(10,2) NOT NULL,
  `pwith` int DEFAULT NULL,
  `pthickness` decimal(10,4) NOT NULL,
  `pquick` decimal(10,4) NOT NULL,
  `sqft` decimal(10,4) NOT NULL,
  `pquick_code` varchar(30) DEFAULT NULL,
  `fproduct_cost` decimal(16,2) DEFAULT '0.00',
  `local_imported` varchar(10) DEFAULT NULL,
  `sale_mode` enum('sale','rent','installment','all') NOT NULL DEFAULT 'sale' COMMENT 'Blueprint: Triple-Mode Logic',
  `rent_price_day` decimal(16,2) DEFAULT '0.00' COMMENT 'Daily rental rate',
  `rent_deposit` decimal(16,2) DEFAULT '0.00' COMMENT 'Security deposit for rental',
  `is_marketplace_listed` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Listed on Timber Marketplace',
  `marketplace_expires` date DEFAULT NULL COMMENT 'Marketplace listing expiry',
  `is_sale` tinyint(1) DEFAULT '1',
  `is_rent` tinyint(1) DEFAULT '0',
  `is_installment` tinyint(1) DEFAULT '0',
  `master_pid` int DEFAULT '0',
  `special_category` varchar(100) DEFAULT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '0',
  `business_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`),
  KEY `pcat` (`pcat`),
  KEY `warehouse` (`warehouse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_product_cat`
--

DROP TABLE IF EXISTS `geopos_product_cat`;
CREATE TABLE IF NOT EXISTS `geopos_product_cat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `extra` varchar(255) DEFAULT NULL,
  `c_type` int DEFAULT '0',
  `rel_id` int DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `requested_by` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_projects`
--

DROP TABLE IF EXISTS `geopos_projects`;
CREATE TABLE IF NOT EXISTS `geopos_projects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `p_id` varchar(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` enum('Waiting','Pending','Terminated','Finished','Progress') NOT NULL DEFAULT 'Pending',
  `priority` enum('Low','Medium','High','Urgent') NOT NULL DEFAULT 'Medium',
  `progress` int NOT NULL,
  `cid` int NOT NULL,
  `sdate` date NOT NULL,
  `edate` date NOT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `phase` varchar(255) DEFAULT NULL,
  `note` text,
  `worth` decimal(16,2) NOT NULL DEFAULT '0.00',
  `ptype` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `p_id` (`p_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_project_meta`
--

DROP TABLE IF EXISTS `geopos_project_meta`;
CREATE TABLE IF NOT EXISTS `geopos_project_meta` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pid` int NOT NULL,
  `meta_key` int NOT NULL,
  `meta_data` varchar(200) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `key3` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `meta_key` (`meta_key`),
  KEY `key3` (`key3`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_promo`
--

DROP TABLE IF EXISTS `geopos_promo`;
CREATE TABLE IF NOT EXISTS `geopos_promo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(15) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `valid` date NOT NULL,
  `active` int NOT NULL,
  `note` varchar(100) NOT NULL,
  `reflect` int NOT NULL,
  `qty` int NOT NULL,
  `available` int NOT NULL,
  `location` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_2` (`code`),
  KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_purchase`
--

DROP TABLE IF EXISTS `geopos_purchase`;
CREATE TABLE IF NOT EXISTS `geopos_purchase` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tid` int NOT NULL,
  `invoicedate` date NOT NULL,
  `invoiceduedate` date NOT NULL,
  `subtotal` decimal(16,2) DEFAULT '0.00',
  `shipping` decimal(16,2) DEFAULT '0.00',
  `ship_tax` decimal(16,2) DEFAULT NULL,
  `ship_tax_type` enum('incl','excl','off') DEFAULT 'off',
  `planing` decimal(16,2) DEFAULT '0.00',
  `planing_tax` decimal(16,2) DEFAULT NULL,
  `planing_taxtype` enum('incl','excl','off') DEFAULT 'off',
  `cuttingsawing` decimal(16,2) DEFAULT '0.00',
  `cuttingsawing_tax` decimal(16,2) DEFAULT NULL,
  `cuttingsawing_taxtype` enum('incl','excl','off') DEFAULT 'off',
  `loadingunloading` decimal(16,2) DEFAULT '0.00',
  `loadingunloading_tax` decimal(16,2) DEFAULT NULL,
  `loadingunloading_taxtype` enum('incl','excl','off') DEFAULT 'off',
  `discount` decimal(16,2) DEFAULT '0.00',
  `discount_rate` decimal(10,2) DEFAULT '0.00',
  `tax` decimal(16,2) DEFAULT '0.00',
  `total` decimal(16,2) DEFAULT '0.00',
  `localtotal` decimal(16,2) DEFAULT '0.00',
  `importedtotal` decimal(16,2) DEFAULT '0.00',
  `pmethod` varchar(14) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `status` enum('paid','due','canceled','partial') NOT NULL DEFAULT 'due',
  `csd` int NOT NULL DEFAULT '0',
  `eid` int NOT NULL,
  `pamnt` decimal(16,2) DEFAULT '0.00',
  `items` decimal(10,2) NOT NULL,
  `taxstatus` enum('yes','no','incl','cgst','igst') NOT NULL DEFAULT 'yes',
  `discstatus` tinyint(1) NOT NULL,
  `format_discount` enum('%','flat') NOT NULL DEFAULT '%',
  `refer` varchar(20) DEFAULT NULL,
  `term` int NOT NULL,
  `multi` int DEFAULT NULL,
  `i_class` int NOT NULL DEFAULT '0',
  `loc` int NOT NULL,
  `r_time` varchar(10) DEFAULT NULL,
  `hiding` int NOT NULL DEFAULT '0',
  `local` decimal(16,2) DEFAULT NULL,
  `imported` decimal(16,2) DEFAULT NULL,
  `business_id` int UNSIGNED DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `eid` (`eid`),
  KEY `csd` (`csd`),
  KEY `invoice` (`tid`) USING BTREE,
  KEY `i_class` (`i_class`),
  KEY `loc` (`loc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_purchase_items`
--

DROP TABLE IF EXISTS `geopos_purchase_items`;
CREATE TABLE IF NOT EXISTS `geopos_purchase_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tid` int NOT NULL,
  `pid` int NOT NULL DEFAULT '0',
  `product` varchar(255) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `qty` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `qty2` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `price` decimal(16,2) NOT NULL DEFAULT '0.00',
  `rate` decimal(16,2) DEFAULT '0.00',
  `tax` decimal(16,2) DEFAULT '0.00',
  `discount` decimal(16,2) DEFAULT '0.00',
  `subtotal` decimal(16,2) DEFAULT '0.00',
  `totaltax` decimal(16,2) DEFAULT '0.00',
  `totaldiscount` decimal(16,2) DEFAULT '0.00',
  `product_des` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `i_class` int NOT NULL DEFAULT '0',
  `unit` varchar(5) DEFAULT NULL,
  `pwith` int DEFAULT NULL,
  `pthickness` decimal(10,4) NOT NULL,
  `pquick` decimal(10,4) NOT NULL,
  `pquick_code` varchar(30) DEFAULT NULL,
  `local_imported` varchar(30) DEFAULT NULL,
  `o_pquick` decimal(10,4) NOT NULL,
  `group_id` int DEFAULT NULL,
  `alert` int DEFAULT NULL,
  `sqft` decimal(10,4) NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_purchase_items_logs`
--

DROP TABLE IF EXISTS `geopos_purchase_items_logs`;
CREATE TABLE IF NOT EXISTS `geopos_purchase_items_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tid` int NOT NULL,
  `pid` int NOT NULL DEFAULT '0',
  `product` varchar(255) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `qty` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `qty2` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `price` decimal(16,2) NOT NULL DEFAULT '0.00',
  `rate` decimal(16,2) DEFAULT '0.00',
  `tax` decimal(16,2) DEFAULT '0.00',
  `discount` decimal(16,2) DEFAULT '0.00',
  `subtotal` decimal(16,2) DEFAULT '0.00',
  `totaltax` decimal(16,2) DEFAULT '0.00',
  `totaldiscount` decimal(16,2) DEFAULT '0.00',
  `product_des` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `i_class` int NOT NULL DEFAULT '0',
  `unit` varchar(5) DEFAULT NULL,
  `pwith` int DEFAULT NULL,
  `pthickness` decimal(10,4) NOT NULL,
  `pquick` decimal(10,4) NOT NULL,
  `pquick_code` varchar(30) DEFAULT NULL,
  `local_imported` varchar(30) DEFAULT NULL,
  `o_pquick` decimal(10,4) NOT NULL,
  `group_id` int DEFAULT NULL,
  `alert` int DEFAULT NULL,
  `sqft` decimal(10,4) NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_purchase_items_wood`
--

DROP TABLE IF EXISTS `geopos_purchase_items_wood`;
CREATE TABLE IF NOT EXISTS `geopos_purchase_items_wood` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tid` int NOT NULL,
  `pid` int NOT NULL,
  `product` varchar(255) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `qty` decimal(10,4) NOT NULL,
  `price` decimal(16,2) DEFAULT '0.00',
  `tax` decimal(16,2) DEFAULT '0.00',
  `discount` decimal(16,2) DEFAULT '0.00',
  `subtotal` decimal(16,2) DEFAULT '0.00',
  `totaltax` decimal(16,2) DEFAULT '0.00',
  `totaldiscount` decimal(16,2) DEFAULT '0.00',
  `product_des` text,
  `unit` varchar(5) DEFAULT NULL,
  `pwith` int DEFAULT NULL,
  `pthickness` decimal(10,4) NOT NULL,
  `pquick` decimal(10,4) NOT NULL,
  `pquick_code` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice` (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_purchase_logs`
--

DROP TABLE IF EXISTS `geopos_purchase_logs`;
CREATE TABLE IF NOT EXISTS `geopos_purchase_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tid` int NOT NULL,
  `invoicedate` date NOT NULL,
  `invoiceduedate` date NOT NULL,
  `subtotal` decimal(16,2) DEFAULT '0.00',
  `shipping` decimal(16,2) DEFAULT '0.00',
  `ship_tax` decimal(16,2) DEFAULT NULL,
  `ship_tax_type` enum('incl','excl','off') DEFAULT 'off',
  `planing` decimal(16,2) DEFAULT '0.00',
  `planing_tax` decimal(16,2) DEFAULT NULL,
  `planing_taxtype` enum('incl','excl','off') DEFAULT 'off',
  `cuttingsawing` decimal(16,2) DEFAULT '0.00',
  `cuttingsawing_tax` decimal(16,2) DEFAULT NULL,
  `cuttingsawing_taxtype` enum('incl','excl','off') DEFAULT 'off',
  `loadingunloading` decimal(16,2) DEFAULT '0.00',
  `loadingunloading_tax` decimal(16,2) DEFAULT NULL,
  `loadingunloading_taxtype` enum('incl','excl','off') DEFAULT 'off',
  `discount` decimal(16,2) DEFAULT '0.00',
  `discount_rate` decimal(10,2) DEFAULT '0.00',
  `tax` decimal(16,2) DEFAULT '0.00',
  `total` decimal(16,2) DEFAULT '0.00',
  `localtotal` decimal(16,2) DEFAULT '0.00',
  `importedtotal` decimal(16,2) DEFAULT '0.00',
  `pmethod` varchar(14) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `status` enum('paid','due','canceled','partial') NOT NULL DEFAULT 'due',
  `csd` int NOT NULL DEFAULT '0',
  `eid` int NOT NULL,
  `pamnt` decimal(16,2) DEFAULT '0.00',
  `items` decimal(10,2) NOT NULL,
  `taxstatus` enum('yes','no','incl','cgst','igst') NOT NULL DEFAULT 'yes',
  `discstatus` tinyint(1) NOT NULL,
  `format_discount` enum('%','flat') NOT NULL DEFAULT '%',
  `refer` varchar(20) DEFAULT NULL,
  `term` int NOT NULL,
  `multi` int DEFAULT NULL,
  `i_class` int NOT NULL DEFAULT '0',
  `loc` int NOT NULL,
  `r_time` varchar(10) DEFAULT NULL,
  `hiding` int NOT NULL DEFAULT '0',
  `local` decimal(16,2) DEFAULT NULL,
  `imported` decimal(16,2) DEFAULT NULL,
  `pquick` varchar(50) DEFAULT NULL,
  `district` varchar(50) DEFAULT '',
  `location_gps` varchar(100) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `eid` (`eid`),
  KEY `csd` (`csd`),
  KEY `invoice` (`tid`) USING BTREE,
  KEY `i_class` (`i_class`),
  KEY `loc` (`loc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_purchase_wood`
--

DROP TABLE IF EXISTS `geopos_purchase_wood`;
CREATE TABLE IF NOT EXISTS `geopos_purchase_wood` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tid` int NOT NULL,
  `invoicedate` date NOT NULL,
  `invoiceduedate` date NOT NULL,
  `subtotal` decimal(16,2) DEFAULT '0.00',
  `shipping` decimal(16,2) DEFAULT '0.00',
  `ship_tax` decimal(16,2) DEFAULT NULL,
  `ship_tax_type` enum('incl','excl','off') DEFAULT 'off',
  `discount` decimal(16,2) DEFAULT '0.00',
  `tax` decimal(16,2) DEFAULT '0.00',
  `total` decimal(16,2) DEFAULT '0.00',
  `pmethod` varchar(14) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `status` enum('paid','due','canceled','partial') DEFAULT 'due',
  `csd` int NOT NULL DEFAULT '0',
  `eid` int NOT NULL,
  `pamnt` decimal(16,2) DEFAULT '0.00',
  `items` decimal(10,2) NOT NULL,
  `taxstatus` enum('yes','no','incl','cgst','igst') DEFAULT 'yes',
  `discstatus` tinyint(1) NOT NULL,
  `format_discount` enum('%','flat') DEFAULT NULL,
  `refer` varchar(20) DEFAULT NULL,
  `term` int NOT NULL,
  `loc` int NOT NULL,
  `multi` int DEFAULT NULL,
  `pquick` varchar(50) DEFAULT NULL,
  `wquick` varchar(50) DEFAULT NULL,
  `quickwastage` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice` (`tid`),
  KEY `eid` (`eid`),
  KEY `csd` (`csd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_quotes`
--

DROP TABLE IF EXISTS `geopos_quotes`;
CREATE TABLE IF NOT EXISTS `geopos_quotes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tid` int NOT NULL,
  `invoicedate` date NOT NULL,
  `invoiceduedate` date NOT NULL,
  `subtotal` decimal(16,2) DEFAULT '0.00',
  `shipping` decimal(16,2) DEFAULT '0.00',
  `ship_tax` decimal(16,2) DEFAULT NULL,
  `ship_tax_type` enum('incl','excl','off') DEFAULT 'off',
  `discount` decimal(16,2) DEFAULT '0.00',
  `tax` decimal(16,2) DEFAULT '0.00',
  `total` decimal(16,2) DEFAULT '0.00',
  `pmethod` varchar(14) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `csd` int NOT NULL DEFAULT '0',
  `eid` int NOT NULL,
  `pamnt` decimal(16,2) NOT NULL,
  `items` decimal(10,2) NOT NULL,
  `taxstatus` enum('yes','no','incl','cgst','igst') DEFAULT 'yes',
  `discstatus` tinyint(1) NOT NULL,
  `format_discount` enum('%','flat') DEFAULT '%',
  `refer` varchar(20) DEFAULT NULL,
  `term` int NOT NULL,
  `proposal` text,
  `multi` int DEFAULT NULL,
  `loc` int NOT NULL,
  `business_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice` (`tid`),
  KEY `eid` (`eid`),
  KEY `csd` (`csd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_quotes_items`
--

DROP TABLE IF EXISTS `geopos_quotes_items`;
CREATE TABLE IF NOT EXISTS `geopos_quotes_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tid` int NOT NULL,
  `pid` int NOT NULL,
  `product` varchar(255) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `qty` decimal(10,4) NOT NULL,
  `price` decimal(16,2) DEFAULT '0.00',
  `tax` decimal(16,2) DEFAULT '0.00',
  `discount` decimal(16,2) DEFAULT '0.00',
  `subtotal` decimal(16,2) DEFAULT '0.00',
  `totaltax` decimal(16,2) DEFAULT '0.00',
  `totaldiscount` decimal(16,2) DEFAULT '0.00',
  `product_des` text,
  `unit` varchar(5) NOT NULL,
  `pwith` int DEFAULT NULL,
  `pthickness` decimal(10,4) NOT NULL,
  `pquick` decimal(10,4) NOT NULL,
  `pquick_code` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice` (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_quote_bids`
--

DROP TABLE IF EXISTS `geopos_quote_bids`;
CREATE TABLE IF NOT EXISTS `geopos_quote_bids` (
  `id` int NOT NULL AUTO_INCREMENT,
  `request_id` int NOT NULL,
  `seller_id` int NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `notes` text,
  `delivery_days` int NOT NULL DEFAULT '7',
  `status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `submitted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `request_id` (`request_id`),
  KEY `seller_id` (`seller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_quote_requests`
--

DROP TABLE IF EXISTS `geopos_quote_requests`;
CREATE TABLE IF NOT EXISTS `geopos_quote_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text,
  `quantity` varchar(50) DEFAULT NULL,
  `budget_min` decimal(15,2) NOT NULL DEFAULT '0.00',
  `budget_max` decimal(15,2) NOT NULL DEFAULT '0.00',
  `province` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `lat` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `lng` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `radius_km` int NOT NULL DEFAULT '50',
  `status` enum('open','bids_received','accepted','completed','cancelled') NOT NULL DEFAULT 'open',
  `expires_at` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`),
  KEY `district` (`district`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_register`
--

DROP TABLE IF EXISTS `geopos_register`;
CREATE TABLE IF NOT EXISTS `geopos_register` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uid` int NOT NULL,
  `o_date` datetime NOT NULL,
  `c_date` datetime NOT NULL,
  `cash` decimal(16,2) NOT NULL,
  `card` decimal(16,2) NOT NULL,
  `bank` decimal(16,2) NOT NULL,
  `cheque` decimal(16,2) NOT NULL,
  `r_change` decimal(16,2) NOT NULL,
  `active` int NOT NULL DEFAULT '0',
  `business_id` int UNSIGNED DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_reports`
--

DROP TABLE IF EXISTS `geopos_reports`;
CREATE TABLE IF NOT EXISTS `geopos_reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `month` varchar(10) DEFAULT NULL,
  `year` int NOT NULL,
  `invoices` int NOT NULL,
  `sales` decimal(16,2) DEFAULT '0.00',
  `items` decimal(10,2) NOT NULL,
  `income` decimal(16,2) DEFAULT '0.00',
  `expense` decimal(16,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_restkeys`
--

DROP TABLE IF EXISTS `geopos_restkeys`;
CREATE TABLE IF NOT EXISTS `geopos_restkeys` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `key` varchar(40) DEFAULT NULL,
  `level` int NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` text,
  `date_created` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_risk_alerts`
--

DROP TABLE IF EXISTS `geopos_risk_alerts`;
CREATE TABLE IF NOT EXISTS `geopos_risk_alerts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `company_id` int NOT NULL DEFAULT '0',
  `branch_id` int NOT NULL DEFAULT '0',
  `warehouse_id` int NOT NULL DEFAULT '0',
  `type` varchar(50) NOT NULL,
  `severity` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `status` enum('New','Viewed','Resolved') NOT NULL DEFAULT 'New',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_roles`
--

DROP TABLE IF EXISTS `geopos_roles`;
CREATE TABLE IF NOT EXISTS `geopos_roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_id` int NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `all_access` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_role_permissions`
--

DROP TABLE IF EXISTS `geopos_role_permissions`;
CREATE TABLE IF NOT EXISTS `geopos_role_permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_id` int NOT NULL,
  `module_id` int NOT NULL,
  `can_view` tinyint(1) DEFAULT '0',
  `can_add` tinyint(1) DEFAULT '0',
  `can_edit` tinyint(1) DEFAULT '0',
  `can_delete` tinyint(1) DEFAULT '0',
  `can_demo` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_smtp`
--

DROP TABLE IF EXISTS `geopos_smtp`;
CREATE TABLE IF NOT EXISTS `geopos_smtp` (
  `id` int NOT NULL,
  `host` varchar(100) NOT NULL,
  `port` int NOT NULL,
  `auth` enum('true','false') NOT NULL,
  `auth_type` enum('none','tls','ssl') NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `sender` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_staff_scores`
--

DROP TABLE IF EXISTS `geopos_staff_scores`;
CREATE TABLE IF NOT EXISTS `geopos_staff_scores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `staff_id` int NOT NULL,
  `branch_id` int NOT NULL,
  `override_count` int NOT NULL DEFAULT '0',
  `return_count` int NOT NULL DEFAULT '0',
  `adjustment_count` int NOT NULL DEFAULT '0',
  `trust_score` int NOT NULL DEFAULT '100',
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_date` (`staff_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_stock_health`
--

DROP TABLE IF EXISTS `geopos_stock_health`;
CREATE TABLE IF NOT EXISTS `geopos_stock_health` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `branch_id` int NOT NULL,
  `health_score` int NOT NULL,
  `aging_stock_value` decimal(16,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_stock_r`
--

DROP TABLE IF EXISTS `geopos_stock_r`;
CREATE TABLE IF NOT EXISTS `geopos_stock_r` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tid` int NOT NULL,
  `invoicedate` date NOT NULL,
  `invoiceduedate` date NOT NULL,
  `subtotal` decimal(16,2) DEFAULT '0.00',
  `shipping` decimal(16,2) DEFAULT '0.00',
  `ship_tax` decimal(16,2) DEFAULT NULL,
  `ship_tax_type` enum('incl','excl','off') DEFAULT 'off',
  `discount` decimal(16,2) DEFAULT '0.00',
  `tax` decimal(16,2) DEFAULT '0.00',
  `total` decimal(16,2) DEFAULT '0.00',
  `pmethod` varchar(14) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `status` enum('pending','accepted','rejected','partial','canceled') DEFAULT 'pending',
  `csd` int NOT NULL DEFAULT '0',
  `eid` int NOT NULL,
  `pamnt` decimal(16,2) DEFAULT '0.00',
  `items` decimal(10,0) NOT NULL,
  `taxstatus` enum('yes','no','incl','cgst','igst') DEFAULT 'yes',
  `discstatus` tinyint(1) NOT NULL,
  `format_discount` enum('%','flat') DEFAULT NULL,
  `refer` varchar(20) DEFAULT NULL,
  `term` int NOT NULL,
  `loc` int NOT NULL,
  `i_class` int NOT NULL DEFAULT '0',
  `multi` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice` (`tid`),
  KEY `eid` (`eid`),
  KEY `csd` (`csd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_stock_r_items`
--

DROP TABLE IF EXISTS `geopos_stock_r_items`;
CREATE TABLE IF NOT EXISTS `geopos_stock_r_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tid` int NOT NULL,
  `pid` int NOT NULL,
  `product` varchar(255) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `qty` decimal(10,4) NOT NULL,
  `price` decimal(16,2) DEFAULT '0.00',
  `tax` decimal(16,2) DEFAULT '0.00',
  `discount` decimal(16,2) DEFAULT '0.00',
  `subtotal` decimal(16,2) DEFAULT '0.00',
  `totaltax` decimal(16,2) DEFAULT '0.00',
  `totaldiscount` decimal(16,2) DEFAULT '0.00',
  `product_des` text,
  `unit` varchar(5) DEFAULT NULL,
  `pwith` int DEFAULT NULL,
  `pthickness` decimal(10,4) NOT NULL,
  `pquick` decimal(10,4) NOT NULL,
  `pquick_code` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice` (`tid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_stock_transfer`
--

DROP TABLE IF EXISTS `geopos_stock_transfer`;
CREATE TABLE IF NOT EXISTS `geopos_stock_transfer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tid` int NOT NULL,
  `invoicedate` date NOT NULL,
  `status` enum('Delivery Ready','Delivered') NOT NULL DEFAULT 'Delivery Ready',
  `items` decimal(10,2) NOT NULL,
  `refer` varchar(20) DEFAULT NULL,
  `from_warehouse` varchar(100) NOT NULL,
  `to_warehouse` varchar(100) NOT NULL,
  `eid` int NOT NULL,
  `business_id` int UNSIGNED DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `invoice` (`tid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_stock_transfer_items`
--

DROP TABLE IF EXISTS `geopos_stock_transfer_items`;
CREATE TABLE IF NOT EXISTS `geopos_stock_transfer_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tid` int NOT NULL,
  `pid` int NOT NULL DEFAULT '0',
  `product` varchar(255) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `qty` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `price` decimal(16,2) NOT NULL DEFAULT '0.00',
  `product_des` decimal(10,2) DEFAULT NULL,
  `unit` varchar(5) DEFAULT NULL,
  `pwith` int DEFAULT NULL,
  `pthickness` decimal(10,4) NOT NULL,
  `pquick` decimal(10,4) NOT NULL,
  `pquick_code` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice` (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_supplier`
--

DROP TABLE IF EXISTS `geopos_supplier`;
CREATE TABLE IF NOT EXISTS `geopos_supplier` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `region` varchar(30) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `postbox` varchar(20) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `picture` varchar(100) NOT NULL DEFAULT 'example.png',
  `gid` int NOT NULL DEFAULT '1',
  `company` varchar(100) DEFAULT NULL,
  `taxid` varchar(100) DEFAULT NULL,
  `loc` int NOT NULL,
  `business_id` int UNSIGNED DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `gid` (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_system`
--

DROP TABLE IF EXISTS `geopos_system`;
CREATE TABLE IF NOT EXISTS `geopos_system` (
  `id` int NOT NULL,
  `cname` char(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(30) NOT NULL,
  `region` varchar(40) NOT NULL,
  `country` varchar(30) NOT NULL,
  `postbox` varchar(15) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `taxid` varchar(20) NOT NULL,
  `tax` int NOT NULL,
  `currency` varchar(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_swedish_ci NOT NULL,
  `currency_format` int NOT NULL,
  `prefix` varchar(5) NOT NULL,
  `dformat` int NOT NULL,
  `zone` varchar(25) NOT NULL,
  `logo` varchar(30) NOT NULL,
  `lang` varchar(20) DEFAULT 'english',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_system_insights`
--

DROP TABLE IF EXISTS `geopos_system_insights`;
CREATE TABLE IF NOT EXISTS `geopos_system_insights` (
  `id` int NOT NULL AUTO_INCREMENT,
  `insight_type` varchar(50) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `priority` varchar(20) DEFAULT 'medium',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_system_settings`
--

DROP TABLE IF EXISTS `geopos_system_settings`;
CREATE TABLE IF NOT EXISTS `geopos_system_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` longtext NOT NULL,
  `access_level` enum('public','role_specific','super_admin_only') NOT NULL DEFAULT 'public',
  `allowed_roles` json DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_terms`
--

DROP TABLE IF EXISTS `geopos_terms`;
CREATE TABLE IF NOT EXISTS `geopos_terms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `type` int NOT NULL,
  `terms` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_tickets`
--

DROP TABLE IF EXISTS `geopos_tickets`;
CREATE TABLE IF NOT EXISTS `geopos_tickets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `cid` int NOT NULL,
  `status` enum('Solved','Processing','Waiting') NOT NULL,
  `section` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_tickets_th`
--

DROP TABLE IF EXISTS `geopos_tickets_th`;
CREATE TABLE IF NOT EXISTS `geopos_tickets_th` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tid` int NOT NULL,
  `message` text,
  `cid` int NOT NULL,
  `eid` int NOT NULL,
  `cdate` datetime NOT NULL,
  `attach` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tid` (`tid`),
  KEY `cid` (`cid`),
  KEY `eid` (`eid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_timber_bids`
--

DROP TABLE IF EXISTS `geopos_timber_bids`;
CREATE TABLE IF NOT EXISTS `geopos_timber_bids` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lot_id` int NOT NULL,
  `lot_type` enum('standing','logs','sawn') NOT NULL,
  `buyer_id` int NOT NULL,
  `bid_amount` decimal(15,2) NOT NULL,
  `bid_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) DEFAULT 'pending',
  `buyer_measurements` text,
  `buyer_agreement` tinyint(1) DEFAULT '0',
  `seller_agreement` tinyint(1) DEFAULT '0',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `transport_cost` decimal(10,2) DEFAULT '0.00',
  `buyer_remarks` text,
  `seller_phone_visible` enum('yes','no') DEFAULT 'no',
  `buyer_phone_visible` enum('yes','no') DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_timber_byproducts`
--

DROP TABLE IF EXISTS `geopos_timber_byproducts`;
CREATE TABLE IF NOT EXISTS `geopos_timber_byproducts` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `job_id` int NOT NULL,
  `product_name` varchar(100) NOT NULL DEFAULT 'Slabs',
  `qty` decimal(15,2) NOT NULL,
  `warehouse_id` int NOT NULL,
  `loc` int NOT NULL DEFAULT '0',
  `status` enum('available','sold','used') NOT NULL DEFAULT 'available',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_timber_logs`
--

DROP TABLE IF EXISTS `geopos_timber_logs`;
CREATE TABLE IF NOT EXISTS `geopos_timber_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lot_name` varchar(100) NOT NULL,
  `seller_id` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `location_gps` varchar(100) DEFAULT NULL,
  `total_cubic_feet` decimal(10,4) DEFAULT '0.0000',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) DEFAULT 'available',
  `featured` tinyint(1) DEFAULT '0',
  `direct_price` decimal(15,2) DEFAULT '0.00',
  `parent_lot_id` int DEFAULT '0',
  `selling_price` decimal(15,2) DEFAULT '0.00',
  `total_price` decimal(15,2) DEFAULT '0.00',
  `district` varchar(50) DEFAULT '',
  `loc` int DEFAULT '0',
  `revid_video_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `revid_video_url` (`revid_video_url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_timber_log_items`
--

DROP TABLE IF EXISTS `geopos_timber_log_items`;
CREATE TABLE IF NOT EXISTS `geopos_timber_log_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `log_id` int NOT NULL,
  `length` decimal(10,2) NOT NULL,
  `girth` decimal(10,2) NOT NULL,
  `cubic_feet` decimal(10,4) NOT NULL,
  `unit_price` decimal(15,2) DEFAULT '0.00',
  `subtotal` decimal(15,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_timber_machinery`
--

DROP TABLE IF EXISTS `geopos_timber_machinery`;
CREATE TABLE IF NOT EXISTS `geopos_timber_machinery` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_name` varchar(200) NOT NULL,
  `specs` text,
  `warehouse_id` int NOT NULL,
  `location_gps` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(50) DEFAULT 'available',
  `selling_price` decimal(15,2) DEFAULT '0.00',
  `total_price` decimal(15,2) DEFAULT '0.00',
  `qty` int DEFAULT '1',
  `district` varchar(50) DEFAULT '',
  `seller_id` int DEFAULT '0',
  `loc` int DEFAULT '0',
  `revid_video_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `revid_video_url` (`revid_video_url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_timber_photos`
--

DROP TABLE IF EXISTS `geopos_timber_photos`;
CREATE TABLE IF NOT EXISTS `geopos_timber_photos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lot_id` int NOT NULL,
  `lot_type` enum('standing','logs','sawn','machinery') NOT NULL,
  `photo` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_timber_purchase`
--

DROP TABLE IF EXISTS `geopos_timber_purchase`;
CREATE TABLE IF NOT EXISTS `geopos_timber_purchase` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `p_date` date NOT NULL,
  `vendor_id` int NOT NULL,
  `species` varchar(100) NOT NULL,
  `qty` decimal(15,2) NOT NULL,
  `unit` varchar(20) NOT NULL DEFAULT 'cubic_ft',
  `price_per_unit` decimal(15,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `loc` int NOT NULL DEFAULT '0',
  `status` enum('pending','received','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_timber_sawmill`
--

DROP TABLE IF EXISTS `geopos_timber_sawmill`;
CREATE TABLE IF NOT EXISTS `geopos_timber_sawmill` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `process_date` date NOT NULL,
  `source_lot_type` varchar(50) NOT NULL,
  `source_lot_id` int NOT NULL,
  `input_qty` decimal(15,2) NOT NULL,
  `output_qty` decimal(15,2) NOT NULL,
  `wastage` decimal(15,2) NOT NULL,
  `operator_id` int NOT NULL,
  `loc` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `slabs_qty` decimal(15,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_timber_sawn`
--

DROP TABLE IF EXISTS `geopos_timber_sawn`;
CREATE TABLE IF NOT EXISTS `geopos_timber_sawn` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lot_name` varchar(100) DEFAULT NULL,
  `warehouse_id` int NOT NULL,
  `location_gps` varchar(100) DEFAULT NULL,
  `total_cubic_feet` decimal(10,4) DEFAULT '0.0000',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) DEFAULT 'available',
  `featured` tinyint(1) DEFAULT '0',
  `direct_price` decimal(15,2) DEFAULT '0.00',
  `parent_lot_id` int DEFAULT '0',
  `selling_price` decimal(15,2) DEFAULT '0.00',
  `total_price` decimal(15,2) DEFAULT '0.00',
  `unit_type` varchar(20) DEFAULT 'cubic_ft',
  `district` varchar(50) DEFAULT '',
  `seller_id` int DEFAULT '0',
  `loc` int DEFAULT '0',
  `revid_video_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `revid_video_url` (`revid_video_url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_timber_sawn_items`
--

DROP TABLE IF EXISTS `geopos_timber_sawn_items`;
CREATE TABLE IF NOT EXISTS `geopos_timber_sawn_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sawn_id` int NOT NULL,
  `wood_type_id` int NOT NULL,
  `width` decimal(10,2) NOT NULL,
  `thickness` decimal(10,2) NOT NULL,
  `length` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `cubic_feet` decimal(10,4) NOT NULL,
  `unit_price` decimal(15,2) DEFAULT '0.00',
  `subtotal` decimal(15,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_timber_sawn_retired`
--

DROP TABLE IF EXISTS `geopos_timber_sawn_retired`;
CREATE TABLE IF NOT EXISTS `geopos_timber_sawn_retired` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `wood_type_id` int NOT NULL,
  `width` decimal(10,2) NOT NULL,
  `thickness` decimal(10,2) NOT NULL,
  `length` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `cubic_feet` decimal(10,4) NOT NULL,
  `location_gps` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_timber_standing`
--

DROP TABLE IF EXISTS `geopos_timber_standing`;
CREATE TABLE IF NOT EXISTS `geopos_timber_standing` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lot_name` varchar(100) DEFAULT NULL,
  `warehouse_id` int NOT NULL,
  `location_gps` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) DEFAULT 'available',
  `featured` tinyint(1) DEFAULT '0',
  `direct_price` decimal(15,2) DEFAULT '0.00',
  `parent_lot_id` int DEFAULT '0',
  `selling_price` decimal(15,2) DEFAULT '0.00',
  `total_price` decimal(15,2) DEFAULT '0.00',
  `total_cubic_feet` decimal(15,4) DEFAULT '0.0000',
  `district` varchar(50) DEFAULT '',
  `seller_id` int DEFAULT '0',
  `loc` int DEFAULT '0',
  `revid_video_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `revid_video_url` (`revid_video_url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_timber_standing_items`
--

DROP TABLE IF EXISTS `geopos_timber_standing_items`;
CREATE TABLE IF NOT EXISTS `geopos_timber_standing_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `standing_id` int NOT NULL,
  `product_id` int NOT NULL,
  `tree_count` int NOT NULL,
  `circumference_avg` decimal(10,2) NOT NULL,
  `est_height` decimal(10,2) NOT NULL,
  `unit_price` decimal(15,2) DEFAULT '0.00',
  `subtotal` decimal(15,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_timber_standing_retired`
--

DROP TABLE IF EXISTS `geopos_timber_standing_retired`;
CREATE TABLE IF NOT EXISTS `geopos_timber_standing_retired` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `tree_count` int NOT NULL,
  `circumference_avg` decimal(10,2) NOT NULL,
  `est_height` decimal(10,2) NOT NULL,
  `permit_status` varchar(50) DEFAULT 'Pending',
  `location_gps` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_timber_transfers`
--

DROP TABLE IF EXISTS `geopos_timber_transfers`;
CREATE TABLE IF NOT EXISTS `geopos_timber_transfers` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `lot_type` enum('log','sawn') NOT NULL DEFAULT 'log',
  `lot_id` int NOT NULL,
  `from_loc` int NOT NULL,
  `to_loc` int NOT NULL,
  `request_qty` decimal(15,2) NOT NULL,
  `status` enum('pending','on_way','completed','cancelled') NOT NULL DEFAULT 'pending',
  `requested_by` int NOT NULL,
  `approved_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_timber_wood_types`
--

DROP TABLE IF EXISTS `geopos_timber_wood_types`;
CREATE TABLE IF NOT EXISTS `geopos_timber_wood_types` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `code` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_timesheets`
--

DROP TABLE IF EXISTS `geopos_timesheets`;
CREATE TABLE IF NOT EXISTS `geopos_timesheets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL,
  `job_code_id` int DEFAULT NULL,
  `clock_in` datetime NOT NULL,
  `clock_out` datetime DEFAULT NULL,
  `total_hours` decimal(10,2) DEFAULT '0.00',
  `note` text,
  `status` varchar(20) DEFAULT 'Pending',
  `is_overtime` tinyint(1) DEFAULT '0',
  `overtime_override` tinyint(1) DEFAULT NULL COMMENT 'NULL=auto, 0=force no OT, 1=force OT',
  `override_reason` varchar(255) DEFAULT NULL,
  `override_by` int DEFAULT NULL,
  `override_at` datetime DEFAULT NULL,
  `approved_by` int DEFAULT NULL,
  `approved_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_todolist`
--

DROP TABLE IF EXISTS `geopos_todolist`;
CREATE TABLE IF NOT EXISTS `geopos_todolist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tdate` date NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `status` enum('Due','Done','Progress') NOT NULL DEFAULT 'Due',
  `start` date NOT NULL,
  `duedate` date NOT NULL,
  `description` text,
  `eid` int NOT NULL,
  `aid` int NOT NULL,
  `related` int NOT NULL,
  `priority` enum('Low','Medium','High','Urgent') NOT NULL,
  `rid` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_transactions`
--

DROP TABLE IF EXISTS `geopos_transactions`;
CREATE TABLE IF NOT EXISTS `geopos_transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int UNSIGNED DEFAULT '0',
  `acid` int NOT NULL,
  `account` varchar(200) NOT NULL,
  `type` enum('Income','Expense','Transfer') NOT NULL,
  `cat` varchar(200) NOT NULL,
  `debit` decimal(16,2) DEFAULT '0.00',
  `credit` decimal(16,2) DEFAULT '0.00',
  `payer` varchar(200) DEFAULT NULL,
  `payerid` int NOT NULL DEFAULT '0',
  `method` varchar(200) DEFAULT NULL,
  `date` date NOT NULL,
  `tid` int NOT NULL DEFAULT '0',
  `eid` int NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `ext` int DEFAULT '0',
  `loc` int NOT NULL,
  `link_id` bigint DEFAULT '0',
  `business_id` int UNSIGNED DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `loc` (`loc`),
  KEY `acid` (`acid`),
  KEY `eid` (`eid`),
  KEY `tid` (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Triggers `geopos_transactions`
--
DROP TRIGGER IF EXISTS `prevent_transaction_delete`;
DELIMITER $$
CREATE TRIGGER `prevent_transaction_delete` BEFORE DELETE ON `geopos_transactions` FOR EACH ROW BEGIN 
    SIGNAL SQLSTATE '45000' 
    SET MESSAGE_TEXT = 'IMMUTABLE LEDGER ERROR: Direct deletion of transactions is strictly prohibited. Use Reversals instead.';
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `prevent_transaction_update`;
DELIMITER $$
CREATE TRIGGER `prevent_transaction_update` BEFORE UPDATE ON `geopos_transactions` FOR EACH ROW BEGIN 
    SIGNAL SQLSTATE '45000' 
    SET MESSAGE_TEXT = 'IMMUTABLE LEDGER ERROR: Modification of transactions is strictly prohibited to ensure financial integrity.';
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_trans_cat`
--

DROP TABLE IF EXISTS `geopos_trans_cat`;
CREATE TABLE IF NOT EXISTS `geopos_trans_cat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `dual_acid` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_units`
--

DROP TABLE IF EXISTS `geopos_units`;
CREATE TABLE IF NOT EXISTS `geopos_units` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `code` varchar(5) NOT NULL,
  `type` int NOT NULL,
  `sub` int NOT NULL,
  `rid` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_users`
--

DROP TABLE IF EXISTS `geopos_users`;
CREATE TABLE IF NOT EXISTS `geopos_users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `pass` varchar(64) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `banned` tinyint(1) DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `last_activity` datetime DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `forgot_exp` text,
  `remember_time` datetime DEFAULT NULL,
  `remember_exp` text,
  `verification_code` text,
  `totp_secret` varchar(16) DEFAULT NULL,
  `ip_address` text,
  `roleid` int NOT NULL,
  `picture` varchar(50) DEFAULT NULL,
  `loc` int NOT NULL,
  `business_id` int NOT NULL DEFAULT '0',
  `is_verified` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Blueprint: Email/phone verified',
  `verification_token` varchar(100) DEFAULT NULL COMMENT 'OTP/Email verification token',
  `verification_expiry` datetime DEFAULT NULL COMMENT 'Token expiry timestamp',
  `provider_type` enum('timber','logistics','services','labour','none') NOT NULL DEFAULT 'none' COMMENT 'Blueprint: Provider category',
  `kyc_status` enum('pending','approved','rejected','not_required') NOT NULL DEFAULT 'not_required' COMMENT 'Blueprint: KYC verification status',
  `kyc_doc_path` varchar(255) DEFAULT NULL COMMENT 'Path to uploaded KYC document',
  `referral_code` varchar(20) DEFAULT NULL COMMENT 'Unique referral code for this user',
  `referred_by` int DEFAULT NULL COMMENT 'User ID who referred this user',
  `green_points` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Blueprint: Green Future CSR points',
  `profile_complete` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Blueprint: Onboarding completed flag',
  `last_active` datetime DEFAULT NULL COMMENT 'Last login/activity timestamp',
  `delete_status` tinyint(1) NOT NULL DEFAULT '0',
  `package_id` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_user_locations`
--

DROP TABLE IF EXISTS `geopos_user_locations`;
CREATE TABLE IF NOT EXISTS `geopos_user_locations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `location_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_warehouse`
--

DROP TABLE IF EXISTS `geopos_warehouse`;
CREATE TABLE IF NOT EXISTS `geopos_warehouse` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `extra` varchar(255) DEFAULT NULL,
  `loc` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_workers`
--

DROP TABLE IF EXISTS `geopos_workers`;
CREATE TABLE IF NOT EXISTS `geopos_workers` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `hourly_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `rating` decimal(3,2) NOT NULL DEFAULT '5.00',
  `loc` int NOT NULL DEFAULT '0',
  `status` enum('online','offline') NOT NULL DEFAULT 'online',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_worker_profiles`
--

DROP TABLE IF EXISTS `geopos_worker_profiles`;
CREATE TABLE IF NOT EXISTS `geopos_worker_profiles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `category_id` int DEFAULT NULL COMMENT 'References geopos_hrm',
  `experience_years` int DEFAULT '0',
  `skills` text COMMENT 'JSON array of skills',
  `hourly_rate` decimal(10,2) DEFAULT '0.00',
  `availability` enum('available','busy','unavailable') DEFAULT 'available',
  `bio` text,
  `phone` varchar(50) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `average_rating` decimal(3,2) DEFAULT '0.00',
  `total_ratings` int DEFAULT '0',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pay_type` enum('hourly','daily','monthly','project') DEFAULT 'hourly',
  `pay_rate` decimal(10,2) DEFAULT '0.00',
  `portfolio` text,
  `provider_type` enum('independent','company') DEFAULT 'independent',
  `owner_id` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  KEY `availability` (`availability`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_worker_ratings`
--

DROP TABLE IF EXISTS `geopos_worker_ratings`;
CREATE TABLE IF NOT EXISTS `geopos_worker_ratings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `worker_id` int NOT NULL,
  `buyer_id` int NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `review` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_rating` (`worker_id`,`buyer_id`),
  KEY `worker_id` (`worker_id`),
  KEY `buyer_id` (`buyer_id`)
) ;

-- --------------------------------------------------------

--
-- Table structure for table `media_templates`
--

DROP TABLE IF EXISTS `media_templates`;
CREATE TABLE IF NOT EXISTS `media_templates` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `slot` tinyint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `bg_music` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rbac_actions`
--

DROP TABLE IF EXISTS `rbac_actions`;
CREATE TABLE IF NOT EXISTS `rbac_actions` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `rbac_modules`
--

DROP TABLE IF EXISTS `rbac_modules`;
CREATE TABLE IF NOT EXISTS `rbac_modules` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `rbac_pages`
--

DROP TABLE IF EXISTS `rbac_pages`;
CREATE TABLE IF NOT EXISTS `rbac_pages` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `module_id` int UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `rbac_permissions`
--

DROP TABLE IF EXISTS `rbac_permissions`;
CREATE TABLE IF NOT EXISTS `rbac_permissions` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `page_id` int UNSIGNED NOT NULL,
  `action_id` int UNSIGNED NOT NULL,
  `perm_key` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `perm_key` (`perm_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `rbac_role_permissions`
--

DROP TABLE IF EXISTS `rbac_role_permissions`;
CREATE TABLE IF NOT EXISTS `rbac_role_permissions` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int UNSIGNED NOT NULL,
  `permission_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `share_logs`
--

DROP TABLE IF EXISTS `share_logs`;
CREATE TABLE IF NOT EXISTS `share_logs` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `ad_id` int UNSIGNED NOT NULL,
  `ad_type` varchar(30) DEFAULT 'logs',
  `platform` varchar(50) NOT NULL,
  `status` enum('pending','success','failed') DEFAULT 'pending',
  `referral_token` varchar(64) DEFAULT NULL,
  `post_id` varchar(255) DEFAULT NULL,
  `error_msg` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `ad_id` (`ad_id`),
  KEY `referral_token` (`referral_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_api_settings`
--

DROP TABLE IF EXISTS `social_api_settings`;
CREATE TABLE IF NOT EXISTS `social_api_settings` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `platform` varchar(50) NOT NULL,
  `app_id` text,
  `app_secret` text,
  `api_key` text,
  `extra_data` text,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `platform` (`platform`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_badges`
--

DROP TABLE IF EXISTS `social_badges`;
CREATE TABLE IF NOT EXISTS `social_badges` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `badge_slug` varchar(50) NOT NULL,
  `awarded_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_badge` (`user_id`,`badge_slug`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_referral_clicks`
--

DROP TABLE IF EXISTS `social_referral_clicks`;
CREATE TABLE IF NOT EXISTS `social_referral_clicks` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `referral_token` varchar(64) NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `ad_id` int UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `clicked_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `referral_token` (`referral_token`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timber_audit_log`
--

DROP TABLE IF EXISTS `timber_audit_log`;
CREATE TABLE IF NOT EXISTS `timber_audit_log` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED DEFAULT '0',
  `action` varchar(100) NOT NULL,
  `entity` varchar(100) NOT NULL,
  `entity_id` varchar(50) DEFAULT NULL,
  `details` text,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `action` (`action`),
  KEY `entity` (`entity`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timber_calculations`
--

DROP TABLE IF EXISTS `timber_calculations`;
CREATE TABLE IF NOT EXISTS `timber_calculations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED DEFAULT '0',
  `calc_type` varchar(50) NOT NULL,
  `input_params` text,
  `result_value` decimal(15,4) DEFAULT '0.0000',
  `result_detail` text,
  `unit` varchar(30) DEFAULT NULL,
  `price_estimate` decimal(15,2) DEFAULT '0.00',
  `species` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `calc_type` (`calc_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tp_ai_ad_logs`
--

DROP TABLE IF EXISTS `tp_ai_ad_logs`;
CREATE TABLE IF NOT EXISTS `tp_ai_ad_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subscription_id` int NOT NULL COMMENT 'tp_business_subscriptions.id',
  `user_id` int NOT NULL COMMENT 'Who triggered the generation',
  `loc` int NOT NULL DEFAULT '0',
  `product_id` int DEFAULT NULL COMMENT 'Product being advertised (geopos_products.pid)',
  `prompt_used` text COMMENT 'AI prompt sent to Revid API',
  `revid_job_id` varchar(255) DEFAULT NULL COMMENT 'Revid API job reference',
  `video_url` varchar(500) DEFAULT NULL COMMENT 'Generated video URL',
  `status` enum('queued','processing','completed','failed') NOT NULL DEFAULT 'queued',
  `platform_targets` varchar(255) DEFAULT NULL COMMENT 'e.g. facebook,instagram,tiktok',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `subscription_id` (`subscription_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Blueprint: AI marketing video generation logs (Revid API)';

-- --------------------------------------------------------

--
-- Table structure for table `tp_business_subscriptions`
--

DROP TABLE IF EXISTS `tp_business_subscriptions`;
CREATE TABLE IF NOT EXISTS `tp_business_subscriptions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `loc` int NOT NULL COMMENT 'Location/business (geopos_locations.id)',
  `user_id` int NOT NULL COMMENT 'Owner/admin user (geopos_users.id)',
  `package_id` int NOT NULL COMMENT 'tp_subscription_packages.id',
  `billing_cycle` enum('monthly','annual') NOT NULL DEFAULT 'monthly',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('active','expired','cancelled','trial') NOT NULL DEFAULT 'trial',
  `ai_videos_used` int NOT NULL DEFAULT '0',
  `marketplace_used` int NOT NULL DEFAULT '0',
  `ring_used` int NOT NULL DEFAULT '0',
  `payment_ref` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `loc` (`loc`),
  KEY `user_id` (`user_id`),
  KEY `package_id` (`package_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Blueprint: Active subscription records per business location';

-- --------------------------------------------------------

--
-- Table structure for table `tp_donation_fund`
--

DROP TABLE IF EXISTS `tp_donation_fund`;
CREATE TABLE IF NOT EXISTS `tp_donation_fund` (
  `id` int NOT NULL AUTO_INCREMENT,
  `donor_user_id` int NOT NULL COMMENT 'Customer who donated (geopos_users.id)',
  `donor_invoice_id` int DEFAULT NULL COMMENT 'Auto-donation from invoice (geopos_invoices.id)',
  `amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `donation_type` enum('invoice_auto','manual','corporate','anonymous') NOT NULL DEFAULT 'manual' COMMENT 'How the donation was made',
  `fund_balance_before` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT 'Fund balance snapshot before',
  `fund_balance_after` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT 'Fund balance snapshot after',
  `note` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `donor_user_id` (`donor_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Blueprint: Green Future CSR donation fund ledger';

-- --------------------------------------------------------

--
-- Table structure for table `tp_escrow_transactions`
--

DROP TABLE IF EXISTS `tp_escrow_transactions`;
CREATE TABLE IF NOT EXISTS `tp_escrow_transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `escrow_id` int NOT NULL COMMENT 'tp_escrow_vault.id',
  `action` enum('deposit','hold','release','refund','fee_charge','dispute_open','dispute_resolve') NOT NULL,
  `amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `performed_by` int NOT NULL COMMENT 'User who performed action (geopos_users.id)',
  `note` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Immutable - no updates allowed by policy',
  PRIMARY KEY (`id`),
  KEY `escrow_id` (`escrow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Blueprint: Escrow transaction ledger. Append-only per No-Delete Policy.';

-- --------------------------------------------------------

--
-- Table structure for table `tp_escrow_vault`
--

DROP TABLE IF EXISTS `tp_escrow_vault`;
CREATE TABLE IF NOT EXISTS `tp_escrow_vault` (
  `id` int NOT NULL AUTO_INCREMENT,
  `escrow_ref` varchar(50) NOT NULL COMMENT 'Unique escrow reference code (e.g. ESC-20260228-001)',
  `payer_user_id` int NOT NULL COMMENT 'Who deposited funds (geopos_users.id)',
  `payee_user_id` int NOT NULL COMMENT 'Who will receive funds on release (geopos_users.id)',
  `amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `fee` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT 'Platform escrow fee',
  `net_amount` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT 'Amount after fee deduction',
  `currency` varchar(10) NOT NULL DEFAULT 'LKR',
  `status` enum('pending','held','released','refunded','disputed') NOT NULL DEFAULT 'pending',
  `purpose` enum('service_request','bid_contract','marketplace_sale','installment') NOT NULL DEFAULT 'service_request',
  `linked_id` int DEFAULT NULL COMMENT 'ID of service_request/bid/invoice this is linked to',
  `linked_type` varchar(50) DEFAULT NULL COMMENT 'Table name of linked record (tp_service_requests, timber_bids, etc.)',
  `loc` int NOT NULL DEFAULT '0',
  `notes` text,
  `held_at` datetime DEFAULT NULL,
  `released_at` datetime DEFAULT NULL COMMENT 'When funds were released (immutable after set)',
  `refunded_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `escrow_ref` (`escrow_ref`),
  KEY `payer_user_id` (`payer_user_id`),
  KEY `payee_user_id` (`payee_user_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Blueprint: Escrow Vault - secure payment holding. No-Delete Policy enforced.';

-- --------------------------------------------------------

--
-- Table structure for table `tp_inventory_reservations`
--

DROP TABLE IF EXISTS `tp_inventory_reservations`;
CREATE TABLE IF NOT EXISTS `tp_inventory_reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `qty` decimal(15,2) DEFAULT NULL,
  `status` enum('Pending','Issued','Cancelled') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `tp_live_tracking`
--

DROP TABLE IF EXISTS `tp_live_tracking`;
CREATE TABLE IF NOT EXISTS `tp_live_tracking` (
  `id` int NOT NULL AUTO_INCREMENT,
  `request_id` int NOT NULL COMMENT 'tp_service_requests.id',
  `user_id` int NOT NULL COMMENT 'Provider being tracked (geopos_users.id)',
  `gps_lat` decimal(10,8) NOT NULL,
  `gps_lng` decimal(11,8) NOT NULL,
  `speed_kmh` decimal(6,2) DEFAULT NULL,
  `heading` decimal(6,2) DEFAULT NULL COMMENT 'Compass heading in degrees',
  `recorded_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `request_id` (`request_id`),
  KEY `user_id` (`user_id`),
  KEY `recorded_at` (`recorded_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Blueprint: Live GPS tracking for Ring System providers';

-- --------------------------------------------------------

--
-- Table structure for table `tp_maintenance_requests`
--

DROP TABLE IF EXISTS `tp_maintenance_requests`;
CREATE TABLE IF NOT EXISTS `tp_maintenance_requests` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `planting_request_id` int UNSIGNED DEFAULT NULL,
  `applicant_user_id` int UNSIGNED DEFAULT '0',
  `applicant_name` varchar(150) NOT NULL,
  `applicant_phone` varchar(30) DEFAULT NULL,
  `applicant_address` text,
  `province` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `location_description` text,
  `tree_count` int DEFAULT '0',
  `photo_path` varchar(255) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_account_no` varchar(50) DEFAULT NULL,
  `bank_branch` varchar(100) DEFAULT NULL,
  `monthly_amount` decimal(10,2) DEFAULT '1500.00',
  `status` enum('pending','verified','paid','rejected') DEFAULT 'pending',
  `verified_by` int UNSIGNED DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `admin_note` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `applicant_user_id` (`applicant_user_id`),
  KEY `status` (`status`),
  KEY `district` (`district`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tp_projects`
--

DROP TABLE IF EXISTS `tp_projects`;
CREATE TABLE IF NOT EXISTS `tp_projects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `location_id` int DEFAULT NULL,
  `customer_id` int DEFAULT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `status` enum('Planning','In-Progress','On-Hold','Completed') DEFAULT 'Planning',
  `total_budget` decimal(15,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `tp_project_finances`
--

DROP TABLE IF EXISTS `tp_project_finances`;
CREATE TABLE IF NOT EXISTS `tp_project_finances` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int DEFAULT NULL,
  `transaction_type` enum('Material','Labor','Overhead') DEFAULT NULL,
  `ledger_entry_id` int DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `tp_project_milestones`
--

DROP TABLE IF EXISTS `tp_project_milestones`;
CREATE TABLE IF NOT EXISTS `tp_project_milestones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `due_date` date DEFAULT NULL,
  `color` varchar(20) DEFAULT '#007bff',
  `status` int DEFAULT '0',
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `tp_project_tasks`
--

DROP TABLE IF EXISTS `tp_project_tasks`;
CREATE TABLE IF NOT EXISTS `tp_project_tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int DEFAULT NULL,
  `task_name` varchar(255) DEFAULT NULL,
  `assigned_to` int DEFAULT NULL,
  `estimated_hours` decimal(10,2) DEFAULT NULL,
  `status` enum('To-Do','Working','Done') DEFAULT 'To-Do',
  `start_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `tp_project_timesheets`
--

DROP TABLE IF EXISTS `tp_project_timesheets`;
CREATE TABLE IF NOT EXISTS `tp_project_timesheets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task_id` int DEFAULT NULL,
  `worker_id` int DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `duration_minutes` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `tp_provider_insurance`
--

DROP TABLE IF EXISTS `tp_provider_insurance`;
CREATE TABLE IF NOT EXISTS `tp_provider_insurance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `provider_user_id` int NOT NULL COMMENT 'Insured provider (geopos_users.id)',
  `policy_number` varchar(100) NOT NULL,
  `insurer_name` varchar(255) NOT NULL DEFAULT 'TimberPro Group Insurance',
  `coverage_type` enum('accident','liability','equipment','life','comprehensive') NOT NULL DEFAULT 'accident',
  `coverage_amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `premium_monthly` decimal(10,2) NOT NULL DEFAULT '0.00',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('active','expired','cancelled','claimed') NOT NULL DEFAULT 'active',
  `notes` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `policy_number` (`policy_number`),
  KEY `provider_user_id` (`provider_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Blueprint: Provider worker accident/liability insurance records';

-- --------------------------------------------------------

--
-- Table structure for table `tp_provider_insurance_claims`
--

DROP TABLE IF EXISTS `tp_provider_insurance_claims`;
CREATE TABLE IF NOT EXISTS `tp_provider_insurance_claims` (
  `id` int NOT NULL AUTO_INCREMENT,
  `insurance_id` int NOT NULL COMMENT 'tp_provider_insurance.id',
  `claim_ref` varchar(100) NOT NULL,
  `incident_date` date NOT NULL,
  `incident_description` text NOT NULL,
  `claim_amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `approved_amount` decimal(16,2) DEFAULT NULL,
  `status` enum('submitted','under_review','approved','rejected','paid') NOT NULL DEFAULT 'submitted',
  `reviewed_by` int DEFAULT NULL COMMENT 'Admin user who reviewed (geopos_users.id)',
  `reviewed_at` datetime DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `claim_ref` (`claim_ref`),
  KEY `insurance_id` (`insurance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Blueprint: Provider insurance claim records';

-- --------------------------------------------------------

--
-- Table structure for table `tp_referral_logs`
--

DROP TABLE IF EXISTS `tp_referral_logs`;
CREATE TABLE IF NOT EXISTS `tp_referral_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `program_id` int NOT NULL DEFAULT '1' COMMENT 'tp_referral_program.id',
  `referrer_user_id` int NOT NULL COMMENT 'User who referred',
  `referee_user_id` int NOT NULL COMMENT 'New user who joined via referral',
  `referral_code` varchar(20) NOT NULL,
  `qualifying_invoice_id` int DEFAULT NULL COMMENT 'Invoice that qualified the referral',
  `status` enum('pending','qualified','rewarded','rejected') NOT NULL DEFAULT 'pending',
  `referrer_rewarded` tinyint(1) NOT NULL DEFAULT '0',
  `referee_rewarded` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `referrer_user_id` (`referrer_user_id`),
  KEY `referee_user_id` (`referee_user_id`),
  KEY `referral_code` (`referral_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Blueprint: Per-user referral activity log';

-- --------------------------------------------------------

--
-- Table structure for table `tp_referral_program`
--

DROP TABLE IF EXISTS `tp_referral_program`;
CREATE TABLE IF NOT EXISTS `tp_referral_program` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT 'Default Referral Program',
  `referrer_reward_type` enum('cash','points','discount','subscription') NOT NULL DEFAULT 'cash',
  `referrer_reward_value` decimal(10,2) NOT NULL DEFAULT '0.00',
  `referee_reward_type` enum('cash','points','discount','subscription') NOT NULL DEFAULT 'discount',
  `referee_reward_value` decimal(10,2) NOT NULL DEFAULT '0.00',
  `min_purchase_to_qualify` decimal(16,2) NOT NULL DEFAULT '0.00',
  `max_referrals_per_user` int NOT NULL DEFAULT '0' COMMENT '0 = unlimited',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `valid_from` date DEFAULT NULL,
  `valid_until` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Blueprint: Referral program reward rules';

-- --------------------------------------------------------

--
-- Table structure for table `tp_ring_logs`
--

DROP TABLE IF EXISTS `tp_ring_logs`;
CREATE TABLE IF NOT EXISTS `tp_ring_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `request_id` int NOT NULL COMMENT 'tp_service_requests.id',
  `provider_user_id` int NOT NULL COMMENT 'Provider who was notified (geopos_users.id)',
  `notified_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` enum('notified','accepted','rejected','timeout','cancelled') NOT NULL DEFAULT 'notified',
  `action_at` datetime DEFAULT NULL,
  `response_seconds` int DEFAULT NULL COMMENT 'How many seconds to respond',
  PRIMARY KEY (`id`),
  KEY `request_id` (`request_id`),
  KEY `provider_user_id` (`provider_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Blueprint: Ring System - 30-second rule audit trail';

-- --------------------------------------------------------

--
-- Table structure for table `tp_service_requests`
--

DROP TABLE IF EXISTS `tp_service_requests`;
CREATE TABLE IF NOT EXISTS `tp_service_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `request_type` enum('timber_delivery','sawmill_service','labour','machinery','transport','other') NOT NULL DEFAULT 'other' COMMENT 'Type of service requested',
  `requester_user_id` int NOT NULL COMMENT 'Who made the request (geopos_users.id)',
  `requester_loc` int NOT NULL DEFAULT '0' COMMENT 'Location of requester (geopos_locations.id)',
  `assigned_provider_id` int DEFAULT NULL COMMENT 'Accepted provider (geopos_users.id)',
  `title` varchar(255) NOT NULL,
  `description` text,
  `gps_lat` decimal(10,8) DEFAULT NULL COMMENT 'Request location latitude',
  `gps_lng` decimal(11,8) DEFAULT NULL COMMENT 'Request location longitude',
  `radius_km` decimal(6,2) DEFAULT '10.00' COMMENT 'Ring broadcast radius in km',
  `status` enum('pending','ringing','accepted','in_progress','completed','cancelled','expired') NOT NULL DEFAULT 'pending',
  `ring_started_at` datetime DEFAULT NULL COMMENT 'When the 30-second ring started',
  `ring_expires_at` datetime DEFAULT NULL COMMENT 'When the ring expires (30s rule)',
  `accepted_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `budget` decimal(16,2) DEFAULT '0.00',
  `final_amount` decimal(16,2) DEFAULT '0.00',
  `invoice_id` int DEFAULT NULL COMMENT 'Resulting invoice if created',
  `escrow_id` int DEFAULT NULL COMMENT 'Linked escrow entry',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `requester_user_id` (`requester_user_id`),
  KEY `assigned_provider_id` (`assigned_provider_id`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Blueprint: Ring System - real-time service requests';

-- --------------------------------------------------------

--
-- Table structure for table `tp_subscription_packages`
--

DROP TABLE IF EXISTS `tp_subscription_packages`;
CREATE TABLE IF NOT EXISTS `tp_subscription_packages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'e.g. Starter, Pro, Enterprise',
  `description` text,
  `price_monthly` decimal(16,2) NOT NULL DEFAULT '0.00',
  `price_annual` decimal(16,2) NOT NULL DEFAULT '0.00',
  `ai_videos_per_month` int NOT NULL DEFAULT '0' COMMENT 'No. of AI video generations included',
  `marketplace_listings` int NOT NULL DEFAULT '0' COMMENT 'Max active marketplace listings',
  `ring_broadcasts` int NOT NULL DEFAULT '0' COMMENT 'Ring system broadcasts per month',
  `priority_ring` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Priority in ring notifications',
  `analytics_access` tinyint(1) NOT NULL DEFAULT '0',
  `whatsapp_api_access` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Blueprint: AI Marketing subscription package definitions';

-- --------------------------------------------------------

--
-- Table structure for table `tp_tree_maintenance_payouts`
--

DROP TABLE IF EXISTS `tp_tree_maintenance_payouts`;
CREATE TABLE IF NOT EXISTS `tp_tree_maintenance_payouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `planting_request_id` int NOT NULL COMMENT 'tp_tree_planting_requests.id',
  `landowner_user_id` int NOT NULL COMMENT 'Rural landowner paid (geopos_users.id)',
  `payout_type` enum('planting','year1_maintenance','year2_maintenance','year3_maintenance','harvest_share') NOT NULL DEFAULT 'planting',
  `amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `payment_method` varchar(50) DEFAULT 'Bank Transfer',
  `payment_ref` varchar(100) DEFAULT NULL,
  `status` enum('pending','paid','failed') NOT NULL DEFAULT 'pending',
  `paid_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `planting_request_id` (`planting_request_id`),
  KEY `landowner_user_id` (`landowner_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Blueprint: Payments to rural landowners for tree maintenance';

-- --------------------------------------------------------

--
-- Table structure for table `tp_tree_planting_requests`
--

DROP TABLE IF EXISTS `tp_tree_planting_requests`;
CREATE TABLE IF NOT EXISTS `tp_tree_planting_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `requested_by` int NOT NULL COMMENT 'User who made the planting request',
  `landowner_user_id` int DEFAULT NULL COMMENT 'Rural landowner assigned to plant',
  `district` varchar(100) NOT NULL,
  `province` varchar(100) DEFAULT NULL,
  `gps_lat` decimal(10,8) DEFAULT NULL,
  `gps_lng` decimal(11,8) DEFAULT NULL,
  `tree_species` varchar(255) DEFAULT NULL,
  `trees_requested` int NOT NULL DEFAULT '1',
  `trees_planted` int NOT NULL DEFAULT '0',
  `cost_per_tree` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_cost` decimal(16,2) NOT NULL DEFAULT '0.00',
  `funded_from_donation` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Funded from CSR donation pool',
  `status` enum('pending','assigned','in_progress','completed','cancelled') NOT NULL DEFAULT 'pending',
  `assigned_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `photo_before` varchar(255) DEFAULT NULL,
  `photo_after` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `grama_niladhari_cert` varchar(255) DEFAULT NULL,
  `sabhapathi_cert` varchar(255) DEFAULT NULL,
  `location_type` enum('roadside','paddy_field','other') DEFAULT 'other',
  `admin_note` text,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `requested_by` (`requested_by`),
  KEY `landowner_user_id` (`landowner_user_id`),
  KEY `district` (`district`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Blueprint: Green Future tree planting job orders';

-- --------------------------------------------------------

--
-- Table structure for table `univarsal_api`
--

DROP TABLE IF EXISTS `univarsal_api`;
CREATE TABLE IF NOT EXISTS `univarsal_api` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `key1` varchar(255) DEFAULT NULL,
  `key2` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `method` varchar(10) DEFAULT NULL,
  `other` text,
  `active` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `users_id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL,
  `var_key` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_deleted` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `cid` int DEFAULT NULL,
  `lang` varchar(25) NOT NULL DEFAULT 'english',
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`users_id`),
  KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `user_social_tokens`
--

DROP TABLE IF EXISTS `user_social_tokens`;
CREATE TABLE IF NOT EXISTS `user_social_tokens` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `platform` varchar(50) NOT NULL,
  `access_token` text,
  `token_data` text,
  `expires_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_platform` (`user_id`,`platform`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `geopos_guide_steps`
--
ALTER TABLE `geopos_guide_steps`
  ADD CONSTRAINT `fk_guide_steps` FOREIGN KEY (`guide_id`) REFERENCES `geopos_guides` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tp_inventory_reservations`
--
ALTER TABLE `tp_inventory_reservations`
  ADD CONSTRAINT `tp_inventory_reservations_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tp_projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tp_project_finances`
--
ALTER TABLE `tp_project_finances`
  ADD CONSTRAINT `tp_project_finances_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tp_projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tp_project_tasks`
--
ALTER TABLE `tp_project_tasks`
  ADD CONSTRAINT `tp_project_tasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tp_projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tp_project_timesheets`
--
ALTER TABLE `tp_project_timesheets`
  ADD CONSTRAINT `tp_project_timesheets_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tp_project_tasks` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
