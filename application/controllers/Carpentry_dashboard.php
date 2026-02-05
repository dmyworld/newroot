<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carpentry_dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->model('projects_model', 'projects');
        $this->load->model('payroll_model', 'payroll');
        $this->load->model('assets_model', 'assets');
    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Carpentry Dashboard';
        $loc = $this->aauth->get_user()->loc;

        // Metrics
        $data['total_projects'] = $this->db->where('ptype', 0)->count_all_results('geopos_projects'); // Refining by type/loc if needed
        // Assuming geopos_projects has loc? Yes, I added it earlier phase or valid existing.
        // Actually, existing projects model logic:
        
        // Fetch recent projects
        $this->db->select('*');
        $this->db->from('geopos_projects');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(5);
        $data['recent_projects'] = $this->db->get()->result_array();

        // Total Payroll (This Month)
        $month = date('n');
        $year = date('Y');
        $this->db->where('month', $month);
        $this->db->where('year', $year);
        $this->db->select_sum('net_pay');
        $query = $this->db->get('geopos_payroll');
        $data['monthly_payroll'] = $query->row()->net_pay;

        // Assets Count
        $data['total_assets'] = $this->db->count_all('geopos_assets');
        $data['assets_value'] = $this->db->select_sum('value')->get('geopos_assets')->row()->value;

        $this->load->view('fixed/header', $head);
        $this->load->view('carpentry/dashboard', $data);
        $this->load->view('fixed/footer');
    }
}
