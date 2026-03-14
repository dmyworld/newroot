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
            $sales_query = $this->db->get();
            $sales_data = ($sales_query && $sales_query->num_rows() > 0) ? $sales_query->row() : null;
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
            $return_count = $this->db->count_all_results();
            
            // 4. Error Count (billing errors - proxy via canceled)
            $error_count = $void_count; // Same as void for now
            
            // FORMULA: 100 - (voids*3 + returns*2 + errors*5)
            $penalty = ($void_count * 3) + ($return_count * 2) + ($error_count * 1);
            $trust_score = 100 - $penalty;
            if ($trust_score < 0) $trust_score = 0;
            
            // Delete existing score for this staff on this date
            $this->db->where('staff_id', $sid);
            $this->db->where('date', $date);
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
                'date' => $date
            );
            
            $this->db->insert('geopos_staff_scores', $data);
        }
    }
    
    public function generate_business_health_index()
    {
        $date = date('Y-m-d');
        $sales = $this->get_aggregated_sales($date);
        
        $sales_score = ($sales > 10000) ? 100 : (($sales / 10000) * 100);
        if($sales_score < 0) $sales_score = 0;
        
        $daily_profit = $this->get_aggregated_profit($date);
        $profit_score = ($daily_profit > 5000) ? 100 : (($daily_profit / 5000) * 100);
        if($profit_score < 0) $profit_score = 0;

        $cash = $this->get_aggregated_cash($date);
        $cash_score = ($cash > 2000) ? 100 : (($cash / 2000) * 100);
        if($cash_score < 0) $cash_score = 0;

        $staff_score = $this->get_avg_staff_trust();

        $health_index = ($sales_score * 0.25) + ($profit_score * 0.35) + ($cash_score * 0.20) + ($staff_score * 0.20);
        $health_rounded = round($health_index);
        
        $this->db->where('date', $date);
        $this->db->where('branch_id', 0); 
        $this->db->delete('geopos_business_health');
        
        $data = array(
            'date' => $date,
            'branch_id' => 0,
            'health_index' => $health_rounded,
            'sales_score' => round($sales_score),
            'profit_score' => round($profit_score),
            'cashflow_score' => round($cash_score),
            'staff_score' => round($staff_score)
        );
        $this->db->insert('geopos_business_health', $data);
        return $health_rounded;
    }

    public function get_business_health($branch_id = 0)
    {
        if ($branch_id == 0) {
            $this->db->select('health_index');
            $this->db->where('date', date('Y-m-d'));
            $this->db->where('branch_id', 0); 
            $this->db->order_by('created_at', 'DESC');
            $this->db->limit(1);
            $query = $this->db->get('geopos_business_health');
            if (!$query) return 85; 
            $result = $query->row();
            return $result ? $result->health_index : 85; 
        } else {
            $date = date('Y-m-d');
            $sales = $this->get_aggregated_sales($date, $branch_id);
            $sales_score = ($sales > 10000) ? 100 : (($sales / 10000) * 100);
            $profit = $this->get_aggregated_profit($date, $branch_id);
            $profit_score = ($profit > 5000) ? 100 : (($profit / 5000) * 100);
            $cash = $this->get_aggregated_cash($date, $branch_id);
            $cash_score = ($cash > 2000) ? 100 : (($cash / 2000) * 100);
            $staff_score = $this->get_avg_staff_trust($branch_id);
            $health_index = ($sales_score * 0.25) + ($profit_score * 0.35) + ($cash_score * 0.20) + ($staff_score * 0.20);
            return round($health_index);
        }
    }

    public function get_avg_staff_trust($branch_id = 0)
    {
        $this->db->select_avg('trust_score');
        $this->db->where('date', date('Y-m-d'));
        if ($branch_id > 0) $this->db->where('branch_id', $branch_id);
        $query = $this->db->get('geopos_staff_scores');
        if (!$query) return 100;
        $result = $query->row();
        $score = $result ? $result->trust_score : null;
        return $score ? round($score) : 100;
    }

    public function get_aggregated_sales($date, $branch_id = 0)
    {
        $this->db->select_sum('total');
        $this->db->from('geopos_invoices');
        $this->db->where('DATE(invoicedate)', $date);
        if ($branch_id > 0) $this->db->where('loc', $branch_id);

        // Business Isolation
        if (isset($this->aauth->get_user()->business_id) && $this->aauth->get_user()->business_id > 0) {
            $this->db->where('business_id', $this->aauth->get_user()->business_id);
        }
        $query = $this->db->get();
        if (!$query) return 0.00;
        $result = $query->row();
        return $result && isset($result->total) ? $result->total : 0.00;
    }

    public function get_aggregated_profit($date, $branch_id = 0)
    {
        $this->db->select_sum('geopos_metadata.col1');
        $this->db->from('geopos_metadata');
        $this->db->join('geopos_invoices', 'geopos_metadata.rid=geopos_invoices.id', 'left');
        $this->db->where('geopos_metadata.type', 9);
        $this->db->where('DATE(geopos_metadata.d_date)', $date);
        if ($branch_id > 0) $this->db->where('geopos_invoices.loc', $branch_id);

        // Business Isolation
        if (isset($this->aauth->get_user()->business_id) && $this->aauth->get_user()->business_id > 0) {
            $this->db->where('geopos_invoices.business_id', $this->aauth->get_user()->business_id);
        }
        $query = $this->db->get();
        if (!$query) return 0.00;
        $result = $query->row();
        return $result && isset($result->col1) ? $result->col1 : 0.00;
    }

    public function get_aggregated_cash($date, $branch_id = 0)
    {
       $this->db->select_sum('credit');
       $this->db->select_sum('debit');
       $this->db->from('geopos_transactions');
       $this->db->where('DATE(date)', $date);
       if ($branch_id > 0) $this->db->where('loc', $branch_id);
       $query = $this->db->get();
       if (!$query) return 0.00;
       $result = $query->row();
       $income = $result && isset($result->credit) ? $result->credit : 0.00;
       $expense = $result && isset($result->debit) ? $result->debit : 0.00;
       return ($income - $expense);
    }

    public function get_top_staff_trust($limit = 5, $branch_id = 0)
    {
        $this->db->select('geopos_staff_scores.*, geopos_users.username, geopos_users.id as user_id');
        $this->db->from('geopos_staff_scores');
        $this->db->join('geopos_users', 'geopos_staff_scores.staff_id = geopos_users.id');
        $this->db->where('geopos_staff_scores.date', date('Y-m-d'));
        if ($branch_id > 0) $this->db->where('geopos_staff_scores.branch_id', $branch_id);
        $this->db->order_by('trust_score', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        $staff_list = $query ? $query->result_array() : array();
        
        foreach ($staff_list as &$staff) {
            $staff_id = $staff['staff_id'];
            $this->db->select_sum('total');
            $this->db->from('geopos_invoices');
            $this->db->where('eid', $staff_id);
            $this->db->where('DATE(invoicedate) >=', date('Y-m-01'));
            $this->db->where('status !=', 'canceled');
            if ($branch_id > 0) $this->db->where('loc', $branch_id);
            $sales_query = $this->db->get();
            $sales_result = ($sales_query && $sales_query->num_rows() > 0) ? $sales_query->row() : null;
            $staff['sales'] = $sales_result->total ?? 0;
            
            $this->db->where('eid', $staff_id);
            $this->db->where('status', 'canceled');
            $this->db->where('DATE(invoicedate) >=', date('Y-m-01'));
            if ($branch_id > 0) $this->db->where('loc', $branch_id);
            $staff['errors'] = $this->db->count_all_results('geopos_invoices');
            $staff['returns'] = $staff['return_count'] ?? 0;

            $this->db->select('COUNT(*) as overrides');
            $this->db->from('geopos_invoice_items');
            $this->db->join('geopos_invoices', 'geopos_invoices.id = geopos_invoice_items.tid');
            $this->db->join('geopos_products', 'geopos_products.id = geopos_invoice_items.product');
            $this->db->where('geopos_invoices.eid', $staff_id);
            $this->db->where('geopos_invoice_items.subtotal / geopos_invoice_items.qty != geopos_products.product_price', NULL, FALSE);
            $this->db->where('date(geopos_invoices.invoicedate) >=', date('Y-m-01'));
            $q_overrides = $this->db->get();
            $staff['overrides'] = ($q_overrides && $q_overrides->num_rows() > 0) ? $q_overrides->row()->overrides : 0;
        }
        return $staff_list;
    }

    public function get_customer_due($branch_id = 0, $start_date = '', $end_date = '')
    {
        $this->db->select_sum('total');
        $this->db->select_sum('pamnt');
        $this->db->from('geopos_invoices');
        $this->db->group_start();
        $this->db->where_in('status', array('due', 'partial', 'Due', 'Partial'));
        $this->db->group_end();
        
        if ($branch_id > 0) {
            $this->db->where('loc', $branch_id);
        } elseif ($branch_id == -1) {
            // All
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }

        if ($end_date) $this->db->where('DATE(invoicedate) <=', $end_date);
        
        $query = $this->db->get();
        if (!$query) return 0.00;
        $result = $query->row();
        if (!$result) return 0.00;
        $total = isset($result->total) ? $result->total : 0.00;
        $paid = isset($result->pamnt) ? $result->pamnt : 0.00;
        return ($total - $paid);
    }

    public function get_supplier_due($branch_id = 0, $start_date = '', $end_date = '') 
    {
        $this->db->select_sum('total');
        $this->db->select_sum('pamnt');
        $this->db->from('geopos_purchase');
        $this->db->group_start();
        $this->db->where_in('status', array('due', 'partial', 'Due', 'Partial'));
        $this->db->group_end();

        if ($branch_id > 0) {
            $this->db->where('loc', $branch_id);
        } elseif ($branch_id == -1) {
            // All
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        if ($end_date) $this->db->where('DATE(invoicedate) <=', $end_date);
        $query = $this->db->get();
        $due_general = 0.00;
        if ($query && $result = $query->row()) {
            $due_general = ($result->total ?? 0) - ($result->pamnt ?? 0);
        }

        $this->db->select_sum('total');
        $this->db->select_sum('pamnt'); 
        $this->db->from('geopos_purchase_logs');
        $this->db->group_start();
        $this->db->where_in('status', array('due', 'partial', 'Due', 'Partial'));
        $this->db->group_end();
        if ($branch_id > 0) {
            $this->db->where('loc', $branch_id);
        } elseif ($branch_id == -1) {
            // All
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        if ($end_date) $this->db->where('DATE(invoicedate) <=', $end_date);
        $query_logs = $this->db->get();
        $due_logs = 0.00;
        if ($query_logs && $result_logs = $query_logs->row()) {
            $due_logs = ($result_logs->total ?? 0) - ($result_logs->pamnt ?? 0);
        }

        return ($due_general + $due_logs);
    }

    public function get_detailed_financial_metrics($branch_id = 0, $start_date = '', $end_date = '')
    {
        $metrics = array(
            'income' => array('Cash' => 0, 'Bank' => 0, 'Cheque' => 0, 'Total' => 0),
            'expense' => array('Cash' => 0, 'Bank' => 0, 'Cheque' => 0, 'Total' => 0)
        );

        // 1. Get Income Breakdown
        $this->db->select('t.method, SUM(t.credit) as total');
        $this->db->from('geopos_transactions t');
        $this->db->join('geopos_accounts a', 't.acid = a.id', 'left');
        $this->db->where('t.credit >', 0);
        $this->db->where('a.account_type', 'Income');
        
        if ($branch_id > 0) {
            $this->db->group_start();
            $this->db->where('t.loc', $branch_id);
            $this->db->or_where('a.loc', $branch_id);
            $this->db->group_end();
        } elseif ($branch_id == -1) {
            // All
        } else {
            $this->db->where('t.loc', 0);
        }

        if ($start_date && $end_date) {
            $this->db->where('DATE(t.date) >=', $start_date);
            $this->db->where('DATE(t.date) <=', $end_date);
        }
        $this->db->group_by('t.method');
        $query = $this->db->get();
        $income_query = $query ? $query->result_array() : array();

        // 2. Get Expense Breakdown
        $this->db->select('t.method, SUM(t.debit) as total');
        $this->db->from('geopos_transactions t');
        $this->db->join('geopos_accounts a', 't.acid = a.id', 'left');
        $this->db->where('t.debit >', 0);
        $this->db->where('a.account_type', 'Expenses');
        
        if ($branch_id > 0) {
            $this->db->group_start();
            $this->db->where('t.loc', $branch_id);
            $this->db->or_where('a.loc', $branch_id);
            $this->db->group_end();
        } elseif ($branch_id == -1) {
            // All
        } else {
            $this->db->where('t.loc', 0);
        }

        if ($start_date && $end_date) {
            $this->db->where('DATE(t.date) >=', $start_date);
            $this->db->where('DATE(t.date) <=', $end_date);
        }
        $this->db->group_by('t.method');
        $query = $this->db->get();
        $expense_query = $query ? $query->result_array() : array();

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
        return 'Bank';
    }

    public function get_cheque_status($branch_id = 0)
    {
        $stats = array('pdc_in' => 0, 'pdc_out' => 0, 'cleared' => 0, 'returned' => 0, 'pending_receivable' => 0, 'pending_payable' => 0, 'returned_count' => 0);
        if (!$this->db->table_exists('geopos_cheques')) return $stats;

        // Pending Receivables
        $this->db->select_sum('amount');
        $this->db->from('geopos_cheques');
        $this->db->where('LOWER(type)', 'incoming');
        $this->db->where_in('LOWER(status)', array('pdc', 'pending'));
        if ($branch_id > 0) $this->db->where('branch_id', $branch_id);
        elseif ($branch_id == 0 && !BDATA) $this->db->where('branch_id', 0);
        $query = $this->db->get();
        if ($query && $row = $query->row()) {
            $stats['pdc_in'] = $row->amount ?: 0;
            $stats['pending_receivable'] = $stats['pdc_in'];
        }

        // Pending Payables
        $this->db->select_sum('amount');
        $this->db->from('geopos_cheques');
        $this->db->where('LOWER(type)', 'outgoing');
        $this->db->where_in('LOWER(status)', array('pdc', 'pending'));
        if ($branch_id > 0) $this->db->where('branch_id', $branch_id);
        elseif ($branch_id == 0 && !BDATA) $this->db->where('branch_id', 0);
        $query = $this->db->get();
        if ($query && $row = $query->row()) {
            $stats['pdc_out'] = $row->amount ?: 0;
            $stats['pending_payable'] = $stats['pdc_out'];
        }

        // Cleared
        $this->db->where('LOWER(status)', 'cleared');
        if ($branch_id > 0) $this->db->where('branch_id', $branch_id);
        elseif ($branch_id == 0 && !BDATA) $this->db->where('branch_id', 0);
        $stats['cleared'] = $this->db->count_all_results('geopos_cheques');

        // Returned
        $this->db->where_in('LOWER(status)', array('returned', 'bounced'));
        if ($branch_id > 0) $this->db->where('branch_id', $branch_id);
        elseif ($branch_id == 0 && !BDATA) $this->db->where('branch_id', 0);
        $stats['returned'] = $this->db->count_all_results('geopos_cheques');
        $stats['returned_count'] = $stats['returned'];

        return $stats;
    }

    public function generate_daily_insights()
    {
        $today = date('Y-m-d');
        $this->db->where('DATE(created_at)', $today);
        if ($this->db->count_all_results('geopos_system_insights') > 0) return true;
        
        $curr_sales = $this->dashboard_model->rangeSales(date('Y-m-d', strtotime('-7 days')), $today);
        $prev_sales = $this->dashboard_model->rangeSales(date('Y-m-d', strtotime('-14 days')), date('Y-m-d', strtotime('-7 days')));
        
        if ($prev_sales > 0) {
            $growth = (($curr_sales - $prev_sales) / $prev_sales) * 100;
            if ($growth > 10) $this->_add_insight('sales_trend', 'Sales increased by ' . number_format($growth, 1) . '% compared to last week.', 'low');
            elseif ($growth < -10) $this->_add_insight('sales_trend', 'Sales dropped by ' . number_format(abs($growth), 1) . '% compared to last week.', 'medium');
        }
        
        $profit = $this->dashboard_model->todayProfit($today);
        $sales = $this->dashboard_model->todaySales($today);
        $margin = ($sales > 0) ? ($profit / $sales) * 100 : 0;
        if ($sales > 5000 && $margin < 10) $this->_add_insight('profit_margin', 'Low profit margin detected today (' . number_format($margin, 1) . '%). Check expense ratios.', 'high');
        
        $this->db->where('qty < alert');
        if ($this->db->count_all_results('geopos_products') > 5) $this->_add_insight('inventory', "Critical stock levels detected for multiple items.", 'medium');
        
        return true;
    }

    private function _add_insight($type, $message, $priority)
    {
        $this->db->insert('geopos_system_insights', array('insight_type' => $type, 'message' => $message, 'priority' => $priority, 'created_at' => date('Y-m-d H:i:s')));
    }

    public function get_recent_insights($limit = 5)
    {
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('geopos_system_insights');
        return $query ? $query->result_array() : array();
    }

    public function get_dead_stock($branch_id = 0, $days_threshold = 30)
    {
        $cutoff_date = date('Y-m-d', strtotime("-{$days_threshold} days"));
        $where = " WHERE p.qty > 0 " . ($branch_id > 0 ? " AND w.loc = {$branch_id} " : ($branch_id == 0 && !BDATA ? " AND w.loc = 0 " : ""));
        $query = "SELECT p.pid as id, p.product_name, p.product_code, p.qty, p.product_price, w.title as warehouse_name, MAX(ii.invoicedate) as last_sale_date, DATEDIFF(NOW(), MAX(ii.invoicedate)) as days_since_sale, (p.qty * p.product_price) as dead_stock_value FROM geopos_products p LEFT JOIN geopos_warehouse w ON p.warehouse = w.id LEFT JOIN geopos_invoice_items i ON p.pid = i.product LEFT JOIN geopos_invoices ii ON i.tid = ii.id $where GROUP BY p.pid HAVING (last_sale_date IS NULL OR last_sale_date < '{$cutoff_date}') ORDER BY dead_stock_value DESC";
        $result = $this->db->query($query);
        return $result ? $result->result_array() : array();
    }

    public function get_slow_moving_stock($branch_id = 0, $days_threshold = 30)
    {
        $cutoff_date = date('Y-m-d', strtotime("-{$days_threshold} days"));
        $where = " WHERE p.qty > 0 " . ($branch_id > 0 ? " AND w.loc = {$branch_id} " : ($branch_id == 0 && !BDATA ? " AND w.loc = 0 " : ""));
        $query = "SELECT p.pid as id, p.product_name, p.product_code, p.qty, p.product_price, COUNT(DISTINCT ii.id) as sales_count, DATEDIFF(NOW(), MAX(ii.invoicedate)) as days_since_sale, (p.qty * p.product_price) as stock_value FROM geopos_products p LEFT JOIN geopos_warehouse w ON p.warehouse = w.id LEFT JOIN geopos_invoice_items i ON p.pid = i.product LEFT JOIN geopos_invoices ii ON i.tid = ii.id AND ii.invoicedate >= '{$cutoff_date}' $where GROUP BY p.pid HAVING sales_count < 2 ORDER BY sales_count ASC, stock_value DESC";
        $result = $this->db->query($query);
        return $result ? $result->result_array() : array();
    }

    public function get_dead_stock_summary($branch_id = 0)
    {
        $dead = $this->get_dead_stock($branch_id); $slow = $this->get_slow_moving_stock($branch_id);
        $dv = 0; foreach($dead as $i) $dv += $i['dead_stock_value'];
        $sv = 0; foreach($slow as $i) $sv += $i['stock_value'];
        return array('dead_stock_count' => count($dead), 'dead_stock_value' => $dv, 'slow_moving_count' => count($slow), 'slow_moving_value' => $sv, 'total_risk_value' => $dv + $sv);
    }

    public function get_fast_moving_stock($branch_id = 0, $days_threshold = 30, $min_sales = 5)
    {
        $cutoff_date = date('Y-m-d', strtotime("-{$days_threshold} days"));
        $where = " WHERE 1=1 " . ($branch_id > 0 ? " AND w.loc = {$branch_id} " : ($branch_id == 0 && !BDATA ? " AND w.loc = 0 " : ""));
        $query = "SELECT p.pid as id, p.product_name, p.product_code, p.qty, p.product_price, p.alert as reorder_point, COUNT(DISTINCT ii.id) as sales_count, SUM(i.qty) as total_qty_sold, MAX(ii.invoicedate) as last_sale_date, (p.qty * p.product_price) as stock_value FROM geopos_products p LEFT JOIN geopos_warehouse w ON p.warehouse = w.id LEFT JOIN geopos_invoice_items i ON p.pid = i.product LEFT JOIN geopos_invoices ii ON i.tid = ii.id AND ii.invoicedate >= '{$cutoff_date}' $where GROUP BY p.pid HAVING sales_count >= {$min_sales} ORDER BY sales_count DESC";
        $result = $this->db->query($query);
        return $result ? $result->result_array() : array();
    }

    public function get_fast_moving_summary($branch_id = 0)
    {
        $fast = $this->get_fast_moving_stock($branch_id); $fv = 0; $ts = 0;
        foreach($fast as $i){ $fv += $i['stock_value']; $ts += $i['sales_count']; }
        return array('fast_moving_count' => count($fast), 'fast_moving_value' => $fv, 'total_sales' => $ts, 'avg_sales_per_product' => count($fast) > 0 ? $ts / count($fast) : 0);
    }

    public function get_inventory_valuation($branch_id = 0)
    {
        $this->db->select('SUM(qty * product_price) as retail_value, SUM(qty * fproduct_price) as wholesale_value, SUM(qty * fproduct_cost) as cost_value', FALSE);
        $this->db->from('geopos_products p');
        $this->db->join('geopos_warehouse w', 'p.warehouse = w.id', 'left');
        if ($branch_id > 0) $this->db->where('w.loc', $branch_id);
        elseif ($branch_id == 0 && !BDATA) $this->db->where('w.loc', 0);
        return $this->db->get()->row_array() ?: array('retail_value' => 0, 'wholesale_value' => 0, 'cost_value' => 0);
    }

    public function get_payroll_intel($branch_id = 0)
    {
        $current_month_start = date('Y-m-01');
        $current_month_end = date('Y-m-t');
        $this->db->select('SUM(i.gross_pay) as monthly_gross');
        $this->db->from('geopos_payroll_items i');
        $this->db->join('geopos_payroll_runs r', 'i.run_id = r.id', 'left');
        $this->db->where('r.start_date >=', $current_month_start);
        $this->db->where('r.start_date <=', $current_month_end);
        if ($branch_id > 0) {
            $this->db->join('geopos_employees e', 'i.employee_id = e.id', 'left');
            $this->db->join('geopos_users u', 'e.id = u.id', 'left');
            $this->db->where('u.loc', $branch_id);
        }
        $query = $this->db->get();
        $payroll_total = ($query && $query->num_rows() > 0) ? ($query->row()->monthly_gross ?? 0) : 0;

        $this->db->from('geopos_payroll_runs');
        $this->db->where_in('status', ['Draft', 'Pending']);
        if ($branch_id > 0) {
              if ($this->db->field_exists('loc', 'geopos_payroll_runs')) $this->db->where('loc', $branch_id);
        }
        $pending_approvals = $this->db->count_all_results();

        $this->db->select('e.dept, SUM(i.gross_pay) as total_gross');
        $this->db->from('geopos_payroll_items i');
        $this->db->join('geopos_payroll_runs r', 'i.run_id = r.id', 'left');
        $this->db->join('geopos_employees e', 'i.employee_id = e.id', 'left');
        $this->db->where('r.start_date >=', $current_month_start);
        $this->db->where('r.start_date <=', $current_month_end);
        if ($branch_id > 0) {
            $this->db->join('geopos_users u', 'e.id = u.id', 'left');
            $this->db->where('u.loc', $branch_id);
        }
        $this->db->group_by('e.dept');
        $this->db->order_by('total_gross', 'DESC');
        $this->db->limit(3);
        $query = $this->db->get();
        $dept_dist_raw = ($query) ? $query->result_array() : array();
        $dept_dist = array();
        foreach($dept_dist_raw as $row) {
             $dept_dist[] = array('dept' => $this->get_dept_name($row['dept']), 'total_gross' => $row['total_gross']);
        }
        return array('monthly_gross' => $payroll_total, 'pending_approvals' => $pending_approvals, 'dept_distribution' => $dept_dist);
    }



    public function get_dept_name($dept_id)
    {
        if (empty($dept_id)) return "General";
        $this->db->select('val1');
        $this->db->from('geopos_hrm');
        $this->db->where('id', $dept_id);
        $this->db->where('typ', 1);
        $query = $this->db->get();
        return ($query && $query->num_rows() > 0) ? $query->row()->val1 : "Dept #" . $dept_id;
    }

    public function get_detailed_financial_position($branch_id = 0)
    {
        $assets = $this->_get_balance_by_type('Assets', $branch_id);
        $liabilities = $this->_get_balance_by_type('Liabilities', $branch_id);
        $equity = $this->_get_balance_by_type('Equity', $branch_id);
        return array('assets' => $assets, 'liabilities' => $liabilities, 'equity' => $equity);
    }
    
    public function _get_balance_by_type($type, $branch_id, $holder_match = '')
    {
         if ($branch_id === 0) $branch_id = -1;
         $this->db->select_sum('lastbal');
         $this->db->from('geopos_accounts');
         $this->db->where('account_type', $type);
         if ($holder_match) {
             $this->db->group_start();
             $this->db->like('holder', $holder_match, 'both');
             if ($holder_match == 'Cash') $this->db->or_like('holder', 'Petty Cash', 'both');
             $this->db->group_end();
         }
         if ($branch_id > 0) {
             $this->db->group_start();
             $this->db->where('loc', $branch_id);
             $this->db->or_where('loc', 0);
             $this->db->group_end();
         } elseif ($branch_id == -1) { }
         else { $this->db->where('loc', 0); }
         
         $query = $this->db->get();
         $result = $query->row();
         $bal = ($result && isset($result->lastbal)) ? (float)$result->lastbal : 0.00;
         
         if ($type == 'Assets' || $type == 'Expenses') return -1 * $bal;
         return $bal;
    }

    public function get_recent_journal_entries($branch_id = 0, $limit = 10)
    {
        $this->db->select('geopos_transactions.*, geopos_accounts.acn as account_number, geopos_accounts.holder as account_name');
        $this->db->from('geopos_transactions');
        $this->db->join('geopos_accounts', 'geopos_transactions.acid = geopos_accounts.id', 'left');
        if ($branch_id > 0) {
            $this->db->group_start();
            $this->db->where('geopos_transactions.loc', $branch_id);
            $this->db->or_where('geopos_transactions.loc', 0);
            $this->db->or_where('geopos_accounts.loc', $branch_id); 
            $this->db->group_end();
        } elseif ($branch_id == -1) { }
        else { $this->db->where('geopos_transactions.loc', 0); }
        $this->db->order_by('geopos_transactions.id', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array() ?: array();
    }

    public function get_strategic_indicators($branch_id = 0, $start_date = '', $end_date = '')
    {
        $this->load->model('dashboard_model');
        $total_sales = $this->dashboard_model->rangeSales($start_date, $end_date, $branch_id == 0 ? -1 : $branch_id);
        $profit = $this->get_dual_entry_profit($branch_id, $start_date, $end_date);
        $fin_pos = $this->get_detailed_financial_position($branch_id);
        
        $this->db->where('DATE(invoicedate) >=', $start_date); $this->db->where('DATE(invoicedate) <=', $end_date);
        if ($branch_id > 0) $this->db->where('loc', $branch_id);
        $invoice_count = $this->db->count_all_results('geopos_invoices');

        return array(
            'net_profit_margin' => ($total_sales > 0) ? ($profit / $total_sales) * 100 : 0,
            'current_ratio' => ($fin_pos['liabilities'] > 0) ? ($fin_pos['assets'] / $fin_pos['liabilities']) : ($fin_pos['assets'] > 0 ? 10.0 : 0),
            'roe' => ($fin_pos['equity'] > 0) ? ($profit / $fin_pos['equity']) * 100 : ($profit > 0 ? 100.0 : 0),
            'debt_to_equity' => ($fin_pos['equity'] > 0) ? ($fin_pos['liabilities'] / $fin_pos['equity']) : ($fin_pos['liabilities'] > 0 ? 1.0 : 0),
            'avg_order_value' => ($invoice_count > 0) ? ($total_sales / $invoice_count) : 0
        );
    }

    public function get_dual_entry_profit($branch_id = 0, $start_date = '', $end_date = '')
    {
        // Net Profit = Total Income - Total Expenses (from transactions based on Account Type)
        
        $this->db->select_sum('t.credit');
        $this->db->from('geopos_transactions t');
        $this->db->join('geopos_accounts a', 't.acid = a.id', 'left');
        $this->db->where('a.account_type', 'Income');
        if ($branch_id > 0) $this->db->where('t.loc', $branch_id);
        elseif ($branch_id == 0 && !BDATA) $this->db->where('t.loc', 0);
        if ($start_date) $this->db->where('DATE(t.date) >=', $start_date);
        if ($end_date) $this->db->where('DATE(t.date) <=', $end_date);
        
        $query_in = $this->db->get();
        $income = ($query_in && $row = $query_in->row()) ? floatval($row->credit) : 0.00;

        $this->db->select_sum('t.debit');
        $this->db->from('geopos_transactions t');
        $this->db->join('geopos_accounts a', 't.acid = a.id', 'left');
        $this->db->where('a.account_type', 'Expenses');
        if ($branch_id > 0) $this->db->where('t.loc', $branch_id);
        elseif ($branch_id == 0 && !BDATA) $this->db->where('t.loc', 0);
        if ($start_date) $this->db->where('DATE(t.date) >=', $start_date);
        if ($end_date) $this->db->where('DATE(t.date) <=', $end_date);
        
        $query_out = $this->db->get();
        $expense = ($query_out && $row = $query_out->row()) ? floatval($row->debit) : 0.00;

        return ($income - $expense);
    }

    public function get_total_cash_in_hand($branch_id = 0) { return $this->_get_balance_by_type('Assets', $branch_id, 'Cash'); }
    public function get_total_bank_balance($branch_id = 0) { return $this->_get_balance_by_type('Assets', $branch_id, 'Bank'); }
    public function get_total_receivables($branch_id = 0) { return $this->get_customer_due($branch_id, '', date('Y-m-d')); }
    public function get_total_payables($branch_id = 0) { return $this->get_supplier_due($branch_id, '', date('Y-m-d')); }
    public function get_today_total_sales($branch_id = 0) { return $this->get_aggregated_sales(date('Y-m-d'), $branch_id); }

    public function get_bundle_suggestions($product_ids = [])
    {
        if (empty($product_ids)) return [];

        $suggestions = [];
        
        // 1. Fetch product categories/names for bundling logic
        $this->db->select('pid, product_name, pcat');
        $this->db->from('geopos_products');
        $this->db->where_in('pid', $product_ids);
        $products = $this->db->get()->result_array();

        foreach ($products as $p) {
            $name = strtolower($p['product_name']);
            $cat  = $p['pcat'];

            // Logic rules
            // Timber bundling
            if (strpos($name, 'timber') !== false || strpos($name, 'log') !== false || strpos($name, 'wood') !== false) {
                $suggestions[] = ['type' => 'service', 'category' => 'Transport', 'reason' => 'Need delivery for your timber?'];
                $suggestions[] = ['type' => 'service', 'category' => 'Sawing', 'reason' => 'Professional sawing available.'];
            }

            // Construction bundling
            if (strpos($name, 'cement') !== false || strpos($name, 'brick') !== false) {
                $suggestions[] = ['type' => 'service', 'category' => 'Masonry', 'reason' => 'Hire a skilled mason for your project.'];
            }

            // Finishings
            if (strpos($name, 'paint') !== false) {
                $suggestions[] = ['type' => 'service', 'category' => 'Painting', 'reason' => 'Find expert painters nearby.'];
            }
        }

        // Deduplicate and Fetch actual service providers or categories
        $unique_cats = array_unique(array_column($suggestions, 'category'));
        $final_suggestions = [];

        foreach ($unique_cats as $cat_name) {
            // Find first reason for this category
            $reason = '';
            foreach($suggestions as $s) if($s['category'] == $cat_name) { $reason = $s['reason']; break; }

            // Fetch top 2 providers in this category
            $this->db->select('id, name, rating, hourly_rate');
            $this->db->from('geopos_workers'); // Assuming a workers table exists from previous steps
            $this->db->where('category', $cat_name);
            $this->db->order_by('rating', 'DESC');
            $this->db->limit(2);
            $providers = $this->db->get()->result_array();

            if (!empty($providers)) {
                $final_suggestions[] = [
                    'category' => $cat_name,
                    'reason'   => $reason,
                    'providers'=> $providers
                ];
            }
        }

        return $final_suggestions;
    }
}
