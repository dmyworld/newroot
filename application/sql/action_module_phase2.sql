-- Phase 2: "Action" Module (Real-time ops, Matching, Notifications, Wallet, Ratings)
-- Target: CodeIgniter 3.x / PHP 7.4 / MySQL
-- Notes:
-- - This SQL is safe to run multiple times (uses IF NOT EXISTS where possible).
-- - Some ALTERs are conditional in app-level migrations; run carefully if columns already exist.

/* ---------------------------------------------------------------------
 * 1) Vendor real-time fields
 * --------------------------------------------------------------------- */
ALTER TABLE `tp_vendor_profiles`
  ADD COLUMN `last_lat`  DECIMAL(10,7) NULL AFTER `location_long`,
  ADD COLUMN `last_long` DECIMAL(10,7) NULL AFTER `last_lat`,
  ADD COLUMN `is_available` TINYINT(1) NOT NULL DEFAULT 0 AFTER `is_online`,
  ADD COLUMN `last_seen_at` DATETIME NULL AFTER `is_available`;

/* ---------------------------------------------------------------------
 * 2) Provider offerings (what categories/items a provider can accept)
 * --------------------------------------------------------------------- */
CREATE TABLE IF NOT EXISTS `tp_vendor_services` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `category_id` INT UNSIGNED NOT NULL,
  `item_id` INT UNSIGNED NULL,
  `type` ENUM('Product','Service') NOT NULL DEFAULT 'Service',
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user` (`user_id`),
  KEY `idx_cat` (`category_id`),
  KEY `idx_item` (`item_id`),
  KEY `idx_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/* ---------------------------------------------------------------------
 * 3) Action Requests + Ring queue
 * --------------------------------------------------------------------- */
CREATE TABLE IF NOT EXISTS `tp_action_requests` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_id` CHAR(36) NOT NULL, -- UUID to link split project requests
  `customer_id` INT UNSIGNED NOT NULL,
  `category_id` INT UNSIGNED NOT NULL,
  `item_id` INT UNSIGNED NULL,
  `request_type` ENUM('Product','Service') NOT NULL DEFAULT 'Service',
  `customer_lat` DECIMAL(10,7) NOT NULL,
  `customer_long` DECIMAL(10,7) NOT NULL,
  `radius_km` DECIMAL(6,2) NOT NULL DEFAULT 10.00,
  `status` ENUM('pending','searching','accepted','no_provider','cancelled','completed') NOT NULL DEFAULT 'pending',
  `chosen_provider_id` INT UNSIGNED NULL,
  `accepted_at` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_group` (`group_id`),
  KEY `idx_customer` (`customer_id`),
  KEY `idx_status` (`status`),
  KEY `idx_cat_item` (`category_id`,`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tp_action_request_rings` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `request_id` INT UNSIGNED NOT NULL,
  `provider_id` INT UNSIGNED NOT NULL, -- provider user_id
  `distance_km` DECIMAL(7,3) NOT NULL,
  `status` ENUM('pending','notified','accepted','declined','timeout','skipped') NOT NULL DEFAULT 'pending',
  `notified_at` DATETIME NULL,
  `expires_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  KEY `idx_request` (`request_id`),
  KEY `idx_request_status` (`request_id`,`status`),
  KEY `idx_provider` (`provider_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/* ---------------------------------------------------------------------
 * 4) Push tokens (FCM)
 * --------------------------------------------------------------------- */
CREATE TABLE IF NOT EXISTS `tp_push_tokens` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `device_id` VARCHAR(100) NOT NULL,
  `platform` ENUM('android','ios','web') NOT NULL,
  `fcm_token` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_user_device` (`user_id`,`device_id`),
  KEY `idx_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/* ---------------------------------------------------------------------
 * 5) Wallet + transactions (commission + payout)
 * --------------------------------------------------------------------- */
CREATE TABLE IF NOT EXISTS `tp_wallets` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `balance` DECIMAL(14,2) NOT NULL DEFAULT 0.00,
  `currency` VARCHAR(10) NOT NULL DEFAULT 'LKR',
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_wallet_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tp_wallet_transactions` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `wallet_id` INT UNSIGNED NOT NULL,
  `ref_type` ENUM('direct_buy','service','installment','commission','adjustment') NOT NULL,
  `ref_id` INT UNSIGNED NULL,
  `direction` ENUM('credit','debit') NOT NULL,
  `amount` DECIMAL(14,2) NOT NULL,
  `meta` JSON NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_wallet` (`wallet_id`),
  KEY `idx_ref` (`ref_type`,`ref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/* ---------------------------------------------------------------------
 * 6) Ratings (trust + metrics)
 * --------------------------------------------------------------------- */
CREATE TABLE IF NOT EXISTS `tp_provider_ratings` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `request_id` INT UNSIGNED NULL,
  `provider_id` INT UNSIGNED NOT NULL,
  `customer_id` INT UNSIGNED NOT NULL,
  `stars` TINYINT UNSIGNED NOT NULL, -- 1..5
  `punctuality` TINYINT UNSIGNED NULL, -- 1..5
  `work_quality` TINYINT UNSIGNED NULL, -- 1..5
  `comment` VARCHAR(500) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_provider` (`provider_id`),
  KEY `idx_customer` (`customer_id`),
  KEY `idx_request` (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

