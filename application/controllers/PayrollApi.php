<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class PayrollApi extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('payroll_report_model', 'reports');
        // Aauth check or key check is handled by REST_Controller or we add here
    }

    // GET /payrollapi/runs?start=Y-m-d&end=Y-m-d
    public function runs_get() {
        $start = $this->get('start');
        $end = $this->get('end');
        
        $runs = $this->reports->get_payroll_runs($start, $end);
        
        if($runs) {
            $this->response($runs, REST_Controller::HTTP_OK);
        } else {
            $this->response(['message' => 'No runs found'], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    
    // GET /payrollapi/run_details?id=123
    public function run_details_get() {
        $id = $this->get('id');
        
        if(!$id) {
             $this->response(['message' => 'ID required'], REST_Controller::HTTP_BAD_REQUEST);
             return;
        }
        
        $run = $this->reports->get_run_details($id);
        $items = $this->reports->get_payroll_items($id);
        
        if($run) {
             $this->response(['run' => $run, 'items' => $items], REST_Controller::HTTP_OK);
        } else {
             $this->response(['message' => 'Run not found'], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    
    // GET /payrollapi/employee_payslip?id=456
    public function employee_payslip_get() {
        $id = $this->get('id'); // This is item ID
        
         if(!$id) {
             $this->response(['message' => 'ID required'], REST_Controller::HTTP_BAD_REQUEST);
             return;
        }
        
        $payslip = $this->reports->get_employee_payslip($id);
        
        if($payslip) {
             $this->response($payslip, REST_Controller::HTTP_OK);
        } else {
             $this->response(['message' => 'Payslip not found'], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
