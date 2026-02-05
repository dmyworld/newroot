<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seasoning extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('seasoning_model');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        $head['title'] = "Seasoning Batches";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['batches'] = $this->seasoning_model->get_all_batches();
        
        $this->load->view('fixed/header', $head);
        $this->load->view('seasoning/index', $data);
        $this->load->view('fixed/footer');
    }

    public function create()
    {
        if ($this->input->post()) {
            $name = $this->input->post('name');
            $method = $this->input->post('method');
            $location = $this->input->post('location');
            $start_date = $this->input->post('start_date');
            $initial_mc = $this->input->post('initial_mc');
            $target_mc = $this->input->post('target_mc');

            if ($this->seasoning_model->create_batch($name, $method, $start_date, $initial_mc, $target_mc, $location)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Seasoning Batch Started'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error Creating Batch'));
            }
        } else {
            $head['title'] = "Start Seasoning Batch";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('seasoning/create');
            $this->load->view('fixed/footer');
        }
    }

    public function view()
    {
        $id = $this->input->get('id');
        $head['title'] = "Batch Details";
        $head['usernm'] = $this->aauth->get_user()->username;
        
        $data['batch'] = $this->seasoning_model->get_batch_details($id);
        $data['logs'] = $this->seasoning_model->get_batch_logs($id);

        $this->load->view('fixed/header', $head);
        $this->load->view('seasoning/view', $data);
        $this->load->view('fixed/footer');
    }

    public function add_reading()
    {
        if ($this->input->post()) {
            $batch_id = $this->input->post('batch_id');
            $date = $this->input->post('check_date');
            $mc = $this->input->post('moisture');
            $temp = $this->input->post('temp');
            $humidity = $this->input->post('humidity');
            $noted_by = $this->aauth->get_user()->username;

            if ($this->seasoning_model->add_log($batch_id, $date, $mc, $temp, $humidity, $noted_by)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Reading Logged Successfully'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error Logging Reading'));
            }
        }
    }
}
