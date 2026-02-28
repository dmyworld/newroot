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
        $this->load->model('categories_model');
        
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function issue()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Issue Stock to Project';
        $data['projects'] = $this->projects_model->project_list_all();
        $data['cat'] = $this->categories_model->category_list();
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

    public function get_sub_categories()
    {
        $id = $this->input->post('id');
        $result = $this->categories_model->category_sub_stock($id);
        echo json_encode($result);
    }

    public function search_products()
    {
        $keyword = $this->input->post('keyword');
        $cid = $this->input->post('cid');
        $sub_cid = $this->input->post('sub_cid');
        
        $this->db->select('pid, product_name, product_price, code_type, product_code');
        $this->db->like('product_name', $keyword);
        
        if($cid) {
             $this->db->where('pcat', $cid);
        }
        if($sub_cid) {
             $this->db->where('sub_id', $sub_cid);
        }
        
        $this->db->limit(30);
        $query = $this->db->get('geopos_products');
        $result = $query->result_array();
        echo json_encode($result);
    }
}
