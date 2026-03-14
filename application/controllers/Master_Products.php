<?php
/**
 * Master Products Controller
 * Handles global product master list and labor categories restricted to Super Admin
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_Products extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
        
        // Strictly Super Admin Only
        if (!$this->aauth->is_admin()) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }

        $this->load->model('Master_Products_model', 'master');
        $this->load->model('categories_model');
        $this->li_a = 'master_products';
    }

    public function index()
    {
        $head['title'] = "Master Products";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('master_products/index');
        $this->load->view('fixed/footer');
    }

    public function master_list()
    {
        $list = $this->master->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->product_name;
            $row[] = $prd->product_code;
            $row[] = amountExchange($prd->product_price, 0, $this->aauth->get_user()->loc);
            $row[] = '<a href="' . base_url() . 'master_products/edit?id=' . $prd->id . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span> ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $prd->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span> ' . $this->lang->line('Delete') . '</a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->master->count_all(),
            "recordsFiltered" => $this->master->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function add()
    {
        if ($this->input->post()) {
            $data = array(
                'product_name' => $this->input->post('product_name', true),
                'product_code' => $this->input->post('product_code', true),
                'pcat' => $this->input->post('product_cat'),
                'product_price' => numberClean($this->input->post('product_price')),
                'fproduct_price' => numberClean($this->input->post('fproduct_price')),
                'fproduct_cost' => numberClean($this->input->post('fproduct_cost')),
                'product_des' => $this->input->post('product_desc', true)
            );
            if ($this->master->add_master_product($data)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['cat'] = $this->categories_model->category_list();
            $head['title'] = "Add Master Product";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('master_products/add', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function edit()
    {
        $id = $this->input->get('id');
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $data = array(
                'product_name' => $this->input->post('product_name', true),
                'product_code' => $this->input->post('product_code', true),
                'pcat' => $this->input->post('product_cat'),
                'product_price' => numberClean($this->input->post('product_price')),
                'fproduct_price' => numberClean($this->input->post('fproduct_price')),
                'fproduct_cost' => numberClean($this->input->post('fproduct_cost')),
                'product_des' => $this->input->post('product_desc', true)
            );
            if ($this->master->update_master_product($id, $data)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['product'] = $this->master->get_master_products($id);
            $data['cat'] = $this->categories_model->category_list();
            $head['title'] = "Edit Master Product";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('master_products/edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');
        if ($this->master->delete_master_product($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    // Labor Categories
    public function labor_categories()
    {
        $data['categories'] = $this->master->get_labor_categories();
        $head['title'] = "Labor Categories";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('master_products/labor_categories', $data);
        $this->load->view('fixed/footer');
    }

    public function add_labor_category()
    {
        if ($this->input->post()) {
            $data = array(
                'title' => $this->input->post('title', true),
                'description' => $this->input->post('description', true),
                'commission_rate' => numberClean($this->input->post('commission_rate'))
            );
            if ($this->master->add_labor_category($data)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $head['title'] = "Add Labor Category";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('master_products/add_labor_category');
            $this->load->view('fixed/footer');
        }
    }

    public function edit_labor_category()
    {
        $id = $this->input->get('id');
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $data = array(
                'title' => $this->input->post('title', true),
                'description' => $this->input->post('description', true),
                'commission_rate' => numberClean($this->input->post('commission_rate'))
            );
            if ($this->master->update_labor_category($id, $data)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['category'] = $this->master->get_labor_categories($id);
            $head['title'] = "Edit Labor Category";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('master_products/edit_labor_category', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function delete_labor_category()
    {
        $id = $this->input->post('deleteid');
        if ($this->master->delete_labor_category($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }
}
