-- Database Migration for Marketplace Dashboard Isolation
-- Add business_id to core tables for owner-level isolation

ALTER TABLE `geopos_users` ADD `business_id` INT(11) NOT NULL DEFAULT '0' AFTER `loc`;
ALTER TABLE `geopos_products` ADD `business_id` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `geopos_invoices` ADD `business_id` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `geopos_quotes` ADD `business_id` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `geopos_product_groups` ADD `business_id` INT(11) NOT NULL DEFAULT '0';

-- Index for performance
ALTER TABLE `geopos_products` ADD INDEX (`business_id`);
ALTER TABLE `geopos_invoices` ADD INDEX (`business_id`);
ALTER TABLE `geopos_quotes` ADD INDEX (`business_id`);
ALTER TABLE `geopos_users` ADD INDEX (`business_id`);

-- Independent Pricing Modes for Triple-Mode
ALTER TABLE `geopos_products` ADD `product_rent` DECIMAL(19,4) NOT NULL DEFAULT '0.0000' AFTER `product_price`;
ALTER TABLE `geopos_products` ADD `product_installment` DECIMAL(19,4) NOT NULL DEFAULT '0.0000' AFTER `product_rent`;
ALTER TABLE `geopos_products` ADD `is_sale` TINYINT(1) NOT NULL DEFAULT '1';
ALTER TABLE `geopos_products` ADD `is_rent` TINYINT(1) NOT NULL DEFAULT '0';
ALTER TABLE `geopos_products` ADD `is_installment` TINYINT(1) NOT NULL DEFAULT '0';
ALTER TABLE `geopos_products` ADD `master_pid` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `geopos_products` ADD `special_category` VARCHAR(100) DEFAULT NULL;

-- Add online_status for service providers
ALTER TABLE `geopos_employees` ADD `online_status` TINYINT(1) NOT NULL DEFAULT '1';

-- Master Products Table
CREATE TABLE IF NOT EXISTS `geopos_master_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `product_code` varchar(100) DEFAULT NULL,
  `pcat` int(11) NOT NULL,
  `sub_id` int(11) DEFAULT '0',
  `product_price` decimal(19,4) NOT NULL DEFAULT '0.0000',
  `fproduct_price` decimal(19,4) NOT NULL DEFAULT '0.0000',
  `fproduct_cost` decimal(19,4) NOT NULL DEFAULT '0.0000',
  `unit` varchar(20) DEFAULT NULL,
  `pwith` varchar(50) DEFAULT NULL,
  `pthickness` varchar(50) DEFAULT NULL,
  `pquick` varchar(50) DEFAULT NULL,
  `product_des` text,
  `image` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Labor Categories Table
CREATE TABLE IF NOT EXISTS `geopos_labor_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `commission_rate` decimal(5,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Update existing users: Owners become their own business_id for isolation
-- This is a one-time setup step for existing owners
-- UPDATE geopos_users SET business_id = id WHERE roleid = 2;
