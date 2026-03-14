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
            redirect('/hub/login', 'refresh');
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

    public function new_job()
    {
        $head['title'] = "New Sawing Job";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['locations'] = $this->locations->locations_list2();
        $this->load->model('categories_model');
        $data['warehouse'] = $this->categories_model->warehouse_list();
        $data['wood_types'] = $this->db->get('geopos_timber_wood_types')->result_array();
        
        $this->load->view('fixed/header', $head);
        $this->load->view('sawmill/new_job', $data);
        $this->load->view('fixed/footer');
    }

    public function ajax_get_logs()
    {
        $loc = $this->input->post('loc') ?: $this->aauth->get_user()->loc;
        $logs = $this->timberpro->get_logs_at_location($loc);
        echo json_encode($logs);
    }

    public function save_job()
    {
        $source_lot_id = $this->input->post('source_lot_id');
        $input_qty = $this->input->post('input_qty');
        $output_qty = $this->input->post('output_qty');
        $slabs_qty = (float)$this->input->post('slabs_qty') ?: 0;
        $wastage = $this->input->post('wastage');
        $items = $this->input->post('items'); // Array of sawn items
        $warehouse_id = $this->input->post('warehouse_id');
        $lot_name = $this->input->post('lot_name');
        $loc = $this->aauth->get_user()->loc;

        $data = array(
            'process_date' => date('Y-m-d'),
            'source_lot_type' => 'logs',
            'source_lot_id' => $source_lot_id,
            'input_qty' => $input_qty,
            'output_qty' => $output_qty,
            'slabs_qty' => $slabs_qty,
            'wastage' => $wastage,
            'operator_id' => $this->aauth->get_user()->id,
            'loc' => $loc
        );

        $result = $this->timberpro->add_sawmill_job($data, $items, $lot_name, $warehouse_id);
        
        if ($result) {
            echo json_encode(array('status' => 'Success', 'message' => 'Job created successfully', 'id' => $result));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Failed to create job'));
        }
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

    public function slabs_inventory()
    {
        $head['title'] = "Slab Inventory (Byproducts)";
        $head['usernm'] = $this->aauth->get_user()->username;
        $loc = $this->aauth->get_user()->loc;
        $data['locations'] = $this->locations->locations_list2();
        
        $this->load->view('fixed/header', $head);
        $this->load->view('sawmill/slabs_inventory', $data);
        $this->load->view('fixed/footer');
    }

    public function ajax_slabs_list()
    {
        $loc = $this->input->post('loc') ?: $this->aauth->get_user()->loc;
        $this->db->where('loc', $loc);
        $this->db->where('status', 'available');
        $query = $this->db->get('geopos_timber_byproducts');
        echo json_encode($query->result_array());
    }
}
