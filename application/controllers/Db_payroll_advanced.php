<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Db_payroll_advanced extends CI_Controller
{
    public function index()
    {
        $this->load->dbforge();

        // 1. Config Table
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'name' => array('type' => 'VARCHAR', 'constraint' => 100, 'unique' => TRUE),
            'value' => array('type' => 'TEXT', 'null' => TRUE),
            'updated_at' => array('type' => 'DATETIME', 'null' => TRUE)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('geopos_payroll_config', TRUE);

        // 2. Overtime Rules
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'name' => array('type' => 'VARCHAR', 'constraint' => 100),
            'type' => array('type' => 'ENUM("daily", "weekly", "holiday", "weekend")', 'default' => 'weekly'),
            'threshold_hours' => array('type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 40.00),
            'rate_multiplier' => array('type' => 'DECIMAL', 'constraint' => '3,2', 'default' => 1.50),
            'is_active' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('geopos_overtime_rules', TRUE);

        // 3. Deduction Types
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'name' => array('type' => 'VARCHAR', 'constraint' => 100),
            'category' => array('type' => 'ENUM("Tax", "Social Security", "Medicare", "Insurance", "Retirement", "Other")', 'default' => 'Other'),
            'is_pre_tax' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
            'calculation_type' => array('type' => 'ENUM("Percentage", "Fixed Amount")', 'default' => 'Fixed Amount'),
            'default_value' => array('type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00),
            'employer_match_percent' => array('type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0.00),
            'is_active' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('geopos_deduction_types', TRUE);

        // 4. Job Codes
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'code' => array('type' => 'VARCHAR', 'constraint' => 20, 'unique' => TRUE),
            'title' => array('type' => 'VARCHAR', 'constraint' => 100),
            'description' => array('type' => 'TEXT', 'null' => TRUE),
            'hourly_rate' => array('type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00),
            'is_active' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('geopos_job_codes', TRUE);

        // 5. Employee Deductions (Linking table)
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'employee_id' => array('type' => 'INT', 'constraint' => 11),
            'deduction_type_id' => array('type' => 'INT', 'constraint' => 11),
            'amount_override' => array('type' => 'DECIMAL', 'constraint' => '10,2', 'null' => TRUE),
            'percentage_override' => array('type' => 'DECIMAL', 'constraint' => '5,2', 'null' => TRUE),
            'effective_date' => array('type' => 'DATE', 'null' => TRUE)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('geopos_emp_deductions', TRUE);

         // 6. Timesheet (Enhanced)
         $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'employee_id' => array('type' => 'INT', 'constraint' => 11),
            'job_code_id' => array('type' => 'INT', 'constraint' => 11, 'null' => TRUE),
            'project_id' => array('type' => 'INT', 'constraint' => 11, 'null' => TRUE),
            'date' => array('type' => 'DATE'),
            'start_time' => array('type' => 'TIME', 'null' => TRUE),
            'end_time' => array('type' => 'TIME', 'null' => TRUE),
            'total_hours' => array('type' => 'DECIMAL', 'constraint' => '5,2'),
            'is_overtime' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
            'status' => array('type' => 'ENUM("Pending", "Approved", "Rejected")', 'default' => 'Pending'),
            'approved_by' => array('type' => 'INT', 'constraint' => 11, 'null' => TRUE)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('geopos_timesheets', TRUE);


        echo "Advanced Payroll Tables Created Successfully.";
    }
}
