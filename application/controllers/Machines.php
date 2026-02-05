<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Machines extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('machines_model', 'machines');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 4) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
    }

    public function index()
    {
        $head['title'] = "Machine Master";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('machines/index');
        $this->load->view('fixed/footer');
    }

    public function get_list()
    {
        $list = $this->machines->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $machine) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $machine->name;
            $row[] = $machine->machine_code;
            $row[] = $machine->capacity_per_hour;
            $row[] = $machine->maintenance_cycle_days . ' Days';
            $row[] = $machine->next_maintenance_date;
            $row[] = '<span class="badge badge-' . ($machine->status == 'Active' ? 'success' : 'danger') . '">' . $machine->status . '</span>';
            $row[] = '<a href="' . site_url('machines/edit?id=' . $machine->id) . '" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $machine->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->machines->count_all(),
            "recordsFiltered" => $this->machines->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function create()
    {
        if ($this->input->post()) {
            $name = $this->input->post('name', true);
            $code = $this->input->post('code', true);
            $capacity = $this->input->post('capacity', true);
            $cycle = $this->input->post('cycle', true);
            $last_maint = $this->input->post('last_maint', true);
            $status = $this->input->post('status', true);

            // Calculate next maintenance date
            $next_maint = date('Y-m-d', strtotime($last_maint . " + $cycle days"));

            if ($this->machines->create($name, $code, $capacity, $cycle, $last_maint, $next_maint, $status)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Machine Added Successfully'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error Adding Machine'));
            }
        } else {
            $head['title'] = "Add Machine";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('machines/create');
            $this->load->view('fixed/footer');
        }
    }

    public function edit()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $name = $this->input->post('name', true);
            $code = $this->input->post('code', true);
            $capacity = $this->input->post('capacity', true);
            $cycle = $this->input->post('cycle', true);
            $last_maint = $this->input->post('last_maint', true);
            $status = $this->input->post('status', true);
            
            // Calculate next maintenance date
            $next_maint = date('Y-m-d', strtotime($last_maint . " + $cycle days"));

            if ($this->machines->edit($id, $name, $code, $capacity, $cycle, $last_maint, $next_maint, $status)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Machine Updated Successfully'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error Updating Machine'));
            }
        } else {
            $head['title'] = "Edit Machine";
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['machine'] = $this->machines->get_details($this->input->get('id'));
            
            $this->load->view('fixed/header', $head);
            $this->load->view('machines/edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');
        if ($id) {
            $this->machines->delete($id);
            echo json_encode(array('status' => 'Success', 'message' => 'Machine Deleted Successfully'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Error Deleting Machine'));
        }
    }
}
