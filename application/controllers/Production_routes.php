<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production_routes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $this->load->model('production_schedule_model', 'scheduler');
    }

    public function add()
    {
        if ($this->input->post()) {
            $batch_id = $this->input->post('batch_id');
            $stage_name = $this->input->post('stage_name');
            $machine_id = $this->input->post('machine_id');
            $hours = $this->input->post('hours');
            $sequence = $this->input->post('sequence');

            if ($this->scheduler->add_route_stage($batch_id, $stage_name, $machine_id, $hours, $sequence)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Stage Added Successfully'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error Adding Stage'));
            }
        }
    }

    public function delete()
    {
        $id = $this->input->post('id');
        if ($this->scheduler->delete_route_stage($id)) {
            echo json_encode(array('status' => 'Success', 'message' => 'Stage Deleted'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Error Deleting Stage'));
        }
    }
}
