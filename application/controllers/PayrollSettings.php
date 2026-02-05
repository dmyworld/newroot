<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PayrollSettings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('payroll_rules_model', 'rules');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    // --- DASHBOARD FOR SETTINGS ---
    public function index()
    {
        if ($this->aauth->get_user()->roleid < 5) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Payroll Configuration';
        
        // Load current settings
        $data['overtime_rules'] = $this->rules->get_overtime_rules();
        $data['deduction_types'] = $this->rules->get_deduction_types();
        $data['job_codes'] = $this->rules->get_job_codes();
        $data['pay_frequency'] = $this->rules->get_config('pay_frequency');

        // Load accounts for account mapping
        $this->load->model('accounts_model', 'accounts_model');
        $data['accounts'] = $this->accounts_model->accountslist();
        
        // Load account mapping config
        $data['payroll_salary_expense_account'] = $this->rules->get_config('payroll_salary_expense_account', 0);
        $data['payroll_epf_payable_account'] = $this->rules->get_config('payroll_epf_payable_account', 0);
        $data['payroll_etf_payable_account'] = $this->rules->get_config('payroll_etf_payable_account', 0);
        $data['payroll_salary_payable_account'] = $this->rules->get_config('payroll_salary_payable_account', 0);
        $data['payroll_payment_account'] = $this->rules->get_config('payroll_payment_account', 0);

        $this->load->view('fixed/header', $head);
        $this->load->view('payroll/settings/index', $data);
        $this->load->view('fixed/footer');
    }

    // --- OVERTIME CRUD ---
    public function add_overtime_rule()
    {
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'type' => $this->input->post('type'),
                'threshold_hours' => $this->input->post('threshold'),
                'rate_multiplier' => $this->input->post('multiplier')
            );
            if($this->rules->add_overtime_rule($data)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Overtime Rule Added Successfully'));
            } else {
                 echo json_encode(array('status' => 'Error', 'message' => 'Failed to add rule'));
            }
        }
    }

    public function delete_overtime_rule()
    {
        if ($this->input->post('deleteid')) {
            if($this->rules->delete_overtime_rule($this->input->post('deleteid'))){
                echo json_encode(array('status' => 'Success', 'message' => 'Rule Deleted'));
            } else {
                 echo json_encode(array('status' => 'Error', 'message' => 'Failed to delete'));
            }
        }
    }

    // --- DEDUCTION CRUD ---
    public function add_deduction_type()
    {
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'category' => $this->input->post('category'),
                'is_pre_tax' => $this->input->post('is_pre_tax') ? $this->input->post('is_pre_tax') : 0,
                'statutory_type' => $this->input->post('statutory_type') ? $this->input->post('statutory_type') : 'None',
                'calculation_type' => $this->input->post('calc_type'),
                'default_value' => $this->input->post('default_val'),
                'employer_match_percent' => $this->input->post('match_percent'),
                'salary_ceiling' => $this->input->post('salary_ceiling')
            );
            if($this->rules->add_deduction_type($data)){
                echo json_encode(array('status' => 'Success', 'message' => 'Deduction Type Added Successfully'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Failed to add deduction type'));
            }
        }
    }

    public function delete_deduction_type()
    {
        if ($this->input->post('deleteid')) {
            if($this->rules->delete_deduction_type($this->input->post('deleteid'))){
                echo json_encode(array('status' => 'Success', 'message' => 'Deduction Deleted'));
            } else {
                 echo json_encode(array('status' => 'Error', 'message' => 'Failed to delete'));
            }
        }
    }

    // --- JOB CODE CRUD ---
    public function add_job_code()
    {
        if ($this->input->post()) {
            $data = array(
                'code' => $this->input->post('code'),
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'hourly_rate' => $this->input->post('rate')
            );
            if($this->rules->add_job_code($data)){
                 echo json_encode(array('status' => 'Success', 'message' => 'Job Code Added Successfully'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Failed to add job code'));
            }
        }
    }
    
    public function delete_job_code()
    {
        if ($this->input->post('deleteid')) {
            if($this->rules->delete_job_code($this->input->post('deleteid'))){
                echo json_encode(array('status' => 'Success', 'message' => 'Job Code Deleted'));
            } else {
                 echo json_encode(array('status' => 'Error', 'message' => 'Failed to delete'));
            }
        }
    }
    
    public function save_accounts_config() {
        if ($this->input->post()) {
            $configs = array(
                'payroll_salary_expense_account',
                'payroll_epf_payable_account',
                'payroll_etf_payable_account',
                'payroll_salary_payable_account',
                'payroll_payment_account'
            );
            
            foreach ($configs as $key) {
                $value = $this->input->post($key);
                $this->rules->set_config($key, $value);
            }
            
            echo json_encode(array('status' => 'Success', 'message' => 'Account mappings saved successfully'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Invalid request'));
        }
    }
    
    // --- GLOBAL CONFIG ---
    public function update_config() {
        if($this->input->post('pay_frequency')) {
             $this->rules->set_config('pay_frequency', $this->input->post('pay_frequency'));
             echo json_encode(array('status' => 'Success', 'message' => 'Configuration Saved'));
        }
    }

}
