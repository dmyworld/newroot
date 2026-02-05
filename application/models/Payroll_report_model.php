<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_report_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_payroll_runs($start = null, $end = null) {
        if($start && $end) {
            $this->db->where('start_date >=', $start);
            $this->db->where('end_date <=', $end);
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get('geopos_payroll_runs')->result_array();
    }
    
    public function get_run_details($run_id) {
        $this->db->where('id', $run_id);
        return $this->db->get('geopos_payroll_runs')->row_array();
    }

    public function get_payroll_items($run_id) {
        $this->db->select('p.id, p.employee_id, p.gross_pay, p.net_pay, p.epf_employee, p.epf_employer, p.etf_employer, p.loan_deduction, p.other_deductions, p.deduction_details, e.name, (p.epf_employee + p.loan_deduction + p.other_deductions) as total_deductions, 0 as tax');
        $this->db->from('geopos_payroll_items p');
        $this->db->join('geopos_employees e', 'e.id = p.employee_id', 'left');
        $this->db->where('p.run_id', $run_id);
        return $this->db->get()->result_array();
    }

    
    public function get_employee_payslip($item_id) {
        $this->db->select('geopos_payroll_items.*, geopos_employees.name, geopos_employees.address, geopos_employees.city, geopos_employees.phone, geopos_payroll_runs.start_date, geopos_payroll_runs.end_date');
        $this->db->from('geopos_payroll_items');
        $this->db->join('geopos_employees', 'geopos_employees.id = geopos_payroll_items.employee_id', 'left');
        $this->db->join('geopos_payroll_runs', 'geopos_payroll_runs.id = geopos_payroll_items.run_id', 'left');
        $this->db->where('geopos_payroll_items.id', $item_id);
        return $this->db->get()->row_array();
    }

    public function get_job_costing_summary($start, $end) {
        // Aggregate hours by job code within date range
        $this->db->select('geopos_job_codes.code, geopos_job_codes.title, SUM(geopos_timesheets.total_hours) as total_hours, COUNT(DISTINCT geopos_timesheets.employee_id) as employee_count');
        $this->db->from('geopos_timesheets');
        $this->db->join('geopos_job_codes', 'geopos_job_codes.id = geopos_timesheets.job_code_id', 'left');
        $this->db->where('geopos_timesheets.clock_in >=', $start);
        $this->db->where('geopos_timesheets.clock_in <=', $end . ' 23:59:59');
        $this->db->group_by('geopos_timesheets.job_code_id');
        return $this->db->get()->result_array();
    }
    
    public function get_dashboard_stats() {
        // 1. Last 6 Payroll Runs Trend
        $this->db->select('end_date, total_amount, total_tax');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(6);
        $trend = $this->db->get('geopos_payroll_runs')->result_array();
        
        // 2. Department Breakdown (Recent Run)
        // Need to join payroll items -> employees -> department (if exists in employee table) or just use logic
        // Assuming geopos_employees has 'dept' or similar. 
        // Let's check employee structure later, for now placeholder
        
        return array(
            'trend' => array_reverse($trend)
        );
    }
    public function get_payslip_statistics($eid, $start, $end) {
        // 1. Job Code Summary
        $this->db->select('geopos_job_codes.title, SUM(geopos_timesheets.total_hours) as hours');
        $this->db->from('geopos_timesheets');
        $this->db->join('geopos_job_codes', 'geopos_job_codes.id = geopos_timesheets.job_code_id', 'left');
        $this->db->where('geopos_timesheets.employee_id', $eid);
        $this->db->where('geopos_timesheets.clock_in >=', $start . ' 00:00:00');
        $this->db->where('geopos_timesheets.clock_in <=', $end . ' 23:59:59');
        $this->db->group_by('geopos_timesheets.job_code_id');
        $jobs = $this->db->get()->result_array();
        
        // 2. Overtime Breakdown
        // Assuming we need to recalculate or just sum hours based on 'is_overtime' flag if exists
        // Converting Check `Payroll_engine` logic: "if (isset($ts['is_overtime']) && $ts['is_overtime'])"
        
        $this->db->select('SUM(total_hours) as hours, is_overtime');
        $this->db->from('geopos_timesheets');
        $this->db->where('employee_id', $eid);
        $this->db->where('clock_in >=', $start . ' 00:00:00');
        $this->db->where('clock_in <=', $end . ' 23:59:59');
        $this->db->group_by('is_overtime');
        $ot_stats = $this->db->get()->result_array();
        
        $regular_hours = 0;
        $ot_hours = 0;
        
        foreach($ot_stats as $row) {
            if($row['is_overtime'] == 1) {
                $ot_hours += $row['hours'];
            } else {
                $regular_hours += $row['hours'];
            }
        }
        
        return array(
            'jobs' => $jobs,
            'regular_hours' => $regular_hours,
            'ot_hours' => $ot_hours
        );
    }
    
    public function get_employee_all_payslips($eid) {
        $this->db->select('geopos_payroll_items.*, geopos_payroll_runs.start_date, geopos_payroll_runs.end_date');
        $this->db->from('geopos_payroll_items');
        $this->db->join('geopos_payroll_runs', 'geopos_payroll_runs.id = geopos_payroll_items.run_id', 'left');
        $this->db->where('geopos_payroll_items.employee_id', $eid);
        $this->db->order_by('geopos_payroll_runs.start_date', 'DESC');
        return $this->db->get()->result_array();
    }
}
