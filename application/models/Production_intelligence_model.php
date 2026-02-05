<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production_intelligence_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_active_alerts()
    {
        $this->db->where('is_dismissed', 0);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('geopos_production_alerts')->result_array();
    }

    public function dismiss_alert($id)
    {
        $this->db->set('is_dismissed', 1);
        $this->db->where('id', $id);
        return $this->db->update('geopos_production_alerts');
    }

    public function run_analysis_logic()
    {
        // 1. Clear old System Alerts (Assuming we regenerate them)
        // Ideally we differentiate between "System Generated" and "Manual". 
        // For now, we'll just check inputs and only add if not exists, or verify.
        // Simplification: We will just detect and insert. Duplicates might be an issue, so we check existence.
        
        $alerts_generated = 0;

        // --- CHECK 1: Production Delays ---
        // Find active batches (not Completed) where Due Date < TODAY
        $this->db->where('status !=', 'Completed');
        // Assuming 'end_date' is the Due Date
        $this->db->where('end_date <', date('Y-m-d')); 
        $overdue_batches = $this->db->get('geopos_production_batches')->result_array();

        foreach($overdue_batches as $batch) {
            $title = "Delay Alert: " . $batch['name'];
            $msg = "Batch #{$batch['id']} is overdue. Expected: " . $batch['end_date'];
            
            // Check if already alerted
            $exists = $this->db->where('title', $title)->where('is_dismissed', 0)->count_all_results('geopos_production_alerts');
            if(!$exists) {
                $this->insert_alert($title, $msg, 'Delay', 'High');
                $alerts_generated++;
            }
        }

        // --- CHECK 2: Low Stock Global ---
        // Simple check on Products table where qty < alert_qty (Assuming default 5 if not set)
        $this->db->select('pid, product_name, qty, alert');
        $this->db->from('geopos_products');
        $this->db->where('qty <=', 10); // Hardcoded threshold for demo
        $low_stock = $this->db->get()->result_array();

        foreach($low_stock as $prod) {
            $title = "Low Stock: " . $prod['product_name'];
            $msg = "Current Quantity: " . $prod['qty'] . ". Reorder recommended.";
            
            $exists = $this->db->where('title', $title)->where('is_dismissed', 0)->count_all_results('geopos_production_alerts');
            if(!$exists) {
                $this->insert_alert($title, $msg, 'Inventory', 'Medium');
                $alerts_generated++;
            }
        }

        return $alerts_generated;
    }

    private function insert_alert($title, $msg, $type, $severity)
    {
        $data = array(
            'title' => $title,
            'message' => $msg,
            'type' => $type,
            'severity' => $severity,
            'is_dismissed' => 0
        );
        $this->db->insert('geopos_production_alerts', $data);
    }
}
