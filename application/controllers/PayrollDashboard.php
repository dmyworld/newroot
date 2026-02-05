<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Quick Payroll Reports Widget
 * Displays payroll summary cards for dashboard
 */

class PayrollDashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('payroll_report_model', 'reports');
        
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        
        $this->li_a = 'payroll';
    }

    public function quick_stats()
    {
        // Current month payroll summary
        $this->db->select('COUNT(DISTINCT employee_id) as total_employees, 
                          SUM(gross_pay) as total_gross,
                          SUM(net_pay) as total_net,
                          SUM(epf_employee + epf_employer + etf_employer) as total_statutory');
        $this->db->from('geopos_payroll_items');
        $this->db->join('geopos_payroll_runs', 'geopos_payroll_runs.id = geopos_payroll_items.run_id');
        $this->db->where('MONTH(geopos_payroll_runs.start_date)', date('m'));
        $this->db->where('YEAR(geopos_payroll_runs.start_date)', date('Y'));
        $query = $this->db->get();
        $current_month = $query->row_array();
        
        // Pending approvals
        $this->db->where('status', 'Pending');
        $pending_runs = $this->db->count_all_results('geopos_payroll_runs');
        
        // Pending timesheets
        $this->db->where('status', 'Pending');
        $pending_timesheets = $this->db->count_all_results('geopos_timesheets');
        
        echo json_encode(array(
            'employees' => $current_month['total_employees'] ?: 0,
            'gross' => amountFormat($current_month['total_gross'] ?: 0),
            'net' => amountFormat($current_month['total_net'] ?: 0),
            'statutory' => amountFormat($current_month['total_statutory'] ?: 0),
            'pending_runs' => $pending_runs,
            'pending_timesheets' => $pending_timesheets
        ));
    }
}
