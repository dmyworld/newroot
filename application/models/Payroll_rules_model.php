<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_rules_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // --- Overtime Rules ---
    public function get_overtime_rules()
    {
        $this->db->where('is_active', 1);
        $query = $this->db->get('geopos_overtime_rules');
        return $query->result_array();
    }

    public function add_overtime_rule($data)
    {
        return $this->db->insert('geopos_overtime_rules', $data);
    }

    public function update_overtime_rule($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('geopos_overtime_rules', $data);
    }
    
    public function delete_overtime_rule($id)
    {
        $data = array('is_active' => 0);
        $this->db->where('id', $id);
        return $this->db->update('geopos_overtime_rules', $data);
    }

    // --- Deduction Types ---
    public function get_deduction_types()
    {
        $this->db->where('is_active', 1);
        $query = $this->db->get('geopos_deduction_types');
        return $query->result_array();
    }

    public function add_deduction_type($data)
    {
        return $this->db->insert('geopos_deduction_types', $data);
    }

    public function update_deduction_type($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('geopos_deduction_types', $data);
    }

    public function delete_deduction_type($id)
    {
        $data = array('is_active' => 0);
        $this->db->where('id', $id);
        return $this->db->update('geopos_deduction_types', $data);
    }

    // --- Job Codes ---
    public function get_job_codes()
    {
        $this->db->where('is_active', 1);
        $query = $this->db->get('geopos_job_codes');
        return $query->result_array();
    }

    public function add_job_code($data)
    {
        return $this->db->insert('geopos_job_codes', $data);
    }

    public function delete_job_code($id)
    {
            $data = array('is_active' => 0);
            $this->db->where('id', $id);
            return $this->db->update('geopos_job_codes', $data);
    }

    // --- Configuration ---
    public function get_config($name)
    {
        $this->db->where('name', $name);
        $query = $this->db->get('geopos_payroll_config');
        $row = $query->row();
        return $row ? $row->value : null;
    }

    public function set_config($name, $value)
    {
        // Check if exists
            $this->db->where('name', $name);
            $q = $this->db->get('geopos_payroll_config');
            if ($q->num_rows() > 0) {
                $this->db->where('name', $name);
                return $this->db->update('geopos_payroll_config', array('value' => $value, 'updated_at' => date('Y-m-d H:i:s')));
            } else {
                return $this->db->insert('geopos_payroll_config', array('name' => $name, 'value' => $value, 'updated_at' => date('Y-m-d H:i:s')));
            }
    }
}
