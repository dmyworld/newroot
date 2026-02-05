<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production_inventory_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_locations()
    {
        return $this->db->get('geopos_production_locations')->result_array();
    }

    public function get_location_stock($location_id)
    {
        // Calculate balance from movements
        // Inflow: to_location_id = $location_id
        // Outflow: from_location_id = $location_id
        
        $sql = "
            SELECT 
                p.product_name, 
                p.pid,
                (
                    COALESCE(SUM(CASE WHEN sm.to_location_id = ? THEN sm.qty ELSE 0 END), 0) -
                    COALESCE(SUM(CASE WHEN sm.from_location_id = ? THEN sm.qty ELSE 0 END), 0)
                ) as current_qty
            FROM geopos_products p
            LEFT JOIN geopos_stock_movements sm ON (p.pid = sm.product_id)
            WHERE (sm.to_location_id = ? OR sm.from_location_id = ?)
            GROUP BY p.pid
            HAVING current_qty > 0
        ";
        
        $query = $this->db->query($sql, array($location_id, $location_id, $location_id, $location_id));
        return $query->result_array();
    }

    public function search_product($term)
    {
        $this->db->select('pid, product_name');
        $this->db->from('geopos_products');
        $this->db->like('product_name', $term);
        $this->db->limit(10);
        return $this->db->get()->result_array();
    }

    public function transfer_stock($product_id, $from_id, $to_id, $qty, $note, $user_id)
    {
        // Optional: Check if enough stock exists in 'from' location (skip for now to allow initialization adjustments)
        
        $data = array(
            'product_id' => $product_id,
            'from_location_id' => $from_id ? $from_id : NULL, // NULL for initial stock add
            'to_location_id' => $to_id,
            'qty' => $qty,
            'type' => 'Transfer',
            'move_date' => date('Y-m-d H:i:s'),
            'note' => $note,
            'created_by' => $user_id
        );
        
        return $this->db->insert('geopos_stock_movements', $data);
    }
}
