<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Risk_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('communication_model');
    }

    public function detect_fraud_patterns()
    {
        $date = date('Y-m-d');
        
        // Get all active users
        $this->db->select('id, username, loc');
        $this->db->from('geopos_users');
        $this->db->where('banned', 0); // Active only
        $query = $this->db->get();
        $staff = $query->result_array();

        foreach ($staff as $user) {
            $sid = $user['id'];
            $branch_id = $user['loc']; // Assuming loc is branch_id

            // 1. Count Void Invoices
            $this->db->where('eid', $sid);
            $this->db->where('DATE(invoicedate)', $date);
            $this->db->where('status', 'canceled');
            $void_count = $this->db->count_all_results('geopos_invoices');

            // 2. Count Returns (Assuming 'returned' status or stock_r check)
            // For now, checking geopos_stock_r table if linked to user, else using invoice status 'returned' if exists
            // Let's use metadata or invoice status 'partially' as proxy if 'returned' not standard. 
            // Better: Check stock_return table logic. 
            // Placeholder: Invoice status='canceled' often covers returns in simple setups, but let's query stock_r
            $this->db->where('DATE(date)', $date);
            $this->db->where('person_type', 'Customer'); // Assuming
            // Note: geopos_stock_r might not track 'who' did it easily without joining log. 
            // We'll stick to invoice-based return proxy for now:
            $returns = 0; // If no direct link, we'll refine later. Logic: same as voids for now or separate table.
            
            // 3. Price Overrides
            // This requires tracking. If not tracked, we'll mock or set to 0. 
            // Real implementation needs a 'geopos_log' check where action='Override'.
            $override_count = 0; // Placeholder

            // Thresholds
            if ($override_count > 5 || $returns > 3 || $void_count > 2) {
                $reasons = [];
                if($override_count > 5) $reasons[] = "High Price Overrides ($override_count)";
                if($returns > 3) $reasons[] = "Excessive Returns ($returns)";
                if($void_count > 2) $reasons[] = "Excessive Voids ($void_count)";
                
                $message = "Suspicious behavior detected: " . implode(', ', $reasons);
                
                $this->log_risk_alert(
                    $sid,
                    'FRAUD_RISK',
                    'High',
                    $message
                );
            }
        }
    }

    public function detect_stock_loss($date = null)
    {
         if (!$date) $date = date('Y-m-d');
         
         // Example: Check stock return/adjustments on this date
         $this->db->select('SUM(total) as loss_amount');
         $this->db->from('geopos_stock_r'); // Assuming stock return table
         $this->db->where('DATE(date)', $date); // Adjust column name if needed
         $query = $this->db->get();
         $result = $query->row_array();
         
         $loss = $result['loss_amount'] ?? 0;
         
         // Compare with Daily Sales
         $daily_sales = $this->get_daily_sales($date);
         
         if ($daily_sales > 0 && ($loss / $daily_sales) > 0.005) { // 0.5%
             $this->log_risk_alert(
                 0, 
                 'Loss', 
                 'Medium', 
                 "Daily stock loss (" . number_format($loss,2) . ") exceeds 0.5% of sales."
             );
         }
         
         return $loss;
    }

    private function get_daily_sales($date)
    {
        $this->db->select_sum('total');
        $this->db->from('geopos_invoices');
        $this->db->where('DATE(invoicedate)', $date);
        $query = $this->db->get();
        return $query->row()->total ?? 0;
    }

    public function log_risk_alert($staff_id, $type, $severity, $message)
    {
        $data = array(
            'company_id' => isset($this->aauth) && $this->aauth->get_user() ? $this->aauth->get_user()->loc : 0,
            'branch_id' => isset($this->aauth) && $this->aauth->get_user() ? $this->aauth->get_user()->loc : 0,
            'type' => $type,
            'severity' => $severity,
            'message' => $message,
            'status' => 'New'
        );
        $this->db->insert('geopos_risk_alerts', $data);
    }
    
    public function get_recent_alerts($limit = 5) {
        $this->db->from('geopos_risk_alerts');
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }
}
