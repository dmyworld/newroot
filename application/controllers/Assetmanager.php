<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assetmanager extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('assets_model', 'assets');
        $this->load->model('employee_model', 'employee'); // For assigning assets
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Tools & Assets Management';
        $data['assets_list'] = $this->assets->get_assets();
        $this->load->view('fixed/header', $head);
        $this->load->view('assets/index', $data);
        $this->load->view('fixed/footer');
    }

    public function add()
    {
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'serial' => $this->input->post('serial'),
                'qty' => $this->input->post('qty'),
                'value' => numberClean($this->input->post('value')),
                'status' => $this->input->post('status'),
                'assigned_to' => $this->input->post('assigned_to') ? $this->input->post('assigned_to') : NULL,
                'note' => $this->input->post('note'),
                'date_acquired' => datefordatabase($this->input->post('date_acquired'))
            );

            if ($this->assets->add_asset($data)) {
                 echo json_encode(array('status' => 'Success', 'message' => 'Asset added successfully.', 'url' => base_url('assetmanager')));
            } else {
                 echo json_encode(array('status' => 'Error', 'message' => 'Error adding asset.'));
            }

        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Add Asset';
            $data['employees'] = $this->employee->list_employee();
            $this->load->view('fixed/header', $head);
            $this->load->view('assets/add', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function delete()
    {
        $id = $this->input->post('deleteid');
        if ($this->assets->delete_asset($id)) {
            echo json_encode(array('status' => 'Success', 'message' => 'Asset deleted successfully.'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Error deleting asset.'));
        }
    }
}
