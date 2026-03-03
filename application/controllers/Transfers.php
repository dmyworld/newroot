<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transfers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('TimberPro_model', 'timber');
        $this->load->model('locations_model', 'locations');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        $head['title'] = "Stock Transfers (Sawmill)";
        $head['usernm'] = $this->aauth->get_user()->username;
        $loc = $this->aauth->get_user()->loc;
        
        // Transfers where current loc is either sender or receiver
        $this->db->select('t.*, l.lot_name, floc.cname as from_name, tloc.cname as to_name');
        $this->db->from('geopos_timber_transfers t');
        $this->db->join('geopos_timber_logs l', 't.lot_id = l.id AND t.lot_type = "log"', 'left');
        $this->db->join('geopos_locations floc', 't.from_loc = floc.id', 'left');
        $this->db->join('geopos_locations tloc', 't.to_loc = tloc.id', 'left');
        $this->db->where("(t.from_loc = $loc OR t.to_loc = $loc)");
        $data['transfers'] = $this->db->get()->result_array();
        $data['locations'] = $this->locations->locations_list2();

        $this->load->view('fixed/header', $head);
        $this->load->view('timber/transfers', $data);
        $this->load->view('fixed/footer');
    }

    public function create()
    {
        $data = array(
            'lot_type' => $this->input->post('lot_type'),
            'lot_id' => $this->input->post('lot_id'),
            'from_loc' => $this->aauth->get_user()->loc,
            'to_loc' => $this->input->post('to_loc'),
            'request_qty' => $this->input->post('qty'),
            'requested_by' => $this->aauth->get_user()->id,
            'status' => 'pending'
        );

        if ($this->timber->initiate_transfer($data)) {
            echo json_encode(array('status' => 'Success', 'message' => 'Transfer requested successfully'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Failed to initiate transfer'));
        }
    }

    public function approve()
    {
        $id = $this->input->post('id');
        if ($this->timber->transfer_lot($id)) {
            echo json_encode(array('status' => 'Success', 'message' => 'Transfer completed and stock moved'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Failed to complete transfer'));
        }
    }
}
