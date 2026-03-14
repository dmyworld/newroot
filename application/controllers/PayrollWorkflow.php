<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PayrollWorkflow extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('payroll_workflow_model', 'workflow');
        $this->load->model('payroll_report_model', 'reports');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
    }

    public function index() {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Payroll Approvals';
        
        if (!$this->db->table_exists('geopos_payroll_approvals')) {
             echo '<div class="alert alert-danger"><strong>Database Error!</strong> Payroll tables are missing. Please run the <a href="' . base_url('install_payroll.php') . '">Installation Script</a>.</div>';
             return;
        }

        $data['pending_runs'] = $this->workflow->get_runs_by_status('Pending');
        // Handle case where query failed (returned false)
        if ($data['pending_runs'] === FALSE) {
            $data['pending_runs'] = array(); 
        }
        
        $this->load->view('fixed/header', $head);
        $this->load->view('payroll/workflow/approval_list', $data);
        $this->load->view('fixed/footer');
    }

    public function request_approval() {
        $run_id = $this->input->post('run_id');
        $result = $this->workflow->update_status($run_id, 'Pending');
        echo json_encode(array('status' => 'Success', 'message' => 'Approval Requested'));
    }

    public function approve() {
         $run_id = $this->input->post('run_id');
         $comments = $this->input->post('comments');
         $approver_id = $this->aauth->get_user()->id;
         
         try {
             // Log the approval
             $this->workflow->log_approval($run_id, $approver_id, 'Approved', $comments);
             
             // Call the comprehensive approve_run method which handles:
             // 1. Status update
             // 2. Bonus processing
             // 3. Loan deductions
             // 4. Journal entry creation
             $this->workflow->approve_run($run_id);
             
             echo json_encode(array('status' => 'Success', 'message' => 'Payroll Run Approved - Journal Entries Created'));
         } catch (Exception $e) {
             log_message('error', 'Approval failed for run #' . $run_id . ': ' . $e->getMessage());
             echo json_encode(array('status' => 'Error', 'message' => 'Approval failed: ' . $e->getMessage()));
         }
     }

    public function reject() {
         $run_id = $this->input->post('run_id');
         $comments = $this->input->post('comments');
         $approver_id = $this->aauth->get_user()->id;
         
         $this->workflow->log_approval($run_id, $approver_id, 'Rejected', $comments);
         $this->workflow->update_status($run_id, 'Rejected');
         
         echo json_encode(array('status' => 'Success', 'message' => 'Payroll Run Rejected'));
    }
}
