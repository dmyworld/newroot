<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Intelligence_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('risk_model');
    }

    public function calculate_staff_trust_score()
    {
        $date = date('Y-m-d');
        
        $this->db->select('id, username, loc');
        $this->db->from('geopos_users');
        $this->db->where('banned', 0);
        $query = $this->db->get();
        $staff = $query->result_array();
        
        foreach ($staff as $user) {
            $sid = $user['id'];
            
            // 1. Sales Count and Amount (Today)
            $this->db->select('COUNT(*) as sales_count, SUM(total) as sales_amount');
            $this->db->from('geopos_invoices');
            $this->db->where('eid', $sid);
            $this->db->where('DATE(invoicedate)', $date);
            $this->db->where_not_in('status', ['canceled', 'pending']);
            $sales_data = $this->db->get()->row();
            $sales_count = $sales_data->sales_count ?? 0;
            $sales_amount = $sales_data->sales_amount ?? 0.00;
            
            // 2. Void Count (Canceled invoices)
            $this->db->where('eid', $sid);
            $this->db->where('DATE(invoicedate)', $date);
            $this->db->where('status', 'canceled');
            $void_count = $this->db->count_all_results('geopos_invoices');
            
            // 3. Return Count (Stock returns via movers table d_type=2)
            $this->db->from('geopos_movers');
            $this->db->where('d_type', '2'); // Return type
            $this->db->where('DATE(d_time)', $date);
            // Note: movers table may not have user ID, so this is approximate
            $return_count = $this->db->count_all_results();
            
            // 4. Error Count (billing errors - proxy via canceled)
            $error_count = $void_count; // Same as void for now
            
            // FORMULA: 100 - (voids*3 + returns*2 + errors*5)
            $penalty = ($void_count * 3) + ($return_count * 2) + ($error_count * 1);
            $trust_score = 100 - $penalty;
            if ($trust_score < 0) $trust_score = 0;
            
            // Delete existing score for this staff on this date
            $this->db->where('staff_id', $sid);
            $this->db->where('last_calculated >=', date('Y-m-d 00:00:00'));
            $this->db->delete('geopos_staff_scores');
            
            // Insert new score
            $data = array(
                'staff_id' => $sid,
                'branch_id' => $user['loc'],
                'trust_score' => $trust_score,
                'sales_count' => $sales_count,
                'sales_amount' => $sales_amount,
                'void_count' => $void_count,
                'return_count' => $return_count,
                'error_count' => $error_count,
                'last_calculated' => date('Y-m-d H:i:s')
            );
            
            $this->db->insert('geopos_staff_scores', $data);
        }
    }
    
    public function generate_business_health_index()
    {
        $date = date('Y-m-d');

        // Get daily sales for scaling
        $sales = $this->get_aggregated_sales($date);
        
        // 1. Sales Score (Target: 10,000 daily sales = 100% score)
        $sales_score = ($sales > 10000) ? 100 : (($sales / 10000) * 100);
        if($sales_score < 0) $sales_score = 0;
        
        // 2. Profit Score (Target: 5,000 daily profit = 100% score)
        $daily_profit = $this->get_aggregated_profit($date);
        $profit_score = ($daily_profit > 5000) ? 100 : (($daily_profit / 5000) * 100);
        if($profit_score < 0) $profit_score = 0;

        // 3. Cash Flow Score (Cash > 2000 => 100)
        $cash = $this->get_aggregated_cash($date);
        $cash_score = ($cash > 2000) ? 100 : (($cash / 2000) * 100);
        if($cash_score < 0) $cash_score = 0;

        // 4. Staff Score (Average staff trust)
        $staff_score = $this->get_avg_staff_trust();

        // FORMULA: (sales*0.25) + (profit*0.35) + (cash*0.20) + (staff*0.20)
        $health_index = ($sales_score * 0.25) + ($profit_score * 0.35) + ($cash_score * 0.20) + ($staff_score * 0.20);
        
        $health_rounded = round($health_index);
        
        // Delete existing record for today
        $this->db->where('date', $date);
        $this->db->where('branch_id', 0); // Global/All branches
        $this->db->delete('geopos_business_health');
        
        // Insert new health index
        $data = array(
            'date' => $date,
            'branch_id' => 0, // 0 = All branches (global)
            'health_index' => $health_rounded,
            'sales_score' => round($sales_score),
            'profit_score' => round($profit_score),
            'cashflow_score' => round($cash_score),
            'staff_score' => round($staff_score)
        );
        $this->db->insert('geopos_business_health', $data);
        
        return $health_rounded;
    }

    public function get_business_health()
    {
        $this->db->select('health_index');
        $this->db->where('date', date('Y-m-d'));
        $this->db->where('branch_id', 0); // Global score
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('geopos_business_health');
        if (!$query) return 85; // Default if query fails
        $result = $query->row();
        return $result ? $result->health_index : 85; // Default if no data
    }

    public function get_avg_staff_trust()
    {
        $this->db->select_avg('trust_score');
        $this->db->where('DATE(last_calculated)', date('Y-m-d'));
        $query = $this->db->get('geopos_staff_scores');
        if (!$query) return 100; // Default if query fails
        $result = $query->row();
        $score = $result ? $result->trust_score : null;
        return $score ? round($score) : 100;
    }

    // New Aggregation Methods for Owner Dashboard

    public function get_aggregated_sales($date, $branch_id = 0)
    {
        $this->db->select_sum('total');
        $this->db->from('geopos_invoices');
        $this->db->where('DATE(invoicedate)', $date);
        
        if ($branch_id > 0) {
            $this->db->where('loc', $branch_id);
        }
        
        $query = $this->db->get();
        if (!$query) return 0.00; // Default if query fails
        $result = $query->row();
        return $result && isset($result->total) ? $result->total : 0.00;
    }

    public function get_aggregated_profit($date, $branch_id = 0)
    {
        // Profit calculation typically involves geopos_metadata type 9
        $this->db->select_sum('geopos_metadata.col1');
        $this->db->from('geopos_metadata');
        $this->db->join('geopos_invoices', 'geopos_metadata.rid=geopos_invoices.id', 'left');
        $this->db->where('geopos_metadata.type', 9);
        $this->db->where('DATE(geopos_metadata.d_date)', $date);

        if ($branch_id > 0) {
            $this->db->where('geopos_invoices.loc', $branch_id);
        }
        
        $query = $this->db->get();
        if (!$query) return 0.00; // Default if query fails
        $result = $query->row();
        return $result && isset($result->col1) ? $result->col1 : 0.00;
    }
    public function get_aggregated_cash($date, $branch_id = 0)
    {
       // RENAMED LOGIC: Total Liquidity (Cash + Bank/Cheque)
       $this->db->select_sum('credit');
       $this->db->select_sum('debit');
       $this->db->from('geopos_transactions');
       $this->db->where('DATE(date)', $date);
       
       if ($branch_id > 0) {
           $this->db->where('loc', $branch_id);
       }
       
       $query = $this->db->get();
       if (!$query) return 0.00; // Default if query fails
       $result = $query->row();
       
       $income = $result && isset($result->credit) ? $result->credit : 0.00;
       $expense = $result && isset($result->debit) ? $result->debit : 0.00;
       
       return ($income - $expense);
    }
    public function get_top_staff_trust($limit = 5, $branch_id = 0)
    {
        // Get staff with trust scores for today
        $this->db->select('geopos_staff_scores.*, geopos_users.username, geopos_users.id as user_id');
        $this->db->from('geopos_staff_scores');
        $this->db->join('geopos_users', 'geopos_staff_scores.staff_id = geopos_users.id');
        $this->db->where('DATE(geopos_staff_scores.last_calculated)', date('Y-m-d'));
        
        if ($branch_id > 0) {
            $this->db->where('geopos_staff_scores.branch_id', $branch_id);
        }
        
        $this->db->order_by('trust_score', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        $staff_list = $query ? $query->result_array() : array();
        
        // Enhance each staff member with Sales, Errors, Returns
        foreach ($staff_list as &$staff) {
            $staff_id = $staff['staff_id'];
            
            // 1. Calculate SALES (This Month)
            $this->db->select_sum('total');
            $this->db->from('geopos_invoices');
            $this->db->where('eid', $staff_id); // Employee ID
            $this->db->where('DATE(invoicedate) >=', date('Y-m-01'));
            $this->db->where('status !=', 'canceled');
            if ($branch_id > 0) $this->db->where('loc', $branch_id);
            $sales_result = $this->db->get()->row();
            $staff['sales'] = $sales_result->total ?? 0;
            
            // 2. Calculate ERRORS (Voids + Canceled invoices this month)
            $this->db->where('eid', $staff_id);
            $this->db->where('status', 'canceled');
            $this->db->where('DATE(invoicedate) >=', date('Y-m-01'));
            if ($branch_id > 0) $this->db->where('loc', $branch_id);
            $errors = $this->db->count_all_results('geopos_invoices');
            $staff['errors'] = $errors;
            
            // 3. Calculate RETURNS (from geopos_movers with d_type=2, this month)
            $staff['returns'] = $staff['return_count'] ?? 0;

            // 4. Calculate PRICE OVERRIDES (Items where price != product base price)
            $this->db->select('COUNT(*) as overrides');
            $this->db->from('geopos_invoice_items');
            $this->db->join('geopos_invoices', 'geopos_invoices.id = geopos_invoice_items.tid');
            $this->db->join('geopos_products', 'geopos_products.id = geopos_invoice_items.product');
            $this->db->where('geopos_invoices.eid', $staff_id);
            $this->db->where('geopos_invoice_items.subtotal / geopos_invoice_items.qty != geopos_products.product_price', NULL, FALSE);
            $this->db->where('date(geopos_invoices.invoicedate) >=', date('Y-m-01'));
            $overrides = $this->db->get()->row()->overrides ?? 0;
            $staff['overrides'] = $overrides;
        }
        
        return $staff_list;
    }

    // --- Phase 10: Financial & Liability Metrics ---

    public function get_customer_due($branch_id = 0, $start_date = '', $end_date = '')
    {
        // Sum of all invoices where status is 'due' or 'partial' (case-insensitive)
        $this->db->select_sum('total');
        $this->db->select_sum('pamnt'); // Paid amount to subtract
        $this->db->from('geopos_invoices');
        $this->db->group_start();
        $this->db->where_in('status', array('due', 'partial', 'Due', 'Partial'));
        $this->db->group_end();
        
        if ($branch_id > 0) {
            $this->db->where('loc', $branch_id);
        }

        // Dues are cumulative liabilities. We usually ignore start_date 
        // to show total outstanding AS OF the end_date.
        if ($end_date) {
            $this->db->where('DATE(invoicedate) <=', $end_date);
        }
        
        $query = $this->db->get();
        if (!$query) return 0.00; // Default if query fails
        $result = $query->row();
        if (!$result) return 0.00;
        $total = isset($result->total) ? $result->total : 0.00;
        $paid = isset($result->pamnt) ? $result->pamnt : 0.00;
        return ($total - $paid);
    }

    public function get_supplier_due($branch_id = 0, $start_date = '', $end_date = '') 
    {
        // 1. General Purchase
        $this->db->select_sum('total');
        $this->db->select_sum('pamnt'); // Paid amount
        $this->db->from('geopos_purchase');
        $this->db->group_start();
        $this->db->where_in('status', array('due', 'partial', 'Due', 'Partial'));
        $this->db->group_end();
        if ($branch_id > 0) $this->db->where('loc', $branch_id);
        if ($end_date) {
            $this->db->where('DATE(invoicedate) <=', $end_date);
        }
        $query = $this->db->get();
        $due_general = 0.00;
        if ($query) {
           $result = $query->row();
            if ($result) {
                $total = isset($result->total) ? $result->total : 0.00;
                $paid = isset($result->pamnt) ? $result->pamnt : 0.00;
                $due_general = ($total - $paid);
            }
        }

        // 2. Timber Logs Purchase (New Phase 19)
        $this->db->select_sum('total');
        $this->db->select_sum('pamnt'); 
        $this->db->from('geopos_purchase_logs'); // Logs Table
        $this->db->group_start();
        $this->db->where_in('status', array('due', 'partial', 'Due', 'Partial'));
        $this->db->group_end();
        if ($branch_id > 0) $this->db->where('loc', $branch_id);
        if ($end_date) {
            $this->db->where('DATE(invoicedate) <=', $end_date);
        }
        $query_logs = $this->db->get();
        $due_logs = 0.00;
        if ($query_logs) {
            $result_logs = $query_logs->row();
            if ($result_logs) {
                $total = isset($result_logs->total) ? $result_logs->total : 0.00;
                $paid = isset($result_logs->pamnt) ? $result_logs->pamnt : 0.00;
                $due_logs = ($total - $paid);
            }
        }

        return ($due_general + $due_logs);
    }

    public function get_detailed_financial_metrics($branch_id = 0, $start_date = '', $end_date = '')
    {
        $metrics = array(
            'income' => array('Cash' => 0, 'Bank' => 0, 'Cheque' => 0, 'Total' => 0),
            'expense' => array('Cash' => 0, 'Bank' => 0, 'Cheque' => 0, 'Total' => 0)
        );

        // 1. Get Income Breakdown (Credit transactions) from Transactions
        $this->db->select('method, SUM(credit) as total');
        $this->db->from('geopos_transactions');
        $this->db->where('credit >', 0);
        // CI standard where_not_in doesn't support functions, use string where
        $this->db->where("LOWER(method) NOT IN ('cheque', 'check')", NULL, FALSE);
        if ($branch_id > 0) $this->db->where('loc', $branch_id);
        if ($start_date && $end_date) {
            $this->db->where('DATE(date) >=', $start_date);
            $this->db->where('DATE(date) <=', $end_date);
        }
        $this->db->group_by('method');
        $query = $this->db->get();
        $income_query = $query ? $query->result_array() : array();

        // 2. Get Expense Breakdown (Debit transactions) from Transactions
        $this->db->select('method, SUM(debit) as total');
        $this->db->from('geopos_transactions');
        $this->db->where('debit >', 0);
        $this->db->where("LOWER(method) NOT IN ('cheque', 'check')", NULL, FALSE);
        if ($branch_id > 0) $this->db->where('loc', $branch_id);
        if ($start_date && $end_date) {
            $this->db->where('DATE(date) >=', $start_date);
            $this->db->where('DATE(date) <=', $end_date);
        }
        $this->db->group_by('method');
        $query = $this->db->get();
        $expense_query = $query ? $query->result_array() : array();

        // 3. Get Cheque Specifics (Clearing transactions + PDC - Returned)
        if ($this->db->table_exists('geopos_cheques')) {
            // Income Cheques (Receivables)
            $this->db->select('status, SUM(amount) as total');
            $this->db->from('geopos_cheques');
            $this->db->where('LOWER(type)', 'incoming');
            if ($branch_id > 0) $this->db->where('branch_id', $branch_id);
            if ($start_date && $end_date) {
                $this->db->where('DATE(issue_date) >=', $start_date);
                $this->db->where('DATE(issue_date) <=', $end_date);
            }
            $this->db->group_by('status');
            $query = $this->db->get();
            $cheque_income_query = $query ? $query->result_array() : array();

            // Expense Cheques (Payables)
            $this->db->select('status, SUM(amount) as total');
            $this->db->from('geopos_cheques');
            $this->db->where('LOWER(type)', 'outgoing');
            if ($branch_id > 0) $this->db->where('branch_id', $branch_id);
            if ($start_date && $end_date) {
                $this->db->where('DATE(issue_date) >=', $start_date);
                $this->db->where('DATE(issue_date) <=', $end_date);
            }
            $this->db->group_by('status');
            $query = $this->db->get();
            $cheque_expense_query = $query ? $query->result_array() : array();

            // Process Cheque Income with Bounce Deduction
            foreach ($cheque_income_query as $row) {
                $s = strtolower($row['status']);
                if (in_array($s, array('pdc', 'cleared', 'issued', 'pending'))) {
                    $metrics['income']['Cheque'] += (float)$row['total'];
                    $metrics['income']['Total'] += (float)$row['total'];
                } elseif (in_array($s, array('returned', 'bounced'))) {
                    // Bounce Deduction
                    $metrics['income']['Cheque'] -= (float)$row['total'];
                    $metrics['income']['Total'] -= (float)$row['total'];
                }
            }

            // Process Cheque Expense with Bounce Deduction
            foreach ($cheque_expense_query as $row) {
                 $s = strtolower($row['status']);
                 if (in_array($s, array('pdc', 'cleared', 'issued', 'pending'))) {
                    $metrics['expense']['Cheque'] += (float)$row['total'];
                    $metrics['expense']['Total'] += (float)$row['total'];
                } elseif (in_array($s, array('returned', 'bounced'))) {
                    // Bounce Deduction
                    $metrics['expense']['Cheque'] -= (float)$row['total'];
                    $metrics['expense']['Total'] -= (float)$row['total'];
                }
            }
        }

        // Process Standard Income
        foreach ($income_query as $row) {
            $method = $this->_map_payment_method($row['method']);
            if (isset($metrics['income'][$method])) {
                $metrics['income'][$method] += $row['total'];
                $metrics['income']['Total'] += $row['total'];
            } else {
                $metrics['income']['Bank'] += $row['total'];
                $metrics['income']['Total'] += $row['total'];
            }
        }

        // Process Standard Expense
        foreach ($expense_query as $row) {
            $method = $this->_map_payment_method($row['method']);
            if (isset($metrics['expense'][$method])) {
                $metrics['expense'][$method] += $row['total'];
                $metrics['expense']['Total'] += $row['total'];
            } else {
                $metrics['expense']['Bank'] += $row['total'];
                $metrics['expense']['Total'] += $row['total'];
            }
        }

        return $metrics;
    }

    private function _map_payment_method($method)
    {
        $method = strtolower($method);
        if (strpos($method, 'cash') !== false) return 'Cash';
        if (strpos($method, 'cheque') !== false || strpos($method, 'check') !== false) return 'Cheque';
        // Everything else (Card, Bank Transfer, Online) usually goes to 'Bank'
        return 'Bank';
    }

    public function get_cheque_status($branch_id = 0)
    {
        $stats = array(
            'pdc_in' => 0,
            'pdc_out' => 0,
            'cleared' => 0,
            'returned' => 0,
            'pending_receivable' => 0,
            'pending_payable' => 0,
            'returned_count' => 0
        );

        if (!$this->db->table_exists('geopos_cheques')) return $stats;

        // 1. Pending Receivables (PDC In)
        $this->db->select_sum('amount');
        $this->db->from('geopos_cheques');
        $this->db->where('LOWER(type)', 'incoming');
        $this->db->where_in('LOWER(status)', array('pdc', 'pending'));
        if ($branch_id > 0) $this->db->where('branch_id', $branch_id);
        $query = $this->db->get();
        if ($query && $row = $query->row()) {
            $stats['pdc_in'] = $row->amount ?: 0;
            $stats['pending_receivable'] = $stats['pdc_in'];
        }

        // 2. Pending Payables (PDC Out)
        $this->db->select_sum('amount');
        $this->db->from('geopos_cheques');
        $this->db->where('LOWER(type)', 'outgoing');
        $this->db->where_in('LOWER(status)', array('pdc', 'pending'));
        if ($branch_id > 0) $this->db->where('branch_id', $branch_id);
        $query = $this->db->get();
        if ($query && $row = $query->row()) {
            $stats['pdc_out'] = $row->amount ?: 0;
            $stats['pending_payable'] = $stats['pdc_out'];
        }

        // 3. Total Cleared (Count)
        $this->db->where('LOWER(status)', 'cleared');
        if ($branch_id > 0) $this->db->where('branch_id', $branch_id);
        $stats['cleared'] = $this->db->count_all_results('geopos_cheques');

        // 4. Total Returned/Bounced (Count)
        $this->db->where_in('LOWER(status)', array('returned', 'bounced'));
        if ($branch_id > 0) $this->db->where('branch_id', $branch_id);
        $stats['returned'] = $this->db->count_all_results('geopos_cheques');
        $stats['returned_count'] = $stats['returned'];

        return $stats;
    }
    
    /**
     * Generate daily business insights logic
     */
    public function generate_daily_insights()
    {
        $today = date('Y-m-d');
        
        // Check if insights already generated for today
        $this->db->where('DATE(created_at)', $today);
        $count = $this->db->count_all_results('geopos_system_insights');
        if ($count > 0) return true; // Already generated
        
        // 1. Sales Trend Analysis (Last 7 days vs Previous 7 days)
        $date_start_current = date('Y-m-d', strtotime('-7 days'));
        $date_end_current = $today;
        $date_start_prev = date('Y-m-d', strtotime('-14 days'));
        $date_end_prev = date('Y-m-d', strtotime('-7 days'));
        
        // Current period sales
        $this->db->select_sum('total');
        $this->db->from('geopos_invoices');
        $this->db->where('invoicedate >=', $date_start_current);
        $this->db->where('invoicedate <=', $date_end_current);
        $curr_sales = $this->db->get()->row()->total ?? 0;
        
        // Previous period sales
        $this->db->select_sum('total');
        $this->db->from('geopos_invoices');
        $this->db->where('invoicedate >=', $date_start_prev);
        $this->db->where('invoicedate <=', $date_end_prev);
        $prev_sales = $this->db->get()->row()->total ?? 0;
        
        if ($prev_sales > 0) {
            $growth = (($curr_sales - $prev_sales) / $prev_sales) * 100;
            if ($growth > 10) {
                $this->_add_insight('sales_trend', 'Sales increased by ' . number_format($growth, 1) . '% compared to last week.', 'low');
            } elseif ($growth < -10) {
                $this->_add_insight('sales_trend', 'Sales dropped by ' . number_format(abs($growth), 1) . '% compared to last week.', 'medium');
            }
        }
        
        // 2. Profit Margin Alert
        $this->load->model('dashboard_model');
        $profit = $this->dashboard_model->todayProfit($today);
        $sales = $this->dashboard_model->todaySales($today);
        $margin = ($sales > 0) ? ($profit / $sales) * 100 : 0;
        
        if ($sales > 5000 && $margin < 10) {
             $this->_add_insight('profit_margin', 'Low profit margin detected today (' . number_format($margin, 1) . '%). Check expense ratios.', 'high');
        }
        
        // 3. Low Stock Alert
        $this->db->where('qty < alert');
        $low_stock_count = $this->db->count_all_results('geopos_products');
        
        if ($low_stock_count > 5) {
            $this->_add_insight('inventory', "There are $low_stock_count items running low on stock. Restock advised.", 'medium');
        }
        
        // 4. Staff Performance Insight
        $top_staff = $this->get_top_staff_trust(1);
        if (!empty($top_staff) && $top_staff[0]['trust_score'] > 95) {
             $this->_add_insight('staff', 'Staff member ' . $top_staff[0]['username'] . ' is performing exceptionally well (Trust Score: ' . number_format($top_staff[0]['trust_score'], 1) . ').', 'low');
        }
        
        return true;
    }
    
    // Helper to add insight
    private function _add_insight($type, $message, $priority)
    {
        $data = array(
            'insight_type' => $type,
            'message' => $message,
            'priority' => $priority,
            'created_at' => date('Y-m-d H:i:s')
        );
        $this->db->insert('geopos_system_insights', $data);
    }
    
    /**
     * Get recent business insights
     */
    /**
     * Get recent business insights
     */
    public function get_recent_insights($limit = 5)
    {
        $this->db->select('*');
        $this->db->from('geopos_system_insights');
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query ? $query->result_array() : array();
    }
    
    /**
     * Get dead stock analysis
     * Dead stock = products with no movement in last 90 days
     */
    public function get_dead_stock($branch_id = 0, $days_threshold = 30)
    {
        $cutoff_date = date('Y-m-d', strtotime("-{$days_threshold} days"));
        
        // Get products with their last sale date
        $query = "
            SELECT 
                p.id,
                p.product_name,
                p.product_code,
                p.qty,
                p.price,
                p.warehouse,
                w.title as warehouse_name,
                MAX(ii.invoicedate) as last_sale_date,
                DATEDIFF(NOW(), MAX(ii.invoicedate)) as days_since_sale,
                (p.qty * p.price) as dead_stock_value
            FROM geopos_products p
            LEFT JOIN geopos_warehouse w ON p.warehouse = w.id
            LEFT JOIN geopos_invoice_items i ON p.id = i.product
            LEFT JOIN geopos_invoices ii ON i.tid = ii.id
        ";
        
        $where = " WHERE p.qty > 0 ";
        
        if ($branch_id > 0) {
            $where .= " AND w.loc = {$branch_id} ";
        } elseif (!BDATA) {
            $where .= " AND w.loc = 0 ";
        }
        
        $query .= $where;
        $query .= " GROUP BY p.id ";
        $query .= " HAVING (last_sale_date IS NULL OR last_sale_date < '{$cutoff_date}') ";
        $query .= " ORDER BY dead_stock_value DESC ";
        
        $result = $this->db->query($query);
        return $result ? $result->result_array() : array();
    }
    
    /**
     * Get slow moving stock
     * Slow moving = products with sales frequency below average
     */
    public function get_slow_moving_stock($branch_id = 0, $days_threshold = 30)
    {
        $cutoff_date = date('Y-m-d', strtotime("-{$days_threshold} days"));
        
        $query = "
            SELECT 
                p.id,
                p.product_name,
                p.product_code,
                p.qty,
                p.price,
                COUNT(DISTINCT ii.id) as sales_count,
                DATEDIFF(NOW(), MAX(ii.invoicedate)) as days_since_sale,
                (p.qty * p.price) as stock_value
            FROM geopos_products p
            LEFT JOIN geopos_warehouse w ON p.warehouse = w.id
            LEFT JOIN geopos_invoice_items i ON p.id = i.product
            LEFT JOIN geopos_invoices ii ON i.tid = ii.id AND ii.invoicedate >= '{$cutoff_date}'
        ";
        
        $where = " WHERE p.qty > 0 ";
        
        if ($branch_id > 0) {
            $where .= " AND w.loc = {$branch_id} ";
        } elseif (!BDATA) {
            $where .= " AND w.loc = 0 ";
        }
        
        $query .= $where;
        $query .= " GROUP BY p.id ";
        $query .= " HAVING sales_count < 2 "; // Less than 2 sales in the period
        $query .= " ORDER BY sales_count ASC, stock_value DESC ";
        
        $result = $this->db->query($query);
        return $result ? $result->result_array() : array();
    }
    
    /**
     * Get dead stock summary statistics
     */
    public function get_dead_stock_summary($branch_id = 0)
    {
        $dead_stock = $this->get_dead_stock($branch_id);
        $slow_moving = $this->get_slow_moving_stock($branch_id);
        
        $dead_stock_value = 0;
        foreach ($dead_stock as $item) {
            $dead_stock_value += $item['dead_stock_value'];
        }
        
        $slow_moving_value = 0;
        foreach ($slow_moving as $item) {
            $slow_moving_value += $item['stock_value'];
        }
        
        return array(
            'dead_stock_count' => count($dead_stock),
            'dead_stock_value' => $dead_stock_value,
            'slow_moving_count' => count($slow_moving),
            'slow_moving_value' => $slow_moving_value,
            'total_risk_value' => $dead_stock_value + $slow_moving_value
        );
    }
    
    /**
     * Get fast-moving stock
     * Fast-moving = products with high sales frequency (10+ sales in last 30 days)
     */
    public function get_fast_moving_stock($branch_id = 0, $days_threshold = 30, $min_sales = 5)
    {
        $cutoff_date = date('Y-m-d', strtotime("-{$days_threshold} days"));
        
        $query = "
            SELECT 
                p.id,
                p.product_name,
                p.product_code,
                p.qty,
                p.price,
                p.alert as reorder_point,
                COUNT(DISTINCT ii.id) as sales_count,
                SUM(i.qty) as total_qty_sold,
                AVG(i.qty) as avg_qty_per_sale,
                MAX(ii.invoicedate) as last_sale_date,
                DATEDIFF(NOW(), MAX(ii.invoicedate)) as days_since_sale,
                (p.qty * p.price) as stock_value
            FROM geopos_products p
            LEFT JOIN geopos_warehouse w ON p.warehouse = w.id
            LEFT JOIN geopos_invoice_items i ON p.id = i.product
            LEFT JOIN geopos_invoices ii ON i.tid = ii.id AND ii.invoicedate >= '{$cutoff_date}'
        ";
        
        $where = " WHERE 1=1 ";
        
        if ($branch_id > 0) {
            $where .= " AND w.loc = {$branch_id} ";
        } elseif (!BDATA) {
            $where .= " AND w.loc = 0 ";
        }
        
        $query .= $where;
        $query .= " GROUP BY p.id ";
        $query .= " HAVING sales_count >= {$min_sales} "; // 10+ sales in the period
        $query .= " ORDER BY sales_count DESC, total_qty_sold DESC ";
        
        $result = $this->db->query($query);
        return $result ? $result->result_array() : array();
    }
    
    /**
     * Get fast-moving stock summary statistics
     */
    public function get_fast_moving_summary($branch_id = 0)
    {
        $fast_moving = $this->get_fast_moving_stock($branch_id);
        
        $fast_moving_value = 0;
        $total_sales = 0;
        
        foreach ($fast_moving as $item) {
            $fast_moving_value += $item['stock_value'];
            $total_sales += $item['sales_count'];
        }
        
        return array(
            'fast_moving_count' => count($fast_moving),
            'fast_moving_value' => $fast_moving_value,
            'total_sales' => $total_sales,
            'avg_sales_per_product' => count($fast_moving) > 0 ? $total_sales / count($fast_moving) : 0
        );
    }

    /**
     * Get sample data for Demo Mode
     */
    public function get_sample_data($type, $branch_id = 0)
    {
        if ($type == 'dead') {
            return array(
                array(
                    'id' => 101, 'product_name' => 'Premium Office Desk (DEMO)', 'product_code' => 'D001', 'qty' => 5, 
                    'price' => 25000, 'warehouse_name' => 'Main Warehouse', 'last_sale_date' => date('Y-m-d', strtotime('-120 days')), 
                    'days_since_sale' => 120, 'dead_stock_value' => 125000
                ),
                array(
                    'id' => 102, 'product_name' => 'Ergonomic Chair - Black (DEMO)', 'product_code' => 'C005', 'qty' => 12, 
                    'price' => 8500, 'warehouse_name' => 'Main Warehouse', 'last_sale_date' => date('Y-m-d', strtotime('-95 days')), 
                    'days_since_sale' => 95, 'dead_stock_value' => 102000
                )
            );
        } elseif ($type == 'slow') {
            return array(
                array(
                    'id' => 103, 'product_name' => 'Designer Coffee Table (DEMO)', 'product_code' => 'T003', 'qty' => 8, 
                    'price' => 15000, 'sales_count' => 1, 'days_since_sale' => 45, 'stock_value' => 120000
                ),
                array(
                    'id' => 104, 'product_name' => 'LED Table Lamp - Silver (DEMO)', 'product_code' => 'L009', 'qty' => 15, 
                    'price' => 3500, 'sales_count' => 0, 'days_since_sale' => 60, 'stock_value' => 52500
                )
            );
        } elseif ($type == 'fast') {
            return array(
                array(
                    'id' => 105, 'product_name' => 'Solid Teak Wood Plank (DEMO)', 'product_code' => 'W-TEAK-S', 'qty' => 4, 
                    'price' => 12000, 'reorder_point' => 10, 'sales_count' => 45, 'total_qty_sold' => 180, 
                    'avg_qty_per_sale' => 4.0, 'last_sale_date' => date('Y-m-d'), 'days_since_sale' => 0, 'stock_value' => 48000
                ),
                array(
                    'id' => 106, 'product_name' => 'Stainless Steel Hinge - 4 inch (DEMO)', 'product_code' => 'H-SS4', 'qty' => 85, 
                    'price' => 450, 'reorder_point' => 50, 'sales_count' => 32, 'total_qty_sold' => 450, 
                    'avg_qty_per_sale' => 14.0, 'last_sale_date' => date('Y-m-d', strtotime('-1 days')), 'days_since_sale' => 1, 'stock_value' => 38250
                ),
                array(
                    'id' => 107, 'product_name' => 'Universal Wood Glue - 1kg (DEMO)', 'product_code' => 'G-UNIV1', 'qty' => 12, 
                    'price' => 1250, 'reorder_point' => 20, 'sales_count' => 28, 'total_qty_sold' => 42, 
                    'avg_qty_per_sale' => 1.5, 'last_sale_date' => date('Y-m-d'), 'days_since_sale' => 0, 'stock_value' => 15000
                )
            );
        }
        return array();
    }
}
