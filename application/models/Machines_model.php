<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Machines_model extends CI_Model
{
    var $table = 'geopos_machines';
    var $column_order = array(null, 'name', 'machine_code', 'capacity_per_hour', 'next_maintenance_date', 'status', null);
    var $column_search = array('name', 'machine_code', 'status');
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
        return $this->db->get()->num_rows();
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
        return $this->db->get()->row_array();
    }

    public function create($name, $code, $capacity, $cycle, $last_maint, $next_maint, $status)
    {
        $data = array(
            'name' => $name,
            'machine_code' => $code,
            'capacity_per_hour' => $capacity,
            'maintenance_cycle_days' => $cycle,
            'last_maintenance_date' => $last_maint,
            'next_maintenance_date' => $next_maint,
            'status' => $status
        );
        return $this->db->insert($this->table, $data);
    }

    public function edit($id, $name, $code, $capacity, $cycle, $last_maint, $next_maint, $status)
    {
        $data = array(
            'name' => $name,
            'machine_code' => $code,
            'capacity_per_hour' => $capacity,
            'maintenance_cycle_days' => $cycle,
            'last_maintenance_date' => $last_maint,
            'next_maintenance_date' => $next_maint,
            'status' => $status
        );
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, array('id' => $id));
    }
}
