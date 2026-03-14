<?php
/**
 * TimberPro - Financial Reporting Module
 * Developed for Advance Financial Accounting & Reporting
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Financial extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
        if (!$this->aauth->premission(5)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $this->load->model('reports_model', 'reports');
        $this->load->model('locations_model');
        $this->li_a = 'accounts';
    }

    public function profit_loss()
    {
        $loc = $this->input->get('loc') ?: $this->aauth->get_user()->loc;
        $s_date = $this->input->get('s_date') ? datefordatabase($this->input->get('s_date')) : date('Y-m-01');
        $e_date = $this->input->get('e_date') ? datefordatabase($this->input->get('e_date')) : date('Y-m-d');

        $data['report'] = $this->reports->get_profit_loss($loc, $s_date, $e_date);
        $data['locations'] = $this->locations_model->locations_list2();
        $data['filter'] = ['loc' => $loc, 's_date' => $s_date, 'e_date' => $e_date];

        $head['title'] = "Profit & Loss Report";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('financial/profit_loss', $data);
        $this->load->view('fixed/footer');
    }

    public function balance_sheet()
    {
        $loc = $this->input->get('loc') ?: $this->aauth->get_user()->loc;

        $data['report'] = $this->reports->get_balance_sheet($loc);
        $data['locations'] = $this->locations_model->locations_list2();
        $data['filter'] = ['loc' => $loc];

        $head['title'] = "Balance Sheet";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('financial/balance_sheet', $data);
        $this->load->view('fixed/footer');
    }
}
