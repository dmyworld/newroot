<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DebugPayroll extends CI_Controller {

    public function index() {
        echo "<h1>Internal Calculation Debugger</h1>";
        
        $this->load->model('payroll_engine_model', 'engine');
        $this->load->model('employee_model', 'employee');
        
        $emp_id = 1;
        $start = '2026-01-25';
        $end = '2026-02-05';
        
        echo "<h3>1. Testing Employee Fetches</h3>";
        $emp = $this->employee->employee_details($emp_id);
        echo "<pre>"; print_r($emp); echo "</pre>";
        
        if(!isset($emp['salary'])) {
            echo "<h2 style='color:red'>CRITICAL: 'salary' column missing from employee_details() result!</h2>";
        } else {
            echo "Salary found: " . $emp['salary'] . "<br>";
        }
        
        echo "<h3>2. Testing Calculation Engine</h3>";
        $result = $this->engine->calculate_payroll($emp_id, $start, $end);
        
        echo "<pre>"; print_r($result); echo "</pre>";
        
        if($result['gross'] == 0) {
             echo "<h2 style='color:red'>Result is ZERO. Check logic.</h2>";
        } else {
             echo "<h2 style='color:green'>Calculation Successful: " . $result['gross'] . "</h2>";
        }
    }
}
