<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OwnerDashboard_backup extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
        
        if ($this->aauth->get_user()->roleid < 5) {
             exit('Authorization Failed');
        }

        $this->load->model('dashboard_model');
        $this->load->model('risk_model');
        $this->load->model('loss_model');
        $this->load->model('intelligence_model');
        $this->load->model('analytics_model');
        $this->load->language('dashboard', 'english'); 
    }

    public function index()
    {
        echo "<h1>OwnerDashboard Test - Step by Step</h1>";
        
        echo "<h2>Step 1: Basic Setup</h2>";
        $head['title'] = 'Owner Intelligence Dashboard';
        $head['usernm'] = $this->aauth->get_user()->username;
        echo "✓ Header setup OK<br>";
        
        echo "<h2>Step 2: Branch Filter</h2>";
        $branch_id = $this->input->get('branch_id');
        if (!isset($_GET['branch_id'])) { 
             $branch_id = 0; 
        }
        echo "✓ Branch ID: $branch_id<br>";
        
        echo "<h2>Step 3: Dashboard Model Data</h2>";
        $today = date('Y-m-d');
        $month = date('m');
        $year = date('Y');
        echo "✓ Date vars set<br>";
        
        try {
            $data['incomechart'] = $this->dashboard_model->incomeChart($today, $month, $year);
            echo "✓ incomeChart loaded<br>";
        } catch (Exception $e) {
            echo "✗ incomeChart error: " . $e->getMessage() . "<br>";
        }
        
        try {
            $data['todayin'] = $this->dashboard_model->todayInvoice($today);
            echo "✓ todayInvoice loaded<br>";
        } catch (Exception $e) {
            echo "✗ todayInvoice error: " . $e->getMessage() . "<br>";
        }
        
        echo "<h2>Step 4: Intelligence Model Data</h2>";
        try {
            $data['today_sales'] = array('total' => $this->intelligence_model->get_aggregated_sales($today, $branch_id));
            echo "✓ get_aggregated_sales loaded<br>";
        } catch (Exception $e) {
            echo "✗ get_aggregated_sales error: " . $e->getMessage() . "<br>";
        }
        
        echo "<h2>All basic tests passed! The controller logic works.</h2>";
        echo "<p>The issue might be in the VIEW file. Let me try loading it...</p>";
        
        // Minimal data for view
        $data['recent'] = [];
        $data['recent_buy'] = [];
        $data['tasks'] = [];
        $data['current_branch'] = $branch_id;
        
        $this->load->view('fixed/header', $head);
        echo "<p>If you see this, the header loaded successfully.</p>";
        // $this->load->view('dashboards/owner', $data); // Comment out to test
        echo "<p><strong>VIEW FILE NOT LOADED YET - Testing controller only</strong></p>";
        $this->load->view('fixed/footer');
    }
}
