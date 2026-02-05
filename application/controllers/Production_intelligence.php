<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production_intelligence extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('production_intelligence_model');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        $head['title'] = "AI Decision Support";
        $head['usernm'] = $this->aauth->get_user()->username;
        
        $data['alerts'] = $this->production_intelligence_model->get_active_alerts();

        $this->load->view('fixed/header', $head);
        $this->load->view('intelligence/dashboard', $data);
        $this->load->view('fixed/footer');
    }

    public function run_analysis()
    {
        $count = $this->production_intelligence_model->run_analysis_logic();
        echo json_encode(array('status' => 'Success', 'message' => "Analysis Complete. $count new alerts generated."));
    }

    public function dismiss()
    {
        $id = $this->input->post('id');
        if($this->production_intelligence_model->dismiss_alert($id)) {
            echo json_encode(array('status' => 'Success'));
        } else {
            echo json_encode(array('status' => 'Error'));
        }
    }
}
