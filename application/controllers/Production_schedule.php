<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production_schedule extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('production_schedule_model', 'scheduler');
        
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        $head['title'] = "Production Schedule";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('production_schedule/index');
        $this->load->view('fixed/footer');
    }

    public function get_calendar_data()
    {
        $start = $this->input->get('start');
        $end = $this->input->get('end');
        $result = $this->scheduler->get_all_batches_for_calendar($start, $end);
        
        // Format for FullCalendar
        $events = array();
        foreach ($result as $row) {
            $color = '#3C8DBC'; // Default Blue
            if ($row['priority'] == 'Urgent') $color = '#DD4B39'; // Red
            if ($row['priority'] == 'High') $color = '#F39C12'; // Orange
            if ($row['status'] == 'Completed') $color = '#00A65A'; // Green

            $events[] = array(
                'id' => $row['id'],
                'title' => $row['title'] . ' (' . $row['status'] . ')',
                'start' => $row['start'],
                'end' => $row['end'], // Optional?
                'color' => $color,
                'url' => site_url('production_schedule/view?id=' . $row['id']) // Add Link
            );
        }
        echo json_encode($events);
    }

    public function create_batch()
    {
        if ($this->input->post()) {
            $name = $this->input->post('name');
            $priority = $this->input->post('priority');
            $wood_id = $this->input->post('wood_id');
            $qty = $this->input->post('qty');
            $unit = $this->input->post('unit');
            $due_date = $this->input->post('due_date');

            if ($this->scheduler->create_batch($name, $priority, $wood_id, $qty, $unit, $due_date)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Batch Created Successfully'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error Creating Batch'));
            }
        } else {
            $head['title'] = "Create Production Batch";
            $head['usernm'] = $this->aauth->get_user()->username;
            
            $this->load->model('wood_types_model');
            $data['wood_types'] = $this->wood_types_model->get_datatables(); 
            // Note: get_datatables returns objects. Using it for simple list for now. Might be inefficient but reusing exist code.

            $this->load->view('fixed/header', $head);
            $this->load->view('production_schedule/create_batch', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function run_auto_scheduler()
    {
        $count = $this->scheduler->auto_schedule();
        echo json_encode(array('status' => 'Success', 'message' => "Scheduled $count batches successfully."));
    }

    public function view()
    {
        $id = $this->input->get('id');
        $head['title'] = "Batch Details";
        $head['usernm'] = $this->aauth->get_user()->username;
        
        $data['batch'] = $this->scheduler->get_batch_details($id);
        $data['routes'] = $this->scheduler->get_batch_routes($id);
        
        // Load machines for dropdown
        $this->load->model('machines_model');
        $data['machines'] = $this->machines_model->get_datatables();

        $this->load->view('fixed/header', $head);
        $this->load->view('production_schedule/view_batch', $data);
        $this->load->view('fixed/footer');
    }
}

