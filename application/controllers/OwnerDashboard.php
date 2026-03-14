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
            redirect('/hub/login', 'refresh');
        }
        
        $user = $this->aauth->get_user();
        $roleid = $user->roleid;
        $username = $user->username;
        $role_name = isset($user->role_name) ? strtolower($user->role_name) : '';

        // 1. Super Admin (Role ID: 1 or 5)
        if ($roleid == 1 || $roleid == 5) {
            // Role 5 is the original Super Admin role in some versions
            // Role 1 is our repaired Super Admin role
            // Allow them to stay on the main OwnerDashboard overview
            // No redirect needed here unless we want to force SystemHealth/dashboard
            // Keeping them on this dashboard for full overview
        }

        // 2. Service Provider (Specific check)
        if ($username == 'Sunil_Caregiver' || $username == 'servicepro' || $role_name == 'service provider') {
            redirect('ServiceDashboard/', 'refresh');
        }

        // 3. Customer (Role ID: 0)
        if ($roleid == 0) {
            redirect('shop/index', 'refresh');
        }

        // 4. Branch Staff (Role ID: 2)
        if ($roleid == 2) {
            redirect('pos_invoices/create', 'refresh');
        } 
        // Note: Role ID 1 used to redirect to worker/profiles here. 
        // It has been moved to the Super Admin check above.

        // Business Owner (Role ID: 4) and Branch Manager (Role ID: 3) stay on this dashboard

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
                 $branch_id = $this->session->userdata('loc'); 
            }
            
            // Capture date range
            $start_date = $this->input->get('start_date') ?: date('Y-m-01');
            $end_date = $this->input->get('end_date') ?: date('Y-m-d');

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
            
            // View Date Range Logic
            $head['start_date'] = $start_date;
            $head['end_date'] = $end_date;
            $head['current_branch'] = $branch_id;
            
            // Logic for Dashboard Model (needs -1 for All)
            $dash_loc = ($branch_id == 0) ? -1 : $branch_id;
            
            $today = date('Y-m-d');
            $month = date('m');
            $year = date('Y');
            
            // Dashboard Model Data - Use date range for KPIs
            $data['incomechart'] = $this->dashboard_model->incomeChart($today, $month, $year, $dash_loc);
            $data['expensechart'] = $this->dashboard_model->expenseChart($today, $month, $year, $dash_loc);
            $data['countmonthlychart'] = $this->dashboard_model->countmonthlyChart($dash_loc);
            
            // Use date range for KPIs instead of just "today"
            $data['todayin'] = $this->dashboard_model->rangeInvoice($start_date, $end_date, $dash_loc);
            $data['todaysales'] = $this->dashboard_model->rangeSales($start_date, $end_date, $dash_loc);
            $data['todayinexp'] = $this->dashboard_model->rangeInexp($start_date, $end_date, $dash_loc);
            $data['todayprofit'] = $this->dashboard_model->rangeProfit($start_date, $end_date, $dash_loc);
            $data['todaynewcustomers'] = $this->dashboard_model->rangeNewCustomers($start_date, $end_date, $dash_loc);
            
            $data['monthin'] = $this->dashboard_model->monthlyInvoice($month, $year, $dash_loc);
            $data['monthsales'] = $this->dashboard_model->monthlySales($month, $year, $dash_loc);
            
            $data['recent'] = $this->dashboard_model->recentInvoices($dash_loc);
            $data['recent_buy'] = $this->dashboard_model->recentBuyers($dash_loc);
            $data['recent_payments'] = $this->dashboard_model->recent_payments($dash_loc);
            
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

            // Phase 4: Service Management Dashboard Widgets
            $data['kyc_pending'] = $this->db->where('status', 0)->count_all_results('tp_service_providers');
            // Today's commission from service bookings (Simplified for now)
            $data['today_commission'] = $this->db->select('SUM(credit) as total')
                ->from('geopos_transactions')
                ->where('DATE(date)', date('Y-m-d'))
                ->get()->row()->total;
            
            // Intelligence Data (0 means All)
            // Intelligence Data (0 means All)
            $data['today_sales'] = array('total' => $this->intelligence_model->get_aggregated_sales($end_date, $dash_loc));
            
            // Link core KPIs to Dual-Entry System
            $data['todayprofit'] = $this->intelligence_model->get_dual_entry_profit($dash_loc, $start_date, $end_date);
            $data['cash_in_hand'] = $this->intelligence_model->get_total_cash_in_hand($dash_loc);
            $data['bank_balance'] = $this->intelligence_model->get_total_bank_balance($dash_loc);
            
            $data['business_health'] = $this->intelligence_model->get_business_health($dash_loc); 
            $data['staff_trust_index'] = $this->intelligence_model->get_avg_staff_trust($dash_loc); 
            $data['dead_stock_summary'] = $this->intelligence_model->get_dead_stock_summary($dash_loc);
            $data['fast_moving_summary'] = $this->intelligence_model->get_fast_moving_summary($dash_loc);
            
            $data['risk_alerts'] = $this->risk_model->get_recent_alerts(5);
            $data['dead_stock_val'] = $this->analytics_model->get_dead_stock_value($dash_loc);
            
            $data['loss_stats'] = array(
                'stock_leak' => $this->loss_model->get_stock_leak_stats($dash_loc),
                'billing_error' => $this->loss_model->get_billing_errors($dash_loc),
                'return_abuse' => $this->loss_model->get_return_abuse_stats($dash_loc),
                'prevented_loss' => $this->loss_model->get_prevented_loss_today($dash_loc)
            );
            
            $data['slow_moving_count'] = $this->analytics_model->get_slow_moving_count($dash_loc);
            $data['staff_scores_list'] = $this->intelligence_model->get_top_staff_trust(5, $dash_loc);
            
            // New Financial Metrics with date range
            $data['customer_due'] = $this->intelligence_model->get_customer_due($dash_loc, $start_date, $end_date);
            $data['supplier_due'] = $this->intelligence_model->get_supplier_due($dash_loc, $start_date, $end_date);
            $data['financial_metrics'] = $this->intelligence_model->get_detailed_financial_metrics($dash_loc, $start_date, $end_date);
            $data['cheque_stats'] = $this->intelligence_model->get_cheque_status($dash_loc);
            $data['inventory_valuation'] = $this->intelligence_model->get_inventory_valuation($dash_loc);
            $data['payroll_intel'] = $this->intelligence_model->get_payroll_intel($dash_loc);

            
            // Phase 20: Advanced Accounting
            $data['financial_position'] = $this->intelligence_model->get_detailed_financial_position($dash_loc);
            $data['recent_journal_entries'] = $this->intelligence_model->get_recent_journal_entries($dash_loc, 10);
            
            // Phase 23: Strategic Business Analysis
            $data['strategic_indicators'] = $this->intelligence_model->get_strategic_indicators($dash_loc, $start_date, $end_date);
            
            $data['branches'] = $this->analytics_model->get_branch_performance($dash_loc);
            
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

    public function switch_location()
    {
        $id = intval($this->input->get('id'));
        $user_id = $this->aauth->get_user()->id;
        $role_id = $this->aauth->get_user()->roleid;

        $allowed = false;

        if ($role_id == 1) {
            // Super Admin can access any location
            $allowed = true;
        } else {
            if ($id == 0) {
                // Wait: depending on business logic, maybe roles shouldn't switch to global (0) unless super admin.
                // Keeping previous logic where role >= 4 could switch to global for backward capability.
                if ($role_id >= 4) {
                    $allowed = true;
                }
            } else {
                // Determine if this user has access to this specific location
                $this->db->where('user_id', $user_id);
                $this->db->where('location_id', $id);
                $query = $this->db->get('geopos_user_locations');
                if ($query->num_rows() > 0) {
                    $allowed = true;
                }
            }
        }

        if ($allowed) {
            if ($id > 0) {
                $this->db->where('id', $id);
                $query = $this->db->get('geopos_locations');
                if ($query->num_rows() > 0) {
                    $this->db->set('loc', $id);
                    $this->db->where('id', $user_id);
                    $this->db->update('geopos_users');
                    $this->session->set_userdata('loc', $id);
                }
            } else {
                $this->db->set('loc', 0);
                $this->db->where('id', $user_id);
                $this->db->update('geopos_users');
                $this->session->set_userdata('loc', 0);
            }
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

}

