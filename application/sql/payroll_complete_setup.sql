-- TimberPro ERP - Advanced Payroll & HRM Module Database Schema
-- Run this script in phpMyAdmin or your MySQL client to build the necessary tables.

-- 1. Job Codes Table (Used for Labor Costing)
CREATE TABLE IF NOT EXISTS `geopos_job_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 2. Timesheets Table (Used for Payroll Calculation)
CREATE TABLE IF NOT EXISTS `geopos_timesheets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `job_code_id` int(11) DEFAULT NULL,
  `clock_in` datetime NOT NULL,
  `clock_out` datetime DEFAULT NULL,
  `total_hours` decimal(10,2) DEFAULT '0.00',
  `note` text,
  `status` varchar(20) DEFAULT 'Pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 3. Payroll Runs Table (Stores the header info for a payroll period)
CREATE TABLE IF NOT EXISTS `geopos_payroll_runs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_created` date NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_amount` decimal(16,2) DEFAULT '0.00',
  `total_tax` decimal(16,2) DEFAULT '0.00',
  `status` varchar(20) DEFAULT 'Draft',
  `approval_status` varchar(20) DEFAULT 'Draft',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 4. Payroll Items Table (Stores individual employee pay for a run)
CREATE TABLE IF NOT EXISTS `geopos_payroll_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `run_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `total_hours` decimal(10,2) DEFAULT '0.00',
  `gross_pay` decimal(16,2) DEFAULT '0.00',
  `tax` decimal(16,2) DEFAULT '0.00',
  `total_deductions` decimal(16,2) DEFAULT '0.00',
  `net_pay` decimal(16,2) DEFAULT '0.00',
  `deduction_details` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `run_id` (`run_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 5. Payroll Approvals (Tracks workflow sign-offs)
CREATE TABLE IF NOT EXISTS `geopos_payroll_approvals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `run_id` int(11) NOT NULL,
  `approver_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `comments` text,
  `approved_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 6. Deduction Types (Configuration for deductions)
CREATE TABLE IF NOT EXISTS `geopos_deduction_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `calculation_type` enum('Percentage','Fixed Amount') NOT NULL,
  `default_value` decimal(10,2) NOT NULL DEFAULT '0.00',
  `is_pre_tax` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 7. Employee Deductions (Mapping employee to deductions)
CREATE TABLE IF NOT EXISTS `geopos_emp_deductions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `deduction_type_id` int(11) NOT NULL,
  `amount_override` decimal(10,2) DEFAULT '0.00',
  `percentage_override` decimal(5,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 8. Overtime Rules (Configuration for Overtime multipliers)
CREATE TABLE IF NOT EXISTS `geopos_overtime_rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `multiplier` decimal(4,2) NOT NULL DEFAULT '1.50',
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 9. Payroll Config (Key-Value settings)
CREATE TABLE IF NOT EXISTS `geopos_payroll_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `value` text,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- DATA SEEDING --

-- Seed Job Codes
INSERT INTO `geopos_job_codes` (`code`, `title`, `description`) VALUES
('JC001', 'General Carpentry', 'Standard framing and wood work'),
('JC002', 'Electrical Helper', 'Assisting electricians'),
('JC003', 'Site Management', 'Supervisory duties')
ON DUPLICATE KEY UPDATE `title`=VALUES(`title`);

-- Seed Deduction Types
INSERT INTO `geopos_deduction_types` (`name`, `calculation_type`, `default_value`, `is_pre_tax`) VALUES
('Health Insurance', 'Fixed Amount', 50.00, 1),
('Union Dues', 'Percentage', 1.5, 0),
('401k Contribution', 'Percentage', 3.0, 1)
ON DUPLICATE KEY UPDATE `default_value`=VALUES(`default_value`);

-- Note: Timesheet seeding requires valid employee IDs. 
-- The following valid SQL insert works assuming employee ID 1 exists. 
-- If you have specific employees, you can manually insert sample timesheets:
-- INSERT INTO `geopos_timesheets` (employee_id, job_code_id, clock_in, clock_out, total_hours) VALUES (1, 1, NOW(), DATE_ADD(NOW(), INTERVAL 8 HOUR), 8);
