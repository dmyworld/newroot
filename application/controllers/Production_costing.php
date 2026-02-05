<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production_costing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('production_costing_model');
        $this->load->model('production_inventory_model'); // Re-use search
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        // List batches to choose from
        // Reuse get_batches logic or simple query
        $data['batches'] = $this->db->get('geopos_production_batches')->result_array();
        
        $head['title'] = "Production Costing";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('costing/index', $data);
        $this->load->view('fixed/footer');
    }

    public function batch_summary()
    {
        $batch_id = $this->input->get('id');
        if(!$batch_id) redirect('production_costing');

        $head['title'] = "Cost Sheet: Batch #$batch_id";
        $head['usernm'] = $this->aauth->get_user()->username;

        $data['batch'] = $this->db->where('id', $batch_id)->get('geopos_production_batches')->row_array();
        $data['costing'] = $this->production_costing_model->get_batch_costing($batch_id);

        $this->load->view('fixed/header', $head);
        $this->load->view('costing/batch_summary', $data);
        $this->load->view('fixed/footer');
    }

    public function add_consumption()
    {
        // Simple form to log material used for a batch
        if($this->input->post()) {
            $batch_id = $this->input->post('batch_id');
            $product_id = $this->input->post('product_id');
            $qty = $this->input->post('qty');
            $note = "Batch #$batch_id Consumption";
            $user_id = $this->aauth->get_user()->id;

            // Log as 'Consumption' in stock movements
            $data = array(
                'product_id' => $product_id,
                'from_location_id' => null, // Just consuming from 'system' or specify location? 
                // Ideally we specify FROM location (e.g. Production Floor). 
                // For simplicity, let's assume we consume from '2' (Sawmill) or default.
                // Or better, let user pick from location if needed. 
                // We'll set 'to_location_id' as 0 (consumed) and type='Consumption'.
                'to_location_id' => 0, 
                'qty' => $qty,
                'ref_id' => $batch_id,
                'type' => 'Consumption',
                'move_date' => date('Y-m-d H:i:s'),
                'note' => $note,
                'created_by' => $user_id
            );
            $this->db->insert('geopos_stock_movements', $data);
            
            echo json_encode(array('status' => 'Success', 'message' => 'Consumption Recorded', 'redirect' => site_url('production_costing/batch_summary?id='.$batch_id)));
        }
    }
}
