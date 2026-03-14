<?php
/**
 * Service Reports Controller
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Service_reports extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid != 1) {
            exit('<h3>Insufficient permissions.</h3>');
        }
        $this->load->model('service_reports_model', 'reports');
        $this->li_a = 'reports';
    }

    public function commissions()
    {
        $head['title'] = "Commission Analysis";
        $start = $this->input->get('start') ? $this->input->get('start') : date('Y-m-d', strtotime('-30 days'));
        $end = $this->input->get('end') ? $this->input->get('end') : date('Y-m-d');
        
        $data['summary'] = $this->reports->get_commission_summary($start, $end);
        $this->load->view('fixed/header-va', $head);
        $this->load->view('reports/service_commissions', $data);
        $this->load->view('fixed/footer');
    }

    public function provider_performance()
    {
        $head['title'] = "Provider Performance Leaderboard";
        $data['leaderboard'] = $this->reports->get_rating_leaderboard();
        $data['payouts'] = $this->reports->get_provider_payouts();
        
        $this->load->view('fixed/header-va', $head);
        $this->load->view('reports/provider_performance', $data);
        $this->load->view('fixed/footer');
    }

    public function category_analysis()
    {
        $head['title'] = "Revenue by Service Category";
        $data['cat_data'] = $this->reports->get_category_revenue();
        $this->load->view('fixed/header-va', $head);
        $this->load->view('reports/category_revenue', $data);
        $this->load->view('fixed/footer');
    }
}
