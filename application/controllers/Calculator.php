<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calculator extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->model('Timber_Calculator_model', 'timber_calc');
        $this->li_a = 'calculator';
    }

    public function index()
    {
        $head['title'] = "Advanced Timber Calculator";
        $this->load->view('fixed/header', $head);
        $this->load->view('calculator/timber_calc');
        $this->load->view('fixed/footer');
    }

    public function wastage()
    {
        $head['title'] = "Wastage & Yield Analysis";
        $this->load->view('fixed/header', $head);
        $this->load->view('calculator/wastage');
        $this->load->view('fixed/footer');
    }
}
