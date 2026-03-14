<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_materials extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('project_costing_model');
        $this->load->model('projects_model'); 
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
    }

    public function view()
    {
        $pid = $this->input->get('pid');
        if (!$pid) {
            exit('Project ID missing');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Project Materials & Costing';
        
        $data['items'] = $this->project_costing_model->get_items($pid);
        $data['project'] = $this->projects_model->details($pid);
        $data['total_cost'] = $this->project_costing_model->get_total_cost($pid);
        $data['pid'] = $pid;

        $this->load->view('fixed/header', $head);
        $this->load->view('projects/materials', $data);
        $this->load->view('fixed/footer');
    }

    public function add()
    {
        if ($this->input->post()) {
            $pid = $this->input->post('project_id');
            $pid_product = $this->input->post('product_id');
            $qty = $this->input->post('qty');
            $price = $this->input->post('price'); // Unit cost
            $user_id = $this->aauth->get_user()->id;

            if ($this->project_costing_model->add_item($pid, $pid_product, $qty, $price, $user_id)) {
                 echo json_encode(array('status' => 'Success', 'message' => 'Material Added'));
            } else {
                 echo json_encode(array('status' => 'Error', 'message' => 'Error Adding Material'));
            }
        }
    }

    public function delete()
    {
        $id = $this->input->post('deleteid');
        if ($this->project_costing_model->delete_item($id)) {
            echo json_encode(array('status' => 'Success', 'message' => 'Material Deleted'));
        } else {
             echo json_encode(array('status' => 'Error', 'message' => 'Error Deleting Material'));
        }
    }
    
    // Helper to search products for autocomplete
    public function search_products()
    {
        $query = $this->input->post('keyword');
        $this->db->select('pid, product_name, product_price');
        $this->db->like('product_name', $query);
        $query = $this->db->get('geopos_products', 10);
        $result = $query->result_array();
        echo json_encode($result);
    }
}
