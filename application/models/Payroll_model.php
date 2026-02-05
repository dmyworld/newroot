<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_model extends CI_Model
{
    var $table = 'geopos_payroll';

    public function __construct()
    {
        parent::__construct();
    }

    // Get employees for payroll (active ones)
    public function get_eligible_employees($loc = 0)
    {
        $this->db->select('geopos_employees.*');
        $this->db->from('geopos_employees');
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');
        if ($loc > 0) {
            $this->db->where('geopos_users.loc', $loc);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function save_payroll($data)
    {
        $this->db->insert('geopos_payroll', $data);
        return $this->db->insert_id();
    }
    
    // Check if payroll already run for this month/employee
    public function check_payroll_exists($eid, $month, $year) 
    {
        $this->db->where('emp_id', $eid);
        $this->db->where('month', $month);
        $this->db->where('year', $year);
        $query = $this->db->get('geopos_payroll');
        return $query->num_rows() > 0;
    }

    public function get_payroll_history($eid = null)
    {
        $this->db->select('geopos_payroll.*, geopos_employees.name as emp_name');
        $this->db->from('geopos_payroll');
        $this->db->join('geopos_employees', 'geopos_payroll.emp_id = geopos_employees.id');
        if($eid) {
            $this->db->where('geopos_payroll.emp_id', $eid);
        }
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
}
