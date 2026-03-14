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
            redirect('/hub/login', 'refresh');
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
    public function save_vehicle()
    {
        $data = array(
            'vehicle_no' => $this->input->post('vehicle_no'),
            'vehicle_type' => $this->input->post('vehicle_type'),
            'driver_name' => $this->input->post('driver_name'),
            'driver_phone' => $this->input->post('driver_phone'),
            'capacity' => $this->input->post('capacity'),
            'loc' => $this->aauth->get_user()->loc,
            'status' => 'active'
        );

        if ($this->logistics->add_vehicle($data)) {
            echo json_encode(array('status' => 'Success', 'message' => 'Vehicle added successfully'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Failed to add vehicle'));
        }
    }

    public function new_order()
    {
        $head['title'] = "New Transport Order";
        $head['usernm'] = $this->aauth->get_user()->username;
        $loc = $this->aauth->get_user()->loc;
        
        $data['fleet'] = $this->logistics->get_fleet($loc);
        $data['invoices'] = $this->logistics->get_invoices($loc);
        $data['purchases'] = $this->logistics->get_purchases($loc);

        $this->load->view('fixed/header', $head);
        $this->load->view('logistics/new_order', $data);
        $this->load->view('fixed/footer');
    }

    public function save_order()
    {
        $data = array(
            'order_id' => $this->input->post('order_ref'),
            'vehicle_id' => $this->input->post('vehicle_id'),
            'pickup_loc' => $this->input->post('pickup_loc'),
            'delivery_loc' => $this->input->post('delivery_loc'),
            'status' => 'dispatched',
            'loc' => $this->aauth->get_user()->loc
        );

        if ($this->logistics->create_transport_order($data)) {
            echo json_encode(array('status' => 'Success', 'message' => 'Transport order created successfully'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Failed to create transport order'));
        }
    }

    public function schedule()
    {
        $head['title'] = "Logistics Schedule & Planning";
        $head['usernm'] = $this->aauth->get_user()->username;
        $loc = $this->aauth->get_user()->loc;
        $data['locations'] = $this->locations->locations_list2();
        
        $this->load->view('fixed/header', $head);
        $this->load->view('logistics/schedule', $data);
        $this->load->view('fixed/footer');
    }

    public function ajax_schedule_data()
    {
        $loc = $this->input->post('loc') ?: $this->aauth->get_user()->loc;
        $orders = $this->logistics->get_transport_orders($loc);
        echo json_encode($orders);
    }
}
