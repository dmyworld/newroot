<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Enable error display for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

class OwnerDashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        
        if ($this->aauth->get_user()->roleid < 5) {
             exit('Authorization Failed');
        }

        $this->load->model('dashboard_model');
        $this->load->model('intelligence_model');
        $this->load->model('analytics_model');
        $this->load->model('risk_model');
        $this->load->model('loss_model');
    }

    public function index()
    {
        try {
            $head['title'] = 'Owner Intelligence Dashboard';
            $head['usernm'] = $this->aauth->get_user()->username;
            
            // Capture branch filter
            $branch_id = $this->input->get('branch_id');
            if (!isset($_GET['branch_id'])) { 
                 $branch_id = 0; 
            }
            
            // Capture date range from filters (with fallbacks)
            $start_date = $this->input->get('start_date') ?: date('Y-m-01'); // Default: first day of current month
            $end_date = $this->input->get('end_date') ?: date('Y-m-d');       // Default: today
            
            // Handle quick filters
            $quick_filter = $this->input->get('quick_filter');
            if ($quick_filter) {
                switch($quick_filter) {
                    case 'today':
                        $start_date = $end_date = date('Y-m-d');
                        break;
                    case 'yesterday':
                        $start_date = $end_date = date('Y-m-d', strtotime('-1 day'));
                        break;
                    case 'this_week':
                        $start_date = date('Y-m-d', strtotime('monday this week'));
                        $end_date = date('Y-m-d');
                        break;
                    case 'this_month':
                        $start_date = date('Y-m-01');
                        $end_date = date('Y-m-d');
                        break;
                    case 'last_month':
                        $start_date = date('Y-m-01', strtotime('first day of last month'));
                        $end_date = date('Y-m-t', strtotime('last day of last month'));
                        break;
                }
            }
            
            // Pass date range to view for display
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['current_branch'] = $branch_id;
            
            $today = date('Y-m-d');
            $month = date('m');
            $year = date('Y');
            
            // Dashboard Model Data - Use date range for KPIs
            $data['incomechart'] = $this->dashboard_model->incomeChart($today, $month, $year, $branch_id);
            $data['expensechart'] = $this->dashboard_model->expenseChart($today, $month, $year, $branch_id);
            $data['countmonthlychart'] = $this->dashboard_model->countmonthlyChart($branch_id);
            
            // Use date range for KPIs instead of just "today"
            $data['todayin'] = $this->dashboard_model->rangeInvoice($start_date, $end_date, $branch_id);
            $data['todaysales'] = $this->dashboard_model->rangeSales($start_date, $end_date, $branch_id);
            $data['todayinexp'] = $this->dashboard_model->rangeInexp($start_date, $end_date, $branch_id);
            $data['todayprofit'] = $this->dashboard_model->rangeProfit($start_date, $end_date, $branch_id);
            $data['todaynewcustomers'] = $this->dashboard_model->rangeNewCustomers($start_date, $end_date, $branch_id);
            
            $data['monthin'] = $this->dashboard_model->monthlyInvoice($month, $year, $branch_id);
            $data['monthsales'] = $this->dashboard_model->monthlySales($month, $year, $branch_id);
            
            $data['recent'] = $this->dashboard_model->recentInvoices($branch_id);
            $data['recent_buy'] = $this->dashboard_model->recentBuyers($branch_id);
            $data['recent_payments'] = $this->dashboard_model->recent_payments($branch_id);
            
            // Tasks
            if ($this->db->table_exists('tasks')) {
                $this->db->where('status', 'Due');
                $this->db->where('related_to', $this->aauth->get_user()->id);
                $this->db->order_by('duedate', 'ASC');
                $this->db->limit(5);
                $query = $this->db->get('tasks');
                $data['tasks'] = $query ? $query->result_array() : array();
            } else {
                $data['tasks'] = array();
            }
            
            // Intelligence Data
            $data['today_sales'] = array('total' => $this->intelligence_model->get_aggregated_sales($end_date, $branch_id));
            $data['today_profit'] = $this->intelligence_model->get_aggregated_profit($end_date, $branch_id);
            $data['cash_in_hand'] = $this->intelligence_model->get_aggregated_cash($end_date, $branch_id);
            
            $data['business_health'] = $this->intelligence_model->get_business_health(); 
            $data['staff_trust_index'] = $this->intelligence_model->get_avg_staff_trust(); 
            $data['dead_stock_summary'] = $this->intelligence_model->get_dead_stock_summary($branch_id);
            $data['fast_moving_summary'] = $this->intelligence_model->get_fast_moving_summary($branch_id);
            
            $data['risk_alerts'] = $this->risk_model->get_recent_alerts(5);
            $data['dead_stock_val'] = $this->analytics_model->get_dead_stock_value($branch_id);
            
            $data['loss_stats'] = array(
                'stock_leak' => $this->loss_model->get_stock_leak_stats($branch_id),
                'billing_error' => $this->loss_model->get_billing_errors($branch_id),
                'return_abuse' => $this->loss_model->get_return_abuse_stats($branch_id),
                'prevented_loss' => $this->loss_model->get_prevented_loss_today($branch_id)
            );
            
            $data['slow_moving_count'] = $this->analytics_model->get_slow_moving_count($branch_id);
            $data['staff_scores_list'] = $this->intelligence_model->get_top_staff_trust(5, $branch_id);
            
            // New Financial Metrics with date range
            $data['customer_due'] = $this->intelligence_model->get_customer_due($branch_id, $start_date, $end_date);
            $data['supplier_due'] = $this->intelligence_model->get_supplier_due($branch_id, $start_date, $end_date);
            $data['financial_metrics'] = $this->intelligence_model->get_detailed_financial_metrics($branch_id, $start_date, $end_date);
            $data['cheque_stats'] = $this->intelligence_model->get_cheque_status($branch_id);
            
            $data['branches'] = $this->analytics_model->get_branch_performance();
            
            // Generate and fetch insights
            $this->intelligence_model->generate_daily_insights();
            $data['system_insights'] = $this->intelligence_model->get_recent_insights(5);
            
            $data['current_branch'] = $branch_id;
            
            // Load branch locations for filter dropdown
            $this->db->where('id !=', 0);
            $this->db->order_by('id', 'ASC');
            $query = $this->db->get('geopos_locations');
            $data['locations'] = $query ? $query->result_array() : array();
            
            // Add goals for income/expense progress tracking (can be customized later)
            $data['goals'] = array(
                'income' => 100000,     // Default monthly income goal
                'expense' => 50000,     // Default monthly expense goal
                'sales' => 100000,      // Default monthly sales goal
                'netincome' => 50000    // Default monthly net income goal
            );

            $this->load->view('fixed/header', $head);
            $this->load->view('dashboards/owner', $data);
            $this->load->view('fixed/footer');
            
        } catch (Exception $e) {
            echo "<h1>Error Loading Owner Dashboard</h1>";
            echo "<p><strong>Error Message:</strong> " . $e->getMessage() . "</p>";
            echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
            echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
        }
    }

    public function view_dead_stock()
    {
        $branch_id = $this->input->get('branch_id');
        if(!$branch_id) $branch_id = 0;
        
        $head['title'] = "Dead Stock Intelligence";
        $head['usernm'] = $this->aauth->get_user()->username;
        
        $data['dead_stock_list'] = $this->analytics_model->predict_dead_stock($branch_id);
        $data['branch_id'] = $branch_id;
        
        $this->load->view('fixed/header', $head);
        $this->load->view('dashboards/dead_stock_list', $data);
        $this->load->view('fixed/footer');
    }
    
    public function staff_leaderboard()
    {
        $branch_id = $this->input->get('branch_id');
        if(!$branch_id) $branch_id = 0;
        
        $head['title'] = "Staff Performance Leaderboard";
        $head['usernm'] = $this->aauth->get_user()->username;
        
        // Get all staff scores (not just top 5)
        $this->db->select('geopos_staff_scores.*, geopos_users.username, geopos_users.email');
        $this->db->from('geopos_staff_scores');
        $this->db->join('geopos_users', 'geopos_staff_scores.staff_id = geopos_users.id');
        $this->db->where('DATE(geopos_staff_scores.last_calculated)', date('Y-m-d'));
        
        if ($branch_id > 0) {
            $this->db->where('geopos_staff_scores.branch_id', $branch_id);
        }
        
        $this->db->order_by('trust_score', 'DESC');
        $query = $this->db->get();
        $data['staff_list'] = $query ? $query->result_array() : array();
        
        // Add rankings
        $rank = 1;
        foreach ($data['staff_list'] as &$staff) {
            $staff['rank'] = $rank++;
        }
        
        $data['branch_id'] = $branch_id;
        
        // Get branch list for filter
        $this->load->model('locations_model');
        $data['branches'] = $this->locations_model->locations_list();
        
        $this->load->view('fixed/header', $head);
        $this->load->view('intelligence/staff_leaderboard', $data);
        $this->load->view('fixed/footer');
    }
}

