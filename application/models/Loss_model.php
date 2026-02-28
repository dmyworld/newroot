<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loss_model extends CI_Model
{
    var $table = 'geopos_loss_logs';

    public function __construct()
    {
        parent::__construct();
    }

    public function log_loss($type, $amount, $description, $date = null)
    {
        if (!$date) $date = date('Y-m-d');
        
        $data = array(
            'date' => $date,
            'branch_id' => isset($this->aauth) && $this->aauth->get_user() ? $this->aauth->get_user()->loc : 0,
            'type' => $type,
            'amount' => $amount,
            'description' => $description
        );
        
        return $this->db->insert($this->table, $data);
    }
    
    public function get_todays_loss()
    {
        $this->db->select_sum('amount');
        $this->db->where('date', date('Y-m-d'));
        $this->db->where('branch_id', isset($this->aauth) && $this->aauth->get_user() ? $this->aauth->get_user()->loc : 0);
        $query = $this->db->get($this->table);
        return $query->row()->amount ?? 0;
    }
    
    public function get_prevented_loss_today($branch_id = 0) 
    {
        $this->db->select_sum('amount');
        $this->db->where('date', date('Y-m-d'));
        $this->db->where('type', 'Prevented');
        if ($branch_id > 0) $this->db->where('branch_id', $branch_id);
        $query = $this->db->get($this->table);
        return $query->row()->amount ?? 0;
    }

    // GAME CHANGER: PROFIT LEAK DETECTOR LOGIC

    public function get_stock_leak_stats($branch_id = 0)
    {
        // Stock Leak: Calculated as adjustments count from geopos_movers
        $this->db->from('geopos_movers');
        
        // Join to filter by branch
        if ($branch_id > 0) {
            $this->db->join('geopos_products', 'geopos_movers.rid1 = geopos_products.pid', 'left');
            $this->db->join('geopos_warehouse', 'geopos_products.warehouse = geopos_warehouse.id', 'left');
            $this->db->where('geopos_warehouse.loc', $branch_id);
        }
        
        $this->db->where_in('geopos_movers.d_type', [4, 5, 20]); 
        $this->db->where('date(geopos_movers.d_time) >=', date('Y-m-01'));
        $adjustments = $this->db->count_all_results();

        return array(
            'percentage' => (float)$adjustments, // Return numeric value
            'status' => ($adjustments > 10) ? 'Critical' : 'Good',
            'count' => $adjustments
        );
    }

    public function get_billing_errors($branch_id = 0)
    {
        // 1. Count Canceled Invoices
        $this->db->where('status', 'canceled');
        $this->db->where('date(invoicedate) >=', date('Y-m-01'));
        if ($branch_id > 0) $this->db->where('loc', $branch_id);
        $canceled = $this->db->count_all_results('geopos_invoices');

        // 2. Total Invoices
        $this->db->where('date(invoicedate) >=', date('Y-m-01'));
        if ($branch_id > 0) $this->db->where('loc', $branch_id);
        $total = $this->db->count_all_results('geopos_invoices');
        
        if ($total == 0) return ['percentage' => 0.0, 'status' => 'Good', 'count' => 0];

        $error_rate = ($canceled / $total) * 100;
        
        $status = 'Good';
        if ($error_rate > 5) $status = 'Critical';
        elseif ($error_rate > 2) $status = 'Normal';

        return array(
            'percentage' => (float)$error_rate, // Return numeric float
            'status' => $status,
            'count' => $canceled
        );
    }

    public function get_return_abuse_stats($branch_id = 0)
    {
        // Return Abuse: Stock Return Notes (SRN) vs Sales
        $this->db->from('geopos_movers');
        
        // Join to filter by branch
        if ($branch_id > 0) {
            $this->db->join('geopos_products', 'geopos_movers.rid1 = geopos_products.pid', 'left');
            $this->db->join('geopos_warehouse', 'geopos_products.warehouse = geopos_warehouse.id', 'left');
            $this->db->where('geopos_warehouse.loc', $branch_id);
        }
        
        $this->db->where('geopos_movers.d_type', '2'); 
        $this->db->where('date(geopos_movers.d_time) >=', date('Y-m-01'));
        $returns_count = $this->db->count_all_results();
        
        $this->db->where('date(invoicedate) >=', date('Y-m-01'));
        if ($branch_id > 0) $this->db->where('loc', $branch_id);
        $sales_count = $this->db->count_all_results('geopos_invoices');
        
        if ($sales_count == 0) return ['percentage' => 0.0, 'status' => 'Good', 'count' => 0];

        $return_rate = ($returns_count / $sales_count) * 100;
        
        $status = 'Good';
        if ($return_rate > 6) $status = 'Critical';
        elseif ($return_rate > 3) $status = 'Warning';

        return array(
            'percentage' => (float)$return_rate, // Return numeric float
            'status' => $status,
            'count' => $returns_count
        );
    }

    /**
     * Create journal entry for stock adjustment (Shortage/Surplus)
     * 
     * @param int $product_id Product ID
     * @param float $qty_diff Quantity difference (negative = shortage, positive = surplus)
     * @param float $unit_price Unit price of the product
     * @param string $note Adjustment note/reason
     * @param int $loc Location/Branch ID
     * @return bool Success status
     */
    public function create_stock_adjustment_entry($product_id, $qty_diff, $unit_price, $note = '', $loc = 0)
    {
        $this->load->model('transactions_model');
        $this->load->model('univarsal_api_model', 'custom');
        
        if (!$loc) {
            $loc = $this->aauth->get_user()->loc;
        }
        
        $amount = abs($qty_diff * $unit_price);
        
        // Get Inventory/Stock Account
        $inventory_acc = $this->custom->api_config(70); // Assuming API key 70 is for Stock/Inventory
        
        if (!$inventory_acc || !$inventory_acc['key1']) {
            return false; // Stock account not configured
        }
        
        $inventory_account_id = $inventory_acc['key1'];
        
        if ($qty_diff < 0) {
            // Stock Shortage: Debit Stock Loss Expense, Credit Inventory
            $loss_acc = $this->custom->api_config(71); // API key for Stock Loss Expense account
            
            if (!$loss_acc || !$loss_acc['key1']) {
                return false;
            }
            
            $note_text = "Stock Shortage Adjustment - Product #$product_id - Qty: " . abs($qty_diff) . " - " . $note;
            
            $result = $this->transactions_model->add_double_entry(
                $loss_acc['key1'],          // Debit: Stock Loss Expense
                $inventory_account_id,      // Credit: Inventory
                $amount,
                $note_text,
                0,                          // payer_id
                "Stock Adjustment",         // payer_name
                'Stock Loss',               // category
                'Journal',                  // method
                date('Y-m-d H:i:s'),        // date
                $loc,                       // location
                0,                          // ext
                $product_id                 // link_id (product)
            );
            
            // Log the loss
            $this->log_loss('Stock Shortage', $amount, $note_text, date('Y-m-d'));
            
        } else {
            // Stock Surplus: Debit Inventory, Credit Stock Gain (Income)
            $gain_acc = $this->custom->api_config(72); // API key for Stock Gain account
            
            if (!$gain_acc || !$gain_acc['key1']) {
                return false;
            }
            
            $note_text = "Stock Surplus Adjustment - Product #$product_id - Qty: $qty_diff - " . $note;
            
            $result = $this->transactions_model->add_double_entry(
                $inventory_account_id,      // Debit: Inventory
                $gain_acc['key1'],          // Credit: Stock Gain
                $amount,
                $note_text,
                0,                          // payer_id
                "Stock Adjustment",         // payer_name
                'Stock Gain',               // category
                'Journal',                  // method
                date('Y-m-d H:i:s'),        // date
                $loc,                       // location
                0,                          // ext
                $product_id                 // link_id (product)
            );
        }
        
        return $result;
    }
}
