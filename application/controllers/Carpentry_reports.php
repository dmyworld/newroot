<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carpentry_reports extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('carpentry_reports_model');
        
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function profitability()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Project Profitability Report';
        
        $data['report'] = $this->carpentry_reports_model->get_projects_profitability();

        $this->load->view('fixed/header', $head);
        $this->load->view('carpentry_reports/profitability', $data);
        $this->load->view('fixed/footer');
    }
}
