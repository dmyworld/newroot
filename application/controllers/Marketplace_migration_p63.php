<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marketplace_migration_p63 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('aauth');
        if (!$this->aauth->is_loggedin()) {
            exit('Admin only');
        }
    }

    public function run() {
        $this->load->dbforge();

        // 1. Create tp_dispatch_queue table
        if (!$this->db->table_exists('tp_dispatch_queue')) {
            $this->dbforge->add_field([
                'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE],
                'request_id' => ['type' => 'INT', 'constraint' => 11],
                'provider_id' => ['type' => 'INT', 'constraint' => 11],
                'status' => ['type' => 'ENUM("pending", "pinged", "accepted", "rejected", "timed_out")', 'default' => 'pending'],
                'ping_at' => ['type' => 'DATETIME', 'null' => TRUE],
                'expires_at' => ['type' => 'DATETIME', 'null' => TRUE],
                'created_at' => ['type' => 'DATETIME', 'default' => NULL]
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_key('request_id');
            $this->dbforge->create_table('tp_dispatch_queue');
            $this->db->query("ALTER TABLE `tp_dispatch_queue` MODIFY `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");
            echo "Created tp_dispatch_queue table <br>";
        }

        // 2. Ensure tp_service_requests has delivery-related fields (Phase 6.4)
        if ($this->db->table_exists('tp_service_requests')) {
            $fields = [
                'request_type' => ['type' => 'ENUM("service", "delivery")', 'default' => 'service', 'after' => 'id'],
                'linked_order_id' => ['type' => 'INT', 'constraint' => 11, 'null' => TRUE, 'after' => 'customer_id'],
                'vehicle_type_id' => ['type' => 'INT', 'constraint' => 11, 'null' => TRUE] // For delivery
            ];
            
            $new_fields = [];
            foreach ($fields as $name => $conf) {
                if (!$this->db->field_exists($name, 'tp_service_requests')) {
                    $new_fields[$name] = $conf;
                }
            }
            if (!empty($new_fields)) {
                $this->dbforge->add_column('tp_service_requests', $new_fields);
                echo "Updated tp_service_requests with delivery fields <br>";
            }
        }

        // 3. Create tp_delivery_vehicles (Phase 6.4)
        if (!$this->db->table_exists('tp_delivery_vehicles')) {
            $this->dbforge->add_field([
                'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE],
                'provider_id' => ['type' => 'INT', 'constraint' => 11],
                'vehicle_name' => ['type' => 'VARCHAR', 'constraint' => 100],
                'vehicle_type' => ['type' => 'ENUM("bike", "tuk", "small_truck", "large_truck", "lorry")', 'default' => 'small_truck'],
                'max_load_kg' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
                'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1]
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('tp_delivery_vehicles');
            echo "Created tp_delivery_vehicles table <br>";
        }

        echo "Phase 6.3 & 6.4 Migration Complete!";
    }
}
