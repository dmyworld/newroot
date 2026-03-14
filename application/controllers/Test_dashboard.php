<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
        if ($this->aauth->get_user()->roleid != 1) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
    }

    public function index()
    {
        echo "<h1>Testing Owner Dashboard Dependencies</h1>";
        
        // Test 1: Check if models exist and can be loaded
        echo "<h2>1. Testing Model Loading...</h2>";
        
        try {
            $this->load->model('dashboard_model');
            echo "✓ Dashboard_model loaded successfully<br>";
        } catch (Exception $e) {
            echo "✗ Error loading Dashboard_model: " . $e->getMessage() . "<br>";
        }
        
        try {
            $this->load->model('intelligence_model');
            echo "✓ Intelligence_model loaded successfully<br>";
        } catch (Exception $e) {
            echo "✗ Error loading Intelligence_model: " . $e->getMessage() . "<br>";
        }
        
        try {
            $this->load->model('risk_model');
            echo "✓ Risk_model loaded successfully<br>";
        } catch (Exception $e) {
            echo "✗ Error loading Risk_model: " . $e->getMessage() . "<br>";
        }
        
        try {
            $this->load->model('loss_model');
            echo "✓ Loss_model loaded successfully<br>";
        } catch (Exception $e) {
            echo "✗ Error loading Loss_model: " . $e->getMessage() . "<br>";
        }
        
        try {
            $this->load->model('analytics_model');
            echo "✓ Analytics_model loaded successfully<br>";
        } catch (Exception $e) {
            echo "✗ Error loading Analytics_model: " . $e->getMessage() . "<br>";
        }
        
        try {
            $this->load->model('locations_model');
            echo "✓ Locations_model loaded successfully<br>";
        } catch (Exception $e) {
            echo "✗ Error loading Locations_model: " . $e->getMessage() . "<br>";
        }
        
        // Test 2: Check if Dashboard_model methods exist
        echo "<h2>2. Testing Dashboard_model Methods...</h2>";
        $this->load->model('dashboard_model');
        $today = date('Y-m-d');
        $month = date('m');
        $year = date('Y');
        
        $methods = [
            'incomeChart' => [$today, $month, $year],
            'expenseChart' => [$today, $month, $year],
            'countmonthlyChart' => [],
            'todayInvoice' => [$today],
            'todaySales' => [$today],
            'todayInexp' => [$today],
            'todayProfit' => [$today],
            'monthlyInvoice' => [$month, $year],
            'monthlySales' => [$month, $year],
            'recentInvoices' => [],
            'recentBuyers' => [],
            'recent_payments' => []
        ];
        
        foreach ($methods as $method => $params) {
            if (method_exists($this->dashboard_model, $method)) {
                echo "✓ Method $method exists<br>";
            } else {
                echo "✗ Method $method MISSING<br>";
            }
        }
        
        // Test 3: Check if view file exists
        echo "<h2>3. Checking View Files...</h2>";
        $view_path = APPPATH . 'views/dashboards/owner.php';
        if (file_exists($view_path)) {
            echo "✓ View file exists: $view_path<br>";
        } else {
            echo "✗ View file MISSING: $view_path<br>";
        }
        
        echo "<h2>All Tests Complete!</h2>";
        echo "<p><a href='" . base_url('ownerdashboard') . "'>Try Owner Dashboard</a></p>";
    }
}
