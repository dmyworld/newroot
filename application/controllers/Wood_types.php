<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wood_types extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('wood_types_model', 'wood_types');
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
        $head['title'] = "Wood Types";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('wood_types/index');
        $this->load->view('fixed/footer');
    }

    public function get_list()
    {
        $list = $this->wood_types->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $wood) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $wood->name;
            $row[] = $wood->density . ' kg/m³';
            $row[] = $wood->moisture_tolerance_min . '% - ' . $wood->moisture_tolerance_max . '%';
            $row[] = $wood->shrinkage_coeff;
            $row[] = '<a href="' . site_url('wood_types/edit?id=' . $wood->id) . '" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $wood->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->wood_types->count_all(),
            "recordsFiltered" => $this->wood_types->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function create()
    {
        if ($this->input->post()) {
            $name = $this->input->post('name', true);
            $density = $this->input->post('density', true);
            $moisture_min = $this->input->post('moisture_min', true);
            $moisture_max = $this->input->post('moisture_max', true);
            $shrinkage = $this->input->post('shrinkage', true);
            $description = $this->input->post('description', true);

            if ($this->wood_types->create($name, $density, $moisture_min, $moisture_max, $shrinkage, $description)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Wood Type Added Successfully'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error Adding Wood Type'));
            }
        } else {
            $head['title'] = "Add Wood Type";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('wood_types/create');
            $this->load->view('fixed/footer');
        }
    }

    public function edit()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $name = $this->input->post('name', true);
            $density = $this->input->post('density', true);
            $moisture_min = $this->input->post('moisture_min', true);
            $moisture_max = $this->input->post('moisture_max', true);
            $shrinkage = $this->input->post('shrinkage', true);
            $description = $this->input->post('description', true);

            if ($this->wood_types->edit($id, $name, $density, $moisture_min, $moisture_max, $shrinkage, $description)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Wood Type Updated Successfully'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error Updating Wood Type'));
            }
        } else {
            $head['title'] = "Edit Wood Type";
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['wood'] = $this->wood_types->get_details($this->input->get('id')); // Fix: method name in model is usually get_details or view
            // Wait, I named it get_details in the model above.
            
            $this->load->view('fixed/header', $head);
            $this->load->view('wood_types/edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');
        if ($id) {
            $this->wood_types->delete($id);
            echo json_encode(array('status' => 'Success', 'message' => 'Wood Type Deleted Successfully'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Error Deleting Wood Type'));
        }
    }
}
