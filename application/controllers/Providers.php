<?php
/**
 * Providers Controller
 * Handle Provider registration approval, profiles and monitoring
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Providers extends CI_Controller
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
        $this->load->model('providers_model', 'providers');
        $this->li_a = 'service_mgmt';
    }

    public function index()
    {
        $head['title'] = "Provider Approval Queue";
        $data['providers'] = $this->providers->get_pending();
        $this->load->view('fixed/header-va', $head);
        $this->load->view('providers/index', $data);
        $this->load->view('fixed/footer');
    }

    public function active()
    {
        $head['title'] = "Active Providers";
        $data['providers'] = $this->providers->get_all_active();
        $this->load->view('fixed/header-va', $head);
        $this->load->view('providers/list', $data);
        $this->load->view('fixed/footer');
    }

    public function view()
    {
        $id = $this->input->get('id');
        $data['details'] = $this->providers->details($id);
        $data['skills'] = $this->providers->get_skills($id);
        $head['title'] = "Provider Details";
        $this->load->view('fixed/header-va', $head);
        $this->load->view('providers/view', $data);
        $this->load->view('fixed/footer');
    }

    public function approve()
    {
        $id = $this->input->post('id');
        if ($this->providers->approve($id)) {
            echo json_encode(array('status' => 'Success', 'message' => 'Provider account activated and group assigned!'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Error activating account!'));
        }
    }

    public function reject()
    {
        $id = $this->input->post('id');
        $reason = $this->input->post('reason');
        if ($this->providers->reject($id, $reason)) {
            echo json_encode(array('status' => 'Success', 'message' => 'Provider account rejected!'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
        }
    }

    public function suspend()
    {
        $id = $this->input->post('id');
        if ($this->providers->suspend($id)) {
            echo json_encode(array('status' => 'Success', 'message' => 'Provider account suspended!'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
        }
    }

    /**
     * Live Monitoring Map
     */
    public function monitoring()
    {
        $head['title'] = "Live Provider Monitoring";
        $this->load->view('fixed/header-va', $head);
        $this->load->view('providers/monitoring');
        $this->load->view('fixed/footer');
    }

    /**
     * AJAX feed for map pins
     */
    public function get_locations()
    {
        $providers = $this->providers->get_online_locations();
        echo json_encode($providers);
    }
}
