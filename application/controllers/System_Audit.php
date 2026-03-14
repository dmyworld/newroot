<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Audit extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('aauth');
        if (!$this->aauth->is_loggedin() && !is_cli()) {
            exit('Admin only');
        }
        $this->load->dbforge();
    }

    public function run_all() {
        echo "<h1>TimberPro System Health Audit</h1>";
        $this->audit_database();
        $this->audit_logs();
        $this->audit_controllers();
    }

    private function audit_database() {
        echo "<h2>1. Database Integrity Check</h2>";
        
        $required_tables = [
            'tp_service_categories',
            'tp_services',
            'tp_service_requests',
            'geopos_rentals',
            'geopos_emi_active',
            'geopos_worker_profiles'
        ];

        foreach ($required_tables as $table) {
            if ($this->db->table_exists($table)) {
                echo "<span style='color:green'>[PASS]</span> Table <b>$table</b> exists.<br>";
            } else {
                echo "<span style='color:red'>[FAIL]</span> Table <b>$table</b> is MISSING.<br>";
            }
        }

        // Check specific columns that caused errors
        $column_checks = [
            'geopos_employees' => ['loc', 'salary', 'phone'],
            'geopos_users' => ['loc'],
            'tp_services' => ['admin_commission_pc']
        ];

        foreach ($column_checks as $table => $columns) {
            if ($this->db->table_exists($table)) {
                foreach ($columns as $col) {
                    if ($this->db->field_exists($col, $table)) {
                        echo "<span style='color:green'>[PASS]</span> $table.<b>$col</b> exists.<br>";
                    } else {
                        echo "<span style='color:red'>[FAIL]</span> $table.<b>$col</b> is MISSING. <a href='".site_url("System_Audit/fix_column/$table/$col")."'>[Fix Now]</a><br>";
                    }
                }
            }
        }
    }

    public function fix_column($table, $column) {
        if (!$this->db->table_exists($table)) exit("Table $table not found");
        
        $fields = [];
        if ($column == 'loc') {
            $fields['loc'] = ['type' => 'INT', 'constraint' => 11, 'default' => 0];
        } elseif ($column == 'salary') {
            $fields['salary'] = ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => '0.00'];
        } elseif ($column == 'phone') {
            $fields['phone'] = ['type' => 'VARCHAR', 'constraint' => '100', 'default' => ''];
        } elseif ($column == 'admin_commission_pc') {
            $fields['admin_commission_pc'] = ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => '0.00'];
        }

        if (!empty($fields)) {
            $this->dbforge->add_column($table, $fields);
            echo "Column $column added to $table successfully. <a href='".site_url('System_Audit/run_all')."'>Back to Audit</a>";
        }
    }

    private function audit_logs() {
        echo "<h2>2. Recent Error Log Analysis</h2>";
        $log_path = APPPATH . 'logs/log-' . date('Y-m-d') . '.php';
        if (file_exists($log_path)) {
            $content = file_get_contents($log_path);
            $errors = preg_grep('/ERROR - /', explode("\n", $content));
            echo "Found " . count($errors) . " errors in today's log.<br>";
            echo "<pre style='background:#f4f4f4; padding:10px;'>";
            foreach (array_slice($errors, -10) as $err) {
                echo htmlspecialchars($err) . "\n";
            }
            echo "</pre>";
        } else {
            echo "No logs found for today.<br>";
        }
    }

    private function audit_controllers() {
        echo "<h2>3. Controller/Model Sanity Check</h2>";
        $controllers = ['Shop', 'ServiceDashboard', 'Dispatch', 'Invoices', 'Marketplace_migration_p62'];
        foreach ($controllers as $c) {
            if (file_exists(APPPATH . 'controllers/' . $c . '.php')) {
                echo "<span style='color:green'>[OK]</span> Controller <b>$c</b> found.<br>";
            } else {
                echo "<span style='color:red'>[MISSING]</span> Controller <b>$c</b> file not found.<br>";
            }
        }
    }
}
