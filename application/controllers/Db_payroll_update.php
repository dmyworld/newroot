<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Db_payroll_update extends CI_Controller
{
    public function index()
    {
        $this->load->dbforge();

        // Payroll Table
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'emp_id' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'month' => array(
                'type' => 'INT',
                'constraint' => 2,
            ),
            'year' => array(
                'type' => 'INT',
                'constraint' => 4,
            ),
            'basic_salary' => array(
                'type' => 'DECIMAL',
                'constraint' => '16,2'
            ),
             'overtime_amount' => array(
                'type' => 'DECIMAL',
                'constraint' => '16,2',
                'default' => 0.00
            ),
             'deductions' => array(
                'type' => 'DECIMAL',
                'constraint' => '16,2',
                'default' => 0.00
            ),
            'bonus' => array(
                'type' => 'DECIMAL',
                'constraint' => '16,2',
                'default' => 0.00
            ),
             'tax' => array(
                'type' => 'DECIMAL',
                'constraint' => '16,2',
                'default' => 0.00
            ),
            'net_pay' => array(
                'type' => 'DECIMAL',
                'constraint' => '16,2'
            ),
             'payment_date' => array(
                'type' => 'DATETIME'
            ),
            'status' => array(
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'Paid' // Paid, Pending
            ),
             'note' => array(
                'type' => 'TEXT',
                'null' => TRUE
            )
        );
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('geopos_payroll', TRUE);

        echo "Payroll Tables Created Successfully. You can delete this file now.";
    }
}
