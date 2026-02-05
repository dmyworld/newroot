<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_costing_model extends CI_Model
{
    var $table = 'geopos_project_items';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_items($project_id)
    {
        $this->db->select('geopos_project_items.*, geopos_products.product_name, geopos_products.product_code');
        $this->db->from($this->table);
        $this->db->join('geopos_products', 'geopos_project_items.product_id = geopos_products.pid', 'left');
        $this->db->where('project_id', $project_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_item($project_id, $product_id, $qty, $unit_cost, $user_id)
    {
        $total_cost = $qty * $unit_cost;
        $data = array(
            'project_id' => $project_id,
            'product_id' => $product_id,
            'qty' => $qty,
            'unit_cost' => $unit_cost,
            'total_cost' => $total_cost,
            'user_id' => $user_id
        );

        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function delete_item($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
    
    public function get_total_cost($project_id) {
        $this->db->select_sum('total_cost');
        $this->db->where('project_id', $project_id);
        $query = $this->db->get($this->table);
        return $query->row()->total_cost;
    }
}
