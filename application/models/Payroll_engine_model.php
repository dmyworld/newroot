<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_engine_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('payroll_rules_model', 'rules');
        $this->load->model('employee_model', 'employee');
    }

    public function create_run($start, $end) {
        $data = array(
            'date_created' => date('Y-m-d'),
            'start_date' => $start,
            'end_date' => $end,
            'status' => 'Draft'
        );
        $this->db->insert('geopos_payroll_runs', $data);
        return $this->db->insert_id();
    }
    
    public function save_payroll_item($run_id, $calc) {
        // Extract deduction breakdown for individual fields
        $epf_employee = 0;
        $epf_employer = 0;
        $etf_employer = 0;
        $loan_deduction = 0;
        $bonus_amount = 0;
        $basic_salary = 0;
        $cola_amount = 0;
        $overtime_pay = 0;
        
        if (isset($calc['deductions']) && is_array($calc['deductions'])) {
            foreach ($calc['deductions'] as $ded) {
                if (isset($ded['name'])) {
                    // EPF Employee
                    if (strpos($ded['name'], 'EPF') !== false && strpos($ded['name'], 'Employee') !== false) {
                        $epf_employee = $ded['amount'];
                    } 
                    // EPF Employer
                    elseif (strpos($ded['name'], 'EPF') !== false && strpos($ded['name'], 'Employer') !== false) {
                        $epf_employer = $ded['amount'];
                    } 
                    // ETF
                    elseif (strpos($ded['name'], 'ETF') !== false) {
                        $etf_employer = $ded['amount'];
                    } 
                    // Loan deduction
                    elseif (isset($ded['id']) && strpos($ded['id'], 'LOAN_') === 0) {
                        $loan_deduction += $ded['amount'];
                    }
                }
            }
        }
        
        // Extract bonuses if present
        if (isset($calc['bonuses']) && is_array($calc['bonuses'])) {
            foreach($calc['bonuses'] as $b) {
                $bonus_amount += isset($b['amount']) ? $b['amount'] : 0;
            }
        }
        
        // COLA from passed data or from gross calculation
        $cola_amount = isset($calc['cola']) ? $calc['cola'] : 0;
        
        // Calculate basic salary - gross minus cola and bonuses
        $basic_salary = $calc['gross'] - $cola_amount - $bonus_amount - $overtime_pay;
        if($basic_salary < 0) $basic_salary = 0;
        
        // Calculate other deductions (total minus known categories)
        $known_deductions = $epf_employee + $loan_deduction;
        $other_deductions = $calc['total_deductions'] - $known_deductions;
        if ($other_deductions < 0) $other_deductions = 0;
        
        $data = array(
            'run_id' => $run_id,
            'employee_id' => $calc['employee_id'],
            'total_hours' => isset($calc['hours']) ? $calc['hours'] : 0,
            'basic_salary' => $basic_salary,
            'cola_amount' => $cola_amount,
            'overtime_pay' => $overtime_pay,
            'bonus_amount' => $bonus_amount,
            'gross_pay' => $calc['gross'],
            'epf_employee' => $epf_employee,
            'epf_employer' => $epf_employer,
            'etf_employer' => $etf_employer,
            'loan_deduction' => $loan_deduction,
            'other_deductions' => $other_deductions,
            'tax' => isset($calc['tax']) ? $calc['tax'] : 0,
            'total_deductions' => $calc['total_deductions'],
            'net_pay' => $calc['net_pay'],
            'deduction_details' => json_encode($calc['deductions'])
        );
        
        $this->db->insert('geopos_payroll_items', $data);
    }
    
    public function update_run_totals($run_id, $amount, $tax, $status = 'Finalized') {
        // If 'approval_status' column exists, we update that too, mapping 'Pending' to 'Pending'. 
        // For backward compatibility if migration failed, we just update 'status' column if it's the only one.
        // Assuming we rely on 'status' column being used for logic or 'approval_status'.
        // Let's assume 'status' column in table is used for 'approval_status' logic or we update both?
        // Let's adhere to the new 'approval_status' column if possible.
        // For safety, let's update 'status' column with the value passed.
        $data = array('total_amount' => $amount, 'total_tax' => $tax, 'status' => $status);
        
        // If using approval_status column from migration
        if ($this->db->field_exists('approval_status', 'geopos_payroll_runs')) {
            $data['approval_status'] = $status;
        }

        $this->db->where('id', $run_id);
        $this->db->update('geopos_payroll_runs', $data);
    }

    // --- MAIN CALCULATOR ---
    public function calculate_payroll($employee_id, $start_date, $end_date)
    {
        // 1. Fetch Employee Details including COLA
        $employee = $this->db->select('*')->from('geopos_employees')->where('id', $employee_id)->get()->row_array();
        if (!$employee) return false;

        $timesheets = $this->get_timesheets($employee_id, $start_date, $end_date);
        
        $gross_pay = 0;
        $total_hours = 0;
        
        // 2. Base Salary (if Monthly) or Hourly
        // For this engine, we assume Timesheet Driven OR Monthly.
        // If Monthly, and no timesheets, we might add base salary.
        // Current logic relies on Timesheets for Gross.
        // Let's add COLA here as fixed additions.
        
        $cola = isset($employee['cola_amount']) ? $employee['cola_amount'] : 0;
        
        // 3. Process Timesheets (Basic + Overtime)
        foreach ($timesheets as $ts) {
            $hours = $ts['total_hours'];
            $rate = isset($employee['salary']) ? $employee['salary'] : 0; 
            
            // Check Overtime Rules
            $multiplier = 1.0;
            if (isset($ts['is_overtime']) && $ts['is_overtime']) {
                 // Future: Load from Config
                 $multiplier = 1.5; 
            }
            
            $pay = $hours * $rate * $multiplier;
            $gross_pay += $pay;
            $total_hours += $hours;
        }
        
        // Add COLA
        $cola = isset($employee['cola_amount']) ? $employee['cola_amount'] : 0;
        $gross_pay += $cola;
        
        // 4. Calculate Deductions (Rules + Loans)
        $deductions = $this->calculate_deductions($employee_id, $gross_pay);
        $loan_deductions = $this->calculate_loan_deductions($employee_id);
        
        // 5. Calculate Bonuses
        $this->load->model('payroll_bonus_model', 'bonus');
        $bonuses = $this->bonus->get_pending_bonuses($employee_id, $start_date, $end_date);
        
        $bonus_items = array();
        foreach($bonuses as $b) {
            $gross_pay += $b['amount'];
            $bonus_items[] = array(
                'id' => 'BONUS-' . $b['id'],
                'name' => 'Bonus: ' . $b['type'], // or Note
                'amount' => $b['amount'],
                'type' => 'Bonus',
                'bonus_id' => $b['id']
            );
        }

        // 6. Calculate Statutory (EPF/ETF)
        // EPF/ETF usually on Earnings (Basic + COLA + Budgetary Relief).
        // Bonuses are usually liable for EPF/ETF in Sri Lanka? 
        // "Performance-linked bonuses" - YES.
        // "Reimbursements" - NO.
        // For Phase 2, let's assume ALL Bonuses are part of Gross and thus Statutory.
        $gross_for_statutory = $gross_pay; 
        
        $statutory = $this->calculate_statutory($gross_for_statutory);
        
        // Merge Details
        $employee_statutory = array();
        $employer_statutory = array();
        
        foreach($statutory as $s) {
            if($s['type'] == 'Employee_Deduction') {
                $employee_statutory[] = $s;
            } else {
                $employer_statutory[] = $s;
            }
        }
        
        $all_deductions = array_merge($deductions, $loan_deductions, $employee_statutory);
        // Include Bonuses in the Details list for storage
        $final_details = array_merge($bonus_items, $all_deductions, $employer_statutory);
        
        $total_deductions = 0;
        foreach($all_deductions as $d) {
            $total_deductions += $d['amount'];
        }

        // 7. Calculate Taxes
        $taxable_income = $gross_pay - $total_deductions;
        if($taxable_income < 0) $taxable_income = 0;
        $tax = 0; 

        // 8. Net Pay
        $net_pay = $gross_pay - $total_deductions - $tax;

        return array(
            'employee_id' => $employee_id,
            'employee_name' => $employee['name'], 
            'start_date' => $start_date,
            'end_date' => $end_date,
            'hours' => $total_hours,
            'gross' => $gross_pay,
            'tax' => $tax,
            'deductions' => $final_details, // Contains Bonuses, Deductions, Emp Contribs
            'total_deductions' => $total_deductions, 
            'net_pay' => $net_pay,
            'hourly_rate' => isset($employee['salary']) ? $employee['salary'] : 0
        );
    }
    
    // Process Bonuses after Finalization
    public function process_bonuses($run_id) {
        $this->load->model('payroll_bonus_model', 'bonus');
        $items = $this->db->get_where('geopos_payroll_items', array('run_id' => $run_id))->result_array();
        
        $bonus_ids = array();
        foreach($items as $item) {
            $details = json_decode($item['deduction_details'], true);
            if($details) {
                foreach($details as $d) {
                    if(isset($d['bonus_id'])) {
                        $bonus_ids[] = $d['bonus_id'];
                    }
                }
            }
        }
        
        if(!empty($bonus_ids)) {
            $this->bonus->mark_bonuses_paid($bonus_ids);
        }
    }
    
    private function calculate_statutory($gross) {
        // Fetch Rules
        if ($this->db->table_exists('geopos_payroll_statutory')) {
            $rules = $this->db->get_where('geopos_payroll_statutory', array('enabled'=>1))->result_array();
        } else {
            return array();
        }
        
        $results = array();
        foreach($rules as $rule) {
            $amount = $gross * ($rule['rate'] / 100);
            $results[] = array(
                'id' => 'STAT-' . $rule['id'],
                'name' => $rule['name'],
                'amount' => $amount,
                'is_pre_tax' => 0,
                'type' => $rule['type'] // Employee_Deduction or Employer_Contribution
            );
        }
        return $results;
    }

    private function get_timesheets($eid, $start, $end)
    {
        $this->db->where('employee_id', $eid);
        $this->db->where('clock_in >=', $start . ' 00:00:00');
        $this->db->where('clock_in <=', $end . ' 23:59:59');
        $this->db->group_start();
        $this->db->where('status', 'Approved');
        $this->db->or_where('status', 'Pending');
        $this->db->or_where('status IS NULL');
        $this->db->group_end();
        return $this->db->get('geopos_timesheets')->result_array();
    }

    private function calculate_deductions($eid, $gross_pay)
    {
        // Get emp specific deductions
        $this->db->select('d.*, ed.amount_override, ed.percentage_override');
        $this->db->from('geopos_emp_deductions ed');
        $this->db->join('geopos_deduction_types d', 'd.id = ed.deduction_type_id');
        $this->db->where('ed.employee_id', $eid);
        $query = $this->db->get();
        $rules = $query->result_array();

        $calculated = array();

        foreach($rules as $rule) {
            $amount = 0;
            if ($rule['calculation_type'] == 'Fixed Amount') {
                $amount = $rule['amount_override'] > 0 ? $rule['amount_override'] : $rule['default_value'];
            } else { // Percentage
                 $pct = $rule['percentage_override'] > 0 ? $rule['percentage_override'] : $rule['default_value']; // This usually stored as 5.0 for 5%
                 $amount = $gross_pay * ($pct / 100);
            }
            
            $calculated[] = array(
                'id' => $rule['id'],
                'name' => $rule['name'],
                'amount' => $amount,
                'is_pre_tax' => $rule['is_pre_tax']
            );
        }
        return $calculated;
    }

    private function calculate_loan_deductions($eid) {
        // Fetch active loans
        $this->db->where('employee_id', $eid);
        $this->db->where('status', 'Due');
        $this->db->where('balance >', 0);
        $loans = $this->db->get('geopos_employee_loans')->result_array();
        
        $deductions = array();
        
        foreach($loans as $loan) {
            $amount = $loan['installment'];
            // Cap at remaining balance
            if($amount > $loan['balance']) {
                $amount = $loan['balance'];
            }
            
            if($amount > 0) {
                $deductions[] = array(
                    'id' => 'LOAN-' . $loan['id'], // Special Marker
                    'name' => 'Loan Repayment', // Generic name, or can add Ref #
                    'amount' => $amount,
                    'is_pre_tax' => 0, // Post-tax
                    'loan_id' => $loan['id'] // Meta data
                );
            }
        }
        return $deductions;
    }
    
    // Process Loan Payments after Finalization
    public function process_loan_payments($run_id) {
        $items = $this->db->get_where('geopos_payroll_items', array('run_id' => $run_id))->result_array();
        
        foreach($items as $item) {
            $deductions = json_decode($item['deduction_details'], true);
            if($deductions) {
                foreach($deductions as $d) {
                    // Check if it is a loan deduction
                    if(isset($d['loan_id']) || (strpos($d['id'], 'LOAN-') === 0) ) {
                        $loan_id = isset($d['loan_id']) ? $d['loan_id'] : str_replace('LOAN-', '', $d['id']);
                        $amount = $d['amount'];
                        
                        // 1. Record Payment
                        $pay_data = array(
                            'loan_id' => $loan_id,
                            'amount' => $amount,
                            'date' => date('Y-m-d'),
                            'method' => 'Payroll Deduction',
                            'note' => 'Payroll Run ID #' . $run_id
                        );
                        $this->db->insert('geopos_employee_loan_payments', $pay_data);
                        
                        // 2. Update Loan Balance
                        $this->db->set('balance', "balance-$amount", FALSE);
                        $this->db->where('id', $loan_id);
                        $this->db->update('geopos_employee_loans');
                        
                        // 3. Mark as Paid if 0
                        // (Check fresh balance)
                        $loan = $this->db->get_where('geopos_employee_loans', array('id' => $loan_id))->row_array();
                        if($loan['balance'] <= 0) {
                            $this->db->set('status', 'Paid');
                            $this->db->where('id', $loan_id);
                            $this->db->update('geopos_employee_loans');
                        }
                    }
                }
            }
        }
    }

}
