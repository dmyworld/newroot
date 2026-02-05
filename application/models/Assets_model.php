<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assets_model extends CI_Model
{
    var $table = 'geopos_assets';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_assets()
    {
        $this->db->select('geopos_assets.*, geopos_employees.name as employee_name');
        $this->db->from('geopos_assets');
        $this->db->join('geopos_employees', 'geopos_assets.assigned_to = geopos_employees.id', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_asset($data)
    {
        return $this->db->insert('geopos_assets', $data);
    }
    
    public function update_asset($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('geopos_assets', $data);
    }

    public function delete_asset($id)
    {
         return $this->db->delete('geopos_assets', array('id' => $id));
    }
}
