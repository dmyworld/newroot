<?php
/**
 * Promo Code Manager Controller
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Promos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid != 1) {
            exit('<h3>Sorry! You have insufficient permissions.</h3>');
        }
        $this->li_a = 'service_mgmt';
    }

    public function index()
    {
        $head['title'] = "Promo Code Manager";
        $data['promos'] = $this->db->get('tp_promo_codes')->result_array();
        $this->load->view('fixed/header-va', $head);
        $this->load->view('services/promos', $data);
        $this->load->view('fixed/footer');
    }

    public function add()
    {
        if ($this->input->post()) {
            $data = array(
                'code' => $this->input->post('code', true),
                'discount_pc' => $this->input->post('discount_pc'),
                'discount_fixed' => $this->input->post('discount_fixed'),
                'deduct_from_admin' => $this->input->post('deduct_from_admin'),
                'expiry_date' => $this->input->post('expiry_date'),
                'status' => 1
            );
            if ($this->db->insert('tp_promo_codes', $data)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Promo code created!'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error creating promo code!'));
            }
        }
    }
}
