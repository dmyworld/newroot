<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('payroll_model', 'payroll');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        // Redirect to new Advanced Payroll
        redirect('payrollprocessing', 'refresh');
    }

    public function create()
    {
         redirect('payrollprocessing', 'refresh');
    }
}
