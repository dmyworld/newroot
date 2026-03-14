<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marketplace_migration_p62 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('aauth');
        if (!$this->aauth || !$this->aauth->is_loggedin()) {
            exit('Admin only');
        }
    }

    public function run() {
        $this->load->dbforge();

        // 1. Update existing product/timber tables
        $tables = ['geopos_products', 'geopos_timber_logs', 'geopos_timber_standing', 'geopos_timber_sawn'];
        $fields = [
            'is_rent' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'product_rent' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => '0.00'],
            'security_deposit' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => '0.00'],
            'rental_terms' => ['type' => 'TEXT', 'null' => TRUE],
            'is_emi_eligible' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0]
        ];

        foreach ($tables as $table) {
            if ($this->db->table_exists($table)) {
                $new_fields = [];
                foreach ($fields as $name => $conf) {
                    if (!$this->db->field_exists($name, $table)) {
                        $new_fields[$name] = $conf;
                    }
                }
                if (!empty($new_fields)) {
                    $this->dbforge->add_column($table, $new_fields);
                    echo "Updated table $table <br>";
                }
            }
        }

        // 2. Create geopos_rentals table
        if (!$this->db->table_exists('geopos_rentals')) {
            $this->dbforge->add_field([
                'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE],
                'product_id' => ['type' => 'INT', 'constraint' => 11],
                'product_type' => ['type' => 'VARCHAR', 'constraint' => 50],
                'customer_id' => ['type' => 'INT', 'constraint' => 11],
                'start_date' => ['type' => 'DATE'],
                'end_date' => ['type' => 'DATE'],
                'status' => ['type' => 'ENUM("pending", "active", "completed", "cancelled")', 'default' => 'pending'],
                'total_price' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
                'security_deposit' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
                'agreement_accepted' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
                'created_at' => ['type' => 'DATETIME', 'default' => NULL]
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('geopos_rentals');
            $this->db->query("ALTER TABLE `geopos_rentals` MODIFY `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");
            echo "Created geopos_rentals table <br>";
        }

        // 3. Create geopos_emi_active table
        if (!$this->db->table_exists('geopos_emi_active')) {
            $this->dbforge->add_field([
                'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE],
                'product_id' => ['type' => 'INT', 'constraint' => 11],
                'product_type' => ['type' => 'VARCHAR', 'constraint' => 50],
                'customer_id' => ['type' => 'INT', 'constraint' => 11],
                'total_amount' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
                'down_payment' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
                'monthly_installment' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
                'duration_months' => ['type' => 'INT', 'constraint' => 3],
                'remaining_balance' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
                'status' => ['type' => 'ENUM("active", "paid_off", "defaulted")', 'default' => 'active'],
                'created_at' => ['type' => 'DATETIME', 'default' => NULL]
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('geopos_emi_active');
            $this->db->query("ALTER TABLE `geopos_emi_active` MODIFY `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");
            echo "Created geopos_emi_active table <br>";
        }

        echo "Migration Complete!";
    }
}
