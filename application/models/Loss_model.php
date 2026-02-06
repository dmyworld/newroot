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
        // For percentage, we can use (adjustments / total moves) if possible, 
        // but for now, we'll return a numeric count or a calculated rate.
        $this->db->from('geopos_movers');
        $this->db->where_in('d_type', [4, 5, 20]); 
        $this->db->where('date(d_time) >=', date('Y-m-01'));
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
        $this->db->where('d_type', '2'); 
        $this->db->where('date(d_time) >=', date('Y-m-01'));
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
}
