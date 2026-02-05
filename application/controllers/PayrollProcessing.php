<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PayrollProcessing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('payroll_engine_model', 'engine');
        $this->load->model('employee_model', 'employee');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Run Payroll';
        
        // Employees loaded via AJAX in view
        
        $this->load->view('fixed/header', $head);
        $this->load->view('payroll/processing/index');
        $this->load->view('fixed/footer');
    }

    public function get_employees() {
        $list = $this->employee->list_employee();
        $data = array();
        foreach ($list as $emp) {
            $data[] = array(
                'id' => $emp['id'],
                'name' => $emp['name'],
                'role' => isset($emp['roleid']) ? $emp['roleid'] : '',
                'dept' => isset($emp['dept']) ? $emp['dept'] : 'N/A'
            );
        }
        echo json_encode(array('data' => $data));
    }

    // AJAX Endpoint to Preview Payroll
    public function preview() {
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $employees = $this->input->post('employee_ids'); // Array

        $results = array();
        
        if($employees) {
            foreach($employees as $eid) {
                // Modified to pass logic for preview
                $calc = $this->engine->calculate_payroll($eid, $start, $end);
                if($calc) $results[] = $calc;
            }
        }
        
        $data['results'] = $results;
        $data['start'] = $start;
        $data['end'] = $end;
        $this->load->view('payroll/processing/preview_table', $data);
    }
    
    // Finalize and Save to DB
    public function finalize() {
        // DEBUG
        file_put_contents('application/logs/payroll_debug.txt', date('Y-m-d H:i:s') . " - Finalize Called\n", FILE_APPEND);
        file_put_contents('application/logs/payroll_debug.txt', "POST: " . print_r($_POST, true) . "\n", FILE_APPEND);

        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $employees = $this->input->post('employee_ids'); // Array/JSON
        
         // If employees is string (from hidden input in preview), decode it
         // Actually, better to re-calculate to be safe or pass signed data. 
         // For now, we will re-calculate based on the IDs provided from the form re-submission or cache.
         // Let's rely on the IDs passed.
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $employees = $this->input->post('employee_ids');

        // Debug logging
        log_message('debug', 'Finalize called - Start: ' . $start . ', End: ' . $end);
        log_message('debug', 'Employee IDs: ' . print_r($employees, true));
        
        if(!$employees || !$start || !$end) {
             log_message('error', 'Finalize validation failed - Missing data');
             echo json_encode(array('status' => 'Error', 'message' => 'Invalid Data: employees=' . count($employees ?: array()) . ', start=' . $start . ', end=' . $end));
             return;
        }
        
        if(!is_array($employees) || count($employees) == 0) {
            log_message('error', 'No employees in array');
            echo json_encode(array('status' => 'Error', 'message' => 'No employees selected'));
            return;
        }
        
        log_message('debug', 'Creating run for ' . count($employees) . ' employees');
        
        // 1. Create Run Record
        $run_id = $this->engine->create_run($start, $end);
        
        $total_amount = 0;
        $total_tax = 0;

        // Get Submitted Arrays
        $inp_hours = $this->input->post('hours');
        $inp_gross = $this->input->post('gross');
        $inp_tax = $this->input->post('tax');
        $inp_ded = $this->input->post('deductions');
        $inp_adv = $this->input->post('advance');
        $inp_net = $this->input->post('net_pay');
        
        // 2. Process Each Employee
        foreach($employees as $eid) {
            // Validate inputs for this employee exist
            if(!isset($inp_gross[$eid])) continue;

            $gross = (float)$inp_gross[$eid];
            $tax = (float)$inp_tax[$eid];
            $hours = (float)$inp_hours[$eid];
            $deduction_total = (float)$inp_ded[$eid];
            $advance = (float)$inp_adv[$eid];
            $net = (float)$inp_net[$eid];

            // Re-calculate to get original deduction breakdown (Tax, EPF, Loan IDs)
            $calc = $this->engine->calculate_payroll($eid, $start, $end);
            $deductions = $calc['deductions'];
            
            // Calculate sum of original deductions
            $original_deduction_total = 0;
            foreach($deductions as $d) {
                $original_deduction_total += $d['amount'];
            }
            
            // Compare with User Input ($deduction_total)
            // Note: User Input 'deductions' field in view might be Sum of Deductions (excluding Advance?). 
            // The view 'deductions' input value is seeded with 'total_deductions'.
            // If user edited it, we add an adjustment.
            
            $diff = $deduction_total - $original_deduction_total;
            
            if(abs($diff) > 0.01) {
                $deductions[] = array(
                    'id' => 'MANUAL_ADJ',
                    'name' => 'Manual Adjustment',
                    'amount' => $diff
                );
            }
            
            // Add Advance (New Item)
            if($advance > 0) {
                $deductions[] = array(
                    'id' => 'MANUAL_ADV',
                    'name' => 'Advance Payment',
                    'amount' => $advance
                );
            }

            $deductions_json = json_encode($deductions);

            $item_data = array(
                'employee_id' => $eid,
                'hours' => $hours, // Use saved hours
                'gross' => $gross,
                'tax' => $tax,
                'deductions' => $deductions, // Full deduction array including loans
                'total_deductions' => $deduction_total + $advance,
                'net_pay' => $net,
                // Pass calculation details for save method
                'basic_salary' => isset($calc['basic_salary']) ? $calc['basic_salary'] : 0,
                'cola' => isset($calc['cola']) ? $calc['cola'] : 0,
                'overtime_pay' => isset($calc['overtime_pay']) ? $calc['overtime_pay'] : 0,
                'bonuses' => isset($calc['bonuses']) ? $calc['bonuses'] : array()
            );
            
            // Allow engine to save, but we need to override the details
            $this->engine->save_payroll_item($run_id, $item_data);
            
            // No need to manually update deduction details - save method handles it now

            $total_amount += $net;
            $total_tax += $tax;
        }
        
        // 3. Update Run Totals and set Request Approval
        $this->engine->update_run_totals($run_id, $total_amount, $total_tax, 'Pending'); // Set to Pending for Approval
        
        echo json_encode(array('status' => 'Success', 'message' => 'Payroll Run Finalized with Submitted Values. Run ID: ' . $run_id));
    }
}
