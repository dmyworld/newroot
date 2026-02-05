<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Work_orders extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('work_orders_model');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    // Manager View: List of all WOs
    public function index()
    {
        $head['title'] = "Work Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
        
        $data['orders'] = $this->work_orders_model->get_all_work_orders();
        $data['employees'] = $this->aauth->list_users(); // To assign tasks

        $this->load->view('fixed/header', $head);
        $this->load->view('work_orders/index', $data);
        $this->load->view('fixed/footer');
    }

    // Worker View: My Tasks
    public function my_tasks()
    {
        $head['title'] = "My Tasks";
        $head['usernm'] = $this->aauth->get_user()->username;
        $user_id = $this->aauth->get_user()->id;

        $data['tasks'] = $this->work_orders_model->get_employee_tasks($user_id);

        $this->load->view('fixed/header', $head);
        $this->load->view('work_orders/my_tasks', $data);
        $this->load->view('fixed/footer');
    }

    // Action: Generate WOs from Batch
    public function generate()
    {
        $batch_id = $this->input->post('batch_id');
        if ($batch_id) {
            $count = $this->work_orders_model->generate_from_batch($batch_id);
            echo json_encode(array('status' => 'Success', 'message' => "$count Work Orders Generated"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Invalid Batch'));
        }
    }

    // Action: Assign Employee
    public function assign()
    {
        $wo_id = $this->input->post('wo_id');
        $emp_id = $this->input->post('employee_id');
        if($this->work_orders_model->assign_employee($wo_id, $emp_id)) {
             echo json_encode(array('status' => 'Success', 'message' => "Assigned Successfully"));
        } else {
             echo json_encode(array('status' => 'Error', 'message' => "Error Assigning"));
        }
    }

    // Action: Update Status (Start/Complete)
    public function update_status()
    {
        $wo_id = $this->input->post('id');
        $status = $this->input->post('status');
        $qty = $this->input->post('qty', TRUE); // optional
        $remarks = $this->input->post('remarks', TRUE); // optional

        if($this->work_orders_model->update_status($wo_id, $status, $qty, $remarks)) {
            echo json_encode(array('status' => 'Success', 'message' => "Status Updated"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => "Error Updating"));
        }
    }
}
