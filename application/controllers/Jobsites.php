<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobsites extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('job_sites_model');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        $cid = $this->input->get('cid');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Client Job Sites';
        $data['sites'] = $this->job_sites_model->get_sites($cid);
        $data['cid'] = $cid;

        $this->load->view('fixed/header', $head);
        $this->load->view('job_sites/index', $data);
        $this->load->view('fixed/footer');
    }

    public function create()
    {
        if ($this->input->post()) {
            $cid = $this->input->post('customer_id');
            $name = $this->input->post('name');
            $address = $this->input->post('address');
            $city = $this->input->post('city');
            $region = $this->input->post('region');
            $country = $this->input->post('country');
            $postbox = $this->input->post('postbox');

            if ($this->job_sites_model->add_site($cid, $name, $address, $city, $region, $country, $postbox)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Job Site Added Successfully'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error Adding Site'));
            }
        } else {
            $this->load->model('customers_model', 'customers');
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Add Job Site';
            $data['customers'] = $this->customers->get_fetchall();
            $this->load->view('fixed/header', $head);
            $this->load->view('job_sites/create', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function delete()
    {
        $id = $this->input->post('deleteid');
        if ($this->job_sites_model->delete_site($id)) {
             echo json_encode(array('status' => 'Success', 'message' => 'Job Site Deleted'));
        } else {
             echo json_encode(array('status' => 'Error', 'message' => 'Error Deleting Site'));
        }
    }
}
