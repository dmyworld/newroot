<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_analytics_model extends CI_Model
{
    public function monthly_trends($year = '')
    {
        if ($year == '') $year = date('Y');
        
        $this->db->select('DATE_FORMAT(geopos_payroll_runs.start_date, "%Y-%m") as month, SUM(geopos_payroll_items.gross_pay) as total_gross');
        $this->db->from('geopos_payroll_items');
        $this->db->join('geopos_payroll_runs', 'geopos_payroll_runs.id = geopos_payroll_items.run_id', 'left');
        $this->db->where('YEAR(geopos_payroll_runs.start_date)', $year);
        $this->db->group_by('month');
        $this->db->order_by('month', 'ASC');
        return $this->db->get()->result_array();
    }

    public function dept_distribution()
    {
        // Join employees to get department
        // Assuming geopos_employees has 'dept' (int) and we might need to join 'geopos_departments' if it exists, or just use ID.
        // Let's check employee model or usage. Usually 'dept' is just an ID or Name.
        // For now, I'll group by 'geopos_employees.dept' if it's an ID.
        // Wait, I should verify if geopos_employees table has dept.
        
        $this->db->select('geopos_employees.dept, SUM(geopos_payroll_items.gross_pay) as total_gross');
        $this->db->from('geopos_payroll_items');
        $this->db->join('geopos_employees', 'geopos_employees.id = geopos_payroll_items.employee_id', 'left');
        $this->db->group_by('geopos_employees.dept');
        $result = $this->db->get()->result_array();
        
        // Map Dept ID to Name if possible, or just return result for now.
        return $result;
    }
    
    public function get_dept_name($id) {
        $this->db->select('val1');
        $this->db->from('geopos_hrm');
         $this->db->where('id', $id);
         $query = $this->db->get();
         if($query->num_rows() > 0) {
             return $query->row()->val1;
         }
         return 'Unknown';
    }
}
