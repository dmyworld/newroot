<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Db_carpentry_init extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            echo "Access Denied";
            exit;
        }
    }

    public function index()
    {
        echo "<h1>Initializing Carpenter Production Line Database...</h1>";
        $this->load->dbforge();

        // 1. Wood Types
        if (!$this->db->table_exists('geopos_wood_types')) {
            $this->db->query("CREATE TABLE `geopos_wood_types` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(100) NOT NULL,
                `density` decimal(10,2) NOT NULL COMMENT 'kg/m3',
                `moisture_tolerance_min` decimal(5,2) NOT NULL DEFAULT '0.00',
                `moisture_tolerance_max` decimal(5,2) NOT NULL DEFAULT '0.00',
                `shrinkage_coeff` decimal(10,4) NOT NULL DEFAULT '0.0000',
                `description` text,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
            echo "<p>[SUCCESS] geopos_wood_types created.</p>";
        } else {
            echo "<p>[INFO] geopos_wood_types already exists.</p>";
        }

        // 2. Timber Grades
        if (!$this->db->table_exists('geopos_timber_grades')) {
            $this->db->query("CREATE TABLE `geopos_timber_grades` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `grade_name` varchar(100) NOT NULL,
                `qc_threshold_min` decimal(5,2) NOT NULL DEFAULT '0.00',
                `qc_threshold_max` decimal(5,2) NOT NULL DEFAULT '100.00',
                `rejection_rule_desc` text,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
            echo "<p>[SUCCESS] geopos_timber_grades created.</p>";
        } else {
            echo "<p>[INFO] geopos_timber_grades already exists.</p>";
        }

        // 3. Machines
        if (!$this->db->table_exists('geopos_machines')) {
            $this->db->query("CREATE TABLE `geopos_machines` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL,
                `machine_code` varchar(50) NOT NULL,
                `capacity_per_hour` decimal(12,2) NOT NULL DEFAULT '0.00',
                `maintenance_cycle_days` int(11) NOT NULL DEFAULT '30',
                `last_maintenance_date` date DEFAULT NULL,
                `next_maintenance_date` date DEFAULT NULL,
                `status` varchar(20) NOT NULL DEFAULT 'Active',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
            echo "<p>[SUCCESS] geopos_machines created.</p>";
        } else {
            echo "<p>[INFO] geopos_machines already exists.</p>";
        }

        // 4. Carpenter Skills
        if (!$this->db->table_exists('geopos_skills')) {
            $this->db->query("CREATE TABLE `geopos_skills` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(100) NOT NULL,
                `description` text,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
            echo "<p>[SUCCESS] geopos_skills created.</p>";
        } else {
            echo "<p>[INFO] geopos_skills already exists.</p>";
        }

        // 5. Employee Skills Matrix
        if (!$this->db->table_exists('geopos_emp_skills')) {
            $this->db->query("CREATE TABLE `geopos_emp_skills` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `employee_id` int(11) NOT NULL,
                `skill_id` int(11) NOT NULL,
                `proficiency_level` int(11) NOT NULL DEFAULT '1' COMMENT '1-5',
                `productivity_score` decimal(5,2) NOT NULL DEFAULT '0.00',
                PRIMARY KEY (`id`),
                KEY `employee_id` (`employee_id`),
                KEY `skill_id` (`skill_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
            echo "<p>[SUCCESS] geopos_emp_skills created.</p>";
        } else {
            echo "<p>[INFO] geopos_emp_skills already exists.</p>";
        }
        
        // 6. Seed Specific Units
        $units = array(
            array('name' => 'Cubic Feet', 'code' => 'CFT'),
            array('name' => 'Square Feet', 'code' => 'SFT'),
            array('name' => 'Running Feet', 'code' => 'RFT')
        );

        foreach ($units as $unit) {
            $exist = $this->db->get_where('geopos_units', array('code' => $unit['code']))->row();
            if (!$exist) {
                $this->db->insert('geopos_units', array('name' => $unit['name'], 'code' => $unit['code'], 'type' => 0));
                echo "<p>[SUCCESS] Unit " . $unit['name'] . " created.</p>";
            } else {
                echo "<p>[INFO] Unit " . $unit['name'] . " already exists.</p>";
            }
        }

        // ==========================================
        // PHASE 2: Production Planning & Scheduling
        // ==========================================

        // 7. Production Batches
        if (!$this->db->table_exists('geopos_production_batches')) {
            $this->db->query("CREATE TABLE `geopos_production_batches` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(200) NOT NULL,
                `priority` enum('Low','Medium','High','Urgent') NOT NULL DEFAULT 'Medium',
                `start_date` date DEFAULT NULL,
                `due_date` date DEFAULT NULL,
                `status` enum('Planned','In-Progress','Completed','Cancelled') NOT NULL DEFAULT 'Planned',
                `wood_type_id` int(11) NOT NULL,
                `total_qty` decimal(12,2) NOT NULL DEFAULT '0.00',
                `unit` varchar(20) NOT NULL DEFAULT 'CFT',
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
            echo "<p>[SUCCESS] geopos_production_batches created.</p>";
        } else {
            echo "<p>[INFO] geopos_production_batches already exists.</p>";
        }

        // 8. Production Routes (Stages/Steps)
        if (!$this->db->table_exists('geopos_production_routes')) {
            $this->db->query("CREATE TABLE `geopos_production_routes` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `batch_id` int(11) NOT NULL,
                `machine_id` int(11) DEFAULT NULL,
                `stage_name` varchar(100) NOT NULL,
                `estimated_hours` decimal(10,2) NOT NULL DEFAULT '0.00',
                `sequence_order` int(11) NOT NULL DEFAULT '1',
                PRIMARY KEY (`id`),
                KEY `batch_id` (`batch_id`),
                KEY `machine_id` (`machine_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
            echo "<p>[SUCCESS] geopos_production_routes created.</p>";
        } else {
            echo "<p>[INFO] geopos_production_routes already exists.</p>";
        }

        // 9. Cutting Plans
        if (!$this->db->table_exists('geopos_cutting_plans')) {
            $this->db->query("CREATE TABLE `geopos_cutting_plans` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `batch_id` int(11) DEFAULT NULL,
                `raw_timber_dim` varchar(100) COMMENT 'LxWxH',
                `plank_dim` varchar(100) COMMENT 'LxWxH',
                `planks_count` int(11) NOT NULL DEFAULT '0',
                `waste_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
            echo "<p>[SUCCESS] geopos_cutting_plans created.</p>";
        } else {
            echo "<p>[INFO] geopos_cutting_plans already exists.</p>";
             // Phase 3 Upgrade: Add total_logs_used if not exists
            if(!$this->db->field_exists('total_logs_used', 'geopos_cutting_plans')) {
                $this->db->query("ALTER TABLE `geopos_cutting_plans` ADD COLUMN `total_logs_used` INT(11) DEFAULT 1 AFTER `planks_count`");
                echo "<p>[UPDATE] geopos_cutting_plans altered (Phase 3).</p>";
            }
        }

        // 10. Cutting Plan Items (Phase 3)
        if (!$this->db->table_exists('geopos_cutting_plan_items')) {
            $this->db->query("CREATE TABLE `geopos_cutting_plan_items` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `plan_id` int(11) NOT NULL,
                `target_length` decimal(10,2) NOT NULL,
                `target_width` decimal(10,2) NOT NULL,
                `target_height` decimal(10,2) NOT NULL,
                `quantity_required` int(11) NOT NULL DEFAULT 1,
                PRIMARY KEY (`id`),
                KEY `plan_id` (`plan_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
             echo "<p>[SUCCESS] geopos_cutting_plan_items created.</p>";
        } else {
             echo "<p>[INFO] geopos_cutting_plan_items already exists.</p>";
        }

        // ==========================================
        // PHASE 4: Seasoning & Drying
        // ==========================================

        // 11. Seasoning Batches
        if (!$this->db->table_exists('geopos_seasoning_batches')) {
            $this->db->query("CREATE TABLE `geopos_seasoning_batches` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `batch_name` varchar(200) NOT NULL,
                `method` enum('Kiln','Air Drying') NOT NULL DEFAULT 'Kiln',
                `start_date` date NOT NULL,
                `estimated_end_date` date DEFAULT NULL,
                `status` enum('Active','Completed','Failed') NOT NULL DEFAULT 'Active',
                `initial_mc` decimal(5,2) NOT NULL COMMENT 'Percentage',
                `target_mc` decimal(5,2) NOT NULL COMMENT 'Percentage',
                `current_mc` decimal(5,2) NOT NULL COMMENT 'Percentage',
                `location` varchar(100) DEFAULT NULL COMMENT 'Kiln ID or Shed Name',
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
            echo "<p>[SUCCESS] geopos_seasoning_batches created.</p>";
        } else {
            echo "<p>[INFO] geopos_seasoning_batches already exists.</p>";
        }

        // 12. Seasoning Logs
        if (!$this->db->table_exists('geopos_seasoning_logs')) {
            $this->db->query("CREATE TABLE `geopos_seasoning_logs` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `batch_id` int(11) NOT NULL,
                `check_date` date NOT NULL,
                `moisture_content` decimal(5,2) NOT NULL,
                `temperature` decimal(10,2) DEFAULT NULL,
                `humidity` decimal(10,2) DEFAULT NULL,
                `noted_by` varchar(100) DEFAULT NULL,
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `batch_id` (`batch_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
            echo "<p>[SUCCESS] geopos_seasoning_logs created.</p>";
        } else {
            echo "<p>[INFO] geopos_seasoning_logs already exists.</p>";
        }

        // ==========================================
        // PHASE 5: Work Orders
        // ==========================================

        // 13. Work Orders
        if (!$this->db->table_exists('geopos_work_orders')) {
            $this->db->query("CREATE TABLE `geopos_work_orders` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `batch_id` int(11) NOT NULL,
                `stage_name` varchar(100) NOT NULL,
                `machine_id` int(11) DEFAULT NULL,
                `assigned_employee_id` int(11) DEFAULT NULL,
                `status` enum('Pending','In Progress','Hold','Completed','Rework') NOT NULL DEFAULT 'Pending',
                `start_time` datetime DEFAULT NULL,
                `end_time` datetime DEFAULT NULL,
                `qty_to_make` int(11) NOT NULL DEFAULT 0,
                `qty_completed` int(11) NOT NULL DEFAULT 0,
                `qty_rejected` int(11) NOT NULL DEFAULT 0,
                `remarks` text DEFAULT NULL,
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `batch_id` (`batch_id`),
                KEY `assigned_employee_id` (`assigned_employee_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
            echo "<p>[SUCCESS] geopos_work_orders created.</p>";
        } else {
            echo "<p>[INFO] geopos_work_orders already exists.</p>";
            // Phase 6: Add 'Rework' status if not exists
            // Modification of ENUM is tricky in standard SQL across drivers, but for MySQL:
            // extracting column type to check is complex, we'll blindly attempt modification or skip if manageable.
            // A safer way for CI is raw query.
            $this->db->query("ALTER TABLE `geopos_work_orders` MODIFY COLUMN `status` enum('Pending','In Progress','Hold','Completed','Rework') NOT NULL DEFAULT 'Pending'");
            echo "<p>[UPDATE] geopos_work_orders status ENUM updated (Phase 6).</p>";
        }

        // ==========================================
        // PHASE 6: Quality Control
        // ==========================================

        // 14. QC Inspections
        if (!$this->db->table_exists('geopos_qc_inspections')) {
            $this->db->query("CREATE TABLE `geopos_qc_inspections` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `wo_id` int(11) NOT NULL,
                `inspector_id` int(11) NOT NULL,
                `inspection_date` datetime NOT NULL,
                `qty_checked` int(11) NOT NULL,
                `qty_passed` int(11) NOT NULL,
                `qty_rework` int(11) NOT NULL DEFAULT 0,
                `qty_scraped` int(11) NOT NULL DEFAULT 0,
                `defect_type` varchar(200) DEFAULT NULL,
                `comments` text DEFAULT NULL,
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `wo_id` (`wo_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
            echo "<p>[SUCCESS] geopos_qc_inspections created.</p>";
        } else {
            echo "<p>[INFO] geopos_qc_inspections already exists.</p>";
        }

        // ==========================================
        // PHASE 7: Inventory & WIP
        // ==========================================

        // 15. Production Locations
        if (!$this->db->table_exists('geopos_production_locations')) {
            $this->db->query("CREATE TABLE `geopos_production_locations` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(100) NOT NULL,
                `type` enum('Storage','Work Center','Transit') NOT NULL DEFAULT 'Storage',
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
            echo "<p>[SUCCESS] geopos_production_locations created.</p>";
            
            // Seed Default Locations
            $this->db->query("INSERT INTO `geopos_production_locations` (`name`, `type`) VALUES 
                ('Main Store', 'Storage'),
                ('Sawmill', 'Work Center'),
                ('Drying Kiln', 'Work Center'),
                ('Assembly Floor', 'Work Center'),
                ('Sanding & Finishing', 'Work Center'),
                ('Showroom / Dispatch', 'Storage')
            ");
             echo "<p>[SEED] Default Locations inserted.</p>";
        } else {
            echo "<p>[INFO] geopos_production_locations already exists.</p>";
        }

        // 16. Stock Movements (WIP Tracking)
        if (!$this->db->table_exists('geopos_stock_movements')) {
            $this->db->query("CREATE TABLE `geopos_stock_movements` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `product_id` int(11) NOT NULL,
                `from_location_id` int(11) DEFAULT NULL,
                `to_location_id` int(11) NOT NULL,
                `qty` decimal(10,2) NOT NULL,
                `ref_id` int(11) DEFAULT NULL COMMENT 'Batch ID or WO ID',
                `type` enum('Transfer','Issue','Return','Consumption') NOT NULL DEFAULT 'Transfer',
                `move_date` datetime NOT NULL,
                `note` varchar(255) DEFAULT NULL,
                `created_by` int(11) NOT NULL,
                PRIMARY KEY (`id`),
                KEY `product_id` (`product_id`),
                KEY `to_location_id` (`to_location_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
            echo "<p>[SUCCESS] geopos_stock_movements created.</p>";
        } else {
             echo "<p>[INFO] geopos_stock_movements already exists.</p>";
        }

        // ==========================================
        // PHASE 8: Costing
        // ==========================================
        
        // 17. Add Hourly Rate to Employees
        if(!$this->db->field_exists('hourly_rate', 'geopos_employees')) {
            $this->db->query("ALTER TABLE `geopos_employees` ADD COLUMN `hourly_rate` DECIMAL(10,2) DEFAULT 0.00 AFTER `username`");
            echo "<p>[UPDATE] geopos_employees added hourly_rate.</p>";
        }

        // ==========================================
        // PHASE 9: AI Intelligence
        // ==========================================

        // 19. Production Alerts
        if (!$this->db->table_exists('geopos_production_alerts')) {
            $this->db->query("CREATE TABLE `geopos_production_alerts` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `title` varchar(150) NOT NULL,
                `message` text NOT NULL,
                `type` enum('Delay','Inventory','Machine','Other') NOT NULL DEFAULT 'Other',
                `severity` enum('High','Medium','Low') NOT NULL DEFAULT 'Medium',
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `is_dismissed` tinyint(1) NOT NULL DEFAULT 0,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
             echo "<p>[SUCCESS] geopos_production_alerts created.</p>";
        } else {
             echo "<p>[INFO] geopos_production_alerts already exists.</p>";
        }

        // ==========================================
        // PHASE 10: Maintenance
        // ==========================================

        // 20. Machine Downtime Logs
        if (!$this->db->table_exists('geopos_machine_downtime')) {
            $this->db->query("CREATE TABLE `geopos_machine_downtime` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `machine_id` int(11) NOT NULL,
                `start_time` datetime NOT NULL,
                `end_time` datetime DEFAULT NULL,
                `reason` varchar(255) NOT NULL,
                `reported_by` int(11) NOT NULL,
                `comments` text DEFAULT NULL,
                `is_resolved` tinyint(1) NOT NULL DEFAULT 0,
                PRIMARY KEY (`id`),
                KEY `machine_id` (`machine_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
             echo "<p>[SUCCESS] geopos_machine_downtime created.</p>";
        } else {
             echo "<p>[INFO] geopos_machine_downtime already exists.</p>";
        }

        // 21. Maintenance Schedule
        if (!$this->db->table_exists('geopos_machine_maintenance')) {
            $this->db->query("CREATE TABLE `geopos_machine_maintenance` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `machine_id` int(11) NOT NULL,
                `scheduled_date` date NOT NULL,
                `description` varchar(255) NOT NULL,
                `is_completed` tinyint(1) NOT NULL DEFAULT 0,
                `completed_date` datetime DEFAULT NULL,
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `machine_id` (`machine_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
             echo "<p>[SUCCESS] geopos_machine_maintenance created.</p>";
        } else {
             echo "<p>[INFO] geopos_machine_maintenance already exists.</p>";
        }
        
        echo "<h2>Initialization Complete.</h2>";
    }
}

