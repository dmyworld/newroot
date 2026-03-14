<?php
/**
 * Services Controller
 * Handle CRUD for tp_services
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller
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
        $this->load->model('services_model', 'services');
        $this->load->model('service_categories_model', 'services_cat');
        $this->li_a = 'service_mgmt';
    }

    public function index()
    {
        $head['title'] = "Master Service List";
        $data['services'] = $this->services->get_all();
        $this->load->view('fixed/header-va', $head);
        $this->load->view('services/list', $data);
        $this->load->view('fixed/footer');
    }

    public function add()
    {
        if ($this->input->post()) {
            $name = $this->input->post('service_name', true);
            $desc = $this->input->post('service_desc', true);
            $cat_id = $this->input->post('cat_id');
            $sub_cat_id = $this->input->post('sub_cat_id');
            $commission = $this->input->post('admin_commission_pc');
            $min_price = $this->input->post('min_price');
            $max_price = $this->input->post('max_price');

            if ($this->services->addnew($name, $desc, $cat_id, $sub_cat_id, $commission, $min_price, $max_price)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Service added successfully!'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error adding service!'));
            }
        } else {
            $head['title'] = "Add New Service";
            $data['main_cats'] = $this->services_cat->get_main_categories();
            $this->load->view('fixed/header-va', $head);
            $this->load->view('services/add', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function edit()
    {
        $id = $this->input->get('id');
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $name = $this->input->post('service_name', true);
            $desc = $this->input->post('service_desc', true);
            $cat_id = $this->input->post('cat_id');
            $sub_cat_id = $this->input->post('sub_cat_id');
            $commission = $this->input->post('admin_commission_pc');
            $min_price = $this->input->post('min_price');
            $max_price = $this->input->post('max_price');

            if ($this->services->edit($id, $name, $desc, $cat_id, $sub_cat_id, $commission, $min_price, $max_price)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Service updated successfully!'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error updating service!'));
            }
        } else {
            $head['title'] = "Edit Service";
            $data['service'] = $this->services->details($id);
            $data['main_cats'] = $this->services_cat->get_main_categories();
            $this->load->view('fixed/header-va', $head);
            $this->load->view('services/edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');
        if ($id) {
            if ($this->services->delete_i($id)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Service deleted successfully!'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error deleting service!'));
            }
        }
    }

    public function status()
    {
        $id = $this->input->post('id');
        if ($id) {
            $new_status = $this->services->toggle_status($id);
            echo json_encode(array('status' => 'Success', 'message' => 'Status updated!', 'new_status' => $new_status));
        }
    }

    public function get_sub_cats()
    {
        $cat_id = $this->input->post('cat_id');
        $subs = $this->services_cat->get_sub_categories($cat_id);
        echo json_encode($subs);
    }

    public function bulk_commission()
    {
        if ($this->input->post()) {
            $sub_cat_id = $this->input->post('sub_cat_id');
            $commission = $this->input->post('commission');
            if ($this->services->bulk_commission_update($sub_cat_id, $commission)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Bulk commission updated successfully!'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error updating bulk commission!'));
            }
        }
    }

    public function surge()
    {
        if ($this->input->post()) {
            $cat_id = $this->input->post('cat_id'); // 0 for Global
            $surge_pc = $this->input->post('surge_pc');
            if ($this->services->surge_pricing($cat_id, $surge_pc)) {
                // Log to system logs
                $this->db->insert('geopos_system_logs', array(
                    'description' => "Surge Pricing Applied: $surge_pc% for Category ID: $cat_id",
                    'date' => date('Y-m-d H:i:s'),
                    'user' => $this->aauth->get_user()->username
                ));
                echo json_encode(array('status' => 'Success', 'message' => 'Surge pricing applied and logged!'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error applying surge pricing!'));
            }
        }
    }
}
