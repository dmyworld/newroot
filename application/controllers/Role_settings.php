<?php
/**
 * Role Settings Controller
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Role_settings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
        
        // Super Admin access only initially for managing settings
        if ($this->aauth->get_user()->roleid != 1) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }

        $this->li_a = 'settings';
        $this->load->model('settings_model', 'settings');
    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Role-Based System Settings';

        $this->db->select('*');
        $this->db->from('geopos_system_settings');
        $query = $this->db->get();
        $data['settings'] = $query->result_array();

        $this->load->view('fixed/header', $head);
        $this->load->view('role_settings/index', $data);
        $this->load->view('fixed/footer');
    }

    public function add()
    {
        if ($this->input->post()) {
            $key = $this->input->post('setting_key', true);
            $value = $this->input->post('setting_value');
            $access_level = $this->input->post('access_level', true);
            
            $allowed_roles = null;
            if ($access_level == 'role_specific') {
                 $roles = $this->input->post('allowed_roles'); // array of role ids
                 if(is_array($roles)){
                    $allowed_roles = json_encode($roles);
                 }
            }

            $data = array(
                'setting_key' => $key,
                'setting_value' => $value,
                'access_level' => $access_level,
                'allowed_roles' => $allowed_roles
            );

            if ($this->db->insert('geopos_system_settings', $data)) {
                 $this->session->set_flashdata('message', "<div class='alert alert-success'>Setting added successfully!</div>");
                 redirect('role_settings');
            } else {
                 $this->session->set_flashdata('message', "<div class='alert alert-danger'>Error adding setting!</div>");
                 redirect('role_settings/add');
            }
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Add Role Setting';

            $this->load->view('fixed/header', $head);
            $this->load->view('role_settings/add');
            $this->load->view('fixed/footer');
        }
    }

    public function edit()
    {
        $id = $this->input->get('id');

        if ($this->input->post()) {
            $id = $this->input->post('id');
            $key = $this->input->post('setting_key', true);
            $value = $this->input->post('setting_value');
            $access_level = $this->input->post('access_level', true);
            
            $allowed_roles = null;
            if ($access_level == 'role_specific') {
                 $roles = $this->input->post('allowed_roles'); // array of role ids
                 if(is_array($roles)) {
                    $allowed_roles = json_encode($roles);
                 }
            } else {
                 $allowed_roles = null;
            }

            $data = array(
                'setting_key' => $key,
                'setting_value' => $value,
                'access_level' => $access_level,
                'allowed_roles' => $allowed_roles
            );

            $this->db->set($data);
            $this->db->where('id', $id);
            if ($this->db->update('geopos_system_settings')) {
                $this->session->set_flashdata('message', "<div class='alert alert-success'>Setting updated successfully!</div>");
                 redirect('role_settings');
            } else {
                 $this->session->set_flashdata('message', "<div class='alert alert-danger'>Error updating setting!</div>");
                 redirect('role_settings/edit?id='.$id);
            }

        } else {
            $this->db->where('id', $id);
            $query = $this->db->get('geopos_system_settings');
            $data['setting'] = $query->row_array();

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Role Setting';

            $this->load->view('fixed/header', $head);
            $this->load->view('role_settings/edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function delete()
    {
        $id = $this->input->post('deleteid');
        if ($this->db->delete('geopos_system_settings', array('id' => $id))) {
            echo json_encode(array('status' => 'Success', 'message' => "Successfully Deleted"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => "Error deleting setting"));
        }
    }
}
