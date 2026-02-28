<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logistics_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add_vehicle($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('geopos_logistics_fleet', $data);
    }

    public function get_fleet($loc = 0)
    {
        if ($loc > 0) $this->db->where('loc', $loc);
        $this->db->order_by('id', 'DESC');
        return $this->db->get('geopos_logistics_fleet')->result_array();
    }

    public function update_vehicle($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('geopos_logistics_fleet', $data);
    }

    public function create_transport_order($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('geopos_logistics_orders', $data);
    }

    public function get_transport_orders($loc = 0)
    {
        $this->db->select('o.*, f.vehicle_no, f.driver_name');
        $this->db->from('geopos_logistics_orders o');
        $this->db->join('geopos_logistics_fleet f', 'f.id = o.vehicle_id', 'left');
        if ($loc > 0) $this->db->where('o.loc', $loc);
        $this->db->order_by('o.id', 'DESC');
        return $this->db->get()->result_array();
    }
}
