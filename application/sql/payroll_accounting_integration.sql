-- Add accounting integration fields to payroll runs
ALTER TABLE `geopos_payroll_runs` 
  ADD COLUMN IF NOT EXISTS `accounting_posted` tinyint(1) DEFAULT 0,
  ADD COLUMN IF NOT EXISTS `accounting_posted_date` datetime DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `payment_posted` tinyint(1) DEFAULT 0,
  ADD COLUMN IF NOT EXISTS `payment_posted_date` datetime DEFAULT NULL;

-- Insert default account configurations if they don't exist
INSERT IGNORE INTO `geopos_payroll_config` (`name`, `value`, `updated_at`) VALUES
  ('payroll_salary_expense_account', '0', NOW()),
  ('payroll_epf_payable_account', '0', NOW()),
  ('payroll_etf_payable_account', '0', NOW()),
  ('payroll_salary_payable_account', '0', NOW()),
  ('payroll_payment_account', '0', NOW());
