<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Db_payroll_execution_tables extends CI_Controller
{
    public function index()
    {
        $this->load->dbforge();

        // 7. Payroll Runs
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'date_created' => array('type' => 'DATE'),
            'start_date' => array('type' => 'DATE'),
            'end_date' => array('type' => 'DATE'),
            'total_amount' => array('type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0.00),
            'total_tax' => array('type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0.00),
            'status' => array('type' => 'ENUM("Draft", "Finalized", "Paid")', 'default' => 'Draft'),
            'note' => array('type' => 'TEXT', 'null' => TRUE)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('geopos_payroll_runs', TRUE);

        // 8. Payroll Items (Line items for each employee in a run)
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'run_id' => array('type' => 'INT', 'constraint' => 11),
            'employee_id' => array('type' => 'INT', 'constraint' => 11),
            'total_hours' => array('type' => 'DECIMAL', 'constraint' => '5,2'),
            'gross_pay' => array('type' => 'DECIMAL', 'constraint' => '15,2'),
            'tax' => array('type' => 'DECIMAL', 'constraint' => '15,2'),
            'total_deductions' => array('type' => 'DECIMAL', 'constraint' => '15,2'),
            'net_pay' => array('type' => 'DECIMAL', 'constraint' => '15,2'),
            'deduction_details' => array('type' => 'TEXT', 'null' => TRUE) // JSON string of specific deductions
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('geopos_payroll_items', TRUE);

        echo "Payroll Execution Tables Created Successfully.";
    }
}
