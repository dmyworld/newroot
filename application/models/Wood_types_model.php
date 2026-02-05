<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wood_types_model extends CI_Model
{
    var $table = 'geopos_wood_types';
    var $column_order = array(null, 'name', 'density', 'moisture_tolerance_min', 'shrinkage_coeff', null);
    var $column_search = array('name', 'description');
    var $order = array('id' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->db->from($this->table);

        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($this->input->post('search')['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
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

    public function create($name, $density, $moisture_min, $moisture_max, $shrinkage, $description)
    {
        $data = array(
            'name' => $name,
            'density' => $density,
            'moisture_tolerance_min' => $moisture_min,
            'moisture_tolerance_max' => $moisture_max,
            'shrinkage_coeff' => $shrinkage,
            'description' => $description
        );

        if ($this->db->insert($this->table, $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function edit($id, $name, $density, $moisture_min, $moisture_max, $shrinkage, $description)
    {
        $data = array(
            'name' => $name,
            'density' => $density,
            'moisture_tolerance_min' => $moisture_min,
            'moisture_tolerance_max' => $moisture_max,
            'shrinkage_coeff' => $shrinkage,
            'description' => $description
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
