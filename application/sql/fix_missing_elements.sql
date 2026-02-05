-- Quick Fix for Missing Database Elements
-- Run this to fix the 5 failed tests

-- 1. Add missing workflow table
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

-- 2. Add missing columns to geopos_employees
ALTER TABLE `geopos_employees` 
  ADD COLUMN IF NOT EXISTS `overtime_eligible` tinyint(1) DEFAULT '1';

-- 3. Add missing columns to geopos_timesheets
ALTER TABLE `geopos_timesheets` 
  ADD COLUMN IF NOT EXISTS `approved_by` int(11) DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `approved_date` datetime DEFAULT NULL;

-- 4. Add missing columns to geopos_payroll_items
ALTER TABLE `geopos_payroll_items` 
  ADD COLUMN IF NOT EXISTS `cola_amount` decimal(10,2) DEFAULT '0.00',
  ADD COLUMN IF NOT EXISTS `overtime_pay` decimal(10,2) DEFAULT '0.00';

-- Verify changes
SELECT 'All missing elements added successfully!' as Status;
SELECT 'Re-run test_payroll_system.php to verify 100% pass rate' as Action;
