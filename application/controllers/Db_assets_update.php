<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Db_assets_update extends CI_Controller
{
    public function index()
    {
        $this->load->dbforge();

        // Assets Table
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'serial' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ),
             'qty' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1
            ),
            'value' => array(
                'type' => 'DECIMAL',
                'constraint' => '16,2',
                'default' => 0.00
            ),
            'status' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => 'Available' // Available, Assigned, Damaged, Lost
            ),
            'assigned_to' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ),
             'note' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'date_acquired' => array(
                'type' => 'DATE',
                 'null' => TRUE
            )
        );
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('geopos_assets', TRUE);

        echo "Assets Tables Created Successfully. You can delete this file now.";
    }
}
