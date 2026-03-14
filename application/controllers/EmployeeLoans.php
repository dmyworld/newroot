<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmployeeLoans extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('employee_model', 'employee'); // Retrieve employee
        $this->load->model('transactions_model', 'transactions'); 
        $this->load->model('accounts_model', 'accounts');
        
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Loans';
        
        // Fetch all loans (Basic query for now, move to model if complex)
        $this->db->select('l.*, e.name as emp_name, a.holder as account_name');
        $this->db->from('geopos_employee_loans l');
        $this->db->join('geopos_employees e', 'l.employee_id = e.id');
        $this->db->join('geopos_accounts a', 'l.account_id = a.id');
        $data['loans'] = $this->db->get()->result_array();

        $this->load->view('fixed/header', $head);
        $this->load->view('employee/loans/index', $data);
        $this->load->view('fixed/footer');
    }

    public function create()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Issue New Loan';
        
        $data['employees'] = $this->employee->list_employee();
        $data['accounts'] = $this->accounts->accountslist();

        $this->load->view('fixed/header', $head);
        $this->load->view('employee/loans/create', $data);
        $this->load->view('fixed/footer');
    }

    public function save()
    {
        $employee_id = $this->input->post('employee_id');
        $account_id = $this->input->post('account_id');
        $amount = $this->input->post('amount');
        $installment = $this->input->post('installment');
        $note = $this->input->post('note');
        
        if(!$employee_id || !$account_id || !$amount) {
            echo json_encode(array('status' => 'Error', 'message' => 'Missing Required Fields'));
            return;
        }

        // 1. Transactions Model - Add Transaction (Expense/Money Out)
        // addtrans($payer_id, $payer_name, $pay_acc, $date, $debit, $credit, $pay_type, $pay_cat, $paymethod, $note, $eid, $loc = 0, $ty = 0,$wallet_balance)
        
        $emp_details = $this->db->get_where('geopos_employees', array('id'=>$employee_id))->row_array();
        $emp_name = $emp_details ? $emp_details['name'] : 'Unknown';
        
        // We use 'Expense' to reduce company balance.
        // Payer = Employee (Receiver of funds in this context log context, but implies who the transaction relates to)
        // Actually for Expense, Payer is usually the Vendor. Here it's the Employee.
        
        $trans_id = $this->transactions->addtrans(
            $employee_id, // Payer ID (Employee)
            $emp_name,    // Payer Name
            $account_id,  // Account
            date('Y-m-d'), // Date
            $amount,      // Debit (Money Out)
            0,            // Credit
            'Expense',    // Type
            'Employee Loan', // Category - Should ensure this exists or use 'Advance'
            'Cash',       // Method - Defaulting to Cash/Bank transfer
            'Loan Issued: ' . $note, // Note

            $this->aauth->get_user()->id, // Employee ID (Admin)
            0, // loc
            0, // ty
            0 // wallet_balance
        );

        if($trans_id) {
            // 2. Create Loan Record
            $data = array(
                'employee_id' => $employee_id,
                'amount' => $amount,
                'balance' => $amount,
                'installment' => $installment, // Monthly deduction
                'account_id' => $account_id, // Where money came from
                'status' => 'Due',
                'note' => $note,
                'type' => $this->input->post('type'),
                'interest_rate' => $this->input->post('interest_rate'),
                'guarantor' => $this->input->post('guarantor')
            );
            
            if($this->db->insert('geopos_employee_loans', $data)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Loan Issued Successfully! Check Accounting for Transaction.'));
            } else {
                 echo json_encode(array('status' => 'Error', 'message' => 'Transaction created but Loan Record Failed. Contact Support.'));
            }
        } else {
             echo json_encode(array('status' => 'Error', 'message' => 'Failed to create accounting transaction.'));
        }
    }
    
    public function delete() {
        $id = $this->input->post('deleteid');
        // Logic to delete loan? Be careful about transactions.
        // For now, simple delete. Ideally should reverse transaction.
        $this->db->delete('geopos_employee_loans', array('id' => $id));
        echo json_encode(array('status' => 'Success', 'message' => 'Loan Record Deleted (Transaction remains)'));
    }
}
