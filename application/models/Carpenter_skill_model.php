<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carpenter_skills_model extends CI_Model
{
    // For Skill list
    var $table_skills = 'geopos_skills';
    var $column_order_skills = array(null, 'name', 'description', null);
    var $column_search_skills = array('name', 'description');
    
    // For Employee Skill Matrix
    var $table_matrix = 'geopos_emp_skills';
    var $column_order_matrix = array(null, 'geopos_employees.name', 'geopos_skills.name', 'proficiency_level', 'productivity_score', null);
    var $column_search_matrix = array('geopos_employees.name', 'geopos_skills.name');

    public function __construct()
    {
        parent::__construct();
    }

    // --- Skills CRUD ---
    public function get_skills_list()
    {
        $this->db->from($this->table_skills);
        return $this->db->get()->result();
    }

    public function create_skill($name, $description)
    {
        $data = array('name' => $name, 'description' => $description);
        return $this->db->insert($this->table_skills, $data);
    }
    
    // --- Matrix Logic ---
    private function _get_matrix_query()
    {
        $this->db->select('geopos_emp_skills.*, geopos_employees.name as emp_name, geopos_skills.name as skill_name');
        $this->db->from($this->table_matrix);
        $this->db->join('geopos_employees', 'geopos_employees.id = geopos_emp_skills.employee_id', 'left');
        $this->db->join('geopos_skills', 'geopos_skills.id = geopos_emp_skills.skill_id', 'left');

        $i = 0;
        foreach ($this->column_search_matrix as $item) 
        {
            if ($this->input->post('search')['value']) 
            {
                if ($i === 0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }
                if (count($this->column_search_matrix) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
        
        if (isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order_matrix[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('geopos_emp_skills.id', 'DESC');
        }
    }

    public function get_matrix_datatables()
    {
        $this->_get_matrix_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_matrix_filtered()
    {
        $this->_get_matrix_query();
        return $this->db->get()->num_rows();
    }

    public function count_matrix_all()
    {
        $this->db->from($this->table_matrix);
        return $this->db->count_all_results();
    }

    public function assign_skill($emp_id, $skill_id, $proficiency, $score)
    {
        // Check if already assigned
        $this->db->where('employee_id', $emp_id);
        $this->db->where('skill_id', $skill_id);
        $q = $this->db->get($this->table_matrix);
        
        $data = array(
            'employee_id' => $emp_id,
            'skill_id' => $skill_id,
            'proficiency_level' => $proficiency,
            'productivity_score' => $score
        );

        if ($q->num_rows() > 0) {
            // Update
            $this->db->where('id', $q->row()->id);
            return $this->db->update($this->table_matrix, $data);
        } else {
            // Insert
            return $this->db->insert($this->table_matrix, $data);
        }
    }
    
    public function delete_assignment($id)
    {
        return $this->db->delete($this->table_matrix, array('id' => $id));
    }
}
