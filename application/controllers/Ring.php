<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ring extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Aauth');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->model('Ring_model', 'ring');
    }

    public function index()
    {
        $data['title'] = 'Ring Service Dashboard';
        $user_id = $this->aauth->get_user()->id;
        
        // Get active and past requests for this user (requester or provider)
        $this->db->where('requester_user_id', $user_id);
        $this->db->or_where('assigned_provider_id', $user_id);
        $this->db->order_by('created_at', 'DESC');
        $data['requests'] = $this->db->get('tp_service_requests')->result_array();

        $this->load->view('fixed/header-va', $data);
        $this->load->view('ring/dashboard', $data);
        $this->load->view('fixed/footer');
    }

    public function create()
    {
        $data['title'] = 'Request New Service';
        $this->load->view('fixed/header-va', $data);
        $this->load->view('ring/create_request', $data);
        $this->load->view('fixed/footer');
    }

    public function save_request()
    {
        $user_id = $this->aauth->get_user()->id;
        $loc_id = $this->aauth->get_user()->loc;
        
        $lat = $this->input->post('lat');
        $lng = $this->input->post('lng');
        $radius = $this->input->post('radius', TRUE) ?: 10;
        
        $request_data = [
            'requester_user_id' => $user_id,
            'requester_loc' => $loc_id,
            'request_type' => $this->input->post('service_type'),
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'gps_lat' => $lat,
            'gps_lng' => $lng,
            'radius_km' => $radius,
            'budget' => $this->input->post('budget'),
            'status' => 'ringing',
            'ring_started_at' => date('Y-m-d H:i:s'),
            'ring_expires_at' => date('Y-m-d H:i:s', strtotime('+30 seconds')),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $request_id = $this->ring->create_request($request_data);

        // Notify nearby providers (Simulation: find and log)
        $providers = $this->ring->find_nearby_providers($lat, $lng, $radius, $user_id);
        foreach ($providers as $p) {
            $this->ring->log_ring($request_id, $p['id']);
            // In a real app, we'd send a push notification/WebSocket here
        }

        redirect('ring/active/' . $request_id);
    }

    public function active($id)
    {
        $data['request'] = $this->ring->get_request($id);
        if (!$data['request']) redirect('ring');

        $data['title'] = 'Active Service Ring - ' . $data['request']->title;
        
        $this->load->view('fixed/header-va', $data);
        $this->load->view('ring/active_ring', $data);
        $this->load->view('fixed/footer');
    }

    public function accept($id)
    {
        $user_id = $this->aauth->get_user()->id;
        $result = $this->ring->accept_request($id, $user_id);
        
        if ($result['status'] == 'success') {
            $this->session->set_flashdata('success', $result['message']);
            redirect('ring/track/' . $id);
        } else {
            $this->session->set_flashdata('error', $result['message']);
            redirect('ring');
        }
    }

    public function track($id)
    {
        $data['request'] = $this->ring->get_request($id);
        if (!$data['request']) redirect('ring');

        $data['title'] = 'Live Tracking - ' . $data['request']->title;
        
        $this->load->view('fixed/header-va', $data);
        $this->load->view('ring/track', $data);
        $this->load->view('fixed/footer');
    }

    /**
     * AJAX endpoint for live tracking updates
     */
    public function ajax_update_tracking()
    {
        $id = $this->input->post('id');
        $lat = $this->input->post('lat');
        $lng = $this->input->post('lng');
        $user_id = $this->aauth->get_user()->id;

        $this->ring->update_tracking($id, $user_id, $lat, $lng);
        echo json_encode(['status' => 'success']);
    }

    /**
     * AJAX endpoint for fetching last location
     */
    public function ajax_get_tracking($id)
    {
        $tracking = $this->ring->get_last_tracking($id);
        echo json_encode($tracking);
    }
}
