<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Payroll Accounting Integration Model
 * Handles journal entry creation when payroll runs are approved
 */
class Payroll_accounting_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('transactions_model', 'transactions');
    }

    /**
     * Create all journal entries for an approved payroll run
     * @param int $run_id Payroll run ID
     * @return bool Success status
     */
    public function create_journal_entries($run_id)
    {
        // Get run details
        $run = $this->db->get_where('geopos_payroll_runs', array('id' => $run_id))->row_array();
        if (!$run) return false;

        // Get payroll items for this run
        $this->db->select('p.*, e.name as employee_name');
        $this->db->from('geopos_payroll_items p');
        $this->db->join('geopos_employees e', 'e.id = p.employee_id', 'left');
        $this->db->where('p.run_id', $run_id);
        $items = $this->db->get()->result_array();

        if (empty($items)) return false;

        // Calculate totals
        $total_gross = 0;
        $total_epf_employee = 0;
        $total_epf_employer = 0;
        $total_etf = 0;
        $total_loan_deduction = 0;
        $total_net = 0;

        foreach ($items as $item) {
            $total_gross += $item['gross_pay'];
            $total_epf_employee += $item['epf_employee'];
            $total_epf_employer += $item['epf_employer'];
            $total_etf += $item['etf_employer'];
            $total_loan_deduction += $item['loan_deduction'];
            $total_net += $item['net_pay'];
        }

        // Get account settings
        $salary_expense_account = $this->get_config('payroll_salary_expense_account', 0);
        $epf_payable_account = $this->get_config('payroll_epf_payable_account', 0);
        $etf_payable_account = $this->get_config('payroll_etf_payable_account', 0);
        $salary_payable_account = $this->get_config('payroll_salary_payable_account', 0);
        $payment_account = $this->get_config('payroll_payment_account', 0);

        $date = date('Y-m-d');
        $loc = $this->aauth->get_user()->loc ?: 0;
        $eid = $this->aauth->get_user()->id;

        // Entry 1: Salary Expense
        if ($salary_expense_account && $salary_payable_account) {
            // Debit: Salary Expense
            $this->transactions->addtrans(
                0,                              // Payer ID
                'Payroll Run #' . $run_id,     // Payer name
                $salary_expense_account,        // Account
                $date,                          // Date
                $total_gross,                   // Debit (Expense)
                0,                              // Credit
                'Expense',                      // Type
                'Salary',                       // Category
                'Journal',                      // Method
                'Salary expense for period ' . $run['start_date'] . ' to ' . $run['end_date'],  // Note
                $eid,                           // Employee ID
                $loc,                           // Location
                0,                              // ty
                0                               // wallet_balance
            );

            // Credit: Salary Payable
            $this->transactions->addtrans(
                0,
                'Payroll Run #' . $run_id,
                $salary_payable_account,
                $date,
                0,                              // Debit
                $total_gross,                   // Credit (Liability)
                'Income',                       // Type (to balance)
                'Salary Payable',
                'Journal',
                'Salary payable for period ' . $run['start_date'] . ' to ' . $run['end_date'],
                $eid,
                $loc,
                0,
                0
            );
        }

        // Entry 2: EPF Contributions
        if ($epf_payable_account && ($total_epf_employee + $total_epf_employer) > 0) {
            // EPF Employer Expense
            $this->transactions->addtrans(
                0,
                'Payroll Run #' . $run_id . ' - EPF',
                $salary_expense_account,
                $date,
                $total_epf_employer,           // Deb it (Expense)
                0,
                'Expense',
                'EPF Employer',
                'Journal',
                'EPF employer contribution 12%',
                $eid,
                $loc,
                0,
                0
            );

            // Total EPF Payable (Employee + Employer)
            $this->transactions->addtrans(
                0,
                'Payroll Run #' . $run_id . ' - EPF',
                $epf_payable_account,
                $date,
                0,
                ($total_epf_employee + $total_epf_employer),  // Credit (Liability)
                'Income',
                'EPF Payable',
                'Journal',
                'Total EPF payable (8% + 12%)',
                $eid,
                $loc,
                0,
                0
            );
        }

        // Entry 3: ETF Contribution
        if ($etf_payable_account && $total_etf > 0) {
            // ETF Employer Expense
            $this->transactions->addtrans(
                0,
                'Payroll Run #' . $run_id . ' - ETF',
                $salary_expense_account,
                $date,
                $total_etf,                    // Debit (Expense)
                0,
                'Expense',
                'ETF Employer',
                'Journal',
                'ETF employer contribution 3%',
                $eid,
                $loc,
                0,
                0
            );

            // ETF Payable
            $this->transactions->addtrans(
                0,
                'Payroll Run #' . $run_id . ' - ETF',
                $etf_payable_account,
                $date,
                0,
                $total_etf,                    // Credit (Liability)
                'Income',
                'ETF Payable',
                'Journal',
                'Total ETF payable (3%)',
                $eid,
                $loc,
                 0,
                0
            );
        }

        // Entry 4: Loan Deductions (reduce salary payable, reduce loan receivable)
        if ($total_loan_deduction > 0) {
            $this->transactions->addtrans(
                0,
                'Payroll Run #' . $run_id . ' - Loans',
                $salary_payable_account,
                $date,
                $total_loan_deduction,         // Debit (reduce liability)
                0,
                'Expense',
                'Loan Recovery',
                'Journal',
                'Loan deductions from salaries',
                $eid,
                $loc,
                0,
                0
            );

            // Note: Loan receivable reduction should be handled per employee in loan processing
            // For now, we'll create a generic entry
            // In production, this should link to specific loan accounts
        }

        // Entry 5: Net Payment (when actually paid)
        // This can be created separately when payment is made
        // For now, we'll create the accrual entries only

        // Update run to mark accounting posted
        $this->db->where('id', $run_id);
        $this->db->update('geopos_payroll_runs', array(
            'accounting_posted' => 1,
            'accounting_posted_date' => date('Y-m-d H:i:s')
        ));

        return true;
    }

    /**
     * Create payment entry when salaries are paid
     * @param int $run_id Payroll run ID
     * @param int $payment_account_id Bank/Cash account ID
     * @return bool
     */
    public function create_payment_entry($run_id, $payment_account_id)
    {
        $run = $this->db->get_where('geopos_payroll_runs', array('id' => $run_id))->row_array();
        if (!$run) return false;

        // Get total net pay
        $this->db->select_sum('net_pay');
        $this->db->where('run_id', $run_id);
        $result = $this->db->get('geopos_payroll_items')->row_array();
        $total_net = $result['net_pay'];

        $salary_payable_account = $this->get_config('payroll_salary_payable_account', 0);

        if (!$salary_payable_account || !$payment_account_id) return false;

        $date = date('Y-m-d');
        $loc = $this->aauth->get_user()->loc ?: 0;
        $eid = $this->aauth->get_user()->id;

        // Debit Salary Payable (reduce liability)
        $this->transactions->addtrans(
            0,
            'Payroll Run #' . $run_id . ' - Payment',
            $salary_payable_account,
            $date,
            $total_net,
            0,
            'Expense',
            'Salary Payment',
            'Bank',
            'Salary payment for period ' . $run['start_date'] . ' to ' . $run['end_date'],
            $eid,
            $loc,
            0,
            0
        );

        // Credit Bank/Cash (reduce asset)
        $this->transactions->addtrans(
            0,
            'Payroll Run #' . $run_id . ' - Payment',
            $payment_account_id,
            $date,
            0,
            $total_net,
            'Income',
            'Salary Payment',
            'Bank',
            'Salary payment for period ' . $run['start_date'] . ' to ' . $run['end_date'],
            $eid,
            $loc,
            0,
            0
        );

        return true;
    }

    /**
     * Get configuration value
     */
    private function get_config($key, $default = null)
    {
        $this->db->where('name', $key);
        $result = $this->db->get('geopos_payroll_config')->row_array();
        return $result ? $result['value'] : $default;
    }
}
