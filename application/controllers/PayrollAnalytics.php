<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PayrollAnalytics extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        // Permission check - e.g. Admin or Payroll Manager
        if ($this->aauth->get_user()->roleid < 5 && !$this->aauth->premission(14)) { 
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        
        $this->load->model('payroll_analytics_model', 'analytics');
        $this->load->library("Custom");
        $this->li_a = 'payroll'; // Highlight Payroll menu
    }
    
    public function index()
    {
        $head['title'] = "Payroll Analytics";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('payroll/analytics/dashboard');
        $this->load->view('fixed/footer');
    }
    
    public function monthly_trends_data()
    {
        $year = $this->input->get('year');
        $data = $this->analytics->monthly_trends($year);
        // Format for Morris.js or Chart.js
        // Morris Line Chart expects: [{ y: '2023-01', a: 100 }, ...]
        $chart_data = array();
        foreach($data as $row) {
             $chart_data[] = array('y' => $row['month'], 'a' => $row['total_gross']);
        }
        echo json_encode($chart_data);
    }
    
    public function dept_distribution_data()
    {
        $data = $this->analytics->dept_distribution();
        // Format for Donut/Bar Chart
        // Morris Donut: [{label: "Label", value: 50}, ...]
        $chart_data = array();
        foreach($data as $row) {
            $dept_name = $this->analytics->get_dept_name($row['dept']);
            $chart_data[] = array('label' => $dept_name, 'value' => $row['total_gross']);
        }
        echo json_encode($chart_data);
    }
}
