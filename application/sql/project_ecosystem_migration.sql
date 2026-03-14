ALTER TABLE `consumer_orders` ADD COLUMN `project_id` INT UNSIGNED DEFAULT 0 AFTER `id`;
ALTER TABLE `consumer_orders` ADD COLUMN `approval_status` ENUM('not_required', 'pending_owner', 'approved', 'rejected') DEFAULT 'not_required' AFTER `project_id`;
ALTER TABLE `geopos_transactions` ADD COLUMN `project_id` INT UNSIGNED DEFAULT 0 AFTER `id`;

-- Multi-Tenancy business_id Isolation Additions
ALTER TABLE `geopos_transactions` ADD COLUMN `business_id` INT UNSIGNED DEFAULT 0;
ALTER TABLE `geopos_employees` ADD COLUMN `business_id` INT UNSIGNED DEFAULT 0;
ALTER TABLE `geopos_customers` ADD COLUMN `business_id` INT UNSIGNED DEFAULT 0;
ALTER TABLE `geopos_supplier` ADD COLUMN `business_id` INT UNSIGNED DEFAULT 0;
ALTER TABLE `geopos_stock_transfer` ADD COLUMN `business_id` INT UNSIGNED DEFAULT 0;
ALTER TABLE `geopos_purchase` ADD COLUMN `business_id` INT UNSIGNED DEFAULT 0;
ALTER TABLE `geopos_project` ADD COLUMN `business_id` INT UNSIGNED DEFAULT 0;
ALTER TABLE `geopos_register` ADD COLUMN `business_id` INT UNSIGNED DEFAULT 0;
