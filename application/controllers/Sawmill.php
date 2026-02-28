<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sawmill extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('locations_model', 'locations');
        $this->load->model('TimberPro_model', 'timberpro');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function processing()
    {
        $head['title'] = "Sawmill Operations";
        $head['usernm'] = $this->aauth->get_user()->username;
        $loc = $this->aauth->get_user()->loc;
        $data['locations'] = $this->locations->locations_list2();
        $data['jobs'] = $this->timberpro->get_sawmill_jobs($loc);
        
        $this->load->view('fixed/header', $head);
        $this->load->view('sawmill/processing', $data);
        $this->load->view('fixed/footer');
    }

    public function sawn_inventory()
    {
        $head['title'] = "Sawn Timber Inventory";
        $head['usernm'] = $this->aauth->get_user()->username;
        $loc = $this->aauth->get_user()->loc;
        $data['locations'] = $this->locations->locations_list2();
        // Since sawn timber is technically products, we could also use products_model
        // But for now we use the timberpro stats/data
        
        $this->load->view('fixed/header', $head);
        $this->load->view('sawmill/sawn_inventory', $data);
        $this->load->view('fixed/footer');
    }
}
