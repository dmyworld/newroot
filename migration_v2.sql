-- Migration script for User Roles, Global Admin Control, and Advanced Inventory

-- 1. Updates to geopos_products for Triple-Mode Logic and Master List
ALTER TABLE `geopos_products` 
ADD COLUMN `is_sale` TINYINT(1) DEFAULT 1,
ADD COLUMN `is_rent` TINYINT(1) DEFAULT 0,
ADD COLUMN `is_installment` TINYINT(1) DEFAULT 0,
ADD COLUMN `master_pid` INT(11) DEFAULT 0;

-- 2. Updates to geopos_product_cat for Approval Workflow
ALTER TABLE `geopos_product_cat` 
ADD COLUMN `status` TINYINT(1) DEFAULT 1, -- 1=Approved by default for existing, 0=Pending
ADD COLUMN `requested_by` INT(11) DEFAULT 0;

-- 3. Updates to geopos_employees for Verification and Benefits
ALTER TABLE `geopos_employees` 
ADD COLUMN `verified` TINYINT(1) DEFAULT 0,
ADD COLUMN `insurance_id` VARCHAR(100) DEFAULT NULL,
ADD COLUMN `security_service` TINYINT(1) DEFAULT 0;

-- 4. Define Roles in aauth_groups
-- Assuming standard IDs or checking presence first
-- Standard IDs usually: 1=Public, 2=Default, 3=User, 4=Manager, 5=Admin
-- We will add/ensure the specific roles requested

INSERT INTO `aauth_groups` (`name`, `definition`) VALUES 
('Super Admin', 'Full Global Control'),
('Business Owner', 'Control over own locations'),
('Location Manager', 'Manager for specific location'),
('Store Keeper', 'Inventory Management'),
('Cashier', 'Sales only'),
('Accountant', 'Financial data only'),
('Customer', 'Client access'),
('Service Provider', 'Partner access')
ON DUPLICATE KEY UPDATE `definition` = VALUES(`definition`);
