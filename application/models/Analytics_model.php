<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function predict_dead_stock($branch_id = 0)
    {
        // Rule: last_sale_date > 45 days AND quantity > 10 (threshold)
        $threshold_days = 45;
        $date_limit = date('Y-m-d', strtotime("-$threshold_days days"));
        
        $this->db->select('p.pid, p.product_name, p.qty, p.product_price');
        $this->db->from('geopos_products p');
        $this->db->join('geopos_warehouse w', 'p.warehouse = w.id', 'left');
        
        // Subquery for Last Sale
        $this->db->join('(SELECT pid, MAX(invoicedate) as last_sale 
                          FROM geopos_invoice_items 
                          JOIN geopos_invoices ON geopos_invoices.id = geopos_invoice_items.tid 
                          GROUP BY pid) as sales', 'p.pid = sales.pid', 'left');
        
        $this->db->group_start();
        $this->db->where('sales.last_sale <', $date_limit);
        $this->db->or_where('sales.last_sale IS NULL', null, false);
        $this->db->group_end();
        
        $this->db->where('p.qty >', 10);
        
        if ($branch_id > 0) {
            $this->db->where('w.loc', $branch_id);
        }
        
        return $this->db->get()->result_array();
    }
    
    public function get_dead_stock_value($branch_id = 0)
    {
        $stocks = $this->predict_dead_stock($branch_id);
        $total_val = 0;
        foreach ($stocks as $item) {
            $total_val += ($item['qty'] * $item['product_price']);
        }
        return $total_val;
    }

    public function get_branch_performance()
    {
        // Mock data for map if actual branch coordinates aren't stored
        // Assuming geopos_locations or warehouses has branch info
        $this->db->select('id, cname as name, address, city'); // Adjust columns based on actual request
        $this->db->from('geopos_locations');
        $query = $this->db->get();
        $branches = $query->result_array();
        
        $this->load->model('intelligence_model');
        
        foreach ($branches as &$branch) {
         // Get Total Sales
         $this->db->select_sum('total');
         $this->db->from('geopos_invoices');
         $this->db->where('loc', $branch['id']);
         $this->db->where('DATE(invoicedate)', date('Y-m-d'));
         $branch['total_sales'] = $this->db->get()->row()->total ?? 0;
         
         // Get Total Expenses (Transactions with type 'Expense')
         $this->db->select_sum('debit');
         $this->db->from('geopos_transactions');
         $this->db->where('loc', $branch['id']);
         $this->db->where('type', 'Expense');
         $this->db->where('DATE(date)', date('Y-m-d'));
         $branch['total_expenses'] = $this->db->get()->row()->debit ?? 0;

         // Calculate Profit
         $branch['profit'] = $branch['total_sales'] - $branch['total_expenses'];
         
         // Define status thresholds
         if ($branch['profit'] > 10000) {
             $branch['status'] = 'green';
         } elseif ($branch['profit'] > 0) {
             $branch['status'] = 'yellow';
         } else {
             $branch['status'] = 'red';
         }
    }
    return $branches; 
    }

    public function get_slow_moving_count($branch_id = 0)
    {
        // Logic: Products with stock > 0 but no sales in last 90 days
        $date_limit = date('Y-m-d', strtotime("-90 days"));
        
        $this->db->from('geopos_products p');
        $this->db->join('geopos_warehouse w', 'p.warehouse = w.id', 'left');
        
        $this->db->join('(SELECT pid, MAX(invoicedate) as last_sale 
                          FROM geopos_invoice_items 
                          JOIN geopos_invoices ON geopos_invoices.id = geopos_invoice_items.tid 
                          GROUP BY pid) as sales', 'p.pid = sales.pid', 'left');
                          
        $this->db->group_start();
        $this->db->where('sales.last_sale <', $date_limit);
        $this->db->or_where('sales.last_sale IS NULL', null, false);
        $this->db->group_end();
        
        $this->db->where('p.qty >', 0);
        
        if ($branch_id > 0) {
            $this->db->where('w.loc', $branch_id);
        }
        
        return $this->db->count_all_results();
    }
}
