-- ============================================================
-- TIMBER PRO BLUEPRINT MIGRATION
-- Generated: 2026-02-28
-- Safe to re-run: Uses IF NOT EXISTS / IF NOT EXISTS guards
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- ============================================================
-- SECTION 1: ALTER EXISTING TABLES
-- ============================================================

-- 1a. geopos_users: Add blueprint-required fields
ALTER TABLE `geopos_users` ADD COLUMN `is_verified` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Blueprint: Email/phone verified';
ALTER TABLE `geopos_users` ADD COLUMN `verification_token` VARCHAR(100) DEFAULT NULL COMMENT 'OTP/Email verification token';
ALTER TABLE `geopos_users` ADD COLUMN `verification_expiry` DATETIME DEFAULT NULL COMMENT 'Token expiry timestamp';
ALTER TABLE `geopos_users` ADD COLUMN `provider_type` ENUM('timber','logistics','services','labour','none') NOT NULL DEFAULT 'none' COMMENT 'Blueprint: Provider category';
ALTER TABLE `geopos_users` ADD COLUMN `kyc_status` ENUM('pending','approved','rejected','not_required') NOT NULL DEFAULT 'not_required' COMMENT 'Blueprint: KYC verification status';
ALTER TABLE `geopos_users` ADD COLUMN `kyc_doc_path` VARCHAR(255) DEFAULT NULL COMMENT 'Path to uploaded KYC document';
ALTER TABLE `geopos_users` ADD COLUMN `referral_code` VARCHAR(20) DEFAULT NULL COMMENT 'Unique referral code for this user';
ALTER TABLE `geopos_users` ADD COLUMN `referred_by` INT DEFAULT NULL COMMENT 'User ID who referred this user';
ALTER TABLE `geopos_users` ADD COLUMN `green_points` DECIMAL(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Blueprint: Green Future CSR points';
ALTER TABLE `geopos_users` ADD COLUMN `profile_complete` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Blueprint: Onboarding completed flag';
ALTER TABLE `geopos_users` ADD COLUMN `last_active` DATETIME DEFAULT NULL COMMENT 'Last login/activity timestamp';

-- 1b. geopos_locations: Add GPS, district, province
ALTER TABLE `geopos_locations` ADD COLUMN `gps_lat` DECIMAL(10,8) DEFAULT NULL COMMENT 'Blueprint: Location GPS latitude';
ALTER TABLE `geopos_locations` ADD COLUMN `gps_lng` DECIMAL(11,8) DEFAULT NULL COMMENT 'Blueprint: Location GPS longitude';
ALTER TABLE `geopos_locations` ADD COLUMN `district` VARCHAR(100) DEFAULT NULL COMMENT 'Administrative district';
ALTER TABLE `geopos_locations` ADD COLUMN `province` VARCHAR(100) DEFAULT NULL COMMENT 'Administrative province';
ALTER TABLE `geopos_locations` ADD COLUMN `contact_whatsapp` VARCHAR(20) DEFAULT NULL COMMENT 'WhatsApp number for this location';
ALTER TABLE `geopos_locations` ADD COLUMN `location_type` ENUM('warehouse','showroom','office','depot','hub') NOT NULL DEFAULT 'warehouse' COMMENT 'Blueprint: Location classification';

-- 1c. geopos_products: Add Triple-Mode Logic (Sale, Rent, Installment)
ALTER TABLE `geopos_products` ADD COLUMN `sale_mode` ENUM('sale','rent','installment','all') NOT NULL DEFAULT 'sale' COMMENT 'Blueprint: Triple-Mode Logic';
ALTER TABLE `geopos_products` ADD COLUMN `rent_price_day` DECIMAL(16,2) DEFAULT 0.00 COMMENT 'Daily rental rate';
ALTER TABLE `geopos_products` ADD COLUMN `rent_deposit` DECIMAL(16,2) DEFAULT 0.00 COMMENT 'Security deposit for rental';
ALTER TABLE `geopos_products` ADD COLUMN `is_marketplace_listed` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Listed on Timber Marketplace';
ALTER TABLE `geopos_products` ADD COLUMN `marketplace_expires` DATE DEFAULT NULL COMMENT 'Marketplace listing expiry';

-- 1d. geopos_invoices: Link to escrow and contract reference
ALTER TABLE `geopos_invoices` ADD COLUMN `escrow_id` INT DEFAULT NULL COMMENT 'Blueprint: Linked escrow vault entry';
ALTER TABLE `geopos_invoices` ADD COLUMN `contract_ref` VARCHAR(100) DEFAULT NULL COMMENT 'Blueprint: Auto-generated contract reference';
ALTER TABLE `geopos_invoices` ADD COLUMN `ring_request_id` INT DEFAULT NULL COMMENT 'Originated from a Ring service request';

-- 1e. timber_bids: Add auto-contract generation fields
ALTER TABLE `timber_bids` ADD COLUMN `auto_contract_generated` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Blueprint: Contract auto-generated on acceptance';
ALTER TABLE `timber_bids` ADD COLUMN `contract_path` VARCHAR(255) DEFAULT NULL COMMENT 'Path to generated PDF contract';
ALTER TABLE `timber_bids` ADD COLUMN `escrow_required` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Whether escrow is required for this bid';
ALTER TABLE `timber_bids` ADD COLUMN `escrow_amount` DECIMAL(16,2) DEFAULT 0.00 COMMENT 'Escrow amount to hold';

-- ============================================================
-- SECTION 2: NEW TABLES - RING SYSTEM (Real-time Service Requests)
-- ============================================================

CREATE TABLE IF NOT EXISTS `tp_service_requests` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `request_type` ENUM('timber_delivery','sawmill_service','labour','machinery','transport','other') NOT NULL DEFAULT 'other' COMMENT 'Type of service requested',
    `requester_user_id` INT NOT NULL COMMENT 'Who made the request (geopos_users.id)',
    `requester_loc` INT NOT NULL DEFAULT 0 COMMENT 'Location of requester (geopos_locations.id)',
    `assigned_provider_id` INT DEFAULT NULL COMMENT 'Accepted provider (geopos_users.id)',
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `gps_lat` DECIMAL(10,8) DEFAULT NULL COMMENT 'Request location latitude',
    `gps_lng` DECIMAL(11,8) DEFAULT NULL COMMENT 'Request location longitude',
    `radius_km` DECIMAL(6,2) DEFAULT 10.00 COMMENT 'Ring broadcast radius in km',
    `status` ENUM('pending','ringing','accepted','in_progress','completed','cancelled','expired') NOT NULL DEFAULT 'pending',
    `ring_started_at` DATETIME DEFAULT NULL COMMENT 'When the 30-second ring started',
    `ring_expires_at` DATETIME DEFAULT NULL COMMENT 'When the ring expires (30s rule)',
    `accepted_at` DATETIME DEFAULT NULL,
    `completed_at` DATETIME DEFAULT NULL,
    `budget` DECIMAL(16,2) DEFAULT 0.00,
    `final_amount` DECIMAL(16,2) DEFAULT 0.00,
    `invoice_id` INT DEFAULT NULL COMMENT 'Resulting invoice if created',
    `escrow_id` INT DEFAULT NULL COMMENT 'Linked escrow entry',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `requester_user_id` (`requester_user_id`),
    KEY `assigned_provider_id` (`assigned_provider_id`),
    KEY `status` (`status`),
    KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Blueprint: Ring System - real-time service requests';

CREATE TABLE IF NOT EXISTS `tp_ring_logs` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `request_id` INT NOT NULL COMMENT 'tp_service_requests.id',
    `provider_user_id` INT NOT NULL COMMENT 'Provider who was notified (geopos_users.id)',
    `notified_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `action` ENUM('notified','accepted','rejected','timeout','cancelled') NOT NULL DEFAULT 'notified',
    `action_at` DATETIME DEFAULT NULL,
    `response_seconds` INT DEFAULT NULL COMMENT 'How many seconds to respond',
    PRIMARY KEY (`id`),
    KEY `request_id` (`request_id`),
    KEY `provider_user_id` (`provider_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Blueprint: Ring System - 30-second rule audit trail';

CREATE TABLE IF NOT EXISTS `tp_live_tracking` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `request_id` INT NOT NULL COMMENT 'tp_service_requests.id',
    `user_id` INT NOT NULL COMMENT 'Provider being tracked (geopos_users.id)',
    `gps_lat` DECIMAL(10,8) NOT NULL,
    `gps_lng` DECIMAL(11,8) NOT NULL,
    `speed_kmh` DECIMAL(6,2) DEFAULT NULL,
    `heading` DECIMAL(6,2) DEFAULT NULL COMMENT 'Compass heading in degrees',
    `recorded_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `request_id` (`request_id`),
    KEY `user_id` (`user_id`),
    KEY `recorded_at` (`recorded_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Blueprint: Live GPS tracking for Ring System providers';

-- ============================================================
-- SECTION 3: NEW TABLES - ESCROW VAULT (Secure Payments)
-- ============================================================

CREATE TABLE IF NOT EXISTS `tp_escrow_vault` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `escrow_ref` VARCHAR(50) NOT NULL COMMENT 'Unique escrow reference code (e.g. ESC-20260228-001)',
    `payer_user_id` INT NOT NULL COMMENT 'Who deposited funds (geopos_users.id)',
    `payee_user_id` INT NOT NULL COMMENT 'Who will receive funds on release (geopos_users.id)',
    `amount` DECIMAL(16,2) NOT NULL DEFAULT 0.00,
    `fee` DECIMAL(16,2) NOT NULL DEFAULT 0.00 COMMENT 'Platform escrow fee',
    `net_amount` DECIMAL(16,2) NOT NULL DEFAULT 0.00 COMMENT 'Amount after fee deduction',
    `currency` VARCHAR(10) NOT NULL DEFAULT 'LKR',
    `status` ENUM('pending','held','released','refunded','disputed') NOT NULL DEFAULT 'pending',
    `purpose` ENUM('service_request','bid_contract','marketplace_sale','installment') NOT NULL DEFAULT 'service_request',
    `linked_id` INT DEFAULT NULL COMMENT 'ID of service_request/bid/invoice this is linked to',
    `linked_type` VARCHAR(50) DEFAULT NULL COMMENT 'Table name of linked record (tp_service_requests, timber_bids, etc.)',
    `loc` INT NOT NULL DEFAULT 0,
    `notes` TEXT DEFAULT NULL,
    `held_at` DATETIME DEFAULT NULL,
    `released_at` DATETIME DEFAULT NULL COMMENT 'When funds were released (immutable after set)',
    `refunded_at` DATETIME DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `escrow_ref` (`escrow_ref`),
    KEY `payer_user_id` (`payer_user_id`),
    KEY `payee_user_id` (`payee_user_id`),
    KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Blueprint: Escrow Vault - secure payment holding. No-Delete Policy enforced.';

CREATE TABLE IF NOT EXISTS `tp_escrow_transactions` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `escrow_id` INT NOT NULL COMMENT 'tp_escrow_vault.id',
    `action` ENUM('deposit','hold','release','refund','fee_charge','dispute_open','dispute_resolve') NOT NULL,
    `amount` DECIMAL(16,2) NOT NULL DEFAULT 0.00,
    `performed_by` INT NOT NULL COMMENT 'User who performed action (geopos_users.id)',
    `note` TEXT DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Immutable - no updates allowed by policy',
    PRIMARY KEY (`id`),
    KEY `escrow_id` (`escrow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Blueprint: Escrow transaction ledger. Append-only per No-Delete Policy.';

-- ============================================================
-- SECTION 4: NEW TABLES - AI MARKETING SUBSCRIPTIONS
-- ============================================================

CREATE TABLE IF NOT EXISTS `tp_subscription_packages` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL COMMENT 'e.g. Starter, Pro, Enterprise',
    `description` TEXT DEFAULT NULL,
    `price_monthly` DECIMAL(16,2) NOT NULL DEFAULT 0.00,
    `price_annual` DECIMAL(16,2) NOT NULL DEFAULT 0.00,
    `ai_videos_per_month` INT NOT NULL DEFAULT 0 COMMENT 'No. of AI video generations included',
    `marketplace_listings` INT NOT NULL DEFAULT 0 COMMENT 'Max active marketplace listings',
    `ring_broadcasts` INT NOT NULL DEFAULT 0 COMMENT 'Ring system broadcasts per month',
    `priority_ring` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Priority in ring notifications',
    `analytics_access` TINYINT(1) NOT NULL DEFAULT 0,
    `whatsapp_api_access` TINYINT(1) NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Blueprint: AI Marketing subscription package definitions';

INSERT IGNORE INTO `tp_subscription_packages` (`id`, `name`, `description`, `price_monthly`, `price_annual`, `ai_videos_per_month`, `marketplace_listings`, `ring_broadcasts`, `priority_ring`, `analytics_access`, `whatsapp_api_access`, `is_active`) VALUES
(1, 'Free', 'Basic access with limited features', 0.00, 0.00, 0, 2, 5, 0, 0, 0, 1),
(2, 'Starter', 'Best for small timber businesses', 1490.00, 14900.00, 5, 10, 20, 0, 1, 0, 1),
(3, 'Pro', 'Full AI marketing suite for growing businesses', 3490.00, 34900.00, 20, 50, 100, 1, 1, 1, 1),
(4, 'Enterprise', 'Unlimited AI & Ring priority for large operations', 7990.00, 79900.00, 999, 999, 999, 1, 1, 1, 1);

CREATE TABLE IF NOT EXISTS `tp_business_subscriptions` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `loc` INT NOT NULL COMMENT 'Location/business (geopos_locations.id)',
    `user_id` INT NOT NULL COMMENT 'Owner/admin user (geopos_users.id)',
    `package_id` INT NOT NULL COMMENT 'tp_subscription_packages.id',
    `billing_cycle` ENUM('monthly','annual') NOT NULL DEFAULT 'monthly',
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `status` ENUM('active','expired','cancelled','trial') NOT NULL DEFAULT 'trial',
    `ai_videos_used` INT NOT NULL DEFAULT 0,
    `marketplace_used` INT NOT NULL DEFAULT 0,
    `ring_used` INT NOT NULL DEFAULT 0,
    `payment_ref` VARCHAR(100) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `loc` (`loc`),
    KEY `user_id` (`user_id`),
    KEY `package_id` (`package_id`),
    KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Blueprint: Active subscription records per business location';

CREATE TABLE IF NOT EXISTS `tp_ai_ad_logs` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `subscription_id` INT NOT NULL COMMENT 'tp_business_subscriptions.id',
    `user_id` INT NOT NULL COMMENT 'Who triggered the generation',
    `loc` INT NOT NULL DEFAULT 0,
    `product_id` INT DEFAULT NULL COMMENT 'Product being advertised (geopos_products.pid)',
    `prompt_used` TEXT DEFAULT NULL COMMENT 'AI prompt sent to Revid API',
    `revid_job_id` VARCHAR(255) DEFAULT NULL COMMENT 'Revid API job reference',
    `video_url` VARCHAR(500) DEFAULT NULL COMMENT 'Generated video URL',
    `status` ENUM('queued','processing','completed','failed') NOT NULL DEFAULT 'queued',
    `platform_targets` VARCHAR(255) DEFAULT NULL COMMENT 'e.g. facebook,instagram,tiktok',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `subscription_id` (`subscription_id`),
    KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Blueprint: AI marketing video generation logs (Revid API)';

-- ============================================================
-- SECTION 5: NEW TABLES - GREEN FUTURE (CSR & Environmental)
-- ============================================================

CREATE TABLE IF NOT EXISTS `tp_donation_fund` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `donor_user_id` INT NOT NULL COMMENT 'Customer who donated (geopos_users.id)',
    `donor_invoice_id` INT DEFAULT NULL COMMENT 'Auto-donation from invoice (geopos_invoices.id)',
    `amount` DECIMAL(16,2) NOT NULL DEFAULT 0.00,
    `donation_type` ENUM('invoice_auto','manual','corporate','anonymous') NOT NULL DEFAULT 'manual' COMMENT 'How the donation was made',
    `fund_balance_before` DECIMAL(16,2) NOT NULL DEFAULT 0.00 COMMENT 'Fund balance snapshot before',
    `fund_balance_after` DECIMAL(16,2) NOT NULL DEFAULT 0.00 COMMENT 'Fund balance snapshot after',
    `note` TEXT DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `donor_user_id` (`donor_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Blueprint: Green Future CSR donation fund ledger';

CREATE TABLE IF NOT EXISTS `tp_tree_planting_requests` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `requested_by` INT NOT NULL COMMENT 'User who made the planting request',
    `landowner_user_id` INT DEFAULT NULL COMMENT 'Rural landowner assigned to plant',
    `district` VARCHAR(100) NOT NULL,
    `province` VARCHAR(100) DEFAULT NULL,
    `gps_lat` DECIMAL(10,8) DEFAULT NULL,
    `gps_lng` DECIMAL(11,8) DEFAULT NULL,
    `tree_species` VARCHAR(255) DEFAULT NULL,
    `trees_requested` INT NOT NULL DEFAULT 1,
    `trees_planted` INT NOT NULL DEFAULT 0,
    `cost_per_tree` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `total_cost` DECIMAL(16,2) NOT NULL DEFAULT 0.00,
    `funded_from_donation` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Funded from CSR donation pool',
    `status` ENUM('pending','assigned','in_progress','completed','cancelled') NOT NULL DEFAULT 'pending',
    `assigned_at` DATETIME DEFAULT NULL,
    `completed_at` DATETIME DEFAULT NULL,
    `photo_before` VARCHAR(255) DEFAULT NULL,
    `photo_after` VARCHAR(255) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `requested_by` (`requested_by`),
    KEY `landowner_user_id` (`landowner_user_id`),
    KEY `district` (`district`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Blueprint: Green Future tree planting job orders';

CREATE TABLE IF NOT EXISTS `tp_tree_maintenance_payouts` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `planting_request_id` INT NOT NULL COMMENT 'tp_tree_planting_requests.id',
    `landowner_user_id` INT NOT NULL COMMENT 'Rural landowner paid (geopos_users.id)',
    `payout_type` ENUM('planting','year1_maintenance','year2_maintenance','year3_maintenance','harvest_share') NOT NULL DEFAULT 'planting',
    `amount` DECIMAL(16,2) NOT NULL DEFAULT 0.00,
    `payment_method` VARCHAR(50) DEFAULT 'Bank Transfer',
    `payment_ref` VARCHAR(100) DEFAULT NULL,
    `status` ENUM('pending','paid','failed') NOT NULL DEFAULT 'pending',
    `paid_at` DATETIME DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `planting_request_id` (`planting_request_id`),
    KEY `landowner_user_id` (`landowner_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Blueprint: Payments to rural landowners for tree maintenance';

-- ============================================================
-- SECTION 6: NEW TABLES - REFERRAL PROGRAM
-- ============================================================

CREATE TABLE IF NOT EXISTS `tp_referral_program` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL DEFAULT 'Default Referral Program',
    `referrer_reward_type` ENUM('cash','points','discount','subscription') NOT NULL DEFAULT 'cash',
    `referrer_reward_value` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `referee_reward_type` ENUM('cash','points','discount','subscription') NOT NULL DEFAULT 'discount',
    `referee_reward_value` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `min_purchase_to_qualify` DECIMAL(16,2) NOT NULL DEFAULT 0.00,
    `max_referrals_per_user` INT NOT NULL DEFAULT 0 COMMENT '0 = unlimited',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `valid_from` DATE DEFAULT NULL,
    `valid_until` DATE DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Blueprint: Referral program reward rules';

INSERT IGNORE INTO `tp_referral_program` (`id`, `name`, `referrer_reward_type`, `referrer_reward_value`, `referee_reward_type`, `referee_reward_value`, `min_purchase_to_qualify`, `max_referrals_per_user`, `is_active`) VALUES
(1, 'Default Timber Pro Referral', 'cash', 500.00, 'discount', 10.00, 5000.00, 0, 1);

CREATE TABLE IF NOT EXISTS `tp_referral_logs` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `program_id` INT NOT NULL DEFAULT 1 COMMENT 'tp_referral_program.id',
    `referrer_user_id` INT NOT NULL COMMENT 'User who referred',
    `referee_user_id` INT NOT NULL COMMENT 'New user who joined via referral',
    `referral_code` VARCHAR(20) NOT NULL,
    `qualifying_invoice_id` INT DEFAULT NULL COMMENT 'Invoice that qualified the referral',
    `status` ENUM('pending','qualified','rewarded','rejected') NOT NULL DEFAULT 'pending',
    `referrer_rewarded` TINYINT(1) NOT NULL DEFAULT 0,
    `referee_rewarded` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `referrer_user_id` (`referrer_user_id`),
    KEY `referee_user_id` (`referee_user_id`),
    KEY `referral_code` (`referral_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Blueprint: Per-user referral activity log';

-- ============================================================
-- SECTION 7: NEW TABLES - PROVIDER INSURANCE
-- ============================================================

CREATE TABLE IF NOT EXISTS `tp_provider_insurance` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `provider_user_id` INT NOT NULL COMMENT 'Insured provider (geopos_users.id)',
    `policy_number` VARCHAR(100) NOT NULL,
    `insurer_name` VARCHAR(255) NOT NULL DEFAULT 'TimberPro Group Insurance',
    `coverage_type` ENUM('accident','liability','equipment','life','comprehensive') NOT NULL DEFAULT 'accident',
    `coverage_amount` DECIMAL(16,2) NOT NULL DEFAULT 0.00,
    `premium_monthly` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `status` ENUM('active','expired','cancelled','claimed') NOT NULL DEFAULT 'active',
    `notes` TEXT DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `policy_number` (`policy_number`),
    KEY `provider_user_id` (`provider_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Blueprint: Provider worker accident/liability insurance records';

CREATE TABLE IF NOT EXISTS `tp_provider_insurance_claims` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `insurance_id` INT NOT NULL COMMENT 'tp_provider_insurance.id',
    `claim_ref` VARCHAR(100) NOT NULL,
    `incident_date` DATE NOT NULL,
    `incident_description` TEXT NOT NULL,
    `claim_amount` DECIMAL(16,2) NOT NULL DEFAULT 0.00,
    `approved_amount` DECIMAL(16,2) DEFAULT NULL,
    `status` ENUM('submitted','under_review','approved','rejected','paid') NOT NULL DEFAULT 'submitted',
    `reviewed_by` INT DEFAULT NULL COMMENT 'Admin user who reviewed (geopos_users.id)',
    `reviewed_at` DATETIME DEFAULT NULL,
    `paid_at` DATETIME DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `claim_ref` (`claim_ref`),
    KEY `insurance_id` (`insurance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Blueprint: Provider insurance claim records';

-- ============================================================
-- END OF MIGRATION
-- ============================================================

-- ============================================================
-- SECTION 10: WhatsApp & Automation Plugin Setup (Safe / INSERT IGNORE)
-- ============================================================

-- WhatsApp Gateway plugin row (ID=10 in univarsal_api)
INSERT IGNORE INTO `univarsal_api` (`id`, `method`, `key1`, `key2`, `url`, `active`, `other`)
VALUES (10, 'whatsapp', '', '', 'https://api.ultramsg.com/instance000/messages/chat', 0, 0);

-- WhatsApp Message Templates
INSERT IGNORE INTO `geopos_templates` (`id`, `name`, `type`, `other`) VALUES
(40, 'WA: Invoice Created',      'whatsapp', 'Dear {Name}, your Invoice #{BillNumber} for {Amount} has been created. Due: {DueDate}. Thank you! - Timber Pro'),
(41, 'WA: HP Payment Confirmed', 'whatsapp', 'Dear {Name}, your HP payment of LKR {Amount} for Installment #{InstallmentNum} (Contract #{ContractID}) is confirmed. Thank you!'),
(42, 'WA: Installment Reminder', 'whatsapp', 'Reminder: Dear {Name}, HP Installment #{InstallmentNum} (Contract #{ContractID}) of LKR {Amount} is due on {DueDate}. Please arrange payment. - Timber Pro');
