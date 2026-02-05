<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_workflow_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_runs_by_status($status) {
        $this->db->where('status', $status);
        $this->db->order_by('id', 'DESC');
        return $this->db->get('geopos_payroll_runs')->result_array();
    }
    
    public function update_status($run_id, $status) {
        $this->db->where('id', $run_id);
        return $this->db->update('geopos_payroll_runs', array('status' => $status));
    }
    
    public function log_approval($run_id, $approver_id, $status, $comments) {
        $data = array(
            'run_id' => $run_id,
            'approver_id' => $approver_id,
            'status' => $status,
            'comments' => $comments,
            'approved_at' => date('Y-m-d H:i:s')
        );
        $this->db->insert('geopos_payroll_approvals', $data);
    }
    
    public function approve_run($run_id) {
        $user_id = $this->aauth->get_user()->id;
        
        // Update run status
        $this->db->where('id', $run_id);
        $this->db->update('geopos_payroll_runs', array(
            'status' => 'Approved',
            'approval_status' => 'Approved',
            'approved_by' => $user_id,
            'approved_date' => date('Y-m-d H:i:s')
        ));
        
        // OLD: Process Bonuses
        $this->db->select('deduction_details');
        $this->db->where('run_id', $run_id);
        $items = $this->db->get('geopos_payroll_items')->result_array();
        
        $bonus_ids = array();
        foreach($items as $item) {
            $details = json_decode($item['deduction_details'], true);
            if($details && is_array($details)) {
                foreach($details as $d) {
                    if(isset($d['type']) && $d['type'] == 'Bonus' && isset($d['bonus_id'])) {
                        $bonus_ids[] = $d['bonus_id'];
                    }
                }
            }
        }
        
        if(!empty($bonus_ids)) {
            $this->load->model('payroll_bonus_model', 'bonus');
            $this->bonus->mark_bonuses_paid($bonus_ids);
        }
        
        // Process Loan Deductions
        $this->db->select('employee_id, loan_deduction, deduction_details');
        $this->db->where('run_id', $run_id);
        $payroll_items = $this->db->get('geopos_payroll_items')->result_array();
        
        foreach($payroll_items as $item) {
            if($item['loan_deduction'] > 0) {
                $details = json_decode($item['deduction_details'], true);
                if($details && is_array($details)) {
                    foreach($details as $d) {
                        if(isset($d['id']) && strpos($d['id'], 'LOAN_') === 0) {
                            $loan_id = str_replace('LOAN_', '', $d['id']);
                            $amount = $d['amount'];
                            
                            // Reduce loan balance
                            $this->db->set('balance', 'balance - ' . $amount, FALSE);
                            $this->db->where('id', $loan_id);
                            $this->db->update('geopos_employee_loans');
                            
                            // Check if loan is fully paid
                            $loan = $this->db->get_where('geopos_employee_loans', array('id' => $loan_id))->row_array();
                            if($loan && $loan['balance'] <= 0.01) {
                                $this->db->where('id', $loan_id);
                                $this->db->update('geopos_employee_loans', array('status' => 'Paid'));
                            }
                        }
                    }
                }
            }
        }
        
        // NEW: Create Accounting Journal Entries
        try {
            $this->load->model('payroll_accounting_model', 'payroll_accounting');
            $accounting_result = $this->payroll_accounting->create_journal_entries($run_id);
            
            if($accounting_result) {
                log_message('info', 'Accounting entries created for payroll run #' . $run_id);
            } else {
                log_message('error', 'Failed to create accounting entries for payroll run #' . $run_id);
            }
        } catch (Exception $e) {
            log_message('error', 'Exception creating accounting entries for run #' . $run_id . ': ' . $e->getMessage());
            // Don't fail the approval if accounting fails
        }
        
        return true;
    }
}
