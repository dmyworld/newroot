<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logistics extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('locations_model', 'locations');
        $this->load->model('Logistics_model', 'logistics');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function fleet()
    {
        $head['title'] = "Fleet Management";
        $head['usernm'] = $this->aauth->get_user()->username;
        $loc = $this->aauth->get_user()->loc;
        $data['locations'] = $this->locations->locations_list2();
        $data['fleet'] = $this->logistics->get_fleet($loc);
        
        $this->load->view('fixed/header', $head);
        $this->load->view('logistics/fleet', $data);
        $this->load->view('fixed/footer');
    }

    public function orders()
    {
        $head['title'] = "Logistics Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
        $loc = $this->aauth->get_user()->loc;
        $data['locations'] = $this->locations->locations_list2();
        $data['orders'] = $this->logistics->get_transport_orders($loc);
        
        $this->load->view('fixed/header', $head);
        $this->load->view('logistics/orders', $data);
        $this->load->view('fixed/footer');
    }
}
