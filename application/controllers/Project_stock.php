<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_stock extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('project_stock_model');
        $this->load->model('projects_model');
        $this->load->model('products_model', 'products');
        
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function issue()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Issue Stock to Project';
        $data['projects'] = $this->projects_model->project_list_all();
        // $data['warehouses']... if needed
        
        $this->load->view('fixed/header', $head);
        $this->load->view('project_stock/issue', $data);
        $this->load->view('fixed/footer');
    }

    public function process_issue()
    {
        if ($this->input->post()) {
            $project_id = $this->input->post('project_id');
            $products_l = $this->input->post('products_l');
            $products_qty = $this->input->post('products_qty');
            $user_id = $this->aauth->get_user()->id;

             // Prepare items
            $items = array();
            $p_ids = explode(',', $products_l);
            $p_qtys = explode(',', $products_qty);
            
            for($i=0; $i<count($p_ids); $i++) {
                if($p_ids[$i]) {
                     $items[] = array('pid' => $p_ids[$i], 'qty' => $p_qtys[$i]);
                }
            }

            if ($this->project_stock_model->process_issue($project_id, 0, $items, $user_id)) {
                 echo json_encode(array('status' => 'Success', 'message' => 'Stock Issued Successfully'));
            } else {
                 echo json_encode(array('status' => 'Error', 'message' => 'Error Issuing Stock'));
            }
        }
    }
}
