<?php
/**
 * Service Categories Controller
 * Handle CRUD for tp_service_categories
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Servicecategories extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid != 1) {
            exit('<h3>Sorry! You have insufficient permissions to access this section.</h3>');
        }
        $this->load->model('service_categories_model', 'services_cat');
        $this->li_a = 'service_mgmt';
    }

    public function index()
    {
        $head['title'] = "Service Categories";
        $data['cat'] = $this->services_cat->get_all();
        $this->load->view('fixed/header-va', $head);
        $this->load->view('services/categories', $data);
        $this->load->view('fixed/footer');
    }

    public function add()
    {
        if ($this->input->post()) {
            $title = $this->input->post('title', true);
            $extra = $this->input->post('extra', true);
            $c_type = $this->input->post('c_type', true);
            $rel_id = $this->input->post('rel_id', true);
            $icon = 'default.png';

            if ($_FILES['icon']['name']) {
                $config['upload_path'] = './userfiles/service_categories/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['file_name'] = time() . $_FILES['icon']['name'];
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('icon')) {
                    $data['response'] = 'Error';
                    $data['message'] = $this->upload->display_errors();
                } else {
                    $upload_data = $this->upload->data();
                    $icon = $upload_data['file_name'];
                }
            }

            if ($this->services_cat->addnew($title, $extra, $icon, $c_type, $rel_id)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Category added successfully!'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error adding category!'));
            }
        } else {
            $head['title'] = "Add Service Category";
            $data['main_cats'] = $this->services_cat->get_main_categories();
            $this->load->view('fixed/header-va', $head);
            $this->load->view('services/categories_add', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function edit()
    {
        $id = $this->input->get('id');
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $title = $this->input->post('title', true);
            $extra = $this->input->post('extra', true);
            $c_type = $this->input->post('c_type', true);
            $rel_id = $this->input->post('rel_id', true);
            $icon = $this->input->post('old_icon');

            if ($_FILES['icon']['name']) {
                $config['upload_path'] = './userfiles/service_categories/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['file_name'] = time() . $_FILES['icon']['name'];
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('icon')) {
                    $upload_data = $this->upload->data();
                    $icon = $upload_data['file_name'];
                }
            }

            if ($this->services_cat->edit($id, $title, $extra, $icon, $c_type, $rel_id)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Category updated successfully!'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error updating category!'));
            }
        } else {
            $head['title'] = "Edit Service Category";
            $data['cat'] = $this->services_cat->details($id);
            $data['main_cats'] = $this->services_cat->get_main_categories();
            $this->load->view('fixed/header-va', $head);
            $this->load->view('services/categories_edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');
        if ($id) {
            $res = $this->services_cat->delete_i($id);
            echo json_encode($res);
        }
    }
}
