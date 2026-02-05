<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production_maintenance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('production_maintenance_model');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        $head['title'] = "Machine Maintenance";
        $head['usernm'] = $this->aauth->get_user()->username;
        
        $data['machines'] = $this->production_maintenance_model->get_machine_status();
        $data['maintenance'] = $this->production_maintenance_model->get_upcoming_maintenance();

        $this->load->view('fixed/header', $head);
        $this->load->view('maintenance/dashboard', $data);
        $this->load->view('fixed/footer');
    }

    public function log_issue()
    {
        if($this->input->post()) {
            $machine_id = $this->input->post('machine_id');
            $reason = $this->input->post('reason');
            $comments = $this->input->post('comments');
            $user_id = $this->aauth->get_user()->id;

            if($this->production_maintenance_model->log_downtime($machine_id, $reason, $comments, $user_id)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Downtime Logged. Machine Status: DOWN.'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Database Error'));
            }
        }
    }

    public function resolve_issue()
    {
         if($this->input->post()) {
            $id = $this->input->post('id'); // downtime id
             if($this->production_maintenance_model->resolve_downtime($id)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Issue Resolved. Machine Status: ACTIVE.'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Database Error'));
            }
         }
    }

    public function schedule()
    {
        if($this->input->post()) {
            $machine_id = $this->input->post('machine_id');
            $date = $this->input->post('date');
            $desc = $this->input->post('description');

            if($this->production_maintenance_model->schedule_service($machine_id, $date, $desc)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Maintenance Scheduled.'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Database Error'));
            }
        }
    }
}
