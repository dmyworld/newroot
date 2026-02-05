<?php
// DB Setup Script
define('BASEPATH', str_replace("\\", "/", "system"));
define('APPPATH', str_replace("\\", "/", "application"));

// Mock CI constants
define('ENVIRONMENT', 'development');

// Load DB config
require_once('application/config/database.php');

$db = $db['default'];
$mysqli = new mysqli($db['hostname'], $db['username'], $db['password'], $db['database']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// SQL from owner_dashboard_tables.sql
$sql = "
CREATE TABLE IF NOT EXISTS `geopos_risk_alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL DEFAULT '0',
  `branch_id` int(11) NOT NULL DEFAULT '0',
  `warehouse_id` int(11) NOT NULL DEFAULT '0',
  `type` varchar(50) NOT NULL,
  `severity` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `status` enum('New','Viewed','Resolved') NOT NULL DEFAULT 'New',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `geopos_loss_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `branch_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `geopos_staff_scores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `override_count` int(11) NOT NULL DEFAULT '0',
  `return_count` int(11) NOT NULL DEFAULT '0',
  `adjustment_count` int(11) NOT NULL DEFAULT '0',
  `trust_score` int(11) NOT NULL DEFAULT '100',
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_date` (`staff_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `geopos_business_health` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `branch_id` int(11) NOT NULL,
  `health_score` int(11) NOT NULL,
  `profit_trend` decimal(10,2) NOT NULL,
  `loss_percent` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `geopos_stock_health` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `branch_id` int(11) NOT NULL,
  `health_score` int(11) NOT NULL,
  `aging_stock_value` decimal(16,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `geopos_system_insights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `geopos_branch_kpi_snapshots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `sales` decimal(16,2) NOT NULL DEFAULT '0.00',
  `profit` decimal(16,2) NOT NULL DEFAULT '0.00',
  `cash_in_hand` decimal(16,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

if ($mysqli->multi_query($sql)) {
    echo "Tables created successfully";
} else {
    echo "Error creating tables: " . $mysqli->error;
}

$mysqli->close();
