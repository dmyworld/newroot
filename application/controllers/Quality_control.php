<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quality_control extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('quality_control_model');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        $head['title'] = "QC Dashboard";
        $head['usernm'] = $this->aauth->get_user()->username;
        
        $data['pending_list'] = $this->quality_control_model->get_pending_inspections();

        $this->load->view('fixed/header', $head);
        $this->load->view('qc/dashboard', $data);
        $this->load->view('fixed/footer');
    }

    public function inspect()
    {
        $wo_id = $this->input->get('id');
        if(!$wo_id) redirect('quality_control');

        $head['title'] = "Perform Inspection";
        $head['usernm'] = $this->aauth->get_user()->username;

        $data['wo'] = $this->quality_control_model->get_wo_details($wo_id);

        $this->load->view('fixed/header', $head);
        $this->load->view('qc/inspect', $data);
        $this->load->view('fixed/footer');
    }

    public function save_inspection()
    {
        if($this->input->post()) {
            $wo_id = $this->input->post('wo_id');
            $qty_checked = $this->input->post('qty_checked');
            $qty_passed = $this->input->post('qty_passed');
            $qty_rework = $this->input->post('qty_rework');
            $qty_scraped = $this->input->post('qty_scraped');
            $defect_type = $this->input->post('defect_type');
            $comments = $this->input->post('comments');
            
            $inspector_id = $this->aauth->get_user()->id;

            // Basic validation
            $total = $qty_passed + $qty_rework + $qty_scraped;
            if($total != $qty_checked) {
                echo json_encode(array('status' => 'Error', 'message' => 'Total quantities do not match quantity checked.'));
                return;
            }

            if($this->quality_control_model->save_inspection($wo_id, $inspector_id, $qty_checked, $qty_passed, $qty_rework, $qty_scraped, $defect_type, $comments)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Inspection Saved Successfully', 'redirect' => site_url('quality_control')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Database Error'));
            }
        }
    }
}
