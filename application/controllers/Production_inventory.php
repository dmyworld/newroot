<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production_inventory extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('production_inventory_model');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        $head['title'] = "Production Inventory";
        $head['usernm'] = $this->aauth->get_user()->username;
        
        $data['locations'] = $this->production_inventory_model->get_all_locations();
        
        // Populate stock for each location
        foreach($data['locations'] as &$loc) {
            $loc['stock'] = $this->production_inventory_model->get_location_stock($loc['id']);
        }

        $this->load->view('fixed/header', $head);
        $this->load->view('production_inventory/dashboard', $data);
        $this->load->view('fixed/footer');
    }

    public function transfer()
    {
        $head['title'] = "Transfer Stock";
        $head['usernm'] = $this->aauth->get_user()->username;
        
        $data['locations'] = $this->production_inventory_model->get_all_locations();

        $this->load->view('fixed/header', $head);
        $this->load->view('production_inventory/transfer', $data);
        $this->load->view('fixed/footer');
    }

    public function product_search()
    {
        $term = $this->input->get('term');
        $result = $this->production_inventory_model->search_product($term);
        echo json_encode($result);
    }

    public function save_transfer()
    {
        if($this->input->post()) {
            $product_id = $this->input->post('product_id');
            $from_id = $this->input->post('from_location_id');
            $to_id = $this->input->post('to_location_id');
            $qty = $this->input->post('qty');
            $note = $this->input->post('note');
            $user_id = $this->aauth->get_user()->id;

            // Use 0 or empty for 'from' to mean 'Initial Stock / Adjustment'
            if($from_id == 0) $from_id = null;

            if($this->production_inventory_model->transfer_stock($product_id, $from_id, $to_id, $qty, $note, $user_id)) {
                 echo json_encode(array('status' => 'Success', 'message' => 'Stock Transferred Successfully', 'redirect' => site_url('production_inventory')));
            } else {
                 echo json_encode(array('status' => 'Error', 'message' => 'Database Error'));
            }
        }
    }
}
