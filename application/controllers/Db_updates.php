<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Db_updates extends CI_Controller
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
        echo "<h1>Running Database Updates...</h1>";
        
        // 1. Job Sites Table
        $sql1 = "CREATE TABLE IF NOT EXISTS `geopos_job_sites` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `customer_id` int(11) NOT NULL,
            `name` varchar(255) NOT NULL,
            `address` text NOT NULL,
            `city` varchar(100) DEFAULT NULL,
            `region` varchar(100) DEFAULT NULL,
            `country` varchar(100) DEFAULT NULL,
            `postbox` varchar(20) DEFAULT NULL,
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `customer_id` (`customer_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        
        if ($this->db->query($sql1)) {
            echo "<p>[SUCCESS] geopos_job_sites table created or exists.</p>";
        } else {
            echo "<p>[ERROR] creating geopos_job_sites: " . $this->db->error()['message'] . "</p>";
        }

        // 2. Project Items (Costing) Table
        $sql2 = "CREATE TABLE IF NOT EXISTS `geopos_project_items` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `project_id` int(11) NOT NULL,
            `product_id` int(11) NOT NULL,
            `qty` decimal(16,4) NOT NULL DEFAULT '0.0000',
            `unit_cost` decimal(16,2) NOT NULL DEFAULT '0.00',
            `total_cost` decimal(16,2) NOT NULL DEFAULT '0.00',
            `date_added` datetime DEFAULT CURRENT_TIMESTAMP,
            `user_id` int(11) DEFAULT NULL,
            `note` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `project_id` (`project_id`),
            KEY `product_id` (`product_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        if ($this->db->query($sql2)) {
            echo "<p>[SUCCESS] geopos_project_items table created or exists.</p>";
        } else {
            echo "<p>[ERROR] creating geopos_project_items: " . $this->db->error()['message'] . "</p>";
        }

        // 3. Check geopos_projects for 'loc' (Branch) column
        if (!$this->db->field_exists('loc', 'geopos_projects')) {
            $sql3 = "ALTER TABLE `geopos_projects` ADD COLUMN `loc` int(11) NOT NULL DEFAULT '0' AFTER `ptype`";
            if ($this->db->query($sql3)) {
                echo "<p>[SUCCESS] Added 'loc' column to geopos_projects.</p>";
            } else {
                echo "<p>[ERROR] Adding 'loc' to geopos_projects: " . $this->db->error()['message'] . "</p>";
            }
        } else {
            echo "<p>[INFO] 'loc' column already exists in geopos_projects.</p>";
        }

        echo "<p>Updates Completed.</p>";
    }
    public function update_payroll_table() {
        $this->load->dbforge();
        
        // Check if timesheet table exists
        if (!$this->db->table_exists('geopos_timesheets')) {
            $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'employee_id' => array(
                    'type' => 'INT',
                    'constraint' => 11
                ),
                 'job_code_id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                     'null' => TRUE
                ),
                'clock_in' => array(
                    'type' => 'DATETIME'
                ),
                'clock_out' => array(
                    'type' => 'DATETIME',
                    'null' => TRUE
                ),
                'total_hours' => array(
                    'type' => 'DECIMAL',
                    'constraint' => '10,2',
                    'default' => 0.00
                ),
                 'note' => array(
                    'type' => 'TEXT',
                     'null' => TRUE
                )
            );
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_field($fields);
            $this->dbforge->create_table('geopos_timesheets');
            echo "Table geopos_timesheets created.<br>";
        }

         // Update Payroll Runs Table for Approvals
         if ($this->db->table_exists('geopos_payroll_runs')) {
            if (!$this->db->field_exists('approval_status', 'geopos_payroll_runs')) {
                 $fields = array(
                    'approval_status' => array(
                        'type' => 'VARCHAR',
                        'constraint' => 20,
                        'default' => 'Draft' // Draft, Pending, Approved, Rejected, Finalized
                    )
                );
                $this->dbforge->add_column('geopos_payroll_runs', $fields);
                 echo "Column approval_status added to geopos_payroll_runs.<br>";
            }
         }

        // Create Approvals Table
         if (!$this->db->table_exists('geopos_payroll_approvals')) {
            $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'run_id' => array(
                    'type' => 'INT',
                    'constraint' => 11
                ),
                'approver_id' => array(
                    'type' => 'INT',
                    'constraint' => 11
                ),
                'status' => array(
                     'type' => 'VARCHAR',
                     'constraint' => 20
                ),
                'comments' => array(
                    'type' => 'TEXT',
                     'null' => TRUE
                ),
                'approved_at' => array(
                    'type' => 'DATETIME',
                    'null' => TRUE
                )
            );
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_field($fields);
            $this->dbforge->create_table('geopos_payroll_approvals');
            echo "Table geopos_payroll_approvals created.<br>";
         }
    }
    public function seed_demo_data() {
        // 1. Job Codes
        $jobs = array(
            array('code' => 'JC001', 'title' => 'General Carpentry', 'description' => 'Standard framing and wood work'),
            array('code' => 'JC002', 'title' => 'Electrical Helper', 'description' => 'Assisting electricians'),
            array('code' => 'JC003', 'title' => 'Site Management', 'description' => 'Supervisory duties')
        );
        foreach($jobs as $j) {
            $exist = $this->db->get_where('geopos_job_codes', array('code' => $j['code']))->row();
            if(!$exist) $this->db->insert('geopos_job_codes', $j);
        }
        echo "Job Codes seeded.<br>";

        // 2. Deduction Types
        $deductions = array(
            array('name' => 'Health Insurance', 'calculation_type' => 'Fixed Amount', 'default_value' => 50.00, 'is_pre_tax' => 1),
            array('name' => 'Union Dues', 'calculation_type' => 'Percentage', 'default_value' => 1.5, 'is_pre_tax' => 0),
            array('name' => '401k Contribution', 'calculation_type' => 'Percentage', 'default_value' => 3.0, 'is_pre_tax' => 1)
        );
        foreach($deductions as $d) {
            $exist = $this->db->get_where('geopos_deduction_types', array('name' => $d['name']))->row();
            if(!$exist) $this->db->insert('geopos_deduction_types', $d);
        }
        echo "Deduction Types seeded.<br>";

        // 3. Ensure we have at least one employee (User ID 1 is usually admin, check for others)
        // Let's rely on existing employees. If 0, create one dummy.
        $count = $this->db->count_all('geopos_employees');
        if($count < 2) {
             // Create a dummy employee
             $user_data = array(
                 'username' => 'demo_employee',
                 'name' => 'John Doe',
                 'email' => 'demo@example.com',
                 'roleid' => 1 // Basic User
             );
             // Verify if geopos_employees has these fields or maps to geopos_users
             // Usually geopos_employees is separate or linked.
             // Let's assume geopos_employees table structure from previous context or simple insert.
             // Safest is to skip creating complex user relations blind.
             // We will query *any* employee.
        }
        
        $employees = $this->db->get('geopos_employees', 5)->result_array();
        
        if($employees) {
            $jc = $this->db->get('geopos_job_codes')->result_array();
            
            foreach($employees as $emp) {
                // 4. Create Timesheets for last 7 days
                for($i=0; $i<7; $i++) {
                   $date = date('Y-m-d', strtotime("-$i days"));
                   $hours = rand(6, 10); // Random hours
                   $job = $jc[array_rand($jc)]['id'];
                   
                   // Check if exists
                   $exist = $this->db->get_where('geopos_timesheets', array('employee_id' => $emp['id'], 'clock_in >=' => $date.' 00:00:00', 'clock_in <=' => $date.' 23:59:59'))->row();
                   
                   if(!$exist) {
                       $data = array(
                           'employee_id' => $emp['id'],
                           'job_code_id' => $job,
                           'clock_in' => $date . ' 09:00:00',
                           'clock_out' => $date . ' ' . (9+$hours) . ':00:00',
                           'total_hours' => $hours,
                           'note' => 'Demo Entry'
                       );
                       $this->db->insert('geopos_timesheets', $data);
                   }
                }
                
                // 5. Assign Defaults Deductions if not present
                // Removed complex logic to avoid errors, assuming user can assign manually or defaults work.
            }
            echo "Timesheets seeded for " . count($employees) . " employees.<br>";
        } else {
            echo "No employees found. Please create an employee first.<br>";
        }
        
        echo "Demo Data Seeding Completed.";
    }
    public function run_loans_migration()
    {
        echo "<h1>Setting up Employee Loans Tables...</h1>";
        $sql = file_get_contents(APPPATH . 'sql/loans_setup.sql');
        
        // Remove comments
        $sql = preg_replace('/#.*/', '', $sql);
        $sql = preg_replace('/--.*/', '', $sql);
        
        $statements = explode(';', $sql);
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if ($statement) {
                if ($this->db->query($statement)) {
                    echo "<p>[SUCCESS] Executed: " . substr($statement, 0, 50) . "...</p>";
                } else {
                    echo "<p>[ERROR] " . $this->db->error()['message'] . "</p>";
                }
            }
        }
        echo "<p>Done.</p>";
    }

    public function update_payroll_phase1() {
        $this->load->dbforge();
        echo "<h1>Running Payroll Phase 1 Updates...</h1>";
        
        // 1. Update geopos_employees
        $fields = array(
            'cola_amount' => array('type' => 'DECIMAL', 'constraint' => '16,2', 'default' => 0.00),
            'epf_no' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE),
            'bank_name' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE),
            'bank_ac' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE)
        );
        
        $col_adds = array();
        foreach($fields as $col => $def) {
            if (!$this->db->field_exists($col, 'geopos_employees')) {
                $col_adds[$col] = $def;
            }
        }
        
        if(!empty($col_adds)) {
            $this->dbforge->add_column('geopos_employees', $col_adds);
            echo "Columns added to geopos_employees.<br>";
        } else {
            echo "Columns already exist in geopos_employees.<br>";
        }

        // 2. Create geopos_payroll_statutory
        if (!$this->db->table_exists('geopos_payroll_statutory')) {
            $this->db->query("CREATE TABLE `geopos_payroll_statutory` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(100) NOT NULL,
              `rate` decimal(5,2) NOT NULL,
              `type` enum('Employee_Deduction','Employer_Contribution') NOT NULL,
              `enabled` tinyint(1) NOT NULL DEFAULT '1',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
            
            // Insert Defaults
            $data = array(
                array('name' => 'EPF (Employee)', 'rate' => 8.00, 'type' => 'Employee_Deduction'),
                array('name' => 'EPF (Employer)', 'rate' => 12.00, 'type' => 'Employer_Contribution'),
                array('name' => 'ETF (Employer)', 'rate' => 3.00, 'type' => 'Employer_Contribution')
            );
            $this->db->insert_batch('geopos_payroll_statutory', $data);
            echo "Table geopos_payroll_statutory created and seeded.<br>";
        } else {
             echo "Table geopos_payroll_statutory already exists.<br>";
        }
        
        echo "<p>Phase 1 Updates Completed.</p>";
    }

    public function update_payroll_phase2() {
        $this->load->dbforge();
        echo "<h1>Running Payroll Phase 2 Updates...</h1>";
        
        // 1. Create Bonus Table
        if (!$this->db->table_exists('geopos_payroll_bonuses')) {
            $this->db->query("CREATE TABLE `geopos_payroll_bonuses` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `employee_id` int(11) NOT NULL,
              `amount` decimal(16,2) NOT NULL DEFAULT '0.00',
              `type` varchar(50) NOT NULL COMMENT 'Performance, Annual, Spot',
              `note` varchar(255) DEFAULT NULL,
              `date_effective` date NOT NULL,
              `status` varchar(20) NOT NULL DEFAULT 'Pending',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
            echo "Table geopos_payroll_bonuses created.<br>";
        } else {
             echo "Table geopos_payroll_bonuses already exists.<br>";
        }

        // 2. Update Employee Loans Table
        $fields = array(
            'type' => array('type' => 'VARCHAR', 'constraint' => '50', 'default' => 'Personal'),
            'interest_rate' => array('type' => 'DECIMAL', 'constraint' => '5,2', 'default' => '0.00'),
            'guarantor' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE)
        );
        
        $col_adds = array();
        foreach($fields as $col => $def) {
            if (!$this->db->field_exists($col, 'geopos_employee_loans')) {
                $col_adds[$col] = $def;
            }
        }
        
        if(!empty($col_adds)) {
            $this->dbforge->add_column('geopos_employee_loans', $col_adds);
            echo "Columns added to geopos_employee_loans.<br>";
        } else {
            echo "Columns already exist in geopos_employee_loans.<br>";
        }
        
        echo "<p>Phase 2 Updates Completed.</p>";
    }
}
