<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timber_grades_model extends CI_Model
{
    var $table = 'geopos_timber_grades';
    var $column_order = array(null, 'grade_name', 'qc_threshold_min', 'qc_threshold_max', null);
    var $column_search = array('grade_name', 'rejection_rule_desc');
    var $order = array('id' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->db->from($this->table);

        $i = 0;

        foreach ($this->column_search as $item) 
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

                if (count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }

        if (isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_details($id)
    {
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function create($grade_name, $qc_min, $qc_max, $rejection_desc)
    {
        $data = array(
            'grade_name' => $grade_name,
            'qc_threshold_min' => $qc_min,
            'qc_threshold_max' => $qc_max,
            'rejection_rule_desc' => $rejection_desc
        );

        if ($this->db->insert($this->table, $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function edit($id, $grade_name, $qc_min, $qc_max, $rejection_desc)
    {
        $data = array(
            'grade_name' => $grade_name,
            'qc_threshold_min' => $qc_min,
            'qc_threshold_max' => $qc_max,
            'rejection_rule_desc' => $rejection_desc
        );

        $this->db->where('id', $id);
        if ($this->db->update($this->table, $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, array('id' => $id));
    }
}
