<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Intelligence extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
        
        // Ensure only authorized roles access this
        if ($this->aauth->get_user()->roleid < 5) {
            exit('Authorization Failed');
        }

        $this->load->model('intelligence_model');
        $this->load->model('analytics_model');
    }

    // Main Intelligence Hub
    public function index()
    {
        $head['title'] = "Business Intelligence Hub";
        $head['usernm'] = $this->aauth->get_user()->username;
        
        $data['insights'] = $this->intelligence_model->get_recent_insights(20);
        $data['health_metrics'] = $this->intelligence_model->get_business_health();
        
        $this->load->view('fixed/header', $head);
        $this->load->view('intelligence/dashboard', $data);
        $this->load->view('fixed/footer');
    }
    
    // AJAX: Get Branch Performance Heatmap Data
    public function get_heatmap_data() 
    {
        $data = $this->analytics_model->get_branch_performance();
        echo json_encode($data);
    }
    
    // AJAX: Get Sales Forecast
    public function get_forecast()
    {
        // Simple linear projection for demo
        $data = array(
            'next_week' => rand(100000, 150000),
            'next_month' => rand(400000, 600000),
            'confidence' => 'Medium'
        );
        echo json_encode($data);
    }

    // Sales Demo / Presentation Mode
    public function sales_demo()
    {
        $head['title'] = "Live Sales Command Center";
        
        // Get Live Data
        $today = date('Y-m-d');
        $month = date('m');
        $year = date('Y');
        
        $this->load->model('dashboard_model');
        
        $data['today_sales'] = $this->dashboard_model->todaySales($today);
        $data['today_count'] = $this->dashboard_model->todayInvoice($today);
        
        $data['month_sales'] = $this->dashboard_model->monthlySales($month, $year);
        $data['recent_transactions'] = $this->dashboard_model->recent_payments();
        
        // Top Products (Last 30 Days)
        $this->db->select('product_name, qty, subtotal');
        $this->db->from('geopos_invoice_items');
        $this->db->join('geopos_invoices', 'geopos_invoices.id = geopos_invoice_items.tid');
        $this->db->where('geopos_invoices.invoicedate >=', date('Y-m-d', strtotime('-30 days')));
        $this->db->order_by('subtotal', 'DESC');
        $this->db->limit(5);
        $data['top_products'] = $this->db->get()->result_array();

        $this->load->view('intelligence/sales_demo', $data);
    }
    
    /**
     * Dead Stock Report - Detailed View
     */
    public function dead_stock()
    {
        $head['title'] = "Dead Stock Analysis";
        $head['usernm'] = $this->aauth->get_user()->username;
        
        // Get branch filter
        // Detect sample mode
        $sample_mode = $this->input->get('sample') == 1;
        
        // Get dead stock data
        $data['dead_stock_items'] = $this->intelligence_model->get_dead_stock($branch_id);
        $data['slow_moving_items'] = $this->intelligence_model->get_slow_moving_stock($branch_id);
        
        // Fallback to sample data if in sample mode or if results are empty
        if ($sample_mode || (empty($data['dead_stock_items']) && empty($data['slow_moving_items']))) {
            if ($sample_mode) {
                $data['dead_stock_items'] = $this->intelligence_model->get_sample_data('dead', $branch_id);
                $data['slow_moving_items'] = $this->intelligence_model->get_sample_data('slow', $branch_id);
                $data['sample_mode'] = true;
            }
        }
        
        $data['summary'] = $this->intelligence_model->get_dead_stock_summary($branch_id);
        
        // Update summary with sample counts if in sample mode
        if (isset($data['sample_mode']) && $data['sample_mode']) {
            $data['summary']['dead_stock_count'] = count($data['dead_stock_items']);
            $data['summary']['slow_moving_count'] = count($data['slow_moving_items']);
            // Recalculate values
            $data['summary']['dead_stock_value'] = array_sum(array_column($data['dead_stock_items'], 'dead_stock_value'));
            $data['summary']['slow_moving_value'] = array_sum(array_column($data['slow_moving_items'], 'stock_value'));
        }

        $data['current_branch'] = $branch_id;
        
        // Get locations for filter
        $this->db->where('id !=', 0);
        $query = $this->db->get('geopos_locations');
        $data['locations'] = $query ? $query->result_array() : array();
        
        $this->load->view('fixed/header', $head);
        $this->load->view('intelligence/dead_stock', $data);
        $this->load->view('fixed/footer');
    }
    
    /**
     * Fast-Moving Stock Report - Detailed View
     */
    public function fast_moving_stock()
    {
        $head['title'] = "Fast-Moving Stock Analysis";
        $head['usernm'] = $this->aauth->get_user()->username;
        
        // Get branch filter
        $branch_id = $this->input->get('branch_id') ?: 0;
        $sample_mode = $this->input->get('sample') == 1;
        
        // Get fast-moving stock data
        $data['fast_moving_items'] = $this->intelligence_model->get_fast_moving_stock($branch_id);
        
        // Fallback to sample data
        if ($sample_mode || empty($data['fast_moving_items'])) {
            if ($sample_mode) {
                $data['fast_moving_items'] = $this->intelligence_model->get_sample_data('fast', $branch_id);
                $data['sample_mode'] = true;
            }
        }

        $data['summary'] = $this->intelligence_model->get_fast_moving_summary($branch_id);
        
        // Update summary for sample mode
        if (isset($data['sample_mode']) && $data['sample_mode']) {
            $data['summary']['fast_moving_count'] = count($data['fast_moving_items']);
            $data['summary']['fast_moving_value'] = array_sum(array_column($data['fast_moving_items'], 'stock_value'));
            $data['summary']['total_sales'] = array_sum(array_column($data['fast_moving_items'], 'sales_count'));
            $data['summary']['avg_sales_per_product'] = $data['summary']['fast_moving_count'] > 0 ? $data['summary']['total_sales'] / $data['summary']['fast_moving_count'] : 0;
        }

        $data['current_branch'] = $branch_id;
        
        // Get locations for filter
        $this->db->where('id !=', 0);
        $query = $this->db->get('geopos_locations');
        $data['locations'] = $query ? $query->result_array() : array();
        
        $this->load->view('fixed/header', $head);
        $this->load->view('intelligence/fast_moving_stock', $data);
        $this->load->view('fixed/footer');
    }
}
