<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SystemHealth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Aauth');
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
        $this->load->model('System_health_model', 'health');
    }

    /**
     * Super Admin Dashboard View
     */
    public function dashboard()
    {
        $roleid = $this->aauth->get_user()->roleid;
        if (!($roleid == 1 || $roleid == 5)) {
             exit('Denied');
        }

        $data['title'] = 'System Health - Super Admin';
        $data['integrity'] = $this->health->get_financial_mismatch();
        $data['performance'] = $this->health->get_performance_stats();
        
        $this->load->view('fixed/header', $data);
        $this->load->view('system_health/super_admin', $data);
        $this->load->view('fixed/footer');
    }

    /**
     * Business Owner Dashboard View
     */
    public function business_overview()
    {
        $loc = $this->aauth->get_user()->loc;
        $data['title'] = 'Business Health Overview';
        $data['liquidity'] = $this->health->get_liquidity_health($loc);
        $data['inventory'] = $this->health->get_inventory_alerts($loc);
        $data['overruns'] = $this->health->get_project_overruns($loc);

        $this->load->view('fixed/header', $data);
        $this->load->view('system_health/business_owner', $data);
        $this->load->view('fixed/footer');
    }
}
