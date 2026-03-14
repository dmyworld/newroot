<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_owner_dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        
        // Security check - only allow admin access
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 5) {
            exit('Authorization Failed - Admin access required');
        }
    }

    public function index()
    {
        echo "<h1>Owner Dashboard Setup</h1>";
        echo "<p><a href='" . base_url('setup_owner_dashboard/create_tables') . "'>Create Database Tables</a></p>";
        echo "<p><a href='" . base_url('setup_owner_dashboard/verify_tables') . "'>Verify Tables</a></p>";
    }

    public function create_tables()
    {
        echo "<h2>Creating Owner Dashboard Tables...</h2><br>";
        
        // Table 1: Risk Alerts
        $sql1 = "CREATE TABLE IF NOT EXISTS `geopos_risk_alerts` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `company_id` int(11) DEFAULT 0,
            `branch_id` int(11) DEFAULT 0,
            `staff_id` int(11) DEFAULT 0 COMMENT 'User ID if staff-related',
            `type` varchar(50) COMMENT 'FRAUD_RISK, STOCK_LOSS, SUSPICIOUS_ACTIVITY',
            `severity` enum('Low','Medium','High','Critical') DEFAULT 'Low',
            `message` text,
            `status` enum('New','Reviewed','Resolved','Dismissed') DEFAULT 'New',
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NULL,
            PRIMARY KEY (`id`),
            KEY `branch_id` (`branch_id`),
            KEY `type` (`type`),
            KEY `status` (`status`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        
        if ($this->db->simple_query($sql1)) {
            echo "✓ Created table: geopos_risk_alerts<br>";
        }
        
        // Table 2: Loss Logs
        $sql2 = "CREATE TABLE IF NOT EXISTS `geopos_loss_logs` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `date` date NOT NULL,
            `branch_id` int(11) DEFAULT 0,
            `type` varchar(50) COMMENT 'Stock_Leak, Billing_Error, Return_Abuse, Prevented',
            `amount` decimal(18,2) DEFAULT 0.00,
            `description` text,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `date` (`date`),
            KEY `branch_id` (`branch_id`),
            KEY `type` (`type`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        
        if ($this->db->simple_query($sql2)) {
            echo "✓ Created table: geopos_loss_logs<br>";
        }
        
        // Table 3: Staff Scores
        $sql3 = "CREATE TABLE IF NOT EXISTS `geopos_staff_scores` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `staff_id` int(11) NOT NULL,
            `branch_id` int(11) DEFAULT 0,
            `trust_score` decimal(5,2) DEFAULT 100.00 COMMENT 'Score from 0-100',
            `sales_count` int(11) DEFAULT 0,
            `sales_amount` decimal(18,2) DEFAULT 0.00,
            `void_count` int(11) DEFAULT 0,
            `return_count` int(11) DEFAULT 0,
            `error_count` int(11) DEFAULT 0,
            `last_calculated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `staff_id` (`staff_id`),
            KEY `branch_id` (`branch_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        
        if ($this->db->simple_query($sql3)) {
            echo "✓ Created table: geopos_staff_scores<br>";
        }
        
        // Table 4: Business Health
        $sql4 = "CREATE TABLE IF NOT EXISTS `geopos_business_health` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `date` date NOT NULL,
            `branch_id` int(11) DEFAULT 0,
            `health_index` decimal(5,2) DEFAULT 0.00 COMMENT 'Overall health score 0-100',
            `sales_score` decimal(5,2) DEFAULT 0.00,
            `profit_score` decimal(5,2) DEFAULT 0.00,
            `cashflow_score` decimal(5,2) DEFAULT 0.00,
            `staff_score` decimal(5,2) DEFAULT 0.00,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `date` (`date`),
            KEY `branch_id` (`branch_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        
        if ($this->db->simple_query($sql4)) {
            echo "✓ Created table: geopos_business_health<br>";
        }
        
        // Table 5: Stock Health
        $sql5 = "CREATE TABLE IF NOT EXISTS `geopos_stock_health` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `product_id` int(11) NOT NULL,
            `branch_id` int(11) DEFAULT 0,
            `status` enum('Healthy','Slow_Moving','Dead_Stock') DEFAULT 'Healthy',
            `last_sale_date` date,
            `days_no_sale` int(11) DEFAULT 0,
            `stock_value` decimal(18,2) DEFAULT 0.00,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `product_id` (`product_id`),
            KEY `branch_id` (`branch_id`),
            KEY `status` (`status`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        
        if ($this->db->simple_query($sql5)) {
            echo "✓ Created table: geopos_stock_health<br>";
        }
        
        // Table 6: System Insights
        $sql6 = "CREATE TABLE IF NOT EXISTS `geopos_system_insights` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `date` date NOT NULL,
            `insight_type` varchar(50) COMMENT 'Sales_Trend, Profit_Alert, Stock_Warning',
            `message` text,
            `severity` enum('Info','Warning','Critical') DEFAULT 'Info',
            `is_read` tinyint(1) DEFAULT 0,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `date` (`date`),
            KEY `insight_type` (`insight_type`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        
        if ($this->db->simple_query($sql6)) {
            echo "✓ Created table: geopos_system_insights<br>";
        }
        
        // Table 7: Branch KPI Snapshots
        $sql7 = "CREATE TABLE IF NOT EXISTS `geopos_branch_kpi_snapshots` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `date` date NOT NULL,
            `branch_id` int(11) NOT NULL,
            `sales_amount` decimal(18,2) DEFAULT 0.00,
            `profit_amount` decimal(18,2) DEFAULT 0.00,
            `invoice_count` int(11) DEFAULT 0,
            `customer_count` int(11) DEFAULT 0,
            `avg_transaction` decimal(18,2) DEFAULT 0.00,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `date` (`date`),
            KEY `branch_id` (`branch_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        
        if ($this->db->simple_query($sql7)) {
            echo "✓ Created table: geopos_branch_kpi_snapshots<br>";
        }
        
        // Table 8: Cheques
        $sql8 = "CREATE TABLE IF NOT EXISTS `geopos_cheques` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `type` enum('Incoming','Outgoing') COMMENT 'PDC In or Out',
            `cheque_number` varchar(100),
            `amount` decimal(18,2) DEFAULT 0.00,
            `issue_date` date NOT NULL,
            `clear_date` date,
            `status` enum('Pending','Cleared','Bounced','Cancelled') DEFAULT 'Pending',
            `party_id` int(11) COMMENT 'Customer or Supplier ID',
            `party_type` enum('Customer','Supplier') DEFAULT 'Customer',
            `bank` varchar(200),
            `branch` varchar(200),
            `branch_id` int(11) DEFAULT 0 COMMENT 'Company Branch ID',
            `tid` int(11) COMMENT 'Transaction ID when synced',
            `notes` text,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NULL,
            PRIMARY KEY (`id`),
            KEY `type` (`type`),
            KEY `status` (`status`),
            KEY `branch_id` (`branch_id`),
            KEY `party_id` (`party_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        
        if ($this->db->simple_query($sql8)) {
            echo "✓ Created table: geopos_cheques<br>";
        }
        
        echo "<br><h3 style='color: green;'>✓ All tables created successfully!</h3>";
        echo "<p><a href='" . base_url('setup_owner_dashboard/verify_tables') . "'>Verify Tables</a></p>";
        echo "<p><a href='" . base_url('ownerdashboard') . "'>Go to Owner Dashboard</a></p>";
    }

    public function verify_tables()
    {
        echo "<h2>Verifying Owner Dashboard Tables...</h2><br>";
        
        $tables = array(
            'geopos_risk_alerts',
            'geopos_loss_logs',
            'geopos_staff_scores',
            'geopos_business_health',
            'geopos_stock_health',
            'geopos_system_insights',
            'geopos_branch_kpi_snapshots',
            'geopos_cheques'
        );
        
        $all_exist = true;
        foreach ($tables as $table) {
            if ($this->db->table_exists($table)) {
                $count = $this->db->count_all($table);
                echo "✓ Table '$table' exists (Rows: $count)<br>";
            } else {
                echo "✗ Table '$table' MISSING<br>";
                $all_exist = false;
            }
        }
        
        if ($all_exist) {
            echo "<br><h3 style='color: green;'>✓ All tables verified successfully!</h3>";
            echo "<p><a href='" . base_url('ownerdashboard') . "'>Go to Owner Dashboard</a></p>";
        } else {
            echo "<br><h3 style='color: red;'>✗ Some tables are missing. Please run table creation.</h3>";
            echo "<p><a href='" . base_url('setup_owner_dashboard/create_tables') . "'>Create Tables</a></p>";
        }
    }
}
