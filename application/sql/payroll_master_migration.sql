-- ========================================
-- COMPLETE PAYROLL SYSTEM MIGRATION
-- Run this to set up all payroll tables
-- ========================================

-- 1. Timesheets Table
CREATE TABLE IF NOT EXISTS `geopos_timesheets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `job_code_id` int(11) DEFAULT NULL,
  `clock_in` datetime NOT NULL,
  `clock_out` datetime NOT NULL,
  `total_hours` decimal(5,2) NOT NULL DEFAULT '0.00',
  `is_overtime` tinyint(1) NOT NULL DEFAULT '0',
  `note` text,
  `status` varchar(20) DEFAULT 'Pending',
  `approved_by` int(11) DEFAULT NULL,
  `approved_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `job_code_id` (`job_code_id`),
  KEY `clock_in` (`clock_in`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 2. Job Codes Table (if not exists)
CREATE TABLE IF NOT EXISTS `geopos_job_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `hourly_rate` decimal(10,2) DEFAULT NULL,
  `overtime_multiplier` decimal(3,2) DEFAULT '1.50',
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 3. Payroll Bonuses Table (if not exists)
CREATE TABLE IF NOT EXISTS `geopos_payroll_bonuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` varchar(50) DEFAULT 'Performance',
  `date_effective` date NOT NULL,
  `note` text,
  `status` enum('Pending','Paid') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `date_effective` (`date_effective`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 4. Payroll Runs Table (if not exists)
CREATE TABLE IF NOT EXISTS `geopos_payroll_runs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('Draft','Pending','Approved','Finalized') DEFAULT 'Draft',
  `total_employees` int(11) DEFAULT '0',
  `total_gross` decimal(15,2) DEFAULT '0.00',
  `total_deductions` decimal(15,2) DEFAULT '0.00',
  `total_net` decimal(15,2) DEFAULT '0.00',
  `created_by` int(11) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `start_date` (`start_date`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 5. Payroll Items Table (if not exists)
CREATE TABLE IF NOT EXISTS `geopos_payroll_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `run_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `basic_salary` decimal(10,2) DEFAULT '0.00',
  `cola_amount` decimal(10,2) DEFAULT '0.00',
  `overtime_pay` decimal(10,2) DEFAULT '0.00',
  `bonus_amount` decimal(10,2) DEFAULT '0.00',
  `gross_pay` decimal(10,2) DEFAULT '0.00',
  `epf_employee` decimal(10,2) DEFAULT '0.00',
  `epf_employer` decimal(10,2) DEFAULT '0.00',
  `etf_employer` decimal(10,2) DEFAULT '0.00',
  `loan_deduction` decimal(10,2) DEFAULT '0.00',
  `other_deductions` decimal(10,2) DEFAULT '0.00',
  `net_pay` decimal(10,2) DEFAULT '0.00',
  `status` varchar(20) DEFAULT 'Draft',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `run_id` (`run_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 6. Statutory Deductions Table (if not exists)
CREATE TABLE IF NOT EXISTS `geopos_payroll_statutory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` enum('EPF','ETF','Tax','Other') DEFAULT 'Other',
  `rate_employee` decimal(5,2) DEFAULT '0.00',
  `rate_employer` decimal(5,2) DEFAULT '0.00',
  `max_salary` decimal(10,2) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert default statutory rates if not exists
INSERT IGNORE INTO `geopos_payroll_statutory` (`name`, `type`, `rate_employee`, `rate_employer`, `status`) VALUES
('EPF (Sri Lanka)', 'EPF', 8.00, 12.00, 'Active'),
('ETF (Sri Lanka)', 'ETF', 0.00, 3.00, 'Active');

-- 7. Employee Columns (Add if missing)
ALTER TABLE `geopos_employees` 
  ADD COLUMN IF NOT EXISTS `cola_amount` decimal(10,2) DEFAULT '0.00',
  ADD COLUMN IF NOT EXISTS `epf_no` varchar(50) DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `overtime_eligible` tinyint(1) DEFAULT '1';

-- 8. Employee Loans Table Updates (Add new columns if missing)
ALTER TABLE `geopos_employee_loans` 
  ADD COLUMN IF NOT EXISTS `type` varchar(50) DEFAULT 'Personal',
  ADD COLUMN IF NOT EXISTS `interest_rate` decimal(5,2) DEFAULT '0.00',
  ADD COLUMN IF NOT EXISTS `guarantor` varchar(255) DEFAULT NULL;

-- 9. Workflow Table (if not exists)
CREATE TABLE IF NOT EXISTS `geopos_payroll_workflow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `run_id` int(11) NOT NULL,
  `approver_id` int(11) NOT NULL,
  `action` enum('Submitted','Approved','Rejected') DEFAULT 'Submitted',
  `comments` text,
  `action_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `run_id` (`run_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 10. Overtime Rules Table (if not exists)
CREATE TABLE IF NOT EXISTS `geopos_overtime_rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `multiplier` decimal(3,2) NOT NULL DEFAULT '1.50',
  `applies_after_hours` int(11) DEFAULT '8',
  `applies_on_weekends` tinyint(1) DEFAULT '1',
  `applies_on_holidays` tinyint(1) DEFAULT '1',
  `status` enum('Active','Inactive') DEFAULT 'Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert default overtime rule
INSERT IGNORE INTO `geopos_overtime_rules` (`name`, `multiplier`, `applies_after_hours`) VALUES
('Standard Overtime', 1.50, 8);

-- Success message
SELECT 'Payroll System Migration Completed Successfully!' as Status;
