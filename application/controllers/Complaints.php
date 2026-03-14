<?php
/**
 * Complaints Controller
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Complaints extends CI_Controller
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
        $head['title'] = "Complaint Dashboard";
        $data['complaints'] = $this->db->select('tp_complaints.*, geopos_users.username as customer_name')
            ->from('tp_complaints')
            ->join('geopos_users', 'tp_complaints.customer_id = geopos_users.id', 'left')
            ->order_by('id', 'DESC')
            ->get()->result_array();
            
        $this->load->view('fixed/header-va', $head);
        $this->load->view('providers/complaints', $data);
        $this->load->view('fixed/footer');
    }

    public function resolve()
    {
        $id = $this->input->post('id');
        $this->db->set('status', 1);
        $this->db->where('id', $id);
        if($this->db->update('tp_complaints')) {
            echo json_encode(array('status' => 'Success', 'message' => 'Complaint marked as resolved!'));
        }
    }
}
