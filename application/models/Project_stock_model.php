<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_stock_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('project_costing_model');
    }

    public function process_issue($project_id, $warehouse_id, $items, $user_id)
    {
        $this->db->trans_start();

        foreach ($items as $item) {
            $product_id = $item['pid'];
            $qty = $item['qty'];
            
            // 1. Get Product Details (for Cost)
            $this->db->select('product_price');
            $this->db->where('pid', $product_id);
            $query = $this->db->get('geopos_products');
            $product = $query->row_array();
            
            if (!$product) continue;
            
            $unit_cost = $product['product_price']; // Using Sales Price as Cost for now or Average Cost if available
            // If actual cost is needed, we should query purchase history or average cost field if exists.
            
            // 2. Deduct from Warehouse
            // We need to check if products table has warehouse specific stock?
            // Usually 'geopos_products' has 'qty'. 'geopos_warehouse' might be just linking.
            // But if multi-warehouse is active, stock is likely in 'geopos_products' (total) or specific table?
            // User requested "Central warehouse + branch stock". 
            // Existing 'Stock_transfer' uses 'stock_transfer_model'. 
            // Let's assume 'geopos_products' holds QTY.
            
            $this->db->set('qty', "qty - $qty", FALSE);
            $this->db->where('pid', $product_id);
            $this->db->update('geopos_products');
            
            // 3. Add to Project Costing
            $this->project_costing_model->add_item($project_id, $product_id, $qty, $unit_cost, $user_id);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
}
