<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marketplace_migration_p7 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
        if (!$this->aauth->get_user()->roleid == 1) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $this->load->dbforge();
    }

    public function run() {
        echo "Starting Phase 7 Migration...<br>";

        // 1. Add Loyalty Points to Customers
        if (!$this->db->field_exists('loyalty_points', 'geopos_customers')) {
            $fields = array(
                'loyalty_points' => array('type' => 'INT', 'constraint' => 11, 'default' => 0)
            );
            $this->dbforge->add_column('geopos_customers', $fields);
            echo "Added loyalty_points to geopos_customers.<br>";
        }

        // 2. Add loyalty_ratio to geopos_system (1 point per X currency)
        if (!$this->db->field_exists('loyalty_ratio', 'geopos_system')) {
            $fields = array(
                'loyalty_ratio' => array('type' => 'INT', 'constraint' => 11, 'default' => 100)
            );
            $this->dbforge->add_column('geopos_system', $fields);
            echo "Added loyalty_ratio to geopos_system.<br>";
        }

        // 3. Ensure next-order coupon tracking in geopos_invoices
        if (!$this->db->field_exists('next_order_coupon', 'geopos_invoices')) {
            $fields = array(
                'next_order_coupon' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => TRUE)
            );
            $this->dbforge->add_column('geopos_invoices', $fields);
            echo "Added next_order_coupon to geopos_invoices.<br>";
        }

        // 4. Create tp_loyalty_logs for audit
        if (!$this->db->table_exists('tp_loyalty_logs')) {
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
                'customer_id' => array('type' => 'INT', 'constraint' => 11),
                'points' => array('type' => 'INT', 'constraint' => 11),
                'direction' => array('type' => 'ENUM("credit", "debit")'),
                'ref_type' => array('type' => 'VARCHAR', 'constraint' => 50), // invoice, redemption, manual
                'ref_id' => array('type' => 'INT', 'constraint' => 11, 'null' => TRUE),
                'description' => array('type' => 'TEXT', 'null' => TRUE),
                'created_at' => array('type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP')
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('tp_loyalty_logs');
            echo "Created tp_loyalty_logs table.<br>";
        }

        // 5. Create tp_scheduled_messages for future reminders (6-month hooks)
        if (!$this->db->table_exists('tp_scheduled_messages')) {
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
                'customer_id' => array('type' => 'INT', 'constraint' => 11),
                'phone' => array('type' => 'VARCHAR', 'constraint' => 20),
                'message' => array('type' => 'TEXT'),
                'media_url' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
                'scheduled_for' => array('type' => 'DATETIME'),
                'status' => array('type' => 'ENUM("pending", "sent", "failed")', 'default' => 'pending'),
                'created_at' => array('type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP')
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('tp_scheduled_messages');
            echo "Created tp_scheduled_messages table.<br>";
        }

        echo "Phase 7 Migration Completed Successfully!<br>";
        echo "<a href='" . base_url('dashboard') . "'>Return to Dashboard</a>";
    }
}
